<?php

namespace App\Http\Controllers;

use App\Bank;
use App\Thana;
use App\Country;
use App\Parking;
use App\Project;
use App\District;
use App\Employee;
use App\Stockout;
use App\CostCenter;
use App\LcCostHead;
use App\Sells\Sell;
use App\ProjectType;
use App\Sells\Client;
use App\ParkingDetails;
use App\Sells\Apartment;
use App\Sells\SoldParking;
use Illuminate\Http\Request;
use App\Sells\Leadgeneration;
use App\Sells\InstallmentList;
use App\SalesCollectionDetails;
use Ramsey\Collection\Collection;
use Illuminate\Support\Facades\DB;
use App\Procurement\MaterialBudget;
use App\Billing\Workorder;
use App\Billing\WorkorderRate;
use App\Boq\Departments\Eme\BoqEmeWorkOrder;
use App\Mouza;

class JsonController extends Controller
{

    public function getDistrict($division)
    {
        $district = District::orderBy('name')->where('division_id', $division)->get(['name', 'id']);
        return $district;
    }

    public function getThana($district)
    {
        $thana = Thana::orderBy('name')->where('district_id', $district)->get(['name', 'id']);
        return $thana;
    }

    public function getMouza($thana)
    {
        $mouza = Mouza::orderBy('name')->where('thana_id', $thana)->get(['name', 'id']);
        return $mouza;
    }


    public function lcCostHeadAutoComplete($lcCost_id)
    {
        return $data = LcCostHead::where('id', $lcCost_id)->firstOrFail();
    }


    public function employeeAutoComplete($employee_id){
        return Employee::where('id', $employee_id)->firstOrFail()->toJson();
    }

    public function getDepartmentEmployee($departmentId)
    {
        $employees = Employee::orderBy('fname')->where('department_id', $departmentId)->get(['id','fname', 'lname'])->pluck('fullName', 'id');
        return $employees;
    }

    public function bankAutoComplete($bank_id)
    {
        return $data = Bank::where('id', $bank_id)->firstOrFail();
    }

    public function countryAutoSuggest(Request $request){
        $search = $request->search;
        if($search == ''){
            $countries = Country::limit(5)->get();
        }else{
            $countries = Country::where('name', 'like', '%' .$search . '%')->limit(10)->get();
        }
        $response = array();
        foreach($countries as $country){
            $response[] = array(
                "label"=>$country->name
            );
        }
        return response()->json($response);
    }

    public function clientAutoSuggest(Request $request){
        $search = $request->search;
        if($search == ''){
            $items = Client::limit(5)->get(['name', 'id']);
        }else{
            $items = Client::where('name', 'like', '%' .$search . '%')->limit(10)->get(['name', 'id', 'contact','nid','profession']);
        }
        $response = array();
        foreach($items as $item){
            $response[] = array("label"=>$item->name,"value"=>$item->id, "contact"=>$item->contact, 'nid' =>$item->nid, 'profession' => $item->profession);
        }
        return response()->json($response);
    }


    public function projectAutoSuggest(Request $request){
//        $material_budgets = MaterialBudget::distinct()->get(['project_id'])->pluck('project_id');

        $items = CostCenter::where('name', 'like', '%' .$request->search . '%')
            ->limit(10)
            ->get(['name', 'project_id','id']);

        $response = [];

        foreach($items as $item){
            $response[] = array("label"=>$item->name,"value"=>$item->project_id,"cost_center_id"=>$item->id);
        }

        return response()->json($response);
    }


    public function leadAutoSuggest(Request $request){
        $search = $request->search;
        if($search == ''){
            $items = LeadGeneration::limit(5)->get(['name', 'id']);
        }else{
            $items = LeadGeneration::where('name', 'like', '%' .$search . '%')
//                ->where('lead_stage','=','A')
                ->limit(10)->get(['name', 'id']);
        }
        $response = array();
        foreach($items as $item){
            $response[] = array("label"=>$item->name,"value"=>$item->id);
        }
        return response()->json($response);
    }

