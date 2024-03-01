<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Subscribe;
use App\Traits\ImageStore;
use App\Traits\SendMail;
use App\Traits\SendSMS;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Modules\SystemSetting\Entities\Page;
use App\Models\PasswordReset;
use App\User;

use App\Events\OneToOneConnection;
use DrewM\MailChimp\MailChimp;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;

use Modules\Setting\Model\GeneralSetting;

use Yajra\DataTables\Facades\DataTables;
use Modules\Newsletter\Http\Controllers\AcelleController;
use Modules\Group\Entities\GroupMember;
use Modules\Group\Repositories\GroupRepository;

class ResetpasswordController extends Controller
{
    use SendSMS, SendMail;

     public function index()
    {
        try {
            $resetpassword = [];
            return view('backend.resetpassword.index', compact('resetpassword'));

        } catch (\Exception $e) {
            Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
            return redirect()->back();
        }
    }
    public function getalllistresetpassword(Request $request){
        $query = User::where('role_id','3')->orderBy('id', 'desc');
        return Datatables::of($query)
            ->addIndexColumn()->editColumn('email', function ($query) {
                return $query->email;
            })->editColumn('created_at', function ($query) {
                return $query->created_at;
            })->addColumn('sendsuccessfully', function ($query) {
                $email = $query->email;
                 $checkemail = PasswordReset::where('email',$email)->count();
                 if($checkemail=='1'){
                    $msg = 'Success' ;
                 }else{
                    $msg ='Pending' ;
                 }
                 return $msg;
            })->rawColumns(['sendsuccessfully'])
            ->make(true);
    }   
}

