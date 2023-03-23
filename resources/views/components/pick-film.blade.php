<div class="films-pick">
    <div class="search-wrapper">
        <div class="filter-wrapper js-filter-wrapper">
            <span class="filter-wrapper-text">Browse by</span>
            <div class="filter-wrapper-inner">
                <select class="filter-wrapper-select js-filter-genre js-filter">
                    <option value="genre" data-id="0" disabled selected>Genre</option>
                    <option value="all" data-id="28,12,16,35,80,99,18,10751,14,36,27,10402,9648,10749,878,10770,53,1075,37">All</option>
                    <option value="action" data-id="28">Action</option>
                    <option value="adventure" data-id="12">Adventure</option>
                    <option value="animation" data-id="16">Animation</option>
                    <option value="comedy" data-id="35">Comedy</option>
                    <option value="crime" data-id="80">Crime</option>
                    <option value="documentary" data-id="99">Documentary</option>
                    <option value="drama" data-id="18">Drama</option>
                    <option value="family" data-id="10751">Family</option>
                    <option value="fantasy" data-id="14">Fantasy</option>
                    <option value="history" data-id="36">History</option>
                    <option value="horror" data-id="27">Horror</option>
                    <option value="music" data-id="10402">Music</option>
                    <option value="mystery" data-id="9648">Mystery</option>
                    <option value="romance" data-id="10749">Romance</option>
                    <option value="science_fiction" data-id="878">Science Fiction</option>
                    <option value="tv_movie" data-id="10770">TV Movie</option>
                    <option value="thriller" data-id="53">Thriller</option>
                    <option value="war" data-id="1075">War</option>
                    <option value="western" data-id="37">Western</option>
                </select>
                <select class="filter-wrapper-select js-filter-decade js-filter">
                    <option value="decade" data-start="1860-01-01" data-end="2019-12-31" disabled selected>Decade</option>
                    <option value="all" data-start="1860-01-01" data-end="2019-12-31">All</option>
                    <option value="2010s" data-start="2010-01-01" data-end="2019-12-31">2010s</option>
                    <option value="2000s" data-start="2000-01-01" data-end="2009-12-31">2000s</option>
                    <option value="1990s" data-start="1990-01-01" data-end="1999-12-31">1990s</option>
                    <option value="1980s" data-start="1980-01-01" data-end="1989-12-31">1980s</option>
                    <option value="1970s" data-start="1970-01-01" data-end="1979-12-31">1970s</option>
                    <option value="1960s" data-start="1960-01-01" data-end="1969-12-31">1960s</option>
                    <option value="1950s" data-start="1950-01-01" data-end="1959-12-31">1950s</option>
                    <option value="1940s" data-start="1940-01-01" data-end="1949-12-31">1940s</option>
                    <option value="1930s" data-start="1930-01-01" data-end="1939-12-31">1930s</option>
                    <option value="1920s" data-start="1920-01-01" data-end="1929-12-31">1920s</option>
                    <option value="1910s" data-start="1910-01-01" data-end="1919-12-31">1910s</option>
                    <option value="1900s" data-start="1900-01-01" data-end="1909-12-31">1900s</option>
                    <option value="1890s" data-start="1890-01-01" data-end="1899-12-31">1890s</option>
                    <option value="1880s" data-start="1870-01-01" data-end="1889-12-31">1880s</option>
                    <option value="1870s" data-start="1860-01-01" data-end="1879-12-31">1870s</option>
                </select>
            </div>
        </div>
        <div class="signup-input-wrapper search-input-wrapper">
            <span class="signup-icon fas fa-search"></span>
            <input type="search" class="signup-input search js-search-film" placeholder="Search a film">
        </div>
    </div>

    <div class="search-results js-search-results">
        <div class="search-results-left">
            <span class="search-results-title">Search results for <span class="js-search-query"></span>
        </div>
    </div>

    <div class="sort-results js-sort-wrapper">
        <select class="sort-select js-sort-results">
            <optgroup label="Sort by popularity">
                <option value="Most popular" data-sort="most-popular">Most popular</option>
                <option value="Least popular" data-sort="least-popular">Least popular</option>
            </optgroup>
            <optgroup label="Sort by rating">
                <option value="Highest first" data-sort="highest">Highest first</option>
                <option value="Lowest first" data-sort="lowest">Lowest first</option>
            </optgroup>
            <optgroup label="Sort by release date">
                <option value="Newest first" data-sort="newest">Newest first</option>
                <option value="Earliest first" data-sort="earliest">Earliest first</option>
            </optgroup>
        </select>
    </div>

    <div class="films-container js-films-container">
        <div class="films js-films">
            @for ($i=0; $i < 18; $i++)
                <div class="films-item-placeholder"></div>
            @endfor
        </div>
        <div class="loader js-loader"></div>
    </div>

    <div class="pagination js-pagination" data-page="1">
        <button class="js-paginate js-previous previous disabled">Previous</button>
        <button class="js-paginate js-next next">Next</button>
    </div>
</div>
