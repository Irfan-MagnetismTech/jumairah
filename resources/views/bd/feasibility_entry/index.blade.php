@extends('layouts.backend-layout')
@section('title', 'Feasibility Dashboard')

@section('breadcrumb-title')
Feasibility Dashboard
@endsection

@section('breadcrumb-button')

@endsection

@section('sub-title')
<span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', null)

@section('content')
{!! Form::open(array('url' => "bdFesibilityUpdateData",'method' => 'POST','class'=>'custom-form')) !!}
{{-- value of full float for calculation --}}
<input type="hidden" id="total_payment_full">
<input type="hidden" id="total_fire_stair_area_full">
<input type="hidden" id="parking_sales_revenue_full">
<input type="hidden" id="total_additional_area_for_front_balcony_full">
<input type="hidden" id="total_additional_area_for_other_balcony_full">
<input type="hidden" id="salary_and_overhead_full">
<input type="hidden" id="sales_revenue_full">
<input type="hidden" id="semi_basement_floor_area_full" name="semi_basement_floor_area">
<input type="hidden" id="total_buildup_area_as_far_full" name="buildup_area">
<input type="hidden" id="total_bonus_saleable_area_full" name="bonus_saleable_area">
<input type="hidden" id="total_builtup_area_full">
<input type="hidden" id="total_saleable_area_full">
<input type="hidden" id="total_saleable_area_of_rfpl_sft_full" name="saleable_area">
<input type="hidden" id="maximum_ground_coverage_sft_full">
<input type="hidden" id="minimum_number_of_floor_considering_mgs_full">
<input type="hidden" id="typical_floor_area_with_bonus_far_full">
<input type="hidden" id="land_payment_per_katha_bdy_lac_full">
<input type="hidden" id="total_payment_for_land_full">
<input type="hidden" id="overhead_full">
<input type="hidden" id="service_pile_cost_full">
<input type="hidden" id="other_costs_full">
<input type="hidden" id="construction_cost_floor_full">
<input type="hidden" id="construction_cost_basement_full">
<input type="hidden" id="finance_cost_full">
<input type="hidden" id="total_construction_cost_full">
<input type="hidden" id="total_cost_before_financial_cost_full">
<input type="hidden" id="total_cost_full">
<input type="hidden" id="total_sales_rev_bdt_full">
<input type="hidden" id="ebit_full">
<input type="hidden" id="avg_con_cost_buildup_area_full">
<input type="hidden" id="avg_con_cost_saleable_area_full">
<input type="hidden" id="bep_full">
<input type="hidden" id="total_sales_rev_from_bonus_far_area_full">
<input type="hidden" id="total_sales_rev_from_far_area_full">
<input type="hidden" id="sales_rev_from_parking_and_utility_full">
<input type="hidden" id="total_sales_rev_full" name="total_sales">
<input type="hidden" id="approx_per_apt_full">
<input type="hidden" id="ground_floor_area_full" name="ground_floor_area">
<input type="hidden" id="parking_number_full">
<input type="hidden" id="inflow" name="inflow">
<input type="hidden" id="outflow" name="outflow">
<input type="hidden" id="construction_life" name="construction_life">
{{-- value of full float for calculation --}}
{{-- value for calculation --}}
<input type="hidden" id="floor_area_far_free">
<input type="hidden" id="bonus_saleable_area">
<input type="hidden" id="ground_floor_sft">
<input type="hidden" id="cons_total_area">
<input type="hidden" id="service_pile_cost_amount">
<input type="hidden" id="ConstructionCostFloor">
<input type="hidden" id="ConstructionCostBasement">
<input type="hidden" id="finance_cost_hide">
<input type="hidden" id="other_costs_hide">
<input type="hidden" id="revenue_from_parking">

{{-- value for calculation --}}
<div class="row custom-form">
    <div class="col-md-6 col-xl-6">
        <div class="input-group input-group-sm input-group-primary">
            <label class="input-group-addon" for="location_id">Location<span class="text-danger">*</span></label>
            {{ Form::select('location_id', $locations, old('location_id') ? old('location_id') : (!empty($ctc->location_id) ? $ctc->location_id : null), ['class' => 'form-control', 'id' => 'location_id', 'placeholder' => 'Select Location', 'autocomplete' => 'off']) }}
        </div>
    </div>
</div><!-- end row -->
<hr class="bg-success">

<div class="row custom-form" style="background-color: #c0eec6;">
    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>Land address</p>
        </div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>:&nbsp;</p>
            <p id="land_address"></p>
        </div>
    </div>

    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>Date</p>
        </div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>:&nbsp;</p>
            <p id="date"></p>
        </div>
    </div>

    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>Type of Land</p>
        </div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>:&nbsp;</p>
            <p class="land_type"></p>
        </div>
    </div>

    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>Development Plan</p>
        </div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>:&nbsp;</p>
            <p id="dev_plan"></p>
        </div>
    </div>

    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>Land Area in Khata</p>
        </div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>:&nbsp;</p>
            <p class="land_size"></p>
        </div>
    </div>

    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>RFPL Ratio (%)</p>
        </div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>:&nbsp;</p>
            <p class="developers_ratio"></p>
        </div>
    </div>

    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>Average Construction Cost/sft</p>
        </div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>:&nbsp;</p>
            <p id="avg_con_cost_per_sft"></p>
        </div>
    </div>

    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>Total Cost(BDT)</p>
        </div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>:&nbsp;</p>
            <p id="total_cost_bdt_crore"></p>
        </div>
    </div>

    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>Net profit before tax in crore</p>
        </div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>:&nbsp;</p>
            <p id="npbt"></p>
        </div>
    </div>

    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>ROI (%)</p>
        </div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>:&nbsp;</p>
            <p id="r_o_i"></p>
        </div>
    </div>

    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>Margin (%)</p>
        </div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>:&nbsp;</p>
            <p id="mar_gin"></p>
        </div>
    </div>

    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>Finance cost (as % of Total Cash Outflow)</p>
        </div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>:&nbsp;</p>
            <p id="fc_as_of_total_outflow"></p>
        </div>
    </div>
</div>

<hr class="bg-success">
{{-- 1st --}}
<div class="row custom-form">
    <div class="col-xl-6 col-md-6">
        <div class="tableHeading" style="background-color: #227447;">
            <h5> LAND INPUTS</h5>
        </div>
    </div>

    <div class="col-xl-6 col-md-6">
        <div class="tableHeading" style="background-color: #227447;">
            <h5>RESULT SUMMARY</h5>
        </div>
    </div>

    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>Land Area (katha)</p>
        </div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="row">
            <div class="col-6">
                <div class="input-group input-group-sm input-group-primary">
                    <p>:&nbsp;</p>
                    <p class="land_size"></p>
                </div>
            </div>
            <div class="col-6">
                <input type="text" class="form-control" id="land_size_input" name="land_size"/>
            </div>
        </div>

    </div>

    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>Total Builtup Area (SFT)</p>
        </div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>:&nbsp;</p>
            <p id="total_builtup_area_sft"></p>
        </div>
    </div>

    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>Total Payment for Land</p>
        </div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="row">
            <div class="col-6">
                <div class="input-group input-group-sm input-group-primary">
                    <p>:&nbsp;</p>
                    <p id="total_payment"></p>
                </div>
            </div>
            <div class="col-6">
                <input type="text" class="form-control" id="total_payment_input" name="total_payment"/>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>Total Sale-able Area of RFPL (SFT)</p>
        </div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>:&nbsp;</p>
            <p id="total_saleable_area_of_rfpl_sft"></p>
        </div>
    </div>

    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>RFPL Ratio (%)</p>
        </div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="row">
            <div class="col-6">
                <div class="input-group input-group-sm input-group-primary">
                    <p>:&nbsp;</p>
                    <p class="developers_ratio"></p>
                </div>
            </div>
            <div class="col-6">
                <input type="text" class="form-control" id="developers_ratio_input" name="developers_ratio"/>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>Total Sales Revenue (BDT Crore)</p>
        </div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>:&nbsp;</p>
            <p id="total_sales_rev_bdt"></p>
        </div>
    </div>

    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>Registration Cost (%)</p>
        </div>
    </div>
    <div class="col-xl-3 col-md-3">

        <div class="row">
            <div class="col-6">
                <div class="input-group input-group-sm input-group-primary">
                    <p>:&nbsp;</p>
                    <p id="registration_cost"></p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>Total Cost (BDT Crore)</p>
        </div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>:&nbsp;</p>
            <p id="total_cost_bdt"></p>
        </div>
    </div>

    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>Adjacent Road Width (Ft)</p>
        </div>
    </div>
    <div class="col-xl-3 col-md-3">

        <div class="row">
            <div class="col-6">
                <div class="input-group input-group-sm input-group-primary">
                    <p>:&nbsp;</p>
                    <p id="adjacent_road_width"></p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>Net Profit Before Tax (BDT Crore)</p>
        </div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>:&nbsp;</p>
            <p id='ebit'></p>
        </div>
    </div>

    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>Type of Land</p>
        </div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>:&nbsp;</p>
            <p class="land_type"></p>
        </div>
    </div>

    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>Margin (%)</p>
        </div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>:&nbsp;</p>
            <p id="margin"></p>
        </div>
    </div>

    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>FAR</p>
        </div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="row">
            <div class="col-6">
                <div class="input-group input-group-sm input-group-primary">
                    <p>:&nbsp;</p>
                    <p id="total_far"></p>
                </div>
            </div>
            <div class="col-6">
                <input type="text" class="form-control" id="total_far_input" name="far"/>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>ROI (%)</p>
        </div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>:&nbsp;</p>
            <p id="roi"></p>
        </div>
    </div>

    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>MGC (%)</p>
        </div>
    </div>
    <div class="col-xl-3 col-md-3">

        <div class="row">
            <div class="col-6">
                <div class="input-group input-group-sm input-group-primary">
                    <p>:&nbsp;</p>
                    <p id="proposed_mgc"></p>
                </div>
            </div>
            <div class="col-6">
                <input type="text" class="form-control" id="proposed_mgc_input" name="mgc"/>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>BEP (BDT / SFT)</p>
        </div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>:&nbsp;</p>
            <P id="bep"></P>
        </div>
    </div>
