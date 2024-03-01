<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPermissionAdminInstructorPayoutForHrdcPayout extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $getPermissionId = \Illuminate\Support\Facades\DB::table('permissions')->where("route","=","admin.instructor.payout")->first();

        DB::table('role_permission')->insert([[
            'permission_id' => $getPermissionId->id,
            'role_id' => 5,
            'status' => '1',
            'created_by' => '1',
            'updated_by' => '1',
        ],
        ]);

        DB::table('role_permission')->insert([[
            'permission_id' => $getPermissionId->id,
            'role_id' => 6,
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
