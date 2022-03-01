<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kontrak_karyawan extends Model
{
    use HasFactory;
    public function karyawan()
    {
        return $this->belongsTo(karyawan::class);
    }
    protected $fillable = [
        'karyawan_id',
        'jenis_kontrak',
        'tgl_awal',
        'tgl_akhir',
        'dokumen_kontrak',
        'kontrak_status',
    ];
}
