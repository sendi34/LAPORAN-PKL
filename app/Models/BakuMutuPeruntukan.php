<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BakuMutuPeruntukan extends Model
{
    protected $table = 'baku_mutu_peruntukan';

    protected $fillable = [
        'indikator_id',
        'peruntukan',
        'baku_mutu',
    ];

    public $timestamps = true;

    public function indikator()
    {
        return $this->belongsTo(IndikatorUji::class, 'indikator_id');
    }
}
