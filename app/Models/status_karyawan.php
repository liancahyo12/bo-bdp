<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class status_karyawan extends Model
{
    use HasFactory;
    public function karyawan()
    {
        return $this->belongsTo(karyawan::class);
    }
    protected $fillable = [
        'karyawan_id',
        'karyawan_status',
        'alasan',
    ];
}
