<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.head.master')
</head>
    <body>

        <div class="page-wrapper">
            @include('layouts.header.master')

            <main class="main" role="main">
                @yield('content')
            </main>

            @include('layouts.footer.master')
        </div>

        @include('components.modal')
        @include('components.pick-modal')

        @include('layouts.scripts.master')
    </body>
</html>
