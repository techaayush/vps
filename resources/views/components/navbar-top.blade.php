<nav class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">

            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse"
                aria-expanded="false">
                <span class="sr-only">@lang('Toggle Navigation')</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        
        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            @auth
                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle nav-link-align-btn" data-toggle="dropdown" role="button"
                            aria-expanded="false" aria-haspopup="true">
                            <span class="label label-danger">
                                {{ !empty(\Auth::user()->role) }}
                            </span>&nbsp;&nbsp;
                            @if(!empty(Auth::user()->pic_path))
                            <img src="{{asset('01-progress.gif')}}" data-src="{{url(Auth::user()->pic_path)}}" alt="Profile Picture"
                                style="vertical-align: middle;border-style: none;border-radius: 50%;width: 30px;height: 30px;">
                            @else
                            <img src="{{asset('01-progress.gif')}}" data-src="https://png.icons8.com/dusk/200/000000/user-female.png"
                                alt="Profile Picture" style="vertical-align: middle;border-style: none;border-radius: 50%;width: 30px;height: 30px;">
                            @endif
                            &nbsp;&nbsp;<span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu">
                            <li>
                                <a href="">@lang('Profile')</a>
                            </li>
                            <li>
                                <a href="">@lang('Change Password')</a>
                            </li>
                            <li>
                                <a href="{{ route('logout') }}">
                                    @lang('Logout')
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            @endauth
        </div>
    </div>
</nav>