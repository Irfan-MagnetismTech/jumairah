<?php
namespace App\Http\Services;

use App\Boq\Configurations\BoqMaterialFormula;
use App\Boq\Configurations\BoqMaterialPriceWastage;
use App\Boq\Configurations\BoqReinforcementMeasurement;
use App\Boq\Configurations\BoqWork;
use App\Boq\Departments\Civil\BoqCivilCalc;
use App\Boq\Departments\Civil\BoqReinforcementSheet;
use App\Boq\Departments\Civil\RevisedSheet\BoqCivilRevisedSheet;
use App\Project;
use Illuminate\Http\Request;

class CivilCalcService
{
    /**
     * @param Request $request
     * @param Project $project
     * @param string $calculation_type
     */
    public function __construct(private Request $request, private Project $project, private string $calculation_type)
    {
    }

    /**
     * Handles Boq Civil Civil Calculation
     *
     * @return void
     */
    public function handleCalculation(): void
    {
        try {

            $work_id     = (int) $this->request->work_id;
            $grand_total = (double) $this->request?->grand_total ?? 0;
            $civil_calc  = BoqCivilCalc::firstOrCreate([
                'boq_floor_id'     => $this->request->boq_floor_id,
                'work_id'          => $work_id,
                'calculation_type' => $this->calculation_type,
                'project_id'       => $this->project->id,
            ], [
                'total'              => $grand_total,
                'secondary_total'    => $this->request?->secondary_total,
                'secondary_total_fx' => $this->request?->secondary_total_fx,
                'unit_id'            => $this->request?->unit_id,
            ]);

            $group_calc = $civil_calc->boqCivilCalcGroups()->delete();
            $civil_calc->boqCivilCalcDetails()->delete();


            foreach ($this->request?->calculation ?? [] as $calculation)
            {
                $group_calc = $civil_calc->boqCivilCalcGroups()->create([
                    'boq_civil_calc_id' => $civil_calc->id,
                    'name'              => $calculation['group_name'] ?? '',
                    'total'             => (double) $calculation['group_total'] ?? 0,
                ]);

                foreach ($calculation['final_material_list'] ?? [] as $finalMaterial){
                    $group_material = $group_calc->boqCivilCalcGroupMaterials()->create([
                        'boq_civil_calc_group_id' => $group_calc->id,
                        'material_id'             => $finalMaterial['material_id'] ?? 0,
                        'material_price'          => $finalMaterial['material_price'] ?? 0,
                        'material_ratio'          => $finalMaterial['material_ratio'] ?? 0,
                        'material_wastage'        => $finalMaterial['material_wastage'] ?? 0,
                    ]);
                }


                //$group_calc->boqCivilCalcDetails()->delete();

                foreach ($calculation['group_data'] ?? [] as $group_data)
                {
                    $group_calc->boqCivilCalcDetails()->create([
                        'boq_civil_calc_id'                => (integer) $civil_calc->id,
                        'sub_location_name'                => (string) ($group_data['location'] ?? null),
                        'no_or_dia'                        => (double) ($group_data['no_or_dia'] ?? 0),
                        'length'                           => (double) ($group_data['length'] ?? 0),
                        'breadth_or_member'                => (double) ($group_data['breadth_or_member'] ?? 0),
                        'height_or_bar'                    => (double) ($group_data['height_or_bar'] ?? 0),
                        'total'                            => (double) ($group_data['row_total'] ?? 0),
                        'boq_reinforcement_measurement_id' => (string) ($group_data['boq_reinforcement_measurement_id'] ?? null),
                        'no_or_dia_fx'                     => (string) ($group_data['no_or_dia_fx'] ?? null),
                        'length_fx'                        => (string) ($group_data['length_fx'] ?? null),
                        'breadth_or_member_fx'             => (string) ($group_data['breadth_or_member_fx'] ?? null),
                        'height_or_bar_fx'                 => (string) ($group_data['height_or_bar_fx'] ?? null),
                    ]);
                }

                //new code material save start

                //new code material save end

            }

            $civil_calc->update([
                'total'              => $grand_total,
                'secondary_total'    => $this->request?->secondary_total,
                'secondary_total_fx' => $this->request?->secondary_total_fx,
                'unit_id'            => $this->request?->unit_id,
            ]);
        }
        catch (\Exception$e)
        {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * Handles Boq Civil Civil Budget
     *
     * @return void
     */
    public function handleBudget()
    {
        try {

            $this->saveMaterialOrLabourBudget();

//            if ($this->calculation_type === 'material-labour')
//            {
//                $this->saveMaterialLabourBudget();
//                //$this->saveLabourBudget();
//            }
//            else
//            {
//                $this->saveMaterialOrLabourBudget();
//            }
        }
        catch (\Exception$e)
        {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * Save Material Budget
     */
    private function saveMaterialLabourBudget()
    {
        try {
            $work     = BoqWork::find($this->request->work_id);
            $formulas = BoqMaterialFormula::where('work_id', $this->request->work_id)->get();

            if ($formulas->count() === 0)
            {
                throw new \Exception("Material formula not found for work: {$work->name}");
            }

            $price_wastage = BoqMaterialPriceWastage::whereIn('nested_material_id', $formulas->pluck('nested_material_id'))
                ->get();

            if ($price_wastage->count() !== $work->boqMaterialFormulas->count())
            {
                throw new \Exception("Material price or wastage not found for work: {$work->name}");
            }

            $price_wastage = $price_wastage->keyBy('nested_material_id');

            $this->project->boqCivilBudgets()->where('boq_work_id', $this->request->work_id)
                ->where('budget_type', $this->calculation_type)
                ->where('work_type_id', $this->request->work_type_id)
                ->where('boq_floor_id', $this->request->boq_floor_id)
                ->delete();

            $iteration = 0;
            foreach ($this->request->selected_material_list as $material_id)
            {
                if($this->request->is_additional_material[$iteration] === 0){
                    //update material price column
                    BoqMaterialPriceWastage::where('nested_material_id', $material_id)->update(array('price' => $this->request->selected_material_price_list[$iteration]));

                    //update ratio and wastage value
                    BoqMaterialFormula::where('work_id', $this->request->work_id)
                        ->where('nested_material_id', $material_id)->update(array('percentage_value' => $this->request->selected_material_ratio_list[$iteration], 'wastage' => $this->request->selected_material_wastage_list[$iteration]));
                }

//                $boq_material_formula = BoqMaterialFormula::where('work_id', $this->request->work_id)
//                    ->where('nested_material_id', $material_id)
//                    ->first();

                //$material_id = $boq_material_formula->nested_material_id;

                $quantity    = ($this->request?->grand_total ?? 0) * $this->request->selected_material_ratio_list[$iteration];
                $wastage_quantity = ceil(($this->request->selected_material_wastage_list[$iteration] ?? 0) * $quantity);
                $wastage     = $this->request->selected_material_wastage_list[$iteration];
                $rate        = $this->request->selected_material_price_list[$iteration];

                $total_quantity = floor($quantity + $wastage_quantity);

                $this->project->boqCivilBudgets()->updateOrCreate(
                    [
                        'boq_work_id'        => $this->request->work_id,
                        'work_type_id'       => $this->request->work_type_id,
                        'boq_floor_id'       => $this->request->boq_floor_id,
                        'nested_material_id' => $material_id,
                        'budget_type'        => $this->calculation_type,
                    ],
                    [
                        'formula_percentage'     => $this->request->selected_material_ratio_list[$iteration],
                        'is_additional_material' => $this->request->is_additional_material[$iteration],
                        'quantity'               => $quantity,
                        'wastage'                => $wastage,
                        'wastage_quantity'       => $wastage_quantity,
                        'rate'                   => $rate,
                        'total_quantity'         => $total_quantity,
                        'total_amount'           => ceil($total_quantity * $rate),
                    ]
                );

                /* Update Boq Supreme budget start */
                $this->project->boqSupremeBudgets()->where('budget_type', $this->calculation_type)
                    ->where('material_id', $material_id)
                    ->where('floor_id', $this->request->boq_floor_id)
                    ->delete();
                $this->request['budget_for'] = 'Civil';
                $this->project->boqSupremeBudgets()->updateOrCreate(
                    [
                        'floor_id'           => $this->request->boq_floor_id,
                        'material_id'        => $material_id,
                        'budget_type'        => $this->calculation_type,
                        'budget_for'         => $this->request->budget_for,
                    ],
                    [
                        'quantity'     => $total_quantity,
                    ]
                );
                $iteration++;
                /* Update Boq Supreme budget end */
            }
//            foreach ($work->boqMaterialFormulas as $boq_material_formula)
//            {
//                $material_id = $boq_material_formula->nested_material_id;
//                $quantity    = ($this->request?->grand_total ?? 0) * ($boq_material_formula->percentage_value / 100);
//                $wastage     = $price_wastage[$material_id]->wastage / 100;
//                $rate        = $price_wastage[$material_id]->price;
//
//                $this->project->boqCivilBudgets()->updateOrCreate(
//                    [
//                        'boq_work_id'        => $this->request->work_id,
//                        'work_type_id'       => $this->request->work_type_id,
//                        'boq_floor_id'       => $this->request->boq_floor_id,
//                        'nested_material_id' => $boq_material_formula->nested_material_id,
//                        'budget_type'        => $this->calculation_type,
//                    ],
//                    [
//                        'formula_percentage' => $boq_material_formula->percentage_value,
//                        'quantity'           => $quantity,
//                        'wastage'            => $wastage,
//                        'rate'               => $rate,
//                        'total_quantity'     => $quantity + $wastage,
//                        'total_amount'       => ($quantity + $wastage) * $rate,
//                    ]
//                );
//
//                /* Update Boq Supreme budget start */
//                $this->project->boqSupremeBudgets()->updateOrCreate(
//                    [
//                        'floor_id'           => $this->request->boq_floor_id,
//                        'material_id'        => $boq_material_formula->nested_material_id,
//                        'budget_type'        => $this->calculation_type,
//                    ],
//                    [
//                        'quantity'     => $quantity + $wastage,
//                    ]
//                );
//                /* Update Boq Supreme budget end */
//            }
        }
        catch (\Exception$e)
        {
            throw new \Exception($e->getMessage());
        }
    }


    /**
     * @param $work
     * @throws \Exception
     * Save Material Or Labour Budget
     */

    private function saveMaterialOrLabourBudget()
    {

        try {
            $work     = BoqWork::find($this->request->work_id);

            $work_type_id = BoqWork::find($this->request->work_type_id);

            if($work_type_id->parent_id == null){
                $this->request['boq_work_parent_id'] = $work_type_id->id;
            } else{
                $this->request['boq_work_parent_id'] = $work_type_id->parent_id;
            }

            $formulas = BoqMaterialFormula::where('work_id', $this->request->work_id)->get();

//            if ($formulas->count() === 0)
//            {
//                throw new \Exception("Material formula not found for work: {$work->name}");
//            }

            $price_wastage = BoqMaterialPriceWastage::whereIn('nested_material_id', $formulas->pluck('nested_material_id'))
                ->get();

//            if ($price_wastage->count() !== $work->boqMaterialFormulas->count())
//            {
//                throw new \Exception("Material price or wastage not found for work: {$work->name}");
//            }

            $price_wastage = $price_wastage->keyBy('nested_material_id');

            $this->project->boqCivilBudgets()->where('boq_work_id', $this->request->work_id)
                ->where('budget_type', $this->calculation_type)
                ->where('work_type_id', $this->request->work_type_id)
                ->where('boq_floor_id', $this->request->boq_floor_id)
                ->delete();

            $iteration = 0;

            //new code start
            foreach ($this->request?->calculation ?? [] as $calculation)
            {

                foreach ($calculation['final_material_list'] ?? [] as $finalMaterial){

                    $totalPreviousQuantity = 0;
                    $totalPreviousWastageQuantity = 0;

                    //update material price column
                    BoqMaterialPriceWastage::where('nested_material_id', $finalMaterial['material_id'])
                        ->update(array('price' => $finalMaterial['material_price']));

                    //update ratio and wastage value
                    BoqMaterialFormula::where('work_id', $this->request->work_id)
                        ->where('nested_material_id', $finalMaterial['material_id'])
                        ->update(array('percentage_value' => $finalMaterial['material_ratio'],
                            'wastage' => $finalMaterial['material_wastage']));


                    // update material price and total amount in boq_civil_budgets table start

                    if($this->calculation_type != 'labour'){
                        $sameMaterialList = $this->project->boqCivilBudgets()->where('nested_material_id', $finalMaterial['material_id'])
                            ->where('budget_type','!=','labour')->get();

                        foreach ($sameMaterialList as $sameMaterial){
                            $sameMaterial->update([
                                'rate' => $finalMaterial['material_price'],
                                'total_amount' => $sameMaterial->total_quantity * $finalMaterial['material_price'],
                            ]);
                        }
                    }

                    // update material price and total amount in boq_civil_budgets table end



                    // get previous budget data with same material with different group start

                    $previous_budget = $this->project->boqCivilBudgets()->where('boq_work_id', $this->request->work_id)
                        ->where('budget_type', $this->calculation_type)
                        ->where('work_type_id', $this->request->work_type_id)
                        ->where('boq_floor_id', $this->request->boq_floor_id)
                        ->where('nested_material_id', $finalMaterial['material_id'])
                        ->get();

                    foreach ($previous_budget as $budget){
                        $totalPreviousQuantity += $budget->quantity;
                        $totalPreviousWastageQuantity += $budget->wastage_quantity;
                    }

                    // get previous budget data with same material with different group end


                    //current material budget start

                    $quantity = (((double) $calculation['group_total'] ?? 0) * $finalMaterial['material_ratio']);

                    $wastage_quantity = ((double) ($finalMaterial['material_wastage'] ?? 0) * $quantity);

                    $quantity = $quantity + $totalPreviousQuantity;
                    $wastage_quantity = $wastage_quantity + $totalPreviousWastageQuantity;

                    $wastage     = $finalMaterial['material_wastage'];
                    $rate        = $finalMaterial['material_price'];

                    $total_quantity = ((double) $quantity + $wastage_quantity ?? 0);

                    //current material budget end

                    $this->project->boqCivilBudgets()->updateOrCreate(
                        [
                            'boq_work_id'        => $this->request->work_id,
                            'work_type_id'       => $this->request->work_type_id,
                            'boq_floor_id'       => $this->request->boq_floor_id,
                            'nested_material_id' => $finalMaterial['material_id'],
                            'budget_type'        => $this->calculation_type,
                        ],
                        [
                            'formula_percentage' => $finalMaterial['material_ratio'],
                            'boq_floor_type_id' => $this->request->boq_floor_type_id,
                            'boq_work_parent_id' => $this->request->boq_work_parent_id,
                            'is_additional_material' => $this->request->is_additional_material[$iteration] ?? 0,
                            'quantity'           => $quantity,
                            'wastage'            => $wastage,
                            'wastage_quantity'   => $wastage_quantity,
                            'rate'               => $rate,
                            'total_quantity'     => $total_quantity,
                            'total_amount'       => $total_quantity * $rate,
                        ]
                    );

                    /* Update Boq Supreme budget start */
                    $this->project->boqSupremeBudgets()->where('budget_type', $this->calculation_type)
                        ->where('material_id', $finalMaterial['material_id'])
                        ->where('floor_id', $this->request->boq_floor_id)
                        ->delete();

                    /* Total material quantity of floor */
                    $total_floor_material_quantity = $this->project->boqCivilBudgets()->where('boq_floor_id', $this->request->boq_floor_id)
                        ->where('budget_type', $this->calculation_type)
                        ->where('nested_material_id', $finalMaterial['material_id'])
                        ->sum('total_quantity');

                    $this->request['budget_for'] = 'Civil';
                    $this->project->boqSupremeBudgets()->updateOrCreate(
                        [
                            'floor_id'           => $this->request->boq_floor_id,
                            'material_id'        => $finalMaterial['material_id'],
                            'budget_type'        => $this->calculation_type,
                            'budget_for'         => $this->request->budget_for,
                        ],
                        [
                            'quantity'     => $total_floor_material_quantity,
                            'budget_type'  => $this->calculation_type,
                        ]
                    );
                    /* Update Boq Revised Sheet */
                    $isExist = BoqCivilRevisedSheet::where('project_id', $this->project->id)
                        ->where('boq_floor_id', $this->request->boq_floor_id)
                        ->where('nested_material_id', $finalMaterial['material_id'])
                        ->where('budget_for', 'Civil')
                        ->where('escalation_no', '>=', 1)
                        ->first();

                    if(!$isExist){

                        //delete previous data
                        $this->project->boqRevisedBudgets()->where('budget_for', 'Civil')
                            ->where('nested_material_id', $finalMaterial['material_id'])
                            ->where('boq_floor_id', $this->request->boq_floor_id)
                            ->delete();

                        //Get total requisition quantity right now
                        $totalRequisitionQuantity = $this->project->requisitionDetails()->where('floor_id', $this->request->boq_floor_id)
                            ->where('material_id', $finalMaterial['material_id'])
                            ->sum('quantity');

                        $this->project->boqRevisedBudgets()->updateOrCreate(
                            [
                                'boq_floor_id'           => $this->request->boq_floor_id,
                                'nested_material_id'     => $finalMaterial['material_id'],
                                'budget_for'             => 'Civil',
                            ],
                            [
                                'project_id'             => $this->project->id,
                                'budget_type'            => $this->calculation_type,
                                'boq_floor_id'           => $this->request->boq_floor_id,
                                'nested_material_id'     => $finalMaterial['material_id'],
                                'escalation_no'          => 0,
                                'escalation_date'        => now(),
                                'budget_for'             => 'Civil',
                                'primary_qty'            => $total_floor_material_quantity,
                                'primary_price'          => $rate,
                                'primary_amount'         => $total_floor_material_quantity * $rate,
                                'used_qty'               => $totalRequisitionQuantity,
                                'current_balance_qty'    => $total_floor_material_quantity - $totalRequisitionQuantity,
                                'revised_qty'            => 0,
                                'revised_price'          => 0,
                                'price_after_revised'    => $rate,
                                'qty_after_revised'      => $total_floor_material_quantity,
                                'amount_after_revised'   => $total_floor_material_quantity * $rate,
                                'increased_or_decreased_amount' => 0,
                                'remarks'                => 'Initial Budget',
                            ]
                        );
                    }

                    $iteration++;
                }
            }
        }
        catch (\Exception$e)
        {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * Save Labour Budget
     */
    private function saveLabourBudget()
    {
        $this->project->boqCivilBudgets()->updateOrCreate(
            [
                'boq_work_id'  => $this->request?->work_id,
                'boq_floor_id' => $this->request?->boq_floor_id,
                'budget_type'  => $this->calculation_type,
            ],
            [

                'quantity'       => $this->request?->labour_quantity ?? 0,
                'rate'           => $this->request?->labour_rate,
                'total_quantity' => $this->request?->labour_quantity ?? 0,
                'total_amount'   => $this->request?->labour_quantity * $this->request?->labour_rate ?? 0,

            ]
        );

    }

    public function reinforcementCalculation(): void
    {
        try {

            $work_id     = (int) $this->request->work_id;

            //delete
            BoqReinforcementSheet::where('project_id', $this->project->id)->where('boq_work_id', $this->request->work_id)
                ->where('budget_type', $this->calculation_type)->where('boq_floor_id', $this->request->boq_floor_id)->delete();


            foreach ($this->request?->calculation ?? [] as $calculation)
            {

                foreach ($calculation['final_material_list'] ?? [] as $finalMaterial){

                    foreach ($calculation['group_data'] ?? [] as $group_data)
                    {

                        //save data in reinforcement budget start

                        $dia = BoqReinforcementMeasurement::find($group_data['boq_reinforcement_measurement_id'] ?? 0);

                        $quantity = (((double) $group_data['row_total'] ?? 0) * $finalMaterial['material_ratio']);
                        $wastage_quantity = ((double) ($finalMaterial['material_wastage'] ?? 0) * $quantity);
                        $wastage     = $finalMaterial['material_wastage'];
                        $total_quantity = ((double) $quantity + $wastage_quantity ?? 0);

                        $boqReinforcementSheet = new BoqReinforcementSheet();
                        $boqReinforcementSheet->project_id = $this->project->id;
                        $boqReinforcementSheet->boq_work_id = $work_id;
                        $boqReinforcementSheet->boq_floor_id = $this->request->boq_floor_id;
                        $boqReinforcementSheet->nested_material_id = $finalMaterial['material_id'] ?? 0;
                        $boqReinforcementSheet->budget_type = $this->calculation_type;
                        $boqReinforcementSheet->formula_percentage = $finalMaterial['material_ratio'] ?? 0;
                        $boqReinforcementSheet->quantity = $quantity;
                        $boqReinforcementSheet->wastage = $wastage;
                        $boqReinforcementSheet->wastage_quantity = $wastage_quantity;
                        $boqReinforcementSheet->rate = $finalMaterial['material_price'] ?? 0;
                        $boqReinforcementSheet->dia = $dia->dia ?? 0;
                        $boqReinforcementSheet->calculation_total = $group_data['row_total'] ?? 0;
                        $boqReinforcementSheet->total_quantity = $total_quantity;
                        $boqReinforcementSheet->total_amount = $total_quantity * $finalMaterial['material_price'] ?? 0;
                        $boqReinforcementSheet->boq_floor_type_id = $this->request->boq_floor_type_id;
                        $boqReinforcementSheet->boq_work_parent_id = $this->request->boq_work_parent_id;
                        $boqReinforcementSheet->save();

                        //save data in reinforcement budget end

                    }
                }

            }

        }
        catch (\Exception$e)
        {
            throw new \Exception($e->getMessage());
        }
    }
}
