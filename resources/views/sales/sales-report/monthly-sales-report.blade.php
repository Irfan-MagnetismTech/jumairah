@extends('layouts.backend-layout')
@section('title', 'Monthly Sales Report')

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
    Montly Sales Report
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
            <div class="col-md-2 px-1 my-1" id="fromDateArea">
                <input type="month" id="month" name="month" class="form-control form-control-sm" value="{{!empty($request->month) ? date('Y-m', strtotime($request->month)): ''}}" placeholder="From Date" autocomplete="off">
            </div>
            <div class="col-md-1 px-1 my-1">
                <div class="input-group input-group-sm">
                    <button class="btn btn-success btn-sm btn-block"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </div><!-- end row -->
    </form>
    <br>
    @if($sales)
    <h3 class="text-center"> Month : {{ $request->month ? \Carbon\Carbon::parse($request->month)->monthName : null }} </h3>
    <div class="table-responsive">
        <table style="width: 100%">
            <thead>
                <tr style="text-align: center; background:#116A7B; color: white; font-weight: bold">
                    <td>#</td>
                    <td>Customer Name</td>
                    <td>Project Name</td>
                    <td>Size/Sft</td>
                    <td>Aprt No.</td>
                    <td>Rate/Sft</td>
                    <td>Total Price</td>
                    <td>Booking Money</td>
                    <td>Team </td>
                    <td>Sold By</td>
                    <td>Ref</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($sales as $key => $sale)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="text-left"> {{ $sale?->sellClient?->client?->name }} </td>
                        <td class="text-left"> {{ $sale?->apartment?->project?->name }} </td>
                        <td class="text-right"> @money($sale->apartment_size) </td>
                        <td class="text-left"> {{ $sale->apartment->name }}</td>
                        <td class="text-right"> @money($sale->apartment_rate) </td>
                        <td class="text-right"> @money($sale->total_value) </td>
                        <td class="text-right"> @money($sale->booking_money) </td>
                        <td class="text-left"> {{ $sale?->user?->member?->team?->user?->name }} </td>
                        <td class="text-left"> {{ $sale->user->name }} </td>
                        <td> -- </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="bg-warning">
                    <td class="text-right" colspan="2"> <strong> Total </strong> </td>
                    <td class="text-center"> -- </td>
                    <td class="text-right"> <strong> @money($sales->sum('apartment_size')) </strong> </td>
                    <td class="text-center"> -- </td>
                    <td class="text-center"> -- </td>
                    <td class="text-right"> <strong> @money($sales->sum('total_value')) </strong> </td>
                    <td class="text-right"> <strong> @money($sales->sum('booking_money')) </strong> </td>
                    <td class="text-center"> -- </td>
                    <td class="text-center"> -- </td>
                    <td class="text-center"> -- </td>
                </tr>
            </tfoot>
        </table>
    </div>
    @endif
@endsection

@section('script')
    <script>
        var CSRF_TOKEN = "{{csrf_token()}}";
        $(function() {
            $('#month').on('change', function(){
                $("#fromDate").val('');
                $("#tillDate").val('');
            })
        });//document.ready
    </script>
@endsection
