<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCourseBulkActionPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $sql = ['module_id' => 5, 'parent_id' => 5, 'name' => 'Course Bulk', 'route' => 'getCourseBulk', 'type' => 2];

        DB::table('permissions')->insert($sql);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $sql = ['module_id' => 5, 'parent_id' => 5, 'name' => 'Course Bulk', 'route' => 'getCourseBulk', 'type' => 2];

        DB::table('permissions')->delete($sql);
    }
}
