<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAllowUsingCourseApiKeyPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $sql =  ['module_id' => 4, 'parent_id' => 44, 'name' => 'Allow course Api Key', 'route' => 'instructor.course_api_key', 'type' => 3];

        DB::table('permissions')->insert($sql);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $sql =  ['module_id' => 4, 'parent_id' => 44, 'name' => 'Allow course Api Key', 'route' => 'instructor.course_api_key', 'type' => 3];

        DB::table('permissions')->delete($sql);
    }
}
