@extends('layouts.backend-layout')
@section('title', 'BOQ - Boq Floor Type List')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title')
    List of Boq Work Floor Type
@endsection

@section('breadcrumb-button')
    @can('project-create')
        <a href="{{ route('boq.configurations.floor-type-work.create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
    @endcan
@endsection

@section('sub-title')
    Total: {{ count($floor_type_works) }}
    @endsection

    @section('content')
            <!-- put search form here.. -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>SL</th>
                <th style="width: 250px;word-wrap:break-word">Floor Type</th>
                <th style="width: 250px;word-wrap:break-word">Work Name</th>
                <th>Action</th>
            </tr>
            </thead>
            <tfoot>
            </tfoot>
            <tbody>
            @foreach($floor_type_works as $key => $workFloorType)
                <tr>
                    <td>{{ $loop->iteration}}</td>
                    <td> {{ $workFloorType?->boq_floor_type?->name ?? '---'}}</td>
                    <td> {{ $workFloorType?->boq_work?->name ?? ''}}</td>
                    <td>
                        @include('components.buttons.action-button', ['actions' => ['edit', 'delete'], 'route' => 'boq.configurations.floor-type-work', 'route_key' => $workFloorType->id])
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="float-right">
            {{ $floor_type_works->links() }}
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
