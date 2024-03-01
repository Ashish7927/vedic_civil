<?php

namespace Modules\OfflinePayment\Http\Controllers;

use App\DepositRecord;
use App\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\OfflinePayment\Entities\OfflinePayment;
use Yajra\DataTables\Facades\DataTables;

class OfflinePaymentController extends Controller
{

public function offlinePaymentView()
{
    return view('offlinepayment::fund.add_fund');
}

    /* 24-2-2022 : New */
    public function getInstructorData()
    {
        $table_data = User::with('offlinePayments', 'currency')->where('role_id', 2);
        
        return Datatables::of($table_data)
            ->editColumn('wallet', function ($query) {
                $wallet_data = getPriceFormat($query->balance);
                return $wallet_data;
            })
            ->editColumn('image', function ($query) {
                $img_src = '';
                if($query->image){
                    $img_src = asset($query->image);
                }
                else{
                    $img_src = asset('frontend/img/client_img.png');
                }
                $html = '<div class="profile_info">
                            <img alt="' . $query->name . '" src="' . $img_src . '" class="add_fund_profile_img">
                        </div>';
                return $html;
            })
            ->addColumn('action', function ($query) {
                $actioinView = '';

                $actioinView = ' <div class="dropdown CRM_dropdown">
                        <button class="btn btn-secondary dropdown-toggle"
                                type="button" id="dropdownMenu2' . $query->id . '"
                                data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                            ' . __('common.Action') . '
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">';

                if(permissionCheck('offlinePayment.add')){
                    $actioinView .= '<a class="dropdown-item" data-toggle="modal" data-target="#AddFund' . $query->id . '" href="#">' . __('common.Add') . '</a>';
                }
                if(permissionCheck('offlinePayment.fund-history')){
                    $route = route('fundHistory',$query->id);
                    $actioinView .= '<a class="dropdown-item" href="' . $route . '"> ' . __('payment.Fund History') . ' </a>';
                }
                return $actioinView;
            })
            ->rawColumns(['wallet', 'image', 'action'])
            ->make(true);
    }

    public function getStudentData()
    {
        $table_data = User::with('offlinePayments', 'currency')->where('role_id', 3);
        
        return Datatables::of($table_data)
            ->editColumn('wallet', function ($query) {
                $wallet_data = getPriceFormat($query->balance);
                return $wallet_data;
            })
            ->editColumn('image', function ($query) {
                $img_src = '';
                if($query->image){
                    $img_src = asset($query->image);
                }
                else{
                    $img_src = asset('frontend/img/client_img.png');
                }
                $html = '<div class="profile_info">
                            <img alt="' . $query->name . '" src="' . $img_src . '" class="add_fund_profile_img">
                        </div>';
                return $html;
            })
            ->addColumn('action', function ($query) {
                $actioinView = '';

                $actioinView = ' <div class="dropdown CRM_dropdown">
                        <button class="btn btn-secondary dropdown-toggle"
                                type="button" id="dropdownMenu2' . $query->id . '"
                                data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                            ' . __('common.Action') . '
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">';

                if(permissionCheck('offlinePayment.add')){
                    $actioinView .= '<a class="dropdown-item" data-toggle="modal" data-target="#AddFund' . $query->id . '" href="#">' . __('common.Add') . '</a>';
                }
                if(permissionCheck('offlinePayment.fund-history')){
                    $route = route('fundHistory',$query->id);
                    $actioinView .= '<a class="dropdown-item" href="' . $route . '"> ' . __('payment.Fund History') . ' </a>';
                }
                return $actioinView;
            })
            ->rawColumns(['wallet', 'image', 'action'])
            ->make(true);
    }
    /* 24-2-2022 */

    public function FundHistory($id)
    {

        try {
            $user = User::with('currency')->where('id', $id)->first();
            $payments = OfflinePayment::latest()->where('user_id', $id)->with('user.role')->get();

            return view('offlinepayment::fund.funding_history', compact('payments', 'user'));
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function addBalance(Request $request)
    {

        $request->validate([
            'user_id' => 'required',
            'amount' => 'required',
        ]);

        try {

            $user = User::where('id', $request->user_id)->first();
            $tran = new OfflinePayment();
            $new = $user->balance + $request->amount;
            $tran->user_id = $user->id;
            $tran->role_id = $user->role_id;
            $tran->amount = $request->amount;
            $tran->status = 1;
            $tran->after_bal = $new;
            $tran->save();
            $user->balance = $new;
            $user->save();

            $depositRecord = new DepositRecord();
            $depositRecord->user_id = $user->id;
            $depositRecord->method = 'Offline Payment';
            $depositRecord->amount = $request->amount;
            $depositRecord->save();
            if ($user->role_id == 3) {
                $isStudent = true;
            } else {
                $isStudent = false;
            }

            if (UserEmailNotificationSetup('OffLine_Payment', $user)) {
                send_email($user, $type = 'OffLine_Payment', $shortcodes = [
                    'amount' => $request->amount,
                    'currency' => Settings('currency_code'),
                    'time' => now()->format(Settings('active_date_format') . ' H:i:s A'),
                ]);
            }
            if (UserBrowserNotificationSetup('OffLine_Payment', $user)) {

                send_browser_notification($user, $type = 'OffLine_Payment', $shortcodes = [
                    'amount' => $request->amount,
                    'currency' => Settings('currency_code'),
                    'time' => now()->format(Settings('active_date_format') . ' H:i:s A'),
                ],
                    '',//actionText
                    ''//actionUrl
                );
            }
            Toastr::success(trans('common.Fund Added'), trans('common.Success'));
            return back()->with('isStudent', $isStudent);
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }

    }


    public function index()
    {
        return view('offlinepayment::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('offlinepayment::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('offlinepayment::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('offlinepayment::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}