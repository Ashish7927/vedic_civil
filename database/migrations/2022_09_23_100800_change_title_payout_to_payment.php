<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\RolePermission\Entities\Permission;

class ChangeTitlePayoutToPayment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $search = 'Payout';
        Permission::where('name', 'LIKE', '%' . $search . '%')
        ->update([
            'name' => DB::raw("REPLACE(name,'$search','Payment')")
        ]);

        \Modules\SystemSetting\Entities\EmailTemplate::where('subj', 'LIKE', '%' . $search . '%')
        ->update([
            'subj' => DB::raw("REPLACE(subj,'$search','Payment')")
        ]);

        \Modules\SystemSetting\Entities\EmailTemplate::where('name', 'LIKE', '%' . $search . '%')
        ->update([
            'name' => DB::raw("REPLACE(name,'$search','Payment')")
        ]);

        \Modules\SystemSetting\Entities\EmailTemplate::where('email_body', 'LIKE', '%' . $search . '%')
        ->update([
            'email_body' => DB::raw("REPLACE(email_body,'$search','Payment')")
        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
    }
}
