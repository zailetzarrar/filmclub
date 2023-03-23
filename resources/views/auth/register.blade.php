@extends('layouts.master')

@section('content')
    <section class="signup">
        <div class="signup-wrapper">
            <div class="signup-top">
                <h1 class="signup-title">Club Signup</h1>
            </div>
            <div class="signup-inner">
                <h2 class="signup-subtitle">
                    @isset($member)
                        Sign up to become a member
                    @else
                        Sign up to create film clubs
                    @endisset
                </h2>
                    <form method="POST" action="#" class="signup-form">
                        @csrf
                    <div class="signup-input-wrapper">
                        <span class="signup-icon fas fa-envelope"></span>
                        <input class="signup-input" type="email" value="{{ old('email') }}" name="email" id="email" placeholder="E-mail address">
                      @if ($errors->has('email'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                      @endif
                    </div>
                    <div class="signup-input-wrapper">
                        <span class="signup-icon fas fa-user"></span>
                        <input class="signup-input" type="text" name="username" value="{{ old('username') }}" id="username" placeholder="Username">
                        @if ($errors->has('username'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('username') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="signup-input-wrapper">
                        <span class="signup-icon fas fa-lock"></span>
                        <input class="signup-input" type="password" name="password" id="password" placeholder="Password">
                        @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="signup-input-wrapper">
                        <span class="signup-icon fas fa-lock"></span>
                        <input class="signup-input" type="password" name="password_confirmation" id="confirm_password" placeholder="Confirm password">
                    </div>

                    <div class="signup-submit-wrapper">
                        <button onclick="block_sumbmit()" class="signup-submit button">
                            @isset($member)
                                Sign up &amp; join the club
                            @else
                                Sign up &amp; create a club
                            @endisset
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
