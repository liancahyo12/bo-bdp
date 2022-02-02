<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class isi_closing extends Model
{
    use HasFactory;
    protected $fillable = [
        'closing_id',
        'jenis_pengajuan_id',
        'pengajuan_id',
        'no',
        'transaksi',
        'jenis_transaksi',
        'coa',
        'nominal',
        'saldo',
        'jumlah_barang',
        
    ];
    public function closing()
    {  
        return $this- belongsTo(closing::class);
    }
}
