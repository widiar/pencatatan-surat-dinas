<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Berkunjung extends Model
{
    use HasFactory;

    protected $table = 'kunjungan';
    protected $guarded = ['id'];

    public function dokumentasi()
    {
        return $this->hasMany(BerkunjungDokumentasi::class, 'kunjungan_id');
    }

    public function delete()
    {
        foreach ($this->dokumentasi as $dok) {
            Storage::disk('public')->delete('kunjungan/dokumentasi/' . $dok->foto);
        }
        $this->dokumentasi()->delete();
        parent::delete();
    }
}
