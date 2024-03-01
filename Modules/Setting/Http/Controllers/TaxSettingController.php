<?php

namespace Modules\Setting\Http\Controllers;

use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Modules\Setting\Entities\TaxSetting;
use Yajra\DataTables\Facades\DataTables;

class TaxSettingController extends Controller
{
    public function index() {
        if (demoCheck('For the demo version, You can not view error logs')) {
            return redirect()->back();
        }
        return view('setting::tax_setting');
    }

    public function getAllData(Request $request) {
        $query = TaxSetting::latest();

          return Datatables::of($query)
              ->addIndexColumn()
              ->editColumn('created_at', function ($query) {
                  return $query->created_at->diffForHumans();
              })
              ->editColumn('status', function($query) {
                  $checked = $query->status == 1 ? "checked" : "";
                  $view = '<label class="switch_toggle" for="active_checkbox' . $query->id . '">
                                <input type="checkbox" class="tax_setting_switch" id="active_checkbox' . $query->id . '" data-id="'.$query->id.'" value="' . $query->status . '" ' . $checked . '>
                                <i class="slider round"></i>
                            </label>';
                  return $view;
              })
              ->addColumn('action', function ($query) {
                  $delete_tax_setting = '<button class="dropdown-item deleteTaxSetting" data-id="' . $query->id . '" type="button">' . trans('common.Delete') . '</button>';
                  $edit_tax_setting = '<a class="dropdown-item edit_brand" href="'.route('setting.tax_setting.edit', $query->id).'">'.trans('common.Edit').'</a>';
                  $actioinView = '<div class="dropdown CRM_dropdown">
                                      <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                          ' . trans('common.Action') . '
                                      </button>
                                      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
                                          ' . $edit_tax_setting . '
                                          ' . $delete_tax_setting . '
                                      </div>
                                  </div>';

                  return $actioinView;
              })->rawColumns(['status', 'action'])->make(true);
    }

    public function create() {
        if (demoCheck('For the demo version, You can not view error logs')) {
            return redirect()->back();
        }
        return view('setting::add_tax_setting');
    }

    public function store(Request $request) {
        if (demoCheck()) {
            return redirect()->back();
        }

        $rules = [
            'name' => 'required',
            'value' => 'required'
        ];

        $this->validate($request, $rules, validationMessage($rules));

        try {
          if ($request->id != '') {
            $taxsetting = TaxSetting::find($request->id);
          } else {
            $taxsetting = new TaxSetting();
          }

          $taxsetting->name = $request->name;
          $taxsetting->value = $request->value;
          $taxsetting->save();

          if ($request->id != '') {
              $message = trans('tax.Update Success');
          } else {
            $message = trans('tax.Add Success');
          }

          Toastr::success($message, trans('common.Success'));
          return redirect()->to(route("setting.tax_setting"));
        } catch (\Exception $e) {
          GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function edit($id) {
        try {
            $edit = TaxSetting::find($id);
            return view('setting::tax_setting', compact('edit'));
        } catch (\Exception $e) {
            return response()->json(['error' => trans("lang.Oops, Something Went Wrong")]);
        }
    }

    public function destroy(Request $request) {
        if (demoCheck()) {
            return redirect()->back();
        }
        $rules = [
            'id' => 'required'
        ];

        $this->validate($request, $rules, validationMessage($rules));

        try {
            $success = trans('lang.Deleted') . ' ' . trans('lang.Successfully');

            $user = TaxSetting::findOrFail($request->id);
            $user->delete();

            Toastr::success($success, 'Success');
            return redirect()->back();

        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function change_status(Request $request) {
        if (demoCheck()) {
            return redirect()->back();
        }
        $rules = [
            'id' => 'required',
            'status' => 'required'
        ];

        $this->validate($request, $rules, validationMessage($rules));

        try {
            $response = [];
            $user = TaxSetting::find($request->id);

            if ($user) {
                $user->status = ($request->status == 0) ? 1 : 0;
                $user->save();

                $response['status'] = true;
                $response['message'] = trans('common.Status has been changed');
            } else {
                $response['status'] = false;
                $response['message'] = trans('common.Something went wrong') . '!';
            }
            
            return response()->json($response);
          } catch (\Exception $e) {
              $response['status'] = false;
              $response['message'] = $e->getMessage();

              return response()->json($response);
        }
    }
}