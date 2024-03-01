<?php

namespace Modules\CourseSetting\Http\Controllers;

use App\Exports\CourseBulkTemplateExport;
use App\Imports\ImportCourseBulk;
use App\Imports\ImportCourseCurriculum;
use App\Models\CourseAccessToken;
use App\User;
use App\Jobs\SendInvitation;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Brian2694\Toastr\Facades\Toastr;
use App\Notifications\EmailNotification;
use Yajra\DataTables\Facades\DataTables;
use App\Notifications\GeneralNotification;
use Modules\CourseSetting\Entities\Course;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\Notification;
use App\Exports\CourseStatisticsExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class CourseInvitationController extends Controller
{

    public function courseStatistics()
    {
        try {
            return view('coursesetting::statistics');
        } catch (\Exception $e) {
            Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
            return redirect()->back();
        }
    }

    public function courseBulkAction()
    {
        try {
            $content_providers = User::select('id', 'name')->whereIn('role_id', [7, 8])->paginate(10);

            return view('coursesetting::bulk_action', compact('content_providers'));
        } catch (\Exception $e) {
            Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
            return redirect()->back();
        }
    }

    public function courseApiKey()
    {
        try {
            if (isPartner()) {
                if (\Auth::user()->is_allow_course_api_key != 1) {
                    Toastr::error(trans('common.You did not have permission to enter'), trans('common.Failed'));
                    return redirect()->to('dashboard');
                }
            }
            $courseApiToken = CourseAccessToken::where('user_id', \Auth::user()->id)->first();
            return view('coursesetting::course_api_key', compact('courseApiToken'));
        } catch (\Exception $e) {
            Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
            return redirect()->back();
        }
    }

    public function courseApiKeyGenerate()
    {
        $checkExist = CourseAccessToken::where('user_id', \Auth::user()->id)->first();
        if (!isset($checkExist->user_id)) {
            $courseAccessToken = new CourseAccessToken();
            $courseAccessToken->user_id = \Auth::user()->id;
            $courseAccessToken->client_key = \Str::random(64);
            $courseAccessToken->secret_key = \Str::random(64);
            $courseAccessToken->save();
        } else {
            $checkExist->client_key = \Str::random(64);
            $checkExist->secret_key = \Str::random(64);
            $checkExist->save();
        }

        Toastr::success(trans('common.Operation successful'), trans('common.Success'));
        return redirect()->back();
    }

    public function dataCourseStatistics()
    {
        $table_data = Course::with('enrollUsers','enrolls','enrolls.user', 'lessons')->where('type', 1);

        return Datatables::of($table_data)
            ->editColumn('enrolled', function ($query) {
                $erolled = $query->enrollUsers->count();
                return $erolled;
            })
            ->editColumn('pass', function ($query) {
                $pass = "NA";
                $is_quiz = $query->courseIsQuizOrNot();
                if($is_quiz)
                    $pass = $query->totalPassFailed(1, $query->id);
                    // $pass = $query->result()['complete'];
                return $pass;
            })
            ->editColumn('fail', function ($query) {
                $fail = "NA";
                $is_quiz = $query->courseIsQuizOrNot();
                if($is_quiz)
                    $fail = $query->totalPassFailed(0, $query->id);
                    // $fail = $query->result()['incomplete'];
                return $fail;
            })
            ->addColumn('action', function ($query) {
                $actioinView = '';
                // <a class="dropdown-item" data-toggle="modal" data-target="#view_result' . $query->id . '" href="#">' . __('common.View') . '</a>
                $actioinView = '<div class="dropdown CRM_dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button"
                                id="dropdownMenu1' . $query->id . '" data-toggle="dropdown"
                                aria-haspopup="true"
                                aria-expanded="false">
                            ' . __('common.Select') . '
                        </button>
                        <div class="dropdown-menu dropdown-menu-right"
                             aria-labelledby="dropdownMenu1' . $query->id . '">
                            <a class="dropdown-item" id="view_button" data-id="'.$query->id.'">' . __('common.View') . '</a>

                        </div>
                    </div>';
                    // '<div class="cource_details d-none">';
                    // $html = view('coursesetting::inc_statistics',['course'=>$query])->render();
                    // $actioinView .= $html;
                    // $actioinView .= '</div>';
                return $actioinView;
            })
            ->rawColumns(['enrolled', 'pass', 'fail', 'action'])
            ->addIndexColumn()
            ->make(true);
    }

    public function courseAjaxData($id)
    {
        $data = Course::with('enrollUsers','enrolls','enrolls.user', 'lessons')->where('id',$id)->first();
        $html = view('coursesetting::inc_statistics',['course'=>$data])->render();
        return $html;
        // if($data){
        //     return response()->json($html);
        // }
    }


    public function enrolled_students($course_id)
    {
        try {
            $course = Course::find($course_id);
            if ($course->status != 2) {
                $students = [];
                return view('coursesetting::student_list', compact('students', 'course'));
            } else {
                Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
                return redirect()->back();
            }

        } catch (\Exception $e) {
            Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
            return redirect()->back();
        }
    }


    public function getAllStudentData(Request $request, $course_id)
    {

        $course = Course::find($course_id);
        $query = $course->enrollUsers;

        return Datatables::of($query)
            ->addIndexColumn()
            ->addColumn('image', function ($query) {
                return " <div class=\"profile_info\"><img src='" . getStudentImage($query->image) . "'   alt='" . $query->name . " image'></div>";
            })->addColumn('student_name', function ($query) {
                return '<a class="dropdown-item" target="_blank" href="' . route('student.courses', $query->id) . '" data-id="' . $query->id . '" type="button">' . $query->name . '</a>';

            })->editColumn('email', function ($query) {
                return $query->email;

            })
            ->editColumn('phone', function ($query) {
                return $query->phone;

            })
            ->addColumn('progressbar', function ($query) use ($course) {
                return "  <div class='progress_percent flex-fill text-right'>
                                                    <div class='progress theme_progressBar '>
                                                        <div class='progress-bar' role='progressbar'
                                                             style='width:" . round($course->userTotalPercentage($query->id, $course->id)) . "%'
                                                             aria-valuenow='25'
                                                             aria-valuemin='0' aria-valuemax='100'></div>
                                                    </div>
                                                    <p class='font_14 f_w_400'>" . round($course->userTotalPercentage($query->id, $course->id)) . "% Complete</p>
                                                </div>";

            })
            ->editColumn('dob', function ($query) {
                return showDate($query->dob);

            })
            ->addColumn('start_working_date', function ($query) {
                if (isModuleActive('Org')) {
                    return showDate($query->start_working_date);
                } else {
                    return '';
                }

            })
            ->editColumn('country', function ($query) {
                return $query->userCountry->name;

            })
            ->addColumn('status', function ($query) {

                $checked = $query->status == 1 ? "checked" : "";
                $view = '<label class="switch_toggle" for="active_checkbox' . $query->id . '">
                                                    <input type="checkbox" class="status_enable_disable"
                                                           id="active_checkbox' . $query->id . '" value="' . $query->id . '"
                                                             ' . $checked . '><i class="slider round"></i></label>';

                return $view;
            })->addColumn('notify_user', function ($query) use ($course) {
                if (round($course->userTotalPercentage($query->id, $course->id)) < 100) {
                    $link = '<a class="" href="' . route('course.courseStudentNotify', [$course->id, $query->id]) . '" data-id="' . $query->id . '" type="button">Notify</a>';
                } else {
                    $link = '';

                }
                return $link;


            })->rawColumns(['status', 'progressbar', 'image', 'notify_user', 'action', 'student_name'])
            ->make(true);
    }


    public function courseStudentNotify($course_id, $student_id)
    {
        try {
            $course = Course::find($course_id);
            $user = User::find($student_id);
            $percentage = round($course->userTotalPercentage($student_id, $course_id));
            $message = "You have complete " . $percentage . "% of " . $course->title . ". Please complete as soon as possible";
            $details = [
                'title' => 'Incomplete course reminder',
                'body' => $message,
                'actionText' => 'Visit',
                'actionURL' => route('courseDetailsView', $course->slug),
            ];
            Notification::send($user, new GeneralNotification($details));
            Toastr::success('Operation Done Successfully', 'Success');
            return redirect()->back();
        } catch (\Throwable $th) {
            Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
            return redirect()->back();
        }

    }

    public function export_course_statistics()
    {
        return Excel::download(new CourseStatisticsExport(), 'course-statistics.csv');
    }

    public function course_bulk_export_template()
    {
        return Excel::download(new CourseBulkTemplateExport(), 'course-bulk-template.csv');
    }

    public function import_course_bulk_action_details(Request $request)
    {
        if ($request->has('file')) {
            if ($request->user_id == '') {
                Toastr::error(trans('Please select a partner.'), trans('common.Error'));
                return redirect()->back()->with('error', 'Please select a partner.');
            }

            Session::forget('content_provider_id');
            Session::put('content_provider_id', $request->user_id);

            Excel::import(new ImportCourseBulk(), $request->file, 'local', \Maatwebsite\Excel\Excel::CSV);

            Toastr::success(trans('Courses Imported Details Successfully'), trans('common.Success'));
            return redirect()->back()->with('success', 'Courses Imported Details Successfully');
        } else {
            Toastr::error(trans('Please upload a csv file.'), trans('common.Error'));
            return redirect()->back()->with('error', 'Please upload a csv file.');
        }
    }

    public function import_course_bulk_action_curriculum(Request $request)
    {
        Excel::import(new ImportCourseCurriculum(), $request->file, 'local', \Maatwebsite\Excel\Excel::CSV);

        Toastr::success(trans('Courses Imported Curriculum Successfully'), trans('common.Success'));
        return redirect()->back()->with('success', 'Courses Imported Curriculum Successfully');
    }
}
