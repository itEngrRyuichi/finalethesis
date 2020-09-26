<?php

namespace App\Http\Controllers;
use App\User;
use App\UserType;
use App\Section;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AccountlistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->userType_id === 1) {
            $userLists = DB::table('users')
                        ->select(
                            'users.id as user_id',
                            'users.school_id',
                            'users.name as user_name'
                            )
                        ->orderBy('users.name', 'asc')
                        ->where([
                            ['users.userType_id', '=', '2'],
                            ['users.usable', '=', 'active'],
                            ])
                        ->get();
            return view('account.teacherAccountlist')->with('userLists', $userLists);
        } elseif(Auth::user()->userType_id === 2) {
            $userLists = DB::table('users')
                        ->select(
                            'users.id as user_id',
                            'users.school_id',
                            'users.name as user_name',
                            'users.section_id',
                            'sections.name as section_name'
                            )
                        ->join('sections', 'users.section_id', '=', 'sections.id')
                        ->orderBy('users.name', 'asc')
                        ->where([
                            ['users.userType_id', '=', '3'],
                            ['users.usable', '=', 'active'],
                            ])
                        ->get();
            return view('account.studentAccountlist')->with('userLists', $userLists);
        } elseif(Auth::user()->userType_id === 3) {
            $userLists = DB::table('users as parent')
                        ->select(
                            'parent.id as parent_id',
                            'parent.name as parent_name',
                            'child.id as child_id',
                            'child.name as child_name'
                            )
                        ->leftJoin('users as child', 'parent.child_id', '=', 'child.id')
                        ->where([
                            ['parent.userType_id', '=', '4'],
                            ['parent.usable', '=', 'active'],
                            ['child.id', '=', Auth::user()->id],
                            ])
                        ->get();
            return view('account.parentAccountlist')->with('userLists', $userLists);
        }
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
        $userList = User::find($id);
        $userList->usable = "passive";
        $userList->save();

        if (Auth::user()->userType_id === 1){
            return redirect('/teacherAccountlist')->with('success', $userList->name.' is passive');
        }elseif (Auth::user()->userType_id === 2) {
            return redirect('/studentAccountlist')->with('success', $userList->name.' is passive');
        }elseif (Auth::user()->userType_id === 3) {
            return redirect('/parentAccountlist')->with('success', $userList->name.' is passive');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $userList = User::find($id);
        $userList->delete();

        if (Auth::user()->userType_id === 1){
            return redirect('/teacherAccountlist')->with('success', $userList->name.' is Removed');
        }elseif (Auth::user()->userType_id === 2) {
            return redirect('/studentAccountlist')->with('success', $userList->name.' is Removed');
        }elseif (Auth::user()->userType_id === 3) {
            return redirect('/parentAccountlist')->with('success', $userList->name.' is Removed');
        }

    }
}