    public function loadProjectApartment($project_id){
         $apartments = Apartment::orderBy('name')->where('owner', 1)
            ->doesntHave('sell')
            ->where('project_id', $project_id)
            ->get();
         return $apartments;
//        dd($apartments->toArray());
    }

    public function loadProjectTypes($project_id){
        return $apartments = ProjectType::orderBy('type_name')->where('project_id', $project_id)->get();
    }

    public function loadProjectBasement($project_id){
        $project = Project::orderBy('name')->where('id', $project_id)->firstOrFail();
        return $project->basement ? $project->basement : 0;
    }

    public function loadClientInformations($client_id){
        return $clients = Client::orderBy('name')->where('id', $client_id)->firstOrFail();
    }

    public function loadLeadInformations($lead_id){

        return $leads = LeadGeneration::orderBy('name')->where('id',$lead_id )->first();
    }


    public function loadSoldClientsWithApartment($project_id){
        $sells = Sell::with('apartment:id,name,project_id','apartment.project:id,name', 'sellClient.client:id,name')
        ->whereHas('apartment', function($q)use($project_id){
            $q->where('project_id', $project_id);
        })->get();
        return $sells;
    //    dd($sells->toArray());
    }


    public function loadSoldApartmentInformation($sell_id){
        $sell = Sell::with('apartment:id,name,project_id,apartment_size','apartment.project:id,name', 'sellClient.client:id,name,contact', 'salesCollections.salesCollectionDetails', 'lastCollection.salesCollectionDetails')
            ->withSum('salesCollectionDetails', 'applied_amount')
            ->withSum('salesCollectionDetails', 'amount')
            ->with('salesCollections', function($q){
                $q->orderBy('created_at', 'desc')->first();
            })
            ->with('salesCollectionDetails', function($q)use($sell_id){
                $q->where('sell_id', $sell_id);
            })
            ->where('id', $sell_id)->first();
        $sell['last_payment_date']=$sell->lastCollection ? $sell->lastCollection->received_date : null;
        $sell['last_payment_purpose']=$sell->lastCollection ? $sell->lastCollection->salesCollectionDetails->pluck('particular')->join(', ', ', and ') : null;
        $sell['last_installment_no']=$sell->lastCollection ? $sell->lastCollection->salesCollectionDetails->pluck('installment_no')->join(', ', ', and ') : null;
        $sell['last_received_amount']=$sell->lastCollection ? $sell->lastCollection->received_amount : null;
//        $sell['last_received_amount']=$sell->sales_collection_details_sum_applied_amount - $sell->lastCollection->received_amount : null;
        return $sell;
    }

    public function loadCurrentInstallment($sell_id){
        $currentInstallment = InstallmentList::withSum('installmentCollections', 'amount')->where('sell_id', $sell_id)->get()
            ->map(function($item){
                if($item->installment_amount > $item->installment_collections_sum_amount){
                    return $item;
                }
            })->filter()->first();
        return $currentInstallment;
    }

    public function loadNextInstallment($sell_id, $installment_no){
        // dd($sell_id, $installmentId);
        $currentInstallment = InstallmentList::where('sell_id', $sell_id)->where('installment_no', $installment_no)->first();
        return $currentInstallment;
    }



    public function loadBookingMoney($sell_id)
    {
        $sell = Sell::withSum('bookingMoneyCollections', 'amount')->whereId($sell_id)->firstOrFail();
        $sell['due']= $sell->booking_money - $sell->booking_money_collections_sum_amount;
        return $sell;
    }


    public function loadDownpayment($sell_id)
    {
        $sell = Sell::withSum('downpaymentCollections', 'amount')->whereId($sell_id)->first();
        $sell['due']= $sell->downpayment - $sell->downpayment_collections_sum_amount;
        return $sell;
    }


