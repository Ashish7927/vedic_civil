<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToHeaderMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('header_menus', function (Blueprint $table) {
            $table->boolean('status')->default(1)->after('is_newtab')->comment('0=inactive | 1=active');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('header_menus', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
