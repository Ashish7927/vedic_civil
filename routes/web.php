<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;



Route::get('/partner/register', 'UserController@partner_register')->name('partner_register');

/* New : 7-3-2022 */
Route::get('/interval-auth-check', 'Frontend\WebsiteController@interval_auth_check')->name('interval_auth_check');
/* End : 7-3-2022 */

Route::get('get-user-data-ajax/{role_id}','UserController@user_data_with_ajax_select2')->name('user_data_with_ajax_select2');

/* New : Vimoe upload in folder demo 3-3-2022 */
Route::get('/vimeo_upload_page_data', 'UploadFileController@vimeo_upload_page')->name('vimeo_upload_page');
Route::post('/vimeo_upload', 'UploadFileController@vimeo_upload')->name('vimeo_upload');
/* End : Vimoe upload in folder demo 3-3-2022 */

/* New : 10-3-2022 */
Route::get('/ipay_page', 'IpayController@ipay_page')->name('ipay_page');
Route::any('/ipay_response', 'IpayController@ipay_response')->name('ipay_response');
Route::post('/ipay_backend', 'IpayController@ipay_backend')->name('ipay_backend');
/* End : 10-3-2022 */

/* New : 15-3-2022 */
Route::get('/instructor/register', 'UserController@instructor_register')->name('instructor_register');
/* New : 15-3-2022 */

// Route::group(['middleware' => ['admin']], function () {
    Route::get('/partner-login', '\App\Http\Controllers\Auth\LoginController@partner_login')->name('partner_login');
    Route::post('plogin', '\App\Http\Controllers\Auth\LoginController@plogin')->name('plogin');
    // Route::post('/partner-login/find', 'UserController@partner_find')->name('partner_find');

    Route::get('/content-provider', 'UserController@cp_register')->name('cp_register');
    Route::post('/content-provider/ldap-data', 'UserController@cp_get_ldap_data')->name('cp_get_ldap_data');
    Route::post('/content-provider/find', 'UserController@cp_find')->name('cp_find');
// });

Auth::routes(['verify' => true]);
Route::get('update-email', '\App\Http\Controllers\Auth\LoginController@updateEmail')->name('updateEmail');
Route::post('update-email-save', '\App\Http\Controllers\Auth\LoginController@updateEmailSave')->name('updateEmailSave');

//Route::get('update_cource_enrolled','Frontend\WebsiteController@updateenrolledcource');
Route::get('send-password-reset-link', 'Auth\ForgotPasswordController@SendPasswordResetLink')->name('SendPasswordResetLink');
Route::get('reset-password', 'Auth\ForgotPasswordController@ResetPassword')->name('ResetPassword');
Route::get('reset-password-email-cron', 'Auth\ForgotPasswordController@reset_bulk_send_cron')->name('reset-password-email-cron');
Route::get('register', 'Auth\RegisterController@RegisterForm')->name('register');
Route::post('registerone', 'Auth\RegisterController@RegisterFormStepOne')->name('registerone');
Route::post('register_partner', 'Auth\RegisterController@register_partner')->name('register_partner');
Route::get('register-personal', 'Auth\RegisterController@RegisterFormSecond')->name('register-personal');
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
Route::post('/resend', '\App\Http\Controllers\Auth\VerificationController@resend_mail')->name('verification_mail_resend');
Route::get('auto-login/{key}', '\App\Http\Controllers\Auth\LoginController@autologin')->name('auto.login');

Route::group(['namespace' => 'Admin', 'prefix' => 'resetpassword', 'middleware' => ['auth', 'admin']], function () {
Route::get('bulkresetpassword', 'ResetpasswordController@index')->name('bulkresetpassword');
Route::get('getalllistresetpassword', 'ResetpasswordController@getalllistresetpassword')->name('bulkresetpassword.getalllistresetpassword');
});
Route::get('/clear-cache', function() {
 Artisan::call('route:clear');
 Artisan::call('config:clear');
 Artisan::call('view:clear');
 $exitCode = Artisan::call('cache:clear');
 return 'Application cache cleared';
 });

