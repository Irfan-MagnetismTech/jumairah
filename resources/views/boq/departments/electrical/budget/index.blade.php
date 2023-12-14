@extends('boq.departments.electrical.layout.app')
@section('title', 'BOQ - EME Budgets')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title')
    List of Budgets
@endsection

@section('breadcrumb-button')
    {{-- @can('project-create') --}}
    @if (count($BoqEmeBudgetData) > 0)
    <a href="{{ route('boq.project.departments.electrical.budgets.edit', ['project' => $project, 'budget' => 0]) }}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning btn-sm">
        <i class="fas fa-pen"></i>
    </a>
    @else
        <a href="{{ route('boq.project.departments.electrical.budgets.create',['project' => $project]) }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
    @endif
        <a href="{{ route('boq.project.departments.electrical.budget.pdf',['project' => $project]) }}" data-toggle="tooltip" title="PDF" class="btn btn-out-dashed btn-sm btn-success"><i class="fas fa-file-pdf"></i></a>
    {{-- @endcan --}}
@endsection

@section('sub-title')
@endsection

    @section('content')
            <!-- put search form here.. -->

    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>SL</th>
                <th>Item Head</th>
                <th>Specification</th>
                <th>Brand/Origin</th>
                <th>Rate</th>
                <th>Quantity</th>
                {{-- <th>Status</th> --}}
                <th>Amount</th>
                {{-- <th style="width:15%!important;">Action</th> --}}
            </tr>
            </thead>
            <tbody>
            @foreach($BoqEmeBudgetData as $data)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td class="text-left">{{$data->EmeBudgetHead->name}}</td>
                    <td>{{$data->specification}}</td>
                    <td>{{$data->brand}}</td>
                    <td>{{$data->rate}}</td>
                    <td>{{$data->quantity}}</td>
                    {{-- @php
                                $approval = \App\Approval\ApprovalLayerDetails::whereHas('approvalLayer', function ($q)use($data){
                                    $q->where([['name','BOQ EME BUDGET'],['department_id',$data->appliedBy->department_id]]);
                                })->whereDoesntHave('approvals',function ($q) use($data){
                                    $q->where('approvable_id',$data->id)->where('approvable_type',\App\Boq\Departments\Eme\BoqEmeBudget::class);
                                })->orderBy('order_by','asc')->first();
                    @endphp
                    <td>
                        @if($data->approval()->exists())
                            @foreach($data->approval as $approval)
                                <span class="badge @if($approval->status == 'Approved') bg-primary @else bg-warning @endif bg-warning badge-sm">
                                    {{ $approval->status }} - {{$approval->user->employee->department->name ?? ''}} - {{$approval->user->employee->designation->name ?? ''}}
                                </span><br>
                            @endforeach
                        @else
                            <span class="badge bg-warning badge-sm">{{ 'Pending' }}</span>
                        @endif
                    </td> --}}
                    <td>@money($data->amount)</td>
                    {{-- <td>
                        <div class="icon-btn">
                            <nobr>
                                @php
                                    $approval = \App\Approval\ApprovalLayerDetails::whereHas('approvalLayer', function ($q)use($data){
                                        $q->where([['name','BOQ EME BUDGET'],['department_id',$data->appliedBy->department_id]]);
                                    })->whereDoesntHave('approvals',function ($q) use($data){
                                        $q->where('approvable_id',$data->id)->where('approvable_type',\App\Boq\Departments\Eme\BoqEmeBudget::class);
                                    })->orderBy('order_by','asc')->first();
                                @endphp
                                @if((!empty($approval) && $approval->designation_id == auth()->user()->designation?->id && $approval->department_id == auth()->user()->department_id) || (!empty($approval) && auth()->user()->hasAnyRole(['admin','super-admin'])))
                                <a href="{{ url("boq/project/$project->id/departments/electrical/budgets/approved/$data->id/1") }}" data-toggle="tooltip" title="Approve" class="btn btn-success"><i class="fa fa-check" aria-hidden="true"></i></a> --}}
                                    {{-- <a href="{{ url("iou/approved/$iou->id/0") }}" data-toggle="tooltip" title="Reject Requisition" class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i></a> --}}
                                    {{-- @include('components.buttons.action-button', ['actions' => ['approve'], 'url' => "boq/project/$project->id/departments/electrical/budgets/approved/$data->id/1"]) --}}
                                {{-- @endif
                                @if($data->approval()->doesntExist() || auth()->user()->hasAnyRole(['admin','super-admin'])) --}}
                                    {{-- @include('components.buttons.action-button', ['actions' => ['edit'], 'route' => 'boq.project.departments.electrical.budgets', 'route_key' => ['project' => $project,'budget' => $data]]) --}}
                                    {{-- <a href="{{ route('boq.project.departments.electrical.budgets.edit', ['project' => $project,'budget' => $data]) }}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                    @if($data->approval()->doesntExist())
                                    <form action="{{ route('boq.project.departments.electrical.budgets.destroy', ['project' => $project,'budget' => $data]) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm delete">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form> --}}
                                    {{-- @include('components.buttons.action-button', ['actions' => ['delete'], 'route' => 'boq.project.departments.electrical.budgets', 'route_key' => ['project' => $project,'budget' => $data]]) --}}
                                    {{-- @endif
                                @endif()
                            </nobr>
                        </div>
                    </td> --}}
                </tr>
            @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="6" class="text-right">Total </td>
                    <td class="text-center">@money($BoqEmeBudgetData->sum('amount'))</td>
                </tr>
            </tfoot>
        </table>
        <div class="float-right">

        </div>
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
                stateSave: true,
                bPaginate: false
            });
        });
    </script>
@endsection
