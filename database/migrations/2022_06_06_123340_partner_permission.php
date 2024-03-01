<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PartnerPermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $sql = [
            ['module_id' => 4, 'parent_id' => null, 'name' => 'Partner', 'route' => 'partner', 'type' => 1, 'created_at' => now(), 'updated_at' => now()]
        ];

        DB::table('permissions')->insert($sql);

        $sql2 = [
            'module_id' => 4,
            'parent_id' => null,
            'name' => 'Partner',
            'route' => 'partner',
            'type' => 1
        ];

        $data = DB::table('permissions')->where($sql2)->first();

        if($data)
        {
            $sql3 = [
                ['module_id' => 4, 'parent_id' => $data->id, 'name' => 'Partner List', 'route' => 'admin.partner.list', 'type' => 2, 'created_at' => now(), 'updated_at' => now()]
            ];

            DB::table('permissions')->insert($sql3);
        }

        $data_2 = DB::table('permissions')->where('route', 'admin.partner.list')->first();

        if($data_2){

            $sql4 = [
                ['module_id' => 4, 'parent_id' => $data_2->id, 'name' => 'Add', 'route' => 'partner.store', 'type' => 3],
                ['module_id' => 4, 'parent_id' => $data_2->id, 'name' => 'Edit', 'route' => 'partner.edit', 'type' => 3],
                ['module_id' => 4, 'parent_id' => $data_2->id, 'name' => 'Delete', 'route' => 'partner.delete', 'type' => 3],
                ['module_id' => 4, 'parent_id' => $data_2->id, 'name' => 'Change Status', 'route' => 'partner.change_status', 'type' => 3],
            ];
            DB::table('permissions')->insert($sql4);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $sql2 = [
            'module_id' => 4,
            'parent_id' => null,
            'name' => 'Partner',
            'route' => 'partner',
            'type' => 1
        ];

        DB::table('permissions')->where($sql2)->delete();

        DB::table('permissions')->where('route', 'admin.partner.list')->delete();
        DB::table('permissions')->where('route', 'partner.store')->delete();
        DB::table('permissions')->where('route', 'partner.edit')->delete();
        DB::table('permissions')->where('route', 'partner.delete')->delete();
        DB::table('permissions')->where('route', 'partner.change_status')->delete();
    }
}
