<?php

use Illuminate\Database\Migrations\Migration;

class AddReviewRequestSuratKeluarPermission extends Migration
{
    private $permissions = [
        [
            'name' => 'review_request_surat_keluar',
            'display_name' => 'Review permintaan surat keluar',
            'description' => 'review permintaan surat keluar',
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
