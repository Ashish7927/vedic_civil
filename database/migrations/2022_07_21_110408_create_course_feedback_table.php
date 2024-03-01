<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseFeedbackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_feedback', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cp_id');
            $table->integer('course_id');
            $table->integer('reviewer_id')->unsigned();
            $table->string('course_title')->nullable();
            $table->text('feedback');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_feedback');
    }
}
