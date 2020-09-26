@extends('layouts.app')

@section('main')
    <div class="container">
        <div class="dashboard-showcase">
            <ul class="nav dashboard-nav">
                <li class="nav-item">
                    <a href="/onGoingClasses" class="nav-link active"><i class="fa fa-running"></i>On Goling Classes</a>
                </li>
                <li class="nav-item">
                    <a href="/completedClass" class="nav-link"><i class="fab fa-font-awesome-flag"></i>Completed Classes</a>
                </li>
            </ul>
            <div class="subj-section">
                {!! Form::open(['action' => 'OnGoingClassesController@store', 'method' => 'POST']) !!}
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3 form-check  text-right">
                                {{Form::checkbox('allCheck', '', null, ['class' => 'form-check-input', 'id' => 'allChecked', 'onClick' => 'allFunction()'])}}
                                {{Form::label('allCheck', 'View All', ['class' => 'form-check-label'])}}
                            </div>
                            <div class="col-md-4">
                                {{Form::label('SY', 'School Year :', ['id' => 'id1'])}}
                                {{Form::select('schoolYear_id',  $SchoolYearOptions, $SchoolYearID, ['class' => 'form-control', 'id' => 'selector1'])}}
                            </div>
                            <div class="col-md-4">
                                {{Form::label('semester_id', 'Semester :', ['id' => 'id2'])}}
                                {{Form::select('semester_id',  $SemesterOptions, $SemesterID, ['class' => 'form-control', 'id' => 'selector2'])}}
                            </div>
                            <div class="col-md-1 align-self-end">
                                {{Form::button('view', ['class' => 'btn btn-info', 'type' => 'submit'])}}
                            </div>
                        </div>
                    </div>
                    <script>
                        function allFunction() {
                                var checkBox = document.getElementById("allChecked");
                                var selector1 = document.getElementById("selector1");
                                var selector2 = document.getElementById("selector2");
                                var label1 = document.getElementById("id1");
                                var label2 = document.getElementById("id2");

                                if (checkBox.checked == true){
                                    selector1.style.display = "none";
                                    selector2.style.display = "none";
                                    label1.style.display = "none";
                                    label2.style.display = "none";
                                    selector1.value = null;
                                    selector2.value = null;
                                } else {
                                    selector1.style.display = "block";
                                    selector2.style.display = "block";
                                    label1.style.display = "block";
                                    label2.style.display = "block";
                                }
                            }
                    </script>
                {!! Form::close() !!}
                @if (Auth::user()->userType_id === 4)
                    <div class="row">
                        @if (count($Parent_onGoingClasses) > 0)
                            @foreach ($Parent_onGoingClasses as $Parent_onGoingClasse)
                                <div class="col-md-3">
                                    <div class="card">
                                        <img src="/storage/images/class/{{$Parent_onGoingClasse->classPic_location}}" class="card-img-top">
                                        <div class="card-body">
                                            <a href="/viewClass/{{$Parent_onGoingClasse->class_id}}/attendance" class="card-title" role="button">{{$Parent_onGoingClasse->coursecode}}</a>
                                            <p class="card-subtitle">stubcode : {{$Parent_onGoingClasse->stubcode}}</p>
                                            <p class="card-text">{{$Parent_onGoingClasse->subject_name}}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p class="title">No Data found</p>
                        @endif
                    </div>
                @else
                    <div class="row">
                        @if (count($onGoingClasses) > 0)
                            @foreach ($onGoingClasses as $onGoingClasse)
                                <div class="col-md-3">
                                    <div class="card">
                                        <img src="/storage/images/class/{{$onGoingClasse->classPic_location}}" class="card-img-top">
                                        <div class="card-body">
                                            <a href="/viewClass/{{$onGoingClasse->class_id}}" class="card-title" role="button">{{$onGoingClasse->coursecode}}</a>
                                            <p class="card-subtitle">stubcode : {{$onGoingClasse->stubcode}}</p>
                                            <p class="card-text">{{$onGoingClasse->subject_name}}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p class="title">No Data found</p>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>                  
@endsection