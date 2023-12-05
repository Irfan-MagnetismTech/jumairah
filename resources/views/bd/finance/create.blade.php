@extends('layouts.backend-layout')
@section('title', 'Feasibility Finance')

@section('breadcrumb-title')
@if ($formType == 'edit')
Edit Finance
@else
Add Finance
@endif
@endsection

@section('breadcrumb-button')
<a href="{{ url('finance') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
<span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', null)

@section('content')
@if ($formType == 'edit')
{!! Form::open(['url' => "finance/$finance->id", 'method' => 'PUT', 'class' => 'custom-form']) !!}
@else
{!! Form::open(['url' => 'finance', 'method' => 'POST', 'class' => 'custom-form']) !!}
@endif
<div class="row">
    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <label class="input-group-addon" for="reason">Location<span class="text-danger">*</span></label>
            {{ Form::select('location_id', $locations, old('location_id') ? old('location_id') : (!empty($finance->location_id) ? $finance->location_id : null), ['class' => 'form-control', 'id' => 'location_id', 'placeholder' => 'Select Location', 'autocomplete' => 'off']) }}
        </div>
    </div>
    <div class="col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <label class="input-group-addon" for="rate">Rate<span class="text-danger">*</span></label>
            {{ Form::text('rate', old('rate') ? old('rate') : (!empty($finance->rate) ? $finance->rate : null), ['class' => 'form-control', 'id' => 'rate', 'autocomplete' => 'off', 'required', 'placeholder' => 'Rate']) }}
        </div>
    </div>
    <div class="col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <label class="input-group-addon" for="rate">Inflow<span class="text-danger">*</span></label>
            {{ Form::text('inflow_amount', old('inflow_amount') ? old('inflow_amount') : (!empty($finance->inflow_amount) ? $finance->inflow_amount : null), ['class' => 'form-control', 'id' => 'inflow', 'autocomplete' => 'off', 'required','readonly','placeholder' => 'Rate']) }}
        </div>
    </div>
    <div class="col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <label class="input-group-addon" for="rate">Outflow<span class="text-danger">*</span></label>
            {{ Form::text('outflow_amount', old('outflow_amount') ? old('outflow_amount') : (!empty($finance->outflow_amount) ? $finance->outflow_amount : null), ['class' => 'form-control', 'id' => 'outflow', 'autocomplete' => 'off', 'required','readonly','placeholder' => 'Rate']) }}
        </div>
    </div>
</div><!-- end row -->

