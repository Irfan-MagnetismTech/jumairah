<?php

namespace App\Http\Controllers\Boq\Departments\Electrical\Loadcalculation;

use App\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Approval\ApprovalLayerDetails;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\QueryException;
use App\Boq\Departments\Eme\BoqEmeLoadCalculation;
use App\Boq\Departments\Eme\BoqEmeLoadCalculationDetails;
use App\Http\Requests\Boq\Eme\BoqEmeLoadcalculationRequest;

class EmeLoadCalculationController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */


  use HasRoles;
  function __construct()
  {
    $this->middleware('permission:boq-eme-load-calculation-view|boq-eme-load-calculation-create|boq-eme-load-calculation-edit|boq-eme-load-calculation-delete', ['only' => ['index', 'show']]);
    $this->middleware('permission:boq-eme-load-calculation-create', ['only' => ['create', 'store']]);
    $this->middleware('permission:boq-eme-load-calculation-edit', ['only' => ['edit', 'update']]);
    $this->middleware('permission:boq-eme-load-calculation-delete', ['only' => ['destroy']]);
  }

  public function index(Project $project)
  {
    //
    $boqemeloadcalculation = BoqEmeLoadCalculation::with('boq_eme_load_calculations_details')->latest()->where('project_id', $project->id)->get()->groupBy(['project_type', 'calculation_type']);
    return view('eme.load_calculation.index', compact('boqemeloadcalculation', 'project'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
    $formType = 'create';
    return view('eme.load_calculation.create', compact('formType'));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(BoqEmeLoadcalculationRequest $request)
  {
    //
    try {
      $load_calculation_data =  $request->only('project_type', 'calculation_type', 'total_connecting_wattage', 'demand_percent', 'total_demand_wattage', 'project_id', 'genarator_efficiency');
      $load_calculations_details = [];
      foreach ($request->material_id as  $key => $data) {
        $load_calculations_details[] = [
          'material_id'           =>   $request->material_id[$key],
          'floor_id'              =>   $request->floor_id[$key],
          'load'                  =>   $request->load[$key],
          'qty'                   =>   $request->qty[$key],
          'connected_load'        =>   $request->connected_load[$key]
        ];
      }
      DB::beginTransaction();
      $load_calculation = BoqEmeLoadCalculation::create($load_calculation_data);
      $load_calculation->boq_eme_load_calculations_details()->createMany($load_calculations_details);
      DB::commit();
      return redirect()->route('eme.eme_projects',)->with('message', 'Data has been inserted successfully');
    } catch (QueryException $e) {
      DB::rollback();
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
  public function edit(BoqEmeLoadCalculation $load_calculation)
  {
    //
    $formType = 'edit';
    return view('eme.load_calculation.create', compact('formType', 'load_calculation'));
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, BoqEmeLoadCalculation $load_calculation)
  {
    //
    try {
      $load_calculation_data =  $request->only('project_type', 'calculation_type', 'total_connecting_wattage', 'demand_percent', 'total_demand_wattage', 'project_id', 'genarator_efficiency');
      $load_calculations_details = [];
      foreach ($request->material_id as  $key => $data) {
        $load_calculations_details[] = [
          'material_id'           =>   $request->material_id[$key],
          'floor_id'              =>   $request->floor_id[$key],
          'load'                  =>   $request->load[$key],
          'qty'                   =>   $request->qty[$key],
          'connected_load'        =>   $request->connected_load[$key]
        ];
      }
      DB::beginTransaction();
      $load_calculation->update($load_calculation_data);
      $load_calculation->boq_eme_load_calculations_details()->delete();
      $load_calculation->boq_eme_load_calculations_details()->createMany($load_calculations_details);
      DB::commit();
      return redirect()->route('eme.eme_projects')->with('message', 'Data has been updated successfully');
    } catch (QueryException $e) {
      DB::rollback();
      return redirect()->back()->withInput()->withErrors($e->getMessage());
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy(Project $project, BoqEmeLoadCalculation $load_calculation)
  {
    //
    try {
      $load_calculation->delete();
      return redirect()->route('eme.eme_projects', $project)->with('message', 'Data has been deleted successfully');
    } catch (QueryException $e) {
      return redirect()->back()->withInput()->withErrors($e->getMessage());
    }
  }
  public function eme_projects()
  {
    $projects = Project::all();
    return view('eme.load_calculation.select-project', compact('projects'));
  }
  public function LoadCalculation(Project $project)
  {
    $boqemeloadcalculation = BoqEmeLoadCalculation::query()
      ->with('boq_eme_load_calculations_details')
      ->latest()
      ->where('project_id', $project->id)
      ->get()
      ->groupBy('project_type');
    return view('eme.load_calculation.show', compact('project', 'boqemeloadcalculation'));
  }

  public function Approve($BoqEmeLoadCalculationId, $status)
  {
    try {
      $BoqEmeLoadCalculation = BoqEmeLoadCalculation::findOrFail($BoqEmeLoadCalculationId);
      $approval = ApprovalLayerDetails::query()
        ->whereHas('approvalLayer', function ($q) use ($BoqEmeLoadCalculation) {
          $q->where([['name', 'BOQ EME LOAD CALCULATION'], ['department_id', $BoqEmeLoadCalculation->appliedBy->department_id]]);
        })->whereDoesntHave('approvals', function ($q) use ($BoqEmeLoadCalculation) {
          $q->where([['approvable_id', $BoqEmeLoadCalculation->id], ['approvable_type', BoqEmeLoadCalculation::class]]);
        })->orderBy('order_by', 'asc')->first();
      $data = [
        'layer_key' => $approval->layer_key,
        'user_id' => auth()->id(),
        'status' => $status,
      ];

      /* Check Last Approval */
      $check_approval = ApprovalLayerDetails::query()
        ->whereHas('approvalLayer', function ($q) use ($BoqEmeLoadCalculation) {
          $q->where([['name', 'BOQ EME LOAD CALCULATION'], ['department_id', $BoqEmeLoadCalculation->appliedBy->department_id]]);
        })->whereDoesntHave('approvals', function ($q) use ($BoqEmeLoadCalculation) {
          $q->where([['approvable_id', $BoqEmeLoadCalculation->id], ['approvable_type', BoqEmeLoadCalculation::class]]);
        })->orderBy('order_by', 'desc')->first();

      DB::transaction(function () use ($BoqEmeLoadCalculation, $data, $check_approval) {
        $approvalData = $BoqEmeLoadCalculation->approval()->create($data);
        if ($approvalData->layer_key == $check_approval->layer_key && $approvalData->status == 'Approved') {
        }
      });
      return redirect()->route('eme.eme_projects')->with('message', 'Data has been approved successfully');
    } catch (QueryException $e) {
      return redirect()->back()->withInput()->withErrors($e->getMessage());
    }
  }
  public function pdf(Project $project)
  {
    //
    $boqemeloadcalculation = BoqEmeLoadCalculation::with(['boq_eme_load_calculations_details', 'project'])->latest()->where('project_id', $project->id)->get()->groupBy(['project_type', 'calculation_type']);

    // return view('boq.departments.electrical.utility_bill.pdf', compact('BoqEmeUtilityBill'));
    $pdf = \PDF::loadview('eme.load_calculation.pdf', compact('boqemeloadcalculation', 'project'))->setPaper('A4', 'landscape');
    $pdf->output();
    $canvas = $pdf->getDomPDF()->getCanvas();

    $height = $canvas->get_height();
    $width = $canvas->get_width();

    $canvas->set_opacity(.15, "Multiply");

    $canvas->page_text(
      $width / 3,
      $height / 2,
      'Rancon FC',
      null,
      55,
      array(0, 0, 0),
      2,
      2,
      -30
    );
    return $pdf->stream('load_calculation.pdf');
  }
}
