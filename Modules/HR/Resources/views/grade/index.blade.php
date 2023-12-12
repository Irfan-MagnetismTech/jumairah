@extends('layouts.backend-layout')
@section('title', 'Grade')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    List of Grades
@endsection

@section('style')
    <style>
    </style>
@endsection
@section('breadcrumb-button')
    @can('grade-create')
        <a href="{{ route('grades.create') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-plus"></i></a>
    @endcan
@endsection
@section('sub-title')
    Total: {{ count($grades) }}
@endsection


@section('content')
    <div class="dt-responsive table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#SL</th>
                    <th>Name</th>
                    <th>Bangla</th>
                    <th>Minimum GS</th>
                    <th>Total Man Power</th>
                    <th>Salery Range</th>
                    <th>Status</th>
                    @canany(['grade-edit', 'grade-delete'])
                        <th>Action</th>
                    @endcanany
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>#SL</th>
                    <th>Name</th>
                    <th>Bangla</th>
                    <th>Minimum GS</th>
                    <th>Total Man Power</th>
                    <th>Salery Range</th>
                    <th>Status</th>
                    @canany(['grade-edit', 'grade-delete'])
                        <th>Action</th>
                    @endcanany
                </tr>
            </tfoot>
            <tbody>
                @foreach ($grades as $key => $data)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td class="text-left">{{ $data->name }}</td>
                        <td class="text-left">{{ $data->bangla ?? '' }}</td>
                        <td class="text-left">{{ $data->minimum_gs }}</td>
                        <td class="text-left">{{ $data->total_manpower }}</td>
                        <td class="text-left">{{ $data->salary_range }}</td>
                        <td class="text-left">{{ $data->status }}</td>
                        @canany(['grade-edit', 'grade-delete'])
                            <td>
                                <div class="icon-btn">
                                    <nobr>
                                        @can('grade-edit')
                                            <a href="{{ route('grades.edit', $data->id) }}" data-toggle="tooltip" title="Edit"
                                                class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                        @endcan
                                        @can('grade-delete')
                                            <form action="{{ url("hr/grades/$data->id") }}" method="POST" data-toggle="tooltip"
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
