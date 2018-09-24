<nav class="navbar navbar-default navbar-static-top" id="nav-main">
    <div class="">
        <div class="navbar-header">
            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            @if(auth()->user()->profile->tutorial_completed)
                <div class="visible-xs-inline" id="alerts-xs">
                    @include('nav.alerts')
                </div>
            @endif
            <!-- Branding Image -->
            <a class="navbar-brand" href="{{ url('/') }}" style="font-size: 24px;">
                <img src="/img/logo_mi_white.png" height="25px" style="    display: inline;
    margin-right: 10px;
    vertical-align: bottom;"><span style=" display: inline-block;">{{ config('app.name', 'Gabinete') }}</span>
            </a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav">
                <scope-menu v-if="$store.getters['Scope/ready']"></scope-menu>
            </ul>
            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                @guest
                    <li><a href="{{ route('login') }}">Login</a></li>
                    {{-- <li><a href="{{ route('register') }}">Register</a></li> --}}
                @else
                    <div class="visible-xs-block" id="left-nav-xs">
                        <!-- <main-menu :menu="{{auth()->user()->getMenu('gabinete', auth()->user()->group()->pluck('name')->toArray(),auth()->user()->role )}}" :user="$store.state.user"></main-menu> -->
                        <main-menu :menu="{{auth()->user()->getMenu('gabinete', [session('user.group.0.name')], session('user.role') )}}" :user="$store.state.user"></main-menu>
                    </div>
                    <shopping-cart-nav-container>
                        <shopping-cart></shopping-cart>
                    </shopping-cart-nav-container>
                    <li class="dropdown" id="profile-dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                           <span class="glyphicon glyphicon-user"></span> {{ session('user_profile.name') }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a href="/profile"><span class="glyphicon glyphicon-list-alt"></span> Mi Perfil</a>
                            </li>
                            <li>
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                   <span class="glyphicon glyphicon-log-out"></span> Logout
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>