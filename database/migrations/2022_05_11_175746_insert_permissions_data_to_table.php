<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InsertPermissionsDataToTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Illuminate\Support\Facades\DB::table('permissions')->where("route","=","admin.markAsComplete")->delete();
        \Illuminate\Support\Facades\DB::table('permissions')->insert([[
            'module_id' => 5,
            'parent_id' => 60,
            'name' => 'Mark as Complete',
            'route' => 'admin.markAsComplete',
            'type' => 3,
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
        //
    }
}
