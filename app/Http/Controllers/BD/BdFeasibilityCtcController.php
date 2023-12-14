<?php

namespace App\Http\Controllers\BD;

use App\BD\BdFeasibilityCtc;
use App\BD\BdFeasiCtcRate;
use App\BD\BdLeadGeneration;
use App\Department;
use App\Designation;
use App\Http\Controllers\Controller;
use App\Http\Requests\BD\BdFeasibilityCtcRequest;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BdFeasibilityCtcController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:bd-Feasibility-CTC-view|bd-Feasibility-CTC-create|bd-Feasibility-CTC-edit|bd-Feasibility-CTC-delete', ['only' => ['index','show']]);
        $this->middleware('permission:bd-Feasibility-CTC-create', ['only' => ['create','store']]);
        $this->middleware('permission:bd-Feasibility-CTC-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:bd-Feasibility-CTC-delete', ['only' => ['destroy']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $bd_ctc = BdFeasibilityCtc::latest()->get();
       return view('bd.ctc.index', compact('bd_ctc'));
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
        $departments = ['Project' => 'Project','Head-Office' => 'Head-Office'];
        $designations = Designation::pluck('name', 'id');
        $employment_nature = [
            'Permanent','Casual','Contractual','Sharing'
        ];
        
       $rate_data = BdFeasiCtcRate::all();
        $employment_nature = array_combine($employment_nature,$employment_nature);
        return view('bd.ctc.create', compact('formType', 'departments', 'designations', 'employment_nature', 'locations','rate_data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BdFeasibilityCtcRequest $request)
    {
     

        try{
            DB::beginTransaction();
            $request_data                     = $request->only('location_id','grand_total_payable','grand_total_effect');
            $request_data['user_id']          = auth()->id();
            $request_details_data = array();
            foreach($request->designation_id as  $key => $data){
                $request_details_data[] = [
                    'department_id'     =>  $request->department_id[$key],
                    'designation_id'    =>  $request->designation_id[$key],
                    'employment_nature' =>  $request->employment_nature[$key],
                    'percent_sharing'   =>  $request->percent_sharing[$key],
                    'number'            =>  $request->number[$key],
                    'gross_salary'      =>  $request->gross_salary[$key],
                    'mobile_bill'       =>  $request->mobile_bill[$key],
                    'providend_fund'    =>  $request->providend_fund[$key],
                    'providend_fund_cent'=>  $request->providend_fund_cent[$key],
                    'bonus'             =>  $request->bonus[$key],
                    'bonus_cent'        =>  $request->bonus_cent[$key],
                    'Long_term_benefit' =>  $request->Long_term_benefit[$key],
                    'canteen_expense'   =>  $request->canteen_expense[$key],
                    'earned_encashment' =>  $request->earned_encashment[$key],
                    'others'            =>  $request->others[$key],
                    'total_payable'     =>  $request->total_payable[$key],
                    'total_effect'      =>  $request->total_effect[$key],
                    'percent_on_slry'   =>  $request->percent_on_slry[$key],
                ];
            }

                $BdFeasibilityCtc = BdFeasibilityCtc::create($request_data);
                $BdFeasibilityCtc->BdFeasiCtcDetail()->createMany($request_details_data);
                BdFeasiCtcRate::query()->delete();
                BdFeasiCtcRate::insert($request_details_data);
            DB::commit();
            return redirect()->route('ctc.index')->with('message', 'Data has been inserted successfully');
        }
        catch(QueryException $e){
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
    public function edit(BdFeasibilityCtc $ctc)
    {
        $formType = 'edit';
        $locations = BdLeadGeneration::get()->pluck('full_location', 'id');
        $departments = ['Project' => 'Project','Head-Office' => 'Head-Office'];
        $designations = Designation::pluck('name', 'id');
        $employment_nature = [
            'Permanent','Casual','Contractual','Sharing'
        ];
        $employment_nature = array_combine($employment_nature,$employment_nature);
        return view('bd.ctc.create', compact('formType', 'departments', 'designations', 'employment_nature', 'locations','ctc'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BdFeasibilityCtc $ctc)
    {
        try{
            DB::beginTransaction();
            $request_data               = $request->only('location_id','grand_total_payable','grand_total_effect');
            $request_details_data = array();
            foreach($request->designation_id as  $key => $data){
                $request_details_data[] = [
                    'department_id'     =>  $request->department_id[$key],
                    'designation_id'    =>  $request->designation_id[$key],
                    'employment_nature' =>  $request->employment_nature[$key],
                    'percent_sharing'   =>  $request->percent_sharing[$key],
                    'number'            =>  $request->number[$key],
                    'gross_salary'      =>  $request->gross_salary[$key],
                    'mobile_bill'       =>  $request->mobile_bill[$key],
                    'providend_fund'    =>  $request->providend_fund[$key],
                    'providend_fund_cent'    =>  $request->providend_fund_cent[$key],
                    'bonus'             =>  $request->bonus[$key],
                    'bonus_cent'             =>  $request->bonus_cent[$key],
                    'Long_term_benefit' =>  $request->Long_term_benefit[$key],
                    'canteen_expense'   =>  $request->canteen_expense[$key],
                    'earned_encashment' =>  $request->earned_encashment[$key],
                    'others'            =>  $request->others[$key],
                    'total_payable'     =>  $request->total_payable[$key],
                    'total_effect'      =>  $request->total_effect[$key],
                    'percent_on_slry'   =>  $request->percent_on_slry[$key],
                ];
            }

                $ctc->update($request_data);
                $ctc->BdFeasiCtcDetail()->delete();
                $ctc->BdFeasiCtcDetail()->createMany($request_details_data);
                BdFeasiCtcRate::query()->delete();
                BdFeasiCtcRate::insert($request_details_data);
            DB::commit();
            return redirect()->route('ctc.index')->with('message', 'Data has been updated successfully');
        }
        catch(QueryException $e){
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
    public function destroy(BdFeasibilityCtc $ctc)
    {
        try{
            $ctc->delete();
            return redirect()->route('ctc.index')->with('message', 'Data has been deleted successfully');
        }
        catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }
}