Route::group(['namespace' => 'Frontend'], function () {

    Route::get('get-state-data','WebsiteController@state_data_with_ajax')->name('state_data_with_ajax');
    Route::get('get-cp-data','WebsiteController@cp_data_with_ajax')->name('cp_data_with_ajax');
    // Route::get('/', 'FrontendHomeController@index')->name('frontendHomePage')->middleware('checkSmeUser');


    Route::get('/get-courses-by-category/{category_id}', 'EdumeFrontendThemeController@getCourseByCategory')->name('getCourseByCategory');

    Route::get('/offline', 'WebsiteController@offline')->name('offline');

//    Route::get('/footer/page/{slug}', 'WebsiteController@page')->name('dynamic.page');
    Route::get('/about-us', 'WebsiteController@aboutData')->name('about');
    Route::get('/contact-us', 'WebsiteController@contact')->name('contact');
    Route::post('/contact-submit', 'WebsiteController@contactMsgSubmit')->name('contactMsgSubmit');
    Route::get('privacy', 'WebsiteController@privacy')->name('privacy');
    Route::get('calendar-view','WebsiteController@calendarView')->name('calendar-view');

    Route::get('instructors', 'InstructorController@instructors')->name('instructors');
    Route::get('become-instructor', 'InstructorController@becomeInstructor')->name('becomeInstructor');
    Route::get('instructorDetails/{id}/{name}', 'InstructorController@instructorDetails')->name('instructorDetails');

    Route::get('cplanding/{id}', 'CplandingController@cplanding')->name('cplanding');
    Route::get('interest-form', 'InterestFormController@interestform')->name('interestform');
    Route::post('saveInterestForm', 'InterestFormController@saveInterestForm')->name('saveInterestForm');

    Route::get('courses', 'CourseController@courses')->name('courses');
    Route::get('courses-new', 'CourseController@courses_new')->name('courses_new');
    Route::get('get-course-list', 'CourseController@getCourseList')->name('get_course_list');
    // Route::get('getSmeCourses', 'CourseController@getSmeCourses')->name('getSmeCourse');
    Route::get('offer', 'CourseController@offer')->name('offer');
    Route::get('courses-details/{slug}', 'CourseController@courseDetails')->name('courseDetailsView');

    // Route::get('sme-courses-page', 'CourseController@smeCoursesPage')->name('smeCoursesPage')->middleware('checkSmeUserDetails');

    Route::get('free-course', 'CourseController@freeCourses')->name('freeCourses');

    Route::get('classes', 'ClassController@classes')->name('classes');
    Route::get('class-details/{slug}', 'ClassController@classDetails')->name('classDetails');
    Route::get('class-start/{slug}/{host}/{meeting_id}', 'ClassController@classStart')->name('classStart');

    Route::get('quizzes', 'QuizController@quizzes')->name('quizzes');
    Route::get('quiz-details/{slug}', 'QuizController@quizDetails')->name('quizDetailsView');
    Route::get('quizStart/{id}/{quiz_id}/{slug}', 'QuizController@quizStart')->name('quizStart');
    Route::post('quizSubmit', 'QuizController@quizSubmit')->name('quizSubmit');
    Route::post('quizTestStart', 'QuizController@quizTestStart')->name('quizTestStart')->middleware('auth');
    Route::post('singleQuizSubmit', 'QuizController@singleQuizSubmit')->name('singleQuizSubmit')->middleware('auth');
    Route::get('quizResult/{id}', 'QuizController@quizResult')->name('getQuizResult');
    Route::get('quizResultPreview/{id}', 'QuizController@quizResultPreview')->name('quizResultPreview');

    Route::get('search', 'WebsiteController@search')->name('search');
    Route::get('category/{id}/{name}', 'WebsiteController@categoryCourse')->name('categoryCourse');
    Route::get('sub_category/{id}/{slug}', 'WebsiteController@subCategoryCourse')->name('subCategory.course');
    Route::get('category/', 'WebsiteController@category')->name('category');

    Route::get('/certificate-verification', 'WebsiteController@searchCertificate')->name('searchCertificate');
    Route::post('/certificate-verification', 'WebsiteController@showCertificate')->name('showCertificate');
    Route::get('/verify-certificate/{number}', 'WebsiteController@certificateCheck')->name('certificateCheck');
    Route::get('/download-certificate/{number}', 'WebsiteController@certificateDownload')->name('certificateDownload');

    Route::get('blogs', 'BlogController@allBlog')->name('blogs');
    Route::get('blog-details/{slug}', 'BlogController@blogDetails')->name('blogDetails');
    Route::get('load-blog-data', 'BlogController@loadMoreData')->name('load-blog-data');
    Route::get('/enrolfree/{id}','WebsiteController@enrolfree')->name('enrolfree');
    Route::get('/addToCart/{id}', 'WebsiteController@addToCart')->name('addToCart');
    Route::get('/buyNow/{id}', 'WebsiteController@buyNow')->name('buyNow');
    Route::post('enrollOrCart/{id}', 'WebsiteController@enrollOrCart')->name('enrollOrCart');
    Route::get('my-cart', 'WebsiteController@myCart')->name('myCart');
    Route::get('ajaxCounterCity', 'WebsiteController@ajaxCounterCity')->name('ajaxCounterCity');
    Route::get('/home/removeItem/{id}', 'WebsiteController@removeItem')->name('removeItem');
    Route::get('/home/removeItemAjax/{id}', 'WebsiteController@removeItemAjax')->name('removeItemAjax');
    Route::post('/submit_ans', 'WebsiteController@submitAns')->name('submitAns');

    Route::get('referral/{code}', 'ReferalController@referralCode')->name('referralCode');
    Route::get('referral', 'ReferalController@referral')->name('referral');

    Route::get('pages/{slug}', 'WebsiteController@frontPage')->name('frontPage');
    Route::get('cp-terms-and-condition', 'WebsiteController@cpTermsAndCondition')->name('cpTermsAndCondition');
    Route::post('subscribe', 'WebsiteController@subscribe')->name('subscribe');
    Route::get('getItemList', 'WebsiteController@getItemList')->name('getItemList');

    //subscription module
    Route::get('/course/subscription', 'WebsiteController@subscription')->name('courseSubscription');
    Route::get('/course/subscription/{plan_id}', 'WebsiteController@subscriptionCourseList')->name('subscriptionCourseList');
    Route::get('/course-subscription/checkout', 'WebsiteController@subscriptionCheckout')->name('courseSubscriptionCheckout');
    Route::get('/subscription-courses', 'WebsiteController@subscriptionCourses')->name('subscriptionCourses');
    Route::get('/continue-course/{slug}', 'WebsiteController@continueCourse')->name('continueCourse');

    //org subscription module
    Route::get('/org-subscription-courses', 'WebsiteController@orgSubscriptionCourses')->name('orgSubscriptionCourses');
    Route::get('/org-subscription-plan-list/{id}', 'WebsiteController@orgSubscriptionPlanList')->name('orgSubscriptionPlanList');


    Route::post('comment', 'CommentController@saveComment')->name('saveComment')->middleware('auth');
    Route::post('comment-replay', 'CommentController@submitCommnetReply')->name('submitCommnetReply')->middleware('auth');
    Route::post('comment-delete/{id}', 'CommentController@deleteComment')->name('deleteComment')->middleware('auth');
    Route::post('review-delete/{id}', 'CommentController@deleteReview')->name('deleteReview')->middleware('auth');
    Route::post('comment-replay-delete/{id}', 'CommentController@deleteCommnetReply')->name('deleteCommentReply')->middleware('auth');

    Route::get('get-cp-data-which-not-added', 'WebsiteController@cp_which_not_added_with_ajax')->name('cp_which_not_added_with_ajax');
    Route::get('get-coporate-data-which-not-added', 'WebsiteController@corporate_which_not_added_with_ajax')->name('corporate_which_not_added_with_ajax');

    Route::get('corporate-access', 'CorporateAccessController@corporate_access')->name('corporate_access_page');

    // frontend-package details page
    Route::get('package-details/{slug}', 'PackageController@packageDetails')->name('packageDetailsView');
    Route::get('package-bookmarks-save/{id}', 'PackageController@packageBookmarkSave')->name('packageBookmarkSave');
    Route::get('/continue-package/{slug}', 'PackageController@continuePackage')->name('continuePackage');
    Route::get('get-packages-data-which-not-added', 'WebsiteController@packages_which_not_added_with_ajax')->name('packages_which_not_added_with_ajax');
});

