@extends('layouts.backend-layout')
@section('title', 'Collections Report')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
    <style>
        #tableArea{margin-top: 10px;margin-bottom: 10px;}
        table, table th, table td {border-spacing: 0;border: 1px solid #a09e9e;}
        table th, table td{padding:5px;}
        .base_header{font-weight: bold; text-align: left;}
        .balance_header{padding-left:30px; text-align: left; }
        .balance_line_style{ font-weight: bold; padding-left:50px; text-align: left; }
        .account_line{ padding-left:80px;  text-align: left; }
        .account{ padding-left:110px;  text-align: left; }
        .child_account_style{ padding-left:130px;  text-align: left; }
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

@endsection

@section('breadcrumb-button')
    {{-- <a href="{{ url('projects/create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a> --}}
@endsection

@section('sub-title')
    {{--Total: {{ count($projects) }}--}}
@endsection


@section('content')

    <br>
    <h2 class="text-center">Cash-Flow Statement</h2>
    <br>
    <div class="table-responsive">
        <table style="width: 100%">
            <thead>
            <tr style="text-align: center; background:#116A7B; color: white; font-weight: bold">
                <td rowspan=""> Particulars </td>
{{--                <td rowspan="2"> Opening Balance </td>--}}
{{--                <td colspan="2"> Transactions </td>--}}
                <td rowspan="">Amount </td>
            </tr>
            <tr>
                <th>Cash Flow From Operation</th>
                <td class="text-right"></td>
            </tr>
            <tr>
                <td>Net Earnings</td>
                <td class="text-right">@money(2250000)</td>
            </tr>
            <tr>
                <td>Additions to Cash</td>
                <td class="text-right"></td>
            </tr>
            <tr>
                <td class="balance_header">Depreciation</td>
                <td class="text-right">@money(300000)</td>
            </tr>
            <tr>
                <td class="balance_header">Decrease in Account Receivable</td>
                <td class="text-right">@money(450000)</td>
            </tr>
            <tr>
                <td class="balance_header">Increase in Account Payable</td>
                <td class="text-right">@money(200000)</td>
            </tr>
            <tr>
                <td class="balance_header">Increase in Taxes Payable</td>
                <td class="text-right">@money(60000)</td>
            </tr>

            <tr>
                <td>Subtractions From Cash</td>
                <td class="text-right"></td>
            </tr>
            <tr>
                <td class="balance_header">Increase Inventory</td>
                <td class="text-right">(@money(700000))</td>
            </tr>
            <tr>
                <th class=""><u>Net Cash From Operating</u></th>
                <td class="text-right"><u>@money(2740000)</u></td>
            </tr>
            <tr>
                <th style="">Cash Flow from Investing</th>
                <td class="text-right"></td>
            </tr>
            <tr>
                <td class="balance_header">Equipment</td>
                <td class="text-right">(@money(1500000))</td>
            </tr>
            <tr>
                <th style="">Cash Flow from Financing</th>
                <td class="text-right"></td>
            </tr>
            <tr>
                <td class="balance_header">Notes Payable</td>
                <td class="text-right">@money(500000)</td>
            </tr>
            <tr>
                <th style=""><u>Cash Flow for FY Ended  - 2022</u></th>
                <th class="text-right"><u>@money(1740000)</u></th>
            </tr>
{{--            <tr style="text-align: center; background:#116A7B; color: white; font-weight: bold">--}}
{{--                <td> Debit </td>--}}
{{--                <td> Credit </td>--}}
{{--            </tr>--}}
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>

@endsection

@section('script')
    <script>
        $(function() {
            $(document).on('click', '.balance_line', function(){
                let currentLine = $(this).attr('id');
                $(".balance_account_"+currentLine).toggle();
                $(".hide_parent_account_"+currentLine).hide();
            });
            $(document).on('click', '.parent_account', function(){
                let parentAccount = $(this).attr('id');
                $(".parent_account_"+parentAccount).toggle();
                $(".hide_child_account_"+parentAccount).hide();
            });
            $(document).on('click', '.child_account', function(){
                let childAccount = $(this).attr('id');
                $(".child_account_"+childAccount).toggle();
            });
        });//document.ready
    </script>
@endsection
