@extends('boq.departments.electrical.layout.app')
@section('title', 'EME Labor Budget List')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title')
    Labor Budget List
@endsection

@section('breadcrumb-button')
    @can('project-create')
        <a href="{{ route('boq.project.departments.electrical.eme-labor-budgets.create',['project' => $project]) }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
    @endcan
@endsection

@section('sub-title')
    Total: {{ count($emeLaborBudget) }}
@endsection

    @section('content')
            <!-- put search form here.. -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>SL</th>
                <th style="width: 250px;word-wrap:break-word">Work Head</th>
                <th style="width: 250px;word-wrap:break-word">Work Name</th>
                <th style="width: 250px;word-wrap:break-word">Unit</th>
                <th style="width: 250px;word-wrap:break-word">Quantity</th>
                <th style="width: 250px;word-wrap:break-word">Labor Rate</th>
                <th style="width: 250px;word-wrap:break-word">Total Rate</th>
                <th>Action</th>
            </tr>
            </thead>
            <tfoot>
            </tfoot>
            <tbody>
                @foreach($emeLaborBudget as $data)
                <tr>
                    <td>{{$loop->iteration }}</td>
                    <td>{{$data->boqEmeRate->emeWork->name }}</td>
                    <td>
                            {{ $data->boqEmeRate->boq_work_name }}
                    </td>
                    <td>{{$data->boqEmeRate->laborUnit->name }}</td>
                    <td>{{$data->quantity }}</td>
                    <td>{{$data->labor_rate }}</td>
                    <td>{{ $data->total_labor_amount }}</td>
                    <td>
                        @include('components.buttons.action-button', ['actions' => ['edit', 'delete'], 'route' => 'boq.project.departments.electrical.eme-labor-budgets', 'route_key' => ['project' => $project,'eme_labor_budget' => $data]])
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
                bPaginate: true
            });
        });
    </script>
@endsection
