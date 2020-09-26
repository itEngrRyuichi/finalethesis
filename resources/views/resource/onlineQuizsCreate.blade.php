@extends('layouts.quiz')

@section('quiz-main')
    @if($quiz_type === 'quiz_tfs')
        {!! Form::open(['action' => ['GenerateQuizzesController@store', $quiz_id], 'method' => 'POST']) !!}
            <div class="form-group row justify-content-end">
                <div class="col-md-3">
                    {{Form::label('itemScore', 'Item Point :')}}
                </div>
                <div class="col-md-2">
                    {{Form::number('itemScore', '', ['min' => '5', 'max' => '30', 'class' => 'form-control'])}}
                </div>
            </div>
            <div class="form-group">
                {{Form::textarea('statement', '', ['class' => 'form-control', 'id' => 'article-ckeditor'])}}
            </div>
            <div class="row justify-content-end">
                <div class="col-md-6">
                    <div class="form-group row">
                        <div class="col-md-6">
                            {{Form::label('answer', 'Correct Answer')}}
                        </div>
                        <div class="col-md-6">
                            {{Form::select('answer', [ 'true' => 'true', 'false' => 'false'], null, ['class' => 'form-control','id' => 'tfAnswer'])}}
                        </div>
                    </div>
                </div>
                <div class="col-md-4"  style="float:right">
                    <div class="form-group">
                        {{Form::checkbox('correctionCheck', '1', null, ['class' => 'form-check-input', 'id' => 'tfCorrectAnswer', 'onClick' => 'chooseCorrection()'])}}
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
                            {{Form::text('trueAnswer', '', ['class' => 'form-control'])}}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4">
                            {{Form::label('falseAnswer', 'Text for "false":')}}
                        </div>
                        <div class="col-md-8">

                            {{Form::text('falseAnswer', '', ['class' => 'form-control'])}}
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
    @elseif($quiz_type === 'quiz_mus')
        {!! Form::open(['action' => ['GenerateQuizzesController@store', $quiz_id], 'method' => 'POST']) !!}
            <div class="form-group row justify-content-end">
                <div class="col-md-3">
                    {{Form::label('itemScore', 'Item Point :')}}
                </div>
                <div class="col-md-2">
                    {{Form::number('itemScore', '', ['min' => '5', 'max' => '30', 'class' => 'form-control'])}}
                </div>
            </div>
            <div class="form-group">
                {{Form::textarea('statement', '', ['class' => 'form-control', 'id' => 'article-ckeditor'])}}
            </div>
            <div class="form-group">
                <div class="row justify-content-end">
                    <div class="col-md-3 text-center">
                        {{Form::label('CorrectAnswer', 'Correct Answer')}}
                    </div>
                </div>
                <div class="row" id="choice_form">
                </div>
            </div>
            <div class="form-group text-center">
                {{Form::label('add', 'Add more choice : ')}}
                <div class="btn-group">
                    <button class="btn btn-primary" onclick="addChoice()" type="button">add</button>
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
    @elseif($quiz_type === 'quiz_ors')
        {!! Form::open(['action' => ['GenerateQuizzesController@store', $quiz_id], 'method' => 'POST']) !!}
            <div class="form-group row justify-content-end">
                <div class="col-md-3">
                    {{Form::label('itemScore', 'Item Point :')}}
                </div>
                <div class="col-md-2">
                    {{Form::number('itemScore', '', ['min' => '5', 'max' => '30', 'class' => 'form-control'])}}
                </div>
            </div>
            <div class="form-group">
                {{Form::textarea('statement', '', ['class' => 'form-control', 'id' => 'article-ckeditor'])}}
            </div>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="row" id="quiz_or_answer">
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group text-center">
                {{Form::label('addOrdering', 'Add Ordering :')}}
                <div class="btn-group">
                    <button class="btn btn-primary" type="button" onclick="addOrder()">Add</button>
                </div>
            </div>
            <div class="form-group text-right">
                {{Form::text('quiz_type', 'quiz_ors', ['class' => 'form-control', 'hidden' => 'true'])}}
                {{Form::button('submit', ['class' => 'btn btn-info', 'type' => 'submit'])}}
            </div>
        {!! Form::close() !!}
        <script>
            var i = 1; 
            function addOrder(){
                var content = '<div class="col-md-3"><input type="text" name="order_no[]" id="ordering" value="'+i+'" class="form-control" readonly></div>'+
                                '<div class="col-md-9"><input type="text" name="column[]" class="form-control"></div>';
                $('#quiz_or_answer').append(content);
                i++;
            }
        </script>
    @elseif($quiz_type === 'quiz_fis')
        {!! Form::open(['action' => ['GenerateQuizzesController@store', $quiz_id], 'method' => 'POST']) !!}
            <div class="form-group row justify-content-end">
                <div class="col-md-3">
                    {{Form::label('itemScore', 'Item Point :')}}
                </div>
                <div class="col-md-2">
                    {{Form::number('itemScore', '', ['min' => '5', 'max' => '30', 'class' => 'form-control'])}}
                </div>
            </div>
            <div class="form-group">
                {{Form::textarea('statement', '', ['class' => 'form-control', 'id' => 'article-ckeditor'])}}
            </div>
            <div class="form-group">
                <div id="quiz_fi_answer">
                </div>
            </div>
            <div class="form-group">
                <button class="btn btn-primary" type="button" onclick="addAnswer()">Add</button>
            </div>
            <div class="form-group text-right">
                {{Form::text('quiz_type', 'quiz_fis', ['class' => 'form-control', 'hidden' => 'true'])}}
                {{Form::button('submit', ['class' => 'btn btn-info', 'type' => 'submit'])}}
            </div>
        {!! Form::close() !!}
        <script>
            function addAnswer(){
                var content = '<div class="row justify-content-end">'+
                    '<div class="col-md-2"><label>Answer</label></div>'+
                    '<div class="col-md-9"><input type="text" name="answer[]"class="form-control"></div>'+
                '</div>';
                $('#quiz_fi_answer').append(content);
            }
        </script>
    @elseif($quiz_type === 'quiz_mas')
        {!! Form::open(['action' => ['GenerateQuizzesController@store', $quiz_id], 'method' => 'POST']) !!}
            <div class="form-group row justify-content-end">
                <div class="col-md-3">
                    {{Form::label('itemScore', 'Item Point :')}}
                </div>
                <div class="col-md-2">
                    {{Form::number('itemScore', '', ['min' => '5', 'max' => '30', 'class' => 'form-control'])}}
                </div>
            </div>
            <div class="form-group">
                {{Form::textarea('statement', '', ['class' => 'form-control', 'id' => 'article-ckeditor'])}}
            </div>
            <div class="form-group">
                <table>
                    <thead>
                        <tr>
                            <th><label>Question Column :</label></th>
                            <th><label>Answer Column :</label></th>
                            <th><a href="#" class="btn-sm btn-primary" onclick="addRow()">Add</a></th>
                            <th><a href="#" class="btn-sm btn-primary" onclick="removeRow()">Remove</a></th>
                        </tr>
                    </thead>
                    <tbody id="quiz_ma_column">
                    </tbody>
                </table>
            </div>
            <script>

                function addRow(){
                    var tr = '<tr>'+
                                '<td><input type="text" name="quiestionColumn[]" class="form-control"></td>'+
                                '<td><input type="text" name="answerColumn[]" class="form-control"></td>'+
                            '</tr>';
                    $('#quiz_ma_column').append(tr);
                }

                function removeRow(){
                    $('#quiz_ma_column').children('tr').remove();
                }
            </script>
            <div class="form-group text-right">
                {{Form::text('quiz_type', 'quiz_mas', ['class' => 'form-control', 'hidden' => 'true'])}}
                {{Form::button('submit', ['class' => 'btn btn-info', 'type' => 'submit'])}}
            </div>
        {!! Form::close() !!}
    @elseif($quiz_type === 'quiz_es')
        {!! Form::open(['action' => ['GenerateQuizzesController@store', $quiz_id], 'method' => 'POST']) !!}
            <div class="form-group row justify-content-end">
                <div class="col-md-3">
                    {{Form::label('itemScore', 'Item Point :')}}
                </div>
                <div class="col-md-2">
                    {{Form::number('itemScore', '', ['min' => '5', 'max' => '30', 'class' => 'form-control'])}}
                </div>
            </div>
            <div class="form-group">
                {{Form::textarea('statement', '', ['class' => 'form-control', 'id' => 'article-ckeditor'])}}
            </div>
            <div class="form-group text-right">
                {{Form::text('quiz_type', 'quiz_es', ['class' => 'form-control', 'hidden' => 'true'])}}
                {{Form::button('submit', ['class' => 'btn btn-info', 'type' => 'submit'])}}
            </div>
        {!! Form::close() !!}
    @endif
@endsection