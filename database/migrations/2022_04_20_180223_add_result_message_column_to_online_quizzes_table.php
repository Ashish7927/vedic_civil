<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddResultMessageColumnToOnlineQuizzesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('online_quizzes', function (Blueprint $table) {
            $table->string('pass_message')->nullable()->after('multiple_attend');
            $table->string('fail_message')->nullable()->after('pass_message');
            $table->tinyInteger('display_result_message')->default(0)->comment("0 = No, 1 = Yes")->after('fail_message');
        });

        Schema::table('groups', function (Blueprint $table) {
            $table->tinyInteger('course_type')->default(0)->comment('1 = Micro-credential, 2 = Claimable course, 3 = Other')->after('name');
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
            $table->dropColumn(['pass_message','fail_message','display_result_message']);
        });

        Schema::table('groups', function (Blueprint $table) {
            $table->dropColumn(['course_type']);
        });
    }
}
