@extends('layouts.backend-layout')
@section('title', 'Fixed Assets')

@section('breadcrumb-title')
    @if (!empty($fixedAsset))
        Edit Fixed Asset
    @else
        Add Fixed Asset
    @endif
@endsection

@section('breadcrumb-button')
    <a href="{{ route('fixed-assets.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', null)

@section('content')
    @if (!empty($fixedAsset))
        {!! Form::open(['url' => "accounts/fixed-assets/$fixedAsset->id", 'method' => 'PUT', 'class' => 'custom-form']) !!}
    @else
        {!! Form::open(['url' => 'accounts/fixed-assets', 'method' => 'POST', 'class' => 'custom-form']) !!}
    @endif
    <input type="hidden" name="fa_id" value="{{ !empty($fixedAsset->id) ? $fixedAsset->id : null }}">
    <div class="row">
        <div class="col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="received_date"> MRR No</label>
                {{ Form::text('mrr_no', old('mrr_no') ? old('mrr_no') : (!empty($fixedAsset->mrr_no) ? $fixedAsset->mrr_no : null), ['class' => 'form-control', 'id' => 'mrr_no', 'autocomplete' => 'off']) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="received_date"> Received Date</label>
                {{ Form::text('received_date', old('received_date') ? old('received_date') : (!empty($fixedAsset->received_date) ? $fixedAsset->received_date : null), ['class' => 'form-control', 'id' => 'received_date', 'autocomplete' => 'off']) }}
            </div>
        </div>

        <div class="col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="tag">Tag</label>
                {{ Form::text('tag', old('tag') ? old('tag') : (!empty($fixedAsset->tag) ? $fixedAsset->tag : null), ['class' => 'form-control', 'id' => 'tag', 'autocomplete' => 'off']) }}
            </div>
        </div>

        <div class="col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="cost_center_id">Cost Center </label>
                {{ Form::select('cost_center_id',$costCenters, old('cost_center_id') ? old('cost_center_id') : (!empty($fixedAsset->cost_center_id) ? $fixedAsset->cost_center_id : null), ['class' => 'form-control', 'id' => 'cost_center_id', 'placeholder' => 'Select Cost Center', 'autocomplete' => 'off']) }}
            </div>
        </div>

        <div class="col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="project_id"> Assets Category <span class="text-danger">*</span></label>
                {{Form::select('account_id',$assetCategories, old('account_id') ? old('account_id') : (!empty($fixedAsset) ? $fixedAsset->account_id : null),['class' => 'form-control','id' => 'account_id','placeholder' => 'Select Categories','autocomplete'=>"off"])}}
            </div>
        </div>
        <div class="col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="project_id"> Name <span class="text-danger">*</span></label>
                {{Form::select('name',[], old('name') ? old('name') : (!empty($fixedAsset) ? $fixedAsset->name : null),['class' => 'form-control','id' => 'name','autocomplete'=>"off"])}}
                {{Form::hidden('material_id', old('material_id') ? old('material_id') : (!empty($fixedAsset) ? $fixedAsset->material_id : null),['class' => 'form-control','id' => 'material_id','autocomplete'=>"off"])}}
            </div>
        </div>

        <div class="col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="department_id">department_id<span class="text-danger">*</span></label>
                {{ Form::select('department_id',$departments, old('department_id') ? old('department_id') : (!empty($fixedAsset) ? $fixedAsset->department_id : null), ['class' => 'form-control', 'id' => 'department_id', 'autocomplete' => 'off']) }}
            </div>
        </div>

        <div class="col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="bill_no">Bill No<span class="text-danger">*</span></label>
                {{ Form::text('bill_no', old('bill_no') ? old('bill_no') : (!empty($fixedAsset) ? $fixedAsset->bill_no : null), ['class' => 'form-control', 'id' => 'bill_no', 'autocomplete' => 'off']) }}
            </div>
        </div>

        <div class="col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="life_time"> Useful Life  </label>
                {{ Form::text('life_time', old('life_time') ? old('life_time') : (!empty($fixedAsset->life_time) ? $fixedAsset->life_time : null), ['class' => 'form-control', 'id' => 'life_time', 'autocomplete' => 'off']) }}
                <label class="input-group-addon" for="life_time"> Dep Rate (%) </label>
                {{ Form::number('percentage', old('percentage') ? old('percentage') : (!empty($fixedAsset->percentage) ? $fixedAsset->percentage : null), ['class' => 'form-control', 'id' => 'percentage', 'autocomplete' => 'off','readonly']) }}
            </div>
        </div>

        <div class="col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="life_time"> Location </label>
                {{ Form::text('location', old('location') ? old('location') : (!empty($fixedAsset->location) ? $fixedAsset->location : null), ['class' => 'form-control', 'id' => 'location', 'autocomplete' => 'off']) }}
            </div>
        </div>

        <div class="col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="life_time"> Put to Use </label>
                {{ Form::text('use_date', old('use_date') ? old('use_date') : (!empty($fixedAsset->use_date) ? $fixedAsset->use_date : null), ['class' => 'form-control', 'id' => 'use_date', 'autocomplete' => 'off']) }}
            </div>
        </div>

<!--        <div class="col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="price">Price</label>
                {{Form::text('price', old('price') ? old('price') : (!empty($fixedAsset->price) ? $fixedAsset->price : null),['class' => 'form-control text-right','id' => 'price','autocomplete'=>"off"])}}
            </div>
        </div>-->

        <div class="col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="brand">Supplier </label>
                {{Form::select('cr_account_id',$accounts, old('cr_account_id') ? old('cr_account_id') : (!empty($fixedAsset->cr_account_id) ? $fixedAsset->cr_account_id : null),['class' => 'form-control','id' => 'cr_account_id','placeholder' => 'Select Account','autocomplete'=>"off"])}}
            </div>
        </div>

        <div class="col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="project_id">Asset Type<span class="text-danger"></span></label>
                <input type="radio" id="yes" name="asset_type" style="height:20px; width:20px; margin-left: 30px; margin-top: 8px" value="Construction" {{ (!empty($salaryHead) && $salaryHead->is_allocate == 'Construction' ? 'checked' : "") }}>
                <label  style="margin-left: 5px; margin-top: 12px" for="yes">Construction</label><br>
                <input type="radio" id="no" name="asset_type" style="height:20px; width:20px; margin-left: 30px; margin-top: 8px" value="Head Office" {{ (!empty($salaryHead) && $salaryHead->is_allocate == 'Head Office' ? 'checked': "") }}>
                <label  style="margin-left: 5px; margin-top: 12px" for="no">Head Office</label><br>
            </div>
        </div>
        <div class="col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="brand">Brand</label>
                {{Form::text('brand', old('brand') ? old('brand') : (!empty($fixedAsset->brand) ? $fixedAsset->brand : null),['class' => 'form-control','id' => 'brand','autocomplete'=>"off"])}}
            </div>
        </div>

        <div class="col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="model"> Model <span class="text-danger">*</span></label>
                {{ Form::text('model', old('model') ? old('model') : (!empty($fixedAsset->model) ? $fixedAsset->model : null), ['class' => 'form-control model', 'id' => 'model', 'autocomplete' => 'off']) }}
            </div>
        </div>

        <div class="col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="serial"> Serial </label>
                {{ Form::text('serial', old('serial') ? old('serial') : (!empty($fixedAsset->serial) ? $fixedAsset->serial : null), ['class' => 'form-control serial', 'id' => 'serial', 'autocomplete' => 'off']) }}
            </div>
        </div>

    </div><!-- end row -->

    @php
        //dd(old('particular'));
        $particulars = old('particular', !empty($fixedAsset) ?  $fixedAsset->fixedAssetCosts->pluck('particular') : []);
        $amounts = old('amount', !empty($fixedAsset) ?  $fixedAsset->fixedAssetCosts->pluck('amount') : []);
    @endphp

    <div class="table-responsive">
        <table class="table table-striped table-bordered table-sm text-center" id="collectionTable">
            <thead>
                <tr>
                    <th>Particulars</th>
                    <th>Amount</th>
                    <th>
                        <button class="btn btn-success btn-sm addItem" type="button"><i class="fa fa-plus"></i></button>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($particulars as $key => $particular)
                    <tr>
                        <td>
                            <select name="particular[]" class="form-control  particular">
{{--                                <option> Select Particulars</option>--}}
                                @foreach ($particularHeads as $particularHead)
                                    <option value="{{ $particularHead }}" @if ($particularHead == $particular) selected @endif>
                                        {{ $particularHead }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input style="text-align: right" type="text" name="amount[]" value="{{number_format($amounts[$key], 2)}}" class="form-control form-control-sm amount" min="0" step="0.01" placeholder="0.00" required autocomplete="off">
                        </td>
                        <td><button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i class="fa fa-minus"></i></button></td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="1" class="text-right"> Total </td>
                    <td>
                        {{Form::text('total_amount', null,['class' => 'form-control form-control-sm text-right', 'id' => 'total_amount', 'tabindex'=>"-1", 'required','readonly'] )}}
                    </td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>

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
        var CSRF_TOKEN = "{{ csrf_token() }}";
        $(function() {
            @if(empty($fixedAsset) && !old('particular'))
                addRow();
            @endif
            totalOperation();

            $("#mrr_no").autocomplete({
                    source: function(request, response) {
                        $.ajax({
                            url: "{{ route('get-mrr-no') }}",
                            type: 'post',
                            dataType: "json",
                            data: {
                                _token: CSRF_TOKEN,
                                search: request.term
                            },
                            success: function(data) {
                                response(data);
                            }
                        });
                    },
                    select: function(event, ui) {
                        $('#mrr_no').val(ui.item.value);
                        $('#received_date').val(ui.item.date);
                        $('#cost_center_id').val(ui.item.cost_center);
                        $('#cr_account_id').val(ui.item.supplier_id);
                        $.each(ui.item.material, function(materialItems, materialItem){
                            let option = '<option value="'+materialItem.account_id+'" >'+materialItem.name+'</option>'
                            $('#name').append(option);
                            $('#material_id').val(materialItem.id);
                        });
                        return false;
                    }
                });

            $('#cheque_date, #use_date').datepicker({
                format: "dd-mm-yyyy",
                autoclose: true,
                todayHighlight: true,
                showOtherMonths: true
            });

            $("#life_time").on('keyup', function (){
               $("#percentage").val((100/$("#life_time").val()).toFixed(2));
            });

            function addRow() {
                let row = `
                    <tr>
                        <td>
                            {{ Form::select('particular[]', $particularHeads, 'Purchase Value', ['class' => 'form-control form-control-sm particular', 'placeholder' => 'Select Particular', 'autocomplete' => 'off', 'required']) }}
                        </td>
                        <td><input style="text-align: right" type="text" name="amount[]" class="form-control form-control-sm amount" min="0" step="0.01" placeholder="0.00" required autocomplete="off"></td>
                        <td><button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i class="fa fa-minus"></i></button></td>
                    </tr>
                `;
                $('#collectionTable tbody').append(row);
                totalOperation();
            }

            function totalOperation() {
                var total = 0;
                if ($(".amount").length > 0) {
                    $(".amount").each(function(i, row) {
                        var total_amountTK = Number($(row).val().replace(/,/g,''));
                        total += parseFloat(total_amountTK);
                    })
                }
                $("#total_amount").val(total.toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 }));
            }

            $(document).on('click', ".addItem", function(){
                addRow();
            });

            $(document).on('keyup', ".amount", function(){
                totalOperation();
            });
            $("#collectionTable").on('click', '.deleteItem', function(){
                $(this).closest('tr').remove();
                totalOperation();
            });

            $(document).on('keyup','.amount, #total_amount, #price ',function (){
                addComma(this)
            });

            function addComma (thisVal){
                $(thisVal).keyup(function(event) {
                    if(event.which >= 37 && event.which <= 40) return;
                    $(this).val(function(index, value) {
                        return value .replace(/[^0-9\.]/g, "") .replace(/\B(?=(\d{3})+(?!\d))/g, ",") ;
                    });
                });
            }
        });
    </script>
@endsection
