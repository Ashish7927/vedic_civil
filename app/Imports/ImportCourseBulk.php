<?php

namespace App\Imports;

use App\Models\UserGroup;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Support\Collection;
use Modules\CourseSetting\Entities\Chapter;
use Modules\CourseSetting\Entities\Course;
use Modules\CourseSetting\Entities\Lesson;
use Modules\StudentSetting\Entities\StudentImportTemporary;
use Modules\CourseSetting\Http\Controllers\CourseSettingController;
use Modules\SCORM\Http\Controllers\SCORMController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use App\Traits\Filepond;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Http\UploadedFile;

class ImportCourseBulk implements WithStartRow, WithHeadingRow, ToModel, WithValidation
{
    use Filepond;

    public function startRow(): int
    {
        return 2;
    }

    public function headingRow(): int
    {
        return 1;
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function Model(array $rows)
    {
        $user_id = (Session::has('content_provider_id')) ? Session::get('content_provider_id') : Auth::id();
        $course_slug = Str::slug($rows['title'], '-');

        $course = new Course();

        $course->user_id = $user_id;

        if (isset($rows['category_ids'])) {
            $category_ids = explode(',', $rows['category_ids']);
            $categoryIds = implode(",", $category_ids);
            $categoryIds = "," . $categoryIds . ",";
            $course->category_ids = $categoryIds;
        }

        if (isset($rows['category'])) {
            $course->category_id = $rows['category'];
        }

        if (isset($rows['language'])) {
            $course->lang_id = $rows['language'];
        }

        if (isset($rows['scope'])) {
            $course->scope = $rows['scope'];
        }

        if (isset($rows['title'])) {
            $course->title = $rows['title'];
            $course->slug = $course_slug;
        }

        if (isset($rows['duration'])) {
            $course->duration = $rows['duration'];
        }

        if (isset($rows['meta_description'])) {
            $course->meta_description = $rows['meta_description'];
        }

        if ($rows['is_discount'] == 1) {
            if (isset($rows['discount_price'])) {
                $course->discount_price = $rows['discount_price'];
            }

            if (isset($rows['discount_start_date'])) {
                $course->discount_start_date = date('Y-m-d', strtotime($rows['discount_start_date']));
            }

            if (isset($rows['discount_end_date'])) {
                $course->discount_end_date = date('Y-m-d', strtotime($rows['discount_end_date']));
            }
        } else {
            $course->discount_price = null;
            $course->discount_start_date = null;
            $course->discount_end_date = null;
        }

        if ($rows['is_free'] == 1) {
            $course->price = 0;
            $course->discount_price = null;
            $course->discount_start_date = null;
            $course->discount_end_date = null;
        } else {
            if (isset($rows['price'])) {
                $course->price = $rows['price'];
            }
        }

        $course->publish = 1;
        $course->status = 0;

        if (isset($rows['level'])) {
            $course->level = $rows['level'];
        }

        if (isset($rows['mode_of_delivery'])) {
            $course->mode_of_delivery = $rows['mode_of_delivery'];
        }

        $course->show_overview_media = $rows['show_overview_media'] ? 1 : 0;

        if (isset($rows['host'])) {
            $course->host = $rows['host'];
        }

        if (isset($rows['subscription_list'])) {
            $course->subscription_list = $rows['subscription_list'];
        }

        $course->trailer_link = null;

        if (isset($rows['course_meta_keyword'])) {
            $course->meta_keywords = $rows['course_meta_keyword'];
        }

        if (isset($rows['course_description'])) {
            $course->about = $rows['course_description'];
        }

        if (isset($rows['requirements'])) {
            $course->requirements = $rows['requirements'];
        }

        if (isset($rows['outcomes'])) {
            $course->outcomes = $rows['outcomes'];
        }

        if (isset($rows['type'])) {
            $course->type = $rows['type'];
        }

        if (isset($rows['drip'])) {
            $course->drip = $rows['drip'];
        }

        if (isset($rows['complete_order'])) {
            $course->complete_order = $rows['complete_order'];
        }

        if (!empty($rows['course_type'])) {
            $course->course_type = $rows['course_type'];
        }
        if (!empty($rows['trainer'])) {
            $course->trainer = $rows['trainer'];
        }

        if (!empty($rows['declaration'])) {
            $course->declaration = 1; //Yes
        } else {
            $course->declaration = 0; //No
        }

        if (Settings('frontend_active_theme') == "edume") {
            if (!empty($rows['trainer'])) {
                $course->what_learn1 = $rows['what_learn1'];
            }
            if (!empty($rows['trainer'])) {
                $course->what_learn2 = $rows['what_learn2'];
            }
        }

        $course->detail_tab = 1;

        if (isset($rows['is_subscription'])) {
            $course->is_subscription = $rows['is_subscription'];
        }

        $info = pathinfo($rows['thumbnail_image']);

        $name = md5($rows['title'] . rand(0, 1000)) . '.' . 'png';
        $img = Image::make(file_get_contents($rows['thumbnail_image']));
        $upload_path = 'uploads/courses/';
        $img->save($upload_path . $name);
        $course->image = $upload_path . $name;

        $name = md5($rows['title'] . rand(0, 1000)) . '.' . 'png';
        $img = Image::make(file_get_contents($rows['thumbnail_image']));
        $upload_path = 'uploads/courses/';
        $img->save($upload_path . $name);
        $course->thumbnail = $upload_path . $name;

        $course->save();

        $chpter_no = Chapter::where('course_id', $course->id)->count();

        if (isset($rows['chapter_name'])) {
            $rows['chapter_name'] = explode(',', $rows['chapter_name']);

            foreach ($rows['chapter_name'] as $key => $chapterName) {
                $chapter = new Chapter();

                $chapter->name = $chapterName;
                $chapter->course_id = $course->id;
                $chapter->chapter_no = $chpter_no + 1;
                $chapter->save();

                $data = [];

                if (isset($rows['lesson_name']) && is_string($rows['lesson_name'])) {
                    $rows['lesson_name'] = explode(',', $rows['lesson_name']);
                    $lessonNames = explode(";", $rows['lesson_name'][$key]);

                    foreach ($lessonNames as $key1 => $one) {
                        $data[$key1] = [
                            'lesson_name' => $one
                        ];
                    }
                } else {
                    $lessonNames = explode(";", $rows['lesson_name'][$key]);

                    foreach ($lessonNames as $key1 => $one) {
                        $data[$key1] = [
                            'lesson_name' => $one
                        ];
                    }
                }

                if (isset($rows['lesson_description']) && is_string($rows['lesson_description'])) {
                    $rows['lesson_description'] = explode(',', $rows['lesson_description']);
                    $lessonDesc = explode(";", $rows['lesson_description'][$key]);

                    foreach ($lessonDesc as $key2 => $one) {
                        $data[$key2] += [
                            'lesson_description' => $one
                        ];
                    }
                } else {
                    $lessonDesc = explode(";", $rows['lesson_description'][$key]);

                    foreach ($lessonDesc as $key2 => $one) {
                        $data[$key2] += [
                            'lesson_description' => $one
                        ];
                    }
                }

                if (isset($rows['lesson_host']) && is_string($rows['lesson_host'])) {
                    $rows['lesson_host'] = explode(',', $rows['lesson_host']);
                    $lessonHost = explode(";", $rows['lesson_host'][$key]);

                    foreach ($lessonHost as $key2 => $one) {
                        $data[$key2] += [
                            'lesson_host' => $one
                        ];
                    }
                } else {
                    $lessonHost = explode(";", $rows['lesson_host'][$key]);

                    foreach ($lessonHost as $key2 => $one) {
                        $data[$key2] += [
                            'lesson_host' => $one
                        ];
                    }
                }

                if (isset($rows['lesson_duration']) && is_string($rows['lesson_duration'])) {
                    $rows['lesson_duration'] = explode(',', $rows['lesson_duration']);
                    $lessonDuration = explode(";", $rows['lesson_duration'][$key]);

                    foreach ($lessonDuration as $key2 => $one) {
                        $data[$key2] += [
                            'lesson_duration' => $one
                        ];
                    }
                } else {
                    if (is_array($rows['lesson_duration'])) {
                        $lessonDuration = explode(";", $rows['lesson_duration'][$key]);
                    } else {
                        $lessonDuration = explode(";", $rows['lesson_duration']);
                    }

                    foreach ($lessonDuration as $key2 => $one) {
                        $data[$key2] += [
                            'lesson_duration' => $one
                        ];
                    }
                }

                if (isset($rows['lesson_is_lock']) && is_string($rows['lesson_is_lock'])) {
                    $rows['lesson_is_lock'] = explode(',', $rows['lesson_is_lock']);
                    $lessonIsLock = explode(";", $rows['lesson_is_lock'][$key]);

                    foreach ($lessonIsLock as $key2 => $one) {
                        $data[$key2] += [
                            'lesson_is_lock' => $one
                        ];
                    }
                } else {
                    if (is_array($rows['lesson_is_lock'])) {
                        $lessonIsLock = explode(";", $rows['lesson_is_lock'][$key]);
                    } else {
                        $lessonIsLock = explode(";", $rows['lesson_is_lock']);
                    }

                    foreach ($lessonIsLock as $key2 => $one) {
                        $data[$key2] += [
                            'lesson_is_lock' => $one
                        ];
                    }
                }

                if (isset($rows['lesson_url']) && is_string($rows['lesson_url'])) {
                    $rows['lesson_url'] = explode(',', $rows['lesson_url']);
                    $lessonIsUrl = explode(";", $rows['lesson_url'][$key]);

                    foreach ($lessonIsUrl as $key2 => $one) {
                        $data[$key2] += [
                            'lesson_url' => $one
                        ];
                    }
                } else {
                    $lessonIsUrl = explode(";", $rows['lesson_url'][$key]);

                    foreach ($lessonIsUrl as $key2 => $one) {
                        $data[$key2] += [
                            'lesson_url' => $one
                        ];
                    }
                }

                if (isset($chapter)) {
                    foreach ($data as $one) {
                        $lesson = new Lesson();

                        $lesson->course_id = $course->id;
                        $lesson->chapter_id = $chapter->id;
                        $lesson->name = $one['lesson_name'];
                        $lesson->description = $one['lesson_description'];
                        $lesson->host = $one['lesson_host'];
                        $lesson->duration = $one['lesson_duration'];
                        $lesson->is_lock = $one['lesson_is_lock'];
                        $lesson->video_url = "";

                        if ($one['lesson_host'] == 'Iframe' || $one['lesson_host'] == 'URL') {
                            $lesson->video_url = $one['lesson_url'];
                        } elseif ($one['lesson_host'] == 'Vimeo') {
                            if (config('vimeo.connections.main.upload_type') == "Direct") {
                                $courseSettingController = new CourseSettingController();
                                $lesson->video_url = $courseSettingController->uploadFileIntoVimeo($one['lesson_name'], $one['lesson_url']);
                            } else {
                                $lesson->video_url = $one['lesson_url'];
                            }
                        } elseif ($one['lesson_host'] == 'SCORM') {
                            $file_name = time().".zip";
                            Storage::disk('local')->put($file_name, file_get_contents($one['lesson_url']));
                            $storagePath = Storage::path($file_name);
                            $scorm = new SCORMController();
                            $url = $scorm->getScormUrl($storagePath, $one['lesson_host'], 'other');
                            $lesson->video_url = $url;
                        }

                        $lesson->save();
                    }
                }
            }
        }

        $course->curriculum_tab = 1;
        $course->save();

        return $course;
    }

    public function rules(): array
    {
        return [
            'title' => 'required',
            'course_type' => 'required',
            'trainer' => 'required',
            'requirements' => 'required',
            'course_description' => 'required',
            // 'meta_description' => 'required',
            'outcomes' => 'required',
            'category' => 'required',
            // 'category_ids' => 'required',
            'level' => 'required',
            'language' => 'required',
            'duration' => 'required',
            'complete_order' => 'required',
            'is_free' => 'required',
            'price' => 'required',
            'is_discount' => 'required',
            'discount_price' => 'required',
            // 'discount_start_date' => 'required',
            // 'discount_end_date' => 'required',
            'show_overview_media' => 'required',
            'mode_of_delivery' => 'required',
            // 'course_meta_keyword' => 'required',
            'chapter_name' => 'required',
            'lesson_name' => 'required',
            'lesson_description' => 'required',
            'lesson_host' => 'required',
            'lesson_host' => function($attribute, $value, $onFailure) {
                $exp_lesson_hostss_1 = explode(',', $value);
                $valid_arr = ['Iframe', 'URL', 'Vimeo', 'SCORM'];

                foreach ($exp_lesson_hostss_1 as $key_1 => $lesson_hosts_1) {
                    $exp_lesson_hostss_2 = explode(';', $lesson_hosts_1);

                    foreach ($exp_lesson_hostss_2 as $key_2 => $lesson_hosts_2) {
                        if (!in_array($lesson_hosts_2, $valid_arr)) {
                            $onFailure('The lesson host must be Iframe or URL or Vimeo or SCORM.');
                        }
                    }
                }
            },
            'lesson_duration' => 'required',
            'lesson_is_lock' => 'required',
            'lesson_url' => 'required',
            'is_subscription' => 'required',
            'thumbnail_image' => 'required',
        ];
    }

    public function customValidationMessages() {
        return [
            'title.required' => 'The title filed is required.',
            'course_type.required' => 'The course type filed is required.',
            'trainer.required' => 'The trainer filed is required.',
            'requirements.required' => 'The requirements filed is required.',
            'course_description.required' => 'The course description filed is required.',
            // 'meta_description.required' => 'The meta description filed is required.',
            'outcomes.required' => 'The outcomes filed is required.',
            'category.required' => 'The category filed is required.',
            // 'category_ids.required' => 'The category ids filed is required.',
            'level.required' => 'The level filed is required.',
            'language.required' => 'The language filed is required.',
            'duration.required' => 'The duration filed is required.',
            'complete_order.required' => 'The complete order filed is required.',
            'is_free.required' => 'The is free filed is required.',
            'price.required' => 'The price filed is required.',
            'is_discount.required' => 'The is discount filed is required.',
            'discount_price.required' => 'The discount price filed is required.',
            // 'discount_start_date.required' => 'The discount start date filed is required.',
            // 'discount_end_date.required' => 'The discount end date filed is required.',
            'show_overview_media.required' => 'The show overview media filed is required.',
            'mode_of_delivery.required' => 'The mode of delivery filed is required.',
            // 'course_meta_keyword.required' => 'The course meta keyword filed is required.',
            'chapter_name.required' => 'The chapter name filed is required.',
            'lesson_name.required' => 'The lesson name filed is required.',
            'lesson_description.required' => 'The lesson description filed is required.',
            'lesson_host.required' => 'The lesson host filed is required.',
            'lesson_duration.required' => 'The lesson duration filed is required.',
            'lesson_is_lock.required' => 'The lesson is lock filed is required.',
            'lesson_url.required' => 'The lesson url filed is required.',
            'is_subscription.required' => 'The is subscription filed is required.',
            'thumbnail_image.required' => 'The thumbnail image filed is required.',
        ];
    }
}
