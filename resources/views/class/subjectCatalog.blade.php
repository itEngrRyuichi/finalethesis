@extends('layouts.app')

@section('main')
<div class="catalog-showcase">
    <div class="container">
        <div class="row justify-content-center">
            @if (Auth::user()->userType_id === 1)
            <div class="col-md-4">
                <div class="sticky">
                    @foreach ($typeOneSubjects as $typeOneSubject)
                            <div class="collapse" id="editsubject{{$typeOneSubject->id}}">
                                <div class="sticky">
                                    <p class="title">Edit Subject Information</p>
                                    {!! Form::open(['action' => ['SubjectController@update', $typeOneSubject->id], 'method' => 'POST']) !!}
                                        <div class="form-group">
                                            {{Form::label('subject_name', 'Subject Name')}}
                                            {{Form::text('subject_name', $typeOneSubject->name, ['class' => 'form-control'])}}
                                        </div>
                                        <div class="form-group">
                                            {{Form::label('gradeLevel', 'Grade')}}
                                            {{Form::select('gradeLevel',  ['grade 11' => 'grade 11', 'grade 12' => 'grade 12'], $typeOneSubject->gradeLevel, ['class' => 'form-control'])}}
                                        </div>
                                        <div class="form-group">
                                            {{Form::label('NumberOfHours', 'Number of Hour')}}
                                            {{Form::input('number', 'NumberOfHours', $typeOneSubject->NumberOfHours, ['class' => 'form-control'])}}
                                        </div>
                                        <div class="form-group text-center">
                                            {{Form::hidden('_method', 'PUT')}}
                                            {{Form::button('submit', ['class' => 'btn btn-info', 'type' => 'submit'])}}
                                        </div>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                    @endforeach
                    @foreach ($typeTwoSubjects as $typeTwoSubject)
                        <div class="collapse" id="editsubject{{$typeTwoSubject->id}}">
                            <div class="sticky">
                                <p class="title">Edit Subject Information</p>
                                {!! Form::open(['action' => ['SubjectController@update', $typeTwoSubject->id], 'method' => 'POST']) !!}
                                    <div class="form-group">
                                        {{Form::label('subject_name', 'Subject Name')}}
                                        {{Form::text('subject_name', $typeTwoSubject->name, ['class' => 'form-control'])}}
                                    </div>
                                    <div class="form-group">
                                        {{Form::label('gradeLevel', 'Grade')}}
                                        {{Form::select('gradeLevel',  ['grade 11' => 'grade 11', 'grade 12' => 'grade 12'], $typeTwoSubject->gradeLevel, ['class' => 'form-control'])}}
                                    </div>
                                    <div class="form-group">
                                        {{Form::label('NumberOfHours', 'Number of Hour')}}
                                        {{Form::input('number', 'NumberOfHours', $typeTwoSubject->NumberOfHours, ['class' => 'form-control'])}}
                                    </div>
                                    <div class="form-group text-center">
                                        {{Form::hidden('_method', 'PUT')}}
                                        {{Form::button('submit', ['class' => 'btn btn-info', 'type' => 'submit'])}}
                                    </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    @endforeach
                    @foreach ($typeThreeSubjects as $typeThreeSubject)
                        <div class="collapse" id="editsubject{{$typeThreeSubject->id}}">
                            <div class="sticky">
                                <p class="title">Edit Subject Information</p>
                                {!! Form::open(['action' => ['SubjectController@update', $typeThreeSubject->id], 'method' => 'POST']) !!}
                                    <div class="form-group">
                                        {{Form::label('subject_name', 'Subject Name')}}
                                        {{Form::text('subject_name', $typeThreeSubject->name, ['class' => 'form-control'])}}
                                    </div>
                                    <div class="form-group">
                                        {{Form::label('gradeLevel', 'Grade')}}
                                        {{Form::select('gradeLevel',  ['grade 11' => 'grade 11', 'grade 12' => 'grade 12'], $typeThreeSubject->gradeLevel, ['class' => 'form-control'])}}
                                    </div>
                                    <div class="form-group">
                                        {{Form::label('NumberOfHours', 'Number of Hour')}}
                                        {{Form::input('number', 'NumberOfHours', $typeThreeSubject->NumberOfHours, ['class' => 'form-control'])}}
                                    </div>
                                    <div class="form-group text-center">
                                        {{Form::hidden('_method', 'PUT')}}
                                        {{Form::button('submit', ['class' => 'btn btn-info', 'type' => 'submit'])}}
                                    </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    @endforeach
                    @foreach ($typeFourSubjects as $typeFourSubject)
                        <div class="collapse" id="editsubject{{$typeFourSubject->id}}">
                            <div class="sticky">
                                <p class="title">Edit Subject Information</p>
                                {!! Form::open(['action' => ['SubjectController@update', $typeFourSubject->id], 'method' => 'POST']) !!}
                                    <div class="form-group">
                                        {{Form::label('subject_name', 'Subject Name')}}
                                        {{Form::text('subject_name', $typeFourSubject->name, ['class' => 'form-control'])}}
                                    </div>
                                    <div class="form-group">
                                        {{Form::label('gradeLevel', 'Grade')}}
                                        {{Form::select('gradeLevel',  ['grade 11' => 'grade 11', 'grade 12' => 'grade 12'], $typeFourSubject->gradeLevel, ['class' => 'form-control'])}}
                                    </div>
                                    <div class="form-group">
                                        {{Form::label('NumberOfHours', 'Number of Hour')}}
                                        {{Form::input('number', 'NumberOfHours', $typeFourSubject->NumberOfHours, ['class' => 'form-control'])}}
                                    </div>
                                    <div class="form-group text-center">
                                        {{Form::hidden('_method', 'PUT')}}
                                        {{Form::button('submit', ['class' => 'btn btn-info', 'type' => 'submit'])}}
                                    </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    @endforeach
                    <p class="title">Create New Subject</p>
                    {!! Form::open(['action' => 'SubjectController@store', 'method' => 'POST']) !!}
                        <div class="form-group">
                            {{Form::label('subject_name', 'Subject Name')}}
                            {{Form::text('subject_name', '', ['class' => 'form-control'])}}
                        </div>
                        <div class="form-group">
                            {{Form::label('gradeLevel', 'Grade')}}
                            {{Form::select('gradeLevel',  ['grade 11' => 'grade 11', 'grade 12' => 'grade 12'], '', ['class' => 'form-control'])}}
                        </div>
                        <div class="form-group">
                            {{Form::label('subjectType', 'Subject Type')}}
                            {{Form::select('subjectType',  [
                                '1' => 'Core Subject', 
                                '2' => 'Academic Track (All other subjects)', 
                                '3' => 'Academic Track', 
                                '4' => 'Technical-Vocational-Livelihood/Sports/Art and Design'
                            ], '', ['class' => 'form-control'])}}
                        </div>
                        <div class="form-group">
                            {{Form::label('NumberOfHours', 'Number of Hour')}}
                            {{Form::input('number', 'NumberOfHours', '320', ['class' => 'form-control'])}}
                        </div>
                        <div class="form-group text-center">
                            {{Form::button('submit', ['class' => 'btn btn-info', 'type' => 'submit'])}}
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
            @endif
            <div class="col-md-8">
                <table class="table">
                    <thead>
                        <tr>
                            <th colspan="5" class="sticky-head" style="text-align: center;">Core Subject</th>
                        </tr>
                        <tr>
                            <th scope="col">Title</th>
                            <th scope="col">Grade</th>
                            <th scope="col">Number of hours</th>
                            @if (Auth::user()->userType_id === 1)
                                <th scope="col"></th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($typeOneSubjects) > 0)
                            @foreach ($typeOneSubjects as $typeOneSubject)
                                <tr>
                                    <td><a href="/classCatalog/{{$typeOneSubject->id}}">{{$typeOneSubject->name}}</a></td>
                                    <td>{{$typeOneSubject->gradeLevel}}</td>
                                    <td>{{$typeOneSubject->NumberOfHours}}</td>
                                    @if (Auth::user()->userType_id === 1)
                                        <td>
                                            <div class="btn-group" role="group">
                                                <button class="btn btn-info" type="button" data-toggle="collapse" data-target="#editsubject{{$typeOneSubject->id}}" aria-expanded="true" aria-controls="editsubject{{$typeOneSubject->id}}">
                                                    Edit
                                                </button>
                                                {!! Form::open(['action' => ['SubjectController@destroy', $typeOneSubject->id], 'method' => 'POST']) !!}
                                                    {{Form::hidden('_method', 'DELETE')}}
                                                    {{Form::button('delete', ['class' => 'btn btn-danger', 'type' => 'submit'])}}
                                                {!! Form::close() !!}
                                            </div>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        @else
                            <p class="title">No Data found</p>
                        @endif
                    </tbody>
                    <thead>
                        <tr>
                            <th colspan="5" class="sticky-head" style="text-align: center;">Academic Track (All other subjects)</th>
                        </tr>
                        <tr>
                            <th scope="col">Title</th>
                            <th scope="col">Grade</th>
                            <th scope="col">Number of hours</th>
                            @if (Auth::user()->userType_id === 1)
                                <th scope="col"></th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($typeTwoSubjects) > 0)
                            @foreach ($typeTwoSubjects as $typeTwoSubject)
                            <tr>
                                <td><a href="/classCatalog/{{$typeTwoSubject->id}}">{{$typeTwoSubject->name}}</a></td>
                                <td>{{$typeTwoSubject->gradeLevel}}</td>
                                <td>{{$typeTwoSubject->NumberOfHours}}</td>
                                @if (Auth::user()->userType_id === 1)
                                <td>
                                    <div class="btn-group" role="group">
                                        <button class="btn btn-info" type="button" data-toggle="collapse" data-target="#editsubject{{$typeTwoSubject->id}}" aria-expanded="true" aria-controls="editsubject{{$typeTwoSubject->id}}">
                                            Edit
                                        </button>
                                        {!! Form::open(['action' => ['SubjectController@destroy', $typeTwoSubject->id], 'method' => 'POST']) !!}
                                                {{Form::hidden('_method', 'DELETE')}}
                                                {{Form::button('delete', ['class' => 'btn btn-danger', 'type' => 'submit'])}}
                                            {!! Form::close() !!}
                                    </div>
                                </td>
                            @endif
                            </tr>
                            @endforeach
                        @else
                            <p class="title">No Data found</p>
                        @endif
                    </tbody>
                    <thead>
                        <tr>
                            <th colspan="5" class="sticky-head" style="text-align: center;">Academic Track</th>
                        </tr>
                        <tr>
                            <th scope="col">Title</th>
                            <th scope="col">Grade</th>
                            <th scope="col">Number of hours</th>
                            @if (Auth::user()->userType_id === 1)
                                <th scope="col"></th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($typeThreeSubjects) > 0)
                            @foreach ($typeThreeSubjects as $typeThreeSubject)
                            <tr>
                                <td><a href="/classCatalog/{{$typeThreeSubject->id}}">{{$typeThreeSubject->name}}</a></td>
                                <td>{{$typeThreeSubject->gradeLevel}}</td>
                                <td>{{$typeThreeSubject->NumberOfHours}}</td>
                                @if (Auth::user()->userType_id === 1)
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button class="btn btn-info" type="button" data-toggle="collapse" data-target="#editsubject{{$typeThreeSubject->id}}" aria-expanded="true" aria-controls="editsubject{{$typeThreeSubject->id}}">
                                                Edit
                                            </button>
                                            {!! Form::open(['action' => ['SubjectController@destroy', $typeThreeSubject->id], 'method' => 'POST']) !!}
                                                {{Form::hidden('_method', 'DELETE')}}
                                                {{Form::button('delete', ['class' => 'btn btn-danger', 'type' => 'submit'])}}
                                            {!! Form::close() !!}
                                        </div>
                                    </td>
                                @endif
                            </tr>
                            @endforeach
                        @else
                            <p class="title">No Data found</p>
                        @endif
                    </tbody>
                    <thead>
                        <tr>
                            <th colspan="5" class="sticky-head" style="text-align: center;">Technical-Vocational-Livelihood/Sports/Art and Design</th>
                        </tr>
                        <tr>
                            <th scope="col">Title</th>
                            <th scope="col">Grade</th>
                            <th scope="col">Number of hours</th>
                            @if (Auth::user()->userType_id === 1)
                                <th scope="col"></th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($typeFourSubjects) > 0)
                            @foreach ($typeFourSubjects as $typeFourSubject)
                            <tr>
                                <td><a href="/classCatalog/{{$typeFourSubject->id}}">{{$typeFourSubject->name}}</a></td>
                                <td>{{$typeFourSubject->gradeLevel}}</td>
                                <td>{{$typeFourSubject->NumberOfHours}}</td>
                                @if (Auth::user()->userType_id === 1)
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button class="btn btn-info" type="button" data-toggle="collapse" data-target="#editsubject{{$typeFourSubject->id}}" aria-expanded="true" aria-controls="editsubject{{$typeFourSubject->id}}">
                                                Edit
                                            </button>
                                            {!! Form::open(['action' => ['SubjectController@destroy', $typeFourSubject->id], 'method' => 'POST']) !!}
                                                {{Form::hidden('_method', 'DELETE')}}
                                                {{Form::button('delete', ['class' => 'btn btn-danger', 'type' => 'submit'])}}
                                            {!! Form::close() !!}
                                        </div>
                                    </td>
                                @endif
                            </tr>
                            @endforeach
                        @else
                            <p class="title">No Data found</p>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
