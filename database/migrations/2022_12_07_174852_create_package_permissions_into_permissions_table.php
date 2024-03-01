<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackagePermissionsIntoPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $sql = [
            ['module_id' => 729, 'parent_id' => null, 'name' => 'Package', 'route' => 'package', 'type' => 1, 'created_at' => now(), 'updated_at' => now()]
        ];

        DB::table('permissions')->insert($sql);

        $sql2 = [
            'module_id' => 729,
            'parent_id' => null,
            'name' => 'Package',
            'route' => 'package',
            'type' => 1
        ];

        $data = DB::table('permissions')->where($sql2)->first();

        if($data) {
            $sql3 = [
                ['module_id' => 729, 'parent_id' => $data->id, 'name' => 'Package List', 'route' => 'admin.package.list', 'type' => 2, 'created_at' => now(), 'updated_at' => now()]
            ];

            DB::table('permissions')->insert($sql3);
        }

        $data_2 = DB::table('permissions')->where('route', 'admin.package.list')->first();

        if($data_2) {
            $sql4 = [
                ['module_id' => 729, 'parent_id' => $data_2->id, 'name' => 'Add', 'route' => 'package.store', 'type' => 3],
                ['module_id' => 729, 'parent_id' => $data_2->id, 'name' => 'Edit', 'route' => 'package.edit', 'type' => 3],
                ['module_id' => 729, 'parent_id' => $data_2->id, 'name' => 'Delete', 'route' => 'package.delete', 'type' => 3],
                ['module_id' => 729, 'parent_id' => $data_2->id, 'name' => 'Change Status', 'route' => 'package.change_status', 'type' => 3],
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
            'module_id' => 729,
            'parent_id' => null,
            'name' => 'Package',
            'route' => 'package',
            'type' => 1
        ];

        DB::table('permissions')->where($sql2)->delete();

        DB::table('permissions')->where('route', 'admin.package.list')->delete();
        DB::table('permissions')->where('route', 'package.store')->delete();
        DB::table('permissions')->where('route', 'package.edit')->delete();
        DB::table('permissions')->where('route', 'package.delete')->delete();
        DB::table('permissions')->where('route', 'package.change_status')->delete();
    }
}
