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
                            <th scope="col">Name</th>
                            <th scope="col">Child</th>
                            <th scope="col">Created Time</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($userLists as $userList)
                        <tr>
                            <td>{{$userList->parent_name}}</td>
                            <td>{{$userList->child_name}}</td>
                            <td>{{$userList->created_at}}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    {!! Form::open(['action' => ['AcceptlistController@update', $userList->parent_id], 'method' => 'POST']) !!}
                                        {{Form::hidden('_method', 'PUT')}}
                                        {{Form::button('accept', ['class' => 'btn btn-success', 'type' => 'submit'])}}
                                    {!! Form::close() !!}
                                    {!! Form::open(['action' => ['AcceptlistController@destroy', $userList->parent_id], 'method' => 'POST']) !!}
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