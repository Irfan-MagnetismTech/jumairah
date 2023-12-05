@extends('layouts.backend-layout')
@section('title', 'teams')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title')
    List of Teams
@endsection

@section('breadcrumb-button')
    @can('team-create')
        <a href="{{ url('teams/create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
    @endcan
@endsection

@section('sub-title')
    Total: {{ count($teams) }}
@endsection
@section('content')
    <div class="row">
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>SL</th>
                <th>Name</th>
                <th>Head</th>
                <th>Action</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>SL</th>
                <th>Name</th>
                <th>Head</th>
                <th>Action</th>
            </tr>
            </tfoot>
            <tbody>
            @foreach($teams as $key => $data)
                <tr>
                    <td>{{$key  + $teams->firstItem()}}</td>
                    <td class="text-center">{{$data->name}}</td>
                    <td class="text-center">{{$data->user->name}}</td>
                    <td>
                        <div class="icon-btn">
                            <nobr>
                                @can('team-view')
                                    <a href="{{ url("teams/$data->id") }}" data-toggle="tooltip" title="Show" class="btn btn-outline-primary"><i class="fas fa-eye"></i></a>
                                @endcan
                                @can('team-edit')
                                    <a href="{{ url("teams/$data->id/edit") }}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                @endcan
                                @can('team-delete')
                                    {!! Form::open(array('url' => "teams/$data->id",'method' => 'delete', 'class'=>'d-inline','data-toggle'=>'tooltip','title'=>'Delete')) !!}
                                    {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete'])}}
                                @endcan
                                    {!! Form::close() !!}
                            </nobr>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
