<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewPermission2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('permissions', function (Blueprint $table) {

        });
            $sql = [
                ['module_id' => 730, 'parent_id' =>'' , 'name' => 'customize packages', 'route' => 'customize_packages', 'type' => 1]
            ];
                //last  286
            DB::table('permissions')->insert($sql);
            $sql = [
                ['module_id' => 730, 'parent_id' => 749, 'name' => 'customize packages List', 'route' => 'customize.packages.list', 'type' => 2],
            ];
            DB::table('permissions')->insert($sql);
            $sql = [
                ['module_id' => 730, 'parent_id' => 750, 'name' => 'Add', 'route' => 'customize.packages.store', 'type' => 3],
                //last  286
            ];
            DB::table('permissions')->insert($sql);
            $sql = [
                ['module_id' => 730, 'parent_id' => 750, 'name' => 'Edit', 'route' => 'customize.packages.edit', 'type' => 3],
                //last  286
            ];
            DB::table('permissions')->insert($sql);
            $sql = [
                 ['module_id' => 730, 'parent_id' => 750, 'name' => 'Delete', 'route' => 'customize.packages.delete', 'type' => 3],
                //last  286
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
        Schema::table('', function (Blueprint $table) {

        });
    }
}
