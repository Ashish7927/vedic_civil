<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPermissionsToCourseApiKeyPage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $sql = ['module_id' => 5, 'parent_id' => 5, 'name' => 'Course Api Key Page', 'route' => 'courseApiKey', 'type' => 2];

        DB::table('permissions')->insert($sql);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $sql = ['module_id' => 5, 'parent_id' => 5, 'name' => 'Course Api Key Page', 'route' => 'courseApiKey', 'type' => 2];

        DB::table('permissions')->delete($sql);
    }
}
