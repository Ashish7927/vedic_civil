<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Setting\Model\DateFormat;

class AddSstRegistrationNoToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string("sst_registration_no")->nullable();
        });

        $data = [
            ['j M, Y', '17 May, 2019']
        ];
        // DB::table('date_formats')->insert($data);
        foreach ($data as $dateFormate) {
            $store = new DateFormat();
            $store->format = $dateFormate[0];
            $store->normal_view = $dateFormate[1];
            $store->created_at = now();
            $store->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['sst_registration_no']);
        });

        DB::table('date_formats')->where('format', 'j M, Y')->delete();
    }
}
