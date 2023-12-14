@extends('layouts.backend-layout')
@section('title', 'Bank Accounts')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title')
    List of Bank Accounts
@endsection

@section('breadcrumb-button')
    <a href="{{ url('accounts/bankAccounts/create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
@endsection

@section('sub-title')
    Total: {{ count($bankAccounts) }}
@endsection

@section('content')
    <!-- put search form here.. -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>#</th>
                <th>Bank Name</th>
                <th>Branch Name</th>
                <th>Account Type</th>
                <th>Account Name</th>
                <th>Account Number</th>
                <th>Opening Date</th>
                <th>Action</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>#</th>
                <th>Bank Name</th>
                <th>Branch Name</th>
                <th>Account Type</th>
                <th>Account Name</th>
                <th>Account Number</th>
                <th>Opening Date</th>
                <th>Action</th>
            </tr>
            </tfoot>
            <tbody>
            @foreach($bankAccounts as $key => $data)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$data->name}}</td>
                    <td>{{$data->branch_name}}</td>
                    <td>{{$data->account_type}}</td>
                    <td>{{$data->account_name}}</td>
                    <td>{{$data->account_number}}</td>
                    <td>{{$data->opening_date}}</td>
                    <td>
                        <div class="icon-btn">
                            <nobr>
                                <a href="{{ route('bankAccounts.edit', $data->id) }}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                {!! Form::open(array('url' => route('bankAccounts.destroy', $data->id),'method' => 'delete', 'class'=>'d-inline','data-toggle'=>'tooltip','title'=>'Delete')) !!}
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
