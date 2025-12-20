<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IndikatorUji extends Model {
    protected $table = 'indikator_uji';
    protected $fillable = ['kode_indikator','nama_indikator','satuan','baku_mutu'];
    public $timestamps = true;
}
