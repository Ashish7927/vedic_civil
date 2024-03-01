<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackageCustomRequests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_custom_requests', function (Blueprint $table) {
            $table->id();
            $table->integer('cpa_id');
            $table->string('full_name');
            $table->string('email_address');
            $table->string('phone_number');
            $table->string('company_name');
            $table->string('company_registration');
            $table->integer('updated_by')->nullable();;
            $table->string('request_status')->default('New');
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
        Schema::dropIfExists('package_custom_requests');
    }
}