</div>
{{-- 2nd --}}
<div class="row custom-form">
    <div class="col-xl-6 col-md-6">
        <div class="tableHeading" style="background-color: #227447;">
            <h5> ADDITIONAL INPUTS</h5>
        </div>
    </div>

    <div class="col-xl-6 col-md-6">
        <div class="tableHeading" style="background-color: #227447;">
            <h5>CALCULATED INFORMATION</h5>
        </div>
    </div>

    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>Semi Basement + Basement</p>
        </div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="row">
            <div class="col-6">
                <div class="input-group input-group-sm input-group-primary">
                    <p>:&nbsp;</p>
                    <p id="total_basement_floor"></p>
                </div>
            </div>
            <div class="col-6">
                <input type="text" class="form-control" id="total_basement_floor_input" name="total_basement_floor" />
            </div>
        </div>

    </div>

    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>Maximum Ground Coverage (SFT)</p>
        </div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>:&nbsp;</p>
            <p id="maximum_ground_coverage_sft"></p>
        </div>
    </div>

    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>Parking area per car (SFT)</p>
        </div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="row">
            <div class="col-6">
                <div class="input-group input-group-sm input-group-primary">
                    <p>:&nbsp;</p>
                    <p id="parking_area_per_car"></p>
                </div>
            </div>
            <div class="col-6">
                <input type="text" class="form-control" id="parking_area_per_car_input" name="parking_area_per_car" />
            </div>
        </div>

    </div>

    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>Minimum Number of Floors Considering MGC</p>
        </div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>:&nbsp;G+</p>
            <p id="minimum_number_of_floor_considering_mgs"></p>
        </div>
    </div>

    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>Building Front Length (FT)</p>
        </div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="row">
            <div class="col-6">
                <div class="input-group input-group-sm input-group-primary">
                    <p>:&nbsp;</p>
                    <p id="building_front_length"></p>
                </div>
            </div>
            <div class="col-6">
                <input type="text" class="form-control" id="building_front_length_input" name="building_front_length"/>
            </div>
        </div>

    </div>

    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>Floors Used</p>
        </div>
    </div>
    <div class="col-xl-3 col-md-3">

        <div class="row">
            <div class="col-6">
                <div class="input-group input-group-sm input-group-primary">
                    <p>:&nbsp;G+</p>
                    <p id="floor_used"></p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>Total Number of Floors</p>
        </div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>:&nbsp;G+</p>
            <p id="floor_number"></p>
        </div>
    </div>

    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>Typical Floor Area WITH Bonus FAR</p>
        </div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>:&nbsp;</p>
            <p id="typical_floor_area_with_bonus_far"></p>
        </div>
    </div>

    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>Fire Stair Area (SFT)</p>
        </div>

    </div>
    <div class="col-xl-3 col-md-3">
        <div class="row">
            <div class="col-6">
                <div class="input-group input-group-sm input-group-primary">
                    <p>:&nbsp;</p>
                    <p id="fire_stair_area"></p>
                </div>
            </div>
            <div class="col-6">
                <input type="text" class="form-control" id="fire_stair_area_input" name="fire_stair_area"/>
            </div>
        </div>

    </div>

    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>Total Number of Parking</p>
        </div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>:&nbsp;</p>
            <p id="total_number_of_parking"></p>
        </div>
    </div>

    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>Number of Parkings in Basement</p>
        </div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="row">
            <div class="col-3">
                <div class="input-group input-group-sm input-group-primary" data-toggle="tooltip" title="Total Ground Floor / Parking Area Per Car">
                    <p>:&nbsp;</p>
                    <p id="parking_number_calculated"></p>
                </div>
            </div>
            <div class="col-3">
                <div class="input-group input-group-sm input-group-primary">
                    <p id="parking_number"></p>
                </div>
            </div>
            <div class="col-6">
                <input type="text" class="form-control" id="parking_number_input" name="parking_number"/>
            </div>
        </div>

    </div>

    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>Land Payment Per Katha (BDT Lac)</p>
        </div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>:&nbsp;</p>
            <p id="land_payment_per_katha_bdy_lac"></p>
        </div>
    </div>

    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>FAR Utilization in Ground Floor (% of MGC)</p>
        </div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="row">
            <div class="col-6">
                <div class="input-group input-group-sm input-group-primary">
                    <p>:&nbsp;</p>
                    <p id="far_utilization_mgc"></p>
                </div>
            </div>
            <div class="col-6">
                <input type="text" class="form-control" id="far_utilization_mgc_input" name="utilization"/>
            </div>
        </div>

    </div>

    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>Avg Construction Cost (BDT/ SFT Builtup Area)</p>
        </div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>:&nbsp;</p>
            <p id="avg_con_cost_buildup_area"></p>
        </div>
    </div>

    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>Total Construction Life Cycle (Years)</p>
        </div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>:&nbsp;</p>
            <p id="construction_life_cycle"></p>
        </div>
    </div>

    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>Avg Construction Cost (BDT/ SFT Sale-able Area)</p>
        </div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>:&nbsp;</p>
            <p id="avg_con_cost_saleable_area"></p>
        </div>
    </div>
</div>

{{-- 3rd --}}
<div class="row custom-form">
    <div class="col-xl-6 col-md-6">
        <div class="tableHeading" style="background-color: #227447;">
            <h5>CONSTRUCTION COST (BDT /SFT)</h5>
        </div>
    </div>

    <div class="col-xl-6 col-md-6">
        <div class="tableHeading" style="background-color: #227447;">
            <h5>COSTS SUMMARY (BDT CRORE)</h5>
        </div>
    </div>

    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>Service Pile Cost (Calculated & To be Used)</p>
        </div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="row">
            <div class="col-6">
                <div class="input-group input-group-sm input-group-primary">
                    <p>:&nbsp;</p>
                    <p id="service_pile_cost"></p>
                </div>
            </div>
        </div>

    </div>

    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>Total Payment for Land</p>
        </div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>:&nbsp;</p>
            <p id="total_payment_for_land"></p>
        </div>
    </div>

    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>Construction Cost : Floor (Calculated & To Be Used)</p>
        </div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="row">
            <div class="col-6">
                <div class="input-group input-group-sm input-group-primary">
                    <p>:&nbsp;</p>
                    <p id="construction_cost_floor"></p>
                </div>
            </div>
        </div>

    </div>

    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>Registration Cost</p>
        </div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>:&nbsp;</p>
            <p id="reg_cost_tk"></p>
        </div>
    </div>

    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>Construction Cost : Basement (Calculated &To Be Used)</p>
        </div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="row">
            <div class="col-6">
                <div class="input-group input-group-sm input-group-primary">
                    <p>:&nbsp;</p>
                    <p id="construction_cost_basement"></p>
                </div>
            </div>
        </div>

    </div>


    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>Total Construction Cost</p>
        </div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>:&nbsp;</p>
            <p id="total_construction_cost"></p>
        </div>
    </div>

    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary"> </div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary"></div>
    </div>

    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>Overhead</p>
        </div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>:&nbsp;</p>
            <p id="overhead"></p>
        </div>
    </div>

    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary"></div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary"></div>
    </div>

    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>Other Costs</p>
        </div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>:&nbsp;</p>
            <p id="other_costs"></p>
        </div>
    </div>

    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary"></div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary"></div>
    </div>

    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>Total Cost before Finance Cost</p>
        </div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>:&nbsp;</p>
            <p id="total_cost_before_financial_cost"></p>
        </div>
    </div>

    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary"></div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary"></div>
    </div>

    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>Finance Cost</p>
        </div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>:&nbsp;</p>
            <p id="finance_cost"></p>
        </div>
    </div>

    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary"></div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary"></div>
    </div>

    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>Finance cost (as % of Total Cash Outflow)</p>
        </div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>:&nbsp;</p>
            <p id="finance_cost_as_percent"></p>
        </div>
    </div>

    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary"></div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary"></div>
    </div>

    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>Total Cost</p>
        </div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>:&nbsp;</p>
            <p id="total_cost"></p>
        </div>
    </div>
</div>
{{-- 4th --}}
<div class="row custom-form">
    <div class="col-xl-6 col-md-6">
        <div class="tableHeading" style="background-color: #227447;">
            <h5>OTHER COST AND REVENUE INPUTS</h5>
        </div>
    </div>

    <div class="col-xl-6 col-md-6">
        <div class="tableHeading" style="background-color: #227447;">
            <h5>REVENUE SUMMARY (BDT CRORE)</h5>
        </div>
    </div>

    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>Sales Revenue (BDT / SFT)</p>
        </div>
    </div>
    <div class="col-xl-3 col-md-3">
        
        <div class="row">
            <div class="col-6">
                <div class="input-group input-group-sm input-group-primary">
                    <p>:&nbsp;</p>
                    <p id="sales_revenue"></p>
                </div>
            </div>
            <div class="col-6">
                <input type="text" class="form-control" id="sales_revenue_input" name="sales_rev_per_floor"/>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>Total Sales Revenue from FAR Area</p>
        </div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>:&nbsp;</p>
            <p id="total_sales_rev_from_far_area"></p>
        </div>
    </div>

    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>Parking Sales Revenue (BDT / Parking)</p>
        </div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="row">
            <div class="col-6">
                <div class="input-group input-group-sm input-group-primary">
                    <p>:&nbsp;</p>
                    <p id="parking_sales_revenue"></p>
                </div>
            </div>
        </div>

    </div>

    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>Total Sales Revenue from Bonus FAR Area</p>
        </div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>:&nbsp;</p>
            <p id="total_sales_rev_from_bonus_far_area"></p>
        </div>
    </div>

    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>Salary and Overhead per Month (BDT)</p>
        </div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="row">
            <div class="col-6">
                <div class="input-group input-group-sm input-group-primary">
                    <p>:&nbsp;</p>
                    <p id="salary_and_overhead"></p>
                </div>
            </div>
        </div>

    </div>

    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>Sales Revenue from Parking & Utility</p>
        </div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>:&nbsp;</p>
            <p id="sales_rev_from_parking_and_utility"></p>
        </div>
    </div>

    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>Other Costs (Design, CDA, Speed money)</p>
        </div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="row">
            <div class="col-6">
                <div class="input-group input-group-sm input-group-primary">
                    <p>:&nbsp;</p>
                    <p id="permission_fees_and_otherCost"></p>
                </div>
            </div>
        </div>

    </div>

    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>Total Sales Revenue</p>
        </div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>:&nbsp;</p>
            <p id="total_sales_rev"></p>
        </div>
    </div>


