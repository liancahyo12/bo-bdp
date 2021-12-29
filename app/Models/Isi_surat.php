<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Isi_surat extends Model
{
    use HasFactory;

    protected $fillable = [
        'surat_keluar_id',
        'jenis_surat_id',
        'item1',
        'item2',
        'item3',
        'item4',
        'item5',
        'item6',
        'item7',
        'item8',
        'item9',
        'item10',
        'item11',
        'item12',
        'item13',
        'item14',
        'item15',
        'item16',
        'item17',
        'item18',
        'item19',
        'item20',
    ];
    public function suratkeluar()
    {
        return $this->belongsTo(Suratkeluar::class);
    }
}
