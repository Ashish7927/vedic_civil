<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CourseFeedbackPermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $sql1 = [
            ['module_id' => 5, 'parent_id' => 60, 'name' => 'Feedback', 'route' => 'course.feedback', 'type' => 3, 'created_at' => now(), 'updated_at' => now()]
        ];

        DB::table('permissions')->insert($sql1);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
         DB::table('permissions')->where('route', 'course.feedback')->delete();
    }
}
