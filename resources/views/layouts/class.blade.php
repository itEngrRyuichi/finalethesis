@extends('layouts.app')

@section('main')
<div class="class-showcase">
    <div class="container">
        <div class="row">
            @include('inc.class-nav')
            <div class="col-md-10 class-main">
                @yield('class-main')
            </div>
        </div>
    </div>
</div>
@endsection