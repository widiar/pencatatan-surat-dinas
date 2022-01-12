<?php

namespace App\Http\Controllers;

use App\Models\Berkunjung;
use App\Models\BerkunjungDokumentasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KunjanganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datas = Berkunjung::all();
        return view('berkunjung.index', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('berkunjung.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $data = Berkunjung::create([
                'nomor_surat' => $request->no_surat,
                'nama_dinas' => $request->dinas,
                'tanggal' => $request->tanggal,
                'tujuan' => $request->tujuan
            ]);
            //save dokumentasi
            foreach ($request->dokfile as $file) {
                $data->dokumentasi()->create([
                    'foto' => $file->hashName()
                ]);
                $file->storeAs('public/kunjungan/dokumentasi', $file->hashName());
            }
            $request->session()->flash('success', 'Berhasil menambah data');
            return response()->json('Sukses');
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Berkunjung::with('dokumentasi')->findOrFail($id);
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Berkunjung::with('dokumentasi')->findOrFail($id);
        return view('berkunjung.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = Berkunjung::find($id);
        $err = 0;
        $msg = '';
        if(!$request->dokfile && $data->dokumentasi()->count() <= 0) {
            $err = 1;
            $msg .= ' Dokumentasi tidak boleh kosong ';
        }
        if($err == 1) {
            $request->session()->flash('error', $msg);
            return response()->json('fail');
        }
        try {
            $data->nomor_surat = $request->no_surat;
            $data->nama_dinas = $request->dinas;
            $data->tanggal = $request->tanggal;
            $data->tujuan = $request->tujuan;

            //save dokumentasi
            if(isset($request->dokfile)){
                foreach ($request->dokfile as $file) {
                    $data->dokumentasi()->create([
                        'foto' => $file->hashName()
                    ]);
                    $file->storeAs('public/kunjungan/dokumentasi', $file->hashName());
                }
            }
            $data->save();
            $request->session()->flash('success', 'Berhasil menambah data');
            return response()->json('Sukses');
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Berkunjung::find($id);
        $data->delete();
        return response()->json('Sukses');
    }

    public function deleteDokumentasi(Request $request)
    {
        $id = $request->id;
        $data = BerkunjungDokumentasi::find($id);
        Storage::disk('public')->delete('kunjungan/dokumentasi/' . $data->foto);
        $data->delete();
        return response()->json('deleted');
    }
}
