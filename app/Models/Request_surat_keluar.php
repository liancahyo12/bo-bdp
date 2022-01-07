<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request_surat_keluar extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'jenis_surat_id',
        'departemen_id',
        'suratkeluars_id',
        'perihal',
        'lampiran',
        'reviewer_id',
        'keterangan',
        'send_status',
        'send_time',
        'request_status',
    ];
}
