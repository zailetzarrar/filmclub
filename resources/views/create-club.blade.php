@extends('layouts.master')

@section('content')
    <section class="signup create-club">
        <div class="signup-wrapper">
            <div class="signup-top">
                <h1 class="signup-title">Make Your Club</h1>
            </div>
            <!-- Step 1 -->
            @include('components/signup-step-one')

            <!-- Step 2 -->
            @include('components/signup-step-two')

            <!-- Step 3 -->
            @include('components/signup-step-three')
        </div>
    </section>
@endsection
