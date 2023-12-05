@extends('layouts.backend-layout')
@section('title', 'Advance Adjustment Details')

@section('breadcrumb-title')
    Advance Adjustment Details
@endsection

@section('breadcrumb-button')
    <a href="{{ url('advanceadjustments') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('content-grid',null)

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive">
                <table id="dataTable" class="table table-striped table-bordered">
                    <tbody class="text-left">
                    <tr style="background-color: #0C4A77;color: white"><td> <strong>IOU No.</strong> </td> <td> <strong>{{$advanceadjustment->iou_id}}</strong></td></tr>
                    <tr style="background-color: #0C4A77;color: white"><td> <strong>MPR No.</strong> </td> <td> <strong>{{$advanceadjustment->iou->mpr_no}}</strong></td></tr>
                    <tr style="background-color: #0C4A77;color: white"><td> <strong>Project Name</strong> </td> <td> <strong>{{$advanceadjustment->iou->costCenter->name}}</strong></td></tr>
                    {{-- <tr><td> <strong>Cheque Issue</strong> </td> <td>{{$advanceadjustment->cheque_issue}}</td></tr> --}}
                    <tr><td> <strong>Applied By</strong> </td> <td> {{$advanceadjustment->iou->appliedBy->name}}</td></tr>
                    <tr><td> <strong>Designation</strong> </td> <td>{{$advanceadjustment->iou->appliedBy->designation->name}}</td></tr>
                    <tr><td> <strong>Department</strong> </td> <td> {{$advanceadjustment->iou->appliedBy->department->name}}</td></tr>
                    <tr><td> <strong>Date</strong> </td> <td>  {{ $advanceadjustment->date}}</td></tr>
                    {{-- <tr><td> <strong>Status</strong> </td> <td class="text-c-orenge"><strong>{{ $advanceadjustment->status}}</strong></td></tr> --}}
                    <tr><td> <strong>Image</strong> </td> <td class="text-c-orenge">
                        @if(!empty($advanceadjustment) && $advanceadjustment->image)
                            <p >
                                <a href="{{ Storage::url($advanceadjustment->image) }}" target="_blank">
                                    See Current Picture
                                </a>
                            </p>
                        @endif   
                    </td></tr> 
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
                <th>Description</th>
                <th>Remarks</th>
                <th>Attachment</th>
                <th>Amount</th>
            </tr>
            </thead>
            <tbody>
            @foreach( $advanceadjustment->advanceadjustmentdetails as $advanceadjustmentdetail)
                <tr>
                    <td> {{$advanceadjustmentdetail->account->account_name}} </td>
                    <td> {{$advanceadjustmentdetail->description}} </td>
                    <td> {{$advanceadjustmentdetail->remarks}} </td>
                    <td><a href='{{route("advanceadjustments.ShowFile",\Illuminate\Support\Facades\Crypt::encryptString($advanceadjustmentdetail->id))}}' target="_blank">Show Attachment</a> </td>
                    <td class="text-right"> @money($advanceadjustmentdetail->amount) </td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
            <tr>
                <td colspan="3" class="text-right">Total Amount</td>
                <td class="text-right">@money($advanceadjustment->grand_total)</td>
            </tr>
            <tr>
                <td colspan="3" class="text-right">Balance</td>
                <td class="text-right">@money($advanceadjustment->balance)</td>
            </tr>
            </tfoot>
        </table>
    </div>
@endsection
