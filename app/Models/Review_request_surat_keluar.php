<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review_request_surat_keluar extends Model
{
    use HasFactory;

    protected $fillable = [
        'komentar',
        'request_status',
        'request_surat_keluar_id',
        'user_id',
        'reviewer_id',
    ];
}
