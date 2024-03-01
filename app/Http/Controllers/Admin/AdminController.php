<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ContentProviderExportMonthlyStatementReport;
use App\Http\Controllers\Controller;
use App\Models\auditTrailLearnerProfile;
use App\Exports\ContentProviderRevenue;
use App\Exports\CorporateAccessExportMonthlyStatementReport;
use App\Exports\EnrollExport;
use App\Exports\EnrollExportForCp;
use App\Models\EnrolledTotal;
use App\Models\Invoice;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Modules\Certificate\Entities\CertificateRecord;
use Modules\CourseSetting\Entities\Course;
use Modules\CourseSetting\Entities\CourseEnrolled;
use Modules\CourseSetting\Entities\Lesson;
use Modules\Payment\Entities\Checkout;
use Modules\Payment\Entities\InstructorTotalPayout;
use Modules\Payment\Entities\Withdraw;
use Modules\Setting\Entities\TaxSetting;
use Modules\Subscription\Entities\SubscriptionCheckout;
use Modules\Subscription\Entities\SubscriptionCourse;
use Yajra\DataTables\DataTables;
use App\Exports\InterestExport;
use Maatwebsite\Excel\Facades\Excel;
use App\LessonComplete;
use App\Models\Company;
use App\Models\HrdcTotalPayout;
use Modules\CourseSetting\Entities\LevyCourseEnrolleds;
use Modules\Setting\Model\GeneralSetting;
use Modules\CourseSetting\Entities\CustomizePackages;
use Modules\CourseSetting\Entities\auditTrailPackage;
use Modules\CourseSetting\Entities\LevyPackageEnrolleds;
use Modules\CourseSetting\Entities\PackageEnrolled;
use PDF;


class AdminController extends Controller
{
    public function enrollLogs(Request $request) {
        $courseId = !empty($request->course) ? $request->course : '';
        $start = !empty($request->start_date) ?  date('Y-m-d', strtotime($request->start_date)) : '';
        $end = !empty($request->end_date) ? date('Y-m-d', strtotime($request->end_date)) : '';

        try {
            $enrolls = [];
            return view('backend.student.enroll_student', compact('courseId', 'start', 'end', 'enrolls'));
        } catch (\Exception $e) {
            Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
            return redirect()->back();
        }
    }

