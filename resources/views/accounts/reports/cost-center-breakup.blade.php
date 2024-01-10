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
        .balance_line{ font-weight: bold; padding-left:50px; text-align: left; }
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
    Breakup of Cost Center
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
                        $balanceHeaderOBDr = $balanceIncomeHeader->descendants->pluck('accounts')->flatten()->pluck('previousYearLedger')->flatten()->sum('dr_amount');
                        $balanceHeaderOBCr = $balanceIncomeHeader->descendants->pluck('accounts')->flatten()->pluck('previousYearLedger')->flatten()->sum('cr_amount');
                        $balanceHeaderDr= $balanceIncomeHeader->descendants->pluck('accounts')->flatten()->pluck('currentYearLedger')->flatten()->sum('dr_amount');
                        $balanceHeaderCr= $balanceIncomeHeader->descendants->pluck('accounts')->flatten()->pluck('currentYearLedger')->flatten()->sum('cr_amount');
                        $BHvalueType = $balanceIncomeHeader->value_type;
                        if ($BHvalueType == 'D'){
                            $balanceHeaderOBTotal = $balanceHeaderOBDr - $balanceHeaderOBCr;
                            $balanceHeaderType = $balanceHeaderOBTotal >= 0 ? 'Dr' : 'Cr';
                            $balanceHeaderClosing  =  $balanceHeaderOBTotal + $balanceHeaderDr - $balanceHeaderCr;
                            $balanceHeaderClType = $balanceHeaderClosing >= 0 ? 'Dr' : 'Cr';
                        }else{
                            $balanceHeaderOBTotal = $balanceHeaderOBCr - $balanceHeaderOBDr ;
                            $balanceHeaderType = $balanceHeaderOBTotal >=0 ?  'Cr' : 'Dr' ;
                            $balanceHeaderClosing  =  $balanceHeaderOBTotal + $balanceHeaderCr - $balanceHeaderDr;
                            $balanceHeaderClType = $balanceHeaderClosing >= 0 ? 'Cr' : 'Dr' ;
                        }
                    @endphp

                    <tr style="background-color: #dbecdb ">
                        <td class="balance_header">{{$balanceIncomeHeader->line_text}}</td>
                        <td style="text-align: right">
                            <strong> @money(abs($balanceHeaderOBTotal)) {{$balanceHeaderType}} </strong>
                        </td>
                        <td style="text-align: right">
                            <strong>@money($balanceHeaderDr)</strong>
                        </td>
                        <td style="text-align: right">
                            <strong>@money($balanceHeaderCr)</strong>
                        </td>
                        <td style="text-align: right"> <strong>@money(abs($balanceHeaderClosing)) {{$balanceHeaderClType}}</strong></td>
                    </tr>
                    @foreach($balanceIncomeHeader->descendants as $balanceLine)
                        @php
                            $balanceLineOBDr = $balanceLine->accounts->pluck('previousYearLedger')->flatten()->sum('dr_amount');
                            $balanceLineOBCr = $balanceLine->accounts->pluck('previousYearLedger')->flatten()->sum('cr_amount');
                            $balanceLineDr = $balanceLine->accounts->pluck('currentYearLedger')->flatten()->sum('dr_amount');
                            $balanceLineCr = $balanceLine->accounts->pluck('currentYearLedger')->flatten()->sum('cr_amount');
                            $valueType = $balanceLine->value_type;
                            if ($valueType == 'D'){
                                $balanceLineOBTotal = $balanceLineOBDr-$balanceLineOBCr;
                                $balanceLineType = $balanceLineOBTotal >=0 ? 'Dr' : 'Cr';
                                $balanceLineClosing  =  $balanceLineOBTotal + $balanceLineDr - $balanceLineCr;
                                $balanceLineClType = $balanceLineClosing >= 0 ? 'Dr' : 'Cr';
                            }else{
                                $balanceLineOBTotal = $balanceLineOBCr - $balanceLineOBDr;
                                $balanceLineType = $balanceLineOBTotal >=0 ?  'Cr' : 'Dr' ;
                                $balanceLineClosing  =  $balanceLineOBTotal + $balanceLineCr - $balanceLineDr;
                                $balanceLineClType = $balanceLineClosing >= 0 ? 'Cr' : 'Dr' ;
                            }

                        @endphp
                        <tr style="background-color: #dbe8e8 ">
                            <td class="balance_line" id="{{$balanceLine->id}}"> {{$balanceLine->line_text}} </td>
                            <td style="text-align: right"> @money(abs($balanceLineOBTotal)) {{$balanceLineType}}</td>
                            <td style="text-align: right"> @money($balanceLineDr)</td>
                            <td style="text-align: right"> @money($balanceLineCr)</td>
                            <td style="text-align: right"> @money(abs($balanceLineClosing)) {{$balanceLineClType}}</td>
                        </tr>
                        @foreach ($balanceLine->accounts as $account)
                            @php
                                $previousYearTotalDebit = $account->previousYearLedger->sum('dr_amount');
                                $previousYearTotalCredit = $account->previousYearLedger->sum('cr_amount');
                                $currentYearTotalDebit = $account->currentYearLedger->sum('dr_amount');
                                $currentYearTotalCredit = $account->currentYearLedger->sum('cr_amount');
                            @endphp

                            <tr class="account_row balance_account_{{$balanceLine->id}}">
                                <td class="account_line">
                                    {{$account->account_name}}
                                </td>
                                <td style="text-align: right">
                                    @if(in_array($account->account_type, [1, 5]))
                                        {{$resultDebit = $previousYearTotalDebit - $previousYearTotalCredit}}
                                        {{($resultDebit >= 0) ? "Dr" : "Cr" }}
                                    @elseif(in_array($account->account_type, [2, 4]))
                                        {{$previousYearCredit = $previousYearTotalCredit - $previousYearTotalDebit}}
                                        {{($previousYearCredit >= 0) ? "Cr" : "Dr" }}
                                    @endif
                                </td>
                                <td style="text-align: right">
                                    @money($currentYearTotalDebit)
                                </td>
                                <td style="text-align: right">
                                    @money($currentYearTotalCredit)
                                </td>
                                <td style="text-align: right">
                                    @if(in_array($account->account_type, [1, 5]))
                                        @php
                                            $currentYearDebit = $currentYearTotalDebit - $currentYearTotalCredit
                                        @endphp
                                        @if ($debitCurrentStatus = ($resultDebit >= 0))
                                            @money($currentYearDebit + $resultDebit)
                                        @else
                                            @money($currentYearDebit)
                                        @endif
                                        {{($debitCurrentStatus >= 0) ? "Dr" : "Cr" }}

                                    @elseif(in_array($account->account_type, [2, 4]))
                                        @php
                                            $currentYearCredit = $currentYearTotalCredit - $currentYearTotalDebit
                                        @endphp

                                        @if ($creditCurrentStatus = ($previousYearCredit >= 0))
                                            @money($currentYearCredit + $previousYearCredit)
                                        @else
                                            @money($currentYearCredit + $previousYearCredit)
                                        @endif
                                        {{($creditCurrentStatus >= 0) ? "Cr" : "Dr" }}
                                    @endif
                                </td>
                            </tr>
                        @endforeach

                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
    @endif





@endsection

@section('script')
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