</div>
{{-- 4th --}}
<div class="row custom-form">
    <div class="col-xl-6 col-md-6">
        <div class="tableHeading" style="background-color: #227447;">
            <h5>TOTAL BUILTUP AREA (SFT)</h5>
        </div>
    </div>

    <div class="col-xl-6 col-md-6"></div>

    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>Semi Basement Floor Area (FAR Free)</p>
        </div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>:&nbsp;</p>
            <p id="semi_basement_floor_area"></p>
        </div>
    </div>

    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary"></div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary"></div>
    </div>

    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>Total Ground Floor Area (FAR Free)</p>
        </div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>:&nbsp;</p>
            <p id="ground_floor_area"></p>
        </div>
    </div>

    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary"></div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary"></div>
    </div>

    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>Total Buildup Area as per FAR (SFT)</p>
        </div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>:&nbsp;</p>
            <p id="total_buildup_area_as_far"></p>
        </div>
    </div>

    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary"></div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary"></div>
    </div>

    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>Total Bonus Sale-able Area</p>
        </div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>:&nbsp;</p>
            <p id="total_bonus_saleable_area"></p>
        </div>
    </div>

    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary"></div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary"></div>
    </div>

    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>Total Fire Stair Area (SFT)</p>
        </div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>:&nbsp;</p>
            <p id="total_fire_stair_area"></p>
        </div>
    </div>

    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary"></div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary"></div>
    </div>

    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>Total Additional Area for Front Balcony</p>
        </div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>:&nbsp;</p>
            <p id="total_additional_area_for_front_balcony"></p>
        </div>
    </div>

    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary"></div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary"></div>
    </div>

    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>Total Additional Area for Other Balcony</p>
        </div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>:&nbsp;</p>
            <p id="total_additional_area_for_other_balcony"></p>
        </div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary"></div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary"></div>
    </div>

    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>Total Builtup Area</p>
        </div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>:&nbsp;</p>
            <p id="total_builtup_area"></p>
        </div>
    </div>

    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary"></div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary"></div>
    </div>


    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>Total Sale-able Area</p>
        </div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>:&nbsp;</p>
            <p id="total_saleable_area"></p>
        </div>
    </div>


    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>Total Apt. No.</p>
        </div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>:&nbsp;</p>
            <p class="apertment_number"></p>
        </div>
    </div>


    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>Approx. per Apt. (SFT)</p>
        </div>
    </div>
    <div class="col-xl-3 col-md-3">
        <div class="input-group input-group-sm input-group-primary">
            <p>:&nbsp;</p>
            <p id="approx_per_apt"> </p>

        </div>
    </div>

</div>
<hr class="bg-success">
<hr class="bg-success">
<div class="row">
    <div class="offset-md-5 col-md-2 mt-2">
        <div class="input-group input-group-sm">
            <button class="btn btn-success btn-round btn-block py-2" disabled="true" id="submit_btn">update</button>
        </div>
    </div>
</div>

{!! Form::close() !!}

@endsection

