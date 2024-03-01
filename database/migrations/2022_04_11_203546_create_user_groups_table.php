<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_groups', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('group_id')->nullable();
            $table->timestamps();
        });

        $sql = [
            ['id' => 559, 'module_id' => 559, 'parent_id' => null, 'name' => 'Group', 'route' => 'group', 'type' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 560, 'module_id' => 559, 'parent_id' => 559, 'name' => 'UserGroup', 'route' => 'group.usergroup', 'type' => 2, 'created_at' => now(), 'updated_at' => now()]
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
        Schema::dropIfExists('user_groups');
    }
}
