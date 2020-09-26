@extends('layouts.takeQuiz')

@section('takeQuiz-main')
    @if (isset($quizItem_info))
        @if($quizItem_info->quiz_type === 'quiz_tfs')
            {!! Form::open(['action' => ['TakeQuizController@store', $class_id, $quiz_id], 'method' => 'POST']) !!}
                <div class="form-group row justify-content-end">
                    <div class="col-md-3">
                        {{Form::label('itemScore', 'Item Score : '.$quizItem_info->itemScore)}}
                    </div>
                </div>
                <div class="form-group" style="background-color: white;">
                    {!! $quiz_tf->statement !!}
                </div>
                <div class="row justify-content-end">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <div class="col-md-6">
                                {{Form::label('answer', 'Correct Answer')}}
                            </div>
                            <div class="col-md-6">
                                {{Form::select('answer', [ 'true' => 'true', 'false' => 'false'], '', ['class' => 'form-control','id' => 'tfAnswer'])}}
                            </div>
                        </div>
                    </div>
                </div>
                @if ($quiz_tf->correctionCheck != null)
                    <div class="row justify-content-end" id="falsediv">
                        <div class="col-md-8">
                            <div class="form-group row">
                                <div class="col-md-4">
                                    {{Form::label('trueAnswer', 'True Answer":')}}
                                </div>
                                <div class="col-md-8">
                                    {{Form::text('trueAnswer', '', ['class' => 'form-control'])}}
                                </div>
                            </div>
                        </div>
                    </div> 
                @endif
                <div class="form-group text-right">
                    {{Form::text('quiz_type', 'quiz_tfs', ['class' => 'form-control', 'hidden' => 'true'])}}
                        {{Form::text('quiz_items_id', $takeQuiz, ['hidden' => true])}}
                    {{Form::button('Next', ['class' => 'btn btn-info', 'type' => 'submit'])}}
                </div>
            {!! Form::close() !!}
        @elseif($quizItem_info->quiz_type === 'quiz_mus')
            {!! Form::open(['action' => ['TakeQuizController@store', $class_id, $quiz_id], 'method' => 'POST']) !!}
                <div class="form-group row justify-content-end">
                    <div class="col-md-3">
                        {{Form::label('itemScore', 'Item Score : '.$quizItem_info->itemScore)}}
                    </div>
                </div>
                <div class="form-group" style="background-color: white;">
                    {!! $quiz_mu->statement !!}
                </div>
                <div class="form-group">
                    <div class="row justify-content-end">
                        <div class="col-md-3 text-center">
                            {{Form::label('CorrectAnswer', 'Correct Answer')}}
                        </div>
                    </div>
                    <div class="row" id="choice_form">
                        @foreach ($quiz_mu_choices as $quiz_mu_choice)
                            <div class="col-md-2">
                                <label>Choice : </label>
                            </div>
                            <div class="col-md-7">
                                <input type="text" name="name[]" class="form-control" value="{{$quiz_mu_choice->name}}" readonly>
                            </div>
                            <div class="col-md-3 text-center">
                                {{ Form::select('correctCheck[]', [0 => 'x', 1 => 'o'], null, ['class' => 'form-control']) }}
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="form-group text-right">
                    {{Form::text('quiz_type', 'quiz_mus', ['class' => 'form-control', 'hidden' => 'true'])}}
                    {{Form::text('quiz_items_id', $takeQuiz, ['hidden' => true])}}
                    {{Form::button('Next', ['class' => 'btn btn-info', 'type' => 'submit'])}}
                </div>
                {!! Form::close() !!}
        @elseif($quizItem_info->quiz_type === 'quiz_ors')
            {!! Form::open(['action' => ['TakeQuizController@store', $class_id, $quiz_id], 'method' => 'POST']) !!}
                <div class="form-group row justify-content-end">
                    <div class="col-md-3">
                        {{Form::label('itemScore', 'Item Score : '.$quizItem_info->itemScore)}}
                    </div>
                </div>
                <div class="form-group" style="background-color: white;">
                    {!! $quiz_or->statement !!}
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="row" id="quiz_or_answer">
                                @foreach ($quiz_or_columns as $quiz_or_column)
                                    <div class="col-md-3"><input type="text" name="order_no" id="ordering" value="{{$quiz_or_column->order_no}}" class="form-control" readonly></div>
                                    <div class="col-md-9"><input type="text" name="column[]" class="form-control"></div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group text-right">
                    {{Form::text('quiz_type', 'quiz_ors', ['class' => 'form-control', 'hidden' => 'true'])}}
                    {{Form::text('quiz_items_id', $takeQuiz, ['hidden' => true])}}
                    {{Form::button('Next', ['class' => 'btn btn-info', 'type' => 'submit'])}}
                </div>
            {!! Form::close() !!}
        @elseif($quizItem_info->quiz_type === 'quiz_fis')
            {!! Form::open(['action' => ['TakeQuizController@store', $class_id, $quiz_id], 'method' => 'POST']) !!}
            <div class="form-group row justify-content-end">
                    <div class="col-md-3">
                        {{Form::label('itemScore', 'Item Score : '.$quizItem_info->itemScore)}}
                    </div>
                </div>
                <div class="form-group" style="background-color: white;">
                    {!! $quiz_fi->statement !!}
                </div>
                <div class="form-group">
                    <div id="quiz_fi_answer">
                        <div class="row justify-content-end">
                            <div class="col-md-2"><label>Answer</label></div>
                            <div class="col-md-9"><input type="text" name="answer"class="form-control"></div>
                        </div>
                    </div>
                </div>
                <div class="form-group text-right">
                    {{Form::text('quiz_type', 'quiz_fis', ['class' => 'form-control', 'hidden' => 'true'])}}
                    {{Form::text('quiz_items_id', $takeQuiz, ['hidden' => true])}}
                    {{Form::button('Next', ['class' => 'btn btn-info', 'type' => 'submit'])}}
                </div>
            {!! Form::close() !!}
        @elseif($quizItem_info->quiz_type === 'quiz_mas')
            {!! Form::open(['action' => ['TakeQuizController@store', $class_id, $quiz_id], 'method' => 'POST']) !!}
                <div class="form-group row justify-content-end">
                    <div class="col-md-3">
                        {{Form::label('itemScore', 'Item Score : '.$quizItem_info->itemScore)}}
                    </div>
                </div>
                <div class="form-group" style="background-color: white;">
                    {!! $quiz_ma->statement !!}
                </div>
                <div class="form-group">
                    <table>
                        <thead>
                            <tr>
                                <th colspan="2"><label>Choice :</label></th>
                            </tr>
                            @foreach ($quiz_ma_choices as $quiz_ma_choice)
                                <tr>
                                    <th colspan="2"><input type="text" name="choice" class="form-control" value="{{$quiz_ma_choice->answerColumn}}" readonly></th>
                                </tr>
                            @endforeach
                            <tr>
                                <th><label>Question Column :</label></th>
                                <th><label>Answer Column :</label></th>
                            </tr>
                        </thead>
                        <tbody id="quiz_ma_column">
                            @foreach ($quiz_ma_columns as $quiz_ma_column)
                                <tr>
                                    <td><input type="text" name="quiestionColumn" class="form-control" value="{{$quiz_ma_column->quiestionColumn}}"></td>
                                    <td><input type="text" name="answerColumn[]" class="form-control"></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="form-group text-right">
                    {{Form::text('quiz_type', 'quiz_mas', ['class' => 'form-control', 'hidden' => 'true'])}}
                    {{Form::text('quiz_items_id', $takeQuiz, ['hidden' => true])}}
                    {{Form::button('Next', ['class' => 'btn btn-info', 'type' => 'submit'])}}
                </div>
            {!! Form::close() !!}
        @elseif($quizItem_info->quiz_type === 'quiz_es')
            {!! Form::open(['action' => ['TakeQuizController@store', $class_id, $quiz_id], 'method' => 'POST']) !!}
                <div class="form-group row justify-content-end">
                    <div class="col-md-3">
                        {{Form::label('itemScore', 'Item Score : '.$quizItem_info->itemScore)}}
                    </div>
                </div>
                <div class="form-group" style="background-color: white;">
                    {!! $quiz_es->statement !!}
                </div>
                <div class="form-group">
                    {{Form::textarea('myEssay', '', ['class' => 'form-control', 'id' => 'article-ckeditor'])}}
                </div>
                <div class="form-group text-right">
                    {{Form::text('quiz_type', 'quiz_es', ['class' => 'form-control', 'hidden' => 'true'])}}
                    {{Form::text('quiz_items_id', $takeQuiz, ['hidden' => true])}}
                    {{Form::button('Next', ['class' => 'btn btn-info', 'type' => 'submit'])}}
                </div>
            {!! Form::close() !!}
        @endif
    @elseif($total_takenItems == 0)
        {!! Form::open(['action' => ['TakeQuizController@update', $class_id, $quiz_id, 1], 'method' => 'POST', 'class' => 'text-center']) !!}
            {{Form::hidden('_method', 'PUT')}}
            {{Form::button('submit', ['class' => 'btn btn-info', 'type' => 'submit'])}}
        {!! Form::close() !!}
    @endif
@endsection