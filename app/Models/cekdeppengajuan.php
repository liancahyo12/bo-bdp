<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cekdeppengajuan extends Model
{
    use HasFactory;
    public function pengajuans()
    {
        return $this->belongsTo(pengajuan::class);
    }

    protected $fillable = [
        'komentar',
        'pengajuan_id',
        'user_id',
        'reviewerdep_id',
        'reviewdep_status',
    ];
}
