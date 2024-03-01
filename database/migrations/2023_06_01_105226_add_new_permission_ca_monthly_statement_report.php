<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewPermissionCaMonthlyStatementReport extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $permission = DB::table('permissions')->where('route', 'admin.ca.monthly.statement.reports')->first();
        if (!$permission) {
            DB::table('permissions')->insert([
                'module_id' => 4, 'parent_id' => 18, 'name' => 'Corporate Access Monthly Statement Reports', 'route' => 'admin.ca.monthly.statement.reports', 'type' => 2, 'created_at' => now(), 'updated_at' => now()
            ]);
        }
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $permission = DB::table('permissions')->where('route', 'admin.ca.monthly.statement.reports')->first();
        if ($permission) {
            DB::table('permissions')->where('route', 'admin.ca.monthly.statement.reports')->delete();
        }

    }
}
