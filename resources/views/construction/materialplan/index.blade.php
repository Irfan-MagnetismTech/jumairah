@extends('layouts.backend-layout')
@section('title', 'Work Plan')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection




@section('breadcrumb-button')
<a href="{{ url('construction/material-budget-project-list') }}/{{ $year }}/{{ $month }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="ti-list" title="Project List"></i></a>
<a href="{{ url('construction/material-budget-pdf') }}/{{ $year }}/{{ $month }}/{{ $project_id }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fas fa-file-pdf" title="PDF"></i></a>
@endsection

@section('sub-title')
    {{-- Total: {{ count($requisitions) }} --}}<i class="fas fa-arrow-alt-left"></i>
    @endsection


    @section('content')
            <!-- put search form here.. -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th colspan="10">Jumairah Holdings Ltd.</th>
                </tr>
                <tr>
                    <th colspan="5">Project Name: {{ $currentYearPlans[0]->materialPlan->projects->name }}</th>
                    <th colspan="5">Duration: {{ date_format(date_create($currentYearPlans[0]->materialPlan->from_date),"d.m.Y")  }} To {{  date_format(date_create($currentYearPlans[0]->materialPlan->to_date),"d.m.Y") }}</th>
                </tr>
                <tr>
                    <th >SL No</th>
                    <th >Name of Materials</th>
                    <th >Unit</th>
                    <th >Week-1</th>
                    <th >Week-2</th>
                    <th >Week-3</th>
                    <th >Week-4</th>
                    <th >Total<br>Quantity</th>
                    <th >Remarks</th>
                    <th >Action</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th colspan="10">Monthly Material Budget</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach ($currentYearPlans as $currentYearPlan)
                @if ($currentYearPlan->materialPlan->is_saved == 1 || (auth()->user()->id == $currentYearPlan->materialPlan->user_id && $currentYearPlan->materialPlan->is_saved == 0))
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $currentYearPlan->nestedMaterials->name ?? null}}</td>
                                <td>{{ $currentYearPlan->nestedMaterials->unit->name ?? null}}</td>
                                <td>{{ $currentYearPlan->week_one ?? null }}</td>
                                <td>{{ $currentYearPlan->week_two ?? null }}</td>
                                <td>{{ $currentYearPlan->week_three ?? null }}</td>
                                <td>{{ $currentYearPlan->week_four ?? null }}</td>
                                <td>{{ $currentYearPlan->total_quantity ?? null }}</td>
                                <td>{{ $currentYearPlan->remarks ?? null }}</td>
                                @if ($loop->first)
                                    <td rowspan="{{count($currentYearPlans)}}">
                                        <div class="icon-btn">
                                            <nobr>
                                            @if ($currentYearPlan->materialPlan->is_saved == 0)
                                                <a href="{{ url("construction/material_plan/$currentYearPlan->material_plan_id/edit") }}" data-toggle="tooltip" title="Edit Draft" class="btn btn-outline-secondary"><i class="fas fa-pen"></i></a><br><br>
                                            @else
                                                @php
                                                    $year = $currentYearPlan->materialPlan->year;
                                                    $month = $currentYearPlan->materialPlan->month;
                                                    $id = $currentYearPlan->material_plan_id;
                                                    $project_id = $currentYearPlan->materialPlan->project_id;
                                                    $approval = \App\Approval\ApprovalLayerDetails::whereHas('approvalLayer', function ($q)use($currentYearPlan){
                                                    $q->where([['name','Material Plan'],['department_id',$currentYearPlan->materialPlan->appliedBy->department_id]]);
                                                })->whereDoesntHave('approvals',function ($q) use($currentYearPlan){
                                                    $q->where('approvable_id',$currentYearPlan->material_plan_id)->where('approvable_type',\App\Construction\MaterialPlan::class);
                                                })->orderBy('order_by','asc')->first();
                                                @endphp
                                                @if((!empty($approval) && $approval->designation_id == auth()->user()->designation?->id && $approval->department_id == auth()->user()->department_id) || (!empty($approval) && auth()->user()->hasAnyRole(['admin','super-admin'])))
                                                <a href="{{ url("construction/material-plan/approved/$currentYearPlan->material_plan_id/1") }}" data-toggle="tooltip" title="Approval" class="btn btn-success"><i class="fa fa-check" aria-hidden="true"></i></a>
                                                @endif
                                                @if($currentYearPlan->materialPlan->approval()->doesntExist() || auth()->user()->hasAnyRole(['admin','super-admin']))
                                                        <a href="{{ url("construction/material_plan/$currentYearPlan->material_plan_id/edit") }}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a><br><br>
                                                    @if($currentYearPlan->materialPlan->approval()->doesntExist())
                                                    {!! Form::open(array('url' => route("construction.material_plan.destroy", $currentYearPlan->material_plan_id),'method' => 'delete', 'class'=>'d-inline','data-toggle'=>'tooltip','title'=>'Delete')) !!}
                                                    {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete'])}}
                                                    {!! Form::close() !!}
                                                    @endif
                                                @endif
                                            @endif
                                            <a href="{{ url("materialPlanLog/$currentYearPlan->material_plan_id/log") }}" data-toggle="tooltip" title="Logs" class="btn btn-dark"><i class="fas fa-history"></i></a>
                                            </nobr>
                                        </div>
                                    </td>
                                @endif
                            </tr>
                @endif
               @endforeach
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

        $(document).ready(function(){
        $(".pending").click(function(){
            if (!confirm("Do you want to approve?")){
                return false;
            }
        });
    });
    </script>
@endsection