Route::group(['namespace' => 'Frontend', 'middleware' => ['student']], function () {
    Route::get('student-dashboard', 'StudentController@myDashboard')->name('studentDashboard');
    Route::get('my-courses', 'StudentController@myCourses')->name('myCourses');
    Route::post('learner-activation-course', 'StudentController@learnerActivationCourse')->name('learnerActivationCourse');
    Route::get('my-classes', 'StudentController@myCourses')->name('myClasses');
    Route::get('my-quizzes', 'StudentController@myCourses')->name('myQuizzes');
    Route::get('my-certificate', 'StudentController@myCertificate')->name('myCertificate');
    /*Courses History & Certificate Routes Start*/
    Route::get('my-history','StudentController@myHistory')->name('myHistory');
    Route::get('/history-courses-certificate/{id}', 'WebsiteController@historycertificateDownload')->name('historycertificateDownload');
    /*Courses History & Certificate Routes End*/

    Route::get('my-assignment', 'StudentController@myAssignment')->name('myAssignment');
    Route::get('my-assignment/{id}', 'StudentController@myAssignmentDetails')->name('myAssignment_details');
    Route::get('bookmarks', 'StudentController@myWishlists')->name('myWishlists');
    Route::get('my-purchases', 'StudentController@myPurchases')->name('myPurchases');
    Route::get('my-bundle', 'StudentController@myBundle')->name('myBundle');
    Route::get('topic-report/{id}', 'StudentController@topicReport')->name('topicReport');
    Route::get('my-profile', 'StudentController@myProfile')->name('myProfile');
    Route::get('my-profile-download', 'StudentController@download')->name('myProfile.download');
    Route::any('ajax-update-profile-image', 'StudentController@ajaxUploadProfilePic')->name('ajaxUploadProfilePic');
    Route::post('my-profile-update', 'StudentController@myProfileUpdate')->name('myProfileUpdate');
    Route::get('my-account', 'StudentController@myAccount')->name('myAccount');
    Route::post('my-password-update', 'StudentController@MyUpdatePassword')->name('MyUpdatePassword');
    Route::post('my-email-update', 'StudentController@MyEmailUpdate')->name('MyEmailUpdate');

    Route::get('deposit', 'StudentController@deposit')->name('deposit');
    Route::post('deposit', 'StudentController@deposit')->name('depositSelectOption');
    Route::get('logged-in/devices', 'StudentController@loggedInDevices')->name('logged.in.devices');
    Route::post('logged-out/device', 'StudentController@logOutDevice')->name('log.out.device');
    Route::get('invoice/{id}', 'StudentController@Invoice')->name('invoice');
    Route::get('subscription-invoice/{id}', 'StudentController@subInvoice')->name('subInvoice');
    Route::get('StudentApplyCoupon', 'StudentController@StudentApplyCoupon')->name('StudentApplyCoupon');
    Route::get('checkout', 'StudentController@CheckOut')->name('CheckOut');
    Route::get('remove-profile-pic', 'StudentController@removeProfilePic')->name('removeProfilePic');
    Route::get('course-certificate/{id}/{slug}', 'StudentController@getCertificate')->name('getCertificate');
    Route::post('/submitReview', 'StudentController@submitReview')->name('submitReview');

    Route::get('my-study-materials', 'StudyMaterialController@myHomework')->name('myHomework');
    Route::get('my-study-materials/{id}', 'StudyMaterialController@myHomeworkDetails')->name('myHomework_details');


});
Route::group(['middleware' => ['student']], function () {
    Route::get('my-notification-setup', 'NotificationController@myNotificationSetup')->name('myNotificationSetup');
    Route::get('my-notifications', 'NotificationController@myNotification')->name('myNotification');
});


