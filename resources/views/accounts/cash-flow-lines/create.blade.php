@extends('layouts.backend-layout')
@section('title', 'Cash Flow Lines')

@section('breadcrumb-title')
    @if(!empty($cashFlowLine) == 'edit')
        Edit Cash Flow Lines
    @else
        Add New Cash Flow Lines
    @endif
@endsection

@section('breadcrumb-button')
    <a href="{{ route('cash-flow-lines.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'offset-md-1 col-md-10 offset-lg-2 col-lg-8 my-3')

@section('content')

    @if(!empty($cashFlowLine) == 'edit')
        {!! Form::open(array('url' => route('cash-flow-lines.update', $cashFlowLine->id),'method' => 'PUT', 'class'=>'custom-form')) !!}
        <input type="hidden" name="id" value="{{old('id') ? old('id') : (!empty($cashFlowLine->id) ? $cashFlowLine->id : null)}}">
    @else
        {!! Form::open(array('url' => route('cash-flow-lines.store'),'method' => 'POST', 'class'=>'custom-form')) !!}
    @endif
        <div class="row">
            <div class="col-12">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="line_type">Line Type<span class="text-danger">*</span></label>
                    {{Form::select('line_type', $line_types, old('line_type') ? old('line_type') : (!empty($cashFlowLine) ? $cashFlowLine->line_type : null),['class' => 'form-control','id' => 'line_type', 'autocomplete'=>"off"])}}
                </div>
            </div>

            <div class="col-12">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="is_net_income">Net Income<span class="text-danger">*</span></label>
                    <div class="form-radio px-1 d-flex" style="width: 100%">
                        <div class="radio radiofill radio-warning radio-inline " style="width: 50%">
                            <label class="my-1 py-1">
                                <input type="radio" name="is_net_income" value="1" {{old('is_net_income') && old('is_net_income') == 1 ? "Checked" : (!empty($cashFlowLine) && $cashFlowLine->is_net_income == 1 ? "Checked" : null)}} required>
                                <i class="helper"></i> Yes
                            </label>
                        </div>
                        <div class="radio radiofill radio-danger radio-inline " style="width: 50%">
                            <label class="my-1 py-1">
                                <input type="radio" name="is_net_income" value="0" {{old('is_net_income') && old('is_net_income') == 0 ? "Checked" : (!empty($cashFlowLine) && $cashFlowLine->is_net_income == 0 ? "Checked" : null)}} required>
                                <i class="helper"></i> No
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="line_text">Line Text<span class="text-danger">*</span></label>
                    {{Form::text('line_text', old('line_text') ? old('line_text') : (!empty($cashFlowLine->line_text) ? $cashFlowLine->line_text : null),['class' => 'form-control','id' => 'line_text', 'autocomplete'=>"off"])}}
                </div>
            </div>

            <div class="col-12">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="value_type">Value Type<span class="text-danger">*</span></label>
                    <div class="form-radio px-1 d-flex" style="width: 100%">
                        <div class="radio radiofill radio-warning radio-inline " style="width: 50%">
                            <label class="my-1 py-1">
                                <input type="radio" name="value_type" value="D" {{old('value_type') && old('value_type') == "D" ? "Checked" : (!empty($cashFlowLine) && $cashFlowLine->value_type == "D" ? "Checked" : null)}} >
                                <i class="helper"></i> Debit
                            </label>
                        </div>
                        <div class="radio radiofill radio-danger radio-inline " style="width: 50%">
                            <label class="my-1 py-1">
                                <input type="radio" name="value_type" value="C" {{old('value_type') && old('value_type') == "C" ? "Checked" : (!empty($cashFlowLine) && $cashFlowLine->value_type == "C" ? "Checked" : null)}} >
                                <i class="helper"></i> Credit
                            </label>
                        </div>
                    </div>
                </div>
            </div>

{{--            <div class="col-12">--}}
{{--                <div class="input-group input-group-sm input-group-primary">--}}
{{--                    <label class="input-group-addon" for="balance_type">Line Type<span class="text-danger">*</span></label>--}}
{{--                    {{Form::select('balance_type', $balanceTypes, old('balance_type') ? old('balance_type') : (!empty($cashFlowLine) ? $cashFlowLine->balance_type : null),['class' => 'form-control','id' => 'balance_type', 'autocomplete'=>"off"])}}--}}
{{--                </div>--}}
{{--            </div>--}}

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
        var CSRF_TOKEN = "{{csrf_token()}}";
        $(function(){
            // $('#opening_date').datepicker({format: "dd-mm-yyyy",autoclose: true,todayHighlight: true,showOtherMonths: true});

        });//document.ready()

    </script>
@endsection
