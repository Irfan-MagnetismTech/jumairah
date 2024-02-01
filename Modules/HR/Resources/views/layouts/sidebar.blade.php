<div class="pcoded-navigation-label text-uppercase bg-primary">HR</div>
<ul class="pcoded-item pcoded-left-item">

    @can('hr-config')
        <li
            class="pcoded-hasmenu {{ request()->routeIs(['salary-settings.*', 'employee-types.*', 'religions.*', 'shifts.*', 'units.*', 'post-offices.*', 'police-stations.*', 'designations.*', 'grades.*', 'lines.*', 'floors.*', 'districts.*', 'sections.*', 'departments.*', 'sub-sections.*', 'banks.*', 'bank-branch-info.*', 'building-infos.*', 'bus-stops.*', 'pay-modes.*', 'genders.*', 'released-types.*', 'allowance-types.*', 'bonus-settings.*', 'job-locations.*', 'leave-types.*', 'bonuses.*']) ? 'active pcoded-trigger' : null }}">
            <a href="javascript:void(0)">
                <span class="pcoded-micon"><i class="ti-panel"></i><b></b></span>
                <span class="pcoded-mtext">Configurations</span>
                <span class="pcoded-mcaret"></span>
            </a>

            <ul class="pcoded-submenu">

                @can('district-show')
                    <li class="{{ request()->routeIs('districts.*') ? 'active' : null }}">
                        <a href="{{ route('districts.index') }}">
                            <span class="pcoded-micon">
                                <i class="ti-angle-right"></i>
                            </span>
                            <span class="pcoded-mtext">District</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                @endcan

                @can('police-station-show')
                    <li class="{{ request()->routeIs('police-stations.*') ? 'active' : null }}">
                        <a href="{{ route('police-stations.index') }}">
                            <span class="pcoded-micon">
                                <i class="ti-angle-right"></i>
                            </span>
                            <span class="pcoded-mtext">Police Station</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                @endcan

                @can('post-office-show')
                    <li class="{{ request()->routeIs('post-offices.*') ? 'active' : null }}">
                        <a href="{{ route('post-offices.index') }}">
                            <span class="pcoded-micon">
                                <i class="ti-angle-right"></i>
                            </span>
                            <span class="pcoded-mtext">Post Office</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                @endcan

                @can('allowance-type-show')
                    <li class="{{ request()->routeIs('allowance-types.*') ? 'active' : null }}">
                        <a href="{{ route('allowance-types.index') }}">
                            <span class="pcoded-micon">
                                <i class="ti-angle-right"></i>
                            </span>
                            <span class="pcoded-mtext">Allowance Types</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                @endcan

                @can('bonus-show')
                    <li class="{{ request()->routeIs('bonuses.*') ? 'active' : null }}">
                        <a href="{{ route('bonuses.index') }}">
                            <span class="pcoded-micon">
                                <i class="ti-angle-right"></i>
                            </span>
                            <span class="pcoded-mtext">Bonuses</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                @endcan

                @can('bonus-setting-show')
                    <li class="{{ request()->routeIs('bonus-settings.*') ? 'active' : null }}">
                        <a href="{{ route('bonus-settings.index') }}">
                            <span class="pcoded-micon">
                                <i class="ti-angle-right"></i>
                            </span>
                            <span class="pcoded-mtext">Bonus Settings</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                @endcan

                @can('job-location-show')
                    <li class="{{ request()->routeIs('job-locations.*') ? 'active' : null }}">
                        <a href="{{ route('job-locations.index') }}">
                            <span class="pcoded-micon">
                                <i class="ti-angle-right"></i>
                            </span>
                            <span class="pcoded-mtext">Job Location</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                @endcan

                @can('department-show')
                    <li class="{{ request()->routeIs('departments.*') ? 'active' : null }}">
                        <a href="{{ route('departments.index') }}">
                            <span class="pcoded-micon">
                                <i class="ti-angle-right"></i>
                            </span>
                            <span class="pcoded-mtext">Department</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                @endcan

                @can('section-show')
                    <li class="{{ request()->routeIs('sections.*') ? 'active' : null }}">
                        <a href="{{ route('sections.index') }}">
                            <span class="pcoded-micon">
                                <i class="ti-angle-right"></i>
                            </span>
                            <span class="pcoded-mtext">Section</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                @endcan

                @can('sub-section-show')
                    <li class="{{ request()->routeIs('sub-sections.*') ? 'active' : null }}">
                        <a href="{{ route('sub-sections.index') }}">
                            <span class="pcoded-micon">
                                <i class="ti-angle-right"></i>
                            </span>
                            <span class="pcoded-mtext">Sub Section</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                @endcan

                @can('floor-show')
                    {{-- <li class="{{ request()->routeIs('floors.*') ? 'active' : null }}">
                        <a href="{{ route('floors.index') }}">
                            <span class="pcoded-micon">
                                <i class="ti-angle-right"></i>
                            </span>
                            <span class="pcoded-mtext">Floors</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li> --}}
                @endcan

                @can('line-show')
                    <li class="{{ request()->routeIs('lines.*') ? 'active' : null }}">
                        <a href="{{ route('lines.index') }}">
                            <span class="pcoded-micon">
                                <i class="ti-angle-right"></i>
                            </span>
                            <span class="pcoded-mtext">Lines</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                @endcan

                {{-- @can('unit-show')
                    <li class="{{ request()->routeIs('units.*') ? 'active' : null }}">
                        <a href="{{ route('units.index') }}">
                            <span class="pcoded-micon">
                                <i class="ti-angle-right"></i>
                            </span>
                            <span class="pcoded-mtext">Unit</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                @endcan --}}

                @can('bank-show')
                    <li class="{{ request()->routeIs('banks.*') ? 'active' : null }}">
                        <a href="{{ route('banks.index') }}">
                            <span class="pcoded-micon">
                                <i class="ti-angle-right"></i>
                            </span>
                            <span class="pcoded-mtext">Bank</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                @endcan

                @can('bank-branch-show')
                    <li class="{{ request()->routeIs('bank-branch-info.*') ? 'active' : null }}">
                        <a href="{{ route('bank-branch-info.index') }}">
                            <span class="pcoded-micon">
                                <i class="ti-angle-right"></i>
                            </span>
                            <span class="pcoded-mtext">Bank Branch</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                @endcan

                {{-- @can('building-show')
                    <li class="{{ request()->routeIs('building-infos.*') ? 'active' : null }}">
                        <a href="{{ route('building-infos.index') }}">
                            <span class="pcoded-micon">
                                <i class="ti-angle-right"></i>
                            </span>
                            <span class="pcoded-mtext">Building</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                @endcan --}}

                @can('busstop-show')
                    <li class="{{ request()->routeIs('bus-stops.*') ? 'active' : null }}">
                        <a href="{{ route('bus-stops.index') }}">
                            <span class="pcoded-micon">
                                <i class="ti-angle-right"></i>
                            </span>
                            <span class="pcoded-mtext">Bus Stop</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                @endcan

                @can('grade-show')
                    <li class="{{ request()->routeIs('grades.*') ? 'active' : null }}">
                        <a href="{{ route('grades.index') }}">
                            <span class="pcoded-micon">
                                <i class="ti-angle-right"></i>
                            </span>
                            <span class="pcoded-mtext">Grade</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                @endcan

                @can('designation-show')
                    <li class="{{ request()->routeIs('designations.*') ? 'active' : null }}">
                        <a href="{{ route('designations.index') }}">
                            <span class="pcoded-micon">
                                <i class="ti-angle-right"></i>
                            </span>
                            <span class="pcoded-mtext">Designation</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                @endcan

                @can('shift-show')
                    <li class="{{ request()->routeIs('shifts.*') ? 'active' : null }}">
                        <a href="{{ route('shifts.index') }}">
                            <span class="pcoded-micon">
                                <i class="ti-angle-right"></i>
                            </span>
                            <span class="pcoded-mtext">Shift</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                @endcan

                @can('gender-show')
                    <li class="{{ request()->routeIs('genders.*') ? 'active' : null }}">
                        <a href="{{ route('genders.index') }}">
                            <span class="pcoded-micon">
                                <i class="ti-angle-right"></i>
                            </span>
                            <span class="pcoded-mtext">Gender</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                @endcan

                @can('religion-show')
                    <li class="{{ request()->routeIs('religions.*') ? 'active' : null }}">
                        <a href="{{ route('religions.index') }}">
                            <span class="pcoded-micon">
                                <i class="ti-angle-right"></i>
                            </span>
                            <span class="pcoded-mtext">Religion</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                @endcan

                @can('employee-type-show')
                    <li class="{{ request()->routeIs('employee-types.*') ? 'active' : null }}">
                        <a href="{{ route('employee-types.index') }}">
                            <span class="pcoded-micon">
                                <i class="ti-angle-right"></i>
                            </span>
                            <span class="pcoded-mtext">Employee Type</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                @endcan

                @can('salary-setting-show')
                    <li class="{{ request()->routeIs('salary-settings.*') ? 'active' : null }}">
                        <a href="{{ route('salary-settings.index') }}">
                            <span class="pcoded-micon">
                                <i class="ti-angle-right"></i>
                            </span>
                            <span class="pcoded-mtext">Salary Settings</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                @endcan

                @can('paymode-show')
                    <li class="{{ request()->routeIs('pay-modes.*') ? 'active' : null }}">
                        <a href="{{ route('pay-modes.index') }}">
                            <span class="pcoded-micon">
                                <i class="ti-angle-right"></i>
                            </span>
                            <span class="pcoded-mtext">Pay Mode</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                @endcan

                @can('released-type-show')
                    <li class="{{ request()->routeIs('released-types.*') ? 'active' : null }}">
                        <a href="{{ route('released-types.index') }}">
                            <span class="pcoded-micon">
                                <i class="ti-angle-right"></i>
                            </span>
                            <span class="pcoded-mtext">Released Types</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                @endcan

                @can('leave-type-show')
                    <li class="{{ request()->routeIs('leave-types.*') ? 'active' : null }}">
                        <a href="{{ route('leave-types.index') }}">
                            <span class="pcoded-micon">
                                <i class="ti-angle-right"></i>
                            </span>
                            <span class="pcoded-mtext">Leave Types</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                @endcan
            </ul>
        </li>
    @endcan

    @can('hr-employee-management')
        <li
            class="pcoded-hasmenu {{ request()->routeIs([
                'employee-masters.*',
                'employee-shifts.*',
                'employee-salaries.*',
                'employee-transfers.*',
                'employee-releases.*',
                'employee-increments.*',
                'employee-transfers.*',
                'employee-shifts.*',
                'employee-idcard',
                'appointmentLettersList.*',
            ])
                ? 'active pcoded-trigger'
                : null }}">
            <a href="javascript:void(0)">
                <span class="pcoded-micon"><i class="ti-panel"></i><b></b></span>
                <span class="pcoded-mtext">Employee Mgt</span>
                <span class="pcoded-mcaret"></span>
            </a>
            <ul class="pcoded-submenu">

                @can('employee-show')
                    <li class="{{ request()->routeIs('employee-masters.*') ? 'active' : null }}">
                        <a href="{{ route('employee-masters.index') }}">
                            <span class="pcoded-micon">
                                <i class="ti-angle-right"></i>
                            </span>
                            <span class="pcoded-mtext">Employee Master</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                @endcan

                @can('employee-salary-show')
                    <li class="{{ request()->routeIs('employee-salaries.*') ? 'active' : null }}">
                        <a href="{{ route('employee-salaries.index') }}">
                            <span class="pcoded-micon">
                                <i class="ti-angle-right"></i>
                            </span>
                            <span class="pcoded-mtext">Employee Salary</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                @endcan

                @can('employee-increment-show')
                    <li class="{{ request()->routeIs('employee-increments.*') ? 'active' : null }}">
                        <a href="{{ route('employee-increments.index') }}">
                            <span class="pcoded-micon">
                                <i class="ti-angle-right"></i>
                            </span>
                            <span class="pcoded-mtext">Employee Increment</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                @endcan

                @can('employee-release-show')
                    <li class="{{ request()->routeIs('employee-releases.*') ? 'active' : null }}">
                        <a href="{{ route('employee-releases.index') }}">
                            <span class="pcoded-micon">
                                <i class="ti-angle-right"></i>
                            </span>
                            <span class="pcoded-mtext">Employee Releases</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                @endcan

                @can('employee-transfer-show')
                    <li class="{{ request()->routeIs('employee-transfers.*') ? 'active' : null }}">
                        <a href="{{ route('employee-transfers.index') }}">
                            <span class="pcoded-micon">
                                <i class="ti-angle-right"></i>
                            </span>
                            <span class="pcoded-mtext">Employee Transfers</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                @endcan

                @can('employee-shift-show')
                    <li class="{{ request()->routeIs('employee-shifts.*') ? 'active' : null }}">
                        <a href="{{ route('employee-shifts.index') }}">
                            <span class="pcoded-micon">
                                <i class="ti-angle-right"></i>
                            </span>
                            <span class="pcoded-mtext">Employee Shift Entry</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                @endcan

                @can('employee-idcard-print')
                    <li class="{{ request()->routeIs('employee-idcard') ? 'active' : null }}">
                        <a href="{{ route('employee-idcard') }}">
                            <span class="pcoded-micon">
                                <i class="ti-angle-right"></i>
                            </span>
                            <span class="pcoded-mtext">Employee Id Card</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                @endcan

                @can('employee-appointment-letter-show')
                    <li class="{{ request()->routeIs('appointmentLettersList.*') ? 'active' : null }}">
                        <a href="{{ route('appointmentLettersList') }}">
                            <span class="pcoded-micon">
                                <i class="ti-angle-right"></i>
                            </span>
                            <span class="pcoded-mtext">Issued Appointment Letters</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                @endcan
            </ul>
        </li>
    @endcan

    @can('hr-attendance-management')
        <li
            class="pcoded-hasmenu {{ request()->routeIs(['fix-attendances.*', 'processed-attendances.index', 'finger-print-device-infos.*']) ? 'active pcoded-trigger' : null }}">
            <a href="javascript:void(0)">
                <span class="pcoded-micon"><i class="ti-panel"></i><b></b></span>
                <span class="pcoded-mtext">Attendance Mgt</span>
                <span class="pcoded-mcaret"></span>
            </a>
            <ul class="pcoded-submenu">
                {{-- @can('fix-attendance-show')
                    <li class="{{ request()->routeIs('attendances-log.list') ? 'active' : null }}">
                        <a href="{{ route('attendance-log.list') }}">
                            <span class="pcoded-micon">
                                <i class="ti-angle-right"></i>
                            </span>
                            <span class="pcoded-mtext">Attendance Log</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                @endcan --}}

                @can('fix-attendance-show')
                    <li class="{{ request()->routeIs('fix-attendances.*') ? 'active' : null }}">
                        <a href="{{ route('fix-attendances.index') }}">
                            <span class="pcoded-micon">
                                <i class="ti-angle-right"></i>
                            </span>
                            <span class="pcoded-mtext">Fix Attendance</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                @endcan

                @can('process-attendance')
                    <li class="{{ request()->routeIs('processed-attendances.index') ? 'active' : null }}">
                        <a href="{{ route('processed-attendances.index') }}">
                            <span class="pcoded-micon">
                                <i class="ti-angle-right"></i>
                            </span>
                            <span class="pcoded-mtext">Process Attendances</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                @endcan

                @can('show-fingerprint-attendance')
                    <li class="{{ request()->routeIs('finger-print-attendance.index') ? 'active' : null }}">
                        <a href="{{ route('finger-print-attendance.index') }}">
                            <span class="pcoded-micon">
                                <i class="ti-angle-right"></i>
                            </span>
                            <span class="pcoded-mtext">Finger Print Attendance</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                @endcan

                @can('employee-overtime-show')
                    <li class="{{ request()->routeIs('employee-overtime.index') ? 'active' : null }}">
                        <a href="{{ route('employee-overtime.index') }}">
                            <span class="pcoded-micon">
                                <i class="ti-angle-right"></i>
                            </span>
                            <span class="pcoded-mtext">Employee Overtime</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                @endcan

                @can('fingerprint-device-show')
                    <li
                        class="pcoded-hasmenu {{ request()->routeIs(['finger-print-device-infos.index', 'finger-print-device-infos.create']) ? 'active pcoded-trigger' : null }}">
                        <a href="javascript:void(0)">
                            <span class="pcoded-micon"><i class="ti-panel"></i><b></b></span>
                            <span class="pcoded-mtext">Device</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                        <ul class="pcoded-submenu">
                            <li class="{{ request()->routeIs('finger-print-device-infos.index') ? 'active' : null }}">
                                <a href="{{ route('finger-print-device-infos.index') }}">
                                    <span class="pcoded-micon">
                                        <i class="ti-angle-right"></i>
                                    </span>
                                    <span class="pcoded-mtext">List</span>
                                    <span class="pcoded-mcaret"></span>
                                </a>
                            </li>
                            @can('fingerprint-device-create')
                                <li class="{{ request()->routeIs('finger-print-device-infos.create') ? 'active' : null }}">
                                    <a href="{{ route('finger-print-device-infos.create') }}">
                                        <span class="pcoded-micon">
                                            <i class="ti-angle-right"></i>
                                        </span>
                                        <span class="pcoded-mtext">Add</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan

            </ul>
        </li>
    @endcan

    @can('hr-leave-balance')
        <li
            class="pcoded-hasmenu {{ request()->routeIs(['leave-balances.*', 'leave-entries.*']) ? 'active pcoded-trigger' : null }}">
            <a href="javascript:void(0)">
                <span class="pcoded-micon"><i class="ti-panel"></i><b></b></span>
                <span class="pcoded-mtext">Leave Mgt</span>
                <span class="pcoded-mcaret"></span>
            </a>
            <ul class="pcoded-submenu">
                @can('leave-balance-show')
                    <li class="{{ request()->routeIs('leave-balances.*') ? 'active' : null }}">
                        <a href="{{ route('leave-balances.index') }}">
                            <span class="pcoded-micon">
                                <i class="ti-angle-right"></i>
                            </span>
                            <span class="pcoded-mtext">Leave Balance</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                @endcan
                @can('leave-entry-show')
                    <li class="{{ request()->routeIs('leave-entries.*') ? 'active' : null }}">
                        <a href="{{ route('leave-entries.index') }}">
                            <span class="pcoded-micon">
                                <i class="ti-angle-right"></i>
                            </span>
                            <span class="pcoded-mtext">Leave Entry</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                @endcan
            </ul>
        </li>
    @endcan

    @can('hr-salary')
        <li
            class="pcoded-hasmenu {{ request()->routeIs(['salary-adjustments.*', 'process-salary.*']) ? 'active pcoded-trigger' : null }}">
            <a href="javascript:void(0)">
                <span class="pcoded-micon"><i class="ti-panel"></i><b></b></span>
                <span class="pcoded-mtext">Salary Mgt</span>
                <span class="pcoded-mcaret"></span>
            </a>
            <ul class="pcoded-submenu">
                @can('salary-adjustment-show')
                    <li class="{{ request()->routeIs('salary-adjustments.*') ? 'active' : null }}">
                        <a href="{{ route('salary-adjustments.index') }}">
                            <span class="pcoded-micon">
                                <i class="ti-angle-right"></i>
                            </span>
                            <span class="pcoded-mtext">Salary Adjustments</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                @endcan
                @can('process-salary')
                    <li class="{{ request()->routeIs('process-salary.*') ? 'active' : null }}">
                        <a href="{{ route('process-salary.index') }}">
                            <span class="pcoded-micon">
                                <i class="ti-angle-right"></i>
                            </span>
                            <span class="pcoded-mtext">Process Salary</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                @endcan
            </ul>
        </li>
    @endcan

    @can('hr-admin-management')
        <li
            class="pcoded-hasmenu {{ request()->routeIs(['holidays.*', 'bonus-process.*', 'loan-applications.*']) ? 'active pcoded-trigger' : null }}">
            <a href="javascript:void(0)">
                <span class="pcoded-micon"><i class="ti-panel"></i><b></b></span>
                <span class="pcoded-mtext">Admin Management</span>
                <span class="pcoded-mcaret"></span>
            </a>
            <ul class="pcoded-submenu">
                @can('holiday-show')
                    <li class="{{ request()->routeIs('holidays.*') ? 'active' : null }}">
                        <a href="{{ route('holidays.index') }}">
                            <span class="pcoded-micon">
                                <i class="ti-angle-right"></i>
                            </span>
                            <span class="pcoded-mtext">Holiday Setup</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                @endcan

                @can('allowance-show')
                    <li class="{{ request()->routeIs('allowances.*') ? 'active' : null }}">
                        <a href="{{ route('allowances.index') }}">
                            <span class="pcoded-micon">
                                <i class="ti-angle-right"></i>
                            </span>
                            <span class="pcoded-mtext">Allowance</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                @endcan

                @can('loan-application')
                    <li class="{{ request()->routeIs('loan-applications.*') ? 'active' : null }}">
                        <a href="{{ route('loan-applications.index') }}">
                            <span class="pcoded-micon">
                                <i class="ti-angle-right"></i>
                            </span>
                            <span class="pcoded-mtext">Loan Application</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                @endcan

                @can('process-bonus-show')
                    <li class="pcoded-hasmenu {{ request()->routeIs(['bonus-process.*']) ? 'active pcoded-trigger' : null }}">
                        <a href="javascript:void(0)">
                            <span class="pcoded-micon"><i class="ti-panel"></i><b></b></span>
                            <span class="pcoded-mtext">Bonus Process</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                        <ul class="pcoded-submenu">
                            @can('process-bonus-create')
                                <li class="{{ request()->routeIs('bonus-process.create') ? 'active' : null }}">
                                    <a href="{{ route('bonus-process.create') }}">
                                        <span class="pcoded-micon">
                                            <i class="ti-angle-right"></i>
                                        </span>
                                        <span class="pcoded-mtext">Create</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>
                            @endcan
                            @can('process-bonus-show')
                                <li class="{{ request()->routeIs('bonus-process.index') ? 'active' : null }}">
                                    <a href="{{ route('bonus-process.index') }}">
                                        <span class="pcoded-micon">
                                            <i class="ti-angle-right"></i>
                                        </span>
                                        <span class="pcoded-mtext">List</span>
                                        <span class="pcoded-mcaret"></span>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan

            </ul>
        </li>
    @endcan

    @can('hr-report')
        <li
            class="pcoded-hasmenu {{ request()->routeIs(['reports.late', 'employeeList', 'promotionIncrementList', 'dailyAttendance', 'attendanceSummary', 'jobCard', 'leaveReport', 'otSheet', 'salarySheet', 'bonusSheet', 'allowanceReportIndex', 'fixAttendanceReportIndex', 'employeeSummary', 'paySlipReportIndex']) ? 'active pcoded-trigger' : null }}">
            <a href="javascript:void(0)">
                <span class="pcoded-micon"><i class="ti-panel"></i><b></b></span>
                <span class="pcoded-mtext">Reports</span>
                <span class="pcoded-mcaret"></span>
            </a>
            <ul class="pcoded-submenu">
                @can('allowance-report')
                    <li class="{{ request()->routeIs('allowanceReportIndex') ? 'active' : null }}">
                        <a href="{{ route('allowanceReportIndex') }}">
                            <span class="pcoded-micon">
                                <i class="ti-angle-right"></i>
                            </span>
                            <span class="pcoded-mtext">Allowance Report</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                @endcan

                {{-- <li class="{{ request()->routeIs('reports.late') ? 'active' : null }}"> --}}
                {{-- <li class="{{ request()->routeIs('reports.late') ? 'active' : null }}">
            <a href="{{ route('reports.late') }}">
                <span class="pcoded-micon">
                    <i class="ti-angle-right"></i>
                </span>
                <span class="pcoded-mtext">Attendance Late Report</span>
                <span class="pcoded-mcaret"></span>
            </a>
        </li> --}}
                @can('employee-list-report')
                    <li class="{{ request()->routeIs('employeeList') ? 'active' : null }}">
                        <a href="{{ route('employeeList') }}">
                            <span class="pcoded-micon">
                                <i class="ti-angle-right"></i>
                            </span>
                            <span class="pcoded-mtext">Employee List Report</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                @endcan

                @can('promotion-increment-list-report')
                    <li class="{{ request()->routeIs('promotionIncrementList') ? 'active' : null }}">
                        <a href="{{ route('promotionIncrementList') }}">
                            <span class="pcoded-micon">
                                <i class="ti-angle-right"></i>
                            </span>
                            <span class="pcoded-mtext">Promotion/Increment List Report</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                @endcan

                @can('daily-attendance-report')
                    <li class="{{ request()->routeIs('dailyAttendance') ? 'active' : null }}">
                        <a href="{{ route('dailyAttendance') }}">
                            <span class="pcoded-micon">
                                <i class="ti-angle-right"></i>
                            </span>
                            <span class="pcoded-mtext">Daily Attendance Report</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                @endcan

                @can('fix-attendance-report')
                    <li class="{{ request()->routeIs('fixAttendanceReportIndex') ? 'active' : null }}">
                        <a href="{{ route('fixAttendanceReportIndex') }}">
                            <span class="pcoded-micon">
                                <i class="ti-angle-right"></i>
                            </span>
                            <span class="pcoded-mtext">Fix Attendance Report</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                @endcan

                @can('attendance-summary-report')
                    <li class="{{ request()->routeIs('attendanceSummary') ? 'active' : null }}">
                        <a href="{{ route('attendanceSummary') }}">
                            <span class="pcoded-micon">
                                <i class="ti-angle-right"></i>
                            </span>
                            <span class="pcoded-mtext">Attendance Summary Report</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                @endcan

                @can('employee-summary-report')
                    <li class="{{ request()->routeIs('employeeSummary') ? 'active' : null }}">
                        <a href="{{ route('employeeSummary') }}">
                            <span class="pcoded-micon">
                                <i class="ti-angle-right"></i>
                            </span>
                            <span class="pcoded-mtext">Employee Summary Report</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                @endcan

                @can('jobcard-report')
                    <li class="{{ request()->routeIs('jobCard') ? 'active' : null }}">
                        <a href="{{ route('jobCard') }}">
                            <span class="pcoded-micon">
                                <i class="ti-angle-right"></i>
                            </span>
                            <span class="pcoded-mtext">Job Card</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                @endcan

                @can('leave-report')
                    <li class="{{ request()->routeIs('leaveReport') ? 'active' : null }}">
                        <a href="{{ route('leaveReport') }}">
                            <span class="pcoded-micon">
                                <i class="ti-angle-right"></i>
                            </span>
                            <span class="pcoded-mtext">Leave Report</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                @endcan

                @can('ot-sheet-report')
                    <li class="{{ request()->routeIs('otSheet') ? 'active' : null }}">
                        <a href="{{ route('otSheet') }}">
                            <span class="pcoded-micon">
                                <i class="ti-angle-right"></i>
                            </span>
                            <span class="pcoded-mtext">OT Sheet</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                @endcan

                @can('pay-slip-report')
                    <li class="{{ request()->routeIs('paySlipReportIndex') ? 'active' : null }}">
                        <a href="{{ route('paySlipReportIndex') }}">
                            <span class="pcoded-micon">
                                <i class="ti-angle-right"></i>
                            </span>
                            <span class="pcoded-mtext">Pay Slip</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                @endcan

                @can('slaray-sheet-report')
                    <li class="{{ request()->routeIs('salarySheet') ? 'active' : null }}">
                        <a href="{{ route('salarySheet') }}">
                            <span class="pcoded-micon">
                                <i class="ti-angle-right"></i>
                            </span>
                            <span class="pcoded-mtext">Salary Sheet</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                @endcan

                @can('bonus-sheet-report')
                    <li class="{{ request()->routeIs('bonusSheet') ? 'active' : null }}">
                        <a href="{{ route('bonusSheet') }}">
                            <span class="pcoded-micon">
                                <i class="ti-angle-right"></i>
                            </span>
                            <span class="pcoded-mtext">Bonus Sheet</span>
                            <span class="pcoded-mcaret"></span>
                        </a>
                    </li>
                @endcan
            </ul>
        </li>
    @endcan
</ul>
