@extends('layouts.register')

@section('register-main')
    <div class="card">
        <div class="card-header">Type Accesscode</div>

        <div class="card-body">
            {!! Form::open(['action' => 'Auth\RegisterController@checkCode', 'method' => 'POST']) !!}
                <div class="form-group">
                    {{Form::label('accesscode', 'Aceesscode')}}
                    {{Form::text('accesscode', '', ['class' => 'form-control', 'placeholder' => '◯◯◯◯-◯◯◯◯']) }}
                </div>
                <div class="form-group text-center">
                    {{Form::button('submit', ['class' => 'btn btn-info', 'type' => 'submit'])}}
                </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
