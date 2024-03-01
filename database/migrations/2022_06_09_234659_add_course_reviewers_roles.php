<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Role\Entities\Role;

class AddCourseReviewersRoles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Role::create([
            'name' => 'Course Reviewer',
            'type' => 'System',
            'details' => 'Course Reviewer'
        ]);

        DB::table('permissions')->insert([[
            'module_id' => 12,
            'parent_id' => 12,
            'name' => 'Course Reviewer',
            'route' => 'permission.course.reviewer',
            'type' => 2,
            'created_at' => now(),
            'updated_at' => now(),
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
       Role::where('name', 'Course Reviewer')->delete();
        DB::table('permissions')->where('route', 'permission.course.reviewer')->delete();
    }
}
