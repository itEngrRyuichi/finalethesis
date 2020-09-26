<?php

namespace App\Http\Controllers;

use App\User;
use App\enrollment;
use App\Clas;
use App\Subject;
use App\Component;
use App\SubjectType;
use App\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Auth;

class LessonsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $class_id = $id;
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
        return view('class.viewClass.lesson.createDetail', [
            'Class_details'=> $Class_details, 
            'class_id'=>$class_id
            ]);
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
            'lessonPic_location' => 'image|nullable|max:1999',
            'name' => 'required',
            'description' => 'required',
            'body' => 'required',
            'class_id' => 'required'
        ]);

        // Handle File Upload
        if ($request->hasFile('lessonPic_location')) {
            // Get filename with the extension
            $filenameWithExt = $request->file('lessonPic_location')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('lessonPic_location')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore = $filename.'_'.time().'.'.$extension;
            // Upload Image
            $path = $request->file('lessonPic_location')->storeAs('public/images/lesson', $fileNameToStore);
        } else{
            $fileNameToStore = 'default-lesson-image.jpg';
        }

        $LessonDetail = new Lesson;
        $LessonDetail->lessonPic_location = $fileNameToStore;
        $LessonDetail->class_id = $request->input('class_id');
        $LessonDetail->name = $request->input('name');
        $LessonDetail->description = $request->input('description');
        $LessonDetail->body = $request->input('body');
        $LessonDetail->save();

        return redirect('/viewClass'.'/'.$request->input('class_id'))->with('success', 'New Lesson Created!');


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($class_id, $detail)
    {
        $class_id = $class_id;
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
        $Lesson = Lesson::find($detail);
        return view('class.viewClass.lesson.detail', [
            'Class_details'=> $Class_details, 
            'class_id'=>$class_id,
            'Lesson'=>$Lesson,
            'detail'=>$detail
            ]);
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
    public function update(Request $request, $class_id, $detail)
    {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'body' => 'required',
            'class_id' => 'required'
        ]);

        // Handle File Upload
        if ($request->hasFile('lessonPic_location')) {
            // Get filename with the extension
            $filenameWithExt = $request->file('lessonPic_location')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('lessonPic_location')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore = $filename.'_'.time().'.'.$extension;
            // Upload Image
            $path = $request->file('lessonPic_location')->storeAs('public/images/lesson', $fileNameToStore);
        }

        $Lesson = Lesson::find($detail);
        if ($request->hasFile('lessonPic_location')){
            $Lesson->lessonPic_location = $fileNameToStore;
        }
        $Lesson->name = $request->input('name');
        $Lesson->description = $request->input('description');
        $Lesson->body = $request->input('body');
        $Lesson->class_id = $class_id;
        $Lesson->save();

        return redirect('/viewClass'.'/'.$class_id)->with('success', 'New Lesson Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($class_id, $detail)
    {
        $Lesson = Lesson::find($detail);


        if($Lesson->lessonPic_location != 'default-lesson-image.jpg'){
            // Delete Image
            Storage::delete('public/images/lesson/'.$Lesson->lessonPic_location);
        }


        $Lesson->delete();
        return redirect('/viewClass'.'/'.$class_id)->with('success', 'Lesson Deleted!');
    }
}
