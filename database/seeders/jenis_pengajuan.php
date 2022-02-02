<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class jenis_pengajuan extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('jenis_pengajuans')->insert([
            [
                'kode' => 'PR',
                'jenis_pengajuan' => 'PURCHASE REQUEST',
            ],
            [
                'kode' => 'RP',
                'jenis_pengajuan' => 'REIMBURSEMENT PAYMENT',
            ],
            [
                'kode' => 'CA',
                'jenis_pengajuan' => 'CASH ADVANCE',
            ],
            [
                'kode' => 'PP',
                'jenis_pengajuan' => 'POSTPAID PAYMENT',
            ],
            [
                'kode' => 'PC',
                'jenis_pengajuan' => 'PETTY CASH',
                'status' = > 0,
            ],
            [
                'kode' => 'PCC',
                'jenis_pengajuan' => 'PETTY CASH CUSTODIAN',
            ],
            [
                'kode' => 'PO',
                'jenis_pengajuan' => 'PURCHASE ORDER',
            ],
        ]);
    }
}
