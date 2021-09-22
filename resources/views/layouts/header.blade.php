<header>
    <nav class="navbar navbar-expand-lg navbar-dark gc-header">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample08"
                aria-controls="navbarsExample08" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="container collapse navbar-collapse justify-content-md-center" id="navbarsExample08">
            <ul class="navbar-nav w-100 d-flex justify-content-center">
                <li class="nav-item px-2">
                    <a class="nav-link" href="https://goldencage.io/">{{ __('Home') }}</a>
                </li>
                <li class="nav-item px-2">
                    <a class="nav-link" href="{{ route('holders') }}">{{ __('Top holders') }}</a>
                </li>
                <a href="https://goldencage.io/" class="px-2 d-none d-lg-block">
                    <img class="gc-logo" src="img/logo.png">
                </a>
                <li class="nav-item px-2">
                    <a class="nav-link" href="{{ route('staking') }}">{{ __('Staking') }}</a>
                </li>
                <li class="nav-item px-2">
                    <a class="nav-link" href="{{ route('collection') }}">{{ __('Collection') }}</a>
                </li>
            </ul>
        </div>

        <div class="pr-4 h4 text-white mb-0">
            <a class="{{ (App::getLocale() == 'en') ? 'btn-link text-white' : '' }}" href="{{ route('lang.switch', 'ru') }}">RU</a>
            |
            <a class="{{ (App::getLocale() == 'ru') ? 'btn-link text-white' : '' }}" href="{{ route('lang.switch', 'en') }}">EN</a>
        </div>
        @if(Auth::check())
            <div class="btn-group dropleft">
                <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenuButton"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{ Auth::user()->wallet }}
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        @if((Auth::user()->usertype ?? '') == 'admin')
                            <a class="dropdown-item" href="/dashboard">{{ __('Dashboard') }}</a>
                        @endif
                        <a class="dropdown-item"
                           onclick="event.preventDefault();this.closest('form').submit();">{{ __('Log out') }}
                        </a>
                    </form>
                </div>
            </div>
        @else
            <button type="button" id="loginBtn" class="btn btn-light" data-toggle="modal" data-target="#loginModal">
                Login
            </button>
        @endif
        <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header border-bottom-0 pb-0">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        <h1 class="h1 font-weight-bold">{{ __('Choose Wallet') }}</h1>
                        <p>{{ __('A wallet lets you connect your blockchain account to GoldenCage') }}</p>
                        <div class="row">
                            <div class="col-12">
                                <button class="btn w-100 btn-wax mb-0" onclick="login()">{{ __('WAX Cloud Wallet') }}</button>
                            </div>
                            <div class="col-12">
                                <p>{{ __('Recommended for new users') }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button class="btn w-100 btn-anchor" onclick="anchorLogin()">{{ __('Anchor') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>
