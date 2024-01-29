<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }

        table {
            font-size: 9px;
        }

        #table {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #table td,
        #table th {
            border: 1px solid ;
            padding: 5px;
        }

        #table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #table tr:hover {
            background-color: #ddd;
        }

        #table th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: center;
            /* background-color: #227447; */
            color: black;
        }

        .tableHead {
            text-align: center;
            font-weight: bold;
            font-size: 13px;
        }

        p {
            margin: 0;
        }

        h1 {
            margin: 0;
        }

        h2 {
            margin: 0;
        }

        .container {
            margin: 20px;
        }

        #logo {
            clear: both;
            width: 100%;
            display: block;
            text-align: center;
            position: relative;
        }

        #client {
            border: 1px dashed #000000;
            position: absolute;
            width: 230px;
            top: 0;
            line-height: 18px;
            padding: 5px;
        }

        #apartment {
            border: 1px dashed #000000;
            position: absolute;
            width: 230px;
            right: 20px;
            top: 20px;
            line-height: 18px;
            padding: 5px;
        }

        .infoTable {
            font-size: 12px;
            width: 100%;
        }

        .infoTableTable td:nth-child(2) {
            text-align: center;
            width: 20px;
        }

        .pdflogo a {
            font-size: 18px;
            font-weight: bold;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }

        @page {
            margin: 40px 0 0 0;
        }

    </style>
</head>

<body>

    <div id="logo" class="pdflogo">
        <img src="{{ asset(config('company_info.logo')) }}" alt="Logo" class="pdfimg">
        <div class="clearfix"></div>
        <h5>{!! htmlspecialchars(config('company_info.company_address')) !!}</h5>
    </div>



    <div class="container" style="margin-top: 10px; clear: both; display: block; width: 100%;">



        <div class="table-responsive">
            <table id="table" class="table table-striped table-bordered text-center">
                <thead>
                    <tr>
                        <th colspan="13">{!! htmlspecialchars(config('company_info.company_fullname')) !!}.</th>
                    </tr>
                    <tr>
                        <th rowspan="4">Project Name</th>
                        <th rowspan="4">Scope of works</th>
                        <th colspan="10">Status-Requirement-Schedule</th>
                        <th rowspan="4">Remarks</th>
                    </tr>
                    <tr>
                        <th rowspan="3">Present Status</th>
                        <th rowspan="3">Target</th>
                        <th rowspan="3">Achivement</th>
                        <th colspan="4">Requirement</th>
                        <th colspan="2">Work Schedule</th>
                        <th rowspan="3">Delay reason</th>
                    </tr>
                    <tr>
                        <th rowspan="2">Description of Work</th>
                        <th rowspan="2">Required Materials</th>
                        <th colspan="2">Action Required by</th>
                        <th width="60px" rowspan="2">Start Date</th>
                        <th rowspan="2">Finish Date</th>
                    </tr>
                    <tr>
                        <th >Architect Dept.</th>
                        <th >Supply Chain Dept.</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($currentYearPlans as $currentYearPlan)
                        @php
                            $planGroups = $currentYearPlan->workPlanDetails->groupBy('work_id');
                        @endphp
                        @foreach ($planGroups as $planGroup)
                            @foreach($planGroup as $key => $planDetail)
                                <tr>
                                    @if ($loop->parent->first && $loop->first)
                                        <td rowspan="{{count($currentYearPlan->workPlanDetails)}}">
                                            {{ $currentYearPlan->projects->name }}
                                        </td>
                                    @endif

                                    @if ($loop->first)
                                        <td rowspan="{{count($planGroup)}}">
                                            {{ $planDetail->boqWorks->name }}
                                        </td>
                                    @endif


                                    @if ($loop->first)
                                        <td rowspan="{{count($planGroup)}}">
                                            @if($planDetail->sub_work && $planDetail->target_accomplishment)
                                            {{ $planDetail->sub_work }}<br>
                                            {{ $planDetail->target_accomplishment }}% completed
                                            @elseif($planDetail->sub_work)
                                            {{ $planDetail->sub_work }}
                                            @elseif($planDetail->target_accomplishment)
                                            {{ $planDetail->target_accomplishment }}% completed
                                            @endif
                                        </td>
                                    @endif

                                    <td>{{ $planDetail->target }}%</td>
                                    <td></td>

                                    <td>{{ $planDetail->description }}</td>

                                    <td>{{ $planDetail->name }}</td>
                                    <td>{{ $planDetail->architect_eng_name }}</td>
                                    <td>{{ $planDetail->sc_eng_name }}</td>
                                    <td>{{ $planDetail->start_date }}</td>
                                    <td>{{ $planDetail->finish_date }}</td>
                                    <td >{{ $planDetail->delay }}</td>
                                    <td></td>
                                </tr>

                            @endforeach
                        @endforeach
                        @empty

                    @endforelse
                </tbody>
            </table>
        </div>





        <br><br><br>
        <div style="display: block; width: 100%;">
            <table style="text-align: center; width: 100%;">
                <tr>
                    <td>
                        <span>---------------------------------</span>
                        <p>GM Construction</p>
                    </td>
                    <td>
                        <span>---------------------------------</span>
                        <p>PMO</p>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>
