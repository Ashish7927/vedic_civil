<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('systemsetting')->group(function () {
    Route::get('/', 'SystemSettingController@index');
    // Route::get('/lang/{id}', 'SystemSettingController@locale');
    Route::get('/setLocale/{lang}', 'SystemSettingController@setLocale');
    Route::get('/getLocale', 'SystemSettingController@getLocale');
    Route::get('/languages', 'SystemSettingController@languages');
    Route::get('/currencies', 'SystemSettingController@currencies');
    Route::get('/get_language', 'SystemSettingController@getLocaleLang');
});

Route::group(['prefix' => 'admin/systemsetting', 'middleware' => ['auth', 'admin']], function () {

    Route::get('/getAllLanguage', 'SystemSettingController@getAllLanguage');
});

Route::group(['prefix' => 'partner', 'middleware' => ['auth', 'admin']], function () {
    /* Partner 6-6-2022 */
    Route::get('/list', 'PartnerSettingController@index')->name('all_partner')->middleware('RoutePermissionCheck:admin.partner.list');
    Route::get('/view-partner/{id}', 'PartnerSettingController@view_partner')->name('view_partner')->middleware('RoutePermissionCheck:admin.partner.list');
    Route::get('/edit-partner/{id}', 'PartnerSettingController@edit_partner')->name('edit_partner')->middleware('RoutePermissionCheck:admin.partner.list');
    Route::get('/data', 'PartnerSettingController@get_all_partner_data')->name('get_all_partner_data')->middleware('RoutePermissionCheck:admin.partner.list');

    Route::get('/not-verified-partners', 'PartnerSettingController@not_verified_partner')->name('not_verified_partner')->middleware('RoutePermissionCheck:admin.partner.list');
    Route::get('/not-verified-partners-data', 'PartnerSettingController@not_verified_partner_data')->name('not_verified_partner_data')->middleware('RoutePermissionCheck:admin.partner.list');
    Route::get('/verify-partner/{id}', 'PartnerSettingController@verify_partner')->name('verify_partner')->middleware('RoutePermissionCheck:admin.partner.list');
    Route::post('/delete-partner', 'PartnerSettingController@delete_partner')->name('delete_partner')->middleware('RoutePermissionCheck:admin.partner.list');
    Route::post('/impersonate', 'PartnerSettingController@impersonate')->name('impersonate')->middleware('RoutePermissionCheck:admin.partner.list');
    Route::get('/allow-using-course-api-partners', 'PartnerSettingController@allow_using_course_api_partners')->name('allow_using_course_api_partners')->middleware('RoutePermissionCheck:admin.partner.list');
    Route::get('/allow-using-course-api-partners-data', 'PartnerSettingController@allow_using_course_api_partners_data')->name('allow_using_course_api_partners_data')->middleware('RoutePermissionCheck:admin.partner.list');
    Route::post('/partner_list_excel_download', 'PartnerSettingController@partner_list_excel_download')->name('partner_list_excel_download')->middleware('RoutePermissionCheck:admin.partner.list');
    Route::post('/send-mail/', 'PartnerSettingController@send_mail_to_partner')->name('send_mail_to_partner')->middleware('RoutePermissionCheck:admin.partner.list');
    /* End : Partner 6-6-2022 */

    Route::post('/change-enabled-package-status', 'PartnerSettingController@change_enabled_package_status')->name('change_enabled_package_status')->middleware('RoutePermissionCheck:admin.partner.list');
});

