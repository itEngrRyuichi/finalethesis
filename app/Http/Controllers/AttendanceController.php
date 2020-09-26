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
use App\Attendance;
use App\AttendanceStatus;
use App\myAttendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Auth;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($class_id)
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
            $statuses = AttendanceStatus::all();
        if (Auth::user()->userType_id == 2) {

            return view('class.viewClass.classAttendance', [
                'Class_details'=>$Class_details,
                'Onequarters'=>$Onequarters,
                'Twoquarters'=>$Twoquarters,
                'class_id'=>$class_id,
                'statuses'=>$statuses
                ]);
        } elseif(Auth::user()->userType_id == 3) {

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

            $Onequarter_id = DB::table('quarters')
                        ->select(
                            'quarters.name as quarter_name',
                            'quarters.id as quarter_id'
                        )
                        ->leftJoin('semesters', 'semesters.id', '=', 'quarters.semester_id')
                        ->leftJoin('classes', 'classes.semester_id', '=', 'semesters.id')
                        ->where([
                            ['classes.id', '=', $class_id]
                            ])
                        ->skip(0)->take(1)->pluck('quarter_id')->first();

            $Twoquarter_id = DB::table('quarters')
                        ->select(
                            'quarters.name as quarter_name',
                            'quarters.id as quarter_id')
                        ->leftJoin('semesters', 'semesters.id', '=', 'quarters.semester_id')
                        ->leftJoin('classes', 'classes.semester_id', '=', 'semesters.id')
                        ->where([
                            ['classes.id', '=', $class_id]
                            ])
                        ->skip(1)->take(1)->pluck('quarter_id')->first();
            $Onetask_id = task::where([
                            ['class_id', '=', $class_id],
                            ['quarter_id', '=', $Onequarter_id],
                            ['task_type', '=', 'attendance'],
                            ])
                            ->pluck('id')->first();

            $Twotask_id = task::where([
                            ['class_id', '=', $class_id],
                            ['quarter_id', '=', $Twoquarter_id],
                            ['task_type', '=', 'attendance'],
                            ])
                            ->pluck('id')->first();

            $OnemyTask_id = myTask::where([
                            ['user_id', '=', Auth::user()->id],
                            ['task_id', '=', $Onetask_id],
                            ])
                            ->pluck('id')->first();

            $TwomyTask_id = myTask::where([
                            ['user_id', '=', Auth::user()->id],
                            ['task_id', '=', $Twotask_id],
                            ])
                            ->pluck('id')->first();
            $OneAttends = DB::table('my_attendances')
                            ->join('attendance_statuses', 'my_attendances.status_id', '=', 'attendance_statuses.id')
                            ->where([
                                ['myTask_id', '=', $OnemyTask_id],
                            ])
                            ->orderBy('my_attendances.date')
                            ->get();
            $TwoAttends = DB::table('my_attendances')
                            ->join('attendance_statuses', 'my_attendances.status_id', '=', 'attendance_statuses.id')            
                            ->where([
                                ['myTask_id', '=', $TwomyTask_id],
                            ])
                            ->orderBy('my_attendances.date')
                            ->get();
            $One_Attend_present = DB::table('my_attendances')
                            ->join('attendance_statuses', 'my_attendances.status_id', '=', 'attendance_statuses.id')
                            ->where([
                                ['myTask_id', '=', $OnemyTask_id],
                                ['attendance_statuses.id', '=', '1'],
                            ])
                            ->count('attendance_statuses.score');

            $One_Attend_late = DB::table('my_attendances')
                            ->join('attendance_statuses', 'my_attendances.status_id', '=', 'attendance_statuses.id')
                            ->where([
                                ['myTask_id', '=', $OnemyTask_id],
                                ['attendance_statuses.id', '=', '2'],
                            ])
                            ->count('attendance_statuses.score');

            $One_Attend_left = DB::table('my_attendances')
                            ->join('attendance_statuses', 'my_attendances.status_id', '=', 'attendance_statuses.id')
                            ->where([
                                ['myTask_id', '=', $OnemyTask_id],
                                ['attendance_statuses.id', '=', '3'],
                            ])
                            ->count('attendance_statuses.score');

            $One_Attend_absent = DB::table('my_attendances')
                            ->join('attendance_statuses', 'my_attendances.status_id', '=', 'attendance_statuses.id')
                            ->where([
                                ['myTask_id', '=', $OnemyTask_id],
                                ['attendance_statuses.id', '=', '4'],
                            ])
                            ->count('attendance_statuses.score');

            $One_Attend_excused = DB::table('my_attendances')
                            ->join('attendance_statuses', 'my_attendances.status_id', '=', 'attendance_statuses.id')
                            ->where([
                                ['myTask_id', '=', $OnemyTask_id],
                                ['attendance_statuses.id', '=', '5'],
                            ])
                            ->count('attendance_statuses.score');
            $One_SUM = DB::table('my_attendances')
                            ->join('attendance_statuses', 'my_attendances.status_id', '=', 'attendance_statuses.id')
                            ->where([
                                ['myTask_id', '=', $OnemyTask_id],
                            ])
                            ->sum('attendance_statuses.score');

            $One_COUNT = DB::table('my_attendances')
                            ->join('attendance_statuses', 'my_attendances.status_id', '=', 'attendance_statuses.id')
                            ->where([
                                ['myTask_id', '=', $OnemyTask_id],
                            ])
                            ->count('attendance_statuses.score');
            if ($One_COUNT != 0) {
                $One_Result = $One_SUM / $One_COUNT;
                $OneResult = round($One_Result, 2);
            }else{
                $OneResult = "N/A";
            }
            $Two_Attend_present = DB::table('my_attendances')
                            ->join('attendance_statuses', 'my_attendances.status_id', '=', 'attendance_statuses.id')
                            ->where([
                                ['myTask_id', '=', $TwomyTask_id],
                                ['attendance_statuses.id', '=', '1'],
                            ])
                            ->count('attendance_statuses.score');

            $Two_Attend_late = DB::table('my_attendances')
                            ->join('attendance_statuses', 'my_attendances.status_id', '=', 'attendance_statuses.id')
                            ->where([
                                ['myTask_id', '=', $TwomyTask_id],
                                ['attendance_statuses.id', '=', '2'],
                            ])
                            ->count('attendance_statuses.score');

            $Two_Attend_left = DB::table('my_attendances')
                            ->join('attendance_statuses', 'my_attendances.status_id', '=', 'attendance_statuses.id')
                            ->where([
                                ['myTask_id', '=', $TwomyTask_id],
                                ['attendance_statuses.id', '=', '3'],
                            ])
                            ->count('attendance_statuses.score');

            $Two_Attend_absent = DB::table('my_attendances')
                            ->join('attendance_statuses', 'my_attendances.status_id', '=', 'attendance_statuses.id')
                            ->where([
                                ['myTask_id', '=', $TwomyTask_id],
                                ['attendance_statuses.id', '=', '4'],
                            ])
                            ->count('attendance_statuses.score');

            $Two_Attend_excused = DB::table('my_attendances')
                            ->join('attendance_statuses', 'my_attendances.status_id', '=', 'attendance_statuses.id')
                            ->where([
                                ['myTask_id', '=', $TwomyTask_id],
                                ['attendance_statuses.id', '=', '5'],
                            ])
                            ->count('attendance_statuses.score');
            $Two_SUM = DB::table('my_attendances')
                            ->join('attendance_statuses', 'my_attendances.status_id', '=', 'attendance_statuses.id')
                            ->where([
                                ['myTask_id', '=', $TwomyTask_id],
                            ])
                            ->sum('attendance_statuses.score');

            $Two_COUNT = DB::table('my_attendances')
                            ->join('attendance_statuses', 'my_attendances.status_id', '=', 'attendance_statuses.id')
                            ->where([
                                ['myTask_id', '=', $TwomyTask_id],
                            ])
                            ->count('attendance_statuses.score');
            if ($Two_COUNT != 0) {
                $Two_Result = $Two_SUM / $Two_COUNT;
                $TwoResult = round($Two_Result, 2);
            }else{
                $TwoResult = "N/A";
            }
            
            return view('class.viewClass.attendance', [
                'Class_details'=>$Class_details,
                'class_id'=>$class_id,
                'Onequarters'=>$Onequarters, 
                'Twoquarters'=>$Twoquarters, 
                'One_Attend_present'=>$One_Attend_present, 
                'One_Attend_late'=>$One_Attend_late, 
                'One_Attend_left'=>$One_Attend_left, 
                'One_Attend_absent'=>$One_Attend_absent, 
                'One_Attend_excused'=>$One_Attend_excused, 
                'Two_Attend_present'=>$Two_Attend_present, 
                'Two_Attend_late'=>$Two_Attend_late, 
                'Two_Attend_left'=>$Two_Attend_left, 
                'Two_Attend_absent'=>$Two_Attend_absent, 
                'Two_Attend_excused'=>$Two_Attend_excused, 
                'OneResult'=>$OneResult, 
                'TwoResult'=>$TwoResult, 
                'OneAttends'=>$OneAttends, 
                'TwoAttends'=>$TwoAttends, 
                ]);
        } elseif(Auth::user()->userType_id == 4){
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
            $statuses = AttendanceStatus::all();
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

            $Onequarter_id = DB::table('quarters')
                        ->select(
                            'quarters.name as quarter_name',
                            'quarters.id as quarter_id'
                        )
                        ->leftJoin('semesters', 'semesters.id', '=', 'quarters.semester_id')
                        ->leftJoin('classes', 'classes.semester_id', '=', 'semesters.id')
                        ->where([
                            ['classes.id', '=', $class_id]
                            ])
                        ->skip(0)->take(1)->pluck('quarter_id')->first();

            $Twoquarter_id = DB::table('quarters')
                        ->select(
                            'quarters.name as quarter_name',
                            'quarters.id as quarter_id')
                        ->leftJoin('semesters', 'semesters.id', '=', 'quarters.semester_id')
                        ->leftJoin('classes', 'classes.semester_id', '=', 'semesters.id')
                        ->where([
                            ['classes.id', '=', $class_id]
                            ])
                        ->skip(1)->take(1)->pluck('quarter_id')->first();
            $Onetask_id = task::where([
                            ['class_id', '=', $class_id],
                            ['quarter_id', '=', $Onequarter_id],
                            ['task_type', '=', 'attendance'],
                            ])
                            ->pluck('id')->first();

            $Twotask_id = task::where([
                            ['class_id', '=', $class_id],
                            ['quarter_id', '=', $Twoquarter_id],
                            ['task_type', '=', 'attendance'],
                            ])
                            ->pluck('id')->first();

            $OnemyTask_id = myTask::where([
                            ['user_id', '=', Auth::user()->child_id],
                            ['task_id', '=', $Onetask_id],
                            ])
                            ->pluck('id')->first();

            $TwomyTask_id = myTask::where([
                            ['user_id', '=', Auth::user()->child_id],
                            ['task_id', '=', $Twotask_id],
                            ])
                            ->pluck('id')->first();
            $OneAttends = DB::table('my_attendances')
                            ->join('attendance_statuses', 'my_attendances.status_id', '=', 'attendance_statuses.id')
                            ->where([
                                ['myTask_id', '=', $OnemyTask_id],
                            ])
                            ->get();
            $TwoAttends = DB::table('my_attendances')
                            ->join('attendance_statuses', 'my_attendances.status_id', '=', 'attendance_statuses.id')            
                            ->where([
                                ['myTask_id', '=', $TwomyTask_id],
                            ])
                            ->get();
            $One_Attend_present = DB::table('my_attendances')
                            ->join('attendance_statuses', 'my_attendances.status_id', '=', 'attendance_statuses.id')
                            ->where([
                                ['myTask_id', '=', $OnemyTask_id],
                                ['attendance_statuses.id', '=', '1'],
                            ])
                            ->count('attendance_statuses.score');

            $One_Attend_late = DB::table('my_attendances')
                            ->join('attendance_statuses', 'my_attendances.status_id', '=', 'attendance_statuses.id')
                            ->where([
                                ['myTask_id', '=', $OnemyTask_id],
                                ['attendance_statuses.id', '=', '2'],
                            ])
                            ->count('attendance_statuses.score');

            $One_Attend_left = DB::table('my_attendances')
                            ->join('attendance_statuses', 'my_attendances.status_id', '=', 'attendance_statuses.id')
                            ->where([
                                ['myTask_id', '=', $OnemyTask_id],
                                ['attendance_statuses.id', '=', '3'],
                            ])
                            ->count('attendance_statuses.score');

            $One_Attend_absent = DB::table('my_attendances')
                            ->join('attendance_statuses', 'my_attendances.status_id', '=', 'attendance_statuses.id')
                            ->where([
                                ['myTask_id', '=', $OnemyTask_id],
                                ['attendance_statuses.id', '=', '4'],
                            ])
                            ->count('attendance_statuses.score');

            $One_Attend_excused = DB::table('my_attendances')
                            ->join('attendance_statuses', 'my_attendances.status_id', '=', 'attendance_statuses.id')
                            ->where([
                                ['myTask_id', '=', $OnemyTask_id],
                                ['attendance_statuses.id', '=', '5'],
                            ])
                            ->count('attendance_statuses.score');
            $One_SUM = DB::table('my_attendances')
                            ->join('attendance_statuses', 'my_attendances.status_id', '=', 'attendance_statuses.id')
                            ->where([
                                ['myTask_id', '=', $OnemyTask_id],
                            ])
                            ->sum('attendance_statuses.score');

            $One_COUNT = DB::table('my_attendances')
                            ->join('attendance_statuses', 'my_attendances.status_id', '=', 'attendance_statuses.id')
                            ->where([
                                ['myTask_id', '=', $OnemyTask_id],
                            ])
                            ->count('attendance_statuses.score');
            if ($One_COUNT != 0) {
                $One_Result = $One_SUM / $One_COUNT;
                $OneResult = round($One_Result, 2);
            }else{
                $OneResult = "N/A";
            }
            $Two_Attend_present = DB::table('my_attendances')
                            ->join('attendance_statuses', 'my_attendances.status_id', '=', 'attendance_statuses.id')
                            ->where([
                                ['myTask_id', '=', $TwomyTask_id],
                                ['attendance_statuses.id', '=', '1'],
                            ])
                            ->count('attendance_statuses.score');

            $Two_Attend_late = DB::table('my_attendances')
                            ->join('attendance_statuses', 'my_attendances.status_id', '=', 'attendance_statuses.id')
                            ->where([
                                ['myTask_id', '=', $TwomyTask_id],
                                ['attendance_statuses.id', '=', '2'],
                            ])
                            ->count('attendance_statuses.score');

            $Two_Attend_left = DB::table('my_attendances')
                            ->join('attendance_statuses', 'my_attendances.status_id', '=', 'attendance_statuses.id')
                            ->where([
                                ['myTask_id', '=', $TwomyTask_id],
                                ['attendance_statuses.id', '=', '3'],
                            ])
                            ->count('attendance_statuses.score');

            $Two_Attend_absent = DB::table('my_attendances')
                            ->join('attendance_statuses', 'my_attendances.status_id', '=', 'attendance_statuses.id')
                            ->where([
                                ['myTask_id', '=', $TwomyTask_id],
                                ['attendance_statuses.id', '=', '4'],
                            ])
                            ->count('attendance_statuses.score');

            $Two_Attend_excused = DB::table('my_attendances')
                            ->join('attendance_statuses', 'my_attendances.status_id', '=', 'attendance_statuses.id')
                            ->where([
                                ['myTask_id', '=', $TwomyTask_id],
                                ['attendance_statuses.id', '=', '5'],
                            ])
                            ->count('attendance_statuses.score');
            $Two_SUM = DB::table('my_attendances')
                            ->join('attendance_statuses', 'my_attendances.status_id', '=', 'attendance_statuses.id')
                            ->where([
                                ['myTask_id', '=', $TwomyTask_id],
                            ])
                            ->sum('attendance_statuses.score');

            $Two_COUNT = DB::table('my_attendances')
                            ->join('attendance_statuses', 'my_attendances.status_id', '=', 'attendance_statuses.id')
                            ->where([
                                ['myTask_id', '=', $TwomyTask_id],
                            ])
                            ->count('attendance_statuses.score');
            if ($Two_COUNT != 0) {
                $Two_Result = $Two_SUM / $Two_COUNT;
                $TwoResult = round($Two_Result, 2);
            }else{
                $TwoResult = "N/A";
            }
            
            return view('class.viewClass.attendance', [
                'Class_details'=>$Class_details,
                'class_id'=>$class_id,
                'Onequarters'=>$Onequarters, 
                'Twoquarters'=>$Twoquarters, 
                'One_Attend_present'=>$One_Attend_present, 
                'One_Attend_late'=>$One_Attend_late, 
                'One_Attend_left'=>$One_Attend_left, 
                'One_Attend_absent'=>$One_Attend_absent, 
                'One_Attend_excused'=>$One_Attend_excused, 
                'Two_Attend_present'=>$Two_Attend_present, 
                'Two_Attend_late'=>$Two_Attend_late, 
                'Two_Attend_left'=>$Two_Attend_left, 
                'Two_Attend_absent'=>$Two_Attend_absent, 
                'Two_Attend_excused'=>$Two_Attend_excused, 
                'OneResult'=>$OneResult, 
                'TwoResult'=>$TwoResult, 
                'OneAttends'=>$OneAttends, 
                'TwoAttends'=>$TwoAttends, 
                ]);
            }
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
        $this->validate($request, [
            'quarter_id' => 'required',
            'date' => 'required'
        ]);

        $quarter_id = $request->input('quarter_id');
        $date = $request->input('date');
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
        $all_students = DB::table('users')
                            ->select(
                                'users.id as user_id',
                                'users.name as user_name'
                            )
                            ->join('enrollments', 'users.id', '=', 'enrollments.user_id')
                            ->join('classes', 'enrollments.class_id', '=', 'classes.id')
                            ->join('tasks', 'classes.id', '=', 'tasks.class_id')
                            ->where([
                                ['enrollments.class_id', '=', $class_id],
                                ['enrollments.user_id', '!=', Auth::user()->id],
                                ['tasks.task_type', '=', 'attendance'],
                                ['tasks.quarter_id', '=', $request->input('quarter_id')],
                                ])
                            ->get();

        $statuses = AttendanceStatus::all();
        return view('class.viewClass.classAttendance', [
            'Class_details'=>$Class_details,
            'all_students'=>$all_students,
            'Onequarters'=>$Onequarters,
            'Twoquarters'=>$Twoquarters,
            'class_id'=>$class_id,
            'quarter_id'=>$quarter_id,
            'date'=>$date,
            'statuses'=>$statuses
            ]);
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
        //
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
            'quarter_id' => 'required',
            'date' => 'required',
            'status' => 'required',
        ]);

        $task_id = task::where([
                        ['class_id', '=', $class_id],
                        ['quarter_id', '=', $request->input('quarter_id')],
                        ['task_type', '=', 'attendance'],
                        ])
                        ->pluck('id')
                        ->first();

        $myTask = myTask::where([
            ['user_id', '=', $user_id],
            ['task_id', '=', $task_id],
            ])->get();

        if ($myTask == "[]") {
            $myTask = new myTask;
            $myTask->user_id = $user_id;
            $myTask->task_id = $task_id;
            $myTask->save();
            $myTask_id = myTask::where([
                                    ['user_id', '=', $user_id],
                                    ['task_id', '=', $task_id],
                                    ])->pluck('id')->first();
        }else{
            $myTask_id = myTask::where([
                                    ['user_id', '=', $user_id],
                                    ['task_id', '=', $task_id],
                                    ])->pluck('id')->first();
    
        }

        $DateExistCheck = myAttendance::where([
            ['date', '=', $request->input('date')],
            ['myTask_id', '=', $myTask_id],
            ])
            ->pluck('id')->first();

        if ($DateExistCheck == null) {
            $myAttendance = new myAttendance;
            $myAttendance->myTask_id = $myTask_id;
            $myAttendance->status_id = $request->input('status');
            $myAttendance->date = $request->input('date');
            $myAttendance->save();

            $sum = DB::table('my_attendances')
                        ->where('myTask_id', '=', $myTask_id)
                        ->join('attendance_statuses', 'attendance_statuses.id', '=', 'my_attendances.status_id')
                        ->sum('attendance_statuses.score');

            $count = DB::table('my_attendances')
                        ->where('myTask_id', '=', $myTask_id)
                        ->join('attendance_statuses', 'attendance_statuses.id', '=', 'my_attendances.status_id')
                        ->count('attendance_statuses.score');

            $ave = ($sum/$count);

            $myTask = myTask::find($myTask_id);
            $myTask->score_check = "checked";
            $myTask->myScore = $ave;
            $myTask->save();

            return redirect('/viewClass'.'/'.$class_id.'/attendance')->with('success', 'You added');

        } else {
            $myAttendance = myAttendance::find($DateExistCheck);
            $myAttendance->myTask_id = $myTask_id;
            $myAttendance->status_id = $request->input('status');
            $myAttendance->date = $request->input('date');
            $myAttendance->save();

            $sum = DB::table('my_attendances')
                        ->where('myTask_id', '=', $myTask_id)
                        ->join('attendance_statuses', 'attendance_statuses.id', '=', 'my_attendances.status_id')
                        ->sum('attendance_statuses.score');

            $count = DB::table('my_attendances')
                        ->where('myTask_id', '=', $myTask_id)
                        ->join('attendance_statuses', 'attendance_statuses.id', '=', 'my_attendances.status_id')
                        ->count('attendance_statuses.score');

            $ave = ($sum/$count);

            $myTask = myTask::find($myTask_id);
            $myTask->score_check = "checked";
            $myTask->myScore = $ave;
            $myTask->save();

            return redirect('/viewClass'.'/'.$class_id.'/attendance')->with('success', 'You Updated');
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($class_id, $user_id)
    {
        //
    }
}
