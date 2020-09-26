
@extends('layouts.register')

@section('register-main')
    @foreach ($userTypes as $userType)
        <div class="card">
            <div class="card-header">{{ __('Register') }}</div>
            <div class="card-body">
            @if ($userType->name === "admin")
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="form-group row">
                        <label for="userType_id" class="col-md-4 col-form-label text-md-right">{{ __('Admin user') }}</label>

                        <div class="col-md-6">
                            <input id="userType_id" type="number" class="form-control" name="userType_id" value="1" hidden>
                        </div>
                    </div>

                    <div class="form-group row" hidden>
                        <label for="usable" class="col-md-4 col-form-label text-md-right">{{ __('usable') }}</label>

                        <div class="col-md-6">
                            <input id="usable" type="text" class="form-control" name="usable" value="active">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                        <div class="col-md-6">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Register') }}
                            </button>
                        </div>
                    </div>
                </form>
            @elseif ($userType->name === "teacher")
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="form-group row">
                        <label for="userType_id" class="col-md-4 col-form-label text-md-right">{{ __('Teacher user') }}</label>

                        <div class="col-md-6">
                            <input id="userType_id" type="number" class="form-control" name="userType_id" value="2" hidden>
                        </div>
                    </div>

                    <div class="form-group row" hidden>
                        <label for="usable" class="col-md-4 col-form-label text-md-right">{{ __('usable') }}</label>

                        <div class="col-md-6">
                            <input id="usable" type="text" class="form-control" name="usable" value="passive">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="school_id" class="col-md-4 col-form-label text-md-right">{{ __('School ID') }}</label>

                        <div class="col-md-6">
                            <input id="school_id" type="text" class="form-control @error('school_id') is-invalid @enderror" name="school_id" placeholder="◯◯-◯◯◯◯-◯◯" value="{{ old('school_id') }}" required autocomplete="school_id" autofocus>

                            @error('school_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                        <div class="col-md-6">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Register') }}
                            </button>
                        </div>
                    </div>
                </form>
            @elseif ($userType->name === "student")
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="form-group row">
                        <label for="userType_id" class="col-md-4 col-form-label text-md-right">{{ __('Student user') }}</label>

                        <div class="col-md-6">
                            <input id="userType_id" type="number" class="form-control" name="userType_id" value="3" hidden>
                        </div>
                    </div>

                    <div class="form-group row" hidden>
                        <label for="usable" class="col-md-4 col-form-label text-md-right">{{ __('usable') }}</label>

                        <div class="col-md-6">
                            <input id="usable" type="text" class="form-control" name="usable" value="passive">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="school_id" class="col-md-4 col-form-label text-md-right">{{ __('School ID') }}</label>

                        <div class="col-md-6">
                            <input id="school_id" type="text" class="form-control @error('school_id') is-invalid @enderror" name="school_id" placeholder="◯◯-◯◯◯◯-◯◯" value="{{ old('school_id') }}" required autocomplete="school_id" autofocus>

                            @error('school_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="section_id" class="col-md-4 col-form-label text-md-right">{{ __('Section') }}</label>

                        <div class="col-md-6">
                            <select id="section_id" class="form-control @error('section_id') is-invalid @enderror"  name="section_id" required autocomplete="section_id" autofocus>
                                <option disabled selected value> -- select section -- </option>
                                @foreach ($sections as $section)
                                    <option value="{{$section->id}}">{{$section->name}}</option>
                                @endforeach
                            </select>

                            @error('section')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                        <div class="col-md-6">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Register') }}
                            </button>
                        </div>
                    </div>
                </form>
            @elseif ($userType->name === "parent")
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="form-group row">
                        <label for="userType_id" class="col-md-4 col-form-label text-md-right">{{ __('Parent user') }}</label>

                        <div class="col-md-6">
                            <input id="userType_id" type="number" class="form-control" name="userType_id" value="4" hidden>
                        </div>
                    </div>

                    <div class="form-group row" hidden>
                        <label for="usable" class="col-md-4 col-form-label text-md-right">{{ __('usable') }}</label>

                        <div class="col-md-6">
                            <input id="usable" type="text" class="form-control" name="usable" value="passive">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="school_id" class="col-md-4 col-form-label text-md-right">{{ __('Child School ID') }}</label>

                        <div class="col-md-6">
                            <input id="school_id" type="text" class="form-control @error('school_id') is-invalid @enderror" name="school_id" placeholder="◯◯-◯◯◯◯-◯◯" value="{{ old('school_id') }}" required autocomplete="school_id" autofocus>

                            @error('school_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                        <div class="col-md-6">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Register') }}
                            </button>
                        </div>
                    </div>
                </form>
            @endif
            </div>
        </div>
    @endforeach
@endsection