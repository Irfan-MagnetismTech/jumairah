<style>
    .back_button{
        background: #116A7B;
        border: 1px solid transparent;
        color: white;
        width: 100%;
        cursor: pointer;
    }

    .back_button:focus{
        outline: transparent;
    }

</style>

<nav class="pcoded-navbar">
    <div class="sidebar_toggle"><a href="#"><i class="icon-close icons"></i></a></div>
    <div class="pcoded-inner-navbar main-menu">
        <div class="pcoded-navigation-label text-uppercase bg-primary">@yield('project-name', 'Project')</div>
        <ul class="pcoded-item pcoded-left-item">
            <!-- Configuration -->
            <li class="pcoded-hasmenu {{ request()->routeIs('boq.project.configurations.areas.*') ? 'active pcoded-trigger' : null }}">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="fas fa-cogs"></i><b></b></span>
                    <span class="pcoded-mtext">Configurations</span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    <li class="{{ request()->routeIs('boq.project.configurations.areas.*') ? 'active' : null }}">
                        <a href="{{ route('boq.project.configurations.areas.index', ['project' => $project]) }}">
                            <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                            <span class="pcoded-mtext"> Floor with area </span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Departments -->
            <li class="pcoded-hasmenu {{ request()->routeIs('boq.project.departments.civil.*') ? 'active pcoded-trigger' : null }}">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="far fa-building"></i><b></b></span>
                    <span class="pcoded-mtext">Parts</span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    <li class="{{ request()->routeIs('boq.project.departments.civil.*') ? 'active' : null }}">
                        <a href="{{ route('boq.project.departments.civil.home',['project' => $project]) }}">
                            <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                            <span class="pcoded-mtext"> Civil </span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('boq.project.departments.electrical.*') ? 'active' : null }}">
                        <a href="{{ route('boq.project.departments.electrical.home',['project' => $project]) }}">
                            <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                            <span class="pcoded-mtext"> EME </span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('boq.project.departments.sanitary.*') ? 'active' : null }}">
                        <a href="{{ route('boq.project.departments.sanitary.home',['project' => $project]) }}">
                            <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                            <span class="pcoded-mtext"> Sanitary </span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                </ul>
            </li>
            <hr>
            <li>
                <button class="back_button" onclick="history.back()">
                    <i class="fa fa-arrow-left"></i>
                    Back
                </button>
            </li>
        </ul>
{{--        <ul class="pcoded-item pcoded-left-item">--}}
{{--            <!-- Configuration -->--}}
{{--            <li class="pcoded-hasmenu {{ request()->routeIs('boq.project.areas.*') ? 'active pcoded-trigger' : null }}">--}}
{{--                <a href="javascript:void(0)">--}}
{{--                    <span class="pcoded-micon"><i class="ti-settings"></i><b></b></span>--}}
{{--                    <span class="pcoded-mtext">Configurations</span>--}}
{{--                    <span class="pcoded-mcaret"></span>--}}
{{--                </a>--}}
{{--                <ul class="pcoded-submenu">--}}
{{--                    <li class="{{ request()->routeIs('boq.project.areas.*') ? 'active' : null }}">--}}
{{--                        <a href="{{ route('boq.project.areas.index', ['project' => $project]) }}">--}}
{{--                            <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>--}}
{{--                            <span class="pcoded-mtext"> Floor with area </span>--}}
{{--                            <span class="pcoded-mcaret"></span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                </ul>--}}
{{--            </li>--}}

{{--            <!-- Departments -->--}}
{{--            <li class="pcoded-hasmenu">--}}
{{--                <a href="javascript:void(0)">--}}
{{--                    <span class="pcoded-micon"><i class="ti-settings"></i><b></b></span>--}}
{{--                    <span class="pcoded-mtext">Departments</span>--}}
{{--                    <span class="pcoded-mcaret"></span>--}}
{{--                </a>--}}
{{--                <ul class="pcoded-submenu">--}}
{{--                    <li class="">--}}
{{--                        <a href="{{ route('boq.project.departments.civil.home', ['project' => $project]) }}">--}}
{{--                            <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>--}}
{{--                            <span class="pcoded-mtext"> Civil </span>--}}
{{--                            <span class="pcoded-mcaret"></span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                    <li class="">--}}
{{--                        <a href="#">--}}
{{--                            <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>--}}
{{--                            <span class="pcoded-mtext"> Electrical </span>--}}
{{--                            <span class="pcoded-mcaret"></span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                    <li class="">--}}
{{--                        <a href="#">--}}
{{--                            <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>--}}
{{--                            <span class="pcoded-mtext"> Sanitary </span>--}}
{{--                            <span class="pcoded-mcaret"></span>--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                    --}}{{-- <li class="">--}}
{{--                        <a href="{{ route('boq.project.reinforcement.calculations.index', ['project' => $project]) }}">--}}
{{--                            <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>--}}
{{--                            <span class="pcoded-mtext"> Re-inforcement </span>--}}
{{--                            <span class="pcoded-mcaret"></span>--}}
{{--                        </a>--}}
{{--                    </li> --}}
{{--                </ul>--}}
{{--            </li>--}}
{{--        </ul>--}}
        <div class="p-5"></div>
    </div>
</nav>
