<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWpNoToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->string('father_name')->nullable()->after('name');
            $table->string('wp_no')->nullable()->after('phone');
            $table->string('where_did_you_know')->nullable()->after('wp_no');
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
            //
            $table->dropColumn('father_name');
            $table->dropColumn('wp_no');
            $table->dropColumn('where_did_you_know');
        });
    }
}
