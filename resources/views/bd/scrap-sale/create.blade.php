@extends('layouts.backend-layout')
@section('title', 'Scrap')

@section('breadcrumb-title')
    @if ($formType == 'edit')
        Edit Scrap Sale
    @else
        Add Scrap Sale
    @endif
@endsection

@section('breadcrumb-button')
    <a href="{{ route('scrapSale.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', null)

@section('content')
    @if ($formType == 'edit')
        {!! Form::open(['url' => "scrapSale/$scrapSale->id", 'method' => 'PUT', 'class' => 'custom-form']) !!}
    @else
        {!! Form::open(['url' => 'scrapSale', 'method' => 'POST', 'class' => 'custom-form']) !!}
    @endif
    <input type="hidden" name="scrapSale_id" value="{{ !empty($scrapSale->id) ? $scrapSale->id : null }}">
    <div class="row">
        <div class="col-md-3">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="reason">Gate Pass.<span class="text-danger">*</span></label>
                    {{ Form::text('gate_pass', old('gate_pass') ? old('gate_pass') : (!empty($scrapSale) ? $scrapSale->gate_pass : null), ['class' => 'form-control', 'id' => 'gate_pass', 'placeholder' => 'Gate Pass', 'required', 'autocomplete' => 'off']) }}
                
            </div>
        </div>
        <div class="col-md-3">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon">Scrap CS No<span class="text-danger">*</span></label>
                {{ Form::text('scrap_cs_no', old('scrap_cs_no') ? old('scrap_cs_no') : (!empty($scrapSale) ? $scrapSale->scrapCs->reference_no : null), ['class' => 'form-control','id' => 'scrap_cs_no', 'autocomplete' => 'off', 'required', 'placeholder' => 'Scrap CS No']) }}
                {{ Form::hidden('scrap_cs_id', old('scrap_cs_id') ? old('scrap_cs_id') : (!empty($scrapSale) ? $scrapSale->scrap_cs_id : null), ['class' => 'form-control','id' => 'scrap_cs_id', 'autocomplete' => 'off', 'required', 'placeholder' => 'Scrap CS id']) }}
            </div>
        </div>
        <div class="col-md-3">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="project_id">Project<span class="text-danger">*</span></label>
                {{ Form::text('project_name', old('project_name') ? old('project_name') : (!empty($scrapSale) ? $scrapSale->costCenter->name : null), ['class' => 'form-control', 'id' => 'project_name', 'autocomplete' => 'off', 'required','readonly','placeholder' => 'Project Name']) }}
                {{ Form::hidden('project_id', old('project_id') ? old('project_id') : (!empty($scrapSale) ? $scrapSale->costCenter->project_id : null), ['class' => 'form-control', 'id' => 'project_id', 'autocomplete' => 'off']) }}
                {{ Form::hidden('cost_center_id', old('cost_center_id') ? old('cost_center_id') : (!empty($scrapSale) ? $scrapSale->cost_center_id : null), ['class' => 'form-control', 'id' => 'cost_center_id', 'autocomplete' => 'off']) }}
            </div>
        </div>
        <div class="col-md-3">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="applied_date">Applied Date<span class="text-danger">*</span></label>
                {{ Form::text('applied_date', old('applied_date') ? old('applied_date') : (!empty($scrapSale) ? $scrapSale->applied_date : null), ['class' => 'form-control', 'id' => 'applied_date', 'autocomplete' => 'off', 'required', 'placeholder' => 'Applied Date', 'readonly']) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="note">SGS</label>
                {{ Form::text('sgs', old('sgs') ? old('sgs') : (!empty($scrapSale) ? $scrapSale->sgs : null), ['class' => 'form-control', 'autocomplete' => 'off', 'required', 'placeholder' => 'SGS']) }}
            </div>
        </div>

        <div class="col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="remarks">Supplier Name</label>
                {{ Form::text('supplier_name', old('supplier_name') ? old('supplier_name') : (!empty($scrapSale) ? $scrapSale->supplier->name : null), ['class' => 'form-control', 'autocomplete' => 'off', 'required', 'id'=>"supplier_name" ,'placeholder' => 'Supplier Name']) }}
                {{ Form::hidden('supplier_id', old('supplier_id') ? old('supplier_id') : (!empty($scrapSale) ? $scrapSale->supplier_id : null), ['class' => 'form-control', 'autocomplete' => 'off', 'required', 'placeholder' => 'Supplier id','id'=>"supplier_id"]) }}
            </div>
        </div>
    </div><!-- end row -->

    <hr class="bg-success">
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-sm text-center" id="itemTable">
            <thead>
                <tr>
                    <th>Material Name <span class="text-danger">*</span></th>
                    <th>Unit</th>
                    <th>Rate</th>
                    <th>Quantity</th>
                    <th>Total Amount</th>
                    <th>Remarks</th>
                    <th>
                        <button class="btn btn-success btn-sm addItem" type="button"><i class="fa fa-plus"></i></button>
                    </th>
                </tr>
            </thead>
            <tbody>

                @if (old('material_id'))
                    @foreach (old('material_id') as $key => $materialOldData)
                        <tr>
                            <td>
                                <input type="text" name="material_name[]" value="{{ old('material_name')[$key] }}"
                                    class="form-control text-center form-control-sm material_name">
                                <input type="hidden" name="material_id[]" value="{{ old('material_id')[$key] }}"
                                    class="form-control form-control-sm text-center material_id" required>
                            </td>
                            <td><input type="text" name="unit[]" value="{{ old('unit')[$key] }}"
                                    class="form-control text-center form-control-sm unit" readonly tabindex="-1"></td>
                            <td><input type="number" name="rate[]" value="{{ old('rate')[$key] }}"
                                    class="form-control text-center form-control-sm rate" tabindex="-1" readonly>
                            </td>
                            <td><input type="number" name="quantity[]"
                                    value="{{ old('quantity')[$key] }}"
                                    class="form-control text-center form-control-sm quantity" tabindex="-1"
                                    readonly></td>
                            <td><input type="number" name="total_amount[]" value="{{ old('total_amount')[$key] }}"
                                    class="form-control text-center form-control-sm total_amount" tabindex="-1" readonly>
                            </td>
                            <td><input type="number" name="remarks[]" value="{{ old('remarks')[$key] }}"
                                    class="form-control text-center form-control-sm remarks" tabindex="-1" readonly>
                            </td>
                            <td><button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i
                                        class="fa fa-minus"></i></button></td>
                        </tr>
                    @endforeach
                @else
                    @if (!empty($scrapSale))
                        @foreach ($scrapSale->scrapSaleDetail as $scrapSaledetail)
                            <tr>
                                <td>
                                    <input type="text" name="material_name[]"
                                        value="{{ $scrapSaledetail->nestedMaterial->name }}"
                                        class="form-control text-center form-control-sm material_name">
                                    <input type="hidden" name="material_id[]"
                                        value="{{ $scrapSaledetail->nestedMaterial->id }}"
                                        class="form-control form-control-sm text-center material_id" required>
                                </td>
                                <td><input type="text" name="unit[]"
                                        value="{{ $scrapSaledetail->nestedMaterial->unit->name }}"
                                        class="form-control text-center form-control-sm text-center unit" readonly
                                        tabindex="-1"></td>
                                <td><input type="number" name="rate[]" value="{{ $scrapSaledetail->rate }}"
                                        class="form-control text-center form-control-sm rate" tabindex="-1"
                                        readonly></td>
                                <td><input type="number" name="quantity[]"
                                        value="{{ $scrapSaledetail->quantity ?? 0 }}"
                                        class="form-control text-center form-control-sm quantity" tabindex="-1"
                                    ></td>
                                <td><input type="number" name="total_amount[]" value="{{ ($scrapSaledetail->rate * $scrapSaledetail->quantity) }}"
                                        class="form-control text-center form-control-sm total_amount" tabindex="-1"
                                        readonly></td>
                                <td><input type="text" name="remarks[]"
                                        value="{{ $scrapSaledetail->remarks }}"
                                        class="form-control text-center form-control-sm remarks" tabindex="-1"
                                        readonly></td>
                                <td><button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i
                                            class="fa fa-minus"></i></button></td>
                            </tr>
                        @endforeach
                    @endif
                @endif
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3">
                    </td>
                    <td>Total</td>
                    <td>
                        <input type="number" name="grand_total"
                            class="form-control text-center form-control-sm grand_total" id="grand_total" tabindex="-1" readonly value={{ (!empty($scrapSale) ? $scrapSale->grand_total : null) }}>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div> <!-- end table responsive -->
    <div class="row">
        <div class="offset-md-5 col-2">

            <button class="btn btn-success btn-round btn-block py-2">Submit</button>
        </div>
    </div>
   
    <!-- end row -->
    {!! Form::close() !!}
@endsection


@section('script')
    <script>
        function addRow() {
            let row = `
                <tr>
                    <td>
                        <input type="hidden" name="material_id[]" class="material_id" id="material_id">
                        <input type="text" name="material_name[]" class="form-control text-center form-control-sm material_name" autocomplete="off" required placeholder="Material Name">
                    </td>
                    <td><input type="text" name="unit[]" class="form-control form-control text-center form-control-sm unit" readonly tabindex="-1"></td>
                    <td><input type="number" name="rate[]" class="form-control text-center form-control-sm rate" tabindex="-1" readonly></td>
                    <td><input type="number" name="quantity[]" class="form-control text-center form-control-sm quantity" tabindex="-1"></td>
                    <td><input type="number" name="total_amount[]" class="form-control text-center form-control-sm total_amount" tabindex="-1" readonly></td>
                    <td><input type="text" name="remarks[]" value="" class="form-control text-center form-control-sm remarks" tabindex="-1"></td>
                    <td><button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i class="fa fa-minus"></i></button></td>
                </tr>
            `;
            $('#itemTable tbody').append(row);
        }

        const CSRF_TOKEN = "{{ csrf_token() }}";
        $(function() {
           

            @if ($formType == 'create' && !old('material_id'))
                addRow();
            @endif

            $("#itemTable").on('click', ".addItem", function() {
                addRow();

            }).on('click', '.deleteItem', function() {
                $(this).closest('tr').remove();
            });

            $('#date,#applied_date').datepicker({
                format: "dd-mm-yyyy",
                autoclose: true,
                todayHighlight: true,
                showOtherMonths: true
            });

            $(document).on('keyup', "#scrap_cs_no", function(){
                
                $(this).autocomplete({
                    source: function(request, response) {
                    $.ajax({
                        url: "{{ route('scrapCsAutoSuggest') }}",
                        type: 'GET',
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
                    $(this).val(ui.item.label);
                    $('#scrap_cs_id').val(ui.item.value);
                    $('#project_id').val(ui.item.project_id);
                    $('#cost_center_id').val(ui.item.cost_center_id);
                    $('#project_name').val(ui.item.project_name);

                    return false;
                    }
                });
            });
          

          

           
        });

        $(function() {
            $('#project_name').on('keyup',function(){
                $(this).autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ route('projectAutoSuggestForScrap') }}",
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
                    $('#cost_center_id').val(ui.item.value);
                    $('#project_id').val(ui.item.project_id);
                    $('#project_name').val(ui.item.label);
                    return false;
                }
            })
            })
        })

        $(function() {
            $('#supplier_name').on('keyup',function(){
                let scrap_cs_id = $('#scrap_cs_id').val();
                if(scrap_cs_id == null || scrap_cs_id == ''){
                    alert('please search scrap cs first');
                }
                $(this).autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ route('supplierAutoSuggestForScrap') }}",
                        type: 'post',
                        dataType: "json",
                        data: {
                            _token: CSRF_TOKEN,
                            search: request.term,
                            scrap_cs_id
                        },
                        success: function(data) {
                            response(data);
                        }
                    });
                },
                select: function(event, ui) {
                    $('#supplier_name').val(ui.item.label);
                    $('#supplier_id').val(ui.item.value);
                    return false;
                }
            })
            })
        })


     
            $(document).on('keyup','.material_name',function(){
                let scrap_cs_id = $('#scrap_cs_id').val();
                let supplier_id = $('#supplier_id').val();
                $(this).autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ route('materialAutoSuggestForScrap') }}",
                        type: 'post',
                        dataType: "json",
                        data: {
                            _token: CSRF_TOKEN,
                            search: request.term,
                            scrap_cs_id:scrap_cs_id,
                            supplier_id:supplier_id
                        },
                        success: function(data) {
                            response(data);
                        }
                    });
                },
                select: function(event, ui) {
                    $(this).val(ui.item.label);
                    $(this).closest('tr').find('.material_id').val(ui.item.value);
                    $(this).closest('tr').find('.unit').val(ui.item.unit);
                    $(this).closest('tr').find('.rate').val(ui.item.price);
                    return false;
                }
                })
            })

$(document).on('keyup change','.quantity', function(){
$(this).closest('tr').find('.total_amount').val($(this).closest('tr').find('.rate').val() * $(this).val());
GrandTotal();
})

function GrandTotal(){
    var total = 0;
    $('.total_amount').map(function(index,currentValue){
        total += Number(currentValue.value ?? 0);
    })
    $('#grand_total').val(total);
}
        $(document).ready(function() {
            @if (old('material_id'))
            @endif
        })
    </script>
@endsection
