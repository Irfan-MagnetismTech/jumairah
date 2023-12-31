@extends('layouts.backend-layout')
@section('title', 'Work Plan')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title')
        Work Plan
@endsection


@section('breadcrumb-button')
    <a href="{{ url('construction/pdf') }}/{{ $year }}/{{ $month }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fas fa-file-pdf"></i></a>
@endsection

@section('sub-title')
    {{-- Total: {{ count($requisitions) }} --}}
    @endsection


    @section('content')
            <!-- put search form here.. -->
            @php
                $parameter_year = request()->route()->parameters['year'];
                $parameter_month = request()->route()->parameters['month'];
            @endphp
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th colspan="14">Jumairah Holdings Ltd.</th>
                </tr>
                <tr>
                    <th rowspan="4">Project Name</th>
                    <th rowspan="4">Scope of works</th>
                    <th colspan="10">Status-Requirement-Schedule</th>
                    <th rowspan="4">Remarks</th>
                    <th rowspan="4">Action</th>
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
                    <th colspan="14">Action Plan</th>
                </tr>
            </tfoot>
            <tbody>
                @forelse ($currentYearPlans as $currentYearPlan)
                    @php
                        $planGroups = $currentYearPlan->workPlanDetails->groupBy('work_id');
                    @endphp
                    @foreach ($planGroups as $planGroup)
                        @foreach($planGroup as $key => $planDetail)
                        @if ($planDetail->workPlan->is_saved == 1 || (auth()->user()->id == $planDetail->workPlan->user_id && $planDetail->workPlan->is_saved == 0))
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

                                @if ($loop->parent->first && $loop->first)
                                    <td rowspan="{{count($currentYearPlan->workPlanDetails)}}">
                                        <div class="icon-btn">
                                            <nobr>
                                                @if ($currentYearPlan->is_saved == 0)
                                                    <a href="{{ url("construction/work_plan/$currentYearPlan->id/edit") }}" data-toggle="tooltip" title="Edit Draft" class="btn btn-outline-secondary"><i class="fas fa-pen"></i></a>
                                                @else
                                                    @php
                                                    $approval = \App\Approval\ApprovalLayerDetails::whereHas('approvalLayer', function ($q)use($currentYearPlan){
                                                        $q->where([['name','Action Plan'],['department_id',$currentYearPlan->appliedBy->department_id]]);
                                                    })->whereDoesntHave('approvals',function ($q) use($currentYearPlan){
                                                        $q->where('approvable_id',$currentYearPlan->id)->where('approvable_type',\App\Construction\WorkPlan::class);
                                                    })->orderBy('order_by','asc')->first();
                                                    @endphp
                                                    @if((!empty($approval) && $approval->designation_id == auth()->user()->designation?->id && $approval->department_id == auth()->user()->department_id) || (!empty($approval) && auth()->user()->hasAnyRole(['admin','super-admin'])))
                                                        <a href="{{ url("construction/work_plan/approved/$currentYearPlan->id/1/$parameter_year/$parameter_month") }}" data-toggle="tooltip" title="Approve" class="btn btn-success"><i class="fa fa-check" aria-hidden="true"></i></a>
                                                    @endif
                                                    @if($currentYearPlan->approval()->doesntExist() || auth()->user()->hasAnyRole(['admin','super-admin']))
                                                        <a href="{{ url("construction/work_plan/$currentYearPlan->id/edit") }}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                                        @if($currentYearPlan->approval()->doesntExist())
                                                        @endif
                                                    @endif
                                                @endif
                                                <a href="{{ url("workPlanLog/$currentYearPlan->id/log") }}" data-toggle="tooltip" title="Logs" class="btn btn-dark"><i class="fas fa-history"></i></a>
                                            </nobr>
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @endif
                        @endforeach
                    @endforeach
                    @empty

                @endforelse
            </tbody>
        </table>
    </div>
@endsection

@section('script')
    <script src="{{asset('js/Datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('js/Datatables/dataTables.bootstrap4.min.js')}}"></script>
    <script>
        $(window).scroll(function () {
            //set scroll position in session storage
            sessionStorage.scrollPos = $(window).scrollTop();
        });
        var init = function () {
            //get scroll position in session storage
            $(window).scrollTop(sessionStorage.scrollPos || 0)
        };
        window.onload = init;

        $(document).ready(function () {
            $('#dataTable').DataTable({
                stateSave: true
            });
        });
    </script>
@endsection
