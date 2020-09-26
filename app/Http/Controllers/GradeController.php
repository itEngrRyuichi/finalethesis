<?php

namespace App\Http\Controllers;

use App\User;
use App\enrollment;
use App\Clas;
use App\Subject;
use App\Component;
use App\SubjectType;
use App\task;
use App\Grade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Auth;

class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($class_id)
    {
        //-----------CLASS DETAILS FOR CLASS NAV--------------------
        if (Auth::user()->userType_id == 4) {
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
                                ['users.id', '=', Auth::user()->child_id],
                                ['classes.id', '=', $class_id]
                                ])
                            ->get();
        }else{
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
        }

        //-----------TEACHER STUDENT LISTS--------------------

        if (Auth::user()->userType_id == 2) {
            $Onequarter = DB::table('quarters')
                                ->select(
                                    'quarters.name as quarter_name'
                                )
                                ->leftJoin('semesters', 'semesters.id', '=', 'quarters.semester_id')
                                ->leftJoin('classes', 'classes.semester_id', '=', 'semesters.id')
                                ->where([
                                    ['classes.id', '=', $class_id]
                                    ])
                                ->skip(0)->take(1)->pluck('quarter_name')->first();
            $Twoquarter = DB::table('quarters')
                                ->select(
                                    'quarters.name as quarter_name'
                                    )
                                ->leftJoin('semesters', 'semesters.id', '=', 'quarters.semester_id')
                                ->leftJoin('classes', 'classes.semester_id', '=', 'semesters.id')
                                ->where([
                                    ['classes.id', '=', $class_id]
                                    ])
                                ->skip(1)->take(1)->pluck('quarter_name')->first();
            $Onequarter_id = DB::table('quarters')       
                                    ->leftJoin('semesters', 'semesters.id', '=', 'quarters.semester_id')
                                    ->leftJoin('classes', 'classes.semester_id', '=', 'semesters.id')
                                    ->where([
                                        ['classes.id', '=', $class_id]
                                        ])
                                    ->pluck('quarters.id')[0];
            $Twoquarter_id = DB::table('quarters')       
                                    ->leftJoin('semesters', 'semesters.id', '=', 'quarters.semester_id')
                                    ->leftJoin('classes', 'classes.semester_id', '=', 'semesters.id')
                                    ->where([
                                        ['classes.id', '=', $class_id]
                                        ])
                                    ->pluck('quarters.id')[1];

            $students = DB::table('enrollments')
                                    ->select(
                                        'users.school_id',
                                        'users.id as user_id',
                                        'users.name as user_name',
                                        'first_grades.myQuarterlyGrade as first',
                                        'second_grades.myQuarterlyGrade as second',
                                        DB::raw("((first_grades.myQuarterlyGrade + second_grades.myQuarterlyGrade)/2 ) as final")
                                        )
                                    ->join('users', 'users.id', '=', 'enrollments.user_id')
                                    ->join('grades as first_grades', 'enrollments.id', '=', 'first_grades.enrollment_id')
                                    ->join('grades as second_grades', 'enrollments.id', '=', 'second_grades.enrollment_id')
                                    ->where([
                                        ['class_id', '=', $class_id],
                                        ['user_id', '!=', Auth::user()->id],
                                        ['first_grades.quarter_id', '=', $Onequarter_id],
                                        ['second_grades.quarter_id', '=', $Twoquarter_id]
                                        ])
                                    ->get();

            return view('class.viewClass.classGrade', [
                'Class_details'=>$Class_details,
                'class_id'=>$class_id,
                'students'=>$students,
                'Onequarter'=>$Onequarter,
                'Twoquarter'=>$Twoquarter
                ]);
        } else{
        //-----------GRADES DETAILS P AND S--------------------
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
                                ['classes.id', '=', $class_id]
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
                                    'quarters.id as quarter_id')
                                ->leftJoin('semesters', 'semesters.id', '=', 'quarters.semester_id')
                                ->leftJoin('classes', 'classes.semester_id', '=', 'semesters.id')
                                ->where([
                                    ['classes.id', '=', $class_id]
                                    ])
                                ->skip(1)->take(1)->get();
        
            if (Auth::user()->userType_id == 4) {
                $enrollment_id = enrollment::where([
                    ['class_id', '=', $class_id],
                    ['user_id', '=', Auth::user()->child_id],
                    ])
                    ->pluck('id')
                    ->first();
            } elseif(Auth::user()->userType_id == 3) {
                $enrollment_id = enrollment::where([
                    ['class_id', '=', $class_id],
                    ['user_id', '=', Auth::user()->id],
                    ])
                    ->pluck('id')
                    ->first();
            }

            $Onequarter_id = DB::table('quarters')       
                                    ->leftJoin('semesters', 'semesters.id', '=', 'quarters.semester_id')
                                    ->leftJoin('classes', 'classes.semester_id', '=', 'semesters.id')
                                    ->where([
                                        ['classes.id', '=', $class_id]
                                        ])
                                    ->pluck('quarters.id')[0];

            $Twoquarter_id = DB::table('quarters')       
                                    ->leftJoin('semesters', 'semesters.id', '=', 'quarters.semester_id')
                                    ->leftJoin('classes', 'classes.semester_id', '=', 'semesters.id')
                                    ->where([
                                        ['classes.id', '=', $class_id]
                                        ])
                                    ->pluck('quarters.id')[1];

            
            $One_final = DB::table('grades')
                            ->where([
                                ['enrollment_id', '=', $enrollment_id],
                                ['quarter_id', '=', $Onequarter_id],
                                ])
                                ->pluck('myQuarterlyGrade')->first();
            if(!isset($One_final)){
                $One_final = 0;
            }
            $Two_final = Grade::where([
                                    ['enrollment_id', '=', $enrollment_id],
                                    ['quarter_id', '=', $Twoquarter_id],
                                    ])
                                    ->pluck('myQuarterlyGrade')->first();
            if(!isset($Two_final)){
                $Two_final = 0;
            }
            
            if(($One_final + $Two_final) > 0){
                $final_grade = ($One_final + $Two_final)/2;
            }else{
                $final_grade = "N/A";
            }

        //-----------GRADES DETAILS STUDENTS--------------------
            if(Auth::user()->userType_id == 3) {
                    // All Task Contents
                    $OneQOneCs = DB::table('tasks')
                                            ->select(
                                                'tasks.name as task_name',
                                                'tasks.task_type',
                                                'my_tasks.myScore',
                                                'tasks.hps',
                                                (DB::raw('(my_tasks.myScore / tasks.hps) * 100 as Per'))
                                                )
                                            ->join('my_tasks', 'tasks.id', '=', 'my_tasks.task_id')
                                            ->where([
                                                ['class_id', '=', $class_id],
                                                ['quarter_id', '=', $Onequarters->pluck('quarter_id')],
                                                ['component_id', '=', $OneComponents->pluck('component_id')],
                                                ['my_tasks.user_id', '=', Auth::user()->id]
                                            ])
                                            ->get();

                    $OneQTwoCs = DB::table('tasks')
                                            ->select(
                                                'tasks.name as task_name',
                                                'tasks.task_type',
                                                'my_tasks.myScore',
                                                'tasks.hps',
                                                DB::raw('(my_tasks.myScore / tasks.hps) * 100 as Per')
                                                )
                                            ->join('my_tasks', 'tasks.id', '=', 'my_tasks.task_id')
                                            ->where([
                                                ['class_id', '=', $class_id],
                                                ['quarter_id', '=', $Onequarters->pluck('quarter_id')],
                                                ['component_id', '=', $TwoComponents->pluck('component_id')],
                                                ['task_type', '!=', 'attendance'],
                                                ['my_tasks.user_id', '=', Auth::user()->id]
                                            ])
                                            ->get();

                    $OneQTwoCs_attendances = DB::table('tasks')
                                            ->select(
                                                'tasks.name as task_name',
                                                'tasks.task_type',
                                                'my_tasks.myScore',
                                                'tasks.hps',
                                                DB::raw('(my_tasks.myScore / tasks.hps) * 100 as Per')
                                                )
                                            ->join('my_tasks', 'tasks.id', '=', 'my_tasks.task_id')
                                            ->where([
                                                ['class_id', '=', $class_id],
                                                ['quarter_id', '=', $Onequarters->pluck('quarter_id')],
                                                ['component_id', '=', $TwoComponents->pluck('component_id')],
                                                ['task_type', '=', 'attendance'],
                                                ['my_tasks.user_id', '=', Auth::user()->id]
                                            ])
                                            ->get();

                    $OneQThreeCs = DB::table('tasks')
                                            ->select(
                                                'tasks.name as task_name',
                                                'tasks.task_type',
                                                'my_tasks.myScore',
                                                'tasks.hps',
                                                DB::raw('(my_tasks.myScore / tasks.hps) * 100 as Per')
                                                )
                                            ->join('my_tasks', 'tasks.id', '=', 'my_tasks.task_id')
                                            ->where([
                                                ['class_id', '=', $class_id],
                                                ['quarter_id', '=', $Onequarters->pluck('quarter_id')],
                                                ['component_id', '=', $ThreeComponents->pluck('component_id')],
                                                ['my_tasks.user_id', '=', Auth::user()->id]
                                            ])
                                            ->get();
                    $TwoQOneCs = DB::table('tasks')
                                            ->select(
                                                'tasks.name as task_name',
                                                'tasks.task_type',
                                                'my_tasks.myScore',
                                                'tasks.hps',
                                                DB::raw('(my_tasks.myScore / tasks.hps) * 100 as Per')
                                                )
                                            ->join('my_tasks', 'tasks.id', '=', 'my_tasks.task_id')
                                            ->where([
                                                ['class_id', '=', $class_id],
                                                ['quarter_id', '=', $Twoquarters->pluck('quarter_id')],
                                                ['component_id', '=', $OneComponents->pluck('component_id')],
                                                ['my_tasks.user_id', '=', Auth::user()->id]
                                            ])
                                            ->get();
                    $TwoQTwoCs = DB::table('tasks')
                                            ->select(
                                                'tasks.name as task_name',
                                                'tasks.task_type',
                                                'my_tasks.myScore',
                                                'tasks.hps',
                                                DB::raw('(my_tasks.myScore / tasks.hps) * 100 as Per')
                                                )
                                            ->join('my_tasks', 'tasks.id', '=', 'my_tasks.task_id')
                                            ->where([
                                                ['class_id', '=', $class_id],
                                                ['quarter_id', '=', $Twoquarters->pluck('quarter_id')],
                                                ['component_id', '=', $TwoComponents->pluck('component_id')],
                                                ['task_type', '!=', 'attendance'],
                                                ['my_tasks.user_id', '=', Auth::user()->id]
                                            ])
                                            ->get();
                    $TwoQTwoCs_attendances = DB::table('tasks')
                                            ->select(
                                                'tasks.name as task_name',
                                                'tasks.task_type',
                                                'my_tasks.myScore',
                                                'tasks.hps',
                                                DB::raw('(my_tasks.myScore / tasks.hps) * 100 as Per')
                                                )
                                            ->join('my_tasks', 'tasks.id', '=', 'my_tasks.task_id')
                                            ->where([
                                                ['class_id', '=', $class_id],
                                                ['quarter_id', '=', $Twoquarters->pluck('quarter_id')],
                                                ['component_id', '=', $TwoComponents->pluck('component_id')],
                                                ['task_type', '=', 'attendance'],
                                                ['my_tasks.user_id', '=', Auth::user()->id]
                                            ])
                                            ->get();
                    $TwoQThreeCs = DB::table('tasks')
                                            ->select(
                                                'tasks.name as task_name',
                                                'tasks.task_type',
                                                'my_tasks.myScore',
                                                'tasks.hps',
                                                DB::raw('(my_tasks.myScore / tasks.hps) * 100 as Per')
                                                )
                                            ->join('my_tasks', 'tasks.id', '=', 'my_tasks.task_id')
                                            ->where([
                                                ['class_id', '=', $class_id],
                                                ['quarter_id', '=', $Twoquarters->pluck('quarter_id')],
                                                ['component_id', '=', $ThreeComponents->pluck('component_id')],
                                                ['my_tasks.user_id', '=', Auth::user()->id]
                                            ])
                                            ->get();
                    //component weight
                    $OneComp_weight = DB::table('components')
                                            ->leftJoin('subject_types', 'subject_types.id', '=', 'components.subjectType_id')
                                            ->leftJoin('subjects', 'subjects.subjectType_id', '=', 'subject_types.id')
                                            ->leftJoin('classes', 'classes.subject_id', '=', 'subjects.id')
                                            ->where([
                                                ['classes.id', '=', $class_id]
                                                ])
                                            ->skip(0)->take(1)->pluck('components.highestWeight')->first();
                    $TwoComp_weight = DB::table('components')
                                            ->leftJoin('subject_types', 'subject_types.id', '=', 'components.subjectType_id')
                                            ->leftJoin('subjects', 'subjects.subjectType_id', '=', 'subject_types.id')
                                            ->leftJoin('classes', 'classes.subject_id', '=', 'subjects.id')
                                            ->where([
                                                ['classes.id', '=', $class_id]
                                                ])
                                            ->skip(1)->take(1)->pluck('components.highestWeight')->first();
                    $ThreeComp_weight = DB::table('components')
                                            ->leftJoin('subject_types', 'subject_types.id', '=', 'components.subjectType_id')
                                            ->leftJoin('subjects', 'subjects.subjectType_id', '=', 'subject_types.id')
                                            ->leftJoin('classes', 'classes.subject_id', '=', 'subjects.id')
                                            ->where([
                                                ['classes.id', '=', $class_id]
                                                ])
                                            ->skip(2)->take(1)->pluck('components.highestWeight')->first();

                    //sum
                    $OneQOneCs_my_sum = DB::table('tasks')
                                            ->join('my_tasks', 'tasks.id', '=', 'my_tasks.task_id')
                                            ->where([
                                                ['class_id', '=', $class_id],
                                                ['quarter_id', '=', $Onequarters->pluck('quarter_id')],
                                                ['component_id', '=', $OneComponents->pluck('component_id')],
                                                ['my_tasks.user_id', '=', Auth::user()->id]
                                            ])
                                            ->sum(DB::raw('(my_tasks.myScore / tasks.hps) * 100'));
                    $OneQOneCs_my_count = DB::table('tasks')
                                            ->join('my_tasks', 'tasks.id', '=', 'my_tasks.task_id')
                                            ->where([
                                                ['class_id', '=', $class_id],
                                                ['quarter_id', '=', $Onequarters->pluck('quarter_id')],
                                                ['component_id', '=', $OneComponents->pluck('component_id')],
                                                ['my_tasks.user_id', '=', Auth::user()->id]
                                            ])
                                            ->count(DB::raw('(my_tasks.myScore / tasks.hps) * 100'));

                    
                    if ($OneQOneCs_my_count != 0) {
                        $OneQOneCs_result = ($OneQOneCs_my_sum / $OneQOneCs_my_count) * 0.01 * $OneComp_weight;
                        $OneQOneCsResult = round($OneQOneCs_result, 2);
                    } else {
                        $OneQOneCsResult = 0;
                    }
                    
                    $OneQTwoCs_my_sum = DB::table('tasks')
                                            ->join('my_tasks', 'tasks.id', '=', 'my_tasks.task_id')
                                            ->where([
                                                ['class_id', '=', $class_id],
                                                ['quarter_id', '=', $Onequarters->pluck('quarter_id')],
                                                ['component_id', '=', $TwoComponents->pluck('component_id')],
                                                ['my_tasks.user_id', '=', Auth::user()->id]
                                            ])
                                            ->sum(DB::raw('(my_tasks.myScore / tasks.hps) * 100'));
                    $OneQTwoCs_my_count = DB::table('tasks')
                                            ->join('my_tasks', 'tasks.id', '=', 'my_tasks.task_id')
                                            ->where([
                                                ['class_id', '=', $class_id],
                                                ['quarter_id', '=', $Onequarters->pluck('quarter_id')],
                                                ['component_id', '=', $TwoComponents->pluck('component_id')],
                                                ['my_tasks.user_id', '=', Auth::user()->id]
                                            ])
                                            ->count(DB::raw('(my_tasks.myScore / tasks.hps) * 100'));
                    if ($OneQTwoCs_my_count != 0) {
                        $OneQTwoCs_result = ($OneQTwoCs_my_sum / $OneQTwoCs_my_count) * 0.01 * $TwoComp_weight;
                        $OneQTwoCsResult = round($OneQTwoCs_result, 2);
                    } else {
                        $OneQTwoCsResult = 0;
                    }
                    $OneQThreeCs_my_sum = DB::table('tasks')
                                            ->join('my_tasks', 'tasks.id', '=', 'my_tasks.task_id')
                                            ->where([
                                                ['class_id', '=', $class_id],
                                                ['quarter_id', '=', $Onequarters->pluck('quarter_id')],
                                                ['component_id', '=', $ThreeComponents->pluck('component_id')],
                                                ['my_tasks.user_id', '=', Auth::user()->id]
                                            ])
                                            ->sum(DB::raw('(my_tasks.myScore / tasks.hps) * 100'));
                    $OneQThreeCs_my_count = DB::table('tasks')
                                            ->join('my_tasks', 'tasks.id', '=', 'my_tasks.task_id')
                                            ->where([
                                                ['class_id', '=', $class_id],
                                                ['quarter_id', '=', $Onequarters->pluck('quarter_id')],
                                                ['component_id', '=', $ThreeComponents->pluck('component_id')],
                                                ['my_tasks.user_id', '=', Auth::user()->id]
                                            ])
                                            ->count(DB::raw('(my_tasks.myScore / tasks.hps) * 100'));
                    if ($OneQThreeCs_my_count != 0) {
                        $OneQThreeCs_result = ($OneQThreeCs_my_sum / $OneQThreeCs_my_count) * 0.01 * $ThreeComp_weight;
                        $OneQThreeCsResult = round($OneQThreeCs_result, 2);
                    } else {
                        $OneQThreeCsResult = 0;
                    }

                    $One_initial = $OneQOneCsResult + $OneQTwoCsResult + $OneQThreeCsResult;

                    $TwoQOneCs_my_sum = DB::table('tasks')
                                            ->join('my_tasks', 'tasks.id', '=', 'my_tasks.task_id')
                                            ->where([
                                                ['class_id', '=', $class_id],
                                                ['quarter_id', '=', $Twoquarters->pluck('quarter_id')],
                                                ['component_id', '=', $OneComponents->pluck('component_id')],
                                                ['my_tasks.user_id', '=', Auth::user()->id]
                                            ])
                                            ->sum(DB::raw('(my_tasks.myScore / tasks.hps) * 100'));
                    $TwoQOneCs_my_count = DB::table('tasks')
                                            ->join('my_tasks', 'tasks.id', '=', 'my_tasks.task_id')
                                            ->where([
                                                ['class_id', '=', $class_id],
                                                ['quarter_id', '=', $Twoquarters->pluck('quarter_id')],
                                                ['component_id', '=', $OneComponents->pluck('component_id')],
                                                ['my_tasks.user_id', '=', Auth::user()->id]
                                            ])
                                            ->count(DB::raw('(my_tasks.myScore / tasks.hps) * 100'));
                    if ($TwoQOneCs_my_count != 0) {
                        $TwoQOneCs_result = ($TwoQOneCs_my_sum / $TwoQOneCs_my_count) * 0.01 * $OneComp_weight;
                        $TwoQOneCsResult = round($TwoQOneCs_result, 2);
                    } else {
                        $TwoQOneCsResult = 0;
                    }
                    $TwoQTwoCs_my_sum = DB::table('tasks')
                                            ->join('my_tasks', 'tasks.id', '=', 'my_tasks.task_id')
                                            ->where([
                                                ['class_id', '=', $class_id],
                                                ['quarter_id', '=', $Twoquarters->pluck('quarter_id')],
                                                ['component_id', '=', $TwoComponents->pluck('component_id')],
                                                ['my_tasks.user_id', '=', Auth::user()->id]
                                            ])
                                            ->sum(DB::raw('(my_tasks.myScore / tasks.hps) * 100'));
                    $TwoQTwoCs_my_count = DB::table('tasks')
                                            ->join('my_tasks', 'tasks.id', '=', 'my_tasks.task_id')
                                            ->where([
                                                ['class_id', '=', $class_id],
                                                ['quarter_id', '=', $Twoquarters->pluck('quarter_id')],
                                                ['component_id', '=', $TwoComponents->pluck('component_id')],
                                                ['my_tasks.user_id', '=', Auth::user()->id]
                                            ])
                                            ->count(DB::raw('(my_tasks.myScore / tasks.hps) * 100'));
                    if ($TwoQTwoCs_my_count != 0) {
                        $TwoQTwoCs_result = ($TwoQTwoCs_my_sum / $TwoQTwoCs_my_count) * 0.01 * $TwoComp_weight;
                        $TwoQTwoCsResult = round($TwoQTwoCs_result, 2);
                    } else {
                        $TwoQTwoCsResult = 0;
                    }
                    $TwoQThreeCs_my_sum = DB::table('tasks')
                                            ->join('my_tasks', 'tasks.id', '=', 'my_tasks.task_id')
                                            ->where([
                                                ['class_id', '=', $class_id],
                                                ['quarter_id', '=', $Twoquarters->pluck('quarter_id')],
                                                ['component_id', '=', $ThreeComponents->pluck('component_id')],
                                                ['my_tasks.user_id', '=', Auth::user()->id]
                                            ])
                                            ->sum(DB::raw('(my_tasks.myScore / tasks.hps) * 100'));
                    $TwoQThreeCs_my_count = DB::table('tasks')
                                            ->join('my_tasks', 'tasks.id', '=', 'my_tasks.task_id')
                                            ->where([
                                                ['class_id', '=', $class_id],
                                                ['quarter_id', '=', $Twoquarters->pluck('quarter_id')],
                                                ['component_id', '=', $ThreeComponents->pluck('component_id')],
                                                ['my_tasks.user_id', '=', Auth::user()->id]
                                            ])
                                            ->count(DB::raw('(my_tasks.myScore / tasks.hps) * 100'));
                    if ($TwoQThreeCs_my_count != 0) {
                        $TwoQThreeCs_result = ($TwoQThreeCs_my_sum / $TwoQThreeCs_my_count) * 0.01 * $ThreeComp_weight;
                        $TwoQThreeCsResult = round($TwoQThreeCs_result, 2);
                    } else {
                        $TwoQThreeCsResult = 0;
                    }

                    $Two_initial = $TwoQOneCsResult + $TwoQTwoCsResult + $TwoQThreeCsResult;
            //-----------GRADES DETAILS PARENTS--------------------
            } elseif(Auth::user()->userType_id == 4) {
                    // All Task Contents
                    $OneQOneCs = DB::table('tasks')
                                            ->select(
                                                'tasks.name as task_name',
                                                'tasks.task_type',
                                                'my_tasks.myScore',
                                                'tasks.hps',
                                                DB::raw('(my_tasks.myScore / tasks.hps) * 100 as Per')
                                                )
                                            ->join('my_tasks', 'tasks.id', '=', 'my_tasks.task_id')
                                            ->where([
                                                ['class_id', '=', $class_id],
                                                ['quarter_id', '=', $Onequarters->pluck('quarter_id')],
                                                ['component_id', '=', $OneComponents->pluck('component_id')],
                                                ['my_tasks.user_id', '=', Auth::user()->child_id]
                                            ])
                                            ->get();

                    $OneQTwoCs = DB::table('tasks')
                                            ->select(
                                                'tasks.name as task_name',
                                                'tasks.task_type',
                                                'my_tasks.myScore',
                                                'tasks.hps',
                                                DB::raw('(my_tasks.myScore / tasks.hps) * 100 as Per')
                                                )
                                            ->join('my_tasks', 'tasks.id', '=', 'my_tasks.task_id')
                                            ->where([
                                                ['class_id', '=', $class_id],
                                                ['quarter_id', '=', $Onequarters->pluck('quarter_id')],
                                                ['component_id', '=', $TwoComponents->pluck('component_id')],
                                                ['task_type', '!=', 'attendance'],
                                                ['my_tasks.user_id', '=', Auth::user()->child_id]
                                            ])
                                            ->get();

                    $OneQTwoCs_attendances = DB::table('tasks')
                                            ->select(
                                                'tasks.name as task_name',
                                                'tasks.task_type',
                                                'my_tasks.myScore',
                                                'tasks.hps',
                                                DB::raw('(my_tasks.myScore / tasks.hps) * 100 as Per')
                                                )
                                            ->join('my_tasks', 'tasks.id', '=', 'my_tasks.task_id')
                                            ->where([
                                                ['class_id', '=', $class_id],
                                                ['quarter_id', '=', $Onequarters->pluck('quarter_id')],
                                                ['component_id', '=', $TwoComponents->pluck('component_id')],
                                                ['task_type', '=', 'attendance'],
                                                ['my_tasks.user_id', '=', Auth::user()->child_id]
                                            ])
                                            ->get();

                    $OneQThreeCs = DB::table('tasks')
                                            ->select(
                                                'tasks.name as task_name',
                                                'tasks.task_type',
                                                'my_tasks.myScore',
                                                'tasks.hps',
                                                DB::raw('(my_tasks.myScore / tasks.hps) * 100 as Per')
                                                )
                                            ->join('my_tasks', 'tasks.id', '=', 'my_tasks.task_id')
                                            ->where([
                                                ['class_id', '=', $class_id],
                                                ['quarter_id', '=', $Onequarters->pluck('quarter_id')],
                                                ['component_id', '=', $ThreeComponents->pluck('component_id')],
                                                ['my_tasks.user_id', '=', Auth::user()->child_id]
                                            ])
                                            ->get();
                    $TwoQOneCs = DB::table('tasks')
                                            ->select(
                                                'tasks.name as task_name',
                                                'tasks.task_type',
                                                'my_tasks.myScore',
                                                'tasks.hps',
                                                DB::raw('(my_tasks.myScore / tasks.hps) * 100 as Per')
                                                )
                                            ->join('my_tasks', 'tasks.id', '=', 'my_tasks.task_id')
                                            ->where([
                                                ['class_id', '=', $class_id],
                                                ['quarter_id', '=', $Twoquarters->pluck('quarter_id')],
                                                ['component_id', '=', $OneComponents->pluck('component_id')],
                                                ['my_tasks.user_id', '=', Auth::user()->child_id]
                                            ])
                                            ->get();
                    $TwoQTwoCs = DB::table('tasks')
                                            ->select(
                                                'tasks.name as task_name',
                                                'tasks.task_type',
                                                'my_tasks.myScore',
                                                'tasks.hps',
                                                DB::raw('(my_tasks.myScore / tasks.hps) * 100 as Per')
                                                )
                                            ->join('my_tasks', 'tasks.id', '=', 'my_tasks.task_id')
                                            ->where([
                                                ['class_id', '=', $class_id],
                                                ['quarter_id', '=', $Twoquarters->pluck('quarter_id')],
                                                ['component_id', '=', $TwoComponents->pluck('component_id')],
                                                ['task_type', '!=', 'attendance'],
                                                ['my_tasks.user_id', '=', Auth::user()->child_id]
                                            ])
                                            ->get();
                    $TwoQTwoCs_attendances = DB::table('tasks')
                                            ->select(
                                                'tasks.name as task_name',
                                                'tasks.task_type',
                                                'my_tasks.myScore',
                                                'tasks.hps',
                                                DB::raw('(my_tasks.myScore / tasks.hps) * 100 as Per')
                                                )
                                            ->join('my_tasks', 'tasks.id', '=', 'my_tasks.task_id')
                                            ->where([
                                                ['class_id', '=', $class_id],
                                                ['quarter_id', '=', $Twoquarters->pluck('quarter_id')],
                                                ['component_id', '=', $TwoComponents->pluck('component_id')],
                                                ['task_type', '=', 'attendance'],
                                                ['my_tasks.user_id', '=', Auth::user()->child_id]
                                            ])
                                            ->get();
                    $TwoQThreeCs = DB::table('tasks')
                                            ->select(
                                                'tasks.name as task_name',
                                                'tasks.task_type',
                                                'my_tasks.myScore',
                                                'tasks.hps',
                                                DB::raw('(my_tasks.myScore / tasks.hps) * 100 as Per')
                                                )
                                            ->join('my_tasks', 'tasks.id', '=', 'my_tasks.task_id')
                                            ->where([
                                                ['class_id', '=', $class_id],
                                                ['quarter_id', '=', $Twoquarters->pluck('quarter_id')],
                                                ['component_id', '=', $ThreeComponents->pluck('component_id')],
                                                ['my_tasks.user_id', '=', Auth::user()->child_id]
                                            ])
                                            ->get();
                    //component weight
                    $OneComp_weight = DB::table('components')
                                            ->leftJoin('subject_types', 'subject_types.id', '=', 'components.subjectType_id')
                                            ->leftJoin('subjects', 'subjects.subjectType_id', '=', 'subject_types.id')
                                            ->leftJoin('classes', 'classes.subject_id', '=', 'subjects.id')
                                            ->where([
                                                ['classes.id', '=', $class_id]
                                                ])
                                            ->skip(0)->take(1)->pluck('components.highestWeight')->first();
                    $TwoComp_weight = DB::table('components')
                                            ->leftJoin('subject_types', 'subject_types.id', '=', 'components.subjectType_id')
                                            ->leftJoin('subjects', 'subjects.subjectType_id', '=', 'subject_types.id')
                                            ->leftJoin('classes', 'classes.subject_id', '=', 'subjects.id')
                                            ->where([
                                                ['classes.id', '=', $class_id]
                                                ])
                                            ->skip(1)->take(1)->pluck('components.highestWeight')->first();
                    $ThreeComp_weight = DB::table('components')
                                            ->leftJoin('subject_types', 'subject_types.id', '=', 'components.subjectType_id')
                                            ->leftJoin('subjects', 'subjects.subjectType_id', '=', 'subject_types.id')
                                            ->leftJoin('classes', 'classes.subject_id', '=', 'subjects.id')
                                            ->where([
                                                ['classes.id', '=', $class_id]
                                                ])
                                            ->skip(2)->take(1)->pluck('components.highestWeight')->first();

                    //sum
                    $OneQOneCs_my_sum = DB::table('tasks')
                                            ->join('my_tasks', 'tasks.id', '=', 'my_tasks.task_id')
                                            ->where([
                                                ['class_id', '=', $class_id],
                                                ['quarter_id', '=', $Onequarters->pluck('quarter_id')],
                                                ['component_id', '=', $OneComponents->pluck('component_id')],
                                                ['my_tasks.user_id', '=', Auth::user()->child_id]
                                            ])
                                            ->sum(DB::raw('(my_tasks.myScore / tasks.hps) * 100'));
                    $OneQOneCs_my_count = DB::table('tasks')
                                            ->join('my_tasks', 'tasks.id', '=', 'my_tasks.task_id')
                                            ->where([
                                                ['class_id', '=', $class_id],
                                                ['quarter_id', '=', $Onequarters->pluck('quarter_id')],
                                                ['component_id', '=', $OneComponents->pluck('component_id')],
                                                ['my_tasks.user_id', '=', Auth::user()->child_id]
                                            ])
                                            ->count(DB::raw('(my_tasks.myScore / tasks.hps) * 100'));

                    
                    if ($OneQOneCs_my_count != 0) {
                        $OneQOneCs_result = ($OneQOneCs_my_sum / $OneQOneCs_my_count) * 0.01 * $OneComp_weight;
                        $OneQOneCsResult = round($OneQOneCs_result, 2);
                    } else {
                        $OneQOneCsResult = 0;
                    }
                    
                    $OneQTwoCs_my_sum = DB::table('tasks')
                                            ->join('my_tasks', 'tasks.id', '=', 'my_tasks.task_id')
                                            ->where([
                                                ['class_id', '=', $class_id],
                                                ['quarter_id', '=', $Onequarters->pluck('quarter_id')],
                                                ['component_id', '=', $TwoComponents->pluck('component_id')],
                                                ['my_tasks.user_id', '=', Auth::user()->child_id]
                                            ])
                                            ->sum(DB::raw('(my_tasks.myScore / tasks.hps) * 100'));
                    $OneQTwoCs_my_count = DB::table('tasks')
                                            ->join('my_tasks', 'tasks.id', '=', 'my_tasks.task_id')
                                            ->where([
                                                ['class_id', '=', $class_id],
                                                ['quarter_id', '=', $Onequarters->pluck('quarter_id')],
                                                ['component_id', '=', $TwoComponents->pluck('component_id')],
                                                ['my_tasks.user_id', '=', Auth::user()->child_id]
                                            ])
                                            ->count(DB::raw('(my_tasks.myScore / tasks.hps) * 100'));
                    if ($OneQTwoCs_my_count != 0) {
                        $OneQTwoCs_result = ($OneQTwoCs_my_sum / $OneQTwoCs_my_count) * 0.01 * $TwoComp_weight;
                        $OneQTwoCsResult = round($OneQTwoCs_result, 2);
                    } else {
                        $OneQTwoCsResult = 0;
                    }
                    $OneQThreeCs_my_sum = DB::table('tasks')
                                            ->join('my_tasks', 'tasks.id', '=', 'my_tasks.task_id')
                                            ->where([
                                                ['class_id', '=', $class_id],
                                                ['quarter_id', '=', $Onequarters->pluck('quarter_id')],
                                                ['component_id', '=', $ThreeComponents->pluck('component_id')],
                                                ['my_tasks.user_id', '=', Auth::user()->child_id]
                                            ])
                                            ->sum(DB::raw('(my_tasks.myScore / tasks.hps) * 100'));
                    $OneQThreeCs_my_count = DB::table('tasks')
                                            ->join('my_tasks', 'tasks.id', '=', 'my_tasks.task_id')
                                            ->where([
                                                ['class_id', '=', $class_id],
                                                ['quarter_id', '=', $Onequarters->pluck('quarter_id')],
                                                ['component_id', '=', $ThreeComponents->pluck('component_id')],
                                                ['my_tasks.user_id', '=', Auth::user()->child_id]
                                            ])
                                            ->count(DB::raw('(my_tasks.myScore / tasks.hps) * 100'));
                    if ($OneQThreeCs_my_count != 0) {
                        $OneQThreeCs_result = ($OneQThreeCs_my_sum / $OneQThreeCs_my_count) * 0.01 * $ThreeComp_weight;
                        $OneQThreeCsResult = round($OneQThreeCs_result, 2);
                    } else {
                        $OneQThreeCsResult = 0;
                    }

                    $One_initial = $OneQOneCsResult + $OneQTwoCsResult + $OneQThreeCsResult;

                    $TwoQOneCs_my_sum = DB::table('tasks')
                                            ->join('my_tasks', 'tasks.id', '=', 'my_tasks.task_id')
                                            ->where([
                                                ['class_id', '=', $class_id],
                                                ['quarter_id', '=', $Twoquarters->pluck('quarter_id')],
                                                ['component_id', '=', $OneComponents->pluck('component_id')],
                                                ['my_tasks.user_id', '=', Auth::user()->child_id]
                                            ])
                                            ->sum(DB::raw('(my_tasks.myScore / tasks.hps) * 100'));
                    $TwoQOneCs_my_count = DB::table('tasks')
                                            ->join('my_tasks', 'tasks.id', '=', 'my_tasks.task_id')
                                            ->where([
                                                ['class_id', '=', $class_id],
                                                ['quarter_id', '=', $Twoquarters->pluck('quarter_id')],
                                                ['component_id', '=', $OneComponents->pluck('component_id')],
                                                ['my_tasks.user_id', '=', Auth::user()->child_id]
                                            ])
                                            ->count(DB::raw('(my_tasks.myScore / tasks.hps) * 100'));
                    if ($TwoQOneCs_my_count != 0) {
                        $TwoQOneCs_result = ($TwoQOneCs_my_sum / $TwoQOneCs_my_count) * 0.01 * $OneComp_weight;
                        $TwoQOneCsResult = round($TwoQOneCs_result, 2);
                    } else {
                        $TwoQOneCsResult = 0;
                    }
                    $TwoQTwoCs_my_sum = DB::table('tasks')
                                            ->join('my_tasks', 'tasks.id', '=', 'my_tasks.task_id')
                                            ->where([
                                                ['class_id', '=', $class_id],
                                                ['quarter_id', '=', $Twoquarters->pluck('quarter_id')],
                                                ['component_id', '=', $TwoComponents->pluck('component_id')],
                                                ['my_tasks.user_id', '=', Auth::user()->child_id]
                                            ])
                                            ->sum(DB::raw('(my_tasks.myScore / tasks.hps) * 100'));
                    $TwoQTwoCs_my_count = DB::table('tasks')
                                            ->join('my_tasks', 'tasks.id', '=', 'my_tasks.task_id')
                                            ->where([
                                                ['class_id', '=', $class_id],
                                                ['quarter_id', '=', $Twoquarters->pluck('quarter_id')],
                                                ['component_id', '=', $TwoComponents->pluck('component_id')],
                                                ['my_tasks.user_id', '=', Auth::user()->child_id]
                                            ])
                                            ->count(DB::raw('(my_tasks.myScore / tasks.hps) * 100'));
                    if ($TwoQTwoCs_my_count != 0) {
                        $TwoQTwoCs_result = ($TwoQTwoCs_my_sum / $TwoQTwoCs_my_count) * 0.01 * $TwoComp_weight;
                        $TwoQTwoCsResult = round($TwoQTwoCs_result, 2);
                    } else {
                        $TwoQTwoCsResult = 0;
                    }
                    $TwoQThreeCs_my_sum = DB::table('tasks')
                                            ->join('my_tasks', 'tasks.id', '=', 'my_tasks.task_id')
                                            ->where([
                                                ['class_id', '=', $class_id],
                                                ['quarter_id', '=', $Twoquarters->pluck('quarter_id')],
                                                ['component_id', '=', $ThreeComponents->pluck('component_id')],
                                                ['my_tasks.user_id', '=', Auth::user()->child_id]
                                            ])
                                            ->sum(DB::raw('(my_tasks.myScore / tasks.hps) * 100'));
                    $TwoQThreeCs_my_count = DB::table('tasks')
                                            ->join('my_tasks', 'tasks.id', '=', 'my_tasks.task_id')
                                            ->where([
                                                ['class_id', '=', $class_id],
                                                ['quarter_id', '=', $Twoquarters->pluck('quarter_id')],
                                                ['component_id', '=', $ThreeComponents->pluck('component_id')],
                                                ['my_tasks.user_id', '=', Auth::user()->child_id]
                                            ])
                                            ->count(DB::raw('(my_tasks.myScore / tasks.hps) * 100'));
                    if ($TwoQThreeCs_my_count != 0) {
                        $TwoQThreeCs_result = ($TwoQThreeCs_my_sum / $TwoQThreeCs_my_count) * 0.01 * $ThreeComp_weight;
                        $TwoQThreeCsResult = round($TwoQThreeCs_result, 2);
                    } else {
                        $TwoQThreeCsResult = 0;
                    }

                    $Two_initial = $TwoQOneCsResult + $TwoQTwoCsResult + $TwoQThreeCsResult;
            }
        }
        return view('class.viewClass.grade', [
            'Class_details'=>$Class_details,
            'class_id'=>$class_id,
            'Onequarters'=>$Onequarters, 
            'Twoquarters'=>$Twoquarters, 
            'components'=>$components,
            'OneComponents'=>$OneComponents,
            'TwoComponents'=>$TwoComponents,
            'ThreeComponents'=>$ThreeComponents,
            'OneQOneCs'=>$OneQOneCs,
            'OneQTwoCs'=>$OneQTwoCs,
            'OneQTwoCs_attendances'=>$OneQTwoCs_attendances,
            'OneQThreeCs'=>$OneQThreeCs,
            'TwoQOneCs'=>$TwoQOneCs,
            'TwoQTwoCs'=>$TwoQTwoCs,
            'TwoQTwoCs_attendances'=>$TwoQTwoCs_attendances,
            'TwoQThreeCs'=>$TwoQThreeCs,
            'One_initial'=>$One_initial,
            'Two_initial'=>$Two_initial,
            'OneQOneCsResult'=>$OneQOneCsResult,
            'OneQTwoCsResult'=>$OneQTwoCsResult,
            'OneQThreeCsResult'=>$OneQThreeCsResult,
            'TwoQOneCsResult'=>$TwoQOneCsResult,
            'TwoQTwoCsResult'=>$TwoQTwoCsResult,
            'TwoQThreeCsResult'=>$TwoQThreeCsResult,
            'One_final'=>$One_final,
            'Two_final'=>$Two_final,
            'final_grade'=>$final_grade,
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($class_id, $user_id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($class_id, $user_id)
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
                                ['classes.id', '=', $class_id]
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
                                'quarters.id as quarter_id')
                            ->leftJoin('semesters', 'semesters.id', '=', 'quarters.semester_id')
                            ->leftJoin('classes', 'classes.semester_id', '=', 'semesters.id')
                            ->where([
                                ['classes.id', '=', $class_id]
                                ])
                            ->skip(1)->take(1)->get();
        $enrollment_id = enrollment::where([
                                ['class_id', '=', $class_id],
                                ['user_id', '=', $user_id],
                                ])
                                ->pluck('id')[0];
    
        $Onequarter_id = DB::table('quarters')       
                                ->leftJoin('semesters', 'semesters.id', '=', 'quarters.semester_id')
                                ->leftJoin('classes', 'classes.semester_id', '=', 'semesters.id')
                                ->where([
                                    ['classes.id', '=', $class_id]
                                    ])
                                ->pluck('quarters.id')[0];

        $Twoquarter_id = DB::table('quarters')       
                                ->leftJoin('semesters', 'semesters.id', '=', 'quarters.semester_id')
                                ->leftJoin('classes', 'classes.semester_id', '=', 'semesters.id')
                                ->where([
                                    ['classes.id', '=', $class_id]
                                    ])
                                ->pluck('quarters.id')[1];

        $One_final = DB::table('grades')
                        ->where([
                            ['enrollment_id', '=', $enrollment_id],
                            ['quarter_id', '=', $Onequarter_id],
                            ])
                            ->pluck('myQuarterlyGrade')->first();
        if(!isset($One_final)){
            $One_final = 0;
        }
        $Two_final = Grade::where([
                                ['enrollment_id', '=', $enrollment_id],
                                ['quarter_id', '=', $Twoquarter_id],
                                ])
                                ->pluck('myQuarterlyGrade')->first();
        if(!isset($Two_final)){
            $Two_final = 0;
        }
        
        if(($One_final + $Two_final) > 0){
            $final_grade = ($One_final + $Two_final)/2;
        }else{
            $final_grade = "N/A";
        }
                        

        // All Task Contents
        $OneQOneCs = DB::table('tasks')
                                ->select(
                                    'tasks.name as task_name',
                                    'tasks.task_type',
                                    'my_tasks.myScore',
                                    'tasks.hps',
                                    DB::raw('(my_tasks.myScore / tasks.hps) * 100 as Per')
                                    )
                                ->join('my_tasks', 'tasks.id', '=', 'my_tasks.task_id')
                                ->where([
                                    ['class_id', '=', $class_id],
                                    ['quarter_id', '=', $Onequarters->pluck('quarter_id')],
                                    ['component_id', '=', $OneComponents->pluck('component_id')],
                                    ['my_tasks.user_id', '=', $user_id]
                                ])
                                ->get();

        $OneQTwoCs = DB::table('tasks')
                                ->select(
                                    'tasks.name as task_name',
                                    'tasks.task_type',
                                    'my_tasks.myScore',
                                    'tasks.hps',
                                    DB::raw('(my_tasks.myScore / tasks.hps) * 100 as Per')
                                    )
                                ->join('my_tasks', 'tasks.id', '=', 'my_tasks.task_id')
                                ->where([
                                    ['class_id', '=', $class_id],
                                    ['quarter_id', '=', $Onequarters->pluck('quarter_id')],
                                    ['component_id', '=', $TwoComponents->pluck('component_id')],
                                    ['task_type', '!=', 'attendance'],
                                    ['my_tasks.user_id', '=', $user_id]
                                ])
                                ->get();

        $OneQTwoCs_attendances = DB::table('tasks')
                                ->select(
                                    'tasks.name as task_name',
                                    'tasks.task_type',
                                    'my_tasks.myScore',
                                    'tasks.hps',
                                    DB::raw('(my_tasks.myScore / tasks.hps) * 100 as Per')
                                    )
                                ->join('my_tasks', 'tasks.id', '=', 'my_tasks.task_id')
                                ->where([
                                    ['class_id', '=', $class_id],
                                    ['quarter_id', '=', $Onequarters->pluck('quarter_id')],
                                    ['component_id', '=', $TwoComponents->pluck('component_id')],
                                    ['task_type', '=', 'attendance'],
                                    ['my_tasks.user_id', '=', $user_id]
                                ])
                                ->get();

        $OneQThreeCs = DB::table('tasks')
                                ->select(
                                    'tasks.name as task_name',
                                    'tasks.task_type',
                                    'my_tasks.myScore',
                                    'tasks.hps',
                                    DB::raw('(my_tasks.myScore / tasks.hps) * 100 as Per')
                                    )
                                ->join('my_tasks', 'tasks.id', '=', 'my_tasks.task_id')
                                ->where([
                                    ['class_id', '=', $class_id],
                                    ['quarter_id', '=', $Onequarters->pluck('quarter_id')],
                                    ['component_id', '=', $ThreeComponents->pluck('component_id')],
                                    ['my_tasks.user_id', '=', $user_id]
                                ])
                                ->get();
        $TwoQOneCs = DB::table('tasks')
                                ->select(
                                    'tasks.name as task_name',
                                    'tasks.task_type',
                                    'my_tasks.myScore',
                                    'tasks.hps',
                                    DB::raw('(my_tasks.myScore / tasks.hps) * 100 as Per')
                                    )
                                ->join('my_tasks', 'tasks.id', '=', 'my_tasks.task_id')
                                ->where([
                                    ['class_id', '=', $class_id],
                                    ['quarter_id', '=', $Twoquarters->pluck('quarter_id')],
                                    ['component_id', '=', $OneComponents->pluck('component_id')],
                                    ['my_tasks.user_id', '=', $user_id]
                                ])
                                ->get();
        $TwoQTwoCs = DB::table('tasks')
                                ->select(
                                    'tasks.name as task_name',
                                    'tasks.task_type',
                                    'my_tasks.myScore',
                                    'tasks.hps',
                                    DB::raw('(my_tasks.myScore / tasks.hps) * 100 as Per')
                                    )
                                ->join('my_tasks', 'tasks.id', '=', 'my_tasks.task_id')
                                ->where([
                                    ['class_id', '=', $class_id],
                                    ['quarter_id', '=', $Twoquarters->pluck('quarter_id')],
                                    ['component_id', '=', $TwoComponents->pluck('component_id')],
                                    ['task_type', '!=', 'attendance'],
                                    ['my_tasks.user_id', '=', $user_id]
                                ])
                                ->get();
        $TwoQTwoCs_attendances = DB::table('tasks')
                                ->select(
                                    'tasks.name as task_name',
                                    'tasks.task_type',
                                    'my_tasks.myScore',
                                    'tasks.hps',
                                    DB::raw('(my_tasks.myScore / tasks.hps) * 100 as Per')
                                    )
                                ->join('my_tasks', 'tasks.id', '=', 'my_tasks.task_id')
                                ->where([
                                    ['class_id', '=', $class_id],
                                    ['quarter_id', '=', $Twoquarters->pluck('quarter_id')],
                                    ['component_id', '=', $TwoComponents->pluck('component_id')],
                                    ['task_type', '=', 'attendance'],
                                    ['my_tasks.user_id', '=', $user_id]
                                ])
                                ->get();
        $TwoQThreeCs = DB::table('tasks')
                                ->select(
                                    'tasks.name as task_name',
                                    'tasks.task_type',
                                    'my_tasks.myScore',
                                    'tasks.hps',
                                    DB::raw('(my_tasks.myScore / tasks.hps) * 100 as Per')
                                    )
                                ->join('my_tasks', 'tasks.id', '=', 'my_tasks.task_id')
                                ->where([
                                    ['class_id', '=', $class_id],
                                    ['quarter_id', '=', $Twoquarters->pluck('quarter_id')],
                                    ['component_id', '=', $ThreeComponents->pluck('component_id')],
                                    ['my_tasks.user_id', '=', $user_id]
                                ])
                                ->get();
        //component weight
        $OneComp_weight = DB::table('components')
                                ->leftJoin('subject_types', 'subject_types.id', '=', 'components.subjectType_id')
                                ->leftJoin('subjects', 'subjects.subjectType_id', '=', 'subject_types.id')
                                ->leftJoin('classes', 'classes.subject_id', '=', 'subjects.id')
                                ->where([
                                    ['classes.id', '=', $class_id]
                                    ])
                                ->skip(0)->take(1)->pluck('components.highestWeight')->first();
        $TwoComp_weight = DB::table('components')
                                ->leftJoin('subject_types', 'subject_types.id', '=', 'components.subjectType_id')
                                ->leftJoin('subjects', 'subjects.subjectType_id', '=', 'subject_types.id')
                                ->leftJoin('classes', 'classes.subject_id', '=', 'subjects.id')
                                ->where([
                                    ['classes.id', '=', $class_id]
                                    ])
                                ->skip(1)->take(1)->pluck('components.highestWeight')->first();
        $ThreeComp_weight = DB::table('components')
                                ->leftJoin('subject_types', 'subject_types.id', '=', 'components.subjectType_id')
                                ->leftJoin('subjects', 'subjects.subjectType_id', '=', 'subject_types.id')
                                ->leftJoin('classes', 'classes.subject_id', '=', 'subjects.id')
                                ->where([
                                    ['classes.id', '=', $class_id]
                                    ])
                                ->skip(2)->take(1)->pluck('components.highestWeight')->first();

        //sum
        $OneQOneCs_my_sum = DB::table('tasks')
                                ->join('my_tasks', 'tasks.id', '=', 'my_tasks.task_id')
                                ->where([
                                    ['class_id', '=', $class_id],
                                    ['quarter_id', '=', $Onequarters->pluck('quarter_id')],
                                    ['component_id', '=', $OneComponents->pluck('component_id')],
                                    ['my_tasks.user_id', '=', $user_id]
                                ])
                                ->sum(DB::raw('(my_tasks.myScore / tasks.hps) * 100'));
        $OneQOneCs_my_count = DB::table('tasks')
                                ->join('my_tasks', 'tasks.id', '=', 'my_tasks.task_id')
                                ->where([
                                    ['class_id', '=', $class_id],
                                    ['quarter_id', '=', $Onequarters->pluck('quarter_id')],
                                    ['component_id', '=', $OneComponents->pluck('component_id')],
                                    ['my_tasks.user_id', '=', $user_id]
                                ])
                                ->count(DB::raw('(my_tasks.myScore / tasks.hps) * 100'));
        if ($OneQOneCs_my_count != 0) {
            $OneQOneCs_result = ($OneQOneCs_my_sum / $OneQOneCs_my_count) * 0.01 * $OneComp_weight;
            $OneQOneCsResult = round($OneQOneCs_result, 2);
        } else {
            $OneQOneCsResult = 0;
        }
        
        $OneQTwoCs_my_sum = DB::table('tasks')
                                ->join('my_tasks', 'tasks.id', '=', 'my_tasks.task_id')
                                ->where([
                                    ['class_id', '=', $class_id],
                                    ['quarter_id', '=', $Onequarters->pluck('quarter_id')],
                                    ['component_id', '=', $TwoComponents->pluck('component_id')],
                                    ['my_tasks.user_id', '=', $user_id]
                                ])
                                ->sum(DB::raw('(my_tasks.myScore / tasks.hps) * 100'));
        $OneQTwoCs_my_count = DB::table('tasks')
                                ->join('my_tasks', 'tasks.id', '=', 'my_tasks.task_id')
                                ->where([
                                    ['class_id', '=', $class_id],
                                    ['quarter_id', '=', $Onequarters->pluck('quarter_id')],
                                    ['component_id', '=', $TwoComponents->pluck('component_id')],
                                    ['my_tasks.user_id', '=', $user_id]
                                ])
                                ->count(DB::raw('(my_tasks.myScore / tasks.hps) * 100'));
        if ($OneQTwoCs_my_count != 0) {
            $OneQTwoCs_result = ($OneQTwoCs_my_sum / $OneQTwoCs_my_count) * 0.01 * $TwoComp_weight;
            $OneQTwoCsResult = round($OneQTwoCs_result, 2);
        } else {
            $OneQTwoCsResult = 0;
        }
        $OneQThreeCs_my_sum = DB::table('tasks')
                                ->join('my_tasks', 'tasks.id', '=', 'my_tasks.task_id')
                                ->where([
                                    ['class_id', '=', $class_id],
                                    ['quarter_id', '=', $Onequarters->pluck('quarter_id')],
                                    ['component_id', '=', $ThreeComponents->pluck('component_id')],
                                    ['my_tasks.user_id', '=', $user_id]
                                ])
                                ->sum(DB::raw('(my_tasks.myScore / tasks.hps) * 100'));
        $OneQThreeCs_my_count = DB::table('tasks')
                                ->join('my_tasks', 'tasks.id', '=', 'my_tasks.task_id')
                                ->where([
                                    ['class_id', '=', $class_id],
                                    ['quarter_id', '=', $Onequarters->pluck('quarter_id')],
                                    ['component_id', '=', $ThreeComponents->pluck('component_id')],
                                    ['my_tasks.user_id', '=', $user_id]
                                ])
                                ->count(DB::raw('(my_tasks.myScore / tasks.hps) * 100'));
        if ($OneQThreeCs_my_count != 0) {
            $OneQThreeCs_result = ($OneQThreeCs_my_sum / $OneQThreeCs_my_count) * 0.01 * $ThreeComp_weight;
            $OneQThreeCsResult = round($OneQThreeCs_result, 2);
        } else {
            $OneQThreeCsResult = 0;
        }

        $One_initial = $OneQOneCsResult + $OneQTwoCsResult + $OneQThreeCsResult;

        $TwoQOneCs_my_sum = DB::table('tasks')
                                ->join('my_tasks', 'tasks.id', '=', 'my_tasks.task_id')
                                ->where([
                                    ['class_id', '=', $class_id],
                                    ['quarter_id', '=', $Twoquarters->pluck('quarter_id')],
                                    ['component_id', '=', $OneComponents->pluck('component_id')],
                                    ['my_tasks.user_id', '=', $user_id]
                                ])
                                ->sum(DB::raw('(my_tasks.myScore / tasks.hps) * 100'));
        $TwoQOneCs_my_count = DB::table('tasks')
                                ->join('my_tasks', 'tasks.id', '=', 'my_tasks.task_id')
                                ->where([
                                    ['class_id', '=', $class_id],
                                    ['quarter_id', '=', $Twoquarters->pluck('quarter_id')],
                                    ['component_id', '=', $OneComponents->pluck('component_id')],
                                    ['my_tasks.user_id', '=', $user_id]
                                ])
                                ->count(DB::raw('(my_tasks.myScore / tasks.hps) * 100'));
        if ($TwoQOneCs_my_count != 0) {
            $TwoQOneCs_result = ($TwoQOneCs_my_sum / $TwoQOneCs_my_count) * 0.01 * $OneComp_weight;
            $TwoQOneCsResult = round($TwoQOneCs_result, 2);
        } else {
            $TwoQOneCsResult = 0;
        }
        $TwoQTwoCs_my_sum = DB::table('tasks')
                                ->join('my_tasks', 'tasks.id', '=', 'my_tasks.task_id')
                                ->where([
                                    ['class_id', '=', $class_id],
                                    ['quarter_id', '=', $Twoquarters->pluck('quarter_id')],
                                    ['component_id', '=', $TwoComponents->pluck('component_id')],
                                    ['my_tasks.user_id', '=', $user_id]
                                ])
                                ->sum(DB::raw('(my_tasks.myScore / tasks.hps) * 100'));
        $TwoQTwoCs_my_count = DB::table('tasks')
                                ->join('my_tasks', 'tasks.id', '=', 'my_tasks.task_id')
                                ->where([
                                    ['class_id', '=', $class_id],
                                    ['quarter_id', '=', $Twoquarters->pluck('quarter_id')],
                                    ['component_id', '=', $TwoComponents->pluck('component_id')],
                                    ['my_tasks.user_id', '=', $user_id]
                                ])
                                ->count(DB::raw('(my_tasks.myScore / tasks.hps) * 100'));
        if ($TwoQTwoCs_my_count != 0) {
            $TwoQTwoCs_result = ($TwoQTwoCs_my_sum / $TwoQTwoCs_my_count) * 0.01 * $TwoComp_weight;
            $TwoQTwoCsResult = round($TwoQTwoCs_result, 2);
        } else {
            $TwoQTwoCsResult = 0;
        }
        $TwoQThreeCs_my_sum = DB::table('tasks')
                                ->join('my_tasks', 'tasks.id', '=', 'my_tasks.task_id')
                                ->where([
                                    ['class_id', '=', $class_id],
                                    ['quarter_id', '=', $Twoquarters->pluck('quarter_id')],
                                    ['component_id', '=', $ThreeComponents->pluck('component_id')],
                                    ['my_tasks.user_id', '=', $user_id]
                                ])
                                ->sum(DB::raw('(my_tasks.myScore / tasks.hps) * 100'));
        $TwoQThreeCs_my_count = DB::table('tasks')
                                ->join('my_tasks', 'tasks.id', '=', 'my_tasks.task_id')
                                ->where([
                                    ['class_id', '=', $class_id],
                                    ['quarter_id', '=', $Twoquarters->pluck('quarter_id')],
                                    ['component_id', '=', $ThreeComponents->pluck('component_id')],
                                    ['my_tasks.user_id', '=', $user_id]
                                ])
                                ->count(DB::raw('(my_tasks.myScore / tasks.hps) * 100'));
        if ($TwoQThreeCs_my_count != 0) {
            $TwoQThreeCs_result = ($TwoQThreeCs_my_sum / $TwoQThreeCs_my_count) * 0.01 * $ThreeComp_weight;
            $TwoQThreeCsResult = round($TwoQThreeCs_result, 2);
        } else {
            $TwoQThreeCsResult = 0;
        }

        $Two_initial = $TwoQOneCsResult + $TwoQTwoCsResult + $TwoQThreeCsResult;



        return view('class.viewClass.grade', [
            'Class_details'=>$Class_details,
            'class_id'=>$class_id,
            'user_id'=>$user_id,
            'Onequarters'=>$Onequarters, 
            'Twoquarters'=>$Twoquarters, 
            'components'=>$components,
            'OneComponents'=>$OneComponents,
            'TwoComponents'=>$TwoComponents,
            'ThreeComponents'=>$ThreeComponents,
            'OneQOneCs'=>$OneQOneCs,
            'OneQTwoCs'=>$OneQTwoCs,
            'OneQTwoCs_attendances'=>$OneQTwoCs_attendances,
            'OneQThreeCs'=>$OneQThreeCs,
            'TwoQOneCs'=>$TwoQOneCs,
            'TwoQTwoCs'=>$TwoQTwoCs,
            'TwoQTwoCs_attendances'=>$TwoQTwoCs_attendances,
            'TwoQThreeCs'=>$TwoQThreeCs,
            'One_initial'=>$One_initial,
            'Two_initial'=>$Two_initial,
            'OneQOneCsResult'=>$OneQOneCsResult,
            'OneQTwoCsResult'=>$OneQTwoCsResult,
            'OneQThreeCsResult'=>$OneQThreeCsResult,
            'TwoQOneCsResult'=>$TwoQOneCsResult,
            'TwoQTwoCsResult'=>$TwoQTwoCsResult,
            'TwoQThreeCsResult'=>$TwoQThreeCsResult,
            'One_final'=>$One_final,
            'Two_final'=>$Two_final,
            'final_grade'=>$final_grade,
            ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $class_id, $user_id)
    {
        $this->validate($request, [
            'final' => 'required',
            'quarter_id' => 'required'
        ]);

        $enrollment_id = enrollment::where([
                                    ['class_id', $class_id],
                                    ['user_id', $user_id],
                                    ])
                                    ->pluck('id')
                                    ->first();

        $final_grade = new Grade;
        $final_grade->enrollment_id = $enrollment_id;
        $final_grade->quarter_id = $request->input('quarter_id');
        $final_grade->myQuarterlyGrade = $request->input('final');
        $final_grade->save();

        return redirect('/viewClass'.'/'.$class_id.'/grade')->with('success', 'You added!');

        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($class_id, $id)
    {
        //
    }
}
