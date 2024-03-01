<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Modules\RolePermission\Entities\Permission;

class AddNewPermissionOfCourseHighlights extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $permission = Permission::where('route', 'package')->first();
        if($permission) {
            DB::table('permissions')->insert(
                [
                    'module_id' => $permission->module_id,
                    'parent_id' => $permission->id,
                    'name' => 'Course Highlights',
                    'route' => 'getAllCourseHighlights',
                    'type' => 2,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        $getPermissionId = DB::table('permissions')->where('route', 'getAllCourseHighlights')->first();
        if($getPermissionId) {
            DB::table('role_permission')->insert([
                [
                    'permission_id' => $getPermissionId->id,
                    'role_id' => 8,
                    'status' => '1',
                    'created_by' => '1',
                    'updated_by' => '1'
                ],
            ]);

            DB::table('role_permission')->insert([
                [
                    'permission_id' => $getPermissionId->id,
                    'role_id' => 7,
                    'status' => '1',
                    'created_by' => '1',
                    'updated_by' => '1'
                ],
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
