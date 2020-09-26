@extends('layouts.class')

@section('class-main')
    <p class="class-title">Lesson</p>
    <p class="class-subtitle">Lorem ipsum dolor sit amet consectetur adipisicing elit. Eum dolor doloribus consectetur praesentium perspiciatis aliquid quibusdam similique molestias quos, sunt delectus tempore, officiis tempora? Voluptate consequuntur autem at fuga minus.</p>
    <div class="row">
        <!--This is Lesson Lists-->
        <div class="col-md-7">
            <div class="lesson-list">
                @if (count($Lessons) > 0)
                    @foreach ($Lessons as $Lesson)
                        <div class="card mb-3">
                            <div class="row">
                                <div class="col-md-5">
                                    <img src="/storage/images/lesson/{{$Lesson->lessonPic_location}}" class="card-img">
                                </div>
                                <div class="col-md-7">
                                    <div class="card-body">
                                        <h5 class="card-title">{{$Lesson->lesson_name}}</h5>
                                        <p class="card-subtitle">{{$Lesson->lesson_desc}}</p>
                                        <div class="btn-group">
                                            <a href="/viewClass/{{$class_id}}/detail/{{$Lesson->lesson_id}}" class="btn btn-primary">See Contents</a>
                                            @if (Auth::user()->userType_id === 2)
                                            {!! Form::open(['action' => ['LessonsController@destroy', $class_id, $Lesson->lesson_id], 'method' => 'POST']) !!}
                                                {{Form::hidden('_method', 'DELETE')}}
                                                {{Form::button('Delete', ['class' => 'btn btn-danger', 'type' => 'submit'])}}
                                            {!! Form::close() !!}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p>No Data Found</p>
                @endif
                @if (Auth::user()->userType_id === 2)
                    <div class="card mb-3" id="add-item">
                        <div class="row">
                            <div class="col-md-5">
                                <i class="fa fa-plus" id="plus"></i>
                            </div>
                            <div class="col-md-7">
                                <div class="card-body">
                                    <a class="card-title" href="/viewClass/{{$class_id}}/detail/create"><i class="fa fa-plus"></i> Add Item</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <!--This is Scoring Criteria-->
        <div class="col-md-5">
            <div class="lesson-criteria">
                <p class="class-title">Grading Criteria</p>
                <table class="table">
                    <thead>
                        <tr>
                            <th colspan="3">Highest Possible FInal Grade</th>
                        </tr>
                        <tr>
                            @foreach ($Onequarters as $Onequarter)
                                <th scope="col">{{$Onequarter->quarter_name}}</th>
                            @endforeach
                            @foreach ($Twoquarters as $Twoquarter)
                                <th scope="col">{{$Twoquarter->quarter_name}}</th>
                            @endforeach
                            <th scope="col">Final Grade</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="tr-ws">
                            <td>100%</td>
                            <td>100%</td>
                            <td>100%</td>
                        </tr>
                    </tbody>
                </table>
                <ul class="nav justify-content-center criteria-nav">
                    @foreach ($Onequarters as $Onequarter)
                        <li class="nav-item">
                            <a class="nav-link" href="#div1">{{$Onequarter->quarter_name}}</a>
                        </li>
                    @endforeach
                    @foreach ($Twoquarters as $Twoquarter)
                        <li class="nav-item">
                            <a class="nav-link" href="#div2">{{$Twoquarter->quarter_name}}</a>
                        </li>
                    @endforeach
                </ul>
                <!--quarterly-->    
                <div id="quarterly">
                    <table class="table">
                        <thead>
                            <tr class="title">
                                <th colspan="3">Grade</th>
                            </tr>
                            <tr>
                                <th colspan="2"></th>
                                <th scope="col">Highest Possible Score</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($components as $component)
                                <tr class="tr-total">
                                    <th scope="row"></th>
                                    <td>{{$component->component_name}}</td>
                                    <td>{{$component->component_weight}} %</td>
                                </tr>
                            @endforeach
                            <tr class="tr-ws">
                                <td colspan="2">Initional Grade</td>
                                <td>100 %</td>
                            </tr>
                            <tr class="tr-ws">
                                <td colspan="2">Quaterly Grade</td>
                                <td>Situational</td>
                            </tr>
                        </tbody>
                    </table>
                    <p class="class-subtitle">This results in the total score for each component, namely Written Work, Performance Tasks, and Quarterly Assessment.</p>
                    <p class="class-subtitle">The grading system for Senior High School (SHS) follows a different set of weights for each component.</p>
                    <p class="class-subtitle">This Initial Grade will be transmuted using the given transmutation table to get the Quarterly Grade (QG).</p>
                </div>                          
                <!--1-->
                <div id="div1">
                    <p class="class-title">{{$Onequarter->quarter_name}}</p>
                    <table class="table">
                        <!--Written Work-->
                        <thead>
                            <tr class="title">
                                <th colspan="2"></th>
                                @foreach ($OneComponents as $OneComponent)
                                    <th scope="col">{{$OneComponent->component_name}}</th>
                                @endforeach
                            </tr>
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">Task Title</th>
                                <th scope="col">Highest Possible Score</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($OneQOneCs) > 0)
                                @foreach ($OneQOneCs as $OneQOneC)
                                    <tr>
                                        <th scope="row"></th>
                                        <td>{{$OneQOneC->name}}</td>
                                        <td>{{$OneQOneC->hps}}</td>
                                    </tr>
                                @endforeach
                            @endif
                            <tr class="tr-total">
                                <td colspan="2">Total</td>
                                <td>{{$OneQOneCs_sum}}</td>
                            </tr>
                            <tr class="tr-total">
                                <td colspan="2">Highest Percentage Score</td>
                                <td>100 %</td>
                            </tr>
                            <tr class="tr-ws">
                                <td colspan="2">Highest Weighted Score</td>
                                @foreach ($OneComponents as $OneComponent)
                                    <td scope="col">{{$OneComponent->component_weight}} %</td>
                                @endforeach
                            </tr>
                        </tbody>
                        <!--Performance Task-->
                        <thead>
                            <tr class="title">
                                <th colspan="2"></th>
                                @foreach ($TwoComponents as $TwoComponent)
                                    <th scope="col">{{$TwoComponent->component_name}}</th>
                                @endforeach
                            </tr>
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">Task Title</th>
                                <th scope="col">Highest Possible Score</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($OneQTwoCs_attendances as $OneQTwoCs_attendance)
                                <tr>
                                    <th scope="row"></th>
                                    <td>{{$OneQTwoCs_attendance->name}}</td>
                                    <td>{{$OneQTwoCs_attendance->hps}}</td>
                                </tr>
                            @endforeach
                            @if (count($OneQTwoCs) > 0)
                                @foreach ($OneQTwoCs as $OneQTwoC)
                                    <tr>
                                        <th scope="row"></th>
                                        <td>{{$OneQTwoC->name}}</td>
                                        <td>{{$OneQTwoC->hps}}</td>
                                    </tr>
                                @endforeach  
                            @endif
                            <tr class="tr-total">
                                <td colspan="2">Total</td>
                                <td>{{$OneQTwoCs_sum}}</td>
                            </tr>
                            <tr class="tr-total">
                                <td colspan="2">Highest Percentage Score</td>
                                <td>100 %</td>
                            </tr>
                            <tr class="tr-ws">
                                <td colspan="2">Highest Weighted Score</td>
                                @foreach ($TwoComponents as $TwoComponent)
                                    <td scope="col">{{$TwoComponent->component_weight}} %</td>
                                @endforeach
                            </tr>
                        </tbody>
                        <!--Quarterly Assessment-->
                        <thead>
                            <tr class="title">
                                <th colspan="2"></th>
                                @foreach ($ThreeComponents as $ThreeComponent)
                                    <th scope="col">{{$ThreeComponent->component_name}}</th>
                                @endforeach
                            </tr>
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">Task Title</th>
                                <th scope="col">Highest Possible Score</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($OneQThreeCs) > 0)
                                @foreach ($OneQThreeCs as $OneQThreeC)
                                    <tr>
                                        <th scope="row"></th>
                                        <td>{{$OneQThreeC->name}}</td>
                                        <td>{{$OneQThreeC->hps}}</td>
                                    </tr>
                                @endforeach
                            @endif
                            <tr class="tr-total">
                                <td colspan="2">Total</td>
                                <td>{{$OneQThreeCs_sum}}</td>
                            </tr>
                            <tr class="tr-total">
                                <td colspan="2">Highest Percentage Score</td>
                                <td>100 %</td>
                            </tr>
                            <tr class="tr-ws">
                                <td colspan="2">Highest Weighted Score</td>
                                @foreach ($ThreeComponents as $ThreeComponent)
                                    <td scope="col">{{$ThreeComponent->component_weight}} %</td>
                                @endforeach
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!--2-->
                <div id="div2">
                    <p class="class-title">{{$Twoquarter->quarter_name}}</p>
                    <table class="table">
                        <!--Written Work-->
                        <thead>
                            <tr class="title">
                                <th colspan="2"></th>
                                @foreach ($OneComponents as $OneComponent)
                                    <th scope="col">{{$OneComponent->component_name}}</th>
                                @endforeach
                            </tr>
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">Task Title</th>
                                <th scope="col">Highest Possible Score</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($TwoQOneCs) > 0)
                                @foreach ($TwoQOneCs as $TwoQOneC)
                                    <tr>
                                        <th scope="row"></th>
                                        <td>{{$TwoQOneC->name}}</td>
                                        <td>{{$TwoQOneC->hps}}</td>
                                    </tr>
                                @endforeach
                            @endif
                            <tr class="tr-total">
                                <td colspan="2">Total</td>
                                <td>{{$TwoQOneCs_sum}}</td>
                            </tr>
                            <tr class="tr-total">
                                <td colspan="2">Highest Percentage Score</td>
                                <td>100 %</td>
                            </tr>
                            <tr class="tr-ws">
                                <td colspan="2">Highest Weighted Score</td>
                                @foreach ($OneComponents as $OneComponent)
                                    <td scope="col">{{$OneComponent->component_weight}} %</td>
                                @endforeach
                            </tr>
                        </tbody>
                        <!--Performance Task-->
                        <thead>
                            <tr class="title">
                                <th colspan="2"></th>
                                @foreach ($TwoComponents as $TwoComponent)
                                    <th scope="col">{{$TwoComponent->component_name}}</th>
                                @endforeach
                            </tr>
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">Task Title</th>
                                <th scope="col">Highest Possible Score</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($TwoQTwoCs_attendances as $TwoQTwoCs_attendance)
                                <tr>
                                    <th scope="row"></th>
                                    <td>{{$TwoQTwoCs_attendance->name}}</td>
                                    <td>{{$TwoQTwoCs_attendance->hps}}</td>
                                </tr>
                            @endforeach
                            @if (count($TwoQTwoCs) > 0)
                                @foreach ($TwoQTwoCs as $TwoQTwoC)
                                    <tr>
                                        <th scope="row"></th>
                                        <td>{{$TwoQTwoC->name}}</td>
                                        <td>{{$TwoQTwoC->hps}}</td>
                                    </tr>
                                @endforeach
                            @endif
                            <tr class="tr-total">
                                <td colspan="2">Total</td>
                                <td>{{$TwoQTwoCs_sum}}</td>
                            </tr>
                            <tr class="tr-total">
                                <td colspan="2">Highest Percentage Score</td>
                                <td>100 %</td>
                            </tr>
                            <tr class="tr-ws">
                                <td colspan="2">Highest Weighted Score</td>
                                @foreach ($TwoComponents as $TwoComponent)
                                    <td scope="col">{{$TwoComponent->component_weight}} %</td>
                                @endforeach
                            </tr>
                        </tbody>
                        <!--Quarterly Assessment-->
                        <thead>
                            <tr class="title">
                                <th colspan="2"></th>
                                @foreach ($ThreeComponents as $ThreeComponent)
                                    <th scope="col">{{$ThreeComponent->component_name}}</th>
                                @endforeach
                            </tr>
                            <tr>
                                <th scope="col"></th>
                                <th scope="col">Task Title</th>
                                <th scope="col">Highest Possible Score</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($TwoQThreeCs) > 0)
                                @foreach ($TwoQThreeCs as $TwoQThreeC)
                                    <tr>
                                        <th scope="row"></th>
                                        <td>{{$TwoQThreeC->name}}</td>
                                        <td>{{$TwoQThreeC->hps}}</td>
                                    </tr>
                                @endforeach
                            @endif
                            <tr class="tr-total">
                                <td colspan="2">Total</td>
                                <td>{{$TwoQThreeCs_sum}}</td>
                            </tr>
                            <tr class="tr-total">
                                <td colspan="2">Highest Percentage Score</td>
                                <td>100 %</td>
                            </tr>
                            <tr class="tr-ws">
                                <td colspan="2">Highest Weighted Score</td>
                                @foreach ($ThreeComponents as $ThreeComponent)
                                    <td scope="col">{{$ThreeComponent->component_weight}} %</td>
                                @endforeach
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
