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
                'kode' => 'PC',
                'jenis_pengajuan' => 'PETTY CASH',
            ],
            [
                'kode' => 'PP',
                'jenis_pengajuan' => 'POSTPAID PAYMENT',
            ],
            [
                'kode' => 'CA',
                'jenis_pengajuan' => 'CASH ADVANCE',
            ],
            [
                'kode' => 'RP',
                'jenis_pengajuan' => 'REIMBURSEMENT PAYMENT',
            ],
            [
                'kode' => 'PPC',
                'jenis_pengajuan' => 'PETTY CASH CUSTODIAN',
            ],
            [
                'kode' => 'PO',
                'jenis_pengajuan' => 'PURCHASE ORDER',
            ],
        ]);
    }
}
