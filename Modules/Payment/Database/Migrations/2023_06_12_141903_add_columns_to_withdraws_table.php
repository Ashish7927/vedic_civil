<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToWithdrawsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('enrolled_totals', function (Blueprint $table) {
            $table->integer('user_id')->nullable()->after('instructor_id');
            $table->integer('course_package_type')->nullable()->after('user_id')->comment('1 = Course 2 => Package');
            $table->integer('course_package_id')->nullable()->after('course_package_type');
            $table->integer('status')->after('myll_amount')->default(0);
        });

        Schema::table('withdraws', function (Blueprint $table) {
            $table->integer('user_id')->nullable()->after('instructor_id');
            $table->integer('course_package_type')->nullable()->after('user_id')->comment('1 = Course 2 => Package');
            $table->integer('course_package_id')->nullable()->after('course_package_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('enrolled_totals', function (Blueprint $table) {
            $table->dropColumn(['user_id', 'course_package_type', 'course_package_id', 'status']);
        });

        Schema::table('withdraws', function (Blueprint $table) {
            $table->dropColumn(['user_id', 'course_package_type', 'course_package_id']);
        });
    }
}
