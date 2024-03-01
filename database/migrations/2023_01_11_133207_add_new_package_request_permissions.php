<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewPackageRequestPermissions extends Migration
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
                ['module_id' => 730, 'parent_id' =>'749' , 'name' => 'package request', 'route' => 'package.request', 'type' => 2]
            ];
                //last  286
            DB::table('permissions')->insert($sql);
            $sql = [
                ['module_id' => 730, 'parent_id' =>'754' , 'name' => 'Add', 'route' => 'package.request.add', 'type' => 3]
            ];
                //last  286
            DB::table('permissions')->insert($sql);
            $sql = [
                ['module_id' => 730, 'parent_id' =>'754' , 'name' => 'Edit', 'route' => 'package.request.edit', 'type' => 3]
            ];
                //last  286
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
