@extends('layouts.app')

@section('main')
    <div class="container">
        <div class="quizStorage-showcase">
            <a class="btn btn-primary" data-toggle="collapse" href="#addQuizForm" role="button" aria-expanded="false" aria-controls="addQuizForm">
                <i class="fa fa-plus"></i> Add New Quiz
            </a>
            <div class="collapse" id="addQuizForm">
                {!! Form::open(['action' => 'QuizStorageController@store', 'method' => 'POST']) !!}
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <div class="form-group">
                                {{Form::label('name', 'Quiz title')}}
                                {{Form::text('name', '', ['class' => 'form-control'])}}
                            </div>
                            <div class="form-group">
                                {{Form::label('subject_id', 'Subject')}}
                                {{Form::select('subject_id',  $subjectOptions, null,  ['class' => 'form-control'])}}
                            </div>
                            <div class="form-group">
                                {{Form::label('time', 'Timer')}}
                                {{Form::input('time', 'timer', '', ['class' => 'form-control'])}}
                            </div>
                            <div class="form-group text-center">
                                {{Form::button('add', ['class' => 'btn btn-info', 'type' => 'submit'])}}
                            </div>
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
            @if (count($quizzes) > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col"></th>
                        <th scope="col">Title</th>
                        <th scope="col">Subject</th>
                        <th scope="col">Update Date</th>
                        <th scope="col">Timer</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($quizzes as $quiz)
                        <tr>
                            <th scope="row"></th>
                            <td><a href="/onlineQuizsStorage/{{$quiz->quiz_id}}/item">{{$quiz->quiz_name}}</a></td>
                            <td>{{$quiz->subject_name}}</td>
                            <td>{{$quiz->created_at}}</td>
                            <td>{{$quiz->timer}}</td>
                            <td>
                                {!! Form::open(['action' => ['QuizStorageController@destroy', $quiz->quiz_id], 'method' => 'POST']) !!}
                                    {{Form::hidden('_method', 'DELETE')}}
                                    {{Form::button('delete', ['class' => 'btn btn-danger', 'type' => 'submit'])}}
                                {!! Form::close() !!}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @else
                <p class="title">No data found</p>
            @endif
        </div>
    </div>
@endsection