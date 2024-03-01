<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDetailTabToCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->tinyInteger("detail_tab")->default(0)->comment('0 = Not completed, 1 = Completed');
            $table->tinyInteger("curriculum_tab")->default(0)->comment('0 = Not completed, 1 = Completed');
            $table->tinyInteger("exercise_files_tab")->default(0)->comment('0 = Not completed, 1 = Completed');
            $table->tinyInteger("certificate_tab")->default(0)->comment('0 = Not completed, 1 = Completed');
        });

        Schema::table('certificates', function (Blueprint $table) {
            $table->tinyInteger("is_free")->default(1)->comment('0 = No, 1 = Yes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn(['detail_tab', 'curriculum_tab', 'exercise_files_tab', 'certificate_tab']);
        });

        Schema::table('certificates', function (Blueprint $table) {
            $table->dropColumn(['is_free']);
        });
    }
}
