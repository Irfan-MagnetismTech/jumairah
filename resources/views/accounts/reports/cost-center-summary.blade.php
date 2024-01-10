@extends('layouts.backend-layout')
@section('title', 'Collections Report')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
    <style>
        #tableArea{margin-top: 10px;margin-bottom: 10px;}
        table, table th, table td {border-spacing: 0;border: 1px solid #a09e9e;}
        table th, table td{padding:5px;}
        .base_header{font-weight: bold; text-align: left;}
        .balance_header{font-weight: bold; padding-left:20px; text-align: left; }
        .balance_line_style{ font-weight: bold; padding-left:50px; text-align: left; }
        .account_line{ padding-left:80px;  text-align: left; }
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
   Cost Center Summary
@endsection

@section('breadcrumb-button')
    {{-- <a href="{{ url('projects/create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a> --}}
@endsection

@section('sub-title')
    {{--Total: {{ count($projects) }}--}}
@endsection


@section('content')
    <form action="" method="get">
        <div class="row px-2">
            <div class="col-md-1 px-1 my-1" data-toggle="tooltip" title="Output">
                <select name="reportType" id="reportType" class="form-control form-control-sm" required>
                    <option value="list" selected> List </option>
                    <option value="pdf"> PDF </option>
                </select>
            </div>
            <div class="col-md-3 px-1 my-1">
                <input type="text" id="project_name" name="project_name" class="form-control form-control-sm" value="{{$request->project_name ?? $request->project_name}}" placeholder="Enter Project Name" autocomplete="off">
                <input type="hidden" id="project_id" name="project_id" class="form-control form-control-sm" value="{{$request->project_id ?? $request->project_id}}">
            </div>
            <div class="col-md-2 px-1 my-1" id="fromDateArea">
                <input type="text" id="fromDate" name="fromDate" class="form-control form-control-sm" value="{{!empty($fromDate) ? date('d-m-Y', strtotime($fromDate)) : ''}}" placeholder="From Date" autocomplete="off">
            </div>
            <div class="col-md-2 px-1 my-1" id="tillDateArea">
                <input type="text" id="tillDate" name="tillDate" class="form-control form-control-sm" value="{{!empty($tillDate) ? date('d-m-Y', strtotime($tillDate)) : ''}}" placeholder="Till Date" autocomplete="off">
            </div>
            <div class="col-md-1 px-1 my-1">
                <div class="input-group input-group-sm">
                    <button class="btn btn-success btn-sm btn-block"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </div><!-- end row -->
    </form>

    @if($balanceIncomeHeaders->isNotEmpty())
    <h2 class="text-center">Cost Center: {{$request->project_name ?? $request->project_name}}</h2>
    <div class="table-responsive">
        <table style="width: 100%">
            <thead>
                <tr style="text-align: center; background:#116A7B; color: white; font-weight: bold">
                    <td rowspan="2"> Particulars </td>
                    <td rowspan="2"> Opening Balance </td>
                    <td colspan="2"> Transactions </td>
                    <td rowspan="2"> Closing Balance </td>
                </tr>
                <tr style="text-align: center; background:#116A7B; color: white; font-weight: bold">
                    <td> Debit </td>
                    <td> Credit </td>
                </tr>
            </thead>
            <tbody>
                @foreach ($balanceIncomeHeaders as $balanceIncomeHeader)
                    @php
                        $openingBalanceDr  = $balanceIncomeHeader->descendants->pluck('accounts')->flatten()->pluck('ledgers')->flatten()->sum('dr_amount');
                        $openingBalanceCr  = $balanceIncomeHeader->descendants->pluck('accounts')->flatten()->pluck('ledgers')->flatten()->sum('cr_amount');
                        //dump($openingBalanceDr);
                    @endphp
                    <tr style="background-color: #dbecdb ">
                        <td class="balance_header balance_line" id="{{$balanceIncomeHeader->id}}">{{$balanceIncomeHeader->line_text}}</td>
                        <td style="text-align: right">
                           <strong>@money($totalOpeningBalance = $openingBalanceDr + $openingBalanceCr) {{$openingBalanceType = $balanceIncomeHeader->value_type == 'D' ? 'Dr' : 'Cr'}}</strong>
                        </td>
                        <td style="text-align: right">
                            <strong>@money($totalDr = $balanceIncomeHeader->descendants->pluck('accounts')->flatten()->pluck('ledgers')->flatten()->sum('dr_amount'))</strong>
                        </td>
                        <td style="text-align: right">
                            <strong>@money($totalCr = $balanceIncomeHeader->descendants->pluck('accounts')->flatten()->pluck('ledgers')->flatten()->sum('cr_amount'))</strong>
                        </td>
                        <td style="text-align: right">
                            @php
                                $totalClosingCr = $totalOpeningBalance + $totalCr - $totalDr;
                                $totalClosingDr = $totalOpeningBalance + $totalDr - $totalCr;
                            @endphp
                            <strong>
                                @if($openingBalanceType == 'Dr')
                                    @money(abs($totalClosingDr))
                                    {{$totalClosingDr >= 0 ? 'Dr' : 'Cr'}}
                                @else
                                    @money(abs($totalClosingCr))
                                    {{$totalClosingCr >= 0 ? 'Cr' : 'Dr'}}
                                @endif
                            </strong>
                        </td>
                    </tr>
                    @foreach($balanceIncomeHeader->descendants as $balanceLine)
                        @php
                            $totalOPDebit=0; $poDr='';
                            $totalCurrentYear  = 0;
                            $balanceStatusDebit='';
                        @endphp
                        @foreach ($balanceLine->accounts as $account)
                            @php
                                $previousYearTotalDebit = $account->ledgers->sum('dr_amount');
                                $previousYearTotalCredit = $account->ledgers->sum('cr_amount');
                                $currentYearTotalDebit = $account->ledgers->sum('dr_amount');
                                $currentYearTotalCredit = $account->ledgers->sum('cr_amount');
                            @endphp

                            @if(in_array($account->account_type, [1, 5]))
                                @php
                                    $resultDebit = $previousYearTotalDebit - $previousYearTotalCredit;
                                    ($resultDebit >= 0) ? $poDr = "Dr" :  $poDr =  "Cr" ;
                                    $totalOPDebit += $resultDebit;

                                    $currentYearDebit = $currentYearTotalDebit - $currentYearTotalCredit;
                                    // $totalCurrentYear += $currentYearDebit;

                                    $totalCurrentYear += ($resultDebit >= 0) ? $currentYearDebit + $resultDebit : $currentYearDebit;
                                    $balanceStatusDebit = ($totalCurrentYear >= 0) ? "Dr" : "Cr" ;
                                @endphp
                            @elseif(in_array($account->account_type, [2, 4]))
                                @php
                                    $previousYearCredit = $previousYearTotalCredit - $previousYearTotalDebit   ;
                                    ($previousYearCredit >= 0) ? $poDr = "Cr" :  $poDr =  "Dr" ;
                                    $totalOPDebit += $previousYearCredit;

                                    $currentYearCredit = $currentYearTotalCredit - $currentYearTotalDebit;
                                    //echo $currentYearCredit;
                                     $totalCurrentYear += ($previousYearCredit >= 0) ?  $currentYearCredit + $previousYearCredit : $previousYearCredit - $currentYearCredit ;
                                     $balanceStatusDebit =    ($totalCurrentYear >= 0) ? "Cr" : "Dr" ;
                                @endphp
                            @endif

                        @endforeach

                        <tr class="account_row balance_account_{{$balanceIncomeHeader->id}}">
                            <th class="balance_line_style"> {{$balanceLine->line_text}} </th>
                            <th style="text-align: right">
                                @money($totalOPDebit) {{$poDr}}
                            </th>
                            <th style="text-align: right">
{{--                                @dump($balanceLine->accounts->pluck('ledgers')->flatten()->pluck('dr_amount', 'id')->sum('dr_amount'))--}}
                                {{-- @dump($balanceLine->accounts->pluck('ledgers')->flatten()->pluck('dr_amount', 'id')->toArray()) --}}
                                <br>
                                @money($balanceLine->accounts->pluck('ledgers')->flatten()->sum('dr_amount'))
                            </th>
                            <th style="text-align: right">
                                @money($balanceLine->accounts->pluck('ledgers')->flatten()->sum('cr_amount'))
                            </th>

                            <th style="text-align: right">
                                @money(abs($totalCurrentYear)) {{$balanceStatusDebit}}
                            </th>
                        </tr>

                    @endforeach
                @endforeach

            </tbody>
        </table>
    </div>
    @endif

@endsection

@section('script')
{{--    <script src="{{asset('js/jquery.min.js')}}"></script>--}}
    <script>
        var CSRF_TOKEN = "{{csrf_token()}}";
        $(function() {
            $("#project_name").autocomplete({
                source: function (request, response) {
                    $.ajax({
                        url: "{{route('costCenterAutoSuggest')}}",
                        type: 'post',
                        dataType: "json",
                        data: {
                            _token: CSRF_TOKEN,
                            search: request.term
                        },
                        success: function (data) {
                            response(data);
                        }
                    });
                },
                select: function (event, ui) {
                    $('#project_name').val(ui.item.label);
                    $('#project_id').val(ui.item.value);
                    return false;
                }
            }).change(function(){
                if(!$(this).val()){
                    $('#project_id').val(null);
                }
            });

            $(document).on('click', '.balance_line', function(){
                let currentLine = $(this).attr('id');
                $(".balance_account_"+currentLine).toggle();
            });

            $('#fromDate').datepicker({format: "dd-mm-yyyy",autoclose: true,todayHighlight: true});
            $('#tillDate').datepicker({format: "dd-mm-yyyy",autoclose: true,todayHighlight: true});
        });//document.ready

    </script>
@endsection
