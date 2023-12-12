@extends('layouts.backend-layout')
@section('title', 'Designation')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    List of Designations
@endsection

@section('style')
    <style>
    </style>
@endsection
@section('breadcrumb-button')
    @can('designation-create')
        <a href="{{ route('designations.create') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-plus"></i></a>
    @endcan
    @can('designation-show')
        <a href="{{ route('generateDesignationListReport') }}" target="blank"
            class="btn btn-out-dashed btn-sm btn-info">Designation
            List report<i class="ml-1 fas fa-file-pdf"></i></a>
    @endcan
@endsection
@section('sub-title')
    Total: {{ count($designations) }}
@endsection


@section('content')
    <div class="dt-responsive table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#SL</th>
                    <th>Name</th>
                    <th>Bangla</th>
                    <!-- <th>Minimum GS</th>
                                                <th>Attendance Bonus</th>
                                                <th>Holiday Bonus</th>
                                                <th>Night Shift Allowance</th>
                                                <th>Grade Name</th>
                                                <th>Total Man Power</th>
                                                <th>Salery Range</th> -->
                    <th>Status</th>
                    @canany(['designation-edit', 'designation-delete'])
                        <th>Action</th>
                    @endcanany
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>#SL</th>
                    <th>Name</th>
                    <th>Bangla</th>
                    <!-- <th>Minimum GS</th>
                                                <th>Attendance Bonus</th>
                                                <th>Holiday Bonus</th>
                                                <th>Night Shift Allowance</th>
                                                <th>Grade Name</th>
                                                <th>Total Man Power</th>
                                                <th>Salery Range</th> -->
                    <th>Status</th>
                    @canany(['designation-edit', 'designation-delete'])
                        <th>Action</th>
                    @endcanany
                </tr>
            </tfoot>
            <tbody>
                @foreach ($designations as $key => $data)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td class="text-left">{{ $data->name }}</td>
                        <td class="text-left">{{ !empty($data->bangla) ? $data->bangla : '' }}</td>
                        <!-- <td class="text-left">{{ !empty($data->grade->minimum_gs) ? $data->grade->minimum_gs : '' }}</td>
                                                    <td class="text-left">{{ $data->attendance_bonus }}</td>
                                                    <td class="text-left">{{ $data->holiday_bonus }}</td>
                                                    <td class="text-left">{{ $data->night_shift_allowance }}</td>
                                                    <td class="text-left">{{ !empty($data->grade->name) ? $data->grade->name : '' }}</td>
                                                    <td class="text-left">{{ !empty($data->grade->total_manpower) ? $data->grade->total_manpower : '' }}</td>
                                                    <td class="text-left">{{ !empty($data->grade->salary_range) ? $data->grade->salary_range : '' }}</td> -->
                        <td class="text-left">{{ $data->status }}</td>
                        @canany(['designation-edit', 'designation-delete'])
                            <td>
                                <div class="icon-btn">
                                    <nobr>
                                        @can('designation-edit')
                                            <a href="{{ route('designations.edit', $data->id) }}" data-toggle="tooltip"
                                                title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                        @endcan
                                        @can('designation-delete')
                                            <form action="{{ url("hr/designations/$data->id") }}" method="POST"
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
