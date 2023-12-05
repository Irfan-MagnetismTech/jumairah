@extends('layouts.backend-layout')
@section('title', 'Minimum Stock')

@section('breadcrumb-title')
    Search Minimum Stock Report
@endsection

{{--@section('breadcrumb-button')--}}
    {{--<a href="{{ url('banks') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>--}}
{{--@endsection--}}

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'offset-md-1 col-md-10 offset-lg-2 col-lg-8 my-3')

@section('content')

    {!! Form::open(array('url' => "inventoryReport/minimumStockPDF",'method' => 'POST', 'class'=>'custom-form')) !!}

        <div class="row">
            <div class="col-12">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="supplier_id">Categories<span class="text-danger">*</span></label>
                    {{Form::select('supplier_id', $categories, old('$materialcategories') ? old('supplier_id') : (!empty($employee->supplier_id) ? $employee->supplier_id : null),['class' => 'form-control','id' => 'supplier_id', 'placeholder'=>"Select Supplier", 'autocomplete'=>"off"])}}
                </div>
            </div>

        </div><!-- end row -->
        <div class="row">
            <div class="offset-md-4 col-md-4 mt-2">
                <div class="input-group input-group-sm ">
                    <button class="btn btn-success btn-round btn-block py-2">Submit</button>
                </div>
            </div>
        </div> <!-- end row -->
    {!! Form::close() !!}

@endsection
@section('script')

    <script>
        $('#date').datepicker({format: "dd-mm-yyyy",autoclose: true,todayHighlight: true,showOtherMonths: true});
    </script>
@endsection
