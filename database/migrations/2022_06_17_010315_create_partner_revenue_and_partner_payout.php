<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartnerRevenueAndPartnerPayout extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $sql = [
            ['module_id' => 4, 'parent_id' => 18, 'name' => 'Partner Revenue', 'route' => 'admin.reveune_list_partner', 'type' => 2, 'created_at' => now(), 'updated_at' => now()]
        ];

        DB::table('permissions')->insert($sql);

        $sql = [
            ['module_id' => 4, 'parent_id' => 18, 'name' => 'Partner Payout', 'route' => 'admin.partner.payout', 'type' => 2, 'created_at' => now(), 'updated_at' => now()],
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

    }
}
