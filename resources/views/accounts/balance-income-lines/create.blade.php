@extends('layouts.backend-layout')
@section('title', 'Balance & Income Line')

@section('breadcrumb-title')
    @if(!empty($balanceAndIncomeLine) == 'edit')
        Edit Balance/Income Line
    @else
        Add New Balance/Income Line
    @endif
@endsection

@section('breadcrumb-button')
    <a href="{{ route('balance-and-income-lines.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'offset-md-1 col-md-10 offset-lg-2 col-lg-8 my-3')

@section('content')

    @if(!empty($balanceAndIncomeLine) == 'edit')
        {!! Form::open(array('url' => route('balance-and-income-lines.update', $balanceAndIncomeLine->id),'method' => 'PUT', 'class'=>'custom-form')) !!}
        <input type="hidden" name="id" value="{{old('id') ? old('id') : (!empty($balanceAndIncomeLine->id) ? $balanceAndIncomeLine->id : null)}}">
    @else
        {!! Form::open(array('url' => route('balance-and-income-lines.store'),'method' => 'POST', 'class'=>'custom-form')) !!}
    @endif
        <div class="row">
            <div class="col-12">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="line_text">Line Text<span class="text-danger">*</span></label>
                    {{Form::text('line_text', old('line_text') ? old('line_text') : (!empty($balanceAndIncomeLine->line_text) ? $balanceAndIncomeLine->line_text : null),['class' => 'form-control','id' => 'line_text', 'autocomplete'=>"off"])}}
                </div>
            </div>

            <div class="col-12">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="value_type">Value Type<span class="text-danger">*</span></label>
                    <div class="form-radio px-1 d-flex" style="width: 100%">
                        <div class="radio radiofill radio-warning radio-inline " style="width: 50%">
                            <label class="my-1 py-1">
                                <input type="radio" name="value_type" value="D" {{old('value_type') && old('value_type') == "D" ? "Checked" : (!empty($balanceAndIncomeLine) && $balanceAndIncomeLine->value_type == "D" ? "Checked" : null)}} required>
                                <i class="helper"></i> Debit
                            </label>
                        </div>
                        <div class="radio radiofill radio-danger radio-inline " style="width: 50%">
                            <label class="my-1 py-1">
                                <input type="radio" name="value_type" value="C" {{old('value_type') && old('value_type') == "C" ? "Checked" : (!empty($balanceAndIncomeLine) && $balanceAndIncomeLine->value_type == "C" ? "Checked" : null)}} required>
                                <i class="helper"></i> Credit
                            </label>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-12">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="line_type">Line Type<span class="text-danger">*</span></label>
                    {{Form::select('line_type', $line_types, old('line_type') ? old('line_type') : (!empty($balanceAndIncomeLine) ? $balanceAndIncomeLine->line_type : null),['class' => 'form-control','id' => 'line_type', 'autocomplete'=>"off"])}}
                </div>
            </div>

            <div class="col-12">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="parent_id">Parent Line<span class="text-danger">*</span></label>
                    {{Form::select('parent_id', $parent_lines, old('parent_id') ? old('parent_id') : (!empty($balanceAndIncomeLine) ? $balanceAndIncomeLine->parent_id : null),['class' => 'form-control select2','id' => 'parent_id', 'placeholder' => 'Select Parent', 'autocomplete'=>"off"])}}
                </div>
            </div>

<!--            <div class="col-12">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="visible_index">Visible Index<span class="text-danger">*</span></label>
                    {{Form::number('visible_index', old('visible_index') ? old('visible_index') : (!empty($balanceAndIncomeLine->visible_index) ? $balanceAndIncomeLine->visible_index : null),['class' => 'form-control','id' => 'visible_index', 'autocomplete'=>"off"])}}
                </div>
            </div>

            <div class="col-12">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="printed_no">Printed No<span class="text-danger">*</span></label>
                    {{Form::number('printed_no', old('printed_no') ? old('printed_no') : (!empty($balanceAndIncomeLine->printed_no) ? $balanceAndIncomeLine->printed_no : null),['class' => 'form-control','id' => 'printed_no', 'autocomplete'=>"off"])}}
                </div>
            </div>-->


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
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        var CSRF_TOKEN = "{{csrf_token()}}";
        $(function(){
            // $('#opening_date').datepicker({format: "dd-mm-yyyy",autoclose: true,todayHighlight: true,showOtherMonths: true});

        });//document.ready()
        $('.select2').select2();

    </script>
@endsection
