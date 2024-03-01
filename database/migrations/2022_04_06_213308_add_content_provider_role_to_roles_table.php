<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Role\Entities\Role;

class AddContentProviderRoleToRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Role::create([
            'name' => 'Content Provider',
            'type' => 'System',
            'details' => 'Work as company'
        ]);

        DB::table('permissions')->insert([[
            'module_id' => 12,
            'parent_id' => 12,
            'name' => 'Content Provider Role',
            'route' => 'permission.roles.contentprovider',
            'type' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        ]);

        Schema::table('users', function (Blueprint $table) {
            $table->string('address2')->nullable()->after('address');
            $table->string('state')->nullable()->after('city');
            $table->string('brand_name')->nullable();
            $table->text('company_profile_summary')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['address2', 'state', 'brand_name', 'company_profile_summary']);
        });
    }
}