    public function loadProjectUnsoldParkings($project_id){
        //Parking Load
        return ParkingDetails::whereHas('parking.project', function($q)use($project_id){
            $q->where('id', $project_id);
        })
        ->where('parking_owner', "JHL")
        ->doesntHave('soldParking')
        ->pluck('parking_name', 'parking_composite');
    }

    public function workOrderAutoSuggest(Request $request){
        //        $material_budgets = MaterialBudget::distinct()->get(['project_id'])->pluck('project_id');

                $items = Workorder::with(['supplier','project.costCenter'])
                    ->where('workorder_no', 'like', '%' .$request->search . '%')
                    ->limit(10)
                    ->get();

                $response = [];
                foreach($items as $item){
                    $response[] = array(
                        "label"=>$item->workorder_no,
                        "value"=>$item->id,
                        'supplier_id'=>$item->supplier_id,
                        'supplier_name' => $item->supplier->name,
                        'project_id' => $item->project_id ?? 0,
                        'project_name' => $item->project?->name ?? 0,
                        'cost_center_id' => $item->project?->costCenter?->id ?? 0,
                        'account_id' => $item->supplier->account->id
                    );
                }

                return response()->json($response);
    }

    public function workOrderAutoSuggestForSuppliers(Request $request){
        //        $material_budgets = MaterialBudget::distinct()->get(['project_id'])->pluck('project_id');

                $items = Workorder::with(['supplier','project.costCenter'])
                    ->where('supplier_id',$request->supplier_id)
                    ->where('workorder_no', 'like', '%' .$request->search . '%')
                    ->limit(10)
                    ->get();

                $response = [];
                foreach($items as $item){
                    $response[] = array(
                        "label"=>$item->workorder_no,
                        "value"=>$item->id,
                        'supplier_id'=>$item->supplier_id,
                        'supplier_name' => $item->supplier->name,
                        'project_id' => $item->project_id,
                        'project_name' => $item->project->name,
                        'cost_center_id' => $item->project->costCenter->id,
                        'account_id' => $item->supplier->account->id
                    );
                }

                return response()->json($response);
    }

    public function boqEmeWorkOrderAutoSuggestForSuppliers(Request $request){
        //        $material_budgets = MaterialBudget::distinct()->get(['project_id'])->pluck('project_id');

                $items = BoqEmeWorkOrder::with(['supplier','workCs.project.costCenter'])
                    ->where('supplier_id',$request->supplier_id)
                    ->where('workorder_no', 'like', '%' .$request->search . '%')
                    ->limit(10)
                    ->get();

                $response = [];
                foreach($items as $item){
                    $response[] = array(
                        "label"=>$item->workorder_no,
                        "value"=>$item->id
                    );
                }
                return response()->json($response);
    }

    public function boqEmeWorkOrderAutoSuggest(Request $request){
        //        $material_budgets = MaterialBudget::distinct()->get(['project_id'])->pluck('project_id');

                $items = BoqEmeWorkOrder::with(['supplier','workCs.project.costCenter'])
                    ->where('workorder_no', 'like', '%' .$request->search . '%')
                    ->limit(10)
                    ->get();

                $response = [];
                foreach($items as $item){
                    $response[] = array(
                        "label"=>$item->workorder_no,
                        "value"=>$item->id,
                        'supplier_id'=>$item->supplier_id,
                        'supplier_name' => $item->supplier->name,
                        'project_id' => $item->workCs->project_id,
                        'project_name' => $item->workCs->project->name,
                        'cost_center_id' => $item->workCs->project->costCenter->id,
                        'account_id' => $item->supplier->account->id
                    );
                }

                return response()->json($response);
    }

    public function searchWorkType(Request $request){
                $items = WorkorderRate::where('workorder_id',$request->search)
                    ->get(['work_level','id']);

                 $response = "<option value='' disabled>Select Work Type</option>";
                 foreach($items as $item){
                    $response  .= "<option value='$item->id'>$item->work_level</option>";
                 };
                 return $response;
    }
}
