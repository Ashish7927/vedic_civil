<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToBbbMeetingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bbb_meetings', function (Blueprint $table) {
            $table->integer('status')->after('state')->comment('0 => Pending, 1 => Approved, 2 => Rejected')->default(0);
            $table->text('admin_review')->after('status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bbb_meetings', function (Blueprint $table) {
            $table->dropColumn(['status', 'admin_review']);
        });
    }
}
