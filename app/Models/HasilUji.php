<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HasilUji extends Model {

    protected $table = 'hasil_uji';

    protected $fillable = [
        'observasi_id',
        'indikator_id',
        'nilai',
        'baku_mutu',
        'status',
        'keterangan',
        'file_berkas'
    ];

    public $timestamps = true;

    public function observasi(){
        return $this->belongsTo(Observasi::class,'observasi_id');
    }

    public function indikator(){
        return $this->belongsTo(IndikatorUji::class,'indikator_id');
    }

}