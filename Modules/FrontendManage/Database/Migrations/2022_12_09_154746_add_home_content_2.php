<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Modules\FrontendManage\Entities\HomeContent;

class AddHomeContent2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /* Corporate Access Page Section */
        DB::table('home_contents')
        ->insert([
            'key' => 'corporate_access_page_title',
            'value' => 'Corporate Access',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('home_contents')
        ->insert([
            'key' => 'corporate_access_page_sub_title',
            'value' => 'One-stop hub for learning',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('home_contents')
        ->insert([
            'key' => 'corporate_access_page_banner',
            'value' => 'frontend/elatihlmstheme/img/banner/ca_bradcam_bg.png',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        $homepage_block_positions = DB::table('homepage_block_positions')->orderBy('order', 'asc')->get();
        $check = DB::table('home_contents')->where(
            'key',
            'homepage_block_positions'
        )->first();
        if ($check) {
            DB::table('home_contents')
            ->where('key', 'homepage_block_positions')
            ->update(['value' => json_encode($homepage_block_positions)]);
        } else {
            DB::table('home_contents')
                ->insert([
                    'key' => 'homepage_block_positions',
                    'value' => json_encode($homepage_block_positions),
                ]);
        }

        $path = Storage::path('homeContent.json');
        $setting = HomeContent::get(['key', 'value'])->pluck('value', 'key')->toJson();
        file_put_contents($path, $setting);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('home_contents')->where('key', 'corporate_access_page_title')->delete();
        DB::table('home_contents')->where('key', 'corporate_access_page_sub_title')->delete();
        DB::table('home_contents')->where('key', 'corporate_access_page_banner')->delete();
    }
}