@section('script')
<script>
    //       let nmbrFormat = new Intl.NumberFormat("en-BD", {
    //   currencySign: "accounting",
    //   signDisplay: "auto",
    //   maximumFractionDigits:2,
    // }).nmbrFormat.format();
    var CSRF_TOKEN = "{{ csrf_token() }}";

    var cons_total_area = 0;
    var total_parking_area = 0;
    $("#location_id").on('change', function() {
        $.ajax({
            url: "{{ url('scj/getFeasibilityEntryData') }}"
            , type: 'get'
            , dataType: "json"
            , data: {
                _token: CSRF_TOKEN
                , location_id: $("#location_id").val()
            , }
            , success: function(data) {
                console.log(data);
                // console.log(data.feasibilityentry.bd_lead_generation);
                $('#land_address').text(data.feasibilityentry.bd_lead_generation.land_location);
                $('#dev_plan').text(data.feasibilityentry.dev_plan);
                /*hidden field*/
                $('#floor_area_far_free').val(data.feasibilityentry.floor_area_far_free);
                $('#bonus_saleable_area').val(data.feasibilityentry.bonus_saleable_area);
                /*hidden field*/
                $('#date').text(data.feasibilityentry.updated_at);
                $('.land_type').text(data.feasibilityentry.bd_lead_generation.category);
                let land_size = data.feasibilityentry.bd_lead_generation.land_size;
                $('.land_size').text(land_size);
                $('#land_size_input').val(land_size);
                let developers_ratio = data.feasibilityentry.rfpl_ratio;
                $('.developers_ratio').text(developers_ratio);
                $('#developers_ratio_input').val(developers_ratio);
                $('#total_payment').text(Number(data.feasibilityentry.total_payment).toLocaleString(
                    undefined, {
                        minimumFractionDigits: 2
                        , maximumFractionDigits: 2
                    }));
                $('#total_payment_full').val(Number(data.feasibilityentry.total_payment));

                $('#total_payment_input').val(Number(data.feasibilityentry.total_payment).toLocaleString(
                    undefined, {
                        minimumFractionDigits: 2
                        , maximumFractionDigits: 2
                    }));
                $('#registration_cost').text(data.feasibilityentry.registration_cost);
                $('#adjacent_road_width').text(data.feasibilityentry.adjacent_road_width);
                let far = data.feasibilityentry.bd_feasi_revenue ? data.feasibilityentry
                    .bd_feasi_revenue.actual_far : 0;
                $('#total_far').text(far);
                $('#total_far_input').val(far);
                let actual_mgc = Number(data.feasibilityentry.bd_feasi_revenue.mgc);
                let proposed_mgc = data.feasibilityentry.bd_feasi_revenue ? data.feasibilityentry
                    .bd_feasi_revenue.mgc : 0;
                $('#proposed_mgc').text(actual_mgc + "%");
                $('#proposed_mgc_input').val(actual_mgc);
                let total_basement_floor = data.feasibilityentry ? data
                    .feasibilityentry.basement_no : 0;
                $('#total_basement_floor').text(total_basement_floor);
                $('#total_basement_floor_input').val(total_basement_floor);
                $('#parking_area_per_car').text(data.feasibilityentry.parking_area_per_car);
                $('#parking_area_per_car_input').val(data.feasibilityentry.parking_area_per_car);
                let actual_floor = data.feasibilityentry.bd_feasi_revenue.actual_story;
                $('#floor_number').text(actual_floor);
                $('#fire_stair_area').text(data.feasibilityentry.fire_stair_area);
                $('#fire_stair_area_input').val(data.feasibilityentry.fire_stair_area);
                let total_fire_stair_area = actual_floor * data
                    .feasibilityentry.fire_stair_area * (actual_floor >= 9)
                $('#total_fire_stair_area').text(total_fire_stair_area.toLocaleString(
                    undefined, {
                        minimumFractionDigits: 2
                        , maximumFractionDigits: 2
                    }));
                $('#total_fire_stair_area_full').val(total_fire_stair_area);

              
                $('#construction_life_cycle').text(data.feasibilityentry.construction_life_cycle);
                $('#construction_life').val(data.feasibilityentry.construction_life_cycle);
                $('#parking_sales_revenue').text(Number(data.feasibilityentry.parking_sales_revenue)
                    .toLocaleString(
                        undefined, {
                            minimumFractionDigits: 2
                            , maximumFractionDigits: 2
                        }));
                $('#parking_sales_revenue_full').val(Number(data.feasibilityentry.parking_sales_revenue));

                $('#building_front_length').text(data.feasibilityentry.building_front_length);
                $('#building_front_length_input').val(data.feasibilityentry.building_front_length);
                $('#total_additional_area_for_front_balcony').text((data.feasibilityentry
                    .building_front_length *
                    0.30 * 3.28 * actual_floor).toLocaleString(
                    undefined, {
                        minimumFractionDigits: 2
                        , maximumFractionDigits: 2
                    }));
                $('#total_additional_area_for_front_balcony_full').val((data.feasibilityentry.building_front_length * 0.30 * 3.28 * actual_floor));

                $('#total_additional_area_for_other_balcony').text((far * land_size * 720 * 0.025)
                    .toLocaleString(
                        undefined, {
                            minimumFractionDigits: 2
                            , maximumFractionDigits: 2
                        }));

                $('#total_additional_area_for_other_balcony_full').val((far * land_size * 720 * 0.025));

                // $('#semi_basement_floor_area').text(data.semi_basement_floor_area);
                // $('#ground_floor_area').text(data.ground_floor_area);
                $('.apertment_number').text(data.feasibilityentry.apertment_number);

                // let sum = 0;
                // data.feasibilityentry.bd_feasibility_ctc.bd_feasi_ctc_detail.forEach(myFunction);

                // function myFunction(item, index) {
                //     sum += item.total_effect;
                // }

                let sum = data.feasibilityentry.bd_feasibility_ctc.grand_total_effect ? data.feasibilityentry.bd_feasibility_ctc.grand_total_effect : 0;

                $('#salary_and_overhead').text(sum.toLocaleString(undefined, {
                    minimumFractionDigits: 2
                    , maximumFractionDigits: 2
                }));

                $('#salary_and_overhead_full').val(sum);

                let sales_revenue = data.feasibilityentry.bd_feasi_revenue.avg_rate;
                $('#sales_revenue').text(sales_revenue.toLocaleString(undefined, {
                    minimumFractionDigits: 2
                    , maximumFractionDigits: 2
                }));

                $('#sales_revenue_input').val(sales_revenue);

                $('#sales_revenue_full').val(sales_revenue);

                let basement_and_land_sft = total_basement_floor * land_size * 720;
                var floor_area_far_free = basement_and_land_sft * data.feasibilityentry
                    .floor_area_far_free / 100;

                $('#semi_basement_floor_area').text(floor_area_far_free.toLocaleString(
                    undefined, {
                        minimumFractionDigits: 2
                        , maximumFractionDigits: 2
                    }));
                $('#semi_basement_floor_area_full').val(floor_area_far_free);

                var total_buildup_area_as_far = far * land_size * 720;
                $('#total_buildup_area_as_far').text(total_buildup_area_as_far.toLocaleString(
                    undefined, {
                        minimumFractionDigits: 2
                        , maximumFractionDigits: 2
                    }));
                $('#total_buildup_area_as_far_full').val(total_buildup_area_as_far);

                var total_bonus_saleable_area = far * land_size * 720 * data.feasibilityentry
                    .bonus_saleable_area / 100;
                $('#total_bonus_saleable_area').text(total_bonus_saleable_area.toLocaleString(
                    undefined, {
                        minimumFractionDigits: 2
                        , maximumFractionDigits: 2
                    }));

                $('#total_bonus_saleable_area_full').val(total_bonus_saleable_area);

                // data.feasibilityentry.bd_feasi_revenue.bd_feasi_revenue_detail.forEach(
                //     farUtilizationFunction);


                // function farUtilizationFunction(item, index) {
                //     var total_builtup_area = 0;

                //     let ground_floor_id = (item.floor_id);
                //     if (ground_floor_id == 108) {
                //         let developers_ratio_percentage = developers_ratio / 100;
                //         let mgc_percentage = proposed_mgc / 100;
                //         let far_utilization_mgc = ((item.floor_sft / developers_ratio_percentage) /
                //             (land_size * 720 * mgc_percentage) * 100).toFixed(2);
                //         $('#far_utilization_mgc').text(far_utilization_mgc + '%');

                //         let land_sft_floor_area_far_free = land_size * 720 * data.feasibilityentry
                //             .floor_area_far_free / 100;
                //         let far_utilization_mgc_percentage = far_utilization_mgc / 100 * land_size *
                //             720 * mgc_percentage;

                //         var ground_floor_area = land_sft_floor_area_far_free -
                //             far_utilization_mgc_percentage;
                //         $('#ground_floor_area').text(ground_floor_area.toFixed(2));
                //         total_builtup_area = floor_area_far_free + ground_floor_area +
                //             total_buildup_area_as_far + total_bonus_saleable_area;

                //         cons_total_area = ground_floor_area + total_bonus_saleable_area +
                //             total_buildup_area_as_far;
                //     } else {
                //         $('#far_utilization_mgc').text('0%');
                //         var ground_floor_area = 0;
                //         $('#ground_floor_area').text(ground_floor_area);
                //         total_builtup_area = floor_area_far_free + ground_floor_area +
                //             total_buildup_area_as_far + total_bonus_saleable_area;
                //     }
                // }


                let ground_floor_sft = Number(data.feasibilityentry.bd_feasi_revenue.ground_floor_sft);

                $('#ground_floor_sft').val(data.feasibilityentry.bd_feasi_revenue.ground_floor_sft);


                if (ground_floor_sft > 0) {
                    utilization = (ground_floor_sft / developers_ratio / 100) / (land_size * 720 * actual_mgc) * 100;
                } else {
                    utilization = 0;
                }
                let total_ground_floor_area = (Number(land_size) * 720 * Number(data.feasibilityentry.floor_area_far_free) / 100) - (utilization / 100 * land_size * 720 * actual_mgc / 100);
                $('#far_utilization_mgc').text(utilization + '%');
                $('#far_utilization_mgc_input').val(utilization);
                $('#ground_floor_area').text(total_ground_floor_area.toFixed(2));
                $('#ground_floor_area_full').val(total_ground_floor_area);
                //
                var total_builtup_area = Number(floor_area_far_free) + Number(total_ground_floor_area) + Number(total_buildup_area_as_far) + Number(total_bonus_saleable_area);
                cons_total_area = Number(total_ground_floor_area) + Number(total_bonus_saleable_area) + Number(total_buildup_area_as_far);

                $('#cons_total_area').val(cons_total_area);

                /*calculation for cost of service pile*/
                // let semi_basement_farea = $('#semi_basement_floor_area').text();
                let t_buildup_area_as_far = total_buildup_area_as_far;
                let t_bonus_saleable_area = total_bonus_saleable_area;
                let g_floor_area = total_ground_floor_area;
                let d_ratio = developers_ratio;
                let far_utili_mgc = utilization;
                // let total_builtup_area = Number(floor_area_far_free) + Number(
                //         t_buildup_area_as_far) + Number(t_bonus_saleable_area) +
                //     Number(g_floor_area);
                $('#total_builtup_area').text(total_builtup_area.toLocaleString(undefined, {
                    minimumFractionDigits: 2
                    , maximumFractionDigits: 2
                }));

                $('#total_builtup_area_full').val(total_builtup_area);

                $('#total_builtup_area_sft').text(total_builtup_area.toLocaleString(undefined, {
                    minimumFractionDigits: 2
                    , maximumFractionDigits: 2
                }));

                let total_saleable_area = Number(t_buildup_area_as_far) + Number(
                    t_bonus_saleable_area)
                $('#total_saleable_area').text(total_saleable_area.toLocaleString(undefined, {
                    minimumFractionDigits: 2
                    , maximumFractionDigits: 2
                }));


                $('#total_saleable_area_full').val(total_saleable_area);


                let total_saleable_area_of_rfpl_sft = (Number(t_buildup_area_as_far) + Number(
                    t_bonus_saleable_area)) * Number(data.feasibilityentry.rfpl_ratio) / 100;

                $('#total_saleable_area_of_rfpl_sft').text(total_saleable_area_of_rfpl_sft
                    .toLocaleString(
                        undefined, {
                            minimumFractionDigits: 2
                            , maximumFractionDigits: 2
                        }));

                $('#total_saleable_area_of_rfpl_sft_full').val(total_saleable_area_of_rfpl_sft);
                
                let mgc = data.feasibilityentry.bd_feasi_revenue ? actual_mgc : 0;
                let maximum_ground_coverage_sft = (mgc / 100) *
                    data.feasibilityentry.bd_lead_generation.land_size * 720;
                $('#maximum_ground_coverage_sft').text(maximum_ground_coverage_sft.toLocaleString(
                    undefined, {
                        minimumFractionDigits: 2
                        , maximumFractionDigits: 2
                    }));
                $('#maximum_ground_coverage_sft_full').val(maximum_ground_coverage_sft);

                $('#minimum_number_of_floor_considering_mgs').text(actual_floor);

                $('#minimum_number_of_floor_considering_mgs_full').val(actual_floor);

                let typical_floor_area_with_bonus_far = ((t_buildup_area_as_far - (far_utili_mgc /
                            100) *
                        (actual_mgc / 100) *
                        data.feasibilityentry.bd_lead_generation.land_size * 720) /
                    actual_floor + t_bonus_saleable_area /
                    actual_floor);
                $('#typical_floor_area_with_bonus_far').text(typical_floor_area_with_bonus_far
                    .toLocaleString(
                        undefined, {
                            minimumFractionDigits: 2
                            , maximumFractionDigits: 2
                        }));

                $('#typical_floor_area_with_bonus_far_full').val(typical_floor_area_with_bonus_far);

                $('#land_payment_per_katha_bdy_lac').text((Number(data.feasibilityentry
                    .total_payment) / Number(data.feasibilityentry
                    .bd_lead_generation.land_size)).toLocaleString(undefined, {
                    minimumFractionDigits: 2
                    , maximumFractionDigits: 2
                }));


                $('#land_payment_per_katha_bdy_lac_full').val((Number(data.feasibilityentry.total_payment) / Number(data.feasibilityentry.bd_lead_generation.land_size)));

                $('#floor_used').text(actual_floor);
                $('#floor_used_input').val(actual_floor);

                let parking_number_calculated = (total_ground_floor_area / data.feasibilityentry.parking_area_per_car);
                let parking_number= Number(data.feasibilityentry.parking_number);
                $('#parking_number_calculated').text(Math.floor(parking_number_calculated));
                $('#parking_number').text(Math.floor(parking_number));
                $('#parking_number_input').val(Math.floor(parking_number));
                $('#parking_number_full').val(parking_number);

                total_parking_area = (parseFloat(floor_area_far_free / data
                        .feasibilityentry.parking_area_per_car)) +
                    parseFloat(parking_number);
                $('#total_number_of_parking').text(Math.floor(total_parking_area));

                $('#total_payment_for_land').text(Number(data.feasibilityentry.total_payment)
                    .toLocaleString(
                        undefined, {
                            minimumFractionDigits: 2
                            , maximumFractionDigits: 2
                        }));
                $('#total_payment_for_land_full').val(Number(data.feasibilityentry.total_payment));

                let overhead = sum * data.feasibilityentry.construction_life_cycle * 12;
                $('#overhead').text(overhead.toLocaleString(undefined, {
                    minimumFractionDigits: 2
                    , maximumFractionDigits: 2
                }));

                $('#overhead_full').val(Number(overhead));


                $('#reg_cost_tk').text(data.feasibilityentry.registration_cost / 100 * data
                    .feasibilityentry.total_payment);

                let location_id = $("#location_id").val();
                let url = "{{ url('scj/getSubStructureTotal') }}/" + location_id;

              




                let total_sales_rev_form_far_area = t_buildup_area_as_far * sales_revenue * data
                    .feasibilityentry.rfpl_ratio / 100
                $('#total_sales_rev_from_far_area').text(total_sales_rev_form_far_area
                    .toLocaleString(undefined, {
                        minimumFractionDigits: 2
                        , maximumFractionDigits: 2
                    }));
                $('#total_sales_rev_from_far_area_full').val(Number(total_sales_rev_form_far_area));

                let total_sales_rev_from_bonus_far_area = t_bonus_saleable_area * sales_revenue *
                    Number(data.feasibilityentry
                        .rfpl_ratio) / 100
                $('#total_sales_rev_from_bonus_far_area').text(total_sales_rev_from_bonus_far_area
                    .toLocaleString(undefined, {
                        minimumFractionDigits: 2
                        , maximumFractionDigits: 2
                    }));

                $('#total_sales_rev_from_bonus_far_area_full').val(Number(total_sales_rev_from_bonus_far_area));
                
                
                let sales_rev_parking_utility = (Number(Math.floor(total_parking_area)) *
                Number(data.feasibilityentry.parking_sales_revenue) *
                Number(data.feasibilityentry.rfpl_ratio) / 100) +
                (Number(data.feasibilityentry.apertment_number) *
                Number(data.feasibilityentry.rfpl_ratio) / 100 * data.feasibilityentry
                .parking_rate);
                // let sales_rev_parking_utility = (Number(Math.floor(total_parking_area)) *
                // Number(data.feasibilityentry.parking_sales_revenue) *
                // Number(data.feasibilityentry.rfpl_ratio) / 100) +
                // (Number(total_saleable_area) *
                // Number(data.feasibilityentry.rfpl_ratio) / 100 *  data.feasibilityentry
                // .parking_rate);
                
                $('#revenue_from_parking').val(Number(data.feasibilityentry
                        .parking_rate));

                $('#sales_rev_from_parking_and_utility').text(sales_rev_parking_utility
                    .toLocaleString(undefined, {
                        minimumFractionDigits: 2
                        , maximumFractionDigits: 2
                    }));
                $('#sales_rev_from_parking_and_utility_full').val(Number(sales_rev_parking_utility));

                let total_sales_rev = total_sales_rev_form_far_area +
                    total_sales_rev_from_bonus_far_area + sales_rev_parking_utility;
                // console.log(total_sales_rev);
                $('#total_sales_rev').text(total_sales_rev.toLocaleString(undefined, {
                    minimumFractionDigits: 2
                    , maximumFractionDigits: 2
                }));

                $('#total_sales_rev_full').val(Number(total_sales_rev));

                let approx_per_apt = (Number(total_saleable_area) / Number(data
                    .feasibilityentry.apertment_number))
                $('#approx_per_apt').text(approx_per_apt.toLocaleString(undefined, {
                    minimumFractionDigits: 2
                    , maximumFractionDigits: 2
                }));

                $('#approx_per_apt_full').val(Number(approx_per_apt));





                $.getJSON(url, function(items) {
                    let service_pile_cost_calculation = items.service_pile_cost / (data.feasibilityentry.bd_lead_generation.land_size * 720);

                    $('#service_pile_cost_amount').val(Number(items.service_pile_cost));
                    $('#ConstructionCostFloor').val(Number(items.ConstructionCostFloor));
                    $('#ConstructionCostBasement').val(Number(items.ConstructionCostBasement));
                    $('#finance_cost_hide').val(Number(items.finance_cost));
                    $('#other_costs_hide').val(Number(items.other_costs));

                    $('#service_pile_cost').text(service_pile_cost_calculation
                        .toLocaleString(
                            undefined, {
                                minimumFractionDigits: 2
                                , maximumFractionDigits: 2
                            }));
                    $('#service_pile_cost_full').val(Number(service_pile_cost_calculation));

                    $('#permission_fees_and_otherCost').text(Number(items.other_costs)
                        .toLocaleString(
                            undefined, {
                                minimumFractionDigits: 2
                                , maximumFractionDigits: 2
                            }));

                    $('#other_costs').text(Number(items.other_costs).toLocaleString(
                        undefined, {
                            minimumFractionDigits: 2
                            , maximumFractionDigits: 2
                        }));
                    $('#other_costs_full').val(Number(items.other_costs));
                    // console.log(cons_total_area)
                    let construction_cost_floor = items.ConstructionCostFloor /
                        cons_total_area;
                    let construction_cost_basement = items.ConstructionCostBasement;
                    $('#construction_cost_floor').text(construction_cost_floor
                        .toLocaleString(
                            undefined, {
                                minimumFractionDigits: 2
                                , maximumFractionDigits: 2
                            }));
                    $('#construction_cost_floor_full').val(Number(construction_cost_floor));

                    $('#construction_cost_basement').text(construction_cost_basement
                        .toLocaleString(
                            undefined, {
                                minimumFractionDigits: 2
                                , maximumFractionDigits: 2
                            }));
                    
                    $('#construction_cost_basement_full').val(Number(construction_cost_basement));

                    $('#finance_cost').text(items.finance_cost.toLocaleString(undefined, {
                        minimumFractionDigits: 2
                        , maximumFractionDigits: 2
                    }));


                    $('#finance_cost_full').val(Number(items.finance_cost));

                    //  let total_construction_cost= (Number(data.feasibilityentry.bd_lead_generation.land_size) * 720) *
                    //         (Number($('#service_pile_cost').text()) +
                    //         Number($('#construction_cost_floor').text()) )
                    // (Number(g_floor_area) +
                    // Number(t_buildup_area_as_far) +
                    // Number(t_bonus_saleable_area)) +
                    // Number($('#construction_cost_basement').text()) *
                    // Number(semi_basement_farea)
                    // ;
                    //
                   
                    //
                    // $('#total_construction_cost').text(total_construction_cost.toFixed(2));

                    let total_construction_cost = (data.feasibilityentry.bd_lead_generation
                        .land_size * 720 * service_pile_cost_calculation +
                        construction_cost_floor * (Number(g_floor_area) +
                            t_buildup_area_as_far + t_bonus_saleable_area) +
                        construction_cost_basement * floor_area_far_free)




                    $('#total_construction_cost').text(total_construction_cost
                        .toLocaleString(
                            undefined, {
                                minimumFractionDigits: 2
                                , maximumFractionDigits: 2
                            }));

                    $('#total_construction_cost_full').val(Number(total_construction_cost));

                    let total_financial_cost = (Number(data.feasibilityentry
                            .total_payment) +
                        Number(data.feasibilityentry.registration_cost / 100 * data
                            .feasibilityentry.total_payment) +
                        Number(total_construction_cost) +
                        Number(overhead) + Number(items.other_costs))

                    $('#total_cost_before_financial_cost').text(total_financial_cost
                        .toLocaleString(
                            undefined, {
                                minimumFractionDigits: 2
                                , maximumFractionDigits: 2
                            }));
                    $('#total_cost_before_financial_cost_full').val(Number(total_financial_cost));

                    $('#finance_cost_as_percent').text(Math.round(Number(items
                            .finance_cost) / Number(total_financial_cost) * 100)
                        .toFixed(2) + '%');
                    $('#fc_as_of_total_outflow').text(Math.round(Number(items
                            .finance_cost) / Number(total_financial_cost) * 100)
                        .toFixed(2) + '%');

                    let total_cost = Number(items.finance_cost) + Number(
                        total_financial_cost)
                    $('#total_cost').text(total_cost.toLocaleString(undefined, {
                        minimumFractionDigits: 2
                        , maximumFractionDigits: 2
                    }));

                    $('#total_cost_full').val(Number(total_cost));

                    $('#total_cost_bdt').text(total_cost.toLocaleString(undefined, {
                        minimumFractionDigits: 2
                        , maximumFractionDigits: 2
                    }));


                    $('#total_cost_bdt_crore').text(total_cost.toLocaleString(
                        undefined, {
                            minimumFractionDigits: 2
                            , maximumFractionDigits: 2
                        }));


                    $('#total_sales_rev_bdt').text(total_sales_rev.toLocaleString(
                        undefined, {
                            minimumFractionDigits: 2
                            , maximumFractionDigits: 2
                        }));


                    $('#total_sales_rev_bdt_full').val(Number(total_sales_rev));

                    let ebit = total_sales_rev - total_cost;
                    $('#ebit').text(ebit.toLocaleString(
                        undefined, {
                            minimumFractionDigits: 2
                            , maximumFractionDigits: 2
                        }));

                    $('#ebit_full').val(Number(ebit));

                    $('#npbt').text(ebit.toLocaleString(
                        undefined, {
                            minimumFractionDigits: 2
                            , maximumFractionDigits: 2
                        }));


                    

                    $('#avg_con_cost_buildup_area').text((total_construction_cost /
                        total_builtup_area).toLocaleString(
                        undefined, {
                            minimumFractionDigits: 2
                            , maximumFractionDigits: 2
                        }));

                    $('#avg_con_cost_buildup_area_full').val(Number(total_construction_cost / total_builtup_area));

                    // $('#total_construction_cost').text((Number(data.bd_lead_generation
                    //         .land_size) * 720 * Number($('#service_pile_cost').text()) +
                    //     Number($('#construction_cost_floor').text()) * (Number(
                    //         g_floor_area) + Number(t_buildup_area_as_far) + Number(
                    //         t_bonus_saleable_area)) + Number($(
                    //         '#construction_cost_basement').text()) * Number(
                    //         semi_basement_farea)).toFixed(2));
                    let avg_con_cost_saleable_area = total_construction_cost /
                        total_saleable_area_of_rfpl_sft;



                    $('#avg_con_cost_saleable_area').text(avg_con_cost_saleable_area
                        .toLocaleString(undefined, {
                            minimumFractionDigits: 2
                            , maximumFractionDigits: 2
                        }));

                    $('#avg_con_cost_saleable_area_full').val(Number(avg_con_cost_saleable_area));

                    $('#avg_con_cost_per_sft').text(avg_con_cost_saleable_area
                        .toLocaleString(undefined, {
                            minimumFractionDigits: 2
                            , maximumFractionDigits: 2
                        }));
                    
                    

                    let margin = ebit / total_sales_rev * 100
                    $('#margin').text(margin.toFixed(2));
                    $('#mar_gin').text(margin.toFixed(2));
                    let roi = ebit / total_cost * 100;
                    $('#roi').text(roi.toFixed(2));
                    $('#r_o_i').text(roi.toFixed(2));
                    $('#bep').text((total_cost / total_saleable_area_of_rfpl_sft)
                        .toLocaleString(
                            undefined, {
                                minimumFractionDigits: 2
                                , maximumFractionDigits: 2
                            }));
                    $('#bep_full').val(Number(total_cost / total_saleable_area_of_rfpl_sft));

                });


                return false;
            }
        });
        
    });



    // function for getting subStructure total
    // function getSubStructureTotal() {
    //     let location_id = $("#location_id").val();
    //     let url = '{{ url('scj / getSubStructureTotal ') }}/' + location_id;

    //     $.getJSON(url, function(items) {
    //         $('#service_pile_cost').text(items.service_pile_cost);
    //         $('#permission_fees_and_otherCost').text(items.other_costs);
    //         $('#construction_cost_floor').text(items.ConstructionCostFloor);
    //         $('#construction_cost_basement').text(items.ConstructionCostBasement);
    //     });
    // }

    /*calculation related with individual change*/
    $('#land_size_input').on('change', function() {
        $('.land_size').text($(this).val());
        total_additional_area_for_other_balcony();
        semi_basement_floor_area();
        total_buildup_area_as_far();
        total_bonus_saleable_area();
        total_ground_floor_area();
        total_builtup_area();
        total_saleable_area();
        total_saleable_area_of_rfpl_sft();
        maximum_ground_coverage_sft()
        typical_floor_area_with_bonus_far();
        land_payment_per_katha_bdy_lac();
        total_number_of_parking();
        overhead();
        reg_cost_tk();
        total_sales_rev_form_far_area();
        total_sales_rev_from_bonus_far_area();
        sales_rev_from_parking_and_utility();

        total_sales_rev();
        approx_per_apt();

        construction_cost_floor();
        total_construction_cost();
        total_cost_before_financial_cost();
        total_cost();
        ebit();
        avg_con_cost_buildup_area();
        avg_con_cost_saleable_area();
        margin();
        roi_bep();
        minimum_floor();
        $("#submit_btn").prop("disabled", false);
    })

    $('#proposed_mgc_input').on('change', function() {
        $('#proposed_mgc').text($(this).val()+'%');
        maximum_ground_coverage_sft();
        minimum_floor();
        $("#submit_btn").prop("disabled", false);
    })

    $('#sales_revenue_input').on('change', function() {
        $('#sales_revenue').text($(this).val());
        $('#sales_revenue_full').val($(this).val());
        total_sales_rev_form_far_area();
        total_sales_rev_from_bonus_far_area();
        total_sales_rev();
        $("#submit_btn").prop("disabled", false);
    })

    $('#developers_ratio_input').on('change', function() {
        $('.developers_ratio').text($(this).val());
        total_saleable_area_of_rfpl_sft()
        total_sales_rev_form_far_area();
        total_sales_rev_from_bonus_far_area();
        sales_rev_from_parking_and_utility();
        total_sales_rev();
        ebit();
        avg_con_cost_saleable_area();
        margin();
        roi_bep();
        $("#submit_btn").prop("disabled", false);
    })

    $('#total_far_input').on('change', function() {
        $('#total_far').text($(this).val());
        total_buildup_area_as_far();
        total_bonus_saleable_area();
        total_builtup_area();
        total_saleable_area();
        total_saleable_area_of_rfpl_sft();
        typical_floor_area_with_bonus_far()
        total_sales_rev_form_far_area();
        total_sales_rev_from_bonus_far_area();
        total_sales_rev();
        approx_per_apt()
        total_construction_cost();
        total_cost_before_financial_cost();
        ebit();
        avg_con_cost_buildup_area();
        avg_con_cost_saleable_area();
        margin();
        roi_bep();
        minimum_floor();
        $("#submit_btn").prop("disabled", false);
    })

    $('#total_basement_floor_input').on('change', function() {
        $('#total_basement_floor').text($(this).val());
        semi_basement_floor_area();
        total_builtup_area();
        total_number_of_parking();
        sales_rev_from_parking_and_utility();
        total_construction_cost();
        total_cost_before_financial_cost();
        total_cost();
        total_sales_rev();
        ebit();
        avg_con_cost_buildup_area();
       
        margin();
        roi_bep();
        $("#submit_btn").prop("disabled", false);
    })

    $('#parking_area_per_car_input').on('change', function() {
        $('#parking_area_per_car').text($(this).val());
        total_number_of_parking();
        $("#submit_btn").prop("disabled", false);
    })


    $('#building_front_length_input').on('change', function() {
        $('#building_front_length').text($(this).val());
        total_additional_area_for_front_balcony();
        $("#submit_btn").prop("disabled", false);
    })

    $('#fire_stair_area_input').on('change', function() {
        $('#fire_stair_area').text($(this).val());
        total_fire_stair_area();
        $("#submit_btn").prop("disabled", false);
    })

    $('#parking_number_input').on('change', function() {
        $('#parking_number').text($(this).val());
        $('#parking_number_full').val($(this).val());
        total_parking_area = $(this).val();
        total_number_of_parking();
        sales_rev_from_parking_and_utility();
        total_sales_rev();
        ebit();
        avg_con_cost_buildup_area();
        avg_con_cost_saleable_area();
        margin();
        roi_bep();
        minimum_floor()
        $("#submit_btn").prop("disabled", false);
    })


    function total_fire_stair_area() {

        let actual_floor = Number($('#floor_number').text());
        let fire_stair_area = Number($('#fire_stair_area').text());
        let total_fire_stair_area = actual_floor * fire_stair_area * (actual_floor >= 9)
        $('#total_fire_stair_area').text(total_fire_stair_area.toLocaleString(
            undefined, {
                minimumFractionDigits: 2
                , maximumFractionDigits: 2
            }));

        $('#total_fire_stair_area_full').val(total_fire_stair_area);

    }
   
    function total_additional_area_for_front_balcony() {
        let actual_floor = Number($('#floor_number').text());
        let building_front_length = Number($('#building_front_length').text());
        $('#total_additional_area_for_front_balcony').text((building_front_length *
                    0.30 * 3.28 * actual_floor).toLocaleString(
                    undefined, {
                        minimumFractionDigits: 2
                        , maximumFractionDigits: 2
                    }));
                $('#total_additional_area_for_front_balcony_full').val((building_front_length * 0.30 * 3.28 * actual_floor));

    }


    function total_additional_area_for_other_balcony() {
        let land_size = Number($('.land_size').first().text());
        let far = Number($('#total_far').text());
        $('#total_additional_area_for_other_balcony').text((far * land_size * 720 * 0.025)
            .toLocaleString(
                undefined, {
                    minimumFractionDigits: 2
                    , maximumFractionDigits: 2
                }));
    }

    function semi_basement_floor_area() {
        let land_size = Number($('.land_size').first().text());
        let total_basement_floor = Number($('#total_basement_floor').text());
        let floor_area_far_fre = Number($('#floor_area_far_free').val());
        let basement_and_land_sft = total_basement_floor * land_size * 720;
        let semi_basement_floor_area = basement_and_land_sft * floor_area_far_fre / 100;
        $('#semi_basement_floor_area').text(semi_basement_floor_area.toLocaleString(
            undefined, {
                minimumFractionDigits: 2
                , maximumFractionDigits: 2
            }));
        $('#semi_basement_floor_area_full').val(semi_basement_floor_area);
    }

    function total_buildup_area_as_far() {

        let far = Number($('#total_far').text());
        let land_size = Number($('.land_size').first().text());
        var total_buildup_area_as_far = far * land_size * 720;
        $('#total_buildup_area_as_far').text(total_buildup_area_as_far.toLocaleString(
            undefined, {
                minimumFractionDigits: 2
                , maximumFractionDigits: 2
            }));
        $('#total_buildup_area_as_far_full').val(total_buildup_area_as_far);
    }


    function total_bonus_saleable_area() {
        let far = Number($('#total_far').text());
        let land_size = Number($('.land_size').first().text());
        let bonus_saleable_area = Number($('#bonus_saleable_area').val());
        let total_bonus_saleable_area = far * land_size * 720 * bonus_saleable_area / 100;
        $('#total_bonus_saleable_area').text(total_bonus_saleable_area.toLocaleString(
            undefined, {
                minimumFractionDigits: 2
                , maximumFractionDigits: 2
            }));
        $('#total_bonus_saleable_area_full').val(total_bonus_saleable_area);
    }

     function total_ground_floor_area() {


        let ground_floor_sft = Number($('#ground_floor_sft').val());
        let land_size = Number($('.land_size').first().text());
        let developers_ratio = Number($('.developers_ratio').first().text());
        let actual_mgc = Number($('#proposed_mgc').text().split('%')[0]);
        let floor_area_far_fre = Number($('#floor_area_far_free').val());
        if(ground_floor_sft > 0) {
                    utilization = (ground_floor_sft / developers_ratio / 100) / (land_size * 720 * actual_mgc) * 100;
                } else {
                    utilization = 0;
                }
        let total_ground_floor_area = (Number(land_size) * 720 * Number(floor_area_far_fre) / 100) - (utilization / 100 * land_size * 720 * actual_mgc / 100);
        $('#far_utilization_mgc').text(utilization + '%');
        $('#far_utilization_mgc_input').val(utilization);
        $('#ground_floor_area').text(total_ground_floor_area.toFixed(2));
        $('#ground_floor_area_full').val(total_ground_floor_area);

     }


     function total_builtup_area() {
                let floor_area_far_fre = Number($('#semi_basement_floor_area_full').val());
                let total_ground_floor_area = Number($('#ground_floor_area_full').val());
                let total_buildup_area_as_far = Number($('#total_buildup_area_as_far_full').val());
                let total_bonus_saleable_area = Number($('#total_bonus_saleable_area_full').val());
                var total_builtup_area = Number(floor_area_far_fre) + Number(total_ground_floor_area) + Number(total_buildup_area_as_far) + Number(total_bonus_saleable_area);
                
                $('#total_builtup_area').text(total_builtup_area.toLocaleString(undefined, {
                    minimumFractionDigits: 2
                    , maximumFractionDigits: 2
                }));

                $('#total_builtup_area_full').val(total_builtup_area);

                $('#total_builtup_area_sft').text(total_builtup_area.toLocaleString(undefined, {
                    minimumFractionDigits: 2
                    , maximumFractionDigits: 2
                }));

                let cons_t_area = Number(total_ground_floor_area) + Number(total_bonus_saleable_area) + Number(total_buildup_area_as_far);

                $('#cons_total_area').val(cons_t_area);


        }


    function total_saleable_area() {
                let t_buildup_area_as_far = Number($('#total_buildup_area_as_far_full').val());
                let t_bonus_saleable_area = Number($('#total_bonus_saleable_area_full').val());

                let total_saleable_area = Number(t_buildup_area_as_far) + Number(t_bonus_saleable_area);

                $('#total_saleable_area').text(total_saleable_area.toLocaleString(undefined, {
                    minimumFractionDigits: 2
                    , maximumFractionDigits: 2
                }));

                $('#total_saleable_area_full').val(total_saleable_area);
    }

    function total_saleable_area_of_rfpl_sft() {

                let t_buildup_area_as_far = Number($('#total_buildup_area_as_far_full').val());
                let t_bonus_saleable_area = Number($('#total_bonus_saleable_area_full').val());
                let rfpl_ratio = Number($('.developers_ratio').first().text());

                let total_saleable_area_of_rfpl_sft = (Number(t_buildup_area_as_far) + Number(
                    t_bonus_saleable_area)) * Number(rfpl_ratio) / 100;

                $('#total_saleable_area_of_rfpl_sft').text(total_saleable_area_of_rfpl_sft
                    .toLocaleString(
                        undefined, {
                            minimumFractionDigits: 2
                            , maximumFractionDigits: 2
                        }));

                $('#total_saleable_area_of_rfpl_sft_full').val(total_saleable_area_of_rfpl_sft);
    }


    function maximum_ground_coverage_sft() {
        let mgc = Number($('#proposed_mgc').text().split('%')[0]);
        let land_size = Number($('.land_size').first().text());
        let maximum_ground_coverage_sft = (mgc / 100) * land_size * 720;
        $('#maximum_ground_coverage_sft').text(maximum_ground_coverage_sft.toLocaleString(
            undefined, {
                minimumFractionDigits: 2
                , maximumFractionDigits: 2
            }));
        $('#maximum_ground_coverage_sft_full').val(maximum_ground_coverage_sft);
}