//in this controller we can use for place order
Route::group(['prefix' => 'order', 'middleware' => ['auth']], function () {

    Route::post('submit', 'PaymentController@makePlaceOrder')->name('makePlaceOrder');
    Route::get('/payment', 'PaymentController@payment')->name('orderPayment');
    Route::get('/receipt/{id}/{type}', 'PaymentController@receipt')->name('orderReceipt');
    Route::post('/paymentSubmit', 'PaymentController@paymentSubmit')->name('paymentSubmit');
    //paypal url
    Route::get('paypal/success', 'PaymentController@paypalSuccess')->name('paypalSuccess');
    Route::get('paypal/failed', 'PaymentController@paypalFailed')->name('paypalFailed');
});
//deposit
Route::group(['prefix' => 'deposit', 'middleware' => ['auth']], function () {

    Route::post('submit', 'DepositController@depositSubmit')->name('depositSubmit');
    Route::get('paypalDepositSuccess', 'DepositController@paypalDepositSuccess')->name('paypalDepositSuccess');
    Route::get('paypalDepositFailed', 'DepositController@paypalDepositFailed')->name('paypalDepositFailed');

});

Route::group(['prefix' => 'subscription', 'middleware' => ['auth']], function () {
    Route::post('payment', 'SubscriptionPaymentController@payment')->name('subscriptionPayment');
    Route::post('submit', 'SubscriptionPaymentController@subscriptionSubmit')->name('subscriptionSubmit');
    Route::get('paypalSubscriptionSuccess', 'SubscriptionPaymentController@paypalSubscriptionSuccess')->name('paypalSubscriptionSuccess');
    Route::get('paypalSubscriptionFailed', 'SubscriptionPaymentController@paypalSubscriptionFailed')->name('paypalSubscriptionFailed');

});


