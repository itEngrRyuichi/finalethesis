@extends('layouts.app')

@section('main')
<div class="acclis-showcase">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <table class="table">
                    @if (count($userLists) > 0)
                        <thead>
                            <tr>
                                <th scope="col">School ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">Section</th>
                                <th scope="col">Created Time</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($userLists as $userList)
                                <tr>
                                    <td>{{$userList->school_id}}</td>
                                    <td>{{$userList->user_name}}</td>
                                    <td>
                                        <a href="/sectionmate{{$userList->section_id}}">{{$userList->section_name}}</a>
                                    </td>
                                    <td>{{$userList->created_at}}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            {!! Form::open(['action' => ['AcceptlistController@update', $userList->user_id], 'method' => 'POST']) !!}
                                                {{Form::hidden('_method', 'PUT')}}
                                                {{Form::button('accept', ['class' => 'btn btn-success', 'type' => 'submit'])}}
                                            {!! Form::close() !!}
                                            {!! Form::open(['action' => ['AcceptlistController@destroy', $userList->user_id], 'method' => 'POST']) !!}
                                                {{Form::hidden('_method', 'DELETE')}}
                                                {{Form::button('delete', ['class' => 'btn btn-danger', 'type' => 'submit'])}}
                                            {!! Form::close() !!}
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    @else
                        <p class="title">No Data found</p>
                    @endif
                </table>
            </div>
        </div>
    </div>
</div>
@endsection