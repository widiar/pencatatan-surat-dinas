<?php

namespace App\Http\Controllers;

use App\Http\Requests\PencatatanRequest;
use App\Models\PencatatanSurat;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PencatatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('view', PencatatanSurat::class);
        $pencatatan = PencatatanSurat::all();
        foreach ($pencatatan as $pen) {
            $now = date('Y m d');
            if($now > date('Y m d', strtotime($pen->tanggal))) {
                $pen->status = 'selesai';
            } else if($now == date('Y m d', strtotime($pen->tanggal))){
                $pen->status = 'berlangsung';
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
        $this->authorize('create', PencatatanSurat::class);
        return view('pencatatan.create');
    }

    public function search(Request $request)
    {
        try {
            $search = $request->search;
            if (env('DB_CONNECTION') == 'mysql') $surat = PencatatanSurat::where('nomor_surat', 'like', "%$search%")->get();
            else $surat = PencatatanSurat::where('nomor_surat', 'ilike', "%$search%")->get();
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
    public function store(PencatatanRequest $request)
    {
        $this->authorize('create', PencatatanSurat::class);
        $data = PencatatanSurat::create([
            'nomor_surat' => $request->no_surat,
            'dinas_berkunjung' => $request->dinas,
            'tanggal' => $request->tanggal,
            'status' => $request->status
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
        $data = PencatatanSurat::find($id);
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
    public function update(PencatatanRequest $request, $id)
    {
        $data = PencatatanSurat::find($id);
        $this->authorize('edit', $data);
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
        $data = PencatatanSurat::find($id);
        $this->authorize('delete', $data);
        $data->delete();
        return response()->json('Sukses');
    }
}
