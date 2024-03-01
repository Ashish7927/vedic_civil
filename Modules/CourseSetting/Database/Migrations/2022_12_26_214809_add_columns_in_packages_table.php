<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsInPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->float('special_commission', 8, 2)->after('total_rating')->nullable();
            $table->integer('hrdc_commission')->after('special_commission')->default(0);
            $table->tinyInteger('is_corporate')->after('hrdc_commission')->default(0)->comment("0 = No, 1 = Yes");
            $table->string('subscription_list')->after('is_corporate')->nullable();
            $table->float('reveune', 8, 2)->after('subscription_list')->default(0.00);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->dropColumn(['special_commission', 'hrdc_commission', 'is_corporate', 'subscription_list', 'reveune']);
        });
    }
}
