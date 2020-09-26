

@if(count($accesscodes) > 0)
    <div class="col-md-8">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">name</th>
                    <th scope="col">accesscode</th>
                    <th scope="col">allow_from</th>
                    <th scope="col">allow_to</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($accesscodes as $accesscode)
                <tr>
                    <th scope="row">#</th>
                    <td>{{$accesscode->name}}</td>
                    <td>{{$accesscode->accesscode}}</td>
                    <td>{{$accesscode->allow_from}}</td>
                    <td>{{$accesscode->allow_to}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@else
    <p class="title">no accesscode found</p>
@endif

{!! Form::open(['action' => 'AccesscodeController@update', 'method' => 'POST']) !!}
                                <th scope="row"></th>
                                <td>{{Form::text('accesscode', $accesscode->accesscode, ['class' => 'form-control', 'readonly' => 'true'])}}</td>
                                <td>{{Form::select('user_types',  ['teacher' => 'teacher', 'student' => 'student', 'parent' => 'parent'], $accesscode->name, ['class' => 'form-control'])}}</td>
                                <td>{{Form::input('dateTime-local', 'allow_from', $accesscode->allow_from, ['class' => 'form-control'])}}</td>
                                <td>{{Form::input('dateTime-local', 'allow_to', $accesscode->allow_to, ['class' => 'form-control'])}}</td>
                                {{!! Form::close() !!}}