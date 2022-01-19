<?php

namespace App\Http\Controllers;

use App\Models\Berkunjung;
use App\Models\BerkunjungDokumentasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KunjunganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('view', Berkunjung::class);
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
        $this->authorize('create', Berkunjung::class);
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
        $this->authorize('create', Berkunjung::class);
        try {
            $cek = Berkunjung::where('nomor_surat', $request->no_surat)->count();
            if($cek > 0) {
                $request->session()->flash('error', 'Nomor surat sudah ada');
                return response()->json('fail');
            }
            $fotoSurat = $request->foto_surat;
            $fotoSurat->storeAs('public/kunjungan/foto-surat', $fotoSurat->hashName());
            $data = Berkunjung::create([
                'nomor_surat' => $request->no_surat,
                'nama_dinas' => $request->dinas,
                'tanggal' => $request->tanggal,
                'tujuan' => $request->tujuan,
                'foto_surat' => $fotoSurat->hashName()
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
        $data = Berkunjung::with('dokumentasi')->findOrFail($id);
        $this->authorize('edit', $data);
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
        $this->authorize('edit', $data);
        $err = 0;
        $msg = '';
        $cek = Berkunjung::where('nomor_surat', $request->no_surat)->where('id', '!=', $id)->count();
        if($cek > 0) {
            $request->session()->flash('error', 'Nomor surat sudah ada');
            return response()->json('fail');
        }
        if(!$request->dokfile && $data->dokumentasi()->count() <= 0) {
            $err = 1;
            $msg .= ' Dokumentasi tidak boleh kosong ';
        }
        if($err == 1) {
            $request->session()->flash('error', $msg);
            return response()->json('fail');
        }
        try {
            if(isset($request->foto_surat)){
                $fotoSurat = $request->foto_surat;
                $fotoSurat->storeAs('public/kunjungan/foto-surat', $fotoSurat->hashName());
                if(!is_null($data->foto_surat)) {
                    Storage::disk('public')->delete('kunjungan/foto-surat/' . $data->foto_surat);
                }
                $data->foto_surat = $fotoSurat->hashName();
            }
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
        $this->authorize('delete', $data);
        $data->delete();
        return response()->json('Sukses');
    }

    public function deleteDokumentasi(Request $request)
    {
        $id = $request->id;
        $data = BerkunjungDokumentasi::find($id);
        $this->authorize('edit', $data);
        Storage::disk('public')->delete('kunjungan/dokumentasi/' . $data->foto);
        $data->delete();
        return response()->json('deleted');
    }
}
