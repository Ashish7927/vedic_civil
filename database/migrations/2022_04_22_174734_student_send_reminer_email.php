<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class StudentSendReminerEmail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dateTime('send_reminder_email_time')->nullable();
        });

        \Illuminate\Support\Facades\DB::table('permissions')->where("route", "=", "student.send_mail")->delete();

        \Illuminate\Support\Facades\DB::table('permissions')->insert([[
            'module_id' => 2,
            'parent_id' => 37,
            'name' => 'student Send Reminder Email',
            'route' => 'student.send_mail',
            'type' => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
