<?php

namespace App\Http\Controllers;

use App\Models\EnrolledTotal;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Modules\BundleSubscription\Entities\BundleCoursePlan;
use Modules\BundleSubscription\Entities\BundleSetting;
use Modules\Group\Events\GroupMemberCreate;
use Omnipay\Omnipay;
use App\BillingDetails;
use Illuminate\Http\Request;
use DrewM\MailChimp\MailChimp;
use App\Events\OneToOneConnection;
use Illuminate\Support\Facades\DB;
use Modules\Payment\Entities\Cart;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Modules\Payment\Entities\Checkout;
use Illuminate\Support\Facades\Redirect;
use Modules\CourseSetting\Entities\Course;
use Modules\Coupons\Entities\UserWiseCoupon;
use Unicodeveloper\Paystack\Facades\Paystack;
use Bryceandy\Laravel_Pesapal\Facades\Pesapal;
use Modules\Payment\Entities\InstructorPayout;
use Modules\CourseSetting\Entities\Notification;
use App\Library\SslCommerz\SslCommerzNotification;
use Modules\CourseSetting\Entities\CourseEnrolled;
use Modules\Coupons\Entities\UserWiseCouponSetting;
use Modules\Paytm\Http\Controllers\PaytmController;
use Modules\Payeer\Http\Controllers\PayeerController;
use Modules\Wallet\Http\Controllers\WalletController;
use Modules\Midtrans\Http\Controllers\MidtransController;
use Modules\Mobilpay\Http\Controllers\MobilpayController;
use Modules\Newsletter\Http\Controllers\AcelleController;
use Modules\Razorpay\Http\Controllers\RazorpayController;
use Modules\Instamojo\Http\Controllers\InstamojoController;
use App\Models\HrdcPayout;
use Modules\Setting\Entities\TaxSetting;
use PDF;

class PaymentController extends Controller
{
    public $payPalGateway;

    public function __construct()
    {
        $this->middleware('maintenanceMode');

        $this->payPalGateway = Omnipay::create('PayPal_Rest');
        $this->payPalGateway->setClientId(env('PAYPAL_CLIENT_ID'));
        $this->payPalGateway->setSecret(env('PAYPAL_CLIENT_SECRET'));
        $this->payPalGateway->setTestMode(env('IS_PAYPAL_LOCALHOST')); //set it to 'false' when go live
    }


    public function makePlaceOrder(Request $request)
    {
        // Session::put('checkbox',1);
        Session::put('checkbox_1', 1);
        $data = $request->validate([
            // 'checkbox' => 'required',
            'checkbox_1' => 'required',
        ], [
            // 'checkbox.required' => 'Please agree to continue to place an order.',
            'checkbox_1.required' => 'Please agree to continue to place an order.',
        ]);
        $carts = Cart::where('user_id', Auth::id())->count();
        if ($carts == 0) {
            return redirect('/');
        }

        $rules = [
            'old_billing' => 'required_if:billing_address,previous',
            'first_name' => 'required_if:billing_address,new',
            'last_name' => 'required_if:billing_address,new',
            'country' => 'required_if:billing_address,new',
            'address1' => 'required_if:billing_address,new',
            'city' => 'required_if:billing_address,new',
            'city_text' => 'required_if:billing_address,new',
            'phone' => 'required_if:billing_address,new',
            'email' => 'required_if:billing_address,new',
        ];
        $this->validate($request, $rules, validationMessage($rules));
        // Session::put('checkbox','');
        Session::put('checkbox_1', '');


        if ($request->billing_address == 'new') {
            $bill = BillingDetails::where('tracking_id', $request->tracking_id)->first();

            if (empty($bill)) {
                $bill = new BillingDetails();
            }

            $bill->user_id = Auth::id();
            $bill->tracking_id = $request->tracking_id;
            $bill->first_name = $request->first_name;
            $bill->last_name = $request->last_name;
            $bill->company_name = $request->company_name;
            $bill->country = $request->country;
            $bill->address1 = $request->address1;
            $bill->address2 = $request->address2;
            $bill->city = $request->city;
            $bill->city_text = $request->city_text;
            $bill->zip_code = $request->zip_code;
            $bill->phone = $request->phone;
            $bill->email = $request->email;
            // $bill->details = $request->details;
            $bill->payment_method = null;
            $bill->save();
        } else {

            $bill = BillingDetails::where('id', $request->old_billing)->first();
            if ($request->previous_address_edit == 1) {
                $bill->user_id = Auth::id();
                $bill->tracking_id = $request->tracking_id;
                $bill->first_name = $request->first_name;
                $bill->last_name = $request->last_name;
                $bill->company_name = $request->company_name;
                $bill->country = $request->country;
                $bill->address1 = $request->address1;
                $bill->address2 = $request->address2;
                $bill->city = $request->city;
                $bill->city_text = $request->city_text;
                $bill->zip_code = $request->zip_code;
                $bill->phone = $request->phone;
                $bill->email = $request->email;
                // $bill->details = $request->details;
                $bill->payment_method = null;
                $bill->save();
            }
        }


        $tracking = Cart::where('user_id', Auth::id())->first()->tracking;
        $checkout_info = Checkout::where('tracking', $tracking)->where('user_id', Auth::id())->latest()->first();
        $carts = Cart::where('tracking', $checkout_info->tracking)->get();

        if ($checkout_info) {
            $taxes = TaxSetting::where('status', 1)->get();
            $taxAmt = 0;
            $taxArr = [];

            foreach ($taxes as $key => $tax) {
                $taxValue = ($checkout_info->price / 100) * $tax->value;
                $taxAmt += $taxValue;

                $taxArr[$key]['id'] = $tax->id;
                $taxArr[$key]['name'] = $tax->name;
                $taxArr[$key]['value'] = $tax->value;
                $taxArr[$key]['tax'] = number_format($taxValue, 2);
            }

            $checkout_info->billing_detail_id = $bill->id;
            $checkout_info->purchase_price = $request->payable_amt;
            $checkout_info->total_tax = number_format($taxAmt, 2);
            $checkout_info->tax_json = json_encode($taxArr);

            $unique_id      = $checkout_info->id + 1000000;
            $first_number   = substr($unique_id, 0, 1);
            $unique_number  = ($first_number > 1) ? $unique_id - 1000000 : substr($unique_id, 1);

            $checkout_info->receipt_no = 'OR/PSMB-'.date('Y').'-'.$unique_number;
            $checkout_info->invoice_no = 'TI/PSMB-'.date('Y').'-'.$unique_number;
            $checkout_info->save();

            if ($checkout_info->purchase_price == 0) {
                $checkout_info->payment_method = 'None';
                $bill->payment_method = 'None';
                $checkout_info->save();
                // foreach ($carts as $cart) {
                    $this->directEnroll('', $checkout_info->tracking);
                //     $cart->delete();
                // }

                Toastr::success('Checkout Successfully Done', 'Success');
                return redirect(route('studentDashboard'));
            } else {
                return redirect()->route('orderPayment');
            }
        } else {
            Toastr::error("Something Went Wrong", 'Failed');
            return \redirect()->back();
        }
        //        payment method start skip for now


    }