function typical_floor_area_with_bonus_far() {

    let t_buildup_area_as_far = Number($('#total_buildup_area_as_far_full').val());
    let t_bonus_saleable_area = Number($('#total_bonus_saleable_area_full').val());
    let land_size = Number($('.land_size').first().text());
    let far_utili_mgc = Number($('#far_utilization_mgc').text().split('%')[0]);
    let actual_mgc = Number($('#proposed_mgc').text().split('%')[0]);
    let actual_floor = Number($('#floor_number').text());

    let typical_floor_area_with_bonus_far = ((t_buildup_area_as_far - (far_utili_mgc / 100) * (actual_mgc / 100) * land_size * 720) / actual_floor + t_bonus_saleable_area / actual_floor);
    $('#typical_floor_area_with_bonus_far').text(typical_floor_area_with_bonus_far
        .toLocaleString(
            undefined, {
                minimumFractionDigits: 2
                , maximumFractionDigits: 2
            }));
    $('#typical_floor_area_with_bonus_far_full').val(typical_floor_area_with_bonus_far);
}

function land_payment_per_katha_bdy_lac() {
    let land_size = Number($('.land_size').first().text());
    let total_payment = Number($('#total_payment_full').val());
    let land_payment_per_katha_bdy_lac = (Number(total_payment) / Number(land_size));

    $('#land_payment_per_katha_bdy_lac').text((land_payment_per_katha_bdy_lac).toLocaleString(undefined, {
                    minimumFractionDigits: 2
                    , maximumFractionDigits: 2
                }));

    $('#land_payment_per_katha_bdy_lac_full').val((land_payment_per_katha_bdy_lac));
}