Route::group(['middleware' => ['auth']], function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('dashboard', 'HomeController@dashboard')->name('dashboard')->middleware('RoutePermissionCheck:dashboard');
    Route::get('/', 'HomeController@dashboard')->name('frontendHomePage');
    /* New - 23-3-2022 */
    Route::post('enroll-month-change', 'HomeController@enroll_month_change')->name('enroll_month_change')->middleware('RoutePermissionCheck:dashboard');
    Route::post('reg-month-change', 'HomeController@reg_month_change')->name('reg_month_change')->middleware('RoutePermissionCheck:dashboard');
    /* End : New - 23-3-2022 */
    Route::get('getDashboardData', 'HomeController@getDashboardData')->name('getDashboardData')->middleware('RoutePermissionCheck:dashboard');
    Route::get('get_enroll_chart_data', 'HomeController@get_enroll_chart_data')->name('get_enroll_chart_data')->middleware('RoutePermissionCheck:dashboard');
    Route::get('get_monthly_revenue_data', 'HomeController@get_monthly_revenue_data')->name('get_monthly_revenue_data')->middleware('RoutePermissionCheck:dashboard');
    Route::get('get_payment_stats_data', 'HomeController@get_payment_stats_data')->name('get_payment_stats_data')->middleware('RoutePermissionCheck:dashboard');
    Route::get('get_status_overview_data', 'HomeController@get_status_overview_data')->name('get_status_overview_data')->middleware('RoutePermissionCheck:dashboard');
    Route::get('get_reg_overview_chart_data', 'HomeController@get_reg_overview_chart_data')->name('get_reg_overview_chart_data')->middleware('RoutePermissionCheck:dashboard');
    Route::get('userLoginChartByDays', 'HomeController@userLoginChartByDays')->name('userLoginChartByDays');
    Route::get('userLoginChartByTime', 'HomeController@userLoginChartByTime')->name('userLoginChartByTime');
    Route::get('/validateGenerate', 'HomeController@validateGenerate')->name('validateGenerate');
    Route::post('/validateGenerate', 'HomeController@validateGenerateSubmit')->name('validateGenerateSubmit');
    Route::post('lesson-complete', 'Frontend\WebsiteController@lessonComplete')->name('lesson.complete');
    Route::any('lesson-complete-ajax', 'Frontend\WebsiteController@lessonCompleteAjax')->name('lesson.complete.ajax');

    Route::get('ajaxNotificationMakeRead', 'NotificationController@ajaxNotificationMakeRead')->name('ajaxNotificationMakeRead');
    Route::get('NotificationMakeAllRead', 'NotificationController@NotificationMakeAllRead')->name('NotificationMakeAllRead');

});
    Route::get('fullscreen-view/{course_id}/{lesson_id}', 'Frontend\WebsiteController@fullScreenView')->name('fullScreenView');


//Admin Routes Here
Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth', 'admin']], function () {

    /* 12-4-2022 */
    Route::get('/group-list', 'GroupController@index')->name('grouplist')->middleware('RoutePermissionCheck:group');
    Route::get('/group-list-data', 'GroupController@group_list_data')->name('getGroupData')->middleware('RoutePermissionCheck:group');
    Route::get('/group-show/{id}', 'GroupController@show')->name('group_show')->middleware('RoutePermissionCheck:group');
    Route::post('group-list-store', 'GroupController@store')->name('group_store')->middleware('RoutePermissionCheck:group');
    Route::post('group-list-update/{id}', 'GroupController@update')->name('group_update')->middleware('RoutePermissionCheck:group');
    Route::get('/group-delete/{id}', 'GroupController@destroy')->name('group_delete')->middleware('RoutePermissionCheck:group');

    Route::get('/user-group-list', 'UserGroupController@index')->name('usergrouplist')->middleware('RoutePermissionCheck:group.usergroup');
    Route::get('/user-group-list-data', 'UserGroupController@user_group_list_data')->name('getUserGroupData')->middleware('RoutePermissionCheck:group.usergroup');
    Route::get('/user-data-ajax', 'UserGroupController@get_user_data_using_ajax')->name('user_data')->middleware('RoutePermissionCheck:group.usergroup');
    Route::get('/group-data-ajax', 'UserGroupController@get_group_data_using_ajax')->name('group_data')->middleware('RoutePermissionCheck:group.usergroup');
    Route::get('/user-group-show/{id}', 'UserGroupController@show')->name('user_group_show')->middleware('RoutePermissionCheck:group.usergroup');
    Route::post('user-group-list-store', 'UserGroupController@store')->name('user_group_store')->middleware('RoutePermissionCheck:group.usergroup');
    Route::post('user-group-list-update/{id}', 'UserGroupController@update')->name('user_group_update')->middleware('RoutePermissionCheck:group.usergroup');
    Route::get('/user-group-delete/{id}', 'UserGroupController@destroy')->name('user_group_delete')->middleware('RoutePermissionCheck:group.usergroup');
    /* End : 2-4-2022 */

    Route::post('/get-user-data/{id}', 'AdminController@getUserDate')->name('getUserDate');


    Route::get('/reveune-list', 'AdminController@reveuneList')->name('reveuneList')->middleware('RoutePermissionCheck:admin.reveuneList');
    Route::get('/audit-trail-learner-profile', 'AdminController@auditTrailLearnerProfile')
        ->name('auditTrailLearnerProfile')
        ->middleware('RoutePermissionCheck:admin.auditTrailLearnerProfile');
     // audit trail for packages
    Route::get('/audit-trail-custom-package', 'AdminController@auditTrailCustomPackage')
        ->name('auditTrailCustomPackage');
    Route::get('/audit-trail-custom-package-data', 'AdminController@auditTrailCustomPackageData')
        ->name('auditTrailCustomPackageData');
    Route::get('/get-compare-audit-trail-custom-package-data/{id}', 'AdminController@getCompareAuditTrailCustomPackageData')
        ->name('getCompareAuditTrailCustomPackageData');
