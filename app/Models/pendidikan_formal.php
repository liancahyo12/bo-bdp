<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pendidikan_formal extends Model
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
        'sekolah',
        'jurusan',
        'periode',
        'tingkat',
        'lulus',
    ];
}
