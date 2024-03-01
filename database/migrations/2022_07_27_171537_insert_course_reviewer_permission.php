<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InsertCourseReviewerPermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $sql = [
            ['module_id' => 4, 'parent_id' => null, 'name' => 'Course Reviewer', 'route' => 'course_reviewer', 'type' => 1, 'created_at' => now(), 'updated_at' => now()]
        ];

        DB::table('permissions')->insert($sql);
        //DB::table('permissions')->where($sql);

        $sql1 = [
            'module_id' => 4,
            'parent_id' => null,
            'name' => 'Course Reviewer',
            'route' => 'course_reviewer',
            'type' => 1
        ];

        $data_cp = DB::table('permissions')->where($sql1)->first();

        $sql2 = [
            ['module_id' => 4, 'parent_id' => $data_cp->id, 'name' => 'Course Reviewer List', 'route' => 'admin.course_reviewer.list', 'type' => 2, 'created_at' => now(), 'updated_at' => now()]
        ];

        DB::table('permissions')->insert($sql2);

        $sql3 = [
            ['module_id' => 5, 'parent_id' => 60, 'name' => 'View Course Feedback', 'route' => 'course.view_course_feedback', 'type' => 3, 'created_at' => now(), 'updated_at' => now()]
        ];

        DB::table('permissions')->insert($sql3);

        $sql4 = [
            ['module_id' => 5, 'parent_id' => 60, 'name' => 'Approve Course', 'route' => 'course.approve_course', 'type' => 3, 'created_at' => now(), 'updated_at' => now()]
        ];

        DB::table('permissions')->insert($sql4);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('permissions')->where('route', 'course_reviewer')->delete();
        DB::table('permissions')->where('route', 'admin.course_reviewer.list')->delete();
        DB::table('permissions')->where('route', 'course.view_course_feedback')->delete();
        DB::table('permissions')->where('route', 'course.approve_course')->delete();
    }
}
