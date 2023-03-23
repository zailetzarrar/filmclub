@extends('layouts.master')

@section('content')
    <section class="discussion">
        <div class="current-pick section">
            <div class="section-title">
                <h1 class="discussion-title">Movie discussion</h1>
            </div>
            @if(!empty($movie))
            <div class="current-pick-inner">
                <div class="current-pick-top">
                    <div class="films-info-top-poster">
                        <img src="{{ $movie->poster }}" class="films-info-top-poster-image">
                    </div>
                    <div class="films-info-top-content">
                        <h2 class="film-title">{{ $movie->title }}</h2>
                        <h3 class="film-director">Directed by: {{ $movie->director }}</h2>
                        <div class="film-genres-wrapper">
                            <h3 class="film-genres-title">Genre: </h3>
                            <span class="film-genres">
                                @if(!empty($movie->genres))
                                @php
                                  $genres = json_decode($movie->genres);
                                @endphp
                                @foreach($genres as $genre)
                                <span class="film-genre">{{ $genre }}</span>
                                @endforeach
                                @endif
                            </span>
                        </div>
                        <h3 class="film-year">Release year: {{ $movie->year }}</h3>
                        <p class="film-description">{{ $movie->description }}</p>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <div class="discussion-area section">
            <div class="section-title">
                <h1 class="discussion-title">Discussion area</h1>
            </div>
            <div class="discussion-inner">
                @foreach($movie->getRelation('comments') as $comment)
                    <div class="discussion-item">
                        <div class="discussion-profile">
                            <div class="discussion-profile-bg">
                                {{ strtoupper($comment->getRelation('comment_user')->username[0]) }} <!-- First letter of username -->
                            </div>
                        </div>
                        <div class="discussion-content">
                            <div class="discussion-content-top">
                                <p class="discussion-user">{{ $comment->getRelation('comment_user')->username }}</p>
                                <time datetime="2019-03-30" class="discussion-date">{{ date_format($comment->created_at,'D, H:i') }}</time>
                            </div>
                            <p class="discussion-content-bottom">
                                {{ $comment->comment }}
                            </p>
                        </div>
                    </div>
                @endforeach

                <form class="discussion-comment-form" action="#">
                    @csrf
                    @if(!empty($movie))
                        <input type="hidden" name="mmdd" value="{{ Crypt::encryptString($movie->mid) }}">
                    @endif
                    <textarea name="comment" placeholder="Leave a comment to add to the discussion" required></textarea>
                    <button class="button discussion-comment-submit" onclick="block_discussion_ratings()">Add comment</button>
                </form>
            </div>
        </div>
    </section>
@endsection
