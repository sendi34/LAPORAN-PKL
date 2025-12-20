<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lokasi extends Model {
    protected $table = 'lokasi';
    protected $fillable = ['kode_lokasi','nama_lokasi','alamat_lokasi','provinsi','latitude','longtitude','peruntukan'];
    public $timestamps = true;

    public function observasi(){
        return $this->hasMany(Observasi::class, 'location_id');
    }
}
