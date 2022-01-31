<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Boilerplate\User;

class closing extends Model
{
    use HasFactory;

    public function review_closing()
    {
        return $this->hasMany(review_closing::class);
    }

    public function approve_closing()
    {
        return $this->hasMany(approve_closing::class);
    }

    public function isi_closing()
    {
        return $this->hasMany(isi_closing::class);
    }
    public function User()
    {  
        return $this- belongsTo(User::class);
    }
    protected $fillable = [
        'user_id',
        'pengajuan_id',
        'jenis_pengajuan_id',
        'departemen_id',
        'no_urut',
        'no_pengajuan',
        'closing',
        'tgl_closing',
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
        'revisi_status',
        'bukti_bayar',
        'bayar_status',
        'bayar_time',
    ];
}
