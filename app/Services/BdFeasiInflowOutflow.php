<?php

namespace App\Services;

use App\BD\BdFeasiRncCal;
use App\BD\ProjectLayout;
use App\Approval\Approval;
use App\BD\BdFeasiFinance;
use App\BD\BdFeasiRevenue;
use App\BD\BdFeasiCtcDetail;
use App\BD\BdLeadGeneration;
use Illuminate\Http\Request;
use App\BD\BdFeasiPerticular;
use App\BD\BdFeasibilityEntry;
use App\Approval\ApprovalLayer;
use Illuminate\Support\Facades\DB;
use App\BD\BdFeasiFessAndCostDetail;
use App\Http\Controllers\Controller;
use App\Approval\ApprovalLayerDetails;
use Illuminate\Database\QueryException;
use App\Http\Requests\BD\BdFeasiFinanceRequest;

class BdFeasiInflowOutflow
{
    private $buildup_area;
    private $bonus_saleable;
    private $ground_floor;
    private $semi_basement;
    private $total_sales;
    private $katha;



    /**
     * @param \Illuminate\Http\Request $request
     */
    private function getactualquantity($item)
    {
        if ($item->headable->dependency_type == 1) {
            $quantity = $this->total_sales;
        } elseif ($item->headable->dependency_type == 2) {
            $quantity = $this->buildup_area + $this->bonus_saleable + $this->ground_floor + $this->semi_basement;
        } elseif ($item->headable->dependency_type == 3) {
            $quantity = $this->buildup_area + $this->bonus_saleable + $this->ground_floor;
        } elseif ($item->headable->dependency_type == 4) {
            $quantity = $this->semi_basement;
        } elseif ($item->headable->dependency_type == 5) {
            $quantity = $this->katha;
        } else {
            $quantity = $item->quantity;
        }
        return $quantity;
    }
    private function permissioFess($location_id)
    {
        $permission_cost = BdFeasiFessAndCostDetail::with('headable')
            ->whereHas('BdFeasiFessAndCost', function ($query) use ($location_id) {
                return $query->where('location_id', $location_id);
            })
            ->where('headble_type', BdFeasiPerticular::class)
            ->whereHasMorph('headable', [BdFeasiPerticular::class], function ($query) {
                $query->where('type', 'Permission Fees');
            })
            ->get()
            ->map(function ($item) {
                $quantity = $this->getactualquantity($item);
                return $item->rate * $quantity;
            })->sum();


        return $permission_cost;
    }

    private function ConstructionCostFloor($location_id)
    {
        $Construction_cost_floor_amount = BdFeasiFessAndCostDetail::with('headable')
            ->whereHas('BdFeasiFessAndCost', function ($query) use ($location_id) {
                return $query->where('location_id', $location_id);
            })
            ->where('headble_type', BdFeasiPerticular::class)
            ->whereHasMorph('headable', [BdFeasiPerticular::class], function ($query) {

                $query->whereIn('type', ['Superstructure & Finishing', 'EME', 'BOQ-Utility']);
            })
            ->get()->map(function ($item) {
                $quantity = $this->getactualquantity($item);
                return $item->rate * $quantity;
            })->sum();


        return $Construction_cost_floor_amount;
    }



    private function costOfShoreAndDevicePile($location_id)
    {
        $cost_of_shore_and_dervice_pile = BdFeasiFessAndCostDetail::with('headable')
            ->whereHas('BdFeasiFessAndCost', function ($query) use ($location_id) {
                return $query->where('location_id', $location_id);
            })
            ->where('headble_type', BdFeasiPerticular::class)
            ->whereHasMorph('headable', [BdFeasiPerticular::class], function ($query) {
                $query->where('statuts', 1)->where('type', 'Substructure');
            })
            ->get()
            ->map(function ($item) {
                $quantity = $this->getactualquantity($item);
                return $item->rate * $quantity;
            })->sum();


        return $cost_of_shore_and_dervice_pile;
    }

