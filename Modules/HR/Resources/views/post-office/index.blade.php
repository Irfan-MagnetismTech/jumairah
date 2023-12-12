@extends('layouts.backend-layout')
@section('title', 'Post Office')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    List of Post Office
@endsection

@section('style')
    <style>
    </style>
@endsection
@section('breadcrumb-button')
    @can('post-office-create')
        <a href="{{ route('post-offices.create') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-plus"></i></a>
    @endcan
@endsection
@section('sub-title')
    Total: {{ count($postOffices) }}
@endsection


@section('content')
    <div class="dt-responsive table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#SL</th>
                    <th>Name</th>
                    <th>Bangla</th>
                    <th>District</th>
                    <th>Police Station</th>
                    <th>Post Code</th>
                    <th>Status</th>
                    @canany(['post-office-edit', 'post-office-delete'])
                        <th>Action</th>
                    @endcanany
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>#SL</th>
                    <th>Name</th>
                    <th>Bangla</th>
                    <th>District</th>
                    <th>Police Station</th>
                    <th>Post Code</th>
                    <th>Status</th>
                    @canany(['post-office-edit', 'post-office-delete'])
                        <th>Action</th>
                    @endcanany
                </tr>
            </tfoot>
            <tbody>
                @foreach ($postOffices as $key => $data)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td class="text-left">{{ $data->name }}</td>
                        <td class="text-left">{{ $data->bangla ?? '' }}</td>
                        <td class="text-left">{{ $data->district->name ?? '' }}</td>
                        <td class="text-left">{{ $data->police_station->name ?? '' }}</td>
                        <td class="text-left">{{ $data->post_code ?? '' }}</td>
                        <td class="text-left">{{ $data->status }}</td>
                        @canany(['post-office-edit', 'post-office-delete'])
                            <td>
                                <div class="icon-btn">
                                    <nobr>
                                        @can('post-office-edit')
                                            <a href="{{ route('post-offices.edit', $data->id) }}" data-toggle="tooltip"
                                                title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                        @endcan
                                        @can('post-office-delete')
                                            <form action="{{ url("hr/post-offices/$data->id") }}" method="POST"
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
