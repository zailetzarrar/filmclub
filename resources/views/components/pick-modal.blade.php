<section class="picker-modal">
    <div class="picker-modal-background js-close-picker">
    </div>
    <div class="picker-modal-wrapper">
        <div class="section-title">
            <h1 class="discussion-title">Pick a movie for the next round</h1>
        </div>
        <div class="picker-modal-dialog js-picker-dialog">
            @include('components/pick-film-member')

            <div class="picker-film-info films-info-inner js-info-inner">
                <div class="films-info-top">
                    <div class="films-info-top-poster">
                        <img src="https://image.tmdb.org/t/p/w300/xPihqTMhCh6b8DHYzE61jrIiNMS.jpg" class="js-info-poster films-info-top-poster-image">
                    </div>
                    <div class="films-info-top-content">
                        <h2 class="film-title js-film-title"></h2>
                        <h3 class="film-director">Directed by <span class="js-director">John Smith</span></h2>
                        <div class="film-genres-wrapper">
                            <h3 class="js-genres-title film-genres-title">Genre: </h3>
                            <span class="js-genres film-genres"></span>
                        </div>
                        <h3 class="film-year">Release year: <span class="js-year">2011</span></h3>
                        <p class="film-description js-description"></p>
                    </div>
                </div>

                <div class="films-info-bottom-input">
                    <label for="deadline" class="film-deadline-label">Set a deadline to watch the film</label>
                    <input type="date" value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}" max="{{ date('Y-m-d', strtotime('+14 days')) }}" name="deadline" id="deadline" class="js-deadline film-deadline-date" required>
                    <div class="icon-wrapper">
                        <i class="fas fa-calendar-alt icon"></i>
                    </div>
                </div>
    
                <div class="films-info-buttons">
                    <button class="button js-member-pick">Pick film</button>
                </div>
            </div>
        </div>
    </div>
</section>
