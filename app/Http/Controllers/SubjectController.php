<?php

namespace App\Http\Controllers;

use App\Subject;
use App\SubjectType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $typeOneSubjects = DB::table('subjects')
                        ->select('subjects.name', 'subjects.gradeLevel', 'subjects.NumberOfHours', 'subjects.id')
                        ->orderBy('subjects.id')
                        ->where('subjects.subjectType_id', '=', '1')
                        ->get();
        $typeTwoSubjects = DB::table('subjects')
                        ->select('subjects.name', 'subjects.gradeLevel', 'subjects.NumberOfHours', 'subjects.id')
                        ->orderBy('subjects.id')
                        ->where('subjects.subjectType_id', '=', '2')
                        ->get();
        $typeThreeSubjects = DB::table('subjects')
                        ->select('subjects.name', 'subjects.gradeLevel', 'subjects.NumberOfHours', 'subjects.id')
                        ->orderBy('subjects.id')
                        ->where('subjects.subjectType_id', '=', '3')
                        ->get();
        $typeFourSubjects = DB::table('subjects')
                        ->select('subjects.name', 'subjects.gradeLevel', 'subjects.NumberOfHours', 'subjects.id')
                        ->orderBy('subjects.id')
                        ->where('subjects.subjectType_id', '=', '4')
                        ->get();
        return view('class.subjectCatalog', ['typeOneSubjects' => $typeOneSubjects, 'typeTwoSubjects' => $typeTwoSubjects, 'typeThreeSubjects' => $typeThreeSubjects, 'typeFourSubjects' => $typeFourSubjects]);
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
            'subjectType' => 'required',
            'subject_name' => 'required',
            'gradeLevel' => 'required',
            'NumberOfHours' => 'required'
        ]);

        $subject = new Subject;
        $subject->subjectType_id = $request->input('subjectType');
        $subject->name = $request->input('subject_name');
        $subject->gradeLevel = $request->input('gradeLevel');
        $subject->NumberOfHours = $request->input('NumberOfHours');
        $subject->save();

        return redirect('/subjectCatalog')->with('success', 'Subject Added!');
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
        $this->validate($request, [
            'subject_name' => 'required',
            'gradeLevel' => 'required',
            'NumberOfHours' => 'required'
        ]);

        $subject = Subject::find($id);
        $subject->name = $request->input('subject_name');
        $subject->gradeLevel = $request->input('gradeLevel');
        $subject->NumberOfHours = $request->input('NumberOfHours');
        $subject->save();

        return redirect('/subjectCatalog')->with('success', 'Subject Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subject = Subject::find($id);
        $subject->delete();
        return redirect('/subjectCatalog')->with('success', 'Subject Removed!');
    }
}
