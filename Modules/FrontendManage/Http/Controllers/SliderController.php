<?php

namespace Modules\FrontendManage\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Traits\ImageStore;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Modules\FrontendManage\Entities\Slider;

class SliderController extends Controller
{
    use ImageStore;

    public function index()
    {
        try {
            // $sliders = Slider::all();
            $sliders = Slider::where('is_corporate', 0)->get();
            return view('frontendmanage::sliders', compact('sliders'));
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }


    public function store(Request $request)
    {

        if (demoCheck()) {
            return redirect()->back();
        }
        $rules = [
            'title' => 'required|unique:sliders,title',
            'mobile_image' => 'required',
            'image' => 'required'
        ];
        $this->validate($request, $rules, validationMessage($rules));

        try {
            $slider = new Slider();
            $slider->title = $request->title;
            $slider->sub_title = $request->sub_title;

            $slider->btn_title1 = $request->btn_title1;
            $slider->btn_link1 = $request->btn_link1;


            $slider->btn_title2 = $request->btn_title2;
            $slider->btn_link2 = $request->btn_link2;

            if ($request->has('image')) {
                $slider->image = $this->saveImage($request->image);
            }
            if ($request->has('mobile_image')) {
                $slider->mobile_image = $this->saveImage($request->mobile_image);
            }

            if ($request->has('btn_image1')) {
                $slider->btn_image1 = $this->saveImage($request->btn_image1);
            }

            if ($request->has('btn_image2')) {
                $slider->btn_image2 = $this->saveImage($request->btn_image2);
            }

            if ($request->btn_type1 == 1) {
                $slider->btn_type1 = 1;
            } else {
                $slider->btn_type1 = 0;
            }

            if ($request->btn_type2 == 1) {
                $slider->btn_type2 = 1;
            } else {
                $slider->btn_type2 = 0;
            }

            if ($request->image_as_link == 1) {
                $slider->image_as_link = 1;
                $slider->link = $request->link;
            } else {
                $slider->image_as_link = 0;
            }

            if ($request->open_in_new == 1) {
                $slider->open_in_new = 1;
            } else {
                $slider->open_in_new = 0;
            }

            if ($request->show_title == 1) {
                $slider->show_title = 1;
            } else {
                $slider->show_title = 0;
            }

            if ($request->show_subtitle == 1) {
                $slider->show_subtitle = 1;
            } else {
                $slider->show_subtitle = 0;
            }
            $slider->order = $request->order;

            if ($request->show_searchbar == 1) {
                $slider->show_searchbar = 1;
            } else {
                $slider->show_searchbar = 0;
            }
            $slider->is_corporate = 0;

            $slider->save();

            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->back();
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }


    public function edit($id)
    {
        try {
            // $sliders = Slider::all();
            $sliders = Slider::where('is_corporate', 0)->get();
            $slider = Slider::findOrFail($id);
            return view('frontendmanage::sliders', compact('sliders', 'slider'));
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function update(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        $rules = [
            'title' => 'required|unique:sliders,title,' . $request->id,
        ];
        $this->validate($request, $rules, validationMessage($rules));

        try {
            $slider = Slider::find($request->id);
            $slider->title = $request->title;
            $slider->sub_title = $request->sub_title;

            $slider->btn_title1 = $request->btn_title1;
            $slider->btn_link1 = $request->btn_link1;


            $slider->btn_title2 = $request->btn_title2;
            $slider->btn_link2 = $request->btn_link2;

            if ($request->has('image')) {
                $slider->image = $this->saveImage($request->image);
            }

            if ($request->has('mobile_image')) {
                $slider->mobile_image = $this->saveImage($request->mobile_image);
            }

            if ($request->has('btn_image1')) {
                $slider->btn_image1 = $this->saveImage($request->btn_image1);
            }

            if ($request->has('btn_image2')) {
                $slider->btn_image2 = $this->saveImage($request->btn_image2);
            }

            if ($request->btn_type1 == 1) {
                $slider->btn_type1 = 1;
            } else {
                $slider->btn_type1 = 0;
            }

            if ($request->btn_type2 == 1) {
                $slider->btn_type2 = 1;
            } else {
                $slider->btn_type2 = 0;
            }

            if ($request->image_as_link == 1) {
                $slider->image_as_link = 1;
                $slider->link = $request->link;
            } else {
                $slider->image_as_link = 0;
            }

            if ($request->open_in_new == 1) {
                $slider->open_in_new = 1;
            } else {
                $slider->open_in_new = 0;
            }

            if ($request->show_title == 1) {
                $slider->show_title = 1;
            } else {
                $slider->show_title = 0;
            }

            if ($request->show_subtitle == 1) {
                $slider->show_subtitle = 1;
            } else {
                $slider->show_subtitle = 0;
            }
            $slider->order = $request->order;

            if ($request->show_searchbar == 1) {
                $slider->show_searchbar = 1;
            } else {
                $slider->show_searchbar = 0;
            }
            $slider->is_corporate = 0;
            
            $slider->save();
            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->back();
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function destroy($id)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        try {
            Slider::destroy($id);
            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect()->back();
        } catch (Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }
}
