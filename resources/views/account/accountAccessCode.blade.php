@extends('layouts.app')

@section('main')
    @if (Auth::user()->userType_id === 1)
    <div class="acclis-showcase">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="sticky">
                        @foreach ($accesscodes as $accesscode)
                            <div class="collapse" id="editAccessCode{{$accesscode->id}}">
                                <p class="title">
                                    Edit
                                </p>
                                {!! Form::open(['action' => ['AccesscodeController@update', $accesscode->id], 'method' => 'POST']) !!}
                                    <div class="form-group">
                                        {{Form::label('accesscode', 'Access Code')}}
                                        {{Form::text('accesscode', $accesscode->accesscode, ['class' => 'form-control', 'readonly' => 'true'])}}
                                    </div>
                                    <div class="form-group">
                                        {{Form::label('user_types', 'Provide To')}}
                                        {{Form::select('user_types',  ['1' => 'admin', '2' => 'teacher', '3' => 'student', '4' => 'parent'], $accesscode->lead_id, ['class' => 'form-control'])}}
                                    </div>
                                    <div class="form-group">
                                        {{Form::label('duration', 'Accessible Duration')}}
                                        <br>
                                        {{Form::label('allow_from', 'From', ['class' => 'text'])}}
                                        {{Form::input('dateTime-local', 'allow_from', date('Y-m-d\Th:m:s',  strtotime($accesscode->allow_from)), ['class' => 'form-control'])}}
                                        {{Form::label('allow_to', 'To', ['class' => 'text'])}}
                                        {{Form::input('dateTime-local', 'allow_to', date('Y-m-d\Th:m:s',  strtotime($accesscode->allow_to)), ['class' => 'form-control'])}}
                                    </div>
                                    <div class="form-group text-center">
                                        {{Form::hidden('_method', 'PUT')}}
                                        {{Form::button('submit', ['class' => 'btn btn-info', 'type' => 'submit'])}}
                                    </div>
                                {!! Form::close() !!}
                            </div>
                        @endforeach
                        <p class="title">
                            Generate Account Access Code
                        </p>
                        {!! Form::open(['action' => 'AccesscodeController@store', 'method' => 'POST']) !!}
                            <div class="form-group">
                                {{Form::label('accesscode', 'New Access Code')}}
                                {{Form::text('accesscode', $newCodes, ['class' => 'form-control', 'readonly' => 'true'])}}
                            </div>
                            <div class="form-group">
                                {{Form::label('user_types', 'Provide To')}}
                                {{Form::select('user_types',  ['1' => 'admin', '2' => 'teacher', '3' => 'student', '4' => 'parent'], '',  ['class' => 'form-control'])}}
                            </div>
                            <div class="form-group">
                                {{Form::label('duration', 'Accessible Duration')}}
                                <br>
                                {{Form::label('allow_from', 'From', ['class' => 'text'])}}
                                {{Form::input('dateTime-local', 'allow_from', date('Y-m-d\Th:m:s',  strtotime($now)), ['class' => 'form-control'])}}
                                {{Form::label('allow_to', 'To', ['class' => 'text'])}}
                                {{Form::input('dateTime-local', 'allow_to', date('Y-m-d\Th:m:s',  strtotime($now60)), ['class' => 'form-control'])}}
                            </div>
                            <div class="form-group text-center">
                                {{Form::button('submit', ['class' => 'btn btn-info', 'type' => 'submit'])}}
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
                @if(count($accesscodes) > 0)
                    <div class="col-md-8">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col"></th>
                                    <th scope="col">Code</th>
                                    <th scope="col">Ptovide to</th>
                                    <th colspan="2">Accessible Duration</th>
                                    <th scope="col"></th> 
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($accesscodes as $accesscode)
                                    <tr>
                                        <th scope="row"></th>
                                        <td id="code">{{$accesscode->accesscode}}</td>
                                        <td id="code">{{$accesscode->name}}</td>
                                        <td id="code">{{$accesscode->allow_from}}</td>
                                        <td id="code">{{$accesscode->allow_to}}</td>
                                        <td>
                                            <div class="btn-group">
                                                <button class="btn btn-info"  type="button" data-toggle="collapse" data-target="#editAccessCode{{$accesscode->id}}" aria-expanded="true" aria-controls="editAccessCode{{$accesscode->id}}"
                                                    >Edit
                                                </button>
                                                {!! Form::open(['action' => ['AccesscodeController@destroy', $accesscode->id], 'method' => 'POST']) !!}
                                                    {{Form::hidden('_method', 'DELETE')}}
                                                    {{Form::button('delete', ['class' => 'btn btn-danger', 'type' => 'submit'])}}
                                                {!! Form::close() !!}
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <script>
                            var table = document.getElementsByTagName('table')[0],
                            rows = table.getElementsByTagName('tr'),
                            text = 'textContent' in document ? 'textContent' : 'innerText';
    
                                for (var i = 0, len = rows.length; i < len; i++){
                                rows[i].children[0][text] = i + ': ' + rows[i].children[0][text];
                            }
                        </script>
                    </div>
                @else
                    <p class="title">no accesscode found</p>
                @endif
            </div>
        </div>
    </div>
    @endif
@endsection
