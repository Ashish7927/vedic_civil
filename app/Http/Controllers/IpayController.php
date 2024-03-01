<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Log;
use Modules\CourseSetting\Entities\Course;
use Modules\Payment\Entities\Cart;
use Modules\Payment\Entities\Checkout;

class IpayController extends Controller
{
    public function __construct()
    {

    }

    public function ipay_page()
    {
        // dd(hash('sha256', 'appleM000032A00000001100MYR1'));
        return view('ipay');
    }

    public function ipay_response(Request $request)
    {
        try {
            Log::info('ipay response start');

            if ($request->MerchantCode == \Config::get('app.merchantcode') && $request->RefNo != "") {
                $checkout_info = Checkout::where('tracking', $request->Remark)->first();
                // $tracking = Cart::where('tracking', $request->Remark)->first();
                // $course = Course::where('id', $tracking->course_id)->first();
                
                $course_package_ids = explode(',', $checkout_info->course_package_ids);
                $course = Course::whereIn('id', $course_package_ids)->first();

                if ($checkout_info->status) {
                    /* HRDCorp email notification */
                    send_email_course_purchased('course_purchase', [
                        'name' => auth()->user()->name,
                        'course_title' => $course->title,
                        'price' => $checkout_info->price,
                        'purchased_date' => \Carbon\Carbon::parse(now())->format('d F Y')
                    ]);
                    /* End : HRDCorp email notification */
                    Toastr::success('Payment done successfully', 'Success');
                    return redirect(route('myCourses'));
                } else if ($request->Status == 1 && $checkout_info->status == 0) {
                    $payController = new PaymentController();
                    $payWithIpay = $payController->payWithGateWay($request->all(), "Ipay88");

                    Log::info($payWithIpay);

                    if ($payWithIpay) {
                        echo "RECEIVEOK";
                        /* HRDCorp email notification */
                        send_email_course_purchased('course_purchase', [
                            'name' => auth()->user()->name,
                            'course_title' => $course->title,
                            'price' => $checkout_info->price,
                            'purchased_date' => \Carbon\Carbon::parse(now())->format('d F Y')
                        ]);
                            /* End : HRDCorp email notification */
                        Toastr::success('Payment done successfully', 'Success');
                        return redirect(route('myCourses'));
                    } else {
                        Toastr::error($request->ErrDesc, 'Error');
                        return redirect(route('CheckOut'));
                    }
                } else {
                    Toastr::error('Payment is unsuccessful');
                    return redirect()->route('CheckOut');
                }
            } else {
                Toastr::error('Transaction is declined');
                return redirect()->route('CheckOut');
            }
        } catch (\Exception $e){
            Log::info($e->getMessage());
        }
    }

    public function ipay_backend(Request $request)
    {
        try {
            Log::info('ipay backend start');

            if ($request->MerchantCode == \Config::get('app.merchantcode') && $request->RefNo != "" && $request->Remark != "") {
                if ($request->Status == 1) {
                    $payController = new PaymentController();
                    $checkout_info = Checkout::where('tracking', $request->Remark)->first();

                    if ($checkout_info->status != 1) {
                        $user = User::find($checkout_info->user_id);

                        if ($user) {
                            $payWithIpay = $payController->payWithGateWay($request->all(), "Ipay88", $user, $checkout_info->id);

                            Log::info($payWithIpay);

                            if ($payWithIpay) {
                                echo "RECEIVEOK";
                            }
                        } else {
                            Log::info('IpayController: User not found.');

                            Toastr::error('User not found.');
                            return redirect()->route('CheckOut');
                        }
                    } else {
                        Log::info('IpayController: Already checkouted.');

                        Toastr::success('Payment done successfully', 'Success');
                        return redirect(route('myCourses'));
                    }
                } else {
                    Log::info('IpayController: Response Status is not 1.');

                    Toastr::error('Response Status is not 1.');
                    return redirect()->route('CheckOut');
                }
            }
        } catch (\Exception $e) {
            Log::info($e->getMessage());

            Toastr::error($e->getMessage());
            return redirect()->route('CheckOut');
        }
    }

    function iPay88_signature($source)
    {
        return hash('sha256', $source);
    }
}
