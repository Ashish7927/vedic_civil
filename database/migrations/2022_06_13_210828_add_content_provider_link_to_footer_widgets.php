<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddContentProviderLinkToFooterWidgets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Modules\Setting\Model\GeneralSetting::create([
            'key' => 'footer_section_four_title',
            'value' => 'Content Provider (CP)',
        ]);
        \Modules\FrontendManage\Entities\FrontPage::create([
            'name' => 'Content Provider',
            'title' => 'Content Provider',
            'sub_title' => '',
            'details' => '',
            'slug' => '/content-provider',
            'status' => 1,
            'is_static' => 1,
        ]);
        $frontPageSelect = \Modules\FrontendManage\Entities\FrontPage::where('slug', '/content-provider')->first();
        \Modules\FooterSetting\Entities\FooterWidget::create([
            'user_id' => 1,
            'name' => 'CP Log In',
            'slug' => '/content-provider',
            'description' => 'Content Provider',
            'page_id' => $frontPageSelect->id,
            'category_id' => 3,
            'page' => '/content-provider',
            'section' => 4,
            'is_static' => 1
        ]);
        \Modules\FrontendManage\Entities\FrontPage::create([
            'name' => 'Content Provider FAQ',
            'title' => 'Content Provider FAQ',
            'sub_title' => '',
            'details' => '',
            'slug' => 'cp-faq',
            'status' => 1,
            'is_static' => 1,
        ]);
        $frontPageSelectFAQ = \Modules\FrontendManage\Entities\FrontPage::where('slug', 'cp-faq')->first();
        \Modules\FooterSetting\Entities\FooterWidget::create([
            'user_id' => 1,
            'name' => 'CP FAQ',
            'slug' => '/cp-faq',
            'description' => 'CP FAQ',
            'page_id' => 0,
            'category_id' => 3,
            'page' => '/cp-faq',
            'section' => 4,
            'is_static' => 0
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \Modules\Setting\Model\GeneralSetting::where('value','Content Provider (CP)')->delete();
        \Modules\FooterSetting\Entities\FooterWidget::where('slug','/content-provider')->delete();
        \Modules\FooterSetting\Entities\FooterWidget::where('slug','cp-faq')->delete();
        \Modules\FrontendManage\Entities\FrontPage::where('slug','/content-provider')->delete();
        \Modules\FrontendManage\Entities\FrontPage::where('slug','/cp-faq')->delete();
    }
}
