@extends('boq.departments.civil.layout.app')
@section('title', 'BOQ - Material Formula List')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    List of Material Formula
@endsection

@section('breadcrumb-button')
@can('boq-civil')
<a href="{{ route('boq.project.departments.civil.configurations.material-formulas.create', ['project' => $project]) }}" class="btn btn-out-dashed btn-sm btn-success">
    <i class="fas fa-plus"></i>
</a>
@endcan
@endsection

@section('sub-title')
    Total: {{ count($material_formulas) }}
@endsection

@section('content')
    <!-- put search form here.. -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>SL</th>
                    <th style="width: 250px;word-wrap:break-word">Material Name</th>
                    <th style="">Budget For</th>
                    <th style="width: 250px;word-wrap:break-word">Work Name</th>
                    <th>Formula Value(%)</th>
                    <th>Wastage Value(%)</th>
                    @can('boq-civil')
                    <th>Action</th>
                    @endcan
                </tr>
            </thead>
            <tfoot>
            </tfoot>
            <tbody>
                @foreach ($material_formulas as $key => $formula)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td> {{ \Illuminate\Support\Str::limit($formula?->material?->name,50) ?? '---' }}</td>
                        <td>{{ $formula?->work?->calculation_type ?? '---' }}</td>
                        <td>
                            @foreach ($formula?->work?->ancestors as $ancestor)
                                @if (!$loop->first)
                                    {{ $ancestor?->name }} ->
                                @endif
                            @endforeach

                            {{ $formula?->work?->name ?? '' }}

                        </td>
                        <td>{{ $formula?->percentage_value }}</td>
                        <td>{{ $formula?->wastage }}</td>
                        @can('boq-civil')
                        <td>
                            @include('components.buttons.action-button', ['actions' => ['edit', 'delete'], 'route' => 'boq.project.departments.civil.configurations.material-formulas', 'route_key' => ['materialFormula' => $formula->id, 'project' => $project]])
                        </td>
                        @endcan
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
                stateSave: true,
                bPaginate: false
            });
        });
    </script>
@endsection
