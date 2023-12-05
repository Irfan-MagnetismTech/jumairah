@extends('layouts.backend-layout')
@section('title', 'Goods Receiving Note')

@section('breadcrumb-title')
    @if($formType == 'edit')
        Edit Goods Receiving Note
    @else
        Add New Goods Receiving Note
    @endif
@endsection

@section('breadcrumb-button')
    <a href="{{ url('purchases') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid',null)

@section('content')

    @if($formType == 'edit')
        {!! Form::open(array('url' => "purchases/$purchase->id",'method' => 'PUT', 'class'=>'custom-form')) !!}
    @else
        {!! Form::open(array('url' => "purchases",'method' => 'POST', 'class'=>'custom-form')) !!}
    @endif
    <div class="row">
        <div class="col-md-3">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="lc_dollar_value"> PO ID <span class="text-danger">*</span></label>
                {{Form::text('purchase_order_id', old('purchase_order_id') ? old('purchase_order_id') : (!empty($purchase->purchase_order_id) ? $purchase->purchase_order_id  : null),['class' => 'form-control', "onchange"=>"getPurchaseOrderInfo(this)", 'autocomplete'=>"off", 'id'=>"purchase_order_id"])}}
            </div>
        </div>
        <div class="col-md-4">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="date"> Date <span class="text-danger">*</span></label>
                {{Form::text('date', old('date') ? old('date') : (!empty($purchase->date) ? date('d-m-Y',strtotime($purchase->date))  : null),['class' => 'form-control','id' => 'date', 'autocomplete'=>"off"])}}
            </div>
        </div>
        <div class="col-md-5">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="supplier_id">Supplier <span class="text-danger">*</span></label>
                {{Form::hidden('supplier_id', old('supplier_id') ? old('supplier_id') : (!empty($purchase->supplier_id) ? $purchase->supplier_id : null),['class' => 'form-control','id' => 'supplier_id','placeholder' => 'Select Supplier', 'autocomplete'=>"off",'readonly'])}}
                {{Form::text('supplier_name', old('supplier_name') ? old('supplier_name') : (!empty($purchase->supplier_id) ? $purchase->supplier->name : null),['class' => 'form-control','id' => 'supplier_name','placeholder' => 'Select Supplier', 'autocomplete'=>"off",'readonly'])}}
            </div>
        </div>

        <div class="col-md-12">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="remarks"> Remarks  <span class="text-danger">*</span></label>
                {{Form::text('remarks', old('remarks') ? old('remarks') : (!empty($purchase->remarks) ? $purchase->remarks : null),['class' => 'form-control','id' => 'remarks', 'autocomplete'=>"off",])}}
            </div>
        </div>
    </div>

    <hr class="bg-success">
{{--        <h5>Add Item </h5>--}}
        <div class="table-responsive">
            <table id="purchaseTable" class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>Raw Material</th>
                    <th>PO Quantity</th>
                    <th>Left Qnt</th>
                    <th>Purchase Quantity</th>
                    <th colspan="2">Unit Price</th>
                    <th colspan="2">Total Price</th>
{{--                    <th><i class="btn btn-primary btn-sm fa fa-plus" id="addItem" onclick="addItemDtl()"> </i></th>--}}
                </tr>
                </thead>
                <tbody id="purchaseTblBody">
                @if(!empty($purchase))
                    @foreach($purchase->purchaseDetails as $purchaseDtl)
                        <tr>
                            <td>
                                {{Form::hidden('raw_material_id[]' ,old('raw_material_id') ? old('raw_material_id') : (!empty($purchaseDtl->raw_material_id) ? $purchaseDtl->raw_material_id : null),  ['class' => 'unit_price form-control raw_material_id item_unit', 'placeholder' => '--Select--','readonly'])}}
                                {{$purchaseDtl->rowMetarials->name}}
                            </td>
                            <td class="">{{$purchaseDtl->purchaseOrderDetail->quantity}}</td>
                            <td class="">

                            </td>
{{--                            <td>{{Form::select('unit_id[]',$units, old('unit_id') ? old('unit_id') : (!empty($purchaseDtl->unit_id) ? $purchaseDtl->unit_id : null),['class' => 'form-control unit_id text-right', 'placeholder' => 'unit', ''] )}}</td>--}}
                            <td>{{Form::number('quantity[]', old('quantity') ? old('quantity') : (!empty($purchaseDtl->quantity) ? $purchaseDtl->quantity : ""),['class' => 'form-control quantity text-right', 'placeholder' => '0 ', '',"onchange"=>"productQnt(this)"] )}}</td>
                            <td colspan="2"> {{Form::number('unite_price[]', old('unite_price') ? old('unite_price') : (!empty($purchaseDtl->unite_price) ? $purchaseDtl->unite_price : null),['class' => 'form-control unite_price text-right', 'placeholder' => '0.00 ', "onchange"=>"productUnitPrice(this)",'readonly'] )}}</td>
                            <td colspan ="2">{{Form::number('totalPrice[]', old('totalPrice') ? old('totalPrice') : (!empty($purchaseDtl->totalPrice) ? $purchaseDtl->totalPrice : null),['class' => 'form-control totalPrice text-right', 'placeholder' => '0.00 ', 'readonly'] )}}</td>
{{--                            <td class="text-center"><button class="btn btn-danger btn-sm deleteItem" onclick="removQRow(this)" type="button"><i class="fa fa-minus"></i></button></td>--}}
                        </tr>
                    @endforeach
                @endif
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" class="text-right"></th>
                        <th colspan="" class="text-right"> VAT (10%)</th>
                        <th class="">{{Form::number('vat', old('vat') ? old('vat') : (!empty($purchase->vat) ? $purchase->vat : null),['class' => 'form-control text-right','id' => 'vat', 'autocomplete'=>"off",'readonly'])}} </th>
                        <th class="text-right">Grand Total</th>
                        <th>{{Form::text('total_amount', old('total_amount') ? old('total_amount') : (!empty($purchase->total_amount) ? $purchase->total_amount : null),['class' => 'form-control text-right','id' => 'producttotal', 'autocomplete'=>"off",'readonly'])}}</th>
{{--                        <th></th>--}}
                    </tr>
                    <tr>
                        <th colspan="3" class="text-right"></th>
                        <th colspan="" class="text-right"> Discount</th>
                        <th>{{Form::number('discount', old('discount') ? old('discount') : (!empty($purchase->discount) ? $purchase->discount : null),['class' => 'form-control text-right','id' => 'discount', 'autocomplete'=>"off",''])}} </th>
                        <th class="text-right">Net Payable</th>
                        <th>{{Form::number('net_total', old('net_total') ? old('net_total') : (!empty($netAmount) ? $netAmount : null),['class' => 'form-control text-right','id' => 'net_total', 'autocomplete'=>"off",'readonly'])}} </th>
{{--                        <th></th>--}}
                    </tr>
                    <tr>
                        <th colspan="3" class="text-right"></th>
                        <th colspan="" class="text-right"> Pay Amount</th>
                        <th>{{Form::number('pay_amount', old('pay_amount') ? old('pay_amount') : (!empty($payAmount) ? $payAmount : null),['class' => 'form-control text-right','id' => 'pay_amount', 'autocomplete'=>"off",''])}}</th>
                        <th class="text-right">Due</th>
                        <th>{{Form::number('due', old('due') ? old('due') : (!empty($dueAmount) ? $dueAmount : null),['class' => 'form-control text-right','id' => 'due', 'autocomplete'=>"off",'readonly'])}}</th>
{{--                        <th></th>--}}
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="row">
            <div class="offset-md-4 col-md-4 mt-2">
                <div class="input-group input-group-sm ">
                    <button class="btn btn-success btn-round btn-block py-2">Submit</button>
                </div>
            </div>
        </div> <!-- end row -->

    {!! Form::close() !!}

