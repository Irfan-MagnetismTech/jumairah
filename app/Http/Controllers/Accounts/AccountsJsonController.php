<?php

namespace App\Http\Controllers\Accounts;

use App\Accounts\Account;
use App\Accounts\BalanceAndIncomeLine;
use App\Accounts\BankAccount;
use App\Accounts\FixedAsset;
use App\Accounts\HeadFirstLayer;
use App\Accounts\HeadType;
use App\Accounts\InterCompany;
use App\Accounts\Loan;
use App\Accounts\Salary;
use App\Approval\ApprovalLayer;
use App\Bank;
use App\CostCenter;
use App\Http\Controllers\Controller;
use App\LedgerEntry;
use App\Procurement\Materialmovement;
use App\Procurement\Materialmovementdetail;
use App\Procurement\MaterialReceive;
use App\Procurement\MovementRequisition;
use App\Procurement\MovementRequisitionDetail;
use App\Procurement\StockHistory;
use App\Procurement\Supplier;
use App\Procurement\Supplierbill;
use App\SalaryDetail;
use App\Transaction;
use Carbon\Carbon;
use FontLib\Table\Type\kern;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class AccountsJsonController extends Controller
{
    public function loadLoanSourceNames($loanable_type)
    {
        $data = $loanable_type == "Inter Company" ? InterCompany::orderBy('name')->pluck('name', 'id') : ($loanable_type == "Bank" ? BankAccount::orderBy('name')->get()->pluck('loan_number', 'id') : null);
        return $data;
    }
    public function bankAutoSuggest(Request $request){
        $search = $request->search;
        if($search == ''){
            $items = Account::whereIn('balance_and_income_line_id', [8,31])->limit(5)->get(['account_name', 'id']);
        }else{
            $items = Account::whereIn('balance_and_income_line_id', [8,31])->where('account_name', 'like', '%' .$search . '%')->limit(10)->get(['account_name', 'id']);
        }
        $response = array();
        foreach($items as $item){
            $response[] = array("label"=>$item->account_name,"value"=>$item->id);
        }
        return response()->json($response);
    }
    public function sundryCreditorAutoSuggest(Request $request){
        $search = $request->search;
        if($search == ''){
            $items = Account::whereIn('balance_and_income_line_id', [34])
                ->whereNotNull('parent_account_id')->limit(5)
//                ->where('parent_account_id','!=',100)
                ->get(['account_name', 'id']);
        }else{
            $items = Account::whereIn('balance_and_income_line_id', [34])
                ->whereNotNull('parent_account_id')
//                ->where('parent_account_id','!=',100)
                ->where('account_name', 'like', '%' .$search . '%')->limit(10)->get(['account_name', 'id']);
        }
        $response = array();
        foreach($items as $item){
            $response[] = array("label"=>$item->account_name, "value"=>$item->id);
        }
        return response()->json($response);
    }

    public function costCenterAutoSuggest(Request $request){
        $search = $request->search;
        if($search == ''){
            $items = CostCenter::limit(5)->get(['name', 'id']);
        }else{
            $items = CostCenter::where('name', 'like', '%' .$search . '%')->limit(10)->get(['name', 'id']);
        }
        $response = array();
        foreach($items as $item){
            $response[] = array("label"=>$item->name,"value"=>$item->id,"project_id"=>$item->project_id);
        }
        return response()->json($response);
    }

    public function loadAccountParent($balance_and_income_line_id)
    {
        $data = Account::where('balance_and_income_line_id', $balance_and_income_line_id)->orderBy('account_name')->get(['account_name', 'id']);
        return response()->json($data);
    }

    public function linesAutoSuggest(Request $request){
        $search = $request->search;
        if($search == ''){
            $items = BalanceAndIncomeLine::whereIn('line_type',['balance_line','income_line'])->limit(5)->get(['line_text', 'id']);
        }else{
            $items = BalanceAndIncomeLine::where('line_text', 'like', '%' .$search . '%')
                                                ->whereIn('line_type',['balance_line','income_line'])->limit(10)->get(['line_text', 'id']);
        }
        $response = array();
        foreach($items as $item){
            $response[] = array("label"=>$item->line_text,"value"=>$item->id);
        }
        return response()->json($response);
    }

    public function loadBillAmount($bill_no)
    {
//         $data = Transaction::with('ledgerEntries')->where('bill_no',$bill_no)->first();
         $data = Transaction::with('ledgerEntries')->where('bill_no',$bill_no)
                ->whereDoesntHave('ledgerEntries', function ($q) {  $q->where('pourpose', 'discount'); })
                ->withSum('ledgerEntries','cr_amount')->get();

         $discount = Transaction::where('bill_no',$bill_no)->whereHas('ledgerEntries', function($q){ $q->where('pourpose','discount'); })
             ->with(['ledgerEntries' => function($q){ $q->where('pourpose','discount');  }])
             ->get();

         $ledgerBill = LedgerEntry::where('ref_bill',$bill_no)->get();
         $unpaidBill = $data->pluck('ledgerEntries')->flatten()->sum('cr_amount') - $discount->pluck('ledgerEntries')->flatten()->sum('dr_amount');
        $amount = $unpaidBill - $ledgerBill->sum('dr_amount');
        return $amount;
    }

    public function unpaidBill($account_id, $project_id)
    {
//        $transactions = Transaction::
//            with(['paidBill' => function ($q) use ($account_id, $project_id){
//                $q->where('account_id',$account_id)->where('cost_center_id',$project_id);
//            }])
//            ->with(['ledgerEntries' => function ($q) use ($account_id,$project_id){
//                $q->where('account_id',$account_id)->where('cost_center_id',$project_id);
//            }])
//            ->whereHas('ledgerEntries', function ($q) use ($account_id, $project_id){
//                $q->where('account_id',$account_id)->where('cost_center_id',$project_id);
//            })
//            ->where('voucher_type','Journal')
//            ->where('bill_no','!=',null)
//            ->get()
//            ->map(function ($item){
////                if ($item->ledgerEntries->sum('cr_amount') >= $item->paidBill->sum('dr_amount')){
//                    return  $item->bill_no;
////                }
//            })
//            ->filter()->toArray();

        $transactions = Transaction::where('voucher_type','Journal')
            ->where('bill_no','!=',null)
            ->whereHas('ledgerEntries', function ($q) use ($account_id, $project_id){
                $q->where('account_id',$account_id)->where('cost_center_id',$project_id);
            })->pluck('bill_no');

        $unpaidbills = Transaction::whereIn('bill_no',$transactions)
            ->whereDoesntHave('ledgerEntries', function ($q) {  $q->where('pourpose', 'discount'); })
            ->get()->groupBy('bill_no')
            ->map(function ($unpaidbills) {
                return $unpaidbills->pluck('ledgerEntries')->flatten()->sum('cr_amount');
            })
        ;

        return $transactions;

        $paidBills = LedgerEntry::whereIn('ref_bill',$transactions)->get()->groupBy('ref_bill')
            ->map(function ($paidbill) {
                return $paidbill->sum('dr_amount');
            });
        $discount = Transaction::whereIn('bill_no',$transactions)
            ->whereHas('ledgerEntries', function($q){ $q->where('pourpose','discount'); })
            ->with(['ledgerEntries' => function($q){ $q->where('pourpose','discount');  }])
            ->get()->groupBy('bill_no')
            ->map(function($item){ return $item->pluck('ledgerEntries')->flatten()->sum('dr_amount'); });

        $bills = Transaction::whereIn('bill_no',$transactions)->get()->groupBY('bill_no')
            ->map(function ($bill, $key) use ($paidBills, $unpaidbills, $discount){
                $bill = $unpaidbills->get($key) - $discount->get($key);
                if($paidBills->get($key) <= $bill ){
                   return $key;
                }
            })->filter();

//        dd($unpaidbills->toArray(), $discount->toArray(), $bills);

        return $bills;
    }
    public function unpaidBillbySupplier($account_id)
    {

        $transactions = Transaction::where('voucher_type','Journal')
            ->where('bill_no','!=',null)
            ->whereHas('ledgerEntries', function ($q) use ($account_id){
                $q->where('account_id',$account_id);
            })->pluck('bill_no');

        $unpaidbills = Transaction::whereIn('bill_no',$transactions)
            ->whereDoesntHave('ledgerEntries', function ($q) {  $q->where('pourpose', 'discount'); })
            ->get()->groupBy('bill_no')
            ->map(function ($unpaidbills) {
                return $unpaidbills->pluck('ledgerEntries')->flatten()->sum('cr_amount');
            })
        ;

        $paidBills = LedgerEntry::whereIn('ref_bill',$transactions)->get()->groupBy('ref_bill')
            ->map(function ($paidbill) {
                return $paidbill->sum('dr_amount');
            });
        $discount = Transaction::whereIn('bill_no',$transactions)
            ->whereHas('ledgerEntries', function($q){ $q->where('pourpose','discount'); })
            ->with(['ledgerEntries' => function($q){ $q->where('pourpose','discount');  }])
            ->get()->groupBy('bill_no')
            ->map(function($item){ return $item->pluck('ledgerEntries')->flatten()->sum('dr_amount'); });

        $bills = Transaction::whereIn('bill_no',$transactions)->get()->groupBY('bill_no')
            ->map(function ($bill, $key) use ($paidBills, $unpaidbills, $discount){
                $bill = $unpaidbills->get($key) - $discount->get($key);
                if($paidBills->get($key) <= $bill ){
                   return $key;
                }
            })->filter();

        return $bills;
    }

    public function getMRRInfo(Request $request)
    {
        $search = $request->search;
        if($search == ''){
            $items = MaterialReceive::get('mrr_no');
        }else{
            $items = MaterialReceive::where('mrr_no','like',"%$search%")
            ->get();
        }
        $response = array();
        foreach($items as $item){
            $response[] = array(
                "label"=>$item->mrr_no,
                "value"=>$item->mrr_no,
                'date'=>$item->date,
                'cost_center'=>$item->cost_center_id,
                'supplier_name'=>$item->purchaseorder->supplier->name,
                'supplier_id'=>$item->purchaseorder->supplier->account->id,
                'material'=>$item->materialreceivedetails->pluck('nestedMaterials')
            );
        }
        return response()->json($response);
    }
    public function loadAssetInfo($asset_id)
    {
        return FixedAsset::with('fixedAssetCosts')->where('id',$asset_id)->first();
    }

    public function getDepreciationAssets($month)
    {
        $assets = FixedAsset::with('fixedAssetCosts','account')->withSum('fixedAssetCosts','amount')->get();
        return $assets;
    }

    public function getSalaryAllocationCost($month)
    {
        $m = date('m',strtotime($month.'-01'));
        $year = date('Y',strtotime($month.'-01'));
        $data = LedgerEntry::whereHas('costCenter',function ($q){ $q->where('project_id','!=',null); })
            ->get()
            ->groupBy('cost_center_id') ;
//        dd($projects);
        $projects = $data->map(function($item, $key) use ($m, $year) {
            $materials = LedgerEntry::whereHas('account', function ($q) {
                $q->where('parent_account_id',139);
            })->whereHas('transaction', function ($q) use ($m,$year){
                $q->whereYear('transaction_date',$year)->whereMonth('transaction_date',$m);
            })->where('cost_center_id',$key)->get();

            $labors = LedgerEntry::whereHas('account', function ($q){
                $q->where('parent_account_id',138);
            })->whereHas('transaction', function ($q) use ($m,$year){
                $q->whereYear('transaction_date',$year)->whereMonth('transaction_date',$m);
            })->where('cost_center_id',$key)->get();

            $costCenter = CostCenter::where('id',$key)->get();

            $constructionAmount = SalaryDetail::whereHas('salary',function ($q) use ($m,$year){ $q->whereYear('month',$year)->whereMonth('month',$m); })
                ->whereHas('salaryHeads',function ($q){ $q->where('is_allocate',1)->where('name','like',"%Construction%"); })->first();
            $icmdAmount = SalaryDetail::whereHas('salary',function ($q) use ($m,$year){ $q->whereYear('month',$year)->whereMonth('month',$m); })
                ->whereHas('salaryHeads',function ($q){ $q->where('is_allocate',1)->where('name','like',"%ICMD%"); })->first();
            $architectureAmount = SalaryDetail::whereHas('salary',function ($q) use ($m,$year){ $q->whereYear('month',$year)->whereMonth('month',$m); })
                ->whereHas('salaryHeads',function ($q){ $q->where('is_allocate',1)->where('name','like',"%Architecture%"); })->first();
            $supplychainAmount = SalaryDetail::whereHas('salary',function ($q) use ($m,$year){ $q->whereYear('month',$year)->whereMonth('month',$m); })
                ->whereHas('salaryHeads',function ($q){ $q->where('is_allocate',1)->where('name','like',"%Supply%"); })->first();

            return [
                'costCenter' => $costCenter,
                'material' => $materials->flatten()->sum('dr_amount'),
                'labors' => $labors->flatten()->sum('dr_amount'),
                'construction' => $constructionAmount->gross_salary ?? 0,
                'icmd' => $icmdAmount->gross_salary ?? 0,
                'architecture' => $architectureAmount->gross_salary ?? 0,
                'supplyChain' => $supplychainAmount->gross_salary ?? 0,
            ];
        });

        return $projects;
    }

    public function getAllocationCost($month)
    {
        $m = date('m',strtotime($month.'-01'));
        $year = date('Y',strtotime($month.'-01'));
        $data = LedgerEntry::whereHas('costCenter',function ($q){ $q->where('project_id','!=',null); })
            ->get()
            ->groupBy('cost_center_id') ;
//        dd($projects);
        $projects = $data->map(function($item, $key) use ($m, $year) {
            $materials = LedgerEntry::whereHas('account', function ($q) {
                $q->where('parent_account_id',139);
            })->whereHas('transaction', function ($q) use ($m, $year){
                $q->whereYear('transaction_date',$year)->whereMonth('transaction_date',$m);
            })->where('cost_center_id',$key)->get();

            $labors = LedgerEntry::whereHas('account', function ($q){
                $q->where('parent_account_id',138);
            })->whereHas('transaction', function ($q) use ($m,$year){
                $q->whereYear('transaction_date',$year)->whereMonth('transaction_date',$m);
            })->where('cost_center_id',$key)->get();

            $installment = LedgerEntry::whereHas('account', function ($q){
                $q->whereIn('parent_account_id',[1,2,3]);
            })->whereHas('transaction', function ($q) use ($m,$year){
                $q->whereYear('transaction_date',$year)->whereMonth('transaction_date',$m);
            })->where('cost_center_id',$key)->get();

            $costCenter = CostCenter::where('id',$key)->get();

            return [
                'costCenter' => $costCenter,
                'material' => $materials->flatten()->sum('dr_amount'),
                'labors' => $labors->flatten()->sum('dr_amount'),
                'revenue' => $installment->flatten()->sum('cr_amount'),
            ];
        });

        return $projects;
    }

    public function getAllocationSalary($month)
    {
        $m = date('m',strtotime($month.'-01'));
        $year = date('Y',strtotime($month.'-01'));
        $data = SalaryDetail::with('salaryHeads')->whereHas('salary',function ($q) use ($m,$year){
                    $q->whereYear('month',$year)->whereMonth('month',$m); })
                ->whereHas('salaryHeads',function ($q){ $q->where('is_allocate',1); })
                ->get();
        return $data;
    }

    public function getLoanInterest($frommonth, $toMonth){
        $m = date('m',strtotime($frommonth.'-01'));
        $year = date('Y',strtotime($frommonth.'-01'));
        $fromDate = $frommonth.'-01';
        $toMonth = $toMonth.'-01';
        $toDate =  date("Y-m-t", strtotime($toMonth));

        $ho = CostCenter::where('name','like',"%Head Office%")->first();
        $sodLoan = LedgerEntry::with('account')
                ->whereHas('account', function ($q){
                    $q->where('balance_and_income_line_id',87)->where('loan_type','SOD');
                })
                ->whereHas('transaction', function ($q) use($fromDate, $toDate) {
                    $q->whereBetween('transaction_date',["$fromDate","$toDate"]);
                })
                ->where('cost_center_id',$ho->id)
                ->get();
        $hblLoan = LedgerEntry::with('account')
                ->whereHas('account', function ($q){
                    $q->where('balance_and_income_line_id',87)->where('loan_type','HBL');
                })
                ->whereHas('transaction', function ($q) use($fromDate, $toDate) {
                    $q->whereBetween('transaction_date',["$fromDate","$toDate"]);
                })
                ->where('cost_center_id',$ho->id)
                ->get();

        $sodInterest = $sodLoan->flatten()->sum('dr_amount');
        $hblLoanInterest = $hblLoan->flatten()->sum('dr_amount');
        //$intersts = Transaction::
        $data = LedgerEntry::whereHas('costCenter',function ($q){ $q->where('project_id','!=',null); })
            ->get()
            ->groupBy('cost_center_id') ;
//        dd($projects);
        $projects = $data->map(function($item, $key) use ($fromDate, $toDate) {

            $installment = LedgerEntry::whereHas('account', function ($q){
                $q->whereIn('parent_account_id',[1,2,3]);
            })->whereHas('transaction', function ($q) use ($fromDate,$toDate){
                $q->whereBetween('transaction_date',["$fromDate","$toDate"]);
            })->where('cost_center_id',$key)->get();

            $outflow = LedgerEntry::
            // whereHas('account', function ($q){ $q->whereIn('parent_account_id',[1,2,3]); })->
            whereHas('transaction', function ($q) use ($fromDate, $toDate){
                $q->whereBetween('transaction_date',["$fromDate","$toDate"])
                ->where('voucher_type', 'Payment');
            })->where('cost_center_id',$key)->get();

            $costCenter = CostCenter::where('id',$key)->get();

            return [
                'costCenter' => $costCenter,
                'revenue' => $installment->flatten()->sum('cr_amount'),
                'outflow' => $outflow->flatten()->sum('dr_amount'),
            ];
        });

        return [$projects, $hblLoanInterest, $sodInterest];
    }

    public function getLoanInfo($loan_id)
    {
        $loan =  Loan::where('id', $loan_id)->first();
        $loan['received_amount'] = $loan->loanReceives->flatten()->sum('receipt_amount');
        return $loan ;
    }

    public function getProjectAvailableMaterial($costcenter, $material){
        $materials_qnt = StockHistory::where('cost_center_id',$costcenter)->where('material_id',$material)->latest()->first();
        return $materials_qnt;
    }

    public function mtrfAutoSuggust(Request $request){
        $search = $request->search;
        if($search == ''){
            $items = MovementRequisition::limit(5)->get(['mtrf_no', 'id']);
        }else{
            $items = MovementRequisition::where('mtrf_no', 'like', '%' .$search . '%')->limit(10)->get(['mtrf_no', 'id']);
        }
        $response = array();
        foreach($items as $item){
            $response[] = array("label"=>$item->mtrf_no,"value"=>$item->id);
        }
        return response()->json($response);
    }

    public function getMovementRequiestionInfo(MovementRequisition $movementRequisitions){
        $data = MovementRequisition::with('toCostCenter','fromCostCenter','movementRequisitionDetails.nestedMaterial')
                ->where('id',$movementRequisitions->id)
                ->first();
        return $data;
    }

    public function getMTRFInfobyMaterial(MovementRequisition $movementRequisitions, $material_id){
        $items = $movementRequisitions->movementRequisitionDetails()->with('nestedMaterial','nestedMaterial.unit')
                ->where('material_id',$material_id)->first();
        return $items;

    }

    public function loadMTRFProjectWise($fromProject, $toProject){
        $approval_layer = ApprovalLayer::where('name', 'Movement Requisition')->first();
        $approval_layer_details = $approval_layer->approvalLeyarDetails->pluck('layer_key')->last();
        $data = MovementRequisition::whereHas('approval',function($q) use($approval_layer_details){
            $q->where('layer_key',$approval_layer_details)->where('status',1);
        })->where('from_costcenter_id',$fromProject)->where('to_costcenter_id',$toProject)->get();
        return $data;
    }

    public function mtoAutoSuggust(Request $request){
        $search = $request->search;
        if($search == ''){
            $items = Materialmovement::limit(5)->get(['mto_no', 'id']);
        }else{
            $items = Materialmovement::where('mto_no', 'like', '%' .$search . '%')->limit(10)->get(['mto_no', 'id']);
        }
        $response = array();
        foreach($items as $item){
            $response[] = array("label"=>$item->mto_no,"value"=>$item->id);
        }
        return response()->json($response);
    }

    public function loadMTRFmtoWise($mto){
        $data = Materialmovement::with('movementdetails.movementRequisition')->where('id',$mto)->first();
        return $data;
    }

    public function getMTOInfobyMaterial(MovementRequisition $movementRequisitions, $material_id, $mto){
        $movementRequisition = $movementRequisitions->movementRequisitionDetails()->with('nestedMaterial.unit')
                ->where('material_id',$material_id)->first();
                // dd($items);
        $movementDetails = $movementRequisitions->movementDetails()->where('material_id',$material_id)
                        ->where('materialmovement_id',$mto)->first();

        return [$movementRequisition, $movementDetails];
    }
}

