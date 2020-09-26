<?php

namespace App\Http\Controllers;

use App\Quiz;
use App\QuizItem;
use App\Quiz_tf;
use App\Quiz_mu;
use App\Quiz_mu_choice;
use App\Quiz_or;
use App\Quiz_or_column;
use App\Quiz_fi;
use App\Quiz_fi_blank_answer;
use App\Quiz_es;
use App\Quiz_ma;
use App\Quiz_ma_column;
use App\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Auth;

class GenerateQuizzesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($quiz_id)
    {
        $quiz_infos = Quiz::find($quiz_id);
        $subjects = Subject::all();
        $subjectOptions = array('' => '-- Select Subject --') + $subjects->pluck('name', 'id')->toArray();

        $quiz_items = DB::table('quiz_items')
                            ->where('quiz_items.quiz_id', '=', $quiz_id)
                            ->get();

        $total_items = DB::table('quiz_items')
                            ->where('quiz_items.quiz_id', '=', $quiz_id)
                            ->count();

        $total_score = DB::table('quiz_items')
                            ->where('quiz_items.quiz_id', '=', $quiz_id)
                            ->sum('itemScore');

        $quizItem_info = null;

        return view('resource.onlineQuizsDetail',[
            'quiz_infos'=>$quiz_infos,
            'subjectOptions'=>$subjectOptions,
            'quiz_id'=>$quiz_id,
            'quiz_items'=>$quiz_items,
            'quizItem_info'=>$quizItem_info,
            'total_items'=>$total_items,
            'total_score'=>$total_score
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $quiz_id)
    {
        $quiz_infos = Quiz::find($quiz_id);
        $subjects = Subject::all();
        $subjectOptions = array('' => '-- Select Subject --') + $subjects->pluck('name', 'id')->toArray();

        $quiz_items = DB::table('quiz_items')
                            ->where('quiz_items.quiz_id', '=', $quiz_id)
                            ->get();

        $total_items = DB::table('quiz_items')
                            ->where('quiz_items.quiz_id', '=', $quiz_id)
                            ->count();

        $total_score = DB::table('quiz_items')
                            ->where('quiz_items.quiz_id', '=', $quiz_id)
                            ->sum('itemScore');

        $quiz_type = $request->input('quiz_type');

        return view('resource.onlineQuizsCreate', [
            'quiz_type'=>$quiz_type,
            'quiz_infos'=>$quiz_infos,
            'subjectOptions'=>$subjectOptions,
            'quiz_items'=>$quiz_items,
            'quiz_id'=>$quiz_id,
            'total_items'=>$total_items,
            'total_score'=>$total_score
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $quiz_id)
    {
        if($request->input('quiz_type') === "quiz_tfs"){

            $this->validate($request, [
                'itemScore' => 'required',
                'statement' => 'required',
                'answer' => 'required',
                'correctionCheck' => 'nullable',
                'trueAnswer' => 'nullable',
                'falseAnswer' => 'nullable'
            ]);

            $quiz_tfs = new Quiz_tf;
            $quiz_tfs->statement = $request->input('statement');
            $quiz_tfs->answer = $request->input('answer');
            $quiz_tfs->correctionCheck = $request->input('correctionCheck');
            $quiz_tfs->trueAnswer = $request->input('trueAnswer');
            $quiz_tfs->falseAnswer = $request->input('falseAnswer');
            $quiz_tfs->save();

            $quiz_items = new QuizItem;
            $quiz_items->quiz_id = $quiz_id;
            $quiz_items->quiz_type = $request->input('quiz_type');
            $quiz_items->quiz_tf_id = $quiz_tfs->id;
            $quiz_items->itemScore = $request->input('itemScore');
            $quiz_items->save();

            return redirect('/onlineQuizsStorage'.'/'.$quiz_id.'/item')->with('success', 'Added Quiz Item : True / False');
        }elseif($request->input('quiz_type') === "quiz_mus"){
            $this->validate($request, [
                'itemScore' => 'required',
                'statement' => 'required',
                'name.*' => 'required',
                'correctCheck.*' => 'nullable'
            ]);

            $quiz_mu = new Quiz_mu;
            $quiz_mu->statement = $request->input('statement');
            $quiz_mu->save();

            for($i= 0; $i<count($request->input('correctCheck')); $i++){
                $quiz_mu_choices[] = [
                    'quiz_mu_id' => $quiz_mu->id,
                    'name' =>  $request->input('name')[$i],
                    'correctCheck' => $request->input('correctCheck')[$i],
                ];
            }
            DB::table('quiz_mu_choices')->insert($quiz_mu_choices);

            $quiz_items = new QuizItem;
            $quiz_items->quiz_id = $quiz_id;
            $quiz_items->quiz_type = $request->input('quiz_type');
            $quiz_items->quiz_mu_id = $quiz_mu->id;
            $quiz_items->itemScore = $request->input('itemScore');
            $quiz_items->save();

            return redirect('/onlineQuizsStorage'.'/'.$quiz_id.'/item')->with('success', 'Added Quiz Item : Multiple Choice');
        }elseif($request->input('quiz_type') === "quiz_ors"){
            $this->validate($request, [
                'itemScore' => 'required',
                'statement' => 'required',
                'order_no.*' => 'required',
                'column.*' => 'required'
            ]);

            $quiz_or = new Quiz_or;
            $quiz_or->statement = $request->input('statement');
            $quiz_or->save();

            for($i= 0; $i<count($request->input('order_no')); $i++){
                $quiz_or_columns[] = [
                    'quiz_or_id' => $quiz_or->id,
                    'order_no' =>  $request->input('order_no')[$i],
                    'column' => $request->input('column')[$i],
                ];
            }
            DB::table('quiz_or_columns')->insert($quiz_or_columns);

            $quiz_items = new QuizItem;
            $quiz_items->quiz_id = $quiz_id;
            $quiz_items->quiz_type = $request->input('quiz_type');
            $quiz_items->quiz_or_id = $quiz_or->id;
            $quiz_items->itemScore = $request->input('itemScore');
            $quiz_items->save();

            return redirect('/onlineQuizsStorage'.'/'.$quiz_id.'/item')->with('success', 'Added Quiz Item : Ordering');
        }elseif($request->input('quiz_type') === "quiz_fis"){
            $this->validate($request, [
                'itemScore' => 'required',
                'statement' => 'required',
                'answer.*' => 'required',
            ]);


            $quiz_fi = new Quiz_fi;
            $quiz_fi->statement = $request->input('statement');
            $quiz_fi->save();

            for($i= 0; $i<count($request->input('answer')); $i++){
                $quiz_fi_blank_answers[] = [
                    'quiz_fi_id' => $quiz_fi->id,
                    'answer' =>  $request->input('answer')[$i],
                ];
            }
            DB::table('quiz_fi_blank_answers')->insert($quiz_fi_blank_answers);

            $quiz_items = new QuizItem;
            $quiz_items->quiz_id = $quiz_id;
            $quiz_items->quiz_type = $request->input('quiz_type');
            $quiz_items->quiz_fi_id = $quiz_fi->id;
            $quiz_items->itemScore = $request->input('itemScore');
            $quiz_items->save();

            return redirect('/onlineQuizsStorage'.'/'.$quiz_id.'/item')->with('success', 'Added Quiz Item : Fill-in-blank');
            
        }elseif($request->input('quiz_type') === "quiz_mas"){
            $this->validate($request, [
                'itemScore' => 'required',
                'statement' => 'required',
                'quiestionColumn.*' => 'required',
                'answerColumn.*' => 'required'
            ]);

            $quiz_ma = new Quiz_ma;
            $quiz_ma->statement = $request->input('statement');
            $quiz_ma->save();

            for($i= 0; $i<count($request->input('quiestionColumn')); $i++){
                $quiz_ma_columns[] = [
                    'quiz_ma_id' => $quiz_ma->id,
                    'quiestionColumn' =>  $request->input('quiestionColumn')[$i],
                    'answerColumn' => $request->input('answerColumn')[$i],
                ];
            }
            DB::table('quiz_ma_columns')->insert($quiz_ma_columns);

            $quiz_items = new QuizItem;
            $quiz_items->quiz_id = $quiz_id;
            $quiz_items->quiz_type = $request->input('quiz_type');
            $quiz_items->quiz_ma_id = $quiz_ma->id;
            $quiz_items->itemScore = $request->input('itemScore');
            $quiz_items->save();

            return redirect('/onlineQuizsStorage'.'/'.$quiz_id.'/item')->with('success', 'Added Quiz Item : Matching Type');
        }elseif($request->input('quiz_type') === "quiz_es"){

            $this->validate($request, [
                'itemScore' => 'required',
                'statement' => 'required'
            ]);

            $quiz_es = new Quiz_es;
            $quiz_es->statement = $request->input('statement');
            $quiz_es->save();

            $quiz_items = new QuizItem;
            $quiz_items->quiz_id = $quiz_id;
            $quiz_items->quiz_type = $request->input('quiz_type');
            $quiz_items->quiz_es_id = $quiz_es->id;
            $quiz_items->itemScore = $request->input('itemScore');
            $quiz_items->save();

            return redirect('/onlineQuizsStorage'.'/'.$quiz_id.'/item')->with('success', 'Added Quiz Item : Essay');
        }else{
            redirect('/onlineQuizsStorage'.'/'.$quiz_id.'/item');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($quiz_id, $item)
    {
        $quiz_infos = Quiz::find($quiz_id);
        $subjects = Subject::all();
        $subjectOptions = array('' => '-- Select Subject --') + $subjects->pluck('name', 'id')->toArray();

        $quiz_items = DB::table('quiz_items')
                            ->where('quiz_items.quiz_id', '=', $quiz_id)
                            ->get();

        $total_items = DB::table('quiz_items')
                            ->where('quiz_items.quiz_id', '=', $quiz_id)
                            ->count();

        $total_score = DB::table('quiz_items')
                            ->where('quiz_items.quiz_id', '=', $quiz_id)
                            ->sum('itemScore');

        $quizItem_info = QuizItem::find($item);
        $quiz_tf = Quiz_tf::find($quizItem_info->quiz_tf_id);
        $quiz_mu = Quiz_mu::find($quizItem_info->quiz_mu_id);
        $quiz_mu_choices = Quiz_mu_choice::where('quiz_mu_id', $quizItem_info->quiz_mu_id)->get();
        $quiz_or = Quiz_or::find($quizItem_info->quiz_or_id);
        $quiz_or_columns = Quiz_or_column::where('quiz_or_id', $quizItem_info->quiz_or_id)->get();
        $quiz_fi = Quiz_fi::find($quizItem_info->quiz_fi_id);
        $quiz_fi_blank_answers = Quiz_fi_blank_answer::where('quiz_fi_id', $quizItem_info->quiz_fi_id)->get();
        $quiz_es = Quiz_es::find($quizItem_info->quiz_es_id);
        $quiz_ma = Quiz_ma::find($quizItem_info->quiz_ma_id);
        $quiz_ma_columns = Quiz_ma_column::where('quiz_ma_id', $quizItem_info->quiz_ma_id)->get();
        return view('resource.onlineQuizsDetail',[
            'item'=>$item,
            'quiz_infos'=>$quiz_infos,
            'subjectOptions'=>$subjectOptions,
            'quiz_id'=>$quiz_id,
            'quiz_items'=>$quiz_items,
            'quizItem_info'=>$quizItem_info,
            'quiz_tf'=>$quiz_tf,
            'quiz_mu'=>$quiz_mu,
            'quiz_mu_choices'=>$quiz_mu_choices,
            'quiz_or'=>$quiz_or,
            'quiz_or_columns'=>$quiz_or_columns,
            'quiz_fi'=>$quiz_fi,
            'quiz_fi_blank_answers'=>$quiz_fi_blank_answers,
            'quiz_es'=>$quiz_es,
            'quiz_ma'=>$quiz_ma,
            'quiz_ma_columns'=>$quiz_ma_columns,
            'total_items'=>$total_items,
            'total_score'=>$total_score
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($quiz_id, $item)
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
    public function update(Request $request, $quiz_id, $item)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($quiz_id, $item)
    {
        $quiz_type = QuizItem::find($item)->quiz_type;
        $quizItem_info = QuizItem::find($item);

        if($quiz_type === "quiz_tfs"){
            $quiz_tf = Quiz_tf::find($quizItem_info->quiz_tf_id);
            $quizItem_info->delete();
            $quiz_tf->delete();
            return redirect('/onlineQuizsStorage'.'/'.$quiz_id.'/item')->with('success', 'Deleted Quiz Item : True / False');
        }elseif($quiz_type === "quiz_mus"){
            $quiz_mu = Quiz_mu::find($quizItem_info->quiz_mu_id);
            $quiz_mu_choices = Quiz_mu_choice::where('quiz_mu_id', $quizItem_info->quiz_mu_id)->delete();
            $quizItem_info->delete();
            $quiz_mu->delete();
            return redirect('/onlineQuizsStorage'.'/'.$quiz_id.'/item')->with('success', 'Deleted Quiz Item : Multiple Choice');
        }elseif($quiz_type === "quiz_ors"){
            $quiz_or = Quiz_or::find($quizItem_info->quiz_or_id);
            $quiz_or_columns = Quiz_or_column::where('quiz_or_id', $quizItem_info->quiz_or_id)->delete();
            $quizItem_info->delete();
            $quiz_or->delete();
            return redirect('/onlineQuizsStorage'.'/'.$quiz_id.'/item')->with('success', 'Deleted Quiz Item : Ordering');
        }elseif($quiz_type === "quiz_fis"){
            $quiz_fi = Quiz_fi::find($quizItem_info->quiz_fi_id);
            $quiz_fi_blank_answers = Quiz_fi_blank_answer::where('quiz_fi_id', $quizItem_info->quiz_fi_id)->delete();
            $quizItem_info->delete();
            $quiz_fi->delete();
            return redirect('/onlineQuizsStorage'.'/'.$quiz_id.'/item')->with('success', 'Deleted Quiz Item : Fill-in-blank');
            
        }elseif($quiz_type === "quiz_mas"){
            $quiz_ma = Quiz_ma::find($quizItem_info->quiz_ma_id);
            $quiz_ma_columns = Quiz_ma_column::where('quiz_ma_id', $quizItem_info->quiz_ma_id)->delete();
            $quizItem_info->delete();
            $quiz_ma->delete();
            return redirect('/onlineQuizsStorage'.'/'.$quiz_id.'/item')->with('success', 'Deleted Quiz Item : Matching Type');
        }elseif($quiz_type === "quiz_es"){
            $quiz_es = Quiz_es::find($quizItem_info->quiz_es_id);
            $quizItem_info->delete();
            $quiz_es->delete();
            return redirect('/onlineQuizsStorage'.'/'.$quiz_id.'/item')->with('success', 'Deleted Quiz Item : Essay');
        }else{
            redirect('/onlineQuizsStorage'.'/'.$quiz_id.'/item');
        }
    }
}
