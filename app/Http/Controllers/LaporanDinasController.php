<?php

namespace App\Http\Controllers;

use App\Models\LaporanDinas;
use App\Models\LaporanDinasDokumentasi;
use App\Models\LaporanDinasNota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LaporanDinasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $laporan = LaporanDinas::with('pencatatan')->get();
        $this->authorize('view', LaporanDinas::class);
        return view('laporan-dinas.index', compact('laporan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', LaporanDinas::class);
        return view('laporan-dinas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'no_surat' => 'required',
            'hasil' => 'required'
        ]);
        $this->authorize('create', LaporanDinas::class);
    
        try {
            $lap = LaporanDinas::create([
                'pencatatan_surat_id' => $request->no_surat,
                'hasil_laporan' => $request->hasil
            ]);
            //save nota
            foreach ($request->notafile as $file) {
                $lap->nota()->create([
                    'foto' => $file->hashName()
                ]);
                $file->storeAs('public/laporan-dinas/nota', $file->hashName());
            }
            //save dokumentasi
            foreach ($request->dokfile as $file) {
                $lap->dokumentasi()->create([
                    'foto' => $file->hashName()
                ]);
                $file->storeAs('public/laporan-dinas/dokumentasi', $file->hashName());
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
        $data = LaporanDinas::with(['nota', 'dokumentasi'])->findOrFail($id);
        $this->authorize('view', $data);
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
        $data = LaporanDinas::with(['pencatatan', 'nota', 'dokumentasi'])->findOrFail($id);
        $this->authorize('edit', $data);
        return view('laporan-dinas.edit', compact('data'));
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
        $request->validate([
            'hasil' => 'required'
        ]);
        $laporan = LaporanDinas::find($id);
        $this->authorize('edit', $laporan);
        $err = 0;
        $msg = '';
        if(!$request->notafile && $laporan->nota()->count() <= 0) {
            $err = 1;
            $msg .= ' Nota tidak boleh kosong ';
        }
        if(!$request->dokfile && $laporan->dokumentasi()->count() <= 0) {
            $err = 1;
            $msg .= ' Dokumentasi tidak boleh kosong ';
        }
        if($err == 1) {
            $request->session()->flash('error', $msg);
            return response()->json('fail');
        }
        try {
            $laporan->hasil_laporan = $request->hasil;
            //save nota
            if(isset($request->notafile)) {
                foreach ($request->notafile as $file) {
                    $laporan->nota()->create([
                        'foto' => $file->hashName()
                    ]);
                    $file->storeAs('public/laporan-dinas/nota', $file->hashName());
                }
            }
            //save dokumentasi
            if(isset($request->dokfile)){
                foreach ($request->dokfile as $file) {
                    $laporan->dokumentasi()->create([
                        'foto' => $file->hashName()
                    ]);
                    $file->storeAs('public/laporan-dinas/dokumentasi', $file->hashName());
                }
            }
            $laporan->save();
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
        $data = LaporanDinas::find($id);
        $this->authorize('delete', $data);
        $data->delete();
        return response()->json('Sukses');
    }

    public function deleteNota(Request $request)
    {
        $id = $request->id;
        $data = LaporanDinasNota::find($id);
        $this->authorize('edit', $data);
        Storage::disk('public')->delete('laporan-dinas/nota/' . $data->foto);
        $data->delete();
        return response()->json('deleted');
    }

    public function deleteDokumentasi(Request $request)
    {
        $id = $request->id;
        $data = LaporanDinasDokumentasi::find($id);
        $this->authorize('edit', $data);
        Storage::disk('public')->delete('laporan-dinas/dokumentasi/' . $data->foto);
        $data->delete();
        return response()->json('deleted');
    }
}
