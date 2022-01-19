<?php

use Illuminate\Database\Migrations\Migration;

class AddPengajuanPermissions extends Migration
{
    private $permissions = [
        [
            'name' => 'reviewdep_pengajuan',
            'display_name' => 'Review pengajuan departemen',
            'description' => 'review pengajuan dari setiap departemen',
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
            'name' => 'pengajuan',
            'display_name' => 'Pengajuan',
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

        DB::table('permissions_categories')->where('name', 'pengajuan')->delete();
    }
}
