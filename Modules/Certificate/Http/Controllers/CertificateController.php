<?php

namespace Modules\Certificate\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Modules\Setting\Model\DateFormat;
use Illuminate\Contracts\Support\Renderable;
use Modules\Certificate\Entities\Certificate;
use Modules\Certificate\Entities\CertificateFont;
use App\User;
use Modules\Certificate\Entities\CertificateRecord;
use Modules\CourseSetting\Entities\Course;
class CertificateController extends Controller
{
    public function index()
    {
        if (Auth::user()->role_id == 1) {
            $certificates = Certificate::latest()->get();
        } else {
            $certificates = Certificate::where('created_by', Auth::user()->id)->latest()->get();
        }
        return view('certificate::certificate.index', compact('certificates'));
    }

    public function fonts()
    {
        $fonts = CertificateFont::all();

        $font_list = [];
        if (count($fonts) == 0) {
            $font_list = [
                'nunito' => 'Nunito',
                'vazir' => 'Vazir',
                'arabic' => 'Arabic',
            ];
        } else {
            foreach ($fonts as $font) {
                $font_list[$font->name] = $font->title;
            }
        }
        return $font_list;
    }

    public function allfonts()
    {
        $fonts = CertificateFont::all();
        return view('certificate::fonts.index', compact('fonts'));

    }

    public function saveFont(Request $request)
    {


        if (demoCheck()) {
            return redirect()->back();
        }
        $rules = [
            'title' => 'required',
            'name' => 'required',
            'font' => 'required',

        ];

        $font = $request->file('font');
        $ext = strtolower($font->getClientOriginalExtension());
        if ($ext != 'ttf') {
            Toastr::error('File format must be TTF', trans('common.Failed'));
            return redirect()->back();
        }
        $this->validate($request, $rules, validationMessage($rules));


        $newFont = new CertificateFont();
        $newFont->title = $request->title;
        $newFont->name = $request->name;
        $newFont->font = $request->name . '.ttf';
        $newFont->save();

        $font->move(public_path('fonts'), $request->name . '.ttf');

        Toastr::success(trans('certificate.Certificate Font Saved Successfully'), trans('common.Success'));
        return redirect()->back();
    }

    public function deleteFont(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        $rules = [
            'id' => 'required',
        ];
        $this->validate($request, $rules, validationMessage($rules));

        $font = CertificateFont::findOrFail($request->id);
        $font->delete();
        Toastr::success(trans('certificate.Certificate Font Delete Successfully'), trans('common.Success'));
        return redirect()->back();


    }

    public function create()
    {
        $font_list = $this->fonts();
        $formats = DateFormat::all();
        return view('certificate::certificate.index', compact('font_list', 'formats'));

    }

