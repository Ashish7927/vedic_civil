<?php

namespace App\Console\Commands;

use App\LessonComplete;
use App\Mail\SendMail;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Modules\CourseSetting\Entities\Course;
use Modules\CourseSetting\Entities\Lesson;

class sendReminderCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sendReminderEmail:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $students = User::query();

        $students->where("role_id","=","3");
        $students = $students->with("enrollCourse")->get();
        foreach ($students as $student) {
            if ($student->role_id === 3) {
                $courses = $student->enrollCourse->toArray();
                foreach ($courses as $course) {
                    if (round($this->userTotalPercentage($student->id, $course["id"])) != 100) {
                        $dataSendMail =
                            [
                                "name" => $student->name,
                                // "content" => url("/") . "/my-courses"
                                "content" => config('app.url') . "/my-courses"
                            ];
                        Mail::to($student->email)
                            ->send(new SendMail($dataSendMail));
                        break;
                    }
                }
            }
        }

        return 0;
    }

    private function userTotalPercentage($user_id, $course_id)
    {
        $complete_lesson = LessonComplete::where('user_id', $user_id)->where('course_id', $course_id)->where('status', 1)->get();
        $lesson = Lesson::where('course_id', $course_id)->get();
        $countCourse = count($complete_lesson);
        if ($countCourse != 0) {
            $percentage = ceil($countCourse / count($lesson) * 100);
        } else {
            $percentage = 0;
        }
        if ($percentage > 100) {
            $percentage = 100;
        }

        return $percentage;

    }
}
