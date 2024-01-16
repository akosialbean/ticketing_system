<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-sm bg-dark navbar-dark sticky-top">
            <div class="container-fluid">
                <span class="navbar-text small p-0 m-0">Ticketing System</span>
            </div>
        </nav>
    </header>

    <nav>
        <nav class="navbar navbar-expand-sm bg-light navbar-light sticky-top">
            <div class="container-fluid">
                <a class="navbar-brand h1" href="#">WMC</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse float-end" id="collapsibleNavbar">
                    {{-- @if(Auth::user()) --}}
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="/alltickets">Tickets</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Link</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Link</a>
                            </li>
                        </ul>
                    {{-- @endif --}}
                </div>
            </div>
        </nav>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer>
        @yield('footer')
    </footer>
</body>
</html>