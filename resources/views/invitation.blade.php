@extends('layouts.master')

@section('content')
    <section class="signup create-club">
        <div class="signup-wrapper">
            <div class="signup-top">
                <h1 class="signup-title">Filmclub.app</h1>
            </div>
            @if(isset($error))
            <div class="signup-inner">
                <h2>No club found</h2>
            </div>
            @else
            <div class="signup-inner">
                <div class="signup-club-info">
                    <h2 class="signup-subtitle">
                        Invitation to join the film club
                        <span class="signup-subtitle-film">{{ $data['club']->club_name }}</span>
                    </h2>
                    <h3>Club admin: {{ $data['admin']->username }}</h3>
                </div>
                <div class="signup-banner">
                    Film picked by mjacobi913
                </div>
                <div class="films-info-inner three no-border">
                    <div class="films-info-top">
                        <div class="films-info-top-poster">
                            <img src="{{ $data['movie']->poster }}" class="films-info-top-poster-image">
                        </div>
                        <div class="films-info-top-content">
                            <h2 class="film-title">{{ $data['movie']->title }}</h2>
                            <h3 class="film-director">Directed by: {{ $data['movie']->director }}</h3>
                            <div class="film-genres-wrapper">
                                <h3 class="film-genres-title">Genre: </h3>
                                <span class="film-genres">
                                    @foreach(json_decode($data['movie']->genres) as $genre)
                                    <span class="film-genre">{{ $genre }}</span>
                                    @endforeach
                                </span>
                            </div>
                            <h3 class="film-year">Release year: {{ $data['movie']->year }}</h3>
                            <p class="film-description">
                                {{ $data['movie']->description }}
                            </p>
                        </div>
                    </div>
                </div>
                @auth
                @if(isset($data['member']))
                <button class="button">You are already member</button>
                @elseif(isset($data['count']))
                <button class="button">Club Required Number Of Members Acheived</button>
                @else
                <form method="POST" action="{{ url('/invitation-accepted/'.$data['club']->token) }}">
                    {{ csrf_field() }}
                    <button type="submit" class="button" onclick="this.disabled=true;this.value='Sending, please wait...';this.form.submit();">Join the club</button>
                </form>
                @endif
                @endauth
                @guest
                <a href="{{ url('/login') }}" class="button">Sign up and join the club</a>
                @endguest
            </div>
            @endif
        </div>
    </section>
@endsection
