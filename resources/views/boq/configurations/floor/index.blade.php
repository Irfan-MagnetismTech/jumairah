@extends('layouts.backend-layout')
@section('title', 'BOQ - Floor List')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title')
    List of Floor
@endsection

@section('breadcrumb-button')
    @can('project-create')
        <a href="{{ route('boq.configurations.floors.create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
    @endcan
@endsection

@section('sub-title')
    Total: {{ count($floors) }}
    @endsection

    @section('content')
            <!-- put search form here.. -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>SL</th>
                <th style="width: 250px;word-wrap:break-word">Parent Floor</th>
                <th style="width: 250px;word-wrap:break-word">Type Name</th>
                <th>Floor Name</th>
                <th>Action</th>
            </tr>
            </thead>
            <tfoot>
            </tfoot>
            <tbody>
            @foreach($floors as $key => $floor)
                <tr>
                    <td>{{ $loop->iteration}}</td>
                    <td> {{ $floor?->parent?->name ?? '---'}}</td>
                    <td> {{ $floor?->floor_type?->name ?? ''}}</td>
                    <td>{{ $floor?->name}}</td>
                    <td>
                        @if($floor?->name == "Ground Floor")
                        @else
                        @include('components.buttons.action-button', ['actions' => ['edit', 'delete'], 'route' => 'boq.configurations.floors', 'route_key' => $floor->id])
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="float-right">
            {{ $floors->links() }}
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
