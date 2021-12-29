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
}
