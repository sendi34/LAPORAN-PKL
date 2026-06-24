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

    public function indikator()
    {
        return $this->belongsTo(IndikatorUji::class, 'indikator_id');
    }

    // accessor: $bakuMutu->baku_mutu_formatted
    public function getBakuMutuFormattedAttribute()
    {
        if ($this->baku_mutu === null) {
            return null; // biar tetap kosong, bukan "0"
        }
        return rtrim(rtrim(number_format($this->baku_mutu, 4, '.', ''), '0'), '.');
    }
}