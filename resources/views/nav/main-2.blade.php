<nav id="top-nav-bar">
    <div class="fx jf-between">
        <div class="fx-center">
            <!-- Branding Image -->
            <a href="{{ url('/') }}" style="font-size: 24px;" class="fx fx-center">
                <img src="/img/logo_mi_white.png" height="25px">
                <div class="brand-name">{{ config('app.name', 'Gabinete') }}</div>
            </a>
            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>

        <div class="fx-center text-center">
            <scope-menu v-if="$store.getters['Scope/ready']"></scope-menu>
        </div>
        <div class="fx fx-center text-center mr-10">
            <!-- Right Side Of Navbar -->
            <div class="visible-xs-block" id="left-nav-xs">
                <main-menu :menu="{{auth()->user()->getMenu('gabinete', [session('user.group.0.name')], session('user.role') )}}" :user="$store.state.user"></main-menu>
            </div>
            <shopping-cart-nav-container>
                <shopping-cart></shopping-cart>
            </shopping-cart-nav-container>
            <div class="fx-center dropdown" id="profile-dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                    <span class="glyphicon glyphicon-user"></span> {{ session('user_profile.name') }} <span class="caret"></span>
                </a>

                <ul class="dropdown-menu top-nav-profile" role="menu">
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
            </div>
        </div>
    </div>
</nav>