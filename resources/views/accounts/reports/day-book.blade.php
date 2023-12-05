@extends('layouts.backend-layout')
@section('title', 'Collections Report')

@section('style')
<link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title')
Day Book
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
                <option value="excel"> Excel </option>
            </select>
        </div>
        <div class="col-md-3 px-1 my-1">
            <input type="text" id="account_name" name="account_name" class="form-control form-control-sm" value="{{$request->account_name ?? $request->account_name}}" placeholder="Enter Account Name" autocomplete="off">
            <input type="hidden" id="account_id" name="account_id" class="form-control form-control-sm" value="{{$request->account_id ?? $request->account_id}}">
        </div>
        <div class="col-md-2 px-1 my-1" id="fromDateArea">
            <input type="text" id="fromDate" name="fromDate" class="form-control form-control-sm" value="{{$fromDate ? date('d-m-Y', strtotime($fromDate)) : ''}}" placeholder="From Date" autocomplete="off">
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
<div class="table-responsive">
    <table id="dataTable" class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Date</th>
                <th>Particulars</th>
                <th>Voucher Type</th>
                <th>Voucher No</th>
                <th>Debit Amount</th>
                <th>Credit Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ledgetEntries as $ledgerEntry)
            <tr>
                <td style="text-align: center"> {{$ledgerEntry->transaction->transaction_date}}</td>
                <td> {{$ledgerEntry->account->account_name}} </td>
                <td> {{$ledgerEntry->transaction->voucher_type}} </td>
                <td> {{$ledgerEntry->transaction->id}} </td>
                <td style="text-align: right"> {{$ledgerEntry->dr_amount}} </td>
                <td style="text-align: right"> {{$ledgerEntry->cr_amount}} </td>
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
        $('#fromDate').datepicker({
            format: "dd-mm-yyyy",
            autoclose: true,
            todayHighlight: true
        });
        $('#tillDate').datepicker({
            format: "dd-mm-yyyy",
            autoclose: true,
            todayHighlight: true
        });

        $("#dateType").change(function() {
            let type = $(this).val();
            if (type === 'custom') {
                $("#fromDateArea, #tillDateArea").show('slow');
                $("#fromDate, #tillDate").attr('required', true);
            } else {
                $("#fromDateArea, #tillDateArea").hide('slow');
                $("#fromDate, #tillDate").removeAttr('required');
            }
        });

        $("#account_name").autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: "{{url('api/account-name')}}",
                    type: 'post',
                    dataType: "json",
                    data: {
                        _token: CSRF_TOKEN,
                        search: request.term
                    },
                    success: function(data) {
                        response(data);
                    }
                });
            },
            select: function(event, ui) {
                $('#account_name').val(ui.item.label);
                $('#account_id').val(ui.item.value);
                return false;
            }
        }).change(function() {
            if (!$(this).val()) {
                $('#account_id').val(null);
            }
        });

    }); //document.ready
</script>
@endsection