<?php

namespace App\Http\Controllers;
use App\User;
use App\UserType;
use App\Section;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $profileID = Auth::user()->id;
        $profileInfos = DB::table('users')
                        ->select(
                            'users.id as user_id',
                            'users.profilePic_location',
                            'user_types.name as type_name', 
                            'users.name as user_name',
                            'sections.name as section_name',
                            'users.birthday',
                            'users.school_id',
                            'users.address',
                            'users.email',
                            'users.tel'
                            )
                        ->join('user_types', 'users.userType_id', '=', 'user_types.id')
                        ->leftJoin('sections', 'users.section_id', '=', 'sections.id')
                        ->where('users.id', '=', $profileID)
                        ->get();

        return view('account.viewAccountDetail', ['profileInfos' => $profileInfos]);
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
            'birthday' => 'nullable',
            'address' => 'nullable',
            'email' => 'required',
            'tel' => 'nullable|numeric|digits_between:9,13'
        ]);

        
        if ($request->hasFile('profilePic_location')) {
            // Get filename with the extension
            $filenameWithExt = $request->file('profilePic_location')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('profilePic_location')->getClientOriginalExtension();
            // Filename to store
            $fileNameToStore = $filename.'_'.time().'.'.$extension;
            // Upload Image
            $path = $request->file('profilePic_location')->storeAs('public/images/account', $fileNameToStore);
        }

        $profileInfo = User::find($id);
        if($request->hasFile('profilePic_location')){
            $profileInfo->profilePic_location = $fileNameToStore;
        }
        $profileInfo->birthday= $request->input('birthday');
        $profileInfo->address= $request->input('address');
        $profileInfo->email= $request->input('email');
        $profileInfo->tel= $request->input('tel');
        $profileInfo->save();

        return redirect('/viewAccountDetail')->with('success', 'Updated!');

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
