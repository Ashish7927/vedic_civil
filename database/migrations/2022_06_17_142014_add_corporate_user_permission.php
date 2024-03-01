<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Role\Entities\Role;

class AddCorporateUserPermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->integer("corporate_id")->nullable();
        });

        $sql = [
            ['module_id' => 4, 'parent_id' => null, 'name' => 'Corporate User', 'route' => 'corporate_user', 'type' => 1, 'is_corporate' => 1, 'created_at' => now(), 'updated_at' => now()]
        ];

        DB::table('permissions')->insert($sql);

        $sql2 = [
            'module_id' => 4,
            'parent_id' => null,
            'name' => 'Corporate User',
            'route' => 'corporate_user',
            'type' => 1,
            'is_corporate' => 1
        ];

        $data = DB::table('permissions')->where($sql2)->first();

        if($data)
        {
            $sql3 = [
                ['module_id' => 4, 'parent_id' => $data->id, 'name' => 'Corporate User List', 'route' => 'admin.corporate_user.list', 'type' => 2, 'is_corporate' => 1, 'created_at' => now(), 'updated_at' => now()]
            ];

            DB::table('permissions')->insert($sql3);
        }

        $data_2 = DB::table('permissions')->where('route', 'admin.corporate_user.list')->first();

        if($data_2){

            $sql4 = [
                ['module_id' => 4, 'parent_id' => $data_2->id, 'name' => 'Add', 'route' => 'corporate_user.store', 'type' => 3, 'is_corporate' => 1],
                ['module_id' => 4, 'parent_id' => $data_2->id, 'name' => 'Edit', 'route' => 'corporate_user.edit', 'type' => 3, 'is_corporate' => 1],
                ['module_id' => 4, 'parent_id' => $data_2->id, 'name' => 'Delete', 'route' => 'corporate_user.delete', 'type' => 3, 'is_corporate' => 1],
                ['module_id' => 4, 'parent_id' => $data_2->id, 'name' => 'Change Status', 'route' => 'corporate_user.change_status', 'type' => 3, 'is_corporate' => 1],
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
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn(['corporate_id']);
        });

        $sql2 = [
            'module_id' => 4,
            'parent_id' => null,
            'name' => 'Corporate User',
            'route' => 'corporate_user',
            'type' => 1,
            'is_corporate' => 1
        ];

        DB::table('permissions')->where($sql2)->delete();

        DB::table('permissions')->where('route', 'admin.corporate_user.list')->delete();
        DB::table('permissions')->where('route', 'corporate_user.store')->delete();
        DB::table('permissions')->where('route', 'corporate_user.edit')->delete();
        DB::table('permissions')->where('route', 'corporate_user.delete')->delete();
        DB::table('permissions')->where('route', 'corporate_user.change_status')->delete();
    }
}
