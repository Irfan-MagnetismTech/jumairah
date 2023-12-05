@extends('layouts.backend-layout')
@section('title', 'BOQ - Calculation')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title')
    List of Comparative Statements
@endsection


@section('breadcrumb-button')
    <a href="{{ route('eme.work_cs.create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
@endsection

@section('sub-title')
    Total: {{ count($cs) }}
    @endsection

    @section('content')
            <!-- put search form here.. -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>SL</th>
                <th>Cs Ref</th>
                <th>project Name</th>
                <th>Effective Date</th>
                <th>Expiry Date</th>
                <th>Remarks</th>
                <th>Selected Supplier</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($cs as $key => $value)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td><strong>#{{$value->reference_no}}</strong></td>
                        <td>{{$value->project->name ?? null}}</td>
                        <td>{{$value->effective_date ?? null}}</td>
                        <td>{{$value->expiry_date ?? null}}</td>
                        <td>{{$value->remarks}}</td>
                        <td>
                            @php $any_selected = false; @endphp
                            @forelse ($value->csSuppliers as $cs_supplier)
                                @if($cs_supplier->is_checked)
                                    @php $any_selected = true; @endphp
                                    <p style="font-size: 11px">{{ $cs_supplier->supplier->name }}</p>
                                @endif
                            @empty
                            @endforelse
                            @if(!$any_selected)
                                <p style="font-size: 11px">No Supplier Selected</p>
                            @endif
                        </td>
                        <td>
                            {{-- <div class="icon-btn">
                                <nobr>
                                    <a href="{{ route("eme.work_cs.edit", ['project' => $project,'work_c' => $value]) }}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                    <a href="{{ route("work-cs.show", $cs->id) }}" data-toggle="tooltip" title="Show" class="btn btn-outline-primary"><i class="fas fa-eye"></i></a> 
                                    <a href="{{ route("workcspdf", $value->id) }}" data-toggle="tooltip" title="PDF" class="btn btn-outline-primary"><i class="fas fa-file-pdf"></i></a> 
                                   {!! Form::open(array('url' => route("eme.work_cs.destroy", ['project' => $project,'work_c' => $value]),'method' => 'delete', 'class'=>'d-inline','data-toggle'=>'tooltip','title'=>'Delete')) !!}
                                    {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete'])}}
                                    {!! Form::close() !!}



                                </nobr>
                            </div> --}}


                            <div class="icon-btn">
                                <nobr>
                                    @php
                                        $approval = \App\Approval\ApprovalLayerDetails::whereHas('approvalLayer', function ($q)use($value){
                                            $q->where([['name','BOQ EME COMPARATIVE STATEMENT'],['department_id',$value->appliedBy->department_id]]);
                                        })->whereDoesntHave('approvals',function ($q) use($value){
                                            $q->where('approvable_id',$value->id)->where('approvable_type',\App\Boq\Departments\Eme\BoqEmeCs::class);
                                        })->orderBy('order_by','asc')->first();
                                    @endphp
                                    @if((!empty($approval) && $approval->designation_id == auth()->user()->designation?->id && $approval->department_id == auth()->user()->department_id) || (!empty($approval) && auth()->user()->hasAnyRole(['admin','super-admin'])))
                                    <a href="{{ url("eme/work_cs/approved/$value->id/1") }}" data-toggle="tooltip" title="Approve" class="btn btn-success"><i class="fa fa-check" aria-hidden="true"></i></a>
                                        {{-- <a href="{{ url("iou/approved/$iou->id/0") }}" data-toggle="tooltip" title="Reject Requisition" class="btn btn-danger"><i class="fa fa-times" aria-hidden="true"></i></a> --}}
                                        {{-- @include('components.buttons.action-button', ['actions' => ['approve'], 'url' => "boq/project/$project->id/departments/electrical/budgets/approved/$data->id/1"]) --}}
                                    @endif
                                    @if($value->approval()->doesntExist() || auth()->user()->hasAnyRole(['admin','super-admin']))
                                        {{-- @include('components.buttons.action-button', ['actions' => ['edit'], 'route' => 'eme.budgets', 'route_key' => ['project' => $project,'budget' => $data]]) --}}
                                        <a href="{{ route("eme.work_cs.edit",['work_c' => $value]) }}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                        @if($value->approval()->doesntExist())
                                        {!! Form::open(array('url' => route("eme.work_cs.destroy", ['work_c' => $value]),'method' => 'delete', 'class'=>'d-inline','data-toggle'=>'tooltip','title'=>'Delete')) !!}
                                        {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete'])}}
                                        {!! Form::close() !!}
                                        {{-- @include('components.buttons.action-button', ['actions' => ['delete'], 'route' => 'eme.budgets', 'route_key' => ['project' => $project,'budget' => $data]]) --}}
                                        @endif
                                    @endif()
                                    <a href="{{ route('eme.work_cs.show',['work_c' => $value]) }}" data-toggle="tooltip" title="Details" class="btn btn-outline-primary"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('eme.work_cs.pdf', ['work_c' => $value]) }}" title="PDF" class="btn btn-out-dashed btn-sm btn-success"><i class="fas fa-file-pdf"></i></a>
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
