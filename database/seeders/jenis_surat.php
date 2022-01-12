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
                'format' =>'format/surat-keputusan.docx'
            ],
            [
                'kode' => '02',
                'jenis_surat' => 'SURAT PERNYATAAN',
                'format' =>'format/surat-pernyataan.docx'
            ],
            [
                'kode' => '03',
                'jenis_surat' => 'SURAT PEMBERITAHUAN',
                'format' =>'format/surat-pemberitahuan.docx'
            ],
            [
                'kode' => '04',
                'jenis_surat' => 'SURAT KETERANGAN',
                'format' =>'format/surat-keterangan.docx'
            ],
            [
                'kode' => '05',
                'jenis_surat' => 'SURAT PERMOHONAN',
                'format' =>'format/surat-permohonan.docx'
            ],
            [
                'kode' => '06',
                'jenis_surat' => 'SURAT KUASA',
                'format' =>'format/surat-kuasa.docx'
            ],
            [
                'kode' => '07',
                'jenis_surat' => 'SURAT PENGANTAR',
                'format' =>'format/surat-pengantar.docx'
            ],
            [
                'kode' => '08',
                'jenis_surat' => 'SURAT UNDANGAN',
                'format' =>'format/surat-undangan.docx'
            ],
            [
                'kode' => '09',
                'jenis_surat' => 'SURAT BALASAN',
                'format' =>'format/surat-balasan.docx'
            ],
            [
                'kode' => '10',
                'jenis_surat' => 'SURAT PEMINJAMAN',
                'format' =>'format/surat-peminjaman.docx'
            ],
            [
                'kode' => '11',
                'jenis_surat' => 'SURAT PERINTAH',
                'format' =>'format/surat-perintah.docx'
            ],
            [
                'kode' => '12',
                'jenis_surat' => 'PERJANJIAN KERJA SAMA',
                'format' =>'format/perjanjian-kerjasama.docx'
            ],
        ]);
    }
}
