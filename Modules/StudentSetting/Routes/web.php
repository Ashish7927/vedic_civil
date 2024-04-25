<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin/student', 'middleware' => ['auth', 'admin']], function () {

    Route::get('/allStudent', 'StudentSettingController@index')->name('student.student_list')->middleware('RoutePermissionCheck:student.student_list');
    Route::post('/store', 'StudentSettingController@store')->name('student.store')->middleware('RoutePermissionCheck:student.store');
    Route::get('/edit/{id}', 'StudentSettingController@edit')->middleware('RoutePermissionCheck:student.edit');
    Route::post('/update', 'StudentSettingController@update')->name('student.update')->middleware('RoutePermissionCheck:student.edit');
    Route::post('/impersonate', 'StudentSettingController@impersonate')->name('student.impersonate')->middleware('RoutePermissionCheck:student.impersonate');
    Route::post('/destroy', 'StudentSettingController@destroy')->name('student.delete')->middleware('RoutePermissionCheck:student.delete');
    Route::post('/reset-password', 'StudentSettingController@resetPassword')->name('student.reset_password')->middleware('RoutePermissionCheck:student.reset_password');
    Route::get('/status/{id}', 'StudentSettingController@status')->name('student.change_status')->middleware('RoutePermissionCheck:student.enable_disable');

    Route::post('/send-mail', 'StudentSettingController@sendMail')->name('student.send_mail')->middleware('RoutePermissionCheck:student.send_mail');


    Route::get('/all/student-data', 'StudentSettingController@getAllStudentData')->name('student.getAllStudentData')->middleware('RoutePermissionCheck:student.student_list');

    Route::get('assign-courses/{id}', 'StudentSettingController@studentAssignedCourses')->name('student.courses')->middleware('RoutePermissionCheck:student.courses');


    Route::get('field', 'StudentSettingController@field')->name('student.student_field')->middleware('RoutePermissionCheck:student.student_field');
    Route::post('field/Store', 'StudentSettingController@fieldstore')->name('student.student_field_store')->middleware('RoutePermissionCheck:student.student_field_store');


    Route::get('/enroll-new', 'StudentSettingController@newEnroll')->name('student.new_enroll')->middleware('RoutePermissionCheck:student.new_enroll');
    Route::post('/enroll-new', 'StudentSettingController@newEnrollSubmit')->name('student.new_enroll_submit')->middleware('RoutePermissionCheck:student.new_enroll_submit');


    Route::get('student-excel-download', 'StudentImportController@export')->name('student_excel_download');
    Route::get('country_list_download', 'StudentImportController@country_list_export')->name('country_list_download');

    Route::get('student-import', 'StudentImportController@index')->name('student_import');
    Route::post('student-import', 'StudentImportController@store')->name('student_import_save');

    Route::get('regular_student-import', 'StudentImportController@regular')->name('regular_student_import');
    Route::post('regular_student-import', 'StudentImportController@regularStore')->name('regular_student_import_save');
    Route::get('regular_student-excel-download', 'StudentImportController@regularStudentexport')->name('regular_student_excel_download');

    /* new 21-3-2022 */
    Route::post('learner-list-excel-download', 'StudentImportController@LearnerListExcelDownload')->name('learner_list_excel_download');
    /* End : new 21-3-2022 */

    Route::post('/notify', 'StudentSettingController@notify')->name('student.notify')->middleware('RoutePermissionCheck:student.notify');
});

Route::group(['prefix' => 'bookmarks', 'middleware' => ['auth', 'student']], function () {
    Route::get('/save/{id}', 'BookmarkController@bookmarkSave')->name('bookmarkSave');
    Route::get('/delete/{id}', 'BookmarkController@bookmarksDelete')->name('bookmarkDelete');
    Route::get('/show/{id}', 'BookmarkController@show')->name('bookmarkShow');
});
