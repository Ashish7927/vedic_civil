<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseAuthenticationTokenWithExpiry extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_authentication_token', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('api_token');
            $table->integer('expiry_time');
            $table->timestamps();
        });

        $sql = ['module_id' => 5, 'parent_id' => 5, 'name' => 'Authentication Course Api', 'route' => 'getCourseAuthenticationApi', 'type' => 2];


        DB::table('permissions')->insert($sql);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_authentication_token');

        $sql = ['module_id' => 5, 'parent_id' => 5, 'name' => 'Authentication Course Api', 'route' => 'getCourseAuthenticationApi', 'type' => 2];

        DB::table('permissions')->delete($sql);
    }
}