    private function ConstructionCostBasement($location_id)
    {
        $ConstructionCostBasement = BdFeasiFessAndCostDetail::with('headable')
            ->whereHas('BdFeasiFessAndCost', function ($query) use ($location_id) {
                return $query->where('location_id', $location_id);
            })
            ->where('headble_type', BdFeasiPerticular::class)
            ->whereHasMorph('headable', [BdFeasiPerticular::class], function ($query) {
                $query->where('statuts', 2)->where('type', 'Substructure');
            })
            ->get()->map(function ($item) {
                return $item->rate;
            })->sum();


        return $ConstructionCostBasement;
    }

    private function overHead($location_id, $construction_life_cycle)
    {
        $overhead = BdFeasiCtcDetail::query()
            ->whereHas('BdFeasiCtc', function ($q) use ($location_id) {
                $q->where('location_id', $location_id);
            })
            ->sum('total_effect') * $construction_life_cycle * 12;


        return $overhead;
    }






    public function getTotalCostwithoutInterest($location_id, $actual_mgc = null, $developers_ratio = null, $far = null, $far_utili_mgc = null, $land_size = null, $parking_area_per_car = null, $parking_number = null, $sales_revenue = null, $total_basement_floor = null)
    {


        $bd_feasi_entry = BdFeasibilityEntry::query()->where('location_id', $location_id)->get()->first();

        $project_layout = ProjectLayout::query()->where('bd_lead_location_id', $location_id)->get()->first();

        $LeadGEnaration = BdLeadGeneration::find($location_id);

        $revenue = BdFeasiRevenue::query()->with('BdFeasiRevenueDetail')->where('location_id', $location_id)->get()->first();

        /** for index **/

        $mgc = ($actual_mgc && $actual_mgc >= 0) ? $actual_mgc : $revenue->actual_mgc;
        $rfpl_ratio = ($developers_ratio && $developers_ratio >= 0) ? $developers_ratio : $bd_feasi_entry->rfpl_ratio;
        $far = ($far && $far >= 0) ? $far : $revenue->actual_far;
        $land_size = ($land_size && $land_size >= 0) ? $land_size : $LeadGEnaration->land_size;
        $parking_area_per_car = ($parking_area_per_car && $parking_area_per_car >= 0) ? $parking_area_per_car : $bd_feasi_entry->parking_area_per_car;
        $parking_number = ($parking_number && $parking_number >= 0) ? $parking_number : $bd_feasi_entry->parking_number;
        $sales_revenue = ($sales_revenue && $sales_revenue >= 0) ? $sales_revenue : $revenue->avg_rate;
        $total_basement_floor = ($total_basement_floor && $total_basement_floor >= 0) ? $total_basement_floor : $bd_feasi_entry->basement_no;


        /****/ $total_payment_for_land = $bd_feasi_entry->total_payment;
        /****/ $registration_cost = $total_payment_for_land * $bd_feasi_entry->registration_cost / 100;

        $this->katha = $land_size;
        $semi_basement_floor_area = $total_basement_floor * $land_size * 720 * ($bd_feasi_entry->floor_area_far_free / 100);
        $this->semi_basement = $semi_basement_floor_area;
        $total_buildup_area = $far * $land_size * 720;
        $this->buildup_area = $total_buildup_area;
        $total_Bonus_saleable_area = $total_buildup_area * $bd_feasi_entry->bonus_saleable_area / 100;
        $this->bonus_saleable = $total_Bonus_saleable_area;





        if ($revenue->ground_floor_sft > 0) {
            $utilization = ($revenue->ground_floor_sft / $rfpl_ratio / 100) / ($land_size * 720 * $mgc) * 100;
        } else {
            $utilization = 0;
        }

        if ($far_utili_mgc && $far_utili_mgc >= 0) {
            $utilization  = $far_utili_mgc;
        }

        $total_ground_floor_area = ($land_size * 720 * $bd_feasi_entry->floor_area_far_free / 100) - ($utilization / 100 * $land_size * 720 * $mgc / 100);
        $this->ground_floor = $total_ground_floor_area;

        /*infow calculation*/
        $sale_revenue_from_far_area = $total_buildup_area * $sales_revenue * ($rfpl_ratio / 100);
        $sale_revenue_from_bonus_far_area = $total_Bonus_saleable_area * $sales_revenue * $rfpl_ratio / 100;

        $nember_of_perking_grounFloor = floor($semi_basement_floor_area / $parking_area_per_car);
        $total_number_of_Perking = ($nember_of_perking_grounFloor + $parking_number);
        $sale_revenue_from_parking_and_utility = $total_number_of_Perking *  $bd_feasi_entry->parking_sales_revenue * ($rfpl_ratio / 100)
            + ($bd_feasi_entry->apertment_number * ($rfpl_ratio / 100) *  $bd_feasi_entry->parking_rate);


        /*infow calculation*/
        $total_inflow = $sale_revenue_from_far_area + $sale_revenue_from_bonus_far_area + $sale_revenue_from_parking_and_utility;
        $this->total_sales = $total_inflow;

        // dd($this->semi_basement,$this->buildup_area,$this->bonus_saleable,$this->ground_floor,$this->total_sales,$this->buildup_area+$this->bonus_saleable+$this->ground_floor);
        /****/ $permission_cost = $this->permissioFess($location_id);
        /****/ $overhead = $this->overHead($location_id, $bd_feasi_entry->construction_life_cycle);

        /*calculation for cost of service pile*/
        $cost_of_shore_and_dervice_pile = $this->costOfShoreAndDevicePile($location_id);

        $cost_of_service_pile = $cost_of_shore_and_dervice_pile / ($land_size * 720);
        /*calculation for cost of service pile*/
        /*calculation for construction cost floor */

        $Construction_cost_floor_amount = $this->ConstructionCostFloor($location_id);

        $super_structure = $total_ground_floor_area + $total_buildup_area + $total_Bonus_saleable_area;
        $ConstructionCostFloor = $Construction_cost_floor_amount / $super_structure;
        /*calculation for construction cost floor */

        $ConstructionCostBasement = $this->ConstructionCostBasement($location_id);

        /****/
        $total_construction_cost = $land_size * 720 * $cost_of_service_pile + $ConstructionCostFloor * ($super_structure) + $ConstructionCostBasement * $semi_basement_floor_area;

        /**calculation for construction cost*/
        $total_outflow = $total_construction_cost + $overhead + $permission_cost + $registration_cost;

        //     dd($total_outflow,
        //     $total_construction_cost , $overhead , $permission_cost , $registration_cost , $total_payment_for_land , $total_payment_for_land
        // );

        /*rnc*/
        $rnc = BdFeasiRncCal::with('BdFeasRncCalCost', 'BdFeasRncCalRate', 'BdFeasRncCalSale')
            ->where('bd_lead_generation_id', $location_id)
            ->first();
        /*rnc*/
        //    dd($total_inflow);
        //    dd($sale_revenue_from_far_area,$sale_revenue_from_bonus_far_area,$sale_revenue_from_parking_and_utility);
        return response()->json([
            'outflow'                 =>    $total_outflow,
            'inflow'                  =>    $total_inflow,
            'fees_and_cost_details'   =>    $cost_of_shore_and_dervice_pile,
            'other_costs'               =>  $permission_cost,
            'ConstructionCostFloor'     =>   $Construction_cost_floor_amount,
            'ConstructionCostBasement'  =>  $ConstructionCostBasement ? $ConstructionCostBasement : 0,
            'rnc'                     =>    $rnc,
            'construction_life'       =>    $bd_feasi_entry->construction_life_cycle
        ]);
    }
}
