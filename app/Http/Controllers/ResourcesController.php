<?php

namespace App\Http\Controllers;

use App\User;
use App\resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Auth;

class ResourcesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = Auth::user()->id;
        $Resources = resource::where('user_id', '=', $user_id)->get();
        return view('resource.resource')->with('Resources', $Resources);
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
            'resource_location' => 'required|file|max:50000|mimes:pdf,docx,doc,ppt,pptx,xls,xlsx,jpg,jpeg,png',
            'name' => 'required'
        ]);

        // Get filename with the extension
        $filenameWithExt = $request->file('resource_location')->getClientOriginalName();
        // Get just filename
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        $extension = $request->file('resource_location')->getClientOriginalExtension();
        // Filename to store
        $fileNameToStore = $filename.'_'.time().'.'.$extension;
        // Upload Image
        $path = $request->file('resource_location')->storeAs('public/resources', $fileNameToStore);
        
        $size = $request->file('resource_location')->getSize();

        $resource = new resource;
        $resource->user_id = Auth::user()->id;
        $resource->name = $request->input('name');
        $resource->resourceType = $extension;
        $resource->size = $size;
        $resource->resource_location = $fileNameToStore;
        $resource->save();

        return redirect('/resource')->with('success', 'New File Uploaded!');
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
        $Resource = resource::find($id);

        // Delete Image
        Storage::delete('public/resources/'.$Resource->resource_location);
        $Resource->delete();

        return redirect('/resource')->with('success', 'File Deleted!');
    }
}
