<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGroupModuleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $totalCount = \Illuminate\Support\Facades\DB::table('modules')->count();
        $newModule = new \Modules\ModuleManager\Entities\Module();
        $newModule->name = 'Group';
        $newModule->details = 'Group module for e-Latih LMS';
        $newModule->status = 0;
        $newModule->order = $totalCount;
        $newModule->save();

        $totalCount = \Illuminate\Support\Facades\DB::table('modules')->count();
        $newModule = new \Modules\ModuleManager\Entities\Module();
        $newModule->name = 'Catalogue';
        $newModule->details = 'Catalogue module for e-Latih LMS';
        $newModule->status = 0;
        $newModule->order = $totalCount;
        $newModule->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}