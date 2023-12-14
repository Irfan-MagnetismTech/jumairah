<?php

namespace App\Http\Controllers\Procurement;

use Illuminate\Support\Str;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Approval\ApprovalLayerDetails;
use App\Procurement\AdvanceAdjustment;
use Illuminate\Database\QueryException;
use App\Procurement\AdvanceAdjustmentDetails;
use App\Http\Requests\AdvanceAdjustmentRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

class AdvanceAdjustmentController extends Controller
{
    private const STORE_PATH = "advanced_adjustment";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:advanceadjustment-view|advanceadjustment-create|advanceadjustment-edit|advanceadjustment-delete', ['only' => ['index','show']]);
        $this->middleware('permission:advanceadjustment-create', ['only' => ['create','store']]);
        $this->middleware('permission:advanceadjustment-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:advanceadjustment-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $advanceadjustments = \App\Procurement\AdvanceAdjustment::latest()->get();
        return view('procurement.advanceadjustments.index', compact('advanceadjustments'));
    }

    public function create()
    {
        $formType = "create";
        return view('procurement.advanceadjustments.create', compact('formType'));
    }

    public function store(AdvanceAdjustmentRequest $request)
    {
//        dd($request->all());
        try{
            $advancedAdjustmentData = $request->only('date','cost_center_id','grand_total','balance','iou_id','mrr_id');
            $advancedAdjustmentData['user_id'] = auth()->id();
            $advancedAdjustmentData['applied_by'] = auth()->id();

            DB::transaction(function() use ($advancedAdjustmentData,$request) {
                $advancedAdjustment = AdvanceAdjustment::create($advancedAdjustmentData);
                $imgname = null;
                foreach($request->account_id as $key => $value){
                    if(isset($request->file('image')[$key])){
                        $images = $request->file('image')[$key];
                        $imagesName = Str::random(8).time().'.'.$images->extension();
                        $imgname = $request->file('image')[$key]->storeAs(self::STORE_PATH, $imagesName);
                    }
                    $advancedAdjustmentDetailsData = [
                        'account_id'    => $request->account_id[$key],
                        'description'   => $request->description[$key],
                        'remarks'       => $request->remarks[$key],
                        'amount'        => $request->amount[$key],
                        'attachment'    => $imgname,
                    ];
                     $advancedAdjustment->advanceadjustmentdetails()->create($advancedAdjustmentDetailsData);
                }
                // $advancedAdjustment->advanceadjustmentdetails()->createMany($advancedAdjustmentDetailsData);
            });
            return redirect()->route('advanceadjustments.index')->with('message','Data has been inserted successfully');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function show(AdvanceAdjustment $advanceadjustment)
    {
        return view('procurement.advanceadjustments.show', compact('advanceadjustment'));

    }
    public function edit(AdvanceAdjustment $advanceadjustment)
    {
        $formType = "edit";
        return view('procurement.advanceadjustments.create', compact('advanceadjustment','formType'));
    }

    public function update(AdvanceAdjustmentRequest $request, AdvanceAdjustment $advanceadjustment)
    {
        //        dd($request->all());
        try{
            $advancedAdjustmentData = $request->only('date','cost_center_id','grand_total','balance','iou_id','mrr_id');

            $advancedAdjustmentDetailsData = [];
            DB::transaction(function() use ($advancedAdjustmentData,$request,$advanceadjustment) {
                $advanceadjustment->update($advancedAdjustmentData);
                $imgname = null;
                $a = $advanceadjustment->advanceadjustmentdetails->pluck('attachment');
                foreach($request->account_id as $key => $value){
                    if(isset($request->file('image')[$key])){
                        (Storage::exists($advanceadjustment->advanceadjustmentdetails[$key]->attachment) && ($advanceadjustment->advanceadjustmentdetails[$key]->attachment != '') && ($advanceadjustment->advanceadjustmentdetails[$key]->attachment != null)) ? Storage::delete($advanceadjustment->advanceadjustmentdetails[$key]->attachment) : null;
                        $images = $request->file('image')[$key];
                        $imagesName = Str::random(8).time().'.'.$images->extension();
                        $imgname = $request->file('image')[$key]->storeAs(self::STORE_PATH, $imagesName);
                    }else{
                        $imgname = $a[$key];
                    }
                    $advancedAdjustmentDetailsData[] = [
                        'account_id'    => $request->account_id[$key],
                        'description'   => $request->description[$key],
                        'remarks'       => $request->remarks[$key],
                        'amount'        => $request->amount[$key],
                        'attachment'    => $imgname,
                    ];
                    //  $advancedAdjustment->advanceadjustmentdetails()->create($advancedAdjustmentDetailsData);
                }
                $advanceadjustment->advanceadjustmentdetails()->delete();
                $advanceadjustment->advanceadjustmentdetails()->createMany($advancedAdjustmentDetailsData);
            });
            // foreach($request->account_id as $key => $value){
            //     $advancedAdjustmentDetailsData[] = [
            //         'account_id'    => $request->account_id[$key],
            //         'description'   => $request->description[$key],
            //         'remarks'       => $request->remarks[$key],
            //         'amount'        => $request->amount[$key]
            //     ];
            // }
            // DB::transaction(function() use ($advanceadjustment,$advancedAdjustmentData,$advancedAdjustmentDetailsData) {
            //     $advanceadjustment->update($advancedAdjustmentData);
            //     $advanceadjustment->advanceadjustmentdetails()->delete();
            //     $advanceadjustment->advanceadjustmentdetails()->createMany($advancedAdjustmentDetailsData);
            // });

            return redirect()->route('advanceadjustments.index')->with('message', 'Data has been updated successfully');
        }catch(QueryException $e){
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AdvanceAdjustment  $advanceadjustment
     * @return \Illuminate\Http\Response
     */
    public function destroy(AdvanceAdjustment $advanceadjustment)
    {
        try{
            $advanceadjustment->delete();
            return redirect()->route('advanceadjustments.index')->with('message', 'Data has been deleted successfully');
        }catch(QueryException $e){
            return redirect()->route('advanceadjustments.index')->withErrors($e->getMessage());
        }
    }

    public function approve(AdvanceAdjustment $advanceAdjustment, $status)
    {
        try {
            DB::beginTransaction();
            $approval = ApprovalLayerDetails::whereHas('approvalLayer', function ($q) use ($advanceAdjustment) {
                $q->where([['name', 'Advance Adjustment'], ['department_id', $advanceAdjustment->appliedBy->department_id]]);
            })->whereDoesntHave('approvals', function ($q) use ($advanceAdjustment) {
                $q->where('approvable_id', $advanceAdjustment->id)
                    ->where('approvable_type', AdvanceAdjustment::class);
            })->orderBy('order_by', 'asc')->first();
            $data = [
                'layer_key' => $approval->layer_key,
                'user_id' => auth()->id(),
                'status' => $status,
            ];
            /* Check Last Approval */
            $check_approval = ApprovalLayerDetails::whereHas('approvalLayer', function ($q) use ($advanceAdjustment) {
                $q->where([['name', 'Advance Adjustment'], ['department_id', $advanceAdjustment->appliedBy->department_id]]);
            })->whereDoesntHave('approvals', function ($q) use ($advanceAdjustment) {
                $q->where('approvable_id', $advanceAdjustment->id)
                    ->where('approvable_type', AdvanceAdjustment::class);
            })->orderBy('order_by', 'desc')->first();

            $approvalData = $advanceAdjustment->approval()->create($data);
            DB::commit();
            if ($approvalData->layer_key == $check_approval->layer_key && $approvalData->status == 'Approved') {
                return redirect()->route('advanceadjustments.index')->with('message', "Adjustment $advanceAdjustment->id approved.");
            }
            return redirect()->route('advanceadjustments.index')->with('message', "Adjustment $advanceAdjustment->id approved.");
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function ShowFile($id){
        $advanceadjustmentdetail = AdvanceAdjustmentDetails::findOrFail(Crypt::decryptString($id));
       if(Storage::exists($advanceadjustmentdetail->attachment)){
           $FilePath = $advanceadjustmentdetail->attachment;
           return response()->file(Storage::path($FilePath));
       }else{
        return redirect()->back()->withErrors('There is No attachment available');
       }
    }
}
