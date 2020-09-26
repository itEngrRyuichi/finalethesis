@extends('layouts.app')

@section('main')
    <div class="container">
        <div class="userResource-showcase">
            <p class="title">Resources</p>
            <p class="subtitle">Lorem ipsum dolor sit amet consectetur adipisicing elit. Eum dolor doloribus consectetur praesentium perspiciatis aliquid quibusdam similique molestias quos, sunt delectus tempore, officiis tempora? Voluptate consequuntur autem at fuga minus.</p>
            <div class="row">
                <div class="col-md-9">
                    <div class="resource-list">
                        @if (count($Resources) > 0)
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">File Title</th>
                                        <th scope="col">Size</th>
                                        <th scope="col">Date Update</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($Resources as $Resource)
                                    <tr>
                                        <td>
                                            <a href="/storage/resources/{{$Resource->resource_location}}">
                                                @if($Resource->resourceType === 'ppt' || $Resource->resourceType === 'pptx' )
                                                    <i class="fa fa-file-powerpoint"></i>
                                                @elseif($Resource->resourceType === 'xls' || $Resource->resourceType === 'xlsx')
                                                    <i class="fa fa-file-excel"></i>
                                                @elseif($Resource->resourceType === 'doc' || $Resource->resourceType === 'docx')
                                                    <i class="fa fa-file-word"></i>
                                                @elseif($Resource->resourceType === 'pdf')
                                                    <i class="fa fa-file-pdf"></i>
                                                @elseif($Resource->resourceType === 'jpg' || $Resource->resourceType === 'jpeg' || $Resource->resourceType === 'png')
                                                    <i class="fa fa-file-image"></i>
                                                @endif
                                                {{$Resource->name}}
                                            </a>
                                        </td>
                                        <td>{{$Resource->size}} KB</td>
                                        <td>{{$Resource->created_at}}</td>
                                        <td>
                                            {!! Form::open(['action' => ['ResourcesController@destroy', $Resource->id], 'method' => 'POST']) !!}
                                                {{Form::hidden('_method', 'DELETE')}}
                                                {{Form::button('delete', ['class' => 'btn btn-danger', 'type' => 'submit'])}}
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p class="title">No Data found</p>
                        @endif
                    </div>
                </div>
                <div class="col-md-3">
                        <div class="sticky">
                            <p class="title"><i class="fa fa-plus"></i> Add Resource</p>
                            {!! Form::open(['action' => 'ResourcesController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                                <div class="form-group">
                                    {{Form::label('name', 'Title')}}
                                    {{Form::text('name', '', ['class' => 'form-control'])}}
                                </div>
                                <div class="form-group">
                                    {{Form::label('resource_location', 'Resource')}}
                                    {{Form::file('resource_location', ['class' => 'form-control-file'])}}
                                </div>
                                <div class="form-group text-center">
                                    {{Form::button('Upload', ['class' => 'btn btn-info', 'type' => 'submit'])}}
                                </div>
                            {!! Form::close() !!}
                        </div>
                </div>
            </div>
        </div>
    </div>
@endsection