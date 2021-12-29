<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PengajuanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('pengajuans')->insert([
            'user_id' => 1;
            'judul' => 'Pembelian Laptop Designer',
            'deskripsi' => 'Laptop dengan spek core i7 rtx 3080',
            'nominal' => 10000000.00;
            'lampiran' => '';
            'send_status' => 0;
            'reviewer_id' => 2;
        ]);
    }
}
