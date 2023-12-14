@extends('boq.departments.civil.layout.app')
@section('title', 'BOQ - Work List')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    List of Work
@endsection

@section('breadcrumb-button')
    @can('project-create', 'boq-civil')
        <a href="{{ route('boq.project.departments.civil.configurations.works.create', ['project' => $project]) }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
    @endcan
@endsection

@section('sub-title')
    Total: {{ count($works) }}
@endsection

@section('content')
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>SL</th>
                    <th style="width: 250px;word-wrap:break-word">Work Head</th>
                    <th style="width: 250px;word-wrap:break-word">Name</th>
                    <th style="width: 250px;word-wrap:break-word">Work For</th>
                    <th style="width: 250px;word-wrap:break-word">Type</th>
                    @can('boq-civil')
                    <th>Action</th>
                    @endcan
                </tr>
            </thead>
            <tfoot>
            </tfoot>
            <tbody>
                @foreach ($works as $key => $work)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $work?->parent?->name ?? '---' }}</td>
                        <td>{{ $work?->name ?? '---' }}</td>
                        <td>{{ $work?->calculation_type ?? '---' }}</td>
                        <td>{{ $work?->is_reinforcement ? 'Reinforcement' : '---' }}</td>
                        @can('boq-civil')
                        <td>
                            @include('components.buttons.action-button', ['actions' => ['edit', 'delete'], 'route' => 'boq.project.departments.civil.configurations.works', 'route_key' => ['project' => $project, 'work' => $work->id]])
                        </td>
                        @endcan
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="float-right">
        </div>
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
                stateSave: true,
                bPaginate: false
            });
        });
    </script>
@endsection
