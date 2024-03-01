<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Modules\FrontendManage\Entities\HomeContent;

class AddShowEachPromoSectionToHomeContents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('home_contents')->insert([
            'key' => 'show_promo1_section',
            'value' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('home_contents')->insert([
            'key' => 'show_promo2_section',
            'value' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('home_contents')->insert([
            'key' => 'show_promo3_section',
            'value' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

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
        DB::table('home_contents')->where('key', 'show_promo1_section')->delete();
        DB::table('home_contents')->where('key', 'show_promo2_section')->delete();
        DB::table('home_contents')->where('key', 'show_promo3_section')->delete();
    }
}
