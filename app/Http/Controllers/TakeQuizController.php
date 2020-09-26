<?php

namespace App\Http\Controllers;

use App\myQuiz;
use App\myQuizItem;
use App\myQuiz_es;
use App\myTask;

use App\Quiz;
use App\QuizItem;
use App\Quiz_tf;
use App\Quiz_mu;
use App\Quiz_mu_choice;
use App\Quiz_or;
use App\Quiz_or_column;
use App\Quiz_fi;
use App\Quiz_fi_blank_answer;
use App\Quiz_es;
use App\Quiz_ma;
use App\Quiz_ma_column;
use App\User;
use App\enrollment;
use App\Clas;
use App\Subject;
use App\Component;
use App\SubjectType;
use App\task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Auth;

class TakeQuizController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($class_id, $quiz_id)
    {
        $task_id = task::where([
                ['submission_id', $quiz_id],
                ['class_id', $class_id],
                ])->pluck('id')->first();

        if(myTask::where([
                ['user_id', '=', Auth::user()->id],
                ['task_id', '=', $task_id],
                ])->count() > 0){
        }else{
            $myQuiz = new myQuiz;
            $myQuiz->save();

            $myTasks = new myTask;
            $myTasks->user_id = Auth::user()->id;
            $myTasks->task_id = $task_id;
            $myTasks->mySubmission_id = $myQuiz->id;
            $myTasks->save();
        }

        $Class_details = DB::table('classes')
                            ->select(
                                'classes.id as class_id',
                                'classes.classPic_location',
                                'classes.coursecode',
                                'classes.stubcode',
                                'subjects.name as subject_name'
                                )
                            ->leftJoin('subjects', 'classes.subject_id', '=', 'subjects.id')
                            ->leftJoin('enrollments', 'classes.id', '=', 'enrollments.class_id')
                            ->leftJoin('users', 'enrollments.user_id', '=', 'users.id')
                            ->where([
                                ['users.id', '=', Auth::user()->id],
                                ['classes.id', '=', $class_id]
                                ])
                            ->get();
        // Quiz
        $quiz_infos = Quiz::find($quiz_id);
        $subjects = Subject::all();
        $total_items = DB::table('quiz_items')
                            ->where('quiz_items.quiz_id', '=', $quiz_id)
                            ->count();
        $total_score = DB::table('quiz_items')
                            ->where('quiz_items.quiz_id', '=', $quiz_id)
                            ->sum('itemScore');
        $quizItem_info = null;
        $quiz_items = DB::table('quiz_items')
                            ->where('quiz_items.quiz_id', '=', $quiz_id)
                            ->get();

        //For Next Botton
        $quiz_item_ids = DB::table('quiz_items')
                                    ->where('quiz_items.quiz_id', '=', $quiz_id)
                                    ->pluck('id')
                            ->toArray();
        $myQuiz_id = myTask::where([
                            ['task_id', '=', $task_id],
                            ['user_id', '=', Auth::user()->id],
                            ])
                            ->pluck('mySubmission_id');
        //taken quizTypes
        $takentf_ids = DB::table('quiz_items')
                                    ->join('my_quiz_items', 'my_quiz_items.quiz_tf_id', '=', 'quiz_items.quiz_tf_id')
                                    ->where([
                                        ['quiz_items.quiz_id', '=', $quiz_id],
                                        ['my_quiz_items.myQuiz_id', '=', $myQuiz_id],
                                        ])
                                    ->pluck('quiz_items.id')
                                    ->toArray();

        $takenmu_ids = DB::table('quiz_items')
                                    ->join('my_quiz_items', 'my_quiz_items.quiz_mu_id', '=', 'quiz_items.quiz_mu_id')
                                    ->where([
                                        ['quiz_items.quiz_id', '=', $quiz_id],
                                        ['my_quiz_items.myQuiz_id', '=', $myQuiz_id],
                                        ])
                                    ->pluck('quiz_items.id')
                                    ->toArray();

        $takenor_ids = DB::table('quiz_items')
                                    ->join('my_quiz_items', 'my_quiz_items.quiz_or_id', '=', 'quiz_items.quiz_or_id')
                                    ->where([
                                        ['quiz_items.quiz_id', '=', $quiz_id],
                                        ['my_quiz_items.myQuiz_id', '=', $myQuiz_id],
                                        ])
                                    ->pluck('quiz_items.id')
                                    ->toArray();

        $takenfi_ids = DB::table('quiz_items')
                                    ->join('my_quiz_items', 'my_quiz_items.quiz_fi_id', '=', 'quiz_items.quiz_fi_id')
                                    ->where([
                                        ['quiz_items.quiz_id', '=', $quiz_id],
                                        ['my_quiz_items.myQuiz_id', '=', $myQuiz_id],
                                        ])
                                    ->pluck('quiz_items.id')
                                    ->toArray();;

        $takenes_ids = DB::table('quiz_items')
                                    ->join('my_quiz_items', 'my_quiz_items.quiz_es_id', '=', 'quiz_items.quiz_es_id')
                                    ->where([
                                        ['quiz_items.quiz_id', '=', $quiz_id],
                                        ['my_quiz_items.myQuiz_id', '=', $myQuiz_id],
                                        ])
                                    ->pluck('quiz_items.id')
                                    ->toArray();

        $takenma_ids = DB::table('quiz_items')
                                    ->join('my_quiz_items', 'my_quiz_items.quiz_ma_id', '=', 'quiz_items.quiz_ma_id')
                                    ->where([
                                        ['quiz_items.quiz_id', '=', $quiz_id],
                                        ['my_quiz_items.myQuiz_id', '=', $myQuiz_id],
                                        ])
                                    ->pluck('quiz_items.id')
                                    ->toArray();

        $takenQuizItem_ids = array_merge($takentf_ids, $takenmu_ids, $takenor_ids, $takenfi_ids, $takenes_ids, $takenma_ids);
        $Quiz_item_diff = array_diff($quiz_item_ids, $takenQuizItem_ids);
        $total_takenItems = count($Quiz_item_diff);
        if (empty($Quiz_item_diff)) {
            return view('class.viewClass.task.onlineQuiz', [
                'class_id'=> $class_id,
                'quiz_id'=> $quiz_id,
                'Class_details'=> $Class_details,
                'quiz_infos'=> $quiz_infos,
                'subjects'=> $subjects,
                'quiz_items'=> $quiz_items,
                'total_items'=> $total_items,
                'total_score'=> $total_score,
                'quizItem_info'=> $quizItem_info,
                'total_takenItems'=>$total_takenItems
            ]);
        }
        $random_num = array_rand($Quiz_item_diff, 1);
        $NextQuiz_id = $Quiz_item_diff[$random_num];

        return view('class.viewClass.task.onlineQuiz', [
            'class_id'=> $class_id,
            'quiz_id'=> $quiz_id,
            'Class_details'=> $Class_details,
            'quiz_infos'=> $quiz_infos,
            'subjects'=> $subjects,
            'quiz_items'=> $quiz_items,
            'total_items'=> $total_items,
            'total_score'=> $total_score,
            'quizItem_info'=> $quizItem_info,
            'NextQuiz_id'=>$NextQuiz_id,
            'total_takenItems'=>$total_takenItems
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($class_id, $quiz_id)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $class_id, $quiz_id)
    {
        $task_id = task::where('submission_id', $quiz_id)->pluck('id')->first();
        $myTask_id = myTask::where('task_id', $task_id)->pluck('id')->first();

        //For Next Botton
        $quiz_item_ids = DB::table('quiz_items')
                                    ->where('quiz_items.quiz_id', '=', $quiz_id)
                                    ->pluck('id')
                            ->toArray();
        $myQuiz_id = myTask::where([
                            ['task_id', '=', $task_id],
                            ['user_id', '=', Auth::user()->id],
                            ])
                            ->pluck('mySubmission_id')
                            ->first();

        if($request->input('quiz_type') === "quiz_tfs"){

            $this->validate($request, [
                'quiz_items_id' => 'required',
                'answer' => 'required',
                'trueAnswer' => 'nullable'
            ]);

            $quizItem_info = QuizItem::find($request->input('quiz_items_id'));
            $quiz_tf = Quiz_tf::find($quizItem_info->quiz_tf_id);

            $correctAnswer = $quiz_tf->answer;
            //$correctTrueAnswer = $quiz_tf->trueAnswer;

            $studentAnswer = $request->input('answer');
            $studenttrueAnswer = $request->input('trueAnswer');


            if ($quiz_tf->falseAnswer != null) {
                $correctTrueAnswer = $quiz_tf->trueAnswer;
                if (($correctAnswer == $studentAnswer) && ($correctTrueAnswer == $studenttrueAnswer)) {
                    $myQuizItem = new myQuizItem;
                    $myQuizItem->myQuiz_id = $myQuiz_id;
                    $myQuizItem->quiz_tf_id = $quizItem_info->quiz_tf_id;
                    $myQuizItem->myScore = $quizItem_info->itemScore;
                    $myQuizItem->save();
                }else{
                    $myQuizItem = new myQuizItem;
                    $myQuizItem->myQuiz_id = $myQuiz_id;
                    $myQuizItem->quiz_tf_id = $quizItem_info->quiz_tf_id;
                    $myQuizItem->myScore = "0";
                    $myQuizItem->save();
                }
            }else{
                if ($correctAnswer == $studentAnswer) {
                    $myQuizItem = new myQuizItem;
                    $myQuizItem->myQuiz_id = $myQuiz_id;
                    $myQuizItem->quiz_tf_id = $quizItem_info->quiz_tf_id;
                    $myQuizItem->myScore = $quizItem_info->itemScore;
                    $myQuizItem->save();
                }else{
                    $myQuizItem = new myQuizItem;
                    $myQuizItem->myQuiz_id = $myQuiz_id;
                    $myQuizItem->quiz_tf_id = $quizItem_info->quiz_tf_id;
                    $myQuizItem->myScore = "0";
                    $myQuizItem->save();
                }
            }
        }elseif($request->input('quiz_type') === "quiz_mus"){
            $this->validate($request, [
                'quiz_items_id' => 'required',
                'correctCheck.*' => 'nullable'
            ]);

            $quizItem_info = QuizItem::find($request->input('quiz_items_id'));
            $quiz_mu = Quiz_mu::find($quizItem_info->quiz_mu_id);
            $quiz_mu_choices = Quiz_mu_choice::where('quiz_mu_id', $quizItem_info->quiz_mu_id)->pluck('correctCheck')->toArray();
            $studentAnswer =  array_map('intval', $request->input('correctCheck'));

            if ($quiz_mu_choices == $studentAnswer) {
                $myQuizItem = new myQuizItem;
                $myQuizItem->myQuiz_id = $myQuiz_id;
                $myQuizItem->quiz_mu_id = $quizItem_info->quiz_mu_id;
                $myQuizItem->myScore = $quizItem_info->itemScore;
                $myQuizItem->save();
            } else {
                $myQuizItem = new myQuizItem;
                $myQuizItem->myQuiz_id = $myQuiz_id;
                $myQuizItem->quiz_mu_id = $quizItem_info->quiz_mu_id;
                $myQuizItem->myScore = "0";
                $myQuizItem->save();
            }
        }elseif($request->input('quiz_type') === "quiz_ors"){
            $this->validate($request, [
                'quiz_items_id' => 'required',
                'column.*' => 'required'
            ]);
            $quizItem_info = QuizItem::find($request->input('quiz_items_id'));
            $quiz_or = Quiz_or::find($quizItem_info->quiz_or_id);
            $quiz_or_columns = Quiz_or_column::where('quiz_or_id', $quizItem_info->quiz_or_id)->pluck('column')->toArray();

            if($quiz_or_columns == $request->input('column')){
                $myQuizItem = new myQuizItem;
                $myQuizItem->myQuiz_id = $myQuiz_id;
                $myQuizItem->quiz_or_id = $quizItem_info->quiz_or_id;
                $myQuizItem->myScore = $quizItem_info->itemScore;
                $myQuizItem->save();
            }else{
                $myQuizItem = new myQuizItem;
                $myQuizItem->myQuiz_id = $myQuiz_id;
                $myQuizItem->quiz_or_id = $quizItem_info->quiz_or_id;
                $myQuizItem->myScore = "0";
                $myQuizItem->save();
            }
        }elseif($request->input('quiz_type') === "quiz_fis"){
        
            $this->validate($request, [
                'quiz_items_id' => 'required',
                'answer.*' => 'required',
            ]);

            $quizItem_info = QuizItem::find($request->input('quiz_items_id'));
            $quiz_fi = Quiz_mu::find($quizItem_info->quiz_fi_id);
            $quiz_fi_blank_answers = Quiz_fi_blank_answer::where('quiz_fi_id', $quizItem_info->quiz_fi_id)->get('answer');
            $studentAnswer = $request->input('answer');

            $result = Quiz_fi_blank_answer::where('answer', $studentAnswer)->get();
            if ($result == '[]') {
                $myQuizItem = new myQuizItem;
                $myQuizItem->myQuiz_id = $myQuiz_id;
                $myQuizItem->quiz_fi_id = $quizItem_info->quiz_fi_id;
                $myQuizItem->myScore = "0";
                $myQuizItem->save();
            } else {
                $myQuizItem = new myQuizItem;
                $myQuizItem->myQuiz_id = $myQuiz_id;
                $myQuizItem->quiz_fi_id = $quizItem_info->quiz_fi_id;
                $myQuizItem->myScore = $quizItem_info->itemScore;
                $myQuizItem->save();
            }
        }elseif($request->input('quiz_type') === "quiz_mas"){
            $this->validate($request, [
                'quiz_items_id' => 'required',
                'answerColumn.*' => 'required'
            ]);
            $quizItem_info = QuizItem::find($request->input('quiz_items_id'));
            $quiz_ma = Quiz_mu::find($quizItem_info->quiz_ma_id);
            $quiz_ma_columns = Quiz_ma_column::where('quiz_ma_id', $quizItem_info->quiz_ma_id)->pluck('answerColumn')->toArray();
            $studentAnswer = $request->input('answerColumn');

            if ($quiz_ma_columns == $studentAnswer) {
                $myQuizItem = new myQuizItem;
                $myQuizItem->myQuiz_id = $myQuiz_id;
                $myQuizItem->quiz_ma_id = $quizItem_info->quiz_ma_id;
                $myQuizItem->myScore = $quizItem_info->itemScore;
                $myQuizItem->save();
            } else {
                $myQuizItem = new myQuizItem;
                $myQuizItem->myQuiz_id = $myQuiz_id;
                $myQuizItem->quiz_ma_id = $quizItem_info->quiz_ma_id;
                $myQuizItem->myScore = "0";
                $myQuizItem->save();
            }
        }elseif($request->input('quiz_type') === "quiz_es"){

            $this->validate($request, [
                'quiz_items_id' => 'required',
                'myEssay' => 'required'
            ]);

            $quizItem_info = QuizItem::find($request->input('quiz_items_id'));
            $quiz_es = Quiz_mu::find($quizItem_info->quiz_es_id);

            $myQuizItem = new myQuizItem;
            $myQuizItem->myQuiz_id = $myQuiz_id;
            $myQuizItem->quiz_es_id = $quizItem_info->quiz_es_id;
            $myQuizItem->myScore = $quizItem_info->itemScore;
            $myQuizItem->myEssay = $request->input('myEssay');
            $myQuizItem->save();
        }

        //taken quizTypes
        $takentf_ids = DB::table('quiz_items')
                                    ->join('my_quiz_items', 'my_quiz_items.quiz_tf_id', '=', 'quiz_items.quiz_tf_id')
                                    ->where([
                                        ['quiz_items.quiz_id', '=', $quiz_id],
                                        ['my_quiz_items.myQuiz_id', '=', $myQuiz_id],
                                        ])
                                    ->pluck('quiz_items.id')
                                    ->toArray();

        $takenmu_ids = DB::table('quiz_items')
                                    ->join('my_quiz_items', 'my_quiz_items.quiz_mu_id', '=', 'quiz_items.quiz_mu_id')
                                    ->where([
                                        ['quiz_items.quiz_id', '=', $quiz_id],
                                        ['my_quiz_items.myQuiz_id', '=', $myQuiz_id],
                                        ])
                                    ->pluck('quiz_items.id')
                                    ->toArray();

        $takenor_ids = DB::table('quiz_items')
                                    ->join('my_quiz_items', 'my_quiz_items.quiz_or_id', '=', 'quiz_items.quiz_or_id')
                                    ->where([
                                        ['quiz_items.quiz_id', '=', $quiz_id],
                                        ['my_quiz_items.myQuiz_id', '=', $myQuiz_id],
                                        ])
                                    ->pluck('quiz_items.id')
                                    ->toArray();

        $takenfi_ids = DB::table('quiz_items')
                                    ->join('my_quiz_items', 'my_quiz_items.quiz_fi_id', '=', 'quiz_items.quiz_fi_id')
                                    ->where([
                                        ['quiz_items.quiz_id', '=', $quiz_id],
                                        ['my_quiz_items.myQuiz_id', '=', $myQuiz_id],
                                        ])
                                    ->pluck('quiz_items.id')
                                    ->toArray();;

        $takenes_ids = DB::table('quiz_items')
                                    ->join('my_quiz_items', 'my_quiz_items.quiz_es_id', '=', 'quiz_items.quiz_es_id')
                                    ->where([
                                        ['quiz_items.quiz_id', '=', $quiz_id],
                                        ['my_quiz_items.myQuiz_id', '=', $myQuiz_id],
                                        ])
                                    ->pluck('quiz_items.id')
                                    ->toArray();

        $takenma_ids = DB::table('quiz_items')
                                    ->join('my_quiz_items', 'my_quiz_items.quiz_ma_id', '=', 'quiz_items.quiz_ma_id')
                                    ->where([
                                        ['quiz_items.quiz_id', '=', $quiz_id],
                                        ['my_quiz_items.myQuiz_id', '=', $myQuiz_id],
                                        ])
                                    ->pluck('quiz_items.id')
                                    ->toArray();

        $takenQuizItem_ids = array_merge($takentf_ids, $takenmu_ids, $takenor_ids, $takenfi_ids, $takenes_ids, $takenma_ids);
        $Quiz_item_diff = array_diff($quiz_item_ids, $takenQuizItem_ids);

        if (empty($Quiz_item_diff)) {
            return redirect('/viewClass'.'/'.$class_id.'/task'.'/'.$quiz_id.'/takeQuiz')->with('success', 'Done');
        }else{
            $random_num = array_rand($Quiz_item_diff, 1);
            $NextQuiz_id = $Quiz_item_diff[$random_num];
            $total_takenItems = count($Quiz_item_diff);
            return redirect('/viewClass'.'/'.$class_id.'/task'.'/'.$quiz_id.'/takeQuiz'.'/'.$NextQuiz_id);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($class_id, $quiz_id, $takeQuiz)
    {
        $task_id = task::where('submission_id', $quiz_id)->pluck('id')->first();

        //For Next Botton
        $quiz_item_ids = DB::table('quiz_items')
                                    ->where('quiz_items.quiz_id', '=', $quiz_id)
                                    ->pluck('id')
                            ->toArray();
        $myQuiz_id = myTask::where([
                            ['task_id', '=', $task_id],
                            ['user_id', '=', Auth::user()->id],
                            ])
                            ->pluck('mySubmission_id')
                            ->first();
        //taken quizTypes
        $takentf_ids = DB::table('quiz_items')
                                    ->join('my_quiz_items', 'my_quiz_items.quiz_tf_id', '=', 'quiz_items.quiz_tf_id')
                                    ->where([
                                        ['quiz_items.quiz_id', '=', $quiz_id],
                                        ['my_quiz_items.myQuiz_id', '=', $myQuiz_id],
                                        ])
                                    ->pluck('quiz_items.id')
                                    ->toArray();

        $takenmu_ids = DB::table('quiz_items')
                                    ->join('my_quiz_items', 'my_quiz_items.quiz_mu_id', '=', 'quiz_items.quiz_mu_id')
                                    ->where([
                                        ['quiz_items.quiz_id', '=', $quiz_id],
                                        ['my_quiz_items.myQuiz_id', '=', $myQuiz_id],
                                        ])
                                    ->pluck('quiz_items.id')
                                    ->toArray();

        $takenor_ids = DB::table('quiz_items')
                                    ->join('my_quiz_items', 'my_quiz_items.quiz_or_id', '=', 'quiz_items.quiz_or_id')
                                    ->where([
                                        ['quiz_items.quiz_id', '=', $quiz_id],
                                        ['my_quiz_items.myQuiz_id', '=', $myQuiz_id],
                                        ])
                                    ->pluck('quiz_items.id')
                                    ->toArray();

        $takenfi_ids = DB::table('quiz_items')
                                    ->join('my_quiz_items', 'my_quiz_items.quiz_fi_id', '=', 'quiz_items.quiz_fi_id')
                                    ->where([
                                        ['quiz_items.quiz_id', '=', $quiz_id],
                                        ['my_quiz_items.myQuiz_id', '=', $myQuiz_id],
                                        ])
                                    ->pluck('quiz_items.id')
                                    ->toArray();;

        $takenes_ids = DB::table('quiz_items')
                                    ->join('my_quiz_items', 'my_quiz_items.quiz_es_id', '=', 'quiz_items.quiz_es_id')
                                    ->where([
                                        ['quiz_items.quiz_id', '=', $quiz_id],
                                        ['my_quiz_items.myQuiz_id', '=', $myQuiz_id],
                                        ])
                                    ->pluck('quiz_items.id')
                                    ->toArray();

        $takenma_ids = DB::table('quiz_items')
                                    ->join('my_quiz_items', 'my_quiz_items.quiz_ma_id', '=', 'quiz_items.quiz_ma_id')
                                    ->where([
                                        ['quiz_items.quiz_id', '=', $quiz_id],
                                        ['my_quiz_items.myQuiz_id', '=', $myQuiz_id],
                                        ])
                                    ->pluck('quiz_items.id')
                                    ->toArray();

        $takenQuizItem_ids = array_merge($takentf_ids, $takenmu_ids, $takenor_ids, $takenfi_ids, $takenes_ids, $takenma_ids);
        $Quiz_item_diff = array_diff($quiz_item_ids, $takenQuizItem_ids);
        if (empty($Quiz_item_diff)) {
            return redirect('/viewClass'.'/'.$class_id.'/task'.'/'.$quiz_id.'/takeQuiz')->with('danger', 'Done');
        }
        $random_num = array_rand($Quiz_item_diff, 1);
        $NextQuiz_id = $Quiz_item_diff[$random_num];
        $total_takenItems = count($Quiz_item_diff) - 1;

        $Class_details = DB::table('classes')
                            ->select(
                                'classes.id as class_id',
                                'classes.classPic_location',
                                'classes.coursecode',
                                'classes.stubcode',
                                'subjects.name as subject_name'
                                )
                            ->leftJoin('subjects', 'classes.subject_id', '=', 'subjects.id')
                            ->leftJoin('enrollments', 'classes.id', '=', 'enrollments.class_id')
                            ->leftJoin('users', 'enrollments.user_id', '=', 'users.id')
                            ->where([
                                ['users.id', '=', Auth::user()->id],
                                ['classes.id', '=', $class_id]
                                ])
                            ->get();
        // Quiz
        $quiz_infos = Quiz::find($quiz_id);
        $subjects = Subject::all();
        $subjectOptions = array('' => '-- Select Subject --') + $subjects->pluck('name', 'id')->toArray();

        $quiz_items = DB::table('quiz_items')
                            ->where('quiz_items.quiz_id', '=', $quiz_id)
                            ->get();

        $total_items = DB::table('quiz_items')
                            ->where('quiz_items.quiz_id', '=', $quiz_id)
                            ->count();

        $total_score = DB::table('quiz_items')
                            ->where('quiz_items.quiz_id', '=', $quiz_id)
                            ->sum('itemScore');

        $quizItem_info = QuizItem::find($takeQuiz);
        $quiz_tf = Quiz_tf::find($quizItem_info->quiz_tf_id);
        $quiz_mu = Quiz_mu::find($quizItem_info->quiz_mu_id);
        $quiz_mu_choices = Quiz_mu_choice::where('quiz_mu_id', $quizItem_info->quiz_mu_id)->get();
        $quiz_or = Quiz_or::find($quizItem_info->quiz_or_id);
        $quiz_or_columns = Quiz_or_column::where('quiz_or_id', $quizItem_info->quiz_or_id)->get();
        $quiz_fi = Quiz_fi::find($quizItem_info->quiz_fi_id);
        $quiz_fi_blank_answers = Quiz_fi_blank_answer::where('quiz_fi_id', $quizItem_info->quiz_fi_id)->get();
        $quiz_es = Quiz_es::find($quizItem_info->quiz_es_id);
        $quiz_ma = Quiz_ma::find($quizItem_info->quiz_ma_id);
        $quiz_ma_columns = Quiz_ma_column::where('quiz_ma_id', $quizItem_info->quiz_ma_id)->get();
        $quiz_ma_choices = Quiz_ma_column::where('quiz_ma_id', $quizItem_info->quiz_ma_id)->inRandomOrder()->get();
        return view('class.viewClass.task.onlineQuiz',[
            'class_id'=> $class_id,
            'takeQuiz'=> $takeQuiz,
            'Class_details'=> $Class_details,
            'quiz_infos'=>$quiz_infos,
            'subjectOptions'=>$subjectOptions,
            'quiz_id'=>$quiz_id,
            'quiz_items'=>$quiz_items,
            'quizItem_info'=>$quizItem_info,
            'quiz_tf'=>$quiz_tf,
            'quiz_mu'=>$quiz_mu,
            'quiz_mu_choices'=>$quiz_mu_choices,
            'quiz_or'=>$quiz_or,
            'quiz_or_columns'=>$quiz_or_columns,
            'quiz_fi'=>$quiz_fi,
            'quiz_fi_blank_answers'=>$quiz_fi_blank_answers,
            'quiz_es'=>$quiz_es,
            'quiz_ma'=>$quiz_ma,
            'quiz_ma_columns'=>$quiz_ma_columns,
            'quiz_ma_choices'=>$quiz_ma_choices,
            'total_items'=>$total_items,
            'total_score'=>$total_score,
            'NextQuiz_id'=>$NextQuiz_id,
            'total_takenItems'=>$total_takenItems
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($class_id, $quiz_id, $takeQuiz)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $class_id, $quiz_id, $takeQuiz)
    {
        $task_id = task::where('submission_id', $quiz_id)->pluck('id')->first();
        $myQuiz_id = myTask::where([
            ['task_id', '=', $task_id],
            ['user_id', '=', Auth::user()->id],
            ])
            ->pluck('mySubmission_id')
            ->first();

        $myQuiz = myQuiz::find($myQuiz_id);
        $myQuiz->submit = "submit";
        $myQuiz->save();

        return redirect('/viewClass'.'/'.$class_id.'/task'.'/'.$task_id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($class_id, $quiz_id, $takeQuiz)
    {
        //
    }
}
