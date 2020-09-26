<?php

namespace App\Http\Controllers;

use App\Subject;
use App\Quiz;
use App\QuizItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Auth;

class QuizStorageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subjects = Subject::all();
        $subjectOptions = array('' => '-- Select Subject --') + $subjects->pluck('name', 'id')->toArray();
        $quizzes = DB::table('quizzes')
                    ->select(
                        'subjects.name as subject_name',
                        'quizzes.name as quiz_name',
                        'quizzes.id as quiz_id',
                        'quizzes.created_at',
                        'quizzes.timer'
                        )
                    ->join('subjects', 'quizzes.subject_id', '=', 'subjects.id')
                    ->where('user_id', '=', Auth::user()->id)
                    ->get();

        return view('resource.onlineQuizsStorage', [
            'subjectOptions' => $subjectOptions,
            'quizzes'=> $quizzes
            ]);
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
            'name' => 'required',
            'subject_id' => 'nullable',
            'timer' => 'nullable'
        ]);

        $Quiz = new Quiz;
        $Quiz->user_id = Auth::user()->id;
        $Quiz->name = $request->input('name');
        $Quiz->subject_id = $request->input('subject_id');
        $Quiz->timer = $request->input('timer');
        $Quiz->save();

        return redirect('/onlineQuizsStorage')->with('success', 'New Quiz Added !');
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
            'name' => 'required',
            'subject_id' => 'nullable',
            'timer' => 'nullable'
        ]);

        $Quiz = Quiz::find($id);
        $Quiz->user_id = Auth::user()->id;
        $Quiz->name = $request->input('name');
        $Quiz->subject_id = $request->input('subject_id');
        $Quiz->timer = $request->input('timer');
        $Quiz->save();

        return redirect('/onlineQuizsStorage'.'/'.$id.'/item');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $quiz = Quiz::find($id);
        $quiz->delete();

        return redirect('/onlineQuizsStorage')->with('success', 'Quiz Removed!');
    }
}
