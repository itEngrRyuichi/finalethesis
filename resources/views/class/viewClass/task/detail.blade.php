@extends('layouts.class')

@section('class-main')
    <div class="detail-showcase">
        @if (Auth::user()->userType_id === 3)
            <p class="class-title">{{$tasksdatas->name}}</p>
            <div class="detailDesc-section">
                {!! $tasksdatas->description !!}
            </div>
            @if ($tasksdatas->task_type === "online quiz")
                @if (isset($myQuiz->submit) > 0)
                    <button class="btn btn-info" type="button" disabled>Take Online Quiz</button>
                @else
                    <a href="/viewClass/{{$class_id}}/task/{{$tasksdatas->submission_id}}/takeQuiz" class="btn btn-info">Take Online Quiz</a>
                @endif
            @endif
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Task Type</th>
                        <th scope="col">Start</th>
                        <th scope="col">Deadline</th>
                        <th scope="col">Highest Possible Score</th>
                        <th scope="col">Your Score</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{$tasksdatas->task_type}}</td>
                        <td>{{$tasksdatas->allow_from}}</td>
                        <td>{{$tasksdatas->allow_until}}</td>
                        <td>{{$tasksdatas->hps}}</td>
                        @if (isset($myTaskdatas))
                            @if ($myTaskdatas->myScore == null)
                            <td><p>N/A</p></td>
                            @else
                                <td>{{$myTaskdatas->myScore}}</td>
                            @endif
                        @else
                            <td><p>N/A</p></td>
                        @endif
                    </tr>
                </tbody>
            </table>
            @if($tasksdatas->task_type === "send file")
                @if ($myFile != null)
                    {!! Form::open(['action' => ['TasksController@destroy', $class_id, $task], 'method' => 'POST']) !!}
                        <div class="form-group">
                            <label>Your Submitted File :</label>
                            <a class="class-text" href="/storage/resources/{{$myFile->myResource_location}}">{{$myFile->name}}</a>
                        </div>    
                        <div class="form-group text-center">
                            {{Form::hidden('_method', 'DELETE')}}
                            {{Form::button('delete', ['class' => 'btn btn-danger', 'type' => 'submit'])}}
                        </div>
                    {!! Form::close() !!}
                @else
                    <div class="row justify-content-center">
                        <div class="col-md-7">
                            <p class="class-title text-center" style="padding-top: 40px;">Send File Here</p>
                            {!! Form::open(['action' => ['TasksController@store', $class_id], 'method' => 'POST', 'enctype' => 'multipart/form-data', 'enctype' => 'multipart/form-data', 'style' => 'padding: 5% 20% 5% 20%;']) !!}
                                <div class="form-group">
                                    {{Form::label('title', 'Title :')}}
                                    {{Form::text('name', '', ['class' => 'form-control'])}}
                                </div>
                                <div class="form-group">
                                    {{Form::label('file', 'Upload your work')}}
                                    {{Form::file('myResource_location', ['class' => 'form-control-file'])}}
                                </div>
                                <div class="form-group text-center">
                                    {{Form::text('task_id', $task, ['hidden' => 'true'])}}
                                    {{Form::button('submit', ['class' => 'btn btn-info', 'type' => 'submit'])}}
                                </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                @endif
            @endif
        @elseif(Auth::user()->userType_id === 2)
            @if ($tasksdatas->task_type === "online quiz")
                <div class="row justify-content-end">
                    <a href="/viewClass/{{$class_id}}/task/{{$tasksdatas->submission_id}}/quizScoring" class="btn btn-primary" style="margin: 20px 20px 0 0;">
                        Score this online quizzes taken by students
                        <i class="fa fa-angle-double-right"></i>
                    </a>
                </div>
            @else
                <div class="row justify-content-end">
                    <a href="/viewClass/{{$class_id}}/task/{{$tasksdatas->id}}/taskScoring" class="btn btn-primary" style="margin: 20px 20px 0 0;">
                        Score this tasks taken by students
                        <i class="fa fa-angle-double-right"></i>
                    </a>
                </div>
            @endif
            {!! Form::open(['action' => ['TasksController@update', $class_id, $tasksdatas->id], 'method' => 'POST']) !!}
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            {{Form::label('name', 'Task Title')}}
                            {{Form::text('name', $tasksdatas->name, ['class' => 'form-control'])}}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {{Form::label('hps', 'Highest Possible Score')}}
                            {{Form::input('number', 'hps', $tasksdatas->hps, ['class' => 'form-control'])}}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            {{Form::label('quarter_id', 'Quarter')}}
                            {{Form::select('quarter_id',  $QuarterOptions, $tasksdatas->quarter_id, ['class' => 'form-control'])}}
                        </div>
                        <div class="form-group">
                            {{Form::label('component_id', 'Component')}}
                            {{Form::select('component_id', $ComponentOptions, $tasksdatas->component_id, ['class' => 'form-control'])}}
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-8">
                                    {{Form::label('task_type', 'Submit Type')}}
                                    {{Form::select('task_type',  [ 'written' => 'written', 'online quiz' => 'online quiz', 'send file' => 'send file'], $tasksdatas->task_type, ['class' => 'form-control', 'id' => 'submission_type'])}}
                                </div>
                                <div class="col-md-4 form-check">
                                    {{Form::checkbox('quizChecked', '', null, ['class' => 'form-check-input', 'id' => 'quizChecked', 'onClick' => 'ozFunction()'])}}
                                    {{Form::label('quizChecked', 'Online Quiz', ['class' => 'form-check-label'])}}
                                </div>
                            </div>
                        </div>
                        <div class="form-group" id="quizStorage" style="display:none">
                            {{Form::label('oz', '-- Select Online Quiz --')}}
                            {{Form::select('submission_id',  $QuizOptions, $tasksdatas->submission_id, ['class' => 'form-control'])}}
                        </div>
                        <script>
                            function ozFunction() {
                                    var checkBox = document.getElementById("quizChecked");
                                    var text = document.getElementById("quizStorage");
                                    var select_submission_type = document.getElementById("submission_type");

                                    if (checkBox.checked == true){
                                        text.style.display = "block";
                                        select_submission_type.value = "online";
                                    } else {
                                        text.style.display = "none";
                                    }
                                }
                        </script>
                        <div class="form-group">
                            {{Form::label('duration', 'Duration')}}
                            <div class="row">
                                <div class="col-md-6">
                                    {{Form::label('allow_from', 'From', ['class' => 'class-subtitle'])}}
                                    {{Form::input('dateTime-local', 'allow_from', date('Y-m-d\Th:m:s',  strtotime($tasksdatas->allow_from)), ['class' => 'form-control'])}}
                                </div>
                                <div class="col-md-6">
                                    {{Form::label('allow_until', 'Until', ['class' => 'class-subtitle'])}}
                                    {{Form::input('dateTime-local', 'allow_until', date('Y-m-d\Th:m:s',  strtotime($tasksdatas->allow_until)), ['class' => 'form-control'])}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    {{Form::label('description', 'Description')}}
                    {{Form::textarea('description', $tasksdatas->description, ['class' => 'form-control', 'id' => 'article-ckeditor'])}}
                </div>
                <div class="form-group text-center">
                    {{Form::hidden('_method', 'PUT')}}
                    {{Form::button('submit', ['class' => 'btn btn-info', 'type' => 'submit'])}}
                </div>
            {!! Form::close() !!}
        @endif
    </div>
@endsection