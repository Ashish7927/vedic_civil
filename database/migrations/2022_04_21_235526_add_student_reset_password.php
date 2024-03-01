<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStudentResetPassword extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Illuminate\Support\Facades\DB::table('permissions')->where("route","=","student.reset_password")->delete();
        \Illuminate\Support\Facades\DB::table('permissions')->insert([[
            'module_id' => 2,
            'parent_id' => 31,
            'name' => 'Student Reset Password',
            'route' => 'student.reset_password',
            'type' => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        ]);

        $getPermissionId = \Illuminate\Support\Facades\DB::table('permissions')->where("route","=","student.reset_password")->first();
        \Illuminate\Support\Facades\DB::table('role_permission')->insert([[
            'permission_id' => $getPermissionId->id,
            'role_id' => 2,
            'status' => '1',
            'created_by'=> '1',
            'updated_by'=> '1'
        ],
        ]);

        \Illuminate\Support\Facades\DB::table('permissions')->where("route","=","student.view_learner_profile")->delete();

        DB::table('permissions')->insert([[
            'module_id' => 2,
            'parent_id' => 31,
            'name' => 'Student View Learner Profile',
            'route' => 'student.view_learner_profile',
            'type' => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        ]);

        $getPermissionId = \Illuminate\Support\Facades\DB::table('permissions')->where("route","=","student.view_learner_profile")->first();

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
        //
    }
}
