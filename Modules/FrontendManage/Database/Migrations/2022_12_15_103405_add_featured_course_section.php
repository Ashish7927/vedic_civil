<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Modules\FrontendManage\Entities\HomeContent;

class AddFeaturedCourseSection extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //added in home cantent table
        DB::table('home_contents')
            ->insert([
                'key' => 'show_featured_course_section',
                'value' => '1',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('home_contents')->where('key', 'show_featured_course_section')->delete();
    }
}
