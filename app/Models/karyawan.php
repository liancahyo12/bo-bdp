<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Boilerplate\User;

class karyawan extends Model
{
    use HasFactory;
    public function User()
    {
        return $this->belongsTo(User::class);
    }
    public function kontak()
    {
        return $this->hasMany(kontak::class);
    }
    public function kontrak_karyawan()
    {
        return $this->hasMany(kontrak_karyawan::class);
    }
    public function pelamar()
    {
        return $this->hasOne(pelamar::class);
    }
    public function pendidikan_formal()
    {
        return $this->hasMany(pendidikan_formal::class);
    }
    public function pengalaman_kerja()
    {
        return $this->hasMany(pengalaman_kerja::class);
    }
    public function referensi_pelamar()
    {
        return $this->hasMany(referensi_pelamar::class);
    }
    public function sertifikat_kypl()
    {
        return $this->hasMany(sertifikat_kypl::class);
    }
    public function sosial_media()
    {
        return $this->hasMany(sosial_media::class);
    }
    public function status_karyawan()
    {
        return $this->hasMany(status_karyawan::class);
    }
    protected $fillable = [
        'user_id',
        'pelamar_id',
        'kode_karyawan',
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
        'aktif',
    ];
}
