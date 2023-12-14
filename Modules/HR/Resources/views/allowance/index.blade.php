@extends('layouts.backend-layout')
@section('title', 'Allowance')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    List of Allowances
@endsection

@section('style')
    <style>
    </style>
@endsection
@section('breadcrumb-button')
    @can('allowance-create')
        <a href="{{ route('allowances.create') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-plus"></i></a>
    @endcan
@endsection
@section('sub-title')
    {{-- Total: {{ count($allowances) }} --}}
@endsection


@section('content')
    <div class="dt-responsive table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#SL</th>
                    <th>Employee</th>
                    <th>Allowance Type</th>
                    <th>Amount</th>
                    @canany(['allowance-edit', 'allowance-delete'])
                        <th>Action</th>
                    @endcanany
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>#SL</th>
                    <th>Employee</th>
                    <th>Allowance Type</th>
                    <th>Amount</th>
                    @canany(['allowance-edit', 'allowance-delete'])
                        <th>Action</th>
                    @endcanany
                </tr>
            </tfoot>
            <tbody>
                @foreach ($allowances as $key => $data)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td class="text-left">{{ $data->employee?->emp_name }}</td>
                        <td class="text-left">{{ $data->allowance_type->name }}</td>
                        <td class="text-left">{{ $data->amount }}</td>
                        @canany(['allowance-edit', 'allowance-delete'])
                            <td>
                                <div class="icon-btn">
                                    <nobr>
                                        @can('allowance-edit')
                                            <a href="{{ route('allowances.edit', $data->id) }}" data-toggle="tooltip" title="Edit"
                                                class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                        @endcan
                                        @can('allowance-delete')
                                            <form action="{{ url("hr/allowances/$data->id") }}" method="POST" data-toggle="tooltip"
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
