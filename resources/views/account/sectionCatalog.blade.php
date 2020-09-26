@extends('layouts.app')

@section('main')
<div class="subj-showcase">
    <div class="container">
        @if (Auth::user()->userType_id === 1)
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <a class="card-title" data-toggle="collapse" href="#collapsesectform" role="button" aria-expanded="false" aria-controls="collapsesectform">
                                <i class="fa fa-plus-square"></i> Add Section
                            </a>
                            <div class="collapse" id="collapsesectform">
                                {!! Form::open(['action' => 'SectionController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                                    <div class="form-group">
                                        {{Form::label('sectionPic_locaiton', 'Cover Photo')}}
                                        {{Form::file('sectionPic_locaiton', ['class' => 'form-control-file'])}}
                                    </div>
                                    <div class="form-group">
                                        {{Form::label('name', 'Section Name')}}
                                        {{Form::text('name', '', ['class' => 'form-control'])}}
                                    </div>
                                    <div class="form-group">
                                        {{Form::label('gradeLevel', 'Grade Level')}}
                                        {{Form::select('gradeLevel',  [ 'grade 11' => 'grade 11', 'grade 12' => 'grade 12'], null, ['class' => 'form-control'])}}
                                    </div>
                                    <div class="form-group">
                                        {{Form::label('description', 'Description')}}
                                        {{Form::textarea('description', '', ['class' => 'form-control'])}}
                                    </div>
                                    <div class="form-group text-center">
                                        {{Form::button('submit', ['class' => 'btn btn-info', 'type' => 'submit'])}}
                                    </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="row">
            @if (count($sections) > 0)
                @foreach ($sections as $section)
                    <div class="col-md-3">
                        <div class="card">
                            <img src="/storage/images/section/{{$section->sectionPic_locaiton}}" class="card-img-top">
                            <div class="card-body">
                                <a href="/sectionCatalog/{{$section->id}}" class="card-title" role="button">{{ $section->name }}</a></h5>
                                <h6 class="card-subtitle mb-2">{{ $section->gradeLevel }}</h6>
                                <p class="card-text"  style="color: #8ba0c4">{!! $section->description !!}</p>
                                @if (Auth::user()->userType_id === 1)
                                    <div class="btn-group">
                                        <button class="btn btn-info" type="button" data-toggle="collapse" data-target="#editSection{{ $section->id }}" aria-expanded="false" aria-controls="editSection{{ $section->id }}">
                                            Edit
                                        </button>
                                        {!! Form::open(['action' => ['SectionController@destroy', $section->id], 'method' => 'POST']) !!}
                                            {{Form::hidden('_method', 'DELETE')}}
                                            {{Form::button('delete', ['class' => 'btn btn-danger', 'type' => 'submit'])}}
                                        {!! Form::close() !!}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5 collapse" id="editSection{{ $section->id }}">
                        <div class="card">
                            <img src="{{ asset('images/section/default-sec-pic.jpg') }}" class="card-img-top">
                            <div class="card-body">
                                {!! Form::open(['action' => ['SectionController@update', $section->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                                    <div class="form-group">
                                        {{Form::label('sectionPic_locaiton', 'Cover Photo')}}
                                        {{Form::file('sectionPic_locaiton', ['class' => 'form-control-file'])}}
                                    </div>
                                    <div class="form-group">
                                        {{Form::label('name', 'Section Name')}}
                                        {{Form::text('name', $section->name, ['class' => 'form-control'])}}
                                    </div>
                                    <div class="form-group">
                                        {{Form::label('gradeLevel', 'Grade Level')}}
                                        {{Form::select('gradeLevel',  [ 'grade 11' => 'grade 11', 'grade 12' => 'grade 12'], $section->gradeLevel, ['class' => 'form-control'])}}
                                    </div>
                                    <div class="form-group">
                                        {{Form::label('description', 'Description')}}
                                        {!!Form::textarea('description', $section->description, ['class' => 'form-control'])!!}
                                    </div>
                                    <div class="form-group text-center">
                                        {{Form::hidden('_method', 'PUT')}}
                                        {{Form::button('submit', ['class' => 'btn btn-info', 'type' => 'submit'])}}
                                    </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>
@endsection
