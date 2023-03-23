@extends('layouts.master')
@section('content')
    <section class="signup">
        <div class="signup-wrapper">
            <div class="signup-top">
                <h1 class="signup-title">Filmclub.app</h1>
            </div>
            <div class="signup-inner">
                <h2 class="signup-subtitle">Enter your e-mail address to request a new password</h2>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}" class="signup-form">
                        @csrf

                        <div class="signup-input-wrapper">
                            <span class="signup-icon fas fa-envelope"></span>
                            <input class="signup-input" type="email" name="email" id="email" value="{{ old('email') }}" placeholder="E-mail address" required>
                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                             <div class="signup-submit-wrapper">
                               <button class="signup-submit button">Send Password Reset Link</button>
                             </div>
                            </div>
                        </div>
                    </form>
                 </div>
               </div>
         </section>
@endsection