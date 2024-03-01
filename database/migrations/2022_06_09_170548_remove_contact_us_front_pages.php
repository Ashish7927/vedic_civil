<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveContactUsFrontPages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $contact = \Modules\FrontendManage\Entities\FrontPage::whereSlug('/contact-us')->first();
        if ($contact) {
            \Modules\FrontendManage\Entities\HeaderMenu::where('link', $contact->slug)->delete();
        }
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
