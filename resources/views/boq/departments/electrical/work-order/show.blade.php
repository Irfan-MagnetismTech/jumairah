@extends('layouts.backend-layout')
@section('title', 'PurchaseOrder Details')

@section('breadcrumb-title')
    Purchase Order Details
@endsection

@section('breadcrumb-button')
    <a href="{{ url('purchaseOrders') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    {{-- <span class="text-danger">*</span> Marked are required. --}}
@endsection

@section('content-grid', null)

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive">
                <table id="dataTable" class="table table-striped table-bordered">
                    <tbody class="text-left">
                        <tr style="background-color: #0C4A77;color: white">
                            <td> <strong>MPR No.</strong> </td>
                            <td> <strong>{{ 'MPR-' . $purchaseOrder->mpr->mpr_no }}</strong></td>
                        </tr>
                        <tr>
                            <td> <strong>CS No.</strong> </td>
                            <td> <strong>{{ $purchaseOrder->cs->reference_no }}</strong></td>
                        </tr>

                        <tr>
                            <td> <strong>Purchase Date</strong> </td>
                            <td> {{ $purchaseOrder->date }}</td>
                        </tr>
                        <tr>
                            <td> <strong>Project Name</strong> </td>

                            <td> {{ $purchaseOrder->mpr->project->name }}</td>
                        </tr>
                        <tr>
                            <td> <strong>Supplier Name</strong> </td>

                            <td>{{ $purchaseOrder->cssupplier->supplier->name }}</td>

                        </tr>
                        <tr>
                            <td> <strong>Source Tax</strong> </td>
                            <td> {{ $purchaseOrder->source_tax }}</td>
                        </tr>
                        <tr>
                            <td> <strong>Source Vat</strong> </td>
                            <td> {{ $purchaseOrder->source_vat }}</td>
                        </tr>
                        <tr>
                            <td> <strong>Remarks</strong> </td>
                            <td> {{ $purchaseOrder->remarks }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <h6 class="text-center">Material Details</h6>
        <table id="example" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>SL.No</th>
                    <th>Material Name</th>
                    <th>Material Code</th>
                    <th>Unit</th>
                    <th>Brand</th>
                    <th>Required Date </th>
                    <th>Quantity</th>
                    <th>Rate</th>
                    <th>Total Price</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($purchaseOrder->purchaseOrderDetails as $purchaseOrderDetail)
                    <tr>
                        <td> {{ $loop->iteration }}</td>
                        <td>{{ $purchaseOrderDetail->nestedMaterials->name }}</td>
                        <td>---</td>
                        <td>{{ $purchaseOrderDetail->nestedMaterials->unit->name }}</td>
                        <td> {{ $purchaseOrderDetail->brand }}</td>
                        <td> {{ $purchaseOrderDetail->required_date }}</td>
                        <td> {{ $purchaseOrderDetail->quantity }}</td>
                        <td class="text-right"> @money($purchaseOrderDetail->unit_price)</td>
                        <td class="text-right"> @money($purchaseOrderDetail->total_price)</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="8" class="text-right"> Carrying Cost </td>
                    <td class="text-right">@money($purchaseOrder->carrying_charge)</td>
                </tr>
                <tr>
                    <td colspan="8" class="text-right"> Labour Charge </td>
                    <td class="text-right">@money($purchaseOrder->labour_charge)</td>
                </tr>
                <tr>
                    <td colspan="8" class="text-right"> Discount </td>
                    <td class="text-right">@money($purchaseOrder->discount)</td>
                </tr>
                <tr>
                    <td colspan="8" class="text-right"> Total Amount </td>
                    <td class="text-right">@money($purchaseOrder->final_total)</td>
                </tr>
            </tfoot>
        </table>
    </div>
@endsection
