<?php

namespace App\Http\Controllers\BD;

use App\BD\BdFeasiRncCal;
use App\BD\ProjectLayout;
use App\BD\BdFeasiFinance;
use App\BD\BdFeasiRevenue;
use App\BD\BdFeasibilityCtc;
use App\BD\BdFeasRncPercent;
use App\BD\BdLeadGeneration;
use Illuminate\Http\Request;
use App\BD\BdFeasiPerticular;
use App\BD\BdFeasiRncCalRate;
use App\BD\BdFeasibilityEntry;
use App\BD\BdFeasiFessAndCost;
use App\BD\BdFeasiRevenueDetail;
use Illuminate\Support\Facades\DB;
use App\BD\BdFeasiFessAndCostDetail;
use App\Boq\Configurations\BoqFloor;
use App\Http\Controllers\Controller;
use App\Services\BdFeasiInflowOutflow;
use Illuminate\Database\QueryException;
use App\Http\Requests\BD\BdFeasibilityEntryRequest;
use Exception;

class BdFeasibilityEntryController extends Controller
{
    private $InflowAndOutflowService;


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:bd-Feasibility-entry-view|bd-Feasibility-entry-create|bd-Feasibility-entry-edit|bd-Feasibility-entry-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:bd-Feasibility-entry-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:bd-Feasibility-entry-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:bd-Feasibility-entry-delete', ['only' => ['destroy']]);
        $this->InflowAndOutflowService = new BdFeasiInflowOutflow();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $locations = BdLeadGeneration::pluck('land_location', 'id');
        return view('bd.feasibility_entry.index', compact('locations'));
    }


    public function locations()
    {
        $formType = 'create';
        $locations = BdLeadGeneration::orderBy('id', 'desc')->get();
        return view('bd.feasibility_entry.locations', compact('locations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($location_id)
    {
        $formType = 'create';
        $previous_data = BdFeasibilityEntry::where('location_id', $location_id)->get();
        $location = BdLeadGeneration::where('id', $location_id)->pluck('land_location', 'id');
        return view('bd.feasibility_entry.create', compact('formType', 'location', 'previous_data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BdFeasibilityEntryRequest $request)
    {
        try {
            $request_data   = $request->only('location_id', 'total_payment', 'rfpl_ratio', 'registration_cost', 'adjacent_road_width', 'parking_area_per_car', 'building_front_length',/*'floor_number',*/ 'fire_stair_area', 'construction_life_cycle', 'parking_sales_revenue', 'apertment_number', 'floor_area_far_free', 'bonus_saleable_area', 'parking_rate', 'basement_no', 'parking_number', 'dev_plan');

            $request_data['user_id']          = auth()->id();

            DB::transaction(function () use ($request_data, $request) {
                BdFeasibilityEntry::updateOrCreate(
                    ['location_id' => $request->location_id],
                    $request_data
                );
            });
            return redirect()->route('feasibility-entry.index')->with('message', 'Data has been inserted successfully');
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function feasibilityCopy()
    {
        $oldFeasibility = BdLeadGeneration::whereHas('finance')->get()->pluck('full_location', 'id');
        $newFeasibility = BdLeadGeneration::whereDoesntHave('finance')->get()->pluck('full_location', 'id');
        return view('bd.feasibility_entry.copy', compact('oldFeasibility', 'newFeasibility'));
    }



    public function feasibilityCopyStore(Request $request)
    {
        try {
            $oldFeasibility = $request->copy_form;
            $newFeasibility = $request->copy_to;
            $userId = auth()->user()->id;
            $lead = BdLeadGeneration::where('id', $newFeasibility)->first();
            $far = ProjectLayout::with('road_details')->where('bd_lead_location_id', $oldFeasibility)->first([
                'id', 'proposed_road_width', 'modified_far', 'total_far', 'proposed_mgc', 'total_basement_floor',
                'front_verenda_feet', 'grand_road_sft', 'proposed_story', 'grand_far_sft'
            ]);
            $far['bd_lead_location_id'] = $newFeasibility;

            $basicEntry = BdFeasibilityEntry::where('location_id', $oldFeasibility)->first([
                'total_payment', 'rfpl_ratio', 'registration_cost', 'adjacent_road_width', 'parking_area_per_car',
                'building_front_length', 'floor_number', 'fire_stair_area', 'parking_number', 'construction_life_cycle', 'parking_sales_revenue', 'semi_basement_floor_area', 'ground_floor_area',
                'apertment_number', 'floor_area_far_free', 'bonus_saleable_area', 'costing_value', 'parking_rate'
            ]);
            $basicEntry['location_id'] = $newFeasibility;
            $basicEntry['user_id'] = $userId;

            $feesParticulars = BdFeasiFessAndCost::with('BdFeasiFessAndCostDetail')->where('location_id', $oldFeasibility)->get();

            $CTC = BdFeasibilityCtc::with('BdFeasiCtcDetail')->where('location_id', $oldFeasibility)
                ->first(['id', 'grand_total_payable', 'grand_total_effect']);
            $CTC['location_id'] = $newFeasibility;
            $CTC['user_id'] = $userId;

            $revenue = BdFeasiRevenue::with('BdFeasiRevenueDetail')->where('location_id', $oldFeasibility)
                ->first();
            $revenue['location_id'] = $newFeasibility;
            $revenue['user_id'] = $userId;

            $financeRate = BdFeasRncPercent::where('bd_lead_generation_id', $oldFeasibility)->first();
            $financeRate['bd_lead_generation_id'] = $newFeasibility;

            $financeRateCalculation = BdFeasiRncCal::where('bd_lead_generation_id', $oldFeasibility)->first();
            $financeRateCalculation['bd_lead_generation_id'] = $newFeasibility;

            $finance = BdFeasiFinance::where('location_id', $oldFeasibility)->first();
            $finance['location_id'] = $newFeasibility;
            $finance['user_id'] = $userId;

            //            dd($finance->toArray());
            DB::transaction(function () use ($newFeasibility, $lead, $far, $basicEntry, $feesParticulars, $userId, $CTC, $revenue, $financeRate, $financeRateCalculation, $finance) {
                if (empty($lead->projectLayout)) {
                    $layout = ProjectLayout::create($far->toArray());
                    $layout->road_details()->createMany($far->road_details->toArray());
                }
                if (empty($lead->feasibility)) {
                    BdFeasibilityEntry::create($basicEntry->toArray());
                }

                if (empty($lead->feesParticular)) {
                    foreach ($feesParticulars as $feesParticular) {
                        $feesParticularArr = [];
                        $feesAndCost = BdFeasiFessAndCost::create(['location_id' => $newFeasibility, 'user_id' => $userId]);
                        foreach ($feesParticular->BdFeasiFessAndCostDetail as $costDetail) {
                            $feesParticularArr[] = [
                                'headble_id' => $costDetail->headble_id,
                                'headble_type' => $costDetail->headble_type,
                                'rate' => $costDetail->rate,
                                'quantity' => $costDetail->quantity,
                                'remarks' => $costDetail->remarks,
                            ];
                        }
                        $feesAndCost->BdFeasiFessAndCostDetail()->createMany($feesParticularArr);
                    }
                }
                if (empty($lead->ctc)) {
                    $ctcData = BdFeasibilityCtc::create($CTC->toArray());
                    $ctcData->BdFeasiCtcDetail()->createMany($CTC->BdFeasiCtcDetail->toArray());
                }
                if (empty($lead->revenue)) {
                    $revenueData = BdFeasiRevenue::create($revenue->toArray());
                    $revenueData->BdFeasiRevenueDetail()->createMany($revenue->BdFeasiRevenueDetail->toArray());
                }
                if (empty($lead->rncPercent)) {
                    $rncPercentData = BdFeasRncPercent::create($financeRate->toArray());
                    $rncPercentData->BdFeasRncPercentDetail()->createMany($financeRate->BdFeasRncPercentDetail->toArray());
                }
                if (empty($lead->rncCalculation)) {
                    $rncCalculation = BdFeasiRncCal::create($financeRateCalculation->toArray());
                    $rncCalculation->BdFeasRncCalCost()->create($financeRateCalculation->BdFeasRncCalCost->toArray());
                    $rncCalculation->BdFeasRncCalRate()->create($financeRateCalculation->BdFeasRncCalRate->toArray());
                    $rncCalculation->BdFeasRncCalSale()->create($financeRateCalculation->BdFeasRncCalSale->toArray());
                }
                if (empty($lead->finance)) {
                    $financeData = BdFeasiFinance::create($finance->toArray());
                    $financeData->financeDetails()->createMany($finance->financeDetails->toArray());
                }
            });
            //            dd();
            return redirect()->route('feasibility-entry.index')->with('message', 'Data has been Copied successfully');
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function calculateFinance()
    {
        $data1 = $this->InflowAndOutflowService->getTotalCostwithoutInterest(70);
        $data = BdFeasiFinance::with('financeDetails')->where('location_id', 70)->get();
        $rate = $data1->original['rnc']->BdFeasRncCalRate;
        $cost = $data1->original['rnc']->BdFeasRncCalCost;
        $rate_array = [
            $rate->row_1st, $rate->row_2nd, $rate->row_3rd, $rate->row_4th, $rate->row_5th, $rate->row_6th, $rate->row_7th, $rate->row_8th, $rate->row_9th, $rate->row_10th
        ];
        $cost_array = [
            $cost->row_1st, $cost->row_2nd, $cost->row_3rd, $cost->row_4th, $cost->row_5th, $cost->row_6th, $cost->row_7th, $cost->row_8th, $cost->row_9th, $cost->row_10th
        ];

        $cumulitive_int = 0;
        $prev_cumulitive = 0;
        $stored_cumulitive = 0;
        $total_loop = (ceil($data1->original['construction_life']) + 1) * 12;

        for ($index = 0; $index < $total_loop; $index++) {
            $item = $data->first()->financeDetails[$index];
            $yr = floor(($index) / 12);
            $inflow = $data1->original['inflow'] * $rate_array[$yr] / 100 / 12;
            $outflow = $data1->original['outflow'] * $cost_array[$yr] / 100 / 12 + $item->amount;
            $net = number_format($inflow, 2, ".", "") - number_format($outflow, 2, ".", "");

            $rate = $data->first()->rate;
            $interest = 0;

            if ($index > 0) {
                if (($net) / 2 + ($prev_cumulitive) < 0) {
                    $interest = number_format(((-1 * (($net) / 2 + ($prev_cumulitive))) * $rate / 12 / 100), 2, ".", "");
                }
            } else {
                if ($net < 0) {
                    $interest = number_format(((-1 * ($net)) / 2 * $rate / 12 / 100), 2, ".", "");
                }
            }

            $cumulitive_int += $interest;
            $prev_cumulitive += $net;
            if (!(($index + 1) % 3)) {
                $prev_cumulitive -= $stored_cumulitive + $interest;
                $stored_cumulitive = 0;
            } else {
                $stored_cumulitive += $interest;
            }
        }

        // $data->first()->financeDetails->map(function ($item, $index) use (
        //     $rate_array,
        //     $cost_array,
        //     $data1,
        //     $data,
        //     &$prev_cumulitive,
        //     &$stored_cumulitive,
        //     &$cumulitive_int,
        // ) {
        //     $yr = floor(($index) / 12);

        //     $inflow = $data1->original['inflow'] * $rate_array[$yr] / 100 / 12;
        //     $outflow = $data1->original['outflow'] * $cost_array[$yr] / 100 / 12 + $item->amount;
        //     $net = number_format($inflow, 2, ".", "") - number_format($outflow, 2, ".", "");

        //     $rate = $data->first()->rate;
        //     $interest = 0;

        //     if ($index > 0) {
        //         if (($net) / 2 + ($prev_cumulitive) < 0) {
        //             $interest = number_format(((-1 * (($net) / 2 + ($prev_cumulitive))) * $rate / 12 / 100), 2, ".", "");
        //         }
        //     } else {
        //         if ($net < 0) {
        //             $interest = number_format(((-1 * ($net)) / 2 * $rate / 12 / 100), 2, ".", "");
        //         }
        //     }

        //     $cumulitive_int += $interest;
        //     $prev_cumulitive += $net;
        //     if (!(($index + 1) % 3)) {
        //         $prev_cumulitive -= $stored_cumulitive + $interest;
        //         $stored_cumulitive = 0;
        //     } else {
        //         $stored_cumulitive += $interest;
        //     }
        // });


        return [number_format($cumulitive_int, 2, ".", ""), number_format($data->first()->total_interest, 2, ".", "")];
    }



    public function getAutoFinaceData(Request $request)
    {


        $data1 = $this->InflowAndOutflowService->getTotalCostwithoutInterest($request->location_id, $request->actual_mgc, $request->developers_ratio, $request->far, $request->far_utili_mgc, $request->land_size, $request->parking_area_per_car, $request->parking_number, $request->sales_revenue, $request->total_basement_floor);
        $data = BdFeasiFinance::with('financeDetails')->where('location_id', $request->location_id)->get();
        $rate = $data1->original['rnc']->BdFeasRncCalRate;
        $cost = $data1->original['rnc']->BdFeasRncCalCost;
        $rate_array = [
            $rate->row_1st, $rate->row_2nd, $rate->row_3rd, $rate->row_4th, $rate->row_5th, $rate->row_6th, $rate->row_7th, $rate->row_8th, $rate->row_9th, $rate->row_10th
        ];
        $cost_array = [
            $cost->row_1st, $cost->row_2nd, $cost->row_3rd, $cost->row_4th, $cost->row_5th, $cost->row_6th, $cost->row_7th, $cost->row_8th, $cost->row_9th, $cost->row_10th
        ];

        $cumulitive_int = 0;
        $prev_cumulitive = 0;
        $stored_cumulitive = 0;


        $total_loop = (ceil($data1->original['construction_life']) + 1) * 12;
        for ($index = 0; $index < $total_loop; $index++) {
            $item = $data->first()->financeDetails[$index];
            $yr = floor(($index) / 12);
            $inflow = $data1->original['inflow'] * $rate_array[$yr] / 100 / 12;
            $outflow = $data1->original['outflow'] * $cost_array[$yr] / 100 / 12 + $item->amount;
            $net = number_format($inflow, 2, ".", "") - number_format($outflow, 2, ".", "");

            $rate = $data->first()->rate;
            $interest = 0;

            if ($index > 0) {
                if (($net) / 2 + ($prev_cumulitive) < 0) {
                    $interest = number_format(((-1 * (($net) / 2 + ($prev_cumulitive))) * $rate / 12 / 100), 2, ".", "");
                }
            } else {
                if ($net < 0) {
                    $interest = number_format(((-1 * ($net)) / 2 * $rate / 12 / 100), 2, ".", "");
                }
            }

            $cumulitive_int += $interest;

            $prev_cumulitive += $net;

            if (!(($index + 1) % 3)) {
                $prev_cumulitive -= $stored_cumulitive + $interest;
                $stored_cumulitive = 0;
            } else {
                $stored_cumulitive += $interest;
            }
        }
        if ($prev_cumulitive < 0) {
            for ($index = $total_loop; $index < 108; $index++) {
                $net = 0;
                $interest = 0;

                if (($prev_cumulitive) < 0) {
                    $interest = number_format(((-1 * (($prev_cumulitive))) * $rate / 12 / 100), 2, ".", "");
                }

                $cumulitive_int += $interest;

                $prev_cumulitive += $net;

                if (!(($index + 1) % 3)) {
                    $prev_cumulitive -= $stored_cumulitive + $interest;
                    $stored_cumulitive = 0;
                } else {
                    $stored_cumulitive += $interest;
                }
            }
        }
        return response()->json(
            [
                'service_pile_cost'   =>    $data1->original['fees_and_cost_details'],
                'other_costs'               =>  $data1->original['other_costs'],
                'ConstructionCostFloor'     =>   $data1->original['ConstructionCostFloor'],
                'ConstructionCostBasement'  =>  $data1->original['ConstructionCostBasement'] ? $data1->original['ConstructionCostBasement'] : 0,
                'finance_cost'              => number_format($cumulitive_int, 2, ".", ""),
                'inflow'              => $data1->original['inflow'],
                'outflow'              => $data1->original['outflow'],

            ]
        );
    }



    public function bdFesibilityUpdateData(Request $request)
    {
        try{
            DB::beginTransaction();
            $new_floor = ceil(($request->buildup_area - ($request->utilization) * ($request->mgc / 100) * $request->land_size * 720) / (($request->mgc) / 100 * $request->land_size * 720));
            $cost_data = [];
            $rev_data = [];
            $rnc = BdFeasiRncCal::with('BdFeasRncCalCost', 'BdFeasRncCalRate', 'BdFeasRncCalSale')
                ->where('bd_lead_generation_id', $request->location_id)
                ->first();
    
    
            /*****/
    
            $data = BdFeasiFinance::with('financeDetails')->where('location_id', $request->location_id)->get();
            $rate = $rnc->BdFeasRncCalRate;
            $cost = $rnc->BdFeasRncCalCost;
            $rate_array = [
                $rate->row_1st, $rate->row_2nd, $rate->row_3rd, $rate->row_4th, $rate->row_5th, $rate->row_6th, $rate->row_7th, $rate->row_8th, $rate->row_9th, $rate->row_10th
            ];
            $cost_array = [
                $cost->row_1st, $cost->row_2nd, $cost->row_3rd, $cost->row_4th, $cost->row_5th, $cost->row_6th, $cost->row_7th, $cost->row_8th, $cost->row_9th, $cost->row_10th
            ];
    
            $cumulitive_int = 0;
            $prev_cumulitive = 0;
            $stored_cumulitive = 0;
            $financeData = [];
    
            $total_loop = (ceil($request->construction_life) + 1) * 12;
            for ($index = 0; $index < $total_loop; $index++) {
                $item = $data?->first()?->financeDetails[$index] ?? 0;
                $yr = floor(($index) / 12);
                $inflow = $request->inflow * $rate_array[$yr] / 100 / 12;
                $outflow = $request->outflow * $cost_array[$yr] / 100 / 12 + ($item?->amount ?? 0);
                $net = number_format($inflow, 2, ".", "") - number_format($outflow, 2, ".", "");
    
                $rate = $data->first()->rate;
                $interest = 0;
    
                if ($index > 0) {
                    if (($net) / 2 + ($prev_cumulitive) < 0) {
                        $interest = number_format(((-1 * (($net) / 2 + ($prev_cumulitive))) * $rate / 12 / 100), 2, ".", "");
                    }
                } else {
                    if ($net < 0) {
                        $interest = number_format(((-1 * ($net)) / 2 * $rate / 12 / 100), 2, ".", "");
                    }
                }
    
                $cumulitive_int += $interest;
    
                $prev_cumulitive += $net;
    
                if (!(($index + 1) % 3)) {
                    $prev_cumulitive -= $stored_cumulitive + $interest;
                    $stored_cumulitive = 0;
                } else {
                    $stored_cumulitive += $interest;
                }
                $financeData[] = [
                    'schedule_no' => $index + 1,
                    'month' => $index + 1,
                    'amount' => $item->amount ?? 0,
                    'outflow_rate' => number_format(($cost_array[$yr] / 4), 2, ".", ""),
                    'inflow_rate' =>  number_format(($rate_array[$yr] / 4), 2, ".", ""),
                    'outflow' => $outflow,
                    'inflow' => $inflow,
                    'net' =>  $net,
                    'interest' => $interest,
                    'cumulitive' => $prev_cumulitive
                ];
            }
            if ($prev_cumulitive < 0) {
                for ($index = $total_loop; $index < 108; $index++) {
                    if ($prev_cumulitive < 0) {
                        $net = 0;
                        $interest = 0;
    
                        if (($prev_cumulitive) < 0) {
                            $interest = number_format(((-1 * (($prev_cumulitive))) * $rate / 12 / 100), 2, ".", "");
                        }
    
                        $cumulitive_int += $interest;
    
                        $prev_cumulitive += $net;
    
                        if (!(($index + 1) % 3)) {
                            $prev_cumulitive -= $stored_cumulitive + $interest;
                            $stored_cumulitive = 0;
                        } else {
                            $stored_cumulitive += $interest;
                        }
    
                        $financeData[] = [
                            'schedule_no' => $index + 1,
                            'month' => $index + 1,
                            'amount' => $item->amount ?? 0,
                            'outflow_rate' => 0,
                            'inflow_rate' =>  0,
                            'outflow' => 0,
                            'inflow' => 0,
                            'net' =>  $net,
                            'interest' => $interest,
                            'cumulitive' => $prev_cumulitive
                        ];
                    }
                }
            }
    
            $data->first()->total_interest = $cumulitive_int;
            $data->first()->inflow_amount = $request->inflow;
            $data->first()->outflow_amount = $request->outflow;
            $data->first()->save();
            $data->first()->financeDetails()->delete();
            $data->first()->financeDetails()->createMany($financeData);
    
    
            /***/
            $permission_cost = BdFeasiFessAndCostDetail::with('headable')
                ->whereHas('BdFeasiFessAndCost', function ($query) use ($request) {
                    return $query->where('location_id', $request->location_id);
                })
                ->get()
                ->map(function ($item) use ($request, &$cost_data) {
    
                    if ($item->headable->dependency_type == 1) {
                        $quantity = $request->total_sales;
                    } elseif ($item->headable->dependency_type == 2) {
                        $quantity = $request->buildup_area + $request->bonus_saleable_area + $request->ground_floor_area + $request->semi_basement_floor_area;
                    } elseif ($item->headable->dependency_type == 3) {
                        $quantity = $request->buildup_area + $request->bonus_saleable_area + $request->ground_floor_area;
                    } elseif ($item->headable->dependency_type == 4) {
                        $quantity = $request->semi_basement_floor_area;
                    } elseif ($item->headable->dependency_type == 5) {
                        $quantity = $request->land_size;
                    } else {
                        $quantity = $item->quantity;
                    }
                    $cost_data[] = [
                        'fess_and_cost_id' => $item->fess_and_cost_id,
                        'headble_id' => $item->headble_id,
                        'headble_type'  => $item->headble_type,
                        'calculation' => $item->calculation,
                        'rate' => $item->rate,
                        'quantity' => $quantity,
                        'remarks'  => $item->remarks,
                        'created_at' => now()
                    ];
                });
    
            BdFeasiFessAndCostDetail::with('headable')
                ->whereHas('BdFeasiFessAndCost', function ($query) use ($request) {
                     return $query->where('location_id', $request->location_id);
                 })
                 ->delete();
            BdFeasiFessAndCostDetail::insert($cost_data);
            $reven = BdFeasiRevenue::where('location_id', $request->location_id)->get()->first();
            $total_floor_sft = $request->saleable_area;
            if($reven->ground_floor_sft > 0){
               $total_floor_sft = $request->saleable_area - $reven->ground_floor_sft;
            }
            $floors = BoqFloor::
                where('name', 'LIKE', "%Floor%")
                ->get(['id','name'])
                ->toArray();
            $individual_sft = number_format(($total_floor_sft / $new_floor), 8, ".", "");
            $total_rev = 0;
            for ($x = 1; $x <= $new_floor; $x++) {
                 $rev_data[] = [
                     'floor_id' => $floors[$x]['id'],
                     'floor_sft'  => $individual_sft,
                     'rate' => $request->sales_rev_per_floor,
                     'total' => $request->sales_rev_per_floor * $individual_sft
                 ];
                 $total_rev += ($request->sales_rev_per_floor * $individual_sft);
               }
             if($reven->ground_floor_sft > 0){
                 $rev_data[] = [
                     'floor_id' => $floors[0]['id'],
                     'floor_sft'  => $reven->ground_floor_sft,
                     'rate' => $request->sales_rev_per_floor,
                     'total' => $request->sales_rev_per_floor * $reven->ground_floor_sft
                 ];
                 $total_rev += ($request->sales_rev_per_floor * $reven->ground_floor_sft);
             }
    
                $reven->total_floor_sft = $total_floor_sft;
                $reven->total_saleable_sft = $total_floor_sft;
                $reven->mgc = $request->mgc;
                $reven->actual_story = $new_floor;
                $reven->actual_far = $request->far;
                $reven->avg_rate = $request->sales_rev_per_floor;
                $reven->total_amount = $total_rev;
                $reven->save();
    
                $reven->BdFeasiRevenueDetail()->delete();
                $reven->BdFeasiRevenueDetail()->createMany($rev_data);
    
                $basic_entry = BdFeasibilityEntry::where('location_id', $request->location_id)->get()->first();
                $basic_entry->parking_number = $request->parking_number;
                $basic_entry->total_payment = $request->total_payment;
                $basic_entry->rfpl_ratio = $request->developers_ratio;
                $basic_entry->basement_no = $request->total_basement_floor;
                $basic_entry->parking_area_per_car = $request->parking_area_per_car;
                $basic_entry->fire_stair_area = $request->fire_stair_area;
                $basic_entry->parking_number = $request->parking_number;
                $basic_entry->save();
    
                $lead = BdLeadGeneration::where('id', $request->location_id)->get()->first();
                $lead->land_size = $request->land_size;
                $lead->proposed_front_road_size = $request->building_front_length;
                $lead->save();
            // return [
            //     'revenue' => $rev_data,
            //     'finance' => $financeData,
            //     'cost'  => $cost_data
            // ];
            DB::commit();
            return redirect()->back()->with('message', 'Data has been updated successfully');
        }catch(Exception $err){
            DB::rollback();
            return redirect()->back()->withInput()->withErrors($err->getMessage());
        }
        
    }
}
