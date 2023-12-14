<style>
    .back_button{
        background: #227447;
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
            @foreach ($sidebar_boq_areas as $type_name => $sidebar_boq_area)
                <li class="pcoded-hasmenu {{ request()->route()->parameter('boq_area')?->boqCommonFloor->type_name == $type_name
                    ? 'active pcoded-trigger'
                    : null }}">
                    <a href="javascript:void(0)">
                        <span class="pcoded-micon"><i class="ti-settings"></i><b></b></span>
                        <span class="pcoded-mtext">{{ Str::ucfirst($type_name) ?? 'Floor type' }}</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">
                        @foreach ($sidebar_boq_area as $sidebar_area)
                            <li class="{{ request()->route()?->parameter('boq_area')?->area_uid == $sidebar_area?->area_uid ? 'active pcoded-trigger' : null }}">
                                @php
                                    $route = isset($reinforcement) ? 'boq.project.reinforcement.calculations.create' : 'boq.project.departments.civil.materials.calculations.create';
                                @endphp

                                <a href="{{ route($route, ['project' => $project, 'boq_area' => $sidebar_area]) }}">
                                    <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                                    <span class="pcoded-mtext"> {{ $sidebar_area->boqCommonFloor->name }} </span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            @endforeach
            <li>
                <button class="back_button" onclick="history.back()">
                    <i class="fa fa-arrow-left"></i>
                    Back
                </button>
            </li>
                <hr>
                <li>
                    <a href="{{ route('boq.project.index', ['project' => $project]) }}">
                        <i class="fa fa-arrow-left"></i>
                        Back To Project
                    </a>
                </li>
        </ul>
    </div>
</nav>
{{-- <a href="{{ route('boq.project.reinforcement.calculations.create', ['project' => $project, 'boq_area' => $sidebar_boq_area]) }}">
    {{ $sidebar_boq_area->name }}
</a> --}}
