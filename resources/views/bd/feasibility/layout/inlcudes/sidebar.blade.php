<nav class="pcoded-navbar">
    <div class="sidebar_toggle"><a href="#"><i class="icon-close icons"></i></a></div>
    <div class="pcoded-inner-navbar main-menu">
        <div class="pcoded-navigation-label text-uppercase bg-primary">@yield('dashboard', $bd_lead_location_name[0]->land_location)</div>
        <ul class="pcoded-item pcoded-left-item">
            <!-- Configuration -->
            

            <!-- Departments -->
            <li class="pcoded-hasmenu {{ request()->routeIs('feasibility.location.site-expense.*') ? 'active pcoded-trigger' : null }}">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="far fa-building"></i><b></b></span>
                    <span class="pcoded-mtext">Site Expense</span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    <li class="{{ request()->routeIs('feasibility.location.site-expense.create') ? 'active' : null }}">
                        <a href="{{ route('feasibility.location.site-expense.create',[ $bd_lead_location_name[0]->id]) }}">
                            <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                            <span class="pcoded-mtext"> New Site Expense</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('feasibility.location.site-expense.index') ? 'active' : null }}">
                        <a href="{{ route('feasibility.location.site-expense.index',[ $bd_lead_location_name[0]->id]) }}">
                            <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                            <span class="pcoded-mtext">Site Expense List</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="{{ request()->routeIs('feasibility.location.far.index') ? 'active' : null }}">
                <a href="{{ route('feasibility.location.far.index',[ $bd_lead_location_name[0]->id]) }}">
                    <span class="pcoded-micon"><i class="fas fa-scroll"></i></span>
                    <span class="pcoded-mtext">FAR</span>
                </a>
            </li>
            
            <li class="pcoded-hasmenu {{ request()->routeIs('feasibility.location.permission-fees-ors.*') ? 'active pcoded-trigger' : null }}">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="far fa-building"></i><b></b></span>
                    <span class="pcoded-mtext">Permission Fees & Ors</span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    <li class="{{ request()->routeIs('feasibility.location.permission-fees-ors.create') ? 'active' : null }}">
                        <a href="{{ route('feasibility.location.permission-fees-ors.create',[ $bd_lead_location_name[0]->id]) }}">
                            <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                            <span class="pcoded-mtext"> New Fees & Ors</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('feasibility.location.permission-fees-ors.index') ? 'active' : null }}">
                        <a href="{{ route('feasibility.location.permission-fees-ors.index',[ $bd_lead_location_name[0]->id]) }}">
                            <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                            <span class="pcoded-mtext">Fees & Ors List</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="pcoded-hasmenu {{ request()->routeIs('feasibility.location.sub-and-generator.*') ? 'active pcoded-trigger' : null }}">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="far fa-building"></i><b></b></span>
                    <span class="pcoded-mtext">Sub & Generator</span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    <li class="{{ request()->routeIs('feasibility.location.sub-and-generator.create') ? 'active' : null }}">
                        <a href="{{ route('feasibility.location.sub-and-generator.create',[ $bd_lead_location_name[0]->id]) }}">
                            <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                            <span class="pcoded-mtext"> New Sub & Generator</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('feasibility.location.sub-and-generator.index') ? 'active' : null }}">
                        <a href="{{ route('feasibility.location.sub-and-generator.index',[ $bd_lead_location_name[0]->id]) }}">
                            <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                            <span class="pcoded-mtext">Sub & Generator List</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="pcoded-hasmenu {{ request()->routeIs('feasibility.location.ctc.*') ? 'active pcoded-trigger' : null }}">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="far fa-building"></i><b></b></span>
                    <span class="pcoded-mtext">CTC</span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    <li class="{{ request()->routeIs('feasibility.location.ctc.create') ? 'active' : null }}">
                        <a href="{{ route('feasibility.location.ctc.create',[ $bd_lead_location_name[0]->id]) }}">
                            <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                            <span class="pcoded-mtext"> New CTC</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('feasibility.location.ctc.index') ? 'active' : null }}">
                        <a href="{{ route('feasibility.location.ctc.index',[ $bd_lead_location_name[0]->id]) }}">
                            <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                            <span class="pcoded-mtext">CTC List</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                </ul>
            </li>
            <hr>
            {{-- <li>
                <a href="{{ route('boq.select_project') }}">
                    <i class="fa fa-arrow-left"></i>
                    Back To Location List
                </a>
            </li> --}}
        </ul>
        <div class="p-5"></div>
    </div>
</nav>
