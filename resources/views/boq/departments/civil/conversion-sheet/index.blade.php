@extends('boq.departments.civil.layout.app')
@section('title', 'BOQ - Conversion Sheet')
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection
@section('project-name')
    <a href="{{ route('boq.project.material-specifications.index', ['project' => $project]) }}"
        style="color:white;">{{ $project->name }}</a>
@endsection

@section('breadcrumb-title')
    Conversion Sheet
@endsection

@section('content-grid', 'col-12')
@section('breadcrumb-button')
@can('boq-civil')
<a href="{{ route('boq.project.departments.civil.conversion-sheets.create', ['project' => $project]) }}"
    class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
@endcan
@endsection

@section('sub-title')
    Total Item Head:
@endsection

@section('content')
    <style>
        tbody tr,
        td {
            text-align: left;
        }

        tbody td {
            margin-left: 5px;
        }
    </style>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>SL</th>
            <th style="width: 250px;word-wrap:break-word">Material</th>
            <th style="width: 250px;word-wrap:break-word">Floor</th>
            <th style="width: 250px;word-wrap:break-word">Date</th>
            <th style="width: 250px;word-wrap:break-word">Boq Quantity</th>
            <th style="width: 250px;word-wrap:break-word">Changed Quantity</th>
            <th style="width: 250px;word-wrap:break-word">Final Quantity</th>
            <th style="width: 250px;word-wrap:break-word">Remarks</th>
            @can('boq-civil')
            <th>Action</th>
            @endcan
        </tr>
        </thead>
        <tbody>
        @foreach ($conversion_sheets as $key => $conversion_sheet)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $conversion_sheet?->material?->name ?? '---' }}</td>
                <td>{{ $conversion_sheet?->floorProject?->floor?->name ?? $conversion_sheet?->boq_floor_id }}</td>
                <td>{{ $conversion_sheet?->conversion_date ?? '---' }}</td>
                <td>@money($conversion_sheet?->boq_qty)</td>
                <td>@money($conversion_sheet?->changed_qty)</td>
                <td>@money($conversion_sheet?->final_qty)</td>
                <td>{{ $conversion_sheet?->remarks ?? '---' }}</td>
                @can('boq-civil')
                <td>
                    @include('components.buttons.action-button', ['actions' => ['edit', 'delete'],
                        'route' => 'boq.project.departments.civil.conversion-sheets',
                        'route_key' => ['project' => $project, 'conversion_sheet' => $conversion_sheet->id]])
                </td>
                @endcan
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="float-right">
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
