<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin/course', 'middleware' => ['auth']], function () {
    Route::get('/allCategory', 'CourseSettingController@allCategory');
    Route::get('/getSubcat/{id}', 'CourseSettingController@getSubcat');
});

//Route For Admin

Route::group(['prefix' => 'admin/course', 'middleware' => ['auth', 'admin']], function () {
    Route::post('/assign-course-to-learners', 'CourseSettingController@assign_course_to_learners_ajax')->name('assign_course_to_learners');
    Route::get('get-course-learner-data','CourseSettingController@course_learner_list')->name('course_learner_list');
    Route::get('/all/featured-courses', 'CourseSettingController@getAllFeaturedCourse')->name('getAllFeaturedCourse')->middleware('RoutePermissionCheck:getAllCourse');
    Route::get('/featured-course-details/{id}', 'CourseSettingController@featuredCourseDetails')->name('featuredCourseDetails')->middleware('RoutePermissionCheck:course.details');
    Route::post('/updateFeaturedCourse', 'CourseSettingController@AdminUpdateFeaturedCourse')->name('AdminUpdateFeaturedCourse')->middleware('RoutePermissionCheck:course.edit');

    Route::get('/all/featured-courses-data', 'CourseSettingController@getAllFeaturedCourseData')->name('getAllFeaturedCourseData')->middleware('RoutePermissionCheck:getAllCourse');

    Route::any('/change-chapter-position', 'CourseSettingController@changeChapterPosition')->name('changeChapterPosition');
    Route::any('/change-lesson-position', 'CourseSettingController@changeLessonPosition')->name('changeLessonPosition');
    Route::any('/change-lesson-chapter', 'CourseSettingController@changeLessonChapter')->name('changeLessonChapter');

    Route::get('get-user-data', 'CourseSettingController@user_data_with_ajax')->name('user_data_with_ajax_in_course');
    //Get Course Subcategory
    Route::get('/ajaxGetCourseSubCategory', 'CourseSettingController@ajaxGetCourseSubCategory');

    //Manage Category
    Route::get('/messages', 'CourseSettingController@toastrMessages')->name('toastrMessages');

    Route::get('/searchCategory', 'CourseSettingController@searchCategory')->name('searchCategory');
    Route::get('/searchCourse', 'CourseSettingController@searchCourse')->name('searchCourse');
    Route::post('/saveCategory', 'CourseSettingController@saveCategory')->name('saveCategory');
    Route::get('/categoryEdit/{id}', 'CourseSettingController@categoryEdit')->name('categoryEdit');

    Route::post('/updateCategory', 'CourseSettingController@updateCategory')->name('updateCategory');
    Route::get('/categoryStatus/{id}', 'CourseSettingController@categoryStatus')->name('categoryStatus');

    //Manage Subcategory

    Route::get('/editSubCategory/{id}', 'CourseSettingController@editSubCategory')->name('editSubCategory');
    Route::post('/updateSubCategory', 'CourseSettingController@updateSubCategory')->name('updateSubCategory');
    Route::post('/disableSubCategory', 'CourseSettingController@disableSubCategory')->name('disableSubCategory');

    //Course Invitation
    Route::get('/course-statistics', 'CourseInvitationController@courseStatistics')->name('course.courseStatistics')->middleware('RoutePermissionCheck:course.courseStatistics');
    Route::get('/export-course-statistics', 'CourseInvitationController@export_course_statistics')->name('course.export_course_statistics')->middleware('RoutePermissionCheck:course.courseStatistics');
    Route::post('/import-course-bulk-action-details', 'CourseInvitationController@import_course_bulk_action_details')->name('course.import_course_bulk_action_details')->middleware('RoutePermissionCheck:getCourseBulk');
    Route::post('/course-bulk-export-template', 'CourseInvitationController@course_bulk_export_template')->name('course.course_bulk_export_template')->middleware('RoutePermissionCheck:getCourseBulk');
    Route::post('/import-course-bulk-action-curriculum', 'CourseInvitationController@import_course_bulk_action_curriculum')->name('course.import_course_bulk_action_curriculum')->middleware('RoutePermissionCheck:getCourseBulk');
    Route::get('/course-bulk-action', 'CourseInvitationController@courseBulkAction')->name('course.courseBulkAction')->middleware('RoutePermissionCheck:getCourseBulk');
    Route::get('/course-api-key', 'CourseInvitationController@courseApiKey')->name('course.courseApiKey')->middleware('RoutePermissionCheck:courseApiKey');
    Route::post('/course-api-key-generate', 'CourseInvitationController@courseApiKeyGenerate')->name('course.courseApiKeyGenerate')->middleware('RoutePermissionCheck:courseApiKey');
    /* New : 2-3-2022 */
    Route::get('/course-statistics/data', 'CourseInvitationController@dataCourseStatistics')->name('course.dataCourseStatistics')->middleware('RoutePermissionCheck:course.courseStatistics');
    Route::get('/course/ajaxdata/{id}', 'CourseInvitationController@courseAjaxData')->name('course.courseAjaxData')->middleware('RoutePermissionCheck:course.courseStatistics');
    /* 2-3-2022 */

    Route::get('/course-students/{course_id}', 'CourseInvitationController@enrolled_students')->name('course.enrolled_students');
    Route::get('/course-students-list/{course_id}', 'CourseInvitationController@getAllStudentData')->name('course.getAllStudentData');
    Route::get('/course-student-notify/{course_id}/{student_id}', 'CourseInvitationController@courseStudentNotify')->name('course.courseStudentNotify')->middleware('RoutePermissionCheck:course.courseStudentNotify');

    Route::get('/course-details/{id}', 'CourseSettingController@courseDetails')->name('courseDetails')->middleware('RoutePermissionCheck:course.details');
    Route::get('/course-details-set-session', 'CourseSettingController@courseDetailsSetSession')->name('courseDetailsSetSession')->middleware('RoutePermissionCheck:course.details');
    Route::get('/course-feature/{id}/{type}', 'CourseSettingController@courseMakeAsFeature')->name('courseMakeAsFeature');

    Route::get('/course-lesson-show/{course_id}/{chapter_id}/{lesson_id}', 'CourseSettingController@CourseLessonShow')->name('CourseQuetionShow');
    /* 23-2-2022 : Changed */
    Route::get('/course-question-show/{question_id}/{course_id}/{chapter_id}/{lesson_id}', 'CourseSettingController@CourseQuetionShow')->name('CourseQuetionShowData');
    /* 23-2-2022 :End */
    Route::get('/course-chapter-show/{course_id}/{chapter_id}', 'CourseSettingController@CourseChapterShow')->name('CourseChapterShow');

    Route::get('/course-question-delete/{quiz_id}/{question_id}', 'CourseSettingController@CourseQuestionDelete')->name('CourseQuestionDelete');


    Route::post('/setCourseDripContent', 'CourseSettingController@setCourseDripContent')->name('setCourseDripContent');
    // Route::get('/course-test/{id}', 'CourseSettingController@courseDetails2')->name('courseDetails2');


    //Manage course
    Route::get('/all/courses', 'CourseSettingController@getAllCourse')->name('getAllCourse')->middleware('RoutePermissionCheck:getAllCourse');

    Route::get('/new/course', 'CourseSettingController@addNewCourse')->name('addNewCourse')->middleware('RoutePermissionCheck:course.store');
    //    Route::get('/edit/course/{id}', 'CourseSettingController@editCourse')->name('addNewCourse')->middleware('RoutePermissionCheck:addNewCourse');

    Route::get('/active/courses', 'CourseSettingController@getAllCourse')->name('getActiveCourse')->middleware('RoutePermissionCheck:getActiveCourse');
    Route::get('/pending/courses', 'CourseSettingController@getAllCourse')->name('getPendingCourse')->middleware('RoutePermissionCheck:getPendingCourse');

    Route::post('/saveCourse', 'CourseSettingController@saveCourse')->name('AdminSaveCourse')->middleware('RoutePermissionCheck:course.store');
    Route::post('/saveCourseValidation', 'CourseSettingController@saveCourseValidation')->name('AdminSaveCourseValidation')->middleware('RoutePermissionCheck:course.store');

    Route::get('/editCourse/{id}', 'CourseSettingController@editCourse')->name('editCourse')->middleware('RoutePermissionCheck:course.edit');

    Route::post('/updateCourse', 'CourseSettingController@AdminUpdateCourse')->name('AdminUpdateCourse')->middleware('RoutePermissionCheck:course.edit');
    Route::post('/updateCourseValidation', 'CourseSettingController@AdminUpdateCourseValidation')->name('AdminUpdateCourseValidation')->middleware('RoutePermissionCheck:course.edit');

    Route::post('/updatecourse-certificate', 'CourseSettingController@AdminUpdateCourseCertificate')->name('AdminUpdateCourseCertificate')->middleware('RoutePermissionCheck:course.edit');
    Route::post('/unpublishCourse', 'CourseSettingController@unpublishCourse')->name('AdminUnpublishCourse');
    Route::get('/publishCourse/{id}', 'CourseSettingController@publishCourse')->name('publishCourse');
    Route::post('/courseStatus', 'CourseSettingController@courseStatus')->name('AdminCourseStatus')->middleware('RoutePermissionCheck:course.status_update');


    Route::get('/getEnroll/{id}', 'CourseSettingController@getEnroll')->name('getEnroll');
    Route::post('/rejectEnroll', 'CourseSettingController@rejectEnroll')->name('rejectEnroll');
    Route::post('/enableEnroll', 'CourseSettingController@enableEnroll')->name('enableEnroll');
    Route::post('/submitEnroll/{id}', 'CourseSettingController@submitEnroll')->name('submitEnroll');
    Route::post('/course-sort-by', 'CourseSettingController@courseSortBy')->name('courseSortBy');
    Route::get('/course-sort-by', 'CourseSettingController@getAllCourse')->name('courseSortByGet');
    Route::get('/courseSortByCat/{id}', 'CourseSettingController@courseSortByCat')->name('courseSortByCat');
    Route::get('/courseSort/{value}', 'CourseSettingController@courseSort')->name('courseSort');
    Route::get('/courseSortByInstructor/{value}', 'CourseSettingController@courseSortByInstructor')->name('courseSortByInstructor');
    Route::get('/course-delete/{id}', 'CourseSettingController@courseDelete')->name('course.delete');

    Route::post('course-list-excel-download', 'CourseSettingController@CourseListExcelDownload')->name('course_list_excel_download')->middleware('RoutePermissionCheck:getAllCourse');


    Route::get('chapter', 'ChapterController@index')->name('chapterPage');
    Route::POST('chapter', 'ChapterController@store')->name('saveChapterPage');
    Route::POST('chapter-search', 'ChapterController@chapterSearchByCourse')->name('chapterSearchByCourse');
    Route::get('chapter/{id}', 'ChapterController@chapterEdit')->name('chapterEdit');
    Route::PUT('chapter-update', 'ChapterController@chapterUpdate')->name('chapterUpdate');

    Route::get('lesson/{id}', 'LessonController@index')->name('lessonPage');
    Route::post('/addLesson', 'LessonController@addLesson')->name('addLesson');
    Route::get('/edit-lesson/{id}', 'LessonController@editLesson')->name('editLesson');
    Route::put('/updateLesson', 'LessonController@updateLesson')->name('updateLesson');
    Route::post('/deleteLesson', 'LessonController@deleteLesson')->name('deleteLesson');
    Route::post('/deleteLessonAssignment', 'LessonController@deleteLessonAssignment')->name('deleteLessonAssignment');

    Route::post('/addAssignment', 'CourseAssignmentController@AssignmentStore')->name('course_assignment_store');
    Route::get('/course-assignment-show/{course_id}/{chapter_id}/{lesson_id}', 'CourseAssignmentController@CourseAssignmentShow')->name('course_assignment_show');
    Route::post('/updateAssignment', 'CourseAssignmentController@AssignmentUpdate')->name('course_assignment_update');


    Route::post('/add-chapter', 'InstructorCourseSettingController@saveChapter')->name('saveChapter');
    Route::post('/saveFile', 'InstructorCourseSettingController@saveFile')->name('saveFile');
    Route::get('/download-file/{id}', 'InstructorCourseSettingController@download_course_file')->name('download_course_file');
    Route::get('/edit-chapter/{id}/{course}', 'InstructorCourseSettingController@editChapter')->name('editChapter');
    Route::get('/delete-chapter/{id}/{course}', 'InstructorCourseSettingController@deleteChapter')->name('deleteChapter');
    Route::put('/update-chapter', 'InstructorCourseSettingController@updateChapter')->name('updateChapter');
    Route::POST('/updateFile', 'InstructorCourseSettingController@updateFile')->name('updateFile');
    Route::get('/course_chapters/{id}', 'InstructorCourseSettingController@course_chapters')->name('course_chapters');
    Route::post('/deleteFile2', 'InstructorCourseSettingController@deleteFile')->name('deleteFile');


    Route::resource('course-level', 'CourseLevelController')->middleware('RoutePermissionCheck:course-level.index')->except('destroy');
    Route::get('course-level-delete/{id}', 'CourseLevelController@delete')->middleware('RoutePermissionCheck:course-level.destroy')->name('course-level.destroy');


    Route::get('/all/courses-data', 'CourseSettingController@getAllCourseData')->name('getAllCourseData')->middleware('RoutePermissionCheck:getAllCourse');


    Route::get('/vdocipher/video-list', 'CourseSettingController@getAllVdocipherData')->name('getAllVdocipherData');
    Route::get('/vdocipher/video/{id}', 'CourseSettingController@getSingleVdocipherData')->name('getSingleVdocipherData');

    /* New : 4-3-2022 */
    Route::get('/select2-autocomplete-ajax-vimeo-video-list/', 'CourseSettingController@auto_select2_ajax_vimeo_video_list')->name('select2.vimeo.video.list');
    /* End : 4-3-2022 */

    Route::post('send-feedback', 'CourseSettingController@send_course_feedback')->name('send_course_feedback');

    /* New : 21-7-2022 */
    Route::get('/course-feedback/{id}', 'CourseSettingController@getCourseFeedbackData')->name('getCourseFeedbackData')->middleware('RoutePermissionCheck:course.view_course_feedback');
    Route::post('approve-course', 'CourseSettingController@approve_course')->name('approve_course');
    Route::post('reject-course', 'CourseSettingController@reject_course')->name('reject_course');
    Route::post('rejected-feedback', 'CourseSettingController@reject_feedback')->name('reject_feedback');
});

