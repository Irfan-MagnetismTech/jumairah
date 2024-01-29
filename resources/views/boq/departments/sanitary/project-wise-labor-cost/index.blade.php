@extends('boq.departments.sanitary.layout.app')
@section('title', 'BOQ - Sanitary')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title')
    List of Labor Cost
@endsection
@section('project-name')
    {{$project->name}}
@endsection

@section('breadcrumb-button')
    @can('project-create')
        <a href="{{ route('boq.project.departments.sanitary.project-wise-labor-cost.create',['project' => $project]) }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
    @endcan
@endsection

@section('sub-title')
@endsection

    @section('content')
            <!-- put search form here.. -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>SL</th>
                <th>Item Name</th>
                <th>Unit</th>
                <th>Rate Per Unit</th>
                <th>Quantity</th>
                <th>Amount</th>
                @can('boq-sanitary')
                <th>Action</th>
                @endcan
            </tr>
            </thead>
            <tbody>
            @foreach($ProjectWiseLaborCostData as $data)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td class="text-left">{{$data->SanitaryLaborCost->name}}</td>
                    <td>{{$data->SanitaryLaborCost->unit->name }}</td>
                    <td >@money($data->SanitaryLaborCost->rate_per_unit)</td>
                    <td>{{$data->quantity}}</td>
                    <td>@money($data->SanitaryLaborCost->rate_per_unit * $data->quantity)</td>
                    @can('boq-sanitary')
                    <td>
                        @include('components.buttons.action-button', ['actions' => ['edit', 'delete'], 'route' => 'boq.project.departments.sanitary.project-wise-labor-cost', 'route_key' => ['project' => $project,'project_wise_labor_cost' => $data]])
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
