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

class CompletedClassesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
