<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_receipts', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('receipt_number');
            $table->string('tracking');
            $table->float('total_tax_rate',8,2);
            $table->float('total_tax_amount',8,2);
            $table->float('grand_total',8,2);
            $table->timestamps();
        });

        Schema::create('user_receipt_courses', function (Blueprint $table) {
            $table->id();
            $table->integer('user_receipt_id');
            $table->integer('course_id');
            $table->integer('instructor_id');
            $table->float('price',8,2);
            $table->float('tax_rate',8,2);
            $table->float('tax_amount',8,2);
            $table->float('total_with_tax',8,2);
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
        Schema::dropIfExists('user_receipts', 'user_receipt_courses');
    }
}