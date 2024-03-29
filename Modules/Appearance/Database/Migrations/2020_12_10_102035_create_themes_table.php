<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateThemesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('themes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('name');
            $table->string('title');
            $table->string('image');
            $table->string('version');
            $table->string('folder_path')->default('elatihlmstheme');
            $table->string('live_link')->default('#');
            $table->text('description');
            $table->boolean('is_active');
            $table->boolean('status');
            $table->text('tags')->nullable();
            $table->timestamps();
        });


        DB::table('themes')->insert(
            [
                'name' => 'elatihlmstheme',
                'title' => 'e-Latih LMS Theme',
                'version' => '1.00',
                'live_link' => '#',
                'tags' => 'clean',
                'folder_path' => 'elatihlmstheme',
                'image' => 'frontend/elatihlmstheme/img/screenshort.jpg',
                'description' => 'e-Latih LMS Default Theme',
                'is_active' => 1,
                'status' => 1
            ]
        );

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('themes');
    }
}
