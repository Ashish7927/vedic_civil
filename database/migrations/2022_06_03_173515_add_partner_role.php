<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Role\Entities\Role;

class AddPartnerRole extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Role::create([
            'name' => 'Partner',
            'type' => 'System',
            'details' => 'Work as company'
        ]);

        DB::table('permissions')->insert([[
            'module_id' => 12,
            'parent_id' => 12,
            'name' => 'Partner Role',
            'route' => 'permission.roles.partner',
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
        Role::where('name', 'Partner')->delete();
        DB::table('permissions')->wehre('route', 'permission.roles.partner')->delete();
    }
}
