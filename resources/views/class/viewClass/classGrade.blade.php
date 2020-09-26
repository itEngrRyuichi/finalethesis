@extends('layouts.class')

@section('class-main')
    <div class="assessment-showcase">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <p class="class-title">Student</p>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">School ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">{{$Onequarter}}</th>
                            <th scope="col">{{$Twoquarter}}</th>
                            <th scope="col">Final</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $student)
                            <tr>
                                <td>{{$student->school_id}}</td>
                                <td>{{$student->user_name}}</td>
                                <td>{{$student->first}} %</td>
                                <td>{{$student->second}} %</td>
                                <td>{{number_format($student->final, 2)}} %</td>
                                <td>
                                    {!! Form::open(['action' => ['GradeController@edit', $class_id, $student->user_id], 'method' => 'POST']) !!}
                                        {{Form::hidden('_method', 'GET')}}    
                                        {{Form::button('See Detail', ['class' => 'btn btn-primary', 'type' => 'submit'])}}
                                    {!! Form::close() !!}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection