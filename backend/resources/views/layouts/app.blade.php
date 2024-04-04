<!DOCTYPE html>
<html lang="en" id="htmlTag" data-bs-theme="light" oncontextmenu="return false">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Alvin Castor">
    <meta name="project" content="E-Ticketing System">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="refresh" content="300">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" defer></script>
    <link href="{{asset('imgs/wmc_logo.png')}}" rel="icon">
</head>
<body class="bg-body-secondary">
    <header class="fixed-top mb-5 shadow">
        <nav class="navbar navbar-expand-lg bg-dark navbar-dark">
            <div class="container-fluid">
                <span class="navbar-text small p-0 m-0">Ticketing System</span>
                <button class="btn btn-sm p-0 m-0" id="darkmodeToggle" onclick="toggleTheme()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-hexagon-half" viewBox="0 0 16 16">
                    <path d="M14 4.577v6.846L8 15V1zM8.5.134a1 1 0 0 0-1 0l-6 3.577a1 1 0 0 0-.5.866v6.846a1 1 0 0 0 .5.866l6 3.577a1 1 0 0 0 1 0l6-3.577a1 1 0 0 0 .5-.866V4.577a1 1 0 0 0-.5-.866z"/>
                  </svg>
                </button>
            </div>
        </nav>
        <nav class="navbar navbar-expand-md bg-auto bg-body-tertiary" data-bs-theme="auto">
            <div class="container-fluid">
                <a class="navbar-brand h1" href="/">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-hospital" viewBox="0 0 16 16">
                        <path d="M8.5 5.034v1.1l.953-.55.5.867L9 7l.953.55-.5.866-.953-.55v1.1h-1v-1.1l-.953.55-.5-.866L7 7l-.953-.55.5-.866.953.55v-1.1zM13.25 9a.25.25 0 0 0-.25.25v.5c0 .138.112.25.25.25h.5a.25.25 0 0 0 .25-.25v-.5a.25.25 0 0 0-.25-.25zM13 11.25a.25.25 0 0 1 .25-.25h.5a.25.25 0 0 1 .25.25v.5a.25.25 0 0 1-.25.25h-.5a.25.25 0 0 1-.25-.25zm.25 1.75a.25.25 0 0 0-.25.25v.5c0 .138.112.25.25.25h.5a.25.25 0 0 0 .25-.25v-.5a.25.25 0 0 0-.25-.25zm-11-4a.25.25 0 0 0-.25.25v.5c0 .138.112.25.25.25h.5A.25.25 0 0 0 3 9.75v-.5A.25.25 0 0 0 2.75 9zm0 2a.25.25 0 0 0-.25.25v.5c0 .138.112.25.25.25h.5a.25.25 0 0 0 .25-.25v-.5a.25.25 0 0 0-.25-.25zM2 13.25a.25.25 0 0 1 .25-.25h.5a.25.25 0 0 1 .25.25v.5a.25.25 0 0 1-.25.25h-.5a.25.25 0 0 1-.25-.25z"/>
                        <path d="M5 1a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v1a1 1 0 0 1 1 1v4h3a1 1 0 0 1 1 1v7a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V8a1 1 0 0 1 1-1h3V3a1 1 0 0 1 1-1zm2 14h2v-3H7zm3 0h1V3H5v12h1v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1zm0-14H6v1h4zm2 7v7h3V8zm-8 7V8H1v7z"/>
                    </svg>
                    Westlake Medical Center
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse float-end" id="collapsibleNavbar">
                    {{-- @if(Auth::user()) --}}
                        @if(Auth::user() && Auth::user()->u_firstlogin == 2)
                            <ul class="navbar-nav ms-auto">
                                @if(Auth::user()->u_role == 1)
                                    <li href="/dashboard" class="nav-item">
                                        <a href="/dashboard" class="nav-link small icon-link icon-link-hover" style="--bs-icon-link-transform: translate3d(0, -0.25rem, 0);"><i class="bi bi-speedometer"></i> Dashboard</a>
                                    </li>
                                @endif
                                <li class="nav-item">
                                    @switch(Auth::user()->u_role)
                                        @case(1)
                                            <a class="nav-link icon-link icon-link-hover" style="--bs-icon-link-transform: translate3d(0, -0.25rem, 0);" href="/{{Auth::user()->u_department}}/tickets/alltickets/ticketid/desc"><i class="bi bi-ticket-detailed"></i> Tickets</a>
                                        @break
                                        @default
                                            <a class="nav-link icon-link icon-link-hover" style="--bs-icon-link-transform: translate3d(0, -0.25rem, 0);" href="/{{Auth::user()->u_department}}/tickets/mytickets/ticketid/desc"><i class="bi bi-ticket-detailed"></i> Tickets</a>
                                    @endswitch
                                </li>

                                @if(Auth::user()->u_role == 1)
                                    <li class="nav-item px-1">
                                        <a class="nav-link icon-link icon-link-hover" style="--bs-icon-link-transform: translate3d(0, -0.25rem, 0);" href="/report"><i class="bi bi-table"></i> Reports</a>
                                    </li>
                                @endif

                                {{-- <li class="nav-item">
                                    <a href="/locals" class="nav-link"><i class="bi bi-telephone"></i> Locals</a>
                                </li> --}}

                                {{-- <li class="nav-item">
                                    <a href="#" class="nav-link"><i class="bi bi-book"></i> Knowledge Base</a>
                                </li> --}}
                                
                                @if(Auth::user()->u_role == 1 && Auth::user()->u_department == 1)
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle icon-link icon-link-hover" style="--bs-icon-link-transform: translate3d(0, -0.25rem, 0);" href="#" role="button" data-bs-toggle="dropdown"><i class="bi bi-gear-fill"></i></a>
                                        <ul class="dropdown-menu">                                            
                                            <li class="nav-item px-1">
                                                <a class="nav-link" href="/categories"><i class="bi bi-tags"></i> Categories</a>
                                            </li>
                                            <li class="nav-item px-1">
                                                <a class="nav-link" href="/departments"><i class="bi bi-houses"></i> Departments</a>
                                            </li>
                                            <li class="nav-item px-1">
                                                <a class="nav-link" href="/severities"><i class="bi bi-exclamation-diamond"></i> Severities</a>
                                            </li>
                                            <li class="nav-item px-1">
                                                <a class="nav-link" href="/users"><i class="bi bi-people"></i> Users</a>
                                            </li>
                                            {{-- <li class="nav-item px-1">
                                                <a class="nav-link" href="#"><i class="bi bi-globe-central-south-asia"></i> Settings</a>
                                            </li>                                           --}}
                                        </ul>
                                    </li>
                                @endif

                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle icon-link icon-link-hover" style="--bs-icon-link-transform: translate3d(0, -0.25rem, 0);" href="#" role="button" data-bs-toggle="dropdown">{{Auth::user()->u_fname}} {{Auth::user()->u_lname}}</a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="/user/{{Auth::user()->id}}" class="dropdown-item">Account</a>
                                        </li>
                                        <li>
                                            <form action="/logout" method="post">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-secondary dropdown-item" onclick="disablebtn()">Logout</button>
                                            </form>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        @endif
                    {{-- @endif --}}
                </div>
            </div>
        </nav>
    </header>

    <main class="mt-3 px-0 pt-1">
        @yield('content')
    </main>

    <footer>
        @yield('footer')
    </footer>

    <script>
        function disablebtn(){
            const btn = document.querySelector('.btn');
            btn.addEventListener('click', () => {
                btn.setAttribute('disabled', true);
            });
        }

    </script>

    <script>
        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    </script>

    <script>
        window.onload = function() {
            var htmlTag = document.getElementById('htmlTag');
            var theme = localStorage.getItem('theme');
            var darkmode = document.getElementById('darkmodeToggle');

            if (theme) {
                htmlTag.setAttribute('data-bs-theme', theme);
                darkmode.style.color = "#fff";
            }
        }

        function toggleTheme() {
            var htmlTag = document.getElementById('htmlTag');
            var currentTheme = htmlTag.getAttribute('data-bs-theme');

            if (currentTheme === 'dark') {
                htmlTag.setAttribute('data-bs-theme', 'light');
                localStorage.setItem('theme', 'light');
            } else {
                htmlTag.setAttribute('data-bs-theme', 'dark');
                localStorage.setItem('theme', 'dark');
            }
        }
    </script>
</body>
</html>