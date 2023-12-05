<nav class="pcoded-navbar">
    <div class="sidebar_toggle"><a href="#"><i class="icon-close icons"></i></a></div>
    <div class="pcoded-inner-navbar main-menu">
        <div class="pcoded-navigation-label text-uppercase bg-primary">
            <a href="{{ route('boq.project.departments.sanitary.home', ['project' => $project]) }}" class='text-white'>BOQ
                - @yield('project-name', Session::get('project_name'))</a>
        </div>
        <ul class="pcoded-item pcoded-left-item">

            <!-- Configurations -->
            <li
                class="pcoded-hasmenu {{ request()->routeIs([
                    'boq.project.departments.sanitary.material-rates*',
                    'boq.project.departments.sanitary.labor-cost*',
                    'boq.project.departments.sanitary.sanitary-formulas*',
                ])
                    ? 'active pcoded-trigger'
                    : null }}">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="fas fa-cogs"></i><b></b></span>
                    <span class="pcoded-mtext">Configurations</span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    <li
                        class="{{ request()->routeIs('boq.project.departments.sanitary.material-rates.create') ? 'active pcoded-trigger' : null }}">
                        @can('boq-sanitary')
                        <a href="{{ route('boq.project.departments.sanitary.material-rates.create', ['project' => $project]) }}">
                            <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                            <span class="pcoded-mtext">New Material Rates </span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                        @endcan
                    </li>
                    <li
                        class="{{ request()->routeIs('boq.project.departments.sanitary.material-rates.index') ? 'active pcoded-trigger' : null }}">
                        <a
                            href="{{ route('boq.project.departments.sanitary.material-rates.index', ['project' => $project]) }}">
                            <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                            <span class="pcoded-mtext">Material Rates List </span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                </ul>
                <ul class="pcoded-submenu">
                    <li
                        class="{{ request()->routeIs('boq.project.departments.sanitary.labor-cost.create') ? 'active pcoded-trigger' : null }}">
                        @can('boq-sanitary')
                        <a
                            href="{{ route('boq.project.departments.sanitary.labor-cost.create', ['project' => $project]) }}">
                            <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                            <span class="pcoded-mtext">Create Labor Cost</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                        @endcan
                    </li>
                    <li
                        class="{{ request()->routeIs('boq.project.departments.sanitary.labor-cost.index') ? 'active pcoded-trigger' : null }}">
                        <a
                            href="{{ route('boq.project.departments.sanitary.labor-cost.index', ['project' => $project]) }}">
                            <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                            <span class="pcoded-mtext">Labor Cost List</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                </ul>
                <ul class="pcoded-submenu">
                    <li
                        class="{{ request()->routeIs('boq.project.departments.sanitary.sanitary-formulas.create') ? 'active pcoded-trigger' : null }}">
                        @can('boq-sanitary')
                        <a
                            href="{{ route('boq.project.departments.sanitary.sanitary-formulas.create', ['project' => $project]) }}">
                            <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                            <span class="pcoded-mtext">New Formula </span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                        @endcan
                    </li>
                    <li
                        class="{{ request()->routeIs('boq.project.departments.sanitary.sanitary-formulas.index') ? 'active pcoded-trigger' : null }}">
                        <a
                            href="{{ route('boq.project.departments.sanitary.sanitary-formulas.index', ['project' => $project]) }}">
                            <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                            <span class="pcoded-mtext">Formula List</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="{{ request()->routeIs('boq.project.departments.sanitary.home') ? 'active' : null }}">
                <a href="{{ route('boq.project.departments.sanitary.home', ['project' => $project]) }}">
                    <span class="pcoded-micon"><i class="fas fa-scroll"></i></span>
                    <span class="pcoded-mtext">Budget Summary</span>
                </a>
            </li>
            <li class="pcoded-hasmenu {{ request()->routeIs('boq.project.departments.sanitary.sanitary-budget-summaries.*') ? 'active pcoded-trigger' : null }}">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="fas fa-cogs"></i><b></b></span>
                    <span class="pcoded-mtext">Budget Entry </span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    <li class="{{ request()->routeIs('boq.project.departments.sanitary.sanitary-budget-summaries.*') ? 'active pcoded-trigger' : null }}">
                        <a
                            href="{{ route('boq.project.departments.sanitary.sanitary-budget-summaries.index', ['project' => $project]) }}">
                            <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                            <span class="pcoded-mtext">Budget Summary Entry</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="pcoded-hasmenu {{ request()->routeIs('boq.project.departments.sanitary.project-wise-materials*') ? 'active pcoded-trigger' : null }}">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="fas fa-cogs"></i><b></b></span>
                    <span class="pcoded-mtext">Budget Details </span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    <li class="{{ request()->routeIs('boq.project.departments.sanitary.project-wise-materials.create') ? 'active pcoded-trigger' : null }}">
                        @can('boq-sanitary')
                        <a
                            href="{{ route('boq.project.departments.sanitary.project-wise-materials.create', ['project' => $project]) }}">
                            <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                            <span class="pcoded-mtext"> Material Budget </span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                        @endcan
                    </li>
                    <li class="{{ request()->routeIs('boq.project.departments.sanitary.project-wise-materials.index') ? 'active pcoded-trigger' : null }}">
                        <a
                            href="{{ route('boq.project.departments.sanitary.project-wise-materials.index', ['project' => $project]) }}">
                            <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                            <span class="pcoded-mtext">Material Budget List</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('boq.project.departments.sanitary.project-wise-labor-cost.create') ? 'active pcoded-trigger' : null }}">
                        @can('boq-sanitary')
                        <a
                            href="{{ route('boq.project.departments.sanitary.project-wise-labor-cost.create', ['project' => $project]) }}">
                            <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                            <span class="pcoded-mtext"> Labor Budget</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                        @endcan
                    </li>
                    <li class="{{ request()->routeIs('boq.project.departments.sanitary.project-wise-labor-cost.index') ? 'active pcoded-trigger' : null }}">
                        <a
                            href="{{ route('boq.project.departments.sanitary.project-wise-labor-cost.index', ['project' => $project]) }}">
                            <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                            <span class="pcoded-mtext">Labor Budget List</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                </ul>
            </li>


            <li
                class="pcoded-hasmenu {{ request()->routeIs('boq.project.departments.sanitary.sanitary-allocations*') ? 'active pcoded-trigger' : null }}">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="fas fa-cogs"></i><b></b></span>
                    <span class="pcoded-mtext">Material Allocation Plan</span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    <li
                        class="{{ request()->routeIs('boq.project.departments.sanitary.sanitary-allocations.create') ? 'active pcoded-trigger' : null }}">
                        @can('boq-sanitary')
                        <a
                            href="{{ route('boq.project.departments.sanitary.sanitary-allocations-create', ['project' => $project, 'type' => 'Residential']) }}">
                            <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                            <span class="pcoded-mtext">Residential Allocation </span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                        @endcan
                    </li>
                    <li
                        class="{{ request()->routeIs('boq.project.departments.sanitary.sanitary-allocations.create') ? 'active pcoded-trigger' : null }}">
                        @can('boq-sanitary')
                        <a
                            href="{{ route('boq.project.departments.sanitary.sanitary-allocations-create', ['project' => $project, 'type' => 'Commercial']) }}">
                            <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                            <span class="pcoded-mtext">Commercial Allocation </span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                        @endcan
                    </li>
                    <li
                        class="{{ request()->routeIs('boq.project.departments.sanitary.sanitary-allocations.index') ? 'active pcoded-trigger' : null }}">
                        <a
                            href="{{ route('boq.project.departments.sanitary.sanitary-allocations.index', ['project' => $project]) }}">
                            <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                            <span class="pcoded-mtext">Allocation List</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                </ul>
            </li>
            <hr>
            <li>
                <a href="{{ route('boq.project.index', ['project' => $project]) }}">
                    <i class="fa fa-arrow-left"></i>
                    Back To Project
                </a>
            </li>
        </ul>
        <div class="p-5"></div>
    </div>
</nav>
