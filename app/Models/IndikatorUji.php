<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\BakuMutuPeruntukan;

class IndikatorUji extends Model
{
    protected $table = 'indikator_uji';

    protected $fillable = [
        'kode_indikator',
        'nama_indikator',
        'satuan'
    ];

    public $timestamps = true;

    // relasi ke tabel baku mutu
    public function bakuMutu()
    {
        return $this->hasMany(BakuMutuPeruntukan::class,'indikator_id');
    }
}