<?php

use Illuminate\Database\Migrations\Migration;

class AddSuratMasukPermissions extends Migration
{
    private $permissions = [
        [
            'name' => 'buat_surat_masuk',
            'display_name' => 'Buat Surat Masuk',
            'description' => 'Buat Surat Masuk',
        ],
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $catId = DB::table('permissions_categories')->insertGetId([
            'name' => 'surat_masuk',
            'display_name' => 'Surat Masuk',
        ]);

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

        DB::table('permissions_categories')->where('name', 'surat_masuk')->delete();
    }
}
