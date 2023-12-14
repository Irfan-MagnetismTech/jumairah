@extends('layouts.backend-layout')
@section('title', 'BOQ - Rate Labor Rate List')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    List of Labor Rate
@endsection

@section('breadcrumb-button')
    @can('project-create')
        <a href="{{ route('eme.labor_rate.create') }}"
            class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
    @endcan
@endsection

@section('sub-title')
    Total: {{ $utilityBills->total() }}
@endsection

@section('content')
    <!-- put search form here.. -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>SL</th>
                    <th style="">Project Name</th>
                    <th style="width: 250px;word-wrap:break-word">Material Name/ Work Name</th>
                    <th style="">Note</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tfoot>
            </tfoot>
            <tbody>
                @php
                    $indx = ($utilityBills->currentPage() - 1) * $utilityBills->perPage();
                @endphp
                @foreach ($utilityBills as $data)
                    <tr>
                        <td>{{ ++$indx }}</td>
                        <td>{{ $data->project->name }}</td>
                        @if($data->type == 0)
                            <td>{{ $data->NestedMaterialSecondLayer->name }}</td>
                        @else
                            @php
                            $parent_data = App\Boq\Configurations\BoqWork::ancestorsOf($data->labor_rate_details->first()->boq_work_id)->pluck('name', 'id');
                            @endphp
                            <td>{{ $parent_data->last() }}</td>
                        
                        @endif
                        
                        <td>{{ $data->note }}</td>
                        <td>
                            <div class="icon-btn">
                                <nobr>
                                    @php
                                        $approval = \App\Approval\ApprovalLayerDetails::whereHas('approvalLayer', function ($q) use ($data) {
                                            $q->where([['name', 'BOQ EME LABOR RATE'], ['department_id', $data->appliedBy->department_id]]);
                                        })
                                            ->whereDoesntHave('approvals', function ($q) use ($data) {
                                                $q->where('approvable_id', $data->id)->where('approvable_type', \App\Boq\Departments\Eme\BoqEmeLaborRate::class);
                                            })
                                            ->orderBy('order_by', 'asc')
                                            ->first();
                                    @endphp
                                    @if ((!empty($approval) &&
                                        $approval->designation_id == auth()->user()->designation?->id &&
                                        $approval->department_id == auth()->user()->department_id) ||
                                        (!empty($approval) &&
                                            auth()->user()->hasAnyRole(['admin', 'super-admin'])))
                                        <a href="{{ url("eme/labor_rate/approved/$data->id/1") }}"
                                            data-toggle="tooltip" title="Approve" class="btn btn-success"><i
                                                class="fa fa-check" aria-hidden="true"></i></a>
                                       
                                    @endif
                                    @if ($data->approval()->doesntExist() ||
                                        auth()->user()->hasAnyRole(['admin', 'super-admin']))
                                       
                                        <a href="{{ route('eme.labor_rate.edit', ['labor_rate' => $data]) }}"
                                            data-toggle="tooltip" title="Edit" class="btn btn-outline-warning">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        @if ($data->approval()->doesntExist())
                                            <form
                                                action="{{ route('eme.labor_rate.destroy', ['labor_rate' => $data]) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm delete">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                            {{-- @include('components.buttons.action-button', ['actions' => ['delete'], 'route' => 'eme.budgets', 'route_key' => ['project' => $project,'budget' => $data]]) --}}
                                        @endif
                                    @endif()
                                    <a href="{{ route('eme.labor_rate.pdf', ['labor_rate' => $data]) }}" title="PDF" class="btn btn-out-dashed btn-sm btn-success"><i class="fas fa-file-pdf"></i></a>
                                </nobr>
                            </div>
                            {{-- @include('components.buttons.action-button', ['actions' => ['edit', 'delete'], 'route' => 'eme.labor_rate', 'route_key' => ['project' => $project,'labor_rate' => $data]]) --}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="float-right">
            {{ $utilityBills->onEachSide(2)->links() }}
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('js/Datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/Datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        $(window).scroll(function() {
            //set scroll position in session storage
            sessionStorage.scrollPos = $(window).scrollTop();
        });
        var init = function() {
            //get scroll position in session storage
            $(window).scrollTop(sessionStorage.scrollPos || 0)
        };
        window.onload = init;

        $(document).ready(function() {
            $('#dataTable').DataTable({
                stateSave: true,
                bPaginate: false
            });
        });
    </script>
@endsection
