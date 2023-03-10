<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="{{ url('/dashboard') }}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ url('/storage/icon.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ url('/storage/banner.png') }}" alt="" height="40">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="{{ url('/dashboard') }}" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ url('/storage/icon.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ url('/storage/banner.png') }}" alt="" height="40">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
            id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        @php
            $module = session()->get('module');
            $current_tab_id = '';
        @endphp

        <div class="container-fluid mt-3">
            <div id="two-column-menu"></div>

            <ul class="navbar-nav" id="navbar-nav">
                @foreach ($module as $res_module)
                    @php
                        $moduleku = explode(';', $res_module);
                    @endphp

                    @if ($current_tab_id != $moduleku[3])
                        <li class="nav-item">
                            <a class="nav-link menu-link {{ $moduleku[3] == $tab_id ? 'active' : '' }}"
                                href="#sidebar{{ $moduleku[4] }}" data-bs-toggle="collapse" role="button"
                                aria-expanded="false" aria-controls="sidebar{{ $moduleku[4] }}"><i
                                    class="{{ $moduleku[5] }}"></i> <span
                                    data-key="t-{{ $moduleku[4] }}">{{ $moduleku[4] }}</span>
                            </a>
                    @endif

                    @if ($current_tab_id != $moduleku[3])
                        </li>

                        @php
                            $current_tab_id = $moduleku[3];
                        @endphp
                    @endif

                    <div class="collapse menu-dropdown {{ $moduleku[3] == $tab_id ? 'show' : '' }}"
                        id="sidebar{{ $moduleku[4] }}">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ url($moduleku[2]) }}"
                                    class="nav-link {{ $moduleku[0] == $menu_id ? 'active' : '' }}"
                                    data-key="t-{{ $moduleku[1] }}">{{ $moduleku[1] }}</a>
                            </li>
                        </ul>
                    </div>
                @endforeach
            </ul>
        </div>
    </div>

    <div class="sidebar-background"></div>
</div>
