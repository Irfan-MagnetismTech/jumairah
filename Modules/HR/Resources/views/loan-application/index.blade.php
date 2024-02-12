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
    @can('line-create')
        <a href="{{ route('loan-applications.create') }}" class="btn btn-out-dashed btn-sm btn-warning"><i
                class="fas fa-plus"></i></a>
    @endcan
@endsection
@section('sub-title')
    Total: {{ count($loanApplications) }}
@endsection


@section('content')
    <div class="dt-responsive table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#SL</th>
                    <th>Employee Name</th>
                    <th>Loan Type</th>
                    <th>Loan Amount</th>
                    <th>Installment</th>
                    <th>Left Amount</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Loan Release Date</th>
                    <th>Remarks</th>
                    <th>Payment</th>
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
                    <th>Loan Amount</th>
                    <th>Installment</th>
                    <th>Left Amount</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Loan Release Date</th>
                    <th>Remarks</th>
                    <th>Payment</th>
                    @canany(['line-edit', 'line-delete'])
                        <th>Action</th>
                    @endcanany
                </tr>
            </tfoot>
            <tbody>
                @foreach ($loanApplications as $key => $data)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td class="text-left">{{ $data->employee->emp_name }}</td>
                        <td class="text-left">{{ $data->loan_type?->name }}</td>
                        <td class="text-left">{{ $data->loan_amount }}</td>
                        <td class="text-left">{{ $data->loan_installment }}</td>
                        <td class="text-left">{{ $data->left_amount }}</td>
                        <td class="text-left">{{ $data->loan_start_date }}</td>
                        <td class="text-left">{{ $data->loan_end_date }}</td>
                        <td class="text-left">{{ $data->loan_released_date }}</td>
                        <td class="text-left">{{ $data->remarks }}</td>
                        <td class="text-left">
                            <a href="{{ route('loan-payment-create', $data->id) }}" class="btn btn-outline-info btn-sm">
                                Installment
                            </a>
                            <a href="{{ route('loan-payment-form', $data->id) }}" class="btn btn-outline-info btn-sm">
                                Payment
                            </a>
                        </td>
                        @canany(['loan-application-delete', 'loan-application-edit'])
                            <td>
                                <div class="icon-btn">
                                    <nobr>
                                        @can('loan-application-edit')
                                            <a href="{{ route('loan-applications.edit', $data->id) }}" data-toggle="tooltip"
                                                title="Edit" class="btn btn-outline-warning">
                                                <i class="fas fa-pen"></i>
                                            </a>
                                        @endcan
                                        @can('loan-application-delete')
                                            <form action="{{ url("hr/loan-applications/$data->id") }}" method="POST"
                                                data-toggle="tooltip" title="Delete" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm delete"><i
                                                        class="fas fa-trash"></i></button>
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
