<?php

namespace App\Http\Controllers;

use App\User;
use App\enrollment;
use App\Clas;
use App\Subject;
use App\Component;
use App\SubjectType;
use App\Quarter;
use App\Quiz;
use App\task;
use App\myTask;
use App\myResource;
use App\myQuiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Auth;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($class_id)
    {
        //Main Table Labels

        $now = Carbon::now();
        $now60 = Carbon::now()->addMinutes(60);
        $OneComponents = DB::table('components')
                        ->select(
                            'components.id as component_id',
                            'components.name as component_name',
                            'components.highestWeight as component_weight'
                            )
                        ->leftJoin('subject_types', 'subject_types.id', '=', 'components.subjectType_id')
                        ->leftJoin('subjects', 'subjects.subjectType_id', '=', 'subject_types.id')
                        ->leftJoin('classes', 'classes.subject_id', '=', 'subjects.id')
                        ->where([
                            ['classes.id', '=', $class_id]
                            ])
                        ->skip(0)->take(1)->get();
        $TwoComponents = DB::table('components')
                        ->select(
                            'components.id as component_id',
                            'components.name as component_name',
                            'components.highestWeight as component_weight'
                            )
                        ->leftJoin('subject_types', 'subject_types.id', '=', 'components.subjectType_id')
                        ->leftJoin('subjects', 'subjects.subjectType_id', '=', 'subject_types.id')
                        ->leftJoin('classes', 'classes.subject_id', '=', 'subjects.id')
                        ->where([
                            ['classes.id', '=', $class_id]
                            ])
                        ->skip(1)->take(1)->get();
        $ThreeComponents = DB::table('components')
                        ->select(
                            'components.id as component_id',
                            'components.name as component_name',
                            'components.highestWeight as component_weight'
                            )
                        ->leftJoin('subject_types', 'subject_types.id', '=', 'components.subjectType_id')
                        ->leftJoin('subjects', 'subjects.subjectType_id', '=', 'subject_types.id')
                        ->leftJoin('classes', 'classes.subject_id', '=', 'subjects.id')
                        ->where([
                            ['classes.id', '=', $class_id]
                            ])
                        ->skip(2)->take(1)->get();
        $Onequarters = DB::table('quarters')
                        ->select(
                            'quarters.name as quarter_name',
                            'quarters.id as quarter_id'
                        )
                        ->leftJoin('semesters', 'semesters.id', '=', 'quarters.semester_id')
                        ->leftJoin('classes', 'classes.semester_id', '=', 'semesters.id')
                        ->where([
                            ['classes.id', '=', $class_id]
                            ])
                        ->skip(0)->take(1)->get();
        $Twoquarters = DB::table('quarters')
                        ->select(
                            'quarters.name as quarter_name',
                            'quarters.id as quarter_id'
                        )
                        ->leftJoin('semesters', 'semesters.id', '=', 'quarters.semester_id')
                        ->leftJoin('classes', 'classes.semester_id', '=', 'semesters.id')
                        ->where([
                            ['classes.id', '=', $class_id]
                            ])
                        ->skip(1)->take(1)->get();
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

        // All Task Contents
        $OneQOneCs = DB::table('tasks')
                                ->where([
                                    ['class_id', '=', $class_id],
                                    ['quarter_id', '=', $Onequarters->pluck('quarter_id')],
                                    ['component_id', '=', $OneComponents->pluck('component_id')],
                                ])
                                ->get();
        $OneQTwoCs = DB::table('tasks')
                                ->where([
                                    ['class_id', '=', $class_id],
                                    ['quarter_id', '=', $Onequarters->pluck('quarter_id')],
                                    ['component_id', '=', $TwoComponents->pluck('component_id')],
                                    ['task_type', '!=', 'attendance'],
                                ])
                                ->get();
        $OneQTwoCs_attendances = DB::table('tasks')
                                ->where([
                                    ['class_id', '=', $class_id],
                                    ['quarter_id', '=', $Onequarters->pluck('quarter_id')],
                                    ['component_id', '=', $TwoComponents->pluck('component_id')],
                                    ['task_type', '=', 'attendance'],
                                ])
                                ->get();
        $OneQThreeCs = DB::table('tasks')
                                ->where([
                                    ['class_id', '=', $class_id],
                                    ['quarter_id', '=', $Onequarters->pluck('quarter_id')],
                                    ['component_id', '=', $ThreeComponents->pluck('component_id')],
                                ])
                                ->get();
        $TwoQOneCs = DB::table('tasks')
                                ->where([
                                    ['class_id', '=', $class_id],
                                    ['quarter_id', '=', $Twoquarters->pluck('quarter_id')],
                                    ['component_id', '=', $OneComponents->pluck('component_id')],
                                ])
                                ->get();
        $TwoQTwoCs = DB::table('tasks')
                                ->where([
                                    ['class_id', '=', $class_id],
                                    ['quarter_id', '=', $Twoquarters->pluck('quarter_id')],
                                    ['component_id', '=', $TwoComponents->pluck('component_id')],
                                    ['task_type', '!=', 'attendance'],
                                ])
                                ->get();
        $TwoQTwoCs_attendances = DB::table('tasks')
                                ->where([
                                    ['class_id', '=', $class_id],
                                    ['quarter_id', '=', $Twoquarters->pluck('quarter_id')],
                                    ['component_id', '=', $TwoComponents->pluck('component_id')],
                                    ['task_type', '=', 'attendance'],
                                ])
                                ->get();
        $TwoQThreeCs = DB::table('tasks')
                                ->where([
                                    ['class_id', '=', $class_id],
                                    ['quarter_id', '=', $Twoquarters->pluck('quarter_id')],
                                    ['component_id', '=', $ThreeComponents->pluck('component_id')],
                                ])
                                ->get();

        //Fetch Tables For Form
        $Quarters = DB::table('quarters')
                    ->select(
                        'quarters.id as quarter_id',
                        'quarters.name as quarter_name'
                        )
                    ->leftJoin('semesters', 'semesters.id', '=', 'quarters.semester_id')
                    ->leftJoin('classes', 'classes.semester_id', '=', 'semesters.id')
                    ->where([
                        ['classes.id', '=', $class_id]
                        ])
                    ->get();
        $QuarterOptions = $Quarters->pluck('quarter_name', 'quarter_id')->toArray();


        $Components = DB::table('components')
                        ->select(
                            'components.id as component_id',
                            'components.name as component_name',
                            'components.highestWeight as component_weight'
                            )
                        ->leftJoin('subject_types', 'subject_types.id', '=', 'components.subjectType_id')
                        ->leftJoin('subjects', 'subjects.subjectType_id', '=', 'subject_types.id')
                        ->leftJoin('classes', 'classes.subject_id', '=', 'subjects.id')
                        ->where([
                            ['classes.id', '=', $class_id]
                            ])
                        ->get();
        $ComponentOptions = $Components->pluck('component_name', 'component_id')->toArray();


        $Quizzes = DB::table('quizzes')
                    ->select(
                        'quizzes.id as quiz_id',
                        'quizzes.name as quiz_name'
                        )
                    ->leftJoin('users', 'users.id', '=', 'quizzes.user_id')
                    ->where([
                        ['users.id', '=', Auth::user()->id]
                        ])
                    ->get();

        $QuizOptions = array('' => 'Select Quiz') + $Quizzes->pluck('quiz_name', 'quiz_id')->toArray();

        

        return view('class.viewClass.task', [
                    'Class_details'=> $Class_details,
                    'Onequarters'=>$Onequarters, 
                    'Twoquarters'=>$Twoquarters, 
                    'OneComponents'=>$OneComponents,
                    'TwoComponents'=>$TwoComponents,
                    'ThreeComponents'=>$ThreeComponents,
                    'class_id'=>$class_id,
                    'now'=>$now,
                    'now60'=>$now60,
                    'QuarterOptions'=>$QuarterOptions,
                    'ComponentOptions'=>$ComponentOptions,
                    'QuizOptions'=>$QuizOptions,
                    'OneQOneCs'=>$OneQOneCs,
                    'OneQTwoCs'=>$OneQTwoCs,
                    'OneQTwoCs_attendances'=>$OneQTwoCs_attendances,
                    'OneQThreeCs'=>$OneQThreeCs,
                    'TwoQOneCs'=>$TwoQOneCs,
                    'TwoQTwoCs'=>$TwoQTwoCs,
                    'TwoQTwoCs_attendances'=>$TwoQTwoCs_attendances,
                    'TwoQThreeCs'=>$TwoQThreeCs
                    ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($class_id)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $class_id)
    {
        if (Auth::user()->userType_id === 2) {
            $this->validate($request, [
                'name' => 'required',
                'hps' => 'required|numeric',
                'quarter_id' => 'required',
                'component_id' => 'required',
                'submission_id' => 'nullable',
                'task_type' => 'required',
                'allow_from' => 'required',
                'allow_until' => 'required',
                'description' => 'required'
            ]);
    
            $task = new task;
            $task->class_id = $class_id;
            $task->quarter_id = $request->input('quarter_id');
            $task->component_id = $request->input('component_id');
            $task->submission_id = $request->input('submission_id');
            $task->task_type = $request->input('task_type');
            $task->name = $request->input('name');
            $task->allow_from = $request->input('allow_from');
            $task->allow_until = $request->input('allow_until');
            $task->hps = $request->input('hps');
            $task->description = $request->input('description');
            $task->save();
    
            return redirect('/viewClass'.'/'.$class_id.'/task')->with('success', 'Task Added!');
        } elseif(Auth::user()->userType_id == 3){
            
            $this->validate($request, [
                'myResource_location' => 'required|file|max:50000|mimes:pdf,docx,doc,ppt,pptx,xls,xlsx,jpg,jpeg,png',
                'name' => 'required',
                'task_id' => 'required'
            ]);

            // Get filename with the extension
            $filenameWithExt = $request->file('myResource_location')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('myResource_location')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore = $filename.'_'.time().'.'.$extension;
            // Upload Image
            $path = $request->file('myResource_location')->storeAs('public/resources', $fileNameToStore);
            
            $size = $request->file('myResource_location')->getSize();

            $myTask = new myTask;
            $myTask->user_id = Auth::user()->id;
            $myTask->task_id  = $request->input('task_id');
            $myTask->save();

            $myResource = new myResource;
            $myResource->my_task_id = $myTask->id;
            $myResource->name = $request->input('name');
            $myResource->resourceType = $extension;
            $myResource->size = $size;
            $myResource->myResource_location = $fileNameToStore;
            $myResource->save();

            return redirect('/viewClass'.'/'.$class_id.'/task'.'/'.$myTask->task_id)->with('success', 'New File Uploaded!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($class_id, $task)
    {
        //Fetch Tables For Form
        $Quarters = DB::table('quarters')
                    ->select(
                        'quarters.id as quarter_id',
                        'quarters.name as quarter_name'
                        )
                    ->leftJoin('semesters', 'semesters.id', '=', 'quarters.semester_id')
                    ->leftJoin('classes', 'classes.semester_id', '=', 'semesters.id')
                    ->where([
                        ['classes.id', '=', $class_id]
                        ])
                    ->get();
        $QuarterOptions = $Quarters->pluck('quarter_name', 'quarter_id')->toArray();


        $Components = DB::table('components')
                        ->select(
                            'components.id as component_id',
                            'components.name as component_name',
                            'components.highestWeight as component_weight'
                            )
                        ->leftJoin('subject_types', 'subject_types.id', '=', 'components.subjectType_id')
                        ->leftJoin('subjects', 'subjects.subjectType_id', '=', 'subject_types.id')
                        ->leftJoin('classes', 'classes.subject_id', '=', 'subjects.id')
                        ->where([
                            ['classes.id', '=', $class_id]
                            ])
                        ->get();
        $ComponentOptions = $Components->pluck('component_name', 'component_id')->toArray();


        $Quizzes = DB::table('quizzes')
                    ->select(
                        'quizzes.id as quiz_id',
                        'quizzes.name as quiz_name'
                        )
                    ->leftJoin('users', 'users.id', '=', 'quizzes.user_id')
                    ->where([
                        ['users.id', '=', Auth::user()->id]
                        ])
                    ->get();

        $QuizOptions = array('' => 'Select Quiz') + $Quizzes->pluck('quiz_name', 'quiz_id')->toArray();
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
        $tasksdatas = task::find($task);

        $myQuiz_id = myTask::where([
            ['task_id', '=', $task],
            ['user_id', '=', Auth::user()->id],
            ])
            ->pluck('mySubmission_id')
            ->first();

        $myQuiz = myQuiz::find($myQuiz_id);

        $myTaskdatas = myTask::where([
            ['task_id', '=', $task],
            ['user_id', '=', Auth::user()->id],
            ])
            ->first();

        if (isset($myTaskdatas)) {
            $myFile = myResource::where('my_task_id', $myTaskdatas->id)
                        ->first();
        }else{
            $myFile = null;
        }


        return view('class.viewClass.task.detail', [
            'QuarterOptions'=>$QuarterOptions,
            'ComponentOptions'=>$ComponentOptions,
            'QuizOptions'=>$QuizOptions,
            'class_id' => $class_id, 
            'task' => $task,
            'Class_details' => $Class_details,
            'tasksdatas' => $tasksdatas,
            'myTaskdatas' => $myTaskdatas,
            'myFile' => $myFile,
            'myQuiz' => $myQuiz,
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($class_id, $task)
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
    public function update(Request $request, $class_id, $task)
    {
        $this->validate($request, [
            'name' => 'required',
            'hps' => 'required|numeric',
            'quarter_id' => 'required',
            'component_id' => 'required',
            'submission_id' => 'nullable',
            'task_type' => 'required',
            'allow_from' => 'required',
            'allow_until' => 'required',
            'description' => 'required'
        ]);

        $taskdata = task::find($task);
        $taskdata->class_id = $class_id;
        $taskdata->quarter_id = $request->input('quarter_id');
        $taskdata->component_id = $request->input('component_id');
        $taskdata->submission_id = $request->input('submission_id');
        $taskdata->task_type = $request->input('task_type');
        $taskdata->name = $request->input('name');
        $taskdata->allow_from = $request->input('allow_from');
        $taskdata->allow_until = $request->input('allow_until');
        $taskdata->hps = $request->input('hps');
        $taskdata->description = $request->input('description');
        $taskdata->save();

        return redirect('/viewClass'.'/'.$class_id.'/task')->with('success', $taskdata->name.'Task Edited!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($class_id, $task)
    {
        if (Auth::user()->userType_id === 2) {
            $tasksdatas = task::find($task);
            $tasksdatas->delete();
            return redirect('/viewClass'.'/'.$class_id.'/task')->with('success', 'Task Removed!');
        } elseif(Auth::user()->userType_id == 3) {
            $myTaskdatas = myTask::where([
                ['task_id', '=', $task],
                ['user_id', '=', Auth::user()->id],
                ])
                ->first();

            $myFile = myResource::where('my_task_id', $myTaskdatas->id)
                            ->first();

            Storage::delete('public/resources'.$myFile->myResource_location);
            $myFile->delete();
            $myTaskdatas->delete();

            return redirect('/viewClass'.'/'.$class_id.'/task'.'/'.$task)->with('success', 'File Removed!');
        }
    }
}
