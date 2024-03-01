<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateColumnNameToCustomizePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customize_packages', function (Blueprint $table) {
            $table->renameColumn('ca_user_id', 'cpa_id');
            $table->renameColumn('cp_user_id', 'created_by');
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