//end audit trail package
    Route::get('/audit-trail-learner-profile-data', 'AdminController@auditTrailLearnerProfileData')
        ->name('auditTrailLearnerProfileData')
        ->middleware('RoutePermissionCheck:admin.auditTrailLearnerProfileData');
    Route::get('/get-compare-audit-trail-learner-profile-data/{id}', 'AdminController@getCompareAuditTrailLearnerProfileData')
        ->name('getCompareAuditTrailLearnerProfileData')
        ->middleware('RoutePermissionCheck:admin.getCompareAuditTrailLearnerProfileData');


     // new add route
        Route::get('/bundle-sales', 'AdminController@bundleSales')
        ->name('bundleSales')
        ->middleware('RoutePermissionCheck:admin.bundleSales.list');
        Route::get('/bundle-sales-data', 'AdminController@bundleSalesData')
        ->name('bundleSalesData')
        ->middleware('RoutePermissionCheck:admin.bundleSales.list');

    Route::get('/reveuneListInstructor', 'AdminController@reveuneListInstructor')->name('reveuneListInstructor')->middleware('RoutePermissionCheck:admin.reveuneListInstructor');
    Route::get('/reveuneListCP', 'AdminController@reveune_list_cp')->name('reveune_list_cp')->middleware('RoutePermissionCheck:admin.reveune_list_cp');
    Route::get('/reveuneListCPData', 'AdminController@revenue_cp_data')->name('reveune_cp_data')->middleware('RoutePermissionCheck:admin.reveune_list_cp_data');
    Route::post('/reveuneListCPExport', 'AdminController@reveune_cp_export')->name('reveune_cp_export');
    Route::post('/cp-export-monthly-statement-report', 'AdminController@cp_export_monthly_statement_report')->name('cp_export_monthly_statement_report')->middleware('RoutePermissionCheck:admin.cp.monthly.statement.reports');
    Route::get('/reveuneListPartner', 'AdminController@reveune_list_partner')->name('reveune_list_partner')->middleware('RoutePermissionCheck:admin.reveune_list_partner');

    Route::get('/enrol-list', 'AdminController@enrollLogs')->name('enrollLogs')->middleware('RoutePermissionCheck:admin.enrollLogs');
    /* new 22-3-2022 */
    Route::post('enroll-list-excel-download', 'AdminController@enroll_list_excel_download')->name('enroll_list_excel_download');
    /* End : new 22-3-2022 */

    Route::get('/interest-form', 'AdminController@interestForm')->name('interest.form')->middleware('RoutePermissionCheck:admin.interest.form');
    Route::get('/all/interestform-data', 'AdminController@getInterestFormData')->name('getInterestFormData');
    Route::get('/interest-form/edit/{id}', 'AdminController@interestFormEdit')->name('interestFormEdit')->middleware('RoutePermissionCheck:admin.interest.form');
    Route::post('interest-update', 'AdminController@interestFormUpdate')->name('interestFormUpdate')->middleware('RoutePermissionCheck:admin.interest.form');
    Route::post('/interest-list-excel-download', 'AdminController@interestListExcelDownload')->name('interest_list_excel_download');

    Route::get('/enrol-delete/{id}', 'AdminController@enrollDelete')->name('enrollDelete')->middleware('RoutePermissionCheck:admin.enrollDelete');
    Route::get('/enroll-mark-as-complete/{id}', 'AdminController@enrollMarkAsComplete')->name('markAsComplete')->middleware('RoutePermissionCheck:admin.markAsComplete');
    Route::get('/instructor-payout', 'AdminController@instructorPayout')->name('instructor.payout')->middleware('RoutePermissionCheck:admin.instructor.payout');
    Route::get('/content-provider-payout', 'AdminController@cpPayout')->name('cp.payout')->middleware('RoutePermissionCheck:admin.cp.payout');
    Route::get('/myll-admin-payout', 'AdminController@myll_admin_payout')->name('myll.admin.payout')->middleware('RoutePermissionCheck:admin.myll.admin.payout');
    Route::get('/monthly-statement-reports', 'AdminController@monthlyStatementReports')->name('cp.monthly.statement.reports')->middleware('RoutePermissionCheck:admin.cp.monthly.statement.reports');
    Route::get('/partner-payout', 'AdminController@partnerPayout')->name('partner.payout')->middleware('RoutePermissionCheck:admin.partner.payout');
    Route::post('/instructor-payout-request', 'AdminController@instructorRequestPayout')->name('instructor.instructorRequestPayout')->middleware('RoutePermissionCheck:admin.instructor.payout');
    Route::post('/instructor-payout-complete', 'AdminController@instructorCompletePayout')->name('instructor.instructorCompletePayout')->middleware('RoutePermissionCheck:admin.instructor.payout');

    Route::get('/hrdc-payout', 'AdminController@hrdcPayout')->name('hrdc.payout')->middleware('RoutePermissionCheck:admin.hrdc.payout');
    Route::post('/hrdc-payout-request', 'AdminController@hrdcRequestPayout')->name('hrdc.hrdcRequestPayout')->middleware('RoutePermissionCheck:admin.hrdc.payout');
    Route::post('/hrdc-payout-complete', 'AdminController@hrdcCompletePayout')->name('hrdc.hrdcCompletePayout')->middleware('RoutePermissionCheck:admin.hrdc.payout');
    Route::get('/all/hrdc-payout-data', 'AdminController@getHrdcPayoutData')->name('getHrdcPayoutData');

    Route::post('/transaction-instructor-list-ajax', 'AdminController@transaction_list_ajax')->name('transaction_list_ajax');
    Route::post('/transaction-instructor-download-pdf', 'AdminController@transaction_download_pdf')->name('transaction_download_pdf');
    Route::post('/transaction-mylladmin-download-pdf', 'AdminController@transaction_myll_admin_download_pdf')->name('transaction_myll_admin_download_pdf');
    Route::post('/myll-admin-download-pdf', 'AdminController@myill_admin_download_pdf')->name('myill_admin_download_pdf');

    Route::get('/enrollFilter', 'AdminController@enrollLogs');
    Route::post('/enrollFilter', 'AdminController@enrollFilter')->name('enrollFilter');
    Route::get('/courseEnrolls/{id}', 'AdminController@courseEnrolls')->name('enrollLog');
    Route::post('/courseEnrolls/{id}', 'AdminController@sortByDiscount')->name('sortByDiscount');

    Route::get('/all/enrol-list-data', 'AdminController@getEnrollLogsData')->name('getEnrollLogsData')->middleware('RoutePermissionCheck:admin.enrollLogs');
    Route::get('/all/payout-data', 'AdminController@getPayoutData')->name('getPayoutData');
    Route::get('/content-provider/payout-data', 'AdminController@getCpPayoutData')->name('getCpPayoutData');
    Route::get('/myll-admin/revenue-data', 'AdminController@getmyllAdminRevenueData')->name('getmyllAdminRevenueData');
    Route::get('/myll-admin/payout-data', 'AdminController@getmyllAdminPayoutData')->name('getmyllAdminPayoutData');
    Route::get('/content-provider/monthly-statement-reports', 'AdminController@getCpMonthlyStatementReports')->name('getCpMonthlyStatementReports');

    Route::post('/payoutcron', 'AdminController@callPayoutCron')->name('callPayoutCron');

    Route::get('/corporate-access-monthly-statement-reports', 'AdminController@monthlyStatementReportsCorporateAccess')->name('ca.monthly.statement.reports')->middleware('RoutePermissionCheck:admin.ca.monthly.statement.reports');
    Route::get('/content-provider/corporate-access-monthly-statement-reports', 'AdminController@getCaMonthlyStatementReports')->name('getCaMonthlyStatementReports');
    Route::post('/ca-export-monthly-statement-report', 'AdminController@ca_export_monthly_statement_report')->name('ca_export_monthly_statement_report')->middleware('RoutePermissionCheck:admin.ca.monthly.statement.reports');
});


