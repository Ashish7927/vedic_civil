<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakePartnerAndCpHasSamePermissionsForData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $sql = [
            ['module_id' => 4, 'parent_id' => 18, 'name' => 'Content Provider and Partner Revenue Data', 'route' => 'admin.reveune_list_cp_data', 'type' => 2, 'created_at' => now(), 'updated_at' => now()]
        ];

        DB::table('permissions')->insert($sql);

        $getPermissionId = \Illuminate\Support\Facades\DB::table('permissions')->where("route","=","admin.reveune_list_cp_data")->first();

        DB::table('role_permission')->insert([[
            'permission_id' => $getPermissionId->id,
            'role_id' => 7,
            'status' => '1',
            'created_by' => '1',
            'updated_by' => '1',
        ],
        ]);

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
