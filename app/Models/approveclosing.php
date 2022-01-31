<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class approveclosing extends Model
{
    use HasFactory;
    public function closing()
    {
        return $this->belongsTo(closing::class);
    }

    protected $fillable = [
        'komentar',
        'approve_status',
        'closing_id',
        'user_id',
        'approver_id',
    ];
}
