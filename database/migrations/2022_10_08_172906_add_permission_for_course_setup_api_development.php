<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPermissionForCourseSetupApiDevelopment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $data_2 = DB::table('permissions')->where('route', 'frontend_CMS')->first();

        if($data_2){

            $sql4 = [
                ['module_id' => 16, 'parent_id' => $data_2->id, 'name' => 'Courses Api development', 'route' => 'frontend.coursesApiDevelopment', 'type' => 2],
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
        //
    }
}
