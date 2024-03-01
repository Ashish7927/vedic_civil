<?php

use Illuminate\Support\Facades\Route;

Route::prefix('offlinepayment')->middleware('auth')->group(function() {
    Route::get('/', 'OfflinePaymentController@index');

    Route::get('/offline', 'OfflinePaymentController@offlinePaymentView')->name('offlinePayment')->middleware('RoutePermissionCheck:offlinePayment');
    Route::get('/offline-history/{id}', 'OfflinePaymentController@FundHistory')->name('fundHistory')->middleware('RoutePermissionCheck:offlinePayment.fund-history');
    Route::post('/addBalance', 'OfflinePaymentController@addBalance')->name('addBalance')->middleware('RoutePermissionCheck:offlinePayment.add');

    /* 24-2-2022 : New */
    Route::get('/offline/instructordata', 'OfflinePaymentController@getInstructorData')->name('offlinePayment.getInstructorData')->middleware('RoutePermissionCheck:offlinePayment');
    Route::get('/offline/studentdata', 'OfflinePaymentController@getStudentData')->name('offlinePayment.getStudentData')->middleware('RoutePermissionCheck:offlinePayment');
    /* 24-2-2022 */
});