Route::group(['prefix' => 'admin/package', 'middleware' => ['auth', 'admin']], function () {
    Route::get('get-course-data', 'PackageController@course_data_with_ajax')->name('course_data_with_ajax_select2');

    Route::get('/new/package', 'PackageController@addPackage')->name('addPackage')->middleware('RoutePermissionCheck:package.store');
    Route::get('get-categories', 'PackageController@get_categories')->name('get_categories');
    Route::post('/save/package', 'PackageController@savePackage')->name('savePackage')->middleware('RoutePermissionCheck:package.store');
    Route::get('/all/packages', 'PackageController@getAllPackages')->name('getAllPackages')->middleware('RoutePermissionCheck:admin.package.list');
    Route::get('/change-package-status', 'PackageController@changePackageStatus')->name('changePackageStatus');
    Route::get('/all/packages/data', 'PackageController@getAllPackageData')->name('getAllPackageData')->middleware('RoutePermissionCheck:admin.package.list');
    Route::get('/edit/package/{id}', 'PackageController@editPackage')->name('editPackage')->middleware('RoutePermissionCheck:package.edit');
    Route::post('assign-certificate', 'PackageController@assign_certificate')->name('assign_certificate');

    /* Partner Landing Page Content Course Highlights start */
    Route::get('/all/course-highlights', 'PackageController@getAllCourseHighlights')->name('getAllCourseHighlights')->middleware('RoutePermissionCheck:getAllCourseHighlights');
    Route::post('/add-course-highlights', 'PackageController@addCourseHighlights')->name('addCourseHighlights');
    Route::post('/edit-course-highlights', 'PackageController@editCourseHighlights')->name('editCourseHighlights');
    Route::post('/delete-course-highlights', 'PackageController@deleteCourseHighlights')->name('deleteCourseHighlights');
    /* Partner Landing Page Content Course Highlights start */

});

