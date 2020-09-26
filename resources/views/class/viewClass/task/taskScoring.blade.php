@extends('layouts.class')

@section('class-main')
    <div class="detail-showcase">
        <div class="row justify-content-center">
            <div class="col-md-11">
                {{-- Sned file --}}
                <p class="class-title">{{$task_detail->name}}</p>
                @if ($task_detail->task_type === "send file")
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Student Name</th>
                                <th>File</th>
                                <th>Score</th>
                                <th>hps</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($SF_students as $SF_student)
                                {!! Form::open(['action' => ['ScoreTaskController@update', $class_id, $task_id, $SF_student->user_id], 'method' => 'POST']) !!}
                                <tr>
                                    <td>{{$SF_student->user_name}}</td>
                                    <td><a href="/storage/resources/{{$SF_student->myResource_location}}">{{$SF_student->myResourceName}}</a></td>
                                    <td>
                                        {{Form::input('number', 'myScore', $task_detail->hps, ['class' => 'form-control'])}}
                                    </td>
                                    <td>/ {{$task_detail->hps}}</td>
                                    <td>
                                        {{Form::hidden('_method', 'PUT')}}
                                        {{Form::button('submit', ['class' => 'btn btn-info', 'type' => 'submit'])}}
                                    </td>
                                </tr>
                                {!! Form::close() !!}
                            @endforeach
                        </tbody>
                    </table>
                @elseif ($task_detail->task_type === "written")
                    @if ($ScoredStudents == "[]")
                        {!! Form::open(['action' => ['ScoreTaskController@store', $class_id, $task_id], 'method' => 'POST']) !!}
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Student Name</th>
                                        <th>Score</th>
                                        <th>hps</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($students as $student)   
                                        <tr>
                                            <td>{{$student->user_name}}</td>
                                            <td>
                                                {{Form::input('number', 'myScore[]', $task_detail->hps, ['class' => 'form-control'])}}
                                            </td>
                                            <td>/ {{$task_detail->hps}}</td>
                                            <td>
                                                {{Form::input('text', 'user_id[]', $student->user_id, ['hidden' => 'false'])}}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                {{Form::button('submit all', ['class' => 'btn btn-info', 'type' => 'submit'])}}
                            </table>
                        {!! Form::close() !!}
                    @else
                        <p class="class-title">You Scored Already</p>
                    @endif
                @endif
                {{-- written --}}
            </div>
        </div>
    </div>
@endsection