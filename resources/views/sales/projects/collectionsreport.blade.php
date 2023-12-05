@extends('layouts.backend-layout')
@section('title', 'Collections Report')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title')
    Collections Report
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
            <div class="col-md-2 px-1 my-1">
                <select name="payment_mode" id="payment_mode" class="form-control form-control-sm" data-toggle="tooltip" title="Payment Mode">
                    <option value="All">All</option>
                    @foreach($paymentModes as $key => $paymentMode)
                        @if($request->payment_mode == $key)
                            <option value="{{$key}}" selected>{{$paymentMode}}</option>
                        @else
                            <option value="{{$key}}">{{$paymentMode}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 px-1 my-1">
                <select name="payment_type" id="payment_type" class="form-control form-control-sm" data-toggle="tooltip" title="Payment Type">
                    <option value="All">All</option>
                    @foreach($paymentTypes as $key => $paymentType)
                        @if($request->payment_type == $key)
                            <option value="{{$key}}" selected>{{$paymentType}}</option>
                        @else
                            <option value="{{$key}}">{{$paymentType}}</option>
                        @endif
                    @endforeach
                </select>
            </div>

            <div class="col-md-2 px-1 my-1">
                <select name="dateType" id="dateType" class="form-control form-control-sm" required>
                    <option value="today" selected> Today </option>
                    <option value="weekly" {{$dateType == "weekly" ? "selected" : ''}}> Last 7 Days </option>
                    <option value="monthly" {{$dateType == "monthly" ? "selected" : ''}}> Last 30 Days </option>
                    <option value="custom" {{$dateType == "custom" ? "selected" : ''}}> Custom </option>
                </select>
            </div>
            <div class="col-md-2 px-1 my-1" id="fromDateArea" style="display: {{$dateType == 'custom' ? 'block' : 'none'}}">
                <input type="text" id="fromDate" name="fromDate" class="form-control form-control-sm" value="{{$fromDate ? date('d-m-Y', strtotime($fromDate)) : ''}}" placeholder="From Date" autocomplete="off">
            </div>
            <div class="col-md-2 px-1 my-1" id="tillDateArea" style="display: {{$dateType == 'custom' ? 'block' : 'none'}}">
                <input type="text" id="tillDate" name="tillDate" class="form-control form-control-sm" value="{{!empty($tillDate) ? date('d-m-Y', strtotime($tillDate)) : ''}}" placeholder="Till Date" autocomplete="off">
            </div>

            <div class="col-md-1 px-1 my-1">
                <div class="input-group input-group-sm">
                    <button class="btn btn-success btn-sm btn-block"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </div><!-- end row -->
    </form>
    {{--@if($apartments->isNotEmpty())--}}
        {{--<div class="bg-warning mt-2 mb-0 p-1">--}}
            {{--<h5 class="text-center"> {{$apartments->first()->project->name}}</h5>--}}
        {{--</div>--}}
    {{--@endif--}}

    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Project<br>Name</th>
                    <th>Client's<br>Name</th>
                    <th>Apartment<br>ID</th>
                    <th>Collection<br>Date</th>
                    <th>Payment<br>Mode</th>
                    <th>Bank<br>Name</th>
                    <th>Cheque<br>Dated</th>
                    <th>Cheque<br>No</th>
                    <th>Amount</th>
                    <th>Purpose</th>
                    <th>Status</th>

                </tr>
            </thead>
            <tbody>
            @forelse($salesCollections as $salesCollection)
                <tr>
                    <td class="text-left">
                        <a target="_blank" href="{{ route('projects.show', $salesCollection->sell->apartment->project->id) }}">{{$salesCollection->sell->apartment->project->name}}</a>
                    </td>
                    <td class="text-left">
                        <a target="_blank" href="{{ route('sells.show', $salesCollection->sell->id) }}">{{$salesCollection->sell->sellClient->client->name}}</a>
                    </td>
                    <td>
                        <a target="_blank" href="{{ route('apartments.show', $salesCollection->sell->apartment->id) }}">{{$salesCollection->sell->apartment->name}}</a>
                    </td>
                    <td>{{$salesCollection->received_date}}</td>
                    <td>{{$salesCollection->payment_mode}}</td>
                    <td>{{$salesCollection->source_name ?? "---"}}</td>
                    <td>{{$salesCollection->dated ?? "---"}}</td>
                    <td>{{$salesCollection->transaction_no ?? "---"}}</td>
                    <td class="text-right"><strong>@money($salesCollection->received_amount)</strong></td>
                    <td>{{$salesCollection->salesCollectionDetails->pluck('particular')->join(', ', ', and ')}}</td>
                    <td>
                        <button style="min-width: 60px" class="btn btn-sm
                            @if($salesCollection->payment_status == "Honored")
                            bg-success
                            @elseif($salesCollection->payment_status == "Dishonored")
                                            bg-warning
                            @elseif($salesCollection->payment_status == "Canceled")
                                            bg-danger
                            @else
                                            bg-dark
                            @endif">
                                            {{$salesCollection->payment_status}}
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="11"> <p class="text-muted my-2"> No Data Found Based on your query. </p> </td>
                </tr>
            @endforelse
            </tbody>

            @if($salesCollections->isNotEmpty())
                <tfoot class="font-weight-bold text-right bg-info">
                <tr>
                    <td colspan="8" class="">Total</td>
                    <td>
                        @money($salesCollections->sum('received_amount'))
                    </td>
                    <td colspan="2"></td>
                </tr>
                </tfoot>
            @endif

        </table>
    </div>
@endsection

@section('script')
    <script>
        var CSRF_TOKEN = "{{csrf_token()}}";
        $(function() {
            $('#fromDate').datepicker({format: "dd-mm-yyyy",autoclose: true,todayHighlight: true});
            $('#tillDate').datepicker({format: "dd-mm-yyyy",autoclose: true,todayHighlight: true});

            $("#dateType").change(function(){
                let type = $(this).val();
                if(type === 'custom'){
                    $("#fromDateArea, #tillDateArea").show('slow');
                    $("#fromDate, #tillDate").attr('required', true);
                }else{
                    $("#fromDateArea, #tillDateArea").hide('slow');
                    $("#fromDate, #tillDate").removeAttr('required');
                }
            });
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

        });//document.ready
    </script>
@endsection