Route::group(['prefix' => 'admin/systemsetting', 'middleware' => ['auth', 'admin']], function () {
    Route::get('/', 'SystemSettingController@index');

    Route::post('/add_phrase', 'SystemSettingController@addPhrase');
    Route::post('/add_module', 'SystemSettingController@addModule');


    Route::get('/companyMessages', 'CompanyController@toastrMessages');
    Route::get('/blogMessages', 'SystemSettingController@toastrMessages');

    //Language Setting

    //    Route::get('/getAllLanguage', 'SystemSettingController@getAllLanguage');
    Route::get('/languageStatus/{id}', 'SystemSettingController@languageStatus');
    Route::post('/language_add', 'SystemSettingController@language_add');
    Route::get('/language_edit/{id}', 'SystemSettingController@language_edit');
    Route::post('/language_update', 'SystemSettingController@language_update');
    Route::post('/language_search', 'SystemSettingController@language_search');
    Route::get('/language_searchData', 'SystemSettingController@language_searchData');
    Route::post('/language_phase', 'SystemSettingController@language_phase');
    Route::get('/language', 'SystemSettingController@language');
    Route::post('/language_delete/{id}', 'SystemSettingController@language_delete');
    Route::get('/changeLanguage/{id}', 'SystemSettingController@changeLanguage');
    Route::get('/allModules', 'SystemSettingController@allModules');
    Route::post('/moduleCode', 'SystemSettingController@moduleCode');
    Route::post('/saveTranslate/{lang}', 'SystemSettingController@saveTranslate');
    Route::post('/socialCreditional', 'SystemSettingController@socialCreditional');



    //Content Provider Manage
    Route::get('/allCp', 'CpSettingController@index')->name('allCp')->middleware('RoutePermissionCheck:admin.cp.list');
    Route::get('/all/cp-data', 'CpSettingController@getAllCpData')->name('getAllCpData');

    Route::post('/cp/update', 'CpSettingController@update')->name('cp.update');
    Route::post('/change-enabled-package-status', 'CpSettingController@change_enabled_package_status')->name('cp.change_enabled_package_status');
    /*Route::post('/store', 'CpSettingController@store')->name('cp.store');*/

    //Course Reviewer Manage
    Route::get('/allReviewer', 'ReviewerSettingController@index')->name('allReviewer')->middleware('RoutePermissionCheck:admin.course_reviewer.list');
    Route::get('/all/reviewer-data', 'ReviewerSettingController@getAllReviewerData')->name('getAllReviewerData');


    //Email Setting
    Route::get('/editEmailSetting', 'SystemSettingController@editEmailSetting');
    Route::post('/updateEmailSetting', 'SystemSettingController@updateEmailSetting')->name('updateEmailSetting');
    Route::post('/sendTestMail', 'SystemSettingController@sendTestMail')->name('sendTestMail');
    Route::get('/getEmailTemp', 'SystemSettingController@getEmailTemp');
    Route::get('/editEmailTemp/{id}', 'SystemSettingController@editEmailTemp');
    Route::get('/viewEmailTemp/{id}', 'SystemSettingController@viewEmailTemp');
    Route::post('/updateEmailTemp', 'SystemSettingController@updateEmailTemp')->name('updateEmailTemp')->middleware('RoutePermissionCheck:updateEmailTemp');
    Route::post('/footerTemplateUpdate', 'SystemSettingController@footerTemplateUpdate')->name('footerTemplateUpdate')->middleware('RoutePermissionCheck:footerTemplateUpdate');

    //Web Setting
    Route::post('/websiteSetting', 'SystemSettingController@websiteSetting');
    Route::post('/seoSetting', 'SystemSettingController@seoSetting');
    Route::post('/recapchaSetting', 'SystemSettingController@recapchaSetting');
    Route::post('/homeVarriant/{id}', 'SystemSettingController@homeVarriant');
    Route::post('/systemSetting', 'SystemSettingController@systemSetting');
    Route::get('/websiteSetting_view', 'SystemSettingController@websiteSetting_view');
    Route::get('/alltimezones', 'SystemSettingController@alltimezones');

    //Currency Setting
    Route::get('/allCurrency', 'SystemSettingController@allCurrency');
    Route::get('/currencyStatus/{id}', 'SystemSettingController@currencyStatus');
    Route::get('/currency_edit/{id}', 'SystemSettingController@currency_edit');
    Route::post('/currency_update', 'SystemSettingController@currency_update');
    Route::post('/currency_add', 'SystemSettingController@currency_add');



    // Company Manage
    Route::get('/allCompany', 'CompanyController@index');
    Route::post('/storeCompany', 'CompanyController@store');
    Route::get('/editCompany/{id}', 'CompanyController@edit');
    Route::post('/updateCompany', 'CompanyController@update');
    Route::get('/destroyCompany/{id}', 'CompanyController@destroy');
    Route::get('/companyStatus/{id}', 'CompanyController@status');
    Route::get('/searchCompany', 'CompanyController@search');


    Route::get('api', 'SystemSettingController@allApi')->name('api.setting');
    Route::post('save/api', 'SystemSettingController@saveApi')->name('save.api.setting');
});



Route::group(['prefix' => 'websitesetting'], function () {
    Route::get('/blog_details/{id}', 'SystemSettingController@blog_detail');
    Route::get('/nextBlog/{id}', 'SystemSettingController@nextBlog');
    Route::get('/previousBlog/{id}', 'SystemSettingController@previousBlog');
    Route::get('/viewBlog/{id}', 'SystemSettingController@viewBlog');

});
