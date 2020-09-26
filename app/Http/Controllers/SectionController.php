<?php

namespace App\Http\Controllers;

use App\Section;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class SectionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sections = DB::table('sections')
                    ->select('sections.id', 'sections.name', 'sections.gradeLevel', 'sections.description', 'sections.sectionPic_locaiton')
                    ->get();

        $users = DB::table('users')
                    ->select('users.id', 'users.name')
                    ->where([
                        ['users.userType_id', '=', '2'],
                        ['users.usable', '=', 'active']
                    ])
                    ->get();
        return view('account.sectionCatalog', ['sections' => $sections]);
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
        $this->validate($request, [
            'sectionPic_locaiton' => 'image|nullable|max:1999',
            'name' => 'required',
            'gradeLevel' => 'required',
            'description' => 'required'
        ]);

        // Handle File Upload
        if ($request->hasFile('sectionPic_locaiton')) {
            // Get filename with the extension
            $filenameWithExt = $request->file('sectionPic_locaiton')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('sectionPic_locaiton')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore = $filename.'_'.time().'.'.$extension;
            // Upload Image
            $path = $request->file('sectionPic_locaiton')->storeAs('public/images/section', $fileNameToStore);
        } else{
            $fileNameToStore = 'noimage.jpg';
        }

        $section = new Section;
        $section->sectionPic_locaiton = $fileNameToStore;
        $section->name = $request->input('name');
        $section->gradeLevel = $request->input('gradeLevel');
        $section->description = $request->input('description');
        $section->save();
        
        return redirect('/sectionCatalog')->with('success', 'New Section Created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $section = Section::find($id);
        $sectionID = $section->id;

        $students = DB::table('users')
                    ->select('users.name', 'users.school_id')
                    ->where([
                        ['users.userType_id', '=', '3'],
                        ['users.section_id', '=', $sectionID]
                        ])
                    ->get();
        return view('account.sectionmate', ['section'=> $section, 'students'=> $students]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
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
            'name' => 'required',
            'gradeLevel' => 'required',
            'description' => 'required'
        ]);

        // Handle File Upload
        if ($request->hasFile('sectionPic_locaiton')) {
            // Get filename with the extension
            $filenameWithExt = $request->file('sectionPic_locaiton')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('sectionPic_locaiton')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore = $filename.'_'.time().'.'.$extension;
            // Upload Image
            $path = $request->file('sectionPic_locaiton')->storeAs('public/images/section', $fileNameToStore);
        }

        $section = Section::find($id);
        if ($request->hasFile('sectionPic_locaiton')){
            $section->sectionPic_locaiton = $fileNameToStore;
        }
        $section->name = $request->input('name');
        $section->gradeLevel = $request->input('gradeLevel');
        $section->description = $request->input('description');
        $section->save();

        return redirect('/sectionCatalog')->with('success', 'Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $section = Section::find($id);


        if($section->sectionPic_locaiton != 'noimage.jpg'){
            // Delete Image
            Storage::delete('public/images/section/'.$section->sectionPic_locaiton);
        }


        $section->delete();
        return redirect('/sectionCatalog')->with('success', 'Section Deleted!');
    }
}
