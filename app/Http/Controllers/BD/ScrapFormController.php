<?php

namespace App\Http\Controllers\BD;

use App\BD\ScrapForm;
use App\Http\Controllers\Controller;
use App\Http\Requests\BD\ScrapFormRequest;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Approval\ApprovalLayerDetails;

class ScrapFormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:bd-scrap-form-view|bd-scrap-form-create|bd-scrap-form-edit|bd-scrap-form-delete', ['only' => ['index','show']]);
        $this->middleware('permission:bd-scrap-form-create', ['only' => ['create','store']]);
        $this->middleware('permission:bd-scrap-form-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:bd-scrap-form-delete', ['only' => ['destroy']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ScrapFormDetails = ScrapForm::get();
        return view('bd.scrap-form.index', compact('ScrapFormDetails'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $formType     = "create";
        return view('bd.scrap-form.create', compact('formType'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ScrapFormRequest $request)
    {
        try{
            $requestData = $request->only('sgsf_no', 'cost_center_id', 'applied_date', 'note');
            $requestData['applied_by']  = auth()->id();
            $requestData['status']          = "Pending";
            $requestDetailData = array();
            foreach($request->material_id as  $key => $data){

                $requestDetailData[] = [
                    'material_id'   =>  $request->material_id[$key],
                    'quantity'      =>  $request->quantity[$key],
                    'remarks'       =>  $request->remarks[$key]
                ];
            }

           DB::transaction(function()use($requestData, $requestDetailData){
               $scrapForm = ScrapForm::create($requestData);
               $scrapForm->scrapFormDetails()->createMany($requestDetailData);
           });

            return redirect()->route('scrapForm.index')->with('message', 'Data has been inserted successfully');
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
    public function edit(ScrapForm $scrapForm)
    {
        $formType     = "edit";
        return view('bd.scrap-form.create', compact('formType', 'scrapForm'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ScrapFormRequest $request, ScrapForm $scrapForm)
    {
        try{
            $requestData = $request->only('sgsf_no', 'cost_center_id', 'applied_date', 'note');
            $requestData['applied_by']  = auth()->id();
            $requestData['status']          = "Pending";
            $requestDetailData = array();
            foreach($request->material_id as  $key => $data){

                $requestDetailData[] = [
                    'material_id'   =>  $request->material_id[$key],
                    'quantity'      =>  $request->quantity[$key],
                    'remarks'       =>  $request->remarks[$key]
                ];
            }

           DB::transaction(function()use($requestData, $requestDetailData, $scrapForm){
               $scrapForm->update($requestData);
               $scrapForm->scrapFormDetails()->delete();
               $scrapForm->scrapFormDetails()->createMany($requestDetailData);
           });

            return redirect()->route('scrapForm.index')->with('message', 'Data has been inserted successfully');
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
    public function destroy(ScrapForm $scrapForm)
    {
        try{
            $scrapForm->delete();
            return redirect()->route('scrapForm.create')->with('message', 'Data has been deleted successfully');
        }catch(QueryException $e){
            return redirect()->route('scrapForm.create')->withErrors($e->getMessage());
        }
    }

    public function Approved(ScrapForm $scrapForm,$status)
    {
        try {
            DB::beginTransaction();
            $approval = ApprovalLayerDetails::whereHas('approvalLayer', function ($q) use ($scrapForm) {
                $q->where([['name', 'SCRAP FORM'], ['department_id', $scrapForm->user->department_id]]);
            })->whereDoesntHave('approvals', function ($q) use ($scrapForm) {
                $q->where('approvable_id', $scrapForm->id)
                    ->where('approvable_type', ScrapForm::class);
            })->orderBy('order_by', 'asc')->first();
            $data = [
                'layer_key' => $approval->layer_key,
                'user_id' => auth()->id(),
                'status' => $status,
            ];

            /* Check Last Approval */
            $check_approval = ApprovalLayerDetails::whereHas('approvalLayer', function ($q) use ($scrapForm) {
                $q->where([['name', 'SCRAP FORM'], ['department_id', $scrapForm->user->department_id]]);
            })->whereDoesntHave('approvals', function ($q) use ($scrapForm) {
                $q->where('approvable_id', $scrapForm->id)
                    ->where('approvable_type', ScrapForm::class);
            })->orderBy('order_by', 'desc')->first();
                $approvalData = $scrapForm->approval()->create($data);
            DB::commit();
            if ($approvalData->layer_key == $check_approval->layer_key && $approvalData->status == 'Approved') {
               
            }
            return redirect()->route('scrapForm.index')->with('message', 'Data has been approved successfully');
        } catch (QueryException $e) {
            DB::rollback();
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
        

    }
}
