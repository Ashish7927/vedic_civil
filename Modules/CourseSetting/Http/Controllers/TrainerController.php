<?php

namespace Modules\CourseSetting\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Brian2694\Toastr\Facades\Toastr;
use Yajra\DataTables\DataTables;
use Intervention\Image\Facades\Image;
use Exception;
use App\User;
use Hash;
use Auth;
use File;

class TrainerController extends Controller
{
    public function index() {
        try {
            return view('coursesetting::trainer.index');
        } catch (\Exception $e) {
            Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
            return redirect()->back();
        }
    }

    public function datatable() {
        $query = User::where('role_id', 14);

        if (check_whether_cp_or_not() || isPartner()) {
            $query = $query->where('cp_id', Auth::id());
        }

        return Datatables::of($query)
            ->addIndexColumn()
            ->addColumn('content_provider', function ($query) {
                return ($query->trainer_cp) ? $query->trainer_cp->name : '';
            })
            ->addColumn('status', function ($query) {
                $checked = ($query->status == 1) ? "checked" : "";

                $status = '<label class="switch_toggle" for="active_checkbox' . $query->id . '">
                            <input type="checkbox" class="status_enable_disable" id="active_checkbox' . $query->id . '" value="' . $query->id . '" ' . $checked . '>
                            <i class="slider round"></i>
                        </label>';

                return $status;
            })
            ->addColumn('action', function ($query) {
                $course_edit = "";

                if (permissionCheck('package.edit')) {
                    $course_edit = '<a href="'.route('trainers.edit', $query->id).'" class="dropdown-item">'. __('common.Edit') .'</a>';
                }

                $actioinView = '<div class="dropdown CRM_dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown"  aria-haspopup="true" aria-expanded="false">
                                    ' . trans('common.Action') . '
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
                                        ' . $course_edit . '
                                    </div>
                                </div>';

                return $actioinView;
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    public function create() {
        $cps = User::whereIn('role_id', [7, 8])->get();

        return view('coursesetting::trainer.create', compact('cps'));
    }

    public function store(Request $request) {
        $rules = [
            'name'          => "required",
            'email'         => "required",
            'country_code'  => "required",
            'address'       => "required",
        ];

        if (isAdmin()) {
            $rules['content_provider_id'] = "required";
        }

        if ($request->has('trainer_id')) {
            $rules['phone'] = 'nullable|string|regex:/^([0-9\s\-\+\(\)]*)$/|min:1|unique:users,phone,' . $request->trainer_id;
        } else {
            $rules['phone'] = 'nullable|string|regex:/^([0-9\s\-\+\(\)]*)$/|min:1|unique:users,phone';
        }

        if ($request->has('image')) {
            $rules['image'] = "required|mimes:jpeg,bmp,png,jpg|max:5120";
        }

        $this->validate($request, $rules, validationMessage($rules));

        try {
            if ($request->has('trainer_id') && $request->trainer_id != '') {
                $trainer = User::where('id', $request->trainer_id)->first();
            } else {
                $trainer = new User();
            }

            $trainerFolderPath = public_path('uploads/trainers/');

            if (!File::isDirectory($trainerFolderPath)) {
                File::makeDirectory($trainerFolderPath, 0777, true, true);
            }

            if ($image = $request->file('image')) {
                if ($trainer->image != '') {
                    $trainerImage = $trainer->image;

                    if (File::exists($trainerImage)) {
                        unlink($trainerImage);
                    }
                }

                $strpos = strpos($request->image, ';');
                $sub = substr($request->image, 0, $strpos);
                $name = md5($request->name . rand(0, 1000)).'.'.'png';
                $img = Image::make($request->image);
                $upload_path = 'uploads/trainers/';
                $img->save($upload_path . $name);
                $trainer->image = 'uploads/trainers/'. $name;
            }

            $trainer->name           = $request->name;
            $trainer->email          = $request->email;
            $trainer->country_code   = $request->country_code;
            $trainer->address        = $request->address;
            $trainer->phone          = $request->phone;
            $trainer->cp_id          = $request->content_provider_id;
            $trainer->role_id        = 14;

            if (!$request->has('trainer_id')) {
                $generated_password = base64_encode(random_bytes(6));

                $mail_val = [
                    'send_to_name'      => $request->name,
                    'send_to'           => $request->email,
                    'email_from'        => env('MAIL_FROM_ADDRESS'),
                    'email_from_name'   => env('MAIL_FROM_NAME'),
                    'subject'           => 'Credential Information'
                ];

                send_credential_info_email($mail_val, 'send_credential_info', [
                    'name'      => $request->name,
                    'username'  => $request->email,
                    'password'  => $generated_password,
                    'url'       => \Config::get('app.public_login_url')
                ]);

                $trainer->password = Hash::make($generated_password);
            }

            $trainer->save();

            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->route('trainers.index');
        } catch (\Exception $e) {
            Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
            return redirect()->back();
        }
    }

    public function edit($id) {
        $trainer    = User::where('id', $id)->first();
        $cps        = User::whereIn('role_id', [7, 8])->get();

        return view('coursesetting::trainer.create', compact('trainer', 'cps'));
    }
}
