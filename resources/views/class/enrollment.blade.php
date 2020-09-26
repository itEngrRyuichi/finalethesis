@extends('layouts.app')

@section('main')
    <div class="enrollment-showcase">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="sticky">
                        <p class="title">Enrollment</p>
                        {!! Form::open(['action' => 'EnrollmentController@store', 'method' => 'POST']) !!}
                            <div class="form-group">
                                {{Form::label('accesscode', 'Type Accesscode')}}
                                {{Form::text('accesscode', '', ['class' => 'form-control', 'placeholder' => '◯◯◯◯-◯◯◯◯'])}}
                            </div>    
                            <div class="form-group text-center">
                                {{Form::button('submit', ['class' => 'btn btn-info', 'type' => 'submit'])}}
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
                <div class="col-md-9">
                    @if (count($enrollLists) > 0)
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Stubcode</th>
                                    <th scope="col">Course Code</th>
                                    <th scope="col">Title</th>
                                    <th scope="col"></th>    
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($enrollLists as $enrollList)
                                    <tr>
                                        <td>{{$enrollList->stubcode}}</td>
                                        <td>{{$enrollList->coursecode}}</td>
                                        <td>{{$enrollList->subject_name}}</td>
                                        <td>
                                            {!! Form::open(['action' => ['EnrollmentController@destroy', $enrollList->enrollment_id], 'method' => 'POST']) !!}
                                                {{Form::hidden('_method', 'DELETE')}}
                                                {{Form::button('withdraw', ['class' => 'btn btn-danger', 'type' => 'submit'])}}
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="title">No Data found</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
