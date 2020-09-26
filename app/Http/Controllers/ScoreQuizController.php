<?php

namespace App\Http\Controllers;

use App\myQuiz;
use App\myQuizItem;
use App\myQuiz_es;

use App\User;
use App\enrollment;
use App\Clas;
use App\Subject;
use App\Component;
use App\SubjectType;
use App\task;
use App\myTask;
use App\Quiz;
use App\QuizItem;
use App\Quiz_es;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Auth;

class ScoreQuizController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($class_id, $quiz_id)
    {
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
        $quiz_details = Quiz::find($quiz_id);
        $task_id = task::where([
                                ['submission_id', '=', $quiz_id],
                                ['class_id', '=', $class_id],
                                ])
                                ->pluck('id')
                                ->first();
        $myTasks = DB::table('my_tasks')
                                ->select(
                                    'users.id as user_id',
                                    'users.name as user_name',
                                    'my_tasks.id as mytask_id'
                                )
                                ->join('users', 'my_tasks.user_id', '=', 'users.id')
                                ->where([
                                ['my_tasks.task_id', '=', $task_id]
                                ])->get();                
        
        return view('class.viewClass.task.quizScoring', [
            'Class_details'=> $Class_details, 
            'class_id'=>$class_id,
            'quiz_id'=>$quiz_id,
            'quiz_details'=>$quiz_details,
            'myTasks'=>$myTasks,
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($class_id, $quiz_id, $user_id)
    {
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
        $quiz_details = Quiz::find($quiz_id);
        $task_id = task::where([
                                ['submission_id', '=', $quiz_id],
                                ['class_id', '=', $class_id],
                                ])
                                ->pluck('id')
                                ->first();
        $myTasks = DB::table('my_tasks')
                                ->select(
                                    'users.id as user_id',
                                    'users.name as user_name',
                                    'my_tasks.id as mytask_id',
                                    'my_tasks.score_check'
                                )
                                ->join('users', 'my_tasks.user_id', '=', 'users.id')
                                ->where([
                                ['my_tasks.task_id', '=', $task_id],
                                ['my_tasks.score_check', '=', null],
                                ])->get();

        $myTasks_Essay_details = DB::table('my_tasks')
                                ->select(
                                    'users.id as user_id',
                                    'users.name as user_name',
                                    'my_tasks.id as mytask_id',
                                    'my_tasks.score_check',
                                    'my_quiz_items.myEssay',
                                    'my_quiz_items.quiz_es_id',
                                    'quiz_items.itemScore',
                                    'my_quiz_items.myScore',
                                    'quiz_es.statement'
                                )
                                ->join('users', 'my_tasks.user_id', '=', 'users.id')
                                ->join('my_quizzes', 'my_tasks.mySubmission_id', '=', 'my_quizzes.id')
                                ->join('my_quiz_items', 'my_quizzes.id', '=', 'my_quiz_items.myQuiz_id')
                                ->join('quiz_es', 'my_quiz_items.quiz_es_id', '=', 'quiz_es.id')
                                ->join('quiz_items', 'quiz_items.quiz_es_id', '=', 'quiz_es.id')
                                ->where([
                                ['my_tasks.task_id', '=', $task_id],
                                ['users.id', '=', $user_id],
                                ['my_tasks.score_check', '=', null],
                                ])->get();              
        
        return view('class.viewClass.task.quizScoring', [
            'Class_details'=> $Class_details, 
            'class_id'=>$class_id,
            'quiz_id'=>$quiz_id,
            'quiz_details'=>$quiz_details,
            'myTasks'=>$myTasks,
            'user_id'=>$user_id,
            'myTasks_Essay_details'=>$myTasks_Essay_details,
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($class_id, $quiz_id ,$user_id)
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
    public function update(Request $request, $class_id, $quiz_id, $user_id)
    {
        $this->validate($request, [
            'myScore' => 'nullable'
        ]);

        $task_id = task::where([
                            ['class_id', '=', $class_id],
                            ['submission_id', '=', $quiz_id],
                            ])
                            ->pluck('id')
                            ->first();

        $myQuiz_id = myTask::where([
                            ['task_id', '=', $task_id],
                            ['user_id', '=', $user_id],
                            ])
                            ->pluck('mySubmission_id')
                            ->first();

        $myQuizItem_id = myQuizItem::where([
                            ['myQuiz_id', '=', $myQuiz_id],
                            ['quiz_es_id', '!=', null],
                            ])
                            ->pluck('id')
                            ->first();

        $myEssay = myQuizItem::find($myQuizItem_id);
        $myEssay->myScore = $request->input('myScore');
        $myEssay->save();

        $myTotalScore = myQuizItem::where('myQuiz_id', '=', $myQuiz_id)
                            ->sum('myScore');

        $myTask_id = myTask::where([
                            ['task_id', '=', $task_id],
                            ['user_id', '=', $user_id],
                            ])
                            ->pluck('id')
                            ->first();

        $myTask = myTask::find($myTask_id);
        $myTask->myScore = $myTotalScore;
        $myTask->score_check = "checked";
        $myTask->save();
        
        return redirect('/viewClass'.'/'.$class_id.'/task'.'/'.$quiz_id.'/quizScoring'.'/'.$user_id)->with('success', 'updated');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($class_id, $quiz_id ,$user_id)
    {
        //
    }
}
