@extends('layouts.app')

@section('main')
    <div class="container">
        <div class="dashboard-showcase">
            <ul class="nav dashboard-nav">
                <li class="nav-item">
                    <a href="/onGoingClasses" class="nav-link"><i class="fa fa-running"></i>On Goling Classes</a>
                </li>
                <li class="nav-item">
                    <a href="/completedClass" class="nav-link active"><i class="fab fa-font-awesome-flag"></i>Completed Classes</a>
                </li>
            </ul>
            <div class="subj-section">
                @if (Auth::user()->userType_id === 4)
                    <div class="row">
                        @if (count($Parent_completedClasses) > 0)
                            @foreach ($Parent_completedClasses as $Parent_completedClasse)
                                <div class="col-md-3">
                                    <div class="card">
                                        <img src="/storage/images/class/{{$Parent_completedClasse->classPic_location}}" class="card-img-top">
                                        <div class="card-body">
                                            <a href="/viewClass/{{$Parent_completedClasse->class_id}}/attendance" class="card-title" role="button">{{$Parent_completedClasse->coursecode}}</a>
                                            <p class="card-subtitle">stubcode : {{$Parent_completedClasse->stubcode}}</p>
                                            <p class="card-text">{{$Parent_completedClasse->subject_name}}</p>
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
                        @if (count($completedClasses) > 0)
                            @foreach ($completedClasses as $completedClasse)
                                <div class="col-md-3">
                                    <div class="card">
                                        <img src="/storage/images/class/{{$completedClasse->classPic_location}}" class="card-img-top">
                                        <div class="card-body">
                                            <a href="/viewClass/{{$completedClasse->class_id}}" class="card-title" role="button">{{$completedClasse->coursecode}}</a>
                                            <p class="card-subtitle">stubcode : {{$completedClasse->stubcode}}</p>
                                            <p class="card-text">{{$completedClasse->subject_name}}</p>
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