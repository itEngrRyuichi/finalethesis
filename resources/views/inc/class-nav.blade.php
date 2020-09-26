<div class="col-md-2">
    <div class="sticky">
        <div class="class-container">
            @foreach ($Class_details as $Class_detail)
                <!--course code-->
                <p class="title">{{$Class_detail->coursecode}}</p>
                <!--title-->
                <p class="subtitle">{{$Class_detail->subject_name}}</p>
                <p class="text">Stub Code : {{$Class_detail->stubcode}}</p>
                <img src="/storage/images/class/{{$Class_detail->classPic_location}}" class="card-img">
            @endforeach
        </div>
        @if(Auth::user()->userType_id === 4)
            <ul class="nav flex-column class-nav">
                <li class="nav-item">
                    <a class="nav-link" href="/viewClass/{{$class_id}}/attendance"><i class="fa fa-user-check"></i>Attendance</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/viewClass/{{$class_id}}/grade"><i class="fa fa-tasks"></i>Grade</a>
                </li>
            </ul>
        @else
            <ul class="nav flex-column class-nav">
                <li class="nav-item">
                    <a class="nav-link" href="/viewClass/{{$class_id}}"><i class="fa fa-chalkboard"></i>Lesson</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/viewClass/{{$class_id}}/task"><i class="fa fa-pencil-alt"></i>Task</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/viewClass/{{$class_id}}/resources"><i class="fa fa-book-open"></i>Resources</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/viewClass/{{$class_id}}/attendance"><i class="fa fa-user-check"></i>Attendance</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/viewClass/{{$class_id}}/grade"><i class="fa fa-tasks"></i>Grade</a>
                </li>
            </ul>
        @endif
    </div>
</div>