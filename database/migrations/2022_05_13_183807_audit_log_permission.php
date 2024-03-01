<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AuditLogPermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $sql1 = [
            ['module_id' => 4, 'parent_id' => 18, 'name' => 'Audit Logs', 'route' => 'admin.auditlogs', 'type' => 2, 'created_at' => now(), 'updated_at' => now()]
        ];

        DB::table('permissions')->insert($sql1);

        $data_error_log = DB::table('permissions')->where('route', 'admin.auditlogs')->first();

        $sql2 = [
            ['module_id' => 4, 'parent_id' => $data_error_log->id, 'name' => 'Audit Logs List', 'route' => 'admin.auditTrailLearnerProfile', 'type' => 3, 'created_at' => now(), 'updated_at' => now()],

            ['module_id' => 4, 'parent_id' => $data_error_log->id, 'name' => 'Audit Logs Data', 'route' => 'admin.auditTrailLearnerProfileData', 'type' => 3, 'created_at' => now(), 'updated_at' => now()],

            ['module_id' => 4, 'parent_id' => $data_error_log->id, 'name' => 'Compare Audit Learner Profile Data', 'route' => 'admin.getCompareAuditTrailLearnerProfileData', 'type' => 3, 'created_at' => now(), 'updated_at' => now()]
        ];

        DB::table('permissions')->insert($sql2);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
