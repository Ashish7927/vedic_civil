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
use Auth;

class CpSettingController extends Controller
{
    public function index()
    {

        try {
            $cp = [];
            return view('systemsetting::cp', compact('cp'));

        } catch (\Exception $e) {
            Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
            return redirect()->back();
        }
    }



    public function getAllCpData(Request $request)
    {
        $query = User::where('role_id', 7);

        return Datatables::of($query)
            ->addIndexColumn()
            ->addColumn('image', function ($query) {
                return " <div class=\"profile_info\"><img src='" . getInstructorImage($query->image) . "'   alt='" . $query->name . " image'></div>";
            })
            ->editColumn('name', function ($query) {
                return $query->name;
            })
            ->editColumn('email', function ($query) {
                return $query->email;
            })
            ->addColumn('group_policy', function ($query) {
                $policy = isModuleActive('OrgInstructorPolicy') ? $query->policy->name : '';

                return $policy;
            })
            ->addColumn('status', function ($query) {
                $checked = $query->status == 1 ? "checked" : "";
                $view = '<label class="switch_toggle" for="active_checkbox' . $query->id . '">
                            <input type="checkbox" class="status_enable_disable" id="active_checkbox' . $query->id . '" value="' . $query->id . '" ' . $checked . '>
                            <i class="slider round"></i>
                        </label>';

                return $view;


            })
            ->addColumn('tax', function ($query) {
                if (!empty($query->sst_registration_no)) {
                    return 'Taxable';
                } else {
                    return 'Non Taxable';
                }

            })
            ->addColumn('enabled_package', function($query) {
                $checked = $query->is_enabled_package == 1 ? "checked" : "";
                $view = '<label class="switch_toggle" for="active_checkbox' . $query->id . '">
                            <input type="checkbox" class="enabled_package" id="active_checkbox'.$query->id.'" value="'.$query->id.'" data-id="'.$query->id.'" data-enabled-package="'.$query->is_enabled_package.'" '.$checked.'>
                            <i class="slider round"></i>
                        </label>';

                return $view;
            })
            ->addColumn('action', function ($query) {
                $instructor_edit    = "";
                $instructor_delete  = "";

                if (permissionCheck('instructor.edit')) {
                    $instructor_edit = '  <button data-item-id =\'' . $query->id . '\' class="dropdown-item edit_cp" type="button">' . trans('common.Edit') . '</button>';
                }

                if (permissionCheck('instructor.delete')) {
                    $instructor_delete = '<button class="dropdown-item deleteInstructor" data-id="' . $query->id . '" type="button">' . trans('common.Delete') . '</button>';
                }

                $actioinView = ' <div class="dropdown CRM_dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        ' . trans('common.Action') . '
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
                                        ' . $instructor_edit . '
                                    </div>
                                </div>';

                return $actioinView;
            })
            ->rawColumns(['image', 'action', 'enabled_package'])
            ->make(true);
    }


    public function update(Request $request)
    {
        Session::flash('type', 'update');

        if (demoCheck()) {
            return redirect()->back();
        }
        // $rules = [
        //     'name' => 'required',
        //     'phone' => 'nullable|string|regex:/^([0-9\s\-\+\(\)]*)$/|min:1|unique:users,phone,' . $request->id,
        //     'email' => 'required|email|unique:users,email,' . $request->id,
        //     'password' => 'bail|nullable|min:8|confirmed',

        // ];

        // $this->validate($request, $rules, validationMessage($rules));
        try {

            if (Config::get('app.app_sync')) {
                Toastr::error('For demo version you can not change this !', 'Failed');
                return back();
            } else {

                $user = User::find($request->id);

                if($user){
                    // $user->name = $request->name;
                    // $user->email = $request->email;
                    // $user->username = null;
                    $user->facebook = $request->facebook;
                    $user->twitter = $request->twitter;
                    $user->linkedin = $request->linkedin;
                    $user->instagram = $request->instagram;
                    $user->about = $request->about;
                    $user->dob = $request->dob;
                    // if (empty($request->phone)) {
                    //     $user->phone = null;
                    // } else {
                    //     $user->phone = $request->phone;
                    // }
                    // if ($request->password)
                    //     $user->password = bcrypt($request->password);

                    $fileName = "";
                    if ($request->file('image') != "") {
                        $file = $request->file('image');
                        $fileName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
                        $file->move('uploads/instructors/', $fileName);
                        $fileName = 'uploads/instructors/' . $fileName;
                        $user->image = $fileName;
                    }

                    // $user->role_id = 7;
                    $user->save();
                }
            }

            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->back();

        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }


    public function destroy(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }

        $rules = [
            'id' => 'required'
        ];

        $this->validate($request, $rules, validationMessage($rules));

        try {

            if (Config::get('app.app_sync')) {
                Toastr::error('For demo version you can not change this !', 'Failed');
                return redirect()->back();
            } else {
                $success = trans('Content Provider') . ' ' . trans('lang.Updated') . ' ' . trans('lang.Successfully');

                $user = User::with('courses')->findOrFail($request->id);
                if (count($user->courses) > 0) {
                    Toastr::error($user->name . ' has course. Please remove it first', 'Failed');
                    return back();
                }
                $user->delete();

            }
            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->back();

        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function change_enabled_package_status(Request $request) {
        if (appMode()) {
            return response()->json(['warning' => trans('common.For the demo version, you cannot change this')], 200);
        }
        if (!Auth::check()) {
            return response()->json(['error' => 'Permission Denied'], 403);
        }
        if (Auth::user()->role_id == 3) {
            return response()->json(['error' => 'Permission Denied'], 403);
        }

        try {
            $user = User::where('id', $request->partner_id)->where('is_enabled_package', $request->enabled_package)->first();

            if ($user) {
                $update_enable_package_status = ($user->is_enabled_package == 1) ? 0 : 1;
                $user->is_enabled_package = $update_enable_package_status;

                if ($user->save()) {
                    $response['status'] = true;
                    $response['message'] = trans('common.Status has been changed');
                } else {
                    $response['status'] = false;
                    $response['message'] = trans('common.Something went wrong') . '!';
                }
            } else {
                $response['status'] = false;
                $response['message'] = trans('CP not found!');
            }

            return response()->json($response);
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();
            \Log::error($errorMessage);

            $response['status'] = false;
            $response['message'] = $e->getMessage();

            return response()->json($response);
        }
    }
}
