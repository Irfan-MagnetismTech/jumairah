@extends('layouts.backend-layout')
@section('title', 'Salary Setting')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    List of salary settings
@endsection

@section('style')
    <style>
    </style>
@endsection
@section('breadcrumb-button')
    @can('salary-setting-create')
        <a href="{{ route('salary-settings.create') }}" class="btn btn-out-dashed btn-sm btn-warning"><i
                class="fas fa-plus"></i></a>
    @endcan
@endsection
@section('sub-title')
    Total: {{ count($salarySettings) }}
@endsection


@section('content')
    <div class="dt-responsive table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#SL</th>
                    <th>Emplayee Type</th>
                    <th>Basic Salary</th>
                    <th>House Rent</th>
                    <th>Medical Allowance</th>
                    <th>Conveyance Allowance</th>
                    <th>Food Allowance</th>
                    @canany(['salary-setting-edit', 'salary-setting-delete'])
                        <th>Action</th>
                    @endcanany
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>#SL</th>
                    <th>Emplayee Type</th>
                    <th>Basic Salary</th>
                    <th>House Rent</th>
                    <th>Medical Allowance</th>
                    <th>Conveyance Allowance</th>
                    <th>Food Allowance</th>
                    @canany(['salary-setting-edit', 'salary-setting-delete'])
                        <th>Action</th>
                    @endcanany
                </tr>
            </tfoot>
            <tbody>
                @foreach ($salarySettings as $key => $data)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $data->employeeType->name ?? '' }}</td>
                        <td>{{ $data->basic }} %</td>
                        <td>{{ $data->house_rent }} %</td>
                        <td>{{ $data->medical_allowance }} %</td>
                        <td>{{ $data->conveyance_allowance }} %</td>
                        <td>{{ $data->food_allowance }} %</td>
                        @canany(['salary-setting-edit', 'salary-setting-delete'])
                            <td>
                                <div class="icon-btn">
                                    <nobr>
                                        @can('salary-setting-edit')
                                            <a href="{{ route('salary-settings.edit', $data->id) }}" data-toggle="tooltip"
                                                title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                        @endcan
                                        @can('salary-setting-delete')
                                            <form action="{{ url("hr/salary-settings/$data->id") }}" method="POST"
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
