<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEnableQuestionFeedbackToQuestionBanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('question_banks', function (Blueprint $table) {
            $table->tinyInteger("enable_question_feedback")->default(0)->comment('1=enable, 0=disable');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('question_banks', function (Blueprint $table) {
            $table->dropColumn("enable_question_feedback");
        });
    }
}
