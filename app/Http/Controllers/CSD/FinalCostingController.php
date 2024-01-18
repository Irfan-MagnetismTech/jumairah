<?php

namespace App\Http\Controllers\CSD;

use App\CSD\CsdFinalCosting;
use App\CSD\CsdFinalCosting as CSDCsdFinalCosting;
use App\CSD\CsdFinalCostingDemand;
use App\CSD\CsdFinalCostingRefund;
use App\CSD\CsdMaterialRate;
use App\Http\Controllers\Controller;
use App\Http\Requests\CSD\FinalCostingRequest;
use App\Procurement\Unit;
use App\Project;
use App\Sells\Apartment;
use App\SellsClient;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Approval\ApprovalLayerDetails;
use App\Sells\Sell;
use Barryvdh\DomPDF\Facade as PDF;

class FinalCostingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:csd-final-costing-view|csd-final-costing-create|csd-final-costing-edit|csd-final-costing-delete', ['only' => ['index','show']]);
        $this->middleware('permission:csd-final-costing-create', ['only' => ['create','store']]);
        $this->middleware('permission:csd-final-costing-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:csd-final-costing-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $costings = CsdFinalCosting::latest()->get();
        return view('csd.costing.index', compact('costings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $formType = 'create';
        $clients = [];
        $projects = Project::orderBy('name')->pluck('name', 'id');
        return view('csd.costing.create', compact( 'formType','projects','clients'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FinalCostingRequest $request)
    {
        try {
            $final_costing = $request->only('project_id', 'apartment_id', 'sell_id');
            $final_costing_demand = array();
            foreach ($request->material_id as  $key => $data) {
                $final_costing_demand[] = [

                    'material_id'       =>  $request->material_id[$key],
                    // 'unit_id'           =>  $request->unit_id[$key],
                    'demand_rate'       =>  $request->demand_rate[$key],
                    'quantity'          =>  $request->quantity[$key],
                    'amount'            =>  $request->amount[$key]
                ];
            }

            $final_costing_refund = array();
            foreach ($request->material_id_refund as  $key => $data) {
                $final_costing_refund[] = [

                    'material_id_refund'        =>  $request->material_id_refund[$key],
                    // 'unit_id_refund'            =>  $request->unit_id_refund[$key],
                    'refund_rate'               =>  $request->refund_rate[$key],
                    'quantity_refund'           =>  $request->quantity_refund[$key],
                    'amount_refund'             =>  $request->amount_refund[$key]
                ];
            }

            DB::transaction(function () use ($final_costing, $final_costing_demand, $final_costing_refund) {
                $csd_final_costing = CsdFinalCosting::create($final_costing);
                $csd_final_costing->csdFinalCostingDemand()->createMany($final_costing_demand);
                $csd_final_costing->csdFinalCostingRefund()->createMany($final_costing_refund);
            });

            return redirect()->route('csd.costing.index')->with('message', 'Data has been inserted successfully');
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
    public function show(CsdFinalCosting $costing)
    {
        $client = SellsClient::with('client')->where('sell_id', $costing->sell_id)->first();
        return view('csd.costing.show', compact('costing', 'client'));
    }

    public function projectList()
    {
        $data = CsdFinalCosting::orderBy('project_id')->latest()->get();
        $projects = $data->groupBy('project_id')->all();
        return view('csd.costing.projectlist', compact(   'projects'));
    }

    public function apartmentList($project_id)
    {
        $apartments = CsdFinalCosting::where('project_id', $project_id)->get();
        return view('csd.costing.apartmentlist', compact(   'apartments'));
    }


    public function apartmentCostingDetails($costing_id)
    {
        $project = CsdFinalCosting::where('id', $costing_id)->first();
        $client = CsdFinalCosting::where('sell_id', $project->sell_id)->first();
        $csd_final_costing_demand = CsdFinalCostingDemand::where('csd_final_costing_id', $costing_id)->get();
        $csd_final_costing_refund = CsdFinalCostingRefund::where('csd_final_costing_id', $costing_id)->get();
        $payment_received = CsdFinalCosting::with('sellCollections.salesCollectionDetails')->where('sell_id', $project->sell_id)->first();

        return view('csd.costing.apartment_details', compact('payment_received', 'client', 'csd_final_costing_demand', 'csd_final_costing_refund', 'project', 'costing_id'));
    }



    /**
     * pdf for specific month of a year.
     *
     * @param  int  $year $month
     * @return \Illuminate\Http\Response
     */
    public function pdf($costing_id)
    {
        $costing = CsdFinalCosting::where('id', $costing_id)->first();
        $client = SellsClient::with('client')->where('sell_id', $costing->sell_id)->first();
        $project = CsdFinalCosting::where('id', $costing_id)->first();
        $csd_final_costing_demand = CsdFinalCostingDemand::where('csd_final_costing_id', $costing_id)->get();
        $csd_final_costing_refund = CsdFinalCostingRefund::where('csd_final_costing_id', $costing_id)->get();
        $payment_received = CsdFinalCosting::with('sellCollections.salesCollectionDetails')->where('sell_id', $project->sell_id)->first();
        return PDF::loadview('csd.costing.pdf', compact('payment_received', 'costing', 'client',  'project', 'csd_final_costing_demand', 'csd_final_costing_refund'))->setPaper('a4', 'landscape')->stream('final-costing.pdf');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(CSDCsdFinalCosting $costing)
    {
        $client = CSDCsdFinalCosting::with('sellClients.client')->where('sell_id', $costing->sell_id)->first();
        $formType = 'edit';
        $clients = [];
        $projects = Project::orderBy('name')->pluck('name', 'id');
        return view('csd.costing.create', compact( 'formType','projects','client', 'clients','costing'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(FinalCostingRequest $request, CSDCsdFinalCosting $costing)
    {

        try {

            $final_costing = $request->only('project_id', 'apartment_id', 'sell_id');

            $final_costing_demand = array();
            foreach ($request->material_id as  $key => $data) {
                $final_costing_demand[] = [

                    'material_id'       =>  $request->material_id[$key],
                    // 'unit_id'           =>  $request->unit_id[$key],
                    'demand_rate'       =>  $request->demand_rate[$key],
                    'quantity'          =>  $request->quantity[$key],
                    'amount'            =>  $request->amount[$key]
                ];
            }

            $final_costing_refund = array();
            foreach ($request->material_id_refund as  $key => $data) {
                $final_costing_refund[] = [

                    'material_id_refund'        =>  $request->material_id_refund[$key],
                    // 'unit_id_refund'            =>  $request->unit_id_refund[$key],
                    'refund_rate'               =>  $request->refund_rate[$key],
                    'quantity_refund'           =>  $request->quantity_refund[$key],
                    'amount_refund'             =>  $request->amount_refund[$key]
                ];
            }

            DB::transaction(function () use ($costing, $final_costing, $final_costing_demand, $final_costing_refund) {
                $costing->update($final_costing);
                $costing->csdFinalCostingDemand()->delete();
                $costing->csdFinalCostingDemand()->createMany($final_costing_demand);
                $costing->csdFinalCostingRefund()->delete();
                $costing->csdFinalCostingRefund()->createMany($final_costing_refund);
            });

            return redirect()->route('csd.costing.index')->with('message', 'Data has been updated successfully');
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function csdApproval($id){
        try{
        $csd_approval['status'] = "Accepted";
        CsdFinalCosting::where('id', $id)->update($csd_approval);
        return redirect()->route('csd.apartment-final-costing-details', $id)->with('message', 'Request has been Approved successfully');
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function auditApproval($id){
        try{
        $csd_approval['status'] = "Checked";
        CsdFinalCosting::where('id', $id)->update($csd_approval);
        return redirect()->route('csd.apartment-final-costing-details', $id)->with('message', 'Request has been Approved successfully');
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function ceoApproval($id){
        try{
        $csd_approval['status'] = "Approved";
        CsdFinalCosting::where('id', $id)->update($csd_approval);
        return redirect()->route('csd.apartment-final-costing-details', $id)->with('message', 'Request has been Approved successfully');
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }


    public function csd_Approved(CsdFinalCosting $costing_id, $status)
    {
        try{
             $approval = ApprovalLayerDetails::whereHas('approvallayer', function ($q){
                 $q->where('name','Final Costing');
             })->whereDoesntHave('approvals',function ($q) use($costing_id){
                 $q->where('approvable_id',$costing_id->id)->where('approvable_type',CsdFinalCosting::class);
             })->orderBy('order_by','asc')->first();

             $data = [
                 'layer_key' => $approval->layer_key,
                 'user_id' => auth()->id(),
                 'status' => $status,
             ];
             $costing_id->approval()->create($data);
            return redirect()->route('csd.apartment-final-costing-details',$costing_id->id)->with('message', "Final Costing No $costing_id->reference_no approved.");
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
    public function destroy($id)
    {
        //
    }

    public function clientList()
    {
        $sales = Sell::with('sellClients','apartment.project')->get();
        return view('csd.costing.clientList', compact('sales'));
    }
}
