@extends('layouts.class')

@section('class-main')
    <div class="classResource-showcase">
        <p class="class-title">Resources</p>
        <p class="class-subtitle">Lorem ipsum dolor sit amet consectetur adipisicing elit. Eum dolor doloribus consectetur praesentium perspiciatis aliquid quibusdam similique molestias quos, sunt delectus tempore, officiis tempora? Voluptate consequuntur autem at fuga minus.</p>
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="resource-list">
                    @if (count($classResources) > 0)
                        <table class="table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th scope="col">File Title</th>
                                    <th scope="col">Size</th>
                                    <th scope="col">Date Update</th>
                                    @if (Auth::user()->userType_id === 2)
                                        <th scope="col"></th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($classResources as $classResource)
                                    <tr>
                                        <td></td>
                                        <td>
                                            <a href="/storage/resources/{{$classResource->classResource_location}}">
                                                @if($classResource->resourceType === 'ppt' || $classResource->resourceType === 'pptx')
                                                    <i class="fa fa-file-powerpoint"></i>
                                                @elseif($classResource->resourceType === 'xls' || $classResource->resourceType === 'xlsx')
                                                    <i class="fa fa-file-excel"></i>
                                                @elseif($classResource->resourceType === 'doc' || $classResource->resourceType === 'docx')
                                                    <i class="fa fa-file-word"></i>
                                                @elseif($classResource->resourceType === 'pdf')
                                                    <i class="fa fa-file-pdf"></i>
                                                @elseif($classResource->resourceType === 'jpg' || $classResource->resourceType === 'jpeg' || $classResource->resourceType === 'png')
                                                    <i class="fa fa-file-image"></i>
                                                @endif
                                                {{$classResource->name}}
                                            </a>
                                        </td>
                                        <td>{{$classResource->size}} KB</td>
                                        <td>{{$classResource->created_at}}</td>
                                        @if (Auth::user()->userType_id === 2)
                                            <td>
                                                {!! Form::open(['action' => ['ClassResourcesController@destroy', $class_id, $classResource->id], 'method' => 'POST']) !!}
                                                    {{Form::hidden('_method', 'DELETE')}}
                                                    {{Form::button('delete', ['class' => 'btn btn-danger', 'type' => 'submit'])}}
                                                {!! Form::close() !!}
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="class-title">No Data found</p>
                    @endif
                </div>
            </div>
            @if (Auth::user()->userType_id === 2)
                <div class="col-md-3">
                    <div class="sticky">
                        <p class="class-title"><i class="fa"></i> Add Resource</p>
                        {!! Form::open(['action' => ['ClassResourcesController@store', $class_id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                            <div class="form-group">
                                {{Form::label('name', 'Title')}}
                                {{Form::text('name', '', ['class' => 'form-control'])}}
                            </div>
                            <div class="form-group">
                                {{Form::label('classResource_location', 'Resource')}}
                                {{Form::file('classResource_location', ['class' => 'form-control-file'])}}
                            </div>
                            <div class="form-group text-center">
                                {{Form::button('Upload', ['class' => 'btn btn-info', 'type' => 'submit'])}}
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            @endif
        </div>
    </div>
    
@endsection