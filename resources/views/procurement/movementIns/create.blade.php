@extends('layouts.backend-layout')
@section('title', 'Material Movements')

@section('breadcrumb-title')
    @if(!empty($movementIn))
        Edit Material Movement (IN)
    @else
        Add Material Movement (IN)
    @endif
@endsection

@section('breadcrumb-button')
    <a href="{{ url('movement-ins') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid',null)

@section('content')

    @if(!empty($movementIn))
        {!! Form::open(array('url' => "movement-ins/$movementIn->id",'method' => 'PUT', 'class'=>'custom-form')) !!}
    @else
        {!! Form::open(array('url' => "movement-ins",'method' => 'POST', 'class'=>'custom-form')) !!}
    @endif
        <div class="row">
            <div class="col-md-4">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="project_id">MTO NO <span class="text-danger">*</span></label>
                    {{Form::text('mto_no', old('mto_no') ? old('mto_no') : (!empty($movementIn) ? $movementIn->materialMovement->mto_no : null),['class' => 'form-control','id' => 'mto_no', 'autocomplete'=>"off","required", 'placeholder' => ''])}}
                    {{Form::hidden('materialmovement_id', old('materialmovement_id') ? old('materialmovement_id') : (!empty($movementIn) ? $movementIn->materialMovement->id : null),['class' => 'form-control','id' => 'materialmovement_id', 'autocomplete'=>"off","required", 'placeholder' => ''])}}
                </div>
            </div>
            <div class="col-md-4">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="project_id">MTI NO <span class="text-danger">*</span></label>
                    {{Form::text('mti_no', old('mti_no') ? old('mti_no') : (!empty($movementIn) ? $movementIn->mti_no : null),['class' => 'form-control','id' => 'mti_no', 'autocomplete'=>"off","required", 'placeholder' => ''])}}
                </div>
            </div>
            <div class="col-4">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="date">Receive Date <span class="text-danger">*</span></label>
                    {{Form::text('receive_date', old('receive_date') ? old('receive_date') : (!empty($movementIn->receive_date) ? $movementIn->receive_date : null),['class' => 'form-control receive_date','id' => 'receive_date', 'autocomplete'=>"off", 'required', 'readonly'])}}
                </div>
            </div>

        </div><!-- end row -->

    <hr class="bg-success">

        <div class="table-responsive">
            <table id="purchaseTable" class="table table-striped table-bordered" >
                <thead>
                <tr>
                    <th>MTRF <span class="text-danger">*</span></th>
                    <th>Material Name <span class="text-danger">*</span></th>
                    <th>Unit</th>
                    <th>MTRF Quantity</th>
                    <th>MTO Quantity</th>
                    <th>MTI Quantity <span class="text-danger">*</span></th>
                    <th>Damage Qnt</th>
                    <th>Remarks</th>
                    <th><i class="btn btn-primary btn-sm fa fa-plus" id="addItem" onclick="addItemDtl()"> </i></th>
                </tr>
                </thead>
                <tbody>

                @php
                    $details = old('movement_requisition_id', !empty($materialmovement) ?  $materialmovement->movementDetails->pluck('movementRequisition.id') : []);
                    $gate_pass = old('gate_pass', !empty($materialmovement) ?  $materialmovement->movementDetails->pluck('gate_pass') : []);
                    $materials = old('material_id', !empty($materialmovement) ?  $materialmovement->movementDetails->pluck('nestedMaterial.name','nestedMaterial.id') : []);
                    $materialIds = old('material_id', !empty($materialmovement) ?  $materialmovement->movementDetails->pluck('material_id') : []);
                    $units = old('unit', !empty($materialmovement) ?  $materialmovement->movementDetails->pluck('nestedMaterial.unit.name') : []);
                    $mtrfQuantity = old('mtrf_quantity', !empty($materialmovement) ?  $materialmovement->movementDetails->pluck('movementRequisition.movementRequisitionDetails') : []);
                    $mtoQuantity = old('mto_quantity', !empty($materialmovement) ?  $materialmovement->movementDetails->pluck('quantity') : []);
                    $remarks = old('remarks', !empty($materialmovement) ?  $materialmovement->movementDetails->pluck('remarks') : []);

                @endphp

                @if(!empty($movementIn))
                    @foreach($movementIn->movementInDetails as  $movementdetail)
                        @php
                            $mtrfQuantity = $movementdetail->movementRequisition->movementRequisitionDetails()
                                            ->where('material_id',$movementdetail->nestedMaterial->id)->first();
                            $mtoQuantity = $movementdetail->movementIn->materialMovement->movementdetails()
                                            ->where('material_id',$movementdetail->nestedMaterial->id)->first();
                        @endphp
                    <tr>
                        <td>
                            {{Form::select('movement_requisition_id[]', $requisitions, $movementdetail->movement_requisition_id, ['class' => 'form-control mtrf_no', 'placeholder'=>" Select MTRF", 'autocomplete'=>"off"])}}
                        </td>
                        <td>
                            <input type="text" name="material_name[]" value="{{ old("material_name", $movementdetail->nestedMaterial->name ?? null) }}" class="form-control material_name" id="material_name" tabindex="-1">
                            <input type="hidden" name="material_id[]" value="{{ old("material_name", $movementdetail->nestedMaterial->id ?? null) }}" class="form-control material_id" id="material_id" tabindex="-1" autocomplete="off">
                        </td>
                        <td>
                            <input type="text" name="unit[]" value="{{ old("unit", $movementdetail->nestedMaterial->unit->name ?? null) }}" class="form-control form-control-sm text-center unit" id="unit_name" readonly tabindex="-1">
                        </td>
                        <td>
                            <input type="number" name="mtrf_quantity[]" value="{{ old("mtrf_quantity", $mtrfQuantity->quantity ?? null) }}" class="form-control mtrf_quantity text-center" min="0" step="0.01" placeholder="0.00">
                        </td>
                        <td>
                            <input type="number" name="mto_quantity[]" value="{{ old("mto_quantity", $mtoQuantity->quantity ?? null) }}" class="form-control mto_quantity text-center" min="0" step="0.01" placeholder="0.00">
                        </td>
                        <td>
                            <input type="number" name="mti_quantity[]" value="{{ old("mti_quantity", $movementdetail->mti_quantity ?? null) }}" class="form-control mti_quantity text-center" min="0" step="0.01" placeholder="0.00">
                        </td>
                        <td>
                            <input type="number" name="damage_quantity[]" value="{{ old("total_value", $movementdetail->damage_quantity ?? null) }}" class="form-control total_value text-center" tabindex="-1">
                        </td>
                        <td>
                            <textarea rows="1" name="remarks[]" value="{{ old("remarks", $movementdetail->remarks ?? null) }}" class="form-control remarks text-center" tabindex="-1">{{  $movementdetail->remarks  }}</textarea>
                        </td>
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

        $( "#mto_no").autocomplete({
            source: function( request, response ) {
                $.ajax({
                    url:"{{route('mtoAutoSuggust')}}",
                    type: 'post',
                    dataType: "json",
                    data: {
                        _token: CSRF_TOKEN,
                        search: request.term
                    },
                    success: function( data ) {
                        response( data );
                    }
                });
            },
            select: function (event, ui) {
                $('#materialmovement_id').val(ui.item.value);
                $('#mto_no').val(ui.item.label);
                $("#itemTable").find("tbody").children("tr").remove();
                loadMTRFmtoWise();
                return false;
            }
        });

        function loadMTRFmtoWise(){
                let mto_id = $("#materialmovement_id").val();
                let url ='{{url("loadMTRFmtoWise")}}/'+ mto_id ;
                fetch(url)
                .then((resp) => resp.json())
                .then(function(data) {
                    console.log(data)
                        $.each(data.movementdetails, function(materialItems, materialItem){
                            let option = `<option value="${materialItem.movement_requision_id}"> ${materialItem.movement_requisition.mtrf_no}</option>`;
                            $(".mtrf_no").append(option);
                        });
                    })
                .catch(function () {
                });
            }

        $(document).on('keyup change', ".mtrf_no", function(){
            let  mtrf_id = $(this).closest('tr').find('.mtrf_no').val();
            let url ='{{url("getMovementRequiestionInfo")}}/'+ mtrf_id;
            let  material_dropdown = $(this).closest('tr').find('.material_id');
            material_dropdown.empty();
            material_dropdown.append('<option selected="true" disabled>Select Material </option>')
            fetch(url)
            .then((resp) => resp.json())
            .then(function(data) {
                    console.log(data.movement_requisition_details.nested_material);
                    $.each(data.movement_requisition_details, function(materialItems, materialItem){
                        let option = `<option value="${materialItem.nested_material.id}"> ${materialItem.nested_material.name}</option>`;
                        material_dropdown.append(option);
                    });
                })
            .catch(function () {
            });
            changeMTRF();
        });

        function changeMTRF(){
            console.log(this.val());

        }

        $(document).on('change', ".material_id", function(){
            let  material_id = $(this).closest('tr').find('.material_id').val();
            let  mtrf_id = $(this).closest('tr').find('.mtrf_no').val();
            let  mto = $("#materialmovement_id").val();
            let url ='{{url("getMTOInfobyMaterial")}}/'+ mtrf_id + '/' + material_id + '/' + mto;
            let mtrf_quantity = $(this).closest('tr').find('.mtrf_quantity');
            let mto_quantity = $(this).closest('tr').find('.mto_quantity');
            let mti_quantity = $(this).closest('tr').find('.mti_quantity');
            let unit = $(this).closest('tr').find('.unit');

            fetch(url)
            .then((resp) => resp.json())
            .then(function(data) {
                console.log();
                    unit.val(data[0].nested_material.unit.name);
                    mtrf_quantity.val(data[0].quantity);
                    mti_quantity.attr({"max" : data[0].quantity});
                    mto_quantity.val(data[1].quantity);
                })
            .catch(function () {
            });
        });

        function addItemDtl(){
            var Row = `
            <tr>
                <td>
                    <select name="movement_requisition_id[]" class="form-control mtrf_no">
                        <option>Select MTRF</option> </select>
                </td>
                <td>
                  <select name="material_id[]" class="form-control material_id">
                    <option>Select Material</option>
                  </select>
                </td>
                <td>
                    <input type="text" name="unit[]"  class="form-control form-control-sm text-center unit" id="unit_name" autocomplete="off" readonly tabindex="-1">
                </td>
                <td>
                    <input type="number" name="mtrf_quantity[]"  class="form-control mtrf_quantity text-center"  tabindex="-1" min="0" step="0.01" placeholder="0.00" autocomplete="off" readonly>
                </td>
                <td> <input type="number" name="mto_quantity[]"  class="form-control mto_quantity text-center" min="0" step="0.01" placeholder="0.00" autocomplete="off">
                </td>
                <td> <input type="number" name="mti_quantity[]"  class="form-control mti_quantity text-center" min="0" step="0.01" placeholder="0.00" autocomplete="off">
                <td> <input type="number" name="damage_quantity[]"  class="form-control damage_quantity text-center" min="0" step="0.01" placeholder="0.00" autocomplete="off">
                </td>
                <td>
                    <textarea rows="1" name="remarks[]"  class="form-control remarks text-center" tabindex="-1" autocomplete="off"></textarea>
                </td>
                <td class="text-center"><button class="btn btn-danger btn-sm deleteItem" onclick="removQRow(this)" type="button"><i class="fa fa-minus"></i></button></td>
            </tr>
            `;

            var tableItem = $('#purchaseTable').append(Row);
            $(this).closest('tr').find('.mtrf_no').empty();
            $(this).closest('tr').find('.mtrf_no').append('<option selected="true" disabled>Select MTRF </option>')
            loadMTRFmtoWise()
        }
        function removQRow(qval){
            var rowIndex = qval.parentNode.parentNode.rowIndex;
            document.getElementById("purchaseTable").deleteRow(rowIndex);
        }


        var CSRF_TOKEN = "{{csrf_token()}}";
        $(function(){
            @if(empty($movementIn))
                addItemDtl();
            @endif

        });


        $(document).on('mouseenter', '.receive_date', function() {
                $(this).datepicker({
                    format: "dd-mm-yyyy",
                    autoclose: true,
                    todayHighlight: true,
                    showOtherMonths: true
                });
            });

    </script>
@endsection
