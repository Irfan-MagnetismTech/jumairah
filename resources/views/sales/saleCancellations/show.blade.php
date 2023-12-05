@extends('layouts.backend-layout')
@section('title', 'Sale Collection')

@section('breadcrumb-title')
    Information of Sale Cancellation
@endsection

@section('breadcrumb-button')
    <a href="{{ url('salesCollections') }}" class="btn btn-out-dashed btn-sm btn-warning"><i
            class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    {{-- <span class="text-danger">*</span> Marked are required. --}}
@endsection

@section('content-grid', 'col-md-12 col-lg-10 offset-lg-1')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive">
                <table id="dataTable" class="table table-striped table-bordered">
                    <tbody class="text-left">
                        <tr>
                            <td> <strong>Applied Date</strong> </td>
                            <td> {{ $saleCancellation->applied_date }} </td>
                        </tr>
                        <tr>
                            <td><strong>Cancelled By</strong></td>
                            <td> {{ $saleCancellation->cancelled_by }} </td>
                        </tr>
                        <tr>
                            <td><strong>Project Name</strong></td>
                            <td> {{ $saleCancellation->sell->apartment->project->name }} </td>
                        </tr>
                        <tr>
                            <td><strong>Client Name</strong></td>
                            <td> {{$saleCancellation->sell->sellClient->client->name}} </td>
                        </tr>
                        <tr>
                            <td><strong>Sold Price </strong></td>
                            <td> @money($saleCancellation->sell->total_value) </td>
                        </tr>
                        <tr>
                            <td><strong>Paid Amount </strong></td>
                            <td> @money($saleCancellation->paid_amount) </td>
                        </tr>
                        <tr>
                            <td><strong>Service Charge </strong></td>
                            <td> @money($saleCancellation->service_charge) </td>
                        </tr>
                        <tr>
                            <td><strong>Deducted Amount</strong></td>
                            <td> @money($saleCancellation->deducted_amount) </td>
                        </tr>
                        <tr>
                            <td><strong>Refund Amount</strong></td>
                            <td> @money($saleCancellation->refund_amount) </td>
                        </tr>
                        <tr class="breakWords">
                            <td><strong>Remarks</strong></td>
                            <td> {{$saleCancellation->remarks}} </td>
                        </tr>
                        <tr>
                            <td><strong>Attachment</strong></td>
                            <td>
                                @if($saleCancellation->attachment)
                                    <strong><a href="{{asset("storage/$saleCancellation->attachment")}}" target="_blank"> See Current Attachment </a></strong>
                                @else
                                    <strong>Not Uploaded</strong>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div> <!-- end row -->

@endsection

@section('script')

@endsection
