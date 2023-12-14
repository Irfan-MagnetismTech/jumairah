@extends('layouts.backend-layout')

@if ($formType == 'edit')
    @section('title', 'BOQ - Edit Utility Bill')
@else
    @section('title', 'BOQ - Create Utility Bill')
@endif
@section('breadcrumb-title')
@if ($formType == 'edit') Edit @else Create @endif Utility Bill
@endsection

@section('breadcrumb-button')
    @include('components.buttons.breadcrumb-button', ['route' => route('eme.utility_bill.index'), 'type' => 'index'])
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'col-12')

@section('content')
<style>
#calculation_table.table-bordered td, .table-bordered th{
    border: 1px solid gainsboro!important;
}
#calculation_table.table-styling .table-info, .table-styling.table-info{
    background-color: #f6f9f9!important;
    color: #191818!important;
    border: 3px solid #07995D!important;
}
#calculation_table.table-styling .table-info tfoot, .table-styling.table-info tfoot {
    background-color: #07995D;
    border: 3px solid #07995D;
}
#calculation_table.table-styling .table-info thead, .table-styling.table-info thead {
}
</style>
<div class="row">
    <div class="col-md-12">
        @if ($formType == 'edit')
        <form action="{{ route('eme.utility_bill.update',['utility_bill' => $utility_bill]) }}" method="POST" class="custom-form form-bg-default">
        @method('put')
        @else
        <form action="{{ route('eme.utility_bill.store') }}" method="POST" class="custom-form form-bg-default">
        @endif
        @csrf
        <div class="row pt-5">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <!-- Select work -->
                            <div class="col-md-4 col-xl-4">
                                <div class="input-group input-group-sm input-group-primary">
                                    <label class="input-group-addon" for="project_name">Project Name</label>
                                    {{Form::text('project_name',old('project_name') ? old('project_name') : (!empty($utility_bill) ? $utility_bill->project->name : null),['class' => 'form-control','id' => 'project_name', 'placeholder'=>"Search Project Name", 'autocomplete'=>"off"])}}
                                    {{Form::hidden('project_id', old('project_id') ? old('project_id') : (!empty($utility_bill) ? $utility_bill->project_id  : null),['class' => 'form-control','id' => 'project_id','autocomplete'=>"off"])}}
                                </div>
                            </div>
                            <div class="col-md-4 col-xl-4">
                                <div class="input-group input-group-sm input-group-primary">
                                    <label class="input-group-addon" for="client_name">Client Name</label>
                                    {{Form::text('client_name',old('client_name') ? old('client_name') : (!empty($utility_bill) ? $utility_bill->client->name : null),['class' => 'form-control','id' => 'client_name', 'placeholder'=>"Search Client Name", 'autocomplete'=>"off"])}}
                                    {{Form::hidden('client_id', old('client_id') ? old('client_id') : (!empty($utility_bill) ? $utility_bill->client_id : null),['class' => 'form-control','id' => 'client_id','autocomplete'=>"off"])}}
                                </div>
                            </div>
                            <div class="col-md-4 col-xl-4">
                                <div class="input-group input-group-sm input-group-primary">
                                    <label class="input-group-addon" for="apartment_id">Apartment ID</label>
                                    {{-- {{Form::text('parent_id',null,['class' => 'form-control','id' => 'parent_id0', 'placeholder'=>"Select 1st layer material Name", 'autocomplete'=>"off"])}} --}}
                                    {{Form::select('apartment_id', (!empty($apartment) ? $apartment : []), old('apartment_id') ? old('apartment_id') : (!empty($utility_bill) ? $utility_bill->apartment_id : null),['class' => 'form-control apartment_id','id' => 'apartment_id', 'placeholder'=>"Select Apartment Name", 'autocomplete'=>"off"])}}
                                </div>
                            </div>
                            <div class="col-md-4 col-xl-4">
                                <div class="input-group input-group-sm input-group-primary">
                                    <label class="input-group-addon" for="parent_id_second">Period</label>
                                    {{Form::text('period',old('period') ? old('period') : (!empty($utility_bill) ? $utility_bill->period : null),['class' => 'form-control','id' => 'period','autocomplete'=>"off"])}}
                                </div>
                            </div>
                            <!-- Select sub-work -->
                            <div class="col-xl-12 col-md-12">
                                <div id="subwork"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-1">
            </div>
        </div>

        <hr>
        <!-- Calculation -->
        <div class="mt-1 row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <div class="card">
                    <div class="tableHeading">
                        <h5> <span>&#10070;</span>Electricity<span>&#10070;</span><span class="work_unit"></span> </h5>
                    </div>
                    <div class="card-body">
                        <!-- Calculations -->
                        <div class="mt-1 row">
                            <div class="col-md-12">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr class="electrical_calc_head">
                                            <th> Previous Reading <span class="text-danger">*</span></th>
                                            <th class="material_rate_th">Present Reading <span class="text-danger">*</span></th>
                                            <th class="material_rate_th">Consumed Unit <span class="text-danger">*</span></th>
                                            <th class="labour_rate_th">Unit Rate</th>
                                            <th class="labour_rate_th">Electric Bill</th>
                                            <th style="width: 6%!important;"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <input type="number" name="previous_reading" value="{{ old('previous_reading') ? old('previous_reading') : (!empty($utility_bill) ? $utility_bill->previous_reading : null) }}" class="form-control text-center previous_reading" autocomplete="off" required id="previous_reading">
                                            </td>
                                            <td>
                                                <input type="number" name="present_reading" value="{{ old('present_reading') ? old('present_reading') : (!empty($utility_bill) ? $utility_bill->present_reading : null) }}" class="form-control present_reading" required id="present_reading">
                                            </td>
                                            <td>
                                                <input type="number" name="consumed_unit" value="{{ old('consumed_unit') ? old('consumed_unit') : (!empty($utility_bill) ? ($utility_bill->present_reading - $utility_bill->previous_reading): null) }}" class="form-control consumed_unit" id="consumed_unit" readonly>
                                            </td>
                                            <td>
                                                <input type="number" name="electricity_rate" value="{{ old('electricity_rate') ? old('electricity_rate') : (!empty($utility_bill) ? $utility_bill->electricity_rate : null) }}" class="form-control rate" id="rate">
                                            </td>
                                            <td>
                                                <input type="number" name="electric_amount" value="{{ old('electric_amount') ? old('electric_amount') : (!empty($utility_bill) ? (($utility_bill->present_reading - $utility_bill->previous_reading) * $utility_bill->electricity_rate): null) }}" class="form-control electric_amount" id="electric_amount" readonly>
                                                @php
                                                if(!empty($utility_bill)){
                                                    $electric_amount = (($utility_bill->present_reading - $utility_bill->previous_reading) * $utility_bill->electricity_rate);
                                                }
                                                @endphp
                                            </td>
                                        </tr>
                                        
                                        
                                        <tr>
                                            <td colspan='2' id='setter' class="text-right">
                                                <span class="text-dark font-weight-bold pr-2">Vat & Tax (%)</span>
                                            </td>
                                            <td id='setter1'>
                                                <input type="number" name="vat_tax_percent" value="{{ old('vat_tax_percent') ? old('vat_tax_percent') : (!empty($utility_bill) ? ($utility_bill->vat_tax_percent) : null) }}" class="form-control vat_tax_per percent"  id="vat_tax_per">
                                            </td>
                                            <td id='setter' class="text-right">
                                                <span class="text-dark font-weight-bold">Vat & Tax</span>
                                            </td>
                                            <td id='setter1'>
                                                <input type="number" name="vat_tax" value="{{ old('vat_tax') ? old('vat_tax') : (!empty($utility_bill) ? ($utility_bill->vat_tax_percent * $electric_amount / 100) : null) }}" class="form-control vat_tax amount" id="vat_tax">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan='2' id='setter' class="text-right">
                                                <span class="text-dark font-weight-bold">Demand Charge (%)</span>
                                            </td>
                                            <td id='setter1'>
                                                <input type="number" name="demand_charge_percent" value="{{ old('demand_charge_percent') ? old('demand_charge_percent') : (!empty($utility_bill) ? ($utility_bill->demand_charge_percent) : null) }}" class="form-control demand_charge_per percent" required  id="demand_charge_per">
                                            </td>
                                            <td id='setter' class="text-right">
                                                <span class="text-dark font-weight-bold">Demand Charge</span>
                                            </td>
                                            <td id='setter1'>
                                                <input type="number" name="demand_charge" value="{{ old('demand_charge') ? old('demand_charge') : (!empty($utility_bill) ? ($utility_bill->demand_charge_percent * $electric_amount / 100) : null) }}" class="form-control demand_charge amount" id="demand_charge">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan='2' id='setter' class="text-right">
                                                <span class="text-dark font-weight-bold">PFC Charge (%)</span>
                                            </td>
                                            <td id='setter1'>
                                                <input type="number" name="pfc_charge_percent" value="{{ old('pfc_charge_percent') ? old('pfc_charge_percent') : (!empty($utility_bill) ? ($utility_bill->pfc_charge_percent) : null) }}" class="form-control pfc_charge_per percent" required  id="pfc_charge_per">
                                            </td>
                                            <td id='setter' class="text-right">
                                                <span class="text-dark font-weight-bold">PFC Charge</span>
                                            </td>
                                            <td id='setter1'>
                                                <input type="number" name="pfc_charge" value="{{ old('pfc_charge') ? old('pfc_charge') : (!empty($utility_bill) ? ($utility_bill->pfc_charge_percent * $electric_amount / 100) : null) }}" class="form-control pfc_charge amount" id="pfc_charge">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan='2' id='setter' class="text-right">
                                                <span class="text-dark font-weight-bold">Delay Charge (%)</span>
                                            </td>
                                            <td id='setter1'>
                                                <input type="number" name="delay_charge_percent" value="{{ old('delay_charge_percent') ? old('delay_charge_percent') : (!empty($utility_bill) ? ($utility_bill->delay_charge_percent)  : null) }}" class="form-control delay_charge_per percent" required  id="delay_charge_per">
                                            </td>
                                            <td id='setter' class="text-right">
                                                <span class="text-dark font-weight-bold">Delay charge</span>
                                            </td>
                                            <td id='setter1'>
                                                <input type="number" name="delay_charge" value="{{ old('delay_charge') ? old('delay_charge') : (!empty($utility_bill) ? ($utility_bill->delay_charge_percent * $electric_amount / 100) : null) }}" class="form-control delay_charge amount" required id="delay_charge">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" class="text-right">
                                                <span class="text-dark font-weight-bold">Common Elec.</span>
                                            </td>
                                            <td>
                                                <input type="number" name="common_electric_amount" value="{{ old('present_reading') ? old('present_reading') : (!empty($utility_bill) ? $utility_bill->common_electric_amount : null) }}" class="form-control common_amount" required id="common_amount">
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" id='setter' class="text-right">
                                                <span class="text-dark font-weight-bold">Total Electric after vat,<br/> tax & other charge</span>
                                            </td>
                                            <td id='setter1'>
                                                <input type="number" name="total_electric_amount_aftervat" value="{{ old('total_electric_amount_aftervat') ? old('total_electric_amount_aftervat') : (!empty($utility_bill) ? ($utility_bill->total_electric_amount_aftervat) : null) }}" class="form-control total_electric_amount_after_vat" required  id="total_electric_amount_after_vat">
                                            </td>
                                            <td style="width: 6%!important;">
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="col-md-4 col-xl-4">
                                <div class="input-group input-group-sm input-group-primary">
                                    <label class="input-group-addon" for="meter_no">Meter No</label>
                                    {{Form::text('meter_no',old('meter_no') ? old('meter_no') : (!empty($utility_bill) ? $utility_bill->meter_no : null),['class' => 'form-control','id' => 'meter_no', 'placeholder'=>"Meter No", 'autocomplete'=>"off"])}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-1"></div>
        </div>

        <hr>
        <!-- Calculation -->
        <div class="mt-1 row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <div class="card">
                    <div class="tableHeading">
                        <h5> <span>&#10070;</span>Other<span>&#10070;</span><span class="work_unit"></span> </h5>
                    </div>
                    <div class="card-body">
                        <!-- Calculations -->
                        <div class="mt-1 row">
                            <div class="col-md-12">
                                <table class="table table-striped table-bordered table-styling table-info table-sm text-center" id="calculation_table">
                                    <thead>
                                        <tr class="electrical_calc_head">
                                            <th class="getter"> Item <span class="text-danger">*</span></th>
                                            <th class="getter1">Amount</th>
                                            <th style="width: 6%!important;"><i class="btn btn-primary btn-sm fa fa-plus add-calculation-row"></i></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($formType == 'edit')
                                            @foreach($utility_bill->eme_utility_bill_detail as $key => $value )
                                            <tr>
                                                <td>
                                                    <input type="text" name="other_cost_name[]" value="{{ $value->other_cost_name }}" class="form-control text-center form-control-sm other_cost_name" autocomplete="off" required tabindex="-1">
                                                </td>
                                                <td> <input type="number" name="other_cost_amount[]" value="{{ $value->other_cost_amount }}" class="form-control individual_amount"> </td>
                                                <td> <i class="btn btn-danger btn-sm fa fa-minus remove-calculation-row"></i> </td>
                                            </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                    <tfoot>
                                        <tr class="electrical_calc_head">
                                            <th class="getter"> Item <span class="text-danger">*</span></th>
                                            <th class="getter1">Amount</th>
                                            <th style="width: 6%!important;"><i class="btn btn-primary btn-sm fa fa-plus add-calculation-row"></i></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-1"></div>
        </div>

        <div class="mt-1 row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <div class="card">
                    <div class="card-body">
                        <!-- Calculations -->
                        <div class="mt-1 row">
                            <div class="col-md-12">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <td id='setter' class="text-right">
                                                <span class="text-dark font-weight-bold">Due Amount</span>
                                            </td>
                                            <td id='setter1'>
                                                <input type="number" name="due_amount" value="{{ old('present_reading') ? old('present_reading') : (!empty($utility_bill) ? ($utility_bill->due_amount) : null) }}" class="form-control due_amount" required  id="due_amount">
                                            </td>
                                            <td style="width: 6%!important;"></td>
                                        </tr>
                                         <tr>
                                            <td class='getter' class="text-right"><span class="text-dark font-weight-bold text-right">Total Bill.</span></td>
                                            <td class="getter1"><input type="number" name="total_bill" class="form-control grand_total" value="{{ old('total_bill') ? old('total_bill') : (!empty($utility_bill) ? $utility_bill->total_bill : null) }}" required id="grand_total"> </td>
                                            <td style="width: 6%!important;"></td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-1"></div>
        </div>
        <div class="row">
            <div class="my-4 offset-md-5 col-md-2">
                <div class="input-group input-group-sm input-group-button">
                    <button type="submit" class="py-2 btn btn-success btn-round btn-block" id="submit-button">{{ isset($utility_bill) ? 'Update' : 'Create' }}</button>
                </div>
            </div>
        </div>
        </form>
    </div>
</div>
@section('script')
    <script>

        const CSRF_TOKEN = "{{ csrf_token() }}";


        function appendCalculationRow(material_id,material_name) {
            let row = `
                <tr>
                    <td>
                        <input type="text" name="other_cost_name[]" class="form-control text-center form-control-sm other_cost_name" autocomplete="off" required" tabindex="-1">
                    </td>
                    <td> <input type="number" name="other_cost_amount[]" class="form-control individual_amount"> </td>
                    <td> <i class="btn btn-danger btn-sm fa fa-minus remove-calculation-row"></i> </td>
                </tr>
                `;
            $('#calculation_table tbody').append(row);
            cssStyle()
        }

        // function for searching third layer material
                $(document).on('keyup','.material_name',function(events){
                    let secondLayerMaterial = $("#parent_id_second").val();
                    $(this).autocomplete({
                        source: function(request, response) {
                            $.ajax({
                                url: "{{ route('scj.getLayer3Material') }}",
                                type: 'get',
                                dataType: "json",
                                data: {
                                    _token: CSRF_TOKEN,
                                    search: request.term,
                                    parent_material_id: secondLayerMaterial
                                },
                                success: function( data ) {
                                    response( data );
                                }
                            });
                        },
                        select: function(event, ui) {
                            $(this).closest('tr').find('.material_name').val(ui.item.label);
                            $(this).closest('tr').find('.material_id').val(ui.item.material_id);
                            return false;
                        }
                    });
                });
                $(function() {
                     $("#project_name").autocomplete({
                    source: function( request, response ) {
                        $.ajax({
                            url:"{{route('projectAutoSuggest')}}",
                            type: 'post',
                            dataType: "json",
                            data: {
                                _token: CSRF_TOKEN,
                                search: request.term
                            },
                            success: function( data ) {
                                response( data );
                            }
                        });
                    },
                    select: function (event, ui) {
                        $('#project_name').val(ui.item.label);
                        $('#project_id').val(ui.item.value);
                        return false;
                    }
                });
            });
                $(function() {
                    $('#client_name').on('keyup change',function(events){
                    let project_id = $('#project_id').val();
                    $(this).autocomplete({
                            source: function(request, response) {
                                $.ajax({
                                    url: "{{route('eme.utility_bill.clientAutoSuggest')}}",
                                    type: 'POST',
                                    dataType: "json",
                                    data: {
                                        _token: CSRF_TOKEN,
                                        search: request.term,
                                        project_id
                                    },
                                    success: function( data ) {
                                        response( data );
                                    }
                                });
                            },
                            select: function(event, ui) {
                                $(this).val(ui.item.label)
                                $('#client_id').val(ui.item.value);
                                let client_id = ui.item.value;
                                    $.ajax({
                                        url: "{{route('eme.utility_bill.getApartmentName')}}",
                                        type: 'post',
                                        data: {
                                            _token: CSRF_TOKEN,
                                             client_id,
                                             project_id
                                        },
                                        success: function(data){
                                            $('#apartment_id').html();
                                            $('#apartment_id').html(data);
                                            return false;
                                        }
                                    });
                                    return false;
                            }
                        });
                    });


                    $('#apartment_id').on('change',function(events){
                            let apartment_id = $(this).val();
                            let project_id = $('#project_id').val();
                                $.ajax({
                                    url: "{{route('eme.utility_bill.previousBillPeriod')}}",
                                    type: 'post',
                                    data: {
                                        _token: CSRF_TOKEN,
                                        apartment_id,
                                        project_id
                                    },
                                    success: function(data){
                                        $('#previous_reading').val(data.previous_reading);
                                        $split_data = data.period.split('-');
                                        if($split_data[0] == 12){
                                            var period = '01-'+ (parseFloat($split_data[1]) + 1);
                                        }else if($split_data[0] < 10){
                                            var period = ("0"+(parseFloat($split_data[0]) + 1)) + '-' + $split_data[1];
                                        }else{
                                            var period = (parseFloat($split_data[0]) + 1) + '-' + $split_data[1];

                                        }
                                        $('#period').val(period);
                                        return false;
                                    }
                                });
                            return false;
                    });

                    $('.percent').on('change keyup',function(){
                        let percent = $(this).val() ? $(this).val() : 0;
                        let total_electric = $('#total_electric_amount').val() ? $('#total_electric_amount').val() : 0;
                        let percent_taka = parseFloat(total_electric * percent / 100);
                        $(this).closest('tr').find('.amount').val(percent_taka);
                        calculation();
                    })

                })


        /* Adds and removes calculation row on click */
        $("#calculation_table")
            .on('click', '.add-calculation-row', () => appendCalculationRow())
            .on('click', '.remove-calculation-row', function() {
                $(this).closest('tr').remove();
            });

        /* The document function */
        @if ($formType == "create")
        $(function() {
            appendCalculationRow();
        });
        @endif
        function cssStyle(){
            let $setter = $("#setter");
                $(".getter").css("width", $setter.width()+"px");
            let $setter1 = $("#setter1");
                $(".getter1").css("width", $setter1.width()+"px");
            let $setter2 = $("#setter2");
                $(".getter2").css("width", $setter2.width()+"px");
        }
        $(document).ready(function() {
            cssStyle()
            $(document).on('click change',function(){
                cssStyle()
            })
        });
            // Date picker formatter
            $('#period').datepicker({
            format: "mm-yyyy",
            minViewMode: 1,
            autoclose: true,
        });
        $(document).on('change keyup','#previous_reading, #present_reading, #consumed_unit, #rate, #electric_amount, #common_amount,#vat_tax,#demand_charge,#pfc_charge,#delay_charge,#due_amount,.individual_amount',function(){
            calculation();
                    })
        function calculation(){
                        let previous_reading = $('#previous_reading').val() ? parseFloat($('#previous_reading').val()) : 0;
                        let present_reading = $('#present_reading').val() ? parseFloat($('#present_reading').val()) : 0;

                        let consumed_unit = present_reading - previous_reading;

                        let rate = $('#rate').val() ? parseFloat($('#rate').val()) : 0;

                        let electric_amount =((present_reading - previous_reading) * rate);

                        let common_amount = $('#common_amount').val() ? parseFloat($('#common_amount').val()) : 0;
                        let vat_tax_per = $('#vat_tax_per').val() ? parseFloat($('#vat_tax_per').val()) : 0;
                        let vat_tax = electric_amount * vat_tax_per / 100;
                        let demand_charge_per = $('#demand_charge_per').val() ? parseFloat($('#demand_charge_per').val()) : 0;
                        let demand_charge = electric_amount * demand_charge_per / 100;
                        let pfc_charge_per = $('#pfc_charge_per').val() ? parseFloat($('#pfc_charge_per').val()) : 0;
                        let pfc_charge = electric_amount * pfc_charge_per / 100;
                        let delay_charge_per = $('#delay_charge_per').val() ? parseFloat($('#delay_charge_per').val()) : 0;
                        let delay_charge =  electric_amount * delay_charge_per / 100;
                        let due_amount = $('#due_amount').val() ? parseFloat($('#due_amount').val()) : 0;
                        
                       
                        let total_electric_amount = electric_amount + common_amount;
                        let total_electric_amount_after_vat = total_electric_amount + vat_tax + demand_charge + pfc_charge + delay_charge;
                        $('#vat_tax').val(vat_tax);
                        $('#demand_charge').val(demand_charge);
                        $('#pfc_charge').val(pfc_charge);
                        $('#delay_charge').val(delay_charge);
                        $('#consumed_unit').val(consumed_unit);
                        $('#electric_amount').val(electric_amount);
                        $('#total_electric_amount').val(total_electric_amount);
                        $('#total_electric_amount_after_vat').val(total_electric_amount_after_vat);
                        var total_individual_amount = 0;
                        if($(".individual_amount").length > 0){
                            $(".individual_amount").each(function(i, row){
                                let amountTK = $(row).val() ? parseFloat($(row).val()) : 0;
                                total_individual_amount += parseFloat(amountTK);
                            })
                        }
                        $('#grand_total').val(total_electric_amount_after_vat + total_individual_amount + due_amount);
        }

          // document.ready   
         
    </script>

@endsection

@endsection
