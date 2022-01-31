<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class reviewdepclosing extends Model
{
    use HasFactory;
    public function closing()
    {
        return $this->belongsTo(closing::class);
    }

    protected $fillable = [
        'komentar',
        'closing_id',
        'user_id',
        'reviewerdep_id',
        'reviewdep_status',
    ];
}
