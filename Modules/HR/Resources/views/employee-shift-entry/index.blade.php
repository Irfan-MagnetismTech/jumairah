@extends('layouts.backend-layout')
@section('title', 'Employee Shift Entry')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    Employee Shift Entry
@endsection

@section('style')
    <style>
    </style>
@endsection
@section('breadcrumb-button')
    @can('employee-shift-create')
        <a href="{{ route('employee-shifts.create') }}" class="btn btn-out-dashed btn-sm btn-warning"><i
                class="fas fa-plus"></i></a>
    @endcan
@endsection
@section('sub-title')
    Total: {{ count($employee_shifts) }}
@endsection

@section('content')
    <div class="dt-responsive table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#SL</th>
                    <th>Employee Name</th>
                    <th>Employee Code</th>
                    <th>Shift Name</th>
                    <th>Shift Date</th>
                    <th>Description</th>
                    <th>Shift In</th>
                    <th>Shift Out</th>
                    <th>Regular Hour</th>
                    <th>Status</th>
                    @canany(['employee-shift-edit', 'employee-shift-delete'])
                        <th>Action</th>
                    @endcanany
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>#SL</th>
                    <th>Employee Name</th>
                    <th>Employee Code</th>
                    <th>Shift Name</th>
                    <th>Shift Date</th>
                    <th>Description</th>
                    <th>Shift In</th>
                    <th>Shift Out</th>
                    <th>Regular Hour</th>
                    <th>Status</th>
                    @canany(['employee-shift-edit', 'employee-shift-delete'])
                        <th>Action</th>
                    @endcanany
                </tr>
            </tfoot>
            <tbody>
                @foreach ($employee_shifts as $key => $data)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td class="text-left">{{ $data->employee?->emp_name }}</td>
                        <td class="text-left">{{ $data->employee?->emp_code }}</td>
                        <td class="text-left">{{ $data->shift->name }}</td>
                        <td class="text-left">{{ date('d/m/Y', strtotime($data->date)) }}</td>
                        <td class="text-left">{{ $data->shift->description }}</td>
                        <td class="text-left">{{ $data->shift->shift_in }}</td>
                        <td class="text-left">{{ $data->shift->shift_out }}</td>
                        <td class="text-left">{{ $data->shift->regular_hour }}</td>
                        <td class="text-left">{{ $data->shift->status }}</td>
                        @canany(['employee-shift-edit', 'employee-shift-delete'])
                            <td>
                                <div class="icon-btn">
                                    <nobr>
                                        @can('employee-shift-edit')
                                            <a href="{{ route('employee-shifts.edit', $data->id) }}" data-toggle="tooltip"
                                                title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                        @endcan

                                        <!-- <form action="{{ url("hr/shifts/$data->id") }}" method="POST" data-toggle="tooltip" title="Delete" class="d-inline">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-outline-danger btn-sm delete"><i class="fas fa-trash"></i></button>
                                                                </form> -->
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
        $(window).scroll(function() {
            //set scroll position in session storage
            sessionStorage.scrollPos = $(window).scrollTop();
        });
        var init = function() {
            //get scroll position in session storage
            $(window).scrollTop(sessionStorage.scrollPos || 0)
        };
        window.onload = init;

        $(document).ready(function() {
            $('#dataTable').DataTable({
                stateSave: true
            });
        });
    </script>
@endsection
