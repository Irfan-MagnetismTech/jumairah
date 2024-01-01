@extends('boq.departments.civil.layout.app')
@section('title', 'BOQ - Price Escalation List')
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection
@section('project-name')
    <a href="{{ route('boq.project.material-specifications.index', ['project' => $project]) }}"
        style="color:white;">{{ $project->name }}</a>
@endsection

@section('breadcrumb-title')
    Price Escalation List
@endsection

@section('content-grid', 'col-12')
@section('breadcrumb-button')
@can('boq-civil')
<a href="{{ route('boq.project.departments.civil.revised-sheets.create', ['project' => $project]) }}"
    class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
@endcan
@endsection

@section('sub-title')
    Total Item Head:
@endsection

@section('content')
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>SL</th>
                <th>Escalation No</th>
                <th style="width: 250px;word-wrap:break-word">Material</th>
                <th style="width: 250px;word-wrap:break-word">Floor</th>
                <th style="width: 250px;word-wrap:break-word">Date</th>
                <th style="width: 250px;word-wrap:break-word">Amount</th>
                @can('boq-civil')
                <th>Action</th>
                @endcan
            </tr>
            </thead>
            <tfoot>
            </tfoot>
            <tbody>
            @foreach ($revised_sheets as $key => $revised_sheet)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $revised_sheet?->escalation_no }}</td>
                    <td>{{ $revised_sheet?->material?->name ?? '---' }}</td>
                    <td>{{ $revised_sheet?->floorProject?->floor?->name ?? $revised_sheet?->boq_floor_id }}</td>
                    <td>{{ $revised_sheet?->till_date ?? '---' }}</td>
                    <td>@money($revised_sheet?->increased_or_decreased_amount)</td>
                    @can('boq-civil')
                    <td>
                        @include('components.buttons.action-button', ['actions' => ['edit', 'delete'],
                            'route' => 'boq.project.departments.civil.revised-sheets',
                            'route_key' => ['project' => $project, 'revised_sheet' => $revised_sheet->id]])
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
        $(document).ready(function() {
            $('#dataTable').DataTable({
                stateSave: true,
                bPaginate: false
            });
        });
    </script>
@endsection
