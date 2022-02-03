<?php

use Illuminate\Database\Migrations\Migration;

class AddArsipSuratMasukPermission extends Migration
{
    private $permissions = [
        [
            'name' => 'arsip_surat_masuk',
            'display_name' => 'Arsip Surat Masuk',
            'description' => 'Arsip Surat Masuk',
        ],
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $catId = DB::table('permissions_categories')->where('name', 'surat_masuk')->first('id')->id;

        foreach ($this->permissions as $permission) {
            $permission['created_at'] = date('Y-m-d H:i:s');
            $permission['updated_at'] = date('Y-m-d H:i:s');
            $permission['category_id'] = $catId;
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