    public function store(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        $rules = [
            'image' => 'required'

        ];
        $this->validate($request, $rules, validationMessage($rules));

        try {
            $certificate = Certificate::create($request->except(['image', 'signature', '_token', 'certificate_id', 'makeURL', 'uploadURL', 'bgImageInput', 'sigImageInput']));


            if ($request->file('signature') != "") {
                $name = md5($request->title . time()) . '.' . 'png';
                $img = Image::make($request->signature);
                $upload_path = 'uploads/certificate/';
                $img->save($upload_path . $name);
                $certificate->signature = 'uploads/certificate/' . $name;
            }
            if ($request->file('image') != "") {
                $name = md5($request->title . rand(0, 1000)) . '.' . 'png';
                $img = Image::make($request->image);
                $upload_path = 'uploads/certificate/';
                $img->save($upload_path . $name);
                $certificate->image = 'uploads/certificate/' . $name;
            }

            if(!isset($request->is_free)){
                $certificate->is_free = 0;
            }

            $certificate->created_by = Auth::user()->id;
            $certificate->save();
            Toastr::success(trans('certificate.Certificate Saved Successfully'), trans('common.Success'));
            return redirect()->route('certificate.index');
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('systemsetting::show');
    }

    public function edit($id)
    {
        $font_list = $this->fonts();
        $certificate = Certificate::findOrFail($id);
        $formats = DateFormat::all();
        return view('certificate::certificate.index', compact('certificate', 'font_list', 'formats'));
    }

    public function update(Request $request, $id)
    {
        echo "sdfasdf";
        // return $request;
        if (demoCheck()) {
            return redirect()->back();
        }

        try {
            $certificate = Certificate::findOrFail($id);
            $input = $request->except(['image', 'signature', '_token', 'certificate_id', 'makeURL', 'uploadURL', 'bgImageInput', 'sigImageInput']);
            $certificate->fill($input);

            if ($request->file('image') != "") {
                $name = md5($request->title . time()) . '.' . 'png';
                $img = Image::make($request->image);
                $upload_path = 'uploads/certificate/';
                $img->save($upload_path . $name);
                $certificate->image = 'uploads/certificate/' . $name;
            }
            if ($request->file('signature') != "") {
                $name = md5($request->title . time()) . '.' . 'png';
                $img = Image::make($request->signature);
                $upload_path = 'uploads/certificate/';
                $img->save($upload_path . $name);
                $certificate->signature = 'uploads/certificate/' . $name;
            }
            if(!isset($request->is_free)){
                $certificate->is_free = 0;
            }
            $certificate->is_partner = $request->is_partner;
            $certificate->save();

            Toastr::success(trans('certificate.Certificate Update Successfully'), trans('common.Success'));
            return redirect()->route('certificate.index');
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function destroy($id)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        try {
            Certificate::destroy($id);
            Toastr::success(trans('certificate.Certificate Deleted Successfully'), trans('common.Success'));
            return back();
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function courseCertificate($id)
    {
        try {

            Certificate::where('for_course', 1)->update(['for_course' => 0]);

            $certificate = Certificate::find($id);
            $certificate->for_course = 1;
            $certificate->for_quiz = 0;
            $certificate->for_class = 0;
            $certificate->save();
            Toastr::success(trans('certificate.Certificate for Course Selected Successfully'), trans('common.Success'));
            return back();
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function quizCertificate($id)
    {
        try {
            Certificate::where('for_quiz', 1)->update(['for_quiz' => 0]);
            $certificate = Certificate::find($id);
            $certificate->for_quiz = 1;
            $certificate->for_course = 0;
            $certificate->for_class = 0;
            $certificate->save();
            Toastr::success(trans('certificate.Certificate for Quiz Selected Successfully'), trans('common.Success'));
            return back();
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function classCertificate($id)
    {
        try {
            Certificate::where('for_class', 1)->update(['for_class' => 0]);
            $certificate = Certificate::find($id);
            $certificate->for_quiz = 0;
            $certificate->for_course = 0;
            $certificate->for_class = 1;
            $certificate->save();
            Toastr::success(trans('certificate.Certificate for Live Class Selected Successfully'), trans('common.Success'));
            return back();
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function getVariants(Request $request)
    {
        $font_family = $request->font;
        $url = "https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyAdtrr9rVkPASrFJCfmeOmV3ZLtpsk-BaU";
        $result = json_decode(file_get_contents($url));
        $output = '';
        foreach ($result->items as $font) {
            if ($font->family == $font_family) {
                $variants = $font->variants;
                $files = [];
                foreach ($font->files as $key => $file)
                    $files[] = $file;
                foreach ($variants as $key => $variant) {
                    if (is_numeric($variant) || $variant == 'regular')
                        $output .= '<option value="' . $variant . '">' . $variant . '</option>';
                }
            }
        }
        return $output;
    }

    public function view($id, Request $request)
    {
        try {
            $certificate = $this->makeCertificate($id, $request)['image'] ?? '';            
            return $certificate->response('png');
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function makeCertificate($id, Request $request)
    {

        try {
            if (!empty($id)) {
                $certificate = Certificate::find($id);
            }
            if (!empty($request->bgImage)) {
                $bg_image = $request->bgImage;
            } elseif ($id) {
                $bg_image = $certificate->image ?? '';
            } else {
                $bg_image = '';
            }


            if (!empty($request->sigImageInput)) {
                $sig_image = $request->sigImageInput;
            } elseif ($id) {
                $sig_image = $certificate->signature ?? '';
            } else {
                $sig_image = '';
            }

            if (!empty($request->bgImage) || $id) {

                $bg_image = asset($bg_image);
                $bg_image = str_replace('https:', 'http:', $bg_image);
                $width = getimagesize($bg_image)[0] ?? 1300;
                $height = getimagesize($bg_image)[1] ?? 910;
            } else {
                $width = 1300;
                $height = 910;
            };


            $img = Image::canvas($width, $height);
            if (!empty($bg_image)) {
                $img->insert(asset($bg_image));
            }


            if (!empty($request->title)) {
                $title = $request->title;
            } elseif (!empty($id)) {
                $title = $certificate->title ?? '';
            } else {
                $title = 'Certificate Title';
            }

            if (!empty($request->title_position_x)) {
                $title_position_x = $request->title_position_x;
            } elseif (!empty($id)) {
                $title_position_x = $certificate->title_position_x ?? '';
            } else {
                $title_position_x = 0;
            }


            if (!empty($request->title_position_y)) {
                $title_position_y = $request->title_position_y;
            } elseif (!empty($id)) {
                $title_position_y = $certificate->title_position_y ?? '';
            } else {
                $title_position_y = 0;
            }


            if (!empty($request->title_font_color)) {
                $title_font_color = $request->title_font_color;
            } elseif (!empty($id)) {
                $title_font_color = $certificate->title_font_color ?? '#000';
            } else {
                $title_font_color = '#000';
            }


            if (!empty($request->title_font_size)) {
                $title_font_size = $request->title_font_size;
            } elseif (!empty($id)) {
                $title_font_size = $certificate->title_font_size ?? 30;
            } else {
                $title_font_size = 30;
            }

            if (!empty($request->title_font_family)) {
                $title_font_family = $request->title_font_family;
            } elseif (!empty($id)) {
                $title_font_family = $certificate->title_font_family ?? 'nunito';
            } else {
                $title_font_family = 'nunito';
            }

//body part style start form here
            if (!empty($request->body)) {
                $body = $request->body;
            } elseif (!empty($id)) {
                if (isset($request->user) & isset($request->course)) {
                    $body = $certificate->body;
                    $body = str_replace("[name]", strtoupper($request->user->name), $body);
                    $body = str_replace("[course]", strtoupper($request->course->title), $body);
                } else {
                    $body = $certificate->body ?? '';
                }

            } else {

                $body = '';
            }

            if (!empty($request->body_position_x)) {
                $body_position_x = $request->body_position_x;
            } elseif (!empty($id)) {
                $body_position_x = $certificate->body_position_x ?? 0;
            } else {
                $body_position_x = 0;
            }

            if (!empty($request->body_position_y)) {
                $body_position_y = $request->body_position_y;
            } elseif (!empty($id)) {
                $body_position_y = $certificate->body_position_y ?? 0;
            } else {
                $body_position_y = 0;
            }

            if (!empty($request->body_font_family)) {
                $body_font_family = $request->body_font_family;
            } elseif (!empty($id)) {
                $body_font_family = $certificate->body_font_family ?? 'nunito';
            } else {
                $body_font_family = 'nunito';
            }


            if (!empty($request->body_max_len)) {
                $body_max_len = $request->body_max_len;
            } elseif (!empty($id)) {
                $body_max_len = $certificate->body_max_len ?? 80;
            } else {
                $body_max_len = 80;
            }

            if (!empty($request->body_font_size)) {
                $body_font_size = $request->body_font_size;
            } elseif (!empty($id)) {
                $body_font_size = $certificate->body_font_size ?? 25;
            } else {
                $body_font_size = 25;
            };

            if (!empty($request->body_font_color)) {
                $body_font_color = $request->body_font_color;
            } elseif (!empty($id)) {
                $body_font_color = $certificate->body_font_color ?? '#000';
            } else {
                $body_font_color = '#000';
            }


            if (isset($request->profile)) {
                $profile = $request->profile;
            } elseif (!empty($id)) {
                $profile = $certificate->profile ?? 0;
            } else {
                $profile = 0;
            }

            if (!empty($request->profile_x)) {
                $profile_x = $request->profile_x;
            } elseif (!empty($id)) {
                $profile_x = $certificate->profile_x ?? 0;
            } else {
                $profile_x = 0;
            }


            if (!empty($request->profile_y)) {
                $profile_y = $request->profile_y;
            } elseif (!empty($id)) {
                $profile_y = $certificate->profile_y ?? 0;
            } else {
                $profile_y = 0;
            }


            if (!empty($request->profile_height)) {
                $profile_height = $request->profile_height;
            } elseif (!empty($id)) {
                $profile_height = $certificate->profile_height ?? 50;
            } else {
                $profile_height = 50;
            }


            if (!empty($request->profile_weight)) {
                $profile_weight = $request->profile_weight;
            } elseif (!empty($id)) {
                $profile_weight = $certificate->profile_weight ?? 50;
            } else {
                $profile_weight = 50;
            }


//        qr start
            if (isset($request->qr)) {
                $qr = $request->qr;
            } elseif (!empty($id)) {
                $qr = $certificate->qr ?? 0;
            } else {
                $qr = 0;
            }

            if (!empty($request->qr_x)) {
                $qr_x = $request->qr_x;
            } elseif (!empty($id)) {
                $qr_x = $certificate->qr_x ?? 0;
            } else {
                $qr_x = 0;
            }


            if (!empty($request->qr_y)) {
                $qr_y = $request->qr_y;
            } elseif (!empty($id)) {
                $qr_y = $certificate->qr_y ?? 0;
            } else {
                $qr_y = 0;
            }


            if (!empty($request->qr_height)) {
                $qr_height = $request->qr_height;
            } elseif (!empty($id)) {
                $qr_height = $certificate->qr_height ?? 50;
            } else {
                $qr_height = 50;
            }


            if (!empty($request->qr_weight)) {
                $qr_weight = $request->qr_weight;
            } elseif (!empty($id)) {
                $qr_weight = $certificate->qr_weight ?? 50;
            } else {
                $qr_weight = 50;
            }
//        qr end


            $studentName = 'Student Name';
            if (isset($request->name)) {
                $name = $request->name;
            } elseif (isset($certificate->name)) {
                if (isset($request->user) & isset($request->course)) {
                    $studentName = strtoupper($request->user->name);
                }
                $name = $certificate->name;
            } else {
                $name = 1;
            }


            if (!empty($request->name_position_x)) {
                $name_position_x = $request->name_position_x;
            } elseif (!empty($id)) {
                $name_position_x = $certificate->name_position_x ?? 0;
            } else {
                $name_position_x = 0;
            }

            if (!empty($request->name_position_y)) {
                $name_position_y = $request->name_position_y;
            } elseif (!empty($id)) {
                $name_position_y = $certificate->name_position_y ?? 0;
            } else {
                $name_position_y = 0;
            }

            if (!empty($request->name_font_family)) {
                $name_font_family = $request->name_font_family;
            } elseif (!empty($id)) {
                $name_font_family = $certificate->name_font_family ?? 'nunito';
            } else {
                $name_font_family = 'nunito';
            }

            if (!empty($request->name_font_size)) {
                $name_font_size = $request->name_font_size;
            } elseif (!empty($id)) {
                $name_font_size = $certificate->name_font_size ?? 50;
            } else {
                $name_font_size = 50;
            }

            if (!empty($request->name_font_color)) {
                $name_font_color = $request->name_font_color;
            } elseif (!empty($id)) {
                $name_font_color = $certificate->name_font_color ?? '#000';
            } else {
                $name_font_color = '#000';
            }
// CP Name
            $cPName = "Content Provider's Name";
            if (isset($request->cp_name)) {
                $cp_name = $request->cp_name;
            } elseif (isset($certificate->cp_name)) {
                if (isset($request->user) & isset($request->course)) {
                    $cPName = strtoupper($request->course->user->name);
                }
                $cp_name = $certificate->cp_name;
            } else {
                $cp_name = 1;
            }


            if (!empty($request->cp_position_x)) {
                $cp_position_x = $request->cp_position_x;
            } elseif (!empty($id)) {
                $cp_position_x = $certificate->cp_position_x ?? 0;
            } else {
                $cp_position_x = 0;
            }

            if (!empty($request->cp_position_y)) {
                $cp_position_y = $request->cp_position_y;
            } elseif (!empty($id)) {
                $cp_position_y = $certificate->cp_position_y ?? 0;
            } else {
                $cp_position_y = 0;
            }

            if (!empty($request->cp_font_family)) {
                $cp_font_family = $request->cp_font_family;
            } elseif (!empty($id)) {
                $cp_font_family = $certificate->cp_font_family ?? 'nunito';
            } else {
                $cp_font_family = 'nunito';
            }

            if (!empty($request->cp_font_size)) {
                $cp_font_size = $request->cp_font_size;
            } elseif (!empty($id)) {
                $cp_font_size = $certificate->cp_font_size ?? 50;
            } else {
                $cp_font_size = 50;
            }

            if (!empty($request->cp_font_color)) {
                $cp_font_color = $request->cp_font_color;
            } elseif (!empty($id)) {
                $cp_font_color = $certificate->cp_font_color ?? '#000';
            } else {
                $cp_font_color = '#000';
            }

//Certificate Noumber

            if (isset($request->certificate_no)) {
                $certificate_no = $request->certificate_no;
            } elseif (isset($certificate->certificate_no)) {
                $certificate_no = $certificate->certificate_no;
            } else {
                $certificate_no = 0;
            }

            if (!empty($request->certificate_no_position_x)) {
                $certificate_no_position_x = $request->certificate_no_position_x;
            } elseif (!empty($id)) {
                $certificate_no_position_x = $certificate->certificate_no_position_x ?? 0;
            } else {
                $certificate_no_position_x = 0;
            }

            if (!empty($request->certificate_no_position_y)) {
                $certificate_no_position_y = $request->certificate_no_position_y;
            } elseif (!empty($id)) {
                $certificate_no_position_y = $certificate->certificate_no_position_y ?? 0;
            } else {
                $certificate_no_position_y = 0;
            }

            if (!empty($request->certificate_no_font_family)) {
                $certificate_no_font_family = $request->certificate_no_font_family;
            } elseif (!empty($id)) {
                $certificate_no_font_family = $certificate->certificate_no_font_family ?? 'nunito';
            } else {
                $certificate_no_font_family = 'nunito';
            }

            if (!empty($request->certificate_no_font_size)) {
                $certificate_no_font_size = $request->certificate_no_font_size;
            } elseif (!empty($id)) {
                $certificate_no_font_size = $certificate->certificate_no_font_size ?? 30;
            } else {
                $certificate_no_font_size = 30;
            }

            if (!empty($request->certificate_no_font_color)) {
                $certificate_no_font_color = $request->certificate_no_font_color;
            } elseif (!empty($id)) {
                $certificate_no_font_color = $certificate->certificate_no_font_color ?? '#000';
            } else {
                $certificate_no_font_color = '#000';
            }

            //Date

            if (isset($request->date)) {
                $date = $request->date;
            } elseif (isset($certificate->date)) {
                $date = $certificate->date;
            } else {
                $date = 0;
            }

            if (!empty($request->date_position_x)) {
                $date_position_x = $request->date_position_x;
            } elseif (!empty($id)) {
                $date_position_x = $certificate->date_position_x ?? 0;
            } else {
                $date_position_x = 0;
            }

            if (!empty($request->date_position_y)) {
                $date_position_y = $request->date_position_y;
            } elseif (!empty($id)) {
                $date_position_y = $certificate->date_position_y ?? 0;
            } else {
                $date_position_y = 0;
            }

            if (!empty($request->date_font_family)) {
                $date_font_family = $request->date_font_family;
            } elseif (!empty($id)) {
                $date_font_family = $certificate->date_font_family ?? 'nunito';
            } else {
                $date_font_family = 'nunito';
            }


            if (!empty($request->date_font_size)) {
                $date_font_size = $request->date_font_size;
            } elseif (!empty($id)) {
                $date_font_size = $certificate->date_font_size ?? 30;
            } else {
                $date_font_size = 30;
            }

            if (!empty($request->date_font_color)) {
                $date_font_color = $request->date_font_color;
            } elseif (!empty($id)) {
                $date_font_color = $certificate->date_font_color ?? '#000';
            } else {
                $date_font_color = '#000';
            }


            if (!empty($request->date_format)) {
                $date_format = $request->date_format;
            } elseif (!empty($id)) {
                $date_format = $certificate->date_format ?? 1;
            } else {
                $date_format = 1;
            }


            if (!empty($request->signature_position_x)) {
                $signature_position_x = $request->signature_position_x;
            } elseif (!empty($id)) {
                $signature_position_x = $certificate->signature_position_x ?? 0;
            } else {
                $signature_position_x = 0;
            }


            if (!empty($request->signature_position_y)) {
                $signature_position_y = $request->signature_position_y;
            } elseif (!empty($id)) {
                $signature_position_y = $certificate->signature_position_y ?? 0;
            } else {
                $signature_position_y = 0;
            }


            if (!empty($request->signature_height)) {
                $signature_height = $request->signature_height;
            } elseif (!empty($id)) {
                $signature_height = $certificate->signature_height ?? 100;
            } else {
                $signature_height = 70;
            }

            if (!empty($request->signature_weight)) {
                $signature_weight = $request->signature_weight;
            } elseif (!empty($id)) {
                $signature_weight = $certificate->signature_weight ?? 100;
            } else {
                $signature_weight = 100;
            }

            if (!empty($request->signature_text)) {
                $signature_text = $request->signature_text;
            } elseif (!empty($id)) {
                $signature_text = $certificate->signature_text ?? '';
            } else {
                $signature_text = '';
            }
            if (!empty($request->signature_text_position_x)) {
                $signature_text_position_x = $request->signature_text_position_x;
            } elseif (!empty($id)) {
                $signature_text_position_x = $certificate->signature_text_position_x ?? 0;
            } else {
                $signature_text_position_x = 0;
            }

            if (!empty($request->signature_text_position_y)) {
                $signature_text_position_y = $request->signature_text_position_y;
            } elseif (!empty($id)) {
                $signature_text_position_y = $certificate->signature_text_position_y ?? 0;
            } else {
                $signature_text_position_y = 0;
            }

            if (!empty($request->signature_text_font_family)) {
                $signature_text_font_family = $request->signature_text_font_family;
            } elseif (!empty($id)) {
                $signature_text_font_family = $certificate->signature_text_font_family ?? 'nunito';
            } else {
                $signature_text_font_family = 'nunito';
            }


            if (!empty($request->signature_text_font_size)) {
                $signature_text_font_size = $request->signature_text_font_size;
            } elseif (!empty($id)) {
                $signature_text_font_size = $certificate->signature_text_font_size ?? 30;
            } else {
                $signature_text_font_size = 30;
            }


            if (!empty($request->signature_text_font_color)) {
                $signature_text_font_color = $request->signature_text_font_color;
            } elseif (!empty($id)) {
                $signature_text_font_color = $certificate->signature_text_font_color ?? '#000';
            } else {
                $signature_text_font_color = '#000';
            }


            //title part
            $img->text($title, ($width / 2) + $title_position_x, $title_position_y + 150, function ($font) use ($title_font_family, $title_font_size, $title_font_color) {
                $font->size($title_font_size);
                $font->file(public_path('fonts/' . $title_font_family . '.ttf'));
                $font->color($title_font_color);
                $font->align('center');
                $font->valign('top');
            });

            if ($name == 1) {
				$center_x = ($width / 2) + $name_position_x;
				$center_y = $name_position_y + 200;
				$font_height = 20;
	            $lines = explode("\n", wordwrap($studentName, $body_max_len));
				$y = $center_y - ((count($lines) - 1) * $font_height);
				foreach ($lines as $line) {
					$img->text($line, $center_x, $y , function ($font) use ($name_font_family, $name_font_size, $name_font_color) {
						$font->size($name_font_size);
						$font->file(public_path('fonts/' . $name_font_family . '.ttf'));
						$font->color($name_font_color);
						$font->align('center');
						$font->valign('top');
					});
					$y += $font_height * 4;
				}
            }

            if ($cp_name == 1) {
				$center_x = ($width / 2) + $cp_position_x;
				$center_y = $cp_position_y + 200;
				$font_height = 20;
	            $lines = explode("\n", wordwrap($cPName, $body_max_len));
				$y = $center_y - ((count($lines) - 1) * $font_height);
				foreach ($lines as $line) {
					$img->text($line, $center_x, $y , function ($font) use ($cp_font_family, $cp_font_size, $cp_font_color) {
						$font->size($cp_font_size);
						$font->file(public_path('fonts/' . $cp_font_family . '.ttf'));
						$font->color($cp_font_color);
						$font->align('center');
						$font->valign('top');
					});
					$y += $font_height * 4;
				}
            }



// body part
            $center_x = ($width / 2) + $body_position_x;
            $center_y = ($height / 2) + $body_position_y;
            $max_len = $body_max_len;
            $font_height = 20;
            $lines = explode("\n", wordwrap("HRD Corp e-LATiH\n".$body, $max_len));
            $y = $center_y - ((count($lines) - 1) * $font_height);
            foreach ($lines as $line) {
                $img->text($line, $center_x, $y, function ($font) use ($body_font_size, $body_font_family, $body_font_color) {
                    $font->file(public_path('fonts/' . $body_font_family . '.ttf'));
                    $font->size($body_font_size);
                    $font->color($body_font_color);
                    $font->align('center');
                    $font->valign('center');
                });
                $y += $font_height * 4;
            }


            //Profile  part
            if ($profile == 1) {
                if (isset($request->user) & isset($request->course)) {
                    $imagePath = getStudentImage($request->user->image);

                } else {
                    $imagePath = public_path('uploads/staff/user.png');
                }

                $profileImageRow = Image::make($imagePath);
                $profileImageRow->resize($profile_weight, $profile_height);
                $profileImg = Image::canvas($profile_weight, $profile_height);
                $profileImg->opacity(0);
                $profileImg->insert($profileImageRow, 'center', 0, 0);
                $img->insert($profileImg, 'top-left', $profile_x + 200, $profile_y + 250);
            }

            //START QR CODE SECTION
            if ($qr == 1) {
                if (in_array('imagick', get_loaded_extensions())) {
                    try {
                        \QrCode::size(500)
                            ->format('png')
                            ->generate(url('verify-certificate/') . '/' . $request->certificate_id, public_path('images/qrcode/' . $request->certificate_id . '.png'));

                        $qrImageRow = Image::make(public_path('images/qrcode/' . $request->certificate_id . '.png'));
                        $qrImageRow->resize($qr_weight, $qr_height);
                        $qrImg = Image::canvas($qr_weight, $qr_height);
                        $qrImg->opacity(0);

                        $qrImg->insert($qrImageRow, 'center', 0, 0);
                        $img->insert($qrImg, 'top-left', $qr_x + 600, $qr_y + 250);

                    } catch (\Exception $e) {
                        Log::info($e->getMessage());
                    }
                } else {
                    Log::info('php imagick extention not found');
                }
            }

            // dd($certificate_no_font_family);
            if ($certificate_no == 1) {
                $img->text('Certificate No: ' . $request->certificate_id, (200 + ($width / 2)) + $certificate_no_position_x, (($height / 2) - 250) + $certificate_no_position_y, function ($font) use ($certificate_no_font_color, $certificate_no_font_size, $certificate_no_font_family) {
                    $font->size($certificate_no_font_size);
                    $font->file(public_path('fonts/' . $certificate_no_font_family . '.ttf'));
                    $font->color($certificate_no_font_color);
                    $font->align('right');
                    $font->valign('right');

                });
            }


            //END QR CODE SECTION
            if ($date == 1) {

                $dateFormat = DateFormat::find($date_format);
                $cerdate = date($dateFormat->format,strtotime($request->cert_created_at));
				$search = array('nd', 'th', 'rd', ',');
				$replace = array('', '', '', '');
				$img->text(strtoupper(str_replace($search, $replace, $cerdate)), (($width / 2)) + $date_position_x, (($height / 2) - 200) + $date_position_y, function ($font) use ($date_font_color, $date_font_size, $date_font_family) {
                    $font->size($date_font_size);
                    $font->file(public_path('fonts/' . $date_font_family . '.ttf'));
                    $font->color($date_font_color);
                    $font->align('center');
                    $font->valign('center');

                });

            }
//

            if (!empty($sig_image)) {
                $sigImageRow = Image::make(asset($sig_image));
                $sigImageRow->resize($signature_weight, $signature_height);
                $sigImg = Image::canvas($signature_weight, $signature_height);
                $sigImg->opacity(0);
                $sigImg->insert($sigImageRow, 'center', 0, 0);
                $img->insert($sigImg, 'top-left', $signature_position_x + 650, $signature_position_y + 750);

////            $img->insert($sigImg, 'center', $signature_position_x + 300, $signature_position_y + 200);
            }


            $img->text('', ($width / 2) + $signature_text_position_x, ($height - (round($height / 5))) + $signature_text_position_y, function ($font) use ($signature_text_font_size, $signature_text_font_color, $signature_text_font_family) {
                $font->size($signature_text_font_size);
                $font->file(public_path('fonts/' . $signature_text_font_family . '.ttf'));
                $font->color($signature_text_font_color);
                $font->align('center');
                $font->valign('bottom');

            });


            $img->text($signature_text, ($width / 2) + $signature_text_position_x, ($height - (round($height / 7) + $signature_text_position_y)), function ($font) use ($signature_text_font_size, $signature_text_font_color, $signature_text_font_family) {
                $font->size($signature_text_font_size);
                $font->file(public_path('fonts/' . $signature_text_font_family . '.ttf'));
                $font->color($signature_text_font_color);
                $font->align('center');
                $font->valign('bottom');

            });
            $data['image'] = $img;
            $data['height'] = $height;
            $data['width'] = $width;
            return $data;
        } catch (\Exception $e) {
            return null;
        }
    }

    /*History Certificate create*/
     public function historymakeCertificate($id, Request $request)
    {

        try {
            if (!empty($id)) {
                $certificate = Certificate::find($id);
            }
            if (!empty($request->bgImage)) {
                $bg_image = $request->bgImage;
            } elseif ($id) {
                $bg_image = $certificate->image ?? '';
            } else {
                $bg_image = '';
            }


            if (!empty($request->sigImageInput)) {
                $sig_image = $request->sigImageInput;
            } elseif ($id) {
                $sig_image = $certificate->signature ?? '';
            } else {
                $sig_image = '';
            }

            if (!empty($request->bgImage) || $id) {

                $bg_image = asset($bg_image);
                $bg_image = str_replace('https:', 'http:', $bg_image);
                $width = getimagesize($bg_image)[0] ?? 1300;
                $height = getimagesize($bg_image)[1] ?? 910;
            } else {
                $width = 1300;
                $height = 910;
            };


            $img = Image::canvas($width, $height);
            if (!empty($bg_image)) {
                $img->insert(asset($bg_image));
            }


            if (!empty($request->title)) {
                $title = $request->title;
            } elseif (!empty($id)) {
                $title = $certificate->title ?? '';
            } else {
                $title = 'Certificate Title';
            }

            if (!empty($request->title_position_x)) {
                $title_position_x = $request->title_position_x;
            } elseif (!empty($id)) {
                $title_position_x = $certificate->title_position_x ?? '';
            } else {
                $title_position_x = 0;
            }


            if (!empty($request->title_position_y)) {
                $title_position_y = $request->title_position_y;
            } elseif (!empty($id)) {
                $title_position_y = $certificate->title_position_y ?? '';
            } else {
                $title_position_y = 0;
            }


            if (!empty($request->title_font_color)) {
                $title_font_color = $request->title_font_color;
            } elseif (!empty($id)) {
                $title_font_color = $certificate->title_font_color ?? '#000';
            } else {
                $title_font_color = '#000';
            }


            if (!empty($request->title_font_size)) {
                $title_font_size = $request->title_font_size;
            } elseif (!empty($id)) {
                $title_font_size = $certificate->title_font_size ?? 30;
            } else {
                $title_font_size = 30;
            }

            if (!empty($request->title_font_family)) {
                $title_font_family = $request->title_font_family;
            } elseif (!empty($id)) {
                $title_font_family = $certificate->title_font_family ?? 'nunito';
            } else {
                $title_font_family = 'nunito';
            }

//body part style start form here
            if (!empty($request->body)) {
                $body = $request->body;
            } elseif (!empty($id)) {
                if (isset($request->name) & isset($request->title)) {
                    $body = $certificate->body;
                    $body = str_replace("[name]", strtoupper($request->name), $body);
                    $body = str_replace("[course]", strtoupper($request->title), $body);
                } else {
                    $body = $certificate->body ?? '';
                }

            } else {

                $body = '';
            }

            if (!empty($request->body_position_x)) {
                $body_position_x = $request->body_position_x;
            } elseif (!empty($id)) {
                $body_position_x = $certificate->body_position_x ?? 0;
            } else {
                $body_position_x = 0;
            }

            if (!empty($request->body_position_y)) {
                $body_position_y = $request->body_position_y;
            } elseif (!empty($id)) {
                $body_position_y = $certificate->body_position_y ?? 0;
            } else {
                $body_position_y = 0;
            }

            if (!empty($request->body_font_family)) {
                $body_font_family = $request->body_font_family;
            } elseif (!empty($id)) {
                $body_font_family = $certificate->body_font_family ?? 'nunito';
            } else {
                $body_font_family = 'nunito';
            }


            if (!empty($request->body_max_len)) {
                $body_max_len = $request->body_max_len;
            } elseif (!empty($id)) {
                $body_max_len = $certificate->body_max_len ?? 80;
            } else {
                $body_max_len = 80;
            }

            if (!empty($request->body_font_size)) {
                $body_font_size = $request->body_font_size;
            } elseif (!empty($id)) {
                $body_font_size = $certificate->body_font_size ?? 25;
            } else {
                $body_font_size = 25;
            };

            if (!empty($request->body_font_color)) {
                $body_font_color = $request->body_font_color;
            } elseif (!empty($id)) {
                $body_font_color = $certificate->body_font_color ?? '#000';
            } else {
                $body_font_color = '#000';
            }


            if (isset($request->profile)) {
                $profile = $request->profile;
            } elseif (!empty($id)) {
                $profile = $certificate->profile ?? 0;
            } else {
                $profile = 0;
            }

            if (!empty($request->profile_x)) {
                $profile_x = $request->profile_x;
            } elseif (!empty($id)) {
                $profile_x = $certificate->profile_x ?? 0;
            } else {
                $profile_x = 0;
            }


            if (!empty($request->profile_y)) {
                $profile_y = $request->profile_y;
            } elseif (!empty($id)) {
                $profile_y = $certificate->profile_y ?? 0;
            } else {
                $profile_y = 0;
            }


            if (!empty($request->profile_height)) {
                $profile_height = $request->profile_height;
            } elseif (!empty($id)) {
                $profile_height = $certificate->profile_height ?? 50;
            } else {
                $profile_height = 50;
            }


            if (!empty($request->profile_weight)) {
                $profile_weight = $request->profile_weight;
            } elseif (!empty($id)) {
                $profile_weight = $certificate->profile_weight ?? 50;
            } else {
                $profile_weight = 50;
            }


//        qr start
            if (isset($request->qr)) {
                $qr = $request->qr;
            } elseif (!empty($id)) {
                $qr = $certificate->qr ?? 0;
            } else {
                $qr = 0;
            }

            if (!empty($request->qr_x)) {
                $qr_x = $request->qr_x;
            } elseif (!empty($id)) {
                $qr_x = $certificate->qr_x ?? 0;
            } else {
                $qr_x = 0;
            }


            if (!empty($request->qr_y)) {
                $qr_y = $request->qr_y;
            } elseif (!empty($id)) {
                $qr_y = $certificate->qr_y ?? 0;
            } else {
                $qr_y = 0;
            }


            if (!empty($request->qr_height)) {
                $qr_height = $request->qr_height;
            } elseif (!empty($id)) {
                $qr_height = $certificate->qr_height ?? 50;
            } else {
                $qr_height = 50;
            }


            if (!empty($request->qr_weight)) {
                $qr_weight = $request->qr_weight;
            } elseif (!empty($id)) {
                $qr_weight = $certificate->qr_weight ?? 50;
            } else {
                $qr_weight = 50;
            }
//        qr end

			$studentName = 'Student Name';
            if (isset($request->name)) {
                $studentName = strtoupper($request->name);
            }
            $name = 1;

            if (!empty($request->name_position_x)) {
                $name_position_x = $request->name_position_x;
            } elseif (!empty($id)) {
                $name_position_x = $certificate->name_position_x ?? 0;
            } else {
                $name_position_x = 0;
            }

            if (!empty($request->name_position_y)) {
                $name_position_y = $request->name_position_y;
            } elseif (!empty($id)) {
                $name_position_y = $certificate->name_position_y ?? 0;
            } else {
                $name_position_y = 0;
            }

            if (!empty($request->name_font_family)) {
                $name_font_family = $request->name_font_family;
            } elseif (!empty($id)) {
                $name_font_family = $certificate->name_font_family ?? 'nunito';
            } else {
                $name_font_family = 'nunito';
            }

            if (!empty($request->name_font_size)) {
                $name_font_size = $request->name_font_size;
            } elseif (!empty($id)) {
                $name_font_size = $certificate->name_font_size ?? 50;
            } else {
                $name_font_size = 50;
            }

            if (!empty($request->name_font_color)) {
                $name_font_color = $request->name_font_color;
            } elseif (!empty($id)) {
                $name_font_color = $certificate->name_font_color ?? '#000';
            } else {
                $name_font_color = '#000';
            }

            $cPName = "Content Provider's Name";
            // if (isset($request->cp_name)) {
            //     $cPName = strtoupper($request->cp_name);
            // }
            // $cp_name = 1;
            if (isset($request->cp_name)) {
                $cp_name = $request->cp_name;
            } elseif (isset($certificate->cp_name)) {
                if (isset($request->user) & isset($request->course)) {
                    $cPName = strtoupper($request->course->user->name);
                }
                $cp_name = $certificate->cp_name;
            } else {
                $cp_name = 1;
            }

            if (!empty($request->cp_position_x)) {
                $cp_position_x = $request->cp_position_x;
            } elseif (!empty($id)) {
                $cp_position_x = $certificate->cp_position_x ?? 0;
            } else {
                $cp_position_x = 0;
            }

            if (!empty($request->cp_position_y)) {
                $cp_position_y = $request->cp_position_y;
            } elseif (!empty($id)) {
                $cp_position_y = $certificate->cp_position_y ?? 0;
            } else {
                $cp_position_y = 0;
            }

            if (!empty($request->cp_font_family)) {
                $cp_font_family = $request->cp_font_family;
            } elseif (!empty($id)) {
                $cp_font_family = $certificate->cp_font_family ?? 'nunito';
            } else {
                $cp_font_family = 'nunito';
            }

            if (!empty($request->cp_font_size)) {
                $cp_font_size = $request->cp_font_size;
            } elseif (!empty($id)) {
                $cp_font_size = $certificate->cp_font_size ?? 50;
            } else {
                $cp_font_size = 50;
            }

            if (!empty($request->cp_font_color)) {
                $cp_font_color = $request->cp_font_color;
            } elseif (!empty($id)) {
                $cp_font_color = $certificate->cp_font_color ?? '#000';
            } else {
                $cp_font_color = '#000';
            }

//Certificate Noumber

            if (isset($request->certificate_no)) {
                $certificate_no = $request->certificate_no;
            } elseif (isset($certificate->certificate_no)) {
                $certificate_no = $certificate->certificate_no;
            } else {
                $certificate_no = 0;
            }

            if (!empty($request->certificate_no_position_x)) {
                $certificate_no_position_x = $request->certificate_no_position_x;
            } elseif (!empty($id)) {
                $certificate_no_position_x = $certificate->certificate_no_position_x ?? 0;
            } else {
                $certificate_no_position_x = 0;
            }

            if (!empty($request->certificate_no_position_y)) {
                $certificate_no_position_y = $request->certificate_no_position_y;
            } elseif (!empty($id)) {
                $certificate_no_position_y = $certificate->certificate_no_position_y ?? 0;
            } else {
                $certificate_no_position_y = 0;
            }

            if (!empty($request->certificate_no_font_family)) {
                $certificate_no_font_family = $request->certificate_no_font_family;
            } elseif (!empty($id)) {
                $certificate_no_font_family = $certificate->certificate_no_font_family ?? 'nunito';
            } else {
                $certificate_no_font_family = 'nunito';
            }

            if (!empty($request->certificate_no_font_size)) {
                $certificate_no_font_size = $request->certificate_no_font_size;
            } elseif (!empty($id)) {
                $certificate_no_font_size = $certificate->certificate_no_font_size ?? 30;
            } else {
                $certificate_no_font_size = 30;
            }

            if (!empty($request->certificate_no_font_color)) {
                $certificate_no_font_color = $request->certificate_no_font_color;
            } elseif (!empty($id)) {
                $certificate_no_font_color = $certificate->certificate_no_font_color ?? '#000';
            } else {
                $certificate_no_font_color = '#000';
            }

            //Date

            if (isset($request->date)) {
                $date = $request->date;
            } elseif (isset($certificate->date)) {
                $date = $certificate->date;
            } else {
                $date = 0;
            }

            if (!empty($request->date_position_x)) {
                $date_position_x = $request->date_position_x;
            } elseif (!empty($id)) {
                $date_position_x = $certificate->date_position_x ?? 0;
            } else {
                $date_position_x = 0;
            }

            if (!empty($request->date_position_y)) {
                $date_position_y = $request->date_position_y;
            } elseif (!empty($id)) {
                $date_position_y = $certificate->date_position_y ?? 0;
            } else {
                $date_position_y = 0;
            }

            if (!empty($request->date_font_family)) {
                $date_font_family = $request->date_font_family;
            } elseif (!empty($id)) {
                $date_font_family = $certificate->date_font_family ?? 'nunito';
            } else {
                $date_font_family = 'nunito';
            }


            if (!empty($request->date_font_size)) {
                $date_font_size = $request->date_font_size;
            } elseif (!empty($id)) {
                $date_font_size = $certificate->date_font_size ?? 30;
            } else {
                $date_font_size = 30;
            }

            if (!empty($request->date_font_color)) {
                $date_font_color = $request->date_font_color;
            } elseif (!empty($id)) {
                $date_font_color = $certificate->date_font_color ?? '#000';
            } else {
                $date_font_color = '#000';
            }


            if (!empty($request->date_format)) {
                $date_format = $request->date_format;
            } elseif (!empty($id)) {
                $date_format = $certificate->date_format ?? 1;
            } else {
                $date_format = 1;
            }


            if (!empty($request->signature_position_x)) {
                $signature_position_x = $request->signature_position_x;
            } elseif (!empty($id)) {
                $signature_position_x = $certificate->signature_position_x ?? 0;
            } else {
                $signature_position_x = 0;
            }


            if (!empty($request->signature_position_y)) {
                $signature_position_y = $request->signature_position_y;
            } elseif (!empty($id)) {
                $signature_position_y = $certificate->signature_position_y ?? 0;
            } else {
                $signature_position_y = 0;
            }


            if (!empty($request->signature_height)) {
                $signature_height = $request->signature_height;
            } elseif (!empty($id)) {
                $signature_height = $certificate->signature_height ?? 100;
            } else {
                $signature_height = 70;
            }

            if (!empty($request->signature_weight)) {
                $signature_weight = $request->signature_weight;
            } elseif (!empty($id)) {
                $signature_weight = $certificate->signature_weight ?? 100;
            } else {
                $signature_weight = 100;
            }

            if (!empty($request->signature_text)) {
                $signature_text = $request->signature_text;
            } elseif (!empty($id)) {
                $signature_text = $certificate->signature_text ?? '';
            } else {
                $signature_text = '';
            }
            if (!empty($request->signature_text_position_x)) {
                $signature_text_position_x = $request->signature_text_position_x;
            } elseif (!empty($id)) {
                $signature_text_position_x = $certificate->signature_text_position_x ?? 0;
            } else {
                $signature_text_position_x = 0;
            }

            if (!empty($request->signature_text_position_y)) {
                $signature_text_position_y = $request->signature_text_position_y;
            } elseif (!empty($id)) {
                $signature_text_position_y = $certificate->signature_text_position_y ?? 0;
            } else {
                $signature_text_position_y = 0;
            }

            if (!empty($request->signature_text_font_family)) {
                $signature_text_font_family = $request->signature_text_font_family;
            } elseif (!empty($id)) {
                $signature_text_font_family = $certificate->signature_text_font_family ?? 'nunito';
            } else {
                $signature_text_font_family = 'nunito';
            }


            if (!empty($request->signature_text_font_size)) {
                $signature_text_font_size = $request->signature_text_font_size;
            } elseif (!empty($id)) {
                $signature_text_font_size = $certificate->signature_text_font_size ?? 30;
            } else {
                $signature_text_font_size = 30;
            }


            if (!empty($request->signature_text_font_color)) {
                $signature_text_font_color = $request->signature_text_font_color;
            } elseif (!empty($id)) {
                $signature_text_font_color = $certificate->signature_text_font_color ?? '#000';
            } else {
                $signature_text_font_color = '#000';
            }


            //title part
            $img->text($title, ($width / 2) + $title_position_x, $title_position_y + 150, function ($font) use ($title_font_family, $title_font_size, $title_font_color) {
                $font->size($title_font_size);
                $font->file(public_path('fonts/' . $title_font_family . '.ttf'));
                $font->color($title_font_color);
                $font->align('center');
                $font->valign('top');
            });

            if ($name == 1) {
				$center_x = ($width / 2) + $name_position_x;
				$center_y = $name_position_y + 200;
				$font_height = 20;
	            $lines = explode("\n", wordwrap($studentName, $body_max_len));
				$y = $center_y - ((count($lines) - 1) * $font_height);
				foreach ($lines as $line) {
					$img->text($line, $center_x, $y , function ($font) use ($name_font_family, $name_font_size, $name_font_color) {
						$font->size($name_font_size);
						$font->file(public_path('fonts/' . $name_font_family . '.ttf'));
						$font->color($name_font_color);
						$font->align('center');
						$font->valign('top');
					});
					$y += $font_height * 4;
				}
            }
            if ($cp_name == 1) {
				$center_x = ($width / 2) + $cp_position_x;
				$center_y = $cp_position_y + 200;
				$font_height = 20;
	            $lines = explode("\n", wordwrap($cPName, $body_max_len));
				$y = $center_y - ((count($lines) - 1) * $font_height);
				foreach ($lines as $line) {
					$img->text($line, $center_x, $y , function ($font) use ($cp_font_family, $cp_font_size, $cp_font_color) {
						$font->size($cp_font_size);
						$font->file(public_path('fonts/' . $cp_font_family . '.ttf'));
						$font->color($cp_font_color);
						$font->align('center');
						$font->valign('top');
					});
					$y += $font_height * 4;
				}
            }


// body part
            $center_x = ($width / 2) + $body_position_x;
            $center_y = ($height / 2) + $body_position_y;
            $max_len = $body_max_len;
            $font_height = 20;
            $lines = explode("\n", wordwrap("HRD Corp e-LATiH\n".$body, $max_len));
            $y = $center_y - ((count($lines) - 1) * $font_height);
            foreach ($lines as $line) {
                $img->text($line, $center_x, $y, function ($font) use ($body_font_size, $body_font_family, $body_font_color) {
                    $font->file(public_path('fonts/' . $body_font_family . '.ttf'));
                    $font->size($body_font_size);
                    $font->color($body_font_color);
                    $font->align('center');
                    $font->valign('center');
                });
                $y += $font_height * 4;
            }


            //Profile  part
            if ($profile == 1) {
                if (isset($request->user) & isset($request->course)) {
                    $imagePath = getStudentImage($request->user->image);

                } else {
                    $imagePath = public_path('uploads/staff/user.png');
                }

                $profileImageRow = Image::make($imagePath);
                $profileImageRow->resize($profile_weight, $profile_height);
                $profileImg = Image::canvas($profile_weight, $profile_height);
                $profileImg->opacity(0);
                $profileImg->insert($profileImageRow, 'center', 0, 0);
                $img->insert($profileImg, 'top-left', $profile_x + 200, $profile_y + 250);
            }

            //START QR CODE SECTION
            if ($qr == 1) {
                if (in_array('imagick', get_loaded_extensions())) {
                    try {
                        \QrCode::size(500)
                            ->format('png')
                            ->generate(url('verify-certificate/') . '/' . $request->certificate_id, public_path('images/qrcode/' . $request->certificate_id . '.png'));

                        $qrImageRow = Image::make(public_path('images/qrcode/' . $request->certificate_id . '.png'));
                        $qrImageRow->resize($qr_weight, $qr_height);
                        $qrImg = Image::canvas($qr_weight, $qr_height);
                        $qrImg->opacity(0);

                        $qrImg->insert($qrImageRow, 'center', 0, 0);
                        $img->insert($qrImg, 'top-left', $qr_x + 600, $qr_y + 250);

                    } catch (\Exception $e) {
                        Log::info($e->getMessage());
                    }
                } else {
                    Log::info('php imagick extention not found');
                }
            }

            // dd($certificate_no_font_family);
            if ($certificate_no == 1) {
                $img->text('Certificate No: ' . $request->certificate_id, (200 + ($width / 2)) + $certificate_no_position_x, (($height / 2) - 250) + $certificate_no_position_y, function ($font) use ($certificate_no_font_color, $certificate_no_font_size, $certificate_no_font_family) {
                    $font->size($certificate_no_font_size);
                    $font->file(public_path('fonts/' . $certificate_no_font_family . '.ttf'));
                    $font->color($certificate_no_font_color);
                    $font->align('right');
                    $font->valign('right');

                });
            }


            //END QR CODE SECTION
            if ($date == 1) {

                $dateFormat = DateFormat::find($date_format);
                $cerdate = date($dateFormat->format,strtotime($request->cert_created_at));
				$search = array('nd', 'th', 'rd', ',');
				$replace = array('', '', '', '');
				$img->text(strtoupper(str_replace($search, $replace, $cerdate)), (($width / 2)) + $date_position_x, (($height / 2) - 200) + $date_position_y, function ($font) use ($date_font_color, $date_font_size, $date_font_family) {
                    $font->size($date_font_size);
                    $font->file(public_path('fonts/' . $date_font_family . '.ttf'));
                    $font->color($date_font_color);
                    $font->align('center');
                    $font->valign('center');

                });

            }
//

            if (!empty($sig_image)) {
                $sigImageRow = Image::make(asset($sig_image));
                $sigImageRow->resize($signature_weight, $signature_height);
                $sigImg = Image::canvas($signature_weight, $signature_height);
                $sigImg->opacity(0);
                $sigImg->insert($sigImageRow, 'center', 0, 0);
                $img->insert($sigImg, 'top-left', $signature_position_x + 650, $signature_position_y + 750);

////            $img->insert($sigImg, 'center', $signature_position_x + 300, $signature_position_y + 200);
            }


            $img->text('', ($width / 2) + $signature_text_position_x, ($height - (round($height / 5))) + $signature_text_position_y, function ($font) use ($signature_text_font_size, $signature_text_font_color, $signature_text_font_family) {
                $font->size($signature_text_font_size);
                $font->file(public_path('fonts/' . $signature_text_font_family . '.ttf'));
                $font->color($signature_text_font_color);
                $font->align('center');
                $font->valign('bottom');

            });


            $img->text($signature_text, ($width / 2) + $signature_text_position_x, ($height - (round($height / 7) + $signature_text_position_y)), function ($font) use ($signature_text_font_size, $signature_text_font_color, $signature_text_font_family) {
                $font->size($signature_text_font_size);
                $font->file(public_path('fonts/' . $signature_text_font_family . '.ttf'));
                $font->color($signature_text_font_color);
                $font->align('center');
                $font->valign('bottom');

            });
            $data['image'] = $img;
            $data['height'] = $height;
            $data['width'] = $width;
            return $data;
        } catch (\Exception $e) {
            return null;
        }
    }
    /*History Certificate create code end*/
    public function download($id, Request $request)
    {
        try {
            $certificate_record = CertificateRecord::where('certificate_id', $id)->first();
            $course = Course::findOrFail($certificate_record->course_id);
            if ($course->certificate_id != null) {
                $certificate = Certificate::findOrFail($course->certificate_id);
            } else {
                if ($course->type == 1) {
                    $certificate = Certificate::where('for_course', 1)->first();
                } else {
                    $certificate = Certificate::where('for_quiz', 1)->first();
                }
            }
            if (!$certificate) {
                Toastr::error(trans('certificate.Right Now You Cannot Download The Certificate'));
                return back();
            }


            $title = $id . ".jpg";

            $downloadFile = new CertificateController();

            $request->certificate_id = $certificate_record->certificate_id;
            $request->cert_created_at = $certificate_record->created_at;
            $request->course = $course;
            $request->user = User::find($certificate_record->student_id);
            $certificate = $downloadFile->makeCertificate($certificate->id, $request)['image'] ?? '';
            $certificate->encode('png');
            $type = 'png';
            $certificate = 'data:image/' . $type . ';base64,' . base64_encode($certificate);

            if ($certificate == null) {
                Toastr::error('Invalid Certificate Number !', 'Failed');
                return redirect()->back();
            }
            //return view('myPDF',compact('certificate'));
            $pdf = PDF::loadView('myPDF', compact('certificate'));
            return $pdf->download($id.'.pdf');
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }

    }

    public function preview(Request $request)
    {
        try {
            $id = $request->id;
            $certificate = $this->makeCertificate($id, $request);
            $data['image'] = $certificate['image']->encode('data-url');
            $data['height'] = $certificate['height'];
            $data['width'] = $certificate['width'];
            return json_encode($data);
        }catch (\Exception $e){
            return  null;
        }
    }

    public function upload(Request $request)
    {
        if ($_FILES["file"]["name"] != '') {
            $test = explode('.', $_FILES["file"]["name"]);
            $ext = end($test);
            $name = md5(rand(100, 999999999999) . time()) . '.' . $ext;
            $location = public_path('uploads/certificate') . '/' . $name;
            $public_path = 'uploads/certificate/' . $name;
            $status = move_uploaded_file($_FILES["file"]["tmp_name"], $location);
            if ($status) {
                $data['type'] = 'Success';
                $data['location'] = $public_path;
            } else {
                $data['type'] = 'Error';
                $data['location'] = '';
            }


        } else {
            $data['type'] = 'Error';
            $data['location'] = '';
        }
        return json_encode($data);
    }
}