Route::group(['namespace' => 'Admin', 'prefix' => 'course', 'as' => 'course.', 'middleware' => ['auth', 'admin']], function () {


    Route::get('categories', 'CourseController@category')->name('category')->middleware('RoutePermissionCheck:course.category');
    Route::post('categories/status-update', 'CourseController@category_status_update')->name('category.status_update')->middleware('RoutePermissionCheck:course.category.status_update');
    Route::post('categories/store', 'CourseController@category_store')->name('category.store')->middleware('RoutePermissionCheck:course.category.store');
    Route::post('categories/update', 'CourseController@category_update')->name('category.update')->middleware('RoutePermissionCheck:course.category.edit');
    Route::get('categories/edit/{id}', 'CourseController@category_edit')->name('category.edit')->middleware('RoutePermissionCheck:course.category.edit');
    Route::get('categories/delete/{id}', 'CourseController@category_delete')->name('category.delete')->middleware('RoutePermissionCheck:course.category.delete');


    Route::get('sub-categories', 'CourseController@sub_category')->name('subcategory')->middleware('RoutePermissionCheck:course.subcategory');
    Route::post('sub-categories/status-update', 'CourseController@sub_category_status_update')->name('subcategory.status_update')->middleware('RoutePermissionCheck:course.subcategory.status_update');
    Route::post('sub-categories/store', 'CourseController@sub_category_store')->name('subcategory.store')->middleware('RoutePermissionCheck:course.subcategory.store');
    Route::post('sub-categories/update', 'CourseController@sub_category_update')->name('subcategory.update')->middleware('RoutePermissionCheck:course.subcategory.edit');
    Route::get('sub-categories/edit/{id}', 'CourseController@sub_category_edit')->name('subcategory.edit')->middleware('RoutePermissionCheck:course.subcategory.edit');
    Route::get('sub-categories/delete/{id}', 'CourseController@sub_category_delete')->name('subcategory.delete')->middleware('RoutePermissionCheck:course.subcategory.delete');


});
Route::get('status-enable-disable', 'AjaxController@statusEnableDisable')->name('statusEnableDisable')->middleware(['auth']);

