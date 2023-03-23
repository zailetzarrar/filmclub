import $ from 'jquery';
import Globals from '../helpers/Globals';
import ContentLock from './ContentLock';

const { $body } = Globals;

const apiKey = '5c127393faf0ad3fc87552a01ce7258b';
let url = '';

export default {
    init() {
        this.loadRandomFilms();

        $body.on('keyup', '.js-search-film', e => this.searchFilm(e));
        $body.on('change', '.js-filter-genre, .js-filter-decade', e => this.filterResults(e));
        $body.on('change', '.js-sort-results', () => this.sortResults());
        $body.on('click', '.js-film-item', e => this.showFilmInfo(e));
        $body.on('click', '.js-close-picker', () => this.closeFilmInfo());
        $body.on('click', '.js-previous', () => this.previousPage());
        $body.on('click', '.js-next', () => this.nextPage());
        $body.on('click', '.js-create-club', e => this.createClub(e));

        $body.on('click', '.js-next-pick', () => this.showPickerModal());
        $body.on('click', '.js-member-pick', e => this.memberPick(e));
    },

    memberPick(e) {
        e.preventDefault();
        e.stopImmediatePropagation();

        const title = $('.js-film-title').text();
        const director = $('.js-data-director').text();
        const year = $('.js-data-year').text();
        const genres = $('.js-genres-title').data('genre-array');
        const description = $('.js-data-description').text();
        const poster = $('.js-data-poster').attr('src');
        const deadline = $('.js-deadline').val();
        const timestamp = new Date(deadline).getTime() / 1000;

        const action = $('.js-member-pick-form').attr('action');
        const data = {
            requesting: 'pick_film',
            film: {
                title,
                director,
                year,
                description,
                genres,
                poster,
                time_limit: timestamp,
            },
        };

        console.log(data);

        $.ajax({
            url: action,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            type: 'post',
            data,
            dataType: 'json',
        })
            .done(() => {
                const markup = `<div class="films-info-bottom success">
                    <div class="success-check-mark"></div>
                    <h2 class="success-title">Success!</h2>
                    <h3 class="success-subtitle">Your pick has been successfully set as the film for this round. You can go to your dashboard and see the updates.</h2>
                    <h3 class="success-subtitle">Enjoy the movie!</h3>
                    <a href="#" class="button js-close-picker">Back to dashboard</a>
                </div>`;
                $('.js-picker-dialog').html(markup);
            })
            .fail((err) => {
                console.warn(err);
                console.warn('failed');
            });
    },

    showPickerModal() {
        $('.js-picker-inner').show();
        $body.addClass('modal-open');
        ContentLock.lock();
    },

    loadRandomFilms() {
        const random = this.randomize(500);
        const $parent = $('.js-films');
        const $searchResults = $('.js-search-results');
        url = `https://api.themoviedb.org/3/discover/movie?api_key=${apiKey}&page=${random}`;

        $parent.attr('data-url', url);
        $parent.html('');

        $.ajax({
            url,
            type: 'GET',
            dataType: 'json',
        })
            .done((response) => {
                if (response.total_results > 18) $('.js-pagination').addClass('active');
                else $('.js-pagination').removeClass('active');
                this.showResults(response);
            })
            .fail((err) => {
                console.warn(err);
            });

        $searchResults.removeClass('active');
    },

    searchFilm(e) {
        const container = $('.js-films-container');
        const parent = $('.js-films');
        const loader = $('.js-loader');
        const $curr = $(e.currentTarget);
        const currVal = $curr.val();

        url = `https://api.themoviedb.org/3/search/movie?api_key=${apiKey}&page=1&sort_by=popularity.desc&query=${currVal}`;

        if (currVal.length) {
            parent.removeClass('active');
            loader.addClass('loading');
            container.addClass('no-events');
            parent.attr('data-search-url', url);

            $.ajax({
                url,
                type: 'GET',
                dataType: 'json',
            })
                .done((response) => {
                    if (response.total_results > 18) $('.js-pagination').addClass('active');
                    else $('.js-pagination').removeClass('active');

                    parent.addClass('active');
                    $('.js-search-query').text(`'${currVal}'`);
                    $('.js-search-results').addClass('active');

                    this.showResults(response, currVal);
                })
                .fail(() => {
                    const markup = '<span class="films-item-none">Could not find a match.</span>';
                    parent.html(markup);
                    loader.removeClass('loading');
                    container.removeClass('no-events');
                });
        } else this.loadRandomFilms();
    },

    filterResults() {
        const id = $('.js-filter-genre option:selected').data('id');
        const genre = `&with_genres=${id}`;
        const startDate = $('.js-filter-decade option:selected').data('start');
        const endDate = $('.js-filter-decade option:selected').data('end');
        const decade = `&primary_release_date.gte=${startDate}&primary_release_date.lte=${endDate}`;
        const parent = $('.js-films');

        url = `https://api.themoviedb.org/3/discover/movie?api_key=${apiKey}&page=1`;

        if (id !== 0) url += genre;
        url += decade;
        parent.attr('data-url', url);

        $.ajax({
            url,
            type: 'GET',
            dataType: 'json',
        })
            .done((response) => {
                if (response.total_results > 18) $('.js-pagination').addClass('active');
                else ($('.js-pagination').removeClass('active'));

                $('.js-previous').addClass('disabled');
                $('.js-search-film').val('');
                $('.js-search-results').removeClass('active');

                this.showResults(response);
            })
            .fail((err) => {
                console.warn(err);
            });
    },

    randomize(max) {
        return Math.floor(Math.random() * Math.floor(max));
    },

    showResults(response) {
        const container = $('.js-films-container');
        const parent = $('.js-films');
        const loader = $('.js-loader');

        parent.html('');

        if (response.results.length) {
            response.results.slice(0, 18).forEach((result) => {
                const image = () => {
                    if (result.poster_path === null) return 'http://www.theprintworks.com/wp-content/themes/psBella/assets/img/film-poster-placeholder.png';
                    return `https://image.tmdb.org/t/p/w300${result.poster_path}`;
                };

                const markup = `<div class="films-item js-film-item" data-id="${result.id}" data-title="${result.title}" data-genres="${result.genre_ids} "data-description="${result.overview}" data-year="${result.release_date}" title="${result.title} (${result.release_date.substring(0, 4)})">
                    <img src="${image()}" class="js-poster films-item-poster image-responsive" />
                    <div class="films-item-hover-content">
                        <div class="rating">
                            <span class="fa fa-star"></span>
                            ${(result.vote_average / 2).toFixed(1)}
                        </div>
                        <div class="films-item-pick">Pick</div>
                    </div>
                </div>`;

                if (result) parent.append(markup);
                setTimeout(() => { parent.addClass('active'); }, 500);

                loader.removeClass('loading');
                container.removeClass('no-events');
            });
        } else {
            const markup = '<span class="films-item-none">Could not find a match.</span>';
            parent.html(markup);
            loader.removeClass('loading');
            container.removeClass('no-events');
        }
    },

    sortResults() {
        const parent = $('.js-films');
        const sortType = $('.js-sort-results option:selected').data('sort');

        console.log(sortType);

        let sort = '';

        if (sortType === 'most-popular') sort = 'popularity.desc';
        else if (sortType === 'least-popular') sort = 'popularity.asc';
        else if (sortType === 'highest') sort = 'vote_average.desc';
        else if (sortType === 'lowest') sort = 'vote_average.asc';
        else if (sortType === 'newest') sort = 'release_date.desc';
        else if (sortType === 'earliest') sort = 'release_date.asc';

        url = parent.attr('data-url');
        url += `&sort_by=${sort}`;

        console.log(url);

        $.ajax({
            url,
            type: 'GET',
            dataType: 'json',
        })
            .done((response) => {
                this.showResults(response);
            })
            .fail((err) => {
                console.warn(err);
            });
    },

    showFilmInfo(e) {
        const $curr = $(e.currentTarget);
        const filmId = $curr.data('id');
        const title = $curr.data('title');
        const description = $curr.data('description');
        const year = $curr.data('year');
        const genres = $curr.data('genres');
        const poster = $curr.find('.js-poster').attr('src');

        if ($body.hasClass('modal-open')) $('.js-picker-inner').hide();

        setTimeout(() => { $('.js-info-inner').addClass('active'); }, 300);

        const directors = [];
        url = `https://api.themoviedb.org/3/movie/${filmId}/credits?api_key=${apiKey}`;

        $.ajax({
            url,
            type: 'GET',
            dataType: 'json',
        })
            .done((response) => {
                response.crew.forEach((entry) => {
                    if (entry.job === 'Director') {
                        directors.push(`${entry.name}`);
                    }

                    $('.js-director').text(directors.join(', '));
                });
            })
            .fail((err) => {
                console.warn(err);
            });

        $('.js-genres').html('');

        const idToGenre = (id) => {
            if (id === 28) return 'Action';
            if (id === 12) return 'Adventure';
            if (id === 16) return 'Animation';
            if (id === 35) return 'Comedy';
            if (id === 80) return 'Crime';
            if (id === 99) return 'Documentary';
            if (id === 18) return 'Drama';
            if (id === 10751) return 'Family';
            if (id === 14) return 'Fantasy';
            if (id === 36) return 'History';
            if (id === 27) return 'Horror';
            if (id === 10402) return 'Music';
            if (id === 9648) return 'Mystery';
            if (id === 10749) return 'Romance';
            if (id === 878) return 'Science Fiction';
            if (id === 10770) return 'TV Movie';
            if (id === 53) return 'Thriller';
            if (id === 10752) return 'War';
            if (id === 37) return 'Western';
            return null;
        };

        const newGenres = genres.split(',');
        const genresArray = [];

        newGenres.forEach((genre) => {
            genresArray.push((idToGenre(parseInt(genre, 10))));
        });

        $('.js-genres-title').data('genre-array', genresArray);

        $('.js-info-poster').attr('src', poster);
        $('.js-film-title').text(title);
        $('.js-description').text(description);
        $('.js-year').text(year.slice(0, 4));

        genresArray.forEach((genre) => {
            const markup = `<span class="js-genre film-genre">${genre}</span>`;
            $('.js-genres').append(markup);
        });

        $body.addClass('pick-film-open');
        ContentLock.lock();
    },

    closeFilmInfo() {
        $body.removeClass('pick-film-open');
        $body.removeClass('modal-open');
        $('.js-info-inner').removeClass('active');
        ContentLock.unlock();
    },

    nextPage() {
        const $pagination = $('.js-pagination');
        const $parent = $('.js-films');

        let currPage = $('.js-pagination').data('page');

        url = $parent.attr('data-url');

        currPage += 1;
        $pagination.data('page', currPage);

        url += `&page=${currPage}`;

        $.ajax({
            url,
            type: 'GET',
            dataType: 'json',
        })
            .done((response) => {
                $('.js-previous').removeClass('disabled');
                this.showResults(response);
            })
            .fail((err) => {
                console.warn(err);
            });
    },

    previousPage() {
        const $pagination = $('.js-pagination');
        const $parent = $('.js-films');

        let currPage = $pagination.data('page');

        url = $parent.attr('data-url');

        currPage -= 1;
        $pagination.data('page', currPage);

        url += `&page=${currPage}`;

        $.ajax({
            url,
            type: 'GET',
            dataType: 'json',
        })
            .done((response) => {
                if (currPage <= 1) $('.js-previous').addClass('disabled');
                this.showResults(response);
            })
            .fail((err) => {
                console.warn(err);
            });
    },

    createClub(e) {
        e.preventDefault();
        e.stopImmediatePropagation();

        const name = $('.js-data-name').val();
        const members = $('.js-data-members').val();
        const title = $('.js-data-title').text();
        const director = $('.js-data-director').text();
        const year = $('.js-data-year').text();
        const genres = $('.js-genres-title').data('genre-array');
        const description = $('.js-data-description').text();
        const poster = $('.js-data-poster').attr('src');
        const deadline = $('.js-deadline').val();
        const timestamp = new Date(deadline).getTime() / 1000;

        const action = $('.js-confirm-pick-form').attr('action');
        const data = {
            requesting: 'club_create_request',
            club: {
                name,
                members,
            },
            film: {
                title,
                director,
                year,
                description,
                genres,
                poster,
                time_limit: timestamp,
            },
        };

        $.ajax({
            url: action,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            type: 'post',
            data,
            dataType: 'json',
        })
            .done((response) => {
                const markup = `<div class="films-info-bottom success">
                    <h2 class="success-title">You have successfully created <span class="success-club">${name}</span>!</h2>
                    <div class="films-info-bottom-input success">
                        <label for="shareable_link" class="film-deadline-label">Invite friends to join the club through this shareable link</label>
                        <input type="text" name="shareable_link" id="shareable_link" class="js-shareable-link film-deadline-date" value="${response}" readonly spellcheck="false">
                        <button class="icon-wrapper js-clipboard" title="Copy to clipboard">
                            <i class="fas fa-clipboard icon"></i>
                            <span class="clipboard-tooltip js-clipboard-tooltip">Copy to clipboard</span>
                        </button>
                    </div>
                    <a href="#" class="button">Go to dashboard</a>
                </div>`;
                $('.js-step-one').remove();
                $('.js-step-two').remove();
                $('.js-step-three').html(markup);
                console.log(response);
            })
            .fail((err) => {
                console.warn(err);
                console.warn('failed');
            });
    },
};
