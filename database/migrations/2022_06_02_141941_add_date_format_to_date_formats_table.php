<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Setting\Model\DateFormat;

class AddDateFormatToDateFormatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $data = [
            ['j M Y', '17 May 2019']
        ];
        foreach ($data as $dateFormate) {
            $store = new DateFormat();
            $store->format = $dateFormate[0];
            $store->normal_view = $dateFormate[1];
            $store->created_at = now();
            $store->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DateFormat::where('format', 'j M Y')->delete();
    }
}
