@extends('layouts.backend-layout')
@section('title', 'Projects')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title')
    List of Projects
@endsection

@section('breadcrumb-button')
    @can('project-create')
        <a href="{{ url('projects/create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
    @endcan
@endsection

@section('sub-title')
    Total: {{ count($projects) }}
    @endsection

    @section('content')
            <!-- put search form here.. -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>SL</th>
                <th style="width: 250px;word-wrap:break-word">Project Name</th>
                <th>Status</th>
                <th>Category</th>
                <th>Storied</th>
                <th>Units</th>
                <th>Land Owner Share</th>
                <th>Developer Share</th>
                <th>Action</th>
            </tr>
            </thead>
            <tfoot>
            </tfoot>
            <tbody>
            @foreach($projects as $key => $project)
                <tr>
                    <td> {{ $loop->iteration}}</td>
                    <td class="text-left">
                        <strong><a href="{{ url("projects/$project->id") }}"> {{ $project->name}}</a></strong> <br>
                        {{ $project->location}}
                    </td>
                    <td>{{ $project->status}}</td>
                    <td> {{ $project->category}}</td>
                    <td> {{ $project->storied}}</td>
                    <td> {{ $project->units}}</td>
                    <td> {{ $project->landowner_share}}</td>
                    <td> {{ $project->developer_share}}</td>
                    <td>
                        <div class="icon-btn">
                            <nobr>
                                @can('project-view')
                                    <a href="{{ url("projects/$project->id") }}" data-toggle="tooltip" title="Show" class="btn btn-outline-primary"><i class="fas fa-eye"></i></a>
                                @endcan
                                @can('project-edit')
                                     <a href="{{ url("projects/$project->id/edit") }}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                @endcan
                                 @can('project-delete')
                                    {!! Form::open(array('url' => "projects/$project->id",'method' => 'delete', 'class'=>'d-inline','data-toggle'=>'tooltip','title'=>'Delete')) !!}
                                    {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete'])}}
                                @endcan
                                    {!! Form::close() !!}
                                <a href="{{ url("projects/{$project->id}/log") }}" data-toggle="tooltip" title="Log" class="btn btn-dark"><i class="fas fa-history"></i></a>
                            </nobr>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
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
                stateSave: true
            });
        });
    </script>
@endsection
