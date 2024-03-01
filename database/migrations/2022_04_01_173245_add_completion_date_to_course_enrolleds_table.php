<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCompletionDateToCourseEnrolledsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('course_enrolleds', function (Blueprint $table) {
            $table->tinyInteger('is_completed')->default(0);
            $table->dateTime('completion_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('course_enrolleds', function (Blueprint $table) {
            $table->dropColumn(['is_completed', 'completion_date']);
        });
    }
}
