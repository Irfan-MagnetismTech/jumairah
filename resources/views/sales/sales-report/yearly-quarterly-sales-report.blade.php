@extends('layouts.backend-layout')
@section('title', 'Project Wise Lead Report')

@section('style')
<link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
<style>
    #tableArea {
        margin-top: 10px;
        margin-bottom: 10px;
    }

    table,
    table th,
    table td {
        border-spacing: 0;
        border: 1px solid #a09e9e;
    }

    table th,
    table td {
        padding: 5px;
    }

    .base_header {
        font-weight: bold;
        text-align: left;
    }

    .balance_header {
        font-weight: bold;
        padding-left: 20px;
        text-align: left;
    }

    .balance_line {
        font-weight: bold;
        padding-left: 50px;
        text-align: left;
    }

    .account_line {
        padding-left: 80px;
        text-align: left;
    }

    table tbody td:nth-child(4),
    table tbody td:nth-child(3) {
        text-align: right;
    }

    .text-right {
        text-align: right;
    }

    .text-right {
        text-align: left;
    }

    .account_row {
        display: none
    }
</style>

@endsection

@section('breadcrumb-title')
Yearly Quarterly Sales Report
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
            <select class="form-control form-control-sm" id="year" name="year">
                <option value="2021">2021</option>
                <option value="2022">2022</option>
                <option value="2023">2023</option>
                <option value="2024">2024</option>
                <option value="2025">2025</option>
                <option value="2026">2026</option>
                <option value="2027">2027</option>
                <option value="2028">2028</option>
                <option value="2029">2029</option>
                <option value="2030">2030</option>
            </select>
        </div>
        <!-- <div class="col-md-1 px-1 my-1">
            <div class="input-group input-group-sm">
                <button class="btn btn-success btn-sm btn-block"><i class="fa fa-search"></i></button>
            </div>
        </div> -->
    </div><!-- end row -->
</form>
<br>

{{-- <h2 class="text-center"> </h2> --}}
<div class="table-responsive">
    <table style="width: 100%">
        <thead>
            <tr style="text-align: center; background:#227447; color: white; font-weight: bold">
                <td>#</td>
                <td>Client Name </td>
                <td>Project Name </td>
                <td>Unit No. </td>
                <td> Size </td>
                <td> Car Parking </td>
                <td> Utilities </td>
                <td> Total Value </td>
                <td> Booking Money </td>
                <td> Sold by </td>
                <td> Month </td>
            </tr>
        </thead>
        <tbody>
            @foreach ($sales as $key => $sale_items)
            @foreach ($sale_items as $sale_item)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $sale_item->sellClient->client->name }}</td>
                <td>{{ $sale_item->apartment->project->name }}</td>
                <td>{{ $sale_item->apartment->name }}</td>
                <td>{{ $sale_item->apartment_size }}</td>
                <td>{{ $sale_item->parking_price }}</td>
                <td>{{ $sale_item->utility_price }}</td>
                <td>{{ $sale_item->total_value }}</td>
                <td>{{ $sale_item->booking_money }}</td>
                <td>{{ $sale_item->user->name }}</td>
                <td>{{ Carbon\Carbon::parse($sale_item->created_at)->format('M') }}</td>
            </tr>
            @endforeach
            <tr>
                @if($key == '1')
                <td colspan="7" class="text-center font-weight-bold">Total(1st Quarter, January-March {{$year}})</td>
                @elseif($key == '2')
                <td colspan="7" class="text-center font-weight-bold">Total(2nd Quarter, April-June {{$year}})</td>
                @elseif($key == '3')
                <td colspan="7" class="text-center font-weight-bold">Total(3rd Quarter, July-September {{$year}})</td>
                @elseif($key == '4')
                <td colspan="7" class="text-center font-weight-bold">Total(4th Quarter, October-December {{$year}})</td>
                @endif
                <td class="text-center font-weight-bold">{{ $sale_items->sum('total_value') }}</td>
                <td class="text-center font-weight-bold">{{ $sale_items->sum('booking_money') }}</td>
                <td></td>
                <td></td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <table style="width: 50%; margin-top:20px;">
        <thead>
            <tr>
                <th>In(%)</th>
                <th>Team</th>
                <th>Sales Achievement</th>
                <th>Sales Targent</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($team_wise_sales as $key => $team_wise_sale)
            <tr>
                <td></td>
                <td>{{ $key }}</td>
                <td>{{ $team_wise_sale->sum('total_value') }}</td>
                <td>0</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection

@section('script')
<script>
    var CSRF_TOKEN = "{{csrf_token()}}";
    $(function() {
        $('#month').on('change', function() {
            $("#fromDate").val('');
            $("#tillDate").val('');
        })
    }); //document.ready

    $(function() {
        $('#year').on('change', function() {
            window.location.href = "{{url('yearly-quarterly-sales-report')}}/" + $(this).val() + "/" + $("#reportType").val();
        })
    }); //document.ready
</script>
@endsection