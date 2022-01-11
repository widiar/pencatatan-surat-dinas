<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanDinasNota extends Model
{
    use HasFactory;

    protected $table = 'laporan_dinas_nota';

    protected $guarded = ['id'];
}
