@extends('layouts.backend-layout')
@section('title', 'Bonus Setting')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    List of Bonus Setting
@endsection

@section('style')
    <style>
    </style>
@endsection
@section('breadcrumb-button')
    @can('bonus-setting-create')
        <a href="{{ route('bonus-settings.create') }}" class="btn btn-out-dashed btn-sm btn-warning"><i
                class="fas fa-plus"></i></a>
    @endcan
@endsection
@section('sub-title')
    Total: {{ count($bonusSettings) }}
@endsection


@section('content')
    <div class="dt-responsive table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#SL</th>
                    {{-- <th>Bonus</th> --}}
                    <th>Employee</th>
                    <th>Based On</th>
                    <th>Amount Type</th>
                    <th>Amount</th>
                    @canany(['bonus-setting-edit', 'bonus-setting-delete'])
                        <th>Action</th>
                    @endcanany
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>#SL</th>
                    {{-- <th>Bonus</th> --}}
                    <th>Employee</th>
                    <th>Based On</th>
                    <th>Amount Type</th>
                    <th>Amount</th>
                    @canany(['bonus-setting-edit', 'bonus-setting-delete'])
                        <th>Action</th>
                    @endcanany
                </tr>
            </tfoot>
            <tbody>
                @foreach ($bonusSettings as $key => $data)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        {{-- <td class="text-left">{{$data->bonus->name}}</td> --}}
                        <td class="text-left">{{ $data->employee?->emp_name }}</td>
                        <td class="text-left">{{ $data->based_on }}</td>
                        <td class="text-left">{{ $data->amount_type }}</td>
                        <td class="text-left">{{ $data->amount }}</td>
                        @canany(['bonus-setting-edit', 'bonus-setting-delete'])
                            <td>
                                <div class="icon-btn">
                                    <nobr>
                                        @can('bonus-setting-edit')
                                            <a href="{{ route('bonus-settings.edit', $data->id) }}" data-toggle="tooltip"
                                                title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                        @endcan
                                        @can('bonus-setting-delete')
                                            <form action="{{ url("hr/bonus-settings/$data->id") }}" method="POST"
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
