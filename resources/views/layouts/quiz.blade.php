@extends('layouts.app')

@section('main')
<div class="container">
    <div class="quiz-showcase">
        <div class="row">
            <!--Information-->
            <div class="col-md-3">
                <div class="sticky">
                    <p class="title">Infromation</p>
                    {!! Form::open(['action' => ['QuizStorageController@update', $quiz_infos->id], 'method' => 'POST']) !!}
                        <div class="form-group">
                            {{Form::label('name', 'Quiz title')}}
                            {{Form::text('name', $quiz_infos->name, ['class' => 'form-control'])}}
                        </div>
                        <div class="form-group">
                            {{Form::label('subject_id', 'Subject')}}
                            {{Form::select('subject_id',  $subjectOptions, $quiz_infos->subject_id,  ['class' => 'form-control'])}}
                        </div>
                        <div class="form-group">
                            {{Form::label('time', 'Timer')}}
                            {{Form::input('time', 'timer', $quiz_infos->timer, ['class' => 'form-control'])}}
                        </div>
                        <div class="form-group">
                            {{Form::label('item', 'Items : '.$total_items)}}
                        </div>
                        <div class="form-group">
                            {{Form::label('total', 'Total Score : '.$total_score)}}
                        </div>
                        <div class="form-group text-center">
                            {{Form::hidden('_method', 'PUT')}}
                            {{Form::button('update', ['class' => 'btn btn-primary', 'type' => 'submit'])}}
                        </div>
                    {!! Form::close() !!}
                    <button class="title btn" type="button" data-toggle="collapse" data-target="#addItem" aria-expanded="false" aria-controls="addItem">
                        <i class="fa fa-plus"></i>Add New Item
                    </button>
                    <div id="addItem" class="collapse">
                        <div class="form-group">
                            {!! Form::open(['action' => ['GenerateQuizzesController@create', $quiz_id], 'method' => 'GET']) !!}
                                {{Form::text('quiz_type', 'quiz_tfs', ['class' => 'form-control', 'hidden' => 'true'])}}
                                {{Form::button('True / False', ['class' => 'btn btn-primary  form-control', 'type' => 'submit'])}}
                            {!! Form::close() !!}
                            {!! Form::open(['action' => ['GenerateQuizzesController@create', $quiz_id], 'method' => 'GET']) !!}
                                {{Form::text('quiz_type', 'quiz_mus', ['class' => 'form-control', 'hidden' => 'true'])}}
                                {{Form::button('Multiple Choice', ['class' => 'btn btn-primary  form-control', 'type' => 'submit'])}}
                            {!! Form::close() !!}
                            {!! Form::open(['action' => ['GenerateQuizzesController@create', $quiz_id], 'method' => 'GET']) !!}
                                {{Form::text('quiz_type', 'quiz_ors', ['class' => 'form-control', 'hidden' => 'true'])}}
                                {{Form::button('Ordering', ['class' => 'btn btn-primary  form-control', 'type' => 'submit'])}}
                            {!! Form::close() !!}
                            {!! Form::open(['action' => ['GenerateQuizzesController@create', $quiz_id], 'method' => 'GET']) !!}
                                {{Form::text('quiz_type', 'quiz_es', ['class' => 'form-control', 'hidden' => 'true'])}}
                                {{Form::button('Essay', ['class' => 'btn btn-primary  form-control', 'type' => 'submit'])}}
                            {!! Form::close() !!}
                            {!! Form::open(['action' => ['GenerateQuizzesController@create', $quiz_id], 'method' => 'GET']) !!}
                                {{Form::text('quiz_type', 'quiz_fis', ['class' => 'form-control', 'hidden' => 'true'])}}
                                {{Form::button('Fill-in-blank', ['class' => 'btn btn-primary  form-control', 'type' => 'submit'])}}
                            {!! Form::close() !!}
                            {!! Form::open(['action' => ['GenerateQuizzesController@create', $quiz_id], 'method' => 'GET']) !!}
                                {{Form::text('quiz_type', 'quiz_mas', ['class' => 'form-control', 'hidden' => 'true'])}}
                                {{Form::button('Matching Type', ['class' => 'btn btn-primary  form-control', 'type' => 'submit'])}}
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
            <!--Contents-->
            <div class="col-md-8">
                <div id="quiz-section">
                    @yield('quiz-main')
                </div>
            </div>
            <!--Items-->
            <div class="col-md-1">
                @if (isset($quiz_items))
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Item</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($quiz_items as $quiz_item)
                                    <tr>
                                        <td>
                                            <a href="/onlineQuizsStorage/{{$quiz_id}}/item/{{$quiz_item->id}}">
                                                <i class="fa fa-chevron-circle-left"></i>
                                            </a>
                                        </td>
                                    </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</div>
    
@endsection