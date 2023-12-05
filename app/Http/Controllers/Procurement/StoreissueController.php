<?php

namespace App\Http\Controllers\Procurement;

use App\Accounts\Account;
use App\Approval\ApprovalLayerDetails;
use App\Http\Controllers\Controller;

use App\Http\Requests\StoreissueRequest;
use App\Procurement\StockHistory;
use App\Procurement\Storeissue;
use App\Procurement\Storeissuedetails;
use App\Sells\SaleCancellation;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class StoreissueController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:storeissue-view|storeissue-create|storeissue-edit|storeissue-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:storeissue-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:storeissue-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:storeissue-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $storeissues = Storeissue::latest()->get();
        return view('procurement.storeissues.index', compact('storeissues'));
    }

    public function create()
    {
        $formType = "create";
        return view('procurement.storeissues.create', compact('formType'));
    }

    public function store(StoreissueRequest $request)
    {
        try {
            $storeissueData = $request->only('date', 'sin_no', 'srf_no', 'cost_center_id');

            DB::transaction(function () use ($storeissueData, $request) {
                $storeissue = Storeissue::create($storeissueData);

                $storeissueDetailData = array();
                foreach ($request->material_id as  $key => $data) {
                    $storeissueDetailData[] = [
                        'floor_id'          =>  $request->floor_id[$key] ?? null,
                        'material_id'       =>  $request->material_id[$key],
                        'issued_quantity'   =>  $request->issued_quantity[$key],
                        'ledger_folio_no'   =>  $request->ledger_folio_no[$key],
                        'purpose'           =>  $request->purpose[$key],
                        'notes'             =>  $request->notes[$key],
                    ];
                }
                $storeissue->storeissuedetails()->createMany($storeissueDetailData);
            });

            return redirect()->route('storeissues.index')->with('message', 'Data has been inserted successfully');
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function show(Storeissue $storeissue)
    {
        return view('procurement.storeissues.show', compact('storeissue'));
    }

    public function edit(Storeissue $storeissue)
    {
        $formType = "edit";
        $materials = Storeissuedetails::where('storeissue_id', $storeissue->id)->get();
        return view('procurement.storeissues.create', compact('storeissue', 'formType', 'materials'));
    }

    public function update(StoreissueRequest $request, Storeissue $storeissue)
    {
        try {
            $storeissueData = $request->only('date', 'sin_no', 'srf_no', 'cost_center_id');


            $storeissueDetailData = array();
            foreach ($request->material_id as  $key => $data) {
                $storeissueDetailData[] = [
                    'floor_id'          =>  $request->material_id[$key],
                    'material_id'       =>  $request->material_id[$key],
                    'issued_quantity'   =>  $request->issued_quantity[$key],
                    'ledger_folio_no'   =>  $request->ledger_folio_no[$key],
                    'purpose'           =>  $request->purpose[$key],
                    'notes'             =>  $request->purpose[$key],
                ];
            }
            DB::transaction(function () use ($storeissue, $storeissueData, $storeissueDetailData) {
                $storeissue->update($storeissueData);
                $storeissue->storeissuedetails()->delete();
                $storeissue->storeissuedetails()->createMany($storeissueDetailData);
            });

            return redirect()->route('storeissues.index')->with('message', 'Data has been updated successfully');
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    public function destroy(Storeissue $storeissue)
    {
        try {
            $storeissue->delete();
            return redirect()->route('storeissues.index')->with('message', 'Data has been deleted successfully');
        } catch (QueryException $e) {
            return redirect()->route('storeissues.index')->withErrors($e->getMessage());
        }
    }

    public function StoreIssueApprovedView(Storeissue $storeissue, $status)
    {
        try {
            $approvalfirst = ApprovalLayerDetails::whereHas('approvalLayer', function ($q) use ($storeissue) {
                $q->where([['name', 'Store Issue'], ['department_id', $storeissue->appliedBy->department_id]]);
            })->whereDoesntHave('approvals', function ($q) use ($storeissue) {
                $q->where('approvable_id', $storeissue->id)->where('approvable_type', Storeissue::class);
            })->orderBy('order_by', 'asc')->first();

            $approvallast = ApprovalLayerDetails::whereHas('approvalLayer', function ($q) use ($storeissue) {
                $q->where([['name', 'Store Issue'], ['department_id', $storeissue->appliedBy->department_id]]);
            })->whereDoesntHave('approvals', function ($q) use ($storeissue) {
                $q->where('approvable_id', $storeissue->id)->where('approvable_type', Storeissue::class);
            })->orderBy('order_by', 'desc')->first();

            $designation = auth()->user()->employee?->designation_id;
            $department = auth()->user()->employee?->department_id;

            if ($approvallast->designation_id == $designation && $approvallast->department_id == $department && $storeissue->costCenter->name == 'Head Office') {
                $accounts = Account::where('balance_and_income_line_id', 86)->pluck('account_name', 'id'); //Administrative Account
                return view('procurement.storeissues.storeissueApprove', compact('storeissue', 'accounts'));
            } else {
                $approveData = [
                    'layer_key' => $approvalfirst->layer_key,
                    'user_id' => auth()->id(),
                    'status' => $status,
                ];

                $transection['voucher_type'] = 'Journal';
                $transection['transaction_date'] = $storeissue->date;
                $transection['user_id'] = auth()->user()->id;

                DB::transaction(function () use ($transection, $storeissue, $approveData, $approvallast) {
                    //                $approval = $storeissue->approval()->create($approveData);
                    //                if ($approval->layer_key == $approvallast->layer_key && $approval->status == 'Approved') {

                    // stockout claculation start
                    $material_ids = $storeissue->storeissuedetails->pluck('material_id');
                    $stock_history_data = StockHistory::where('cost_center_id', $storeissue->cost_center_id)
                        ->whereIn('material_id', $material_ids)
                        ->get()
                        ->mapWithKeys(function ($item) {
                            return [
                                $item->material_id => $item
                            ];
                        });
                    // dd($stock_history_data);

                    $materialGroups = $storeissue->storeissuedetails->groupBy('material_id');
                    $stock_data = array();
                    foreach ($materialGroups as $key => $materialGroup) {
                        $totalQuantity = 0;
                        foreach ($materialGroup as $material_data) {
                            $totalQuantity += $material_data->issued_quantity;
                        }
                        if (!empty($stock_history_data[$key])) {
                            $present_stock = $stock_history_data[$key]->present_stock - $totalQuantity;

                            $stock_data[] = [
                                'cost_center_id' => $storeissue->cost_center_id,
                                'material_id' => $key,
                                'previous_stock' => $stock_history_data[$key]->present_stock,
                                'quantity' => $totalQuantity,
                                'present_stock' => $present_stock,
                                'average_cost' => $stock_history_data[$key]->average_cost,
                                'after_discount_po' => $stock_history_data[$key]->after_discount_po
                            ];
                        }
                    }
                    $storeissue->stockHistory()->createMany($stock_data);
                    // stockout claculation end

                    $storeissuedetails = $storeissue->stockHistory->groupBy('nestedMaterial.account_id');
                    $accountInvData = [];
                    $accountWipData = [];
                    $materialName = [];
                    //                dump($storeissuedetails);
                    foreach ($storeissuedetails as $key => $storeissuedetail) {
                        $total = 0;
                        foreach ($storeissuedetail as $storeData) {
                            $total += $storeData->average_cost * $storeData->quantity;
                        }
                        //                    dump($total);
                        $invAccountData = $storeissuedetail->first()->nestedMaterial->account->account_name;
                        $invAccount = explode('- Inv', $invAccountData);
                        $wipAccount = Account::where('parent_account_id', 139)->where('account_name', 'like', "%$invAccount[0]%")->first();
                        $accountInvData = [
                            'account_id' => $key,
                            'cr_amount' => $total,
                            //                        'pourpose' => implode(',',$materialName),
                            'cost_center_id' => $storeissue->cost_center_id,
                        ];
                        $accountWipData = [
                            'account_id' => $wipAccount->id,
                            'dr_amount' => $total,
                            //                        'pourpose' => implode(',',$materialName),
                            'cost_center_id' => $storeissue->cost_center_id,
                        ];
                        $transectionData = $storeissue->transaction()->create($transection);
                        $transectionData->ledgerEntries()->create($accountWipData);
                        $transectionData->ledgerEntries()->create($accountInvData);
                    }
                    $storeissue->update(['status' => 'Approved']);
                    //                }
                });

                $storeissue->approval()->create($approveData);

                return redirect()->route('storeissues.index')->with('message', "Issue Note has $status successfully");
            }
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }

    //    public function StoreIssueApprovedStore(Request $request )
    //    {
    ////        dd($request->all());
    //        try {
    //            foreach($request->account_id as  $key => $data){
    //                $storeissueDetailData[] = [
    //                    'floor_id'          =>  $request->account_id[$key],
    //                ];
    //            }
    //        }catch (QueryException $e){
    //
    //        }
    //        return view('procurement.storeissues.storeissueApprove');
    //    }

    public function StoreIssueApproved(Request $request)
    {
        try {
            $storeissue = Storeissue::where('id', $request->storeIssue_id)->first();

            foreach ($request->account_id as  $key => $data) {
                $storeissueDetailData[] = [
                    'floor_id'    =>  $request->account_id[$key],
                ];
            }
            $transection['voucher_type'] = 'Journal';
            $transection['transaction_date'] = $storeissue->date;
            $transection['user_id'] = auth()->user()->id;

            $approvalfirst = ApprovalLayerDetails::whereHas('approvalLayer', function ($q) use ($storeissue) {
                $q->where([['name', 'Store Issue'], ['department_id', $storeissue->appliedBy->department_id]]);
            })->wheredoesnthave('approvals', function ($q) use ($storeissue) {
                $q->where('approvable_id', $storeissue->id)->where('approvable_type', Storeissue::class);
            })->orderBy('order_by', 'asc')->first();

            $approvallast = ApprovalLayerDetails::whereHas('approvalLayer', function ($q) use ($storeissue) {
                $q->where([['name', 'Store Issue'], ['department_id', $storeissue->appliedBy->department_id]]);
            })->whereDoesntHave('approvals', function ($q) use ($storeissue) {
                $q->where('approvable_id', $storeissue->id)->where('approvable_type', Storeissue::class);
            })->orderBy('order_by', 'desc')->first();

            $approveData = [
                'layer_key' => $approvalfirst->layer_key,
                'user_id' => auth()->id(),
                'status' => 1,
            ];
            DB::transaction(function () use ($transection, $storeissue, $approveData, $approvallast, $request) {
                //                dd('ff');
                $approval = $storeissue->approval()->create($approveData);
                if ($approval->layer_key == $approvallast->layer_key && $approval->status == 'Approved') {
                    // stockout claculation start
                    $material_ids = $storeissue->storeissuedetails->pluck('material_id');
                    $stock_history_data = StockHistory::where('cost_center_id', $storeissue->cost_center_id)->whereIn('material_id', $material_ids)->latest('id')
                        ->get()->mapWithKeys(function ($item) {
                            return [
                                $item->material_id => $item
                            ];
                        });

                    $materialGroups = $storeissue->storeissuedetails->groupBy('material_id');
                    $stock_data = array();
                    foreach ($materialGroups as $key => $materialGroup) {
                        $totalQuantity = 0;
                        foreach ($materialGroup as $material_data) {
                            $totalQuantity += $material_data->issued_quantity;
                        }
                        if (!empty($stock_history_data[$key])) {
                            $present_stock = $stock_history_data[$key]->present_stock - $totalQuantity;

                            $stock_data[] = [
                                'cost_center_id' => $storeissue->cost_center_id,
                                'material_id' => $key,
                                'previous_stock' => $stock_history_data[$key]->present_stock,
                                'date' => date('Y-m-d', strtotime($storeissue->date)),
                                'quantity' => $totalQuantity,
                                'present_stock' => $present_stock,
                                'average_cost' => $stock_history_data[$key]->average_cost,
                            ];
                        }
                    }
                    // $storeissue->stockHistory()->createMany($stock_data);
                    // stockout claculation end

                    $storeissuedetails = $storeissue->stockHistory->groupBy('nestedMaterial.account_id');
                    $accountInvData = [];
                    $accountWipData = [];
                    $materialName = [];
                    //                dump($storeissuedetails);
                    $i = 0;
                    foreach ($storeissuedetails as $key => $storeissuedetail) {
                        $total = 0;
                        foreach ($storeissuedetail as $storeData) {
                            $total += $storeData->average_cost * $storeData->quantity;
                        }
                        //                    dump($total);
                        $invAccountData = $storeissuedetail->first()->nestedMaterial->account->account_name;
                        $invAccount = explode('- Inv', $invAccountData);
                        $wipAccount = Account::where('parent_account_id', 139)->where('account_name', 'like', "%$invAccount[0]%")->first();
                        $accountInvData = [
                            'account_id' => $key,
                            'cr_amount' => $total,
                            //                        'pourpose' => implode(',',$materialName),
                            'cost_center_id' => $storeissue->cost_center_id,
                        ];
                        $accountWipData = [
                            'account_id' => $request->account_id[$i++],
                            'dr_amount' => $total,
                            //                        'pourpose' => implode(',',$materialName),
                            'cost_center_id' => $storeissue->cost_center_id,
                        ];
                        //                        dump($accountInvData, $accountWipData);
                        $transectionData = $storeissue->transaction()->create($transection);
                        $transectionData->ledgerEntries()->create($accountWipData);
                        $transectionData->ledgerEntries()->create($accountInvData);
                    }
                    $storeissue->update(['status' => 'Approved']);
                    //                    die();
                }
            });
            return redirect()->route('storeissues.index')->with('message', 'Issue Note has Approved successfully');
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors($e->getMessage());
        }
    }
}
