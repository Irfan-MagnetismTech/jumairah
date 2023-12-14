@extends('layouts.backend-layout')
@section('title', 'Payment History')

@section('breadcrumb-title')
    Payment History of {{strtoupper($sell->client->name)}}
@endsection

@section('breadcrumb-button')
    <a href="{{ url('sells') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
{{--    <span class="text-danger">*</span> Marked are required.--}}
@endsection

@section('content-grid',null)

@section('content')
<div class="row">
    <div class="col-12">
        <div class="bg-warning mt-2 my-0 p-1">
            <h5 class="text-center"> Payment History </h5>
        </div>
        <div class="table-responsive">
            <table id="dataTable" class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>Purpose</th>
                    <th>Schedule <br>Date</th>
                    <th>Scheduled <br>Amount</th>
                    <th>Received Date</th>
                    <th>Received <br>Amount</th>


                    <th>Chq. H. Date</th>
                    <th>Applied <br>Amount</th>
                    <th>Due Days</th>
                    <th>Delay Charge <br>Rate(%)</th>
                    <th>Delay Charge <br>Amount</th>
                    <th>Remarks</th>
                </tr>
                </thead>
                <tbody>

                @forelse($sell->salesCollections as $key => $salesCollection)
                    @php($countRow=count($salesCollection->salesCollectionDetails))
                    @foreach($salesCollection->salesCollectionDetails as $collectionDetail)
                        <tr>
                            <td>{{$collectionDetail->particular}} {{$collectionDetail->installment_no ? "- $collectionDetail->installment_no" : null}}</td>
                            <td>
                                @if($collectionDetail->installment_no)
                                    {{$collectionDetail->salesCollection->sell->installmentList->where('installment_no', $collectionDetail->installment_no)->first()->installment_date}}
                                @endif
                            </td>
                            <td class="text-right">
                                @if($collectionDetail->installment_no)
                                    {{$collectionDetail->salesCollection->sell->installmentList->where('installment_no', $collectionDetail->installment_no)->first()->installment_amount}}
                                @elseif($collectionDetail->particular == "Booking Money")
                                    {{$collectionDetail->salesCollection->sell->installmentList->where('installment_no', $collectionDetail->installment_no)->first()->installment_amount}}
                                @endif
                            </td>
                            <td rowspan="{{$countRow}}">{{$salesCollection->received_date}}</td>
                            <td class="text-right"> {{$collectionDetail->amount}}</td>



                            <td>{{$collectionDetail->dated}}</td>

                            <td>??</td>
                            <td>Later??</td>
                            <td>Later??</td>
                            <td>Later??</td>
                            <td class="text-left breakWords">{{$salesCollection->remarks}}</td>
                        </tr>
                    @endforeach
                @empty
                    <tr>
                        <td colspan="11"> <h5 class="text-muted text-center my-2 text-left"> No Data Found Based on your query. </h5> </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div> <!-- col-12 -->
</div> <!-- end row -->
@endsection

@section('script')

@endsection