<hr class="bg-success">
<div class="table-responsive">
    <table class="table table-striped table-bordered table-sm text-center" id="itemTable">
        <thead>
            <tr>
                <th>Schedule No<span class="text-danger">*</span></th>
                <th>Month</th>
                <th>Cash Benefit Payment Plan</th>
                <th>Outflow Rate</th>
                <th>Inflow Rate</th>
                <th>Outflow</th>
                <th>Inflow</th>
                <th>Net</th>
                <th>Interest</th>
                <th>Cumulitive</th>
            </tr>
        </thead>
        <tbody>

            @if (old('schedule_no'))
                @foreach (old('schedule_no') as $key => $materialOldData)
                    <tr>
                        <td>
                            <input type="number" name="schedule_no[]" value="{{ old('schedule_no')[$key] }}" class="form-control text-center form-control-sm schedule_no" step="0.01" readonly>
                        </td>
                        <td><input type="text" name="month[]" value="{{ old('month')[$key] }}" class="form-control text-center form-control-sm month" readonly step="0.01"></td>
                        <td><input type="number" name="amount[]" value="{{ old('amount')[$key] }}" class="form-control text-center form-control-sm amount" autocomplete="off" step="0.01"></td>
                        <td><input type="number" value="{{ old('outflow_rate')[$key] }}" name="outflow_rate[]" class="form-control text-center form-control-sm outflow_rate" autocomplete="off" readonly step="0.01"></td>
                        <td><input type="number" value="{{ old('inflow_rate')[$key] }}" name="inflow_rate[]" class="form-control form-control-sm text-center inflow_rate" autocomplete="off" readonly step="0.01"></td>
                        <td><input type="number" name="outflow[]" value="{{ old('outflow')[$key] }}" class="form-control text-center form-control-sm outflow" readonly autocomplete="off" step="0.01"></td>
                        <td><input type="number" name="inflow[]" value="{{ old('inflow')[$key] }}" class="form-control form-control-sm text-center inflow" autocomplete="off" readonly step="0.01"></td>
                        <td><input type="number" name="net[]" value="{{ old('net')[$key] }}" class="form-control form-control-sm net" autocomplete="off" readonly step="0.01"></td>
                        <td><input type="number" name="interest[]" value="{{ old('interest')[$key] }}" class="form-control form-control-sm interest" autocomplete="off" readonly step="0.01"></td>
                        <td><input type="text" name="cumulitive[]" value="{{ old('cumulitive')[$key] }}" class="form-control form-control-sm cumulitive" autocomplete="off" readonly step="0.01"></td>
                    </tr>
                @endforeach
            @else
                @if (!empty($finance))
                    @foreach ($finance->financeDetails as $financeDetail)
                        <tr>
                            <td>
                                <input type="number" name="schedule_no[]" value="{{ $financeDetail->schedule_no }}" class="form-control form-control-sm text-center schedule_no" required readonly>
                            </td>
                            <td><input type="text" name="month[]" value="{{ $financeDetail->month }}" class="form-control text-center form-control-sm text-center month" readonly></td>
                            <td><input type="number" name="amount[]" value="{{ $financeDetail->amount }}" class="form-control text-center form-control-sm amount" step="0.01"></td>
                            <td><input type="number" name="outflow_rate[]" value="{{ $financeDetail->outflow_rate }}" class="form-control text-center form-control-sm outflow_rate" readonly step="0.01"></td>
                            <td><input type="number" name="inflow_rate[]" value="{{ $financeDetail->inflow_rate }}" class="form-control form-control-sm text-center inflow_rate" autocomplete="off" readonly step="0.01">
                            </td>
                            <td><input type="number" name="outflow[]" value="{{ $financeDetail->outflow }}" class="form-control text-center form-control-sm outflow" readonly step="0.01"></td>
                            <td><input type="number" name="inflow[]" value="{{ $financeDetail->inflow }}" class="form-control form-control-sm text-center inflow" autocomplete="off" readonly step="0.01">
                            </td>
                            <td><input type="text" name="net[]" value="{{ $financeDetail->net }}" class="form-control form-control-sm net" autocomplete="off" readonly step="0.01"></td>
                            <td><input type="text" name="interest[]" value="{{ $financeDetail->interest }}" class="form-control form-control-sm interest" autocomplete="off" readonly step="0.01"></td>
                            <td><input type="text" name="cumulitive[]" value="{{ $financeDetail->cumulitive }}" class="form-control form-control-sm cumulitive" autocomplete="off" readonly step="0.01"></td>
                        </tr>
                    @endforeach
                @endif
            @endif
        </tbody>
        <tfoot>
            <tr>
                <td colspan="8">
                </td>
                <td>
                    {{ Form::text('total_interest', old('total_interest') ? old('total_interest') : (!empty($finance->total_interest) ? $finance->total_interest : null), ['class' => 'form-control form-control-sm total_interest', 'id' => 'total_interest', 'autocomplete' => 'off', 'required', 'readonly', 'placeholder' => '0.00']) }}
                
                </td>
                <td></td>
            </tr>
        </tfoot>
    </table>
