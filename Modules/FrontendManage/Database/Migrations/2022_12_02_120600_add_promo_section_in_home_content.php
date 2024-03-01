<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Modules\FrontendManage\Entities\HomeContent;

class AddPromoSectionInHomeContent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        DB::table('home_contents')
        ->insert([
            'key' => 'show_promo_section',
            'value' => '1',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        /* promo section 1 */
        DB::table('home_contents')
        ->insert([
            'key' => 'promo_image_1',
            'value' => 'frontend/elatihlmstheme/img/promo/image14.png',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('home_contents')
        ->insert([
            'key' => 'promo_title_1',
            'value' => 'Discover a limitless world of learning',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('home_contents')
        ->insert([
            'key' => 'promo_sub_title_1',
            'value' => 'Review important concepts and explore new topics—the options are endless with e-LATiH.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        /* promo section 2 */
        DB::table('home_contents')
        ->insert([
            'key' => 'promo_image_2',
            'value' => 'frontend/elatihlmstheme/img/promo/image16.png',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('home_contents')
        ->insert([
            'key' => 'promo_title_2',
            'value' => 'Get job-ready for an in-demand Career',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('home_contents')
        ->insert([
            'key' => 'promo_sub_title_2',
            'value' => 'Break into a new field like information technology or data science.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        /* promo section 3 */
        DB::table('home_contents')
        ->insert([
            'key' => 'promo_image_3',
            'value' => 'frontend/elatihlmstheme/img/promo/image15.png',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('home_contents')
        ->insert([
            'key' => 'promo_title_3',
            'value' => 'Elevate Professional and Personal Knowledge',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('home_contents')
        ->insert([
            'key' => 'promo_sub_title_3',
            'value' => 'Discover hot topics and the latest information from your fingertips.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);


        $homepage_block_positions = DB::table('homepage_block_positions')->orderBy('order', 'asc')->get();
        $check = DB::table('home_contents')->where('key', 'homepage_block_positions')->first();
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
        DB::table('home_contents')->where('key', 'show_promo_section')->delete();
        DB::table('home_contents')->where('key', 'promo_image_1')->delete();
        DB::table('home_contents')->where('key', 'promo_title_1')->delete();
        DB::table('home_contents')->where('key', 'promo_sub_title_1')->delete();
        DB::table('home_contents')->where('key', 'promo_image_2')->delete();
        DB::table('home_contents')->where('key', 'promo_title_2')->delete();
        DB::table('home_contents')->where('key', 'promo_sub_title_2')->delete();
        DB::table('home_contents')->where('key', 'promo_image_3')->delete();
        DB::table('home_contents')->where('key', 'promo_title_3')->delete();
        DB::table('home_contents')->where('key', 'promo_sub_title_3')->delete();
    }
}
