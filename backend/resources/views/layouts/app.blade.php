<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body>
    <header class="fixed-top mb-5 shadow">
        <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
            <div class="container-fluid">
                <span class="navbar-text small p-0 m-0">Ticketing System</span>
            </div>
        </nav>
        <nav class="navbar navbar-expand-sm bg-light navbar-light">
            <div class="container-fluid">
                <a class="navbar-brand h1" href="#">WMC</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse float-end" id="collapsibleNavbar">
                    {{-- @if(Auth::user()) --}}
                        @if(Auth::user())
                            <ul class="navbar-nav ms-auto">
                                <li class="nav-item">
                                    <a class="nav-link" href="/tickets">Tickets</a>
                                </li>
                                @if(Auth::user()->u_role == 1)
                                    <li class="nav-item">
                                        <a class="nav-link" href="/categories">Categories</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="/departments">Departments</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="/severities">Severities</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="/users">Users</a>
                                    </li>
                                @endif
                                <li class="nav-item">
                                    <form action="/logout" method="post">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-secondary">{{Auth::user()->u_fname}}</button>
                                    </form>
                                </li>
                            </ul>
                        @endif
                    {{-- @endif --}}
                </div>
            </div>
        </nav>
    </header>

    <main class="mt-3 pt-1">
        @yield('content')
    </main>

    <footer>
        @yield('footer')
    </footer>
</body>
</html>