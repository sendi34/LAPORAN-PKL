<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Laporan extends Model {
    protected $table = 'laporan';
    protected $fillable = ['judul_laporan','tahun_laporan','jenis_laporan','dibuat_oleh'];
}
