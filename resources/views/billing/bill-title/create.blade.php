@extends('layouts.backend-layout')
@section('title', 'Bill Title')

@section('breadcrumb-title', 'Bill Title')

@section('breadcrumb-button')
{{--    <a href="{{ route('departments.index')}}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>--}}
@endsection

@section('sub-title')
    {{--<span class="text-danger">*</span> Marked are required.--}}
@endsection
@section('content')
        @if(!empty($bill_title))
            {!! Form::open(array('url' => "bill-title/$bill_title->id",'method' => 'PUT', 'class'=>'custom-form')) !!}
        @else
            {!! Form::open(array('url' => "bill-title",'method' => 'POST', 'class'=>'custom-form')) !!}
        @endif

        <div class="row">
            <div class="col-md-5 pr-md-1 my-1 my-md-0">
                {{Form::text('name', old('name') ? old('name') : (!empty($bill_title->name) ? $bill_title->name : null),['class' => 'form-control form-control-sm','id' => 'name', 'placeholder' => 'Enter Department Name', 'autocomplete'=>"off"] )}}
                <input type="hidden" name="id" value="{{old('id') ? old('id') : (!empty($department->id) ? $department->id : null)}}">
            </div>
            <div class="col-md-2 pl-md-1 my-1 my-md-0">
                <div class="input-group input-group-sm">
                    <button class="btn btn-success btn-sm btn-block">Submit</button>
                </div>
            </div>
        </div><!-- end form row -->
        {!! Form::close() !!}
        <br>
        <hr class="my-2 bg-success">
        <div class="table-responsive">
            <table id="dataTable" class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>SL</th>
                    <th>Bill Title Name</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>SL</th>
                    <th>Bill Title Name</th>
                    <th>Action</th>
                </tr>
                </tfoot>
                <tbody>
                @foreach($departments as $key => $data)
                    <tr>
                        <td>{{$key  + $departments->firstItem()}}</td>
                        <td class="">{{$data->name}}</td>
                        <td>
                            <div class="icon-btn">
                                <nobr>
                                        <a href="{{ url("bill-title/$data->id/edit") }}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                              
                                  
                                        {!! Form::open(array('url' => "bill-title/$data->id",'method' => 'delete', 'class'=>'d-inline','data-toggle'=>'tooltip','title'=>'Delete')) !!}
                                        {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete'])}}
                                   
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
