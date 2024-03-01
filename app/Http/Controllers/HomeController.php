<?php

namespace App\Http\Controllers;

use App\User;
use App\UserLogin;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Modules\CourseSetting\Entities\Course;
use Modules\CourseSetting\Entities\CourseEnrolled;
use Modules\Payment\Entities\Withdraw;
use Omnipay\MobilPay\Api\Request;
use Illuminate\Support\Facades\Log;
use Modules\CourseSetting\Entities\LevyCourseEnrolleds;
use Modules\CourseSetting\Entities\PackageEnrolled;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        $this->middleware(['auth', 'verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index()
    {

        if (Auth::user()->role_id == 1) {
            return redirect()->route('dashboard');
        } else {
            return redirect('/');
        }
    }


    // dashboard
    public function dashboard()
    {
        try {
            return view('dashboard');
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function userLoginChartByDays(\Illuminate\Http\Request $request)
    {
        $userLoginChartByDays = [];
        $type = $request->type;
        $days = $request->days;

        if ($type == "days") {

            $from = Carbon::now()->subDays($days - 1);
            $to = Carbon::now();
        } else {
            $allDays = explode(' - ', $days);
            $from = Carbon::parse($allDays[0]);
            $to = Carbon::parse($allDays[1]);
        }


        $period = CarbonPeriod::create($from, $to);
        $dates = [];
        $data = [];

        foreach ($period as $key => $value) {
            $day = $value->format('Y-m-d');;
            $dates[] = $day;
            $data[] = UserLogin::whereDate('login_at', $day)->count();
        }
        $userLoginChartByDays['date'] = $dates;
        $userLoginChartByDays['data'] = $data;

        return $userLoginChartByDays;
    }

    public function userLoginChartByTime(\Illuminate\Http\Request $request)
    {
        $userLoginChartByDays = [];
        $type = $request->type;
        $days = $request->days;

        if ($type == "days") {

            $from = Carbon::now()->subDays($days - 1);
            $to = Carbon::now();
        } else {
            $allDays = explode(' - ', $days);
            $from = Carbon::parse($allDays[0]);
            $to = Carbon::parse($allDays[1]);
        }


        $period = CarbonPeriod::create($from, $to);
        $hours = [];

        foreach ($period as $key => $value) {
            $day = $value->format('Y-m-d');


            $loginData = UserLogin::whereDate('login_at', $day)->get(['id', 'login_at'])->groupBy(function ($date) {
                return Carbon::parse($date->login_at)->format('H');
            });

            for ($i = 0; $i <= 23; $i++) {
                if (!isset($hours[$i])) {
                    $hours[$i] = 0;
                }
                if (!isset($loginData[$i])) {
                    $loginData[$i] = [];
                }
                $hours[$i] = count($loginData[$i]) + $hours[$i];
            }
        }
        return $hours;
    }

    public function getDashboardData()
    {
        try {
            $user = Auth::user();
            $totallearner = 0;

            if ($user->role_id == 2) {
                // $allCourseEnrolled = CourseEnrolled::with('user', 'course')
                //     ->whereHas('course', function ($query) use ($user) {
                //         $query->where('user_id', '=', $user->id);
                //     })->get();

                $allCourses = Course::where('user_id', $user->id)->where('type', 1)->get();
                $published_course = Course::where('user_id', $user->id)->where('status', 1)->get();
                $inreview_course = Course::where('user_id', $user->id)->where('status', 0)->get();

                // $thisMonthEnroll = CourseEnrolled::whereYear('created_at', Carbon::now()->year)
                //     ->whereMonth('created_at', Carbon::now()->format('m'))
                //     ->whereHas('course', function ($query) use ($user) {
                //         $query->where('user_id', '=', $user->id);
                //     })->sum('reveune');

                $today = CourseEnrolled::whereDate('created_at', Carbon::today())
                    ->whereHas('course', function ($query) use ($user) {
                        $query->where('user_id', '=', $user->id);
                    })->sum('reveune');

                //$rev = $allCourseEnrolled->sum('reveune');

                /* CourseEnrolleds ' Sales */
                $commission = 100 - Settings('commission') - Settings('hrdc_commission');
                $query1 = CourseEnrolled::with('user', 'course', 'checkout')
                    ->whereHas('course', function ($query) use ($user) {
                        $query->where('user_id', '=', $user->id);
                    })
                    ->whereHas(
                        'user',
                        function ($user) {
                            return $user->whereHas('role', function ($role) {
                                return $role->where('name', '!=', 'Corporate Admin');
                            });
                        }
                    )->whereHas('checkout', function ($checkout) {
                        return $checkout->where('price', '>', 0)->where('status', 1);
                    })->select(DB::raw('ROUND(sum(purchase_price * quantity * ' . $commission / 100 . '), 2) as Revenue, ROUND(sum(purchase_price * quantity), 2) as Total'))->first();

                $query2 = LevyCourseEnrolleds::with('user', 'course', 'checkout')
                    ->whereHas('course', function ($query) use ($user) {
                        $query->where('user_id', '=', $user->id);
                    })
                    ->whereHas('checkout', function ($checkout) {
                        return $checkout->where('price', '>', 0)->where('status', 1);
                    })->select(DB::raw('ROUND(sum(purchase_price * quantity * ' . $commission / 100 . '), 2) as Revenue, ROUND(sum(purchase_price * quantity), 2) as Total'))->first();

                $query3 = PackageEnrolled::with('user', 'package', 'checkout')
                    ->whereHas('package', function ($query) use ($user) {
                        $query->where('user_id', '=', $user->id);
                    })
                    ->whereHas('checkout', function ($checkout) {
                        return $checkout->where('price', '>', 0)->where('status', 1);
                    })->select(DB::raw('ROUND(sum(purchase_price * initial_quantity * ' . $commission / 100 . '), 2) as Revenue, ROUND(sum(purchase_price * initial_quantity), 2) as Total'))->first();

                $all_course_enrolled_revenue = $query1->Revenue + $query2->Revenue + $query3->Revenue;
                $all_course_enrolled_total = $query1->Total + $query2->Total + $query3->Total;

                /* CourseEnrolleds' count */
                $courseEnrolled1 = CourseEnrolled::with('user', 'course', 'checkout')
                    ->whereHas('course', function ($query) use ($user) {
                        $query->where('user_id', '=', $user->id);
                    })
                    ->whereHas('user', function ($user) {
                        return $user->whereHas('role', function ($role) {
                            return $role->where('name', '!=', 'Corporate Admin');
                        });
                    })->whereHas('checkout', function ($checkout) {
                        return $checkout->where('price', '>', 0)->where('status', 1);
                    })->get();
                $courseEnrolled2 = LevyCourseEnrolleds::with('user', 'course', 'checkout')
                    ->whereHas('course', function ($query) use ($user) {
                        $query->where('user_id', '=', $user->id);
                    })
                    ->whereHas('checkout', function ($checkout) {
                        return $checkout->where('price', '>', 0)->where('status', 1);
                    })->get();
                $courseEnrolled3 = PackageEnrolled::with('user', 'package', 'checkout')
                    ->whereHas('package', function ($query) use ($user) {
                        $query->where('user_id', '=', $user->id);
                    })
                    ->whereHas('checkout', function ($checkout) {
                        return $checkout->where('price', '>', 0)->where('status', 1);
                    })->get();
                $all_course_enrolleds = $courseEnrolled1->merge($courseEnrolled2)->merge($courseEnrolled3);

                /* CourseEnrolleds' revenue by month */
                $this_month_enroll1 = CourseEnrolled::with('user', 'course', 'checkout')
                    ->whereYear('created_at', Carbon::now()->year)
                    ->whereMonth('created_at', Carbon::now()->format('m'))
                    ->whereHas('course', function ($query) use ($user) {
                        $query->where('user_id', '=', $user->id);
                    })
                    ->whereHas('user', function ($user) {
                        return $user->whereHas('role', function ($role) {
                            return $role->where('name', '!=', 'Corporate Admin');
                        });
                    })->whereHas('checkout', function ($checkout) {
                        return $checkout->where('price', '>', 0)->where('status', 1);
                    })->select(DB::raw('ROUND(sum(purchase_price * quantity * ' . $commission / 100 . '), 2) as Revenue'))->first();

                $this_month_enroll2 = LevyCourseEnrolleds::with('user', 'course', 'checkout')
                    ->whereYear('created_at', Carbon::now()->year)
                    ->whereMonth('created_at', Carbon::now()->format('m'))
                    ->whereHas(
                        'course',
                        function ($query) use ($user) {
                            $query->where('user_id', '=', $user->id);
                        }
                    )
                    ->whereHas('checkout', function ($checkout) {
                        return $checkout->where('price', '>', 0)->where('status', 1);
                    })->select(DB::raw('ROUND(sum(purchase_price * quantity * ' . $commission / 100 . '), 2) as Revenue, ROUND(sum(purchase_price * quantity), 2) as Total'))->first();

                $this_month_enroll3 = PackageEnrolled::with('user', 'package', 'checkout')
                    ->whereYear('created_at', Carbon::now()->year)
                    ->whereMonth('created_at', Carbon::now()->format('m'))
                    ->whereHas('package', function ($query) use ($user) {
                        $query->where('user_id', '=', $user->id);
                    })
                    ->whereHas('checkout', function ($checkout) {
                        return $checkout->where('price', '>', 0)->where('status', 1);
                    })->select(DB::raw('ROUND(sum(purchase_price * initial_quantity * ' . $commission / 100 . '), 2) as Revenue, ROUND(sum(purchase_price * initial_quantity), 2) as Total'))->first();
                $this_month_enroll = $this_month_enroll1->Revenue + $this_month_enroll2->Revenue + $this_month_enroll3->Revenue;
            } else if ($user->role_id == 7 || is_partner($user)) {
                // $allCourseEnrolled = CourseEnrolled::with('user', 'course')
                //     ->whereHas('course', function ($query) use ($user) {
                //         $query->where('user_id', '=', $user->id);
                //     })->get();

                $allCourses = Course::where('user_id', $user->id)->where('type', 1)->where('status', '!=', 2)->get();
                $published_course = Course::where('user_id', $user->id)->where('status', 1)->get();
                $inreview_course = Course::where('user_id', $user->id)->where('status', 0)->where('type', 1)->get();

                // $thisMonthEnroll = CourseEnrolled::whereYear('created_at', Carbon::now()->year)
                //     ->whereMonth('created_at', Carbon::now()->format('m'))
                //     ->whereHas('course', function ($query) use ($user) {
                //         $query->where('user_id', '=', $user->id);
                //     })->sum('reveune');

                $today = CourseEnrolled::whereDate('created_at', Carbon::today())
                    ->whereHas('course', function ($query) use ($user) {
                        $query->where('user_id', '=', $user->id);
                    })->sum('reveune');

                // $rev = $allCourseEnrolled->sum('reveune');

                /* CourseEnrolleds ' Sales */
                $commission = 100 - Settings('commission') - Settings('hrdc_commission');
                $query1 = CourseEnrolled::with('user', 'course', 'checkout')
                    ->whereHas('course', function ($query) use ($user) {
                        $query->where('user_id', '=', $user->id);
                    })
                    ->whereHas('user', function ($user) {
                        return $user->whereHas('role', function ($role) {
                            return $role->where('name', '!=', 'Corporate Admin');
                        });
                    })->whereHas('checkout', function ($checkout) {
                        return $checkout->where('price', '>', 0)->where('status', 1);
                    })->select(DB::raw('ROUND(sum(purchase_price * quantity * ' . $commission / 100 . '), 2) as Revenue, ROUND(sum(purchase_price * quantity), 2) as Total'))->first();

                $query2 = LevyCourseEnrolleds::with('user', 'course', 'checkout')
                    ->whereHas('course', function ($query) use ($user) {
                        $query->where('user_id', '=', $user->id);
                    })
                    ->whereHas('checkout', function ($checkout) {
                        return $checkout->where('price', '>', 0)->where('status', 1);
                    })->select(DB::raw('ROUND(sum(purchase_price * quantity * ' . $commission / 100 . '), 2) as Revenue, ROUND(sum(purchase_price * quantity), 2) as Total'))->first();

                $query3 = PackageEnrolled::with('user', 'package', 'checkout')
                    ->whereHas('package', function ($query) use ($user) {
                        $query->where('user_id', '=', $user->id);
                    })
                    ->whereHas('checkout', function ($checkout) {
                        return $checkout->where('price', '>', 0)->where('status', 1);
                    })->select(DB::raw('ROUND(sum(purchase_price * initial_quantity * ' . $commission / 100 . '), 2) as Revenue, ROUND(sum(purchase_price * initial_quantity), 2) as Total'))->first();

                $all_course_enrolled_revenue = $query1->Revenue + $query2->Revenue + $query3->Revenue;
                $all_course_enrolled_total = $query1->Total + $query2->Total + $query3->Total;

                /* CourseEnrolleds' count */
                $courseEnrolled1 = CourseEnrolled::with('user', 'course', 'checkout')
                    ->whereHas('course', function ($query) use ($user) {
                        $query->where('user_id', '=', $user->id);
                    })
                    ->whereHas('user', function ($user) {
                        return $user->whereHas('role', function ($role) {
                            return $role->where('name', '!=', 'Corporate Admin');
                        });
                    })->whereHas('checkout', function ($checkout) {
                        return $checkout->where('price', '>', 0)->where('status', 1);
                    })->get();
                $courseEnrolled2 = LevyCourseEnrolleds::with('user', 'course', 'checkout')
                    ->whereHas('course', function ($query) use ($user) {
                        $query->where('user_id', '=', $user->id);
                    })
                    ->whereHas('checkout', function ($checkout) {
                        return $checkout->where('price', '>', 0)->where('status', 1);
                    })->get();
                $courseEnrolled3 = PackageEnrolled::with('user', 'package', 'checkout')
                    ->whereHas('package', function ($query) use ($user) {
                        $query->where('user_id', '=', $user->id);
                    })
                    ->whereHas('checkout', function ($checkout) {
                        return $checkout->where('price', '>', 0)->where('status', 1);
                    })->get();
                $all_course_enrolleds = $courseEnrolled1->merge($courseEnrolled2)->merge($courseEnrolled3);

                /* CourseEnrolleds' revenue by month */
                $this_month_enroll1 = CourseEnrolled::with('user', 'course', 'checkout')
                    ->whereYear('created_at', Carbon::now()->year)
                    ->whereMonth('created_at', Carbon::now()->format('m'))
                    ->whereHas('course', function ($query) use ($user) {
                        $query->where('user_id', '=', $user->id);
                    })
                    ->whereHas('user', function ($user) {
                        return $user->whereHas('role', function ($role) {
                            return $role->where('name', '!=', 'Corporate Admin');
                        });
                    })->whereHas('checkout', function ($checkout) {
                        return $checkout->where('price', '>', 0)->where('status', 1);
                    })->select(DB::raw('ROUND(sum(purchase_price * quantity * ' . $commission / 100 . '), 2) as Revenue'))->first();

                $this_month_enroll2 = LevyCourseEnrolleds::with('user', 'course', 'checkout')
                    ->whereYear('created_at', Carbon::now()->year)
                    ->whereMonth('created_at', Carbon::now()->format('m'))
                    ->whereHas('course', function ($query) use ($user) {
                        $query->where('user_id', '=', $user->id);
                    })
                    ->whereHas('checkout', function ($checkout) {
                        return $checkout->where('price', '>', 0)->where('status', 1);
                    })->select(DB::raw('ROUND(sum(purchase_price * quantity * ' . $commission / 100 . '), 2) as Revenue, ROUND(sum(purchase_price * quantity), 2) as Total'))->first();

                $this_month_enroll3 = PackageEnrolled::with('user', 'package', 'checkout')
                    ->whereYear('created_at', Carbon::now()->year)
                    ->whereMonth('created_at', Carbon::now()->format('m'))
                    ->whereHas('package', function ($query) use ($user) {
                        $query->where('user_id', '=', $user->id);
                    })
                    ->whereHas('checkout', function ($checkout) {
                        return $checkout->where('price', '>', 0)->where('status', 1);
                    })->select(DB::raw('ROUND(sum(purchase_price * initial_quantity * ' . $commission / 100 . '), 2) as Revenue, ROUND(sum(purchase_price * initial_quantity), 2) as Total'))->first();
                $this_month_enroll = $this_month_enroll1->Revenue + $this_month_enroll2->Revenue + $this_month_enroll3->Revenue;
            } else {
                // $allCourseEnrolled  = CourseEnrolled::groupBy('user_id', 'course_id')->get();
                $allCourses         = Course::where('type', 1)->whereIn('status', [0, 1])->get();
                $published_course   = Course::where('type', 1)->where('status', 1)->get();
                $inreview_course    = Course::where('type', 1)->where('status', 0)->get();
                $thisMonthEnroll    = CourseEnrolled::whereYear('created_at', Carbon::now()->year)
                    ->whereMonth('created_at', Carbon::now()->format('m'))
                    ->sum('reveune');
                $today  = CourseEnrolled::whereDate('created_at', Carbon::today())->sum('reveune');
                // $rev    = $allCourseEnrolled->sum('hrdc_reveune');

                /* CourseEnrolleds' sales */
                $commission = 100 - Settings('commission') - Settings('hrdc_commission');
                $query1 = CourseEnrolled::with(['user' => function ($query) {
                    $query->select('id', 'name');
                    $query->whereHas('role', function ($roleQuery) {
                        $roleQuery->where('name', '!=', 'Corporate Admin');
                    });
                }])
                    ->whereHas('checkout', function ($query) {
                        $query->where('price', '>', 0)->where('status', 1);
                    })
                    ->selectRaw('ROUND(SUM(purchase_price * quantity * ?), 2) AS Revenue, ROUND(SUM(purchase_price * quantity), 2) AS Total', [$commission / 100])
                    ->first();

                // $query1 = CourseEnrolled::with('user', 'course', 'checkout')
                // ->whereHas('user', function ($user) {
                //     return $user->whereHas('role', function ($role) {
                //         return $role->where('name', '!=', 'Corporate Admin');
                //     });
                // })->whereHas('checkout', function ($checkout) {
                //     return $checkout->where('price', '>', 0)->where('status', 1);
                // })->select(DB::raw('ROUND(sum(purchase_price * quantity * ' . $commission / 100 . '), 2) as Revenue, ROUND(sum(purchase_price * quantity), 2) as Total'))->first();

                $query2 = LevyCourseEnrolleds::with('user', 'course', 'checkout')
                    ->whereHas('checkout', function ($checkout) {
                        $checkout->where('price', '>', 0)->where('status', 1);
                    })
                    ->selectRaw('ROUND(SUM(purchase_price * quantity * ?), 2) as Revenue, ROUND(SUM(purchase_price * quantity), 2) as Total', [$commission / 100])
                    ->first();

                // $query2 = LevyCourseEnrolleds::with('user', 'course', 'checkout')
                //     ->whereHas('checkout', function ($checkout) {
                //         return $checkout->where('price', '>', 0)->where('status', 1);
                //     })->select(DB::raw('ROUND(sum(purchase_price * quantity * ' . $commission / 100 . '), 2) as Revenue, ROUND(sum(purchase_price * quantity), 2) as Total'))->first();


                $query3 = PackageEnrolled::with('user', 'package', 'checkout')
                    ->whereHas('checkout', function ($checkout) {
                        $checkout->where('price', '>', 0)->where('status', 1);
                    })
                    ->selectRaw('ROUND(SUM(purchase_price * initial_quantity * ?), 2) AS Revenue, ROUND(SUM(purchase_price * initial_quantity), 2) AS Total', [$commission / 100])
                    ->first();

                // $query3 = PackageEnrolled::with('user', 'package', 'checkout')
                // ->whereHas('checkout', function ($checkout) {
                //     return $checkout->where('price', '>', 0)->where('status', 1);
                // })->select(DB::raw('ROUND(sum(purchase_price * initial_quantity * ' . $commission / 100 . '), 2) as Revenue, ROUND(sum(purchase_price * initial_quantity), 2) as Total'))->first();

                $all_course_enrolled_revenue = $query1->Revenue + $query2->Revenue + $query3->Revenue;
                $all_course_enrolled_total = $query1->Total + $query2->Total + $query3->Total;

                /* CourseEnrolleds' count */
                //  $courseEnrolled1 = CourseEnrolled::with('user', 'course', 'checkout')
                //  ->whereHas('user', function ($user) {
                //      return $user->whereHas('role', function ($role) {
                //          return $role->where('name', '!=', 'Corporate Admin');
                //      });
                //  })->whereHas('checkout', function ($checkout) {
                //      return $checkout->where('price', '>', 0)->where('status', 1);
                //  })->get();

                /* $courseEnrolled1 = CourseEnrolled::with([
                    'user' => function ($query) {
                        $query->select('id', 'name');
                        $query->whereHas('role', function ($roleQuery) {
                            $roleQuery->where('name', '!=', 'Corporate Admin');
                        });
                    }])            
                    ->whereHas('checkout', function ($query) {
                        $query->where('price', '>', 0)->where('status', 1);
                    })->get();
                $courseEnrolled2 = LevyCourseEnrolleds::with('user', 'course', 'checkout')
                    ->whereHas('checkout', function ($checkout) {
                        return $checkout->where('price', '>', 0)->where('status', 1);
                    })->get();
                $courseEnrolled3 = PackageEnrolled::with('user', 'package', 'checkout')
                    ->whereHas('checkout', function ($checkout) {
                        return $checkout->where('price', '>', 0)->where('status', 1);
                    })->get();
                $all_course_enrolleds = $courseEnrolled1->merge($courseEnrolled2)->merge($courseEnrolled3);*/

                $courseEnrolled1 = CourseEnrolled::with([
                    'user' => function ($query) {
                        $query->select('id', 'name');
                    }
                ])
                    ->groupBy('user_id', 'course_id')
                    ->get();

                /* CourseEnrolleds' revenue by month */
                // $this_month_enroll1 = CourseEnrolled::with('user', 'course', 'checkout')
                // ->whereYear('created_at', Carbon::now()->year)
                // ->whereMonth('created_at', Carbon::now()->format('m'))
                // ->whereHas('user', function ($user) {
                //     return $user->whereHas('role', function ($role) {
                //         return $role->where('name', '!=', 'Corporate Admin');
                //     });
                // })->whereHas('checkout', function ($checkout) {
                //     return $checkout->where('price', '>', 0)->where('status', 1);
                // })->select(DB::raw('ROUND(sum(purchase_price * quantity * ' . $commission / 100 . '), 2) as Revenue'))->first();

                $this_month_enroll1 = CourseEnrolled::with(['user' => function ($query) {
                    $query->select('id', 'name');
                    $query->whereHas('role', function ($roleQuery) {
                        $roleQuery->where('name', '!=', 'Corporate Admin');
                    });
                }])
                    ->whereYear('created_at', '=', Carbon::now()->year)
                    ->whereMonth('created_at', '=', Carbon::now()->format('m'))
                    ->whereHas('checkout', function ($checkout) {
                        $checkout->where('price', '>', 0)->where('status', 1);
                    })
                    ->selectRaw('ROUND(sum(purchase_price * quantity * ?), 2) as Revenue', [$commission / 100])
                    ->first();


                $this_month_enroll2 = LevyCourseEnrolleds::with('user', 'course', 'checkout')
                    ->whereYear('created_at', Carbon::now()->year)
                    ->whereMonth('created_at', Carbon::now()->format('m'))
                    ->whereHas('checkout', function ($checkout) {
                        return $checkout->where('price', '>', 0)->where('status', 1);
                    })->select(DB::raw('ROUND(sum(purchase_price * quantity * ' . $commission / 100 . '), 2) as Revenue, ROUND(sum(purchase_price * quantity), 2) as Total'))->first();

                $this_month_enroll3 = PackageEnrolled::with('user', 'package', 'checkout')
                    ->whereYear('created_at', Carbon::now()->year)
                    ->whereMonth('created_at', Carbon::now()->format('m'))
                    ->whereHas('checkout', function ($checkout) {
                        return $checkout->where('price', '>', 0)->where('status', 1);
                    })->select(DB::raw('ROUND(sum(purchase_price * initial_quantity * ' . $commission / 100 . '), 2) as Revenue, ROUND(sum(purchase_price * initial_quantity), 2) as Total'))->first();
                $this_month_enroll = $this_month_enroll1->Revenue + $this_month_enroll2->Revenue + $this_month_enroll3->Revenue;
            }

            $info['student']    = User::where('role_id', 3)->count();
            $info['instructor'] = User::where('role_id', 2)->count();
            $info['allCourse']  = $allCourses->count();
            $info['published_course'] = $published_course->count();
            $info['inreview_course'] = $inreview_course->count();
            //$info['totalEnroll'] = $allCourseEnrolled->count();
            //$info['totalSell'] = number_format($allCourseEnrolled->sum('purchase_price'), 2, '.', '');
            //$info['adminRev']   = number_format($rev, 2, '.', '');
            $info['today'] = number_format($today, 2, '.', '');
            // $info['thisMonthEnroll'] = number_format($thisMonthEnroll, 2, '.', '');

            $info['totalEnroll'] = $courseEnrolled1->count();
            $info['totalSell'] = number_format($all_course_enrolled_total, 2, '.', '');
            $info['adminRev']   = number_format($all_course_enrolled_revenue, 2, '.', '');
            $info['thisMonthEnroll'] = number_format($this_month_enroll, 2, '.', '');

            return Response::json($info);
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function get_enroll_chart_data()
    {
        $user = Auth::user();

        if ($user->role_id == 2) {
            $courses_enrolle = CourseEnrolled::select(
                DB::raw('MONTHNAME(created_at) as month'),
                DB::raw('YEAR(created_at) as year'),
                DB::raw('DAY(created_at) as day'),
                DB::raw('count(*) as count')
            )
                ->whereHas('course', function ($query) use ($user) {
                    $query->where('user_id', '=', $user->id);
                })
                ->groupBy('year', 'month', 'day')->get();
        } else if ($user->role_id == 7 || is_partner($user)) {
            $courses_enrolle = CourseEnrolled::select(
                DB::raw('MONTHNAME(created_at) as month'),
                DB::raw('YEAR(created_at) as year'),
                DB::raw('DAY(created_at) as day'),
                DB::raw('count(*) as count')
            )
                ->whereHas('course', function ($query) use ($user) {
                    $query->where('user_id', '=', $user->id);
                })
                ->groupBy('year', 'month', 'day')
                ->get();
        } else {
            $courses_enrolle = CourseEnrolled::select(
                DB::raw('MONTHNAME(created_at) as month'),
                DB::raw('YEAR(created_at) as year'),
                DB::raw('DAY(created_at) as day'),
                DB::raw('count(*) as count')
            )
                ->groupBy('year', 'month', 'day')
                ->get();
        }

        $enrolls = [];

        foreach ($courses_enrolle as $course) {
            if (date('Y') == $course->year && date('F') == $course->month) {
                $enrolls[] = $course;
            }
        }

        $days = days_of_given_month_of_current_year(date('F'));
        $data = enroll_day_count_calculation($days, $enrolls);

        $info['enroll_day']     = $data['enroll_day'];
        $info['enroll_count']   = $data['enroll_count'];

        return response()->json($info);
    }

    public function get_monthly_revenue_data()
    {
        $user = Auth::user();

        if ($user->role_id == 2) {
            $coursesEarnings = CourseEnrolled::select(
                DB::raw('Month(created_at) as month_number'),
                DB::raw('DATE_FORMAT(created_at , "%b") as month'),
                DB::raw('YEAR(created_at) as year'),
                DB::raw('reveune as earning')
            )
                ->whereHas('course', function ($query) use ($user) {
                    $query->where('user_id', '=', $user->id);
                })
                ->groupBy('month_number', 'year', 'month')
                ->whereYear('created_at', Carbon::now()->year)
                ->get()->sortBy('month_number');
        } else if ($user->role_id == 7 || is_partner($user)) {
            $coursesEarnings = CourseEnrolled::select(
                DB::raw('Month(created_at) as month_number'),
                DB::raw('DATE_FORMAT(created_at , "%b") as month'),
                DB::raw('YEAR(created_at) as year'),
                DB::raw('ROUND(sum(reveune),2) as earning')
            )
                ->whereHas('course', function ($query) use ($user) {
                    $query->where('user_id', '=', $user->id);
                })
                ->groupBy('month_number', 'year', 'month')
                ->whereYear('created_at', Carbon::now()->year)
                ->get()
                ->sortBy('month_number');
        } else {
            $coursesEarnings = CourseEnrolled::select(
                DB::raw('Month(created_at) as month_number'),
                DB::raw('DATE_FORMAT(created_at , "%b") as month'),
                DB::raw('YEAR(created_at) as year'),
                DB::raw('sum(reveune) as earning')
            )
                ->groupBy('month_number', 'year', 'month')
                ->whereYear('created_at', Carbon::now()->year)
                ->get()
                ->sortBy('month_number');
        }

        $courseEarningMonthName = [];
        $courseEarningMonthly   = [];

        foreach ($coursesEarnings as $key => $earning) {
            $courseEarningMonthName[]   = $earning->month;
            $courseEarningMonthly[]     = $earning->earning;
        }

        $info['courseEarningMonthName'] = $courseEarningMonthName;
        $info['courseEarningMonthly']   = $courseEarningMonthly;

        return response()->json($info);
    }

    public function get_payment_stats_data()
    {
        $user = Auth::user();

        $withdraws_query = Withdraw::selectRaw('monthname(issueDate) as month')
            ->selectRaw('YEAR(issueDate) as year')
            ->select('status')
            ->whereYear('issueDate', '=', date('Y'))
            ->whereMonth('issueDate', '=', date('m'));

        if ($user->role_id != 1) {
            $withdraws_query->where('instructor_id', $user->id);
        }

        $withdraws = $withdraws_query->get();

        $info['payment_stats']['paid']      = $withdraws->where('status', '=', 1)->count();
        $info['payment_stats']['unpaid']    = $withdraws->where('status', '=', 0)->count();
        $info['payment_stats']['month']     = Carbon::now()->format('F');

        return response()->json($info);
    }

    public function get_status_overview_data()
    {
        $user = Auth::user();

        $allCourses = Course::with('user', 'enrolls')->get();
        if ($user->role_id == 7 || is_partner($user)) {
            $allCourses = Course::with('user', 'enrolls')->where('user_id', $user->id)->get();
        }

        $info['course_overview']['active']  = $allCourses->where('status', 1)->count();
        $info['course_overview']['pending'] = $allCourses->where('status', 0)->count();
        $info['course_overview']['courses'] = $allCourses->where('type', 1)->count();
        $info['course_overview']['quizzes'] = $allCourses->where('type', 2)->count();
        $info['course_overview']['classes'] = $allCourses->where('type', 3)->count();

        return response()->json($info);
    }

    public function get_reg_overview_chart_data()
    {
        $user = Auth::user();

        $registered_learner = User::select(
            DB::raw('MONTHNAME(created_at) as month'),
            DB::raw('YEAR(created_at) as year'),
            DB::raw('DAY(created_at) as day'),
            DB::raw('count(*) as count')
        )
            ->groupBy('year', 'month', 'day')
            ->where('role_id', 3)
            ->get();

        $learners = [];
        foreach ($registered_learner as $register) {
            if (date('Y') == $register->year && date('F') == $register->month) {
                $learners[] = $register;
            }
        }

        $reg_days = days_of_given_month_of_current_year(date('F'));
        $red_data = enroll_day_count_calculation($reg_days, $learners);

        $info['reg_day']    = $red_data['enroll_day'];
        $info['reg_count']  = $red_data['enroll_count'];

        return response()->json($info);
    }

    public function validateGenerate()
    {
        return view('validate_generate');
    }


    public function validateGenerateSubmit()
    {
        $field = request()->field;
        $rules = request()->rules;
        $arr = [];


        $single_rule = explode('|', $rules);


        foreach ($single_rule as $rule) {
            $string = explode(':', $rule);
            $rule_name = $rule_message_key = $string[0];

            if (in_array($rule_name, ['max', 'min'])) {
                $rule_message_key = $rule_message_key . '.string';
            }

            $message = __('validation.' . $rule_message_key);

            $field_string = str_replace('_', ' ', $field);

            $message = str_replace(
                [':attribute', ':ATTRIBUTE', ':Attribute'],
                [$field_string, \Illuminate\Support\Str::upper($field_string), \Illuminate\Support\Str::ucfirst($field_string)],
                $message
            );
            if (in_array($rule_name, ['max', 'min'])) {
                $message = str_replace(
                    [':' . $rule_name],
                    [$string[1]],
                    $message
                );
            }

            if ($rule_name == 'required_if') {
                $ex = explode(',', $string[1]);
                $message = str_replace(
                    [':other'],
                    [str_replace('_', ' ', $ex[0])],
                    $message
                );
                if (isset($ex[2])) {
                    $message = str_replace(
                        [':value', "'"],
                        [str_replace('_', ' ', $ex[2]), ''],
                        $message
                    );
                } else {
                    $message = str_replace(
                        [':value', "'"],
                        [str_replace('_', ' ', $ex[1]), ''],
                        $message
                    );
                }
            }

            if ($rule_name == 'mimes') {

                $message = str_replace(
                    [':values'],
                    [str_replace('_', ' ', $string[1])],
                    $message
                );
            }
            if ($rule_name == 'same') {

                $message = str_replace(
                    [':other'],
                    [str_replace('_', ' ', $string[1])],
                    $message
                );
            }
            if ($rule_name == 'required_with') {

                $message = str_replace(
                    [':values'],
                    [str_replace('_', ' ', $string[1])],
                    $message
                );
            }

            if ($rule_name == 'after_or_equal') {

                $message = str_replace(
                    [':date'],
                    [str_replace('_', ' ', $string[1])],
                    $message
                );
            }
            if ($rule_name == 'after') {

                $message = str_replace(
                    [':date'],
                    [str_replace('_', ' ', $string[1])],
                    $message
                );
            }


            $arr[$field . '.' . $rule_name] = $message;
        }

        $defaultFile = public_path('/../resources/lang/default/validation.php');
        $languages = include "{$defaultFile}";
        $languages = array_merge($languages, $arr);
        file_put_contents($defaultFile, '');
        file_put_contents($defaultFile, '<?php return ' . var_export($languages, true) . ';');


        return view('validate_generate', compact('field', 'rules', 'arr'));
    }

    public function enroll_month_change(\Illuminate\Http\Request $request)
    {
        $month = (int)$request->month;
        $user = Auth::user();
        if ($user->role_id != 2 && $user->role_id != 3 && $user->role_id != 7 && !is_partner($user)) {
            $courses_enrolled = CourseEnrolled::select(
                DB::raw('MONTHNAME(created_at) as month'),
                DB::raw('YEAR(created_at) as year'),
                DB::raw('DAY(created_at) as day'),
                DB::raw('count(*) as count')
            )
                ->whereMonth('created_at', '=', $month)
                ->groupBy('year', 'month', 'day')
                ->get();
        } else if ($user->role_id == 2 || $user->role_id == 7 || is_partner($user)) {
            $courses_enrolled = CourseEnrolled::select(
                DB::raw('MONTHNAME(created_at) as month'),
                DB::raw('YEAR(created_at) as year'),
                DB::raw('DAY(created_at) as day'),
                DB::raw('count(*) as count')
            )
                ->whereHas('course', function ($query) use ($user) {
                    $query->where('user_id', '=', $user->id);
                })
                ->whereMonth('created_at', '=', $month)
                ->groupBy('year', 'month', 'day')->get();
        }
        // dd($courses_enrolled->toArray());

        $enrolls = [];

        foreach ($courses_enrolled as $course) {
            if (date('Y') == $course->year && $request->month_name == $course->month)
                $enrolls[] = $course;
        }

        $days = days_of_given_month_of_current_year($request->month_name);
        $data = enroll_day_count_calculation($days, $enrolls);

        $response['success'] = 1;
        $response['enroll_day'] = $data['enroll_day'];
        $response['enroll_count'] = $data['enroll_count'];
        return response()->json($response);
    }

    public function reg_month_change(\Illuminate\Http\Request $request)
    {
        $month = (int)$request->month;
        $registered_learner = User::select(
            DB::raw('MONTHNAME(created_at) as month'),
            DB::raw('YEAR(created_at) as year'),
            DB::raw('DAY(created_at) as day'),
            DB::raw('count(*) as count')
        )
            ->groupBy('year', 'month', 'day')
            ->where('role_id', 3)
            ->whereMonth('created_at', '=', $month)
            ->get();
        // dd($registered_learner->toArray());

        $learners = [];

        foreach ($registered_learner as $register) {
            if (date('Y') == $register->year && $request->month_name == $register->month)
                $learners[] = $register;
        }
        $days = days_of_given_month_of_current_year($request->month_name);
        $data = enroll_day_count_calculation($days, $learners);
        $reg_day = $data['enroll_day'];
        $reg_count = $data['enroll_count'];
        // foreach ($learners as $key => $learn) {
        //     $reg_day[] = $learn->day;
        // }
        // $reg_count = [];
        // foreach ($learners as $key => $learn) {
        //     $reg_count[] = $learn->count;
        // }

        $response['success'] = 1;
        $response['reg_day'] = $reg_day;
        $response['reg_count'] = $reg_count;
        return response()->json($response);
    }
}