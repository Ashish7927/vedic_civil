<?php

Route::prefix('live-training')->group(function () {
    Route::name('bbb.')->middleware('auth')->group(function () {
        Route::get('meetings', 'BbbMeetingController@index')->name('meetings')->middleware('RoutePermissionCheck:bbb.meetings.index');
        Route::get('datatable', 'BbbMeetingController@datatable')->name('meetings.datatable')->middleware('RoutePermissionCheck:bbb.meetings.index');
        Route::post('meetings', 'BbbMeetingController@store')->name('meetings.store')->middleware('RoutePermissionCheck:bbb.meetings.store');
        Route::get('meetings-show/{id}', 'BbbMeetingController@show')->name('meetings.show')->middleware('RoutePermissionCheck:bbb.meetings.index');
        Route::get('meetings-edit/{id}', 'BbbMeetingController@edit')->name('meetings.edit')->middleware('RoutePermissionCheck:bbb.meetings.edit');
        Route::post('meetings/{id}', 'BbbMeetingController@update')->name('meetings.update')->middleware('RoutePermissionCheck:bbb.meetings.edit');
        Route::delete('meetings/{id}', 'BbbMeetingController@destroy')->name('meetings.destroy')->middleware('RoutePermissionCheck:bbb.meetings.destroy');
        Route::get('settings', 'BbbSettingController@settings')->name('settings')->middleware('RoutePermissionCheck:bbb.settings');
        Route::post('settings', 'BbbSettingController@updateSettings')->name('settings.update')->middleware('RoutePermissionCheck:bbb.settings');
        Route::get('user-list-user-type-wise', 'BbbMeetingController@userWiseUserList')->name('user.list.user.type.wise');
        Route::get('virtual-class-room/{id}', 'BbbMeetingController@meetingStart')->name('meeting.join');
        Route::post('meetings', 'BbbMeetingController@store')->name('meetings.store');

        Route::post('meeting-start', 'BbbMeetingController@meetingStart')->name('meetingStart');
        Route::get('meeting-start-attendee/{course_id}/{meeting_id}', 'BbbMeetingController@meetingStartAsAttendee')->name('meetingStartAsAttendee');
        Route::get('meeting-record-list/{meeting_id}', 'BbbMeetingController@recordList')->name('recordList');

        Route::post('approve', 'BbbMeetingController@approve_meeting')->name('meetings.approve');
        Route::post('reject', 'BbbMeetingController@reject_meeting')->name('meetings.reject');
    });
});
