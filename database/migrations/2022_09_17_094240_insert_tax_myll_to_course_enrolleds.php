<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InsertTaxMyllToCourseEnrolleds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('course_enrolleds', function (Blueprint $table) {
            $table->float('tax_price', 8, 2)->default(0);
            $table->float('myll_revenue', 8, 2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumns('course_enrolleds', ['tax_price', 'myll_revenue'])) {
            Schema::table('course_enrolleds', function (Blueprint $table) {
                $table->dropColumn(['tax_price', 'myll_revenue']);
            });
        }
    }
}
