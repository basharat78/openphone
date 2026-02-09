<nav class="navbar navbar-expand-lg navbar-dark shadow-sm"
     style="background: linear-gradient(135deg,#667eea,#764ba2);">

    <div class="container-fluid">

        <!-- Brand -->
        <a class="navbar-brand fw-bold" href="#">
            QC Panel
        </a>

        <!-- Mobile Toggle -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarContent">

            <ul class="navbar-nav me-auto"></ul>

            <!-- Right Side -->
            <ul class="navbar-nav">

                {{-- Guest --}}
                @guest

                    <li class="nav-item me-2">
                        <a href="{{ route('login') }}"
                           class="btn btn-light btn-sm rounded-pill px-3">
                            Login
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('register') }}"
                           class="btn btn-warning btn-sm rounded-pill px-3 text-dark fw-semibold">
                            Sign Up
                        </a>
                    </li>

                @endguest


                {{-- Authenticated User --}}
                @auth

                    <li class="nav-item dropdown">

                        <a class="nav-link dropdown-toggle d-flex align-items-center"
                           href="#"
                           role="button"
                           data-bs-toggle="dropdown">

                            <span class="me-2">
                                {{ auth()->user()->name }}
                            </span>

                            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}"
                                 class="rounded-circle"
                                 width="35">
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end shadow">

                            <li>
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                    
                            {{ __('Profile') }}
                      
                                </a> 
                            </li>

                            <li>
                                <hr class="dropdown-divider">
                            </li>

                            <li>
                                <a class="dropdown-item text-danger"
                                   href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                   document.getElementById('logout-form').submit();">
                                    Logout
                                </a>
                            </li>

                        </ul>

                        <form id="logout-form"
                              action="{{ route('logout') }}"
                              method="POST"
                              class="d-none">
                            @csrf
                        </form>

                    </li>

                @endauth

            </ul>

        </div>
    </div>
</nav>
