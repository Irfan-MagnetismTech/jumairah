@extends('layouts.backend-layout')
@section('title', 'MRR Details')

@section('breadcrumb-title')
    Material Receive Receipt (MRR) Details
@endsection

@section('breadcrumb-button')
    @php
        $approval = \App\Approval\ApprovalLayerDetails::whereHas('approvalLayer', function ($q) {
            $q->where('name', 'Material Receive Report');
        })
            ->whereDoesntHave('approvals', function ($q) use ($materialReceife) {
                $q->where('approvable_id', $materialReceife->id)->where('approvable_type', \App\Procurement\MaterialReceive::class);
            })
            ->orderBy('order_by', 'asc')
            ->first();
    @endphp
    @if (!empty($approval) && $approval->designation_id == auth()->user()->designation?->id)
        <a href="{{ url("material-receive-approve/$materialReceife->id/1") }}" data-toggle="tooltip"
            title="Approve Requisition" class="btn btn-sm btn-success"><i class="fa fa-check" aria-hidden="true"></i></a>
    @endif
    @if ($materialReceife->approval()->doesntExist())
        <a href="{{ url("materialReceives/$materialReceife->id/edit") }}" data-toggle="tooltip" title="Edit"
            class="btn btn-sm btn-outline-warning"><i class="fas fa-pen"></i></a>
    @endif()
    <a href="{{ url('materialReceives') }}" class="btn btn-out-dashed btn-sm btn-warning"><i
            class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    {{--    <span class="text-danger">*</span> Marked are required. --}}
@endsection

@section('content-grid', null)

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive">
                <table id="dataTable" class="table table-striped table-bordered">
                    <tbody class="text-left">

                        <tr style="background-color: #0C4A77;color: white">
                            <td> <strong>MRR No.</strong> </td>
                            <td> <strong>{{ $materialReceife->mrr_no }}</strong></td>
                        </tr>
                        <tr style="background-color: #0C4A77;color: white">
                            <td> <strong>Supplier Name</strong> </td>
                            <td> <strong>{{ $materialReceife->purchaseorderForPo->cssupplier->supplier->name }}</strong>
                            </td>
                        </tr>
                        @if ($materialReceife->iou_id)
                            <tr style="background-color: #0C4A77;color: white">
                                <td> <strong>Iou No.</strong> </td>
                                <td> <strong>{{ $materialReceife->iou->iou_no }}</strong></td>
                            </tr>
                        @else
                            <tr style="background-color: #0C4A77;color: white">
                                <td> <strong>MPR No.</strong> </td>
                                <td> <strong>{{ $materialReceife->purchaseorderForPo->mpr->mpr_no }}</strong></td>
                            </tr>
                        @endif
                        @if ($materialReceife->requisition_id)
                            <tr style="background-color: #0C4A77;color: white">
                                <td> <strong>MPR No.</strong> </td>
                                <td> <strong>{{ $materialReceife->iou->mpr->mpr_no }}</strong></td>
                            </tr>
                        @endif
                        <tr style="background-color: #0C4A77;color: white">
                            <td> <strong>PO No.</strong> </td>
                            <td>{{ $materialReceife->po_no }}</td>
                        </tr>
                        <tr>
                            <td> <strong>MPR Date</strong> </td>
                            <td> {{ $materialReceife->purchaseorderForPo->mpr->applied_date }}</td>
                        </tr>
                        <tr>
                            <td> <strong>PO Date</strong> </td>
                            <td> {{ $materialReceife->purchaseorderForPo->date }}</td>
                        </tr>
                        <tr>
                            <td> <strong>Date</strong> </td>
                            <td> {{ $materialReceife->date }}</td>
                        </tr>
                        <tr>
                            <td> <strong>Project Name</strong> </td>
                            <td> {{ $materialReceife->purchaseorderForPo->mpr->costCenter->name }}</td>
                        </tr>
                        <tr>
                            <td> <strong>Project Address</strong> </td>
                            <td>{{ $materialReceife->purchaseorderForPo->mpr->costCenter->project->location }}</td>
                        </tr>
                        <tr>
                            <td> <strong>Remarks</strong> </td>
                            <td>{{ $materialReceife->remarks }}</td>
                        </tr>
                        <tr>
                            <td> <strong>Quality</strong> </td>
                            <td>{{ $materialReceife->quality }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table id="example" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Material Name</th>
                    <th>Unit</th>
                    <th>Brand</th>
                    <th>Origin</th>
                    <th>Challan No.</th>
                    <th>Quantity</th>
                    <th>ledger Folio No</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($materialReceife->materialreceivedetails as $materialreceivedetail)
                    <tr>
                        <td> {{ $materialreceivedetail->nestedMaterials->name }} </td>
                        <td> {{ $materialreceivedetail->nestedMaterials->unit->name }} </td>
                        <td>{{ $materialreceivedetail->brand }}</td>
                        <td> {{ $materialreceivedetail->origin }} </td>
                        <td> {{ $materialreceivedetail->challan_no }} </td>
                        <td> {{ $materialreceivedetail->quantity }} </td>
                        <td> {{ $materialreceivedetail->ledger_folio_no }} </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if ($materialReceife->approval()->exists())
        <div class="table-responsive">
            <table id="example" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th style="background-color: #2077b6;color: white">Approval Status</th>
                        <th style="background-color: #2077b6;color: white">Department</th>
                        <th style="background-color: #2077b6;color: white">Approved By</th>
                        <th style="background-color: #2077b6;color: white">Designation</th>
                        <th style="background-color: #2077b6;color: white">Approved At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($materialReceife->approval as $item)
                        <tr>
                            <td> {{ $item->status }} </td>
                            <td> {{ $item->user->employee->department->name ?? '' }} </td>
                            <td> {{ $item->user->name ?? '' }} </td>
                            <td> {{ $item->user->employee->designation->name ?? '' }}</td>
                            <td> {{ $item->created_at }} </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endsection
