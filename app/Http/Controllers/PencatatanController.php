<?php

namespace App\Http\Controllers;

use App\Http\Requests\PencatatanRequest;
use App\Models\PencatatanSurat;
use Illuminate\Http\Request;

class PencatatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pencatatan = PencatatanSurat::all();
        return view('pencatatan.index', compact('pencatatan'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pencatatan.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PencatatanRequest $request)
    {
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
