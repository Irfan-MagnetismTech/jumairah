@extends('layouts.backend-layout')
@section('title', 'Sell Details')

@section('breadcrumb-title')
    Showing information of {{strtoupper($sell->sellClient->client->name)}}
@endsection

@section('breadcrumb-button')
    <a href="{{ url('sells') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid',null)

@section('content')
<div class="row">
    <div class="col-lg-6">
        <div class="table-responsive">
            <table id="dataTable" class="table table-striped table-bordered">
                <tbody class="text-left">
                <tr class="bg-info"><td> <strong>Project</strong> </td> <td> <strong>{{ $sell->apartment->project->name}}</strong></td></tr>
                <tr><td> <strong>Apartment Name</strong> </td> <td> {{ $sell->apartment->name}}</td></tr>
                <tr><td> <strong>Apartment Size</strong> </td> <td> @money($sell->apartment_size)</td></tr>
                <tr><td> <strong>Apartment Rate</strong> </td> <td> @money( $sell->apartment_rate)</td></tr>
                <tr><td> <strong>Apartment Price</strong> </td> <td> @money($sell->apartment_value)</td></tr>
                <tr><td> <strong>No. of Parking</strong> </td> <td> {{ $sell->parking_no}}</td></tr>
                <tr><td> <strong>Total Parking Price</strong> </td> <td> @money( $sell->parking_price)</td></tr>
                <tr><td> <strong>No. of Utility</strong> </td> <td> {{ $sell->utility_no}}</td></tr>
                <tr><td> <strong>Utility Rate</strong> </td> <td> @money( $sell->utility_fees)</td></tr>
                <tr><td> <strong>Utility Price</strong> </td> <td> @money( $sell->utility_price)</td></tr>
                <tr><td> <strong>No. of Reserve</strong> </td> <td> {{ $sell->reserve_no}}</td></tr>
                <tr><td> <strong>Reserve Rate</strong> </td> <td> @money( $sell->reserve_rate)</td></tr>
                <tr><td> <strong>Reserve Price</strong> </td> <td>@money( $sell->reserve_fund)</td></tr>
                <tr><td> <strong>Others</strong> </td> <td> @money( $sell->others)</td></tr>
                <tr><td> <strong>Total Apartment Value</strong> </td> <td> @money( $sell->total_value)</td></tr>
                <tr><td> <strong>Booking Amount</strong> </td> <td> @money( $sell->booking_money)</td></tr>
                <tr><td> <strong>Booking Date</strong> </td> <td> {{ $sell->booking_money_date}}</td></tr>
                <tr><td> <strong>Down Payment Date</strong></td> <td>  @money( $sell->downpayment)</td></tr>
                <tr><td> <strong>Down Payment</strong></td> <td>  {{ $sell->downpayment_date}}</td></tr>
                <tr><td> <strong>Remaining Amount</strong></td> <td> @money( $sell->installment)</td></tr>
                <tr><td> <strong>No of Installment</strong></td> <td>  {{ $sell->installmentList->count()}}</td></tr>
                <tr><td> <strong>Sale By</strong></td> <td>  {{ $sell->user->name}}</td></tr>
                <tr><td> <strong>Sale Date</strong></td> <td>  {{ $sell->sell_date}}</td></tr>
                </tbody>
            </table>
        </div>
    </div>
    <!-- sell information end -->

    <div class="col-lg-6">
        <div class="table-responsive">
            <table id="dataTable" class="table table-striped table-bordered">
                @foreach($sell->sellClients as $sellClient)
                    <tbody class="text-left">
                        <tr style="background-color: #0C4A77">
                            <td class="text-white" style="font-weight: 600"> Client Name </td>
                            <td>
                                <a href="{{route('clients.show', $sellClient->client->id)}}" class="text-white"><strong>{{$sellClient->client->name}}</strong></a>
                            </td>
                        </tr>
                        <tr>
                            <td> Contact</td>
                            <td> {{$sellClient->client->contact}} </td>
                        </tr>
                        <tr>
                            <td> Picture</td>
                            <td>
                                @if($sellClient->client->picture)
                                    <img src="{{asset($sellClient->client->picture)}}" alt="" width="80px" height="auto">
                                @else
                                    Not Uploaded
                                @endif
                            </td>
                        </tr>
                        @if(!$loop->last)
                            <tr class="text-center" style="border: none; background: #FFF">
                                <td colspan="2"> </td>
                            </tr>
                        @endif
                    </tbody>
                @endforeach
            </table>
        </div> <!-- end  table-responsive-->

        @if($sell->soldParking->isNotEmpty())
            <div class="row">
                <div class="col-lg-12">
                    <p class="text-center font-weight-bold m-b-0">Parking Information</p>
                    <div class="table-responsive">
                        <table id="dataTable" class="table table-striped table-bordered text-center">
                            <thead>
                            <tr>
                                <th style="background-color: #0C4A77;">Sl.</th>
                                <th style="background-color: #0C4A77;">Parking Name</th>
                                <th style="background-color: #0C4A77;">Parking Rate</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($sell->soldParking as $parking)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$parking->parkingDetails->parking_name}}</td>
                                    <td  class="text-right">@money($parking->parking_rate)</td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot >
                                <tr>
                                    <td colspan="2" class="text-right">Total</td>
                                    <td  class="text-right">@money($sell->parking_price)</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        @endif

        @if($sell->sellClient->client->notifications)
            <div class="row">
                <div class="col-lg-12">
                    <p class="text-center font-weight-bold m-b-0">Notification / Reminder</p>
                    <div class="table-responsive">
                        <table id="dataTable" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th style="background-color: #0C4A77;">Sl.</th>
                                <th style="background-color: #0C4A77;">Delivered Date (Time) </th>
                                <th style="background-color: #0C4A77;">Description</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($sell->sellClient->client->notifications as $notification)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$notification->created_at->format('d-m-Y')}} ({{$notification->created_at->format('h:i:s a')}})</td>
                                    <td class="text-left">
                                        @foreach($notification->data as $key => $data)
                                            <strong> {{$key}} </strong> : {{$data}} <br>
                                        @endforeach
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif

    </div> <!-- end col-lg-- -->

    <!-- sell information start-->

    <div class="col-lg-12">
        <div class="bg-info mt-2 my-0 p-1">
            <h5 class="text-center"> Payment Schedule & Status </h5>
        </div>
        <div class="table-responsive">
            <table id="dataTable" class="table table-bordered text-center">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Schedule <br>Date</th>
                    <th>Schedule <br>Amount</th>
                    <th>Received <br>Date</th>
                    <th>Received <br>Amount</th>
                    <th>Payment <br>Mode</th>
                    <th>Bank Name</th>
                    <th>Cheque No</th>
                    <th>Cheque <br>Dated</th>
                    <th>D/A <br> Days</th>
                    <th>Delay <br> Amount </th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody>
                    @php($rowCount = count($sell->bookingMoneyCollections))
                    @forelse($sell->bookingMoneyCollections as $bookingMoneyCollection)
                    <tr>
                        @if($loop->first)
                            <td rowspan="{{$rowCount}}">BM</td>
                            <td rowspan="{{$rowCount}}"><strong>{{$sell->booking_money_date}}</strong></td>
                            <td rowspan="{{$rowCount}}" class="text-right"><strong>@money($sell->booking_money)</strong></td>
                        @endif
                            <td>{{$bookingMoneyCollection->salesCollection->received_date}}</td>
                            <td class="text-right"><strong>@money($bookingMoneyCollection->amount)</strong></td>
                            <td>{{$bookingMoneyCollection->salesCollection->payment_mode}}</td>
                            <td>{{$bookingMoneyCollection->salesCollection->source_name ?? "---"}}</td>
                            <td>{{$bookingMoneyCollection->salesCollection->transaction_no ?? "---"}}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>{{$bookingMoneyCollection->salesCollection->payment_status}}</td>
                    </tr>
                    @empty
                        <tr>
                            <td>BM</td>
                            <td><strong>{{$sell->booking_money_date}}</strong></td>
                            <td class="text-right"><strong>@money($sell->booking_money)</strong></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    @endforelse


                    @php($totalDownpayments = count($sell->downpaymentCollections))
                    @forelse($sell->downpaymentCollections as $downpaymentCollection)
                    <tr>
                        @if($loop->first)
                            <td rowspan="{{$totalDownpayments}}">DP</td>
                            <td rowspan="{{$totalDownpayments}}"><strong>{{$sell->downpayment_date}}</strong></td>
                            <td rowspan="{{$totalDownpayments}}" class="text-right"><strong>@money($sell->downpayment)</strong></td>
                        @endif
                            <td>{{$downpaymentCollection->salesCollection->received_date}}</td>
                            <td class="text-right"><strong>@money($downpaymentCollection->amount)</strong></td>
                            <td>{{$downpaymentCollection->salesCollection->payment_mode}}</td>
                            <td>{{$downpaymentCollection->salesCollection->source_name ?? "---"}}</td>
                            <td>{{$downpaymentCollection->salesCollection->transaction_no ?? "---"}}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>{{$downpaymentCollection->salesCollection->payment_status}}</td>
                    </tr>
                    @empty
                        <tr>
                            <td>DP</td>
                            <td><strong>{{$sell->downpayment_date}}</strong></td>
                            <td class="text-right"><strong>@money($sell->downpayment)</strong></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    @endforelse

                @php($totalReceived = 0)
                @php($totalDelayDays = 0)
                @php($totalDelayAmount = 0)
                @foreach($sell->installmentList as $installment)
                    @php($countRow = $installment->installmentCollections->count())
                    @forelse($installment->installmentCollections as $installmentCollection)
                        <tr>
                            @if($loop->first)
                                <td rowspan="{{$countRow}}">{{$installment->installment_no}}</td>
                                <td rowspan="{{$countRow}}"><strong>{{$installment->installment_date}}</strong></td>
                                <td rowspan="{{$countRow}}" class="text-right"><strong>@money($installment->installment_amount)</strong></td>
                            @endif
                            <td> {{$installmentCollection->salesCollection->received_date}} </td>
                            <td class="text-right">
                                @php($totalReceived += $installmentCollection->amount)
                                @money($installmentCollection->amount)
                            </td>
                            <td> {{$installmentCollection->salesCollection->payment_mode ?? "--"}} </td>
                            <td> {{$installmentCollection->salesCollection->source_name ?? "--"}} </td>
                            <td> {{$installmentCollection->salesCollection->transaction_no ?? "--"}} </td>
                            <td> {{$installmentCollection->salesCollection->dated ?? "--"}} </td>
                            <td>
                                {{$installmentCollection->applied_days}}
                                @php($totalDelayDays += $installmentCollection->applied_days)
                            </td>
                            <td>
                                @php($totalDelayAmount += $installmentCollection->applied_amount)
                                @money($installmentCollection->applied_amount)
                            </td>
                            <td> {{$installmentCollection->salesCollection->payment_status}}</td>
                        </tr>
                    @empty
                        <tr>
                            <td >{{$installment->installment_no}}</td>
                            <td ><strong>{{$installment->installment_date}}</strong></td>
                            <td class="text-right"><strong>@money($installment->installment_amount)</strong></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    @endforelse
                @endforeach
                </tbody>
                <tfoot class="text-right">

                    <tr class="bg-warning">
                        <td colspan="2" class="text-right"> <strong>Total</strong> </td>
                        <td class="text-right"> <strong> @money($sell->booking_money + $sell->downpayment + $sell->installmentList->sum('installment_amount')) </strong></td>
                        <td></td>
                        <td>
                            @money($sell->downpaymentCollections->sum('amount') + $sell->bookingMoneyCollections->sum('amount') + $totalReceived)
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                            {{$totalDelayDays}}
                        </td>
                        <td>
                            @money($totalDelayAmount)
                        </td>
                        <td></td>
                    </tr>
            </table>
        </div>
    </div>
</div> <!-- end row -->
@endsection

@section('script')

@endsection
