<?php

namespace App\Http\Controllers;

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

class PagesController extends Controller
{
    #---------------
    #|    Home     |
    #---------------
    //index//
    public function welcome(){
        return view('pages.welcome');
    }
    public function home(){
        return view('pages.home');
    }
    //-------------------

    #---------------
    #|   2class    |
    #---------------


    /* student class view */

    public function completed(){
        $completedClasses = DB::table('classes')
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
                                ['classes.progress', '=', 'completed']
                                ])
                            ->get();
        $Parent_completedClasses = DB::table('classes')
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
                                ['users.id', '=', Auth::user()->child_id],
                                ['classes.progress', '=', 'completed']
                                ])
                            ->get();
        return view('class.completedClass', ['completedClasses'=> $completedClasses, 'Parent_completedClasses'=> $Parent_completedClasses]);
    }

    //View Class (Lesson)
    public function viewClass($id){
        $class_id = $id;
        $components = DB::table('components')
                        ->select(
                            'components.id as component_id',
                            'components.name as component_name',
                            'components.highestWeight as component_weight'
                            )
                        ->leftJoin('subject_types', 'subject_types.id', '=', 'components.subjectType_id')
                        ->leftJoin('subjects', 'subjects.subjectType_id', '=', 'subject_types.id')
                        ->leftJoin('classes', 'classes.subject_id', '=', 'subjects.id')
                        ->where([
                            ['classes.id', '=', $id]
                            ])
                        ->get();
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
                            ['classes.id', '=', $id]
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
                            ['classes.id', '=', $id]
                            ])
                        ->skip(0)->take(1)->get();
        $Twoquarters = DB::table('quarters')
                        ->select(
                            'quarters.name as quarter_name',
                            'quarters.id as quarter_id')
                        ->leftJoin('semesters', 'semesters.id', '=', 'quarters.semester_id')
                        ->leftJoin('classes', 'classes.semester_id', '=', 'semesters.id')
                        ->where([
                            ['classes.id', '=', $id]
                            ])
                        ->skip(1)->take(1)->get();

        // All Task Contents
        $OneQOneCs = DB::table('tasks')
                                ->where([
                                    ['class_id', '=', $class_id],
                                    ['quarter_id', '=', $Onequarters->pluck('quarter_id')],
                                    ['component_id', '=', $OneComponents->pluck('component_id')],
                                ])
                                ->get();
        $OneQOneCs_sum = DB::table('tasks')
                                ->where([
                                    ['class_id', '=', $class_id],
                                    ['quarter_id', '=', $Onequarters->pluck('quarter_id')],
                                    ['component_id', '=', $OneComponents->pluck('component_id')],
                                ])
                                ->sum('hps');
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
        $OneQTwoCs_sum = DB::table('tasks')
                                ->where([
                                    ['class_id', '=', $class_id],
                                    ['quarter_id', '=', $Onequarters->pluck('quarter_id')],
                                    ['component_id', '=', $TwoComponents->pluck('component_id')],
                                ])
                                ->sum('hps');
        $OneQThreeCs = DB::table('tasks')
                                ->where([
                                    ['class_id', '=', $class_id],
                                    ['quarter_id', '=', $Onequarters->pluck('quarter_id')],
                                    ['component_id', '=', $ThreeComponents->pluck('component_id')],
                                ])
                                ->get();
        $OneQThreeCs_sum = DB::table('tasks')
                                ->where([
                                    ['class_id', '=', $class_id],
                                    ['quarter_id', '=', $Onequarters->pluck('quarter_id')],
                                    ['component_id', '=', $ThreeComponents->pluck('component_id')],
                                ])
                                ->sum('hps');
        $TwoQOneCs = DB::table('tasks')
                                ->where([
                                    ['class_id', '=', $class_id],
                                    ['quarter_id', '=', $Twoquarters->pluck('quarter_id')],
                                    ['component_id', '=', $OneComponents->pluck('component_id')],
                                ])
                                ->get();
        $TwoQOneCs_sum = DB::table('tasks')
                                ->where([
                                    ['class_id', '=', $class_id],
                                    ['quarter_id', '=', $Twoquarters->pluck('quarter_id')],
                                    ['component_id', '=', $OneComponents->pluck('component_id')],
                                ])
                                ->sum('hps');
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
        $TwoQTwoCs_sum = DB::table('tasks')
                                ->where([
                                    ['class_id', '=', $class_id],
                                    ['quarter_id', '=', $Twoquarters->pluck('quarter_id')],
                                    ['component_id', '=', $TwoComponents->pluck('component_id')],
                                ])
                                ->sum('hps');
        $TwoQThreeCs = DB::table('tasks')
                                ->where([
                                    ['class_id', '=', $class_id],
                                    ['quarter_id', '=', $Twoquarters->pluck('quarter_id')],
                                    ['component_id', '=', $ThreeComponents->pluck('component_id')],
                                ])
                                ->get();
        $TwoQThreeCs_sum = DB::table('tasks')
                                ->where([
                                    ['class_id', '=', $class_id],
                                    ['quarter_id', '=', $Twoquarters->pluck('quarter_id')],
                                    ['component_id', '=', $ThreeComponents->pluck('component_id')],
                                ])
                                ->sum('hps');

        // Lessons
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
                                ['classes.id', '=', $id]
                                ])
                            ->get();
        $Lessons = DB::table('lessons')
                        ->select(
                            'lessons.lessonPic_location',
                            'lessons.id as lesson_id',
                            'lessons.name as lesson_name',
                            'lessons.description as lesson_desc'
                            )
                        ->where('lessons.class_id', '=', $id)
                        ->get();

        
        return view('class.viewClass', [
            'Class_details'=> $Class_details, 
            'Onequarters'=>$Onequarters, 
            'Twoquarters'=>$Twoquarters, 
            'components'=>$components,
            'OneComponents'=>$OneComponents,
            'TwoComponents'=>$TwoComponents,
            'ThreeComponents'=>$ThreeComponents,
            'OneQOneCs'=>$OneQOneCs,
            'OneQOneCs_sum'=>$OneQOneCs_sum,
            'OneQTwoCs'=>$OneQTwoCs,
            'OneQTwoCs_attendances'=>$OneQTwoCs_attendances,
            'OneQTwoCs_sum'=>$OneQTwoCs_sum,
            'OneQThreeCs'=>$OneQThreeCs,
            'OneQThreeCs_sum'=>$OneQThreeCs_sum,
            'TwoQOneCs'=>$TwoQOneCs,
            'TwoQOneCs_sum'=>$TwoQOneCs_sum,
            'TwoQTwoCs'=>$TwoQTwoCs,
            'TwoQTwoCs_attendances'=>$TwoQTwoCs_attendances,
            'TwoQTwoCs_sum'=>$TwoQTwoCs_sum,
            'TwoQThreeCs'=>$TwoQThreeCs,
            'TwoQThreeCs_sum'=>$TwoQThreeCs_sum,
            'class_id'=>$class_id,
            'Lessons'=>$Lessons
            ]);
    }
    //-----------------



}
