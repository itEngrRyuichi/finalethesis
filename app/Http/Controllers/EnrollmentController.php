<?php

namespace App\Http\Controllers;
use App\Subject;
use App\Clas;
use App\leadToClass;
use App\Accesscode;
use App\User;
use App\enrollment;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $enrollLists = DB::table('classes')
                        ->select(
                            'enrollments.id as enrollment_id',
                            'classes.id as class_id',
                            'classes.stubcode',
                            'classes.coursecode',
                            'classes.progress',
                            'classes.subject_id',
                            'subjects.name as subject_name',
                            'subjects.gradeLevel'
                            )
                        ->leftJoin('subjects', 'classes.subject_id', '=', 'subjects.id')
                        ->leftJoin('enrollments', 'classes.id', '=', 'enrollments.class_id')
                        ->leftJoin('users', 'enrollments.user_id', '=', 'users.id')
                        ->where('users.id', '=', Auth::user()->id)
                        ->get();

        return view('class.enrollment')->with('enrollLists', $enrollLists);
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
        $this->validate($request, [
            'accesscode' => 'required'
        ]);

        $access_id = $request->input('accesscode');
        $accesscode = Accesscode::where('accesscode', $access_id)->first();
        $leadToClass_id = $accesscode->id;
        $leadToclass = leadToClass::where('access_id',  $leadToClass_id)->first();
        $class_id = $leadToclass->lead_id;

        $enroll = new enrollment;
        $enroll->class_id = $class_id;
        $enroll->user_id = Auth::user()->id;
        $enroll->save();

        return redirect('/enrollment')->with('success', 'You Enrolled!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $enroll = enrollment::find($id);
        $enroll->delete();
        return redirect('/enrollment')->with('success', 'withdraw');
    }
}
