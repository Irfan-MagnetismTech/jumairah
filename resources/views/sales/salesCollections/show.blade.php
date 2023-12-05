@extends('layouts.backend-layout')
@section('title', 'Sale Collection')

@section('breadcrumb-title')
   Information of Sale Collection
@endsection

@section('breadcrumb-button')
    <a href="{{ url('salesCollections') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
{{--    <span class="text-danger">*</span> Marked are required.--}}
@endsection

@section('content-grid', 'col-md-12 col-lg-10 offset-lg-1')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive">
                <table id="dataTable" class="table table-striped table-bordered">
                    <tbody class="text-left">
{{--                    <tr class="bg-success"><td> <strong>Sale Collection ID</strong> </td> <td> <strong>{{ $salesCollection->id}}</strong></td></tr>--}}
                    <tr  class="bg-success breakWords"><td> <strong>Client Name</strong> </td> <td> {{$salesCollection->sell->sellClient->client->name}}</td></tr>
                    <tr><td> <strong>Project</strong> </td><td>{{$salesCollection->sell->apartment->project->name}}</td></tr>
                    <tr><td> <strong>Apartment ID</strong> </td> <td>  {{$salesCollection->sell->apartment->name}}</td></tr>
                    <tr><td> <strong>Particular</strong> </td>
                        <td>Later???</td>
                    </tr>

                    <tr><td> <strong>Payment Mode</strong> </td> <td> {{ $salesCollection->payment_mode}}</td></tr>
                    @if(($salesCollection->payment_mode)!='Cash')
                    <tr><td> <strong>Bank Name</strong> </td> <td> {{ $salesCollection->source_name}}</td></tr>
                    <tr><td> <strong>Transaction No.</strong> </td> <td> {{$salesCollection->transaction_no}}</td></tr>
                    <tr><td> <strong>Dated</strong> </td> <td> {{$salesCollection->dated}}</td></tr>
                    @endif
                    <tr><td> <strong>Received Date</strong> </td> <td> {{$salesCollection->received_date}}</td></tr>
                    <tr><td> <strong>Received Amount</strong> </td> <td> @money($salesCollection->received_amount)</td></tr>
{{--                    <tr><td> <strong>Rebate Days</strong> </td> <td>{{ $salesCollection->salesCollectionDetails->rebate_days}} </td></tr>--}}
{{--                    <tr><td> <strong>Rebate Amount</strong> </td> <td>{{ $salesCollection->salesCollectionDetails->rebate_amount}}</td></tr>--}}
                    <tr><td> <strong>Approval Status </strong> </td>
                        <td>Later???</td>
                    </tr>
{{--                    @if(($salesCollection->salesCollectionApprovals->approval_status)!='Honored')--}}
                    <tr><td> <strong>Approval Date</strong> </td>
                        <td>Later???</td>
                    </tr>
                    <tr><td> <strong>Cancellation\Dishonored Reason</strong> </td>
                        <td>Later???</td>
                    </tr>
{{--                    @endif--}}
                    </tbody>
                </table>
            </div>
        </div>

    </div> <!-- end row -->

@endsection

@section('script')

@endsection



