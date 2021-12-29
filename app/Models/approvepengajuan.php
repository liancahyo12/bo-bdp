<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class approvepengajuan extends Model
{
    use HasFactory;

    public function pengajuans()
    {
        return $this->belongsTo(pengajuan::class);
    }

    protected $fillable = [
        'komentar',
        'approve_status'
    ];
}
