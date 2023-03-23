@extends('layouts.master')

@section('content')
    <div class="signup">
        <div class="signup-wrapper">
            <div class="signup-top">
                <h1 class="signup-title">Filmclub.app</h1>
            </div>
            @if($status)
            <div class="signup-inner">
                <div class="success-check-mark"></div>
                <h2 class="success-title">You have successfully joined <span class="success-club">{{ $club->club_name }}</span>!</h2>
                <a href="#" class="button">Go to dashboard</a>
            </div>
            @else
            <div class="signup-inner">
                <h2 class="success-title">Some problem occured try again later</h2>
                <a href="#" class="button">Go to dashboard</a>
            </div>
            @endif
        </div>
    </div>
@endsection
