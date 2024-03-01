<?php

namespace Modules\Quiz\Http\Controllers;

use App\Exports\ExportCategory;
use App\Exports\ExportQuestionGroup;
use App\Exports\ExportSampleQuestionBank;
use App\Exports\ExportSubCategory;
use App\Http\Controllers\Controller;
use App\Imports\QuestionBankImport;
use App\Traits\ImageStore;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use Modules\CourseSetting\Entities\Category;
use Modules\Quiz\Entities\QuestionBank;
use Modules\Quiz\Entities\QuestionGroup;
use Modules\Quiz\Entities\QuestionLevel;
use Yajra\DataTables\Facades\DataTables;
use Modules\Quiz\Entities\QuestionBankMuOption;
use Modules\Quiz\Entities\OnlineExamQuestionAssign;

class QuestionBankController extends Controller
{
    use ImageStore;

    public function form()
    {
        try {
            $user = Auth::user();
            if ($user->role_id == 1) {
                $groups = QuestionGroup::where('active_status', 1)->latest()->get();
            } else {
                $groups = QuestionGroup::where('active_status', 1)->where('user_id', $user->id)->latest()->get();
            }
            $categories = Category::where('status',1)->get();

            return view('quiz::question_bank', compact('groups', 'categories'));
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function index(Request $request)
    {
        try {
            if ($request->group) {
                $group = $request->group;
            } else {
                $group = '';
            }
            $user = Auth::user();
            if ($user->role_id == 1) {
                $groups = QuestionGroup::where('active_status', 1)->latest()->get();
            } else {
                $groups = QuestionGroup::where('active_status', 1)->where('user_id', $user->id)->latest()->get();
            }

            return view('quiz::question_bank_list', compact('group', 'groups'));
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function CourseQuetionShow($id)
    {
        try {
            $levels = QuestionLevel::get();
            $groups = QuestionGroup::get();
            $banks = [];
            $bank = QuestionBank::with('category', 'subCategory', 'questionGroup')->find($id);
            $categories = Category::get();

            //return $bank;
            return view('quiz::question_bank', compact('levels', 'groups', 'banks', 'bank', 'categories'));
        } catch (\Exception $e) {
            Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
            return redirect()->back();
        }
    }

    public function store(Request $request)
    {
        // dd($request->question_type);
        $user = Auth::user();
        if (demoCheck()) {
            return redirect()->back();
        }

        if ($request->question_type == "") {
            $rules = [
                'group' => "required",
                'category' => "required",
                'question' => "required",
                'question_type' => "required",
                'marks' => "required"
            ];
            $this->validate($request, $rules, validationMessage($rules));
        } elseif ($request->question_type == "M") {
            $rules = [
                'group' => "required",
                'category' => "required",
                'question' => "required",
                'question_type' => "required",
                'marks' => "required",
                'number_of_option' => "required"
            ];

            $message = [
                'group.required' => 'The Group field is required.',
                'category.required' => 'The Category field is required.',
                'question.required' => 'The Question field is required.',
                'question_type.required' => 'The Question Type field is required.',
                'marks.required' => 'The Marks field is required.',
                'number_of_option.required' => 'The Number of option field is required.',
            ];

            $option_check_arr = [];
            if (isset($request->option)) {
                foreach ($request->option as $i => $option) {
                    $i++;
                    $option_check_data = 'option_check_' . $i;
                    if (isset($request->$option_check_data)) {
                        array_push($option_check_arr, $i);
                    }
                }
            }
            if (count($option_check_arr) == 0) {
                $rules['option_check_'] = "required";
            }

            $message['option_check_.required'] = 'Please tick at the correct answer.';
            $this->validate($request, $rules, $message);
            // $this->validate($request, $rules, validationMessage($rules));

        } elseif ($request->question_type == "S") {
            $rules = [
                'group' => "required",
                'category' => "required",
                'question' => "required",
                'question_type' => "required",
                // 'marks' => "required",
            ];
            $this->validate($request, $rules, validationMessage($rules));
        } elseif ($request->question_type == "L") {
            $rules = [
                'group' => "required",
                'category' => "required",
                'question' => "required",
                'question_type' => "required",
                'marks' => "required",
            ];
            $this->validate($request, $rules, validationMessage($rules));
        } elseif ($request->question_type == "F") {
            $rules = [
                'group' => "required",
                'category' => "required",
                'question' => "required",
                'marks' => "required",
                'question_type' => "required",
                'option_check_fill' => "required",
                'number_of_option_fill' => "required",
            ];

            $message = [
                'group.required' => 'The Group field is required.',
                'category.required' => 'The Category field is required.',
                'question.required' => 'The Question field is required.',
                'marks.required' => 'The Marks field is required.',
                'question_type.required' => 'The Question Type field is required.',
                'option_check_fill.required' => 'Tick the correct answer.',
                'number_of_option_fill.required' => 'The Number of option field is required.',
            ];

            $this->validate($request, $rules, $message);
        } elseif ($request->question_type == "Mt") {
            $rules = [
                'group' => "required",
                'category' => "required",
                'question' => "required",
                'question_type' => "required",
                'marks' => "required",
                'number_of_option_for_matching' => "required"
            ];
            $this->validate($request, $rules, validationMessage($rules));
        }
        try {
            if ($request->question_type == 'S' || $request->question_type == 'L' || $request->question_type == "") {
                $online_question = new QuestionBank();
                $online_question->type = $request->question_type;
                $online_question->q_group_id = $request->group;
                $online_question->category_id = $request->category;
                $online_question->sub_category_id = $request->sub_category;
                $online_question->marks = $request->marks;
                $online_question->question = $request->question;
                $online_question->user_id = $user->id;
                $online_question->question_feedback = $request->question_feedback;
                $online_question->enable_question_feedback = $request->enable_question_feedback;
                $result = $online_question->save();
                if (!$result) {
                    Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
                    return redirect()->back();
                }
            } elseif ($request->question_type == "F") {
                $online_question = new QuestionBank();
                $online_question->type = $request->question_type;
                $online_question->q_group_id = $request->group;
                $online_question->category_id = $request->category;
                $online_question->sub_category_id = $request->sub_category;
                $online_question->marks = $request->marks;
                $online_question->question = $request->question;
                $online_question->number_of_option = $request->number_of_option_fill;
                $online_question->user_id = $user->id;
                $online_question->question_feedback = $request->question_feedback;
                $online_question->enable_question_feedback = $request->enable_question_feedback;

                $online_question->save();
                $online_question->toArray();
                $i = 0;
                if (isset($request->option_fill)) {
                    foreach ($request->option_fill as $key => $option) {
                        $i++;
                        $online_question_option = new QuestionBankMuOption();
                        $online_question_option->question_bank_id = $online_question->id;
                        $online_question_option->title = $option;
                        if ($key == $request->option_check_fill) {
                            $online_question_option->status = 1;
                        } else {
                            $online_question_option->status = 0;
                        }
                        $online_question_option->save();
                    }
                }
                $assign = new OnlineExamQuestionAssign();
                $assign->online_exam_id = $request->quize_id;
                $assign->question_bank_id = $online_question->id;
                $assign->save();
            } elseif ($request->question_type == "Mt") {
                $online_question = new QuestionBank();
                $online_question->type = $request->question_type;
                $online_question->q_group_id = $request->group;
                $online_question->category_id = $request->category;
                $online_question->sub_category_id = $request->sub_category;
                $online_question->marks = $request->marks;
                $online_question->question = $request->question;
                $online_question->number_of_option = $request->number_of_option_for_matching;
                $online_question->user_id = $user->id;
                $online_question->question_feedback = $request->question_feedback;
                $online_question->enable_question_feedback = $request->enable_question_feedback;

                $online_question->save();
                $online_question->toArray();
                $i = 0;
                $ans_ids = [];
                if (isset($request->matching_ans_opts)) {
                    foreach ($request->matching_ans_opts as $key => $option) {
                        $i++;
                        $online_question_option = new QuestionBankMuOption();
                        $online_question_option->question_bank_id = $online_question->id;
                        $online_question_option->title = $option;
                        $online_question_option->match_type = 2; //answer
                        $online_question_option->save();

                        $ans_ids[$key] = $online_question_option->id;
                    }
                }
                if (isset($request->matching_que_opts)) {
                    foreach ($request->matching_que_opts as $key => $option) {
                        $i++;
                        $online_question_option = new QuestionBankMuOption();
                        $online_question_option->question_bank_id = $online_question->id;
                        $online_question_option->title = $option;
                        $online_question_option->match_type = 1; //question
                        $online_question_option->match_ans_id = $ans_ids[$key];
                        $online_question_option->save();
                    }
                }
                $assign = new OnlineExamQuestionAssign();
                $assign->online_exam_id = $request->quize_id;
                $assign->question_bank_id = $online_question->id;
                $assign->save();
            } else {

                DB::beginTransaction();

                try {
                    $online_question = new QuestionBank();
                    $online_question->type = $request->question_type;
                    $online_question->q_group_id = $request->group;
                    $online_question->category_id = $request->category;
                    $online_question->sub_category_id = $request->sub_category;
                    $online_question->marks = $request->marks;
                    $online_question->question = $request->question;
                    $online_question->number_of_option = $request->number_of_option;
                    $online_question->user_id = $user->id;
                    $online_question->question_feedback = $request->question_feedback;
                    $online_question->enable_question_feedback = $request->enable_question_feedback;

                    $online_question->save();
                    $online_question->toArray();
                    $i = 0;
                    if (isset($request->option)) {
                        foreach ($request->option as $option) {
                            $i++;
                            $option_check = 'option_check_' . $i;
                            $online_question_option = new QuestionBankMuOption();
                            $online_question_option->question_bank_id = $online_question->id;
                            $online_question_option->title = $option;
                            if (isset($request->$option_check)) {
                                $online_question_option->status = 1;
                            } else {
                                $online_question_option->status = 0;
                            }
                            $online_question_option->save();
                        }
                    }
                    $assign = new OnlineExamQuestionAssign();
                    $assign->online_exam_id = $request->quize_id;
                    $assign->question_bank_id = $online_question->id;
                    $assign->save();

                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollBack();
                }
            }

            if ($request->hasFile('image')) {
                $online_question->image = $this->saveImage($request->image);
            } else {
                $online_question->image = null;
            }
            $online_question->save();


            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect(route('question-bank-list'));
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function updateCourse(Request $request, $id)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        if ($request->question_type == "") {
            $rules = [
                // 'group' => "required",
                'category' => "required",
                'question' => "required",
                'question_type' => "required",
                'marks' => "required"
            ];

            $this->validate($request, $rules, validationMessage($rules));
        } elseif ($request->question_type == "M") {
            $rules = [
                // 'group' => "required",
                'category' => "required",
                'question' => "required",
                'question_type' => "required",
                'marks' => "required",
                'number_of_option' => "required"
            ];
            $this->validate($request, $rules, validationMessage($rules));
        } elseif ($request->question_type == "F") {
            $rules = [
                // 'group' => "required",
                'category' => "required",
                'question' => "required",
                'question_type' => "required",
                'marks' => "required",
                'suitable_words' => "required"
            ];
            $this->validate($request, $rules, validationMessage($rules));
        }
        try {
            if ($request->question_type != 'M') {
                $online_question = QuestionBank::find($id);
                $online_question->type = $request->question_type;
                // $online_question->q_group_id = $request->group;
                $online_question->category_id = $request->category;
                $online_question->sub_category_id = $request->sub_category;
                $online_question->marks = $request->marks;
                $online_question->question = $request->question;
                $online_question->question_feedback = $request->question_feedback;
                $online_question->enable_question_feedback = $request->enable_question_feedback;
                if ($request->question_type == "F") {
                    $online_question->suitable_words = $request->suitable_words;
                } elseif ($request->question_type == "T") {
                    $online_question->trueFalse = $request->trueOrFalse;
                }
                $result = $online_question->save();
                if ($result) {
                    Toastr::success(trans('common.Operation successful'), trans('common.Success'));
                    return redirect()->back();
                } else {
                    Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
                    return redirect()->back();
                }
            } else {
                DB::beginTransaction();
                try {
                    $online_question = QuestionBank::find($id);
                    $online_question->type = $request->question_type;
                    // $online_question->q_group_id = $request->group;
                    $online_question->category_id = $request->category;
                    $online_question->sub_category_id = $request->sub_category;
                    $online_question->marks = $request->marks;
                    $online_question->question = $request->question;
                    $online_question->number_of_option = $request->number_of_option;
                    $online_question->question_feedback = $request->question_feedback;
                    $online_question->enable_question_feedback = $request->enable_question_feedback;
                    $online_question->save();
                    $online_question->toArray();
                    $i = 0;
                    if (isset($request->option)) {
                        QuestionBankMuOption::where('question_bank_id', $online_question->id)->delete();
                        foreach ($request->option as $option) {
                            $i++;
                            $option_check = 'option_check_' . $i;
                            $online_question_option = new QuestionBankMuOption();
                            $online_question_option->question_bank_id = $online_question->id;
                            $online_question_option->title = $option;
                            if (isset($request->$option_check)) {
                                $online_question_option->status = 1;
                            } else {
                                $online_question_option->status = 0;
                            }
                            $online_question_option->save();
                        }
                    }
                    DB::commit();
                    Toastr::success(trans('common.Operation successful'), trans('common.Success'));
                    return redirect()->back();
                } catch (\Exception $e) {
                    DB::rollBack();
                }
                Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
                return redirect()->back();
            }
        } catch (\Exception $e) {
            // dd($e);
            Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $levels = QuestionLevel::get();
            $groups = QuestionGroup::get();
            $banks = [];
            $bank = QuestionBank::with('category', 'subCategory', 'questionGroup')->find($id);
            $categories = Category::where('status',1)->get();

            return view('quiz::question_bank', compact('levels', 'groups', 'banks', 'bank', 'categories'));
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    public function storeCourse(Request $request)
    {
        $user = Auth::user();
        if (demoCheck()) {
            return redirect()->back();
        }
        // return $request;
        if ($request->question_type == "") {
            $rules = [
                // 'group' => "required",
                'category' => "required",
                'question' => "required",
                'question_type' => "required",
                'marks' => "required"
            ];
            $this->validate($request, $rules, validationMessage($rules));
        } elseif ($request->question_type == "M") {
            $rules = [
                // 'group' => "required",
                'category' => "required",
                'question' => "required",
                'question_type' => "required",
                'marks' => "required",
                'number_of_option' => "required"
            ];
            $this->validate($request, $rules, validationMessage($rules));
        } elseif ($request->question_type == "F") {
            $rules = [
                // 'group' => "required",
                'category' => "required",
                'question' => "required",
                'question_type' => "required",
                'marks' => "required",
                'suitable_words' => "required"
            ];
            $this->validate($request, $rules, validationMessage($rules));
        }
        try {
            if ($request->question_type != 'M') {
                $online_question = new QuestionBank();
                $online_question->type = $request->question_type;
                // $online_question->q_group_id = $request->group;
                $online_question->category_id = $request->category;
                $online_question->sub_category_id = $request->sub_category;
                $online_question->marks = $request->marks;
                $online_question->question = $request->question;
                $online_question->user_id = $user->id;
                $online_question->question_feedback = $request->question_feedback;
                $online_question->enable_question_feedback = $request->enable_question_feedback;
                if ($request->question_type == "F") {
                    $online_question->suitable_words = $request->suitable_words;
                } elseif ($request->question_type == "T") {
                    $online_question->trueFalse = $request->trueOrFalse;
                }
                $result = $online_question->save();
                if ($result) {
                    Toastr::success(trans('common.Operation successful'), trans('common.Success'));
                    return redirect()->back();
                } else {
                    Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
                    return redirect()->back();
                }
            } else {

                DB::beginTransaction();

                try {
                    $online_question = new QuestionBank();
                    $online_question->type = $request->question_type;
                    // $online_question->q_group_id = $request->group;
                    $online_question->category_id = $request->category;
                    $online_question->sub_category_id = $request->sub_category;
                    $online_question->marks = $request->marks;
                    $online_question->question = $request->question;
                    $online_question->number_of_option = $request->number_of_option;
                    $online_question->user_id = $user->id;
                    $online_question->question_feedback = $request->question_feedback;
                    $online_question->enable_question_feedback = $request->has('enable_question_feedback') ? $request->enable_question_feedback : 0;
                    $online_question->save();
                    $online_question->toArray();
                    $i = 0;
                    if (isset($request->option)) {
                        foreach ($request->option as $option) {
                            $i++;
                            $option_check = 'option_check_' . $i;
                            $online_question_option = new QuestionBankMuOption();
                            $online_question_option->question_bank_id = $online_question->id;
                            $online_question_option->title = $option;
                            if (isset($request->$option_check)) {
                                $online_question_option->status = 1;
                            } else {
                                $online_question_option->status = 0;
                            }
                            $online_question_option->save();
                        }
                    }
                    $assign = new OnlineExamQuestionAssign();
                    $assign->online_exam_id = $request->quize_id;
                    $assign->question_bank_id = $online_question->id;
                    $assign->save();

                    DB::commit();
                    Toastr::success(trans('common.Operation successful'), trans('common.Success'));
                    return redirect()->back();
                } catch (\Exception $e) {
                    // dd($e);
                    DB::rollBack();
                }
                Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
                return redirect()->back();
            }
        } catch (\Exception $e) {
            // dd($e);
            Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        if (demoCheck()) {
            return redirect()->back();
        }
        if ($request->question_type == "") {
            $rules = [
                'group' => "required",
                'category' => "required",
                'question' => "required",
                'question_type' => "required",
                'marks' => "required"
            ];

            $this->validate($request, $rules, validationMessage($rules));
        } elseif ($request->question_type == "M") {
            $rules = [
                'group' => "required",
                'category' => "required",
                'question' => "required",
                'question_type' => "required",
                'marks' => "required",
                'number_of_option' => "required"
            ];

            $message = [
                'group.required' => 'The Group field is required.',
                'category.required' => 'The Category field is required.',
                'question.required' => 'The Question field is required.',
                'question_type.required' => 'The Question Type field is required.',
                'marks.required' => 'The Marks field is required.',
                'number_of_option.required' => 'The Number of option field is required.',
            ];

            $option_check_arr = [];
            if (isset($request->option)) {
                foreach ($request->option as $i => $option) {
                    $i++;
                    $option_check_data = 'option_check_' . $i;
                    if (isset($request->$option_check_data)) {

                        array_push($option_check_arr, $i);
                    }
                }
            }
            if (count($option_check_arr) == 0) {
                $rules['option_check_'] = "required";
                $message['option_check_.required'] = 'Please tick at the correct answer.';
            }

            $this->validate($request, $rules, $message);
            // $this->validate($request, $rules, validationMessage($rules));

        } elseif ($request->question_type == "S") {
            $rules = [
                'group' => "required",
                'category' => "required",
                'question' => "required",
                'question_type' => "required",
                // 'marks' => "required",
            ];
        } elseif ($request->question_type == "L") {
            $rules = [
                'group' => "required",
                'category' => "required",
                'question' => "required",
                'question_type' => "required",
                'marks' => "required",
            ];
            $this->validate($request, $rules, validationMessage($rules));
        } elseif ($request->question_type == "F") {
            $rules = [
                'group' => "required",
                'category' => "required",
                'question' => "required",
                'marks' => "required",
                'question_type' => "required",
                'option_check_fill' => "required",
                'number_of_option_fill' => "required",
            ];

            $message = [
                'group.required' => 'The Group field is required.',
                'category.required' => 'The Category field is required.',
                'question.required' => 'The Question field is required.',
                'marks.required' => 'The Marks field is required.',
                'question_type.required' => 'The Question Type field is required.',
                'option_check_fill.required' => 'Tick the correct answer.',
                'number_of_option_fill.required' => 'The Number of option field is required.',
            ];

            $this->validate($request, $rules, $message);
        } elseif ($request->question_type == "Mt") {
            $rules = [
                'group' => "required",
                'category' => "required",
                'question' => "required",
                'question_type' => "required",
                'marks' => "required",
                'number_of_option_for_matching' => "required"
            ];
            $this->validate($request, $rules, validationMessage($rules));
        }
        try {
            if ($request->question_type == 'S' || $request->question_type == 'L' || $request->question_type == "") {
                $online_question = QuestionBank::find($id);
                $online_question->type = $request->question_type;
                $online_question->q_group_id = $request->group;
                $online_question->category_id = $request->category;
                $online_question->sub_category_id = $request->sub_category;
                $online_question->marks = $request->marks;
                $online_question->question = $request->question;
                $online_question->question_feedback = $request->question_feedback;
                $online_question->enable_question_feedback = $request->enable_question_feedback;

                $result = $online_question->save();
                if (!$result) {
                    Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
                    return redirect()->back();
                }
            } elseif ($request->question_type == "F") {
                $online_question = QuestionBank::find($id);
                $online_question->type = $request->question_type;
                $online_question->q_group_id = $request->group;
                $online_question->category_id = $request->category;
                $online_question->sub_category_id = $request->sub_category;
                $online_question->marks = $request->marks;
                $online_question->question = $request->question;
                $online_question->number_of_option = $request->number_of_option_fill;
                $online_question->question_feedback = $request->question_feedback;
                $online_question->enable_question_feedback = $request->enable_question_feedback;
                $online_question->save();
                $online_question->toArray();
                $i = 0;
                if (isset($request->option_fill)) {
                    QuestionBankMuOption::where('question_bank_id', $online_question->id)->delete();
                    foreach ($request->option_fill as $key => $option) {
                        $i++;
                        $online_question_option = new QuestionBankMuOption();
                        $online_question_option->question_bank_id = $online_question->id;
                        $online_question_option->title = $option;
                        if ($key == $request->option_check_fill) {
                            $online_question_option->status = 1;
                        } else {
                            $online_question_option->status = 0;
                        }
                        $online_question_option->save();
                    }
                }
            } elseif ($request->question_type == "Mt") {
                $online_question = QuestionBank::find($id);
                $online_question->type = $request->question_type;
                $online_question->q_group_id = $request->group;
                $online_question->category_id = $request->category;
                $online_question->sub_category_id = $request->sub_category;
                $online_question->marks = $request->marks;
                $online_question->question = $request->question;
                $online_question->number_of_option = $request->number_of_option_for_matching;
                $online_question->question_feedback = $request->question_feedback;
                $online_question->enable_question_feedback = $request->enable_question_feedback;
                $online_question->save();
                $online_question->toArray();
                $i = 0;
                $ans_ids = [];
                if (isset($request->matching_ans_opts)) {
                    QuestionBankMuOption::where('question_bank_id', $online_question->id)->where('match_type', 2)->delete();
                    foreach ($request->matching_ans_opts as $key => $option) {
                        $i++;
                        $online_question_option = new QuestionBankMuOption();
                        $online_question_option->question_bank_id = $online_question->id;
                        $online_question_option->title = $option;
                        $online_question_option->match_type = 2; //answer
                        $online_question_option->save();

                        $ans_ids[$key] = $online_question_option->id;
                    }
                }
                if (isset($request->matching_que_opts)) {
                    QuestionBankMuOption::where('question_bank_id', $online_question->id)->where('match_type', 1)->delete();
                    foreach ($request->matching_que_opts as $key => $option) {
                        $i++;
                        $online_question_option = new QuestionBankMuOption();
                        $online_question_option->question_bank_id = $online_question->id;
                        $online_question_option->title = $option;
                        $online_question_option->match_type = 1; //question
                        $online_question_option->match_ans_id = $ans_ids[$key];
                        $online_question_option->save();
                    }
                }
            } else {
                DB::beginTransaction();
                try {
                    $online_question = QuestionBank::find($id);
                    $online_question->type = $request->question_type;
                    $online_question->q_group_id = $request->group;
                    $online_question->category_id = $request->category;
                    $online_question->sub_category_id = $request->sub_category;
                    $online_question->marks = $request->marks;
                    $online_question->question = $request->question;
                    $online_question->number_of_option = $request->number_of_option;
                    $online_question->question_feedback = $request->question_feedback;
                    $online_question->enable_question_feedback = $request->enable_question_feedback;
                    $online_question->save();
                    $online_question->toArray();
                    $i = 0;
                    if (isset($request->option)) {
                        QuestionBankMuOption::where('question_bank_id', $online_question->id)->delete();
                        foreach ($request->option as $option) {
                            $i++;
                            $option_check = 'option_check_' . $i;
                            $online_question_option = new QuestionBankMuOption();
                            $online_question_option->question_bank_id = $online_question->id;
                            $online_question_option->title = $option;
                            if (isset($request->$option_check)) {
                                $online_question_option->status = 1;
                            } else {
                                $online_question_option->status = 0;
                            }
                            $online_question_option->save();
                        }
                    }
                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollBack();
                }
            }

            if ($request->hasFile('image')) {
                $online_question->image = $this->saveImage($request->image);
            }
            $online_question->save();
            $online_question->save();
            Toastr::success(trans('common.Operation successful'), trans('common.Success'));
            return redirect('quiz/question-bank-list');
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }


    public function destroy(Request $request)
    {

        if (demoCheck()) {
            return redirect()->back();
        }

        try {
            $id = $request->id;

            $online_question = QuestionBank::findOrFail($id);

            if ($online_question->type == "M") {
                QuestionBankMuOption::where('question_bank_id', $online_question->id)->delete();
            }

            $result = $online_question->delete();

            if ($result) {
                Toastr::success(trans('common.Operation successful'), trans('common.Success'));
                return redirect()->to(route('question-bank-list'));
            } else {
                Toastr::error(trans('common.Operation failed'), trans('common.Failed'));
                return redirect()->back();
            }
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function getAllQuizData(Request $request)
    {
        $user = Auth::user();


        if ($user->role_id == 1) {
            $queries = QuestionBank::latest()->select('question_banks.*')->where('question_banks.active_status', 1)->with('category', 'subCategory', 'questionGroup');
        } else {
            $queries = QuestionBank::latest()->select('question_banks.*')->where('question_banks.active_status', 1)->with('category', 'subCategory', 'questionGroup')->where('question_banks.user_id', $user->id);
        }
        if ($request->group) {
            $queries->where('q_group_id', $request->group);
        }
        return Datatables::of($queries)
            ->addIndexColumn()
            ->addColumn('delete_btn', function ($query) {
                $btn = '<label class="primary_checkbox d-flex  " for="question' . $query->id . '">
                                                    <input type="checkbox" name="questions[]"
                                                          id="question' . $query->id . '"   value="' . $query->id . '"
                                                           class="common-checkbox question">
                                                    <span class="checkmark"></span>
                                                </label>';



                return $btn;
            })->editColumn('questionGroup_title', function ($query) {
                return $query->questionGroup->title;
            })->editColumn('category_name', function ($query) {
                return $query->category->name;
            })->editColumn('question', function ($query) {
                return $query->question;
            })->editColumn('question_feedback', function ($query) {
                return $query->question_feedback;
            })->editColumn('enable_question_feedback', function ($query) {
                return $query->enable_question_feedback;
            })->editColumn('image', function ($query) {
                if (empty($query->image)) {
                    $return = '';
                } else {
                    $return = '<img style="max-width: 150px;" src="' . asset($query->image) . '">';
                }
                return $return;
            })->editColumn('created_at', function ($query) {
                return $query->created_at;
            })->editColumn('type', function ($query) {

                if ($query->type == "M") {
                    return 'Multiple Choice';
                } elseif ($query->type == "S") {
                    return 'Short Answer';
                } elseif ($query->type == "L") {
                    return 'Long Answer';
                } elseif ($query->type == "F") {
                    return 'Fill in the blank';
                } elseif ($query->type == "Mt") {
                    return 'Matching Question';
                }
            })->addColumn('action', function ($query) {

                if (permissionCheck('question-bank.edit')) {

                    $quiz_bank_edit = ' <a class="dropdown-item edit_brand"
                                                               href="' . route('question-bank-edit', [$query->id]) . '">' . trans('common.Edit') . '</a>';
                } else {
                    $quiz_bank_edit = "";
                }


                if (permissionCheck('question-bank.delete')) {

                    $quiz_bank_delete = '<button class="dropdown-item deleteQuiz_bank"
                                                                    data-id="' . $query->id . '"
                                                                    type="button">' . trans('common.Delete') . '</button>';
                } else {
                    $quiz_bank_delete = "";
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
                                                        ' . $quiz_bank_edit . '
                                                        ' . $quiz_bank_delete . '




                                                    </div>
                                                </div>';

                return $actioinView;
            })->rawColumns(['delete_btn', 'action', 'image', 'question'])->make(true);
    }

    public function questionBulkImport()
    {
        $user = Auth::user();
        if ($user->role_id == 1) {
            $groups = QuestionGroup::latest()->get();
        } else {
            $groups = QuestionGroup::where('user_id', $user->id)->latest()->get();
        }
        $categories = Category::whereNull('parent_id')->where('status',1)->latest()->get();

        return view('quiz::bulk-import', compact('groups', 'categories'));
    }


    public function downloadGroup()
    {
        return Excel::download(new ExportQuestionGroup(), 'question-group.xlsx');
    }

    public function downloadCategory()
    {
        return Excel::download(new ExportCategory(), 'categories.xlsx');
    }

    public function downloadSubCategory()
    {
        return Excel::download(new ExportSubCategory(), 'sub-categories.xlsx');
    }

    public function downloadSample()
    {
        return Excel::download(new ExportSampleQuestionBank(), 'sample-questions.xlsx');
    }

    public function questionBulkImportSubmit(Request $request)
    {

        if (demoCheck()) {
            return redirect()->back();
        }

        $rules = [
            'group' => "required",
            'category' => "required",
            'excel_file' => 'required',
        ];

        $this->validate($request, $rules, validationMessage($rules));

        if ($request->hasFile('excel_file')) {
            $extension = File::extension($request->excel_file->getClientOriginalName());
            if ($extension != "xlsx" && $extension != "xls") {
                Toastr::error('Excel File is Required', trans('common.Failed'));
                return redirect()->back();
            }
        }

        try {
            Excel::import(new QuestionBankImport($request->group, $request->category, $request->sub_category), $request->excel_file);

            Toastr::success(trans('common.Operation successful'), trans('common.Success'));

            return redirect('quiz/question-bank-list');
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }

    public function bulkDestroy(Request $request)
    {
        if (demoCheck()) {
            return redirect()->back();
        }

        try {
            $questions = explode(',', $request->questions);
            if (count($questions) != 0) {
                foreach ($questions as $question) {
                    $online_question = QuestionBank::find($question);

                    if ($online_question) {
                        if ($online_question->type == "M") {
                            QuestionBankMuOption::where('question_bank_id', $online_question->id)->delete();
                        }
                        $online_question->delete();
                    }
                }

                Toastr::success(trans('common.Operation successful'), trans('common.Success'));
                return redirect()->to(route('question-bank-list'));
            }
        } catch (\Exception $e) {
            GettingError($e->getMessage(), url()->current(), request()->ip(), request()->userAgent());
        }
    }
}