    public function payment()
    {
        try {
            $carts = Cart::where('user_id', Auth::id())->count();
            if ($carts == 0) {
                return redirect('/');
            }
            return view(theme('pages.payment'));
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function paymentSubmit(Request $request)
    {

        $checkout_info = Checkout::where('id', $request->id)->where('tracking', $request->tracking_id)->with('user')->first();
        if (!empty($checkout_info)) {
            if ($request->payment_method == "Sslcommerz") {


                $post_data = array();
                $post_data['total_amount'] = $checkout_info->purchase_price; # You cant not pay less than 10
                $post_data['currency'] = Settings('currency_code') ?? 'USD';
                $post_data['tran_id'] = uniqid(); // tran_id must be unique

                # CUSTOMER INFORMATION
                $post_data['cus_name'] = $request->first_name ?? 'Customer Name';
                $post_data['cus_email'] = $request->email ?? 'customer@mail.com';
                $post_data['cus_add1'] = $request->address1 ?? 'Customer Address';
                $post_data['cus_add2'] = $request->address2 ?? '';
                $post_data['cus_city'] = $request->city ?? 'Dhaka';
                $post_data['cus_state'] = "";
                $post_data['cus_postcode'] = $request->zip_code ?? '';
                $post_data['cus_country'] = $request->country ?? '';
                $post_data['cus_phone'] = $request->phone ?? '8801XXXXXXXXX';
                $post_data['cus_fax'] = "";


                # SHIPMENT INFORMATION
                $post_data['ship_name'] = "Store Test";
                $post_data['ship_add1'] = "Dhaka";
                $post_data['ship_add2'] = "Dhaka";
                $post_data['ship_city'] = "Dhaka";
                $post_data['ship_state'] = "Dhaka";
                $post_data['ship_postcode'] = "1000";
                $post_data['ship_phone'] = "";
                $post_data['ship_country'] = "Bangladesh";

                $post_data['shipping_method'] = "NO";
                $post_data['product_name'] = "Computer";
                $post_data['product_category'] = "Goods";
                $post_data['product_profile'] = "physical-goods";

                # OPTIONAL PARAMETERS
                $post_data['value_a'] = $checkout_info->id;
                $post_data['value_b'] = $checkout_info->tracking;
                $post_data['value_c'] = "ref003";
                $post_data['value_d'] = "ref004";


                #Before  going to initiate the payment order status need to update as Pending.
                $update_product = DB::table('orders')
                    ->where('transaction_id', $post_data['tran_id'])
                    ->updateOrInsert([
                        'user_id' => $checkout_info->user->id,
                        'tracking' => $checkout_info->tracking,
                        'name' => $post_data['cus_name'] ?? '',
                        'email' => $post_data['cus_email'] ?? '',
                        'phone' => $post_data['cus_phone'] ?? '',
                        'amount' => $post_data['total_amount'] ?? '',
                        'status' => 'Pending',
                        'address' => $post_data['cus_add1'] ?? '',
                        'transaction_id' => $post_data['tran_id'],
                        'currency' => $post_data['currency']
                    ]);
                $sslc = new SslCommerzNotification();
                # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
                $payment_options = $sslc->makePayment($post_data, 'checkout', 'json');
                $payment_options = \GuzzleHttp\json_decode($payment_options);

                if ($payment_options->status == "success") {
                    return Redirect::to($payment_options->data);
                } else {
                    Toastr::error('Something went wrong', 'Failed');
                    return Redirect::back();
                }
            } elseif ($request->payment_method == "PayPal") {

                try {
                    $response = $this->payPalGateway->purchase(array(
                        'amount' => convertCurrency(Settings('currency_code') ?? 'BDT', Settings('currency_code'), $checkout_info->purchase_price),
                        'currency' => Settings('currency_code'),
                        'returnUrl' => route('paypalSuccess'),
                        'cancelUrl' => route('paypalFailed'),

                    ))->send();

                    if ($response->isRedirect()) {
                        $response->redirect(); // this will automatically forward the customer
                    } else {
                        Toastr::error($response->getMessage(), trans('common.Failed'));
                        return \redirect()->back();
                    }
                } catch (\Exception $e) {
                    GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
                }
            } elseif ($request->payment_method == "Payeer") {


                try {
                    $payeer = new PayeerController();
                    $request->merge(['type' => 'Payment']);
                    $request->merge(['amount' => $checkout_info->purchase_price]);
                    $response = $payeer->makePayment($request);

                    if ($response) {
                        return \redirect()->to($response);
                    } else {
                        Toastr::error('Something went wrong', 'Failed');
                        return \redirect()->back();
                    }
                } catch (\Exception $e) {
                    GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
                }
            } elseif ($request->payment_method == "Midtrans") {

                try {
                    $midtrans = new MidtransController();
                    $request->merge(['type' => 'Payment']);
                    $request->merge(['amount' => $checkout_info->purchase_price]);
                    $response = $midtrans->makePayment($request);

                    if ($response) {
                        return $response;
                    } else {
                        Toastr::error('Something went wrong', 'Failed');
                        return \redirect()->back();
                    }
                } catch (\Exception $e) {
                    GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
                }
            } elseif ($request->payment_method == "Instamojo") {

                $amount = convertCurrency(Settings('currency_code') ?? 'BDT', 'INR', $checkout_info->purchase_price);
                $instamojo = new InstamojoController();
                $response = $instamojo->paymentProcess($amount);
                if ($response) {
                    return \redirect()->to($response);
                } else {
                    Toastr::error('Something went wrong', 'Failed');
                    return \redirect()->back();
                }
            } elseif ($request->payment_method == "Mobilpay") {

                $amount = convertCurrency(Settings('currency_code') ?? Settings('currency_code'), 'RON', $checkout_info->purchase_price);
                $mobilpay = new MobilpayController();
                $mobilpay->paymentProcess($amount);
            } elseif ($request->payment_method == "Stripe") {

                $request->validate([
                    'stripeToken' => 'required'
                ]);
                $token = $request->stripeToken ?? '';
                $gatewayStripe = Omnipay::create('Stripe');
                $gatewayStripe->setApiKey(env('STRIPE_SECRET'));

                //            $formData = array('number' => '4242424242424242', 'expiryMonth' => '6', 'expiryYear' => '2030', 'cvv' => '123');
                $response = $gatewayStripe->purchase(array(
                    'amount' => convertCurrency(Settings('currency_code') ?? 'BDT', Settings('currency_code'), $checkout_info->purchase_price),
                    'currency' => Settings('currency_code'),
                    'token' => $token,
                ))->send();

                if ($response->isRedirect()) {
                    // redirect to offsite payment gateway
                    $response->redirect();
                } elseif ($response->isSuccessful()) {
                    // payment was successful: update database

                    $payWithStripe = $this->payWithGateWay($response->getData(), "Stripe");
                    if ($payWithStripe) {
                        Toastr::success('Payment done successfully', 'Success');
                        return redirect(route('studentDashboard'));
                    } else {
                        Toastr::error('Something Went Wrong', 'Error');
                        return \redirect()->back();
                    }
                } else {

                    if ($response->getCode() == "amount_too_small") {
                        $amount = round(convertCurrency(Settings('currency_code'), strtoupper(Settings('currency_code') ?? 'BDT'), 0.5));
                        $message = "Amount must be at least " . Settings('currency_symbol') . ' ' . $amount;
                        Toastr::error($message, 'Error');
                    } else {
                        Toastr::error($response->getMessage(), 'Error');
                    }
                    return redirect()->back();
                }
            } //payment getway
            elseif ($request->payment_method == "RazorPay") {

                if (empty($request->razorpay_payment_id)) {
                    Toastr::error('Something Went Wrong', 'Error');
                    return \redirect()->back();
                }

                $payment = new RazorpayController();
                $response = $payment->payment($request->razorpay_payment_id);

                if ($response['type'] == "error") {
                    Toastr::error($response['message'], 'Error');
                    return \redirect()->back();
                }

                $payWithRazorPay = $this->payWithGateWay($response['response'], "RazorPay");

                if ($payWithRazorPay) {
                    Toastr::success('Payment done successfully', 'Success');
                    return redirect(route('studentDashboard'));
                } else {
                    Toastr::error('Something Went Wrong', 'Error');
                    return \redirect()->back();
                }
            } //payment getway
            elseif ($request->payment_method == "PayTM") {


                $userData = [
                    'user' => $checkout_info['tracking'],
                    'mobile' => $checkout_info->billing->phone,
                    'email' => $checkout_info->billing->email,
                    'amount' => convertCurrency(Settings('currency_code') ?? 'BDT', 'INR', $checkout_info->purchase_price),
                    'order' => $checkout_info->billing->phone . "_" . rand(1, 1000),
                ];

                $payment = new PaytmController();
                return $payment->payment($userData);
            } //payment getway


            elseif ($request->payment_method == "PayStack") {

                try {
                    return Paystack::getAuthorizationUrl()->redirectNow();
                } catch (\Exception $e) {
                    GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
                }
            } elseif ($request->payment_method == "Pesapal") {

                try {
                    $paymentData = [
                        'amount' => $checkout_info->purchase_price,
                        'currency' => Settings('currency_code'),
                        'description' => 'Payment',
                        'type' => 'MERCHANT',
                        'reference' => 'Payment|' . $checkout_info->purchase_price,
                        'first_name' => Auth::user()->first_name,
                        'last_name' => Auth::user()->last_name,
                        'email' => Auth::user()->email,
                    ];

                    $iframe_src = Pesapal::getIframeSource($paymentData);

                    return view('laravel_pesapal::iframe', compact('iframe_src'));
                } catch (\Exception $e) {
                    GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
                }
            } //payment getway

            elseif ($request->payment_method == "Wallet") {


                $payment = new WalletController();
                $response = $payment->payment($request);

                if ($response['type'] == "error") {
                    Toastr::error($response['message'], 'Error');
                    return \redirect()->back();
                }

                $payWithWallet = $this->payWithGateWay($response['response'], "Wallet");

                if ($payWithWallet) {
                    Toastr::success('Payment done successfully', 'Success');
                    return redirect(route('studentDashboard'));
                } else {
                    Toastr::error('Something Went Wrong', 'Error');
                    return \redirect()->back();
                }
            } elseif ($request->payment_method == "Ipay88") {
                $refno = random_no_for_ipay88_refno();
                $product_des = $request->product_des;
                $phone = (auth()->user()->phone) ? auth()->user()->phone : '';
                $signature = signature_for_ipay88(\Config::get('app.merchantkey'), \Config::get('app.merchantcode'), $refno, $checkout_info->purchase_price, "MYR");
                $html = '<form id="payment_form" method="post" name="ePayment" action="' . \Config::get('app.ipay_url') . '">
              <input type="hidden" name="MerchantCode" value="' . \Config::get('app.merchantcode') . '">
              <input type="hidden" name="PaymentId" value="">
              <input type="hidden" name="RefNo" value="' . $refno . '">
              <input type="hidden" name="Amount" value="' . $checkout_info->purchase_price . '">
              <input type="hidden" name="Currency" value="MYR">
              <input type="hidden" name="ProdDesc" value="' . "HRD Corp e-LATiH: " . $product_des . '">
              <input type="hidden" name="UserName" value="' . auth()->user()->name . '">
              <input type="hidden" name="UserEmail" value="' . auth()->user()->email . '">
              <input type="hidden" name="UserContact" value="' . $phone . '">
              <input type="hidden" name="Remark" value="' . $checkout_info->tracking . '">
              <input type="hidden" name="SignatureType" value="SHA256">
              <input type="hidden" name="Signature" value="' . $signature . '">
              <input type="hidden" name="ResponseURL" value="' . route('ipay_response') . '" />
              <input type="hidden" name="BackendURL" value="' . route('ipay_backend') . '">
              </form><script>document.getElementById("payment_form").submit();</script>';
                return $html;
            }
        } else {
            Toastr::error('Something went wrong', 'Failed');
            return Redirect::back();
        }
    }


    public function directEnroll($id, $tracking = null)
    {
        try {
            $success = trans('lang.Enrolled') . ' ' . trans('lang.Successfully');
            /*     $course = Course::find($id);
             $user = Auth::user();


             $enrolled = $course->total_enrolled;
             $course->total_enrolled = ($enrolled + 1);

             $enroll = new CourseEnrolled();
             $instractor = User::find($course->user_id);
             $enroll->user_id = $user->id;
             $enroll->course_id = $course->id;
             $enroll->purchase_price = $course->price;
             $enroll->coupon = null;
             $enroll->discount_amount = 0.00;
             if (!empty($tracking))
                 $enroll->tracking = $tracking;
             $enroll->status = 1;

             if (!is_null($course->special_commission)) {
                 $commission = $course->special_commission;
                 $reveune = ($course->price * $commission) / 100;
                 $enroll->reveune = $reveune;
             } elseif (!is_null($instractor->special_commission)) {
                 $commission = $instractor->special_commission;
                 $reveune = ($course->price * $commission) / 100;
                 $enroll->reveune = $reveune;
             } else {
                 $commission = Settings('commission');
                 $reveune = ($course->price * $commission) / 100;
                 $enroll->reveune = $reveune;
             }
             if (isModuleActive('Subscription')) {
                 if (isSubscribe()) {
                     $enroll->subscription = 1;

                     $enroll->subscription_validity_date = $user->subscription_validity_date;
                 }
             }



             if (UserEmailNotificationSetup('Course_Enroll_Payment',$course->user)) {
                  send_email($course->user, 'Course_Enroll_Payment', [
                     'time' => Carbon::now()->format('d-M-Y ,s:i A'),
                     'course' => $course->title,
                     'price' => 0,
                     'currency' => '',
                     'instructor' => $course->user->name,
                     'gateway' => 'None',
                 ]);
             }
             if (UserBrowserNotificationSetup('Course_Enroll_Payment',$course->user)) {

                  send_browser_notification($course->user, $type = 'Course_Enroll_Payment', $shortcodes = [
                     'time' => Carbon::now()->format('d-M-Y ,s:i A'),
                     'course' => $course->title,
                     'price' => 0,
                     'currency' => '',
                     'instructor' => $course->user->name,
                     'gateway' => 'None',
                 ],
                 '',//actionText
                 ''//actionUrl
                 );
             }


              if (UserEmailNotificationSetup('Enroll_notify_Instructor',$course->user)) {
                 send_email($course->user, 'Enroll_notify_Instructor', [
                     'time' => Carbon::now()->format('d-M-Y ,s:i A'),
                     'course' => $course->title,
                     'price' => 0,
                     'rev' => 0,
                     'currency' => '',
                 ]);
             }
             if (UserBrowserNotificationSetup('Enroll_notify_Instructor',$course->user)) {

                  send_browser_notification($course->user, $type = 'Enroll_notify_Instructor', $shortcodes = [
                     'time' => Carbon::now()->format('d-M-Y ,s:i A'),
                     'course' => $course->title,
                     'price' => 0,
                     'rev' => 0,
                     'currency' => '',
                 ],
                 '',//actionText
                 ''//actionUrl
                 );
             }


             $enroll->save();
             if (isModuleActive('Group')) {
                 if ($course->isGroupCourse) {
                     Event::dispatch(new GroupMemberCreate($course->id, $user->id));
                 }
             }


             $course->reveune = (($course->reveune) + ($enroll->reveune));
             $course->save();

             if ($instractor->subscription_api_status == 1) {
                 try {
                     if ($instractor->subscription_method == "Mailchimp") {
                         $list = $course->subscription_list;
                         $MailChimp = new MailChimp($instractor->subscription_api_key);
                         $MailChimp->post("lists/$list/members", [
                             'email_address' => Auth::user()->email,
                             'status' => 'subscribed',
                         ]);

                     } elseif ($instractor->subscription_method == "GetResponse") {

                         $list = $course->subscription_list;
                         $getResponse = new \GetResponse($instractor->subscription_api_key);
                         $getResponse->addContact(array(
                             'email' => Auth::user()->email,
                             'campaign' => array('campaignId' => $list),

                         ));
                     }
                 } catch (\Exception $exception) {

                 }
             }

             if (isModuleActive('Chat')) {
                 event(new OneToOneConnection($instractor, $user, $course));
             }*/
            $user = Auth::user();
            $this->payWithGateway([], 'None', $user);
            return response()->json([
                'success' => $success
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => trans("lang.Operation Failed")]);
        }
    }


    public function paypalSuccess(Request $request)
    {

        // Once the transaction has been approved, we need to complete it.
        if ($request->input('paymentId') && $request->input('PayerID')) {
            $transaction = $this->payPalGateway->completePurchase(array(
                'payer_id' => $request->input('PayerID'),
                'transactionReference' => $request->input('paymentId'),
            ));
            $response = $transaction->send();

            if ($response->isSuccessful()) {
                // The customer has successfully paid.
                $arr_body = $response->getData();
                $payWithPapal = $this->payWithGateWay($arr_body, "PayPal");
                if ($payWithPapal) {
                    Toastr::success('Payment done successfully', 'Success');
                    return redirect(route('studentDashboard'));
                } else {
                    Toastr::error('Something Went Wrong', 'Error');
                    return redirect(route('studentDashboard'));
                }
            } else {
                $msg = str_replace("'", " ", $response->getMessage());
                Toastr::error($msg, 'Failed');
                return redirect()->back();
            }
        } else {
            Toastr::error('Transaction is declined');
            return redirect()->back();
        }
    }

    public function paypalFailed()
    {
        Toastr::error('User is canceled the payment.', 'Failed');
        return redirect()->back();
    }

    public function payWithGateWay($response, $gateWayName, $user_id = null, $check_id = null)
    {
        try {
            $user = ($user_id) ? User::find($user_id->id) : Auth::user();

            if (!$user) {
                Toastr::error('User Not Exists', 'Error');
                return false;
            }

            $checkout_info = ($check_id != null) ? Checkout::find($check_id) : Checkout::where('user_id', $user->id)->latest()->first();

            if (!isset($checkout_info)) {
                Toastr::error('Checkout Not Found', 'Error');
                return false;
            }

            $discount = $checkout_info->discount;

            $courseType = collect();
            $renew = 'new';
            $bundleId = 0;
            $carts = Cart::where('user_id', $user->id)->get();

            foreach ($carts as $cartKey => $cart) {
                if ($cart->course_id != 0) {
                    $courseType->single = 1;

                    $course = Course::find($cart->course_id);
                    $enrolled = $course->total_enrolled;
                    $course->total_enrolled = ($enrolled + 1);

                    //==========================Start Referral========================
                    $purchase_history = CourseEnrolled::where('user_id', $user->id)->first();
                    $referral_check = UserWiseCoupon::where('invite_accept_by', $user->id)->where('category_id', null)->where('course_id', null)->first();
                    $referral_settings = UserWiseCouponSetting::where('role_id', $user->role_id)->first();

                    if ($purchase_history == null && $referral_check != null) {
                        $referral_check->category_id = $course->category_id;
                        $referral_check->subcategory_id = $course->subcategory_id;
                        $referral_check->course_id = $course->id;
                        $percentage_cal = ($referral_settings->amount / 100) * $checkout_info->price;

                        if ($referral_settings->type == 1) {
                            if ($checkout_info->price > $referral_settings->max_limit) {
                                $bonus_amount = $referral_settings->max_limit;
                            } else {
                                $bonus_amount = $referral_settings->amount;
                            }
                        } else {
                            if ($percentage_cal > $referral_settings->max_limit) {
                                $bonus_amount = $referral_settings->max_limit;
                            } else {
                                $bonus_amount = $percentage_cal;
                            }
                        }

                        $referral_check->bonus_amount = $bonus_amount;

                        $invite_by = User::find($referral_check->invite_by);
                        $invite_by->balance += $bonus_amount;

                        $invite_accept_by = User::find($referral_check->invite_accept_by);
                        $invite_accept_by->balance += $bonus_amount;
                    }
                    //==========================End Referral========================

                    if ($discount != 0 || !empty($discount)) {
                        $itemPrice = $cart->price - ($discount / count($carts));
                        $discount_amount = $cart->price - $itemPrice;
                    } else {
                        $itemPrice = $cart->price;
                        $discount_amount = 0.00;
                    }

                    $taxSetting = TaxSetting::first();
                    $tax_price = $taxSetting ? ($itemPrice * $taxSetting->value / 100) : 0;

                    $enroll = new CourseEnrolled();
                    $instructor = User::find($cart->instructor_id);
                    $enroll->user_id = $user->id;
                    $enroll->tracking = $checkout_info->tracking;
                    $enroll->course_id = $course->id;
                    $enroll->purchase_price = $itemPrice;
                    $enroll->tax_price = $tax_price;
                    $enroll->coupon = null;
                    $enroll->discount_amount = $discount_amount;
                    $enroll->status = 0;

                    // if (!isset($enroll_total)) $enroll_total = get_enroll_total($course->user_id);
                    // $enroll_total->amount += $itemPrice;
                    // $enroll_total->tax_amount += $tax_price;

                    $enroll_total = new EnrolledTotal();
                    $enroll_total->instructor_id = $course->user_id;
                    $enroll_total->tracking = $checkout_info->tracking;
                    $enroll_total->amount = $itemPrice;
                    $enroll_total->tax_amount = $tax_price;

                    if (check_if_instructor_cp_or_partner($course->user_id)) {
                        $commission = get_instructor_commission();
                        $revenue = ($itemPrice * $commission) / 100;
                        $enroll->reveune = $revenue;
                    } else {
                        $commission = Settings('commission');
                        $revenue = ($itemPrice * $commission) / 100;
                        $enroll->reveune = $revenue;
                    }

                    $payout = new InstructorPayout();
                    $payout->instructor_id = $course->user_id;
                    $payout->reveune = $revenue;
                    $payout->status = 0;

                    $enroll_total->instructor_amount = $revenue;

                    $instructor_total = get_instructor_total_payout($course->user_id);
                    $instructor_total->amount += $revenue;

                    if (isModuleActive('Group')) {
                        if ($course->isGroupCourse) {
                            Event::dispatch(new GroupMemberCreate($course->id, $user->id));
                        }
                    }

                    $course->reveune += $enroll->reveune;

                    Log::info("start figure hrdc commission");
                    if (!is_null($course->hrdc_commission) && $course->hrdc_commission != 0) {
                        $hrdccommission = $course->hrdc_commission;
                        $hrdc_reveune = ($itemPrice * $hrdccommission) / 100;
                    } elseif (!is_null($instructor->hrdc_commission) && $instructor->hrdc_commission != 0) {
                        $hrdccommission = $instructor->hrdc_commission;
                        $hrdc_reveune = ($itemPrice * $hrdccommission) / 100;
                    } else {
                        $hrdccommission = Settings('hrdc_commission');
                        $hrdc_reveune = ($itemPrice * $hrdccommission) / 100;
                    }

                    // $myll_commission = 100 - ($commission + $hrdccommission);
                    $myll_commission = Settings('commission');
                    $myll_reveune = ($itemPrice * $myll_commission) / 100;

                    $enroll->hrdc_reveune = $hrdc_reveune;
                    $enroll->myll_revenue = $myll_reveune;

                    $enroll_total->hrdc_amount = $hrdc_reveune;
                    $enroll_total->myll_amount = $myll_reveune;
                    $enroll_total->user_id = $user->id;
                    $enroll_total->course_package_type = 1;
                    $enroll_total->course_package_id = $course->id;

                    $hrdc_payout = new HrdcPayout();
                    $hrdc_payout->instructor_id = $course->user_id;
                    $hrdc_payout->hrdc_reveune = $hrdc_reveune;
                    $hrdc_payout->myll_reveune = $myll_reveune;
                    $hrdc_payout->status = 0;

                    $hrdc_total_payout = get_hrdc_total_payout($course->user_id);
                    $hrdc_total_payout->hrdc_amount += $hrdc_reveune;

                    /* learner receipt */
                    $taxes = TaxSetting::where('status', 1)->get();

                    $mail_val = [
                        'send_to_name' => $user->name,
                        'send_to' => $user->email,
                        'email_from' => env('MAIL_FROM_ADDRESS'),
                        'email_from_name' => env('MAIL_FROM_NAME'),
                        'subject' => 'Payment Done',
                    ];
                    send_email_learner_receipt($mail_val, 'user_payment_receipt', [
                        'date' => \Carbon\Carbon::parse(now())->format('d M Y'),
                        'pay_method' => $checkout_info->payment_method,
                        'status' => 'Paid',
                        'bill_to_name' => $user->name,
                        'bill_to_phone' => $user->phone,
                        'cource_details' => html_table_for_learner_receipt($itemPrice, $cart, $taxes)
                    ]);
                    /* End : learner receipt */

                    /* cp receipt */
                    $taxes = TaxSetting::where('status', 1)->get();

                    $mail_val = [
                        'send_to_name' => $course->user->name,
                        'send_to' => $course->user->email,
                        'email_from' => env('MAIL_FROM_ADDRESS'),
                        'email_from_name' => env('MAIL_FROM_NAME'),
                        'subject' => 'Payment Done',
                    ];
                    send_email_learner_receipt($mail_val, 'content_provider_receipt', [
                        'date' => \Carbon\Carbon::parse(now())->format('d M Y'),
                        'bill_to_name' => $user->name,
                        'transaction_id' => $cart->tracking,
                        'cource_details' => html_table_for_cp_receipt($itemPrice, $cart,$taxes)
                    ]);
                    /* End : cp receipt */

                    if (isModuleActive('Chat')) {
                        event(new OneToOneConnection($instructor, $user, $course));
                    }

                    if (UserEmailNotificationSetup('Course_Enroll_Payment', $checkout_info->user)) {
                        send_email($checkout_info->user, 'Course_Enroll_Payment', [
                            'time' => \Illuminate\Support\Carbon::now()->format('d-M-Y ,s:i A'),
                            'course' => $course->title,
                            'currency' => $checkout_info->user->currency->symbol ?? '$',
                            'price' => ($checkout_info->user->currency->conversion_rate * $itemPrice),
                            'instructor' => $course->user->name,
                            'gateway' => $gateWayName,
                            'name' => $user->name,
                            'email' => $user->email,
                        ]);
                    }

                    if (UserBrowserNotificationSetup('Course_Enroll_Payment', $checkout_info->user)) {
                        send_browser_notification(
                            $checkout_info->user,
                            $type = 'Course_Enroll_Payment',
                            $shortcodes = [
                                'time' => \Illuminate\Support\Carbon::now()->format('d-M-Y ,s:i A'),
                                'course' => $course->title,
                                'currency' => $checkout_info->user->currency->symbol ?? '$',
                                'price' => ($checkout_info->user->currency->conversion_rate * $itemPrice),
                                'instructor' => $course->user->name,
                                'gateway' => $gateWayName,
                            ],
                            '', //actionText
                            '' //actionUrl
                        );
                    }

                    if (UserEmailNotificationSetup('Enroll_notify_Instructor', $instructor)) {
                        send_email($instructor, 'Enroll_notify_Instructor', [
                            'time' => Carbon::now()->format('d-M-Y ,s:i A'),
                            'course' => $course->title,
                            'currency' => $instructor->currency->symbol ?? '$',
                            'price' => ($instructor->currency->conversion_rate * $itemPrice),
                            'rev' => @$revenue,
                        ]);
                    }

                    if (UserBrowserNotificationSetup('Enroll_notify_Instructor', $instructor)) {
                        send_browser_notification(
                            $instructor,
                            $type = 'Enroll_notify_Instructor',
                            $shortcodes = [
                                'time' => Carbon::now()->format('d-M-Y ,s:i A'),
                                'course' => $course->title,
                                'currency' => $instructor->currency->symbol ?? '$',
                                'price' => ($instructor->currency->conversion_rate * $itemPrice),
                                'rev' => @$revenue,
                            ],
                            '', //actionText
                            '' //actionUrl
                        );
                    }

                    // start email subscription
                    Log::info("start email subscription");
                    if ($instructor->subscription_api_status == 1) {
                        try {
                            if ($instructor->subscription_method == "Mailchimp") {
                                $list = $course->subscription_list;
                                $MailChimp = new MailChimp($instructor->subscription_api_key);
                                $MailChimp->post("lists/$list/members", [
                                    'email_address' => $user->email,
                                    'status' => 'subscribed',
                                ]);
                            } elseif ($instructor->subscription_method == "GetResponse") {
                                $list = $course->subscription_list;
                                $getResponse = new \GetResponse($instructor->subscription_api_key);
                                $getResponse->addContact(array(
                                    'email' => $user->email,
                                    'campaign' => array('campaignId' => $list),
                                ));
                            } elseif ($instructor->subscription_method == "Acelle") {
                                $list = $course->subscription_list;
                                $email = $user->email;
                                $make_action_url = '/subscribers?list_uid=' . $list . '&EMAIL=' . $email;
                                $acelleController = new AcelleController();
                                $response = $acelleController->curlPostRequest($make_action_url);
                            }
                        } catch (\Exception $exception) {
                            Log::info($exception->getMessage());
                            GettingError($exception->getMessage(), url()->current(), request()->ip(), request()->userAgent(), true);
                        }
                    }
                } else {
                    $bundleCheck = BundleCoursePlan::find($cart->bundle_course_id);

                    $totalCount = count($bundleCheck->course);
                    $price = $bundleCheck->price;
                    if ($price != 0) $price = $price / $totalCount;

                    $courseType->bundle = 1;
                    if ($cart->renew != 1) {
                        foreach ($bundleCheck->course as $course) {
                            $enrolled = $course->course->total_enrolled;
                            $course->course->total_enrolled = ($enrolled + 1);

                            $taxSetting = TaxSetting::first();
                            $tax_price = $taxSetting ? ($price * $taxSetting->value / 100) : 0;

                            Log::info("start create enroll 2");
                            if (!isset($enroll_total)) $enroll_total = get_enroll_total($cart->instructor_id);

                            $enroll = new CourseEnrolled();
                            $instructor = User::find($cart->instructor_id);
                            $enroll->user_id = $user->id;
                            $enroll->tracking = $checkout_info->tracking;
                            $enroll->course_id = $course->course->id;
                            $enroll->purchase_price = $price;
                            $enroll->tax_price = $tax_price;
                            $enroll->coupon = null;
                            $enroll->discount_amount = 0;
                            $enroll->status = 1;
                            $enroll->bundle_course_id = $cart->bundle_course_id;
                            $enroll->bundle_course_validity = $cart->bundle_course_validity;

                            $enroll_total->amount += $price;
                            $enroll_total->tax_amount += $tax_price;

                            save_or_fail($enroll);
                            save_or_fail($enroll_total);
                            save_or_fail($course->course);
                        }
                    } else {
                        $enrollBundleCourse = CourseEnrolled::where('bundle_course_id', $cart->bundle_course_id)->where('user_id', Auth::id())->get();
                        foreach ($enrollBundleCourse as $enroll) {
                            $instructor = User::find($cart->user_id);
                            $enroll->bundle_course_id = $cart->bundle_course_id;
                            $enroll->bundle_course_validity = $cart->bundle_course_validity;
                            save_or_fail($enroll);
                        }
                        $bundleId = $cart->bundle_course_id;
                        $renew = 1;
                    }

                    $bundleCommission = BundleSetting::getData();
                    if ($bundleCommission) {
                        $commission = $bundleCommission->commission_rate;
                        $revenue = ($bundleCheck->price * $commission) / 100;
                        $bundleCheck->reveune += $revenue;
                        $bundleCheck->student += 1;
                    }

                    $payout = new InstructorPayout();
                    $payout->instructor_id = $bundleCheck->user_id;
                    $payout->reveune = $revenue;
                    $payout->status = 0;

                    if (!isset($enroll_total)) $enroll_total = get_enroll_total($bundleCheck->user_id);
                    $enroll_total->instructor_amount += $revenue;

                    $instructor_total = get_instructor_total_payout($bundleCheck->user_id);
                    $instructor_total->amount += $revenue;

                    if (UserEmailNotificationSetup('Course_Enroll_Payment', $checkout_info->user)) {
                        send_email($checkout_info->user, 'Course_Enroll_Payment', [
                            'time' => \Illuminate\Support\Carbon::now()->format('d-M-Y ,s:i A'),
                            'course' => $bundleCheck->title,
                            'currency' => $checkout_info->user->currency->symbol ?? '$',
                            'price' => ($checkout_info->user->currency->conversion_rate * $bundleCheck->price),
                            'instructor' => $bundleCheck->user->name,
                            'gateway' => 'Sslcommerz',
                        ]);
                    }

                    if (UserBrowserNotificationSetup('Course_Enroll_Payment', $checkout_info->user)) {
                        send_browser_notification(
                            $checkout_info->user,
                            $type = 'Course_Enroll_Payment',
                            $shortcodes = [
                                'time' => \Illuminate\Support\Carbon::now()->format('d-M-Y ,s:i A'),
                                'course' => $bundleCheck->title,
                                'currency' => $checkout_info->user->currency->symbol ?? '$',
                                'price' => ($checkout_info->user->currency->conversion_rate * $bundleCheck->price),
                                'instructor' => $bundleCheck->user->name,
                                'gateway' => $gateWayName,
                            ],
                            '', // actionText
                            ''  // actionUrl
                        );
                    }

                    if (UserEmailNotificationSetup('Enroll_notify_Instructor', $instructor)) {
                        send_email($instructor, 'Enroll_notify_Instructor', [
                            'time' => Carbon::now()->format('d-M-Y ,s:i A'),
                            'course' => $bundleCheck->title,
                            'currency' => $instructor->currency->symbol ?? '$',
                            'price' => ($instructor->currency->conversion_rate * $bundleCheck->price),
                            'rev' => @$revenue,
                        ]);
                    }

                    if (UserBrowserNotificationSetup('Enroll_notify_Instructor', $instructor)) {
                        send_browser_notification(
                            $instructor,
                            $type = 'Enroll_notify_Instructor',
                            $shortcodes = [
                                'time' => Carbon::now()->format('d-M-Y ,s:i A'),
                                'course' => $bundleCheck->title,
                                'currency' => $instructor->currency->symbol ?? '$',
                                'price' => ($instructor->currency->conversion_rate * $bundleCheck->price),
                                'rev' => @$revenue,
                            ],
                            '', // actionText
                            ''  // actionUrl
                        );
                    }

                    if (isModuleActive('Chat')) {
                        event(new OneToOneConnection($instructor, $user, $course));
                    }

                    // start email subscription
                    if ($instructor->subscription_api_status == 1) {
                        try {
                            if ($instructor->subscription_method == "Mailchimp") {
                                $list = $course->subscription_list;
                                $MailChimp = new MailChimp($instructor->subscription_api_key);
                                $MailChimp->post("lists/$list/members", [
                                    'email_address' => Auth::user()->email,
                                    'status' => 'subscribed',
                                ]);
                            } elseif ($instructor->subscription_method == "GetResponse") {
                                $list = $course->subscription_list;
                                $getResponse = new \GetResponse($instructor->subscription_api_key);
                                $getResponse->addContact(array(
                                    'email' => Auth::user()->email,
                                    'campaign' => array('campaignId' => $list),
                                ));
                            }
                        } catch (\Exception $exception) {
                            GettingError($exception->getMessage(), url()->current(), request()->ip(), request()->userAgent(), true);
                        }
                    }
                }

                $checkout_info->payment_method = $gateWayName;
                $checkout_info->status = 1;
                $checkout_info->response = json_encode($response);

                if (isModuleActive('BundleSubscription')) {
                    $checkout_info->bundle_id = (int)$bundleId;
                    $checkout_info->renew = $renew;

                    if (isset($courseType->bundle) && $courseType->bundle == 1 && isset($courseType->single) && $courseType->single == 1) {
                        $checkout_info->course_type = 'multi';
                    } elseif (isset($courseType->single) && $courseType->single == 1) {
                        $checkout_info->course_type = 'single';
                    } else {
                        $checkout_info->course_type = 'bundle';
                    }
                }

                if (isset($referral_check)) save_or_fail($referral_check);
                if (isset($invite_by)) save_or_fail($invite_by);
                if (isset($invite_accept_by)) save_or_fail($invite_accept_by);
                if (isset($enroll)) save_or_fail($enroll);
                if (isset($enroll_total)) save_or_fail($enroll_total);
                if (isset($course)) save_or_fail($course);
                if (isset($course->course)) save_or_fail($course->course);
                if (isset($bundleCheck)) save_or_fail($bundleCheck);
                if (isset($checkout_info)) save_or_fail($checkout_info);
            }

            if ($checkout_info->user->status == 1) {
                foreach ($carts as $old) {
                    $old->delete();
                }
            }

            Toastr::success('Checkout Successfully Done', 'Success');
            return true;
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent(), true);
        }
    }

    public function receipt($id) {
        $checkout_info  = Checkout::findOrFail($id);
        $print_type     = 'receipt';
        $filename       = 'receipt-user.pdf';

        if (request()->segment(count(request()->segments())) == 'invoice') {
            $print_type = 'invoice';
            $filename   = 'tax-invoice.pdf';
        }

        $pdf = PDF::loadView('userReceipt', compact('checkout_info', 'print_type'));
        return $pdf->download($filename);
    }
}
