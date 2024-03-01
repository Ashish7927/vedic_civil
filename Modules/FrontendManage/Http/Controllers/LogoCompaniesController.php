<?php

namespace Modules\FrontendManage\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\ImageStore;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Modules\FrontendManage\Entities\FrontPage;
use Illuminate\Support\Facades\DB;

class LogoCompaniesController extends Controller
{
    use ImageStore;

    public function index() 
    {
        $data['companies'] = DB::table('companies')
        //->where('show_log_in_front', '1')
        ->orderBy('show_log_in_front', 'asc')
        ->get();
        //$data['companies'] = FrontPage::where('is_static', '=', '0')->latest()->get();
        return view('frontendmanage::logo_companies.index', $data);
    }


    // public function create()
    // {
    //     return view('frontendmanage::logo_companies.create');
    // }

    // public function store(Request $request)
    // {

    //     if (demoCheck()) {
    //         return redirect()->back();
    //     }
    //     $rules = [
    //         'title' => 'required',
    //         'details' => 'required',
    //     ];
    //     $this->validate($request, $rules, validationMessage($rules));

    //     try {

    //         $data = [
    //             'name' => $request->title,
    //             'title' => $request->title,
    //             'slug' => $this->createSlug(empty($request->slug) ? $request->title : $request->slug),
    //             'sub_title' => $request->sub_title,
    //             'details' => $request->details,
    //             'is_static' => 0,
    //         ];
    //         $frontpage = FrontPage::create($data);

    //         if ($request->banner != null) {

    //             if ($request->file('banner')->extension() == "svg") {
    //                 $file = $request->file('banner');
    //                 $fileName = md5(rand(0, 9999) . '_' . time()) . '.' . $file->clientExtension();
    //                 $url1 = 'uploads/settings/' . $fileName;
    //                 $file->move(public_path('uploads/settings'), $fileName);
    //             } else {
    //                 $url1 = $this->saveImage($request->banner);
    //             }
    //             $frontpage->banner = $url1;
    //             $frontpage->is_static = 0;
    //             $frontpage->save();
    //         }

    //         Toastr::success(trans('common.Operation successful'), trans('common.Success'));
    //         return redirect()->route('frontend.page.index');
    //     } catch (Exception $e) {

    //         GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
    //     }
    // }


    public function show($id)
    {
        return view('frontendmanage::logo_companies.show');
    }


    public function edit($id)
    {
        $data['editData'] = DB::table('companies')
        ->where('id', $id)
        ->first();
        // $data['editData'] = FrontPage::findOrFail($id);
        return view('frontendmanage::logo_companies.create', $data);

    }

    public function update(Request $request, $id)
    {
        
        if (demoCheck()) {
            return redirect()->back();
        }
        $page = DB::table('companies')
        ->where('id', $id)
        ->first();
        try {

            DB::table('companies') ->where('id', $id) ->limit(1) ->update( [ 'show_log_in_front' => $request->show_log_in_front ]); 
            // //echo $request->show_log_in_front; die;
            // $page->show_log_in_front = $request->show_log_in_front;
            
            // $page->save();

            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->route('frontend.logo-companies.index');
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }


    }

 

}
