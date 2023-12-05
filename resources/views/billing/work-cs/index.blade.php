@extends('layouts.backend-layout')
@section('title', 'Comparative Statements')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
<style>

.specifictd {
        white-space: normal !important; /* css-3 */
        max-width: 400px; /* Change the value to your desired width */
        word-wrap: break-word;
    }
</style>
@endsection

@section('breadcrumb-title')
    List of Comparative Statements
@endsection


@section('breadcrumb-button')
    <a href="{{ route('work-cs.create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
@endsection

@section('sub-title')
    Total: {{ count($workC) }}
    @endsection

    @section('content')
            <!-- put search form here.. -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>SL</th>
                <th>Cs Ref</th>
                <th>Effective Date</th>
                <th>Expiry Date</th>
                <th>Remarks</th>
                <th>Selected Supplier</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($workC as $key => $cs)
                @if ($cs->is_saved == 1 || (auth()->user()->id == $cs->user_id && $cs->is_saved == 0))
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td><strong>#{{$cs->reference_no}}</strong></td>
                        <td>{{$cs->effective_date ?? null}}</td>
                        <td>{{$cs->expiry_date ?? null}}</td>
                        <td class="specifictd">{!! $cs->remarks !!}</td>
                        <td>
                            @php $any_selected = false; @endphp
                            @forelse ($cs->workCsSuppliers as $cs_supplier)
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
                        @php
                            $approval = \App\Approval\ApprovalLayerDetails::whereHas('approvalLayer', function ($q)use($cs){
                                $q->where([['name','WORK CS'],['department_id',$cs->appliedBy->department_id]]);
                            })->whereDoesntHave('approvals',function ($q) use($cs){
                                $q->where('approvable_id',$cs->id)->where('approvable_type',\App\Billing\WorkCs::class);
                            })->orderBy('order_by','asc')->get();

                            $TotalApproval = \App\Approval\ApprovalLayerDetails::whereHas('approvalLayer', function ($q)use($cs){ $q->where([['name','WORK CS'],['department_id',$cs->appliedBy->department_id]]);
                            })->orderBy('order_by','asc')->get()->count();
                        @endphp
                        <td>
                            @if($cs->approval()->exists())
                                @foreach($cs->approval as $approval1)
                                    <span class="badge @if($approval1->status == 'Approved') bg-primary @else bg-warning @endif bg-warning badge-sm">
                                        {{ $approval1->status }} - {{$approval1->user->employee->department->name ?? ''}} - {{$approval1->user->employee->designation->name ?? ''}}
                                    </span><br>
                                @endforeach
                                @if (($cs->approval->count() != $TotalApproval))
                                    <span class="badge bg-warning badge-sm">Pending in {{$approval->first()->designation->name ?? ''}} - {{$approval->first()->department->name ?? ''}}</span>
                                @endif
                            @else
                                <span class="badge bg-warning badge-sm">Pending in {{$approval->first()->designation->name ?? ''}} - {{$approval->first()->department->name ?? ''}}</span>
                            @endif
                        </td>
                        <td>
                            <div class="icon-btn">
                                <nobr>
                                    {{-- @if ($cs->is_saved == 0)
                                        <a href="{{ route("work-cs.edit", $cs->id) }}" data-toggle="tooltip" title="Edit draft" class="btn btn-outline-secondary"><i class="fas fa-pen"></i></a>
                                    @else
                                        <a href="{{ route("work-cs.edit", $cs->id) }}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                    @endif
                                    {{-- <a href="{{ route("work-cs.show", $cs->id) }}" data-toggle="tooltip" title="Show" class="btn btn-outline-primary"><i class="fas fa-eye"></i></a> --}}
                                    {{-- <a href="{{ route("workcspdf", $cs->id) }}" data-toggle="tooltip" title="PDF" class="btn btn-outline-primary"><i class="fas fa-file-pdf"></i></a>
                                   {!! Form::open(array('url' => route("work-cs.destroy", $cs->id),'method' => 'delete', 'class'=>'d-inline','data-toggle'=>'tooltip','title'=>'Delete')) !!}
                                    {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete'])}}
                                    {!! Form::close() !!} --}}
                                    @if ($cs->is_saved == 0)
                                        <a href="{{ route("work-cs.edit", $cs->id) }}" data-toggle="tooltip" title="Edit draft" class="btn btn-outline-secondary"><i class="fas fa-pen"></i></a>
                                        {!! Form::open(array('url' => route("work-cs.destroy", $cs->id),'method' => 'delete', 'class'=>'d-inline','data-toggle'=>'tooltip','title'=>'Delete')) !!}
                                                {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete'])}}
                                                {!! Form::close() !!}
                                    @else
                                        @php
                                        $approval = \App\Approval\ApprovalLayerDetails::whereHas('approvalLayer', function ($q)use($cs){
                                            $q->where([['name','WORK CS'],['department_id',$cs->appliedBy->department_id]]);
                                        })->whereDoesntHave('approvals',function ($q) use($cs){
                                            $q->where('approvable_id',$cs->id)->where('approvable_type',\App\Billing\WorkCs::class);
                                        })->orderBy('order_by','asc')->first();
                                        @endphp
                                        @if((!empty($approval) && $approval->designation_id == auth()->user()->designation?->id && $approval->department_id == auth()->user()->department_id) || (!empty($approval) && auth()->user()->hasAnyRole(['admin','super-admin'])))
                                            <a href="{{ url("work_cs/approved/$cs->id/1") }}" data-toggle="tooltip" title="Approve" class="btn btn-success"><i class="fa fa-check" aria-hidden="true"></i></a>
                                        @endif
                                        @if($cs->approval()->doesntExist() || auth()->user()->hasAnyRole(['admin','super-admin']))
                                                <a href="{{ route("work-cs.edit", $cs->id) }}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                            @if($cs->approval()->doesntExist())
                                                {!! Form::open(array('url' => route("work-cs.destroy", $cs->id),'method' => 'delete', 'class'=>'d-inline','data-toggle'=>'tooltip','title'=>'Delete')) !!}
                                                {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete'])}}
                                                {!! Form::close() !!}
                                            @endif
                                        @else
                                            <a href="{{ url("work_cs/copy/$cs->id") }}" data-toggle="tooltip" title="Copy" class="btn btn-success"><i class="fas fa-clone" aria-hidden="true"></i></a>
                                        @endif
                                        <a href="{{ route("workcspdf", $cs->id) }}" data-toggle="tooltip" title="PDF" class="btn btn-outline-primary"><i class="fas fa-file-pdf"></i></a>
                                    @endif
                                    <a href="{{ url("workcsLog/$cs->id/log") }}" data-toggle="tooltip" title="Logs" class="btn btn-dark"><i class="fas fa-history"></i></a>
                                </nobr>
                            </div>
                        </td>
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
    </script>
@endsection
