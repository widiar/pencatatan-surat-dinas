<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class LaporanDinas extends Model
{
    use HasFactory;

    protected $table = 'laporan_dinas';

    protected $guarded = ['id'];

    public function pencatatan()
    {
        return $this->belongsTo(Perjalanan::class, 'perjalanan_id', 'id');
    }

    public function nota()
    {
        return $this->hasMany(LaporanDinasNota::class, 'laporan_dinas_id');
    }

    public function dokumentasi()
    {
        return $this->hasMany(LaporanDinasDokumentasi::class, 'laporan_dinas_id');
    }

    public function delete()
    {
        foreach ($this->nota as $data) {
            Storage::disk('public')->delete('laporan-dinas/nota/' . $data->foto);
        }
        foreach ($this->dokumentasi as $data) {
            Storage::disk('public')->delete('laporan-dinas/dokumentasi/' . $data->foto);
        }
        $this->nota()->delete();
        $this->dokumentasi()->delete();
        parent::delete();
    }
}
