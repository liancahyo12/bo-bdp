<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pengajuan extends Model
{
    use HasFactory;

    public function cekpengajuans()
    {
        return $this->hasMany(cekpengajuan::class);
    }

    public function approvepengajuans()
    {
        return $this->hasMany(approvepengajuan::class);
    }

    protected $fillable = [
        'jenis_pengajuan',
        'judul',
        'deskripsi',
        'nominal',
        'lampiran',
        'check_status',
        'approve_status'
    ];
}
