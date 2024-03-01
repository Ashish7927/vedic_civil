<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeaturedCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('featured_courses', function (Blueprint $table) {
            $table->id();
            $table->boolean('type')->default(0)->comment('course type: 0 = free course, 1 = premium course');
            $table->unsignedBigInteger('course_id');
            $table->string('course_title')->nullable();
            $table->string('thumbnail')->nullable();
            $table->unsignedInteger('order')->default(0);
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
        Schema::dropIfExists('featured_courses');
    }
}
