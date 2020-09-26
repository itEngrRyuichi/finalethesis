@extends('layouts.class')

@section('class-main')
    <p class="class-title">Grade</p>
    <p class="class-subtitle">Lorem ipsum dolor sit amet consectetur adipisicing elit. Eum dolor doloribus consectetur praesentium perspiciatis aliquid quibusdam similique molestias quos, sunt delectus tempore, officiis tempora? Voluptate consequuntur autem at fuga minus.</p>
    <div class="assessment-showcase">
        <ul class="nav justify-content-center">
            <li class="nav-item"><a href="#div1" class="nav-link">@foreach ($Onequarters as $Onequarter){{$Onequarter->quarter_name}}@endforeach</a></li>
            <li class="nav-item"><a href="#div2" class="nav-link">@foreach ($Twoquarters as $Twoquarter){{$Twoquarter->quarter_name}}@endforeach</a></li>
            <li class="nav-item"><a href="#final" class="nav-link">Final Grade</a></li>
        </ul>
        <!--1-->
        <div id="div1">
            <p class="class-title">@foreach ($Onequarters as $Onequarter){{$Onequarter->quarter_name}}@endforeach</p>
            <table class="table">
                <!--Written Work-->
                <thead>
                    <tr class="title">
                        <th colspan="3"></th>
                        @foreach ($OneComponents as $OneComponent)
                            <th colspan="2">{{$OneComponent->component_name}}</th>
                        @endforeach
                    </tr>
                    <tr>
                        <th scope="col">Task Title</th>
                        <th scope="col">Task Type</th>
                        <th scope="col">Your Score</th>
                        <th scope="col">Highest Possible Score</th>
                        <th scope="col">%</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($OneQOneCs) > 0)
                        @foreach ($OneQOneCs as $OneQOneC)
                            <tr>
                                <td>{{$OneQOneC->task_name}}</td>
                                <td>{{$OneQOneC->task_type}}</td>
                                <td>{{$OneQOneC->myScore}}</td>
                                <td>{{$OneQOneC->hps}}</td>
                                <td class="red">{{number_format($OneQOneC->Per, 2)}}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
                <!--Performance Task-->
                <thead>
                    <tr class="title">
                        <th colspan="3"></th>
                        @foreach ($TwoComponents as $TwoComponent)
                            <th colspan="2">{{$TwoComponent->component_name}}</th>
                        @endforeach
                    </tr>
                    <tr>
                        <th scope="col">Task Title</th>
                        <th scope="col">Task Type</th>
                        <th scope="col">Your Score</th>
                        <th scope="col">Highest Possible Score</th>
                        <th scope="col">%</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($OneQTwoCs_attendances as $OneQTwoCs_attendance)
                        <tr>
                            <td>{{$OneQTwoCs_attendance->task_name}}</td>
                            <td>{{$OneQTwoCs_attendance->task_type}}</td>
                            <td>{{$OneQTwoCs_attendance->myScore}}</td>
                            <td>{{$OneQTwoCs_attendance->hps}}</td>
                            <td class="red">{{number_format($OneQTwoCs_attendance->Per, 2)}}</td>
                        </tr>
                    @endforeach
                    @if (count($OneQTwoCs) > 0)
                        @foreach ($OneQTwoCs as $OneQTwoC)
                            <tr>
                                <td>{{$OneQTwoC->task_name}}</td>
                                <td>{{$OneQTwoC->task_type}}</td>
                                <td>{{$OneQTwoC->myScore}}</td>
                                <td>{{$OneQTwoC->hps}}</td>
                                <td class="red">{{number_format($OneQTwoC->Per, 2)}}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
                <!--Quarterly Assessment-->
                <thead>
                    <tr class="title">
                        <th colspan="3"></th>
                        @foreach ($ThreeComponents as $ThreeComponent)
                            <th colspan="2">{{$ThreeComponent->component_name}}</th>
                        @endforeach
                    </tr>
                    <tr>
                        <th scope="col">Task Title</th>
                        <th scope="col">Task Type</th>
                        <th scope="col">Your Score</th>
                        <th scope="col">Highest Possible Score</th>
                        <th scope="col">%</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($OneQThreeCs) > 0)
                        @foreach ($OneQThreeCs as $OneQThreeC)
                            <tr>
                                <td>{{$OneQThreeC->task_name}}</td>
                                <td>{{$OneQThreeC->task_type}}</td>
                                <td>{{$OneQThreeC->myScore}}</td>
                                <td>{{$OneQThreeC->hps}}</td>
                                <td class="red">{{number_format($OneQThreeC->Per, 2)}}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
                <!--1stQ Total-->
                <thead>
                    <tr class="title">
                        <th colspan="5">@foreach ($Onequarters as $Onequarter){{$Onequarter->quarter_name}}@endforeach Total</th>
                    </tr>
                    <tr>
                        <th colspan="3"></th>
                        <th scope="col">Component</th>
                        <th scope="col">Your Score</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="4">@foreach ($OneComponents as $OneComponent){{$OneComponent->component_name}} @endforeach</td>
                        <td class="red">{{$OneQOneCsResult}} %</td>
                    </tr>
                    <tr>
                        <td colspan="4">@foreach ($TwoComponents as $TwoComponent){{$TwoComponent->component_name}} @endforeach</td>
                        <td class="red">{{$OneQTwoCsResult}} %</td>
                    </tr>
                    <tr>
                        <td colspan="4">@foreach ($ThreeComponents as $ThreeComponent){{$ThreeComponent->component_name}} @endforeach</td>
                        <td class="red">{{$OneQThreeCsResult}} %</td>
                    </tr>
                    <tr>
                        <td colspan="4">Initial Grade</td>
                        <td class="red">{{$One_initial}} %</td>
                    </tr>
                    <tr>
                        @foreach ($Onequarters as $Onequarter)
                        <td colspan="4" class="red">{{$Onequarter->quarter_name}} Grade</td>
                        <td class="red">
                            @if (Auth::user()->userType_id == 2)
                                @if ($One_final == 0)
                                    {!! Form::open(['action' => ['GradeController@update', $class_id, $user_id], 'method' => 'POST', 'style' => 'background:none;']) !!}
                                        {{Form::text('final', '', ['class' => 'form-control'])}}  
                                        {{Form::text('quarter_id', $Onequarter->quarter_id, ['class' => 'form-control', 'hidden' =>'true'])}}
                                        {{Form::hidden('_method', 'PUT')}}    
                                        {{Form::button('submit', ['class' => 'btn btn-primary', 'type' => 'submit'])}}
                                    {!! Form::close() !!}
                                @else
                                    {{$One_final}} %
                                @endif
                            @else
                                @if ($One_final > 0)
                                    {{$One_final}} %
                                @else
                                    N/A
                                @endif
                            @endif
                        </td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
        </div>
        <!--2-->
        <div id="div2">
            <p class="class-title">@foreach ($Twoquarters as $Twoquarter){{$Twoquarter->quarter_name}}@endforeach</p>
            <table class="table">
                <!--Written Work-->
                <thead>
                    <tr class="title">
                        <th colspan="3"></th>
                        @foreach ($OneComponents as $OneComponent)
                            <th colspan="2">{{$OneComponent->component_name}}</th>
                        @endforeach
                    </tr>
                    <tr>
                        <th scope="col">Task Title</th>
                        <th scope="col">Task Type</th>
                        <th scope="col">Your Score</th>
                        <th scope="col">Highest Possible Score</th>
                        <th scope="col">%</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($TwoQOneCs) > 0)
                        @foreach ($TwoQOneCs as $TwoQOneC)
                            <tr>
                                <td>{{$TwoQOneC->task_name}}</td>
                                <td>{{$TwoQOneC->task_type}}</td>
                                <td>{{$TwoQOneC->myScore}}</td>
                                <td>{{$TwoQOneC->hps}}</td>
                                <td class="red">{{number_format($TwoQOneC->Per, 2)}}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
                <!--Performance Task-->
                <thead>
                    <tr class="title">
                        <th colspan="3"></th>
                        @foreach ($TwoComponents as $TwoComponent)
                            <th colspan="2">{{$TwoComponent->component_name}}</th>
                        @endforeach
                    </tr>
                    <tr>
                        <th scope="col">Task Title</th>
                        <th scope="col">Task Type</th>
                        <th scope="col">Your Score</th>
                        <th scope="col">Highest Possible Score</th>
                        <th scope="col">%</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($TwoQTwoCs_attendances) > 0)
                        @foreach ($TwoQTwoCs_attendances as $TwoQTwoCs_attendance)
                            <tr>
                                <td>{{$TwoQTwoCs_attendance->task_name}}</td>
                                <td>{{$TwoQTwoCs_attendance->task_type}}</td>
                                <td>{{$TwoQTwoCs_attendance->myScore}}</td>
                                <td>{{$TwoQTwoCs_attendance->hps}}</td>
                                <td class="red">{{number_format($TwoQTwoCs_attendance->Per, 2)}}</td>
                            </tr>
                        @endforeach
                    @endif
                    @if (count($TwoQTwoCs) > 0)
                        @foreach ($TwoQTwoCs as $TwoQTwoC)
                            <tr>
                                <td>{{$TwoQTwoC->task_name}}</td>
                                <td>{{$TwoQTwoC->task_type}}</td>
                                <td>{{$TwoQTwoC->myScore}}</td>
                                <td>{{$TwoQTwoC->hps}}</td>
                                <td class="red">{{number_format($TwoQTwoC->Per, 2)}}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
                <!--Quarterly Assessment-->
                <thead>
                    <tr class="title">
                        <th colspan="3"></th>
                        @foreach ($ThreeComponents as $ThreeComponent)
                            <th colspan="2">{{$ThreeComponent->component_name}}</th>
                        @endforeach
                    </tr>
                    <tr>
                        <th scope="col">Task Title</th>
                        <th scope="col">Task Type</th>
                        <th scope="col">Your Score</th>
                        <th scope="col">Highest Possible Score</th>
                        <th scope="col">%</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($TwoQThreeCs) > 0)
                        @foreach ($TwoQThreeCs as $TwoQThreeC)
                            <tr>
                                <td>{{$TwoQThreeC->task_name}}</td>
                                <td>{{$TwoQThreeC->task_type}}</td>
                                <td>{{$TwoQThreeC->myScore}}</td>
                                <td>{{$TwoQThreeC->hps}}</td>
                                <td class="red">{{number_format($TwoQThreeC->Per, 2)}}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
                <!--2ndQ Total-->
                <thead>
                    <tr class="title">
                        <th colspan="5">@foreach ($Twoquarters as $Twoquarter){{$Twoquarter->quarter_name}}@endforeach Total</th>
                    </tr>
                    <tr>
                        <th colspan="3"></th>
                        <th scope="col">Component</th>
                        <th scope="col">Your Score</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="4">@foreach ($OneComponents as $OneComponent){{$OneComponent->component_name}} @endforeach</td>
                        <td class="red">{{$TwoQOneCsResult}} %</td>
                    </tr>
                    <tr>
                        <td colspan="4">@foreach ($TwoComponents as $TwoComponent){{$TwoComponent->component_name}} @endforeach</td>
                        <td class="red">{{$TwoQTwoCsResult}} %</td>
                    </tr>
                    <tr>
                        <td colspan="4">@foreach ($ThreeComponents as $ThreeComponent){{$ThreeComponent->component_name}} @endforeach</td>
                        <td class="red">{{$TwoQThreeCsResult}} %</td>
                    </tr>
                    <tr>
                        <td colspan="4">Initial Grade</td>
                        <td class="red">{{$Two_initial}} %</td>
                    </tr>
                    <tr>
                        @foreach($Twoquarters as $Twoquarter)
                        <td colspan="4" class="red">{{$Twoquarter->quarter_name}} Grade</td>
                        <td class="red">
                            @if (Auth::user()->userType_id == 2)
                                @if ($Two_final == 0)
                                    {!! Form::open(['action' => ['GradeController@update', $class_id, $user_id], 'method' => 'POST', 'style' => 'background:none;']) !!}
                                        {{Form::text('final', '', ['class' => 'form-control'])}}  
                                        {{Form::text('quarter_id', $Twoquarter->quarter_id, ['class' => 'form-control', 'hidden' =>'true'])}}
                                        {{Form::hidden('_method', 'PUT')}}    
                                        {{Form::button('submit', ['class' => 'btn btn-primary', 'type' => 'submit'])}}
                                    {!! Form::close() !!}
                                @else
                                    {{$Two_final}} %
                                @endif
                            @else
                                @if ($Two_final > 0)
                                    {{$Two_final}} %
                                @else
                                    N/A
                                @endif
                            @endif
                        </td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
        </div>
        <!--Final-->
        <div id="final">
            <p class="class-title">Final Grade</p>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Quarter Title</th>
                        <th scope="col">Grade</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>@foreach ($Onequarters as $Onequarter){{$Onequarter->quarter_name}}@endforeach</td>
                        <td class="red">
                            @if ($One_final > 0)
                                {{$One_final}} %
                            @else
                                N/A
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>@foreach ($Twoquarters as $Twoquarter){{$Twoquarter->quarter_name}}@endforeach</td>
                        <td class="red">
                            @if ($Two_final > 0)
                                {{$Two_final}} %
                            @else
                                N/A
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="final">Final Grade</td>
                        <td class="final">
                            @if ($final_grade !== "N/A")
                                {{$final_grade}} %
                            @else
                                {{$final_grade}}
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection