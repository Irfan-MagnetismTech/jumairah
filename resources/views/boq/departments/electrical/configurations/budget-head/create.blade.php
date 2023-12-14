@extends('boq.departments.electrical.layout.app')
@section('title', 'BOQ - EME Budget Head')
 
@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title', "EME Budget Head")

@section('breadcrumb-button')
@endsection

@section('sub-title') 
@endsection
@section('content')
        @if($formType == 'edit')
            {!! Form::open(array('url' => "boq/project/$project->id/departments/electrical/configurations/eme-budget-head/$budgetHead->id",'method' => 'PUT')) !!}
            <input type="hidden" name="id" value="{{old('id') ? old('id') : (!empty($budgetHead) ? $budgetHead->id : null)}}">
        @else
            {!! Form::open(array('url' => "boq/project/$project->id/departments/electrical/configurations/eme-budget-head",'method' => 'POST')) !!}
        @endif
        <div class="row">
            <div class="col-md-5 pr-md-1 my-1 my-md-0">
                {{Form::text('name', old('name') ? old('name') : (!empty($budgetHead) ? $budgetHead->name : null),['class' => 'form-control form-control-sm','id' => 'name', 'placeholder' => 'Enter Head Name', 'autocomplete'=>"off"] )}}
            </div>
            <div class="col-md-2 pl-md-1 my-1 my-md-0">
                <div class="input-group input-group-sm">
                    <button class="btn btn-success btn-sm btn-block">Submit</button>
                </div>
            </div>
        </div><!-- end form row -->

        {!! Form::close() !!}
        <hr class="my-2 bg-success">

        <div class="table-responsive">
            <table id="dataTable" class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>SL</th>
                    <th>Head Name</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>SL</th>
                    <th>Head Name</th>
                    <th>Action</th>
                </tr>
                </tfoot>
                <tbody>
                @foreach($budgetHeadData as $data)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td class="text-left">{{$data->name}}</td>
                        <td>
                            <div class="icon-btn">
                                <nobr>
                                    <a href="{{ url("boq/project/$project->id/departments/electrical/configurations/eme-budget-head/$data->id/edit") }}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                    {!! Form::open(array('url' => "boq/project/$project->id/departments/electrical/configurations/eme-budget-head/$data->id",'method' => 'delete', 'class'=>'d-inline','data-toggle'=>'tooltip','title'=>'Delete')) !!}
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

