<?php

namespace Modules\Rolemanage\Http\Controllers;

use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Modules\Rolemanage\Entities\Role;

class RolemanageController extends Controller
{
    public function index()
    {
         try {
            $user = Auth::user();
            $query = Role::with('user')->where('id','!=',1)->where('id','!=',3);

            $roles = $query->latest()->get();

            return view('rolemanage::index', compact('roles'));

        } catch (\Exception $e) {

            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('rolemanage::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
       if (demoCheck()) {
            return redirect()->back();
        }
        $rules = [
            'name' => 'required|unique:roles,name'
        ];
    
        $this->validate($request, $rules, validationMessage($rules));

        try {
            $role = new role;
            $role->name = $request->name;
            $role->save();

            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->back();
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());

        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('rolemanage::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('rolemanage::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request)
    {
        $rules = [
            'name' => 'required|unique:roles,name,' . $request->id
        ];
        $this->validate($request, $rules, validationMessage($rules));


        try {
            $role = Role::find($request->id);
            $role->name = $request->name;
            $role->save();
            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->back();

        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());

        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Request $request)
    {

        try {
            $role = Role::findOrFail($request->id);
            $role->delete();

            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->back();
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());

        }
    }
}