Route::group(['middleware' => ['auth', 'admin']], function () {
    Route::get('profile-settings', 'UserController@changePassword')->name('changePassword');
    Route::post('profile-settings', 'UserController@UpdatePassword')->name('updatePassword');
    Route::post('profile-update', 'UserController@update_user')->name('update_user');
    Route::post('profile-partner-update/{id}', 'UserController@update_partner_user')->name('update_partner_user');
});
//Route::post('get-user-by-role', 'UserController@getUsersByRole')->name('getUsersByRole')->middleware('auth');

Route::group(['namespace' => 'Admin', 'prefix' => 'communication', 'as' => 'communication.', 'middleware' => ['auth', 'admin']], function () {
    Route::get('private-messages', 'CommunicationController@PrivateMessage')->name('PrivateMessage')->middleware('RoutePermissionCheck:communication.PrivateMessage');
    Route::get('questions-answer', 'CommunicationController@QuestionAnswer')->name('QuestionAnswer')->middleware('RoutePermissionCheck:communication.QuestionAnswer');
    Route::any('StorePrivateMessage', 'CommunicationController@StorePrivateMessage')->name('StorePrivateMessage')->middleware('RoutePermissionCheck:communication.send');
    Route::post('getMessage', 'CommunicationController@getMessage')->name('getMessage');
});


Route::get('change-language/{language_code}', 'UserController@changeLanguage')->name('changeLanguage');
Route::post('/search', 'SearchController@search')->name('routeSearch');

Route::prefix('filepond/api')->group(function () {
    Route::post('/process', 'FilepondController@upload')->name('filepond.upload');
    Route::patch('/process', 'FilepondController@chunk')->name('filepond.chunk');
    Route::delete('/process', 'FilepondController@delete')->name('filepond.delete');
});

Route::get('ajaxGetSubCategoryList', 'AjaxController@ajaxGetSubCategoryList')->name('ajaxGetSubCategoryList');
Route::get('ajaxGetCourseList', 'AjaxController@ajaxGetCourseList')->name('ajaxGetCourseList');
Route::get('ajaxGetQuizList', 'AjaxController@ajaxGetQuizList')->name('ajaxGetQuizList');
Route::get('update-activity', 'AjaxController@updateActivity')->name('updateActivity');
Route::get('get-courses-data', 'AjaxController@courses_which_not_added_with_ajax')->name('courses_which_not_added_with_ajax');
Route::get('get-certificate-data-list', 'AjaxController@get_certificate_list')->name('get_certificate_list');
Route::post('get-selected-certificate', 'AjaxController@get_selected_certificate')->name('get_selected_certificate');

Route::post('summer-note-file-upload', 'UploadFileController@upload_image')->name('summerNoteFileUpload');


//auth adding
Route::get('auth/social', 'Auth\LoginController@showLoginForm')->name('social.login');
Route::get('oauth/{driver}', 'Auth\LoginController@redirectToProvider')->name('social.oauth');
Route::get('oauth/{driver}/callback', 'Auth\LoginController@handleProviderCallback')->name('social.callback');

Route::get('vimeo/video/{vimeo_id}', 'Frontend\WebsiteController@vimeoPlayer')->name('vimeoPlayer');

