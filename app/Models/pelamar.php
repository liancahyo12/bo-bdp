<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pelamar extends Model
{
    use HasFactory;
    public function karyawan()
    {
        return $this->belongsTo(karyawan::class);
    }
    protected $fillable = [
        'user_id',
        'karyawan_id',
        'nama',
        'tem_lahir',
        'tgl_lahir',
        'gender',
        'nikah_status',
        'jumlah_anak',
        'alamat_ktp',
        'alamat_dom',
        'nik',
        'npwp',
        'email_pel',
        'nama_ayah',
        'nama_ibu',
        'alamat_ortu',
        'goldar',
        'posisi',
        'channel',
        'pendapatan',
    ];
}
