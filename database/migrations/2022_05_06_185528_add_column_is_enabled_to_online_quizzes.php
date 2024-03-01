<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnIsEnabledToOnlineQuizzes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('online_quizzes', function (Blueprint $table) {
            $table->tinyInteger("is_enabled")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('online_quizzes', function (Blueprint $table) {
            $table->dropColumn("is_enabled");
        });
    }
}
