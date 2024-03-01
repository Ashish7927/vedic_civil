<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStudentImpersonateToPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Illuminate\Support\Facades\DB::table('permissions')->where("route","=","student.impersonate")->delete();

        DB::table('permissions')->insert([[
            'module_id' => 2,
            'parent_id' => 31,
            'name' => 'Student Impersonate',
            'route' => 'student.impersonate',
            'type' => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        ]);

        $getPermissionId = \Illuminate\Support\Facades\DB::table('permissions')->where("route","=","student.impersonate")->first();

        DB::table('role_permission')->insert([[
            'permission_id' => $getPermissionId->id,
            'role_id' => 4,
            'status' => '1',
            'created_by' => '1',
            'updated_by' => '1',
        ],
        ]);

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
        Schema::table('permissions', function (Blueprint $table) {
            //
        });
    }
}
