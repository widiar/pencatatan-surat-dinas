<?php

namespace App\Http\Controllers;

use App\Models\LaporanDinas;
use Illuminate\Http\Request;

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
        return view('laporan-dinas.index', compact('laporan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
