<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class reviewclosing extends Model
{
    use HasFactory;
    public function closing()
    {
        return $this->belongsTo(closing::class);
    }

    protected $fillable = [
        'komentar',
        'review_status',
        'closing_id',
        'user_id',
        'reviewer_id',
    ];
}
