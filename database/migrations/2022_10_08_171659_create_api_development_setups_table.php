<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApiDevelopmentSetupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses_api_development_setups', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('is_enabled');
            $table->timestamps();
        });

        \Illuminate\Support\Facades\DB::table('courses_api_development_setups')->insert([
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
        Schema::dropIfExists('api_development_setups');
    }
}
