<style>
    .back_button{
        background: #116A7B;
        border: 1px solid transparent;
        color: white;
        width: 100%;
        cursor: pointer;
        text-align: center;
        outline: transparent;
    }
    .back_button:focus{
        outline: transparent;
    }
</style>

<nav class="pcoded-navbar">
    <div class="sidebar_toggle"><a href="#"><i class="icon-close icons"></i></a></div>
    <div class="pcoded-inner-navbar main-menu">
        <div class="pcoded-navigation-label text-uppercase bg-primary">BOQ - @yield('project-name', 'Project')</div>
        <ul class="pcoded-item pcoded-left-item">
            <!-- Configurations -->
            <li
                class="pcoded-hasmenu {{ request()->routeIs(['boq.project.departments.civil.configurations.*', 'boq.project.global-material-specifications.*']) ? 'active pcoded-trigger' : null }}">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="ti-settings"></i><b></b></span>
                    <span class="pcoded-mtext">Setup</span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    <li
                        class="{{ request()->routeIs('boq.project.departments.civil.configurations.works.*') ? 'active pcoded-trigger' : null }}">
                        <a
                            href="{{ route('boq.project.departments.civil.configurations.works.index', ['project' => $project]) }}">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext"> Works </span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li
                        class="{{ request()->routeIs('boq.project.departments.civil.configurations.material-formulas.*') ? 'active pcoded-trigger' : null }}">
                        <a
                            href="{{ route('boq.project.departments.civil.configurations.material-formulas.index', ['project' => $project]) }}">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext"> Material Formulas </span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li
                        class="{{ request()->routeIs('boq.project.departments.civil.configurations.material-price-wastage.*') ? 'active pcoded-trigger' : null }}">
                        <a
                            href="{{ route('boq.project.departments.civil.configurations.material-price-wastage.index', ['project' => $project]) }}">
                            <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                            <span class="pcoded-mtext"> Global Material Rate</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li
                        class="{{ request()->routeIs('boq.project.departments.civil.configurations.reinforcement-measurement.*') ? 'active pcoded-trigger' : null }}">
                        <a
                            href="{{ route('boq.project.departments.civil.configurations.reinforcement-measurement.index', ['project' => $project]) }}">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext"> Reinforcement Measurement </span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li
                        class="{{ request()->routeIs('boq.project.global-material-specifications.*') ? 'active pcoded-trigger' : null }}">
                        <a
                            href="{{ route('boq.project.global-material-specifications.index', ['project' => $project]) }}">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext"> Material Specifications </span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Calculation -->
            <li
                class="pcoded-hasmenu {{ request()->routeIs('boq.project.departments.civil.calculations.*') || request()->routeIs('boq.project.departments.civil.costs.consumables.*') ? 'active pcoded-trigger' : null }}">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="fas fa-calculator"></i><b></b></span>
                    <span class="pcoded-mtext">Calculations</span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    @can('boq-civil')
                    <li
                        class="{{ request()->routeIs('boq.project.departments.civil.calculations.*') &&
                        request()->route()->parameter('calculation_type') == 'material'
                            ? 'active pcoded-trigger'
                            : null }}">
                        <a
                            href="{{ route('boq.project.departments.civil.calculations.create', ['project' => $project, 'calculation_type' => 'material']) }}">
                            <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                            <span class="pcoded-mtext"> Material </span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li
                        class="{{ request()->routeIs('boq.project.departments.civil.calculations.*') &&
                        request()->route()->parameter('calculation_type') == 'labour'
                            ? 'active pcoded-trigger'
                            : null }}">
                        <a
                            href="{{ route('boq.project.departments.civil.calculations.create', ['project' => $project, 'calculation_type' => 'labour']) }}">
                            <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                            <span class="pcoded-mtext"> Labour </span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li
                        class="{{ request()->routeIs('boq.project.departments.civil.calculations.*') &&
                        request()->route()->parameter('calculation_type') == 'material-labour'
                            ? 'active pcoded-trigger'
                            : null }}">
                        <a
                            href="{{ route('boq.project.departments.civil.calculations.create', ['project' => $project, 'calculation_type' => 'material-labour']) }}">
                            <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                            <span class="pcoded-mtext"> Material & Labour </span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li
                        class="{{ request()->routeIs('boq.project.departments.civil.costs.consumables.create.*') ? 'active pcoded-trigger' : null }}">
                        <a
                            href="{{ route('boq.project.departments.civil.costs.consumables.create', ['project' => $project]) }}">
                            <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                            <span class="pcoded-mtext"> Related Materials/Work</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    @endcan
                    <li class="{{ request()->routeIs('boq.project.departments.civil.revised-sheets.index.*') ? 'active pcoded-trigger' : null }}">
                        <a href="{{ route('boq.project.departments.civil.revised-sheets.index', ['project' => $project]) }}">
                            <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                            <span class="pcoded-mtext"> Revised Sheet</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('boq.project.departments.civil.conversion-sheets.index.*') ? 'active pcoded-trigger' : null }}">
                        <a href="{{ route('boq.project.departments.civil.conversion-sheets.index', ['project' => $project]) }}">
                            <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                            <span class="pcoded-mtext"> Conversion Sheet</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li
                        class="{{ request()->routeIs('boq.project.departments.civil.configurations.projectwise-material-price.*') ? 'active pcoded-trigger' : null }}">
                        <a
                            href="{{ route('boq.project.departments.civil.configurations.projectwise-material-price.index', ['project' => $project]) }}">
                            <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                            <span class="pcoded-mtext"> Material Prices</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Costs -->
            {{-- <li
                class="pcoded-hasmenu {{ request()->routeIs('boq.project.departments.civil.costs.*') ? 'active pcoded-trigger' : null }}">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="fas fa-dollar-sign"></i><b></b></span>
                    <span class="pcoded-mtext">Costs</span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu"> --}}
            {{--                    <li class="{{ request()->routeIs('boq.project.departments.civil.costs.labours.*') ? 'active pcoded-trigger' : null }}"> --}}
            {{--                        <a href="{{ route('boq.project.departments.civil.costs.labours.index', ['project' => $project]) }}"> --}}
            {{--                            <span class="pcoded-micon"><i class="icon-pie-chart"></i></span> --}}
            {{--                            <span class="pcoded-mtext"> Labour Cost</span> --}}
            {{--                            <span class="pcoded-mcaret"></span> --}}
            {{--                        </a> --}}
            {{--                    </li> --}}
            {{-- <li
                        class="{{ request()->routeIs('boq.project.departments.civil.costs.consumables.*') ? 'active pcoded-trigger' : null }}">
                        <a
                            href="{{ route('boq.project.departments.civil.costs.consumables.index', ['project' => $project]) }}">
                            <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                            <span class="pcoded-mtext"> Consumable Cost</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li> --}}
            {{-- </ul>
            </li> --}}

            <!-- Cost Analysis -->
            <li
                class="pcoded-hasmenu {{ request()->routeIs('boq.project.departments.civil.cost_analysis.floor_wise.*') || request()->routeIs('boq.project.departments.civil.cost_analysis.work.quantity') ? 'active pcoded-trigger' : null }}">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="fas fa-chart-bar"></i><b></b></span>
                    <span class="pcoded-mtext">BOQ</span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    {{-- Work from here... --}}
                    <li
                        class="{{ request()->routeIs('boq.project.departments.civil.cost_analysis.work.quantity') ? 'active pcoded-trigger' : null }}">
                        <a
                            href="{{ route('boq.project.departments.civil.cost_analysis.work.quantity', ['project' => $project]) }}">
                            <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                            <span class="pcoded-mtext"> Work Quantity </span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li
                        class="{{ request()->routeIs('boq.project.departments.civil.cost_analysis.reinforcement.sheet') ? 'active pcoded-trigger' : null }}">
                        <a
                            href="{{ route('boq.project.departments.civil.cost_analysis.reinforcement.sheet', ['project' => $project]) }}">
                            <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                            <span class="pcoded-mtext"> MS Rod Sheet </span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li
                        class="{{ request()->routeIs('boq.project.departments.civil.cost_analysis.percentage_sheet.floorwise') ? 'active pcoded-trigger' : null }}">
                        <a
                            href="{{ route('boq.project.departments.civil.cost_analysis.percentage_sheet.floorwise', ['project' => $project]) }}">
                            <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                            <span class="pcoded-mtext"> Floorwise Percentage Sheet </span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li
                        class="{{ request()->routeIs('boq.project.departments.civil.cost_analysis.percentage_sheet.workwise') ? 'active pcoded-trigger' : null }}">
                        <a
                            href="{{ route('boq.project.departments.civil.cost_analysis.percentage_sheet.workwise', ['project' => $project]) }}">
                            <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                            <span class="pcoded-mtext"> Itemwise Percentage Sheet </span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li
                        class="{{ request()->routeIs('boq.project.departments.civil.cost_analysis.floor_wise.material.costs') ? 'active pcoded-trigger' : null }}">
                        <a
                            href="{{ route('boq.project.departments.civil.cost_analysis.floor_wise.material.costs', ['project' => $project]) }}">
                            <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                            <span class="pcoded-mtext">Material Cost Floorwise</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li
                        class="{{ request()->routeIs('boq.project.departments.civil.cost_analysis.floor_wise.labour.costs') ? 'active pcoded-trigger' : null }}">
                        <a
                            href="{{ route('boq.project.departments.civil.cost_analysis.floor_wise.labour.costs', ['project' => $project]) }}">
                            <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                            <span class="pcoded-mtext"> Labour Cost Floorwise </span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li
                        class="{{ request()->routeIs('boq.project.departments.civil.cost_analysis.floor_wise.material_labour.costs') ? 'active pcoded-trigger' : null }}">
                        <a
                            href="{{ route('boq.project.departments.civil.cost_analysis.floor_wise.material_labour.costs', ['project' => $project]) }}">
                            <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                            <span class="pcoded-mtext"> Material & Labour Cost Floorwise </span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>

                    <li
                        class="{{ request()->routeIs('boq.project.departments.civil.cost_analysis.floor_wise.related_material.costs') ? 'active pcoded-trigger' : null }}">
                        <a
                            href="{{ route('boq.project.departments.civil.cost_analysis.floor_wise.related_material.costs', ['project' => $project]) }}">
                            <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                            <span class="pcoded-mtext"> Related Material Cost</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>

                    {{-- <li class="{{ request()->routeIs('boq.project.departments.civil.cost_analysis.floor_wise.material.statement')? 'active pcoded-trigger': null }}">
                        <a href="{{ route('boq.project.departments.civil.cost_analysis.floor_wise.material.statement', ['project' => $project]) }}">
                            <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                            <span class="pcoded-mtext"> Material Statement Floorwise </span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li> --}}
                    {{--                    <li --}}
                    {{--                        class="{{ request()->routeIs('boq.project.departments.civil.cost_analysis.floor_wise.workwise.material.statement') ? 'active pcoded-trigger' : null }}"> --}}
                    {{--                        <a --}}
                    {{--                            href="{{ route('boq.project.departments.civil.cost_analysis.floor_wise.workwise.material.statement', ['project' => $project]) }}"> --}}
                    {{--                            <span class="pcoded-micon"><i class="icon-pie-chart"></i></span> --}}
                    {{--                            <span class="pcoded-mtext"> Material Statement Workwise </span> --}}
                    {{--                            <span class="pcoded-mcaret"></span> --}}
                    {{--                        </a> --}}
                    {{--                    </li> --}}
                    {{--                    --}}{{-- Work from here... --}}
                    {{--                    <li --}}
                    {{--                        class="{{ request()->routeIs('boq.project.departments.civil.cost_analysis.floor_wise.material.summary') ? 'active pcoded-trigger' : null }}"> --}}
                    {{--                        <a --}}
                    {{--                            href="{{ route('boq.project.departments.civil.cost_analysis.floor_wise.material.summary', ['project' => $project]) }}"> --}}
                    {{--                            <span class="pcoded-micon"><i class="icon-pie-chart"></i></span> --}}
                    {{--                            <span class="pcoded-mtext"> Material Summary </span> --}}
                    {{--                            <span class="pcoded-mcaret"></span> --}}
                    {{--                        </a> --}}
                    {{--                    </li> --}}

                    {{--                    <!-- Percentage Sheet --> --}}
                    {{--                    <li --}}
                    {{--                        class="pcoded-hasmenu {{ request()->routeIs('boq.project.departments.civil.cost_analysis.percentage_sheet.*') ? 'active pcoded-trigger' : null }}"> --}}
                    {{--                        <a href="javascript:void(0)"> --}}
                    {{--                            <span class="pcoded-micon"><i class="ti-settings"></i><b></b></span> --}}
                    {{--                            <span class="pcoded-mtext">Percentage Sheet</span> --}}
                    {{--                            <span class="pcoded-mcaret"></span> --}}
                    {{--                        </a> --}}
                    {{--                        <ul class="pcoded-submenu"> --}}
                    {{--                            <li --}}
                    {{--                                class="{{ request()->routeIs('boq.project.departments.civil.cost_analysis.percentage_sheet.workwise.*') ? 'active pcoded-trigger' : null }}"> --}}
                    {{--                                <a --}}
                    {{--                                    href="{{ route('boq.project.departments.civil.cost_analysis.percentage_sheet.workwise', ['project' => $project]) }}"> --}}
                    {{--                                    <span class="pcoded-micon"><i class="icon-pie-chart"></i></span> --}}
                    {{--                                    <span class="pcoded-mtext"> Workwise </span> --}}
                    {{--                                    <span class="pcoded-mcaret"></span> --}}
                    {{--                                </a> --}}
                    {{--                            </li> --}}
                    {{--                            <li --}}
                    {{--                                class="{{ request()->routeIs('boq.project.departments.civil.cost_analysis.percentage_sheet.floorwise.*') ? 'active pcoded-trigger' : null }}"> --}}
                    {{--                                <a --}}
                    {{--                                    href="{{ route('boq.project.departments.civil.cost_analysis.percentage_sheet.floorwise', ['project' => $project]) }}"> --}}
                    {{--                                    <span class="pcoded-micon"><i class="icon-pie-chart"></i></span> --}}
                    {{--                                    <span class="pcoded-mtext"> Floorwise </span> --}}
                    {{--                                    <span class="pcoded-mcaret"></span> --}}
                    {{--                                </a> --}}
                    {{--                            </li> --}}
                    {{--                        </ul> --}}
                    {{--                    </li> --}}
                </ul>
            </li>
            <hr>
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
        <div class="p-5"></div>
    </div>
</nav>
