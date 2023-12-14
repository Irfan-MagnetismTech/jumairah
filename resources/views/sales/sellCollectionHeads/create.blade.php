@extends('layouts.backend-layout')
@section('title', 'Sale Collection Heads')

@section('breadcrumb-title', 'Sale Collection Heads')

@section('breadcrumb-button')
@endsection

@section('sub-title')
@endsection
@section('content')
    @can('sellCollectionHead-create')
        @if(!empty($sellCollectionHead))
            {!! Form::open(array('url' => "sellCollectionHeads/$sellCollectionHead->id",'method' => 'PUT')) !!}
        @else
            {!! Form::open(array('url' => "sellCollectionHeads",'method' => 'POST')) !!}
        @endif
        <div class="row">
            <div class="col-md-5 pr-md-1 my-1 my-md-0">
                {{Form::text('name', old('name') ? old('name') : (!empty($sellCollectionHead->name) ? $sellCollectionHead->name : null),['class' => 'form-control form-control-sm','id' => 'name', 'placeholder' => 'Enter Sell Collection Head', 'autocomplete'=>"off"] )}}
            </div>
            <div class="col-md-2 pl-md-1 my-1 my-md-0">
                <div class="input-group input-group-sm">
                    <button class="btn btn-success btn-sm btn-block">Submit</button>
                </div>
            </div>
        </div><!-- end form row -->
        {!! Form::close() !!}
    @endcan
        <br>
        <hr class="my-2 bg-success">
        <div class="table-responsive">
            <table id="dataTable" class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>SL</th>
                    <th>Head</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>SL</th>
                    <th>Head</th>
                    <th>Action</th>
                </tr>
                </tfoot>
                <tbody>
                @foreach($sellCollectionHeads as $key => $data)
                    <tr>
                        <td>{{$key  + $sellCollectionHeads->firstItem()}}</td>
                        <td class="text-center">{{$data->name}}</td>
                        <td>
                            <div class="icon-btn">
                                <nobr>
                                    @can('sellCollectionHead-edit')
                                    <a href="{{ url("sellCollectionHeads/$data->id/edit") }}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                    @endcan

                                    @can('sellCollectionHead-delete')
                                    {!! Form::open(array('url' => "sellCollectionHeads/$data->id",'method' => 'delete', 'class'=>'d-inline','data-toggle'=>'tooltip','title'=>'Delete')) !!}
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
