<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookedDemo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booked_demo', function (Blueprint $table) {
            $table->id();
            $table->string('full_name', 50);
            $table->string('email_address', 30);
            $table->string('phone_number', 50);
            $table->string('company_name', 50);
            $table->string('company_registration_no', 50);
            $table->string('location', 50);
            $table->string('industry', 100);
            $table->smallInteger('no_of_employees');
            $table->string('hrd_corp', 3);
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
        Schema::dropIfExists('booked_demo');
    }
}
