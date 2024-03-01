<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEnableQuizFeedbackToOnlineQuizzesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('online_quizzes', function (Blueprint $table) {
            $table->tinyInteger("enable_quiz_feedback")->default(0)->comment('1=enable, 0=disable');
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
            $table->dropColumn("enable_quiz_feedback");
        });
    }
}
