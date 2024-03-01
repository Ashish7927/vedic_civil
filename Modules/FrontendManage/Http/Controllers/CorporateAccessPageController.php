<?php

namespace Modules\FrontendManage\Http\Controllers;

use Exception;
use Throwable;
use App\AboutPage;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ImageStore;
use App\View\Components\FeatureCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Cache;
use Modules\CourseSetting\Entities\Course;
use Modules\FrontendManage\Entities\FrontPage;
use Modules\SystemSetting\Entities\SocialLink;
use Modules\FrontendManage\Entities\HomeSlider;
use Modules\SystemSetting\Entities\Testimonial;
use Modules\FrontendManage\Entities\HomeContent;
use Modules\FrontendManage\Entities\CourseSetting;
use Modules\FrontendManage\Entities\PrivacyPolicy;
use Modules\FrontendManage\Entities\TopbarSetting;
use Modules\SystemSetting\Entities\FrontendSetting;
use Illuminate\Support\Facades\Storage;

class CorporateAccessPageController extends Controller
{
    use ImageStore;

    public function index()
    {
        try {
            $corporate_access_page_content = app('getHomeContent');

            return view('frontendmanage::corporate_access_page_content', compact('corporate_access_page_content'));
        } catch (Throwable $th) {
            Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
            return redirect()->back();
        }
    }

