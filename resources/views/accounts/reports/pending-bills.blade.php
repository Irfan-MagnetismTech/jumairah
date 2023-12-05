@extends('layouts.backend-layout')
@section('title', 'Pending Bills')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title')
    Pending Bills
@endsection


@section('breadcrumb-button')
    <a href="{{ route('vouchers.create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
@endsection

@section('sub-title')
    Total: {{ count($transactions) }}
@endsection

@section('content')
    <!-- put search form here.. -->
    <div class="table-responsive">
        <table id="dataTable" class="table  table-bordered">
            <thead>
            <tr>
                <th>SL</th>
                <th>Date</th>
                {{-- <th>Voucher Type</th> --}}
                <th>Account Head</th>
                <th>Bill No</th>
                <th> Amount</th>
{{--                <th>Status</th>--}}
                <th>Paid Amount</th>
            </tr>
            </thead>
            <tfoot>

            </tfoot>
            <tbody>
            @foreach($transactions as $key => $transaction)
                @php $rows = $transaction->count();
                    $totalPaid = 0; $discountAmount = 0;
                @endphp
                @foreach($transaction as $transactiondata)
                    @php
                        $discount = \App\LedgerEntry::whereHas('transaction', function ($q) use($transactiondata){
                                    $q->where('bill_no', $transactiondata->bill_no);
                                })->where('pourpose', 'discount')->get();
                        $discountAmount = $discount->sum('dr_amount');
                    @endphp
                    <tr>
                        <td rowspan="">{{$rows}} </td>
                        <td rowspan=""> {{ $transactiondata->transaction_date ? date('d-m-Y', strtotime($transactiondata->transaction_date)):null }}</td>
                        {{-- <td rowspan=""> {{ $transactiondata->voucher_type }}</td> --}}
                        <td class="text-left">
                            @foreach ($transactiondata->ledgerEntries as $ledgerEntry)
                                <a href="{{url("ledgers?account_id=".$ledgerEntry->account->id)}}" target="blank">
                                    @if($ledgerEntry->dr_amount > 0)
                                        <span style=""> {{$ledgerEntry->account->account_name}} </span>
                                    @else
                                        <span style="margin-left: 50px"> {{$ledgerEntry->account->account_name}} </span>
                                    @endif
                                    <span style="color: black"> {{$ledgerEntry->pourpose ? '- ( ' .$ledgerEntry->pourpose. ' )' :  ''}} </span></a>
                                <br>
                            @endforeach
                        </td>
                        @if($loop->first)
                            <td rowspan="{{$rows}}">{{$transactiondata->bill_no}}</td>
                        @endif
                        <td class="text-right">
                            @foreach ($transactiondata->ledgerEntries as $ledgerEntry)
                                @if($ledgerEntry->dr_amount) @money($ledgerEntry->dr_amount)  @endif <br>
                            @endforeach
                        </td>

{{--                        <td> <button class="btn btn-sm btn-warning btn-pill"> Pending </button> </td>--}}
                        @if($loop->first)
                            <td rowspan="{{$rows}}" class="text-right"> @php $totalPaid = $transactiondata->paid_bill_sum_dr_amount @endphp </td>
                        @endif
                    </tr>
                @endforeach
                @if($discountAmount)
                    <tr>
                        <td colspan="4" class="">
                            <strong> Discount </strong>
                        </td>
                        <td class="text-right"><b>@money($discountAmount)</b></td>
                        <td></td>
                    </tr>
                @endif
                <tr>
                    <th colspan="4" style="background-color: #ddeee8; color: black">TOTAL  </th>
                    <th class="text-right" style="background-color: #ddeee8; color: black">@money($transaction->pluck('ledgerEntries')->flatten()->sum('dr_amount') - $discountAmount)</th>
                    <th class="text-right" style="background-color: #ddeee8; color: black">@money($totalPaid)</th>
                </tr>

{{--                --}}
{{--<!--                    <tr>--}}
{{--                        <td rowspan="">{{1+$key}}</td>--}}
{{--                        <td rowspan=""> {{ $data->transaction_date ? date('d-m-Y', strtotime($data->transaction_date)):null }}</td>--}}
{{--                        <td rowspan=""> {{ $data->voucher_type }}</td>--}}
{{--                        <td class="text-left">--}}
{{--                            @foreach ($data->ledgerEntries as $ledgerEntry)--}}
{{--                                <a href="{{url("ledgers?account_id=".$ledgerEntry->account->id)}}" target="blank">{{$ledgerEntry->account->account_name}}--}}
{{--                                    <span style="color: black"> {{$ledgerEntry->pourpose ? '- ( ' .$ledgerEntry->pourpose. ' )' :  ''}} </span></a>--}}
{{--                                <br>--}}
{{--                            @endforeach--}}
{{--                        </td>--}}
{{--                        <td>{{$data->bill_no}}</td>--}}
{{--                        <td class="text-right">--}}
{{--{{&#45;&#45;                            {{$data->ledgerEntries->sum('dr_amount')}}&#45;&#45;}}--}}
{{--                            @foreach ($data->ledgerEntries as $ledgerEntry)--}}
{{--                                @if($ledgerEntry->dr_amount)--}}
{{--                                    {{$ledgerEntry->dr_amount - $ledgerEntry->cr_amount}}--}}
{{--                                @endif <br>--}}
{{--                            @endforeach--}}
{{--                        </td>--}}
{{--                        <td class="text-right">--}}
{{--                            @foreach ($data->ledgerEntries as $ledgerEntry)--}}
{{--                                @if($ledgerEntry->cr_amount)--}}
{{--                                    @money($ledgerEntry->cr_amount - $ledgerEntry->dr_amount)--}}
{{--                                @endif <br>--}}
{{--                            @endforeach--}}
{{--                        </td>--}}
{{--                        <td> <button class="btn btn-sm btn-warning btn-pill"> Pending </button> </td>--}}
{{--                        <td>--}}
{{--                            @money(abs($data->paid_bill_sum_dr_amount))--}}
{{--                        </td>--}}
{{--                    </tr>-->--}}
            @endforeach
{{--            {{die()}}--}}
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
