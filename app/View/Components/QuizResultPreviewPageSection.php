<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Modules\Quiz\Entities\OnlineQuiz;
use Modules\Quiz\Entities\QuizeSetup;
use Modules\Quiz\Entities\QuizTestDetails;

class QuizResultPreviewPageSection extends Component
{
    public $quizTest, $user, $course;

    public function __construct($quizTest, $user, $course)
    {
        $this->quizTest = $quizTest;
        $this->user = $user;
        $this->course = $course;
    }


    public function render()
    {
        $quizSetup = QuizeSetup::getData();

        $quiz = OnlineQuiz::with('assign.questionBank', 'assign.questionBank.questionMu')->findOrFail($this->quizTest->quiz_id);
        $questions = [];
        foreach (@$quiz->assign as $key => $assign) {
            $questions[$key]['qus'] = $assign->questionBank->question;
            $questions[$key]['type'] = $assign->questionBank->type;
            $questions[$key]['qus_id'] = $assign->questionBank->id;

            $test = QuizTestDetails::where('quiz_test_id', $this->quizTest->id)->where('qus_id', $assign->questionBank->id)->first();
            // if($assign->questionBank->type == "Mt")
                // dd($this->quizTest, $test, $assign->questionBank);
            $questions[$key]['isSubmit'] = false;
            $questions[$key]['isWrong'] = false;

            if ($assign->questionBank->type == "S" || $assign->questionBank->type == "L" || $assign->questionBank->type == "") {

                if ($test) {
                    $questions[$key]['isSubmit'] = true;
                    if ($test->status == 0) {
                        $questions[$key]['isWrong'] = true;
                    }
                    $questions[$key]['answer'] = $test->answer;
                }
              }
                elseif($assign->questionBank->type == "F"){
                    foreach (@$assign->questionBank->questionMuInSerial as $key2 => $option) {
                        $questions[$key]['option'][$key2]['title'] = $option->title;
                        $questions[$key]['option'][$key2]['right'] = $option->status == 1 ? true : false;

                        if ($test) {
                              $questions[$key]['isSubmit'] = true;
                              if ($test->status == 0) {
                                  if($option->question_bank_id == $test->qus_id && $option->id == $test->ans_id){

                                      $questions[$key]['option'][$key2]['wrong'] = $test->status == 0 ? true : false;
                                      $questions[$key]['isWrong'] = true;
                                  }
                              }
                        }
                    }
                }
                elseif($assign->questionBank->type == "Mt"){
                foreach (@$assign->questionBank->questionMuInSerial as $key2 => $option) {

                    $test_match_qus = QuizTestDetails::where('quiz_test_id', $this->quizTest->id)->where('match_qus_id', $option->id)->first();
                    if($option->match_type == 1){

                        $ans_data = $assign->questionBank->questionMuInSerial->where('id',$option->match_ans_id)->first();
                        $questions[$key]['option'][$key2]['que_id'] = $option->id;
                        $questions[$key]['option'][$key2]['que_title'] = $option->title;
                        if($ans_data){
                            $questions[$key]['option'][$key2]['ans_id'] = $ans_data->id;
                            $questions[$key]['option'][$key2]['ans_title'] = $ans_data->title;
                        }

                        if ($test_match_qus) {
                            $questions[$key]['isSubmit'] = true;
                            $questions[$key]['option'][$key2]['right'] = $test_match_qus->status == 1 ? true : false;
                            if ($test_match_qus->status == 0) {
                                if($option->question_bank_id == $test_match_qus->qus_id && $option->id == $test_match_qus->match_qus_id){

                                    $questions[$key]['option'][$key2]['wrong'] = $test_match_qus->status == 0 ? true : false;
                                    $questions[$key]['isWrong'] = true;

                                    $wrong_ans_data = $assign->questionBank->questionMuInSerial->where('id',$test_match_qus->ans_id)->first();
                                    if($wrong_ans_data){
                                        $questions[$key]['option'][$key2]['wrong_ans_id'] = $wrong_ans_data->id;
                                        $questions[$key]['option'][$key2]['wrong_ans_title'] = $wrong_ans_data->title;
                                    }
                                }
                            }
                        }
                    }
                }
            }
                else {
                foreach (@$assign->questionBank->questionMuInSerial as $key2 => $option) {
                    $questions[$key]['option'][$key2]['title'] = $option->title;
                    $questions[$key]['option'][$key2]['right'] = $option->status == 1 ? true : false;
                }

                if ($test) {
                    $questions[$key]['isSubmit'] = true;
                    if ($test->status == 0) {
                        $questions[$key]['option'][$key2]['wrong'] = $test->status == 0 ? true : false;
                        $questions[$key]['isWrong'] = true;
                    }
                }
            }

            if (!$questions[$key]['isSubmit']){
                $questions[$key]['isWrong'] = true;
            }

        }

        return view(theme('components.quiz-result-preview-page-section'), compact('questions', 'quizSetup'));
    }
}
