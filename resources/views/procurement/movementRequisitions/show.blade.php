@extends('layouts.backend-layout')
@section('title', 'MPR Details')

@section('breadcrumb-title')
    Material Transfer Requisition (MTR) Details
@endsection

@section('breadcrumb-button')
        @php
            $approval = \App\Approval\ApprovalLayerDetails::whereHas('approvalLayer', function ($q){
                $q->where('name','Requisiton');
            })->whereDoesntHave('approvals',function ($q) use($movementRequisition){
                $q->where('approvable_id',$movementRequisition->id)->where('approvable_type',\App\Procurement\Requisition::class);
            })->orderBy('order_by','asc')->first();
        @endphp
        @if(!empty($approval) && $approval->designation_id == auth()->user()->designation?->id)
            <a href="{{ url("generalRequisitions/approved/$requisition->id/1") }}" data-toggle="tooltip" title="Approve Requisition" class="btn btn-sm btn-success"><i class="fa fa-check" aria-hidden="true"></i></a>
        @endif
    <a href="{{ url('movement-requisitions') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection


@section('content-grid',null)

@section('content')

    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="table-responsive">
                <table id="dataTable" class="table table-striped table-bordered">
                    <tbody class="text-left">
                    <tr style="background-color: #0C4A77;color: white"><td> <strong>MTR No.</strong> </td> <td> <strong>{{"MPR-".$movementRequisition->mtrf_no}}</strong></td></tr>
                    <tr><td> <strong>Project Name</strong> </td> <td> {{$movementRequisition->fromCostcenter->name}}</td></tr>
                    <tr><td> <strong>Note</strong> </td> <td>   {{$movementRequisition->reason}}</td></tr>
                    <tr><td> <strong>Applied Date</strong> </td> <td>  {{$movementRequisition->applied_date}}</td></tr>
                    <tr><td> <strong>Requisition By</strong> </td> <td>  {{ $movementRequisition->user->name}}</td></tr>
                    <tr><td> <strong>Requisition Remarks</strong> </td> <td>  {{ $movementRequisition->remarks}}</td></tr>
                    <tr><td> <strong>Status</strong> </td> <td class="text-c-orenge"><strong>{{ $movementRequisition->status}}</strong></td></tr>
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
            @foreach( $movementRequisition->movementRequisitionDetails as $key => $movementRequisitiondetail)
                <tr>
                    <td> {{!empty($movementRequisitiondetail->boqFloor->name) ? $movementRequisitiondetail->boqFloor->name : "-"}} </td>
                    <td> {{$movementRequisitiondetail->nestedMaterial->name}} </td>
                    <td> {{$movementRequisitiondetail->nestedMaterial->unit->name}} </td>
                    <td> {{ !empty($movementRequisition->costCenter->boqSupremeBudget[0]->quantity) ? $movementRequisition->costCenter->boqSupremeBudget[0]->quantity : "-" }} </td>
                    <td> after MRR </td>
                    <td> after MRR </td>
                    <td> {{$movementRequisitiondetail->quantity}} </td>
                    <td> {{$movementRequisitiondetail->required_date}} </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
