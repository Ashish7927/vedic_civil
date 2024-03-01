<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnToPackages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->integer('corporate_id')->after('user_id');
            $table->enum('package_type', ['0','1'])->default('0')->after('status')->comment('0 = package, 1 = custom package');;
            $table->integer('aprove_status')->after('package_type')->default(0)->comment('1 => Aproved');
            $table->integer('aproved_by')->after('aprove_status')->nullable();
          
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('packages', function (Blueprint $table) {
            //
        });
    }
}
