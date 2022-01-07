<?php

use Illuminate\Database\Migrations\Migration;

class AddBuatSuratKeluarPermission extends Migration
{
    private $permissions = [
        [
            'name' => 'buat_surat_keluar',
            'display_name' => 'Buat Surat Keluar',
            'description' => 'Buat Surat Keluar',
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
