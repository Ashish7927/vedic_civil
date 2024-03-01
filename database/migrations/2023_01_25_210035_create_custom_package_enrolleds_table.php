<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomPackageEnrolledsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custom_package_enrolleds', function (Blueprint $table) {
            $table->id();
            $table->string('tracking')->default(1)->nullable();
            $table->integer('user_id');
            $table->integer('customize_packages_id');
            $table->float('purchase_price', 8, 2);
            $table->string('coupon')->nullable();
            $table->float('discount_amount', 8, 2);
            $table->float('quantity', 8, 2);
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('is_assigned')->default(0)->comment('0 = No, 1 = Yes');
            $table->integer('assigner_id')->nullable();
            $table->date('due_date')->nullable();
            $table->dateTime('activation_date')->nullable();
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
        Schema::dropIfExists('custom_package_enrolleds');
    }
}
