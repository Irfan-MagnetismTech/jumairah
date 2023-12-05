@extends('layouts.backend-layout')
@section('title', 'Scrap Form')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title')
    List of Scrap Goods
@endsection


@section('breadcrumb-button')
    <a href="{{ url('scrapForm/create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
@endsection

    @section('content')
            <!-- put search form here.. -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>SGSF No.</th>
                    <th>Applied Date</th>
                    <th>Applied By</th>
                    <th>Project Name</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>SL</th>
                    <th>SGSF No.</th>
                    <th>Applied Date</th>
                    <th>Applied By</th>
                    <th>Project Name</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </tfoot>
            <tbody>
            @foreach($ScrapFormDetails as $key => $ScrapFormDetail)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$ScrapFormDetail->sgsf_no}}</td>
                    <td>{{$ScrapFormDetail->applied_date}}</td>
                    <td>{{$ScrapFormDetail->user->name}}</td>
                    <td>{{$ScrapFormDetail->costCenter->name}}</td>
                    <td>{{$ScrapFormDetail->status}}</td>
                    {{-- <td>
                        @if($requisition->approval()->exists())
                            @foreach($requisition->approval as $approval)
                                <span class="badge @if($approval->status == 'Approved') bg-primary @else bg-warning @endif bg-warning badge-sm">
                                    {{ $approval->status }} - {{$approval->user->employee->department->name ?? ''}} - {{$approval->user->employee->designation->name ?? ''}}
                                </span><br>
                            @endforeach
                        @else
                            <span class="badge bg-warning badge-sm">{{ 'Pending' }}</span>
                        @endif
                    </td> --}}
                    <td>
                        <div class="icon-btn">
                            <nobr>
                                @php
                                    $approval = \App\Approval\ApprovalLayerDetails::whereHas('approvalLayer', function ($q) use ($ScrapFormDetail){
                                        $q->where([['name','SCRAP FORM'],['department_id',$ScrapFormDetail->user->department_id]]);
                                    })->wheredoesnthave('approvals',function ($q) use($ScrapFormDetail){
                                        $q->where('approvable_id',$ScrapFormDetail->id)->where('approvable_type',\App\BD\ScrapForm::class);
                                    })->orderBy('order_by','asc')->first();
                                @endphp

                                @if((!empty($approval) && $approval->designation_id == auth()->user()->designation?->id && $approval->department_id == auth()->user()->department_id) || (!empty($approval) && auth()->user()->hasAnyRole(['admin','super-admin'])))
                                    <a href="{{ url("scrapForm/approved/$ScrapFormDetail->id/1") }}" data-toggle="tooltip" title="Approve SCRAP" class="btn btn-success"><i class="fa fa-check" aria-hidden="true"></i></a>
                                @endif

                                @if($ScrapFormDetail->approval()->doesntExist() || auth()->user()->hasAnyRole(['admin','super-admin']))
                                    <a href="{{ url("scrapForm/$ScrapFormDetail->id/edit") }}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                    @if($ScrapFormDetail->approval()->doesntExist())
                                    {!! Form::open(array('url' => "scrapForm/$ScrapFormDetail->id",'method' => 'delete', 'class'=>'d-inline','data-toggle'=>'tooltip','title'=>'Delete')) !!}
                                    {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete'])}}
                                    {!! Form::close() !!}
                                    @endif
                                @endif
                                {{-- <a href="{{ url('scrapForm-pdf') }}/{{ $ScrapFormDetail->id }}" title="PDF" class="btn btn-out-dashed btn-sm btn-success"><i class="fas fa-file-pdf"></i></a> --}}
                                {{-- <a href="{{ url("scrapForm/$ScrapFormDetail->id") }}" data-toggle="tooltip" title="Details" class="btn btn-outline-primary"><i class="fas fa-eye"></i></a> --}}

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
