@extends('layouts.backend-layout')
@section('title', 'MPR Details')

@section('breadcrumb-title')
    Material Purchase Requisition (MPR) Details
@endsection

@section('breadcrumb-button')
        @php
            $approval = \App\Approval\ApprovalLayerDetails::whereHas('approvalLayer', function ($q){
                $q->where('name','Requisiton');
            })->whereDoesntHave('approvals',function ($q) use($requisition){
                $q->where('approvable_id',$requisition->id)->where('approvable_type',\App\Procurement\Requisition::class);
            })->orderBy('order_by','asc')->first();
        @endphp
        @if(!empty($approval) && $approval->designation_id == auth()->user()->designation?->id)
            <a href="{{ url("generalRequisitions/approved/$requisition->id/1") }}" data-toggle="tooltip" title="Approve Requisition" class="btn btn-sm btn-success"><i class="fa fa-check" aria-hidden="true"></i></a>
        @endif
    <a href="{{ url('general-requisitions') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection


@section('content-grid',null)

@section('content')

    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="table-responsive">
                <table id="dataTable" class="table table-striped table-bordered">
                    <tbody class="text-left">
                    <tr style="background-color: #0C4A77;color: white"><td> <strong>MPR No.</strong> </td> <td> <strong>{{"MPR-".$requisition->mpr_no}}</strong></td></tr>
                    <tr><td> <strong>Project Name</strong> </td> <td> {{$requisition->costCenter->name}}</td></tr>
                    <tr><td> <strong>Note</strong> </td> <td>   {{$requisition->note}}</td></tr>
                    <tr><td> <strong>Applied Date</strong> </td> <td>  {{$requisition->applied_date}}</td></tr>
                    <tr><td> <strong>Requisition By</strong> </td> <td>  {{ $requisition->requisitionBy->name}}</td></tr>
                    <tr><td> <strong>Requisition Remarks</strong> </td> <td>  {{ $requisition->remarks}}</td></tr>
                    <tr><td> <strong>Status</strong> </td> <td class="text-c-orenge"><strong>{{ $requisition->status}}</strong></td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>



    <div class="table-responsive">
        <table id="example" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>Floor Name</th>
                <th>Material Name</th>
                <th>Unit</th>
                <th>Total Estimated<br> Requirement</th>
                <th>Net Comulative<br> Received</th>
                <th>Present<br> Stock</th>
                <th>Required<br> Presently</th>
                <th>Required<br> Delivery Date</th>
            </tr>
            </thead>
            <tbody>

            @foreach( $requisition->requisitiondetails as $key => $requisitiondetail)
            @php
                $boqMaterial = App\Procurement\NestedMaterial::whereHas('boqSupremeBudgets')->whereAncestorOrSelf($requisitiondetail->material_id)->orderBy('id','desc')->first();

                if (!empty($requisitiondetail->floor_id)) {
                    $floorNo = $requisitiondetail->boqFloors->where('project_id', $requisitiondetail->requisition->costCenter->project_id)->first();

                    $boq_quantity = App\Procurement\BoqSupremeBudget::
                            where('project_id',$requisitiondetail->requisition->costCenter->project_id)
                        ->where('floor_id', $floorNo->boq_floor_project_id)
                        ->where('material_id', $boqMaterial->id)
                        ->first();

                        $requisition_quantity = App\Procurement\Requisitiondetails::
                        where('floor_id', $requisitiondetail->floor_id)
                        ->where('material_id', $requisitiondetail->material_id)
                        ->get()
                        ->sum('quantity');

                }else{
                    $boq_quantity = App\Procurement\BoqSupremeBudget::
                        where('project_id',$requisitiondetail->requisition->costCenter->project_id)
                        ->where('material_id', $boqMaterial->id)
                        ->first();

                        $requisition_quantity = App\Procurement\Requisitiondetails::
                        whereNull('floor_id')
                        ->where('material_id', $requisitiondetail->material_id)
                        ->get()
                        ->sum('quantity');

                }

                    $present_stock_in_stock_history = App\Procurement\StockHistory::
                        where('cost_center_id', $requisitiondetail->requisition->cost_center_id)
                        ->where('material_id', $requisitiondetail->material_id)
                        ->latest()
                        ->get();
                    $material_receive_project_id = App\Procurement\MaterialReceive::
                        where('cost_center_id', $requisitiondetail->requisition->cost_center_id)
                        ->groupBy('cost_center_id')
                        ->first();


                    if(!empty($material_receive_project_id)){
                        $material_receive_details_quantity_sum = App\Procurement\Materialreceiveddetail::with('materialreceive')
                            ->whereHas('materialreceive', function ($query) use ($material_receive_project_id){
                                return $query->where('cost_center_id', $material_receive_project_id->cost_center_id);
                            })
                            ->where('material_id', $requisitiondetail->material_id)
                            ->where('created_at','>=',$requisitiondetail->created_at)
                            ->get()
                            ->sum('quantity');
                    }
                    $budgeted_quantity = $boq_quantity->quantity ?? 0;
                    $taken_quantity = $material_receive_details_quantity_sum ?? 0;
                    $present_stock = $present_stock_in_stock_history[0]->present_stock ?? 0;
                @endphp
                <tr>
                    <td> {{!empty($requisitiondetail->boqFloor->name) ? $requisitiondetail->boqFloor->name : "-"}} </td>
                    <td> {{$requisitiondetail->nestedMaterial->name}} </td>
                    <td> {{$requisitiondetail->nestedMaterial->unit->name}} </td>
                    <td> {{ $budgeted_quantity }} </td>
                    <td> {{ $taken_quantity }} </td>
                    <td> {{ $present_stock }} </td>
                    <td> {{$requisitiondetail->quantity}} </td>
                    <td> {{$requisitiondetail->required_date}} </td>
                </tr>
            @endforeach

            </tbody>
        </table>
    </div>
@endsection
