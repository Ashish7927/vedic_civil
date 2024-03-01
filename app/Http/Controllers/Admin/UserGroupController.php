<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Group;
use App\Models\UserGroup;
use Yajra\DataTables\DataTables;
use Brian2694\Toastr\Facades\Toastr;

class UserGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.group.group_user_list');
    }

    public function user_group_list_data(Request $request)
    {
        $query = UserGroup::query();
        return Datatables::of($query)
            ->addIndexColumn()
            ->editColumn('user', function ($query) {
                return $query->user->name;
            })
            ->editColumn('group', function ($query) {
                return $query->group->name;
            })
            ->addColumn('action', function ($query) {

                if (permissionCheck('group.usergroup')) {
                    $deleteUrl = route('admin.user_group_delete', $query->id);
                    $user_group_delete = '<a onclick="confirm_modal(\'' . $deleteUrl . '\')" class="dropdown-item edit_brand">' . trans('common.Delete') . '</a>';
                } else {
                    $user_group_delete = "";
                }

                if (permissionCheck('group.usergroup')) {

                    $user_group_edit = ' <a class="dropdown-item edit_group" data-id="' . $query->id . '" href="javascript:;">' . trans('common.Edit') . '</a>';
                } else {
                    $user_group_edit = "";
                }

                $actioinView = '<div class="dropdown CRM_dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button"
                                            id="dropdownMenu2" data-toggle="dropdown"
                                            aria-haspopup="true"
                                            aria-expanded="false">
                                        ' . trans('common.Action') . '
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right"
                                         aria-labelledby="dropdownMenu2">

                                        ' . $user_group_edit . '
                                        ' . $user_group_delete . '

                                    </div>
                                </div>';

                return $actioinView;

            })
            ->rawColumns(['action'])->make(true);
    }

    public function get_user_data_using_ajax(Request $request)
    {
        if ($request->ajax()) {

            $term = trim($request->term);

            $ids = UserGroup::pluck('user_id')->toArray();

            $posts = User::select('id','name as text')
                // ->where('role_id',3)
                ->whereNotIn('id', $ids)
                ->where('name', 'LIKE',  '%' . $term. '%')
                ->whereIn('role_id', [1, 5, 6])
                ->simplePaginate(10);

            $morePages=true;
            $pagination_obj= json_encode($posts);
            if (empty($posts->nextPageUrl())){
                $morePages=false;
            }
            $results = array(
                "results" => $posts->items(),
                "pagination" => array(
                    "more" => $morePages
                )
            );

            return \Response::json($results);
        }
        else{
            $ids = UserGroup::pluck('user_id')->toArray();
            $users = User::where('role_id',3)->whereNotIn('id', $ids)->get();

            if(isset($users) && count($users)>0)
                return response()->json(['status' => 1, 'data' => $users]);
            else
                return response()->json(['status' => 0, 'message' => 'Data not found!!']);
        }
    }

    public function get_group_data_using_ajax(Request $request)
    {
        if ($request->ajax()) {

            $term = trim($request->term);

            $ids = UserGroup::pluck('user_id')->toArray();

            $posts = Group::select('id','name as text')
                ->where('name', 'LIKE',  '%' . $term. '%')
                ->simplePaginate(10);

            $morePages=true;
            $pagination_obj= json_encode($posts);
            if (empty($posts->nextPageUrl())){
                $morePages=false;
            }
            $results = array(
                "results" => $posts->items(),
                "pagination" => array(
                    "more" => $morePages
                )
            );

            return \Response::json($results);
        }
        else{
            $groups = Group::all();
            if(count($groups)>0)
                return response()->json(['status' => 1, 'data' => $groups]);
            else
                return response()->json(['status' => 0, 'message' => 'Data not found!!']);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->id == ""){
            $group_data = new UserGroup();
        }
        else{
            $group_data = UserGroup::find($request->id);
        }
        if(isset($group_data)){
            $group_data->user_id = $request->user_id;
            $group_data->group_id = $request->group_id;
            $group_data->save();
            return response()->json(['status' => 1, 'data' => $group_data]);
        }
        return response()->json(['status' => 0, 'message' => 'Data not created!!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = UserGroup::with('user', 'group')->find($id);
        if($data){
            return response()->json(['status' => 1, 'data' => $data]);
        }
        return response()->json(['status' => 0, 'message' => 'Data not found!!']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = UserGroup::find($id);
        if($data){
            $data->delete();
            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->back();
        }
        Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
        return redirect()->back();
    }
}
