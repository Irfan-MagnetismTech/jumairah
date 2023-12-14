@extends('layouts.backend-layout')
@section('title', 'opening-balances')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title')
    List of Opening Balance
@endsection


@section('breadcrumb-button')
    <a href="{{ route('account-opening-balances.create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
@endsection

@section('sub-title')
    Total: {{ count($openingBalances) }}
@endsection

@section('content')
    <!-- put search form here.. -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>SL</th>
                <th>Date</th>
                <th>Cost Center </th>
                <th>Account Head</th>
                <th>Debit Amount</th>
                <th>Credit Amount</th>
                <th>Action</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>SL</th>
                <th>Date</th>
                <th>Cost Center </th>
                <th>Account Head</th>
                <th>Debit Amount</th>
                <th>Credit Amount</th>
                <th>Action</th>
            </tr>
            </tfoot>
            <tbody>
            @foreach($openingBalances as $key => $data)
                    <tr>
                        <td>{{1+$key}} </td>
                        <td> {{ $data->date ?? '' }}</td>

                        <td class="text-left"> {{ $data->costCenter->name ?? '' }}</td>
                        <td class="text-left"> {{ $data->account->account_name ?? '' }}</td>
                        <td class="text-right"> @money($data->dr_amount)</td>
                        <td class="text-right"> @money($data->cr_amount) </td>
                        <td rowspan="">
                            <div class="icon-btn">
                                <nobr>
                                    <a href="{{ route("account-opening-balances.edit", $data->id)}}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                    {!! Form::open(array('url' => "accounts/account-opening-balances/$data->id",'method' => 'delete', 'class'=>'d-inline','data-toggle'=>'tooltip','title'=>'Delete')) !!}
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
