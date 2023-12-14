@extends('layouts.backend-layout')
@section('title', 'General Bill Details')

@section('breadcrumb-title')
    General Bill Details
@endsection

@section('breadcrumb-button')
    <a href="{{ url('generalBill') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('content-grid',null)

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive">
                <table id="dataTable" class="table table-striped table-bordered">
                    <tbody class="text-left">
                    <tr style="background-color: #0C4A77;color: white"><td> <strong>MPR No.</strong> </td> <td> <strong>{{$generalBill->mpr->mpr_no  ?? 'N/A'}}</strong></td></tr>
                    <tr style="background-color: #0C4A77;color: white"><td> <strong>MRR No.</strong> </td> <td> <strong>{{$generalBill->mrr->mrr_no  ?? 'N/A'}}</strong></td></tr>
                    <tr style="background-color: #0C4A77;color: white"><td> <strong>Project Name</strong> </td> <td> <strong>{{$generalBill->project->name}}</strong></td></tr>
                    <tr><td> <strong>Applied By</strong> </td> <td> {{$generalBill->user->employee->fullName ?? 'N/A'}}</td></tr>
                    <tr><td> <strong>Designation</strong> </td> <td>{{$generalBill->user->designation->name ?? 'N/A'}}</td></tr>
                    <tr><td> <strong>Department</strong> </td> <td> {{$generalBill->user->department->name ?? 'N/A'}}</td></tr>
                    <tr><td> <strong>Date</strong> </td> <td>  {{ $generalBill->date}}</td></tr>
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
            @foreach( $generalBill->generalBilldetails as $generalBilldetail)
                <tr>
                    <td> {{$generalBilldetail->account->account_name}} </td>
                    <td> {{$generalBilldetail->description}} </td>
                    <td> {{$generalBilldetail->remarks}} </td>
                    <td>
                        @if(!empty($generalBilldetail) && $generalBilldetail->attachment)
                        <a href='{{route("generalBilldetail.ShowFile",\Illuminate\Support\Facades\Crypt::encryptString($generalBilldetail->id))}}' target="_blank">Show Attachment</a>
                        @else
                        <p class="text-muted">No attachment</p>
                        @endif
                    </td>
                    <td class="text-right"> @money($generalBilldetail->amount) </td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
            <tr>
                <td colspan="4" class="text-right">Total Amount</td>
                <td class="text-right">@money($generalBill->total_amount)</td>
            </tr>
            </tfoot>
        </table>
    </div>
@endsection
