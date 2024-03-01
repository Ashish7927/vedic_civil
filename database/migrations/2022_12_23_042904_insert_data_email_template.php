<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\SystemSetting\Entities\EmailTemplate;

class InsertDataEmailTemplate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        EmailTemplate::insert([
            'act' => 'Interest_form',
            'name' => 'Interest Form',
            'subj' => 'Interest Form Notification',
            'email_body' => 'Interest form notification at {{time}}  {{footer}} ',
            'shortcodes' => '{"full_name":"Full Name","email_address":"Email","phone_number":"Phone","company_name":"Company Name","company_registration_no":"Company Registration No","location":"Location","industry":"Industry","no_of_employees":"No of Employees","hrd_corp":"HRD Corp","footer":"Email footer"}',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
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