Route::group(['prefix' => 'admin/trainers', 'as' => 'trainers.', 'middleware' => ['auth', 'admin']], function () {
    Route::get('/', 'TrainerController@index')->name('index');
    Route::get('/datatable', 'TrainerController@datatable')->name('datatable');
    Route::get('/create', 'TrainerController@create')->name('create');
    Route::post('/store', 'TrainerController@store')->name('store');
    Route::get('/edit/{id}', 'TrainerController@edit')->name('edit');
    Route::post('/store', 'TrainerController@store')->name('store');
    Route::get('/destroy/{id}', 'TrainerController@destroy')->name('destroy');
});

Route::group(['prefix' => 'admin/customize_package', 'middleware' => ['auth', 'admin']], function () {
    Route::get('/new/customize-package', 'CustomizePackageController@addPackage')->name('addCustomPackage')->middleware('RoutePermissionCheck:customize.packages.store');
    Route::post('/save/customize-package', 'CustomizePackageController@savePackage')->name('saveCustomizePackage');
    Route::get('/all/customize-package', 'CustomizePackageController@getAllPackages')->name('getAllCustomizePackages')->middleware('RoutePermissionCheck:customize.packages.list');
    Route::get('/all/customize-package/data', 'CustomizePackageController@getAllPackageData')->name('getAllCustomizePackageData')->middleware('RoutePermissionCheck:customize.packages.list');
    Route::get('/edit/customize-package/{id}', 'CustomizePackageController@editPackage')->name('editCutomizePackage')->middleware('RoutePermissionCheck:customize.packages.edit');
    Route::get('get-courses-data', 'CustomizePackageController@course_data_with_ajax')->name('get-courses-data');
    Route::get('/package/request','CustomizePackageController@packageRequest')->name('packageRequest')->middleware('RoutePermissionCheck:package.request');
    Route::get('/package/request/list','CustomizePackageController@getAllPackageRequest')->name('getAllPackageRequest')->middleware('RoutePermissionCheck:package.request');
    Route::get('/package/request/edit/{id}','CustomizePackageController@PackageRequestEdit')->name('editPackageRequest')->middleware('RoutePermissionCheck:package.request.edit');
    Route::post('/package/request/update','CustomizePackageController@PackageRequestUpdate')->name('updatePackageRequest')->middleware('RoutePermissionCheck:package.request.edit');
});


