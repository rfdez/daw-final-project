<footer class="footer">
    <div class="container-fluid">
        <nav>
            <ul>
                <li>
                    <a href="{{ url('/') }}">
                        welcome
                    </a>
                </li>
                @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
                @if (Route::has('register'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                </li>
                @endif
                @else
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}">{{ __('Dashboard') }}</a>
                </li>
                @endguest
            </ul>
        </nav>
        <div class="copyright">
            &copy; {{ date('Y') }} atmos.com
        </div>
    </div>
</footer>