function total_number_of_parking() {

    let semi_basement_floor_area_full = Number($('#semi_basement_floor_area_full').val());
    let parking_area_per_car = Number($('#parking_area_per_car').text());
    let total_ground_floor_area = Number($('#ground_floor_area_full').val());

    let parking_number_calculated = (total_ground_floor_area / parking_area_per_car);

    $('#parking_number_calculated').text(Math.floor(parking_number_calculated));
    
    let parking_number = Number($('#parking_number_full').val());


    let total_parking_area = (parseFloat(semi_basement_floor_area_full / parking_area_per_car)) +
                    parseFloat(parking_number);
    $('#total_number_of_parking').text(Math.floor(total_parking_area));
}


function overhead(){
    let sum = Number($('#salary_and_overhead_full').val());
    let construction_life_cycle = Number($('#construction_life_cycle').text());
    let overhead = sum * construction_life_cycle * 12;
    $('#overhead').text(overhead.toLocaleString(undefined, {
                    minimumFractionDigits: 2
                    , maximumFractionDigits: 2
                }));

    $('#overhead_full').val(Number(overhead));
}

function reg_cost_tk(){
    let registration_cost = Number($('#registration_cost').text());
    let total_payment = Number($('#total_payment_full').val());
    $('#reg_cost_tk').text(registration_cost / 100 * total_payment);
}

