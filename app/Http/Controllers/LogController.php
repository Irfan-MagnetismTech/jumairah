<?php

namespace App\Http\Controllers;

use App\Billing\WorkCs;
use App\Billing\Workorder;
use App\Construction\MaterialPlan;
use App\construction\ProjectProgressReport;
use App\Construction\TentativeBudget;
use App\Construction\WorkPlan;
use App\CSD\CsdFinalCosting;
use App\CSD\CsdLetter;
use App\Parking;
use App\Procurement\AdvanceAdjustment;
use App\Procurement\Cs;
use App\Procurement\Iou;
use App\Procurement\Materialmovement;
use App\Procurement\MaterialReceive;
use App\Procurement\MovementIn;
use App\Procurement\MovementRequisition;
use App\Procurement\PurchaseOrder;
use App\Procurement\Requisition;
use App\Procurement\Storeissue;
use App\Procurement\Supplierbill;
use App\Project;
use App\SellCollectionHead;
use App\Sells\Apartment;
use App\Sells\Client;
use App\Sells\Followup;
use App\Sells\Leadgeneration;
use App\Sells\NameTransfer;
use App\Sells\SaleCancellation;
use App\Sells\SalesCollectionApproval;
use App\Sells\Sell;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class LogController extends Controller
{
    public function iouLog(Iou $iou)
    {
        $saleCancel = $iou;
        $activities = Activity::where('subject_type',Iou::class)->where('subject_id', $saleCancel->id)->get();
        return view('logs.saleCancellationLog', compact('activities', 'saleCancel'));
    }
    public function projectLog(Project  $project )
    {
        $saleCancel = $project;
        $activities = Activity::where('subject_type',Project::class)->where('subject_id', $saleCancel->id)->get();
        return view('logs.saleCancellationLog', compact('activities', 'saleCancel'));
    }

    public function parkingLog($id)
    {
        $saleCancel = Parking::whereId($id)->firstOrFail();
        $activities = Activity::where('subject_type',get_class($saleCancel))->where('subject_id', $saleCancel->id)->get();
        return view('logs.saleCancellationLog', compact('activities', 'saleCancel'));
    }

    public function apartmentLog($id)
    {
        $saleCancel = Apartment::whereId($id)->firstOrFail();
        $activities = Activity::where('subject_type',get_class($saleCancel))->where('subject_id', $saleCancel->id)->get();
        return view('logs.saleCancellationLog', compact('activities', 'saleCancel'));
    }

    public function leadgenerationLog($id)
    {
        $saleCancel = Leadgeneration::whereId($id)->firstOrFail();
        $activities = Activity::where('subject_type',get_class($saleCancel))->where('subject_id', $saleCancel->id)->get();
        return view('logs.saleCancellationLog', compact('activities', 'saleCancel'));
    }

    public function followupLog($id)
    {
        $saleCancel = Followup::whereId($id)->firstOrFail();
        $activities = Activity::where('subject_type',get_class($saleCancel))->where('subject_id', $saleCancel->id)->get();
        return view('logs.saleCancellationLog', compact('activities', 'saleCancel'));
    }

    public function clientLog($id)
    {
        $saleCancel = Client::whereId($id)->firstOrFail();
        $activities = Activity::where('subject_type',get_class($saleCancel))->where('subject_id', $saleCancel->id)->get();
        return view('logs.saleCancellationLog', compact('activities', 'saleCancel'));
    }

    public function sellLog($id)
    {
        $saleCancel = Sell::whereId($id)->firstOrFail();
        $activities = Activity::where('subject_type',get_class($saleCancel))->where('subject_id', $saleCancel->id)->get();
        return view('logs.saleCancellationLog', compact('activities', 'saleCancel'));
    }

    public function salesCollectionLog($id)
    {
        $saleCancel = SaleCancellation::whereId($id)->firstOrFail();
        $activities = Activity::where('subject_type',get_class($saleCancel))->where('subject_id', $saleCancel->id)->get();
        return view('logs.saleCancellationLog', compact('activities', 'saleCancel'));
    }

    public function nameTransferLog($id)
    {
        $saleCancel = NameTransfer::whereId($id)->firstOrFail();
        $activities = Activity::where('subject_type',get_class($saleCancel))->where('subject_id', $saleCancel->id)->get();
        return view('logs.saleCancellationLog', compact('activities', 'saleCancel'));
    }

    public function sellCollectionHeadLog($id)
    {
        $saleCancel = SellCollectionHead::whereId($id)->firstOrFail();
        $activities = Activity::where('subject_type',get_class($saleCancel))->where('subject_id', $saleCancel->id)->get();
        return view('logs.saleCancellationLog', compact('activities', 'saleCancel'));
    }

    public function salesCollectionApprovalLog($id)
    {
        $saleCancel = SalesCollectionApproval::whereId($id)->firstOrFail();
        $activities = Activity::where('subject_type',get_class($saleCancel))->where('subject_id', $saleCancel->id)->get();
        return view('logs.saleCancellationLog', compact('activities', 'saleCancel'));
    }

    public function saleCancellationLog($id)
    {
        $saleCancel = SaleCancellation::whereId($id)->firstOrFail();
        $activities = Activity::where('subject_type',get_class($saleCancel))->where('subject_id', $saleCancel->id)->get();
        return view('logs.saleCancellationLog', compact('activities', 'saleCancel'));
    }

    public function requisitionLog($id)
    {
        $saleCancel = Requisition::whereId($id)->firstOrFail();
        $activities = Activity::where('subject_type',get_class($saleCancel))->where('subject_id', $saleCancel->id)->get();
        return view('logs.saleCancellationLog', compact('activities', 'saleCancel'));
    }

    public function csLog($id)
    {
        $saleCancel = Cs::whereId($id)->firstOrFail();
        $activities = Activity::where('subject_type',get_class($saleCancel))->where('subject_id', $saleCancel->id)->get();
        return view('logs.saleCancellationLog', compact('activities', 'saleCancel'));
    }

    public function purchaseOrderLog($id)
    {
        $saleCancel = PurchaseOrder::whereId($id)->firstOrFail();
        $activities = Activity::where('subject_type',get_class($saleCancel))->where('subject_id', $saleCancel->id)->get();
        return view('logs.saleCancellationLog', compact('activities', 'saleCancel'));
    }

    public function materialReceiveLog($id)
    {
        $saleCancel = MaterialReceive::whereId($id)->firstOrFail();
        $activities = Activity::where('subject_type',get_class($saleCancel))->where('subject_id', $saleCancel->id)->get();
        return view('logs.saleCancellationLog', compact('activities', 'saleCancel'));
    }

    public function supplierBillLog($id)
    {
        $saleCancel = Supplierbill::whereId($id)->firstOrFail();
        $activities = Activity::where('subject_type',get_class($saleCancel))->where('subject_id', $saleCancel->id)->get();
        return view('logs.saleCancellationLog', compact('activities', 'saleCancel'));
    }

    public function storeissueLog($id)
    {
        $saleCancel = Storeissue::whereId($id)->firstOrFail();
        $activities = Activity::where('subject_type',get_class($saleCancel))->where('subject_id', $saleCancel->id)->get();
        return view('logs.saleCancellationLog', compact('activities', 'saleCancel'));
    }

    public function advanceadjustmentsLog($id)
    {
        $saleCancel = AdvanceAdjustment::whereId($id)->firstOrFail();
        $activities = Activity::where('subject_type',get_class($saleCancel))->where('subject_id', $saleCancel->id)->get();
        return view('logs.saleCancellationLog', compact('activities', 'saleCancel'));
    }

    public function materialmovementLog($id)
    {
        $saleCancel = Materialmovement::whereId($id)->firstOrFail();
        $activities = Activity::where('subject_type',get_class($saleCancel))->where('subject_id', $saleCancel->id)->get();
        return view('logs.saleCancellationLog', compact('activities', 'saleCancel'));
    }

    public function movementRequisitionLog($id)
    {
        $saleCancel = MovementRequisition::whereId($id)->firstOrFail();
        $activities = Activity::where('subject_type',get_class($saleCancel))->where('subject_id', $saleCancel->id)->get();
        return view('logs.saleCancellationLog', compact('activities', 'saleCancel'));
    }

    public function movementInLog($id)
    {
        $saleCancel = MovementIn::whereId($id)->firstOrFail();
        $activities = Activity::where('subject_type',get_class($saleCancel))->where('subject_id', $saleCancel->id)->get();
        return view('logs.saleCancellationLog', compact('activities', 'saleCancel'));
    }

    public function generalRequisitionLog($id)
    {
        $saleCancel = Requisition::whereId($id)->firstOrFail();
        $activities = Activity::where('subject_type',get_class($saleCancel))->where('subject_id', $saleCancel->id)->get();
        return view('logs.saleCancellationLog', compact('activities', 'saleCancel'));
    }

    public function workPlanLog($id)
    {
        $saleCancel = WorkPlan::whereId($id)->firstOrFail();
        $activities = Activity::where('subject_type',get_class($saleCancel))->where('subject_id', $saleCancel->id)->get();
        return view('logs.saleCancellationLog', compact('activities', 'saleCancel'));
    }

    public function materialPlanLog($id)
    {
        $saleCancel = MaterialPlan::whereId($id)->firstOrFail();
        $activities = Activity::where('subject_type',get_class($saleCancel))->where('subject_id', $saleCancel->id)->get();
        return view('logs.saleCancellationLog', compact('activities', 'saleCancel'));
    }

    public function workcsLog($id)
    {
        $saleCancel = WorkCs::whereId($id)->firstOrFail();
        $activities = Activity::where('subject_type',get_class($saleCancel))->where('subject_id', $saleCancel->id)->get();
        return view('logs.saleCancellationLog', compact('activities', 'saleCancel'));
    }

    public function workorderLog($id)
    {
        $saleCancel = Workorder::whereId($id)->firstOrFail();
        $activities = Activity::where('subject_type',get_class($saleCancel))->where('subject_id', $saleCancel->id)->get();
        return view('logs.saleCancellationLog', compact('activities', 'saleCancel'));
    }

    public function constructionbillLog($id)
    {
        $saleCancel = Workorder::whereId($id)->firstOrFail();
        $activities = Activity::where('subject_type',get_class($saleCancel))->where('subject_id', $saleCancel->id)->get();
        return view('logs.saleCancellationLog', compact('activities', 'saleCancel'));
    }

    public function tentativeBudgetLog($year, $id)
    {
        $saleCancel = TentativeBudget::where('applied_year', $year)->where('cost_center_id', $id)->firstOrFail();
        $activities = Activity::where('subject_type',get_class($saleCancel))->where('subject_id', $saleCancel->id)->get();
        return view('logs.saleCancellationLog', compact('activities', 'saleCancel'));
    }

    public function monthlyProgressReportLog($id)
    {
        $saleCancel = ProjectProgressReport::whereId($id)->firstOrFail();
        $activities = Activity::where('subject_type',get_class($saleCancel))->where('subject_id', $saleCancel->id)->get();
        return view('logs.saleCancellationLog', compact('activities', 'saleCancel'));
    }

    public function finalCostingLog($id)
    {
        $saleCancel = CsdFinalCosting::whereId($id)->firstOrFail();
        $activities = Activity::where('subject_type',get_class($saleCancel))->where('subject_id', $saleCancel->id)->get();
        return view('logs.saleCancellationLog', compact('activities', 'saleCancel'));
    }

    public function csdletterLog($id)
    {
        $saleCancel = CsdLetter::whereId($id)->firstOrFail();
        $activities = Activity::where('subject_type',get_class($saleCancel))->where('subject_id', $saleCancel->id)->get();
        return view('logs.saleCancellationLog', compact('activities', 'saleCancel'));
    }



}
