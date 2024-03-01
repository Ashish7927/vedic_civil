<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPremissionPayoutRecords extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $sql = [
            ['module_id' => 4, 'parent_id' => 18, 'name' => 'Content Provider Payout Records', 'route' => 'admin.payout.records', 'type' => 2, 'created_at' => now(), 'updated_at' => now()]
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
        $sql = [
            ['module_id' => 4, 'parent_id' => 18, 'name' => 'Content Provider Payout Records', 'route' => 'admin.payout.records', 'type' => 2, 'created_at' => now(), 'updated_at' => now()]
        ];
        DB::table('permissions')->delete($sql);
    }
}