function total_sales_rev_form_far_area(){

    let t_buildup_area_as_far = Number($('#total_buildup_area_as_far_full').val());
    let sales_revenue = Number($('#sales_revenue_full').val());
    let rfpl_ratio = Number($('.developers_ratio').first().text());

    let total_sales_rev_form_far_area = t_buildup_area_as_far * sales_revenue * rfpl_ratio / 100
                $('#total_sales_rev_from_far_area').text(total_sales_rev_form_far_area
                    .toLocaleString(undefined, {
                        minimumFractionDigits: 2
                        , maximumFractionDigits: 2
                    }));
    $('#total_sales_rev_from_far_area_full').val(Number(total_sales_rev_form_far_area));
    
}


function total_sales_rev_from_bonus_far_area(){
    let sales_revenue = Number($('#sales_revenue_full').val());
    let rfpl_ratio = Number($('.developers_ratio').first().text());
    let t_bonus_saleable_area = Number($('#total_bonus_saleable_area_full').val());

    let total_sales_rev_from_bonus_far_area = t_bonus_saleable_area * sales_revenue * Number(rfpl_ratio) / 100
    $('#total_sales_rev_from_bonus_far_area').text(total_sales_rev_from_bonus_far_area
        .toLocaleString(undefined, {
            minimumFractionDigits: 2
            , maximumFractionDigits: 2
        }));

    $('#total_sales_rev_from_bonus_far_area_full').val(Number(total_sales_rev_from_bonus_far_area));

}



 function sales_rev_from_parking_and_utility(){
     let rfpl_ratio = Number($('.developers_ratio').first().text());
     let parking_sales_revenue = Number($('#parking_sales_revenue_full').val());
     let revenue_from_parking = Number($('#revenue_from_parking').val());
    let apertment_number = Number($('.apertment_number').first().text());

     let sales_rev_parking_utility = (Number(Math.floor(total_parking_area)) *
                         Number(parking_sales_revenue) *
                         Number(rfpl_ratio) / 100) +
                     (Number(apertment_number) *
                         Number(rfpl_ratio) / 100 * revenue_from_parking);
console.log(total_parking_area,rfpl_ratio,parking_sales_revenue,revenue_from_parking,apertment_number,sales_rev_parking_utility);
    $('#sales_rev_from_parking_and_utility').text(sales_rev_parking_utility
        .toLocaleString(undefined, {
            minimumFractionDigits: 2
            , maximumFractionDigits: 2
        }));
    $('#sales_rev_from_parking_and_utility_full').val(Number(sales_rev_parking_utility));
 }

 function total_sales_rev(){
    let total_sales_rev_form_far_area = Number($('#total_sales_rev_from_far_area_full').val());
    let total_sales_rev_from_bonus_far_area = Number($('#total_sales_rev_from_bonus_far_area_full').val());
    let sales_rev_parking_utility = Number($('#sales_rev_from_parking_and_utility_full').val());

     let total_sales_rev = total_sales_rev_form_far_area +
                     total_sales_rev_from_bonus_far_area + sales_rev_parking_utility;
                 // console.log(total_sales_rev);
                 $('#total_sales_rev').text(total_sales_rev.toLocaleString(undefined, {
                     minimumFractionDigits: 2
                     , maximumFractionDigits: 2
                 }));

                 $('#total_sales_rev_full').val(Number(total_sales_rev));
 }

function approx_per_apt(){
    let total_saleable_area = Number($('#total_saleable_area_full').val());
    let apertment_number = Number($('.apertment_number').first().text());

    let approx_per_apt = (Number(total_saleable_area) / Number(apertment_number))
                $('#approx_per_apt').text(approx_per_apt.toLocaleString(undefined, {
                    minimumFractionDigits: 2
                    , maximumFractionDigits: 2
                }));

                $('#approx_per_apt_full').val(Number(approx_per_apt));
}




function construction_cost_floor(){
    let construction_cost_floor = Number($('#ConstructionCostBasement').val()) / Number($('#cons_total_area').val());
    $('#construction_cost_floor').text(construction_cost_floor
        .toLocaleString(
            undefined, {
                minimumFractionDigits: 2
                , maximumFractionDigits: 2
            }));
    $('#construction_cost_floor_full').val(Number(construction_cost_floor));
                    
}


function total_construction_cost(){
    let land_size = Number($('.land_size').first().text());
    let service_pile_cost_calculation = Number($('#service_pile_cost_full').val());
    let construction_cost_floor = Number($('#construction_cost_floor_full').val());
    let g_floor_area = Number($('#ground_floor_area_full').val());
    let t_buildup_area_as_far = Number($('#total_buildup_area_as_far_full').val());
    let t_bonus_saleable_area = Number($('#total_bonus_saleable_area_full').val());
    let construction_cost_basement = Number($('#construction_cost_basement_full').val());
    let floor_area_far_fre = Number($('#floor_area_far_free').val());

    let total_construction_cost = (land_size * 720 * service_pile_cost_calculation +
                        construction_cost_floor * (Number(g_floor_area) +
                            t_buildup_area_as_far + t_bonus_saleable_area) +
                        construction_cost_basement * floor_area_far_fre)
                        
    $('#total_construction_cost').text(total_construction_cost
        .toLocaleString(
            undefined, {
                minimumFractionDigits: 2
                , maximumFractionDigits: 2
            }));
    $('#total_construction_cost_full').val(Number(total_construction_cost));
                    
}


