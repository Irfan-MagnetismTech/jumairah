@extends('layouts.backend-layout')
@section('title', 'salary')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title')
    List of Financial Allocations
@endsection


@section('breadcrumb-button')
    <a href="{{ route('allocations.create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
@endsection

@section('sub-title')
{{--    Total: {{ count($allocations) }}--}}
@endsection

@section('content')
    <!-- put search form here.. -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>SL</th>
                <th>Month</th>
                <th>Project </th>
                <th>SOD Amount </th>
                <th>HBL Amount</th>
                <th>Total</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>SL</th>
                <th>Month</th>
                <th>Project </th>
                <th>SOD Amount </th>
                <th>HBL Amount</th>
                <th>Total</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            </tfoot>
            <tbody>
            @foreach($allocations as $key => $allocation)
                <tr>
                    <td>{{1+$key}}</td>
                    <td> {{ $allocation->first()->from_month }} - {{ $allocation->first()->to_month }} </td>
                    <td class="text-left">
                        @foreach($allocation->financialAllocationDetails as $data)
                            {{$data->costCenter->name ?? ''}} <br>
                        @endforeach
                    </td>
                    <td class="text-right">
                        @foreach($allocation->financialAllocationDetails as $data)
                            {{number_format($data->sod_allocate_amount,2) ?? ''}} <br>
                        @endforeach
                    </td>
                    <td class="text-right">
                        @foreach($allocation->financialAllocationDetails as $data)
                            {{number_format($data->hbl_allocate_amount,2) ?? ''}} <br>
                        @endforeach
                    </td>

                    <td class="text-right">
                        @foreach($allocation->financialAllocationDetails as $data)
                            {{number_format($data->total_allocation,2) ?? ''}} <br>
                        @endforeach
                    </td>
                    <td>
                        @if($allocation->approval()->exists())
                            @foreach($allocation->approval as $approval)
                                <span class="badge @if($approval->status == 'Approved') bg-primary @else bg-warning @endif bg-warning badge-sm">
                                    {{ $approval->status }} - {{$approval->user->employee->designation->name ?? ''}}
                                </span><br>
                            @endforeach
                        @else
                            <span class="badge bg-warning badge-sm">{{ 'Pending' }}</span>
                        @endif
                    </td>
                    <td rowspan="">
                        <div class="icon-btn">
                            <nobr>
                                @php
                                    $approval = \App\Approval\ApprovalLayerDetails::
                                    whereHas('approvalLayer', function ($q){
                                        $q->where('name','Allocation');
                                    })->wheredoesnthave('approvals',function ($q) use($allocation){
                                        $q->where('approvable_id',$allocation->id)->where('approvable_type',\App\Account\Allocation::class);
                                    })
                                    ->orderBy('order_by','asc')->first();

                                    //dump($approval, auth()->user()->designation?->id)
                                @endphp

                                @if(!empty($approval) && ($approval->designation_id == auth()->user()->designation?->id) )
                                    <a href="{{ url("financial-allocations-approval/$allocation->id/1")}}" data-toggle="tooltip" title="Approved" class="btn btn-outline-info"><i class="fas fa-check"></i></a>
                                @endif
                                <a href="{{ route('financial-allocations.show',$allocation->id)}}" data-toggle="tooltip" title="View" class="btn btn-outline-primary"><i class="fas fa-eye"></i></a>
                                @if($allocation->approval()->doesntExist())
                                    <a href="{{ route("financial-allocations.edit", $allocation->id)}}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                    {!! Form::open(array('url' => "accounts/financial-allocation/$allocation->id",'method' => 'delete', 'class'=>'d-inline','data-toggle'=>'tooltip','title'=>'Delete')) !!}
                                    {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete'])}}
                                    {!! Form::close() !!}
                                @endif
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
