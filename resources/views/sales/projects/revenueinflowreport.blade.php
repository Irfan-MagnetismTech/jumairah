@extends('layouts.backend-layout')
@section('title', 'Revenue Inflow Report')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title')
    Revenue Inflow
@endsection

@section('breadcrumb-button')
    <a href="{{ url('projects/create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
@endsection

@section('sub-title')
    {{--Total: {{ count($projects) }}--}}
@endsection


@section('content')
    <form action="" method="get">
        <div class="row px-2">
            <div class="col-md-1 px-1 my-1 my-md-0" data-toggle="tooltip" title="Output">
                <select name="reportType" id="reportType" class="form-control form-control-sm" required>
                    <option value="list" selected> List </option>
                    <option value="pdf"> PDF </option>
                </select>
            </div>
            <div class="col-md-3 px-1 my-1 my-md-0">
                <input type="text" id="project_name" name="project_name" class="form-control form-control-sm" value="{{!empty($request) ? $request->project_name : null}}" placeholder="Enter Project Name" autocomplete="off">
                <input type="hidden" id="project_id" name="project_id" class="form-control form-control-sm" value="{{!empty($request) ? $request->project_id : null}}">
            </div>
            {{--<div class="col-md-3 px-1 my-1 my-md-0">--}}
                {{--<input type="text" id="month" name="month" class="form-control form-control-sm" value="{{!empty($request) ? $request->month : null}}" placeholder="Select Month" autocomplete="off">--}}
            {{--</div>--}}
            <div class="col-md-1 px-1 my-1 my-md-0">
                <div class="input-group input-group-sm">
                    <button class="btn btn-success btn-sm btn-block"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </div><!-- end row -->
    </form>

    <div class="bg-warning mt-2 mb-0 p-1">
        <h5 class="text-center"> Month : {{now()->format('F-Y')}}</h5>
    </div>

    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th rowspan="2">Project Name</th>
                    <th rowspan="2">Client's Name</th>
                    <th rowspan="2">Apartment ID</th>
                    <th colspan="4">Regular </th>
                    <th rowspan="2">Over Due</th>
                    <th rowspan="2">Total Due</th>
                    <th rowspan="2">Due Date</th>
                    <th rowspan="2">Received</th>
                    <th rowspan="2">Balance</th>
                    <th rowspan="2">Action</th>
                </tr>
                <tr>
                    <th> Inst. No</th>
                    <th> Inst. Amount </th>
                    <th> Prev. Paid </th>
                    <th> Inst. Due </th>
                </tr>
            </thead>
            <tbody>
                @foreach($projects['clients'] as $key =>$client)                    
                     <tr class="{{$loop->even ? "bg-light" : null}}">
                        <td>
                            <a target="_blank" href="{{route('projects.show', $client->project_id )}}">{{$client->project_name}} </a>
                        </td>
                        <td class="text-left breakWords">
                            <a target="_blank" href="{{route('sells.show', $client->sell_id)}}"> {{$client->client_name}} </a>
                        </td>
                        <td>{{$client->apartment_name}}</td>
                        <td> {{$client->curr_inst_no}} </td>
                        <td class="text-right"> @money($client->curr_inst_amount) </td>
                        <td class="text-right"> @money($client->curr_inst_prev_paid_amount) </td>
                        <td class="text-right"> @money($client->curr_inst_due) </td>
                        <td class="text-right"> @money($client->over_due) </td>
                        <td class="text-right"> @money($client->total_due) </td>
                        <td class="text-center">
                            {{$client->curr_inst_date ?? null}}
                        </td>
                        <td class="text-right">
                            <strong>
                                @money($client->curr_month_received_amount)
                            </strong>
                        </td>
                        <td class="text-right">
                            @money($client->balance_amount)
                        </td>
                        <td>
                            <div class="icon-btn">
                                <nobr>
                                    <a href="{{ url("salesinvoice/$client->sell_id/pdf") }}" target="_blank" data-toggle="tooltip" title="Print Invoice" class="btn btn-outline-primary"><i class="fas fa-print"></i></a>
                                </nobr>
                            </div>
                        </td>
                        
                    </tr>
                @endforeach
            </tbody>

            <tfoot class="font-weight-bold text-right bg-info">
                <tr>
                    <td colspan="4" class="">Total</td>
                    <td> @money($projects['ttl_curr_inst_amount'] ) </td>
                    <td> @money($projects['ttl_curr_inst_prev_paid'] ) </td>
                    <td> @money($projects['ttl_curr_inst_due'] ) </td>
                    <td> @money($projects['ttl_curr_over_due'] ) </td>
                    <td> @money($projects['ttl_curr_total_due'] ) </td>
                    <td> -- </td>
                    <td> @money($projects['ttl_curr_month_received_amount'] ) </td>
                    <td> @money($projects['balance_amount'] ) </td>
                    <td></td>
                </tr>
            </tfoot>

        </table>
    </div>
@endsection

@section('script')
    <script>
        var CSRF_TOKEN = "{{csrf_token()}}";
        $(function() {
            $("#project_name").autocomplete({
                source: function (request, response) {
                    $.ajax({
                        url: "{{route('projectAutoSuggest')}}",
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

            $("#month").datepicker( {
                format: "MM-yyyy",
                startView: "months",
                minViewMode: "months",
                todayHighlight: true,
                autoclose: true
            });
        });//document.ready
    </script>
@endsection