function total_cost_before_financial_cost(){
    let total_payment = Number($('#total_payment_full').val());
    let registration_cost = Number($('#registration_cost').text());
    let total_construction_cost = $('#total_construction_cost_full').val();
    let overhead = Number($('#overhead_full').val());
    let other_costs = Number($('#other_costs_full').val());
    let finance_cost = Number($('#finance_cost_full').val());

    let total_financial_cost = (Number(total_payment) +
                        Number(registration_cost / 100 * total_payment) +
                        Number(total_construction_cost) +
                        Number(overhead) + Number(other_costs))

    $('#total_cost_before_financial_cost').text(total_financial_cost
        .toLocaleString(
            undefined, {
                minimumFractionDigits: 2
                , maximumFractionDigits: 2
            }));
    $('#total_cost_before_financial_cost_full').val(Number(total_financial_cost));

    $('#finance_cost_as_percent').text(Math.round(Number(finance_cost) / Number(total_financial_cost) * 100).toFixed(2) + '%');

    $('#fc_as_of_total_outflow').text(Math.round(Number(finance_cost) / Number(total_financial_cost) * 100).toFixed(2) + '%');



                    
}

function total_cost(){

    let finance_cost = Number($('#finance_cost_full').val());
    let total_financial_cost = $('#total_cost_before_financial_cost_full').val();

    let total_cost = Number(finance_cost) + Number(total_financial_cost);

    $('#total_cost').text(total_cost.toLocaleString(undefined, {
        minimumFractionDigits: 2
        , maximumFractionDigits: 2
    }));

    $('#total_cost_full').val(Number(total_cost));

    $('#total_cost_bdt').text(total_cost.toLocaleString(undefined, {
        minimumFractionDigits: 2
        , maximumFractionDigits: 2
    }));


    $('#total_cost_bdt_crore').text(total_cost.toLocaleString(
        undefined, {
            minimumFractionDigits: 2
            , maximumFractionDigits: 2
        }));
                    
}

function ebit(){
    let total_sales_rev = Number($('#total_sales_rev_full').val());
    let total_cost = Number($('#total_cost_full').val());
    let ebit = total_sales_rev - total_cost;
                    $('#ebit').text(ebit.toLocaleString(
                        undefined, {
                            minimumFractionDigits: 2
                            , maximumFractionDigits: 2
                        }));

                    $('#ebit_full').val(Number(ebit));

                    $('#npbt').text(ebit.toLocaleString(
                        undefined, {
                            minimumFractionDigits: 2
                            , maximumFractionDigits: 2
                        }));

                    
}



function avg_con_cost_buildup_area(){
   let total_construction_cost = Number($('#total_construction_cost_full').val());
   let total_builtup_area = Number($('#total_builtup_area_full').val());

    $('#avg_con_cost_buildup_area').text((total_construction_cost /
                        total_builtup_area).toLocaleString(
                        undefined, {
                            minimumFractionDigits: 2
                            , maximumFractionDigits: 2
                        }));

    $('#avg_con_cost_buildup_area_full').val(Number(total_construction_cost / total_builtup_area));
}

function avg_con_cost_saleable_area(){
    let total_construction_cost = Number($('#total_construction_cost_full').val());
    let total_saleable_area_of_rfpl_sft = Number($('#total_saleable_area_of_rfpl_sft_full').val());

    let avg_con_cost_saleable_area = total_construction_cost / total_saleable_area_of_rfpl_sft;



    $('#avg_con_cost_saleable_area').text(avg_con_cost_saleable_area
        .toLocaleString(undefined, {
            minimumFractionDigits: 2
            , maximumFractionDigits: 2
        }));

    $('#avg_con_cost_saleable_area_full').val(Number(avg_con_cost_saleable_area));

    $('#avg_con_cost_per_sft').text(avg_con_cost_saleable_area
        .toLocaleString(undefined, {
            minimumFractionDigits: 2
            , maximumFractionDigits: 2
        }));
}

function margin(){
    let ebit = Number($('#ebit_full').val());
    let total_sales_rev = Number($('#total_sales_rev_full').val());
    let margin = ebit / total_sales_rev * 100
                    $('#margin').text(margin.toFixed(2));
                    $('#mar_gin').text(margin.toFixed(2));
}
                    
                    
function roi_bep(){
    let ebit = Number($('#ebit_full').val());
    let total_cost = Number($('#total_cost_full').val());
    let total_saleable_area_of_rfpl_sft = Number($('#total_saleable_area_of_rfpl_sft_full').val());
    let roi = ebit / total_cost * 100;
                    $('#roi').text(roi.toFixed(2));
                    $('#r_o_i').text(roi.toFixed(2));
                    $('#bep').text((total_cost / total_saleable_area_of_rfpl_sft)
                        .toLocaleString(
                            undefined, {
                                minimumFractionDigits: 2
                                , maximumFractionDigits: 2
                            }));
                    $('#bep_full').val(Number(total_cost / total_saleable_area_of_rfpl_sft));
}
                    

function minimum_floor(){
    let t_buildup_area_as_far = Number($('#total_buildup_area_as_far_full').val());
    let far_utili_mgc = Number($('#far_utilization_mgc').text().split('%')[0]);
    let actual_mgc = Number($('#proposed_mgc').text().split('%')[0]);
    let land_size = Number($('.land_size').first().text());
    let maximum_ground_coverage_sft = Number($('#maximum_ground_coverage_sft_full').val());
    let flr = Math.round((t_buildup_area_as_far - (far_utili_mgc/100 * actual_mgc/100*land_size*720)) / maximum_ground_coverage_sft);
    $('#minimum_number_of_floor_considering_mgs').text(flr);

    $('#minimum_number_of_floor_considering_mgs_full').val(flr);
}

$(document).ready(function(){
    $(document).on('change','#land_size_input,#developers_ratio_input,#total_far_input,#proposed_mgc_input,#total_basement_floor_input,#parking_area_per_car_input,#parking_number_input,#far_utilization_mgc_input,#sales_revenue_input',function(){
        TotalFinancialCost();
    })
})
function TotalFinancialCost(){
    let sales_revenue = $('#sales_revenue_full').val();
    let far_utili_mgc = Number($('#far_utilization_mgc').text().split('%')[0]);
    let parking_number = $('#parking_number_full').val();
    let location_id = $('#location_id').val();
    let parking_area_per_car = Number($('#parking_area_per_car').text());
    let total_basement_floor = $('#total_basement_floor').text();
    let actual_mgc = Number($('#proposed_mgc').text().split('%')[0]);
    let far = Number($('#total_far').text());
    let developers_ratio = Number($('.developers_ratio').first().text());
    let land_size = Number($('.land_size').first().text());

    $.ajax({
            url: "{{ route('getAutoFinaceData') }}",
            type: 'post',
            dataType: "json",
            data: {
                _token: CSRF_TOKEN,
                sales_revenue,
                far_utili_mgc,
                parking_number,
                parking_area_per_car,
                total_basement_floor,
                actual_mgc,
                far,
                developers_ratio,
                land_size,
                location_id
            },
            success: function(data) {
                console.log(data);
                // $("#submit_btn").prop("disabled", false);

                let land_size = Number($('.land_size').first().text());
                let service_pile_cost_calculation = data.service_pile_cost / (land_size * 720);

                $('#service_pile_cost_amount').val(Number(data.service_pile_cost));
                $('#ConstructionCostFloor').val(Number(data.ConstructionCostFloor));
                $('#ConstructionCostBasement').val(Number(data.ConstructionCostBasement));
                $('#finance_cost_hide').val(Number(data.finance_cost));
                $('#other_costs_hide').val(Number(data.other_costs));
                $('#inflow').val(Number(data.inflow));
                $('#outflow').val(Number(data.outflow));

                $('#service_pile_cost').text(service_pile_cost_calculation
                    .toLocaleString(
                        undefined, {
                            minimumFractionDigits: 2
                            , maximumFractionDigits: 2
                        }));
                $('#service_pile_cost_full').val(Number(service_pile_cost_calculation));

                $('#permission_fees_and_otherCost').text(Number(data.other_costs)
                    .toLocaleString(
                        undefined, {
                            minimumFractionDigits: 2
                            , maximumFractionDigits: 2
                        }));

                $('#other_costs').text(Number(data.other_costs).toLocaleString(
                    undefined, {
                        minimumFractionDigits: 2
                        , maximumFractionDigits: 2
                    }));
                $('#other_costs_full').val(Number(data.other_costs));
                let cons_t_area =   Number($('#cons_total_area').val());
                // console.log(cons_total_area)
                let construction_cost_floor = data.ConstructionCostFloor / cons_t_area;
                let construction_cost_basement = data.ConstructionCostBasement;
                $('#construction_cost_floor').text(construction_cost_floor
                    .toLocaleString(
                        undefined, {
                            minimumFractionDigits: 2
                            , maximumFractionDigits: 2
                        }));
                $('#construction_cost_floor_full').val(Number(construction_cost_floor));

                $('#construction_cost_basement').text(construction_cost_basement
                    .toLocaleString(
                        undefined, {
                            minimumFractionDigits: 2
                            , maximumFractionDigits: 2
                        }));

                $('#construction_cost_basement_full').val(Number(construction_cost_basement));

                $('#finance_cost').text(data.finance_cost.toLocaleString(undefined, {
                    minimumFractionDigits: 2
                    , maximumFractionDigits: 2
                }));


                $('#finance_cost_full').val(Number(data.finance_cost));


              
                total_construction_cost();
                total_cost_before_financial_cost();
                total_cost();
                ebit();
                avg_con_cost_buildup_area();
                avg_con_cost_saleable_area();
                margin();
                roi_bep();
                minimum_floor();
                return false;
            }
        });
}
$(function() { 
            document.addEventListener("keydown", function(event) {
                if (event.key === "Enter") {
                    event.preventDefault();
                }
            });
            
        }) // Document.Ready
    /**/

</script>
@endsection
