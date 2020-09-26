<?php

namespace App\Http\Controllers;

use App\User;
use App\enrollment;
use App\Clas;
use App\Subject;
use App\Component;
use App\SubjectType;
use App\ClassResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Auth;

class ClassResourcesController extends Controller
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

        $classResources = ClassResource::where('class_id', '=', $class_id)->get();
        

        return view('class.viewClass.resources', [
            'class_id'=> $class_id,
            'Class_details'=> $Class_details,
            'classResources'=> $classResources
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
        $this->validate($request, [
            'classResource_location' => 'required|file|max:50000|mimes:pdf,docx,doc,ppt,pptx,xls,xlsx,jpg,jpeg,png',
            'name' => 'required'
        ]);

        // Get filename with the extension
        $filenameWithExt = $request->file('classResource_location')->getClientOriginalName();
        // Get just filename
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        $extension = $request->file('classResource_location')->getClientOriginalExtension();
        // Filename to store
        $fileNameToStore = $filename.'_'.time().'.'.$extension;
        // Upload Image
        $path = $request->file('classResource_location')->storeAs('public/resources', $fileNameToStore);
        
        $size = $request->file('classResource_location')->getSize();

        $classResource = new ClassResource;
        $classResource->class_id = $class_id;
        $classResource->name = $request->input('name');
        $classResource->resourceType = $extension;
        $classResource->size = $size;
        $classResource->classResource_location = $fileNameToStore;
        $classResource->save();

        return redirect('/viewClass'.'/'.$class_id.'/resources')->with('success', 'New File Uploaded!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($class_id, $resource)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($class_id, $resource)
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
    public function update(Request $request, $class_id, $resource)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($class_id, $resource)
    {
        $classResource = ClassResource::find($resource);

        // Delete Image
        Storage::delete('public/resources/'.$classResource->classResource_location);
        $classResource->delete();

        return redirect('/viewClass'.'/'.$class_id.'/resources')->with('success', 'File Deleted!');
    }
}
