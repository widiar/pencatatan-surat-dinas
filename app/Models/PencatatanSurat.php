<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PencatatanSurat extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function laporan()
    {
        return $this->hasOne(LaporanDinas::class, 'pencatatan_surat_id');
    }
}
