@extends('layouts.backend-layout')
@section('title', 'Employee Release')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    List of Employee Release
@endsection

@section('style')
    <style>
    </style>
@endsection
@section('breadcrumb-button')
    @can('employee-release-create')
        <a href="{{ route('employee-releases.create') }}" class="btn btn-out-dashed btn-sm btn-warning"><i
                class="fas fa-plus"></i></a>
    @endcan
@endsection
@section('sub-title')
    Total: {{ count($employee_releases) }}
@endsection


@section('content')
    <div class="dt-responsive table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#SL</th>
                    <th>Name</th>
                    <th>Release Type</th>
                    <th>Release Date</th>
                    <th>Last Present Day</th>
                    <th>Remarks</th>
                    @canany(['employee-release-edit', 'employee-release-delete'])
                        <th>Action</th>
                    @endcanany
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>#SL</th>
                    <th>Name</th>
                    <th>Release Type</th>
                    <th>Release Date</th>
                    <th>Last Present Day</th>
                    <th>Remarks</th>
                    @canany(['employee-release-edit', 'employee-release-delete'])
                        <th>Action</th>
                    @endcanany
                </tr>
            </tfoot>
            <tbody>
                @foreach ($employee_releases as $key => $data)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td class="text-left">{{ $data->employee?->emp_name }}</td>
                        <td class="text-left">{{ $data->release_type->name }}</td>
                        <td class="text-left">{{ $data->release_date }}</td>
                        <td class="text-left">{{ $data->last_present_day }}</td>
                        <td class="text-left">{{ $data->remarks }}</td>
                        @canany(['employee-release-edit', 'employee-release-delete'])
                            <td>
                                <div class="icon-btn">
                                    <nobr>
                                        @can('employee-release-edit')
                                            <a href="{{ route('employee-releases.edit', $data->id) }}" data-toggle="tooltip"
                                                title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                        @endcan
                                        @can('employee-release-delete')
                                            <form action="{{ url("hr/employee-releases/$data->id") }}" method="POST"
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
