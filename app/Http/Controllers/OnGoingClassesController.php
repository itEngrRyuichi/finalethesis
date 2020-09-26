<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\enrollment;
use App\Clas;
use App\Subject;
use App\Component;
use App\SubjectType;
use App\task;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Auth;

class OnGoingClassesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $onGoingClasses = DB::table('classes')
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
                                ['classes.progress', '=', 'on going']
                                ])
                            ->get();
        $Parent_onGoingClasses = DB::table('classes')
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
                                        ['classes.progress', '=', 'on going']
                                        ])
                                    ->get();
        //Option Purpose
        $SchoolYear = DB::table('school_years')
                            ->select(
                                'school_years.id as school_years_id',
                                'school_years.name as school_years_name'
                            )
                            ->get();

        $SchoolYearOptions = $SchoolYear->pluck('school_years_name', 'school_years_id')->toArray();

        $Semesters = DB::table('semesters')
                            ->select(
                                'semesters.id as semester_id',
                                'semesters.name as semester_name'
                                )
                            ->get();

        $SchoolYearID = null;
        $SemesterID = null;

        $SemesterOptions = $Semesters->pluck('semester_name', 'semester_id')->toArray();
        return view('class.onGoingClasses', [
            'onGoingClasses'=> $onGoingClasses,
            'Parent_onGoingClasses'=> $Parent_onGoingClasses,
            'SchoolYearOptions'=> $SchoolYearOptions,
            'SemesterOptions'=> $SemesterOptions,
            'SchoolYearID'=> $SchoolYearID,
            'SemesterID'=> $SemesterID
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->input('schoolYear_id') != null) {
            $onGoingClasses = DB::table('classes')
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
                                ['classes.progress', '=', 'on going'],
                                ['classes.schoolYear_id', '=', $request->input('schoolYear_id')],
                                ['classes.semester_id', '=', $request->input('semester_id')]
                                ])
                            ->get();
            $Parent_onGoingClasses = DB::table('classes')
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
                                        ['classes.progress', '=', 'on going'],
                                        ['classes.schoolYear_id', '=', $request->input('schoolYear_id')],
                                        ['classes.semester_id', '=', $request->input('semester_id')]
                                        ])
                                    ->get();
            //Option Purpose
            $SchoolYear = DB::table('school_years')
                                ->select(
                                    'school_years.id as school_years_id',
                                    'school_years.name as school_years_name'
                                )
                                ->get();
            $SchoolYearOptions = $SchoolYear->pluck('school_years_name', 'school_years_id')->toArray();
            $SchoolYearID = $request->input('schoolYear_id');
            $Semesters = DB::table('semesters')
                                ->select(
                                    'semesters.id as semester_id',
                                    'semesters.name as semester_name'
                                    )
                                ->get();

            $SemesterOptions = $Semesters->pluck('semester_name', 'semester_id')->toArray();
            $SemesterID = $request->input('semester_id');
            return view('class.onGoingClasses', [
                'onGoingClasses'=> $onGoingClasses,
                'Parent_onGoingClasses'=> $Parent_onGoingClasses,
                'SchoolYearOptions'=> $SchoolYearOptions,
                'SemesterOptions'=> $SemesterOptions,
                'SchoolYearID'=> $SchoolYearID,
                'SemesterID'=> $SemesterID
                ]);
        } else {
            return redirect('/onGoingClasses');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
