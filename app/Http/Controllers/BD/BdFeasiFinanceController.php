<?php

namespace App\Http\Controllers\BD;

use App\Approval\Approval;
use App\Approval\ApprovalLayer;
use App\Approval\ApprovalLayerDetails;
use App\BD\BdFeasiFinance;
use App\BD\BdLeadGeneration;
use App\Http\Controllers\Controller;
use App\Http\Requests\BD\BdFeasiFinanceRequest;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BdFeasiFinanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:bd-Feasibility-finance-view|bd-Feasibility-finance-create|bd-Feasibility-finance-edit|bd-Feasibility-finance-delete', ['only' => ['index','show']]);
        $this->middleware('permission:bd-Feasibility-finance-create', ['only' => ['create','store']]);
        $this->middleware('permission:bd-Feasibility-finance-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:bd-Feasibility-finance-delete', ['only' => ['destroy']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $finance = BdFeasiFinance::latest()->get();

        return view('bd.finance.index', compact('finance'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $formType = 'create';
        $locations = BdLeadGeneration::get()->pluck('full_location', 'id');
        return view('bd.finance.create', compact('formType', 'locations'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BdFeasiFinanceRequest $request)
    {
        try{
            $request_data                     = $request->only('location_id','rate','inflow_amount','outflow_amount','total_interest');
            $request_data['user_id']          = auth()->id();

            $reference_request_details = [];
            foreach($request->schedule_no as $key => $data)
            {
                // $month = $this->formatDate($request->month[$key]);
                $reference_request_details[] = [
                    'schedule_no'                =>  $request->schedule_no[$key],
                    'month'                      =>  $request->month[$key],
                    'amount'                     =>  $request->amount[$key] ?? null,
                    'outflow_rate'               =>  $request->outflow_rate[$key],
                    'inflow_rate'                =>  $request->inflow_rate[$key],
                    'outflow'                    =>  $request->outflow[$key],
                    'inflow'                     =>  $request->inflow[$key],
                    'net'                        =>  $request->net[$key],
                    'interest'                   =>  $request->interest[$key],
                    'cumulitive'                 =>  $request->cumulitive[$key]
                ];
            }
            DB::transaction(function()use($request_data, $reference_request_details){
                $BdFeasiFinance= BdFeasiFinance::create($request_data);
                $BdFeasiFinance->financeDetails()->createMany($reference_request_details);
            });

            return redirect()->route('finance.index')->with('message', 'Budget has been inserted successfully');
        }catch(QueryException $e){
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
    public function edit(BdFeasiFinance $finance)
    {
        $formType = 'edit';
        $locations = BdLeadGeneration::get()->pluck('full_location', 'id');
        return view('bd.finance.create', compact('formType', 'locations', 'finance'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BdFeasiFinanceRequest $request, BdFeasiFinance $finance)
    {
        try{
            $request_data                     = $request->only('location_id','rate','inflow_amount','outflow_amount','total_interest');
            $reference_request_details = [];
            foreach($request->schedule_no as $key => $data)
            {
                // $month = $this->formatDate($request->month[$key]);
                $reference_request_details[] = [
                    'schedule_no'                =>  $request->schedule_no[$key],
                    'month'                      =>  $request->month[$key],
                    'amount'                     =>  $request->amount[$key] ?? null,
                    'outflow_rate'               =>  $request->outflow_rate[$key],
                    'inflow_rate'                =>  $request->inflow_rate[$key],
                    'outflow'                    =>  $request->outflow[$key],
                    'inflow'                     =>  $request->inflow[$key],
                    'net'                        =>  $request->net[$key],
                    'interest'                   =>  $request->interest[$key],
                    'cumulitive'                 =>  $request->cumulitive[$key]
                ];
            }
            DB::transaction(function()use($request_data, $reference_request_details, $finance){
                $finance->update($request_data);
                $finance->financeDetails()->delete();
                $finance->financeDetails()->createMany($reference_request_details);
            });

            return redirect()->route('finance.index')->with('message', 'Budget has been updated successfully');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(BdFeasiFinance $finance)
    {
        try{
            $finance->delete();
            return redirect()->route('finance.index')->with('message', 'Data has been deleted successfully');
        }catch(QueryException $e){
            return redirect()->route('finance.index')->withErrors($e->getMessage());
        }
    }

    public function Approved($id,$status)
    {
        try {
            DB::beginTransaction();
            $finance = BdFeasiFinance::findOrFail($id);
            $approval = ApprovalLayerDetails::whereHas('approvalLayer', function ($q) use ($finance) {
                $q->where([['name', 'Feasibility Finance'], ['department_id', $finance->appliedBy->department_id]]);
            })->whereDoesntHave('approvals', function ($q) use ($finance) {
                $q->where('approvable_id', $finance->id)
                    ->where('approvable_type', BdFeasiFinance::class);
            })->orderBy('order_by', 'asc')->first();
            $data = [
                'layer_key' => $approval->layer_key,
                'user_id' => auth()->id(),
                'status' => $status,
            ];

            /* Check Last Approval */
            $check_approval = ApprovalLayerDetails::whereHas('approvalLayer', function ($q) use ($finance) {
                $q->where([['name', 'Feasibility Finance'], ['department_id', $finance->appliedBy->department_id]]);
            })->whereDoesntHave('approvals', function ($q) use ($finance) {
                $q->where('approvable_id', $finance->id)
                    ->where('approvable_type', BdFeasiFinance::class);
            })->orderBy('order_by', 'desc')->first();
                $approvalData = $finance->approval()->create($data);
            DB::commit();
            if ($approvalData->layer_key == $check_approval->layer_key && $approvalData->status == 'Approved') {
               
            }
            return redirect()->route('finance.index')->with('message', 'Data has been approved successfully');
        } catch (QueryException $e) {
            DB::rollback();
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }

    }

    /**
     *  Formats the date into y-m.
     *
     * @return string
     */
    private function formatDate(string $date): string
    {
        return substr( date_format(date_create($date),"y-m"), 0);
    }

    public function paymentSchedule()
    {
        $approval_layer = ApprovalLayer::where('name', 'like', 'Feasibility Finance')->first();
        $approval_layer_details = $approval_layer->approvalLeyarDetails->last();

        $BdFeasiFinanceApproval = Approval::whereHas('approvable', function ($q) {
            $q->where('approvable_type', BdFeasiFinance::class);
        })->orderBy('id', 'desc') ->first();

            $finance = BdFeasiFinance::latest()->get();

        return view('bd.finance.payment-schedule', compact('finance'));
    }
}
