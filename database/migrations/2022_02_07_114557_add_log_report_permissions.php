<?php

use Illuminate\Database\Migrations\Migration;

class AddLogReportPermissions extends Migration
{
    private $permissions = [
        [
            'name' => 'log_report_pengajuan_saya',
            'display_name' => 'Log Report Pengajuan Saya',
            'description' => 'Log Report Pengajuan Saya',
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
            'name' => 'log_report',
            'display_name' => 'Log Report',
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

        DB::table('permissions_categories')->where('name', 'log_report')->delete();
    }
}
