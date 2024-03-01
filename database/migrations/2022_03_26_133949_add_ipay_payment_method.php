<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIpayPaymentMethod extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('payment_methods')->insert([[
            'method' => 'Ipay88',
            'type' => 'System',
            'active_status' => 1,
            'module_status' => 1,
            'logo' => 'demo/gateway/ipay88.png',
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
