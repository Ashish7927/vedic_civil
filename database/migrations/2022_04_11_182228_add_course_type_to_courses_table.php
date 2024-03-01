<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCourseTypeToCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->tinyInteger('course_type')->default(0)->comment('1 = Micro-credential, 2 = Claimable course, 3 = Other')->after('type');
            $table->tinyInteger('declaration')->default(0)->comment('0 = No, 1 = Yes')->after('course_type');
            $table->string('trainer')->nullable()->after('declaration');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('state', 'city_text');
        });

        \Illuminate\Support\Facades\DB::unprepared("ALTER TABLE `users` CHANGE `city` `city` VARCHAR(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT '1374' COMMENT 'as State'");

        \Illuminate\Support\Facades\DB::unprepared("ALTER TABLE `billing_details` CHANGE `city` `city` VARCHAR(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'as State'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn(['course_type', 'declaration', 'trainer']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('city_text', 'state');
        });
    }
}
