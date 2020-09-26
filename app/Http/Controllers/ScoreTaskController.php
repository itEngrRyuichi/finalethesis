<?php

namespace App\Http\Controllers;

use App\User;
use App\enrollment;
use App\Clas;
use App\Subject;
use App\Component;
use App\SubjectType;
use App\task;
use App\myTask;
use App\myResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Auth;

class ScoreTaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($class_id, $task_id)
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

        $task_detail = task::find($task_id);

        $SF_students = DB::table('enrollments')
                        ->select(
                            'users.id as user_id',
                            'users.name as user_name',
                            'my_resources.myResource_location',
                            'my_resources.name as myResourceName'
                            )
                        ->join('users', 'users.id', '=', 'enrollments.user_id')
                        ->join('my_tasks', 'users.id', '=', 'my_tasks.user_id')
                        ->join('my_resources', 'my_resources.my_task_id', '=', 'my_tasks.id')
                        ->where([
                            ['enrollments.class_id', $class_id],
                            ['my_tasks.task_id', $task_id],
                            ['my_tasks.score_check', '=', null],
                            ['users.userType_id', 3],
                            ])
                        ->get();

        $students = DB::table('enrollments')
                        ->select(
                            'users.id as user_id',
                            'users.name as user_name'
                            )
                        ->join('users', 'users.id', '=', 'enrollments.user_id')
                        ->where([
                            ['enrollments.class_id', $class_id],
                            ['users.userType_id', 3],
                            ])
                        ->get();

        $ScoredStudents = DB::table('enrollments')
                        ->select(
                            'users.id as user_id',
                            'users.name as user_name'
                            )
                        ->join('users', 'users.id', '=', 'enrollments.user_id')
                        ->join('my_tasks', 'users.id', '=', 'my_tasks.user_id')
                        ->where([
                            ['enrollments.class_id', $class_id],
                            ['my_tasks.task_id', $task_id]
                            ])
                        ->get();

        return view('class.viewClass.task.taskScoring', [
            'Class_details'=> $Class_details, 
            'class_id'=>$class_id,
            'task_id'=>$task_id,
            'students'=>$students,
            'ScoredStudents'=>$ScoredStudents,
            'SF_students'=>$SF_students,
            'task_detail'=>$task_detail,
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($class_id, $task_id)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $class_id, $task_id)
    {
        $this->validate($request, [
            'myScore*' => 'required',
            'user_id*' => 'required'
        ]);

        for($i= 0; $i<count($request->input('user_id')); $i++){
            $my_tasks[] = [
                'myScore' =>  $request->input('myScore')[$i],
                'user_id' => $request->input('user_id')[$i],
                'score_check' => "checked",
                'task_id' => $task_id
            ];
        }
        DB::table('my_tasks')->insert($my_tasks);

        return redirect('/viewClass'.'/'.$class_id.'/task'.'/'.$task_id.'/taskScoring')->with('success', 'Scored!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($class_id, $task_id, $user_id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($class_id, $task_id, $user_id)
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
    public function update(Request $request, $class_id, $task_id, $user_id)
    {
        $this->validate($request, [
            'myScore' => 'required'
        ]);

        $myTask_id = myTask::where([
                            ['task_id', '=', $task_id],
                            ['user_id', '=', $user_id]
                            ])
                            ->pluck('id')
                            ->first();

        $myTask = myTask::find($myTask_id);

        $myTask->myScore = $request->input('myScore');
        $myTask->score_check = "checked";
        $myTask->save();

        return redirect('/viewClass'.'/'.$class_id.'/task'.'/'.$task_id.'/taskScoring')->with('success', 'Scored !!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($class_id, $task_id, $user_id)
    {
        //
    }
}
