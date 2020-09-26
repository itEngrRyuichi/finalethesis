@extends('layouts.class')

@section('class-main')
    <p class="class-title">Task</p>
    <p class="class-subtitle">Lorem ipsum dolor sit amet consectetur adipisicing elit. Eum dolor doloribus consectetur praesentium perspiciatis aliquid quibusdam similique molestias quos, sunt delectus tempore, officiis tempora? Voluptate consequuntur autem at fuga minus.</p>
    <div class="assessment-showcase">
        <ul class="nav justify-content-center">
            @foreach ($Onequarters as $Onequarter)
                <li class="nav-item"><a href="#div1" class="nav-link">{{$Onequarter->quarter_name}}</a></li>
            @endforeach
            @foreach ($Twoquarters as $Twoquarter)
                <li class="nav-item"><a href="#div2" class="nav-link">{{$Twoquarter->quarter_name}}</a></li>
            @endforeach
            @if (Auth::user()->userType_id === 2)
                <li class="nav-item"><a href="#add" class="nav-link" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="add">
                    <i class="fa fa-plus"></i> Add</a>
                </li>
            @endif
        </ul>
        <!--add-->
        <div id="add" class="collapse">
            <p class="class-title"><i class="fa fa-plus"></i> Add New Task</p>
            {!! Form::open(['action' => ['TasksController@store', $class_id], 'method' => 'POST']) !!}
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            {{Form::label('name', 'Task Title')}}
                            {{Form::text('name', '', ['class' => 'form-control'])}}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {{Form::label('hps', 'Highest Possible Score')}}
                            {{Form::input('number', 'hps', '', ['class' => 'form-control', 'id' => 'hps'])}}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            {{Form::label('quarter_id', 'Quarter')}}
                            {{Form::select('quarter_id',  $QuarterOptions, null, ['class' => 'form-control'])}}
                        </div>
                        <div class="form-group">
                            {{Form::label('component_id', 'Component')}}
                            {{Form::select('component_id', $ComponentOptions, null, ['class' => 'form-control'])}}
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-8">
                                    {{Form::label('task_type', 'Submit Type')}}
                                    {{Form::select('task_type',  [ 'written' => 'written', 'online quiz' => 'online quiz', 'send file' => 'send file'], null, ['class' => 'form-control', 'id' => 'submission_type'])}}
                                </div>
                                <div class="col-md-4 form-check">
                                    {{Form::checkbox('quizChecked', '', null, ['class' => 'form-check-input', 'id' => 'quizChecked', 'onClick' => 'ozFunction()'])}}
                                    {{Form::label('quizChecked', 'Online Quiz', ['class' => 'form-check-label'])}}
                                </div>
                            </div>
                        </div>
                        <div class="form-group" id="quizStorage" style="display:none">
                            {{Form::label('oz', '-- Select Online Quiz --')}}
                            {{Form::select('submission_id',  $QuizOptions, null, ['class' => 'form-control'])}}
                        </div>
                        <script>
                            function ozFunction() {
                                    var checkBox = document.getElementById("quizChecked");
                                    var text = document.getElementById("quizStorage");
                                    var select_submission_type = document.getElementById("submission_type");
                                    var input_hps = document.getElementById("hps");

                                    if (checkBox.checked == true){
                                        text.style.display = "block";
                                        select_submission_type.value = "online quiz";
                                        input_hps.value = "100";
                                        input_hps.readOnly  = true;
                                    } else {
                                        text.style.display = "none";
                                    }
                                }
                        </script>
                        <div class="form-group">
                            {{Form::label('duration', 'Duration')}}
                            <div class="row">
                                <div class="col-md-6">
                                    {{Form::label('allow_from', 'From', ['class' => 'class-subtitle'])}}
                                    {{Form::input('dateTime-local', 'allow_from', date('Y-m-d\Th:m:s',  strtotime($now)), ['class' => 'form-control'])}}
                                </div>
                                <div class="col-md-6">
                                    {{Form::label('allow_until', 'Until', ['class' => 'class-subtitle'])}}
                                    {{Form::input('dateTime-local', 'allow_until', date('Y-m-d\Th:m:s',  strtotime($now60)), ['class' => 'form-control'])}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    {{Form::label('description', 'Description')}}
                    {{Form::textarea('description', '', ['class' => 'form-control', 'id' => 'article-ckeditor'])}}
                </div>
                <div class="form-group text-center">
                    {{Form::button('submit', ['class' => 'btn btn-info', 'type' => 'submit'])}}
                </div>
            {!! Form::close() !!}
        </div>
        <!--1-->
        <div id="div1">
            <p class="class-title">{{$Onequarter->quarter_name}}</p>
            <table class="table">
                <!--Written Work-->
                @if (count($OneQOneCs) > 0)
                    <thead>
                        <tr class="title">
                            <th colspan="4"></th>
                            @foreach ($OneComponents as $OneComponent)
                                <th colspan="3">{{$OneComponent->component_name}}</th>
                            @endforeach
                        </tr>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">Task Title</th>
                            <th scope="col">Task Type</th>
                            <th scope="col">Start</th>
                            <th scope="col">Deadline</th>
                            <th scope="col">Highest Possible Score</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($OneQOneCs as $OneQOneC)
                            <tr>
                                <th scope="row"></th>
                                <td><a href="/viewClass/{{$class_id}}/task/{{$OneQOneC->id}}">{{$OneQOneC->name}}</a></td>
                                <td>{{$OneQOneC->task_type}}</td>
                                <td>{{$OneQOneC->allow_from}}</td>
                                <td>{{$OneQOneC->allow_until}}</td>
                                <td>{{$OneQOneC->hps}}</td>
                                @if(Auth::user()->userType_id === 2)
                                    <td>
                                        {!! Form::open(['action' => ['TasksController@destroy',$class_id ,$OneQOneC->id], 'method' => 'POST']) !!}
                                            {{Form::hidden('_method', 'DELETE')}}
                                            {{Form::button('Delete', ['class' => 'btn-sm btn-danger', 'type' => 'submit'])}}
                                        {!! Form::close() !!}
                                    </td>
                                @else
                                    <td></td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                @endif
                <!--Performance Task-->
                <thead>
                    <tr class="title">
                        <th colspan="4"></th>
                        @foreach ($TwoComponents as $TwoComponent)
                            <th colspan="3">{{$TwoComponent->component_name}}</th>
                        @endforeach
                    </tr>
                    <tr>
                        <th scope="col"></th>
                        <th scope="col">Task Title</th>
                        <th scope="col">Task Type</th>
                        <th scope="col">Start</th>
                        <th scope="col">Deadline</th>
                        <th scope="col">Highest Possible Score</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($OneQTwoCs_attendances as $OneQTwoCs_attendance)
                        <tr>
                            <th scope="row"></th>
                            <td>{{$OneQTwoCs_attendance->name}}</td>
                            <td>{{$OneQTwoCs_attendance->task_type}}</td>
                            <td>-</td>
                            <td>-</td>
                            <td>{{$OneQTwoCs_attendance->hps}}</td>
                            <td></td>
                        </tr>
                    @endforeach
                    @if (count($OneQTwoCs) > 0)
                        @foreach ($OneQTwoCs as $OneQTwoC)
                            <tr>
                                <th scope="row"></th>
                                <td><a href="/viewClass/{{$class_id}}/task/{{$OneQTwoC->id}}">{{$OneQTwoC->name}}</a></td>
                                <td>{{$OneQTwoC->task_type}}</td>
                                <td>{{$OneQTwoC->allow_from}}</td>
                                <td>{{$OneQTwoC->allow_until}}</td>
                                <td>{{$OneQTwoC->hps}}</td>
                                @if(Auth::user()->userType_id === 2)
                                    <td>
                                        {!! Form::open(['action' => ['TasksController@destroy',$class_id ,$OneQTwoC->id], 'method' => 'POST']) !!}
                                            {{Form::hidden('_method', 'DELETE')}}
                                            {{Form::button('Delete', ['class' => 'btn-sm btn-danger', 'type' => 'submit'])}}
                                        {!! Form::close() !!}
                                    </td>
                                @else
                                    <td></td>
                                @endif
                            </tr>
                        @endforeach 
                    @endif
                </tbody>
                <!--Quarterly Assessment-->
                @if (count($OneQThreeCs) > 0)
                    <thead>
                        <tr class="title">
                            <th colspan="4"></th>
                            @foreach ($ThreeComponents as $ThreeComponent)
                                <th colspan="3">{{$ThreeComponent->component_name}}</th>
                            @endforeach
                        </tr>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">Task Title</th>
                            <th scope="col">Task Type</th>
                            <th scope="col">Start</th>
                            <th scope="col">Deadline</th>
                            <th scope="col">Highest Possible Score</th>
                            @if(Auth::user()->userType_id === 2)
                                <th scope="col"></th>
                            @else
                                <th></th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($OneQThreeCs as $OneQThreeC)
                            <tr>
                                <th scope="row"></th>
                                <td><a href="/viewClass/{{$class_id}}/task/{{$OneQThreeC->id}}">{{$OneQThreeC->name}}</a></td>
                                <td>{{$OneQThreeC->task_type}}</td>
                                <td>{{$OneQThreeC->allow_from}}</td>
                                <td>{{$OneQThreeC->allow_until}}</td>
                                <td>{{$OneQThreeC->hps}}</td>
                                @if(Auth::user()->userType_id === 2)
                                    <td>
                                        {!! Form::open(['action' => ['TasksController@destroy',$class_id ,$OneQThreeC->id], 'method' => 'POST']) !!}
                                            {{Form::hidden('_method', 'DELETE')}}
                                            {{Form::button('Delete', ['class' => 'btn-sm btn-danger', 'type' => 'submit'])}}
                                        {!! Form::close() !!}
                                    </td>
                                @else
                                    <td></td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                @endif
            </table>
        </div>
        <!--2-->
        <div id="div2">
            <p class="class-title">{{$Twoquarter->quarter_name}}</p>
            <table class="table">
                <!--Written Work-->
                @if (count($TwoQOneCs) > 0)
                    <thead>
                        <tr class="title">
                            <th colspan="4"></th>
                            @foreach ($OneComponents as $OneComponent)
                                <th colspan="3">{{$OneComponent->component_name}}</th>
                            @endforeach
                        </tr>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">Task Title</th>
                            <th scope="col">Task Type</th>
                            <th scope="col">Start</th>
                            <th scope="col">Deadline</th>
                            <th scope="col">Highest Possible Score</th>
                            @if(Auth::user()->userType_id === 2)
                                <th scope="col"></th>
                            @else
                                <th></th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($TwoQOneCs as $TwoQOneC)
                            <tr>
                                <th scope="row"></th>
                                <td><a href="/viewClass/{{$class_id}}/task/{{$TwoQOneC->id}}">{{$TwoQOneC->name}}</a></td>
                                <td>{{$TwoQOneC->task_type}}</td>
                                <td>{{$TwoQOneC->allow_from}}</td>
                                <td>{{$TwoQOneC->allow_until}}</td>
                                <td>{{$TwoQOneC->hps}}</td>
                                @if(Auth::user()->userType_id === 2)
                                    <td>
                                        {!! Form::open(['action' => ['TasksController@destroy',$class_id ,$TwoQOneC->id], 'method' => 'POST']) !!}
                                            {{Form::hidden('_method', 'DELETE')}}
                                            {{Form::button('Delete', ['class' => 'btn-sm btn-danger', 'type' => 'submit'])}}
                                        {!! Form::close() !!}
                                    </td>
                                @else
                                    <td></td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                @else
                    
                @endif
                <!--Performance Task-->
                <thead>
                    <tr class="title">
                        <th colspan="4"></th>
                        @foreach ($TwoComponents as $TwoComponent)
                            <th colspan="3">{{$TwoComponent->component_name}}</th>
                        @endforeach
                    </tr>
                    <tr>
                        <th scope="col"></th>
                        <th scope="col">Task Title</th>
                        <th scope="col">Task Type</th>
                        <th scope="col">Start</th>
                        <th scope="col">Deadline</th>
                        <th scope="col">Highest Possible Score</th>
                        @if(Auth::user()->userType_id === 2)
                            <th scope="col"></th>
                        @else
                            <th></th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($TwoQTwoCs_attendances as $TwoQTwoCs_attendance)
                        <tr>
                            <th scope="row"></th>
                            <td>{{$TwoQTwoCs_attendance->name}}</td>
                            <td>{{$TwoQTwoCs_attendance->task_type}}</td>
                            <td>-</td>
                            <td>-</td>
                            <td>{{$TwoQTwoCs_attendance->hps}}</td>
                            <td></td>
                        </tr>
                    @endforeach
                    @if (count($TwoQTwoCs) > 0)
                        @foreach ($TwoQTwoCs as $TwoQTwoC)
                            <tr>
                                <th scope="row"></th>
                                <td><a href="/viewClass/{{$class_id}}/task/{{$TwoQTwoC->id}}">{{$TwoQTwoC->name}}</a></td>
                                <td>{{$TwoQTwoC->task_type}}</td>
                                <td>{{$TwoQTwoC->allow_from}}</td>
                                <td>{{$TwoQTwoC->allow_until}}</td>
                                <td>{{$TwoQTwoC->hps}}</td>
                                @if(Auth::user()->userType_id === 2)
                                    <td>
                                        {!! Form::open(['action' => ['TasksController@destroy',$class_id ,$TwoQTwoC->id], 'method' => 'POST']) !!}
                                            {{Form::hidden('_method', 'DELETE')}}
                                            {{Form::button('Delete', ['class' => 'btn-sm btn-danger', 'type' => 'submit'])}}
                                        {!! Form::close() !!}
                                    </td>
                                @else
                                    <td></td>
                                @endif
                            </tr>
                        @endforeach
                    @endif
                </tbody>
                <!--Quarterly Assessment-->
                @if (count($TwoQThreeCs) > 0)
                    <thead>
                        <tr class="title">
                            <th colspan="4"></th>
                            @foreach ($ThreeComponents as $ThreeComponent)
                                <th colspan="3">{{$ThreeComponent->component_name}}</th>
                            @endforeach
                        </tr>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">Task Title</th>
                            <th scope="col">Task Type</th>
                            <th scope="col">Start</th>
                            <th scope="col">Deadline</th>
                            <th scope="col">Highest Possible Score</th>
                            @if(Auth::user()->userType_id === 2)
                                <th scope="col"></th>
                            @else
                                <th></th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($TwoQThreeCs as $TwoQThreeC)
                            <tr>
                                <th scope="row"></th>
                                <td><a href="/viewClass/{{$class_id}}/task/{{$TwoQThreeC->id}}">{{$TwoQThreeC->name}}</a></td>
                                <td>{{$TwoQThreeC->task_type}}</td>
                                <td>{{$TwoQThreeC->allow_from}}</td>
                                <td>{{$TwoQThreeC->allow_until}}</td>
                                <td>{{$TwoQThreeC->hps}}</td>
                                @if(Auth::user()->userType_id === 2)
                                    <td>
                                        {!! Form::open(['action' => ['TasksController@destroy',$class_id ,$TwoQThreeC->id], 'method' => 'POST']) !!}
                                            {{Form::hidden('_method', 'DELETE')}}
                                            {{Form::button('Delete', ['class' => 'btn-sm btn-danger', 'type' => 'submit'])}}
                                        {!! Form::close() !!}
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                @endif
            </table>
        </div>
    </div>
@endsection