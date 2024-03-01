<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsInEnrolledTotalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('enrolled_totals', function (Blueprint $table) {
            $table->string('tracking')->nullable()->after('id');
            $table->unsignedInteger('withdraw_id')->nullable()->after('tracking');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('enrolled_totals', function (Blueprint $table) {
            $table->dropColumn('tracking');
            $table->dropColumn('withdraw_id');
        });
    }
}
