<header class="header">
    <div class="content header-wrapper">
        <h1 class="header-logo">
            <a href="{{ url('/') }}" class="header-logo-link">
                <h2>Demo App</h2>
            </a>
        </h1>
        <div class="header-nav-wrapper">
            @auth
                <nav class="header-nav">
                    <ul class="header-menu">
                        <li class="header-menu-item">
                            <a href="{{ url('/') }}" class="header-menu-link">
                                Home
                            </a>
                        </li>
                        <li class="header-menu-item">
                            <a href="{{ url('/clubs') }}" class="header-menu-link">
                                Clubs
                            </a>
                        </li>
                    </ul>
                </nav>
            @endauth
        </div>
        <div class="header-user">
            @auth
                <a href="" class="header-user-link">
                    {{ Auth::user()->username }}
                </a>
                <a href="{{ url('/logout') }}" class="header-user-link">
                    Logout
                </a>
            @endauth
            @guest
                <a href="{{ route('login') }}" class="header-user-link">
                    Login
                </a>
                <a href="{{ route('register') }}" class="header-user-link">
                    Signup
                </a>
            @endguest
        </div>
    </div>
</header>
