@extends('boq.departments.sanitary.layout.app')
@section('title', 'BOQ - Calculation List')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title')
    List of Budget Summary
@endsection
@section('project-name')
    {{$project->name}}
@endsection

@section('breadcrumb-button')
{{--    @can('project-create')--}}
@can('boq-sanitary')
        <a href="{{ route('boq.project.departments.sanitary.sanitary-budget-summaries.create',['project' => $project]) }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
@endcan
@endsection

@section('sub-title')
@endsection

    @section('content')
            <!-- put search form here.. -->
    @php
        $BudgetType = ['Main','Incremental'];
    @endphp
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>SL</th>
                <th style="width: 250px;word-wrap:break-word">Project Name</th>
                <th style="width: 250px;word-wrap:break-word">Rate Per Unit</th>
                <th style="width: 250px;word-wrap:break-word">Total Amount </th>
                <th style="width: 250px;word-wrap:break-word">Budget Type </th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($allData as $key => $data)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$data->project->name}}</td>
                    <td class="text-right">{{$data->rate_per_unit}}</td>
                    <td class="text-right">@money($data->total_amount)</td>
                    <td class="text-right">{{ $BudgetType[$data->type] }}</td>
                    <td>
                        @include('components.buttons.action-button', ['actions' => ['edit', 'delete'], 'route' => 'boq.project.departments.sanitary.sanitary-budget-summaries', 'route_key' => ['project' => $project,'sanitary_budget_summary' => $data->id,'calculation' => 4]])
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="float-right">

        </div>
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
                stateSave: true,
                bPaginate: false
            });
        });
    </script>
@endsection
