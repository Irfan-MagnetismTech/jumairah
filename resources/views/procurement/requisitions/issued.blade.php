@extends('layouts.backend-layout')
@section('title', 'Requistions')

@section('breadcrumb-title')
    @if($formType == 'edit')
        Edit Requistion
    @else
        Add New Requistion
    @endif
@endsection

@section('breadcrumb-button')
    <a href="{{ url('requisitions') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', null)

@section('content')

    @if($formType == 'issue')
        {!! Form::open(array('url' => "requisitions/$issue->id",'method' => 'PUT', 'class'=>'custom-form')) !!}
    @else
        {!! Form::open(array('url' => "requisitions",'method' => 'POST', 'class'=>'custom-form')) !!}
    @endif
        <div class="row">
            <div class="col-12 col-lg-4">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="reason">Requistion For<span class="text-danger">*</span></label>
                    {{Form::select('reason', $reasons, old('reason') ? old('reason') : (!empty($requisition->reason) ? $requisition->reason : null),['class' => 'form-control','id' => 'reason', 'placeholder'=>"Select Reason", 'autocomplete'=>"off"])}}
                </div>
            </div>
            <div class="col-12 col-lg-8">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="remarks">Remarks<span class="text-danger">*</span></label>
                    {{Form::textarea('remarks', old('remarks') ? old('remarks') : (!empty($requisition->remarks) ? $requisition->remarks : null),['class' => 'form-control','id' => 'remarks', 'autocomplete'=>"off", 'rows'=>1])}}
                </div>
            </div>

        </div><!-- end row -->

        <hr class="bg-success">
        <div class="table-responsive">
            <table id="purchaseTable" class="table table-striped table-bordered" >
                <thead>
                <tr>
                    <th>Item</th>
                    <th>Quantity</th>
                    <th>Issued Quantity</th>
                    <th>Remarks (Product-Wise)</th>
                    <th><i class="btn btn-primary btn-sm fa fa-plus" id="addItem" onclick="addItemDtl()"> </i></th>
                </tr>
                </thead>
                <tbody>

                @if(!empty($requisition))
                    @foreach($requisition->requisitiondetails as $requisitiondetail)
                        <tr>
                            <td>{{Form::select('raw_material_id[]',$rawMaterials,old('raw_material_id') ? old('raw_material_id') : (!empty($requisitiondetail->raw_material_id) ? $requisitiondetail->raw_material_id : null),  ['class' => 'form-control', 'placeholder' => 'Select Product', 'required']  )}}</td>
                            <td>{{Form::number('quantity[]', old('quantity') ? old('quantity') : (!empty($requisitiondetail->quantity) ? $requisitiondetail->quantity : null),['class' => 'form-control text-right', 'min'=>'0', 'step'=>'0.01', 'required'] )}}</td>
                            <td>{{Form::number('issued_quantity[]', old('issued_quantity') ? old('issued_quantity') : (!empty($requisitiondetail->issued_quantity) ? $requisitiondetail->issued_quantity : null),['class' => 'form-control text-right', 'min'=>'0', 'step'=>'0.01'] )}}</td>
                            <td>{{Form::textarea('product_remarks[]', old('product_remarks') ? old('product_remarks') : (!empty($requisitiondetail->product_remarks) ? $requisitiondetail->product_remarks : null),['class' => 'form-control quantity', 'rows'=>1] )}}</td>
                            <td class="text-center"><button class="btn btn-danger btn-sm deleteItem" onclick="removQRow(this)" type="button"><i class="fa fa-minus"></i></button></td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
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

        var i = "{{!empty($requisition) ? count($requisition->requisitiondetails) : 1}}";
        function addItemDtl(){
            i++;
            var Row = `
                <tr>
                <td>{{Form::select('raw_material_id[]',$rawMaterials,old('raw_material_id') ? old('raw_material_id') : (!empty($requisition->raw_material_id) ? $requisition->raw_material_id : null),  ['class' => 'form-control', 'placeholder' => 'Select Product', 'required']  )}}</td>
                <td>{{Form::number('quantity[]', old('quantity') ? old('quantity') : (!empty($requisition->quantity) ? $requisition->quantity : null),['class' => 'form-control text-right', 'min'=>'0', 'step'=>'0.01', 'required'] )}}</td>
                <td>{{Form::number('issued_quantity[]', old('issued_quantity') ? old('issued_quantity') : (!empty($requisition->issued_quantity) ? $requisition->issued_quantity : null),['class' => 'form-control text-right', 'min'=>'0', 'step'=>'0.01'] )}}</td>
                <td>{{Form::textarea('product_remarks[]', old('product_remarks') ? old('product_remarks') : (!empty($requisition->product_remarks) ? $requisition->product_remarks : null),['class' => 'form-control', 'rows' => 1] )}}</td>
                <td class="text-center"><button class="btn btn-danger btn-sm deleteItem" onclick="removQRow(this)" id="" type="button"><i class="fa fa-minus"></i></button></td>
                </tr>
            `;

            var tableItem = $('#purchaseTable').append(Row);
        }
        function removQRow(qval){
            var rowIndex = qval.parentNode.parentNode.rowIndex;
            document.getElementById("purchaseTable").deleteRow(rowIndex);
        }

        $(function(){
            @if($formType == 'create')
                addItemDtl();
            @endif

            $('#date').datepicker({format: "dd-mm-yyyy",autoclose: true,todayHighlight: true,showOtherMonths: true});
        });


    </script>
@endsection
