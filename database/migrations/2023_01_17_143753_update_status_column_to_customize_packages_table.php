<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateStatusColumnToCustomizePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customize_packages', function (Blueprint $table) {
             $table->integer('status')->default(0)->comment('0 => Saved, 1 => Published, 2 => UnPublished')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customize_packages', function (Blueprint $table) {
            //
        });
    }
}
