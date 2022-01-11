<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanDinas extends Model
{
    use HasFactory;

    protected $table = 'laporan_dinas';

    protected $guarded = ['id'];

    public function pencatatan()
    {
        return $this->belongsTo(PencatatanSurat::class, 'pencatatan_surat_id', 'id');
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
        $this->nota()->delete();
        $this->dokumentasi()->delete();
        parent::delete();
    }
}
