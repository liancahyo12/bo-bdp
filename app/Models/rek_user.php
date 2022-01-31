<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Boilerplate\User;

class rek_user extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'nama_rek',
        'no_rek',
        'bank',
    ];
    public function User()
    {  
        return $this- belongsTo(User::class);
    }
}
