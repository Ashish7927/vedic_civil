<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class HrdcPayoutsPermissionChange extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $sql1 = [
            'module_id' => 4,
            'parent_id' => 4,
            'name' => 'Hrdc Payout List',
            'route' => 'admin.hrdc.payout',
            'type' => 2
        ];

        DB::table('permissions')->where($sql1)->update(['parent_id' => 18]);

        $sql2 = [
            'module_id' => 4,
            'parent_id' => 4,
            'name' => 'Payout List',
            'route' => 'admin.instructor.payout',
            'type' => 2
        ];

        DB::table('permissions')->where($sql2)->update(['parent_id' => 18]);

        $sql = [
            ['module_id' => 4, 'parent_id' => 18, 'name' => 'Content Provider Revenue', 'route' => 'admin.reveune_list_cp', 'type' => 2, 'created_at' => now(), 'updated_at' => now()]
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
        //
    }
}
