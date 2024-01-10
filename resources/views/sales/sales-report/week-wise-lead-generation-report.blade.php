@extends('layouts.backend-layout')
@section('title', 'Category Wise Lead Report')

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
Category Wise Sales Report
@endsection



@section('content')

<div class="row px-2">
    <div class="col-md-1 px-1 my-1" data-toggle="tooltip" title="Output">
        <select name="reportType" id="reportType" class="form-control form-control-sm" required>
            <option value="list" selected> List </option>
            <option value="excel"> Excel </option>
        </select>
    </div>
    <div class="col-md-2 px-1 my-1" id="fromDateArea">
        <input type="month" name="month" id="month" class="form-control form-control-sm" value="{{ $month }}" required>
    </div>
    <div class="col-md-1 px-1 my-1">
        <div class="input-group input-group-sm">
            <button class="btn btn-success btn-sm btn-block" id="search"><i class="fa fa-search"></i></button>
        </div>
    </div>
</div><!-- end row -->

<br>

{{-- <h2 class="text-center"> </h2> --}}
<div class="table-responsive">
    <table style="width: 100%" id="categoryWiseTable">
        <thead>
            <tr style="text-align: center; background:#116A7B; color: white; font-weight: bold">
                <td>Category</td>
                <td>#</td>
                <td>Customer Name </td>
                <td>Project</td>
                <td> Apt No/Floor </td>
                <td> Apt Size (sft.) </td>
                <td> Company Offer </td>
                <td> Client Offer </td>
                <td> Remarks </td>
            </tr>
        </thead>
        <tbody>
            @foreach ($week_wise_leads as $key => $week_wise_lead)
            <tr>
                <td rowspan="{{ count($week_wise_lead) + 1 }}" style="text-align: center; font-weight: bold">
                    @if($key == 1)
                    Week 1 (1-8)
                    @elseif($key == 2)
                    Week 2 (9-16)
                    @elseif($key == 3)
                    Week 3 (17-23)
                    @elseif($key == 4)
                    Week 4 (24-31)
                    @endif
                </td>

                @foreach ($week_wise_lead as $lead)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $lead->name }}</td>
                <td>{{ $lead->apartment->project->name }}</td>
                <td>{{ $lead->apartment->floor }}</td>
                <td>{{ $lead->apartment->apartment_size }}</td>
                <td></td>
                <td></td>
                <td>{{ $lead->lastFollowup->remarks ?? '' }}</td>
            </tr>
            @endforeach
            <tr>
                <td>Total</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
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
        $('#search').on('click', function() {
            window.location.href = "{{url('week-wise-lead-generation-report')}}/" + $('#month').val() + "/" + $("#reportType").val();
        })
    }); //document.ready
</script>
@endsection