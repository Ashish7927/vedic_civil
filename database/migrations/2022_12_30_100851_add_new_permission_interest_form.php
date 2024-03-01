<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewPermissionInterestForm extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $permission = DB::table('permissions')->where('route', 'admin.interest.form')->first();
        if (!$permission) {
            DB::table('permissions')->insert(['module_id' => 4, 'parent_id' => 18, 'name' => 'Corporate Access Interest Form', 'route' => 'admin.interest.form', 'type' => 2]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('permissions')->where('route', 'admin.interest.form')->delete();
    }
}
