<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Modules\FrontendManage\Entities\HomeContent;

class AddHomeContents1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        /* hide and update the old section */
        $home_contents1 = DB::table('home_contents')->where('key', 'show_key_feature')->limit(1);
        if ($home_contents1) {
            $home_contents1->update(['value' => 0]);
        }
        $home_contents2 = DB::table('home_contents')->where('key', 'show_category_section')->limit(1);
        if ($home_contents2) {
            $home_contents2->update(['value' => 0]);
        }
        $home_contents3 = DB::table('home_contents')->where('key', 'course_title')->limit(1);
        if ($home_contents3) {
            $home_contents3->update(['value' => 'Top Online Courses']);
        }

        /* Corporate Access Promotion Section */
        DB::table('home_contents')
        ->insert([
            'key' => 'show_corporate_access_promo_section',
            'value' => '1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('home_contents')
        ->insert([
            'key' => 'corporate_access_promo_title',
            'value' => 'Corporate Access',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('home_contents')
        ->insert([
            'key' => 'corporate_access_promo_sub_title',
            'value' => 'A seamless management system for organisations.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        /* Homepage Advertisement Section */
        DB::table('home_contents')
        ->insert([
            'key' => 'show_hp_advertisement_section',
            'value' => '1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('home_contents')
        ->insert([
            'key' => 'hp_advertisement_banner',
            'value' => 'frontend/elatihlmstheme/img/banner/adv_bg.png',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('home_contents')
        ->insert([
            'key' => 'hp_advertisement_title',
            'value' => 'Learn from industry experts,and connect with a global network of experience',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        /* Featured Course Section */
        DB::table('home_contents')
            ->insert([
                'key' => 'course_title_1',
                'value' => 'Featured Courses',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

        DB::table('home_contents')
            ->insert([
                'key' => 'course_sub_title_1',
                'value' => "Malaysia's largest selection of online learning courses. Choose from over 1,000 courses and check out new and exciting content published every month.",
                'created_at' => now(),
                'updated_at' => now(),
            ]);

        $homepage_block_positions = DB::table('homepage_block_positions')->orderBy('order', 'asc')->get();
        $check = DB::table('home_contents')->where('key',
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
        DB::table('home_contents')->where('key', 'show_corporate_access_promo_section')->delete();
        DB::table('home_contents')->where('key', 'show_hp_advertisement_section')->delete();
        DB::table('home_contents')->where('key', 'corporate_access_promo_title')->delete();
        DB::table('home_contents')->where('key', 'hp_advertisement_banner')->delete();
        DB::table('home_contents')->where('key', 'corporate_access_promo_sub_title')->delete();
        DB::table('home_contents')->where('key', 'hp_advertisement_title')->delete();
        DB::table('home_contents')->where('key', 'course_title_1')->delete();
        DB::table('home_contents')->where('key', 'course_sub_title_1')->delete();
    }
}
