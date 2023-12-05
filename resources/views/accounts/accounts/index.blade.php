@extends('layouts.backend-layout')
@section('title', 'Account Names')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title')
    List of Accounts
@endsection

@section('breadcrumb-button')
    <a href="{{ route('accounts.create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
@endsection

@section('sub-title')
    Total: {{ count($accounts) }}
@endsection

@section('content')
    <!-- put search form here.. -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                <th class="px-4 py-3">#</th>
                <th class="px-4 py-3">Balance/Income Line</th>
                <th class="px-4 py-3">Balance/Income Type</th>
                <th class="px-4 py-3">Account Name</th>
                <th class="px-4 py-3">Account Type</th>
                <th class="px-4 py-3">Parent Account</th>
                <th class="px-4 py-3">Account Code</th>
                <th class="px-4 py-3">Action</th>
            </tr>
            </thead>
            <tbody>
                @forelse ($accounts as $line)
                    <tr class="text-gray-700 dark:text-gray-400">
                        <td class="px-4 py-3 text-sm">{{ $loop->iteration }}</td>
                        <td class="px-4 py-3 text-sm text-left">{{ $line->balanceIncome->line_text ?? '' }}</td>
                        <td class="px-4 py-3 text-sm">{{ $line->balanceIncome->line_type ?? '' }}</td>
                        <td class="px-4 py-3 text-sm text-left">{{ $line->account_name }}</td>
                        <td class="px-4 py-3 text-sm">{{ $line->account_type }}</td>
                        <td class="px-4 py-3 text-sm">{{ $line->parent->account_name}}</td>
                        <td class="px-4 py-3 text-sm">{{ $line->account_code}} </td>

                        <td class="flex items-center gap-4 px-4 py-3 text-xs">
                            <div class="icon-btn">
                                <nobr>
                                    <a href="{{ route('accounts.edit', $line->id) }}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                    <form action="{{ url("accounts/$line->id") }}" method="POST" data-toggle="tooltip" title="Delete" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm delete"><i class="fas fa-trash"></i></button>
                                    </form>
                                </nobr>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr class="text-center text-gray-700 dark:text-gray-400">
                        <td colspan="7" class="px-4 py-3 text-sm">
                            No categories found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection

@section('script')
    <script src="{{asset('js/Datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('js/Datatables/dataTables.bootstrap4.min.js')}}"></script>
    <script>
        $(window).scroll(function () {
            //set scroll position in session storage
            sessionStorage.scrollPos = $(window).scrollTop();
        });
        var init = function () {
            //get scroll position in session storage
            $(window).scrollTop(sessionStorage.scrollPos || 0)
        };
        window.onload = init;

        $(document).ready(function () {
            $('#dataTable').DataTable({
                stateSave: true
            });
        });
    </script>
@endsection
