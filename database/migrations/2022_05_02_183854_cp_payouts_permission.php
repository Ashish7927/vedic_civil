<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CpPayoutsPermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        // Schema::table('courses', function (Blueprint $table) {
        //     $table->tinyInteger('is_saved')->default(0)->comment('0 = No, 1 = Yes');
        // });
        
        $sql = [
            ['module_id' => 4, 'parent_id' => 18, 'name' => 'Content Provider Payout', 'route' => 'admin.cp.payout', 'type' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['module_id' => 4, 'parent_id' => null, 'name' => 'Content Provider', 'route' => 'content_provider', 'type' => 1, 'created_at' => now(), 'updated_at' => now()]
        ];

        DB::table('permissions')->insert($sql);

        $sql2 = [
            'module_id' => 4,
            'parent_id' => null,
            'name' => 'Content Provider',
            'route' => 'content_provider',
            'type' => 1
        ];

        $data_cp = DB::table('permissions')->where($sql2)->first();

        $sql3 = [
            ['module_id' => 4, 'parent_id' => $data_cp->id, 'name' => 'Content Provider List', 'route' => 'admin.cp.list', 'type' => 2, 'created_at' => now(), 'updated_at' => now()]
        ];

        DB::table('permissions')->insert($sql3);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::table('courses', function (Blueprint $table) {
        //     $table->dropColumn(['is_saved']);
        // });
    }
}
