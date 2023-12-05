@extends('layouts.backend-layout')
@section('title', 'Cash Flow Lines')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title')
    List of Cash Flow Lines
@endsection

@section('breadcrumb-button')
    <a href="{{ route('cash-flow-lines.create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
@endsection

@section('sub-title')
    Total: {{ count($lines) }}
@endsection

@section('content')
    <!-- put search form here.. -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Line Type</th>
                    <th>Net Income</th>
                    <th>Line Text</th>
                    <th>Value Type</th>
{{--                    <th>Balance Type</th>--}}
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($lines as $line)
                <tr class="text-gray-700 dark:text-gray-400">
                    <td> {{ $loop->index + $lines->firstItem() }} </td>
                    <td> {{ $line->line_type }} </td>
                    <td> {{ $line->is_net_income ? "Yes" : "No"}} </td>
                    <td class="px-4 py-3 text-xs"> {{ $line->line_text ?? '---' }} </td>
                    <td> {{ $line->value_type }} </td>
{{--                    <td> {{ $line->balance_type }}  </td>--}}
                    <td class="flex items-center gap-4 px-4 py-3 text-xs">
                        <div class="icon-btn">
                            <nobr>
                                <a href="{{ route('cash-flow-lines.edit', $line->id) }}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                <form action="{{ url("cash-flow-lines/$line->id") }}" method="POST" data-toggle="tooltip" title="Delete" class="d-inline">
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
                        <td colspan="8" class="px-4 py-3 text-sm">
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
