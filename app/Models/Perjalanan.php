<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perjalanan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'perjalanan';

    public function laporan()
    {
        return $this->hasOne(LaporanDinas::class, 'perjalanan_id');
    }
}
