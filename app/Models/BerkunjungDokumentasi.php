<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BerkunjungDokumentasi extends Model
{
    use HasFactory;

    protected $table = 'kunjungan_dokumentasi';
    protected $guarded = ['id'];
}
