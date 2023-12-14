@extends('layouts.backend-layout')
@section('title', 'Available Stock')

@section('breadcrumb-title')
    Search Available Stock Report
@endsection

{{--@section('breadcrumb-button')--}}
{{--<a href="{{ url('banks') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>--}}
{{--@endsection--}}

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection


@section('content')

    {!! Form::open(array('url' => "availableStockSearch",'method' => 'get', 'class'=>'custom-form', 'id'=>'available')) !!}
    <div class="row">

        <div class="col-12 col-lg-8">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="warehouse_id">Type <span class="text-danger">*</span></label>
                {{Form::select('category', $categories, old('category') ? old('category') : (!empty($stockout->category) ? $stockout->category : null),['class' => 'form-control','id' => 'reason', 'placeholder'=>"Select ", 'autocomplete'=>"off"])}}
            </div>
        </div>
        <div class="col-12 col-lg-3">
            <button type="button" id="" class="btn  btn-out-dashed btn-sm btn-success" onclick="formsubmit('search')">Search</button>
            <button type="button" id="" class="btn  btn-sm btn-info " onclick="formsubmit('excel')"><i class="fa fa-file-excel fa-2x" ></i></button>
            <button type="button" id="" class="btn  btn-sm btn-info " onclick="formsubmit('pdf')"><i class="fa fa-file-pdf fa-2x" ></i></button>
            <form action="" method=""></form>
        </div>

    </div>
    {!! Form::close() !!}
    <hr>
    <!-- put search form here.. -->
    <div class="table-responsive">
        <table id="" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>SL</th>
                <th>Item</th>
                <th>Quantity</th>
                <th>Minimum Level</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>SL</th>
                <th>Item</th>
                <th>Quantity</th>
                <th>Minimum Level</th>
            </tr>
            </tfoot>
            <tbody>
            @foreach($datas as $key => $data)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$data->rawMaterial->name}}</td>
                    <td>{{$data->quantity}}</td>
                    <td>{{$data->rawMaterial->min_quantity}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>

    {{--<div class="float-right">--}}
        {{--{{ $stockouts->links() }}--}}
    {{--</div>--}}

@endsection
@section('script')

    <script>

        function formsubmit(val){
            if (val == 'search'){
                $('#available').attr('action', 'availableStockSearch');
                $("#available").submit();
            }else if (val == 'excel'){
                $('#available').attr('action', 'availableStockExcel');
                $("#available").submit()
            }else {
                $('#available').attr('action', 'currentStockPDF');
                $("#available").submit()
            }
        }
        $('#date').datepicker({format: "dd-mm-yyyy",autoclose: true,todayHighlight: true,showOtherMonths: true});
    </script>
@endsection
