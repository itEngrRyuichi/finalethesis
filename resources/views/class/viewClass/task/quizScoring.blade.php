@extends('layouts.scoreQuiz')

@section('scoreQuiz-main')
    @if (isset($user_id))
        @foreach ($myTasks_Essay_details as $myTasks_Essay_detail)
            {!! Form::open(['action' => ['ScoreQuizController@update', $class_id, $quiz_id, $user_id], 'method' => 'POST']) !!}
                <div class="form-group row justify-content-end">
                    <div class="col-md-3">
                        {{Form::label('Item Score : ')}}
                    </div>
                    <div class="col-md-3">
                        {{Form::input('number', 'myScore', $myTasks_Essay_detail->myScore, ['class' => 'form-control', 'maxlength' => $myTasks_Essay_detail->itemScore])}}
                    </div>
                    <div class="col-md-3">
                        {{Form::label('/'.$myTasks_Essay_detail->itemScore)}}
                    </div>
                </div>
                <div class="form-group">
                    {{Form::label('statemnt', 'Problem Statement :')}}
                    <div style="background:white; padding: 30px;">
                        {!! $myTasks_Essay_detail->statement !!}
                    </div>
                </div>
                <div class="form-group">
                    {{Form::label('Answer', 'Student Answer :')}}
                    <div style="background:white; padding: 30px;">
                        {!! $myTasks_Essay_detail->myEssay !!}
                    </div>
                </div>
                <div class="form-group text-right">
                    {{Form::hidden('_method', 'PUT')}}
                    {{Form::button('update', ['class' => 'btn btn-info', 'type' => 'submit'])}}
                </div>
            {!! Form::close() !!}
        @endforeach
    @endif
@endsection