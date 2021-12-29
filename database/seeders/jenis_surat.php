<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class jenis_surat extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('jenis_surats')->insert([
            [
                'kode' => '01',
                'jenis_surat' => 'SURAT KEPUTUSAN',
            ],
            [
                'kode' => '02',
                'jenis_surat' => 'SURAT PERNYATAAN',
            ],
            [
                'kode' => '03',
                'jenis_surat' => 'SURAT PEMBERITAHUAN',
            ],
            [
                'kode' => '04',
                'jenis_surat' => 'SURAT KETERANGAN',
            ],
            [
                'kode' => '05',
                'jenis_surat' => 'SURAT PERMOHONAN',
            ],
            [
                'kode' => '06',
                'jenis_surat' => 'SURAT KUASA',
            ],
            [
                'kode' => '07',
                'jenis_surat' => 'SURAT PENGANTAR',
            ],
            [
                'kode' => '08',
                'jenis_surat' => 'SURAT UNDANGAN',
            ],
            [
                'kode' => '09',
                'jenis_surat' => 'SURAT BALASAN',
            ],
            [
                'kode' => '10',
                'jenis_surat' => 'SURAT PEMINJAMAN',
            ],
            [
                'kode' => '11',
                'jenis_surat' => 'SURAT PERINTAH',
            ],
            [
                'kode' => '12',
                'jenis_surat' => 'PERJANJIAN KERJA SAMA',
            ],
        ]);
    }
}