    public function CorporateAccessPageContentUpdate(Request $request)
    {
        
        if (demoCheck()) {
            return redirect()->back();
        }

        try {

            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->route('frontend.corporateAccessPageContent');
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    /* Content Provider's function start */
    public function addContentProvider(Request $request)
    {
        try {

            $corporate_access_page_content = app('getHomeContent');
            
            $cp_data = json_decode(isset($corporate_access_page_content->content_provider_list) ? $corporate_access_page_content->content_provider_list : '', true);
            $num_of_cp = is_array($cp_data) ? count($cp_data) : 0;

            if ($request->cp_ids) {
                foreach ($request->cp_ids as $index => $data) {
                    $cp_arr[] = [
                        'id' => $data,
                        'order' => $index + $num_of_cp + 1,
                    ];
                }
                if ($cp_data) {
                    $arr_merged  = array_unique(array_merge($cp_data, $cp_arr), SORT_REGULAR);
                    UpdateHomeContent('content_provider_list', json_encode($arr_merged));
                } else {
                    UpdateHomeContent('content_provider_list', json_encode($cp_arr));
                }

                return response()->json(['success' => true]);
            } 
            
        } catch (\Exception $e) {
            Toastr::error('Operation Failed', 'Failed');
            Log::info($e->getMessage());
        }
    }

    public function editContentProviderElement(Request $request)
    {
        try {

            $cp_users = User::where('id', $request->id)->first();

            if ($cp_users) {
                $cp_users->company_banner_title = $request->cp_page_title;
                $cp_users->company_banner_subtitle = $request->cp_page_sub_title;

                if ($request->logo != null) {
                    $logo = $this->saveImage($request->logo);
                    $cp_users->image = $logo;
                }
                $cp_users->save();

                return response()->json(['success' => true]);
            } else {
                Toastr::error("Can't find the user", "Failed");
                return response()->json(['success' => false]);
            }

            
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            return response()->json(['success' => false]);
        }
    }

    public function deleteContentProvider(Request $request)
    {
        try {
            $cp_user = $request->id;
            $corporate_access_page_content = app('getHomeContent');
            $cp_data = json_decode($corporate_access_page_content->content_provider_list, true);

           foreach ($cp_data as $index => $value) {
                $key = array_search($cp_user, array_column($cp_data, 'id'));
                if ($key != '') {
                    unset($cp_data[$key]); // remove item based on keyindex 

                    // re-arrange the order
                    $reorder_array = array_slice($cp_data, $key, null, true); // reorder and preserve the key index
                    foreach ($reorder_array as $i => $newValue) {
                        $cp_data[$i]['order'] =  $newValue['order'] - 1;
                    }

                    $array = array_values($cp_data); //re-index

                    UpdateHomeContent('content_provider_list', json_encode($array));
                    return response()->json(['success' => true]);
                } else {
                    return response()->json(['success' => false]);
                }
              
            }
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            return response('error');
        }
    }

    public function reorderingContentProvider(Request $request)
    {
        try {
            $newOrder = json_decode($request->get('order'), true);

            $corporate_access_page_content = app('getHomeContent');
            $cp_data = json_decode($corporate_access_page_content->content_provider_list, true);
                
                foreach ($cp_data as $key => $value) {
                    foreach ($newOrder as $index => $newValue) {
                        $key = array_search($newValue['id'], array_column($cp_data, 'id'));
                        $cp_data[$key]['order'] = $index + 1;
                    }
                }
            UpdateHomeContent('content_provider_list', json_encode($cp_data));

            return true;
        } catch (Exception $e) {
            Log::info($e->getMessage());
        }
    }
    /* Content Provider end */

    /* Corporate start */
    public function addCorporate(Request $request)
    {
        try {

            $corporate_access_page_content = app('getHomeContent');

            $ca_ids = $request->ca_ids;
            $ca_arr = [];
            $corporate_data = json_decode(isset($corporate_access_page_content->corporate_list) ? $corporate_access_page_content->corporate_list : '' , true);
            $num_of_corporate = is_array($corporate_data) ? count($corporate_data) : 0;

            if ($ca_ids) {
                foreach ($request->ca_ids as $index => $data) {
                    $ca_arr[] = [
                        'id' => $data,
                        'order' => $index + $num_of_corporate + 1,
                    ];
                }
                if ($corporate_data) {
                    $arr_merged  = array_unique(array_merge($corporate_data, $ca_arr), SORT_REGULAR);
                    UpdateHomeContent('corporate_list', json_encode($arr_merged));
                } else {
                    UpdateHomeContent('corporate_list', json_encode($ca_arr));
                }
            }
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            Toastr::error('Operation Failed', 'Failed');
        }
    }

    public function editCorporateElement(Request $request)
    {
        try {

            $corporate = DB::table('companies')->where('id', $request->id)->limit(1);
            if ($corporate) {
                if ($request->logo != null) {
                    $logo = $this->saveImage($request->logo);
                }
                $corporate->update(['logo' => $logo]);
            } else {
                Toastr::error("Can't find the corporate", "Failed");
                return back();
            }
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
        }
    }

    public function deleteCorporate(Request $request)
    {
        try {
            $corporate = $request->id;
            $corporate_access_page_content = app('getHomeContent');
            $ca_data = json_decode($corporate_access_page_content->corporate_list, true);

                $key = array_search($corporate, array_column($ca_data, 'id'));
                if ($key != '') {
                    unset($ca_data[$key]); // remove item based on keyindex 

                    // re-arrange the order
                    $reorder_array = array_slice($ca_data, $key, null, true); // reorder and preserve the key index
                    foreach ($reorder_array as $i => $newValue) {
                        $cp_data[$i]['order'] =  $newValue['order'] - 1;
                    }

                    $array = array_values($ca_data); //re-index

                    UpdateHomeContent('corporate_list', json_encode($array));
                    return response()->json(['success' => true]);
                } else {
                    return response()->json(['success' => false]);
                }

        } catch (\Exception $e) {
            Log::info($e->getMessage());
            return response('error');
        }
    }

    public function reorderingCorporate(Request $request)
    {
        try {
            $newCorporateOrder = json_decode($request->get('orderCorporate'), true);

            $corporate_access_page_content = app('getHomeContent');
            $ca_data = json_decode($corporate_access_page_content->corporate_list, true);

            foreach ($ca_data as $value) {
                foreach ($newCorporateOrder as $index => $newValue) {
                    $key = array_search($newValue['id'], array_column($ca_data, 'id'));
                    $ca_data[$key]['order'] = $index + 1;
                }
            }
            UpdateHomeContent('corporate_list', json_encode($ca_data));

            return true;
        } catch (Exception $e) {
            Log::info($e->getMessage());
        }
    }
    /* Corporate end */
}
