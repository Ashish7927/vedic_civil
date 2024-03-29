<?php

namespace Modules\RolePermission\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\RolePermission\Entities\Permission;
use Modules\RolePermission\Entities\Role;
use Modules\RolePermission\Http\Requests\RoleFormRequest;
use Modules\RolePermission\Repositories\RoleRepository;

class RoleController extends Controller
{

    public $roleRepository;
    public function __construct(RoleRepository $roleRepository)
    {
        $this->middleware(['auth']);
        $this->roleRepository = $roleRepository;
    }

    public function index()
    {

        if(isModuleActive('HumanResource')){
            $data['RoleList'] = $this->roleRepository->all();
            return view('rolepermission::index', $data);
        }else{
            $PermissionList = Permission::where('status', 1)->where('backend', 1)->where('is_corporate', 0)->get();
            $role = Role::with('permissions')->find(2);
            $data['role'] = $role;
            $data['MainMenuList'] = $PermissionList->where('type', 1);
            $data['SubMenuList'] = $PermissionList->where('type', 2);
            $data['ActionList'] = $PermissionList->where('type', 3);
            $data['PermissionList'] = $PermissionList;
            return view('rolepermission::permission', $data);
        }


    }
    public function contentproviderrole()
    {

        if(isModuleActive('HumanResource')){
            $data['RoleList'] = $this->roleRepository->all();
            return view('rolepermission::index', $data);
        }else{
            $PermissionList = Permission::where('status', 1)->where('backend', 1)->where('is_corporate', 0)->get();
            $role = Role::with('permissions')->find(7);
            $data['role'] = $role;
            $data['MainMenuList'] = $PermissionList->where('type', 1);
            $data['SubMenuList'] = $PermissionList->where('type', 2);
            $data['ActionList'] = $PermissionList->where('type', 3);
            $data['PermissionList'] = $PermissionList;
            return view('rolepermission::permission', $data);
        }


    }

    public function partnerrole()
    {
        if(isModuleActive('HumanResource')){
            $data['RoleList'] = $this->roleRepository->all();
            return view('rolepermission::index', $data);
        }else{
            $PermissionList = Permission::where('status', 1)->where('backend', 1)->where('is_corporate', 0)->get();
            $role = Role::with('permissions')->find(8);
            $data['role'] = $role;
            $data['MainMenuList'] = $PermissionList->where('type', 1);
            $data['SubMenuList'] = $PermissionList->where('type', 2);
            $data['ActionList'] = $PermissionList->where('type', 3);
            $data['PermissionList'] = $PermissionList;
            return view('rolepermission::permission', $data);
        }
    }

    public function studentIndex()
    {

        $PermissionList = Permission::where('status', 1)->where('backend', 0)->where('is_corporate', 0)->get();
        $role = Role::with('permissions')->find(3);
        $data['role'] = $role;
        $data['MainMenuList'] = $PermissionList->where('type', 1);
        $data['SubMenuList'] = $PermissionList->where('type', 2);
        $data['ActionList'] = $PermissionList->where('type', 3);
        $data['PermissionList'] = $PermissionList;
        return view('rolepermission::permission', $data);

    }

    public function trainerIndex()
    {
        $PermissionList = Permission::where('status', 1)->where('backend', 1)->where('is_corporate', 0)->get();
        $role = Role::with('permissions')->find(14);
        $data['role'] = $role;
        $data['MainMenuList'] = $PermissionList->where('type', 1);
        $data['SubMenuList'] = $PermissionList->where('type', 2);
        $data['ActionList'] = $PermissionList->where('type', 3);
        $data['PermissionList'] = $PermissionList;
        return view('rolepermission::permission', $data);
    }

    public function staffIndex()
    {

        $PermissionList = Permission::where('status', 1)->where('backend', 1)->where('is_corporate', 0)->get();
        $role = Role::with('permissions')->find(4);
        $data['role'] = $role;
        $data['MainMenuList'] = $PermissionList->where('type', 1);
        $data['SubMenuList'] = $PermissionList->where('type', 2);
        $data['ActionList'] = $PermissionList->where('type', 3);
        $data['PermissionList'] = $PermissionList;
        return view('rolepermission::permission', $data);

    }

    public function create()
    {
        return view('rolepermission::create');
    }

    public function store(RoleFormRequest $request)
    {
        try {
            $this->roleRepository->create($request->except("_token"));
            return redirect()->route('permission.roles.index');
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function show($id)
    {
        $PermissionList = Permission::where('status', 1)->where('backend', 1)->where('is_corporate', 0)->get();
        $role = Role::with('permissions')->find($id);
        $data['role'] = $role;
        $data['MainMenuList'] = $PermissionList->where('type', 1);
        $data['SubMenuList'] = $PermissionList->where('type', 2);
        $data['ActionList'] = $PermissionList->where('type', 3);
        $data['PermissionList'] = $PermissionList;
        return view('rolepermission::permission', $data);
    }


    public function edit(Role $role)
    {
        try {
            $RoleList = $this->roleRepository->all();
            return view('rolepermission::role', compact('RoleList', 'role'));
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function update(RoleFormRequest $request, $id)
    {
        try {
            $role = $this->roleRepository->update($request->except("_token"), $id);
            \LogActivity::successLog($request->name . '- has been updated.');
            return redirect()->back();
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function destroy($id)
    {
        try {
            $role = $this->roleRepository->delete($id);
            \LogActivity::successLog('A Role has been destroyed.');
            return redirect()->back();
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }
}
