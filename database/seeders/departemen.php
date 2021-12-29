<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class departemen extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('departemens')->insert([[
                'kode' => 'DIR',
                'departemen' => 'DIREKSI',
            ],
            [
                'kode' => 'CA',
                'departemen' => 'CORPORATE ADMIN',
            ],
            [
                'kode' => 'FAT',
                'departemen' => 'FINANCE, ACCOUNTING, AND TAX',
            ],
            [
                'kode' => 'IA',
                'departemen' => 'INTERNAL AUDIT',
            ],
            [
                'kode' => 'LG',
                'departemen' => 'LEGAL',
            ],
            [
                'kode' => 'MS',
                'departemen' => 'MARKETING & SOLUTIONS',
            ],
            [
                'kode' => 'IT',
                'departemen' => 'INFORMATION TECHNOLOGY',
            ],
            [
                'kode' => 'HRGS',
                'departemen' => 'HR DAN GS',
            ],
        ]);
    }
}
