@extends('layouts.backend-layout')
@section('title', 'Client Collection Report')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title')
    Client Collection Report
@endsection

@section('breadcrumb-button')
{{--    <a href="{{ url('projects/create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>--}}
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
                <input type="text" id="project_name" name="project_name" class="form-control form-control-sm" value="{{$request->project_name ?? null}}" placeholder="Enter Project Name" autocomplete="off">
                <input type="hidden" id="project_id" name="project_id" class="form-control form-control-sm" value="{{$request->project_id ?? null}}">
            </div>
            <div class="col-md-3 px-1 my-1 my-md-0" data-toggle="tooltip" title="Client Name">
                <select name="sell_id" id="sell_id" class="form-control form-control-sm" required>
                    @foreach($clients as $stat)
                        <option value="{{$stat}}" {{($stat == $current_status) ? "selected" : null}}>{{$stat}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-1 px-1 my-1 my-md-0">
                <div class="input-group input-group-sm">
                    <button class="btn btn-success btn-sm btn-block"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </div><!-- end row -->
    </form>

    @if(!empty($request))
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>Received<br>Date</th>
                <th>Purpose</th>
                <th>Scheduled <br>Amount</th>
                <th>Received <br>Amount</th>
                <th>Due <br>Amount</th>
                <th>Schedule <br>Date</th>
                <th>Cheque<br>Honored<br>Date</th>
                <th>Applied<br>Days</th>
                <th>Applied<br>Amount</th>
                <th> Payment <br> Status </th>
                <th class="breakWords">Remarks</th>
            </tr>
            </thead>
            <tbody>
            @php($totalScheduledAmount=0)
            @forelse($clientCollections as $key => $clientCollection)
                @php($countRow=count($clientCollection->salesCollectionDetails))
{{--                @dump(count($clientCollection->salesCollectionDetails))--}}
                @foreach($clientCollection->salesCollectionDetails as $detailKey => $collectionDetail)
                    <tr>
                        @if($loop->first)
                        <td rowspan="{{$countRow}}">{{$clientCollection->received_date}}</td>
                        @endif
                        <td>
                            {{$collectionDetail->particular}} {{$collectionDetail->installment_no ? "- $collectionDetail->installment_no" : null}}
                        </td>
                        <td class="text-right">
                            @if($collectionDetail->installment_no)
                                @php($scheduledAmount= $collectionDetail->installment->installment_amount)
                                @money($scheduledAmount)
                                @php($totalScheduledAmount+=$scheduledAmount)
                            @elseif($collectionDetail->particular == "Booking Money")
                                @php($scheduledAmount=$clientCollection->sell->booking_money)
                                @money($scheduledAmount)
                                @php($totalScheduledAmount+=$scheduledAmount)
                            @elseif($collectionDetail->particular == "Down Payment")
                                @php($scheduledAmount=$clientCollection->sell->downpayment)
                                @money($scheduledAmount)
                                @php($totalScheduledAmount+=$scheduledAmount)
                            @endif
                        </td>
                        <td class="text-right"> @money($collectionDetail->amount)</td>
                        <td>

                        </td>
                        <td>
                            @if($collectionDetail->installment_no)
                                {{$collectionDetail->installment->installment_date}}
                            @elseif($collectionDetail->particular == "Booking Money")
                                {{$clientCollection->sell->booking_date}}
                            @elseif($collectionDetail->particular == "Down Payment")
                                {{$clientCollection->sell->downpayment_date}}
                            @endif
                        </td>
                        <td>{{$collectionDetail->dated}}</td>
                        <td>{{$collectionDetail->applied_days}}</td>
                        <td>{{$collectionDetail->applied_amount}}</td>
                        <td> {{$clientCollection->payment_status}}</td>
                        <td class="text-left">{{$clientCollection->remarks}}</td>
                    </tr>
                @endforeach
            @empty
                <tr>
                    <td colspan="12"> <h5 class="text-muted text-center my-2 text-left"> No Data Found Based on your query. </h5> </td>
                </tr>
            @endforelse
            </tbody>
            @if($clientCollections->isNotEmpty())
                <tfoot class="font-weight-bold text-right bg-info">
                <tr>
                    <td colspan="2">Total</td>
                    <td>@money($totalScheduledAmount)</td>
                    <td>@money($clientCollections->sum('sales_collection_details_sum_amount'))</td>
                    <td colspan="78"></td>
                </tr>
                </tfoot>
            @endif

        </table>
    </div>
    @endif
@endsection

@section('script')
    <script>
        function loadSoldClientsWithApartment(){
            let dropdown = $('#sell_id');
            let oldSelectedItem = "{{!empty($client) ? $client : null}}";

            dropdown.empty();
            dropdown.append('<option selected="true" disabled>Select Client </option>');
            dropdown.prop('selectedIndex', 0);
            const url = '{{url("loadSoldClientsWithApartment")}}/' + $("#project_id").val();
            // Populate dropdown with list of provinces
            $.getJSON(url, function (items) {
                $.each(items, function (key, entry) {
                    let select=(oldSelectedItem == entry.id) ? "selected" : null;
                    dropdown.append($(`<option ${select}></option>`).attr('value', entry.id).text(`${entry.sell_client.client.name} [Apartment : ${entry.apartment.name}]`));
                })
            });
        }

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
            }).on('change', function(){
                loadSoldClientsWithApartment();
            });

            @if($request->sell_id)
                loadSoldClientsWithApartment();
            @endif

        });//document.ready
    </script>
@endsection
