<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Approvesuratkeluar extends Model
{
    use HasFactory;

    public function suratkeluars()
    {
        return $this->belongsTo(suratkeluar::class);
    }

    protected $fillable = [
        'komentar',
        'approve_status',
        'surat_keluar_id',
        'user_id',
        'approver_id',
    ];
}
