@extends('layouts.class')

@section('class-main')
<div class="container">
    <div class="quiz-showcase">
        <div class="row">
            <!--Contents-->
            <div class="col-md-10">
                <div id="quiz-section">
                    @if ($total_items == $total_takenItems)
                        <a href="/viewClass/{{$class_id}}/task/{{$quiz_id}}/takeQuiz/{{$NextQuiz_id}}" class="btn btn-info">
                            Start
                            <i class="fa fa-arrow-right"></i>
                        </a>
                    @endif
                    @yield('takeQuiz-main')
                </div>
            </div>
            <!--Information-->
            <div class="col-md-2">
                <div class="sticky">
                    <form>
                        <div class="form-group">
                            <label>Quiz title : </label>
                            <p class="text">{{$quiz_infos->name}}</p>
                        </div>
                        <div class="form-group">
                            <label>Timer :</label>
                            <p class="text">{{$quiz_infos->timer}}</p>
                        </div>
                        <div class="form-group">
                            <label>Item :</label>
                            <p class="text">{{$total_items}}</p>
                        </div>
                        <div class="form-group">
                            <label>hps :</label>
                            <p class="text">{{$total_score}}</p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
    
@endsection