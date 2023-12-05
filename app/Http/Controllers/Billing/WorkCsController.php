<?php

namespace App\Http\Controllers\Billing;

use App\Billing\WorkCs;
use App\Approval\Approval;
use Illuminate\Http\Request;
use App\Billing\WorkCsSupplier;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Approval\ApprovalLayerDetails;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\QueryException;
use Facade\Ignition\QueryRecorder\Query;
use App\Http\Requests\StoreWorkCsRequest;
use App\Http\Requests\UpdateWorkCsRequest;
use App\Procurement\Unit;
use App\Services\UniqueNoGenaratorService;

class WorkCsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $uniqueNoGenarate;
    use HasRoles;
    function __construct()
    {
        $this->middleware('permission:work-cs-view|work-cs-create|work-cs-edit|work-cs-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:work-cs-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:work-cs-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:work-cs-delete', ['only' => ['destroy']]);
        $this->uniqueNoGenarate = new UniqueNoGenaratorService();
    }

    public function index()
    {
        $workC = WorkCs::latest()->get();
        return view('billing.work-cs.index', compact('workC'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $units = Unit::pluck('name');
        $csTypes = ['Civil Work', 'Paint & Polish Work', 'Glazing Work', 'Sanitary & Plumbing Work'];
        return view('billing.work-cs.create', compact('units', 'csTypes'));
    }

    /**
     * Store a newly created resource in storage.
     * @param  \App\Http\Requests\StoreWorkCsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreWorkCsRequest $request)
    {
        try {
            $workCData = $request->only('project_id', 'title', 'cs_type', 'effective_date', 'expiry_date', 'remarks', 'description', 'involvement', 'is_for_all', 'notes');
            $workCData['reference_no'] = $this->uniqueNoGenarate->generateUniqueNo(WorkCs::class, 'WorkCs', 'project_id', $request->project_id, 'reference_no');
            // $workCData['title'] = $request->cs_title;
            $workCData['is_saved'] = 1;
            $work_cs_suppliers = array();
            foreach ($request->supplier_id as  $key => $data) {
                $work_cs_suppliers[] = [
                    'supplier_id' => $request->supplier_id[$key],
                    'is_checked' => in_array($request->supplier_id[$key], $request['checked_supplier']) ? true : false,
                    'vat' => $request->vat[$key],
                    'advanced' => $request->advanced[$key],
                ];
            }
            $involvment = [];
            // dd(!empty($request->detail));
            if(!empty($request->detail)){
                foreach ($request->detail as  $key => $data) {
                    $involvment[] = [
                        'detail' => $request->detail[$key],
                    ];
                }
            }


            $work_cs_levels = array();
            foreach ($request->work_level as  $key => $data) {
                $work_cs_levels[] = [
                    'work_level' => $request->work_level[$key],
                    'work_description' => $request->work_description[$key],
                    'work_quantity' => $request->work_quantity[$key],
                    'work_unit' => $request->work_unit[$key],
                ];
            }
            DB::transaction(function () use ($workCData, $work_cs_suppliers, $work_cs_levels, $request, $involvment) {
                $workC = WorkCs::create($workCData);
                $cs_suppliers = $workC->workCsSuppliers()->createMany($work_cs_suppliers);
                $cs_works = $workC->workCsLines()->createMany($work_cs_levels);
                $workC->csSuppliersRates()->createMany($this->getMaterialSuppliersDetails($cs_works, $cs_suppliers, $request));
                $workC->workCsInvolvment()->createMany($involvment);
            });
            return redirect()->route('work-cs.index')->with('message', 'Data has been inserted successfully');
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Billing\WorkCs  $workC
     * @return \Illuminate\Http\Response
     */
    public function show(WorkCs $workC)
    {
        $units = Unit::pluck('name');
        $csTypes = ['Civil Work', 'Paint & Polish Work', 'Glazing Work', 'Sanitary & Plumbing Work'];
        return view('billing.work-cs.create', compact('workC', 'units', 'csTypes'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Billing\WorkCs  $workC
     * @return \Illuminate\Http\Response
     */
    public function edit(WorkCs $workC)
    {
        // dd($workC);
        $units = Unit::pluck('name');
        $csTypes = ['Civil Work', 'Paint & Polish Work', 'Glazing Work', 'Sanitary & Plumbing Work'];
        return view('billing.work-cs.create', compact('units', 'workC', 'csTypes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateWorkCsRequest  $request
     * @param  \App\Billing\WorkCs  $workC
     * @return \Illuminate\Http\Response
     */
    public function update(StoreWorkCsRequest $request, WorkCs $workC)
    {
        // dd($request->all());
        try {
            // $workCData = []
            $workCData = $request->only('title', 'project_id', 'cs_type', 'effective_date', 'expiry_date', 'remarks', 'description', 'involvement', 'is_for_all', 'notes');
            if (($request->project_id != $workC->project_id) || $request->reference_no == null) {
                $workCData['reference_no'] = $this->uniqueNoGenarate->generateUniqueNo(WorkCs::class, 'WorkCs', 'project_id', $request->project_id, 'reference_no');
            }

            $workCData['is_saved'] = 1;
            $work_cs_suppliers = array();
            foreach ($request->supplier_id as  $key => $data) {
                $work_cs_suppliers[] = [
                    'supplier_id' => $request->supplier_id[$key],
                    'is_checked' => in_array($request->supplier_id[$key], $request['checked_supplier']) ? true : false,
                    'vat' => $request->vat[$key],
                    'advanced' => $request->advanced[$key],
                ];
            }
            $involvment = [];
            // dd($request->detail);
            if(!empty($request->detail)){
                foreach ($request->detail as  $key => $data) {
                    $involvment[] = [
                        'detail' => $request->detail[$key],
                    ];
                }
            }

            // dd($work_cs_suppliers);
            $work_cs_levels = array();
            foreach ($request->work_level as  $key => $data) {
                $work_cs_levels[] = [
                    'work_level' => $request->work_level[$key],
                    'work_description' => $request->work_description[$key],
                    'work_quantity' => $request->work_quantity[$key],
                    'work_unit' => $request->work_unit[$key],
                ];
            }
            DB::transaction(function () use ($workCData, $work_cs_suppliers, $work_cs_levels, $request, $workC, $involvment) {
                $workC->update($workCData);

                $workC->workCsSuppliers()->delete();
                $cs_suppliers = $workC->workCsSuppliers()->createMany($work_cs_suppliers);

                $workC->workCsLines()->delete();
                $cs_works = $workC->workCsLines()->createMany($work_cs_levels);

                $workC->csSuppliersRates()->delete();
                $workC->csSuppliersRates()->createMany($this->getMaterialSuppliersDetails($cs_works, $cs_suppliers, $request));

                $workC->workCsInvolvment()->delete();
                $workC->workCsInvolvment()->createMany($involvment);
            });
            return redirect()->route('work-cs.index')->with('message', 'Data has been updated successfully.');
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Billing\WorkCs  $workC
     * @return \Illuminate\Http\Response
     */
    public function destroy(WorkCs $workC)
    {
        try {
            $workC->delete();
            return redirect()->route('work-cs.index')->with('message', 'Data has been deleted successfully.');
        } catch (QueryException $e) {
            return redirect()->route('work-cs.index')->withErrors($e->getMessage());
        }
    }


    private function getMaterialSuppliersDetails($cs_works, $cs_suppliers, $request): array
    {
        $price_index = 0;
        foreach ($cs_works as $cs_work) {
            foreach ($cs_suppliers as $cs_supplier) {
                $cs_materials_suppliers[] = [
                    'work_cs_id' => $cs_supplier->work_cs_id ?? null,
                    'work_cs_supplier_id' => $cs_supplier->supplier_id ?? null,
                    'work_cs_line_id' => $cs_work->id ?? null,
                    'price' => $request['price'][$price_index++] ?? null,
                ];
            }
        }
        return $cs_materials_suppliers;
    }

    public function pdf(WorkCs $workCs)
    {
        $workCs->load('appliedBy.employee');
        $approvals = Approval::query()->with(['user.employee', 'approvalLayerDetails'])->where('approvable_id', $workCs->id)->where('approvable_type', WorkCs::class)->get();

        // dd($workCs);
        return \PDF::loadview('billing.work-cs.pdf', compact('workCs', 'approvals'))->setPaper('a4', 'landscape')->stream('billing.work-cs.pdf');
        return view('billing.work-cs.pdf', compact('workCs', 'approvals'));
    }



    public function DraftSave(Request $request)
    {
        try {
            $workCData = $request->only('project_id', 'cs_type', 'reference_no', 'effective_date', 'expiry_date', 'remarks', 'description', 'involvement', 'title');
            // $workCData['title'] = $request->cs_title;
            $workCData['user_id'] = auth()->user()->id;

            $work_cs_suppliers = array();
            if (isset($request->supplier_id)) {
                foreach ($request->supplier_id as  $key => $data) {
                    $work_cs_suppliers[] = [
                        'supplier_id' => $request->supplier_id[$key] ?? null,
                        'is_checked' => isset($request->supplier_id[$key]) && $request['checked_supplier'] ? (in_array($request->supplier_id[$key], $request['checked_supplier']) ? true : false) : 0,
                        'vat' => $request->vat[$key],
                        'advanced' => $request->advanced[$key],
                    ];
                }
            }

            $work_cs_levels = array();
            if (isset($request->work_level)) {
                foreach ($request->work_level as  $key => $data) {
                    $work_cs_levels[] = [
                        'work_level' => $request->work_level[$key] ?? null,
                        'work_description' => $request->work_description[$key] ?? null,
                        'work_quantity' => $request->work_quantity[$key] ?? null,
                        'work_unit' => $request->work_unit[$key] ?? null,
                    ];
                }
            }

            if (isset($request->draft_id) && $request->draft_id != null) {
                $workC = WorkCs::findOrFail($request->draft_id);
                DB::transaction(function () use ($workCData, $work_cs_suppliers, $work_cs_levels, $request, $workC) {
                    $workC->update($workCData);

                    if (count($work_cs_suppliers) != 0) {
                        $workC->workCsSuppliers()->delete();
                        $cs_suppliers = $workC->workCsSuppliers()->createMany($work_cs_suppliers);
                    }
                    if (count($work_cs_levels) != 0) {
                        $workC->workCsLines()->delete();
                        $cs_works = $workC->workCsLines()->createMany($work_cs_levels);
                    }
                    if (isset($cs_suppliers) && isset($cs_works) && (isset($request['price']) && $request['price'] > 0)) {
                        $workC->csSuppliersRates()->delete();
                        $workC->csSuppliersRates()->createMany($this->getMaterialSuppliersDetails($cs_works, $cs_suppliers, $request));
                    }
                });
            } else {
                DB::transaction(function () use ($workCData, $work_cs_suppliers, $work_cs_levels, $request, &$workC) {
                    $workC = WorkCs::create($workCData);
                    if (count($work_cs_suppliers) != 0) {
                        $cs_suppliers = $workC->workCsSuppliers()->createMany($work_cs_suppliers);
                    }
                    if (count($work_cs_levels) != 0) {
                        $cs_works = $workC->workCsLines()->createMany($work_cs_levels);
                    }
                    if (isset($cs_suppliers) && isset($cs_works) && (isset($request['price']) && $request['price'] > 0)) {
                        $workC->csSuppliersRates()->createMany($this->getMaterialSuppliersDetails($cs_works, $cs_suppliers, $request));
                    }
                });
            }
            return redirect()->route('work-cs.index')->with('message', 'Draft has been saved successfully.');
        } catch (QueryException $err) {
            return redirect()->route('work-cs.index')->withErrors($err->getMessage());
        }
    }

    public function Approve(WorkCs $workCs, $status)
    {
        try {
            $approval = ApprovalLayerDetails::whereHas('approvalLayer', function ($q) use ($workCs) {
                $q->where([['name', 'WORK CS'], ['department_id', $workCs->appliedBy->department_id]]);
            })->whereDoesntHave('approvals', function ($q) use ($workCs) {
                $q->where('approvable_id', $workCs->id)
                    ->where('approvable_type', WorkCs::class);
            })->orderBy('order_by', 'asc')->first();
            $data = [
                'layer_key' => $approval->layer_key,
                'user_id' => auth()->id(),
                'status' => $status,
            ];

            /* Check Last Approval */
            $check_approval = ApprovalLayerDetails::whereHas('approvalLayer', function ($q) use ($workCs) {
                $q->where([['name', 'WORK CS'], ['department_id', $workCs->appliedBy->department_id]]);
            })->whereDoesntHave('approvals', function ($q) use ($workCs) {
                $q->where('approvable_id', $workCs->id)
                    ->where('approvable_type', WorkCs::class);
            })->orderBy('order_by', 'desc')->first();

            DB::transaction(function () use ($workCs, $data, $check_approval) {
                $approvalData = $workCs->approval()->create($data);
                if ($approvalData->layer_key == $check_approval->layer_key && $approvalData->status == 'Approved') {
                }
            });
            return redirect()->route('work-cs.index')->with('message', 'Data has been approved successfully.');
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function Copy(WorkCs $workCs)
    {
        try {
            DB::beginTransaction();
            $price['price'] = $workCs->csSuppliersRates->pluck('price')->toArray();
            $workCs['reference_no'] = $this->uniqueNoGenarate->generateUniqueNo(WorkCs::class, 'WorkCs', 'project_id', $workCs->project_id, 'reference_no');
            $workCs['user_id'] = auth()->id();
            $workC = WorkCs::create($workCs->toArray());
            $cs_suppliers = $workC->workCsSuppliers()->createMany($workCs->workCsSuppliers->toArray());
            $cs_works = $workC->workCsLines()->createMany($workCs->workCsLines->toArray());
            $workC->csSuppliersRates()->createMany($this->getMaterialSuppliersDetails($cs_works, $cs_suppliers, $price));
            $workC->workCsInvolvment()->createMany($workCs->workCsInvolvment->toArray());
            DB::commit();
            return redirect()->route('work-cs.index')->with('message', 'Data has been copied successfully.');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }
}
