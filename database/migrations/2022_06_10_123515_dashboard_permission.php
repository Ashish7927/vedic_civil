<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class DashboardPermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $sql = [
            ['module_id' => 1, 'parent_id' => 1, 'name' => 'Number Of Published Courses', 'route' => 'dashboard.number_of_published_courses', 'type' => 2],
            ['module_id' => 1, 'parent_id' => 1, 'name' => 'Number Of In Review Courses', 'route' => 'dashboard.number_of_inreview_courses', 'type' => 2]
        ];

        DB::table('permissions')->insert($sql);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('permissions')->where('route', 'dashboard.number_of_published_courses')->delete();
        DB::table('permissions')->where('route', 'dashboard.number_of_inreview_courses')->delete();
    }
}
