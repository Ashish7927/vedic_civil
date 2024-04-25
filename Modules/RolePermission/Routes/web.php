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

Route::prefix('role-permission')->middleware(['auth', 'admin'])->group(function () {
    Route::name('permission.')->group(function () {
        Route::resource('roles', 'RoleController')->middleware('RoutePermissionCheck:permission.permissions.store');
        Route::get('/roles-student', 'RoleController@studentIndex')->name('student-roles')->middleware('RoutePermissionCheck:permission.permissions.store');
        Route::get('/roles-trainer', 'RoleController@trainerIndex')->name('trainer-roles')->middleware('RoutePermissionCheck:permission.permissions.store');
        Route::get('/roles-staff', 'RoleController@staffIndex')->name('staff-roles')->middleware('RoutePermissionCheck:permission.permissions.store');
        Route::resource('permissions', 'PermissionController')->middleware('RoutePermissionCheck:permission.permissions.store');
        Route::get('permissionview', 'PermissionController@index');
        Route::get('/rolemanage', 'RolemanageController@index');

        Route::get('/content-provider-role', 'RoleController@contentproviderrole')->name('roles.contentprovider')->middleware('RoutePermissionCheck:permission.permissions.store');
        Route::get('/partner-role', 'RoleController@partnerrole')->name('roles.partnerrole')->middleware('RoutePermissionCheck:permission.permissions.store');


        Route::get('/adminuser','AdminuserController@index');
        Route::get('/all/admin-data', 'AdminuserController@getAllAdminData')->name('admin.getAllAdminData');
        Route::post('admin/store', 'AdminuserController@store')->name('admin.store');
        Route::post('admin/update', 'AdminuserController@update')->name('admin.update');
        Route::post('admin/destroy', 'AdminuserController@destroy')->name('admin.delete');
        Route::get('admin/status/{id}', 'AdminuserController@status')->name('admin.change_status');

        Route::post('roles/update', 'RolemanageController@update')->name('role.roles.update');
        Route::post('roles/store', 'RolemanageController@store')->name('role.roles.store');
        Route::post('roles/destroy', 'RolemanageController@destroy')->name('role.roles.destroy');

    });
});
