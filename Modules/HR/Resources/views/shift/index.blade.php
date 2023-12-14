@extends('layouts.backend-layout')
@section('title', 'Shift')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    List of Shifts
@endsection

@section('style')
    <style>
    </style>
@endsection
@section('breadcrumb-button')
    @can('shift-create')
        <a href="{{ route('shifts.create') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-plus"></i></a>
    @endcan
    @can('shift-show')
        <a href="{{ route('generateShiftReport') }}" target="blank" class="btn btn-out-dashed btn-sm btn-info">Shift report<i
                class="ml-1 fas fa-file-pdf"></i></a>
    @endcan
@endsection
@section('sub-title')
    Total: {{ count($shifts) }}
@endsection


@section('content')
    <div class="dt-responsive table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#SL</th>
                    <th>Name</th>
                    <th>Code</th>
                    <th>Description</th>
                    <th>Shift In</th>
                    <th>Shift Out</th>
                    <th>Shift late</th>
                    <th>Lunch Time</th>
                    <th>Lunch In</th>
                    <th>Lunch Out</th>
                    <th>Regular Hour</th>
                    <th>Tiffin Time</th>
                    <th>Tiffin In</th>
                    <th>Tiffin Out</th>
                    <th>Tiffin Time 2</th>
                    <th>Tiffin In 2</th>
                    <th>Tiffin Out 2</th>
                    <th>Status</th>
                    @canany(['shift-edit', 'shift-delete'])
                        <th>Action</th>
                    @endcanany
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>#SL</th>
                    <th>Name</th>
                    <th>Code</th>
                    <th>Description</th>
                    <th>Shift In</th>
                    <th>Shift Out</th>
                    <th>Shift late</th>
                    <th>Lunch Time</th>
                    <th>Lunch In</th>
                    <th>Lunch Out</th>
                    <th>Regular Hour</th>
                    <th>Tiffin Time</th>
                    <th>Tiffin In</th>
                    <th>Tiffin Out</th>
                    <th>Tiffin Time 2</th>
                    <th>Tiffin In 2</th>
                    <th>Tiffin Out 2</th>
                    <th>Status</th>
                    @canany(['shift-edit', 'shift-delete'])
                        <th>Action</th>
                    @endcanany
                </tr>
            </tfoot>
            <tbody>
                @foreach ($shifts as $key => $data)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td class="text-left">{{ $data->name }}</td>
                        <td class="text-left">{{ $data->code ?? '' }}</td>
                        <td class="text-left">{{ $data->description }}</td>
                        <td class="text-left">{{ $data->shift_in }}</td>
                        <td class="text-left">{{ $data->shift_out }}</td>
                        <td class="text-left">{{ $data->shift_late }}</td>
                        <td class="text-left">{{ $data->lunch_time }}</td>
                        <td class="text-left">{{ $data->lunch_in }}</td>
                        <td class="text-left">{{ $data->lunch_out }}</td>
                        <td class="text-left">{{ $data->regular_hour }}</td>
                        <td class="text-left">{{ $data->tiffin_time }}</td>
                        <td class="text-left">{{ $data->tiffin_in }}</td>
                        <td class="text-left">{{ $data->tiffin_out }}</td>
                        <td class="text-left">{{ $data->tiffin_time_2 }}</td>
                        <td class="text-left">{{ $data->tiffin_time_2_in }}</td>
                        <td class="text-left">{{ $data->tiffin_time_2_out }}</td>
                        <td class="text-left">{{ $data->status }}</td>
                        @canany(['shift-edit', 'shift-delete'])
                            <td>
                                <div class="icon-btn">
                                    <nobr>
                                        @can('shift-edit')
                                            <a href="{{ route('shifts.edit', $data->id) }}" data-toggle="tooltip" title="Edit"
                                                class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                        @endcan
                                        @can('shift-delete')
                                            <form action="{{ url("hr/shifts/$data->id") }}" method="POST" data-toggle="tooltip"
                                                title="Delete" class="d-inline">
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
