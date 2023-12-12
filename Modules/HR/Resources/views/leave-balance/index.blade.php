@extends('layouts.backend-layout')
@section('title', 'Leave Balance')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    List of Leave Balance
@endsection

@section('style')

@endsection
@section('breadcrumb-button')
    @can('leave-balance-create')
        <a href="{{ route('leave-balances.create') }}" class="btn btn-out-dashed btn-sm btn-warning"><i
                class="fas fa-plus"></i></a>
    @endcan
@endsection
@section('sub-title')
    Total: {{ count($leave_balances) }}
@endsection


@section('content')
    <style>
        table th,
        table td {
            border: 1px solid #D3E7FB !important;
        }
    </style>
    <div class="dt-responsive table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th rowspan="2">#SL</th>
                    <th rowspan="2">Employee Code</th>
                    <th rowspan="2">Employee Name</th>
                    <th rowspan="2">Year</th>
                    <th colspan="2">Casual Leave</th>
                    <th colspan="2">Sick Leave</th>
                    <th colspan="2">Earned Leave</th>
                    <th colspan="2">Maternity Leave</th>
                    <th colspan="2">Others</th>
                    <th rowspan="2">Remarks</th>
                    @canany(['leave-balance-edit', 'leave-balance-delete'])
                        <th rowspan="2">Action</th>
                    @endcanany
                </tr>
                <tr>
                    <th>Total</th>
                    <th>Enjoyed</th>
                    <th>Total</th>
                    <th>Enjoyed</th>
                    <th>Total</th>
                    <th>Enjoyed</th>
                    <th>Total</th>
                    <th>Enjoyed</th>
                    <th>Total</th>
                    <th>Enjoyed</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th rowspan="2">#SL</th>
                    <th rowspan="2">Employee Code</th>
                    <th rowspan="2">Employee Name</th>
                    <th rowspan="2">Year</th>
                    <th colspan="2">Casual Leave</th>
                    <th colspan="2">Sick Leave</th>
                    <th colspan="2">Earned Leave</th>
                    <th colspan="2">Maternity Leave</th>
                    <th colspan="2">Others</th>
                    <th rowspan="2">Remarks</th>
                    @canany(['leave-balance-edit', 'leave-balance-delete'])
                        <th rowspan="2">Action</th>
                    @endcanany
                </tr>
                <tr>

                    <th>Total</th>
                    <th>Enjoyed</th>
                    <th>Total</th>
                    <th>Enjoyed</th>
                    <th>Total</th>
                    <th>Enjoyed</th>
                    <th>Total</th>
                    <th>Enjoyed</th>
                    <th>Total</th>
                    <th>Enjoyed</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach ($leave_balances as $key => $data)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td class="text-left">{{ $data->employee?->emp_code }}</td>
                        <td class="text-left">{{ $data->employee?->emp_name }}</td>
                        <td class="text-center">{{ $data->year }}</td>
                        <td class="text-center">
                            {{ !empty($data->leave_balance_details->cl) ? $data->leave_balance_details->cl : '0' }}</td>
                        <td class="text-center">
                            {{ !empty($data->leave_balance_details->cl_enjoyed) ? $data->leave_balance_details->cl_enjoyed : '0' }}
                        </td>
                        <td class="text-center">
                            {{ !empty($data->leave_balance_details->sl) ? $data->leave_balance_details->sl : '0' }}</td>
                        <td class="text-center">
                            {{ !empty($data->leave_balance_details->sl_enjoyed) ? $data->leave_balance_details->sl_enjoyed : '0' }}
                        </td>
                        <td class="text-center">
                            {{ !empty($data->leave_balance_details->el) ? $data->leave_balance_details->el : '0' }}</td>
                        <td class="text-center">
                            {{ !empty($data->leave_balance_details->el_enjoyed) ? $data->leave_balance_details->el_enjoyed : '0' }}
                        </td>
                        <td class="text-center">
                            {{ !empty($data->leave_balance_details->ml) ? $data->leave_balance_details->ml : '0' }}</td>
                        <td class="text-center">
                            {{ !empty($data->leave_balance_details->ml_enjoyed) ? $data->leave_balance_details->ml_enjoyed : '0' }}
                        </td>
                        <td class="text-center">
                            {{ !empty($data->leave_balance_details->other) ? $data->leave_balance_details->other : '0' }}
                        </td>
                        <td class="text-center">
                            {{ !empty($data->leave_balance_details->other_enjoyed) ? $data->leave_balance_details->other_enjoyed : '0' }}
                        </td>
                        <td class="text-left">{{ $data->leave_balance_details->remarks }}</td>
                        @canany(['leave-balance-edit', 'leave-balance-delete'])
                            <td>
                                <div class="icon-btn">
                                    <nobr>
                                        @can('leave-balance-edit')
                                            <a href="{{ route('leave-balances.edit', $data->id) }}" data-toggle="tooltip"
                                                title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                        @endcan
                                        @can('leave-balance-delete')
                                            <form action="{{ url("hr/leave-balances/$data->id") }}" method="POST"
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
    <script src="{{ asset('js/Datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/Datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        // $(document).ready(function() {
        //     $('#dataTable').DataTable({
        //         // stateSave: true
        //         dom: 'lBfrtip',
        //         lengthMenu: [5, 10, 20, 50, 100, 200, 500],
        //         buttons: [
        //                 // 'csv'
        //         ],
        //         info: true,
        //         bAutoWidth: false,
        //     });
        // });
    </script>
    <script>
        $(window).scroll(function() {
            //set scroll position in session storage
            sessionStorage.scrollPos = $(window).scrollTop();
        });
        var init = function() {
            //get scroll position in session storage
            $(window).scrollTop(sessionStorage.scrollPos || 0)
        };
        window.onload = init;
    </script>
@endsection
