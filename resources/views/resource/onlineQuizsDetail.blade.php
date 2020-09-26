@extends('layouts.quiz')

@section('quiz-main')
    @if (isset($quizItem_info))
        @if($quizItem_info->quiz_type === 'quiz_tfs')
            {!! Form::open(['action' => ['GenerateQuizzesController@store', $quiz_id, $item], 'method' => 'POST']) !!}
                <div class="form-group row justify-content-end">
                    <div class="col-md-3">
                        {{Form::label('itemScore', 'Item Score :')}}
                    </div>
                    <div class="col-md-2">
                        {{Form::number('itemScore', $quizItem_info->itemScore, ['min' => '5', 'max' => '30', 'class' => 'form-control'])}}
                    </div>
                </div>
                <div class="form-group">
                    {{Form::textarea('statement', $quiz_tf->statement, ['class' => 'form-control', 'id' => 'article-ckeditor'])}}
                </div>
                <div class="row justify-content-end">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <div class="col-md-6">
                                {{Form::label('answer', 'Correct Answer')}}
                            </div>
                            <div class="col-md-6">
                                {{Form::select('answer', [ 'true' => 'true', 'false' => 'false'], $quiz_tf->answer, ['class' => 'form-control','id' => 'tfAnswer'])}}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4"  style="float:right">
                        <div class="form-group">
                            {{Form::checkbox('correctionCheck', '1', $quiz_tf->correctionCheck, ['class' => 'form-check-input', 'id' => 'tfCorrectAnswer', 'onClick' => 'chooseCorrection()'])}}
                            {{Form::label('correctionCheck', 'Require a correction if false')}}
                        </div>
                    </div>
                </div>
                <div class="row justify-content-end" id="falsediv" style="display:none">
                    <div class="col-md-8">
                        <div class="form-group row">
                            <div class="col-md-4">
                                {{Form::label('trueAnswer', 'Text for "true":')}}
                            </div>
                            <div class="col-md-8">
                                {{Form::text('trueAnswer', $quiz_tf->trueAnswer, ['class' => 'form-control'])}}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">
                                {{Form::label('falseAnswer', 'Text for "false":')}}
                            </div>
                            <div class="col-md-8">

                                {{Form::text('falseAnswer', $quiz_tf->falseAnswer, ['class' => 'form-control'])}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group text-right">
                    {{Form::text('quiz_type', 'quiz_tfs', ['class' => 'form-control', 'hidden' => 'true'])}}
                    {{Form::button('submit', ['class' => 'btn btn-info', 'type' => 'submit'])}}
                </div>
            {!! Form::close() !!}
            <script>
                function chooseCorrection() {
                    var checkbox = document.getElementById("tfCorrectAnswer");
                    var text = document.getElementById("falsediv");

                    if (checkbox.checked == true){
                        text.style.display = "block";
                        document.getElementById('tfAnswer').value = 'false';
                    } else {
                        text.style.display = "none";
                    }
                }
            </script>
        @elseif($quizItem_info->quiz_type === 'quiz_mus')
            {!! Form::open(['action' => ['GenerateQuizzesController@store', $quiz_id, $item], 'method' => 'POST']) !!}
                <div class="form-group row justify-content-end">
                    <div class="col-md-3">
                        {{Form::label('itemScore', 'Item Score :')}}
                    </div>
                    <div class="col-md-2">
                        {{Form::number('itemScore', $quizItem_info->itemScore, ['min' => '5', 'max' => '30', 'class' => 'form-control'])}}
                    </div>
                </div>
                <div class="form-group">
                    {{Form::textarea('statement', $quiz_mu->statement, ['class' => 'form-control', 'id' => 'article-ckeditor'])}}
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
                                <input type="text" name="name[]" class="form-control" value="{{$quiz_mu_choice->name}}">
                            </div>
                            <div class="col-md-3 text-center">
                                {{ Form::select('correctCheck[]', ['0' => 'x', '1' => 'o'], $quiz_mu_choice->correctCheck, ['class' => 'form-control']) }}
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="form-group text-right">
                    {{Form::text('quiz_type', 'quiz_mus', ['class' => 'form-control', 'hidden' => 'true'])}}
                    {{Form::button('submit', ['class' => 'btn btn-info', 'type' => 'submit'])}}
                </div>
                {!! Form::close() !!}
            <script>
                function addChoice(){
                    var content = '<div class="col-md-2">'+
                            '<label>Choice : </label>'+
                        '</div>'+
                        '<div class="col-md-7">'+
                            '<input type="text" name="name[]" class="form-control">'+
                        '</div>'+
                        '<div class="col-md-3 text-center">'+
                            '<select name="correctCheck[]" class="form-control">'+
                            '<option value="0">x</option>'+
                            '<option value="1">o</option>'+
                        '</select>'+
                        '</div>';
                    $('#choice_form').append(content);
                }
            </script>
        @elseif($quizItem_info->quiz_type === 'quiz_ors')
            {!! Form::open(['action' => ['GenerateQuizzesController@store', $quiz_id, $item], 'method' => 'POST']) !!}
                <div class="form-group row justify-content-end">
                    <div class="col-md-3">
                        {{Form::label('itemScore', 'Item Score :')}}
                    </div>
                    <div class="col-md-2">
                        {{Form::number('itemScore', $quizItem_info->itemScore, ['min' => '5', 'max' => '30', 'class' => 'form-control'])}}
                    </div>
                </div>
                <div class="form-group">
                    {{Form::textarea('statement', $quiz_or->statement, ['class' => 'form-control', 'id' => 'article-ckeditor'])}}
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="row" id="quiz_or_answer">
                                @foreach ($quiz_or_columns as $quiz_or_column)
                                    <div class="col-md-3"><input type="text" name="order_no" id="ordering" value="{{$quiz_or_column->order_no}}" class="form-control" readonly></div>
                                    <div class="col-md-9"><input type="text" name="column" class="form-control" value="{{$quiz_or_column->column}}"></div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group text-right">
                    {{Form::text('quiz_type', 'quiz_ors', ['class' => 'form-control', 'hidden' => 'true'])}}
                    {{Form::button('submit', ['class' => 'btn btn-info', 'type' => 'submit'])}}
                </div>
            {!! Form::close() !!}
        @elseif($quizItem_info->quiz_type === 'quiz_fis')
            {!! Form::open(['action' => ['GenerateQuizzesController@store', $quiz_id, $item], 'method' => 'POST']) !!}
                <div class="form-group row justify-content-end">
                    <div class="col-md-3">
                        {{Form::label('itemScore', 'Item Score :')}}
                    </div>
                    <div class="col-md-2">
                        {{Form::number('itemScore', $quizItem_info->itemScore, ['min' => '5', 'max' => '30', 'class' => 'form-control'])}}
                    </div>
                </div>
                <div class="form-group">
                    {{Form::textarea('statement', $quiz_fi->statement, ['class' => 'form-control', 'id' => 'article-ckeditor'])}}
                </div>
                <div class="form-group">
                    <div id="quiz_fi_answer">
                            <div class="row justify-content-end">
                                <div class="col-md-2"><label>Answer</label></div>
                                @foreach ($quiz_fi_blank_answers as $quiz_fi_blank_answer)
                                    <div class="col-md-9"><input type="text" name="answer[]"class="form-control" value="{{$quiz_fi_blank_answer->answer}}"></div>
                                @endforeach
                            </div>
                    </div>
                </div>
                <div class="form-group text-right">
                    {{Form::text('quiz_type', 'quiz_fis', ['class' => 'form-control', 'hidden' => 'true'])}}
                    {{Form::button('submit', ['class' => 'btn btn-info', 'type' => 'submit'])}}
                </div>
            {!! Form::close() !!}
        @elseif($quizItem_info->quiz_type === 'quiz_mas')
            {!! Form::open(['action' => ['GenerateQuizzesController@store', $quiz_id, $item], 'method' => 'POST']) !!}
                <div class="form-group row justify-content-end">
                    <div class="col-md-3">
                        {{Form::label('itemScore', 'Item Score :')}}
                    </div>
                    <div class="col-md-2">
                        {{Form::number('itemScore', $quizItem_info->itemScore, ['min' => '5', 'max' => '30', 'class' => 'form-control'])}}
                    </div>
                </div>
                <div class="form-group">
                    {{Form::textarea('statement', $quiz_ma->statement, ['class' => 'form-control', 'id' => 'article-ckeditor'])}}
                </div>
                <div class="form-group">
                    <table>
                        <thead>
                            <tr>
                                <th><label>Question Column :</label></th>
                                <th><label>Answer Column :</label></th>
                            </tr>
                        </thead>
                        <tbody id="quiz_ma_column">
                            @foreach ($quiz_ma_columns as $quiz_ma_column)
                                <tr>
                                    <td><input type="text" name="quiestionColumn" class="form-control" value="{{$quiz_ma_column->quiestionColumn}}"></td>
                                    <td><input type="text" name="answerColumn" class="form-control" value="{{$quiz_ma_column->answerColumn}}"></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="form-group text-right">
                    {{Form::text('quiz_type', 'quiz_mas', ['class' => 'form-control', 'hidden' => 'true'])}}
                    {{Form::button('submit', ['class' => 'btn btn-info', 'type' => 'submit'])}}
                </div>
            {!! Form::close() !!}
        @elseif($quizItem_info->quiz_type === 'quiz_es')
            {!! Form::open(['action' => ['GenerateQuizzesController@store', $quiz_id, $item], 'method' => 'POST']) !!}
                <div class="form-group row justify-content-end">
                    <div class="col-md-3">
                        {{Form::label('itemScore', 'Item Score :')}}
                    </div>
                    <div class="col-md-2">
                        {{Form::number('itemScore', $quizItem_info->itemScore, ['min' => '5', 'max' => '30', 'class' => 'form-control'])}}
                    </div>
                </div>
                <div class="form-group">
                    {{Form::textarea('statement', $quiz_es->statement, ['class' => 'form-control', 'id' => 'article-ckeditor'])}}
                </div>
                <div class="form-group text-right">
                    {{Form::text('quiz_type', 'quiz_es', ['class' => 'form-control', 'hidden' => 'true'])}}
                    {{Form::button('submit', ['class' => 'btn btn-info', 'type' => 'submit'])}}
                </div>
            {!! Form::close() !!}
        @endif
        {!! Form::open(['action' => ['GenerateQuizzesController@destroy', $quiz_id, $quizItem_info->id], 'method' => 'POST', 'class' => 'text-center']) !!}
            {{Form::hidden('_method', 'DELETE')}}
            {{Form::button('delete', ['class' => 'btn btn-danger', 'type' => 'submit'])}}
        {!! Form::close() !!}
    @else
    @endif
@endsection