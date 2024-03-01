<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAllowPermissionsForPartner extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $getPermissionId = \Illuminate\Support\Facades\DB::table('permissions')->where("route","=","instructor.course_api_key")->first();

        DB::table('role_permission')->insert([[
            'permission_id' => $getPermissionId->id,
            'role_id' => 8,
            'status' => '1',
            'created_by' => '1',
            'updated_by' => '1',
        ],
        ]);
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
