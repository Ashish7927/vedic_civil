<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBbbMeetingUsersTable extends Migration
{

    public function up()
    {
        Schema::create('bbb_meeting_users', function (Blueprint $table) {
            $table->id();
            $table->integer('meeting_id')->default(1);
            $table->integer('user_id')->default(1);
            $table->integer('moderator')->default(0)->comment('1= moderator , 0=attendee');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bbb_meeting_users');
    }
}
