<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Isi_pengajuan extends Model
{
    use HasFactory;
    protected $fillable = [
        'pengajuan_id',
        'jenis_pengajuan_id',
        'no',
        'transaksi',
        'jenis_transaksi',
        'coa',
        'nominal',
        'saldo',
        'jumlah_barang',
    ];
    public function pengajuan()
    {  
        return $this- belongsTo(pengajuan::class);
    }
}
