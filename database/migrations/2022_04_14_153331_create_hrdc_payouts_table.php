<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrdcPayoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrdc_payouts', function (Blueprint $table) {
            $table->id();
            $table->integer('instructor_id');
            $table->float('hrdc_reveune')->default(0.00);
            $table->float('myll_reveune')->default(0.00);
            $table->boolean('status')->default(0);
            $table->timestamps();
        });

        Schema::table('course_enrolleds', function (Blueprint $table) {
            $table->integer('hrdc_reveune')->default(0)->after('reveune');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hrdc_payouts');

        Schema::table('course_enrolleds', function (Blueprint $table) {
            $table->dropColumn(['hrdc_reveune']);
        });
    }
}
