<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDailyWiseRegisterUserPermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('permissions')->insert([[
            'module_id' => 1,
            'parent_id' => 1,
            'name' => 'Daily Wise Registered User',
            'route' => 'dashboard.daily_wise_registered_user',
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
        
    }
}
