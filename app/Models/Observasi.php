<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Observasi extends Model {
    protected $table = 'observasi';
    protected $fillable = ['location_id','user_id','tanggal_pemantauan','tahun_pemantauan','periode_pemantauan','shu'];
    public $timestamps = true;

    public function lokasi(){ return $this->belongsTo(Lokasi::class,'location_id'); }
    public function user(){ return $this->belongsTo(User::class,'user_id'); }
    public function hasilUji(){ return $this->hasMany(HasilUji::class,'observasi_id'); }
}
