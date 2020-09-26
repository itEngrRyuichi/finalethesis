@extends('layouts.app')

@section('main')
    <div class="account-showcase">
        <div class="container">
          <div class="card collapse" id="editProfile">
              <div class="row">
                @foreach ($profileInfos as $profileInfo)
                    <div class="col-md-5">
                        <img src="/storage/images/account/{{$profileInfo->profilePic_location}}">
                    </div>
                    <div class="col-md-7 card-body">
                        {!! Form::open(['action' => ['UserController@update', $profileInfo->user_id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                            <h2 class="card-title">{{$profileInfo->user_name}}</h2>
                            <div class="form-group">
                                {{Form::label('profilePic_location', 'Profile Picture')}}
                                {{Form::file('profilePic_location', ['class' => 'form-control-file'])}}
                            </div>
                            <div class="form-group">
                                {{Form::label('birthday', 'Birthday')}}
                                {{Form::input('date', 'birthday', $profileInfo->birthday, ['class' => 'form-control'])}}
                            </div>
                            <div class="form-group">
                                {{Form::label('address', 'Address')}}
                                {{Form::text('address', $profileInfo->address, ['class'=>'form-control'])}}
                            </div>
                            <div class="form-group">
                                {{Form::label('email', 'Email')}}
                                {{Form::text('email', $profileInfo->email, ['class'=>'form-control'])}}
                            </div>
                            <div class="form-group">
                                {{Form::label('tel', 'Cell Phone')}}
                                {{Form::text('tel', $profileInfo->tel, ['class' => 'form-control'])}}
                            </div>
                            <div class="form-group text-center">
                                {{Form::hidden('_method', 'PUT')}}
                                {{Form::button('submit', ['class' => 'btn btn-info', 'type' => 'submit'])}}
                            </div>
                        {!! Form::close() !!}
                    </div>
                @endforeach
              </div>
          </div>
          <div class="card" id="hideDiv">
                <div class="row">
                    @foreach ($profileInfos as $profileInfo)
                        <div class="col-md-5">
                            <img src="/storage/images/account/{{$profileInfo->profilePic_location}}">
                        </div>
                        <div class="col-md-7 card-body">
                            <h5 class="card-subtitle">{{$profileInfo->type_name}}</h5>
                            <h2 class="card-title">{{$profileInfo->user_name}}</h2>
                            @if (Auth::user()->userType_id === 3)
                                <label class="label">Section :</label><br>
                                <a href="/sectionmate" class="card-text">{{$profileInfo->section_name}}</a><br>
                                <label class="label">ID Number:</label><br>
                                <p class="card-text">{{$profileInfo->school_id}}</p>
                            @elseif(Auth::user()->userType_id === 2)
                                <label class="label">ID Number:</label><br>
                                <p class="card-text">{{$profileInfo->school_id}}</p>
                            @endif
                            <label class="label">Birthday :</label><br>
                            <p class="card-text">{{$profileInfo->birthday}}</p>
                            <label class="label">Address :</label><br>
                            <p class="card-text">{{$profileInfo->address}}</p>
                            <label class="label">Email :</label><br>
                            <p class="card-text">{{$profileInfo->email}}</p>
                            <label class="label">Cell Phone :</label>
                            <p class="card-text">{{$profileInfo->tel}}</p>
                            <a class="btn btn-info" data-toggle="collapse" href="#editProfile" role="button" aria-expanded="false" aria-controls="editProfile" onclick="hideFunction()">
                                Edit
                            </a>
                            <script>
                                function hideFunction() {
                                var x = document.getElementById("hideDiv");
                                if (x.style.display === "none") {
                                    x.style.display = "block";
                                } else {
                                    x.style.display = "none";
                                }
                                }
                            </script>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection