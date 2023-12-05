@extends('boq.departments.electrical.layout.app')
@section('title', 'CS Options')

@section('breadcrumb-title')
    @if($formType == 'edit')  Edit  @else  Create  @endif
    CS Options
@endsection

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">

    <style>
        .input-group-addon{
           // min-width: 110px;
        }
    </style>
@endsection
@section('breadcrumb-button')
    <a href="{{ route('boq.project.departments.electrical.configurations.cs_supplier_eval_option.index',['project' => $project]) }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection
@section('content')

        @if ($formType == 'edit')
            <form action="{{ route('boq.project.departments.electrical.configurations.cs_supplier_eval_option.update',['project' => $project,'cs_supplier_eval_option' => $cs_supplier_eval_option]) }}" method="POST" class="custom-form">
        @method('put')
        @else
            <form action="{{ route('boq.project.departments.electrical.configurations.cs_supplier_eval_option.store',['project' => $project]) }}" method="POST" class="custom-form">
        @endif
        @csrf
                <div class="row">
                    <div class="col-md-5 pr-md-1 my-1 my-md-0">
                        {{Form::text('name', old('name') ? old('name') : (!empty($cs_supplier_eval_option->name) ? $cs_supplier_eval_option->name : null),['class' => 'form-control','id' => 'name', 'placeholder' => 'Option Name'] )}}
                    </div>
                    <div class="col-md-2 pl-md-1 my-1 my-md-0">
                        <div class="input-group input-group-sm">
                            <button class="btn btn-success btn-sm btn-block">Submit</button>
                        </div>
                    </div>
                </div><!-- end form row -->
            </form>
        <hr class="my-2 bg-success">
        <div class="table-responsive">
            <table id="dataTable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>#SL</th>
                        <th>Option Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>#SL</th>
                        <th>Option Name</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody>
                @foreach($permissions as $key => $data)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td class="text-left">{{$data->name}}</td>
                        <td>
                            <div class="icon-btn">
                                <nobr>
                                    <a href="{{ route('boq.project.departments.electrical.configurations.cs_supplier_eval_option.edit',['project' => $project,'cs_supplier_eval_option' => $data]) }}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>

                                    <form action="{{ route('boq.project.departments.electrical.configurations.cs_supplier_eval_option.destroy',['project' => $project,'cs_supplier_eval_option' => $data]) }}" class='d-inline' data-toggle='tooltip' title='Delete' method="POST">
                                        @method('delete')
                                        @csrf
                                        {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete'])}}
                                    </form>
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

