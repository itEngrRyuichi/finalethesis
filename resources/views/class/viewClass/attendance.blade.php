@extends('layouts.class')

@section('class-main')
    <p class="class-title">Attendance</p>
    <p class="class-subtitle">Lorem ipsum dolor sit amet consectetur adipisicing elit. Eum dolor doloribus consectetur praesentium perspiciatis aliquid quibusdam similique molestias quos, sunt delectus tempore, officiis tempora? Voluptate consequuntur autem at fuga minus.</p>
    <div class="row attendance-showcase">
        <div class="col-md-8">
            <table class="table">
                <thead>
                    <tr class="title">
                        <th colspan="6">@foreach ($Onequarters as $Onequarter){{$Onequarter->quarter_name}}@endforeach Total</th>
                    </tr>
                    <tr>
                        <th scope="col">Present</th>
                        <th scope="col">Late</th>
                        <th scope="col">Left Early</th>
                        <th scope="col">Absent</th>
                        <th scope="col">Excused</th>
                        <th scope="col">%</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{$One_Attend_present}}</td>
                        <td>{{$One_Attend_late}}</td>
                        <td>{{$One_Attend_left}}</td>
                        <td>{{$One_Attend_absent}}</td>
                        <td>{{$One_Attend_excused}}</td>
                        <td>{{$OneResult}} %</td>
                    </tr>
                </tbody>
                <thead>
                    <tr class="title">
                        <th colspan="6">@foreach ($Twoquarters as $Twoquarter){{$Twoquarter->quarter_name}}@endforeach Total</th>
                    </tr>
                    <tr>
                        <th scope="col">Present</th>
                        <th scope="col">Late</th>
                        <th scope="col">Left Early</th>
                        <th scope="col">Absent</th>
                        <th scope="col">Excused</th>
                        <th scope="col">%</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{$Two_Attend_present}}</td>
                        <td>{{$Two_Attend_late}}</td>
                        <td>{{$Two_Attend_left}}</td>
                        <td>{{$Two_Attend_absent}}</td>
                        <td>{{$Two_Attend_excused}}</td>
                        <td>{{$TwoResult}} %</td>
                    </tr>
                </tbody>
            </table>
            <div class="row">
                <div class="col-md-6">
                    <table class="table">
                        <thead>
                            <tr class="title">
                                <th colspan="3">@foreach ($Onequarters as $Onequarter){{$Onequarter->quarter_name}}@endforeach</th>
                            </tr>
                            <tr>
                                <th scope="col">Date</th>
                                <th scope="col">Status</th>
                                <th scope="col">%</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($OneAttends as $OneAttend)
                                <tr>
                                    <td>{{$OneAttend->date}}</td>
                                    <td>
                                        @if ($OneAttend->status_id === 1)
                                            <i class="far fa-circle"></i>
                                        @elseif ($OneAttend->status_id === 2)
                                            <i class="far fa-square"></i>
                                        @elseif ($OneAttend->status_id === 3)
                                            <i class="fa fa fa-play"></i>
                                        @elseif ($OneAttend->status_id === 4)
                                            <i class="fa fa-times"></i>
                                        @elseif ($OneAttend->status_id === 5)
                                            <i class="fa fa-check"></i>
                                        @endif
                                    </td>
                                    <td>{{$OneAttend->score}} %</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table">
                        <thead>
                            <tr class="title">
                                <th colspan="3">@foreach ($Twoquarters as $Twoquarter){{$Twoquarter->quarter_name}}@endforeach</th>
                            </tr>
                            <tr>
                                <th scope="col">Date</th>
                                <th scope="col">Status</th>
                                <th scope="col">%</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($TwoAttends as $TwoAttend)
                                <tr>
                                    <td>{{$TwoAttend->date}}</td>
                                    <td>
                                        @if ($TwoAttend->status_id === 1)
                                            <i class="far fa-circle"></i>
                                        @elseif ($TwoAttend->status_id === 2)
                                            <i class="far fa-square"></i>
                                        @elseif ($TwoAttend->status_id === 3)
                                            <i class="fa fa fa-play"></i>
                                        @elseif ($TwoAttend->status_id === 4)
                                            <i class="fa fa-times"></i>
                                        @elseif ($TwoAttend->status_id === 5)
                                            <i class="fa fa-check"></i>
                                        @endif
                                    </td>
                                    <td>{{$TwoAttend->score}} %</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="sticky">
                <p class="class-subtitle"><i class="far fa-circle"></i> Present</p>
                <p class="class-subtitle"><i class="far fa-square"></i> Late</p>
                <p class="class-subtitle"><i class="fa fa-play"></i> Left Early</p>
                <p class="class-subtitle"><i class="fa fa-times"></i> Abesent</p>
                <p class="class-subtitle"><i class="fa fa-check"></i> Excused</p>
            </div>
        </div>
    </div>
@endsection