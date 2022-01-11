<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanDinasDokumentasi extends Model
{
    use HasFactory;

    protected $table = 'laporan_dinas_dokumentasi';

    protected $guarded = ['id'];
}
