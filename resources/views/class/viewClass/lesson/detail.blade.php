@extends('layouts.class')

@section('class-main')
    @if (Auth::user()->userType_id === 3)
        <div class="detail-showcase">
            <p class="class-title">{{$Lesson->name}}</p>
            <p class="class-subtitle">{{$Lesson->description}}</p>
            <div class="detail-content">
                {!! $Lesson->body !!}
            </div>
        </div>
    @elseif (Auth::user()->userType_id === 2)
        <div class="detail-showcase">
                {!! Form::open(['action' => ['LessonsController@update',$class_id, $detail], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                <div class="detail-content">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                {{Form::label('lessonPic_location', 'Cover Photo')}}
                                {{Form::file('lessonPic_location', ['class' => 'form-control-file'])}}
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                {{Form::label('name', 'Name')}}
                                {{Form::text('name', $Lesson->name, ['class' => 'form-control'])}}
                            </div>
                            <div class="form-group">
                                {{Form::label('description', 'Description')}}
                                {{Form::text('description', $Lesson->description, ['class' => 'form-control'])}}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        {{Form::label('body', 'Body')}}
                        {{Form::textarea('body', $Lesson->body, ['class' => 'form-control', 'id' => 'article-ckeditor'])}}
                    </div>
                    <div class="form-group text-center">
                        {{Form::text('class_id', $class_id, ['hidden' => true])}}
                        {{Form::hidden('_method', 'PUT')}}
                        {{Form::button('submit', ['class' => 'btn btn-info', 'type' => 'submit'])}}
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    @endif
@endsection