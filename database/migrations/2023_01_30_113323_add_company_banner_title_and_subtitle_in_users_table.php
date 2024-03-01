<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\FrontendManage\Entities\HomeContent;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class AddCompanyBannerTitleAndSubtitleInUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('company_banner_title')->nullable();
            $table->string('company_banner_subtitle')->nullable();
        });

        // reset the value of 'content_provider_list' in home_content table
        $cp_list = DB::table('home_contents')->where('key', 'content_provider_list')->first();
        $cp_list_value = json_decode($cp_list->value, true);
        foreach ($cp_list_value as $index => $value) {
            unset($cp_list_value[$index]['cp_page_sub_title']);
            unset($cp_list_value[$index]['cp_page_title']);
        }
        $new_cp_list_value = json_encode($cp_list_value);

        DB::table('home_contents')
            ->where('key', 'content_provider_list')
            ->update(['value' => $new_cp_list_value]);
        

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
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['company_banner_title', 'company_banner_subtitle']);
        });
    }
}
