@extends('layouts.class')

@section('class-main')
    @if (Auth::user()->userType_id === 2)
    <div class="detail-showcase">
            {!! Form::open(['action' => ['LessonsController@store', $class_id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
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
                                {{Form::text('name', '', ['class' => 'form-control'])}}
                            </div>
                            <div class="form-group">
                                {{Form::label('description', 'Description')}}
                                {{Form::text('description', '', ['class' => 'form-control'])}}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        {{Form::label('body', 'Body')}}
                        {{Form::textarea('body', '', ['class' => 'form-control', 'id' => 'article-ckeditor'])}}
                    </div>
                    <div class="form-group text-center">
                        {{Form::text('class_id', $class_id, ['hidden' => true])}}
                        {{Form::button('submit', ['class' => 'btn btn-info', 'type' => 'submit'])}}
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    @endif
@endsection