@endsection

@section('script')
    <script>

        function getPurchaseOrderInfo(purVal){
            let poId = $(purVal).val()
            let url ='{{url("purchase/getPurchaseOrder")}}/'+poId;
            let detailTable = $("#purchaseTblBody");
            fetch(url)
                .then((resp) => resp.json())
                .then(function(poInfo) {
                    $("#supplier_id").val(poInfo.supplier_id);
                    $("#supplier_name").val(poInfo.supplier.name);
                    $(detailTable).empty();

                    poInfo.purchase_order_details.forEach(function (purchaseOrderDtl, key){
                        // console.log(purchaseOrderDtl.purchase_details);
                        let purchaseQnt = 0;
                        purchaseOrderDtl.purchase_details.forEach(function (purchaseDtl, key){
                            purchaseQnt += purchaseDtl.quantity;
                        })
                        $(detailTable).append(`
                            <tr>
                                <td>${purchaseOrderDtl.row_metarials.name}
                                    <input type="hidden" name="purchase_order_detail_id[]" value="${purchaseOrderDtl.id}" class="">
                                    <input type="hidden" name="raw_material_id[]" value="${purchaseOrderDtl.raw_material_id}" class="">
                                </td>
                                <td>${purchaseOrderDtl.quantity} ${purchaseOrderDtl.unit.name}</td>
                                <td>${purchaseOrderDtl.quantity - purchaseQnt}</td>
                                <td>{{Form::number('quantity[]', old('quantity') ? old('quantity') : (!empty($purchaseOrderDtl->quantity) ? $purchaseOrderDtl->quantity : "purchaseOrderDtl.unit_price"),['class' => 'form-control quantity text-right', 'placeholder' => '0 ', '',"onchange"=>"productQnt(this)"] )}}</td>
                                <td colspan="2" class="text-right"><input type="text" name="unite_price[]" value="${purchaseOrderDtl.unit_price}" class="form-control unite_price text-right" readonly></td>
                                <td colspan="2" class="text-right"><input type="text" name="totalPrice[]" value="" class="form-control totalPrice text-right" readonly></td>
                            </tr>
                        `)
                    });
                    $("#producttotal").val(poInfo.grand_total_price);
                    let vatPercentage = ((poInfo.grand_total_price/ 100 )*10);
                    $("#vat").val(vatPercentage.toFixed(2));
                })
                .catch(function () {
                });
        }

