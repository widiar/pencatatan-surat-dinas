<?php

namespace App\Http\Controllers;

use App\Http\Requests\PerjalananRequest;
use App\Models\Perjalanan;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PerjalananController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('view', Perjalanan::class);
        $pencatatan = Perjalanan::all();
        foreach ($pencatatan as $pen) {
            $now = date('Y m d');
            if($now > date('Y m d', strtotime($pen->tanggal))) {
                $pen->status = 'selesai';
            } else if($now == date('Y m d', strtotime($pen->tanggal))){
                $pen->status = 'berlangsung';
            } else {
                $pen->status = 'akan datang';
            }
            $pen->save();
        }
        return view('pencatatan.index', compact('pencatatan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Perjalanan::class);
        return view('pencatatan.create');
    }

    public function search(Request $request)
    {
        try {
            $search = $request->search;
            if (env('DB_CONNECTION') == 'mysql') $surat = Perjalanan::where('nomor_surat', 'like', "%$search%")->get();
            else $surat = Perjalanan::where('nomor_surat', 'ilike', "%$search%")->get();
            $data = [];
            foreach ($surat as $sr) {
                if($sr->laporan()->count() <= 0) {
                    $dt = [
                        'id' => $sr->id,
                        'text' => $sr->nomor_surat
                    ];
                    array_push($data, $dt);
                }
            }
            return response()->json($data);
        } catch (\Throwable $th) {  
            return response()->json($th->getMessage(), 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PerjalananRequest $request)
    {
        $this->authorize('create', Perjalanan::class);
        $fotoSurat = $request->foto_surat;
        $fotoSurat->storeAs('public/perjalanan/foto-surat', $fotoSurat->hashName());
        $data = Perjalanan::create([
            'nomor_surat' => $request->no_surat,
            'dinas_berkunjung' => $request->dinas,
            'tanggal' => $request->tanggal,
            'status' => $request->status,
            'foto_surat' => $fotoSurat->hashName(),
        ]);
        if($data) return redirect()->route('pencatatan.index')->with('success', 'Data berhasil di tambahkan');
        else return redirect()->route('pencatatan.index')->with('error', 'Data gagal di tambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Perjalanan::find($id);
        $this->authorize('edit', $data);
        return view('pencatatan.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PerjalananRequest $request, $id)
    {
        $data = Perjalanan::find($id);
        $this->authorize('edit', $data);
        if(isset($request->foto_surat)){
            $fotoSurat = $request->foto_surat;
            $fotoSurat->storeAs('public/perjalanan/foto-surat', $fotoSurat->hashName());
            if(!is_null($data->foto_surat)) {
                Storage::disk('public')->delete('perjalanan/foto-surat/' . $data->foto_surat);
            }
            $data->foto_surat = $fotoSurat->hashName();
        }
        $data->nomor_surat = $request->no_surat;
        $data->dinas_berkunjung = $request->dinas;
        $data->tanggal = $request->tanggal;
        $data->status = $request->status;
        $data->save();
        return redirect()->route('pencatatan.index')->with('success', 'Data berhasil di update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Perjalanan::find($id);
        $this->authorize('delete', $data);
        $data->delete();
        return response()->json('Sukses');
    }
}
