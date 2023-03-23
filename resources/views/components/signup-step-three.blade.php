<div class="signup-content js-step js-step-three">
    <div class="signup-progress-wrapper">
            <h2 class="signup-subtitle">Create a film club</h2>
    
            <div class="signup-progress">
                <ol class="signup-progress-list">
                    <li class="signup-progress-item js-progress js-progress-one">
                        <span class="signup-progress-item-number">1</span>
                    </li>
                    <li class="signup-progress-item js-progress js-progress-two">
                        <span class="signup-progress-item-number">2</span>
                    </li>
                    <li class="signup-progress-item js-progress js-progress-three active no-events">
                        <span class="signup-progress-item-number">3</span>
                    </li>
                </ol>
            </div>
        </div>
    <div class="signup-banner">
        Film picked by you
        <button class="signup-banner-button js-progress js-progress-two">Change pick</button>
    </div>
    <div class="films-info-inner three js-info-inner">
        <div class="films-info-top">
            <div class="films-info-top-poster">
                <img src="https://image.tmdb.org/t/p/w300/xPihqTMhCh6b8DHYzE61jrIiNMS.jpg" class="js-info-poster js-data-poster films-info-top-poster-image">
            </div>
            <div class="films-info-top-content">
                <h2 class="film-title js-film-title js-data-title"></h2>
                <h3 class="film-director">Directed by <span class="js-director js-data-director"></span></h2>
                <div class="film-genres-wrapper">
                    <h3 class="js-genres-title film-genres-title">Genre: </h3>
                    <span class="js-genres js-data-genres film-genres"></span>
                </div>
                <h3 class="film-year">Release year: <span class="js-year js-data-year">2011</span></h3>
                <p class="film-description js-description js-data-description"></p>
            </div>
        </div>
    </div>
    <div class="films-info-bottom">
        <div class="films-info-bottom-input">
            <label for="deadline" class="film-deadline-label">Set a deadline to watch the film</label>
            <input type="date" value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}" max="{{ date('Y-m-d', strtotime('+14 days')) }}" name="deadline" id="deadline" class="js-deadline film-deadline-date" required>
            <div class="icon-wrapper">
                <i class="fas fa-calendar-alt icon"></i>
            </div>
        </div>
    </div>
    <form action="{{ url('/create_club_ajax') }}" method="POST" class="js-confirm-pick-form">
        <div class="films-info-buttons">
            <button type="button" class="button js-create-club">Create club</button>
        </div>
    </form>
</div>
