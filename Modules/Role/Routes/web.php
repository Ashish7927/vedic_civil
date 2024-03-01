<?php

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
use Illuminate\Support\Facades\Route;

Route::prefix('manage')->middleware(['auth', 'admin'])->group(function () {
    Route::resource('role', 'RolemanageController')->except('update', 'destroy');
    Route::post('roles/update', 'RolemanageController@update')->name('roles.update');
    Route::post('roles/store', 'RolemanageController@store')->name('roles.store');
    Route::post('roles/destroy', 'RolemanageController@destroy')->name('roles.destroy');
});
