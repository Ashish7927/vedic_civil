<?php

namespace Modules\SystemSetting\Http\Controllers;

use Image;
use App\User;
use App\Subscription;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use DrewM\MailChimp\MailChimp;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;
use Modules\Newsletter\Entities\NewsletterSetting;
use Modules\Newsletter\Http\Controllers\AcelleController;


class ReviewerSettingController extends Controller
{
    public function index()
    {

        try {
            $course_reviewer = [];
            return view('systemsetting::course_reviewer', compact('course_reviewer'));
        } catch (\Exception $e) {
            Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
            return redirect()->back();
        }
    }



    public function getAllReviewerData(Request $request)
    {

        $query = User::where('role_id', 10);

        return Datatables::of($query)
            ->addIndexColumn()
            ->addColumn('image', function ($query) {
                return " <div class=\"profile_info\"><img src='" . getInstructorImage($query->image) . "'   alt='" . $query->name . " image'></div>";
            })->editColumn('name', function ($query) {
                return $query->name;
            })->editColumn('email', function ($query) {
                return $query->email;
            })->addColumn('group_policy', function ($query) {
                $policy = '';
                if (isModuleActive('OrgInstructorPolicy')) {
                    $policy = $query->policy->name;
                }
                return $policy;
            })
            ->addColumn('status', function ($query) {

                $checked = $query->status == 1 ? "checked" : "";
                $view = '<label class="switch_toggle" for="active_checkbox' . $query->id . '">
                                <input type="checkbox" class="status_enable_disable"
                                        id="active_checkbox' . $query->id . '" value="' . $query->id . '"
                                        ' . $checked . '><i class="slider round"></i></label>';

                return $view;
            })->addColumn('action', function ($query) {

                if (permissionCheck('instructor.edit')) {
                    $instructor_edit = '  <button data-item-id =\'' . $query->id . '\'
                                                class="dropdown-item edit_cp"
                                                type="button">' . trans('common.Edit') . '</button>';
                } else {
                    $instructor_edit = "";
                }


                if (permissionCheck('instructor.delete')) {

                    $instructor_delete = '<button class="dropdown-item deleteInstructor"
                                                data-id="' . $query->id . '"
                                                type="button">' . trans('common.Delete') . '</button>';
                } else {
                    $instructor_delete = "";
                }

                $actioinView = ' <div class="dropdown CRM_dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button"
                                            id="dropdownMenu2" data-toggle="dropdown"
                                            aria-haspopup="true"
                                            aria-expanded="false">
                                        ' . trans('common.Action') . '
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right"
                                         aria-labelledby="dropdownMenu2">
                                        ' . $instructor_edit . '
                                    </div>
                                </div>';

                return $actioinView;
            })
            ->rawColumns(['image', 'action'])->make(true);
    }
}
