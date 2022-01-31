<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Boilerplate\User;
use App\Notifications\Boilerplate\ReviewdepPengajuan;

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

    public function isi_pengajuan()
    {
        return $this->hasMany(Isi_pengajuan::class);
    }
    public function User()
    {  
        return $this- belongsTo(User::class);
    }
    protected $fillable = [
        'user_id',
        'jenis_pengajuan_id',
        'departemen_id',
        'no_urut',
        'no_pengajuan',
        'pengajuan',
        'tgl_pengajuan',
        'no_invoice',
        'perusahaan',
        'alamat',
        'phone',
        'kontak',
        'ppn',
        'dpp',
        'email',
        'bank',
        'nama_rek',
        'no_rek',
        'catatan',
        'total_nominal',
        'jumlah_pc',
        'lampiran',
        'send_status',
        'send_time',
        'reviewer_id',
        'review_status',
        'review_time',
        'reviewerdep_id',
        'reviewdep_status',
        'reviewdep_time',
        'approver_id',
        'approve_status',
        'approve_time',
        'bukti_bayar',
        'bayar_status',
        'bayar_time',
        'revisi_status',
        'pengajuan_jadi',
    ];

    public function sendReviewdepPengajuanNotification($id)
    {
        $this->notify(new ReviewdepPengajuan($id, $this));
    }
}
