@extends('layouts.backend-layout')
@section('title', 'IOU Slip Details')

@section('breadcrumb-title')
    IOU Slip Details
@endsection

@section('breadcrumb-button')
    <a href="{{ url('ious') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    {{--    <span class="text-danger">*</span> Marked are required.--}}
@endsection

@section('content-grid',null)

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive">
                <table id="dataTable" class="table table-striped table-bordered">
                    <tbody class="text-left">

                    <tr style="background-color: #0C4A77;color: white"><td> <strong>Iou No.</strong> </td> <td> <strong>{{ $iou->iou_no ?? 'N/A'}}</strong></td></tr>
                    <tr><td> <strong>Project Name</strong> </td> <td>  {{$iou->costCenter->name}}</td></tr>
                    <tr><td> <strong>Applied Date</strong> </td> <td>  {{$iou->applied_date}}</td></tr>
                    <tr><td> <strong>Iou For</strong> </td>
                         <td>
                        @if ($iou->type == 0)
                            Employee
                        @elseif ($iou->type == 1)
                            Supplier
                        @elseif($iou->type == 2)
                            Construction
                        @elseif ($iou->type == 3)
                            EME
                        @endif
                        @if ($iou->type != 0)
                            <span class="font-weight-bold ml-5"> Supplier Name:</span><span>{{ $iou->supplier->name }} </span>
                        @endif
                        </td>
                    </tr>
                    @if ($iou->type == 1)
                    <tr>
                        <td> <strong>PO No.</strong> </td>
                        <td>
                            {{$iou->po_no}}
                        </td>
                    </tr>
                    @elseif ($iou->type == 2)
                    <tr>
                        <td> <strong>Work Order No.</strong> </td>
                        <td>
                            {{$iou->workOrder->workorder_no}}
                        </td>
                    </tr>
                    @elseif ($iou->type == 3)
                    <tr>
                        <td> <strong>Work Order No.</strong> </td>
                        <td>
                            {{$iou->EmeWorkOrder->workorder_no}}
                        </td>
                    </tr>
                    @endif
                
                    <tr><td> <strong>Applied By</strong> </td> <td>  {{ $iou->appliedBy->name}}</td></tr>
                    <tr><td> <strong>Note</strong> </td> <td>  {{ $iou->remarks}}</td></tr>
                    {{-- <tr><td> <strong>Status</strong> </td> <td class="text-c-orenge"><strong>{{ $iou->status}}</strong></td></tr> --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>



    <div class="table-responsive">
        <table id="example" class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>Purpose</th>
                    @if($iou->type == 0)
                        <th>Remarks</th> 
                    @endif
                    <th width="200px">Amount</th>

                </tr>
                </thead>
                <tbody>
                @foreach( $iou->ioudetails as $ioudetail)
                    <tr>
                        <td> {{$ioudetail->purpose}}</td>
                        @if($iou->type == 0)
                            <td>{{$ioudetail->remarks}} </td>
                        @endif
                            <td class="text-center">@money($ioudetail->amount) </td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td @if($iou->type == 0) colspan="2" @endif class="text-right">Total Amount</td>
                        <td class="text-center"><strong>@money($iou->total_amount)</strong></td>
                    </tr>
                </tfoot>
        </table>
    </div>
@endsection
