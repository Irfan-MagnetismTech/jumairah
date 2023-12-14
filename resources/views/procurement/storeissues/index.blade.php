@extends('layouts.backend-layout')
@section('title', 'Store Issue Note List')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title')
    List of Store Issue Note
@endsection


@section('breadcrumb-button')
    <a href="{{ url('storeissues/create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
@endsection

@section('sub-title')
    Total: {{ count($storeissues) }}
    @endsection


    @section('content')
            <!-- put search form here.. -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>SIN No.</th>
                    <th>SRF No.</th>
                    <th>Project Name</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>SL</th>
                    <th>SIN No.</th>
                    <th>SRF No.</th>
                    <th>Project Name</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </tfoot>
            <tbody>
            @foreach($storeissues as $key => $storeissue)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$storeissue->sin_no}}</td>
                    <td>{{$storeissue->srf_no}}</td>
                    <td>{{$storeissue->costCenter->name}}</td>
                    <td>{{$storeissue->date}}</td>
                    <td>
                        @php
                                    $approval = \App\Approval\ApprovalLayerDetails::whereHas('approvalLayer', function ($q)use($storeissue){
                                        $q->where([['name','Store Issue'],['department_id',$storeissue->appliedBy->department_id]]);
                                    })->whereDoesntHave('approvals',function ($q) use($storeissue){
                                        $q->where('approvable_id',$storeissue->id)->where('approvable_type',\App\Procurement\Storeissue::class);
                                    })->orderBy('order_by','asc')->first();
                                @endphp
                        @if($storeissue->approval()->exists())
                            @php $approvalstatus = '' ;@endphp
                            @foreach($storeissue->approval as $approval)
                                <span class="badge @if($approval->status == 'Approved') bg-primary @else bg-warning @endif bg-warning badge-sm">
                                    {{ $approval->status }} - {{$approval->user->employee->department->name ?? ''}} - {{$approval->user->employee->designation->name ?? ''}}
                                </span><br>
                            @endforeach
                        @else
                        @php $approvalstatus = 'Pending' ;@endphp
                            <span class="badge bg-warning badge-sm">Pending in {{$approval->designation->name ?? ''}} - {{$approval->department->name ?? ''}}</span>
                        @endif
{{--                        {{$approvalstatus}}--}}
                    </td>
                    <td>
                        <div class="icon-btn">
                            <nobr>
                                @php
                                    $approval = \App\Approval\ApprovalLayerDetails::whereHas('approvalLayer', function ($q)use($storeissue){
                                        $q->where([['name','Store Issue'],['department_id',$storeissue->appliedBy->department_id]]);
                                    })->whereDoesntHave('approvals',function ($q) use($storeissue){
                                        $q->where('approvable_id',$storeissue->id)->where('approvable_type',\App\Procurement\Storeissue::class);
                                    })->orderBy('order_by','asc')->first();
                                @endphp
                                 @if((!empty($approval) && $approval->designation_id == auth()->user()->designation?->id && $approval->department_id == auth()->user()->department_id) || (!empty($approval) && auth()->user()->hasAnyRole(['admin','super-admin'])))
{{--                                    {{$approvalstatus}}--}}
                                    @if($approvalstatus == 'Pending' || $approvalstatus == 'Approved')
                                        <a href="{{ url("store-issue-view/approved/$storeissue->id/1") }}" data-toggle="tooltip" title="Approval" class="btn btn-success"><i class="fa fa-check" aria-hidden="true"></i></a>
                                    @endif
                                @endif
{{--                                {{$approval, $approval->designation_id}} - {{auth()->user()->designation?->id}}--}}
                                @if($storeissue->approval()->doesntExist() || auth()->user()->hasAnyRole(['admin','super-admin']))
                                    <a href="{{ url("storeissues/$storeissue->id/edit") }}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                    @if($storeissue->approval()->doesntExist())
                                    {!! Form::open(array('url' => "storeissues/$storeissue->id",'method' => 'delete', 'class'=>'d-inline','data-toggle'=>'tooltip','title'=>'Delete')) !!}
                                        {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete'])}}
                                    {!! Form::close() !!}
                                    @endif
                                @endif

                                <a href="{{ url("storeissues/$storeissue->id") }}" data-toggle="tooltip" title="Details" class="btn btn-outline-primary"><i class="fas fa-eye"></i></a>
                                <a href="{{ url("storeissueLog/$storeissue->id/log") }}" data-toggle="tooltip" title="Logs" class="btn btn-dark"><i class="fas fa-history"></i></a>

                            </nobr>
                        </div>
                    <td>
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
