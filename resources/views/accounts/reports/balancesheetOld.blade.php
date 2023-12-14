@extends('layouts.backend-layout')
@section('title', 'Balancesheet')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
    <style>

        #tableArea{margin-top: 10px;margin-bottom: 10px;}
        table, table th, table td {border-spacing: 0;border: 1px solid #a09e9e;}
        table th, table td{padding:5px;}
        .base_header{font-weight: bold; text-align: left;}
        .balance_header{font-weight: bold; padding-left:10px; text-align: left; }
        .balance_line{ font-weight: bold; padding-left:25px; text-align: left; }
        .balance_line:hover{ background: #c5c5c5;}
        .account_line{ padding-left:50px;  text-align: left; }
        table tbody td:nth-child(4),table tbody td:nth-child(3){
            text-align: right;
        }
        .text-right{
            text-align: right;
        }
        .text-right{
            text-align: left;
        }
        .account_row{display: none}
    </style>

@endsection

@section('breadcrumb-title')
    {{--    Breakup of Cost Center--}}
@endsection

@section('breadcrumb-button')
    {{-- <a href="{{ url('projects/create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a> --}}
@endsection

@section('sub-title')
    {{--Total: {{ count($projects) }}--}}
@endsection


@section('content')

    <div>
        <h2 class="text-center">Balance Sheet</h2>
        <hr>
        <div class="table-responsive">
            <table style="width: 100%">
                <tr>
                    <td style="vertical-align: top;" colspan="3">


                        <table style="width: 100%; ">
                            <thead style="background:#227447; color: white; font-weight: bold; font-size: 14px">
                            <tr>
                                <td colspan="3" class="base_header text-center">Liabilities</td>
                            </tr>
                            </thead>
                            <tbody>
                            @php $totalLiabilities=0 @endphp
                            @foreach($liabilities as $liabilityHeader)
                                <tr style="background-color: #dbecdb">
                                    <td class="balance_header">{{$liabilityHeader->line_text}}</td>
                                    <td style="text-align: right"></td>
                                    <td style="text-align: right">
                                        <strong>
                                            @php
                                                $liabilityHeaderAmount = $liabilityHeader->descendants->flatten()->pluck('accounts')->flatten()->pluck('ledgers')->flatten();
                                                $headerTotal = $liabilityHeaderAmount->sum('cr_amount') - $liabilityHeaderAmount->sum('dr_amount');
                                            @endphp
                                            @money(abs($headerTotal))
                                            @php
                                                $totalLiabilities += $headerTotal;
                                            @endphp
                                        </strong>
                                    </td>
                                </tr>
                                @foreach($liabilityHeader->descendants as $balanceLine)
                                    <tr >
                                        <td class="balance_line" id="{{$balanceLine->id}}">
                                            {{$balanceLine->line_text}}
                                        </td>
                                        <td style="text-align: right">
                                            @money($fdh = abs($balanceLine->accounts->sum('creditBalance')))
                                        </td>
                                    </tr>
                                    @foreach ($balanceLine->accounts as $account)
                                        <tr class="account_row balance_account_{{$balanceLine->id}}">
                                            <td class="account_name account_line">
                                                <a href="{{url("ledgers?account_id=$account->id")}}" target="blank">{{$account->account_name}} </a>
                                            </td>
                                            <td style="text-align: right"> @money(abs($account->debitBalance)) </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            @endforeach
                            @php
                                $directIncome = $directIncomes->pluck('descendants')->flatten()->pluck('accounts')->flatten()->pluck('ledgers')->flatten()->sum('cr_amount')
                                    - $directIncomes->pluck('descendants')->flatten()->pluck('accounts')->flatten()->pluck('ledgers')->flatten()->sum('dr_amount');

                                $indirectIncome = $indirectIncomes->pluck('descendants')->flatten()->pluck('accounts')->flatten()->pluck('ledgers')->flatten()->sum('cr_amount')
                                    - $indirectIncomes->pluck('descendants')->flatten()->pluck('accounts')->flatten()->pluck('ledgers')->flatten()->sum('dr_amount');


                                $directExpenses = $directExpenses->pluck('descendants')->flatten()->pluck('accounts')->flatten()->pluck('ledgers')->flatten()->sum('dr_amount')
                                    - $directExpenses->pluck('descendants')->flatten()->pluck('accounts')->flatten()->pluck('ledgers')->flatten()->sum('cr_amount')
                                    ;

                                $indirectExpenses = $indirectExpenses->pluck('descendants')->flatten()->pluck('accounts')->flatten()->pluck('ledgers')->flatten()->sum('dr_amount')
                                    - $indirectExpenses->pluck('descendants')->flatten()->pluck('accounts')->flatten()->pluck('ledgers')->flatten()->sum('cr_amount')
                                    ;

                                $grossProfit = $directIncome - $directExpenses;
                                $netProfit = $grossProfit +  $indirectIncome - $indirectExpenses;

                            @endphp
                            </tbody>
                            <tfoot>
                            <tr>
                                <th class="balance_line" id="">
                                    Profit / Loss
                                </th>
                                <td></td>
                                <th style="text-align: right"> <b>@money($netProfit)</b> </th>
                            </tr>
                            </tfoot>
                        </table>

                    </td>
                    <td style="vertical-align: top" colspan="3">
                        <table style="width: 100%">
                            <thead style="background:#227447; color: white; font-weight: bold; font-size: 14px">
                            <tr>
                                <td colspan="3" class="base_header text-center">Assets</td>
                            </tr>
                            </thead>
                            <tbody>
                            @php $totalAssests=0 @endphp
                            @foreach($assets as $assetHeader)
                                <tr style="background-color: #dbecdb">
                                    <td class="balance_header" colspan="">{{$assetHeader->line_text}}</td>
                                    <td style="text-align: right"></td>
                                    <td style="text-align: right">
                                        <strong>
                                            @php
                                                $assetHeaderAmount = $assetHeader->descendants->flatten()->pluck('accounts')->flatten()->pluck('ledgers')->flatten();
                                                $headerTotal = $assetHeaderAmount->sum('dr_amount') - $assetHeaderAmount->sum('cr_amount');
                                            @endphp
                                                @money(abs($headerTotal))
                                            @php  $totalAssests += $headerTotal; @endphp
                                        </strong>
                                    </td>
                                </tr>
                                @foreach($assetHeader->descendants as $balanceLine)
                                    <tr>
                                        <td class="balance_line" id="{{$balanceLine->id}}">
                                            {{$balanceLine->line_text}}
                                        </td>
                                        <td style="text-align: right">
                                            @money(abs($balanceLine->accounts->sum('debitBalance')))

                                        </td>
                                    </tr>
                                    @foreach ($balanceLine->accounts as $account)
                                        <tr class="account_row balance_account_{{$balanceLine->id}}">
                                            <td class="account_name account_line"><a href="{{url("ledgers?account_id=$account->id")}}" target="blank">{{$account->account_name}} </a></td>
                                            <td style="text-align: right"> @money(abs($account->debitBalance)) </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            @endforeach

                            </tbody>
                            <tfoot>

                            </tfoot>
                        </table>
                    </td>
                </tr>
                <tr style="background:#e3e3e3">
                    <th colspan="2" class="text-right" style="width: 60%; border-right: none"> Total Liabilities</th>
                    <th class="text-right" style="border-left: none">
                        @money(abs($netProfit > 0 ? $totalLiabilities + $netProfit : $totalLiabilities - $netProfit ))
                    </th>
                    <th colspan="2" class="text-right" style="width: 60%; border-right: none">Total Assets</th>
                    <th class="text-right" style="border-left: none">
                        @money(abs($totalAssests))
                    </th>
                </tr>

            </table>

        </div>
    </div>

@endsection

@section('script')
    <script>
        $(function(){
            $(document).on('click', '.balance_line', function(){
                let currentLine = $(this).attr('id');
                $(".balance_account_"+currentLine).toggle();
            });
        });
    </script>
@endsection
