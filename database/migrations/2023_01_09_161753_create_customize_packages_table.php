<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomizePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customize_packages', function (Blueprint $table) {
            $table->id();
            $table->integer('ca_user_id')->comment('corporate_id');
            $table->integer('cp_user_id')->comment('content_provider_id')->nullable();
            $table->string('name');
            $table->float('price', 8, 2);
            $table->integer('expiry_period');

            $table->text('description');
            $table->string('image');
            $table->integer('total_courses');
            $table->integer('status')->default(0)->comment('0 => New, 1 => In Progress, 2 => Completed, 3 =>Closed');
            $table->dateTime('published_at')->nullable();
            $table->dateTime('submitted_at')->nullable();
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
        Schema::dropIfExists('customize_packages');
    }
}
