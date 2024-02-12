@extends('layouts.backend-layout')
@section('title', 'Loan Application')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    List of Loan Applications
@endsection

@section('style')
    <style>
    </style>
@endsection
@section('breadcrumb-button')
    {{-- @can('line-create')
        <a href="{{ route('loan-payments.create') }}" class="btn btn-out-dashed btn-sm btn-warning"><i
                class="fas fa-plus"></i></a>
    @endcan --}}
@endsection
@section('sub-title')
    Total: {{ count($loanPayments) }}
@endsection


@section('content')
    <div class="dt-responsive table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#SL</th>
                    <th>Employee Name</th>
                    <th>Loan Type</th>
                    <th>Payment</th>
                    <th>Payment Date</th>
                    @canany(['line-edit', 'line-delete'])
                        <th>Action</th>
                    @endcanany
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>#SL</th>
                    <th>Employee Name</th>
                    <th>Loan Type</th>
                    <th>Payment</th>
                    <th>Payment Date</th>
                    @canany(['line-edit', 'line-delete'])
                        <th>Action</th>
                    @endcanany
                </tr>
            </tfoot>
            <tbody>
                @foreach ($loanPayments as $key => $data)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $data->loan_application?->employee?->emp_name }}</td>
                        <td>{{ $data->loan_application?->loan_type?->name }}</td>
                        <td>{{ $data->payment_amount }}</td>
                        <td>{{ $data->payment_date }}</td>
                        @canany(['line-edit', 'line-delete'])
                            <td>
                                <div class="icon-btn">
                                    <nobr>
                                        @can('line-edit')
                                            {{-- <a href="{{ route('loan-payments.edit', $data->id) }}" data-toggle="tooltip" title="Edit"
                                                class="btn btn-outline-warning"><i class="fas fa-pen"></i></a> --}}
                                        @endcan
                                        @can('line-delete')
                                            <form action="{{ url("hr/loan-payments/$data->id") }}" method="POST" data-toggle="tooltip"
                                                title="Delete" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endcan
                                    </nobr>
                                </div>
                            </td>
                        @endcanany
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection

@section('script')

    <script></script>
@endsection
