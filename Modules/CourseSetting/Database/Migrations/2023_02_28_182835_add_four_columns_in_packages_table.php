<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFourColumnsInPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->integer('min_license_no')->after('reveune')->default(0);
            $table->integer('max_license_no')->after('min_license_no')->default(0);
            $table->integer('total_course')->after('max_license_no')->default(0);
            $table->text('overview')->after('total_course')->nullable();
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
            $table->dropColumn(['min_license_no', 'max_license_no', 'total_course', 'overview']);
        });
    }
}
