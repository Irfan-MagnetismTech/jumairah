@extends('boq.departments.electrical.layout.app')
@section('title', 'BOQ - Eme Load Calculation')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title')
    List of Load Calculation
@endsection
@section('breadcrumb-button')
    @can('project-create')
        <a href="{{ route('boq.project.departments.electrical.show_load_cal',['project' => $project]) }}" data-toggle="tooltip" title="Details" class="btn btn-out-dashed btn-sm btn-primary"><i class="fas fa-eye"></i></a>
        <a href="{{ route('boq.project.departments.electrical.load_calculations.create',['project' => $project]) }}" class="btn btn-out-dashed btn-sm btn-success" data-toggle="tooltip" title="Create New"><i class="fa fa-plus"></i></a>
    @endcan
@endsection

@section('sub-title')
@endsection

@section('content')
            <!-- put search form here.. -->
    @php
        $calculation_type = ['Common','typical','generator'];
        $project_type = ['Residential','Commercial','Residential_cum_commercial'];
    @endphp
    @foreach ($boqemeloadcalculation as $key => $grpvalues)
    @foreach ($grpvalues as $key1 => $values )
    @php
        $total_connected_load = 0;
    @endphp
    <div class="table-responsive">
        <table id="" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th colspan="6" class="text-center">
                    <span>
                        {{ $project_type[$values->first()->project_type] }} - {{ $calculation_type[$values->first()->calculation_type] }}
                    </span>
                    <span class='float-right pr-5 mr-5 d-flex'>
                         {{-- @include('components.buttons.action-button', ['actions' => ['edit', 'delete'], 'route' => 'boq.project.departments.electrical.load_calculations', 'route_key' => ['project' => $project,'load_calculation' => $values->first()]]) --}}
                         <div class="icon-btn">
                            <nobr>
                                @php
                                $data = $values->first();

                                    $approval = \App\Approval\ApprovalLayerDetails::whereHas('approvalLayer', function ($q)use($data){
                                        $q->where([['name','BOQ EME LOAD CALCULATION'],['department_id',$data->appliedBy->department_id]]);
                                    })->whereDoesntHave('approvals',function ($q) use($data){
                                        $q->where('approvable_id',$data->id)->where('approvable_type',\App\Boq\Departments\Eme\BoqEmeLoadCalculation::class);
                                    })->orderBy('order_by','asc')->first();
                                @endphp
                                @if((!empty($approval) && $approval->designation_id == auth()->user()->designation?->id && $approval->department_id == auth()->user()->department_id) || (!empty($approval) && auth()->user()->hasAnyRole(['admin','super-admin'])))
                                <a href="{{ url("boq/project/$project->id/departments/electrical/load_calculations/approved/$data->id/1") }}" data-toggle="tooltip" title="Approve" class="btn btn-success"><i class="fa fa-check" aria-hidden="true"></i></a>
                                    {{-- <a href="{{ url("iou/approved/$iou->id/0") }}" data-toggle="tooltip" title="Reject Requisition" class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i></a> --}}
                                    {{-- @include('components.buttons.action-button', ['actions' => ['approve'], 'url' => "boq/project/$project->id/departments/electrical/budgets/approved/$data->id/1"]) --}}
                                @endif
                                @if($data->approval()->doesntExist() || auth()->user()->hasAnyRole(['admin','super-admin']))
                                    {{-- @include('components.buttons.action-button', ['actions' => ['edit'], 'route' => 'boq.project.departments.electrical.budgets', 'route_key' => ['project' => $project,'budget' => $data]]) --}}
                                    <a href="{{ route('boq.project.departments.electrical.load_calculations.edit', ['project' => $project,'load_calculation' => $data]) }}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    @if($data->approval()->doesntExist())
                                    <form action="{{ route('boq.project.departments.electrical.load_calculations.destroy', ['project' => $project,'load_calculation' => $data]) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm delete">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                    {{-- @include('components.buttons.action-button', ['actions' => ['delete'], 'route' => 'boq.project.departments.electrical.budgets', 'route_key' => ['project' => $project,'budget' => $data]]) --}}
                                    @endif
                                @endif
                            </nobr>
                        </div> 
                    </span>
                </th>
            </tr>
            <tr>
                <th>SL</th>
                <th style="width: 250px;word-wrap:break-word">Floor</th>
                <th style="width: 250px;word-wrap:break-word">Material</th>
                <th style="width: 250px;word-wrap:break-word">Load</th>
                <th style="width: 250px;word-wrap:break-word">Quantity</th>
                <th style="width: 250px;word-wrap:break-word">Connected Load</th>
            </tr>
            </thead>
            <tbody>
            @foreach($values->first()->boq_eme_load_calculations_details as $key1 => $data)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $data->floor->name }}</td>
                    <td>{{ $data->material->name }}</td>
                    <td>{{ $data->load }}</td>
                    <td>{{ $data->qty }}</td>
                    <td>{{ $data->connected_load }}</td>
                    @php
                        $total_connected_load += $data->connected_load;
                    @endphp
                </tr>
            @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4"></td>
                    <td class="text-center">Total</td>
                    <td class="text-center">{{ $total_connected_load }}</td>
                </tr>
                <tr>
                    <td class="text-right" colspan="5">Asuuming {{ $values->first()->demand_percent }}% demand load</td>
                    <td class="text-center">{{ $values->first()->total_demand_wattage }}</td>
                </tr>
            </tfoot>
        </table>
        <div class="float-right">

        </div>
    </div>
    @endforeach
    @endforeach
    {{-- <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>SL</th>
                <th style="width: 250px;word-wrap:break-word">Calculation Type</th>
                <th style="width: 250px;word-wrap:break-word">Project Type</th>
                <th style="width: 250px;word-wrap:break-word">Connected Wattage</th>
                <th style="width: 250px;word-wrap:break-word">Demand Wattage</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($boqemeloadcalculation as $key => $data)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $calculation_type[$data->calculation_type] }}</td>
                    <td>{{ $project_type[$data->project_type] }}</td>
                    <td class="text-right">{{ $data->total_connecting_wattage }}</td>
                    <td class="text-right">{{ $data->total_demand_wattage }}</td>
                    <td>
                        @include('components.buttons.action-button', ['actions' => ['edit', 'delete'], 'route' => 'boq.project.departments.electrical.load_calculations', 'route_key' => ['project' => $project,'load_calculation' => $data]])
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="float-right">

        </div>
    </div> --}}
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
                stateSave: true,
                bPaginate: false
            });
        });
    </script>
@endsection
