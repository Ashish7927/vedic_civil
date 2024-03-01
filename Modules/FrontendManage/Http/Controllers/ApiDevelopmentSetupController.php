<?php

namespace Modules\FrontendManage\Http\Controllers;

use App\Models\ApiDevelopmentSetup;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ApiDevelopmentSetupController extends Controller
{
    public function index()
    {
        $course_api_development_setup = ApiDevelopmentSetup::first();
        return view('frontendmanage::courseApiDevelopment.index', compact('course_api_development_setup'));
    }

    public function store(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        try {
            $setup = ApiDevelopmentSetup::firstOrCreate(['id' => 1]);
            $setup->is_enabled = $request->is_api_development_courses_enabled;
            $setup->save();
            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->back();
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }
}
