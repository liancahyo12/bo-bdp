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

    public function isi_pengajuan()
    {
        return $this->hasMany(Isi_pengajuan::class);
    }
    protected $fillable = [
        'user_id',
        'jenis_pengajuan_id',
        'departemen_id',
        'pengajuan',
        'tgl_pengajuan',
        'no_invoice',
        'perusahaan',
        'alamat',
        'phone',
        'kontak',
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
    ];
}
