@extends('boq.departments.civil.layout.app')
@section('title', 'BOQ - Reinforcement Measurement')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    List of Reinforcement Measurement
@endsection

@section('breadcrumb-button')
@can('boq-civil')
<a href="{{ route('boq.project.departments.civil.configurations.reinforcement-measurement.create', ['project' => $project]) }}" class="btn btn-out-dashed btn-sm btn-success">
    <i class="fas fa-plus"></i>
</a>
@endcan
@endsection

@section('sub-title')
    Total: {{ count($measurements) }}
@endsection

@section('content')
    <!-- put search form here.. -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>SL</th>
                    <th style="width: 250px;word-wrap:break-word">Dia</th>
                    <th style="width: 250px;word-wrap:break-word">Weight</th>
                    <th>Unit</th>
                    @can('boq-civil')
                    <th>Action</th>
                    @endcan
                </tr>
            </thead>
            <tfoot>
            </tfoot>
            <tbody>
                @foreach ($measurements as $key => $measurement)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td> {{ $measurement?->dia ?? '---' }}</td>
                        <td> {{ $measurement?->weight ?? '---' }}</td>
                        <td>{{ $measurement?->unit?->name ?? '---' }}</td>
                        @can('boq-civil')
                        <td>
                            @include('components.buttons.action-button', ['actions' => ['edit', 'delete'], 'route' => 'boq.project.departments.civil.configurations.reinforcement-measurement', 'route_key' => ['project' => $project, 'reinforcementMeasurement' => $measurement->id]])
                        </td>
                        @endcan
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="float-right">
            {{ $measurements->links() }}
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
