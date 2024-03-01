<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewPermissionFrontendCorporateAccessPageContent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $sql = ['module_id' => 16, 'parent_id' => 16, 'name' => 'Corporate Access Page Contennt', 'route' => 'frontend.corporateAccessPageContent', 'type' => 2];
        DB::table('permissions')->insert($sql);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('permissions')->where('route', 'frontend.corporateAccessPageContent')->delete();
    }
}
