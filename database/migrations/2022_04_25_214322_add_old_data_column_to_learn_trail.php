<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOldDataColumnToLearnTrail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('audit_trail_learner_profiles', function (Blueprint $table) {
            $table->text('subject')->nullable()->change();
            $table->text('old_data')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('learn_trail', function (Blueprint $table) {
            //
        });
    }
}
