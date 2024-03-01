<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBundleSalesPermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('', function (Blueprint $table) {

        });
            $sql = [
                ['module_id' => 4, 'parent_id' =>'', 'name' => 'bundleSales', 'route' => 'admin.bundleSales', 'type' => 1],
                //last  286
            ];
            DB::table('permissions')->insert($sql);
            $sql = [
                ['module_id' => 4, 'parent_id' =>'757', 'name' => 'bundleSalesList', 'route' => 'admin.bundleSales.list', 'type' => 2],
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
