@extends('layouts.backend-layout')
@section('title', 'Sales & Revenue Register')

@section('style')
    {{--<link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">--}}
@endsection

@section('breadcrumb-title')
    Sales & Revenue Register
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
                <input type="text" id="project_name" name="project_name" class="form-control form-control-sm" value="{{$project_name ?? $project_name}}" placeholder="Enter Project Name" autocomplete="off">
                <input type="hidden" id="project_id" name="project_id" class="form-control form-control-sm" value="{{$project_id ?? $project_id}}">
            </div>
            <div class="col-md-2 px-1 my-1 my-md-0">
                <select name="dateType" id="dateType" class="form-control form-control-sm" required>
                    <option value="today" selected> Today </option>
                    <option value="weekly" {{$dateType == "weekly" ? "selected" : ''}}> Last 7 Days </option>
                    <option value="monthly" {{$dateType == "monthly" ? "selected" : ''}}> Last 30 Days </option>
                    <option value="custom" {{$dateType == "custom" ? "selected" : ''}}> Custom </option>
                </select>
            </div>
            <div class="col-md-2 px-1 my-1 my-md-0" id="fromDateArea" style="display: {{$dateType == 'custom' ? 'block' : 'none'}}">
                <input type="text" id="fromDate" name="fromDate" class="form-control form-control-sm" value="{{$fromDate ? date('d-m-Y', strtotime($fromDate)) : ''}}" placeholder="From Date" autocomplete="off">
            </div>
            <div class="col-md-2 px-1 my-1 my-md-0" id="tillDateArea" style="display: {{$dateType == 'custom' ? 'block' : 'none'}}">
                <input type="text" id="tillDate" name="tillDate" class="form-control form-control-sm" value="{{!empty($tillDate) ? date('d-m-Y', strtotime($tillDate)) : ''}}" placeholder="Till Date" autocomplete="off">
            </div>                       
            <div class="col-md-1 px-1 my-1 my-md-0">
                <div class="input-group input-group-sm">
                    <button class="btn btn-success btn-sm btn-block"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </div><!-- end row -->
    </form>
    {{-- @if($sells->isNotEmpty())
        <div class="bg-warning mt-2 mb-0 p-1">
            <h5 class="text-center"> {{$sells->first()->apartment->project->name}}</h5>
        </div>
    @endif --}}

    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Sl.<br>No.</th>
                    <th>Project Name</th>                    
                    <th>Customer<br>Name</th>
                    <th>Apartment<br>No.</th>                    
                    <th>Size</th>
                    <th>Per Sft.<br> Rate</th>
                    <th>Apartment<br> Value</th>
                    <th>Car<br>Parking</th>
                    <th>Utility</th>
                    <th>Reserve<br>Fund</th>
                    {{-- <th>Delay<br>Charge</th> --}}
                    <th>Others</th>
                    {{-- <th>Modification</th> --}}
                    <th>Total<br>Value</th>
                    <th>Payable<br>Till Date</th>
                    <th>Paid<br>Amount</th>
                    <th>Due<br>Till<br>Date</th>
                    <th>Balance</th>
                    <th rowspan="2">Sold<br>By</th>
                    <th rowspan="2">Sold<br>Date</th>
                </tr>
            </thead>
            <tbody class="text-right">
            @php
                $totalPaid = 0;
                $totalDueTillDate = 0;
            @endphp
            @forelse($sells as $sell)
                <tr>
                    <td class="text-center">{{$loop->iteration}}</td>
                    <td class="text-left">
                        <strong>
                            <a href="{{ url('projects/'.$sell->apartment->project->id) }}" target="_blank"> 
                                {{ $sell->apartment->project->name}}
                            </a>
                        </strong>                             
                    </td>                                    
                    <td class="text-left breakWords" style="min-width:180px">
                        <a target="_blank" href="{{ route('sells.show', $sell->id) }}">{{$sell ? $sell->sellClient->client->name : null}}</a>
                    </td>
                    <td class="text-center"><strong><a target="_blank" href="{{ route('apartments.show', $sell->apartment->id) }}">{{$sell->apartment->name}}</a></strong></td>
                    <td>@money($sell->apartment_size)</td>
                    <td>@money($sell->apartment_rate)</td>
                    <td>@money($sell->apartment_value)</td>
                    <td>@money($sell->parking_price)</td>
                    <td>@money($sell->utility_fees)</td>
                    <td>@money($sell->reserve_fund)</td>
                    {{-- <td>Later</td> --}}
                    <td class="text-right">@money($sell->others)</td>
                    {{-- <td>Later</td> --}}
                    <td class="text-right">@money($sell->total_value)</td>
                    <td> @money($sell->payableTillToday) </td>
                    <td class="text-right"> @money($sell->totalCollectedAmount) </td>
                    <td> @money($sell->dueTillToday) </td>
                    <td class="text-right">
                        @money($sell->total_value - $sell->totalCollectedAmount)
                    </td>
                    <td>
                        {{$sell->user->name}}
                    </td>
                    <td>
                        {{$sell->sell_date}}
                    </td>
                </tr>
            @empty
                <tr class="text-center">
                    <td colspan="20"> <h6 class="text-muted my-3"> Please Enter a Project Name. </h6> </td>
                </tr>
            @endforelse

            </tbody>
            @if($sells->isNotEmpty())
            <tfoot class="font-weight-bold text-right bg-info">
                <tr>
                    <td colspan="6" class="">Total</td>
                    <td>@money($sells->sum('apartment_value'))</td>
                    <td>@money($sells->sum('parking_price'))</td>
                    <td>@money($sells->sum('utility_fees'))</td>
                    <td>@money($sells->sum('reserve_fund'))</td>
                    {{-- <td>Later</td> --}}
                    <td>@money($sells->sum('others'))</td>
                    {{-- <td>Later</td> --}}
                    <td>@money($sells->sum('total_value'))</td>
                    <td>@money($sells->sum('payableTillToday'))</td>
                    <td>@money($sells->sum('totalCollectedAmount')) </td>
                    <td>@money($sells->sum('dueTillToday'))</td>
                    <td>
                        @php($balance = $sells->sum('total_value') - $sells->sum('totalCollectedAmount'))
                        @money($balance)
                    </td>
                    <td></td>
                    <td></td>
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