    public function enrollFilter(Request $request) {
        try {
            if (!empty($request->course)) {
                $courseId = $request->course;
            } else {
                $courseId = '';
            }
            if (!empty($request->start_date)) {
                $start = date('Y-m-d', strtotime($request->start_date));
            } else {
                $start = '';
            }
            if (!empty($request->end_date)) {
                $end = date('Y-m-d', strtotime($request->end_date));
            } else {
                $end = '';
            }


            // $courses = Course::paginate(20);
            // $students = User::paginate(20);
            return view('backend.student.enroll_student', compact('courseId', 'start', 'end'));
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function reveuneList() {
        try {
            $query = CourseEnrolled::with('course', 'course.user')
                ->select(DB::raw('course_id, COUNT(course_id) as cnt, SUM(myll_revenue) as myll_revenue'))
                ->groupBy('course_id')
                ->where('myll_revenue', '>', 0);
            $enrolls = $query->get();
            $taxSetting = TaxSetting::first();
            $tax = $taxSetting ? (1 + $taxSetting->value / 100) : 1;

            $instructors = User::where('role_id', 2)
                ->orWhere('role_id', 7)
                ->orWhere('role_id', 8)
                ->get();
            return view('payment::admin_revenue', compact('enrolls', 'tax', 'instructors'));
        } catch (\Exception $e) {
            return response()->json(['error' => trans("lang.Oops, Something Went Wrong")]);
        }
    }

    public function getmyllAdminRevenueData(Request $request) {
        try {
            $query1 = CourseEnrolled::with('course', 'course.user')
                ->withoutGlobalScope('courseenrolldata')
                ->select(DB::raw('course_id, COUNT(course_id) as cnt, SUM(myll_revenue) as myll_revenue'))
                ->groupBy('course_id')
                ->where('myll_revenue', '>', 0);

            $query2 = PackageEnrolled::with('package', 'package.user')
                ->select(DB::raw('package_id, COUNT(package_id) as cnt, SUM(myll_revenue) as myll_revenue'))
                ->groupBy('package_id')
                ->where('myll_revenue', '>', 0);


            $instructor = empty($request->instructor) ? '' : $request->instructor;
            $start_date = empty($request->start_date) ? '' : $request->start_date;
            $end_date = empty($request->end_date) ? '' : $request->end_date;

            if (!empty($start_date)) {
                $query1->whereHas('course', function ($q) use ($start_date) {
                    $q->whereDate('created_at', '>=', $start_date);
                });
                $query2->whereHas('package', function ($q) use ($start_date) {
                    $q->whereDate('created_at', '>=', $start_date);
                });
            }
            if (!empty($end_date)) {
                $query1->whereHas('course', function ($q) use ($end_date) {
                    $q->whereDate('created_at', '<=', $end_date);
                });
                $query2->whereHas('package', function ($q) use ($end_date) {
                    $q->whereDate('created_at', '<=', $end_date);
                });
            }
            if (!empty($instructor)) {
                $query1->whereHas('course', function($q) use ($instructor) {
                    $q->whereHas('user', function($qq) use ($instructor) {
                        $qq->where('id', $instructor);
                    });
                });
                $query2->whereHas('package', function ($q) use ($instructor) {
                    $q->whereHas('user', function ($qq) use ($instructor) {
                        $qq->where('id', $instructor);
                    });
                });
            }


            $query = $query1->get()->toBase()->merge($query2->get());

            return DataTables::of($query)
            ->editColumn('course.title', function ($query) {
                return $query->course->title ?? $query->package->name;
            })
            ->editColumn('course.user.name', function ($query) {
                return $query->course->user->name ?? @$query->package->user->name;
            })
                ->editColumn('course.price', function($query) {
                    return getPriceFormat($query->course->price ?? $query->package->price);
                })
                ->editColumn('course.created_at', function($query) {
                    return showDate(@$query->course->created_at ?? @$query->package->created_at);
                })
                ->editColumn('myll_revenue', function($query) {
                    $taxSetting = TaxSetting::first();
                    $tax = $taxSetting ? (1 + $taxSetting->value / 100) : 1;
                    return '<a href="' . route('admin.enrollLog', $query->course_id ?? $query->package_id) . '"
                               class="btn_1 light">' . getPriceFormat($query->myll_revenue / $tax) . '</a>';
                })
                ->rawColumns(['myll_revenue'])
                ->make(true);
        } catch (\Exception $e) {
            Log::info($e->getMessage());
        }
    }

    public function auditTrailLearnerProfile() {
        return view('coursesetting::audit_trail_learner_profile');
    }

    public function auditTrailLearnerProfileData(Request $request) {
        $query = auditTrailLearnerProfile::latest();

        if (!empty($request->email)) {
            $query->where('learner_name', 'LIKE', '%' . $request->email . '%')->orWhere('email', 'LIKE', '%' . $request->email . '%');
        }

        if (!empty($request->start_date) && empty($request->end_date)) {
            $query->where('created_at', '>=', $request->start_date);
        }

        if (!empty($request->start_date) && $request->start_date != "") {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if (!empty($request->end_date) && $request->end_date != "") {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        return Datatables::of($query)
            ->addIndexColumn()
            ->addColumn('created_at', function ($query) {
                return $query->created_at;
            })
            ->addColumn('user', function ($query) {
                return !empty($query->user->name) ? $query->user->name : 'Guest';
            })
            ->addColumn('action', function ($query) {
                $view = '<button class="dropdown-item viewStudentAuditTrail"
                                 data-id="' . $query->id . '"
                                 type="button">' . trans('common.View') . '</button>';
                $actioinView = ' <div class="dropdown CRM_dropdown">
                                     <div class="btn btn-info">
                                         ' . $view . '
                                     </div>
                                 </div>';

                return $actioinView;
            })->rawColumns(['action'])->make(true);
    }

    public function getCompareAuditTrailLearnerProfileData($id) {
        $columnChanges = [];
        $dataChanges = [];
        $changes = auditTrailLearnerProfile::select("subject")->where("id", $id)->first();

        $changes = json_decode($changes["subject"], true);

        foreach ($changes as $key => $one) {
            if ($key != "updated_at" && $key != "password") {
                $columnChanges[] = $key;
                $dataChanges[] = $one;
            }
        }
        $html = view('coursesetting::compare_audit_trail', ['dataChanges' => $dataChanges, "columnChanges" => $columnChanges])->render();

        return $html;
    }

    public function reveuneListInstructor(Request $request) {
        try {
            if (empty($request->instructor)) {
                $search_instructor = '';
            } else {
                $search_instructor = $request->instructor;
            }
            if (empty($request->month)) {
                $search_month = '';
            } else {
                $search_month = $request->month;
            }
            if (empty($request->year)) {
                $search_year = date('Y');
            } else {
                $search_year = $request->year;
            }


            $query = CourseEnrolled::with('course', 'user', 'course.user');

            if (!empty($search_month)) {
                $from = date($search_year . '-' . $search_month . '-1');
                $to = date($search_year . '-' . $search_month . '-31');
                $query->whereBetween('created_at', [$from, $to]);
            }

            if (!empty($search_instructor)) {
                $query->whereHas('course', function ($q) use ($search_instructor) {
                    $q->where('user_id', $search_instructor);
                });
            }

            if (Auth::user()->role_id == 2) {
                $query->whereHas('course', function ($q) {
                    $q->where('user_id', Auth::user()->id);
                });
            }

            if (Auth::user()->role_id == 7 || isPartner()) {
                $query->whereHas('course', function ($q) {
                    $q->where('user_id', Auth::user()->id);
                });
            }

            $enrolls = $query->whereHas('course.user', function ($query) {
                $query->where('id', '!=', 1)->where('role_id', '!=', 7);
            })->latest()->get();


            $query2 = DB::table('subscription_courses')
                ->select('subscription_courses.*')
                ->selectRaw("SUM(revenue) as total_price");
            if (Auth::user()->role_id == 2) {
                $query2->where('user_id', '=', Auth::user()->id);
            }


            if (isModuleActive('Subscription')) {
                $subscriptionsData = $query2->groupBy('checkout_id')
                    ->latest()->get();
                $subscriptions = [];
                foreach ($subscriptionsData as $key => $data) {
                    $subscriptions[$key]['checkout_id'] = $data->checkout_id;
                    $subscriptions[$key]['date'] = $data->date;
                    $subscriptions[$key]['price'] = $data->total_price;
                    $user = User::where('id', $data->instructor_id)->first();
                    $subscriptions[$key]['instructor'] = $user->name ?? '';

                    $plan = SubscriptionCheckout::where('id', $data->checkout_id)->first();

                    $subscriptions[$key]['plan'] = $plan->plan->title ?? '';
                }
            } else {
                $subscriptions = [];
            }
            $instructors = User::where('role_id', 2)->get();
            return view('payment::instructor_revenue_report', compact('search_instructor', 'search_month', 'search_year', 'instructors', 'enrolls', 'subscriptions'));
        } catch (\Exception $e) {
            return response()->json(['error' => trans("lang.Oops, Something Went Wrong")]);
        }
    }

    public function reveune_list_cp(Request $request) {
        try {
            $rolesId = 7;
            $search_instructor = empty($request->instructor) ? '' : $request->instructor;
            $start_date = empty($request->start_date) ? '' : $request->start_date;
            $end_date = empty($request->end_date) ? '' : $request->end_date;
            $search_learning_type = empty($request->product_type) ? '' : $request->product_type;
            $search_title = empty($request->title) ? '' : $request->title;
            $search_user = '';
            if (!empty($request->user)) {
                if (preg_match("/[^a-zA-z]/", $request->user)) {
                    $search_user = trim(preg_replace("/[^0-9]/", "", $request->user));
                } else {
                    $search_user = $request->user;
                }
            }

            $query = CourseEnrolled::with('course', 'user', 'course.user');
            $learners = User::where('role_id', 3)->get();
            $companies = Company::all();
            $arr = ['Users', 'Companies'];
            $users = array_combine($arr, array($learners, $companies));

            if (!empty($start_date) && empty($end_date)) {
                $query->whereDate('created_at', '>=', $start_date);
            }

            if (empty($start_date) && !empty($end_date)) {
                $query->whereDate('created_at', '<=', $end_date);
            }

            if (!empty($request->start_date) && !empty($request->end_date)) {
                $query->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date);
            }

            if (Auth::user()->role_id == 7 || isPartner()) {
                $query->whereHas('course', function ($q) {
                    $q->where('user_id', Auth::user()->id);
                });
            }

            $enrolls = $query->whereHas('course.user', function ($query) {
                $query->where('id', '!=', 1)->where('role_id', 7);
            })->latest()->get();

            $query2 = DB::table('subscription_courses')
                ->select('subscription_courses.*')
                ->selectRaw("SUM(revenue) as total_price");
            if (Auth::user()->role_id == 7 || isPartner()) {
                $query2->where('user_id', '=', Auth::user()->id);
            }

            if (isModuleActive('Subscription')) {
                $subscriptionsData = $query2->groupBy('checkout_id')
                    ->latest()->get();;
                $subscriptions = [];
                foreach ($subscriptionsData as $key => $data) {
                    $subscriptions[$key]['checkout_id'] = $data->checkout_id;
                    $subscriptions[$key]['date'] = $data->date;
                    $subscriptions[$key]['price'] = $data->total_price;
                    $user = User::where('id', $data->instructor_id)->first();
                    $subscriptions[$key]['instructor'] = $user->name ?? '';

                    $plan = SubscriptionCheckout::where('id', $data->checkout_id)->first();

                    $subscriptions[$key]['plan'] = $plan->plan->title ?? '';
                }
            } else {
                $subscriptions = [];
            }

            $instructors = User::where('role_id', 7)->get(); // CP = role - 7
            return view('payment::cp_revenue_report', compact('search_instructor', 'start_date', 'end_date', 'instructors', 'enrolls', 'subscriptions', 'rolesId', 'users', 'search_user', 'search_learning_type', 'search_title'));
        } catch (\Exception $e) {
            return response()->json(['error' => trans("lang.Oops, Something Went Wrong")]);
        }
    }

    public function revenue_cp_data(Request $request) {
        try {
            $user = auth()->user();
            // $query = CourseEnrolled::with('course', 'user', 'course.user', 'checkout');
            // $query->where('purchase_price', '>', 0);
            $query1 = CourseEnrolled::query()
                ->withoutGlobalScope('courseenrolldata')
                ->whereHas('checkout', function ($checkout) {
                    return $checkout->where('price', '>', 0)->where('status', 1)
                            ->where(function ($q){
                                $q->where('is_levy_deduction', 0)->where('purchase_price', '!=', 0);
                            }); // this is to show the package is payment by ipay only
                })
                ->with('user', 'course', 'checkout');

            $query2 = LevyCourseEnrolleds::query()
                ->whereHas('checkout', function ($checkout) {
                    return $checkout->where('price', '>', 0)->where('status', 1);
                })
                ->with('user', 'course', 'checkout');

            $query3 = PackageEnrolled::query()
                ->whereHas('checkout', function ($checkout) {
                    return $checkout->where('price', '>', 0)->where('status', 1)
                            ->where(function ($q){
                                $q->where('is_levy_deduction', 0)->where('purchase_price', '!=', 0);
                            }); // this is to show the package is payment by ipay only
                })
                ->with('user', 'package', 'checkout');

            $query4 = LevyPackageEnrolleds::query()
                ->whereHas('checkout', function ($checkout) {
                    return $checkout->where('price', '>', 0)->where('status', 1);
                })
                ->with('user', 'package', 'checkout');

            $role_id = empty($request->role) ? '' : $request->role;
            $search_instructor = empty($request->instructor) ? '' : User::where('id', $request->instructor)->first();
            $start_date = empty($request->start_date) ? '' : $request->start_date;
            $end_date = empty($request->end_date) ? '' : $request->end_date;
            $search_title = empty($request->title) ? '' : $request->title;
            $search_learning_type = empty($request->product_type) ? '' : $request->product_type;



            if ($user->role_id == 7 || isPartner()) {
                $query1->whereHas('course', function ($q) {
                    return $q->where('user_id', auth()->user()->id);
                });
                $query2->whereHas('course', function ($q) {
                    return $q->where('user_id', auth()->user()->id);
                });
                $query3->whereHas('package', function ($q) {
                    return $q->where('user_id', auth()->user()->id);
                });
                $query4->whereHas('package', function ($q) {
                    return $q->where('user_id', auth()->user()->id);
                });
            } else if (!empty($role_id)) {
                Session::put('role_id', $role_id);
                $query1->whereHas('course.user', function ($q) {
                    return $q->where('role_id', Session::get('role_id'));
                });
                $query2->whereHas('course.user', function ($q) {
                    return $q->where('role_id', Session::get('role_id'));
                });
                $query3->whereHas('package.user', function ($q) {
                    return $q->where('role_id', Session::get('role_id'));
                });
                $query4->whereHas('package.user', function ($q) {
                    return $q->where('role_id', Session::get('role_id'));
                });
            }

            if (!empty($start_date) && empty($end_date)) {
                $query1->whereDate('created_at', '>=', $start_date);
                $query2->whereDate('created_at', '>=', $start_date);
                $query3->whereDate('created_at', '>=', $start_date);
                $query4->whereDate('created_at', '>=', $start_date);
            }

            if (empty($start_date) && !empty($end_date)) {
                $query1->whereDate('created_at', '<=', $end_date);
                $query2->whereDate('created_at', '<=', $end_date);
                $query3->whereDate('created_at', '<=', $end_date);
                $query4->whereDate('created_at', '<=', $end_date);
            }

            if (!empty($start_date) && !empty($end_date)) {
                $query1->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date);
                $query2->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date);
                $query3->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date);
                $query4->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date);
            }

            if (!empty($search_instructor)) {
                Session::put('instructor_name', $search_instructor->name);
                $query1->whereHas('course', function ($q) {
                    $q->whereHas('user', function ($qq) {
                        $qq->where('name', Session::get('instructor_name'));
                    });
                });
                $query2->whereHas('course', function ($q) {
                    $q->whereHas('user', function ($qq) {
                        $qq->where('name', Session::get('instructor_name'));
                    });
                });
                $query3->whereHas('package', function ($q) {
                    $q->whereHas('user', function ($qq) {
                        $qq->where('name', Session::get('instructor_name'));
                    });
                });
                $query4->whereHas('package', function ($q) {
                    $q->whereHas('user', function ($qq) {
                        $qq->where('name', Session::get('instructor_name'));
                    });
                });
            }

            if (!empty($request->user)) {
                if (str_contains($request->user, 'Users')) {
                    $user_id = trim(str_replace('Users', "", $request->user));
                    $search_user = empty($request->user) ? '' : User::where('id', $user_id)->first();
                    Session::put('user_name', $search_user->name);
                    $query1->whereHas('user', function ($q) {
                        $q->where('name', Session::get('user_name'));
                    });
                    $query2->whereHas('user', function ($q) {
                        $q->where('name', Session::get('user_name'));
                    });
                    $query3->whereHas('user', function ($q) {
                        $q->where('name', Session::get('user_name'));
                    });
                    $query4->whereHas('user', function ($q) {
                        $q->where('name', Session::get('user_name'));
                    });
                } else {
                    $company_id = trim(str_replace('Companies', "", $request->user));
                    $search_user = empty($request->user) ? '' : Company::where('id', $company_id)->first();
                    Session::put('user_name', $search_user->name);
                    $query1->whereHas('user.company', function ($q) {
                        $q->where('name', Session::get('user_name'));
                    });
                    $query2->whereHas('user.company', function ($q) {
                        $q->where('name', Session::get('user_name'));
                    });
                    $query3->whereHas('user.company', function ($q) {
                        $q->where('name', Session::get('user_name'));
                    });
                    $query4->whereHas('user.company', function ($q) {
                        $q->where('name', Session::get('user_name'));
                    });
                }
            }

            if (!empty($search_title)) {
                $query1->whereHas('course', function ($q) use ($search_title) {
                    $q->where('title', 'LIKE', '%' . $search_title . '%');
                });
                $query2->whereHas('course', function ($q) use ($search_title) {
                    $q->where('title', 'LIKE', '%' . $search_title . '%');
                });
                $query3->whereHas('package', function ($q) use ($search_title) {
                    $q->where('name', 'LIKE', '%' . $search_title . '%');
                });
                $query4->whereHas('package', function ($q) use ($search_title) {
                    $q->where('name', 'LIKE', '%' . $search_title . '%');
                });
            }

            if (!empty($search_learning_type)) {
                if ($search_learning_type == 1) {
                    $query1->whereHas('checkout', function ($q) {
                        $q->whereIn('product_type', [0, 1]);
                    });
                    $query2->whereHas('checkout', function ($q) {
                        $q->whereIn('product_type', [0, 1]);
                    });
                    $query3->whereHas('checkout', function ($q) {
                        $q->whereIn('product_type', [0, 1]);
                    });
                    $query4->whereHas('checkout', function ($q) {
                        $q->whereIn('product_type', [0, 1]);
                    });
                } else {
                    $query1->whereHas('checkout', function ($q) {
                        $q->whereIn('product_type', [2, 3]);
                    });
                    $query2->whereHas('checkout', function ($q) {
                        $q->whereIn('product_type', [2, 3]);
                    });
                    $query3->whereHas('checkout', function ($q) {
                        $q->whereIn('product_type', [2, 3]);
                    });
                    $query4->whereHas('checkout', function ($q) {
                        $q->whereIn('product_type', [2, 3]);
                    });
                }
            }

            $query1 = $query1->get()->toBase();
            $query2 = $query2->get()->toBase();
            $query3 = $query3->get()->toBase();
            $query4 = $query4->get()->toBase();
            $query = $query1->merge($query2)->merge($query3)->merge($query4);

            return DataTables::of($query)
                ->addColumn('purchase_id', function ($query) {
                    return $query->id + 1000;
                })
                ->editColumn('title', function ($query) {
                    $title = '';
                    if (!empty($query->course)) {
                        $title = $query->course->title;
                    }
                    if (!empty($query->package)) {
                        $title = $query->package->name;
                    }
                    return $title;
                })
                ->addColumn('learning_type', function ($query) {
                    $type = '';
                    if ($query->checkout->product_type == 2 || $query->checkout->product_type == 3) {
                        $type = 'Subscription';
                    } elseif ($query->checkout->product_type == 0 || $query->checkout->product_type == 1) {
                        $type = 'Pay per Use';
                    }
                    return $type;
                })
                ->editColumn('created_at', function ($query) {
                    // return showDate(@$query->created_at);
                    return [
                        'display' => showDate(@$query->created_at),
                        'timestamp' => $query->created_at->timestamp
                    ];
                })
                ->editColumn('cp_partner_name', function ($query) {
                    $cp_partner_name = '';
                    if (!empty($query->course->user)) {
                        $cp_partner_name = $query->course->user->name;
                    }
                    if (!empty($query->package->user)) {
                        $cp_partner_name = $query->package->user->name;
                    }
                    return $cp_partner_name;
                })
                ->editColumn('user_name', function ($query) {
                    $name = '';

                    if (!empty($query->user->company) || !empty($query->user_model->company)) {
                        $name = $query->user->company->name ?? $query->user_model->company->name;
                    } else {
                        $name = $query->user->name ?? $query->user_model->name;
                    }

                    return $name;
                })
                ->editColumn('purchase_price', function ($query) {
                    return getPriceFormat($query->purchase_price);
                })
                ->editColumn('quantity', function ($query) {
                    $quantity = '';
                    if (isset($query->package)) {
                        $quantity = $query->initial_quantity ?? $query->quantity;
                    } else {
                        $quantity = $query->quantity;
                    }
                    return $quantity;
                })
                ->editColumn('grand_total', function ($query) {
                    $quantity = '';
                    if (isset($query->package)) {
                        $quantity = $query->initial_quantity ?? $query->quantity;
                    } else {
                        $quantity = $query->quantity;
                    }

                    $total = $query->purchase_price * $quantity;
                    return getPriceFormat($total);
                })
                ->editColumn('reveune', function ($query) {
                    // return getPriceFormat($query->reveune);
                    $commission = 100 - Settings('commission') - Settings('hrdc_commission');

                    $quantity = '';
                    if (isset($query->package)) {
                        $quantity = $query->initial_quantity ?? $query->quantity;
                    } else {
                        $quantity = $query->quantity;
                    }
                    return getPriceFormat(($query->purchase_price * $quantity) * $commission / 100);
                })
                ->make(true);
        } catch (\Exception $e) {
            Log::info($e->getMessage());
        }
    }

    public function reveune_cp_export(Request $request) {
        if (isPartner() || $request->role_id == 8) {
            return Excel::download(new ContentProviderRevenue($request->instructor, $request->start_date, $request->end_date, $request->role_id, $request->title, $request->search_learning_type, $request->user), 'partner-revenue.csv');
        } else {
            return Excel::download(new ContentProviderRevenue($request->instructor, $request->start_date, $request->end_date, $request->role_id, $request->title, $request->search_learning_type, $request->user), 'content-provider-revenue.csv');
        }
    }

    public function cp_export_monthly_statement_report(Request $request) {
        return Excel::download(new ContentProviderExportMonthlyStatementReport($request->partner, $request->instructor, $request->start_date, $request->end_date), 'content-provider-monthly-statement-report.csv');
    }

    public function reveune_list_partner(Request $request) {
        try {
            $rolesId = 8;
            $search_instructor = empty($request->instructor) ? '' : $request->instructor;
            $search_month = empty($request->month) ? '' : $request->month;
            $search_year = empty($request->year) ? '' : $request->year;
            $start_date = empty($request->start_date) ? '' : $request->start_date;
            $end_date = empty($request->end_date) ? '' : $request->end_date;
            $search_learning_type = empty($request->product_type) ? '' : $request->product_type;
            $search_title = empty($request->title) ? '' : $request->title;
            $search_user = '';
            if (!empty($request->user)) {
                if (preg_match("/[^a-zA-z]/", $request->user)) {
                    $search_user = trim(preg_replace("/[^0-9]/", "", $request->user));
                } else {
                    $search_user = $request->user;
                }
            }

            $query = CourseEnrolled::with('course', 'user', 'course.user');
            $learners = User::where('role_id', 3)->get();
            $companies = Company::all();
            $arr = ['Users', 'Companies'];
            $users = array_combine($arr, array($learners, $companies));

            if (!empty($search_month)) {
                $from = date($search_year . '-' . $search_month . '-1');
                $to = date($search_year . '-' . $search_month . '-31');
                $query->whereBetween('created_at', [$from, $to]);
            }

            if (empty($search_month) && !empty($search_year)) {
                $query->whereYear('created_at','=',$search_year);
            }

            if (!empty($start_date) && empty($end_date)) {
                $query->whereDate('created_at', '>=', $start_date);
            }

            if (empty($start_date) && !empty($end_date)) {
                $query->whereDate('created_at', '<=', $end_date);
            }

            if (!empty($request->start_date) && !empty($request->end_date)) {
                $query->whereDate('created_at', '>=', $start_date)->whereDate('created_at', '<=', $end_date);
            }

            if (isPartner()) {
                $query->whereHas('course', function ($q) {
                    $q->where('user_id', Auth::user()->id);
                });
            }

            $enrolls = $query->whereHas('course.user', function ($query) {
                $query->where('id', '!=', 1)->where('role_id', 7);
            })->latest()->get();

            $query2 = DB::table('subscription_courses')
                ->select('subscription_courses.*')
                ->selectRaw("SUM(revenue) as total_price");
            if (Auth::user()->role_id == 7 || isPartner()) {
                $query2->where('user_id', '=', Auth::user()->id);
            }

            if (isModuleActive('Subscription')) {
                $subscriptionsData = $query2->groupBy('checkout_id')
                    ->latest()->get();;
                $subscriptions = [];
                foreach ($subscriptionsData as $key => $data) {
                    $subscriptions[$key]['checkout_id'] = $data->checkout_id;
                    $subscriptions[$key]['date'] = $data->date;
                    $subscriptions[$key]['price'] = $data->total_price;
                    $user = User::where('id', $data->instructor_id)->first();
                    $subscriptions[$key]['instructor'] = $user->name ?? '';

                    $plan = SubscriptionCheckout::where('id', $data->checkout_id)->first();

                    $subscriptions[$key]['plan'] = $plan->plan->title ?? '';
                }
            } else {
                $subscriptions = [];
            }

            $instructors = User::where('role_id', 8)->get();
            return view('payment::cp_revenue_report', compact('search_instructor', 'search_month', 'search_year', 'instructors', 'enrolls', 'subscriptions', 'rolesId','users', 'search_user', 'search_learning_type', 'search_title', 'start_date', 'end_date'));
        } catch (\Exception $e) {
            return response()->json(['error' => trans("lang.Oops, Something Went Wrong")]);
        }
    }

    public function sortByDiscount(Request $request) {
        $rules = [
            'discount' => 'required',
            'id' => 'required'
        ];

        $this->validate($request, $rules, validationMessage($rules));

        try {
            $id = $request->id;
            $val = $request->discount;
            $start = date('Y-m-d', strtotime($request->start_date));
            $end = date('Y-m-d', strtotime($request->end_date));
            $method = $request->methods;
            if ((isset($request->end_date)) && (isset($request->start_date))) {
                if ($val == 10) {
                    $logs = CourseEnrolled::where('course_id', $id)->where('discount_amount', '>', 0)->whereDate('created_at', '>=', $start)->whereDate('created_at', '<=', $end)->latest()->with('user')->get();
                } else {
                    $logs = CourseEnrolled::where('course_id', $id)->where('discount_amount', '=', 0)->whereDate('created_at', '>=', $start)->whereDate('created_at', '<=', $end)->latest()->with('user')->get();
                }
            } elseif (is_null($request->start_date) && is_null($request->end_date)) {
                if ($val == 10) {
                    $logs = CourseEnrolled::where('course_id', $id)->where('discount_amount', '>', 0)->with('user', 'course')->latest()->get();
                } else {
                    $logs = CourseEnrolled::where('course_id', $id)->where('discount_amount', '=', 0)->with('user', 'course')->latest()->get();
                }
            } elseif (isset($request->start_date) && is_null($request->end_date)) {
                if ($val == 10) {
                    $logs = CourseEnrolled::where('course_id', $id)->where('discount_amount', '>', 0)->with('user', 'course')->whereDate('created_at', '>=', $start)->latest()->get();
                } else {
                    $logs = CourseEnrolled::where('course_id', $id)->where('discount_amount', '=', 0)->with('user', 'course')->whereDate('created_at', '>=', $start)->latest()->get();
                }
            } elseif (isset($request->end_date) && is_null($start)) {
                if ($val == 10) {
                    $logs = CourseEnrolled::where('course_id', $id)->where('discount_amount', '>', 0)->with('user', 'course')->whereDate('created_at', '<=', $end)->latest()->get();
                } else {
                    $logs = CourseEnrolled::where('course_id', $id)->where('discount_amount', '=', 0)->with('user', 'course')->whereDate('created_at', '<=', $end)->latest()->get();
                }
            }
            $course_id = $request->id;
            return view('payment::enroll_log', compact('logs', 'course_id'));
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function courseEnrolls($id) {
        try {
            $logs = CourseEnrolled::where('course_id', $id)->with('user', 'course')->latest()->get();
            $course_id = $id;
            $taxSetting = TaxSetting::first();
            $tax = $taxSetting ? (1 + $taxSetting->value / 100) : 1;
            return view('payment::enroll_log', compact('logs', 'course_id', 'tax'));
        } catch (\Exception $e) {
            return response()->json(['error' => trans("lang.Oops, Something Went Wrong")]);
        }
    }

    public function interestForm() {
        $instructors = User::where('role_id', 2)->get();
        $user = Auth::user();

        $enroll_total = EnrolledTotal::where('instructor_id', $user->id)->first();
        $remaining = $enroll_total ? $enroll_total->instructor_amount : 0;

        return view('payment::interest_form', compact('remaining', 'instructors'));
    }

    public function interestFormEdit($id) {
        $data = DB::table('booked_demo')
                ->select('booked_demo.*')
                ->where('id', $id)
                ->orderBy('id','DESC')->first();
        return view('payment::interest_form_edit', compact('data'));
    }

    public function interestFormUpdate(Request $request) {
            Session::flash('type', 'update');
            Session::flash('id', $request->id);

            if (demoCheck()) {
                return redirect()->back();
            }
            
            try {

                DB::table('booked_demo')
                ->where('id', $request->id)
                ->update([
                    'status' => $request->status
                ]);

                Toastr::success('Status has been updated', trans('common.Success'));
                return redirect()->to(route('admin.interest.form'));
            } catch (Exception $e) {
                GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
            }
        
    }

    public function interestListExcelDownload(Request $request) {
        return Excel::download(new InterestExport($request->from_date, $request->to_date), 'interes-list.xlsx');
    }

    public function getInterestFormData(Request $request) {
        try {
            $query2 = DB::table('booked_demo')
                ->select('booked_demo.*');
                if($request->from_date!=""){
                    $query2->where('created_at', '>=', $request->from_date);
                }
                if($request->to_date!=""){
                    $query2->where('created_at', '<=', $request->to_date);
                }
                
                $query2->orderBy('id','DESC');
                
            return Datatables::of($query2)
                ->addIndexColumn()
                ->addColumn('full_name', function ($query) {
                    return $query->full_name;
                })
                ->addColumn('email_address', function ($query) {
                    return $query->email_address;
                })
                ->addColumn('phone_number', function ($query) {
                    return $query->phone_number;
                })
                ->addColumn('company_name', function ($query) {
                    return $query->company_name;
                })
                ->addColumn('company_registration_no', function ($query) {
                    return $query->company_registration_no;
                })
                ->addColumn('location', function ($query) {
                    return $query->location;
                })
                ->addColumn('industry', function ($query) {
                    return $query->industry;
                })
                ->addColumn('no_of_employees', function ($query) {
                    return $query->no_of_employees;
                })
                ->addColumn('hrd_corp', function ($query) {
                    return $query->hrd_corp;
                })
                ->addColumn('status', function ($query) {
                    if ($query->status == 1) {
                        $view = 'Completed';
                    } else {
                        $view = 'Pending';
                    }
                    return $view;
                })
                ->addColumn('submission_date', function ($query) {
                    return showDate(@$query->created_at);
                })
                ->addColumn('action', function ($query) {
                    if (\auth()->user()->role_id == 1) {
                        $view = '<div class="dropdown CRM_dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button"
                                            id="dropdownMenu2" data-toggle="dropdown"
                                            aria-haspopup="true"
                                            aria-expanded="false">
                                       ' . trans('common.Action') . '
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right"
                                         aria-labelledby="dropdownMenu2">
                                        <a href="'.route('admin.interestFormEdit', $query->id).'" class="dropdown-item viewdetails" data-instructor_id="' . $query->id . '"
                                        data-withdraw_id="' . $query->id . '" data-type="1"
                                           type="button">' . trans('Edit') . '</a>
                                    </div>
                                </div>';
                    } else {
                        $view = '';
                    }
                    return $view;
                })
                ->rawColumns(['method', 'user.image', 'action'])->make(true);
        } catch (\Exception $e) {
            Log::info($e->getMessage());
        }
    }

    public function instructorPayout() {
        $instructors = User::where('role_id', 2)->get();
        $user = Auth::user();

        $enroll_total = EnrolledTotal::where('instructor_id', $user->id)->first();
        $remaining = $enroll_total ? $enroll_total->instructor_amount : 0;

        return view('payment::instructor_payout', compact('remaining', 'instructors'));
    }

    public function cpPayout() {
        $rolesId = 7;
        $instructors = User::where('role_id', $rolesId)->get();
        $user = Auth::user();

        $enroll_total = EnrolledTotal::where('instructor_id', $user->id)->first();
        $remaining = $enroll_total ? $enroll_total->instructor_amount : 0;

        return view('payment::cp_payout', compact('remaining', 'instructors', 'rolesId'));
    }

    public function myll_admin_payout() {
        $rolesId = 7;
        $instructors = User::where('role_id', 7)->get();

        $user = Auth::user();

        $enroll_total = EnrolledTotal::where('instructor_id', $user->id)->first();
        $remaining = $enroll_total ? $enroll_total->myll_amount : 0;

        return view('payment::myll_admin_payout', compact('remaining', 'instructors', 'rolesId'));
    }

    public function monthlyStatementReports(Request $request) {
        $search_instructor = $request->instructor ?? '';
        $search_partner = $request->partner ?? '';
        $instructors = User::where('role_id', 7)->get();
        $partners    = User::where('role_id', 8)->get();

        return view('payment::cp_monthly_statement_reports',compact('instructors','partners','search_instructor','search_partner'));
    }

    public function partnerPayout() {
        $rolesId = 8;
        $instructors = User::where('role_id', 8)->get();
        $user = Auth::user();

        $instructorTotal = InstructorTotalPayout::where('instructor_id', $user->id)->first();
        $remaining = $instructorTotal->amount ?? 0;

        return view('payment::cp_payout', compact('remaining', 'instructors', 'rolesId'));
    }

    public function instructorRequestPayout(Request $request) {
        try {
            $user = Auth::user();
            $totalPayout = InstructorTotalPayout::where('instructor_id', $user->id)->first();
            $maxAmount = $totalPayout->amount;
            $amount = $request->amount;

            if ($maxAmount < $amount) {
                Toastr::error('Max Limit is ' . getPriceFormat($maxAmount), 'Error');
                return redirect()->back();
            }

            $withdraw = new Withdraw();
            $withdraw->instructor_id = Auth::user()->id;
            $withdraw->amount = $amount;
            $withdraw->issueDate = Carbon::now();
            $withdraw->type = 1; //Instructor
            $withdraw->method = Auth::user()->payout;
            $withdraw->save();
            $totalPayout->amount = $totalPayout->amount - $amount;
            $totalPayout->save();

            Toastr::success('Payment request has been successfully submitted', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function instructorCompletePayout(Request $request) {
        try {
            $withdraws = Withdraw::where('instructor_id', $request->instructor_id)->where('status', 0)->whereYear('created_at', $request->year)->whereMonth('created_at', $request->month);

            if (isset($request->payout_type) && $request->payout_type == 'myll_admin_payout') {
                $withdraws = $withdraws->where('type', 3);
            } else {
                $withdraws = $withdraws->where('type', 1);
            }

            $withdraws = $withdraws->get();

            $instractor = User::find($request->instructor_id);
            $amount = 0;

            foreach ($withdraws as $withdraw) {
                $withdraw->status = 1;
                $withdraw->payment_date = Carbon::now();
                $withdraw->save();

                $amount += $withdraw->amount;

                $user = User::where('id', $withdraw->instructor_id)->first();

                if (isset($request->payout_type) && $request->payout_type == 'myll_admin_payout') {
                    if (isAdmin() || isHRDCorp()) {
                        $type = 'new_payment_for_myll';

                        send_email($user, $type, [
                            'name' => $user->name,
                            'amount' => $withdraw->amount,
                            'issue_date' => $withdraw->issueDate,
                            'billing_cycle' => Carbon::parse($withdraw->created_at)->format('F Y')
                        ]);
                    }
                } else {
                    $type = 'new_payment_for_cp';

                    send_email($user, $type, [
                        'trainer_name' => $user->name,
                        'amount' => $withdraw->amount,
                        'issue_date' => $withdraw->issueDate,
                        'billing_cycle' => Carbon::parse($withdraw->created_at)->format('F Y')
                    ]);
                }
            }

            $instractor->balance += $amount;
            $instractor->save();

            Toastr::success('Payment request has been Approved', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function enrollDelete($id) {
        if (demoCheck()) {
            return redirect()->back();
        }
        $enroll = CourseEnrolled::findOrFail($id);

        $user = Auth::user();
        if ($user->role_id == 1 || $enroll->user->id == $user->id) {
            $enroll->delete();
        }

        if (UserEmailNotificationSetup('Enroll_Rejected', $enroll->user)) {
            if ($enroll->user) {
                send_email($enroll->user, 'Enroll_Rejected', [
                    'course' => $enroll->course->title,
                    'time' => now(),
                    'reason' => ''
                ]);
            }
        }

        if (UserBrowserNotificationSetup('Enroll_Rejected', $enroll->user)) {
            send_browser_notification(
                $enroll->user,
                $type = 'Enroll_Rejected',
                $shortcodes = [
                    'course' => $enroll->course->title,
                    'time' => now(),
                    'reason' => ''
                ],
                '', //actionText
                '' //actionUrl
            );
        }

        if (UserEmailNotificationSetup('Enroll_Rejected', $enroll->course->user)) {
            if ($enroll->course->user) {
                send_email($enroll->course->user, 'Enroll_Rejected', [
                    'course' => $enroll->course->title,
                    'time' => now(),
                    'reason' => ''
                ]);
            }
        }

        if (UserBrowserNotificationSetup('Enroll_Rejected', $enroll->course->user)) {
            send_browser_notification(
                $enroll->course->user,
                $type = 'Enroll_Rejected',
                $shortcodes = [
                    'course' => $enroll->course->title,
                    'time' => now(),
                    'reason' => ''
                ],
                '', //actionText
                '' //actionUrl
            );
        }

        Toastr::success(trans('common.Operation successful'), trans('common.Success'));
        return redirect()->back();
    }

    public function enrollMarkAsComplete($id) {
        if (demoCheck()) {
            return redirect()->back();
        }

        if (permissionCheck("admin.markAsComplete")) {
            $getAllCourseEnrolledByUserId = CourseEnrolled::where("id", $id)->first();
            CourseEnrolled::where("id", $id)->where("user_id", $getAllCourseEnrolledByUserId->user_id)->update(['is_completed' => 1]);
            CourseEnrolled::where("id", $id)->where("user_id", $getAllCourseEnrolledByUserId->user_id)->update(['completion_date' => date("Y-m-d H:i:s")]);
            $lessonCount = Lesson::where("course_id", $getAllCourseEnrolledByUserId->course_id)->get();
            foreach ($lessonCount as $one) {
                $lesson = new LessonComplete();
                $lesson->user_id = $getAllCourseEnrolledByUserId->user_id;
                $lesson->course_id = $getAllCourseEnrolledByUserId->course_id;
                $lesson->lesson_id = $one->id;
                $lesson->status = 1;
                $lesson->save();
            }
            $checkCertificate = CertificateRecord::where('student_id', $getAllCourseEnrolledByUserId->user_id)->where('course_id', $getAllCourseEnrolledByUserId->course_id)->first();
            if (!isset($checkCertificate->id)) {
                $certificateReports = new CertificateRecord();
                $certificateReports->certificate_id = random_int(100000, 999999);
                $certificateReports->student_id = $getAllCourseEnrolledByUserId->user_id;
                $certificateReports->course_id = $getAllCourseEnrolledByUserId->course_id;
                $certificateReports->created_by = Auth::user()->id;
                $certificateReports->save();
            }
        }

        Toastr::success(trans('common.Operation successful'), trans('common.Success'));
        return redirect()->back();
    }

    public function getEnrollLogsData(Request $request) {
        $user = Auth::user();
        $query = CourseEnrolled::query();

        if ($user->role_id == 2 || $user->role_id == 7 || isPartner()) {
            $query->whereHas('course', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            });
        }

        $query->groupBy('user_id', 'course_id');
        if (!empty($request->name) && $request->name != "") {
            $name = $request->name;
            $query = $query->whereHas('user', function ($query) use ($name) {
                return $query->where('name', 'like', '%' . $name . '%');
            });
        }
        if (!empty($request->email) && $request->email != "") {
            $email = $request->email;
            $query = $query->whereHas('user', function ($query) use ($email) {
                return $query->where('email', 'like', '%' . $email . '%');
            });
        }
        if (!empty($request->course) && $request->course != "") {
            $query->where('course_id', $request->course);
        }
        if (!empty($request->start_date)) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if (!empty($request->end_date) && $request->end_date != "") {
            $query->whereDate('created_at', '<=', $request->end_date);
        }
        if ($request->status != 'all' && !is_null($request->status) && $request->status != "") {
            $status = (int) $request->status;
            $query->where('is_completed', $status);
        }

        return Datatables::of($query)
            ->addIndexColumn()
            ->addColumn('user.image', function ($query) {
                return "<div class=\"profile_info\"><img src='" . getInstructorImage($query->user->image) . "'   alt='" . $query->user->name . " image'></div>";
            })->editColumn('user.name', function ($query) {
                return $query->user->name;
            })->editColumn('user.email', function ($query) {
                return $query->user->email;
            })
            ->editColumn('course.title', function ($query) {
                return $query->course->title;
            })
            ->editColumn('end_date', function ($query) {
                $date_of_completion = $query->completion_date;
                $end_date = '';
                if ($date_of_completion != '' && $date_of_completion != null) {
                    $end_date = showDate($date_of_completion);
                }
                return $end_date;
            })
            ->editColumn('duration', function ($query) {
                if (isset($query->completion_date)) {
                    $startTime = new \DateTime($query->created_at);
                    $finishTime = new \DateTime($query->completion_date);
                    $diff = $startTime->diff($finishTime);
                    $hours = $diff->h;
                    $hours = $hours + ($diff->days * 24);
                    if ($hours >= 24) {
                        return $startTime->diff($finishTime)->format('%a days, %h hours');
                    } else if ($hours < 24 && $hours >= 1) {
                        return $startTime->diff($finishTime)->format('%h hours, %i minutes');
                    } elseif ($hours < 1) {
                        return $startTime->diff($finishTime)->format('%i minutes');
                    }
                }
                return "";
            })
            ->editColumn('course.duration', function ($query) {
                return $query->course->duration;
            })
            ->editColumn('status', function ($query) {
                $course_status = $query->is_completed;
                if ($course_status == 1) $status = 'Completed';
                else $status = 'In Progress';
                return $status;
            })
            ->editColumn('created_at', function ($query) {
                return showDate(@$query->created_at);
            })
            ->editColumn('activation_date', function ($query) {
                return showDate(@$query->activation_date);
            })
            ->addColumn('action', function ($query) {
                if (permissionCheck('course.delete')) {
                    $deleteUrl = route('admin.enrollDelete', $query->id);
                    $course_delete = '<a onclick="confirm_modal(\'' . $deleteUrl . '\')"
                                         class="dropdown-item edit_brand">' . trans('common.Delete') . '</a>';
                } else {
                    $course_delete = "";
                }

                if (permissionCheck('admin.markAsComplete')) {
                    $course_status = $query->is_completed;
                    if ($course_status != 1) {
                        $markAsCompleteUrl = route('admin.markAsComplete', $query->id);
                        $course_mark_as_complete = '<a onclick="confirm_modal_mark_as_complete(\'' . $markAsCompleteUrl . '\')"
                                                       class="dropdown-item mark_as_complete">' . trans('common.Mark as complete') . '</a>';
                    } else {
                        $course_mark_as_complete = '';
                    }
                } else {
                    $course_mark_as_complete = "";
                }

                $actioinView = ' <div class="dropdown CRM_dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button"
                                            id="dropdownMenu2" data-toggle="dropdown"
                                            aria-haspopup="true"
                                            aria-expanded="false">
                                        ' . trans('common.Action') . '
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right"
                                         aria-labelledby="dropdownMenu2">
                                        ' . $course_delete . '
                                        ' . $course_mark_as_complete . '
                                    </div>
                                </div>';
                return $actioinView;
            })
            ->rawColumns(['user.image', 'action'])
            ->make(true);
    }

    public function getPayoutData(Request $request) {
        try {
            $query = Withdraw::select(
                DB::raw('instructor_id, status, method'),
                DB::raw('ROUND(sum(amount),2) as sum')
            )
                ->groupBy('instructor_id',)
                ->whereHas('user', function ($query) {
                    return $query->where('role_id', 2);
                })
                ->where('type', 1)
                ->latest()->with('user');
            if (!empty($request->month)) $query->whereMonth('created_at', '=', $request->month);
            if (!empty($request->year)) $query->whereYear('created_at', '=', $request->year);
            if (!empty($request->instructor)) $query->where('instructor_id', '=', $request->instructor);
            if (Auth::user()->role_id != 1) $query->where('instructor_id', '=', Auth::user()->id);

            return Datatables::of($query)
                ->addIndexColumn()
                ->addColumn('user.name', function ($query) {
                    return $query->user->name;
                })
                ->editColumn('amount', function ($query) {
                    return $query->sum;
                })
                ->addColumn('requested_date', function ($query) {
                    return showDate(@$query->created_at);
                })
                ->editColumn('method', function ($query) {
                    $withdraw = $query;
                    return view('backend.partials._withdrawMethod', compact('withdraw'));
                })
                ->addColumn('status', function ($query) {
                    $status = $query->status == 1 ? 'Paid' : 'Unpaid';
                    return $status;
                })
                ->addColumn('action', function ($query) {
                    if (\auth()->user()->role_id == 1) {
                        $view = '<div class="dropdown CRM_dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button"
                                            id="dropdownMenu2" data-toggle="dropdown"
                                            aria-haspopup="true"
                                            aria-expanded="false">
                                       ' . trans('common.Action') . '
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right"
                                         aria-labelledby="dropdownMenu2">
                                        <a href="#" class="dropdown-item viewdetails" data-instructor_id="' . $query->instructor_id . '"
                                        data-withdraw_id="' . $query->id . '" data-type="1"
                                           type="button">' . trans('Details') . '</a>
                                    </div>
                                </div>';
                    } else {
                        $view = '';
                    }
                    return $view;
                })
                ->rawColumns(['method', 'user.image', 'action'])->make(true);
        } catch (\Exception $e) {
            Log::info($e->getMessage());
        }
    }

    public function getCpPayoutData(Request $request) {
        try {
            $rolesId = $request->rolesId;
            Session::put('rolesId', $rolesId);

            $query = Withdraw::with('user')->select(
                DB::raw('id, instructor_id, invoice_id, status, method, created_at'),
                DB::raw('ROUND(sum(amount), 2) as sum'),
                DB::raw('MONTH(created_at) as month, YEAR(created_at) as year')
            )
            ->groupBy('month','year','instructor_id')
            ->where('type', 1)
            ->whereHas('user', function ($query) {
                return $query->where('role_id', Session::get('rolesId'));
            })
            ->latest();

            $general_data = GeneralSetting::where('key', 'cut_off_date')->first();
            $cut_off_date = ($general_data) ? $general_data->value : "";

            if ($cut_off_date != "" && empty($request->month) && empty($request->year)) {
                $sub_year = now()->subYear()->format('Y');
                $sub_month = now()->subMonth()->format('m');

                if ($sub_month == '12') {
                    $last_date = $sub_year . '-' . $sub_month . '-' . $cut_off_date . ' ' . date('H:m:s');
                } else {
                    $last_date = date('Y') . '-' . $sub_month . '-' . $cut_off_date . ' ' . date('H:m:s');
                }

                $current_date = date('Y-m-d H:m:s');
                $query->whereBetween('created_at', [$last_date, $current_date]);
            }

            if (!empty($request->month)) $query->whereMonth('created_at', $request->month);
            if (!empty($request->year)) $query->whereYear('created_at', $request->year);
            if (!empty($request->instructor)) $query->where('instructor_id', $request->instructor);
            if (Auth::user()->role_id != 1 && Auth::user()->role_id != 5 && Auth::user()->role_id != 6) $query->where('instructor_id', Auth::user()->id);

            return Datatables::of($query)
                ->editColumn('created_at', function ($query) {
                    return date('m/Y', strtotime($query->created_at));
                })
                ->editColumn('payment_date', function ($query) {
                    return showDate($query->created_at);
                })
                ->editColumn('invoice_id', function ($query) {
                    return $query->invoice ? $query->invoice->getInvoice() : 0;
                })
                ->editColumn('sum', function ($query) {
                    return getPriceFormat($query->sum);
                })
                ->addColumn('status', function ($query) {
                    $status = $query->status ? 'Paid' : 'Unpaid';
                    return $status;
                })
                ->addColumn('action', function ($query) {
                    $view = '<div class="dropdown CRM_dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    ' . trans('common.Action') . '
                                </button>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
                                    <a href="#" class="dropdown-item viewdetails"
                                        data-instructor_id="' . $query->instructor_id . '"
                                        data-withdraw_id="' . $query->id . '"
                                        data-type="1"
                                        data-month="' . $query->created_at->format('m') . '"
                                        data-year="' . $query->created_at->format('Y') . '"
                                        type="button">
                                        ' . trans('Details') . '
                                    </a>
                                    <a href="#" class="dropdown-item viewPayMethod"
                                        data-bank_name="' . $query->user->bank_name . '"
                                        data-acc_number="' . $query->user->bank_account_number . '"
                                        data-acc_holder="' . $query->user->account_holder_name . '"
                                        data-bkash="' . $query->user->bkash_number . '"
                                        data-email="' . $query->user->payout_email . '"
                                        data-withdraw_method="' . $query->method . '"
                                        data-withdraw_id="' . $query->id . '">
                                        ' . trans('View Payment Details') . '
                                    </a>
                                    <a href="#" class="dropdown-item downloadPDF"
                                        data-instructor_id="' . $query->instructor_id . '"
                                        data-withdraw_id="' . $query->id . '"
                                        data-date="' . $query->created_at . '"
                                        data-type="2"
                                        type="button">
                                        ' . trans('Download Invoice') . '
                                    </a>
                                </div>
                            </div>';

                    return $view;
                })
                ->rawColumns(['method', 'user.image', 'action'])
                ->make(true);
        } catch (\Exception $e) {
            Log::info($e->getMessage());
        }
    }

    public function getmyllAdminPayoutData(Request $request) {
        try {
            $query = Withdraw::select(
                DB::raw('id, instructor_id, SUM(amount) as amount, type, status, method, created_at'),
                DB::raw('YEAR(created_at) as year, MONTH(created_at) as month')
            )
            ->groupBy('type')
            ->groupBy('year', 'month')
            ->where('status', 0) // show unpaid amount
            ->where('type', 3) // MyLL
            ->latest();

            if (!empty($request->month)) $query->whereMonth('created_at', $request->month);
            if (!empty($request->year)) $query->whereYear('created_at', $request->year);

            return Datatables::of($query)
                ->addIndexColumn()
                ->editColumn('month_year', function ($query) {
                    return date('m/Y', strtotime($query->created_at));
                })
                ->addColumn('amount', function ($query) {
                    $query2 = Withdraw::select(
                        DB::raw('SUM(amount) as amount, type'),
                        DB::raw('YEAR(created_at) as year, MONTH(created_at) as month')
                    )
                    ->groupBy ('year', 'month')
                    ->whereMonth('created_at',$query->month)
                    ->whereYear('created_at',$query->year)
                    ->where('type', 0); // Principle

                    return getPriceFormat($query2->first()->amount);
                })
                ->editColumn('total_revenue', function ($query) {
                    $revenue_query = Withdraw::select(
                        DB::raw('SUM(amount) as amount, type'),
                        DB::raw('YEAR(created_at) as year, MONTH(created_at) as month')
                    )
                    ->groupBy ('year', 'month')
                    ->whereMonth('created_at', $query->month)
                    ->whereYear('created_at', $query->year)
                    ->where('type', 3)->first();

                    $myll_revenue = ($revenue_query) ? $revenue_query->amount : 0;

                    return getPriceFormat($myll_revenue);
                })
                ->editColumn('total_sst', function ($query) {
                    $sst_query = Withdraw::select(
                        DB::raw('SUM(amount) as amount, type'),
                        DB::raw('YEAR(created_at) as year, MONTH(created_at) as month')
                    )
                    ->groupBy ('year', 'month')
                    ->whereMonth('created_at', $query->month)
                    ->whereYear('created_at', $query->year)
                    ->where('type', 4)->first();

                    $tax_amount = ($sst_query) ? $sst_query->amount : 0;

                    return getPriceFormat($tax_amount);
                })
                ->addColumn('action', function ($query) {
                    $taxSetting = TaxSetting::first();
                    $tax = $taxSetting ? $taxSetting->value : 0;
                    $view = '<div class="dropdown CRM_dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                   ' . trans('common.Action') . '
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu2">
                                    <a href="#" class="dropdown-item downloadPDF"
                                        data-instructor_id="' . $query->instructor_id . '"
                                        data-withdraw_id="' . $query->id . '"
                                        data-type="2"
                                        data-date="' . $query->created_at .'"
                                        type="button">
                                        ' . trans('Download PDF') . '
                                    </a>
                                </div>
                            </div>';
                    return $view;
                })
                ->rawColumns(['method', 'user.image', 'action'])
                ->make(true);
        } catch (\Exception $e) {
            Log::info($e->getMessage());
        }
    }

    public function getCpMonthlyStatementReports(Request $request) {
        try {
            $query1 = CourseEnrolled::with('user', 'course', 'checkout')
                ->whereHas('course', function ($course) {
                    return $course->whereHas('user', function ($user) {
                        return $user->whereIn('role_id', [7, 8]);
                    });
                })
                ->whereHas('checkout', function ($checkout) {
                    return $checkout->where('price', '>', 0)->where('status', 1)
                            ->where(function ($q) {
                                $q->where('is_levy_deduction', 0)->where('purchase_price', '!=', 0);
                            }); // this is to show the package is payment by ipay only
                });

            $query2 = LevyCourseEnrolleds::with('user', 'course', 'checkout')
                ->whereHas('course', function ($course) {
                    return $course->whereHas('user', function ($user) {
                        return $user->whereIn('role_id', [7, 8]);
                    });
                })
                ->whereHas('checkout', function ($checkout) {
                        return $checkout->where('price', '>', 0)->where('status', 1);
                })
                ->whereHas('user', function ($query) {
                    $query->where('is_corporate_user', 0)->orWhere('corporate_id', null);
                });

            $query3 = PackageEnrolled::with('user', 'package', 'checkout')
                ->withoutGlobalScope('packageenrolldata')
                ->whereHas('package', function ($package) {
                    return $package->whereHas('user', function ($user) {
                        return $user->whereIn('role_id', [7, 8]);
                    });
                })
                ->whereHas('checkout', function ($checkout) {
                    return $checkout->where('price', '>', 0)->where('status', 1)
                            ->where(function ($q) {
                                $q->where('is_levy_deduction', 0)->where('purchase_price', '!=', 0);
                            }); // this is to show the package is payment by ipay only
                })
                ->whereHas('user', function ($query) {
                    $query->where('is_corporate_user', 0)->orWhere('corporate_id', null);
                });

            $query4 = LevyPackageEnrolleds::with('user', 'package', 'checkout')
                ->whereHas('package', function ($package) {
                    return $package->whereHas('user', function ($user) {
                        return $user->whereIn('role_id', [7, 8]);
                    });
                })
                ->whereHas('checkout', function ($checkout) {
                    return $checkout->where('price', '>', 0)->where('status', 1);
                })
                ->whereHas('user', function ($query) {
                    $query->where('is_corporate_user', 0)->orWhere('corporate_id', null);
                });

            if (!empty($request->start_date) && empty($request->end_date)) {
                Session::put('start_date', $request->start_date);

                $query1->whereDate('created_at', '>=', Session::get('start_date'));
                $query2->whereDate('created_at', '>=', Session::get('start_date'));
                $query3->whereDate('created_at', '>=', Session::get('start_date'));
                $query4->whereDate('created_at', '>=', Session::get('start_date'));
            }

            if (empty($request->start_date) && !empty($request->end_date)) {
                Session::put('end_date', $request->end_date);

                $query1->whereDate('created_at', '<=', Session::get('end_date'));
                $query2->whereDate('created_at', '<=', Session::get('end_date'));
                $query3->whereDate('created_at', '<=', Session::get('end_date'));
                $query4->whereDate('created_at', '<=', Session::get('end_date'));
            }

            if (!empty($request->start_date) && !empty($request->end_date)) {
                Session::put('start_date', $request->start_date);
                Session::put('end_date', $request->end_date);

                $query1->whereDate('created_at', '>=', Session::get('start_date'))->WhereDate('created_at', '<=', Session::get('end_date'));
                $query2->whereDate('created_at', '>=', Session::get('start_date'))->WhereDate('created_at', '<=', Session::get('end_date'));
                $query3->whereDate('created_at', '>=', Session::get('start_date'))->WhereDate('created_at', '<=', Session::get('end_date'));
                $query4->whereDate('created_at', '>=', Session::get('start_date'))->WhereDate('created_at', '<=', Session::get('end_date'));
            }

            if (!empty($request->instructor) || !empty($request->partner)) {
                Session::put('instructor', $request->instructor != '' ? $request->instructor : $request->partner);

                $query1->whereHas('course', function ($course) {
                    return $course->whereHas('user', function ($user) {
                        return $user->where('id', Session::get('instructor'));
                    });
                });

                $query2->whereHas('course', function ($course) {
                    return $course->whereHas('user', function ($user) {
                        return $user->where('id', Session::get('instructor'));
                    });
                });

                $query3->whereHas('package', function ($package) {
                    return $package->whereHas('user', function ($user) {
                        return $user->where('id', Session::get('instructor'));
                    });
                });

                $query4->whereHas('package', function ($package) {
                    return $package->whereHas('user', function ($user) {
                        return $user->where('id', Session::get('instructor'));
                    });
                });
            }

            $query1 = $query1->get()->toBase();
            $query2 = $query2->get()->toBase();
            $query3 = $query3->get()->toBase();
            $query4 = $query4->get()->toBase();

            $query = $query1->merge($query2)->merge($query3)->merge($query4);

            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('transaction_date', function ($query) {
                    return [
                        'display' => Carbon::parse($query->created_at)->format('d-m-Y'),
                        'timestamp' => $query->created_at->timestamp
                    ];
                })
                ->editColumn('product_type', function ($query) {
                    return isset($query->package) ? 'Subscription' : 'E-learning';
                })
                ->editColumn('customer_name', function ($query) {
                    return $query->checkout->user_model->name;
                })
                ->addColumn('tax_invoice_number', function ($query) {
                    return $query->checkout->invoice_no;
                })
                ->addColumn('my_co_id', function ($query) {
                    return @$query->checkout->user_model->identification_number;
                })
                ->editColumn('customer_address', function ($query) {
                    $address = @$query->checkout->user_model->address;
                    $address1 = @$query->checkout->user_model->address2;

                    $full_address = $address.' '.$address1;

                    return strlen($full_address) > 40 ? substr($full_address,0,40)."..." : $full_address;
                })
                ->editColumn('cp_name', function ($query) {
                    return $query->course->user->name ?? $query->package->user->name;
                })
                ->addColumn('course_title', function ($query) {
                    return $query->course->title ?? $query->package->name;
                })
                ->addColumn('qty', function ($query) {
                    return isset($query->package) ? $query->initial_quantity ?? $query->quantity : $query->quantity;
                })
                ->addColumn('unit_price', function ($query) {
                    return getPriceFormat($query->purchase_price);
                })
                ->addColumn('total_sales', function ($query) {
                    $quantity = isset($query->package) ? $query->initial_quantity ?? $query->quantity : $query->quantity;

                    return getPriceFormat($query->purchase_price * $quantity);
                })
                ->addColumn('sst', function ($query) {
                    $tax = TaxSetting::firstOrFail();
                    $quantity = isset($query->package) ? $query->initial_quantity ?? $query->quantity : $query->quantity;

                    return getPriceFormat(($query->purchase_price * $quantity) * $tax->value / 100);
                })
                ->addColumn('total_sales_inclusive_sst', function ($query) {
                    $tax = TaxSetting::firstOrFail();
                    $quantity = isset($query->package) ? $query->initial_quantity ?? $query->quantity : $query->quantity;

                    return getPriceFormat(($query->purchase_price * $quantity) * $tax->value / 100 + ($query->purchase_price * $quantity));
                })
                ->addColumn('content_provider_amount', function ($query) {
                    $commission = 100 - Settings('commission') - Settings('hrdc_commission');
                    $quantity = isset($query->package) ? $query->initial_quantity ?? $query->quantity : $query->quantity;

                    return getPriceFormat(($query->purchase_price * $quantity) * $commission / 100);
                })
                ->addColumn('vendor', function ($query) {
                    $commission = Settings('commission');
                    $quantity = isset($query->package) ? $query->initial_quantity ?? $query->quantity : $query->quantity;

                    return getPriceFormat(($query->purchase_price * $quantity) * $commission / 100);
                })
                ->addColumn('hrdcorp_sst', function ($query) {
                    $commission = Settings('hrdc_commission');
                    $tax = TaxSetting::firstOrFail();
                    $quantity = isset($query->package) ? $query->initial_quantity ?? $query->quantity : $query->quantity;

                    return getPriceFormat(($query->purchase_price * $quantity) * $commission / 100 + ($query->purchase_price * $quantity) * $tax->value / 100);
                })
                ->addColumn('payment_to_hrdcorp', function ($query) {
                    if (isset($query->course)) {
                        $course_package_type = 1;
                        $course_package_id = $query->course_id;
                        $user_id = $query->course->user_id;
                    } else {
                        $course_package_type = 2;
                        $course_package_id = $query->package_id;
                        $user_id = $query->package->user_id;
                    }
                    $enrollsData = EnrolledTotal::where('tracking', $query->tracking)->where('instructor_id', $user_id)->where('course_package_type', $course_package_type)->where('course_package_id', $course_package_id)->first();

                    $withdraw_id = @$enrollsData->withdraw_id;

                    $getPaymentToHrdc = Withdraw::where('id', $withdraw_id)->where('type', 2)->where('status', 1)->first();

                    // $getPaymentToHrdc = Withdraw::where('instructor_id', $user_id)->where('course_package_type', $course_package_type)->where('course_package_id', $course_package_id)->where('type', 2)->where('status', 1)->first();

                    // $getPaymentToHrdc = Withdraw::where('instructor_id', $user_id)->where('user_id', $query->user_id)->where('course_package_type', $course_package_type)->where('course_package_id', $course_package_id)->where('type', 2)->where('status', 1)->first();

                    $date = $getPaymentToHrdc->payment_date ?? 'NONE';

                    return $date;
                })
                ->rawColumns(['customer_name', 'tax_invoice_number', 'my_co_id', 'customer_address', 'cp_name', 'course_title','qty','unit_price'])
                ->make(true);
        } catch (\Exception $e) {
            Log::info($e->getMessage());
        }
    }

    public function getUserDate($id) {
        $user = User::find($id);
        return $user;
    }

    public function enroll_list_excel_download(Request $request) {
        if (check_whether_cp_or_not() || isPartner()){
            return Excel::download(new EnrollExportForCp($request->start_date, $request->end_date, $request->status, $request->name), 'enroll-list.xlsx');
        }else{
            return Excel::download(new EnrollExport($request->start_date, $request->end_date, $request->status, $request->name, $request->email), 'enroll-list.xlsx');
        }

    }

    public function hrdcPayout(Request $request) {
        $rolesId = [2, 7, 8, 9];
        $instructors = User::whereIn('role_id', $rolesId)->get();
        $user = Auth::user();

        $hrdcTotal = HrdcTotalPayout::where('instructor_id', $user->id)->first();
        $remaining = $hrdcTotal->amount ?? 0;

        return view('payment::hrdc_payout', compact('remaining', 'instructors', 'rolesId'));
    }

    public function hrdcRequestPayout(Request $request) {
        try {
            $user = Auth::user();
            $totalPayout = HrdcTotalPayout::where('instructor_id', $user->id)->first();
            $maxAmount = $totalPayout->amount;
            $amount = $request->amount;

            if ($maxAmount < $amount) {
                Toastr::error('Max Limit is ' . getPriceFormat($maxAmount), 'Error');
                return redirect()->back();
            }

            $withdraw = new Withdraw();
            $withdraw->instructor_id = Auth::user()->id;
            $withdraw->amount = $amount;
            $withdraw->issueDate = Carbon::now();
            $withdraw->type = 2; //HRDC
            $withdraw->method = Auth::user()->payout;
            $withdraw->save();
            $totalPayout->amount = $totalPayout->amount - $amount;
            $totalPayout->save();

            Toastr::success('Payment request has been successfully submitted', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function hrdcCompletePayout(Request $request) {
        try {
            $instructor_ids = array_unique(explode(',', $request->instructor_id));
            $withdraws = Withdraw::whereIn('instructor_id', $instructor_ids)->where('type', 2)->where('status', 0)->whereYear('created_at', $request->year)->whereMonth('created_at', $request->month)->get();

            foreach ($withdraws as $withdraw) {
                $withdraw->status = 1;
                $withdraw->payment_date = Carbon::now();
                $withdraw->save();

                if ($withdraw->save()) {
                    $instractor = User::find($withdraw->instructor_id);

                    if ($instractor) {
                        $instractor->balance += $withdraw->amount;
                        $instractor->save();
                    }
                }
            }

            Toastr::success('Payment request has been Approved', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function getHrdcPayoutData(Request $request) {
        try {
            $query = Withdraw::select(
                DB::raw('group_concat(instructor_id) as instructor_ids'),
                DB::raw('id, sum(amount) as amount, status, created_at, updated_at, payment_date'),
                DB::raw('MONTH(created_at) as month, YEAR(created_at) as year'),
                DB::raw('ROUND(sum(amount),2) as sum')
            )
            ->groupBy('month', 'year')
            ->where('type', 2) // HRDC
            ->latest();

            if (!empty($request->month)) $query->whereMonth('created_at', $request->month);
            if (!empty($request->year)) $query->whereYear('created_at', $request->year);

            return Datatables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function ($query) {
                if (auth()->user()->role_id == 1 || auth()->user()->role_id == 5) {
                    $view = '<div class="dropdown CRM_dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button"
                                        id="dropdownMenu2" data-toggle="dropdown"
                                        aria-haspopup="true"
                                        aria-expanded="true">
                                   ' . trans('common.Action') . '
                                </button>
                                <div class="dropdown-menu dropdown-menu-right"
                                     aria-labelledby="dropdownMenu2">
                                     <a href="#" class="dropdown-item viewdetails"
                                        data-instructor_id="' . $query->instructor_ids . '"
                                        data-withdraw_id="' . $query->id . '"
                                        data-type="2"
                                        data-month="' . $query->created_at->format('m') . '"
                                        data-year="' . $query->created_at->format('Y') . '"
                                        type="button">' . trans('Details') . '</a>
                                </div>
                            </div>';
                }

                return $view;
            })
            ->editColumn('created_at', function ($query) {
                return date('m/Y', strtotime($query->created_at));
            })
            ->addColumn('total_amount', function ($query) {
                $sales_query = Withdraw::select(
                    DB::raw('SUM(amount) as amount, type'),
                    DB::raw('YEAR(created_at) as year, MONTH(created_at) as month')
                )
                ->groupBy ('year', 'month')
                ->whereMonth('created_at', $query->month)
                ->whereYear('created_at', $query->year)
                ->where('type', 0)->first();

                $tax_amount = ($sales_query) ? $sales_query->amount : 0;

                return getPriceFormat($tax_amount);
            })
            ->editColumn('total_revenue', function ($query) {
                return getPriceFormat($query->amount);
            })
            ->editColumn('payable_amount', function ($query) {
                return getPriceFormat($query->sum);
            })
            ->editColumn('payment_date', function ($query) {
                return ($query->status == 1) ? showDate($query->payment_date) : '';
            })
            ->addColumn('payment_status', function ($query) {
                $status = ($query->status == 1) ? 'Paid' : 'Unpaid';
                return $status;
            })
            ->rawColumns(['action'])
            ->make(true);
    } catch (\Exception $e) {
            Log::info($e->getMessage());
        }
    }

    public function transaction_download_pdf(Request $request) {
        $taxSetting = TaxSetting::firstOrFail();
        $courseTransactionForCp = [];

        $query = Withdraw::select(
            DB::raw('instructor_id, status, method, created_at, invoice_id, issueDate'),
            DB::raw('ROUND(sum(amount), 2) as sum')
        )
        ->where('id', $request->withdraw_id)->first();

        $hrdc_user = User::where('role_id', 5)->first();
        $cut_off_start = Carbon::parse($request->date)->subMonth()->format('Y-m-d');
        $cut_off_end = Carbon::parse($request->date)->format('Y-m-d');

        $query1 = CourseEnrolled::with('user', 'course', 'checkout')
            ->withoutGlobalScope('courseenrolldata')
            ->whereHas('course', function ($course) {
                return $course->whereHas('user', function ($user) {
                    return $user->whereIn('role_id', [7, 8]);
                });
            })
            ->whereHas('checkout', function ($checkout) {
                return $checkout->where('price', '>', 0)->where('status', 1)
                    ->where(function ($q) {
                        $q->where('is_levy_deduction', 0)->where('purchase_price', '!=', 0);
                    }); // this is to show the package is payment by ipay only
            })
            ->whereDate('created_at', '>=', $cut_off_start)
            ->whereDate('created_at', '<=', $cut_off_end);

        $query2 = LevyCourseEnrolleds::with('user', 'course', 'checkout')
            ->whereHas('course', function ($course) {
                return $course->whereHas('user', function ($user) {
                    return $user->whereIn('role_id', [7, 8]);
                });
            })
            ->whereHas('checkout', function ($checkout) {
                return $checkout->where('price', '>', 0)->where('status', 1);
            })
            ->whereDate('created_at', '>=', $cut_off_start)
            ->whereDate('created_at', '<=', $cut_off_end);

        $query3 = PackageEnrolled::with('user', 'package', 'checkout')
            ->whereHas('package', function ($package) {
                return $package->whereHas('user', function ($user) {
                    return $user->whereIn('role_id', [7, 8]);
                });
            })
            ->whereHas('checkout', function ($checkout) {
                return $checkout->where('price', '>', 0)->where('status', 1)
                    ->where(function ($q) {
                        $q->where('is_levy_deduction', 0)->where('purchase_price', '!=', 0);
                    }); // this is to show the package is payment by ipay only
            })
            ->whereDate('created_at', '>=', $cut_off_start)
            ->whereDate('created_at', '<=', $cut_off_end);

        $query4 = LevyPackageEnrolleds::with('user', 'package', 'checkout')
            ->whereHas('package', function ($package) {
                return $package->whereHas('user', function ($user) {
                    return $user->whereIn('role_id', [7, 8]);
                });
            })
            ->whereHas('checkout', function ($checkout) {
                return $checkout->where('price', '>', 0)->where('status', 1);
            })
            ->whereDate('created_at', '>=', $cut_off_start)
            ->whereDate('created_at', '<=', $cut_off_end);

        $query1 = $query1->get()->toBase();
        $query2 = $query2->get()->toBase();
        $query3 = $query3->get()->toBase();
        $query4 = $query4->get()->toBase();
        $all_enrolleds = $query1->merge($query2)->merge($query3)->merge($query4);

        foreach ($all_enrolleds as $coursePackageEnrolled) {
            $courseTitle = [];
            $qty = [];
            $coursePrice = [];
            $courseIds = [];

            if (!empty($coursePackageEnrolled->course)) {
                if ($coursePackageEnrolled->course->user->id == $query->instructor_id) {
                    $courseTitle[$coursePackageEnrolled->course_id] = $coursePackageEnrolled->course->title;
                    $qty[$coursePackageEnrolled->course_id] = $coursePackageEnrolled->quantity;
                    $coursePrice[$coursePackageEnrolled->course_id] = $coursePackageEnrolled->purchase_price;
                    $courseIds[] = $coursePackageEnrolled->course->id;
                }
            }

            if (!empty($coursePackageEnrolled->package)) {
                if ($coursePackageEnrolled->package->user->id == $query->instructor_id) {
                    $courseTitle[$coursePackageEnrolled->package_id] = $coursePackageEnrolled->package->name;
                    $qty[$coursePackageEnrolled->package_id] = $coursePackageEnrolled->initial_quantity ?? $coursePackageEnrolled->quantity;
                    $coursePrice[$coursePackageEnrolled->package_id] = $coursePackageEnrolled->purchase_price;
                    $courseIds[] = $coursePackageEnrolled->package->id;
                }
            }

            foreach ($courseIds as $courseId) {
                if (isset($courseTransactionForCp[$courseId])) {
                    $courseTransactionForCp[$courseId]['qty'] += $qty[$courseId];
                } else {
                    $courseTransactionForCp[$courseId] = [
                        'title' => $courseTitle[$courseId] ?? null,
                        'qty' => $qty[$courseId],
                        'unit_price' => $coursePrice[$courseId],
                    ];
                }
            }
        }

        $datas = $courseTransactionForCp;

        $pdf = PDF::loadView('transaction_download_pdf', compact('query', 'datas', 'taxSetting', 'hrdc_user'))->setPaper('A4','landscape');
        return $pdf->download('transaction_download_pdf.pdf');
    }

    public function transaction_myll_admin_download_pdf(Request $request) {
        $taxSetting = TaxSetting::firstOrFail();
        $hrdc_user = User::where('role_id', 5)->first();
        $courseTransactionForCp = [];

        $query = Withdraw::select(
                DB::raw('instructor_id, SUM(amount) as amount, type, status, method, created_at, invoice_id'),
                DB::raw('YEAR(created_at) as year, MONTH(created_at) as month')
            )
            ->where('id', $request->withdraw_id)->first();

        $cut_off_end = Carbon::parse($request->date)->subDay()->format('Y-m-d');
        $cut_off_start = Carbon::parse($request->date)->subMonth()->format('Y-m-d');

        $query1 = CourseEnrolled::with('user', 'course', 'checkout')
            ->withoutGlobalScope('courseenrolldata')
            ->whereHas('course', function ($course) {
                return $course->whereHas('user', function ($user) {
                    return $user->whereIn('role_id', [7, 8]);
                });
            })
            ->whereHas('checkout', function ($checkout) {
                return $checkout->where('price', '>', 0)->where('status', 1)
                    ->where(function ($q) {
                        $q->where('is_levy_deduction', 0)->where('purchase_price', '!=', 0);
                    }); // this is to show the package is payment by ipay only
            })
            ->whereDate('created_at', '>=', $cut_off_start)
            ->whereDate('created_at', '<=', $cut_off_end);

        $query2 = LevyCourseEnrolleds::with('user', 'course', 'checkout')
            ->whereHas('course', function ($course) {
                return $course->whereHas('user', function ($user) {
                    return $user->whereIn('role_id', [7, 8]);
                });
            })
            ->whereHas('checkout', function ($checkout) {
                return $checkout->where('price', '>', 0)->where('status', 1);
            })
            ->whereDate('created_at', '>=', $cut_off_start)
            ->whereDate('created_at', '<=', $cut_off_end);

        $query3 = PackageEnrolled::with('user', 'package', 'checkout')
            ->whereHas('package', function ($package) {
                return $package->whereHas('user', function ($user) {
                    return $user->whereIn('role_id', [7, 8]);
                });
            })
            ->whereHas('checkout', function ($checkout) {
                return $checkout->where('price', '>', 0)->where('status', 1)
                    ->where(function ($q) {
                        $q->where('is_levy_deduction', 0)->where('purchase_price', '!=', 0);
                    }); // this is to show the package is payment by ipay only
            })
            ->whereDate('created_at', '>=', $cut_off_start)
            ->whereDate('created_at', '<=', $cut_off_end);

        $query4 = LevyPackageEnrolleds::with('user', 'package', 'checkout')
            ->whereHas('package', function ($package) {
                return $package->whereHas('user', function ($user) {
                    return $user->whereIn('role_id', [7, 8]);
                });
            })
            ->whereHas('checkout', function ($checkout) {
                return $checkout->where('price', '>', 0)->where('status', 1);
            })
            ->whereDate('created_at', '>=', $cut_off_start)
            ->whereDate('created_at', '<=', $cut_off_end);

        $query1 = $query1->get()->toBase();
        $query2 = $query2->get()->toBase();
        $query3 = $query3->get()->toBase();
        $query4 = $query4->get()->toBase();
        $all_enrolleds = $query1->merge($query2)->merge($query3)->merge($query4);

        foreach ($all_enrolleds as $coursePackageEnrolled) {
            $courseTitle = [];
            $qty = [];
            $coursePrice = [];
            $courseIds = [];

            if (!empty($coursePackageEnrolled->course)) {
                // if ($coursePackageEnrolled->course->user->id == $query->instructor_id) {
                    $courseTitle[$coursePackageEnrolled->course_id] = $coursePackageEnrolled->course->title;
                    $qty[$coursePackageEnrolled->course_id] = $coursePackageEnrolled->quantity;
                    $coursePrice[$coursePackageEnrolled->course_id] = $coursePackageEnrolled->purchase_price;
                    $courseIds[] = $coursePackageEnrolled->course->id;
                //}
            }

            if (!empty($coursePackageEnrolled->package)) {
                //if ($coursePackageEnrolled->package->user->id == $query->instructor_id) {
                    $courseTitle[$coursePackageEnrolled->package_id] = $coursePackageEnrolled->package->name;
                    $qty[$coursePackageEnrolled->package_id] = $coursePackageEnrolled->initial_quantity ?? $coursePackageEnrolled->quantity;
                    $coursePrice[$coursePackageEnrolled->package_id] = $coursePackageEnrolled->purchase_price;
                    $courseIds[] = $coursePackageEnrolled->package->id;
                //}
            }

            foreach ($courseIds as $courseId) {
                if (isset($courseTransactionForCp[$courseId])) {
                    $courseTransactionForCp[$courseId]['qty'] += $qty[$courseId];
                } else {
                    $courseTransactionForCp[$courseId] = [
                        'title' => $courseTitle[$courseId] ?? null,
                        'qty' => $qty[$courseId],
                        'unit_price' => $coursePrice[$courseId],
                    ];
                }
            }
        }

        $datas = $courseTransactionForCp;
        $pdf = PDF::loadView('transaction_download_myll_pdf', compact('query', 'datas', 'taxSetting', 'hrdc_user'))->setPaper('A4','landscape');
        return $pdf->download('transaction_download_myll_pdf.pdf');
    }

    public function transaction_list_ajax(Request $request) {
        $withdraw = Withdraw::with('user')->select(
                    DB::raw('group_concat(instructor_id) as instructor_ids'),
                    DB::raw('id, status, created_at'),
                    DB::raw('MONTH(created_at) as month, YEAR(created_at) as year'),
                    DB::raw('ROUND(sum(amount), 2) as amount')
                )
                ->where('type', $request->type)
                ->latest();

        if ($request->type == 1) {
            $withdraw = $withdraw->where('instructor_id', $request->instructor_id)->groupBy('instructor_id');

            if (Session::has('rolesId') && Session::get('rolesId') != '') {
                $withdraw = $withdraw->whereHas('user', function ($query) {
                    return $query->where('role_id', Session::get('rolesId'));
                });
            }

            $general_data = GeneralSetting::where('key', 'cut_off_date')->first();
            $cut_off_date = ($general_data) ? $general_data->value : "";

            if ($cut_off_date != "" && empty($request->month) && empty($request->year)) {
                $sub_year = now()->subYear()->format('Y');
                $sub_month = now()->subMonth()->format('m');

                if ($sub_month == '12') {
                    $last_date = $sub_year . '-' . $sub_month . '-' . $cut_off_date . ' ' . date('H:m:s');
                } else {
                    $last_date = date('Y') . '-' . $sub_month . '-' . $cut_off_date . ' ' . date('H:m:s');
                }

                $current_date = date('Y-m-d H:m:s');
                $withdraw = $withdraw->whereBetween('created_at', [$last_date, $current_date]);
            }
        } else {
            $withdraw = $withdraw->groupBy('month', 'year');
        }

        if (!empty($request->month)) $withdraw->whereMonth('created_at', $request->month);
        if (!empty($request->year)) $withdraw->whereYear('created_at', $request->year);

        $withdraw = $withdraw->first();

        return response()->json(['status' => 1, 'data' => $withdraw, 'is_myll_admin' => $request->is_myll_admin ?? '']);
    }

    public function callPayoutCron() {
        $user = auth()->user();
        if ($user->role_id != 1 && $user->role_id != 5 && $user->role_id != 6) {
            Toastr::error('Permission Denied', trans('common.Failed'));
            return redirect()->back();
        }
        Artisan::call('payout:cron --manual=1');
        Toastr::success('Payout calculate successfully', 'Success');
        return redirect()->back();
    }

     public function bundleSales() {
        $search_instructor = $request->instructor ?? '';
        $search_partner = $request->partner ?? '';
        $content_providers = User::where('role_id', [7,8])->get();
        $corporate_admins = User::where('role_id', 11)->get();

       return view('bundle_sales',compact('content_providers','corporate_admins','search_instructor','search_partner'));
    }

    public function bundleSalesData(Request $request) {
        try {

            $query = Checkout::with('package','package.corporate_user','package.user')->where('status',1);
            $query->whereHas('package', function ($q) {
                        $q->where('package_type','1');
                    });
            if (!empty($request->content_provider)){
                Session::put('content_provider', $request->content_provider);
                $query->whereHas('package', function ($q) {
                        $q->where('user_id',Session::get('content_provider'));
                    });

            }
            if(!empty($request->corporate_admin)){
                Session::put('corporate_admin', $request->corporate_admin);
                 $query->whereHas('package', function ($q) {
                        $q->where('corporate_id',Session::get('corporate_admin'));
                    });
            }
            $query = $query->get();
            return Datatables::of($query)
                ->addIndexColumn()
                ->editColumn('package_name',function($query){
                    return $query->package->name;
                })
                ->editColumn('content_provider_name',function($query){
                    return $query->package->user->name;
                })
                ->editColumn('corporate_name',function($query){
                    return $query->package->corporate_user->name;
                })
                ->editColumn('transaction_date', function ($query) {
                    return date('m-d-Y', strtotime($query->created_at));
                })
                 ->rawColumns(['package_name','transaction_date', 'content_provider_name','corporate_name'])
                ->make(true);

        } catch (\Exception $e) {
            Log::info($e->getMessage());
        }
    }

    public function auditTrailCustomPackage() {
        return view('coursesetting::audit_trail_custom_package');
    }

    public function auditTrailCustomPackageData(Request $request) {
        $query = auditTrailPackage::latest()->with('package');
        $query->whereHas('package', function ($q) {
                        $q->where('package_type','1');
                    });
        // if (!empty($request->email)) {
        //     $query->where('learner_name', 'LIKE', '%' . $request->email . '%')->orWhere('email', 'LIKE', '%' . $request->email . '%');
        // }

        if (!empty($request->start_date) && empty($request->end_date)) {
            $query->where('created_at', '>=', $request->start_date);
        }

        if (!empty($request->start_date) && $request->start_date != "") {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if (!empty($request->end_date) && $request->end_date != "") {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        return Datatables::of($query)
            ->addIndexColumn()
            ->addColumn('created_at', function ($query) {
                return $query->created_at;
            })
            ->editColumn('package_name',function($query){
                return $query->package->name;
            })
            ->addColumn('user', function ($query) {
                return !empty($query->user->name) ? $query->user->name : 'Guest';
            })
            ->addColumn('action', function ($query) {
                $view = '<button class="dropdown-item viewStudentAuditTrail"
                                 data-id="' . $query->id . '"
                                 type="button">' . trans('common.View') . '</button>';
                $actioinView = ' <div class="dropdown CRM_dropdown">
                                     <div class="btn btn-info">
                                         ' . $view . '
                                     </div>
                                 </div>';

                return $actioinView;
            })->rawColumns(['action','package_name'])->make(true);
    }

    public function getCompareAuditTrailCustomPackageData($id) {
         $columnChanges = [];
         $dataChanges = [];

        $changes = auditTrailPackage::select("subject")->where("id", $id)->first();

        $changes = json_decode($changes["subject"], true);
        //dd($changes);
        foreach ($changes as $key => $one) {
            if ($key != "updated_at" && $key != "password") {
                $columnChanges[] = $key;
                $dataChanges[] = $one;
            }
        }
        $html = view('coursesetting::compare_audit_trail', ['dataChanges' => $dataChanges, "columnChanges" => $columnChanges])->render();

        return $html;
    }

    public function monthlyStatementReportsCorporateAccess(Request $request) {
        $search_instructor = $request->instructor ?? '';
        $search_partner = $request->partner ?? '';
        $instructors = User::where('role_id', 7)->get();
        $partners = User::where('role_id', 8)->get();

        return view('payment::ca_monthly_statement_reports', compact('instructors', 'partners', 'search_instructor', 'search_partner'));
    }

    public function getCaMonthlyStatementReports(Request $request) {
        try {
            $query1 = CourseEnrolled::with('user', 'course', 'checkout')
                ->withoutGlobalScope('courseenrolldata')
                ->whereHas('course', function ($course) {
                    return $course->whereHas('user', function ($user) {
                        return $user->whereIn('role_id', [7, 8]);
                    });
                })
                ->whereHas('checkout', function ($checkout) {
                    return $checkout->where('price', '>', 0)->where('status', 1)
                    ->where(function ($q) {
                        $q->where('is_levy_deduction', 0)->where('purchase_price', '!=', 0);
                    }); // this is to show the package is payment by ipay only
                })
                ->whereHas('user', function ($query) {
                    $query->withoutGlobalScope('userdata')->where('is_corporate_user', '=', 1)->orWhere('corporate_id', '!=', null);
                });

            $query2 = LevyCourseEnrolleds::with('user', 'course', 'checkout')
                ->whereHas('course', function ($course) {
                    return $course->whereHas('user', function ($user) {
                        return $user->whereIn('role_id', [7, 8]);
                    });
                })
                ->whereHas('checkout', function ($checkout) {
                    return $checkout->where('price', '>', 0)->where('status', 1);
                })
                ->whereHas('user', function ($query) {
                    $query->where('is_corporate_user', '=', 1)->orWhere('corporate_id', '!=', null);
                });

            $query3 = PackageEnrolled::with('user', 'package', 'checkout')
                ->whereHas('package', function ($package) {
                    return $package->whereHas('user', function ($user) {
                        return $user->whereIn('role_id', [7, 8]);
                    });
                })
                ->whereHas('checkout', function ($checkout) {
                    return $checkout->where('price', '>', 0)->where('status', 1)
                    ->where(function ($q) {
                        $q->where('is_levy_deduction', 0)->where('purchase_price', '!=', 0);
                    }); // this is to show the package is payment by ipay only
                });

            $query4 = LevyPackageEnrolleds::with('user', 'package', 'checkout')
                ->whereHas('package', function ($package) {
                    return $package->whereHas('user', function ($user) {
                        return $user->whereIn('role_id', [7, 8]);
                    });
                })
                ->whereHas('checkout', function ($checkout) {
                    return $checkout->where('price', '>', 0)->where('status', 1);
                })
                ->whereHas('user', function ($query) {
                    $query->where('is_corporate_user', '=', 1)->orWhere('corporate_id', '!=', null);
                });

            if (!empty($request->start_date) && empty($request->end_date)) {
                Session::put('start_date', $request->start_date);

                $query1->whereDate('created_at', '>=', Session::get('start_date'));
                $query2->whereDate('created_at', '>=', Session::get('start_date'));
                $query3->whereDate('created_at', '>=', Session::get('start_date'));
                $query4->whereDate('created_at', '>=', Session::get('start_date'));
            }

            if (empty($request->start_date) && !empty($request->end_date)) {
                Session::put('end_date', $request->end_date);

                $query1->whereDate('created_at', '<=', Session::get('end_date'));
                $query2->whereDate('created_at', '<=', Session::get('end_date'));
                $query3->whereDate('created_at', '<=', Session::get('end_date'));
                $query4->whereDate('created_at', '<=', Session::get('end_date'));
            }

            if (!empty($request->start_date) && !empty($request->end_date)) {
                Session::put('start_date', $request->start_date);
                Session::put('end_date', $request->end_date);

                $query1->whereDate('created_at', '>=', Session::get('start_date'))->WhereDate('created_at', '<=', Session::get('end_date'));
                $query2->whereDate('created_at', '>=', Session::get('start_date'))->WhereDate('created_at', '<=', Session::get('end_date'));
                $query3->whereDate('created_at', '>=', Session::get('start_date'))->WhereDate('created_at', '<=', Session::get('end_date'));
                $query4->whereDate('created_at', '>=', Session::get('start_date'))->WhereDate('created_at', '<=', Session::get('end_date'));
            }

            if (!empty($request->instructor) || !empty($request->partner)) {
                Session::put('instructor', $request->instructor != '' ? $request->instructor : $request->partner);

                $query1->whereHas('course', function ($course) {
                    return $course->whereHas('user', function ($user) {
                        return $user->where('id', Session::get('instructor'));
                    });
                });

                $query2->whereHas('course', function ($course) {
                    return $course->whereHas('user', function ($user) {
                        return $user->where('id', Session::get('instructor'));
                    });
                });

                $query3->whereHas('package', function ($package) {
                    return $package->whereHas('user', function ($user) {
                        return $user->where('id', Session::get('instructor'));
                    });
                });

                $query4->whereHas('package', function ($package) {
                    return $package->whereHas('user', function ($user) {
                        return $user->where('id', Session::get('instructor'));
                    });
                });
            }

            $query1 = $query1->get()->toBase();
            $query2 = $query2->get()->toBase();
            $query3 = $query3->get()->toBase();
            $query4 = $query4->get()->toBase();
            $query = $query1->merge($query2)->merge($query3)->merge($query4);

            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('transaction_date', function ($query) {
                    return [
                        'display' => Carbon::parse($query->created_at)->format('d-m-Y'),
                        'timestamp' => $query->created_at->timestamp
                    ];
                })
                ->addColumn('transaction_id', function ($query) {
                    return $query->checkout->tracking;
                })
                ->addColumn('customer_corporate_name', function ($query) {
                    return @$query->checkout->user_model->corporate_admin->corporate->name;
                })
                ->editColumn('customer_name', function ($query) {
                    return $query->checkout->user_model->name;
                })
                ->addColumn('tax_invoice_number', function ($query) {
                    return $query->checkout->invoice_no;
                })
                ->addColumn('my_co_id', function ($query) {
                    $my_co_id = '';
                    $ic_no = '';
                    $mycoid_icno = 'N/A';

                    if (isset($query->checkout) && isset($query->checkout->user_model) && isset($query->checkout->user_model->corporate_admin->corporate)) {
                        $my_co_id = $query->checkout->user_model->corporate_admin->corporate->my_co_id;
                    }

                    if (isset($query->checkout) && isset($query->checkout->user_model)) {
                        $ic_no = $query->checkout->user_model->identification_number;
                    }

                    if ($my_co_id != '') {
                        $mycoid_icno = $my_co_id;
                    } elseif ($my_co_id == '' && $ic_no != '') {
                        $mycoid_icno = $ic_no;
                    }

                    return $mycoid_icno;
                })
                ->editColumn('customer_address', function ($query) {
                    $address = @$query->checkout->user_model->corporate_admin->corporate->address;
                    $city = @$query->checkout->user_model->corporate_admin->corporate->city->name;
                    $postcode = @$query->checkout->user_model->corporate_admin->corporate->postcode;

                    $full_address = $address.', '.$city.', '.$postcode;

                    return strlen($full_address) > 40 ? substr($full_address, 0, 40)."..." : $full_address;
                })
                ->editColumn('cp_name', function ($query) {
                    return $query->course->user->name ?? $query->package->user->name;
                })
                ->addColumn('course_title', function ($query) {
                    return $query->course->title ?? $query->package->name;
                })
                ->addColumn('qty', function ($query) {
                    $quantity = isset($query->package) ? $query->initial_quantity ?? $query->quantity : $query->quantity;

                    return $quantity;
                })
                ->addColumn('unit_price', function ($query) {
                    return getPriceFormat($query->purchase_price);
                })
                ->addColumn('total_sales', function ($query) {
                    $quantity = isset($query->package) ? $query->initial_quantity ?? $query->quantity : $query->quantity;

                    return getPriceFormat($query->purchase_price * $quantity);
                })
                ->editColumn('payment_type', function ($query) {
                    return $query->checkout->payment_method;
                })
                ->addColumn('amount_paid_via_levy', function ($query) {
                    return (getPriceFormat($query->checkout->levy_deduction) == 'Free') ? 'NONE' :  getPriceFormat($query->checkout->levy_deduction);
                })
                ->addColumn('amount_paid_via_ipay', function ($query) {
                    return (getPriceFormat($query->checkout->purchase_price) == 'Free') ? 'NONE' : getPriceFormat($query->checkout->purchase_price);
                })
                ->addColumn('sst', function ($query) {
                    $tax = TaxSetting::firstOrFail();
                    $quantity = isset($query->package) ? $query->initial_quantity ?? $query->quantity : $query->quantity;

                    return getPriceFormat(($query->purchase_price * $quantity) * $tax->value / 100);
                })
                ->addColumn('total_sales_inclusive_sst', function ($query) {
                    $tax = TaxSetting::firstOrFail();
                    $quantity = isset($query->package) ? $query->initial_quantity ?? $query->quantity : $query->quantity;

                    return getPriceFormat(($query->purchase_price * $quantity) * $tax->value / 100 + ($query->purchase_price * $quantity));
                })
                ->addColumn('content_provider_amount', function ($query) {
                    $commission = 100 - Settings('commission') - Settings('hrdc_commission');
                    $quantity = isset($query->package) ? $query->initial_quantity ?? $query->quantity : $query->quantity;

                    return getPriceFormat(($query->purchase_price * $quantity) * $commission / 100);
                })
                ->addColumn('vendor', function ($query) {
                    $commission = Settings('commission');
                    $quantity = isset($query->package) ? $query->initial_quantity ?? $query->quantity : $query->quantity;

                    return getPriceFormat(($query->purchase_price * $quantity) * $commission / 100);
                })
                ->addColumn('hrdcorp_sst', function ($query) {
                    $commission = Settings('hrdc_commission');
                    $tax = TaxSetting::firstOrFail();
                    $quantity = isset($query->package) ? $query->initial_quantity ?? $query->quantity : $query->quantity;

                    return getPriceFormat(($query->purchase_price * $quantity) * $commission / 100 + ($query->purchase_price * $quantity) * $tax->value / 100);
                })
                ->addColumn('payment_to_hrdcorp', function ($query) {
                    $getPaymentToHrdc = Withdraw::where('instructor_id', $query->course->user->id ?? $query->package->user->id)->where('status', 1)->first();

                    $date = $getPaymentToHrdc->payment_date ?? 'NONE';

                    return $date;
                })
                ->rawColumns(['customer_name', 'tax_invoice_number', 'my_co_id', 'customer_address', 'cp_name', 'course_title', 'qty', 'unit_price'])
                ->make(true);
        } catch (\Exception $e) {
            Log::info($e->getMessage());
        }
    }

    public function ca_export_monthly_statement_report(Request $request) {
        return Excel::download(new CorporateAccessExportMonthlyStatementReport($request->partner, $request->instructor, $request->start_date, $request->end_date), 'corporate-access-monthly-statement-report.csv');
    }
}
