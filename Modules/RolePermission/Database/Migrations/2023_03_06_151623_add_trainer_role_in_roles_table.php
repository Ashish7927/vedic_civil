<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\RolePermission\Entities\Role;
use Illuminate\Support\Facades\DB;

class AddTrainerRoleInRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Role::create([
            'name' => 'Trainer',
            'type' => 'System',
            'details' => 'Company Trainer',
            'created_at' => date('Y-m-d h:i:s')
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Role::where('name', 'Trainer')->delete();
    }
}
