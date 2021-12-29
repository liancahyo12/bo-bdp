<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Boilerplate\User;

class Suratkeluar extends Model
{
    use HasFactory;

    public function reviewsuratkeluar()
    {
        return $this->hasMany(Reviewsuratkeluar::class);
    }

    public function approvesuratkeluar()
    {
        return $this->hasMany(Approvesuratkeluar::class);
    }

    public function isi_surat()
    {
        return $this->hasOne(Isi_surat::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $fillable = [
        'user_id',
        'jenis_surat_id',
        'departemen_id',
        'no_urut',
        'tgl_surat',
        'no_surat',
        'perihal',
        'isi_surat',
        'lampiran',
        'reviewer_id',
        'approver_id',
        'send_status',
        'send_time',
        'approve_status',
        'review_status',
    ];
}
