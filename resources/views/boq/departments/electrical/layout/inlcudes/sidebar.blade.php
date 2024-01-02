
<nav class="pcoded-navbar">
    <div class="sidebar_toggle"><a href="#"><i class="icon-close icons"></i></a></div>
    <div class="pcoded-inner-navbar main-menu">
        <div class="pcoded-navigation-label text-uppercase bg-primary"><a href="{{ route('boq.project.departments.electrical.home',['project' => $project]) }}" class='text-white'>BOQ - @yield("project-name", $project->name)</a></div>

        <ul class="pcoded-item pcoded-left-item">

            {{--            <!-- Configurations -->--}}
            @can('boq-eme-configuration-view')
            <li class="pcoded-hasmenu {{ request()->routeIs('boq.project.departments.electrical.configurations.*') ? 'active pcoded-trigger' : null }}">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="fas fa-cogs"></i><b></b></span>
                    <span class="pcoded-mtext">Configurations</span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    <li class="{{ request()->routeIs('boq.project.departments.electrical.configurations.eme-budget-head.*') ? 'active pcoded-trigger' : null }}">
                        <a href="{{ route('boq.project.departments.electrical.configurations.eme-budget-head.create', ['project' => $project ]) }}">
                            <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                            <span class="pcoded-mtext"> Budget Head </span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                </ul>
                <ul class="pcoded-submenu">

                    <li class="{{ request()->routeIs('boq.project.departments.electrical.configurations.rates.*') ? 'active pcoded-trigger' : null }}">
                        <a href="{{ route('boq.project.departments.electrical.configurations.rates.create', ['project' => $project ]) }}">
                            <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                            <span class="pcoded-mtext"> Rates </span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                </ul>

                {{-- <ul class="pcoded-submenu">

                    <li class="{{ request()->routeIs('boq.project.departments.electrical.configurations.cs_supplier_eval_option.*') ? 'active pcoded-trigger' : null }}">
                        <a href="{{ route('boq.project.departments.electrical.configurations.cs_supplier_eval_option.create', ['project' => $project ]) }}">
                            <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                            <span class="pcoded-mtext">CS Supplier Eval Option </span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                </ul> --}}
            </li>
            @endcan
            @can('boq-eme-budget-view')
            <li class="pcoded-hasmenu {{ request()->routeIs('boq.project.departments.electrical.budgets.*') ? 'active pcoded-trigger' : null }}">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="fas fa-scroll"></i><b></b></span>
                    <span class="pcoded-mtext">Budgets</span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">

                    {{-- <li class="{{ request()->routeIs('boq.project.departments.electrical.budgets.create') ? 'active pcoded-trigger' : null }}">
                        <a href="{{ route('boq.project.departments.electrical.budgets.create', ['project' => $project ]) }}">
                            <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                            <span class="pcoded-mtext"> New Budget </span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li> --}}
                    <li class="{{ request()->routeIs('boq.project.departments.electrical.budgets.index') ? 'active pcoded-trigger' : null }}">
                        <a href="{{ route('boq.project.departments.electrical.budgets.index', ['project' => $project ]) }}">
                            <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                            <span class="pcoded-mtext"> Budget List</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                </ul>
            </li>
            @endcan
            @can('boq-eme-budget-details-view')
{{--            <!-- Calculation -->--}}
            <li class="pcoded-hasmenu {{ request()->routeIs('boq.project.departments.electrical.calculations.*') ? 'active pcoded-trigger' : null }}">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="fas fa-calculator"></i><b></b></span>
                    <span class="pcoded-mtext">Budget Details</span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    <li class="{{ request()->routeIs('boq.project.departments.electrical.calculations.*')  ? 'active pcoded-trigger' : null }}">
                        <a href="{{ route('boq.project.departments.electrical.calculations.index', ['project' => $project ]) }}">
                            <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                            <span class="pcoded-mtext"> Item Calculation </span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                </ul>
            </li>
            @endcan
            {{-- @can('boq-eme-load-calculation')
            <li class="pcoded-hasmenu {{ request()->routeIs('boq.project.departments.electrical.load_calculations.*') ? 'active pcoded-trigger' : null }}">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="fas fa-calculator"></i><b></b></span>
                    <span class="pcoded-mtext">Load Calculations</span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    <li class="{{ request()->routeIs('boq.project.departments.electrical.load_calculations.create')  ? 'active pcoded-trigger' : null }}">
                        <a href="{{ route('boq.project.departments.electrical.load_calculations.create', ['project' => $project ]) }}">
                            <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                            <span class="pcoded-mtext">Create</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('boq.project.departments.electrical.load_calculations.index')  ? 'active pcoded-trigger' : null }}">
                        <a href="{{ route('boq.project.departments.electrical.load_calculations.index', ['project' => $project ]) }}">
                            <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                            <span class="pcoded-mtext">index</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                </ul>
            </li>
            @endcan --}}
            {{-- @can('boq-eme-utility-bill-view')
            <li class="pcoded-hasmenu {{ request()->routeIs('boq.project.departments.electrical.utility_bill.*') ? 'active pcoded-trigger' : null }}">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="fas fa-calculator"></i><b></b></span>
                    <span class="pcoded-mtext">Utility Bill</span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    <li class="{{ request()->routeIs('boq.project.departments.electrical.utility_bill.create')  ? 'active pcoded-trigger' : null }}">
                        <a href="{{ route('boq.project.departments.electrical.utility_bill.create', ['project' => $project ]) }}">
                            <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                            <span class="pcoded-mtext">Create</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('boq.project.departments.electrical.utility_bill.index')  ? 'active pcoded-trigger' : null }}">
                        <a href="{{ route('boq.project.departments.electrical.utility_bill.index', ['project' => $project ]) }}">
                            <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                            <span class="pcoded-mtext">index</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                </ul>
            </li>
            @endcan --}}
            <!-- @can('boq-eme-labor-rate-view')
            <li class="pcoded-hasmenu {{ request()->routeIs('boq.project.departments.electrical.labor_rate.*') ? 'active pcoded-trigger' : null }}">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="fas fa-calculator"></i><b></b></span>
                    <span class="pcoded-mtext">Labor Rate</span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    <li class="{{ request()->routeIs('boq.project.departments.electrical.labor_rate.create')  ? 'active pcoded-trigger' : null }}">
                        <a href="{{ route('boq.project.departments.electrical.labor_rate.create', ['project' => $project ]) }}">
                            <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                            <span class="pcoded-mtext">Create</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('boq.project.departments.electrical.labor_rate.index')  ? 'active pcoded-trigger' : null }}">
                        <a href="{{ route('boq.project.departments.electrical.labor_rate.index', ['project' => $project ]) }}">
                            <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                            <span class="pcoded-mtext">index</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                </ul>
            </li>
            @endcan -->
            {{-- @can('boq-eme-work-cs-view')
            <li class="pcoded-hasmenu {{ request()->routeIs('boq.project.departments.electrical.work_cs.*') ? 'active pcoded-trigger' : null }}">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="fas fa-calculator"></i><b></b></span>
                    <span class="pcoded-mtext">Work C.S.</span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    <li class="{{ request()->routeIs('boq.project.departments.electrical.work_cs.create')  ? 'active pcoded-trigger' : null }}">
                        <a href="{{ route('boq.project.departments.electrical.work_cs.create', ['project' => $project ]) }}">
                            <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                            <span class="pcoded-mtext">Create</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('boq.project.departments.electrical.work_cs.index')  ? 'active pcoded-trigger' : null }}">
                        <a href="{{ route('boq.project.departments.electrical.work_cs.index', ['project' => $project ]) }}">
                            <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                            <span class="pcoded-mtext">index</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                </ul>
            </li>
            @endcan
            @can('boq-eme-work-order-view')
            <li class="pcoded-hasmenu {{ request()->routeIs('boq.project.departments.electrical.work_order.*') ? 'active pcoded-trigger' : null }}">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="fas fa-calculator"></i><b></b></span>
                    <span class="pcoded-mtext">Work Order</span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    <li class="{{ request()->routeIs('boq.project.departments.electrical.work_order.create')  ? 'active pcoded-trigger' : null }}">
                        <a href="{{ route('boq.project.departments.electrical.work_order.create', ['project' => $project ]) }}">
                            <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                            <span class="pcoded-mtext">Create</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('boq.project.departments.electrical.work_order.index')  ? 'active pcoded-trigger' : null }}">
                        <a href="{{ route('boq.project.departments.electrical.work_order.index', ['project' => $project ]) }}">
                            <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                            <span class="pcoded-mtext">index</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                </ul>
            </li>
            @endcan --}}
             {{-- <li class="pcoded-hasmenu {{ request()->routeIs('boq.project.departments.civil.costs.*') ? 'active pcoded-trigger' : null }}">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="fas fa-dollar-sign"></i><b></b></span>
                    <span class="pcoded-mtext">Costs sefsf</span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    <li class="{{ request()->routeIs('boq.project.departments.civil.costs.consumables.*') ? 'active pcoded-trigger' : null }}">
                        <a href="{{ route('boq.project.departments.civil.costs.consumables.index',['project' => $project ]) }}">
                            <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                            <span class="pcoded-mtext"> Consumable Cost</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                </ul>
            </li> --}}

            <!-- Cost Analysis -->
             {{-- <li class="pcoded-hasmenu">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="fas fa-chart-bar"></i><b></b></span>
                    <span class="pcoded-mtext">Cost Analysis</span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    <li class="">
                        <a href="">
                            <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                            <span class="pcoded-mtext"> Material Statement Floorwise </span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="">
                        <a href="">
                            <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                            <span class="pcoded-mtext"> Material Cost Floorwise </span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="">
                        <a href="">
                            <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                            <span class="pcoded-mtext"> Labour Cost Floorwise </span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="">
                        <a href="">
                            <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                            <span class="pcoded-mtext"> Material & Labour Cost Floorwise </span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <!-- Percentage Sheet -->
                    <li class="pcoded-hasmenu ">
                        <a href="javascript:void(0)">
                            <span class="pcoded-micon"><i class="ti-settings"></i><b></b></span>
                            <span class="pcoded-mtext">Percentage Sheet</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                        <ul class="pcoded-submenu">
                            <li class="">
                                <a href="">
                                    <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                                    <span class="pcoded-mtext"> Workwise </span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
                            <li class="">
                                <a href="">
                                    <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                                    <span class="pcoded-mtext"> Floorwise </span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li> --}}
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
