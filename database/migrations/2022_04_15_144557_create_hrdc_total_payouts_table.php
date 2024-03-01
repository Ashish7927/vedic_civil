<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrdcTotalPayoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrdc_total_payouts', function (Blueprint $table) {
            $table->id();
            $table->integer('instructor_id');
            $table->string('hrdc_amount')->default(0);
            $table->timestamps();
        });

        Schema::table('withdraws', function (Blueprint $table) {
            $table->tinyInteger('type')->default(0)->comment('1 = Instructor, 2 = HRDC')->after('method');
        });

        $sql = [
            ['module_id' => 4, 'parent_id' => 4, 'name' => 'Hrdc Payout List', 'route' => 'admin.hrdc.payout', 'type' => 2, 'created_at' => now(), 'updated_at' => now()]
        ];

        DB::table('permissions')->insert($sql);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hrdc_total_payouts');

        Schema::table('withdraws', function (Blueprint $table) {
            $table->dropColumn(['type']);
        });
    }
}
