<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEmailAddressColumnToAuditTrail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('audit_trail_learner_profiles', function (Blueprint $table) {
            $table->string("learner_name")->nullable();
            $table->string("email")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('audit_trail_learner_profiles', function (Blueprint $table) {
            $table->dropColumn("learner_name");
            $table->dropColumn('email');
        });
    }
}
