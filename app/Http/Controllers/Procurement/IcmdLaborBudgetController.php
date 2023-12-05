<?php

namespace App\Http\Controllers\Procurement;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Procurement\IcmdLaborBudget;
use App\Approval\ApprovalLayerDetails;
use Illuminate\Database\QueryException;

class IcmdLaborBudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    function __construct()
    {
        $this->middleware('permission:masterrole-view|masterrole-create|masterrole-edit|masterrole-delete', ['only' => ['index','show']]);
        $this->middleware('permission:masterrole-create', ['only' => ['create','store']]);
        $this->middleware('permission:masterrole-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:masterrole-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datas = IcmdLaborBudget::query()->latest()->get();
        return view('procurement.icmdLaborBudget.index', compact('datas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $formType = "create";
        return view('procurement.icmdLaborBudget.create', compact('formType'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $laborBudgetData = $request->only('date', 'cost_center_id', 'month', 'total_amount');
            $laborBudgetDetailsData = [];
            foreach ($request->amount as $key => $value) {

                $laborBudgetDetailsData[] = [
                    'description'       => $request->description[$key],
                    'mason_no'          => $request->mason_no[$key] ?? 0,
                    'helper_no'         => $request->helper_no[$key] ?? 0,
                    'mason_rate'        => $request->mason_rate[$key] ?? 0,
                    'helper_rate'       => $request->helper_rate[$key] ?? 0,
                    'amount'            => $request->amount[$key],
                ];
            }

            DB::transaction(function () use ($laborBudgetData, $laborBudgetDetailsData) {
                $laborBudget = IcmdLaborBudget::create($laborBudgetData);

                $laborBudget->icmdlaborbudgetdetails()->createMany($laborBudgetDetailsData);
            });
            return redirect()->route('icmdLaborBudget.index')->with('message', 'Data has been inserted successfully');
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
    public function show(IcmdLaborBudget $icmdLaborBudget)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(IcmdLaborBudget $icmdLaborBudget)
    {
        $formType = "edit";
        return view('procurement.icmdLaborBudget.create', compact('formType', 'icmdLaborBudget'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, IcmdLaborBudget $icmdLaborBudget)
    {
        try {
            $laborBudgetData = $request->only('date', 'cost_center_id', 'month', 'total_amount');
            $laborBudgetDetailsData = [];
            foreach ($request->amount as $key => $value) {

                $laborBudgetDetailsData[] = [
                    'description'       => $request->description[$key],
                    'mason_no'          => $request->mason_no[$key] ?? 0,
                    'helper_no'         => $request->helper_no[$key] ?? 0,
                    'mason_rate'        => $request->mason_rate[$key] ?? 0,
                    'helper_rate'       => $request->helper_rate[$key] ?? 0,
                    'amount'            => $request->amount[$key],
                ];
            }

            DB::transaction(function () use ($icmdLaborBudget, $laborBudgetData, $laborBudgetDetailsData) {
                $icmdLaborBudget->update($laborBudgetData);
                $icmdLaborBudget->icmdlaborbudgetdetails()->delete();
                $icmdLaborBudget->icmdlaborbudgetdetails()->createMany($laborBudgetDetailsData);
            });
            return redirect()->route('icmdLaborBudget.index')->with('message', 'Data has been updated successfully');
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
    public function destroy(IcmdLaborBudget $icmdLaborBudget)
    {
        try {
            $icmdLaborBudget->delete();
            return redirect()->route('icmdLaborBudget.index')->with('message', 'Data has been deleted successfully');
        } catch (QueryException $e) {
            return redirect()->route('icmdLaborBudget.index')->withErrors($e->getMessage());
        }
    }

    public function Pdf($id)
    {
        // $iou = Iou::findOrFail($id);
        // return PDF::loadview('procurement.ious.ioureportpdf', compact('iou'))->stream('iou'.$iou->iou_no.'pdf');



    }


    public function Approve(IcmdLaborBudget $icmdLaborBudget, $status)
    {
        try{
            DB::beginTransaction();
            $approval = ApprovalLayerDetails::whereHas('approvalLayer', function ($q) use ($icmdLaborBudget) {
                $q->where([['name', 'MASTER ROLE'], ['department_id', $icmdLaborBudget->appliedBy->department_id]]);
            })->whereDoesntHave('approvals', function ($q) use ($icmdLaborBudget) {
                $q->where('approvable_id', $icmdLaborBudget->id)
                    ->where('approvable_type', IcmdLaborBudget::class);
            })->orderBy('order_by', 'asc')->first();

            $data = [
                'layer_key' => $approval->layer_key,
                'user_id' => auth()->id(),
                'status' => $status,
            ];

            /* Check Last Approval */
            $check_approval = ApprovalLayerDetails::whereHas('approvalLayer', function ($q) use ($icmdLaborBudget) {
                $q->where([['name', 'MASTER ROLE'], ['department_id', $icmdLaborBudget->appliedBy->department_id]]);
            })->whereDoesntHave('approvals', function ($q) use ($icmdLaborBudget) {
                $q->where('approvable_id', $icmdLaborBudget->id)
                    ->where('approvable_type', IcmdLaborBudget::class);
            })->orderBy('order_by', 'desc')->first();

            $approvalData = $icmdLaborBudget->approval()->create($data);
            DB::commit();
            if ($approvalData->layer_key == $check_approval->layer_key && $approvalData->status == 'Approved') {
               
            }
            return redirect()->route('icmdLaborBudget.index')->with('message', 'Data has been approved successfully');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }

    }
}
