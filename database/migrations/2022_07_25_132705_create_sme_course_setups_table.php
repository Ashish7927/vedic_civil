<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSmeCourseSetupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sme_course_setups', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('is_enabled');
            $table->timestamps();
        });

        \Illuminate\Support\Facades\DB::table('sme_course_setups')->insert([
           'is_enabled' => 1,
           'created_at' => now(),
           'updated_at' => now()
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sme_course_setups');
    }
}
