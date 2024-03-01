<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Group;
use Yajra\DataTables\DataTables;
use Brian2694\Toastr\Facades\Toastr;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.group.index');
    }

    public function group_list_data(Request $request)
    {

        $query = Group::query();
        return Datatables::of($query)
            ->addIndexColumn()
            ->editColumn('course_type', function ($query) {
                $course_type_original = $query->course_type;
                $course_type = '';
                if($course_type_original == 1)
                    $course_type = 'Micro-credential';
                if($course_type_original == 2)
                    $course_type = 'Claimable';
                if($course_type_original == 3)
                    $course_type = 'Other';
                if($course_type_original == 4)
                    $course_type = 'e-Learning';
                return $course_type;
            })
            ->addColumn('action', function ($query) {

                if (permissionCheck('group')) {
                    $deleteUrl = route('admin.group_delete', $query->id);
                    $course_delete = '<a onclick="confirm_modal(\'' . $deleteUrl . '\')" class="dropdown-item edit_brand">' . trans('common.Delete') . '</a>';
                } else {
                    $course_delete = "";
                }

                if (permissionCheck('group')) {

                    $course_edit = ' <a class="dropdown-item edit_group" data-id="' . $query->id . '" href="javascript:;">' . trans('common.Edit') . '</a>';
                } else {
                    $course_edit = "";
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

                                        ' . $course_edit . '
                                        ' . $course_delete . '

                                    </div>
                                </div>';

                return $actioinView;

            })
            ->rawColumns(['action'])->make(true);
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
        $rules = [
            'name' => 'required',
            'course_type' => 'required',
            // 'description' => 'required'
        ];

        $messages = [
            'required' => 'The :attribute field is required.'
        ];

        $validator = $this->validate($request, $rules, validationMessage($rules));
        // dd($validate->errors);
        try {
            if($request->id == ""){
                $group_data = new Group();
                $group_data->created_by = auth()->user()->id;
            }
            else{
                $group_data = Group::find($request->id);
            }
            if(isset($group_data)){
                $group_data->name = $request->name;
                $group_data->course_type = $request->course_type;
                $group_data->description = $request->description;
                $group_data->save();

                Toastr::success(trans('common.Operation successful'), trans('common.Success'));
                return redirect()->back();
                // return response()->json(['status' => 1, 'data' => $group_data]);
            }
            // return response()->json(['status' => 0, 'message' => 'Data not created!!']);
            Toastr::error('Data not created!!', 'Failed');
            return redirect()->back();
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Group::find($id);
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
        $data = Group::find($id);
        if($data){
            $data->delete();
            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->back();
        }
        Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
        return redirect()->back();
    }
}
