<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCorporateIdToQuestionBanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('question_banks', function (Blueprint $table) {
            $table->integer("corporate_id")->nullable();
        });

        Schema::table('question_groups', function (Blueprint $table) {
            $table->integer("corporate_id")->nullable();
        });

        Schema::table('online_quizzes', function (Blueprint $table) {
            $table->integer("corporate_id")->nullable();
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
            $table->dropColumn(['corporate_id']);
        });

        Schema::table('question_groups', function (Blueprint $table) {
            $table->dropColumn(['corporate_id']);
        });

        Schema::table('online_quizzes', function (Blueprint $table) {
            $table->dropColumn(['corporate_id']);
        });
    }
}
