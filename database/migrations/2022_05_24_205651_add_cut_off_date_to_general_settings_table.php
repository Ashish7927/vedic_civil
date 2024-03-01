<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Setting\Model\GeneralSetting;

class AddCutOffDateToGeneralSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('general_settings', function (Blueprint $table) {
            $setting = GeneralSetting::where('key', 'cut_off_date')->first();
            if (!$setting) {
                $setting = new GeneralSetting();
                $setting->key = 'cut_off_date';
                $setting->updated_at = now();
                $setting->created_at = now();
                $setting->save();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('general_settings', function (Blueprint $table) {
            GeneralSetting::where('key', 'cut_off_date')->delete();
        });
    }
}
