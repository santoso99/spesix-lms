<div class="navbar-right">
    <ul class="navbar-nav">
        <li class="dropdown">
            <a href="javascript:void(0);" class="dropdown-toggle text-uppercase" title="Language" data-toggle="dropdown" role="button"><i class="zmdi zmdi-translate"></i><br>{{ LaravelLocalization::getCurrentLocale() }}</a>
            <ul class="dropdown-menu slideUp2">
                <li class="header">{{ __('label.switch_language') }}</li>
                <li class="body">
                    <ul class="menu app_sortcut list-unstyled">
                        @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                            <li>
                                <a rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                    <div class="icon-circle mb-2"><img class="mr-2" src="{{asset('img/'.$localeCode.'.png')}}" width="30px"></div>
                                    <p class="mb-0">{{ $properties['native'] }}</p>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            </ul>
        </li>
        <li class="dropdown">
            <a href="javascript:void(0);" class="dropdown-toggle text-uppercase" title="Logout" data-toggle="dropdown" role="button"><i class="zmdi zmdi-power"></i></a>
            <ul class="dropdown-menu slideUp2">
                <form action="{{\LaravelLocalization::localizeURL('/logout')}}" method="post" class="mega-menu">
                    @csrf
                    <button type="submit" class="btn bg-transparent text-dark w-100"><i class="zmdi zmdi-power"></i> {{ __('menu-label.logout') }}</button>
                </form>
            </ul>
        </li>
    </ul>
</div>