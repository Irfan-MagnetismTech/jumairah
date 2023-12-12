@extends('layouts.backend-layout')
@section('title', 'Bus Stop')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    List of Bus Stops
@endsection

@section('style')
    <style>
    </style>
@endsection
@section('breadcrumb-button')
    @can('busstop-create')
        <a href="{{ route('bus-stops.create') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-plus"></i></a>
    @endcan
@endsection
@section('sub-title')
    {{-- Total: {{ count($users) }} --}}
@endsection


@section('content')
    <div class="dt-responsive table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#SL</th>
                    <th>Name</th>
                    <th>Rate</th>
                    <th>Remarks</th>
                    <th>Status</th>
                    @canany(['busstop-edit', 'busstop-delete'])
                        <th>Action</th>
                    @endcanany
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>#SL</th>
                    <th>Name</th>
                    <th>Rate</th>
                    <th>Remarks</th>
                    <th>Status</th>
                    @canany(['busstop-edit', 'busstop-delete'])
                        <th>Action</th>
                    @endcanany
                </tr>
            </tfoot>
            <tbody>
                @foreach ($busStops as $key => $data)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td class="text-left">{{ $data->name }}</td>
                        <td class="text-left">{{ $data->rate ?? '' }}</td>
                        <td class="text-left">{{ $data->remarks }}</td>
                        <td class="text-left">{{ $data->status }}</td>
                        @canany(['busstop-edit', 'busstop-delete'])
                            <th>Action</th>
                        @endcanany
                        <td>
                            <div class="icon-btn">
                                <nobr>
                                    @can('busstop-edit')
                                        <a href="{{ route('bus-stops.edit', $data->id) }}" data-toggle="tooltip" title="Edit"
                                            class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                    @endcan
                                    @can('busstop-delete')
                                        <form action="{{ url("hr/bus-stops/$data->id") }}" method="POST" data-toggle="tooltip"
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
