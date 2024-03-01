<?php

namespace Modules\FrontendManage\Http\Controllers;

use App\Models\smeCourseSetup;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class SmeCoursesController extends Controller
{

    public function index()
    {
        $sme_setup = smeCourseSetup::first();
        return view('frontendmanage::sme_courses.index', compact('sme_setup'));
    }

    public function store(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        try {
            $setup = smeCourseSetup::firstOrCreate(['id' => 1]);
            $setup->is_enabled = $request->is_sme_courses_enabled;
            $setup->save();
            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->back();
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }
}
