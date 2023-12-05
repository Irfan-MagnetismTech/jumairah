@extends('layouts.backend-layout')
@section('title', 'Sales Collection Approval')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title')
    List of Sales Collection Approval
@endsection

@section('breadcrumb-button')
    <a href="{{ url('salesCollections') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
@endsection

@section('sub-title')
    Total: {{ count($sales_collection_approvals) }}
@endsection

    @section('content')
    <!-- put search form here.. -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Sale Collection ID</th>
                    <th>Client Name</th>
                    <th>Project</th>
                    <th>Apartment ID</th>
                    <th>Payment Mode</th>
                    <th>Bank Name</th>
                    <th>Transaction ID</th>
                    <th>Approval Date</th>
                    <th>Approval Status</th>
                    <th>Reason</th>
{{--                    <th>Action</th>--}}
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>SL</th>
                    <th>Sale Collection ID</th>
                    <th>Client Name</th>
                    <th>Project</th>
                    <th>Apartment ID</th>
                    <th>Payment Mode</th>
                    <th>Bank Name</th>
                    <th>Transaction ID</th>
                    <th>Approval Date</th>
                    <th>Approval Status</th>
                    <th>Reason</th>
{{--                    <th>Action</th>--}}
                </tr>
            </tfoot>
            <tbody>
            @foreach($sales_collection_approvals as $key => $sales_collection_approval)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td> <a href="{{ url("salesCollections/$sales_collection_approval->salecollection_id") }}">{{$sales_collection_approval->salecollection_id}}</a></td>
                    <td class="breakWords">{{$sales_collection_approval->saleCollection->sell->sellClient->client->name}}</td>
                    <td>{{$sales_collection_approval->salecollection->sell->apartment->project->name}}</td>
                    <td>{{$sales_collection_approval->salecollection->sell->apartment->name}}</td>
                    <td>{{$sales_collection_approval->saleCollection->payment_mode}}</td>
                    <td>{{$sales_collection_approval->saleCollection->source_name}}</td>
                    <td>{{$sales_collection_approval->saleCollection->transaction_no}}</td>
                    <td>{{$sales_collection_approval->approval_date}}</td>
                    @if($sales_collection_approval->approval_status == 'Honored')
                        <td class="text-success"><strong>{{$sales_collection_approval->approval_status}}</strong></td>
                    @else
                        <td class="text-danger"><strong>{{$sales_collection_approval->approval_status}}</strong></td>

                    @endif
                    <td class="breakWords">{{$sales_collection_approval->reason}}</td>
{{--                    <td>--}}
{{--                        <div class="icon-btn">--}}
{{--                            <nobr>--}}
{{--                                <a href="{{ url("salesCollectionApprovals/$sales_collection_approval->id/edit") }}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>--}}
{{--                                {!! Form::open(array('url' => "salesCollectionApprovals/$sales_collection_approval->id",'method' => 'delete', 'class'=>'d-inline','data-toggle'=>'tooltip','title'=>'Delete')) !!}--}}
{{--                                {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete'])}}--}}
{{--                                {!! Form::close() !!}--}}
{{--                            </nobr>--}}
{{--                        </div>--}}
{{--                    </td>--}}
                </tr>
            @endforeach
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
