<?php

namespace App\Http\Controllers\Boq\Departments\Electrical\Configurations;

use App\Project;
use App\Procurement\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Boq\Configurations\BoqWork;
use App\Procurement\NestedMaterial;
use App\Http\Controllers\Controller;
use App\Boq\Departments\Eme\BoqEmeItem;
use App\Boq\Departments\Eme\BoqEmeRate;
use Illuminate\Database\QueryException;
use App\Boq\Departments\Eme\EmeLaborHead;
use App\Http\Requests\Boq\Eme\BoqEmeRateRequest;

class BoqElectricalRateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Project $project)
    {
        $BoqEmeRateData = BoqEmeRate::latest()->get();
        return view('boq.departments.electrical.configurations.rates.index', compact('project', 'BoqEmeRateData'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Project $project)
    {
        $optionList = BoqEmeRate::whereNotNull('boq_work_name')->pluck('boq_work_name');
        $options = $optionList->toArray();
        $formType = 'create';
        $units = Unit::orderBy( 'id' )->pluck( 'name', 'id' );
        $boq_works = EmeLaborHead::latest()->get();
        $leyer1NestedMaterial = NestedMaterial::with('descendants')->where('parent_id', null)->orderBy('id')->pluck('name', 'id');
        $emeMaterial = NestedMaterial::where('name', 'ELECTRICAL MATERIALS')->first();
        $secondMaterial = $materials = NestedMaterial::with('descendants')
            ->where('parent_id', $emeMaterial->id)
            ->orderBy('id')
            ->pluck('name', 'id');

        return view('boq.departments.electrical.configurations.rates.create', compact('project', 'leyer1NestedMaterial', 'formType', 'boq_works', 'emeMaterial', 'secondMaterial', 'options', 'units'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BoqEmeRateRequest $request, Project $project)
    {
        try {
            $BoqEmeRateData = array();
            if ($request->type) {
                foreach ($request->work_id as  $key => $data) {
                    $BoqEmeRateData[] = [
                        'parent_id_second'  =>  $request->parentwork_id,
                        'boq_work_name'     =>  $request->work_id[$key],
                        'labor_unit'        =>  $request->labor_unit[$key],
                        'labour_rate'       =>  $request->work_labour_rate[$key],
                        'type'              =>  1,
                        'created_at'        =>  now(),
                        'updated_at'        =>  now()
                    ];
                }
            } else {
                foreach ($request->material_id as  $key => $data) {
                    $BoqEmeRateData[] = [
                        'parent_id_second'  =>  $request->parent_id_second,
                        'material_id'       =>  $request->material_id[$key],
                        'labour_rate'       =>  $request->labour_rate[$key],
                        'labor_unit'        =>  null,
                        'created_at'        =>  now(),
                        'updated_at'        =>  now()
                    ];
                }
            }

            DB::transaction(function () use ($BoqEmeRateData) {
                BoqEmeRate::insert($BoqEmeRateData);
            });

            return redirect()->route('boq.project.departments.electrical.configurations.rates.index', $project)->with('message', 'Data has been inserted successfully');
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
    public function edit(Project $project, $BoqEmeRateId)
    {
        $optionList = BoqEmeRate::whereNotNull('boq_work_name')->pluck('boq_work_name');
        $options = $optionList->toArray();
        $units = Unit::orderBy( 'id' )->pluck( 'name', 'id' );
        $formType = 'edit';
        $boq_works  = EmeLaborHead::latest()->get();
        $BoqEmeDatas =  BoqEmeRate::findOrFail($BoqEmeRateId);
        // $parent_data = BoqWork::ancestorsOf($BoqEmeDatas->boq_work_name)->pluck('name', 'id');
        $leyer1NestedMaterial = NestedMaterial::with('descendants')->whereNull('parent_id')->orderBy('id')->pluck('name', 'id');
        $leyer2NestedMaterial = NestedMaterial::with('descendants')->where('parent_id', $BoqEmeDatas->NestedMaterialSecondLayer->parent_id)->orderBy('id')->pluck('name', 'id');
        $emeMaterial = NestedMaterial::where('name', 'ELECTRICAL MATERIALS')->first();
        $secondMaterial = $materials = NestedMaterial::with('descendants')
            ->where('parent_id', $emeMaterial->id)
            ->orderBy('id')
            ->pluck('name', 'id');
        return view('boq.departments.electrical.configurations.rates.create', compact('project', 'formType', 'BoqEmeDatas', 'leyer1NestedMaterial', 'leyer2NestedMaterial', 'BoqEmeRateId', 'boq_works', 'emeMaterial', 'secondMaterial', 'options', 'units'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BoqEmeRateRequest $request, Project $project, $BoqEmeRateId)
    {
        //
        try {
            $BoqEmeDatas =  BoqEmeRate::findOrFail($BoqEmeRateId);
            $BoqEmeRateData = array();
            if ($request->type) {
                foreach ($request->work_id as  $key => $data) {
                    $BoqEmeRateData = [
                        'boq_work_name'     =>  $request->work_id[$key],
                        'labour_rate'       =>  $request->work_labour_rate[$key],
                        'parent_id_second'  =>  $request->parentwork_id,
                        'labor_unit'        =>  $request->labor_unit[$key],
                        'material_id'       =>  null,
                        'type'              =>  1,
                        'created_at'        =>  now(),
                        'updated_at'        =>  now()
                    ];
                }
            } else {
                foreach ($request->material_id as  $key => $data) {
                    $BoqEmeRateData = [
                        'parent_id_second'  =>  $request->parent_id_second,
                        'boq_work_name'     =>  null,
                        'labor_unit'        =>  null,
                        'material_id'       =>  $request->material_id[$key],
                        'labour_rate'       =>  $request->labour_rate[$key],
                        'created_at'        =>  now(),
                        'updated_at'        =>  now()
                    ];
                }
            }

            DB::transaction(function () use ($BoqEmeRateData, $BoqEmeDatas) {
                $BoqEmeDatas->update($BoqEmeRateData);
            });

            return redirect()->route('boq.project.departments.electrical.configurations.rates.index', $project)->with('message', 'Data has been updated successfully');
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project, $BoqEmeRateId)
    {
        try {
            $BoqEmeDatas =  BoqEmeRate::findOrFail($BoqEmeRateId);
            $BoqEmeDatas->delete();
            return redirect()->route('boq.project.departments.electrical.configurations.rates.index', $project)->with('message', 'Data has been Deleted successfully');
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }
}
