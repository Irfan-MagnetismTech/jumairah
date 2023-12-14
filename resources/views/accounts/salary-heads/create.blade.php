@extends('layouts.backend-layout')
@section('title', 'salary-heads')

@section('breadcrumb-title', 'Salary Particular')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-button')
{{--    <a href="{{ route('departments.index')}}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>--}}
@endsection

@section('sub-title')
    {{--<span class="text-danger">*</span> Marked are required.--}}
@endsection
@section('content')
{{--    @can('department-create')--}}
        @if(!empty($salaryHead))
            {!! Form::open(array('url' => "accounts/salary-heads/$salaryHead->id",'method' => 'PUT', 'class'=>'custom-form')) !!}
            <input type="hidden" name="id" value="{{old('id') ? old('id') : (!empty($salaryHead->id) ? $salaryHead->id : null)}}">
        @else
            {!! Form::open(array('url' => "accounts/salary-heads",'method' => 'POST', 'class'=>'custom-form')) !!}
        @endif

        <div class="row">
            <div class="col-md-5 pr-md-1 my-1 my-md-0">
                {{Form::text('name', old('name') ? old('name') : (!empty($salaryHead->name) ? $salaryHead->name : null),['class' => 'form-control form-control-sm','id' => 'name', 'placeholder' => 'Enter Particular Name', 'autocomplete'=>"off"] )}}
                <input type="hidden" name="id" value="{{old('id') ? old('id') : (!empty($salaryHead->id) ? $salaryHead->id : null)}}">
            </div>
            <div class="col-md-3 pr-md-1 my-1 my-md-0">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="project_id">Is Allocate<span class="text-danger"></span></label>
                    <input type="radio" id="yes" name="is_allocate" style="height:20px; width:20px; margin-left: 30px; margin-top: 8px" value="1" {{ (!empty($salaryHead) && $salaryHead->is_allocate == 1 ? 'checked' : "") }}>
                    <label  style="margin-left: 5px; margin-top: 12px" for="yes">Yes</label><br>

                    <input type="radio" id="no" name="is_allocate" style="height:20px; width:20px; margin-left: 30px; margin-top: 8px" value="0" {{ (!empty($salaryHead) && $salaryHead->is_allocate == 0 ? 'checked': "") }}>
                    <label  style="margin-left: 5px; margin-top: 12px" for="no">No</label><br>
                </div>
            </div>
            <div class="col-md-2 pl-md-1 my-1 my-md-0">
                <div class="input-group input-group-sm">
                    <button class="btn btn-success btn-sm btn-block">Submit</button>
                </div>
            </div>
        </div><!-- end form row -->
        {!! Form::close() !!}
{{--    @endcan--}}
        <br>
        <hr class="my-2 bg-success">
        <div class="table-responsive">
            <table id="dataTable" class="table table-striped table-bordered">
                <thead>
                <tr>

                    <th>SL</th>
                    <th>Salary Particulars</th>
                    <th>Allocate Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($heads as $key => $data)
                    <tr>
                        <td>{{1 + $key }}</td>
                        <td class="text-left">{{$data->name}}</td>
                        <td>
                            {{$data->is_allocate}}
                        </td>
                        <td>
                            <div class="icon-btn">
                                <nobr>
                                       <a href="{{ url("accounts/salary-heads/$data->id/edit") }}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                        {!! Form::open(array('url' => "accounts/salary-heads/$data->id",'method' => 'delete', 'class'=>'d-inline','data-toggle'=>'tooltip','title'=>'Delete')) !!}
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

