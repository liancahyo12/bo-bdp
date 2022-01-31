<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            [
                'name' => 'corporate_adm',
                'display_name' => 'Corporate Adm',
                'description' => 'Review, Buat, dan Arsip surat',
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ],
            [
                'name' => 'direktur',
                'display_name' => 'Direktur',
                'description' => 'Approver',
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ],
            [
                'name' => 'review_departemen_pengajuan',
                'display_name' => 'review departemen pengajuan',
                'description' => 'review departemen pengajuan',
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ],
            [
                'name' => 'review_pengajuan_keuangan',
                'display_name' => 'review pengajuan keuangan',
                'description' => 'review pengajuan keuangan',
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ],
            [
                'name' => 'approve_pengajuan',
                'display_name' => 'approve pengajuan',
                'description' => 'approve pengajuan',
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ],
            [
                'name' => 'buat_pengajuan',
                'display_name' => 'Buat Pengajuan',
                'description' => 'Buat Pengajuan',
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ],
            [
                'name' => 'bayar_pengajuan',
                'display_name' => 'Bayar Pengajuan',
                'description' => 'Bayar Pengajuan',
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ],
        ]);
        DB::table('roles')->insert([
            [
                'name' => 'corporate_adm',
                'display_name' => 'Corporate Adm',
                'description' => 'Review, Buat, dan Arsip surat',
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ],
            [
                'name' => 'direktur',
                'display_name' => 'Direktur',
                'description' => 'Approver',
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ],
            [
                'name' => 'review_departemen_pengajuan',
                'display_name' => 'review departemen pengajuan',
                'description' => 'review departemen pengajuan',
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ],
            [
                'name' => 'review_pengajuan_keuangan',
                'display_name' => 'review pengajuan keuangan',
                'description' => 'review pengajuan keuangan',
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ],
            [
                'name' => 'approve_pengajuan',
                'display_name' => 'approve pengajuan',
                'description' => 'approve pengajuan',
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ],
            [
                'name' => 'buat_pengajuan',
                'display_name' => 'Buat Pengajuan',
                'description' => 'Buat Pengajuan',
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ],
            [
                'name' => 'bayar_pengajuan',
                'display_name' => 'Bayar Pengajuan',
                'description' => 'Bayar Pengajuan',
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ],
        ]);
    }
}