</div> <!-- end table responsive -->
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
    function addRow(month = 0, outflowrate = 0, inflowrate = 0, outflow = 0, inflow = 0, net = 0) {
        let row = `
                <tr>
                    <td>
                        <input type="number" name="schedule_no[]" value="${month+1}" class="form-control text-center form-control-sm schedule_no" autocomplete="off" readonly>
                    </td>
                    <td><input type="text" name="month[]" value="${month+1}" class="form-control form-control text-center form-control-sm month" readonly></td>
                    <td><input type="number" name="amount[]" class="form-control text-center form-control-sm amount" step="0.01"></td>
                    <td><input type="number" value="${outflowrate}" name="outflow_rate[]" class="form-control text-center form-control-sm outflow_rate" readonly step="0.01"></td>
                    <td><input type="number" value="${inflowrate}" name="inflow_rate[]" class="form-control form-control-sm text-center inflow_rate" autocomplete="off" readonly step="0.01"></td>
                    <td><input type="number" value="${outflow}" name="outflow[]" class="form-control text-center form-control-sm outflow" readonly step="0.01"></td>
                    <td><input type="number" value="${inflow}" name="inflow[]" class="form-control form-control-sm text-center inflow" autocomplete="off" readonly step="0.01"></td>
                    <td><input type="number" name="net[]" value="${net}" class="form-control form-control-sm net" autocomplete="off" readonly step="0.01"></td>
                    <td><input type="text" name="interest[]" class="form-control form-control-sm interest" autocomplete="off" readonly step="0.01"></td>
                    <td><input type="text" name="cumulitive[]" class="form-control form-control-sm cumulitive" autocomplete="off" readonly step="0.01"></td>
                </tr>
            `;
        $('#itemTable tbody').append(row);
        // calculateCashOutFlow(this);
    }

    //         function calculateCashOutFlow(thisVal) {
    //             let amount = $(thisVal).closest('tr').find('.amount').val() > 0 ? parseFloat($(thisVal).closest('tr').find('.amount').val()) : 0;
    //             let cash_outflow = $(thisVal).closest('tr').find('.cash_outflow').val() > 0 ? Number(parseFloat($(thisVal).closest('tr').find('.cash_outflow').val())) : 0;
    //             let total_cost_before_financial_cost = Number($('#total_cost_before_financial_cost').text());
    //             let total_payment_for_land = Number($('#total_payment_for_land').text());
    //             let cash_outflow_data = total_cost_before_financial_cost - total_payment_for_land;
    // // console.log(total_cost_before_financial_cost);


    //             // if(amount>0 || cash_outflow>0){

    //             if(cash_outflow>0){
    //                 var outflow_rate = ((cash_outflow_data * cash_outflow / 100) / 3) + amount;
    //                 console.log(cash_outflow_data,cash_outflow,amount);
    //             }else{
    //                 var outflow_rate = amount;
    //             }

    //                 $(thisVal).closest('tr').find('.outflow_rate').val(outflow_rate);
    //             // }else{
    //                 // $(thisVal).closest('tr').find('.outflow_rate').val(0);
    //             // }
    //         }

    // $(document).on('keyup change', '.amount, .cash_outflow', function() {
    //     calculateCashOutFlow(this);
    // });

    var CSRF_TOKEN = "{{ csrf_token() }}";

    $("#location_id").on('change', function() {
        let rt = $('#rate').val();
        $('#inflow').val('');
        $('#outflow').val('');
        $('#itemTable tbody').empty();
        if (rt == '' || rt == null || rt == 0) {
            alert('Please Type Rate');
            return false;
        }
        $.ajax({
            url: "{{ route('scj.getTotalCostwithoutInterest') }}",
            type: 'get',
            dataType: "json",
            data: {
                _token: CSRF_TOKEN,
                location_id: $("#location_id").val(),
            },
            success: function(data) {
                console.log(data);
                if (data.inflow) {
                    $('#inflow').val(data.inflow);
                }
                if (data.outflow) {
                    $('#outflow').val(data.outflow);
                }
                let total_loop = (Number(Math.ceil(data.construction_life)) + 1) * 12;
                let rate = data.rnc.bd_feas_rnc_cal_rate;
                let cost = data.rnc.bd_feas_rnc_cal_cost;
                let rate_array = [rate.row_1st, rate.row_2nd, rate.row_3rd, rate.row_4th, rate
                    .row_5th, rate.row_6th, rate.row_7th, rate.row_8th, rate.row_9th, rate
                    .row_10th
                ]
                let cost_array = [cost.row_1st, cost.row_2nd, cost.row_3rd, cost.row_4th, cost
                    .row_5th, cost.row_6th, cost.row_7th, cost.row_8th, cost.row_9th, cost
                    .row_10th
                ]
                /**/
                $('#itemTable tbody').empty();
                for (let i = 0; i < total_loop; i++) {
                    let yr = Math.floor((i) / 12);
                    let inflow = data.inflow * rate_array[yr] / 100 / 12;
                    let outflow = data.outflow * cost_array[yr] / 100 / 12;
                    let outflowrate = cost_array[yr] / 4;
                    let inflowrate = rate_array[yr] / 4;
                    let net = inflow.toFixed(2) - outflow.toFixed(2);
                    addRow(i, outflowrate, inflowrate, outflow.toFixed(2), inflow.toFixed(2), net)
                }
                calculateCumulitive();
                TotalInterest();
                return false;
            }
        });
    });

    //  function for getting subStructure total
    // function getSubStructureTotal() {


    // }


    $(function() {
        @if($formType == 'create' && !old('material_id'))
        addRow();
        @endif

        $("#itemTable").on('click', ".addItem", function() {
            addRow();
        }).on('click', '.deleteItem', function() {
            $(this).closest('tr').remove();
        });

        // $(document).on('mouseenter', '.month', function() {
        //     $(this).datepicker({
        //         format: "dd-mm-yyyy",
        //         autoclose: true,
        //         todayHighlight: true,
        //         showOtherMonths: true
        //     });
        // });
        // function addComma (thisVal){
        //         $(thisVal).keyup(function(event) {
        //             if(event.which >= 37 && event.which <= 40) return;
        //             $(this).val(function(index, value) {
        //                 return value .replace(/[^0-9\.]/g, "") .replace(/\B(?=(\d{3})+(?!\d))/g, ",") ;
        //             });
        //         });
        //     }

        $(document).on('change', '.amount', function() {
            let cash_payment = Number($(this).val());
            let outflow = Number($('#outflow').val());
            let rate = $(this).closest('tr').find('.outflow_rate').val();
            let row_inflow = $(this).closest('tr').find('.inflow').val();
            let row_outflow = (outflow * Number(rate) / 100 / 3) + cash_payment;
            $(this).closest('tr').find('.outflow').val(row_outflow.toFixed(2));
            $(this).closest('tr').find('.net').val(Number(row_inflow).toFixed(2) - row_outflow.toFixed(2));
            calculateCumulitive();
            TotalInterest();
        });

    });

    function calculateCumulitive() {
        var cumulitive = 0;
        $('.cumulitive').each(function(row) {
            let net_amount = $(this).closest('tr').find('.net').val() ?? 0;
            cumulitive += Number(net_amount);
            var rowIndex = $(this).closest('tr').prop('rowIndex');
            var rate = $('#rate').val();
            var cum = $('.cumulitive');
            var Int = $('.interest');
            var interest = 0;
            if (rowIndex > 1) {
                if ((Number(net_amount) / 2 + Number(cum[rowIndex - 2].value)) < 0) {
                    interest = (-1 * (Number(net_amount) / 2 + Number(cum[rowIndex - 2].value))) * rate / 12 / 100;
                }
            } else {
                if (net_amount < 0) {
                    interest = ((-1 * Number(net_amount)) / 2 * rate / 12 / 100);
                }
            }
            $(this).closest('tr').find('.interest').val(interest.toFixed(2));
            if (!(rowIndex % 3)) {
                cumulitive -= (Number(Int[rowIndex - 2].value) + Number(Int[rowIndex - 3].value) + interest);

            }
            $(this).val(cumulitive.toFixed(2));

        })
    }

    function TotalInterest() {
        var interest = 0;
        $('.interest').each(function(row) {
            let int = $(this).val() ?? 0;
            interest += Number(int);
        })
        $('#total_interest').val(interest.toFixed(2));
    }


        $(function() { 
            document.addEventListener("keydown", function(event) {
                if (event.key === "Enter") {
                    event.preventDefault();
                }
            });
            
        }) // Document.Ready
    </script>
    
@endsection