{{--        @if($formType == 'create')--}}
        $(function(){
           // addItemDtl();
            totalItem();
            let po_id = $("#purchase_order_id").val()
            getPurchaseOrderInfo();
        });
{{--        @endif--}}

        var i =1;
        function addItemDtl(){
            i++;
            var Row = `
                <tr class='menuItem'>
                    <td>{{Form::select('raw_material_id[]',$rawItems ,old('raw_material_id') ? old('raw_material_id') : (!empty($purchaseDtl->raw_material_id) ? $purchaseDtl->raw_material_id : null),  ['class' => 'unit_price form-control raw_material_id item_unit', 'placeholder' => '--Select--',]  )}}</td>
                    <td>{{Form::number('quantity[]', old('quantity') ? old('quantity') : (!empty($purchaseDtl->quantity) ? $purchaseDtl->quantity : null),['class' => 'form-control quantity text-right', 'placeholder' => '0 ', '',"onchange"=>"productQnt(this)"] )}}</td>
                    <td>{{Form::select('unit_id[]',$units, old('unit_id') ? old('unit_id') : (!empty($purchaseDtl->unit_id) ? $purchaseDtl->unit_id : null),['class' => 'form-control unit_id text-right', 'placeholder' => 'unit', ''] )}}</td>
                    <td colspan="2"> {{Form::number('unite_price[]', old('unite_price') ? old('unite_price') : (!empty($purchaseDtl->unite_price) ? $purchaseDtl->unite_price : null),['class' => 'form-control unite_price text-right', 'placeholder' => '0.00 ', "onchange"=>"productUnitPrice(this)"] )}}</td>
                    <td colspan ="2">{{Form::number('totalPrice[]', old('totalPrice') ? old('totalPrice') : (!empty($purchaseDtl->totalPrice) ? $purchaseDtl->totalPrice : null),['class' => 'form-control totalPrice text-right', 'placeholder' => '0.00 ', 'readonly'] )}}</td>
                    <td class="text-center"><button class="btn btn-danger btn-sm deleteItem" onclick="removQRow(this)" id="" type="button"><i class="fa fa-minus"></i></button></td>
                </tr>
            `;
            var tableItem = $('#purchaseTable').append(Row);
            totalItem()
            // cost = up/pt*tc
        }
        function removQRow(qval){
            var rowIndex = qval.parentNode.parentNode.rowIndex;
            document.getElementById("purchaseTable").deleteRow(rowIndex);
            totalItem();
        }
        function totalItem(){
            var totalItemPrice = 0;
            if($(".totalPrice").length > 0){
                $(".totalPrice").each(function(i, row){
                    let productTK = Number($(row).val());
                    totalItemPrice += parseFloat(productTK);
                })
            }
            $("#producttotal").val(totalItemPrice.toFixed(2));
            let vatPercentage = ((totalItemPrice/ 100 )*10);
            $("#vat").val(vatPercentage.toFixed(2));
        }
        function productQnt(qnt){
            let quantity =  $(qnt).val();
            let unitPrice = $(qnt).closest('tr').find('.unite_price').val();
            let totalPr =  unitPrice * quantity;
            $(qnt).closest('tr').find('.totalPrice').val(totalPr.toFixed(2));
        }
        function productUnitPrice(price){
            let priceval =  $(price).val();
            let quantity = $(price).closest('tr').find('.quantity').val();
            $(price).closest('tr').find('.totalPrice').val( priceval * quantity);
        }
        $("#discount").on('change', function (){
            let gtotal = $("#producttotal").val()
            let vat = $("#vat").val();
            let dis = $("#discount").val();
            let nettotal =gtotal-vat-dis;
            $("#net_total").val(nettotal.toFixed(2))
        })
        $("#pay_amount").on('change', function (){
            let payAmt = $("#pay_amount").val();
            let net_total = $("#net_total").val()
            let due = net_total-payAmt;
            $("#due").val(due.toFixed(2))
        })
        $(document,'.totalPrice').on('change', function(){
            totalItem();
        });

        $('#date').datepicker({format: "dd-mm-yyyy",autoclose: true,todayHighlight: true,showOtherMonths: true});

    </script>
@endsection
