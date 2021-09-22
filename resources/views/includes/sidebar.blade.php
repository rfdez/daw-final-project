<div class="sidebar" data-color="blue">

    <div class="logo">
        <a href="{{ url('/') }}" class="simple-text logo-mini">
            <img src="{{ asset('assets/img/icons/logo250.svg') }}" alt="">
        </a>

        <a href="{{ url('/') }}" class="simple-text logo-normal">
            ATMOSPHERE
        </a>
        <div class="navbar-minimize">
            <button id="minimizeSidebar" class="btn btn-outline-white btn-icon btn-neutral btn-round">
                <i class="now-ui-icons text_align-center visible-on-sidebar-regular"></i>
                <i class="now-ui-icons design_bullet-list-67 visible-on-sidebar-mini"></i>
            </button>
        </div>
    </div>

    <div class="sidebar-wrapper" id="sidebar-wrapper">
        <div class="user">
            <div class="photo">
                @if (auth()->user()->avatar)
                <img src="{{ asset('storage/' . auth()->user()->avatar) }}" />
                @else
                <img src="{{ asset('assets/img/logo250.png') }}" />
                @endif
            </div>
            <div class="info">
                <a data-toggle="collapse" href="#perfil" class="collapsed">
                    <span>
                        {{ auth()->user()->name }}
                        <b class="caret"></b>
                    </span>
                </a>
                <div class="clearfix"></div>
                <div class="collapse" id="perfil">
                    <ul class="nav">
                        <li>
                            <a href="{{ route('profile') }}">
                                <span class="sidebar-mini-icon"><i class="now-ui-icons users_single-02"></i></span>
                                <span class="sidebar-normal">Mi Perfil</span>
                            </a>
                        </li>
                        <li>
                            <a href="">
                                <span class="sidebar-mini-icon"><i class="now-ui-icons loader_gear"></i></span>
                                <span class="sidebar-normal">Configuración</span>
                            </a>
                        </li>
                        <li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>

                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <span class="sidebar-mini-icon"><i class="now-ui-icons sport_user-run"></i></span>
                                <span class="sidebar-normal">Cerrar Sesión</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <ul class="nav">
            <li>
                <a href="{{ route('my.groups', ['user' => auth()->user()->id]) }}">
                    <i class="now-ui-icons location_bookmark"></i>
                    <p>Grupos</p>
                </a>
            </li>

            @role('admin')
            <li>
                <a href="{{ route('devices.index', ['user' => auth()->user()->id]) }}">
                    <i class="now-ui-icons tech_mobile"></i>
                    <p>Sensores</p>
                </a>
            </li>
            @endrole
        </ul>
    </div>
</div>