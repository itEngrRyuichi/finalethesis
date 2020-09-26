@extends('layouts.class')

@section('class-main')
    <div class="classAll-showcase">
        <div class="row">
            <div class="col-md-3">
                <div class="sticky">
                    {!! Form::open(['action' => ['AttendanceController@store', $class_id], 'method' => 'POST']) !!}
                        <div class="form-group">
                            {{Form::label('quarter_id', 'quarter')}}
                            <select name="quarter_id" class="form-control">
                                @foreach ($Onequarters as $Onequarter)<option value="{{$Onequarter->quarter_id}}">{{$Onequarter->quarter_name}}</option>@endforeach
                                @foreach ($Twoquarters as $Twoquarter)<option value="{{$Twoquarter->quarter_id}}">{{$Twoquarter->quarter_name}}</option>@endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            {{Form::label('date', 'Date')}}
                            {{Form::input('date', 'date', '', ['class' => 'form-control'])}}
                        </div>
                        <div class="form-group text-center">
                            {{Form::button('add', ['class' => 'btn btn-info', 'type' => 'submit'])}}
                        </div>
                        {!! Form::close() !!}
                </div>
            </div>
            <div class="col-md-7">
                @if (isset($all_students) >0)
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Student Name</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($all_students as $all_student)
                                <tr>
                                    <td>{{$all_student->user_name}}</td>
                                    <td class="text-center">
                                        {!! Form::open(['action' => ['AttendanceController@update', $class_id, $all_student->user_id], 'method' => 'POST']) !!}
                                            {{Form::text('quarter_id', $quarter_id, ['hidden' => 'true'])}}
                                            {{Form::text('date', $date, ['hidden' => 'true'])}}
                                            {{Form::hidden('_method', 'PUT')}}
                                            <div class="btn-group">
                                                @foreach ($statuses as $status)
                                                    <button type="submit" class="btn btn-info" name="status" value="{{$status->id}}">
                                                        @if ($status->name === "present")
                                                            <i class="far fa-circle"></i>
                                                        @elseif ($status->name === "late")
                                                            <i class="far fa-square"></i>
                                                        @elseif ($status->name === "left early")
                                                            <i class="fa fa-play"></i>
                                                        @elseif ($status->name === "absent")
                                                            <i class="fa fa-times"></i>
                                                        @elseif ($status->name === "excused")
                                                            <i class="fa fa-check"></i>
                                                        @endif
                                                    </button>
                                                @endforeach
                                            </div>
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
            <div class="col-md-2">
                <div class="sticky">
                    <p class="class-subtitle"><i class="far fa-circle"></i> Present</p>
                    <p class="class-subtitle"><i class="far fa-square"></i> Late</p>
                    <p class="class-subtitle"><i class="fa fa-play"></i> Left Early</p>
                    <p class="class-subtitle"><i class="fa fa-times"></i> Abesent</p>
                    <p class="class-subtitle"><i class="fa fa-check"></i> Excused</p>
                </div>
            </div>
        </div>
        
    </div>
@endsection