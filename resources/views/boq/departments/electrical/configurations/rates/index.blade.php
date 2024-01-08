@extends('boq.departments.electrical.layout.app')
@section('title', 'BOQ - Rate List')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title')
    List of Rate
@endsection

@section('breadcrumb-button')
    @can('project-create')
        <a href="{{ route('boq.project.departments.electrical.configurations.rates.create',['project' => $project]) }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
    @endcan
@endsection

@section('sub-title')
    Total: {{ count($BoqEmeRateData) }}
    @endsection

    @section('content')
            <!-- put search form here.. -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>SL</th>
                <th style="width: 250px;word-wrap:break-word">Item Name</th>
                <th style="width: 250px;word-wrap:break-word">Material Name / Work Name</th>
                <th style="width: 250px;word-wrap:break-word">Rate</th>
                <th>Action</th>
            </tr>
            </thead>
            <tfoot>
            </tfoot>
            <tbody>
                @foreach($BoqEmeRateData as $data)
                <tr>
                    <td>{{$loop->iteration }}</td>
                    <td>
                            @if ($data->boq_work_name == null)
                            {{$data->NestedMaterialSecondLayer->name }}
                            @else
                            {{ $data->emeWork->name }}
                            @endif
                    </td>
                    <td>
                        @if($data->type)
                        {{$data->boq_work_name}}
                        @else
                        {{$data->NestedMaterial->name }}
                        @endif
                    </td>
                    <td>{{$data->labour_rate }}</td>
                    <td>
                        @include('components.buttons.action-button', ['actions' => ['edit', 'delete'], 'route' => 'boq.project.departments.electrical.configurations.rates', 'route_key' => ['project' => $project,'rate' => $data]])
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
