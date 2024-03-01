<?php


use Illuminate\Support\Facades\Route;

Route::prefix('scorm')->as('scorm.')->group(function () {
    Route::get('/', 'SCORMController@index');
    Route::get('/viewer/{version}/{link}', 'SCORMController@viewer')->name('viewer');
    Route::get('/action', 'SCORMController@action')->name('action');
    Route::post('/statement', 'SCORMController@statement')->name('statement');
    Route::post('/report-store', 'SCORMReportController@store')->name('report.store');
    Route::get('/report', 'SCORMReportController@index')->name('report.index');
    Route::get('/report-data', 'SCORMReportController@data')->name('report.data');
    Route::get('/report-details/{id}', 'SCORMReportController@details')->name('report.details');
    Route::get('/report-lesson-details/{user_id}/{lesson_id}', 'SCORMReportController@lessonDetails')->name('report.lesson-details');
});
