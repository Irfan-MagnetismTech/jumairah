<nav class="pcoded-navbar">
    <div class="sidebar_toggle"><a href="#"><i class="icon-close icons"></i></a></div>
    <div class="pcoded-inner-navbar main-menu">
        <ul class="pcoded-item pcoded-left-item">
            @hasanyrole('super-admin|admin')
                <li
                    class="pcoded-hasmenu {{ request()->routeIs(['users.*', 'roles.*', 'permissions.*']) ? 'active pcoded-trigger' : null }}">
                    <a href="javascript:void(0)">
                        <span class="pcoded-micon"><i class="ti-panel"></i><b>D</b></span>
                        <span class="pcoded-mtext">Control Users</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="{{ request()->routeIs('users.*') ? 'active' : null }}">
                            <a href="{{ route('users.index') }}"> <span class="pcoded-micon"><i
                                        class="ti-angle-right"></i></span><span class="pcoded-mtext">User</span><span
                                    class="pcoded-mcaret"></span></a>
                        </li>
                        <li class="{{ request()->routeIs('roles.*') ? 'active' : null }}">
                            <a href="{{ route('roles.index') }}"> <span class="pcoded-micon"><i
                                        class="ti-angle-right"></i></span><span class="pcoded-mtext">Role</span><span
                                    class="pcoded-mcaret"></span></a>
                        </li>
                        @role('super-admin')
                            <li class="{{ request()->routeIs('permissions.*') ? 'active' : null }}">
                                <a href="{{ route('permissions.index') }}"> <span class="pcoded-micon"><i
                                            class="ti-angle-right"></i></span><span class="pcoded-mtext">Permission</span><span
                                        class="pcoded-mcaret"></span></a>
                            </li>
                        @endrole
                    </ul>
                </li>
            @endhasanyrole
            {{-- @endrole --}}
            <li
                class="pcoded-hasmenu {{ request()->routeIs(['branches.*', 'apsections.*', 'teams.*', 'departments.*', 'designations.*', 'employees.*', 'sellCollectionHeads.*']) ? 'active pcoded-trigger' : null }}">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="ti-settings"></i><b>P</b></span>
                    <span class="pcoded-mtext">Configurations</span>
                    {{-- <span class="pcoded-badge label label-warning">NEW</span> --}}
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    {{-- <li class="{{request()->routeIs('branches.*') ? "active" : null}}"><a href="{{ route('branches.index') }}"><span class="pcoded-micon"><i class="icon-pie-chart"></i></span><span class="pcoded-mtext"> Branches </span><span class="pcoded-mcaret"></span></a></li> --}}
                    {{-- <li class="{{request()->routeIs('apsections.*') ? "active" : null}}"><a href="{{ route('apsections.index') }}"><span class="pcoded-micon"><i class="icon-pie-chart"></i></span><span class="pcoded-mtext"> Sections </span><span class="pcoded-mcaret"></span></a></li> --}}
                    {{-- <li class="{{request()->routeIs('teams.*') ? "active" : null}}"><a href="{{ route('teams.index') }}"><span class="pcoded-micon"><i class="icon-pie-chart"></i></span><span class="pcoded-mtext"> Teams </span><span class="pcoded-mcaret"></span></a></li> --}}
                    <li class="pcoded-hasmenu {{ request()->routeIs('teams.*') ? 'active pcoded-trigger' : null }}">
                        <a href="javascript:void(0)">
                            <span class="pcoded-micon"><i class="far fa-building"></i><b>BC</b></span>
                            <span class="pcoded-mtext">Team Details</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                        <ul class="pcoded-submenu">
                            <li class="{{ request()->routeIs('teams.create') ? 'active' : null }}">
                                <a href="{{ route('teams.create') }}">
                                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                    <span class="pcoded-mtext">New Team </span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('teams.index') ? 'active' : null }}">
                                <a href="{{ route('teams.index') }}">
                                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                    <span class="pcoded-mtext">Teams List </span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="{{ request()->routeIs('departments.*') ? 'active' : null }}"><a
                            href="{{ route('departments.index') }}"><span class="pcoded-micon"><i
                                    class="icon-pie-chart"></i></span><span class="pcoded-mtext"> Departments
                            </span><span class="pcoded-mcaret"></span></a></li>
                    <li class="{{ request()->routeIs('designations.*') ? 'active' : null }}"><a
                            href="{{ route('designations.index') }}"><span class="pcoded-micon"><i
                                    class="icon-pie-chart"></i></span><span class="pcoded-mtext"> Designations
                            </span><span class="pcoded-mcaret"></span></a></li>
                    <li class="{{ request()->routeIs('employees.*') ? 'active' : null }}"><a
                            href="{{ route('employees.index') }}"><span class="pcoded-micon"><i
                                    class="icon-pie-chart"></i></span><span class="pcoded-mtext"> Employee </span><span
                                class="pcoded-mcaret"></span></a></li>
                    <li class="{{ request()->routeIs('sellCollectionHeads.*') ? 'active' : null }}"><a
                            href="{{ route('sellCollectionHeads.index') }}"><span class="pcoded-micon"><i
                                    class="icon-pie-chart"></i></span><span class="pcoded-mtext"> Sale Collection Head
                            </span><span class="pcoded-mcaret"></span></a></li>
                    <li class="{{ request()->routeIs('to_do_lists.*') ? 'active' : null }}"><a
                            href="{{ route('to_do_lists.index') }}"><span class="pcoded-micon"><i
                                    class="icon-pie-chart"></i></span><span class="pcoded-mtext"> To Do List
                            </span><span class="pcoded-mcaret"></span></a></li>
                    <li class="{{ request()->routeIs('budget-head.*') ? 'active' : null }}"><a
                            href="{{ route('budget-head.index') }}"><span class="pcoded-micon"><i
                                    class="icon-pie-chart"></i></span><span class="pcoded-mtext"> Budget Head
                            </span><span class="pcoded-mcaret"></span></a></li>

                    @can('approval-view')
                        <li class="pcoded-hasmenu {{ request()->routeIs('teams.*') ? 'active pcoded-trigger' : null }}">
                            <a href="javascript:void(0)">
                                <span class="pcoded-micon"><i class="far fa-building"></i><b>BC</b></span>
                                <span class="pcoded-mtext">Approval Layer</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                            <ul class="pcoded-submenu">
                                @role('super-admin')
                                    <li class="{{ request()->routeIs('leayer-name.*') ? 'active' : null }}">
                                        <a href="{{ route('leayer-name.index') }}">
                                            <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                                            <span class="pcoded-mtext"> Layer Subject</span>
                                            <span class="pcoded-mcaret"></span>
                                        </a>
                                    </li>
                                @endrole
                                <li class="{{ request()->routeIs('approval-layer.create') ? 'active' : null }}">
                                    <a href="{{ route('approval-layer.create') }}">
                                        <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                        <span class="pcoded-mtext">New Layer </span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>
                                <li class="{{ request()->routeIs('approval-layer.index') ? 'active' : null }}">
                                    <a href="{{ route('approval-layer.index') }}">
                                        <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                        <span class="pcoded-mtext"> Layer List</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endcan
                </ul>
            </li>
        </ul>
        <div class="pcoded-navigation-label text-uppercase bg-primary">General</div>
        <ul class="pcoded-item pcoded-left-item">
            <li
                class="pcoded-hasmenu {{ request()->routeIs('general-requisitions.*') ? 'active pcoded-trigger' : null }}">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="fas fa-cart-plus"></i><b>BC</b></span>
                    <span class="pcoded-mtext">General Requisitions</span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    <li class="{{ request()->routeIs('general-requisitions.create') ? 'active' : null }}">
                        <a href="{{ route('general-requisitions.create') }}">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext">New Requisition </span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('general-requisitions.index') ? 'active' : null }}">
                        <a href="{{ route('general-requisitions.index') }}">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext">Requisitions List </span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                </ul>
            </li>

            @can('bill-register-view')
                <li class="pcoded-hasmenu {{ request()->routeIs('bill-register.*') ? 'active pcoded-trigger' : null }}">
                    <a href="javascript:void(0)">
                        <span class="pcoded-micon"><i class="fas fa-cart-plus"></i><b>BC</b></span>
                        <span class="pcoded-mtext">Bill Register</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="{{ request()->routeIs('bill-register.create') ? 'active' : null }}">
                            <a href="{{ route('bill-register.create') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">New Bill Register </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('bill-register.index') ? 'active' : null }}">
                            <a href="{{ route('bill-register.index') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Bill Register List</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan

            <li class="pcoded-hasmenu {{ request()->routeIs('generalBill.*') ? 'active pcoded-trigger' : null }}">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="fas fa-cart-plus"></i><b>BC</b></span>
                    <span class="pcoded-mtext">General Bill</span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    <li class="{{ request()->routeIs('costMemo.create') ? 'active' : null }}">
                        <a href="{{ route('generalBill.create') }}">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext">New general bill</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('generalBill.index') ? 'active' : null }}">
                        <a href="{{ route('generalBill.index') }}">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext">General Bill List</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                </ul>
            </li>

            {{-- <li class="pcoded-hasmenu {{ request()->routeIs('costMemo.*') ? 'active pcoded-trigger' : null }}">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="fas fa-cart-plus"></i><b>BC</b></span>
                    <span class="pcoded-mtext">Cost Memo</span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    <li class="{{ request()->routeIs('costMemo.create') ? 'active' : null }}">
                        <a href="{{ route('costMemo.create') }}">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext">New Cost Memo</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('costMemo.index') ? 'active' : null }}">
                        <a href="{{ route('costMemo.index') }}">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext">Cost Memo List</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                </ul>
            </li> --}}

            @can('iou-create')
                <li class="pcoded-hasmenu {{ request()->routeIs('ious.*') ? 'active pcoded-trigger' : null }}">
                    <a href="javascript:void(0)">
                        <span class="pcoded-micon"><i class="fas fa-cart-plus"></i><b>BC</b></span>
                        <span class="pcoded-mtext">IOU</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="{{ request()->routeIs('ious.create') ? 'active' : null }}">
                            <a href="{{ route('ious.create') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">New IOU Slip </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('ious.index') ? 'active' : null }}">
                            <a href="{{ route('ious.index') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">IOU List </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li
                    class="pcoded-hasmenu {{ request()->routeIs('advanceadjustments.*') ? 'active pcoded-trigger' : null }}">
                    <a href="javascript:void(0)">
                        <span class="pcoded-micon"><i class="fas fa-cart-plus"></i><b>BC</b></span>
                        <span class="pcoded-mtext">Advance Adjustment</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="{{ request()->routeIs('advanceadjustments.create') ? 'active' : null }}">
                            <a href="{{ route('advanceadjustments.create') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">New Advance Adjustment </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('advanceadjustments.index') ? 'active' : null }}">
                            <a href="{{ route('advanceadjustments.index') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Advance Adjustment List </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan

            {{-- @can('admin-yearly-budgets')
                <li
                    class="pcoded-hasmenu {{ request()->routeIs('admin-yearly-budgets.*') ? 'active pcoded-trigger' : null }}">
                    <a href="javascript:void(0)">
                        <span class="pcoded-micon"><i class="fas fa-cart-plus"></i><b>BC</b></span>
                        <span class="pcoded-mtext">Admin Yearly Budget</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="{{ request()->routeIs('admin-yearly-budgets.create') ? 'active' : null }}">
                            <a href="{{ route('admin-yearly-budgets.create') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">New Yearly Budgets </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('admin-yearly-budgets.index') ? 'active' : null }}">
                            <a href="{{ route('admin-yearly-budgets.index') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Yearly Budget List</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('admin-yearly-budgets-report') ? 'active' : null }}">
                            <a href="{{ route('admin-yearly-budgets-report') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Yearly Budget Report</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan --}}
            {{-- @can('admin-monthly-budgets')
                <li
                    class="pcoded-hasmenu {{ request()->routeIs('admin-monthly-budgets.*') ? 'active pcoded-trigger' : null }}">
                    <a href="javascript:void(0)">
                        <span class="pcoded-micon"><i class="fas fa-cart-plus"></i><b>BC</b></span>
                        <span class="pcoded-mtext">Admin Monthly Budget</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="{{ request()->routeIs('admin-monthly-budgets.create') ? 'active' : null }}">
                            <a href="{{ route('admin-monthly-budgets.create') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">New monthly Budgets </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('admin-monthly-budgets.index') ? 'active' : null }}">
                            <a href="{{ route('admin-monthly-budgets.index') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Monthly Budget List</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('admin-monthly-budgets-report') ? 'active' : null }}">
                            <a href="{{ route('admin-monthly-budgets-report') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Monthly Budget Report</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan --}}
        </ul>

        @canany(['bd-source-view', 'bd-lead-generation-view', 'project-layout', 'bd-feasibility-locations-view',
            'project-view', 'bd-monthly-budget-view', 'bd-yearly-budget-view', 'bd-priority-land-view', 'bd-inventory-view',
            'parking-view', 'apartment-view'])
            <div class="pcoded-navigation-label text-uppercase bg-primary">Business Development (BD)</div>
        @endcanany

        <ul class="pcoded-item pcoded-left-item">
            <li
                class="pcoded-hasmenu {{ request()->routeIs(['feasi_perticular.*']) ? 'active pcoded-trigger' : null }}">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="ti-settings"></i><b>P</b></span>
                    <span class="pcoded-mtext">Configurations</span>
                    {{-- <span class="pcoded-badge label label-warning">NEW</span> --}}
                    <span class="pcoded-mcaret"></span>
                </a>
                @can('mouza-view')
                    <ul class="pcoded-submenu">
                        <li class="pcoded-hasmenu {{ request()->routeIs('mouzas.*') ? 'active pcoded-trigger' : null }}">
                            <a href="javascript:void(0)">
                                <span class="pcoded-micon"><i class="ti-home"></i><b>BC</b></span>
                                <span class="pcoded-mtext">Mouza</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                            <ul class="pcoded-submenu">
                                <li class="{{ request()->routeIs('mouzas.create') ? 'active' : null }}">
                                    <a href="{{ route('mouzas.create') }}">
                                        <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                        <span class="pcoded-mtext">New</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>
                                <li class="{{ request()->routeIs('mouzas.index') ? 'active' : null }}">
                                    <a href="{{ route('mouzas.index') }}">
                                        <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                        <span class="pcoded-mtext">List</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                @endcan
                @can('bd-source-view')
                    <ul class="pcoded-submenu">
                        <li class="pcoded-hasmenu {{ request()->routeIs('source.*') ? 'active pcoded-trigger' : null }}">
                            <a href="javascript:void(0)">
                                <span class="pcoded-micon"><i class="ti-home"></i><b>BC</b></span>
                                <span class="pcoded-mtext">Sources</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                            <ul class="pcoded-submenu">
                                <li class="{{ request()->routeIs('source.create') ? 'active' : null }}">
                                    <a href="{{ route('source.create') }}">
                                        <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                        <span class="pcoded-mtext">New Source</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>
                                <li class="{{ request()->routeIs('source.index') ? 'active' : null }}">
                                    <a href="{{ route('source.index') }}">
                                        <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                        <span class="pcoded-mtext">Source List </span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                @endcan
                @can('bd-Feasibility-particuler-view')
                    <ul class="pcoded-submenu">
                        <li
                            class="pcoded-hasmenu {{ request()->routeIs('feasi_perticular.*') ? 'active pcoded-trigger' : null }}">
                            <a href="javascript:void(0)">
                                <span class="pcoded-micon"><i class="far fa-building"></i><b>BC</b></span>
                                <span class="pcoded-mtext">Feasibility Particular</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                            <ul class="pcoded-submenu">
                                <li class="{{ request()->routeIs('feasi_perticular.create') ? 'active' : null }}">
                                    <a href="{{ route('feasi_perticular.create') }}">
                                        <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                        <span class="pcoded-mtext">New Particular</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>
                                <li class="{{ request()->routeIs('feasi_perticular.index') ? 'active' : null }}">
                                    <a href="{{ route('feasi_perticular.index') }}">
                                        <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                        <span class="pcoded-mtext">Particular List </span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                @endcan
                @can('bd-Feasibility-referene-fees-view')
                    <ul class="pcoded-submenu">
                        <li
                            class="pcoded-hasmenu {{ request()->routeIs('reference_fees.*') ? 'active pcoded-trigger' : null }}">
                            <a href="javascript:void(0)">
                                <span class="pcoded-micon"><i class="far fa-building"></i><b>BC</b></span>
                                <span class="pcoded-mtext">Reference of Fees</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                            <ul class="pcoded-submenu">
                                <li class="{{ request()->routeIs('reference_fees.create') ? 'active' : null }}">
                                    <a href="{{ route('reference_fees.create') }}">
                                        <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                        <span class="pcoded-mtext">New Reference of Fees </span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>
                                <li class="{{ request()->routeIs('reference_fees.index') ? 'active' : null }}">
                                    <a href="{{ route('reference_fees.index') }}">
                                        <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                        <span class="pcoded-mtext">Reference of Fees List </span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                @endcan
                <ul class="pcoded-submenu">
                    <li class="{{ request()->routeIs('feasibility-copy') ? 'active' : null }}">
                        <a href="{{ route('feasibility-copy') }}">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext">Feasibility Copy</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                </ul>
            </li>

            @can('bd-lead-generation-view')
                <li class="pcoded-hasmenu {{ request()->routeIs('bd_lead.*') ? 'active pcoded-trigger' : null }}">
                    <a href="javascript:void(0)">
                        <span class="pcoded-micon"><i class="ti-home"></i><b>BC</b></span>
                        <span class="pcoded-mtext">Lead Generations</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="{{ request()->routeIs('bd_lead.create') ? 'active' : null }}">
                            <a href="{{ route('bd_lead.create') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Lead Add</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('bd_lead.index') ? 'active' : null }}">
                            <a href="{{ route('bd_lead.index') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Lead List </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan



            {{-- @can('pending-bill')
                <li class="{{ request()->routeIs('pending-bills') ? 'active' : null }}">
                    <a href="{{ route('pending-bills') }}">
                        <span class="pcoded-micon"><i class="fas fa-scroll"></i></span>
                        <span class="pcoded-mtext">Feasibility</span>
                    </a>
                </li>
            @endcan --}}

            @can('bd-project-layout-view')
                <li class="{{ request()->routeIs('project-layout.*', 'project-layout.index') ? 'active' : null }}">
                    <a href="{{ route('project-layout.index') }}">
                        <span class="pcoded-micon"><i class="far fa-building"></i><b>BC</b></span>
                        <span class="pcoded-mtext">FAR Calculation</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                    {{-- <ul class="pcoded-submenu">
                        <li class="{{ request()->routeIs('project-layout.index') ? 'active' : null }}">
                            <a href="{{ route('project-layout.index') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">New Calculation </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('bd_lead_index') ? 'active' : null }}">
                            <a href="{{ route('bd_lead_index') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Calculation List</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('project-layout.index') ? 'active' : null }}">
                            <a href="{{ route('project-layout.index') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Layout List </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                    </ul> --}}
                </li>
            @endcan

            {{-- @can('bd-feasibility-locations-view')
                <li class="{{ request()->routeIs('feasibility_locations.index') ? 'active' : null }}">
                    <a href="{{ route('feasibility_locations.index') }}">
                        <span class="pcoded-micon"><i class="ti-home"></i></span>
                        <span class="pcoded-mtext">Feasibility</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
            @endcan --}}
            <li
                class="pcoded-hasmenu {{ request()->routeIs(['fees_cost.*', 'finance.*', 'paymentSchedule', 'rnc_percent.*', 'rnc_calculation.*', 'feasibility-entry.locations', 'fees_cost.*', 'boq_fees_cost.create', 'boq_ref_fees_cost.create', 'ctc.*', 'revenue.*']) ? 'active pcoded-trigger' : null }}">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="ti-settings"></i><b>P</b></span>
                    <span class="pcoded-mtext">Feasibility</span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    @can('bd-Feasibility-Fees-Cost-view')
                        <li class="{{ request()->routeIs('feasibility-entry.locations') ? 'active' : null }}">
                            <a href="{{ route('feasibility-entry.locations') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Feasibility Basic Entry</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li
                            class="pcoded-hasmenu {{ request()->routeIs('fees_cost.*') ? 'active pcoded-trigger' : null }}">
                            <a href="javascript:void(0)">
                                <span class="pcoded-micon"><i class="far fa-building"></i><b>BC</b></span>
                                <span class="pcoded-mtext">Fees & Cost</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                            <ul class="pcoded-submenu">
                                <li class="{{ request()->routeIs('fees_cost.create') ? 'active' : null }}">
                                    <a href="{{ route('fees_cost.create') }}">
                                        <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                        <span class="pcoded-mtext">New Permission Fees</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>

                                <li class="{{ request()->routeIs('boq_fees_cost.create') ? 'active' : null }}">
                                    <a href="{{ route('boq_fees_cost.create') }}">
                                        <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                        <span class="pcoded-mtext">New Boq and Other Fees</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>

                                <li class="{{ request()->routeIs('boq_ref_fees_cost.create') ? 'active' : null }}">
                                    <a href="{{ route('boq_ref_fees_cost.create') }}">
                                        <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                        <span class="pcoded-mtext">New Ref Fees and Other Fees</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>

                                <li class="{{ request()->routeIs('fees_cost.index') ? 'active' : null }}">
                                    <a href="{{ route('fees_cost.index') }}">
                                        <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                        <span class="pcoded-mtext">Fees & Cost List </span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endcan
                    @can('bd-Feasibility-CTC-view')
                        <li class="pcoded-hasmenu {{ request()->routeIs('ctc.*') ? 'active pcoded-trigger' : null }}">
                            <a href="javascript:void(0)">
                                <span class="pcoded-micon"><i class="far fa-building"></i><b>BC</b></span>
                                <span class="pcoded-mtext">Cost of Company(CTC)</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                            <ul class="pcoded-submenu">
                                <li class="{{ request()->routeIs('ctc.create') ? 'active' : null }}">
                                    <a href="{{ route('ctc.create') }}">
                                        <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                        <span class="pcoded-mtext">New CTC</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>
                                <li class="{{ request()->routeIs('ctc.index') ? 'active' : null }}">
                                    <a href="{{ route('ctc.index') }}">
                                        <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                        <span class="pcoded-mtext">CTC List </span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endcan


                    <li
                        class="pcoded-hasmenu {{ request()->routeIs('revenue.*') ? 'active pcoded-trigger' : null }}">
                        <a href="javascript:void(0)">
                            <span class="pcoded-micon"><i class="far fa-building"></i><b>BC</b></span>
                            <span class="pcoded-mtext">Revenue</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                        <ul class="pcoded-submenu">
                            <li class="{{ request()->routeIs('revenue.create') ? 'active' : null }}">
                                <a href="{{ route('revenue.create') }}">
                                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                    <span class="pcoded-mtext">New Revenue</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('revenue.index') ? 'active' : null }}">
                                <a href="{{ route('revenue.index') }}">
                                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                    <span class="pcoded-mtext">Revenue List </span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li
                        class="pcoded-hasmenu {{ request()->routeIs('finance.*', 'paymentSchedule', 'rnc_percent.*', 'rnc_calculation.*') ? 'active pcoded-trigger' : null }}">
                        <a href="javascript:void(0)">
                            <span class="pcoded-micon"><i class="far fa-building"></i><b>BC</b></span>
                            <span class="pcoded-mtext">Finance</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                        <ul class="pcoded-submenu">
                            <li
                                class="pcoded-hasmenu {{ request()->routeIs('rnc_percent.*') ? 'active pcoded-trigger' : null }}">
                                <a href="javascript:void(0)">
                                    <span class="pcoded-micon"><i class="far fa-building"></i><b>BC</b></span>
                                    <span class="pcoded-mtext">Revenue & Cost Percent</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                                <ul class="pcoded-submenu">
                                    <li class="{{ request()->routeIs('rnc_percent.create') ? 'active' : null }}">
                                        <a href="{{ route('rnc_percent.create') }}">
                                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                            <span class="pcoded-mtext">New</span>
                                            <span class="pcoded-mcaret"></span>
                                        </a>
                                    </li>
                                    <li class="{{ request()->routeIs('rnc_percent.index') ? 'active' : null }}">
                                        <a href="{{ route('rnc_percent.index') }}">
                                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                            <span class="pcoded-mtext">List </span>
                                            <span class="pcoded-mcaret"></span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li
                                class="pcoded-hasmenu {{ request()->routeIs('rnc_calculation.*') ? 'active pcoded-trigger' : null }}">
                                <a href="javascript:void(0)">
                                    <span class="pcoded-micon"><i class="far fa-building"></i><b>BC</b></span>
                                    <span class="pcoded-mtext">Revenue & Cost Calculation</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                                <ul class="pcoded-submenu">
                                    <li class="{{ request()->routeIs('rnc_calculation.create') ? 'active' : null }}">
                                        <a href="{{ route('rnc_calculation.create') }}">
                                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                            <span class="pcoded-mtext">New</span>
                                            <span class="pcoded-mcaret"></span>
                                        </a>
                                    </li>
                                    <li class="{{ request()->routeIs('rnc_calculation.index') ? 'active' : null }}">
                                        <a href="{{ route('rnc_calculation.index') }}">
                                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                            <span class="pcoded-mtext">List </span>
                                            <span class="pcoded-mcaret"></span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="{{ request()->routeIs('finance.create') ? 'active' : null }}">
                                <a href="{{ route('finance.create') }}">
                                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                    <span class="pcoded-mtext">Add Finance</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('finance.index') ? 'active' : null }}">
                                <a href="{{ route('finance.index') }}">
                                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                    <span class="pcoded-mtext">Finance List </span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>

                            {{-- <li class="{{ request()->routeIs('paymentSchedule') ? 'active' : null }}">
                                <a href="{{ route('paymentSchedule') }}">
                                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                    <span class="pcoded-mtext">Payment Schedule</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li> --}}
                        </ul>
                    </li>


                    <li class="{{ request()->routeIs('feasibility-entry.index') ? 'active' : null }}">
                        <a href="{{ route('feasibility-entry.index') }}">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext">Main Feasibility </span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                </ul>
            </li>

            @can('project-view')
                <li class="pcoded-hasmenu {{ request()->routeIs('projects.*') ? 'active pcoded-trigger' : null }}">
                    <a href="javascript:void(0)">
                        <span class="pcoded-micon"><i class="far fa-building"></i><b>BC</b></span>
                        <span class="pcoded-mtext">Project Details</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">
                        @can('project-create')
                            <li class="{{ request()->routeIs('projects.create') ? 'active' : null }}">
                                <a href="{{ route('projects.create') }}">
                                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                    <span class="pcoded-mtext">New Project </span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
                        @endcan

                        <li class="{{ request()->routeIs('projects.index') ? 'active' : null }}">
                            <a href="{{ route('projects.index') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Projects List </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan
            {{-- @can('bd-priority-land-view')
                <li class="pcoded-hasmenu {{ request()->routeIs('priority_land.*') ? 'active pcoded-trigger' : null }}">
                    <a href="javascript:void(0)">
                        <span class="pcoded-micon"><i class="far fa-building"></i><b>BC</b></span>
                        <span class="pcoded-mtext">Priority Land</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="{{ request()->routeIs('priority_land.create') ? 'active' : null }}">
                            <a href="{{ route('priority_land.create') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">New Plan </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>

                        <li class="{{ request()->routeIs('priority_land.index') ? 'active' : null }}">
                            <a href="{{ route('priority_land.index') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">PLan List </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan --}}

            @can('bd-inventory-view')
                <li class="pcoded-hasmenu {{ request()->routeIs('bd_inventory.*') ? 'active pcoded-trigger' : null }}">
                    <a href="javascript:void(0)">
                        <span class="pcoded-micon"><i class="far fa-building"></i><b>BC</b></span>
                        <span class="pcoded-mtext">Inventory</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="{{ request()->routeIs('bd_inventory.create') ? 'active' : null }}">
                            <a href="{{ route('bd_inventory.create') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">New Inventory </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>

                        <li class="{{ request()->routeIs('bd_inventory.index') ? 'active' : null }}">
                            <a href="{{ route('bd_inventory.index') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Inventory List </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan
            @can('parking-view')
                <li class="pcoded-hasmenu {{ request()->routeIs('parkings.*') ? 'active pcoded-trigger' : null }}">
                    <a href="javascript:void(0)">
                        <span class="pcoded-micon"><i class="fa fa-car"></i><b>BC</b></span>
                        <span class="pcoded-mtext">Parkings</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">
                        @can('parking-create')
                            <li class="{{ request()->routeIs('parkings.create') ? 'active' : null }}">
                                <a href="{{ route('parkings.create') }}">
                                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                    <span class="pcoded-mtext">New Parking </span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
                        @endcan
                        <li class="{{ request()->routeIs('parkings.index') ? 'active' : null }}">
                            <a href="{{ route('parkings.index') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Parking List </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan
            @can('apartment-view')
                <li class="pcoded-hasmenu {{ request()->routeIs('apartments.*') ? 'active pcoded-trigger' : null }}">
                    <a href="javascript:void(0)">
                        <span class="pcoded-micon"><i class="ti-home"></i><b>BC</b></span>
                        <span class="pcoded-mtext">Apartment</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">
                        @can('apartment-create')
                            <li class="{{ request()->routeIs('apartments.create') ? 'active' : null }}">
                                <a href="{{ route('apartments.create') }}">
                                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                    <span class="pcoded-mtext">New Apartment</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
                        @endcan
                        <li class="{{ request()->routeIs('apartments.index') ? 'active' : null }}">
                            <a href="{{ route('apartments.index') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Apartment List </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan

            {{-- @can('bd-monthly-budget-view')
                <li class="pcoded-hasmenu {{ request()->routeIs('bd_budget.*') ? 'active pcoded-trigger' : null }}">
                    <a href="javascript:void(0)">
                        <span class="pcoded-micon"><i class="far fa-building"></i><b>BC</b></span>
                        <span class="pcoded-mtext">Monthly Budget</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="{{ request()->routeIs('bd_budget.create') ? 'active' : null }}">
                            <a href="{{ route('bd_budget.create') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">New Monthly Budget </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>

                        <li class="{{ request()->routeIs('bd_budget.index') ? 'active' : null }}">
                            <a href="{{ route('bd_budget.index') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Monthly Budget List </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan --}}
            {{-- @can('bd-yearly-budget-view')
                <li
                    class="pcoded-hasmenu {{ request()->routeIs('bd_yearly_budget.*') ? 'active pcoded-trigger' : null }}">
                    <a href="javascript:void(0)">
                        <span class="pcoded-micon"><i class="far fa-building"></i><b>BC</b></span>
                        <span class="pcoded-mtext">Yearly Budget</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="{{ request()->routeIs('bd_yearly_budget.create') ? 'active' : null }}">
                            <a href="{{ route('bd_yearly_budget.create') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">New Yearly Budget </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>

                        <li class="{{ request()->routeIs('bd_yearly_budget.index') ? 'active' : null }}">
                            <a href="{{ route('bd_yearly_budget.index') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Yearly Budget List </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan --}}

            {{-- @can('memo-view')
                <li class="pcoded-hasmenu {{ request()->routeIs('memo.*') ? 'active pcoded-trigger' : null }}">
                    <a href="javascript:void(0)">
                        <span class="pcoded-micon"><i class="ti-home"></i><b>BC</b></span>
                        <span class="pcoded-mtext">Memo(Letter)</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">
                        @can('apartment-create')
                            <li class="{{ request()->routeIs('memo.create') ? 'active' : null }}">
                                <a href="{{ route('memo.create') }}">
                                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                    <span class="pcoded-mtext">New Memo</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
                        @endcan
                        <li class="{{ request()->routeIs('memo.index') ? 'active' : null }}">
                            <a href="{{ route('memo.index') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Memo List </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan --}}
            @can('warehouse-list')
                <li class="pcoded-hasmenu {{ request()->routeIs('warehouses.*') ? 'active pcoded-trigger' : null }}">
                    <a href="javascript:void(0)">
                        <span class="pcoded-micon"><i class="ti-home"></i><b>BC</b></span>
                        <span class="pcoded-mtext">Warehouse</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="{{ request()->routeIs('warehouses.create') ? 'active' : null }}">
                            <a href="{{ route('warehouses.create') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Create Warehouse</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('warehouses.index') ? 'active' : null }}">
                            <a href="{{ route('warehouses.index') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Warehouses List </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan






            {{-- <li class="pcoded-hasmenu {{ request()->routeIs(['scrapForm.*']) ? 'active pcoded-trigger' : null }}">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="ti-settings"></i><b>P</b></span>
                    <span class="pcoded-mtext">Scrap</span>
                    <span class="pcoded-mcaret"></span>
                </a> --}}
            {{--  <ul class="pcoded-submenu">
                    <li
                        class="pcoded-hasmenu {{ request()->routeIs('scrapForm.*') ? 'active pcoded-trigger' : null }}">
                        <a href="javascript:void(0)">
                            <span class="pcoded-micon"><i class="far fa-building"></i><b>BC</b></span>
                            <span class="pcoded-mtext">Scrap Form</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                        <ul class="pcoded-submenu">
                            <li class="{{ request()->routeIs('scrapForm.create') ? 'active' : null }}">
                                <a href="{{ route('scrapForm.create') }}">
                                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                    <span class="pcoded-mtext">New</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('scrapForm.index') ? 'active' : null }}">
                                <a href="{{ route('scrapForm.index') }}">
                                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                    <span class="pcoded-mtext">List </span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul> --}}
            {{-- <ul class="pcoded-submenu">
                    <li
                        class="pcoded-hasmenu {{ request()->routeIs('scrapCs.*') ? 'active pcoded-trigger' : null }}">
                        <a href="javascript:void(0)">
                            <span class="pcoded-micon"><i class="far fa-building"></i><b>BC</b></span>
                            <span class="pcoded-mtext">Scrap CS</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                        <ul class="pcoded-submenu">
                            <li class="{{ request()->routeIs('scrapCs.create') ? 'active' : null }}">
                                <a href="{{ route('scrapCs.create') }}">
                                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                    <span class="pcoded-mtext">New</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('scrapCs.index') ? 'active' : null }}">
                                <a href="{{ route('scrapCs.index') }}">
                                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                    <span class="pcoded-mtext">List </span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul> --}}

            {{-- <ul class="pcoded-submenu">
                    <li
                        class="pcoded-hasmenu {{ request()->routeIs('scrapSale.*') ? 'active pcoded-trigger' : null }}">
                        <a href="javascript:void(0)">
                            <span class="pcoded-micon"><i class="far fa-building"></i><b>BC</b></span>
                            <span class="pcoded-mtext">Scrap Sale</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                        <ul class="pcoded-submenu">
                            <li class="{{ request()->routeIs('scrapSale.create') ? 'active' : null }}">
                                <a href="{{ route('scrapSale.create') }}">
                                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                    <span class="pcoded-mtext">New</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
                            <li class="{{ request()->routeIs('scrapSale.index') ? 'active' : null }}">
                                <a href="{{ route('scrapSale.index') }}">
                                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                    <span class="pcoded-mtext">List</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul> --}}
            {{-- </li> --}}
        </ul>

        {{-- @can('bd-feasibility-view')
            <div class="pcoded-navigation-label text-uppercase bg-primary">Feasibility</div>
        @endcan
        <ul class="pcoded-item pcoded-left-item">
            @can('bd-feasibility-locations-view')
                <li class="{{ request()->routeIs('feasibility_locations.index') ? 'active' : null }}">
                    <a href="{{ route('feasibility_locations.index') }}">
                        <span class="pcoded-micon"><i class="ti-home"></i></span>
                        <span class="pcoded-mtext">Locations</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                </li>
            @endcan
        </ul> --}}
        {{--        @hasanyrole('super-admin|admin|Sales-Manager|CSD-Manager') --}}

        @canany(['leadgeneration-view', 'client-view', 'sell-view', 'salesCollection-view', 'sale-cancellation-view',
            'name-transfer-view', 'apartment-shifting-view', 'final-settlement-view', 'budget-view', 'sales-report'])
            <div class="pcoded-navigation-label text-uppercase bg-primary">Sales </div>
        @endcanany
        <ul class="pcoded-item pcoded-left-item">
            @can('leadgeneration-view')
                <li
                    class="pcoded-hasmenu {{ request()->routeIs(['leadgenerations.*', 'followups.*', 'noactivity']) ? 'active pcoded-trigger' : null }}">
                    <a href="javascript:void(0)">
                        <span class="pcoded-micon"><i class="fas fa-users"></i><b>BC</b></span>
                        <span class="pcoded-mtext">Lead Generations</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">
                        @can('leadgeneration-create')
                            <li class="{{ request()->routeIs('leadgenerations.create') ? 'active' : null }}">
                                <a href="{{ route('leadgenerations.create') }}">
                                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                    <span class="pcoded-mtext">Add Lead </span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
                        @endcan
                        <li class="{{ request()->routeIs('leadgenerations.index') ? 'active' : null }}">
                            <a href="{{ route('leadgenerations.index') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Lead List </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('dead-list') ? 'active' : null }}">
                            <a href="{{ route('dead-list') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Dead List </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('followups.index') ? 'active' : null }}">
                            <a href="{{ route('followups.index') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Followup List </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('missedFollowup') ? 'active' : null }}">
                            <a href="{{ route('missedFollowup') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Missed Followup List </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('todayFollowups') ? 'active' : null }}">
                            <a href="{{ route('todayFollowups') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Today's Followup List </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('noactivity') ? 'active' : null }}">
                            <a href="{{ route('noactivity') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">No Activity List </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan
            @can('client-view')
                <li class="pcoded-hasmenu {{ request()->routeIs('clients.*') ? 'active pcoded-trigger' : null }}">
                    <a href="javascript:void(0)">
                        <span class="pcoded-micon"><i class="far fa-handshake"></i><b>BC</b></span>
                        <span class="pcoded-mtext">Clients</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">
                        @can('client-create')
                            <li class="{{ request()->routeIs('clients.create') ? 'active' : null }}">
                                <a href="{{ route('clients.create') }}">
                                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                    <span class="pcoded-mtext">New Client </span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
                        @endcan
                        <li class="{{ request()->routeIs('clients.index') ? 'active' : null }}">
                            <a href="{{ route('clients.index') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Client List </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan

            @can('sell-view')
                <li
                    class="pcoded-hasmenu {{ request()->routeIs(['sells.*', 'apartment-handovers.*']) ? 'active pcoded-trigger' : null }}">
                    <a href="javascript:void(0)">
                        <span class="pcoded-micon"><i class="far fa-handshake"></i><b>BC</b></span>
                        <span class="pcoded-mtext">Sales</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">
                        @can('sell-create')
                            <li class="{{ request()->routeIs('sells.create') ? 'active' : null }}">
                                <a href="{{ route('sells.create') }}">
                                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                    <span class="pcoded-mtext">New Sale </span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
                        @endcan
                        <li class="{{ request()->routeIs('sells.index') ? 'active' : null }}">
                            <a href="{{ route('sells.index') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Sales List </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('apartment-handovers.index') ? 'active' : null }}">
                            <a href="{{ route('apartment-handovers.index') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Handover List </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan

            @can('salesCollection-view')
                <li
                    class="pcoded-hasmenu {{ request()->routeIs('salesCollections.*', 'salesCollectionApprovals.*') ? 'active pcoded-trigger' : null }}">
                    <a href="javascript:void(0)">
                        <span class="pcoded-micon"><i class="fas fa-hand-holding-usd"></i><b>BC</b></span>
                        <span class="pcoded-mtext">Sales Collections</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">
                        @can('salesCollection-create')
                            <li class="{{ request()->routeIs('salesCollections.create') ? 'active' : null }}">
                                <a href="{{ route('salesCollections.create') }}">
                                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                    <span class="pcoded-mtext">New Collection </span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
                        @endcan
                        <li class="{{ request()->routeIs('salesCollections.index') ? 'active' : null }}">
                            <a href="{{ route('salesCollections.index') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Collection List </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('salesCollectionApprovals.index') ? 'active' : null }}">
                            <a href="{{ route('salesCollectionApprovals.index') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Sales Collection Approval List </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan

            @can('sale-cancellation-view')
                <li
                    class="pcoded-hasmenu {{ request()->routeIs('saleCancellations.*') ? 'active pcoded-trigger' : null }}">
                    <a href="javascript:void(0)">
                        <span class="pcoded-micon"><i class="fas fa-user-times"></i><b>BC</b></span>
                        <span class="pcoded-mtext">Sale Cancellation</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">
                        @can('sale-cancellation-create')
                            <li class="{{ request()->routeIs('saleCancellations.create') ? 'active' : null }}">
                                <a href="{{ route('saleCancellations.create') }}">
                                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                    <span class="pcoded-mtext">New Cancellation </span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
                        @endcan
                        <li class="{{ request()->routeIs('saleCancellations.index') ? 'active' : null }}">
                            <a href="{{ route('saleCancellations.index') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Sale Cancellations</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan
            @can('name-transfer-view')
                <li class="pcoded-hasmenu {{ request()->routeIs('name-transfers.*') ? 'active pcoded-trigger' : null }}">
                    <a href="javascript:void(0)">
                        <span class="pcoded-micon"><i class="fas fa-hand-holding-usd"></i><b>BC</b></span>
                        <span class="pcoded-mtext">Name Transfer</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">
                        @can('name-transfer-create')
                            <li class="{{ request()->routeIs('name-transfers.create') ? 'active' : null }}">
                                <a href="{{ route('name-transfers.create') }}">
                                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                    <span class="pcoded-mtext">Name Transfer </span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
                        @endcan
                        <li class="{{ request()->routeIs('name-transfers.index') ? 'active' : null }}">
                            <a href="{{ route('name-transfers.index') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Name Transfer List </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan
            @can('apartment-shifting-view')
                <li
                    class="pcoded-hasmenu {{ request()->routeIs('apartment-shiftings.*') ? 'active pcoded-trigger' : null }}">
                    <a href="javascript:void(0)">
                        <span class="pcoded-micon"><i class="fas fa-hand-holding-usd"></i><b>BC</b></span>
                        <span class="pcoded-mtext">Apartment Shifting</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">
                        @can('apartment-shifting-create')
                            <li class="{{ request()->routeIs('apartment-shiftings.create') ? 'active' : null }}">
                                <a href="{{ route('apartment-shiftings.create') }}">
                                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                    <span class="pcoded-mtext">New Aparment Shifting</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
                        @endcan
                        <li class="{{ request()->routeIs('apartment-shiftings.index') ? 'active' : null }}">
                            <a href="{{ route('apartment-shiftings.index') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Aparment Shifting List </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan
            @can('final-settlement-view')
                <li
                    class="pcoded-hasmenu {{ request()->routeIs(['final-settlements.*']) ? 'active pcoded-trigger' : null }}">
                    <a href="javascript:void(0)">
                        <span class="pcoded-micon"><i class="fas fa-hand-holding-usd"></i><b>BC</b></span>
                        <span class="pcoded-mtext">Final Settlement</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">
                        @can('final-settlement-create')
                            <li class="{{ request()->routeIs('final-settlements.create') ? 'active' : null }}">
                                <a href="{{ route('final-settlements.create') }}">
                                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                    <span class="pcoded-mtext">New Settlement </span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
                        @endcan
                        <li class="{{ request()->routeIs('final-settlements.index') ? 'active' : null }}">
                            <a href="{{ route('final-settlements.index') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Final Settlement List </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan
            @can('budget-view')
                <li
                    class="pcoded-hasmenu {{ request()->routeIs(['sales-yearly-budgets.*', 'collection-yearly-budgets.*']) ? 'active pcoded-trigger' : null }}">
                    <a href="javascript:void(0)">
                        <span class="pcoded-micon"><i class="fas fa-hand-holding-usd"></i><b>BC</b></span>
                        <span class="pcoded-mtext">Budget</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">
                        @can('sales-yearly-budget-create')
                            <li class="{{ request()->routeIs('sales-yearly-budgets.create') ? 'active' : null }}">
                                <a href="{{ route('sales-yearly-budgets.create') }}">
                                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                    <span class="pcoded-mtext">Sales Yearly Plan</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
                        @endcan
                        @can('sales-yearly-budget-view')
                            <li class="{{ request()->routeIs('sales-yearly-budgets.index') ? 'active' : null }}">
                                <a href="{{ route('sales-yearly-budgets.index') }}">
                                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                    <span class="pcoded-mtext">Sales Yearly Plan List </span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
                        @endcan
                        @can('collection-yearly-budget-create')
                            <li class="{{ request()->routeIs('collection-yearly-budgets.create') ? 'active' : null }}">
                                <a href="{{ route('collection-yearly-budgets.create') }}">
                                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                    <span class="pcoded-mtext">Revenue Collection Plan</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
                        @endcan
                        @can('collection-yearly-budget-view')
                            <li class="{{ request()->routeIs('collection-yearly-budgets.index') ? 'active' : null }}">
                                <a href="{{ route('collection-yearly-budgets.index') }}">
                                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                    <span class="pcoded-mtext">Revenue Collection List </span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan
            @can('sales-report')
                <li
                    class="pcoded-hasmenu {{ request()->routeIs([
                        'inventoryreport',
                        'projectsreport',
                        'finalsettlementreport',
                        'projectreport',
                        'collectionsreport',
                        'clientcollectionreport',
                        'revenueinflowreport',
                        'yearlycollectionreport',
                        'project-wise-lead-report',
                        'monthly-sales-report',
                        'yearly-quarterly-sales-report',
                        'category-wise-lead-generation-report',
                    ])
                        ? 'active pcoded-trigger'
                        : null }}">
                    <a href="javascript:void(0)">
                        <span class="pcoded-micon"><i class="ti-files"></i><b>BC</b></span>
                        <span class="pcoded-mtext">Reports</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="{{ request()->routeIs('inventoryreport') ? 'active' : null }}">
                            <a href="{{ route('inventoryreport') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Projects Inventory </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('projectsreport') ? 'active' : null }}">
                            <a href="{{ route('projectsreport') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Projects Details Summary </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('projectreport') ? 'active' : null }}">
                            <a href="{{ route('projectreport') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Sales & Revenue Register </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('collectionsreport') ? 'active' : null }}">
                            <a href="{{ route('collectionsreport') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Collections Register </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('clientcollectionreport') ? 'active' : null }}">
                            <a href="{{ route('clientcollectionreport') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Individual Collection Report </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('revenueinflowreport') ? 'active' : null }}">
                            <a href="{{ route('revenueinflowreport') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Revenue Inflow Report</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('finalsettlementreport') ? 'active' : null }}">
                            <a href="{{ route('finalsettlementreport') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext"> Final Settlement Report </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('yearly-sales-plan-report') ? 'active' : null }}">
                            <a href="{{ route('yearly-sales-plan-report') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Yearly Sales Plan Report </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('yearlycollectionreport') ? 'active' : null }}">
                            <a href="{{ route('yearlycollectionreport') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Yearly Collection Report </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('yearlycollectionreport') ? 'active' : null }}">
                            <a href="{{ route('yearly-collection-plan-report') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Yearly Revenue Plan </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('project-wise-lead-report') ? 'active' : null }}">
                            <a href="{{ route('project-wise-lead-report') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Project Wise Categorise Report </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('monthly-sales-report') ? 'active' : null }}">
                            <a href="{{ route('monthly-sales-report') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Monthly Sales Report</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('yearly-quarterly-sales-report') ? 'active' : null }}">
                            <a href="{{ route('yearly-quarterly-sales-report') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Yearly Sales Report </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('category-wise-lead-generation-report') ? 'active' : null }}">
                            <a href="{{ route('category-wise-lead-generation-report') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Category wise Monthly Report </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>

                    </ul>
                </li>
            @endcan
        </ul>
        {{--        @endhasanyrole --}}
        <!-- BOQ -->
        @canany(['boq-configuration', 'boq-configuration', 'boqSupremeBudgets-view'])
            <div class="pcoded-navigation-label text-uppercase bg-primary"> BOQ </div>
        @endcanany
        <ul class="pcoded-item pcoded-left-item">
            <!-- Configurations -->
            @can('boq-configuration')
                <li
                    class="pcoded-hasmenu {{ request()->routeIs('boq.configurations.*') ? 'active pcoded-trigger' : null }}">
                    <a href="javascript:void(0)">
                        <span class="pcoded-micon"><i class="ti-layers"></i></span>
                        <span class="pcoded-mtext"> Configurations </span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li
                            class="{{ request()->routeIs('boq.configurations.floors.*') ? 'active pcoded-trigger' : null }}">
                            <a href="{{ route('boq.configurations.floors.index') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext"> Floors </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li
                            class="{{ request()->routeIs('boq.configurations.floor-type-work.*') ? 'active pcoded-trigger' : null }}">
                            <a href="{{ route('boq.configurations.floor-type-work.index') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext"> Work Floor Type </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan
            <!-- Select project -->
            @can('boq-configuration')
                <li class="{{ request()->routeIs(['boq.select_project']) ? 'active pcoded-trigger' : null }}">
                    <a href="{{ route('boq.select_project') }}">
                        <span class="pcoded-micon"><i class="ti-list"></i><b>P</b></span>
                        <span class="pcoded-mtext">Projects list</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                    {{-- <ul class="pcoded-submenu">
                        <li class="{{ request()->routeIs('boq.select_project') ? 'active' : null }}"><a
                                href="{{ route('boq.select_project') }}"><span class="pcoded-micon"><i
                                        class="icon-pie-chart"></i></span><span class="pcoded-mtext"> Project List
                                </span><span class="pcoded-mcaret"></span></a></li>
                    </ul> --}}
                </li>
            @endcan

            @can('boq-budget-list')
                <li class=" {{ request()->routeIs(['boq.budget-list']) ? 'active pcoded-trigger' : null }}">
                    <a href="{{ route('boq.budget-list') }}">
                        <span class="pcoded-micon"><i class="ti-list"></i><b>P</b></span>
                        <span class="pcoded-mtext"> Budget List</span>
                        {{-- <span class="pcoded-mcaret"></span> --}}
                    </a>
                </li>
            @endcan

            {{-- @can('boqSupremeBudgets-view')
                <li
                    class="pcoded-hasmenu {{ request()->routeIs('boqSupremeBudgets.*') ? 'active pcoded-trigger' : null }}">
                    <a href="javascript:void(0)">
                        <span class="pcoded-micon"><i class="fas fa-search-dollar"></i><b>BC</b></span>
                        <span class="pcoded-mtext">Existing Budget List</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">
                        @can('boqSupremeBudgets-create')
                            <li class="{{ request()->routeIs('boqSupremeBudgets.create') ? 'active' : null }}">
                                <a href="{{ route('boqSupremeBudgets.create') }}">
                                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                    <span class="pcoded-mtext">Add Existing Budget </span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
                        @endcan
                        <li class="{{ request()->routeIs('boqSupremeBudgets.index') ? 'active' : null }}">
                            <a href="{{ url('supreme-budget-list/Civil') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Budget List (Civil)</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('boqSupremeBudgets.index') ? 'active' : null }}">
                            <a href="{{ url('supreme-budget-list/Sanitary') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Budget List (Sanitary)</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('boqSupremeBudgets.index') ? 'active' : null }}">
                            <a href="{{ url('supreme-budget-list/Eme') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Budget List (EME)</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan --}}

            <li
                class="pcoded-hasmenu {{ request()->routeIs('boq.MaterialServincing.*') ? 'active pcoded-trigger' : null }}">
                <a href="javascript:void(0)">
                    <span class="pcoded-micon"><i class="fas fa-search-dollar"></i><b>BC</b></span>
                    <span class="pcoded-mtext">Material Servicing</span>
                    <span class="pcoded-mcaret"></span>
                </a>
                <ul class="pcoded-submenu">
                    <li class="{{ request()->routeIs('boq.MaterialServincing.create') ? 'active' : null }}">
                        <a href="{{ route('boq.MaterialServincing.create') }}">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext">New Servicing </span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                    <li class="{{ request()->routeIs('boq.MaterialServincing.index') ? 'active' : null }}">
                        <a href="{{ route('boq.MaterialServincing.index') }}">
                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                            <span class="pcoded-mtext">Servicing List</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                </ul>
            </li>

        </ul>
        @canany(['supplier-view', 'nestedmaterial-view', 'requisition-view', 'comparative-statement-view',
            'purchase-order-view', 'materialReceiv-view', 'supplierbill-view', 'pending-bill', 'storeissue-view',
            'scm-material-budget-dashboard', 'vendors-outstanding-statement', 'iou-create', 'movement-requisitions-view',
            'materialmovement-view', 'movementIn-view', 'stock-reports'])
            <div class="pcoded-navigation-label text-uppercase bg-primary">Supply Chain</div>
        @endcanany
        <ul class="pcoded-item pcoded-left-item">

            @can('supplier-view')
                <li
                    class="pcoded-hasmenu {{ request()->routeIs(['units.*', 'materialcategories.*']) ? 'active pcoded-trigger' : null }}">
                    <a href="javascript:void(0)">
                        <span class="pcoded-micon"><i class="ti-settings"></i><b>P</b></span>
                        <span class="pcoded-mtext">Configurations</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="{{ request()->routeIs('units.*') ? 'active' : null }}"><a
                                href="{{ route('units.index') }}"><span class="pcoded-micon"><i
                                        class="icon-pie-chart"></i></span><span class="pcoded-mtext"> Units </span><span
                                    class="pcoded-mcaret"></span></a></li>
                        {{-- <li class="{{ request()->routeIs('materialcategories.*') ? 'active' : null }}"><a href="{{ route('materialcategories.index') }}"><span class="pcoded-micon"><i class="icon-pie-chart"></i></span><span class="pcoded-mtext"> Material Categories </span><span class="pcoded-mcaret"></span></a></li> --}}
                        {{-- <li class="pcoded-hasmenu {{ request()->routeIs('warehouses.*') ? 'active pcoded-trigger' : null }}">
                    <a href="javascript:void(0)">
                        <span class="pcoded-micon"><i class="fas fa-store"></i><b>BC</b></span>
                        <span class="pcoded-mtext">Warehouses</span>
                        <span class="pcoded-mcaret"></span>
                    </a>

                </li> --}}

                        @can('nestedmaterial-view')
                            <li
                                class="pcoded-hasmenu {{ request()->routeIs('nestedmaterials.*') ? 'active pcoded-trigger' : null }}">
                                <a href="javascript:void(0)">
                                    <span class="pcoded-micon"><i class="fas fa-cubes"></i><b>BC</b></span>
                                    <span class="pcoded-mtext">Materials</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                                <ul class="pcoded-submenu">
                                    <li class="{{ request()->routeIs('nestedmaterials.create') ? 'active' : null }}">
                                        <a href="{{ route('nestedmaterials.create') }}">
                                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                            <span class="pcoded-mtext">New Material </span>
                                            <span class="pcoded-mcaret"></span>
                                        </a>
                                    </li>
                                    <li class="{{ request()->routeIs('nestedmaterials.index') ? 'active' : null }}">
                                        <a href="{{ route('nestedmaterials.index') }}">
                                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                            <span class="pcoded-mtext">Material List </span>
                                            <span class="pcoded-mcaret"></span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endcan
                        <li
                            class="pcoded-hasmenu {{ request()->routeIs('opening-material.*') ? 'active pcoded-trigger' : null }}">
                            <a href="javascript:void(0)">
                                <span class="pcoded-micon"><i class="fas fa-cubes"></i><b>BC</b></span>
                                <span class="pcoded-mtext">Opening Materials</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                            <ul class="pcoded-submenu">
                                <li class="{{ request()->routeIs('opening-material.create') ? 'active' : null }}">
                                    <a href="{{ route('opening-material.create') }}">
                                        <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                        <span class="pcoded-mtext">New Opening Material </span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>
                                <li class="{{ request()->routeIs('opening-material.index') ? 'active' : null }}">
                                    <a href="{{ route('opening-material.index') }}">
                                        <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                        <span class="pcoded-mtext">Opening Material List </span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li
                            class="pcoded-hasmenu {{ request()->routeIs('suppliers.*') ? 'active pcoded-trigger' : null }}">
                            <a href="javascript:void(0)">
                                <span class="pcoded-micon"><i class="fas fa-address-book"></i><b>BC</b></span>
                                <span class="pcoded-mtext">Suppliers</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                            <ul class="pcoded-submenu">
                                <li class="{{ request()->routeIs('suppliers.create') ? 'active' : null }}">
                                    <a href="{{ route('suppliers.create') }}">
                                        <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                        <span class="pcoded-mtext">Add New Supplier</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>
                                <li class="{{ request()->routeIs('suppliers.index') ? 'active' : null }}">
                                    <a href="{{ route('suppliers.index') }}">
                                        <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                        <span class="pcoded-mtext">Suppliers List </span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>

                            </ul>
                        </li>
                    </ul>
                </li>
            @endcan

            @can('requisition-view')
                <li class="pcoded-hasmenu {{ request()->routeIs('requisitions.*') ? 'active pcoded-trigger' : null }}">
                    <a href="javascript:void(0)">
                        <span class="pcoded-micon"><i class="fas fa-cart-plus"></i><b>BC</b></span>
                        <span class="pcoded-mtext">Requisitions</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="{{ request()->routeIs('requisitions.create') ? 'active' : null }}">
                            <a href="{{ route('requisitions.create') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">New Requisition </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('requisitions.index') ? 'active' : null }}">
                            <a href="{{ route('requisitions.index') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Requisitions List </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan

            @can('comparative-statement-view')
                <li
                    class="pcoded-hasmenu {{ request()->routeIs('comparative-statements.*') ? 'active pcoded-trigger' : null }}">
                    <a href="javascript:void(0)">
                        <span class="pcoded-micon"><i class="fas fa-sitemap"></i><b>BC</b></span>
                        <span class="pcoded-mtext">C. Statements</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">
                        @can('comparative-statement-create')
                            <li class="{{ request()->routeIs('comparative-statements.create') ? 'active' : null }}">
                                <a href="{{ route('comparative-statements.create') }}">
                                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                    <span class="pcoded-mtext">New CS </span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
                        @endcan
                        <li class="{{ request()->routeIs('comparative-statements.index') ? 'active' : null }}">
                            <a href="{{ route('comparative-statements.index') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">CS List </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan
            @can('purchase-order-view')
                <li
                    class="pcoded-hasmenu {{ request()->routeIs('purchaseOrders.*') ? 'active pcoded-trigger' : null }}">
                    <a href="javascript:void(0)">
                        <span class="pcoded-micon"><i class="fas fa-file-signature"></i><b>BC</b></span>
                        <span class="pcoded-mtext">Purchase Orders</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">
                        @can('purchase-order-create')
                            <li class="{{ request()->routeIs('purchaseOrders.create') ? 'active' : null }}">
                                <a href="{{ route('purchaseOrders.create') }}">
                                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                    <span class="pcoded-mtext">New Order </span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
                        @endcan
                        <li class="{{ request()->routeIs('purchaseOrders.index') ? 'active' : null }}">
                            <a href="{{ route('purchaseOrders.index') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Orders List </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan

            @can('materialReceiv-view')
                <li
                    class="pcoded-hasmenu {{ request()->routeIs('materialReceives.*') ? 'active pcoded-trigger' : null }}">
                    <a href="javascript:void(0)">
                        <span class="pcoded-micon"><i class="fas fa-hand-holding-water"></i><b>BC</b></span>
                        <span class="pcoded-mtext">Material Receive </span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="{{ request()->routeIs('materialReceives.create') ? 'active' : null }}">
                            <a href="{{ route('materialReceives.create') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">New Material Receive </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('materialReceives.index') ? 'active' : null }}">
                            <a href="{{ route('materialReceives.index') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Material Receive List </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan

            @can('supplierbill-view')
                <li
                    class="pcoded-hasmenu {{ request()->routeIs('supplierbills.*', 'requestedSupplierbills') ? 'active pcoded-trigger' : null }}">
                    <a href="javascript:void(0)">
                        <span class="pcoded-micon"><i class="fas fa-cart-plus"></i><b>BC</b></span>
                        <span class="pcoded-mtext">Supplier Bill</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">
                        @can('supplierbill-create')
                            <li class="{{ request()->routeIs('supplierbills.create') ? 'active' : null }}">
                                <a href="{{ route('supplierbills.create') }}">
                                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                    <span class="pcoded-mtext">New Supplier Bill </span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
                        @endcan
                        <li class="{{ request()->routeIs('supplierbills.index') ? 'active' : null }}">
                            <a href="{{ route('supplierbills.index') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Supplier Bill List </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('requestedSupplierbills') ? 'active' : null }}">
                            <a href="{{ route('requestedSupplierbills') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Requested Suppliers List </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan

            @can('storeissue-view')
                <li class="pcoded-hasmenu {{ request()->routeIs('storeissues.*') ? 'active pcoded-trigger' : null }}">
                    <a href="javascript:void(0)">
                        <span class="pcoded-micon"><i class="fas fa-shipping-fast"></i><b>BC</b></span>
                        <span class="pcoded-mtext">Store Issue </span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="{{ request()->routeIs('storeissues.create') ? 'active' : null }}">
                            <a href="{{ route('storeissues.create') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">New Store Issue Note </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('storeissues.index') ? 'active' : null }}">
                            <a href="{{ route('storeissues.index') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Store Issue Note List </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan

            @can('movement-requisitions-view')
                <li
                    class="pcoded-hasmenu {{ request()->routeIs('movement-requisitions.*') ? 'active pcoded-trigger' : null }}">
                    <a href="javascript:void(0)">
                        <span class="pcoded-micon"><i class="fas fa-shipping-fast"></i><b>BC</b></span>
                        <span class="pcoded-mtext"> Movements Requisition </span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="{{ request()->routeIs('movement-requisitions.create') ? 'active' : null }}">
                            <a href="{{ route('movement-requisitions.create') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Add Movement Requisition </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>

                        <li class="{{ request()->routeIs('movement-requisitions.index') ? 'active' : null }}">
                            <a href="{{ route('movement-requisitions.index') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext"> Movement Requisition List </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan

            @can('materialmovement-view')
                <li
                    class="pcoded-hasmenu {{ request()->routeIs('materialmovements.*') ? 'active pcoded-trigger' : null }}">
                    <a href="javascript:void(0)">
                        <span class="pcoded-micon"><i class="fas fa-shipping-fast"></i><b>BC</b></span>
                        <span class="pcoded-mtext"> Movements (OUT) </span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="{{ request()->routeIs('materialmovements.create') ? 'active' : null }}">
                            <a href="{{ route('materialmovements.create') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Add Movements (OUT)</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>

                        <li class="{{ request()->routeIs('materialmovements.index') ? 'active' : null }}">
                            <a href="{{ route('materialmovements.index') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Movements (OUT) List </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan

            @can('movementIn-view')
                <li class="pcoded-hasmenu {{ request()->routeIs('movement-ins.*') ? 'active pcoded-trigger' : null }}">
                    <a href="javascript:void(0)">
                        <span class="pcoded-micon"><i class="fas fa-shipping-fast"></i><b>BC</b></span>
                        <span class="pcoded-mtext"> Movements (IN) </span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="{{ request()->routeIs('movement-ins.create') ? 'active' : null }}">
                            <a href="{{ route('movement-ins.create') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Add Movements (IN) </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>

                        <li class="{{ request()->routeIs('movement-ins.index') ? 'active' : null }}">
                            <a href="{{ route('movement-ins.index') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Movements (IN) List </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan
            @can('scm-material-budget-dashboard')
                <li class="{{ request()->routeIs('scm-material-budget-year-List') ? 'active' : null }}">
                    <a href="{{ route('scm-material-budget-year-List') }}">
                        <span class="pcoded-micon"><i class="fas fa-scroll"></i></span>
                        <span class="pcoded-mtext">Material Budgets</span>
                    </a>
                </li>
            @endcan
            @can('masterrole-view')
                <li
                    class="pcoded-hasmenu {{ request()->routeIs('icmdLaborBudget.*') ? 'active pcoded-trigger' : null }}">
                    <a href="javascript:void(0)">
                        <span class="pcoded-micon"><i class="fas fa-shipping-fast"></i><b>BC</b></span>
                        <span class="pcoded-mtext">Master Role</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="{{ request()->routeIs('icmdLaborBudget.create') ? 'active' : null }}">
                            <a href="{{ route('icmdLaborBudget.create') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Add</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>

                        <li class="{{ request()->routeIs('icmdLaborBudget.index') ? 'active' : null }}">
                            <a href="{{ route('icmdLaborBudget.index') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">List</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan
            @can('stock-reports')
                <li
                    class="pcoded-hasmenu {{ request()->routeIs(['mir-costcenter-List', 'mir-year-List', 'mir-month-List', 'mir-get-report', 'costcenter_List', 'get_material', 'get_material_ledger']) ? 'active pcoded-trigger' : null }}">
                    <a href="javascript:void(0)">
                        <span class="pcoded-micon"><i class="fas fa-shipping-fast"></i><b>BC</b></span>
                        <span class="pcoded-mtext">Reports </span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="{{ request()->routeIs('mir-costcenter-List') ? 'active' : null }}">
                            <a href="{{ route('mir-costcenter-List') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Material Inventory Report </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('costcenter_List') ? 'active' : null }}">
                            <a href="{{ route('costcenter_List') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Material Ledger </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('floor-wise-consumption') ? 'active' : null }}">
                            <a href="{{ route('floor-wise-consumption') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Floor Wise Consumption </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        @can('vendors-outstanding-statement')
                            <li class="{{ request()->routeIs('vendors_outstanding_statement') ? 'active' : null }}">
                                <a href="{{ route('vendors_outstanding_statement') }}">
                                    <span class="pcoded-micon"><i class="fas fa-scroll"></i></span>
                                    <span class="pcoded-mtext">Vendor's Outstanding</span>
                                </a>
                            </li>
                        @endcan
                        @can('pending-bill')
                            <li class="{{ request()->routeIs('pending-bills') ? 'active' : null }}">
                                <a href="{{ route('pending-bills') }}">
                                    <span class="pcoded-micon"><i class="fas fa-scroll"></i></span>
                                    <span class="pcoded-mtext">Pending Bills</span>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan
        </ul>
        @canany(['boq-eme-load-calculation', 'boq-eme-labor-rate-view', 'boq-eme-utility-bill-view',
            'boq-eme-work-cs-view', 'boq-eme-work-order-view', 'boq-eme-construction-bill-view'])
            <div class="pcoded-navigation-label text-uppercase bg-primary">Eme</div>
        @endcanany
        <ul class="pcoded-item pcoded-left-item">
            @can('boq-eme-load-calculation')
                <li
                    class="pcoded-hasmenu {{ request()->routeIs('eme.load_calculations.*,eme.eme_projects') ? 'active pcoded-trigger' : null }}">
                    <a href="javascript:void(0)">
                        <span class="pcoded-micon"><i class="fas fa-calculator"></i><b></b></span>
                        <span class="pcoded-mtext">Load Calculations</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li
                            class="{{ request()->routeIs('eme.load_calculations.create') ? 'active pcoded-trigger' : null }}">
                            <a href="{{ route('eme.load_calculations.create') }}">
                                <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                                <span class="pcoded-mtext">Create</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('eme.eme_projects') ? 'active pcoded-trigger' : null }}">
                            <a href="{{ route('eme.eme_projects') }}">
                                <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                                <span class="pcoded-mtext">index</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan
            @can('boq-eme-labor-rate-view')
                <li
                    class="pcoded-hasmenu {{ request()->routeIs('eme.labor_rate.*') ? 'active pcoded-trigger' : null }}">
                    <a href="javascript:void(0)">
                        <span class="pcoded-micon"><i class="fas fa-calculator"></i><b></b></span>
                        <span class="pcoded-mtext">Labor Rate</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="{{ request()->routeIs('eme.labor_rate.create') ? 'active pcoded-trigger' : null }}">
                            <a href="{{ route('eme.labor_rate.create') }}">
                                <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                                <span class="pcoded-mtext">Create</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('eme.labor_rate.index') ? 'active pcoded-trigger' : null }}">
                            <a href="{{ route('eme.labor_rate.index') }}">
                                <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                                <span class="pcoded-mtext">index</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan
            @can('boq-eme-utility-bill-view')
                <li
                    class="pcoded-hasmenu {{ request()->routeIs(['eme.utility_bill.*']) ? 'active pcoded-trigger' : null }}">
                    <a href="javascript:void(0)">
                        <span class="pcoded-micon"><i class="ti-settings"></i><b>P</b></span>
                        <span class="pcoded-mtext">Utility Bill</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="{{ request()->routeIs('csd.utility_bill.*') ? 'active' : null }}"><a
                                href="{{ route('eme.utility_bill.index') }}"><span class="pcoded-micon"><i
                                        class="icon-pie-chart"></i></span><span class="pcoded-mtext"> List
                                </span><span class="pcoded-mcaret"></span></a></li>
                        <li class="{{ request()->routeIs('eme.utility_bill.*') ? 'active' : null }}"><a
                                href="{{ route('eme.utility_bill.create') }}"><span class="pcoded-micon"><i
                                        class="icon-pie-chart"></i></span><span class="pcoded-mtext"> New
                                </span><span class="pcoded-mcaret"></span></a></li>
                    </ul>
                </li>
            @endcan
            @can('boq-eme-work-cs-view')
                <li class="pcoded-hasmenu {{ request()->routeIs('eme.work_cs.*') ? 'active pcoded-trigger' : null }}">
                    <a href="javascript:void(0)">
                        <span class="pcoded-micon"><i class="fas fa-calculator"></i><b></b></span>
                        <span class="pcoded-mtext">Work C.S.</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="{{ request()->routeIs('eme.work_cs.create') ? 'active pcoded-trigger' : null }}">
                            <a href="{{ route('eme.work_cs.create') }}">
                                <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                                <span class="pcoded-mtext">Create</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('eme.work_cs.index') ? 'active pcoded-trigger' : null }}">
                            <a href="{{ route('eme.work_cs.index') }}">
                                <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                                <span class="pcoded-mtext">index</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan
            @can('boq-eme-work-order-view')
                <li
                    class="pcoded-hasmenu {{ request()->routeIs('eme.work_order.*') ? 'active pcoded-trigger' : null }}">
                    <a href="javascript:void(0)">
                        <span class="pcoded-micon"><i class="fas fa-calculator"></i><b></b></span>
                        <span class="pcoded-mtext">Work Order</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="{{ request()->routeIs('eme.work_order.create') ? 'active pcoded-trigger' : null }}">
                            <a href="{{ route('eme.work_order.create') }}">
                                <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                                <span class="pcoded-mtext">Create</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('eme.work_order.index') ? 'active pcoded-trigger' : null }}">
                            <a href="{{ route('eme.work_order.index') }}">
                                <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                                <span class="pcoded-mtext">index</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan
            @can('boq-eme-construction-bill-view')
                <li class="pcoded-hasmenu {{ request()->routeIs('eme.bills.*') ? 'active pcoded-trigger' : null }}">
                    <a href="javascript:void(0)">
                        <span class="pcoded-micon"><i class="fas fa-calculator"></i><b></b></span>
                        <span class="pcoded-mtext">Bill</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="{{ request()->routeIs('eme.bills.create') ? 'active pcoded-trigger' : null }}">
                            <a href="{{ route('eme.bills.create') }}">
                                <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                                <span class="pcoded-mtext">Create</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('eme.bills.index') ? 'active pcoded-trigger' : null }}">
                            <a href="{{ route('eme.bills.index') }}">
                                <span class="pcoded-micon"><i class="icon-pie-chart"></i></span>
                                <span class="pcoded-mtext">index</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan
        </ul>
        @canany(['csd-material-view', 'construction-action-plan-view', 'construction-material-plan-view',
            'work-cs-view', 'work-order-view', 'construction-bill-view', 'construction-tentative-budget-view',
            'construction-cost-incurred-report-view', 'construction-project-progress-report-view',
            'csd-final-costing-view'])
            <div class="pcoded-navigation-label text-uppercase bg-primary">Constructions</div>
        @endcanany

        <ul class="pcoded-item pcoded-left-item">

            @can('csd-material-view')
                <li
                    class="pcoded-hasmenu {{ request()->routeIs(['csd.materials.*', 'csd.material_rate.*', 'bill-title.*']) ? 'active pcoded-trigger' : null }}">
                    <a href="javascript:void(0)">
                        <span class="pcoded-micon"><i class="ti-settings"></i><b>P</b></span>
                        <span class="pcoded-mtext">Configurations</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="{{ request()->routeIs('csd.materials.*') ? 'active' : null }}"><a
                                href="{{ route('csd.materials.index') }}"><span class="pcoded-micon"><i
                                        class="icon-pie-chart"></i></span><span class="pcoded-mtext"> Materials
                                </span><span class="pcoded-mcaret"></span></a></li>
                        <li class="{{ request()->routeIs('csd.material_rate.*') ? 'active' : null }}"><a
                                href="{{ route('csd.material_rate.index') }}"><span class="pcoded-micon"><i
                                        class="icon-pie-chart"></i></span><span class="pcoded-mtext"> Material Rate
                                </span><span class="pcoded-mcaret"></span></a></li>
                        <li class="{{ request()->routeIs('bill-title.*') ? 'active' : null }}"><a
                                href="{{ route('bill-title.index') }}"><span class="pcoded-micon"><i
                                        class="icon-pie-chart"></i></span><span class="pcoded-mtext"> Bill Title
                                </span><span class="pcoded-mcaret"></span></a></li>
                    </ul>
                </li>
            @endcan

            @can('construction-material-plan-view')
                <li
                    class="pcoded-hasmenu {{ request()->routeIs('construction.work_plan.*') ? 'active pcoded-trigger' : null }}">
                    <a href="javascript:void(0)">
                        <span class="pcoded-micon"><i class="fas fa-sitemap"></i><b>BC</b></span>
                        <span class="pcoded-mtext">Action Plan</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="{{ request()->routeIs('construction.work_plan.create') ? 'active' : null }}">
                            <a href="{{ route('construction.work_plan.create') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Create Action Plan</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('construction.work_plan.index') ? 'active' : null }}">
                            <a href="{{ route('construction.work_plan.index') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Action Plan List </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan
            @can('construction-action-plan-view')
                <li
                    class="pcoded-hasmenu {{ request()->routeIs('construction.material_plan.*') ? 'active pcoded-trigger' : null }}">
                    <a href="javascript:void(0)">
                        <span class="pcoded-micon"><i class="fas fa-cubes"></i><b>BC</b></span>
                        <span class="pcoded-mtext">Material Plan</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="{{ request()->routeIs('construction.material_plan.create') ? 'active' : null }}">
                            <a href="{{ route('construction.material_plan.create') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Create Material Plan</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('construction.material-plan-year-List') ? 'active' : null }}">
                            <a href="{{ route('construction.material-plan-year-List') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Material Plan List </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan
            @can('work-cs-view')
                <li class="pcoded-hasmenu {{ request()->routeIs('work-cs.*') ? 'active pcoded-trigger' : null }}">
                    <a href="javascript:void(0)">
                        <span class="pcoded-micon"><i class="fas fa-sitemap"></i><b>BC</b></span>
                        <span class="pcoded-mtext">Work CS</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="{{ request()->routeIs('work-cs.create') ? 'active' : null }}">
                            <a href="{{ route('work-cs.create') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Create Work CS</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('work-cs.index') ? 'active' : null }}">
                            <a href="{{ route('work-cs.index') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Work CS List </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan
            @can('work-order-view')
                <li class="pcoded-hasmenu {{ request()->routeIs('workorders.*') ? 'active pcoded-trigger' : null }}">
                    <a href="javascript:void(0)">
                        <span class="pcoded-micon"><i class="fas fa-paint-roller"></i><b>BC</b></span>
                        <span class="pcoded-mtext">Work Order</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="{{ request()->routeIs('workorders.create') ? 'active' : null }}">
                            <a href="{{ route('workorders.create') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Create Work Order</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('workorders.index') ? 'active' : null }}">
                            <a href="{{ route('workorders.index') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Work Order List </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan
            @can('construction-bill-view')
                <li
                    class="pcoded-hasmenu {{ request()->routeIs('construction-bills.*') ? 'active pcoded-trigger' : null }}">
                    <a href="javascript:void(0)">
                        <span class="pcoded-micon"><i class="fas fa-file-invoice-dollar"></i><b>BC</b></span>
                        <span class="pcoded-mtext">Construction Bills</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="{{ request()->routeIs('construction-bills.create') ? 'active' : null }}">
                            <a href="{{ route('construction-bills.create') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Create Bill</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('construction-bills.index') ? 'active' : null }}">
                            <a href="{{ route('construction-bills.index') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Bill List </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('construction.labour-budget-year-List') ? 'active' : null }}">
                            <a href="{{ route('construction.labour-budget-year-List') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Labor Budget</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan

            {{-- tentative budget START --}}
            @can('construction-tentative-budget-view')
                <li
                    class="pcoded-hasmenu {{ request()->routeIs('construction.tentative_budget.*') ? 'active pcoded-trigger' : null }}">
                    <a href="javascript:void(0)">
                        <span class="pcoded-micon"><i class="fas fa-sitemap"></i><b>BC</b></span>
                        <span class="pcoded-mtext">Tentative Budget</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="{{ request()->routeIs('construction.tentative_budget.create') ? 'active' : null }}">
                            <a href="{{ route('construction.tentative_budget.create') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Create Tentative Budget</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('construction.tentative-budget-list') ? 'active' : null }}">
                            <a href="{{ route('construction.tentative-budget-list') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Tentative Budget List </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan

            {{-- tentative budget END --}}

            @can('construction-tentative-budget-view')
                <li
                    class="pcoded-hasmenu {{ request()->routeIs('construction.monthly_progress_report.*') ? 'active pcoded-trigger' : null }}">
                    <a href="javascript:void(0)">
                        <span class="pcoded-micon"><i class="fas fa-sitemap"></i><b>BC</b></span>
                        <span class="pcoded-mtext">Progress Report</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li
                            class="{{ request()->routeIs('construction.monthly_progress_report.create') ? 'active' : null }}">
                            <a href="{{ route('construction.monthly_progress_report.create') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Create Report</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li
                            class="{{ request()->routeIs('construction.monthly_progress_report.index') ? 'active' : null }}">
                            <a href="{{ route('construction.monthly_progress_report.index') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Report List </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan
            @can(['construction-cost-incurred-report-view', 'construction-project-progress-report-view'])
                <li
                    class="pcoded-hasmenu {{ request()->routeIs(['construction.project-progress-report-year-list']) ? 'active pcoded-trigger' : null }}">
                    <a href="javascript:void(0)">
                        <span class="pcoded-micon"><i class="fas fa-shipping-fast"></i><b>BC</b></span>
                        <span class="pcoded-mtext">Reports </span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">
                        @can('construction-project-progress-report-view')
                            <li
                                class="{{ request()->routeIs('construction.project-progress-report-year-list') ? 'active' : null }}">
                                <a href="{{ route('construction.project-progress-report-year-list') }}">
                                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                    <span class="pcoded-mtext">Project Progress Report </span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
                        @endcan
                        @can('construction-cost-incurred-report-view')
                            <li class="{{ request()->routeIs('construction.cost-incurred-year-list') ? 'active' : null }}">
                                <a href="{{ route('construction.cost-incurred-year-list') }}">
                                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                    <span class="pcoded-mtext">Cost Incurred Report </span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>

            @endcan
            @can('csd-final-costing-view')
                <li class="pcoded-hasmenu {{ request()->routeIs('csd.costing.*') ? 'active pcoded-trigger' : null }}">
                    <a href="javascript:void(0)">
                        <span class="pcoded-micon"><i class="fas fa-sitemap"></i><b>BC</b></span>
                        <span class="pcoded-mtext">Final Costing</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="{{ request()->routeIs('csd.costing.create') ? 'active' : null }}">
                            <a href="{{ route('csd.costing.create') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Create Final Costing</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('csd.project-List') ? 'active' : null }}">
                            <a href="{{ route('csd.project-List') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Final Costing List </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="pcoded-hasmenu {{ request()->routeIs('csd.letter.*') ? 'active pcoded-trigger' : null }}">
                    <a href="javascript:void(0)">
                        <span class="pcoded-micon"><i class="fas fa-sitemap"></i><b>BC</b></span>
                        <span class="pcoded-mtext">Letters</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="{{ request()->routeIs('csd.letter.create') ? 'active' : null }}">
                            <a href="{{ route('csd.letter.create') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Create Letter</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('csd.letter.index') ? 'active' : null }}">
                            <a href="{{ route('csd.letter.index') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Letter List </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('csd.mail-records') ? 'active' : null }}">
                            <a href="{{ route('csd.mail-records') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Mail Records</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan
        </ul>
        @hasanyrole('super-admin|admin|Accounts-Manager')
            <div class="pcoded-navigation-label text-uppercase bg-primary">Accounts</div>
            <ul class="pcoded-item pcoded-left-item">
                <li
                    class="pcoded-hasmenu {{ request()->routeIs(['balance-and-income-lines.*', 'accounts.*', 'categories.*', 'subCategories.*', 'cashAccounts.*', 'bankAccounts.*', '']) ? 'active pcoded-trigger' : null }}">
                    <a href="javascript:void(0)"><span class="pcoded-micon"><i
                                class="ti-settings"></i><b>P</b></span><span
                            class="pcoded-mtext">Configurations</span><span class="pcoded-mcaret"></span></a>
                    <ul class="pcoded-submenu">

                        <li
                            class="pcoded-hasmenu {{ request()->routeIs('balance-and-income-lines.*') ? 'active pcoded-trigger' : null }}">
                            <a href="javascript:void(0)"><span class="pcoded-micon"><i
                                        class="ti-package"></i><b>BC</b></span><span class="pcoded-mtext">Balance Income
                                    Lines</span><span class="pcoded-mcaret"></span></a>
                            <ul class="pcoded-submenu">
                                <li
                                    class="{{ request()->routeIs('balance-and-income-lines.create') ? 'active' : null }}">
                                    <a href="{{ route('balance-and-income-lines.create') }}"><span
                                            class="pcoded-micon"><i class="ti-angle-right"></i></span><span
                                            class="pcoded-mtext"> Add Line</span><span class="pcoded-mcaret"></span></a>
                                </li>
                                <li
                                    class="{{ request()->routeIs('balance-and-income-lines.index') ? 'active' : null }}">
                                    <a href="{{ route('balance-and-income-lines.index') }}"><span
                                            class="pcoded-micon"><i class="ti-angle-right"></i></span><span
                                            class="pcoded-mtext">All Lines </span><span
                                            class="pcoded-mcaret"></span></a>
                                </li>
                            </ul>
                        </li>

                        <li
                            class="pcoded-hasmenu {{ request()->routeIs('accounts.*') ? 'active pcoded-trigger' : null }}">
                            <a href="javascript:void(0)"><span class="pcoded-micon"><i
                                        class="ti-package"></i><b>BC</b></span><span
                                    class="pcoded-mtext">Accounts</span><span class="pcoded-mcaret"></span></a>
                            <ul class="pcoded-submenu">
                                <li class="{{ request()->routeIs('accounts.create') ? 'active' : null }}">
                                    <a href="{{ route('accounts.create') }}"><span class="pcoded-micon"><i
                                                class="ti-angle-right"></i></span><span class="pcoded-mtext"> Add
                                            Account</span><span class="pcoded-mcaret"></span></a>
                                </li>
                                <li class="{{ request()->routeIs('accounts.index') ? 'active' : null }}">
                                    <a href="{{ route('accounts.index') }}"><span class="pcoded-micon"><i
                                                class="ti-angle-right"></i></span><span class="pcoded-mtext">All
                                            Accounts </span><span class="pcoded-mcaret"></span></a>
                                </li>
                                <li class="{{ request()->routeIs('account-list') ? 'active' : null }}">
                                    <a href="{{ route('account-list') }}"><span class="pcoded-micon"><i
                                                class="ti-angle-right"></i></span><span class="pcoded-mtext"> Accounts
                                            List Head Wise</span><span class="pcoded-mcaret"></span></a>
                                </li>
                            </ul>
                        </li>

                        <li
                            class="pcoded-hasmenu {{ request()->routeIs('account-opening-balances.*') ? 'active pcoded-trigger' : null }}">
                            <a href="javascript:void(0)"><span class="pcoded-micon"><i
                                        class="ti-package"></i><b>BC</b></span><span class="pcoded-mtext">Opening
                                    Balance</span><span class="pcoded-mcaret"></span></a>
                            <ul class="pcoded-submenu">
                                <li
                                    class="{{ request()->routeIs('account-opening-balances.create') ? 'active' : null }}">
                                    <a href="{{ route('account-opening-balances.create') }}"><span
                                            class="pcoded-micon"><i class="ti-angle-right"></i></span><span
                                            class="pcoded-mtext"> Opening Balance </span><span
                                            class="pcoded-mcaret"></span></a>
                                </li>
                                <li
                                    class="{{ request()->routeIs('account-opening-balances.index') ? 'active' : null }}">
                                    <a href="{{ route('account-opening-balances.index') }}"><span
                                            class="pcoded-micon"><i class="ti-angle-right"></i></span><span
                                            class="pcoded-mtext">Opening Balance List </span><span
                                            class="pcoded-mcaret"></span></a>
                                </li>
                            </ul>
                        </li>
                        <li
                            class="pcoded-hasmenu {{ request()->routeIs('cash-flow-lines.*') ? 'active pcoded-trigger' : null }}">
                            <a href="javascript:void(0)"><span class="pcoded-micon"><i
                                        class="ti-package"></i><b>BC</b></span><span class="pcoded-mtext">Cash Flow
                                    Lines</span><span class="pcoded-mcaret"></span></a>
                            <ul class="pcoded-submenu">
                                <li class="{{ request()->routeIs('cash-flow-lines.create') ? 'active' : null }}">
                                    <a href="{{ route('cash-flow-lines.create') }}"><span class="pcoded-micon"><i
                                                class="ti-angle-right"></i></span><span class="pcoded-mtext"> Add
                                            Line</span><span class="pcoded-mcaret"></span></a>
                                </li>
                                <li class="{{ request()->routeIs('cash-flow-lines.index') ? 'active' : null }}">
                                    <a href="{{ route('cash-flow-lines.index') }}"><span class="pcoded-micon"><i
                                                class="ti-angle-right"></i></span><span class="pcoded-mtext">All Lines
                                        </span><span class="pcoded-mcaret"></span></a>
                                </li>
                            </ul>
                        </li>
                        <li
                            class="pcoded-hasmenu {{ request()->routeIs('bankAccounts.*') ? 'active pcoded-trigger' : null }}">
                            <a href="javascript:void(0)"><span class="pcoded-micon"><i
                                        class="ti-package"></i><b>BC</b></span><span class="pcoded-mtext">Bank
                                    Accounts</span><span class="pcoded-mcaret"></span></a>
                            <ul class="pcoded-submenu">
                                <li class="{{ request()->routeIs('bankAccounts.create') ? 'active' : null }}">
                                    <a href="{{ route('bankAccounts.create') }}"><span class="pcoded-micon"><i
                                                class="ti-angle-right"></i></span><span class="pcoded-mtext">New Bank
                                            Account</span><span class="pcoded-mcaret"></span></a>
                                </li>
                                <li class="{{ request()->routeIs('bankAccounts.index') ? 'active' : null }}">
                                    <a href="{{ route('bankAccounts.index') }}"><span class="pcoded-micon"><i
                                                class="ti-angle-right"></i></span><span class="pcoded-mtext">Bank
                                            Accounts List </span><span class="pcoded-mcaret"></span></a>
                                </li>
                            </ul>
                        </li>
                        <li
                            class="pcoded-hasmenu {{ request()->routeIs('salary-heads.*') ? 'active pcoded-trigger' : null }}">
                            <a href="{{ route('salary-heads.create') }}"><span class="pcoded-micon"><i
                                        class="ti-package"></i><b>BC</b></span><span class="pcoded-mtext">Salary
                                    Heads</span><span class="pcoded-mcaret"></span></a>
                        </li>
                        <li
                            class="pcoded-hasmenu {{ request()->routeIs('cashAccounts.*') ? 'active pcoded-trigger' : null }}">
                            <a href="javascript:void(0)"><span class="pcoded-micon"><i
                                        class="ti-package"></i><b>BC</b></span><span class="pcoded-mtext">Cash
                                    Accounts</span><span class="pcoded-mcaret"></span></a>
                            <ul class="pcoded-submenu">
                                <li class="{{ request()->routeIs('cashAccounts.create') ? 'active' : null }}">
                                    <a href="{{ route('cashAccounts.create') }}"><span class="pcoded-micon"><i
                                                class="ti-angle-right"></i></span><span class="pcoded-mtext"> Cash
                                            Account</span><span class="pcoded-mcaret"></span></a>
                                </li>
                                <li class="{{ request()->routeIs('cashAccounts.index') ? 'active' : null }}">
                                    <a href="{{ route('cashAccounts.index') }}"><span class="pcoded-micon"><i
                                                class="ti-angle-right"></i></span><span class="pcoded-mtext"> Cash
                                            Account List </span><span class="pcoded-mcaret"></span></a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="pcoded-hasmenu {{ request()->routeIs('vouchers.*') ? 'active pcoded-trigger' : null }}">
                    <a href="javascript:void(0)">
                        <span class="pcoded-micon"><i class="fas fa-receipt"></i><b>BC</b></span>
                        <span class="pcoded-mtext">Vouchers </span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="{{ request()->routeIs('vouchers.create') ? 'active' : null }}">
                            <a href="{{ route('vouchers.create') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">New Voucher </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('vouchers.index') ? 'active' : null }}">
                            <a href="{{ route('vouchers.index') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Voucher List </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li
                    class="pcoded-hasmenu {{ request()->routeIs('bank-reconciliations.*') ? 'active pcoded-trigger' : null }}">
                    <a href="javascript:void(0)">
                        <span class="pcoded-micon"><i class="fas fa-receipt"></i><b>BC</b></span>
                        <span class="pcoded-mtext">Bank Reconciliation </span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="{{ request()->routeIs('bank-reconciliations.index') ? 'active' : null }}">
                            <a href="{{ route('bank-reconciliations.index') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Cheque List </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                    </ul>
                    <ul class="pcoded-submenu">
                        <li class="{{ request()->routeIs('bank-reconciliations-pdf') ? 'active' : null }}">
                            <a href="{{ route('bank-reconciliations-pdf') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Bank Reconciliation Report</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li
                    class="pcoded-hasmenu {{ request()->routeIs('loans.*', 'loan-receipts.*') ? 'active pcoded-trigger' : null }}">
                    <a href="javascript:void(0)">
                        <span class="pcoded-micon"><i class="fas fa-donate"></i><b>BC</b></span>
                        <span class="pcoded-mtext">Loans</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="{{ request()->routeIs('loans.create') ? 'active' : null }}">
                            <a href="{{ route('loans.create') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">New Loan </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('loans.index') ? 'active' : null }}">
                            <a href="{{ route('loans.index') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Loans List </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                    </ul>
                    <ul class="pcoded-submenu">
                        <li class="{{ request()->routeIs('loan-receipts.create') ? 'active' : null }}">
                            <a href="{{ route('loan-receipts.create') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext"> Loan Receipt </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('loan-receipts.index') ? 'active' : null }}">
                            <a href="{{ route('loan-receipts.index') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Loans Receipt List </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="pcoded-hasmenu {{ request()->routeIs('fixed-assets') ? 'active pcoded-trigger' : null }}">
                    <a href="javascript:void(0)">
                        <span class="pcoded-micon"><i class="fas fa-project-diagram"></i><b>BC</b></span>
                        <span class="pcoded-mtext"> Fixed Assets </span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="{{ request()->routeIs('fixed-assets') ? 'active' : null }}">
                            <a href="{{ route('fixed-assets.create') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext"> New Assets </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('fixed-assets.index') ? 'active' : null }}">
                            <a href="{{ route('fixed-assets.index') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Assets List </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('depreciations') ? 'active' : null }}">
                            <a href="{{ route('depreciations.create') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext"> Add Depreciation </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('depreciations.index') ? 'active' : null }}">
                            <a href="{{ route('depreciations.index') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Depreciation List </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="pcoded-hasmenu {{ request()->routeIs('salaries.*') ? 'active pcoded-trigger' : null }}">
                    <a href="javascript:void(0)">
                        <span class="pcoded-micon"><i class="fas fa-receipt"></i><b>BC</b></span>
                        <span class="pcoded-mtext">Salary </span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="{{ request()->routeIs('salaries.create') ? 'active' : null }}">
                            <a href="{{ route('salaries.create') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext"> Add Salary </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                    </ul>
                    <ul class="pcoded-submenu">
                        <li class="{{ request()->routeIs('salaries.index') ? 'active' : null }}">
                            <a href="{{ route('salaries.index') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext"> Salary List </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li
                    class="pcoded-hasmenu {{ request()->routeIs('allocations.*', 'salary-allocates.*') ? 'active pcoded-trigger' : null }}">
                    <a href="javascript:void(0)">
                        <span class="pcoded-micon"><i class="fas fa-receipt"></i><b>BC</b></span>
                        <span class="pcoded-mtext">Allocation </span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="{{ request()->routeIs('salary-allocates.create') ? 'active' : null }}">
                            <a href="{{ route('salary-allocates.create') }}"> <span class="pcoded-mtext"> Salary
                                    Allocation </span> </a>
                        </li>
                    </ul>
                    <ul class="pcoded-submenu">
                        <li class="{{ request()->routeIs('salary-allocates.index') ? 'active' : null }}">
                            <a href="{{ route('salary-allocates.index') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext"> Salary Allocation List </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                    </ul>
                    <ul class="pcoded-submenu">
                        <li class="{{ request()->routeIs('allocations.create') ? 'active' : null }}">
                            <a href="{{ route('allocations.create') }}"> <span class="pcoded-mtext"> Allocation
                                </span> </a>
                        </li>
                    </ul>
                    <ul class="pcoded-submenu">
                        <li class="{{ request()->routeIs('allocations.index') ? 'active' : null }}">
                            <a href="{{ route('allocations.index') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext"> Allocation List </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                    </ul>
                    <ul class="pcoded-submenu">
                        <li class="{{ request()->routeIs('financial-allocations.create') ? 'active' : null }}">
                            <a href="{{ route('financial-allocations.create') }}"> <span class="pcoded-mtext">
                                    Financial Allocation </span> </a>
                        </li>
                    </ul>
                    <ul class="pcoded-submenu">
                        <li class="{{ request()->routeIs('financial-allocations.index') ? 'active' : null }}">
                            <a href="{{ route('financial-allocations.index') }}">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Financial Allocation List </span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                    </ul>
                </li>

                {{--                <li class="pcoded-hasmenu {{ request()->routeIs('vehicles.*') ? 'active pcoded-trigger' : null }}"> --}}
                {{--                    <a href="javascript:void(0)"> --}}
                {{--                        <span class="pcoded-micon"><i class="fas fa-car"></i><b>BC</b></span> --}}
                {{--                        <span class="pcoded-mtext">Vehicles</span> --}}
                {{--                        <span class="pcoded-mcaret"></span> --}}
                {{--                    </a> --}}
                {{--                    <ul class="pcoded-submenu"> --}}
                {{--                        <li class="{{ request()->routeIs('vehicles.create') ? 'active' : null }}"> --}}
                {{--                            <a href="{{ route('vehicles.create') }}"> --}}
                {{--                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span> --}}
                {{--                                <span class="pcoded-mtext">New Vehicle </span> --}}
                {{--                                <span class="pcoded-mcaret"></span> --}}
                {{--                            </a> --}}
                {{--                        </li> --}}
                {{--                        <li class="{{ request()->routeIs('vehicles.index') ? 'active' : null }}"> --}}
                {{--                            <a href="{{ route('vehicles.index') }}"> --}}
                {{--                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span> --}}
                {{--                                <span class="pcoded-mtext">Vehicles List </span> --}}
                {{--                                <span class="pcoded-mcaret"></span> --}}
                {{--                            </a> --}}
                {{--                        </li> --}}
                {{--                    </ul> --}}
                {{--                </li> --}}
                {{--                <li class="pcoded-hasmenu {{ request()->routeIs('interCompanies') ? 'active pcoded-trigger' : null }}"> --}}
                {{--                    <a href="javascript:void(0)"> --}}
                {{--                        <span class="pcoded-micon"><i class="fas fa-project-diagram"></i><b>BC</b></span> --}}
                {{--                        <span class="pcoded-mtext">Inter Companies </span> --}}
                {{--                        <span class="pcoded-mcaret"></span> --}}
                {{--                    </a> --}}
                {{--                    <ul class="pcoded-submenu"> --}}
                {{--                        <li class="{{ request()->routeIs('interCompanies') ? 'active' : null }}"> --}}
                {{--                            <a href="{{ route('interCompanies.create') }}"> --}}
                {{--                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span> --}}
                {{--                                <span class="pcoded-mtext">New Inter Company </span> --}}
                {{--                                <span class="pcoded-mcaret"></span> --}}
                {{--                            </a> --}}
                {{--                        </li> --}}
                {{--                        <li class="{{ request()->routeIs('interCompanies.index') ? 'active' : null }}"> --}}
                {{--                            <a href="{{ route('interCompanies.index') }}"> --}}
                {{--                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span> --}}
                {{--                                <span class="pcoded-mtext">Inter Company List </span> --}}
                {{--                                <span class="pcoded-mcaret"></span> --}}
                {{--                            </a> --}}
                {{--                        </li> --}}
                {{--                    </ul> --}}
                {{--                </li> --}}

                <li
                    class="pcoded-hasmenu {{ request()->routeIs(['balancesheet', 'income-statement', 'ledgers', 'trial-balance', 'day-book', 'cost-center-summary', 'cost-center-breakup']) ? 'active pcoded-trigger' : null }}">
                    <a href="javascript:void(0)">
                        <span class="pcoded-micon"><i class="fas fa-chart-bar"></i><b>BC</b></span>
                        <span class="pcoded-mtext">AIS Reports </span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="{{ request()->routeIs('balancesheet') ? 'active' : null }}">
                            <a href="{{ route('balancesheet') }}" target="blank">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Balance Sheet</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('income-statement') ? 'active' : null }}">
                            <a href="{{ route('income-statement') }}" target="blank">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Income Statement</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('ledgers') ? 'active' : null }}">
                            <a href="{{ route('ledgers') }}" target="blank">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Ledger</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('trial-balance') ? 'active' : null }}">
                            <a href="{{ route('trial-balance') }}" target="blank">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Trial Balance</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('day-book') ? 'active' : null }}">
                            <a href="{{ route('day-book') }}" target="blank">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Day Book</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('bank-loan-statement') ? 'active' : null }}">
                            <a href="{{ route('bank-loan-statement') }}" target="blank">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Bank Loan Statement</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('fixed-asset-statment') ? 'active' : null }}">
                            <a href="{{ route('fixed-asset-statment') }}" target="blank">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Fixed Asset Statement</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('balance-income-line-report') ? 'active' : null }}">
                            <a href="{{ route('balance-income-line-report') }}" target="blank">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Ledger Group Report</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('projects-wip') ? 'active' : null }}">
                            <a href="{{ route('projects-wip') }}" target="blank">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext"> Cost Center</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>

                        <li class="{{ request()->routeIs('cost-center-summary') ? 'active' : null }}">
                            <a href="{{ route('cost-center-summary') }}" target="blank">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Cost Center Summary</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('cost-center-breakup') ? 'active' : null }}">
                            <a href="{{ route('cost-center-breakup') }}" target="blank">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Cost Center Breakup</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('receipt-payment-statement') ? 'active' : null }}">
                            <a href="{{ route('receipt-payment-statement') }}" target="blank">
                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                <span class="pcoded-mtext">Cash Flow Statement</span>
                                <span class="pcoded-mcaret"></span>
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- <li
                    class="pcoded-hasmenu {{ request()->routeIs(['profitabilityBasicInformation']) ? 'active pcoded-trigger' : null }}">
                    <a href="javascript:void(0)">
                        <span class="pcoded-micon"><i class="fas fa-donate"></i><b>P</b></span>
                        <span class="pcoded-mtext">Profitability</span>
                        <span class="pcoded-mcaret"></span>
                    </a>
                    <ul class="pcoded-submenu">
                        <li class="{{ request()->routeIs('profitabilityBasicInformation') ? 'active' : null }}"><a
                                href="{{ route('profitabilityBasicInformation') }}"><span class="pcoded-micon"><i
                                        class="icon-pie-chart"></i></span><span class="pcoded-mtext"> Profitability
                                    Report
                                </span><span class="pcoded-mcaret"></span></a></li>
                    </ul>
                </li> --}}
                <!--            <li class="pcoded-hasmenu {{ request()->routeIs(['mis-correction', 'mis-summary', 'mis-hr-report']) ? 'active pcoded-trigger' : null }}">
                                                        <a href="javascript:void(0)">
                                                            <span class="pcoded-micon"><i class="fas fa-chart-line"></i><b>BC</b></span>
                                                            <span class="pcoded-mtext">MIS Reports </span>
                                                            <span class="pcoded-mcaret"></span>
                                                        </a>
                                                        <ul class="pcoded-submenu">

                                                            <li class="{{ request()->routeIs('budget-cash-flow') ? 'active' : null }}">
                                                                <a href="{{ route('budget-cash-flow') }}" target="blank">
                                                                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                                                    <span class="pcoded-mtext">Budget Cash Flow</span>
                                                                    <span class="pcoded-mcaret"></span>
                                                                </a>
                                                            </li>
                                                            <li class="{{ request()->routeIs('budget-comparison-statement') ? 'active' : null }}">
                                                                <a href="{{ route('budget-comparison-statement') }}" target="blank">
                                                                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                                                    <span class="pcoded-mtext">Budget Comparison Statement</span>
                                                                    <span class="pcoded-mcaret"></span>
                                                                </a>
                                                            </li>
                                                            <li class="{{ request()->routeIs('mis-correction') ? 'active' : null }}">
                                                                <a href="{{ route('mis-correction') }}" target="blank">
                                                                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                                                    <span class="pcoded-mtext">MIS Correction</span>
                                                                    <span class="pcoded-mcaret"></span>
                                                                </a>
                                                            </li>

                                                            <li class="{{ request()->routeIs('mis-summary') ? 'active' : null }}">
                                                                <a href="{{ route('mis-summary') }}" target="blank">
                                                                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                                                    <span class="pcoded-mtext">MIS Summary</span>
                                                                    <span class="pcoded-mcaret"></span>
                                                                </a>
                                                            </li>

                                                            <li class="{{ request()->routeIs('mis-hr-report') ? 'active' : null }}">
                                                                <a href="{{ route('mis-hr-report') }}" target="blank">
                                                                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                                                    <span class="pcoded-mtext">MIS HR Report</span>
                                                                    <span class="pcoded-mcaret"></span>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </li>-->

            </ul>
        @endhasanyrole


        {{-- @can('hr') --}}
        @include('hr::layouts.sidebar')
        {{-- @endcan --}}


        <div class="p-5"></div>
    </div>
</nav>
