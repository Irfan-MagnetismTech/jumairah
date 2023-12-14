@extends('layouts.backend-layout')
@section('title', 'Feasibility Finance')

@section('breadcrumb-title')
    @if($formType == 'edit')
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
    @if($formType == 'edit')
        {!! Form::open(array('url' => "finance/$finance->id",'method' => 'PUT', 'class'=>'custom-form')) !!}
    @else
        {!! Form::open(array('url' => "finance",'method' => 'POST', 'class'=>'custom-form')) !!}
    @endif

        <input type="hidden" name="total_cost_before_financial_cost" value="" id="total_cost_before_financial_cost">
        <input type="hidden" name="total_payment_for_land" value="" id="total_payment_for_land">
        <input type="hidden" name="registration_cost" value="" id="registration_cost">
        <input type="hidden" name="land_size" value="" id="land_size">
        <input type="hidden" name="total_bonus_saleable_area" value="" id="total_bonus_saleable_area">
        <input type="hidden" name="semi_basement_floor_area" value="" id="semi_basement_floor_area">
        <input type="hidden" name="salary_and_overhead" value="" id="salary_and_overhead">
        <input type="hidden" name="construction_life_cycle" value="" id="construction_life_cycle">
        <input type="hidden" name="floor_area_far_free" value="" id="floor_area_far_free">
        <input type="hidden" name="developers_ratio" value="" id="developers_ratio">
        <input type="hidden" name="proposed_mgc" value="" id="proposed_mgc">
        <input type="hidden" name="ground_floor_area" value="" id="ground_floor_area">
        

        <div class="row">
            <div class="col-xl-3 col-md-3">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="reason">Location<span class="text-danger">*</span></label>
                    {{Form::select('location_id', $locations, old('location_id') ? old('location_id') : (!empty($finance->location_id) ? $finance->location_id : null),['class' => 'form-control','id' => 'location_id', 'placeholder'=>"Select Location", 'autocomplete'=>"off"])}}
                </div>
            </div>
            <div class="col-md-3">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="rate">Rate<span class="text-danger">*</span></label>
                    {{Form::text('rate', old('rate') ? old('rate') : (!empty($finance->rate) ? $finance->rate : null),['class' => 'form-control','id' => 'rate','autocomplete'=>"off","required", 'placeholder' => 'Rate'])}}
                </div>
            </div>
            <div class="col-md-3">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="rate">Rate<span class="text-danger">*</span></label>
                    <input type="text" name="total_buildup_area_as_far" value="" id="total_buildup_area_as_far">
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
                <th>Cash Outflow</th>
                <th>Sales Revenue Inflow</th>
                <th>Outflow Rate</th>
                <th>Inflow Rate</th>
                <th>Net</th>
                <th>Interest</th>
                <th>
                    <button class="btn btn-success btn-sm addItem" type="button"><i class="fa fa-plus"></i></button>
                </th>
            </tr>
            </thead>
            <tbody>

            @if(old('schedule_no'))
                @foreach(old('schedule_no') as $key => $materialOldData)
                    <tr>
                        <td>
                            <input type="text" name="schedule_no[]"   value="{{old('schedule_no')[$key]}}" class="form-control text-center form-control-sm schedule_no">
                        </td>
                        <td><input type="text" name="month[]"  value="{{old('month')[$key]}}" class="form-control text-center form-control-sm month" readonly ></td>
                        <td><input type="number" name="amount[]" value="{{old('amount')[$key]}}" class="form-control text-center form-control-sm amount"></td>
                        <td><input type="number" name="cash_outflow[]" value="{{old('cash_outflow')[$key]}}"  class="form-control text-center form-control-sm cash_outflow" ></td>
                        <td><input type="number" name="sales_revenue_inflow[]" value="{{old('sales_revenue_inflow')[$key]}}"  class="form-control text-center form-control-sm sales_revenue_inflow" ></td>
                        <td><input type="number" name="outflow_rate[]" value="{{old('outflow_rate')[$key]}}" class="form-control text-center form-control-sm outflow_rate" readonly></td>
                        <td><input type="number" name="inflow_rate[]" value="{{old('inflow_rate')[$key]}}" class="form-control form-control-sm text-center inflow_rate" autocomplete="off"></td>
                        <td><input type="number" name="net[]" value="{{old('net')[$key]}}"  class="form-control form-control-sm net" autocomplete="off"></td>
                        <td><input type="number" name="interest[]" value="{{old('interest')[$key]}}"  class="form-control form-control-sm interest" autocomplete="off"></td>
                        <td><button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i class="fa fa-minus"></i></button></td>
                    </tr>
                @endforeach
            @else
                @if(!empty($finance))
                    @foreach($finance->financeDetails as $financeDetail)
                        <tr>
                            <td>
                               <input type="number" name="schedule_no[]" value="{{$financeDetail->schedule_no}}" class="form-control form-control-sm text-center schedule_no" required >
                            </td>
                            <td><input type="text" name="month[]"  value="{{$financeDetail->month}}" class="form-control text-center form-control-sm text-center month"></td>
                            <td><input type="number" name="amount[]" value="{{$financeDetail->amount}}" class="form-control text-center form-control-sm amount"></td>
                            <td><input type="number" name="cash_outflow[]" value="{{$financeDetail->cash_outflow}}"  class="form-control text-center form-control-sm cash_outflow"></td>
                            <td><input type="number" name="sales_revenue_inflow[]" value="{{$financeDetail->sales_revenue_inflow}}"  class="form-control text-center form-control-sm sales_revenue_inflow"></td>
                            <td><input type="number" name="outflow_rate[]" value="{{$financeDetail->outflow_rate}}" class="form-control text-center form-control-sm outflow_rate" readonly></td>
                            <td><input type="number" name="inflow_rate[]" value="{{ $financeDetail->inflow_rate }}" class="form-control form-control-sm text-center inflow_rate" autocomplete="off"></td>
                            <td><input type="text" name="net[]" value="{{$financeDetail->net}}"  class="form-control form-control-sm net" autocomplete="off"></td>
                            <td><input type="text" name="interest[]" value="{{$financeDetail->interest}}"  class="form-control form-control-sm interest" autocomplete="off"></td>
                            <td><button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i class="fa fa-minus"></i></button></td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="8"></td>
                        <td><input type="text" class="form-control" value="{{$finance->financeDetails->sum('interest')}}"></td>
                    </tr>
                @endif
            @endif
            </tbody>
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

        function addRow(outflowrate=0,inflowrate=0){
            let row = `
                <tr>
                    <td>
                        <input type="number" name="schedule_no[]" class="form-control text-center form-control-sm schedule_no" autocomplete="off">
                    </td>
                    <td><input type="text" name="month[]" class="form-control form-control text-center form-control-sm month" readonly></td>
                    <td><input type="number" name="amount[]" class="form-control text-center form-control-sm amount"></td>
                    <td><input type="number" name="cash_outflow[]" class="form-control text-center form-control-sm cash_outflow"></td>
                    <td><input type="number" name="sales_revenue_inflow[]" class="form-control text-center form-control-sm sales_revenue_inflow"></td>
                    <td><input type="number" value="${outflowrate}" name="outflow_rate[]" class="form-control text-center form-control-sm outflow_rate" readonly></td>
                    <td><input type="number" value="${inflowrate}" name="inflow_rate[]" class="form-control form-control-sm text-center inflow_rate" autocomplete="off" ></td>
                    <td><input type="number" name="net[]" class="form-control form-control-sm net" autocomplete="off" ></td>
                    <td><input type="number" name="interest[]" class="form-control form-control-sm interest" autocomplete="off" ></td>
                    <td><button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i class="fa fa-minus"></i></button></td>
                </tr>
            `;
            $('#itemTable tbody').append(row);
            calculateCashOutFlow(this);
        }

        function calculateCashOutFlow(thisVal) {
            let amount = $(thisVal).closest('tr').find('.amount').val() > 0 ? parseFloat($(thisVal).closest('tr').find('.amount').val()) : 0;
            let cash_outflow = $(thisVal).closest('tr').find('.cash_outflow').val() > 0 ? Number(parseFloat($(thisVal).closest('tr').find('.cash_outflow').val())) : 0;
            let total_cost_before_financial_cost = Number($('#total_cost_before_financial_cost').text());
            let total_payment_for_land = Number($('#total_payment_for_land').text());
            let cash_outflow_data = total_cost_before_financial_cost - total_payment_for_land;
// console.log(total_cost_before_financial_cost);


            // if(amount>0 || cash_outflow>0){

            if(cash_outflow>0){
                var outflow_rate = ((cash_outflow_data * cash_outflow / 100) / 3) + amount;
                console.log(cash_outflow_data,cash_outflow,amount);
            }else{
                var outflow_rate = amount;
            }

                $(thisVal).closest('tr').find('.outflow_rate').val(outflow_rate);
            // }else{
                // $(thisVal).closest('tr').find('.outflow_rate').val(0);
            // }
        }

        $(document).on('keyup change', '.amount, .cash_outflow', function() {
            calculateCashOutFlow(this);
        });

        var CSRF_TOKEN = "{{ csrf_token() }}";

        $("#location_id").on('change', function() {
            $.ajax({
                url: "{{ route('scj.getFeasibilityEntryData') }}",
                type: 'post',
                dataType: "json",
                data: {
                    _token: CSRF_TOKEN,
                    location_id: $("#location_id").val(),
                },
                success: function(data) {
                    console.log(data.feasibilityentry.construction_life_cycle);
                    let total_loop = (Number(Math.ceil(data.feasibilityentry.construction_life_cycle)) + 1) * 12;
                    console.log(total_loop,data.rnc);
                    let rate = data.rnc.bd_feas_rnc_cal_rate;
                    let cost = data.rnc.bd_feas_rnc_cal_cost;
                    let rate_array = [rate.row_1st,rate.row_2nd,rate.row_3rd,rate.row_4th,rate.row_5th,rate.row_6th,rate.row_7th,rate.row_8th,rate.row_9th,rate.row_10th]
                    let cost_array = [cost.row_1st,cost.row_2nd,cost.row_3rd,cost.row_4th,cost.row_5th,cost.row_6th,cost.row_7th,cost.row_8th,cost.row_9th,cost.row_10th]
                    console.log(rate_array,cost_array);
                    /**/
                    for(let i=0;i<total_loop;i++){
                        let yr = Math.ceil((i)/12);
                        console.log(i,yr,rate_array[yr],cost_array[yr]);
                    }
                    /**/
                    $('#total_payment_for_land').text(data.feasibilityentry.total_payment);
                    $('#registration_cost').text(data.feasibilityentry.registration_cost);
                    $('#land_size').text(data.feasibilityentry.bd_lead_generation.land_size);

                    var total_bonus_saleable_area = Math.round(data.feasibilityentry.project_layout.total_far * data.feasibilityentry.bd_lead_generation.land_size * 720 * data.feasibilityentry.bonus_saleable_area / 100);
                    $('#total_bonus_saleable_area').text(total_bonus_saleable_area);

                    let total_basement_floor = data.feasibilityentry.project_layout.total_basement_floor;
                    let basement_and_land_sft = total_basement_floor * data.feasibilityentry.bd_lead_generation.land_size * 720;
                    var floor_area_far_free = basement_and_land_sft * data.feasibilityentry.floor_area_far_free / 100;
                    $('#semi_basement_floor_area').text(Math.round(floor_area_far_free));

                    let sum = 0;
                    data.feasibilityentry.bd_feasibility_ctc.bd_feasi_ctc_detail.forEach(myFunction);

                    function myFunction(item, index) {
                        sum += item.total_payable;
                    }
                    $('#salary_and_overhead').text(sum);
                    $('#construction_life_cycle').text(data.feasibilityentry.construction_life_cycle);
                    $('#floor_area_far_free').text(data.feasibilityentry.floor_area_far_free);
                    $('#developers_ratio').text(data.feasibilityentry.rfpl_ratio);
                    $('#proposed_mgc').text( data.feasibilityentry.project_layout.proposed_mgc);
                    data.feasibilityentry.bd_feasi_revenue.bd_feasi_revenue_detail.forEach(farUtilizationFunction);

                    function farUtilizationFunction(item, index) {
                        var total_builtup_area = 0;
                        let ground_floor_id = (item.floor_id);
                        if (ground_floor_id == 729) {
                            let developers_ratio_percentage = data.feasibilityentry.rfpl_ratio / 100;
                            let mgc_percentage = data.feasibilityentry.project_layout.proposed_mgc / 100;
                            let far_utilization_mgc = ((item.floor_sft / developers_ratio_percentage) /
                                (data.feasibilityentry.bd_lead_generation.land_size * 720 * mgc_percentage) * 100).toFixed(2);

                            let land_sft_floor_area_far_free = data.feasibilityentry.bd_lead_generation.land_size * 720 * data.
                            feasibilityentry.floor_area_far_free / 100;
                            let far_utilization_mgc_percentage = far_utilization_mgc / 100 * data.feasibilityentry.bd_lead_generation.land_size *
                                720 * mgc_percentage;
                            var ground_floor_area = land_sft_floor_area_far_free -
                                far_utilization_mgc_percentage;
                            $('#ground_floor_area').text(ground_floor_area);
                            // alert(floor_area_far_free);

                        } else {
                            var ground_floor_area = 0;
                            $('#ground_floor_area').text(ground_floor_area);
                        }

                    }
                   
                    var total_buildup_area_as_far = Math.round(data.feasibilityentry.project_layout.total_far * data.feasibilityentry.bd_lead_generation.land_size * 720);
                    console.log(total_buildup_area_as_far);
                    $('#total_buildup_area_as_far').text(total_buildup_area_as_far);

                    getSubStructureTotal();
                    return false;
                }
            });
        });

        //  function for getting subStructure total
        function getSubStructureTotal() {
            let location_id = $("#location_id").val();
            let url = '{{ url('scj/getSubStructureTotal') }}/' + location_id;

            $.getJSON(url, function(items) {
                let land_size = $("#land_size").text();
                let total_payment_for_land = $("#total_payment_for_land").text();
                let registration_cost = $("#registration_cost").text();
                let t_bonus_saleable_area = $("#total_bonus_saleable_area").text();
                let semi_basement_farea = $("#semi_basement_floor_area").text();
                let floor_area_far_free = $("#floor_area_far_free").text();
                let g_floor_area = Number($("#ground_floor_area").text()).toFixed(4);
                let t_buildup_area_as_far = $("#total_buildup_area_as_far").text();
                let salary_and_overhead = $('#salary_and_overhead').text();
                let construction_life_cycle = $('#construction_life_cycle').text();

                // let total_construction_cost = land_size * 720 *
                //     items.service_pile_cost +
                //     items.ConstructionCostFloor *
                //     Number(g_floor_area) +
                //     Number(t_buildup_area_as_far) +
                //     t_bonus_saleable_area +
                //     items.ConstructionCostBasement *
                //     semi_basement_farea;
                    // console.log('total_construction_cost',total_construction_cost);
                    // /******/
                let total_construction_cost = (Number(land_size) * 720 * Number(items.service_pile_cost) +
                            Number(items.ConstructionCostFloor) * (Number(
                                g_floor_area) + Number(t_buildup_area_as_far) + Number(
                                t_bonus_saleable_area)) + Number(items.ConstructionCostBasement) * Number(
                                semi_basement_farea)).toFixed(4);
                    // let sum = 0;
                    // data.bd_feasibility_ctc.bd_feasi_ctc_detail.forEach(myFunction);

                    // function myFunction(item, index) {
                    //     sum += item.total_payable;
                    // }
                    // $('#salary_and_overhead').text(sum);

                    // $('#overhead').text(Number($('#salary_and_overhead').text()) * data
                    //     .construction_life_cycle * 12);

                    // $('#total_cost_before_financial_cost').text(Number(data.total_payment) +
                    //         Number(data.registration_cost / 100 * data.total_payment) +
                    //         Number($('#total_construction_cost').text()) + Number($(
                    //             '#overhead').text()) + Number(items.other_costs));

                    /******/
                   let overhead = (Number(salary_and_overhead) * Number(construction_life_cycle) * 12);
console.log(Number(total_payment_for_land) +
                    (Number(registration_cost) / 100 * Number(total_payment_for_land)) + Number(total_construction_cost) + Number(overhead) +
                   Number(items.other_costs));
                    $('#total_cost_before_financial_cost').text(Number(total_payment_for_land) +
                    (Number(registration_cost) / 100 * Number(total_payment_for_land)) + Number(total_construction_cost) + Number(overhead) +
                   Number(items.other_costs));

            });
        }


        $(function(){
            @if($formType == 'create' && !old('material_id'))
                addRow();
            @endif

            $("#itemTable").on('click', ".addItem", function(){
                addRow();
            }).on('click', '.deleteItem', function(){
                $(this).closest('tr').remove();
            });

            $(document).on('mouseenter', '.month', function(){
                $(this).datepicker({format: "dd-mm-yyyy",autoclose: true,todayHighlight: true,showOtherMonths: true});
            });
        });

    </script>
@endsection
