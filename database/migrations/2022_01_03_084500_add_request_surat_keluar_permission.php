<?php

use Illuminate\Database\Migrations\Migration;

class AddRequestSuratKeluarPermission extends Migration
{
    private $permissions = [
        [
            'name' => 'request_surat_keluar',
            'display_name' => 'Permintaan pembuatan surat keluar',
            'description' => 'permintaan pembuatan surat keluar',
        ],
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach ($this->permissions as $permission) {
            $permission['created_at'] = date('Y-m-d H:i:s');
            $permission['updated_at'] = date('Y-m-d H:i:s');
            DB::table('permissions')->insert($permission);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach ($this->permissions as $permission) {
            DB::table('permissions')->where('name', $permission['name'])->delete();
        }
    }
}
