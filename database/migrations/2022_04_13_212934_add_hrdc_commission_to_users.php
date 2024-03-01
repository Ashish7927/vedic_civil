<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHrdcCommissionToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('hrdc_commission')->default(0)->after('special_commission');
        });

        Schema::table('courses', function (Blueprint $table) {
            $table->integer('hrdc_commission')->default(0)->after('special_commission');
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
            $table->dropColumn(['hrdc_commission']);
        });

        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn(['hrdc_commission']);
        });
    }
}
