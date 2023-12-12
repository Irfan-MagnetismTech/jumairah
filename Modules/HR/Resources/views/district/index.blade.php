@extends('layouts.backend-layout')
@section('title', 'District')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    List of Districts
@endsection

@section('style')
    <style>
    </style>
@endsection
@section('breadcrumb-button')
    @can('district-create')
        <a href="{{ route('districts.create') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-plus"></i></a>
    @endcan
@endsection
@section('sub-title')
    Total: {{ count($districts) }}
@endsection


@section('content')
    <div class="dt-responsive table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#SL</th>
                    <th>Name</th>
                    <th>Bangla</th>
                    <th>Division</th>
                    <th>Short Name</th>
                    @canany(['district-edit', 'district-delete'])
                        <th>Action</th>
                    @endcanany
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>#SL</th>
                    <th>Name</th>
                    <th>Bangla</th>
                    <th>Division</th>
                    <th>Short Name</th>
                    @canany(['district-edit', 'district-delete'])
                        <th>Action</th>
                    @endcanany
                </tr>
            </tfoot>
            <tbody>
                @foreach ($districts as $key => $data)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td class="text-left">{{ $data->name }}</td>
                        <td class="text-left">{{ $data->bangla ?? '' }}</td>
                        <td class="text-left">{{ $data->division->name }}</td>
                        <td class="text-left">{{ $data->short_name }}</td>
                        @canany(['district-edit', 'district-delete'])
                            <td>
                                <div class="icon-btn">
                                    <nobr>
                                        @can('district-edit')
                                            <a href="{{ route('districts.edit', $data->id) }}" data-toggle="tooltip" title="Edit"
                                                class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                        @endcan
                                        @can('district-delete')
                                            <form action="{{ url("hr/districts/$data->id") }}" method="POST" data-toggle="tooltip"
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
