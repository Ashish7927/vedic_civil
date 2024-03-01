<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPermissionsToHrdcAdminToViewCpPayout extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $getPermissionId = \Modules\RolePermission\Entities\Permission::where('route', 'admin.cp.payout')->first();
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
