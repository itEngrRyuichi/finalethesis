@extends('layouts.app')

@section('main')
<div class="acclis-showcase">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="sticky">
                        <div class="card">
                            <div class="card-body">
                                <p class="card-title">{{$section->name}}</p> 
                            </div>
                            <img src="/storage/images/section/{{$section->sectionPic_locaiton}}" class="card-img">
                            <div class="card-body">
                                <p class="card-subtitle">{{$section->gradeLevel}}</p> 
                                <p class="card-text">{{$section->description}}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="text-right">
                        <a href="/sectionCatalog" class="text btn"><i class="fa fa-columns"></i> Back to catalog</a>
                    </div>
                    <table class="table">
                        @if (count($students) > 0)
                            <thead>
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">ID Number</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($students as $student)
                                    <tr>
                                        <td>{{$student->name}}</td>
                                        <td>{{$student->school_id}}</td>
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
