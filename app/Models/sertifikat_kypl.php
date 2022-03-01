<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sertifikat_kypl extends Model
{
    use HasFactory;
    public function karyawan()
    {
        return $this->belongsTo(karyawan::class);
    }
    public function pelamar()
    {
        return $this->belongsTo(pelamar::class);
    }
    protected $fillable = [
        'pelamar_id',
        'karyawan_id',
        'sertifikat',
        'organisasi',
        'lokasi',
        'tahun',
        'level',
    ];
}
