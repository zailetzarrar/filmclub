@extends('layouts.master')

@section('content')
    <section class="signup">
        <div class="signup-wrapper">
            <div class="signup-top">
                <h1 class="signup-title">Club Login</h1>
            </div>
            <div class="signup-inner">
                <h2 class="signup-subtitle">Login to your account</h2>
                    <form method="POST" action="{{ route('login') }}" class="signup-form">
                    @csrf

                    <div class="signup-input-wrapper">
                        <span class="signup-icon fas fa-user"></span>
                        <input class="signup-input" type="text" name="username" value="{{ old('username') }}" id="username" placeholder="Username" required>
                        @if ($errors->has('username'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('username') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="signup-input-wrapper">
                        <span class="signup-icon fas fa-lock"></span>
                        <input class="signup-input" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" id="password" placeholder="Password" required>                        
                        @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="signup-submit-wrapper signup-buttons">
                        <button type="submit" class="signup-submit button">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
