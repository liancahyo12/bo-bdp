<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reviewsuratkeluar extends Model
{
    use HasFactory;

    public function suratkeluar()
    {
        return $this->belongsTo(Suratkeluar::class);
    }

    protected $fillable = [
        'komentar',
        'review_status',
    ];
}
