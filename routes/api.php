<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/table.php';




Route::group(['namespace' => 'Api', 'as' => 'api.'], function () {

Auth::routes(['verify' => true]);
});


Route::group([
    'namespace' => 'Api'
], function () {
    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');
    Route::post('verify-otp', 'AuthController@verifyOtp');

    Route::post('set-fcm-token', 'AuthController@setFcmToken');
    Route::post('courses/oauth/token', 'AuthController@setCoursesOauthToken');

    Route::post('/get-courses-required-details', 'CourseApiController@getCoursesRequiredDetails');
    Route::post('/get-courses-progress-update', 'CourseApiController@getCoursesProgressUpdate');

    //CourseApiController
    Route::get('/get-all-courses', 'CourseApiController@getAllCourses');
    Route::get('/get-free-courses', 'CourseApiController@getFreeCourses');
    
    Route::get('/get-all-classes', 'CourseApiController@getAllClasses');
    Route::get('/get-all-quizzes', 'CourseApiController@getAllQuizzes');
    Route::get('/get-popular-courses', 'CourseApiController@getPopularCourses');
    Route::get('/get-popular-classes', 'CourseApiController@getPopularClasses');
    Route::get('/get-course-details/{id}', 'CourseApiController@getCourseDetails');
    Route::get('/get-class-details/{id}', 'CourseApiController@getClassDetails');

    Route::get('/get-quiz-details/{id}', 'CourseApiController@getQuizDetails');
    Route::get('/get-lesson-quiz-details/{quiz_id}', 'CourseApiController@getLessonQuizDetails');
    
    Route::get('/top-categories', 'CourseApiController@topCategories');
    Route::get('/search-course', 'CourseApiController@searchCourse');
    Route::get('/filter-course', 'CourseApiController@filterCourse');
    Route::get('/payment-gateways', 'WebsiteApiController@paymentGateways');

    Route::get('categories', 'CourseApiController@categories');
    Route::get('sub-categories/{category_id}', 'CourseApiController@subCategories');
    Route::get('levels', 'CourseApiController@levels');
    Route::get('languages', 'CourseApiController@languages');



    // Route::group([
    //     'middleware' => ['auth:api', 'verified']
    // ], function () {
        //with login routes

        Route::any('lesson-complete', 'WebsiteApiController@lessonComplete')->name('api.lesson.complete');


        Route::get('/get-bbb-start-url/{meeting_id}/{user_name}', 'WebsiteApiController@getBbbMeetingUrl');

        Route::get('/cart-list/{user_id}', 'WebsiteApiController@cartList');
        Route::post('/add-to-cart', 'WebsiteApiController@addToCart');
        Route::get('/remove-to-cart/{id}', 'WebsiteApiController@removeCart');
        Route::post('/apply-coupon', 'WebsiteApiController@applyCoupon');

        //AuthController
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');
        Route::post('change-password', 'AuthController@changePassword');
        Route::post('/update-profile', 'WebsiteApiController@updateProfile');


        //WebsiteApiController
        Route::get('/home', 'WebsiteApiController@homePage');
        Route::get('/countries', 'WebsiteApiController@countries');
        Route::get('/cities/{country_id}', 'WebsiteApiController@cities');
        Route::get('/my-courses/{user_id}', 'WebsiteApiController@myCourses');
        Route::get('/my-quizzes', 'WebsiteApiController@myQuizzes');
        Route::get('/my-classes', 'WebsiteApiController@myClasses');
        Route::post('/submit-review', 'WebsiteApiController@submitReview');
        Route::post('/comment', 'WebsiteApiController@comment');
        Route::post('/comment-reply', 'WebsiteApiController@commentReply');
        Route::get('/payment-methods', 'WebsiteApiController@paymentMethods');

        Route::post('/make-order', 'WebsiteApiController@makeOrder');
        Route::post('/make-payment', 'WebsiteApiController@payWithGateWay');
        Route::get('/my-billing-address', 'WebsiteApiController@myBilling');

        Route::post('paytm-order-generate', 'WebsiteApiController@paytmOrderGenerate');
        Route::post('paytm-order-verify', 'WebsiteApiController@paytmOrderVerify');


        //quiz route
        Route::post('quiz-start/{course_id}/{quiz_id}', 'WebsiteApiController@quizStart');
        Route::post('quiz-single-submit', 'WebsiteApiController@singleQusSubmit');
        Route::post('quiz-final-submit', 'WebsiteApiController@finalQusSubmit');
        Route::post('quiz-result/{course_id}/{quiz_id}', 'WebsiteApiController@quizResult');
        Route::post('quiz-results/{user_id}', 'WebsiteApiController@quizResults');
        Route::post('quiz-result-preview/{quiz_id}', 'WebsiteApiController@quizResultPreview');


        Route::post('learning-progress-update', 'PackageProgressApiController@storePackageProgress');
    // });
});
