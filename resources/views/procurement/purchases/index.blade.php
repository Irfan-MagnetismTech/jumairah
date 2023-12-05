@extends('layouts.backend-layout')
@section('title', 'LC Purchase')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title')
    List of Local Purchase
@endsection

@section('breadcrumb-button')
    <a href="{{ url('purchases/create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
@endsection

@section('sub-title')
    Total: {{ count($allData) }}
    @endsection

    @section('content')
            <!-- put search form here.. -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>SL</th>
                <th>Supplier Name</th>
                <th>Date</th>
                <th>Raw Material </th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Total Amount</th>
                <th>Action</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>SL</th>
                <th>Supplier Name</th>
                <th>Date</th>
                <th>Raw Material </th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Total Amount</th>
                <th>Action</th>
            </tr>
            </tfoot>
            <tbody>
            @foreach($allData as $key => $data)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td class="text-left"> {{ $data->supplier->name ?? '' }}</td>
                    <td> {{ $data->date ? date('d-m-Y',strtotime($data->date)):'' }}</td>
                    <td class="text-right">
                        @foreach($data->purchaseDetails as $purchaseDtl)
                            {{$purchaseDtl->rowMetarials->name ?? ''}}<br>
                        @endforeach
                    </td>
                    <td>
                        @foreach($data->purchaseDetails as $purchaseDtl)
                            {{$purchaseDtl->quantity ?? ''}} {{$purchaseDtl->rowMetarials->unit->name ?? ''}}<br>
                        @endforeach
                    </td>
                    <td class="text-right">
                        @foreach($data->purchaseDetails as $purchaseDtl)
                            {{$purchaseDtl->unite_price ?? ''}}<br>
                        @endforeach
                    </td>
                    <td class="text-right">
                        @foreach($data->purchaseDetails as $purchaseDtl)
                            {{$purchaseDtl->totalPrice ?? ''}}<br>
                        @endforeach
                    </td>
                    <td>
                        <div class="icon-btn">
                            <nobr>
                                <a href="{{ url("purchases/$data->id") }}" data-toggle="tooltip" title="Show" class="btn btn-outline-primary"><i class="fas fa-eye"></i></a>
                                <a href="{{ url("purchases/$data->id/edit") }}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                {!! Form::open(array('url' => "purchases/$data->id",'method' => 'delete', 'class'=>'d-inline','data-toggle'=>'tooltip','title'=>'Delete')) !!}
                                {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete'])}}
                                {!! Form::close() !!}
                            </nobr>
                        </div>
                    </td>
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
