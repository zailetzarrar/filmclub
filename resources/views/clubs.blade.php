@extends('layouts.master')

@section('content')
    <section class="discussion">
        <h1 style="font-size:xx-large;color:white;margin:10px;">Clubs Own</h1>
        @if($ownclubs->isEmpty())
            <p style="color:orange;">No club own by you</p>
        @else
        @foreach($ownclubs as $oclub)
            <p style="margin:2px;"><a style="color:orange;" href="{{ url('/club-info/'.$oclub->token) }}">{{ $oclub->name }}</a></p>
        @endforeach
        @endif

        <h1 style="font-size:xx-large;color:white;margin:10px;">Clubs Join</h1>
        @if($joinclubs->isEmpty())
            <p style="color:orange;">You are not member of any club</p>
        @else
        @foreach($joinclubs as $jclub)
            <p style="margin:2px;"><a style="color:orange;" href="{{ url('/club-info/'.$jclub->getRelation('get_clubs')->token) }}">{{ $jclub->getRelation('get_clubs')->name }}</a></p>
        @endforeach
        @endif
    </section>
@endsection
