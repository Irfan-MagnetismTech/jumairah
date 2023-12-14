@extends('layouts.backend-layout')
@section('title', 'Action Plan')

@section('breadcrumb-title')
    Monthly Action Plan
@endsection

@section('breadcrumb-button')
    <a href="{{ url('construction/work_plan/create') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    {{--    <span class="text-danger">*</span> Marked are required.--}}
@endsection

@section('content-grid',null)

@section('content')

<div class="table-responsive">
    <table id="dataTable" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th colspan="13">Jumairah Holdings Ltd.</th>
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
                <th rowspan="2">Start Date</th>
                <th rowspan="2">Finish Date</th>
            </tr>
            <tr>
                <th >Architect Dept.</th>
                <th >Supply Chain Dept.</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th colspan="13">Action Plan</th>
            </tr>
        </tfoot>
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
@endsection
