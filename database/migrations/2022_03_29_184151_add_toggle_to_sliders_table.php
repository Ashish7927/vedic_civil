<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddToggleToSlidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sliders', function (Blueprint $table) {
            $table->tinyInteger('image_as_link')->default(0)->comment("0 = No, 1 = Yes")->after('status');
            $table->string('link')->nullable()->after('image_as_link');
            $table->tinyInteger('open_in_new')->default(0)->comment("0 = No, 1 = Yes")->after('link');
            $table->tinyInteger('show_title')->default(0)->comment("0 = No, 1 = Yes")->after('open_in_new');
            $table->tinyInteger('show_subtitle')->default(0)->comment("0 = No, 1 = Yes")->after('show_title');
            $table->string('order')->nullable()->after('show_subtitle');
            $table->tinyInteger('show_searchbar')->default(0)->comment("0 = No, 1 = Yes")->after('order');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sliders', function (Blueprint $table) {
            $table->dropColumn(['image_as_link','link','open_in_new','show_title','show_subtitle','order','show_searchbar']);
        });
    }
}
