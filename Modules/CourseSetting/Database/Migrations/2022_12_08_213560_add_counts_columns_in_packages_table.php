<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCountsColumnsInPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->integer('total_courses')->after('image')->default(0);
            $table->integer('total_enrolled')->after('total_courses')->default(0);
            $table->integer('total_rating')->after('total_enrolled')->default(0);
            $table->string('slug')->after('name')->nullable();
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
            $table->dropColumn(['slug', 'total_courses', 'total_enrolled', 'total_rating']);
        });
    }
}
