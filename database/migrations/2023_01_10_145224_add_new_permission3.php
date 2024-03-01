<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewPermission3 extends Migration
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
         if (!\Modules\RolePermission\Entities\Permission::find(754)) {
            $sql = [
                ['id' => 754, 'module_id' => 730, 'parent_id' =>'749' , 'name' => 'package request', 'route' => 'package.request', 'type' => 2]
            ];
                //last  286
            DB::table('permissions')->insert($sql);
        }
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
