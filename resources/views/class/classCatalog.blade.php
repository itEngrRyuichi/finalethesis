@extends('layouts.app')

@section('main')
<div class="catalog-showcase">
    <div class="container">
        @if (Auth::user()->userType_id === 2)
            @foreach ($classLists as $classList)
                <div class="collapse" id="editClass{{$classList->class_id}}">
                    <p class="title">Edit</p>
                    {!! Form::open(['action' => ['ClassCatalogController@update', $classList->class_id], 'method' => 'POST', 'enctype' => 'multipart/form-data', 'enctype' => 'multipart/form-data']) !!}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{Form::label('accesscode', 'New Access Code')}}
                                    {{Form::text('accesscode', $classList->accesscode, ['class' => 'form-control', 'readonly' => 'true'])}}
                                </div>
                                <div class="form-group">
                                    {{Form::label('duration', 'Accessible Duration')}}
                                    <br>
                                    {{Form::label('allow_from', 'From', ['class' => 'text'])}}
                                    {{Form::input('dateTime-local', 'allow_from', date('Y-m-d\Th:m:s',  strtotime($classList->allow_from)), ['class' => 'form-control'])}}
                                    {{Form::label('allow_to', 'To', ['class' => 'text'])}}
                                    {{Form::input('dateTime-local', 'allow_to', date('Y-m-d\Th:m:s',  strtotime($classList->allow_to)), ['class' => 'form-control'])}}
                                </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                {{Form::label('schoolYear_id', 'SY')}}
                                                {{Form::select('schoolYear_id',  ['1' => '2018-2019', '2' => '2019-2020'], $classList->schoolYear_id,  ['class' => 'form-control'])}}
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                {{Form::label('semester', 'Semester')}}
                                                {{Form::select('semester_id',  ['1' => 'First semester', '2' => 'Second semester'], $classList->semester_id,  ['class' => 'form-control'])}}
                                            </div>
                                        </div>
                                    </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    {{Form::label('stubcode', 'Stubcode')}}
                                    {{Form::text('stubcode', $classList->stubcode, ['class' => 'form-control'])}}
                                </div>
                                <div class="form-group">
                                    {{Form::label('coursecode', 'Coursecode')}}
                                    {{Form::text('coursecode', $classList->coursecode, ['class' => 'form-control'])}}
                                </div>
                                <div class="form-group">
                                    {{Form::label('classPic_location', 'Cover Photo')}}
                                    {{Form::file('classPic_location', ['class' => 'form-control-file'])}}
                                </div>
                                <div class="form-group">
                                    {{Form::label('progress', 'Progress')}}
                                    {{Form::select('progress',  ['on going' => 'On Going', 'completed' => 'Completed'], $classList->progress,  ['class' => 'form-control'])}}
                                </div>
                            </div>
                        </div>
                        <div class="form-group text-center">
                            {{Form::text('subject_id', $subjectID, ['hidden' => true])}}
                            {{Form::hidden('_method', 'PUT')}}
                            {{Form::button('submit', ['class' => 'btn btn-info', 'type' => 'submit'])}}
                        </div>
                    {!! Form::close() !!}
                </div>
            @endforeach
            <div class="text-right">
                <a class="btn btn-primary" data-toggle="collapse" href="#newClass" role="button" aria-expanded="false" aria-controls="newClass">
                    <i class="fa fa-plus"></i>  Create New Class
                </a>
            </div>
            <div class="collapse" id="newClass">
                <p class="title">Create New Class</p>
                {!! Form::open(['action' => 'ClassCatalogController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                {{Form::label('accesscode', 'New Access Code')}}
                                {{Form::text('accesscode', $newCodes, ['class' => 'form-control', 'readonly' => 'true'])}}
                            </div>
                            <div class="form-group">
                                {{Form::label('duration', 'Accessible Duration')}}
                                <br>
                                {{Form::label('allow_from', 'From', ['class' => 'text'])}}
                                {{Form::input('dateTime-local', 'allow_from', date('Y-m-d\Th:m:s',  strtotime($now)), ['class' => 'form-control'])}}
                                {{Form::label('allow_to', 'To', ['class' => 'text'])}}
                                {{Form::input('dateTime-local', 'allow_to', date('Y-m-d\Th:m:s',  strtotime($now60)), ['class' => 'form-control'])}}
                            </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {{Form::label('schoolYear_id', 'SY')}}
                                            {{Form::select('schoolYear_id',  ['1' => '2018-2019', '2' => '2019-2020'], null,  ['class' => 'form-control'])}}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {{Form::label('semester', 'Semester')}}
                                            {{Form::select('semester_id',  ['1' => 'First semester', '2' => 'Second semester'], null,  ['class' => 'form-control'])}}
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{Form::label('stubcode', 'Stubcode')}}
                                {{Form::text('stubcode', '', ['class' => 'form-control'])}}
                            </div>
                            <div class="form-group">
                                {{Form::label('coursecode', 'Coursecode')}}
                                {{Form::text('coursecode', '', ['class' => 'form-control'])}}
                            </div>
                            <div class="form-group">
                                {{Form::label('classPic_location', 'Cover Photo')}}
                                {{Form::file('classPic_location', ['class' => 'form-control-file'])}}
                            </div>
                            <div class="form-group">
                                {{Form::label('progress', 'Progress')}}
                                {{Form::select('progress',  ['on going' => 'On Going', 'completed' => 'Completed'], '',  ['class' => 'form-control'])}}
                            </div>
                        </div>
                    </div>
                    <div class="form-group text-center">
                        {{Form::text('subject_id', $subjectID, ['hidden' => true])}}
                        {{Form::button('submit', ['class' => 'btn btn-info', 'type' => 'submit'])}}
                    </div>
                {!! Form::close() !!}
            </div>
        @endif
        @if(count($classLists) > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col" class="sticky-head">Stub Code</th>
                        <th scope="col" class="sticky-head">Course Code</th>
                        <th scope="col" class="sticky-head">Title</th>
                        <th scope="col" class="sticky-head">Progress</th>
                        <th scope="col" class="sticky-head">SY</th>
                        <th scope="col" class="sticky-head">Semester</th>
                        @if (Auth::user()->userType_id === 2)
                            <th scope="col" class="sticky-head">Accesscode</th>
                            <th scope="col" class="sticky-head">Allow from</th>
                            <th scope="col" class="sticky-head">Allow to</th>
                            <th scope="col" class="sticky-head"></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($classLists as $classList)
                        <tr>
                            <td>{{$classList->stubcode}}</td>
                            <td>{{$classList->coursecode}}</td>
                            <td>{{$classList->subject_name}}</td>
                            <td>{{$classList->progress}}</td>
                            <td>{{$classList->schoolYear}}</td>
                            <td>{{$classList->semester}}</td>
                            @if (Auth::user()->userType_id === 2)
                                <td>{{$classList->accesscode}}</td>
                                <td>{{$classList->allow_from}}</td>
                                <td>{{$classList->allow_to}}</td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-info"  type="button" data-toggle="collapse" data-target="#editClass{{$classList->class_id}}" aria-expanded="true" aria-controls="editClass{{$classList->class_id}}">
                                            Edit
                                        </button>
                                        {!! Form::open(['action' => ['ClassCatalogController@destroy', $classList->class_id], 'method' => 'POST']) !!}
                                            {{Form::hidden('_method', 'DELETE')}}
                                            {{Form::button('delete', ['class' => 'btn btn-danger', 'type' => 'submit'])}}
                                        {!! Form::close() !!}
                                    </div>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="title">no class found</p>
        @endif
    </div>
</div>
@endsection
