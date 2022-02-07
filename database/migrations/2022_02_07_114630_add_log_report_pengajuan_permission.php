<?php

use Illuminate\Database\Migrations\Migration;

class AddLogReportPengajuanPermission extends Migration
{
    private $permissions = [
        [
            'name' => 'log_report_pengajuan',
            'display_name' => 'Log Report Pengajuan Semua',
            'description' => 'Log Report Pengajuan Semua',
        ],
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $catId = DB::table('permissions_categories')->where('name', 'log_report')->first('id')->id;

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
