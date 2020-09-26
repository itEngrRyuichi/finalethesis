@extends('layouts.class')

@section('class-main')
<div class="container">
    <div class="quiz-showcase">
        <p class="title">{{$quiz_details->name}}</p>
        <div class="row">
            <!--Student Lists-->
            <div class="col-md-3">
                @if (isset($myTasks) > 0)
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Student</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($myTasks as $myTask)
                            <tr>
                                <td><a href="/viewClass/{{$class_id}}/task/{{$quiz_id}}/quizScoring/{{$myTask->user_id}}">{{$myTask->user_name}}</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                    No One take this quiz
                @endif
            </div>
            <!--Contents-->
            <div class="col-md-9">
                <div id="quiz-section">
                    @yield('scoreQuiz-main')
                </div>
            </div>
        </div>
    </div>
</div>
    
@endsection