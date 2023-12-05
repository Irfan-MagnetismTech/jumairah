@extends('layouts.backend-layout')
@section('title', 'Work Order List')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title')

    List of Work Orders
@endsection

@section('breadcrumb-button')
    <a href="{{ url("eme/work_order/create") }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
@endsection

@section('sub-title')
    Total: {{ count($workorders) }}
    @endsection

    @section('content')

            <!-- put search form here.. -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>SL</th>
                <th>Project Name</th>
                <th>Work Order No</th>
                <th>Issue Date</th>
                <th>Supplier Name</th>
                <th>CS Ref No.</th>
                <th>Action</th>
            </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>SL</th>
                    <th>Project Name</th>
                    <th>Work Order No</th>
                    <th>Issue Date</th>
                    <th>Supplier Name</th>
                    <th>CS Ref No.</th>
                    <th>Action</th>
                </tr>
            </tfoot>
            <tbody>
            @foreach($workorders as $key => $workorder)

                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$workorder->project->name}}</td>
                    <td>{{$workorder->workorder_no}}</td>
                    <td>{{ $workorder->issue_date}}</td>
                    <td>{{$workorder->supplier->name}}</td>
                    <td>
                        {{--<a href="{{route('eme.work_cs.show', ['project' => $project ,'work_c' => $workorder->boq_eme_cs_id])}}" target="_blank">--}}{{$workorder->workCs->reference_no}}{{--</a>--}}
                    </td>
                    <td>
                        {{-- <div class="icon-btn">
                            <nobr>
                                <a href="{{ url("workorders/$workorder->id") }}" data-toggle="tooltip" title="Show" class="btn btn-outline-primary"><i class="fas fa-eye"></i></a> 
                                <a href="{{ url("workorderpdf/$workorder->id") }}" data-toggle="tooltip" title="PDF" class="btn btn-outline-primary"><i class="fas fa-file"></i></a>
                                <a href="{{ url("eme/work_order/$workorder->id/edit") }}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                <a href="{{route("eme.workorder.terms", ['project' => $project ,'workorder' => $workorder->id])}}" data-toggle="tooltip" title="Edit Terms" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                <a href="{{route("eme.workorder.technical_specification", ['project' => $project ,'workorder' => $workorder->id]) }}" data-toggle="tooltip" title="Edit Technical Specification" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                <a href="{{route("eme.workorder.other_feature", ['project' => $project ,'workorder' => $workorder->id]) }}" data-toggle="tooltip" title="Edit Other Features" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                {!! Form::open(array('url' => "eme/work_order/$workorder->id",'method' => 'delete', 'class'=>'d-inline','data-toggle'=>'tooltip','title'=>'Delete')) !!}
                                {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete'])}}
                                {!! Form::close() !!}
                            </nobr>
                        </div> --}}

                        <div class="icon-btn">
                            <nobr>
                                @php
                                    $approval = \App\Approval\ApprovalLayerDetails::whereHas('approvalLayer', function ($q)use($workorder){
                                        $q->where([['name','BOQ EME WORK ORDER'],['department_id',$workorder->appliedBy->department_id]]);
                                    })->whereDoesntHave('approvals',function ($q) use($workorder){
                                        $q->where('approvable_id',$workorder->id)->where('approvable_type',\App\Boq\Departments\Eme\BoqEmeWorkOrder::class);
                                    })->orderBy('order_by','asc')->first();
                                @endphp
                                @if((!empty($approval) && $approval->designation_id == auth()->user()->designation?->id && $approval->department_id == auth()->user()->department_id) || (!empty($approval) && auth()->user()->hasAnyRole(['admin','super-admin'])))
                                <a href="{{ url("eme/workorder/approved/$workorder->id/1") }}" data-toggle="tooltip" title="Approve" class="btn btn-success"><i class="fa fa-check" aria-hidden="true"></i></a>
                                    {{-- <a href="{{ url("iou/approved/$iou->id/0") }}" data-toggle="tooltip" title="Reject Requisition" class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i></a> --}}
                                    {{-- @include('components.buttons.action-button', ['actions' => ['approve'], 'url' => "eme/budgets/approved/$data->id/1"]) --}}
                                @endif
                                @if($workorder->approval()->doesntExist() || auth()->user()->hasAnyRole(['admin','super-admin']))
                                    {{-- @include('components.buttons.action-button', ['actions' => ['edit'], 'route' => 'eme.budgets', 'route_key' => ['project' => $project,'budget' => $data]]) --}}
                                        <a href="{{ url("eme/work_order/$workorder->id/edit") }}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                        <a href="{{route("eme.workorder.terms", ['workorder' => $workorder->id])}}" data-toggle="tooltip" title="Edit Terms" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                        <a href="{{route("eme.workorder.technical_specification", ['workorder' => $workorder->id]) }}" data-toggle="tooltip" title="Edit Technical Specification" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                        <a href="{{route("eme.workorder.other_feature", ['workorder' => $workorder->id]) }}" data-toggle="tooltip" title="Edit Other Features" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                    @if($workorder->approval()->doesntExist())
                                        {!! Form::open(array('url' => "eme/work_order/$workorder->id",'method' => 'delete', 'class'=>'d-inline','data-toggle'=>'tooltip','title'=>'Delete')) !!}
                                        {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete'])}}
                                        {!! Form::close() !!}
                                    {{-- @include('components.buttons.action-button', ['actions' => ['delete'], 'route' => 'eme.budgets', 'route_key' => ['project' => $project,'budget' => $data]]) --}}
                                    
                                    @endif
                                @endif
                                <a href="{{ route('eme.workorder.pdf', ['work_order' => $workorder->id]) }}" title="PDF" class="btn btn-out-dashed btn-sm btn-success"><i class="fas fa-file-pdf"></i></a>
                            </nobr>
                        </div> 
                    </td>
                </tr>
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
    </script>

@endsection

