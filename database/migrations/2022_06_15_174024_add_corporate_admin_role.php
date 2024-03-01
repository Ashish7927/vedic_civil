<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Role\Entities\Role;

class AddCorporateAdminRole extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Role::create([
            'name' => 'Corporate Admin',
            'type' => 'System',
            'details' => 'Company'
        ]);

        Schema::table('permissions', function (Blueprint $table) {
            $table->tinyInteger("is_corporate")->default(0)->comment('0 = No, 1 = Yes')->after('type');
        });

        DB::table('permissions')->insert([[
            'module_id' => 12,
            'parent_id' => 12,
            'name' => 'Corporate Admin Role',
            'route' => 'permission.roles.corporateadmin',
            'type' => 2,
            'is_corporate' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        ]);

        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->integer('corporate_id');
            $table->string('name')->nullable();
            $table->string('logo')->nullable();
            $table->string('no_of_employees')->nullable()->comment('1 = 1-100, 2 = 101-500, 3 = 501 - 1000, 4 = More than 1000');
            $table->string('industry')->nullable();
            $table->text('address')->nullable();
            $table->string('postcode')->nullable();
            $table->string('state')->nullable();
            $table->tinyInteger('status')->default(0)->comment('0 = In active, 1 = Active');
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->tinyInteger("is_corporate_user")->default(0)->comment('0 = No, 1 = Yes');
            $table->integer("corporate_id")->nullable();
        });


        // Corporate Admin User Permissions
        $sql = [
            ['module_id' => 4, 'parent_id' => null, 'name' => 'Corporate Admin', 'route' => 'corporate_admin', 'type' => 1, 'is_corporate' => 1, 'created_at' => now(), 'updated_at' => now()]
        ];

        DB::table('permissions')->insert($sql);

        $sql2 = [
            'module_id' => 4,
            'parent_id' => null,
            'name' => 'Corporate Admin',
            'route' => 'corporate_admin',
            'type' => 1,
            'is_corporate' => 1
        ];

        $data = DB::table('permissions')->where($sql2)->first();

        if($data)
        {
            $sql3 = [
                ['module_id' => 4, 'parent_id' => $data->id, 'name' => 'Corporate Admin List', 'route' => 'admin.corporate_admin.list', 'type' => 2, 'is_corporate' => 1, 'created_at' => now(), 'updated_at' => now()]
            ];

            DB::table('permissions')->insert($sql3);
        }

        $data_2 = DB::table('permissions')->where('route', 'admin.corporate_admin.list')->first();

        if($data_2){

            $sql4 = [
                ['module_id' => 4, 'parent_id' => $data_2->id, 'name' => 'Add', 'route' => 'corporate_admin.store', 'type' => 3, 'is_corporate' => 1],
                ['module_id' => 4, 'parent_id' => $data_2->id, 'name' => 'Edit', 'route' => 'corporate_admin.edit', 'type' => 3, 'is_corporate' => 1],
                ['module_id' => 4, 'parent_id' => $data_2->id, 'name' => 'Delete', 'route' => 'corporate_admin.delete', 'type' => 3, 'is_corporate' => 1],
                ['module_id' => 4, 'parent_id' => $data_2->id, 'name' => 'Change Status', 'route' => 'corporate_admin.change_status', 'type' => 3, 'is_corporate' => 1],
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
        Role::where('name', 'Corporate Admin')->delete();
        DB::table('permissions')->wehre('route', 'permission.roles.corporateadmin')->delete();

        Schema::table('permissions', function (Blueprint $table) {
            $table->dropColumn(['is_corporate']);
        });

        Schema::dropIfExists('companies');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['is_corporate_user','corporate_id']);
        });


        $sql2 = [
            'module_id' => 4,
            'parent_id' => null,
            'name' => 'Corporate Admin',
            'route' => 'corporate_admin',
            'type' => 1,
            'is_corporate' => 1
        ];

        DB::table('permissions')->where($sql2)->delete();

        DB::table('permissions')->where('route', 'admin.corporate_admin.list')->delete();
        DB::table('permissions')->where('route', 'corporate_admin.store')->delete();
        DB::table('permissions')->where('route', 'corporate_admin.edit')->delete();
        DB::table('permissions')->where('route', 'corporate_admin.delete')->delete();
        DB::table('permissions')->where('route', 'corporate_admin.change_status')->delete();
    }
}
