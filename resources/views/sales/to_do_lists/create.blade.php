@extends('layouts.backend-layout')
@section('title', 'To Do List')

@section('breadcrumb-title', 'To Do List')

@section('breadcrumb-button')
@endsection

@section('sub-title')
@endsection
@section('content')
        @if(!empty($to_do_list))
            {!! Form::open(array('url' => "to_do_lists/$to_do_list->id",'method' => 'PUT')) !!}
            <input type="hidden" name="id" value="{{old('id') ? old('id') : (!empty($to_do_list->id) ? $to_do_list->id : null)}}">
        @else
            {!! Form::open(array('url' => "to_do_lists",'method' => 'POST')) !!}
        @endif
        <div class="row">
            <div class="col-md-5 pr-md-1 my-1 my-md-0">
                {{Form::text('task_name', old('task_name') ? old('task_name') : (!empty($to_do_list->task_name) ? $to_do_list->task_name : null),['class' => 'form-control form-control-sm','id' => 'task_name', 'placeholder' => 'Enter Task Name', 'autocomplete'=>"off"] )}}
            </div>
            @if($formType=="edit")
                <div class="col-md-5 pr-md-1 my-1 my-md-0">
                    {{Form::text('completion_date', old('completion_date') ? old('completion_date') : (!empty($to_do_list->completion_date) ? $to_do_list->completion_date : null),['class' => 'form-control form-control-sm','id' => 'completion_date', 'placeholder' => 'Enter Completion Date if task is complete', 'autocomplete'=>"off"] )}}
                </div>
            @endif

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
                    <th>Task</th>
                    <th>Creating Date</th>
                    <th>Completion Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>SL</th>
                    <th>Task</th>
                    <th>Creating Date</th>
                    <th>Completion Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </tfoot>
                <tbody>
                @foreach($to_do_lists as $key => $data)
                    <tr>
                        <td>{{$key  + $to_do_lists->firstItem()}}</td>
                        <td class="text-center breakWords">{{$data->task_name}}</td>
                        <td class="text-center">{{$data->creating_date}}</td>
                        <td class="text-center">{{ $data->completion_date==null  ? "---": $data->completion_date}}</td>
                        @if($data->status=='Pending')
                            <td class="text-center text-danger "><strong>{{$data->status}}</strong></td>
                        @else
                            <td class="text-center text-success "><strong>{{$data->status}}</strong></td>
                        @endif

                            <td>
                            <div class="icon-btn">
                                <nobr>
                                    <a href="{{ url("to_do_lists/$data->id/edit") }}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                    {!! Form::open(array('url' => "to_do_lists/$data->id",'method' => 'delete', 'class'=>'d-inline','data-toggle'=>'tooltip','title'=>'Delete')) !!}
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
@section('script')
    <script>

    $('#completion_date').datepicker({format: "dd-mm-yyyy",autoclose: true,todayHighlight: true,showOtherMonths: true});
    </script>
@endsection
