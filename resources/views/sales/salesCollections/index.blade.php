@extends('layouts.backend-layout')
@section('title', 'Sales Collections')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title')
    List of Sales Collections
@endsection

@section('breadcrumb-button')
    @can('salesCollection-create')
    <a href="{{ url('salesCollections/create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
    @endcan
@endsection

@section('sub-title')
    Total: {{ count($salesCollections) }}
@endsection

@section('content')
    <!-- put search form here.. -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>SL</th>
                <th>Project <br>Apartment ID</th>
                <th>Client</th>
                <th>Received <br> Date</th>
                <th>Received <br> Amount</th>
                <th>Payment Info </th>
                <th>Particular</th>
                <th>Amount</th>
                <th>Applied <br> Days</th>
                <th>Applied <br> Amount</th>
                <th>Attachment</th>
                <th>Approval <br>Status</th>
                <th>Action</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>SL</th>
                <th>Project <br>Apartment ID</th>
                <th>Client</th>
                <th>Received <br> Date</th>
                <th>Received <br>  Amount</th>
                <th>Payment Info </th>
                <th>Particular</th>
                <th>Amount</th>
                <th>Applied  <br> Days</th>
                <th>Applied  <br> Amount</th>
                <th>Attachment</th>
                <th>Approval <br>Status</th>
                <th>Action</th>
            </tr>
            </tfoot>
            <tbody>
            @foreach($salesCollections as $key => $salesCollection)
                @php($rows = $salesCollection->salesCollectionDetails->count())

{{--                @foreach($salesCollection->salesCollectionDetails as $key => $collectionDetail)--}}
                    <tr>
{{--                        @if($loop->first)--}}
                            <td rowspan="">{{$loop->iteration}}</td>
                            <td rowspan="" class="text-left breakWords">
                                <strong>{{$salesCollection->sell->apartment->project->name}}</strong><br>
                                {{$salesCollection->sell->apartment->name}}
                            </td>
                            <td rowspan="" class="text-left breakWords">
                                <strong>
                                    @if($salesCollection->sell->id)
                                        <a href="{{route('sells.show', $salesCollection->sell->id)}}" target="_blank">
                                            {{$salesCollection->sell->sellClient->client->name}}
                                        </a>
                                    @endif
                                </strong>
                            </td>
                            <td rowspan="">{{$salesCollection->received_date}}</td>
                            <td rowspan="" class="text-right"> @money($salesCollection->received_amount)</td>

                            <td rowspan="">
                                <p class="m-1">{{$salesCollection->payment_mode}}</p>
                                @if($salesCollection->payment_mode !== "Cash")
                                    No: <strong>{{$salesCollection->transaction_no}}</strong> <br>
                                    Dated: <strong class="text-danger">{{$salesCollection->dated ?? null }}</strong> <br>
                                    Bank: {{$salesCollection->source_name}}
                                @endif
                            </td>
{{--                        @endif--}}

                        <td>
                            @foreach($salesCollection->salesCollectionDetails as $key => $collectionDetail)
                            {{$collectionDetail->particular}} {{$collectionDetail->installment_no ? "-$collectionDetail->installment_no" : null}}
                                <br>
                                @if($rows > 1 && $loop->last)
                                    <hr class="m-0 p-0">
                                    <strong class="text-right">Total</strong>
                                @endif
                            @endforeach
                        </td>

                        <td class="text-right">
                            @foreach($salesCollection->salesCollectionDetails as $key => $collectionDetail)
                                @money($collectionDetail->amount) <br>
                                @if($rows > 1 && $loop->last)
                                    <hr class="m-0 p-0">
                                    <strong>@money($salesCollection->total_amount)</strong>
                                @endif
                            @endforeach
                        </td>
                        <td>
                            @foreach($salesCollection->salesCollectionDetails as $key => $collectionDetail)
                                {{$collectionDetail->applied_days ?? "---"}} <br>
                            @endforeach
                        </td>
                        <td>
                            @foreach($salesCollection->salesCollectionDetails as $key => $collectionDetail)
                            {{$collectionDetail->applied_amount ?? "---"}} <br>
                            @endforeach
                        </td>
                        <td>
                            @if($salesCollection->attachment)
                                <strong><a href="{{$salesCollection->attachment}}" target="_blank"> Attachment </a></strong>
                            @endif
                        </td>
                        <td>
                            <button style="min-width: 60px" class="btn btn-sm
                            @if($salesCollection->payment_status == "Honored")
                                bg-success
                            @elseif($salesCollection->payment_status == "Hold")
                                bg-info
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
{{--                        @if($loop->first)--}}
                            <td rowspan="">
                                <div class="icon-btn">
                                    <nobr>
                                        @can('sales-collection-approval-create')
                                            @if(in_array($salesCollection->payment_status,["Dishonored", "Received", "Hold"]))
                                                    <a href="{{ url("salescollectionapproval/$salesCollection->id") }}" data-toggle="tooltip" title="Approve Collection" class="btn btn-outline-success"><i class="fas fa-plus"></i></a>
                                            @endif
                                        @endcan
                                        @can('salesCollection-view')
                                             <a href="{{ url("salesCollections/$salesCollection->id") }}" data-toggle="tooltip" title="Show" class="btn btn-outline-primary"><i class="fas fa-eye"></i></a>
                                        @endcan

                                        @can('salesCollection-view')
                                             <a href="{{ url("salesCollections/$salesCollection->id/acknowledgement") }}" data-toggle="tooltip" title="Print Acknowledgement" class="btn btn-outline-dark"><i class="fas fa-print"></i></a>
                                        @endcan
                                        @can('salesCollection-edit')
                                        @if(!$salesCollection->salesCollectionApprovals->isNotEmpty())
                                            <a href="{{ url("salesCollections/$salesCollection->id/edit") }}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                        @endif
                                        @endcan
                                        @can('salesCollection-delete')
                                            {!! Form::open(array('url' => "salesCollections/$salesCollection->id",'method' => 'delete', 'class'=>'d-inline','data-toggle'=>'tooltip','title'=>'Delete')) !!}
                                            {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete'])}}
                                        @endcan
                                            {!! Form::close() !!}
                                    </nobr>
                                </div>
                            </td>
{{--                        @endif--}}
                    </tr>
                @endforeach
{{--            @endforeach--}}
            </tbody>
        </table>
    </div>
@endsection

@section('script')
    <script src="{{asset('js/Datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('js/Datatables/dataTables.bootstrap4.min.js')}}"></script>
    <script>
        $(window).scroll(function () {
            //set scroll position in session storage
            sessionStorage.scrollPos = $(window).scrollTop();
        });
        var init = function () {
            //get scroll position in session storage
            $(window).scrollTop(sessionStorage.scrollPos || 0)
        };
        window.onload = init;

        $(document).ready(function () {
            $('#dataTable').DataTable({
                stateSave: true
            });
        });
    </script>
@endsection
