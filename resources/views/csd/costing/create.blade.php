@extends('layouts.backend-layout')
@section('title', 'Final Costing')

@section('breadcrumb-title')
    @if ($formType == 'edit')
        Edit Costing
    @else
        Make Costing
    @endif

@endsection

@section('breadcrumb-button')
    {{-- <a href="{{ url(route("construction/work_plan/show")) }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a> --}}
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', null)

@section('content')
    @if($formType == 'edit')
        {!! Form::open(array('url' => "csd/costing/$costing->id",'method' => 'PUT', 'class'=>'custom-form')) !!}
    @else
        {!! Form::open(array('url' => 'csd/costing','method' => 'POST', 'class'=>'custom-form')) !!}
    @endif

        <div class="row">
            <div class="col-xl-6 col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="project_name">Project Name<span class="text-danger">*</span></label>
                    {{Form::text('project_name', old('project_name') ? old('project_name') : (!empty($costing) ? $costing->sell->apartment->project->name : null),['class' => 'form-control','id' => 'project_name', 'autocomplete'=>"off",'required'])}}
                    {{Form::hidden('project_id', old('project_id') ? old('project_id') : (!empty($costing->id) ? $costing->sell->apartment->project_id : null),['class' => 'form-control','id' => 'project_id', 'autocomplete'=>"off",'required'])}}
                </div>
            </div>
            <div class="col-xl-6 col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    {{Form::hidden('apartment_id', old('apartment_id') ? old('apartment_id') : (!empty($costing->apartment_id) ? $costing->apartment_id : null),['class' => 'form-control apartment_id','id' => 'apartment_id', 'autocomplete'=>"off",'required'])}}

                    <label class="input-group-addon" for="sell_id">Client Name<span class="text-danger">*</span></label>
                    {{Form::select('sell_id', $clients, old('sell_id') ? old('sell_id') : (!empty($costing->sell_id) ? $costing->sell_id : null),['class' => 'form-control','id' => 'sell_id', 'autocomplete'=>"off"])}}
                </div>
            </div>
        </div>

        <hr class="bg-success">

        <div class="row">
            <div class="col-md-12">
                <div class="tableHeading">
                    <h5> <span>&#10070;</span> Additional/Demand Work <span>&#10070;</span> </h5>
                </div>
                <div class="table-responsive">
                    <table id="Table" class="table table-striped table-sm text-center table-bordered" >
                        <thead>
                            <tr>
                                <th>Search<br> Material Name<span class="text-danger">*</span></th>
                                <th>Unit</th>
                                <th>Demand Rate</th>
                                <th>Quantity<span class="text-danger">*</span></th>
                                <th>Amount</th>
                                <th><i class="btn btn-primary btn-sm fa fa-plus" id="addItem" onclick="addItemDtl()"> </i></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(old('material_id'))
                                @foreach(old('material_id') as $key=>$oldMaterialName)
                                    <tr>
                                        <td>
                                            <input type="text" name="material_name[]" value="{{old('material_name')[$key]}}" id="text-center material_name" class="form-control form-control-sm material_name" autocomplete="off" required>
                                            <input type="hidden" name="material_id[]" value="{{old('material_id')[$key]}}" class="material_id" id="material_id">
                                        </td>
                                        <td>
                                            <input type="text" name="unit_name[]" value="{{old('unit_name')[$key]}}" class="text-center form-control form-control-sm unit_name" tabindex="-1" autocomplete="off" id="unit_name" readonly>
                                            <input type="hidden" name="unit_id[]" value="{{old('unit_id')[$key]}}" class="text-center form-control form-control-sm unit_id" tabindex="-1" autocomplete="off" id="unit_id">
                                        </td>
                                        <td><input type="text" name="demand_rate[]" value="{{old('demand_rate')[$key]}}" class="text-center form-control form-control-sm demand_rate" tabindex="-1" autocomplete="off" id="demand_rate" readonly></td>
                                        <td><input type="text" name="quantity[]" value="{{old('quantity')[$key]}}" class="text-center form-control form-control-sm quantity" tabindex="-1" autocomplete="off" id="quantity"></td>
                                        <td><input type="text" name="amount[]" value="{{old('amount')[$key]}}" class="text-center form-control form-control-sm amount" tabindex="-1" autocomplete="off" id="amount" readonly></td>

                                        <td class="text-center">
                                            <button class="btn btn-danger btn-sm deleteItem" onclick="removQRow(this)" type="button">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                                @else
                                @if (!empty($costing))
                                    @foreach ($costing->csdFinalCostingDemand as $csdFinalCosting)
                                    <tr>
                                        <td>
                                            <input type="text" name="material_name[]" value="{{ $csdFinalCosting->csdMaterials->name }}" id="material_name" class="text-center form-control form-control-sm material_name" autocomplete="off" required>
                                            <input type="hidden" name="material_id[]" value="{{ $csdFinalCosting->csdMaterials->id }}" class="material_id" id="material_id">
                                        </td>
                                        <td>
                                            <input type="text" name="unit_name[]" value="{{ $csdFinalCosting->csdMaterials->unit->name }}" class="text-center form-control form-control-sm unit_name" tabindex="-1" autocomplete="off" id="unit_name" readonly>
                                            <input type="hidden" name="unit_id[]" value="{{ $csdFinalCosting->csdMaterials->unit->id }}" class="form-control form-control-sm unit_id" tabindex="-1" autocomplete="off" id="unit_id">
                                        </td>
                                        <td><input type="text" name="demand_rate[]" value="{{ $csdFinalCosting->demand_rate }}" class="text-center form-control form-control-sm demand_rate" tabindex="-1" autocomplete="off" id="demand_rate" readonly></td>
                                        <td><input type="text" name="quantity[]" value="{{ $csdFinalCosting->quantity }}" class="text-center form-control form-control-sm quantity" tabindex="-1" autocomplete="off" id="quantity"></td>
                                        <td><input type="text" name="amount[]" value="{{ $csdFinalCosting->amount }}" class="text-center form-control form-control-sm amount" tabindex="-1" autocomplete="off" id="amount" readonly></td>

                                        <td class="text-center">
                                            <button class="btn btn-danger btn-sm deleteItem" onclick="removQRow(this)" type="button">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                @endif
                            @endif
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" class="text-right"> Grand Total </td>
                                <td>{{ Form::number('grand_total', old('grand_total', $purchaseOrder->sub_total ?? null), ['class' => 'text-center form-control form-control-sm grand_total text-right', 'id' => 'grand_total', 'placeholder' => '0.00 ', 'readonly']) }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <br><br>

        <div class="row">
            <div class="col-md-12">
                <div class="tableHeading">
                    <h5> <span>&#10070;</span> Refund Work <span>&#10070;</span> </h5>
                </div>
                <div class="table-responsive">
                    <table id="TableRefund" class="table table-striped table-sm text-center table-bordered" >
                        <thead>
                            <tr>
                                <th>Search<br> Material Name<span class="text-danger">*</span></th>
                                <th>Unit</th>
                                <th>Refund Rate</th>
                                <th>Quantity<span class="text-danger">*</span></th>
                                <th>Amount</th>
                                <th><i class="btn btn-primary btn-sm fa fa-plus" id="addItemRefund" onclick="addItemDtlRefund()"> </i></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(old('material_id_refund'))
                                @foreach(old('material_id_refund') as $key=>$oldMaterialName)
                                    <tr>
                                        <td>
                                            <input type="text" name="material_name_refund[]" value="{{old('material_name_refund')[$key]}}" id="material_name_refund" class="text-center form-control form-control-sm material_name_refund" autocomplete="off" required>
                                            <input type="hidden" name="material_id_refund[]" value="{{old('material_id_refund')[$key]}}" class="material_id_refund" id="material_id_refund">
                                        </td>
                                        <td>
                                            <input type="text" name="unit_name_refund[]" value="{{old('unit_name_refund')[$key]}}" class="text-center form-control form-control-sm unit_name_refund" tabindex="-1" autocomplete="off" id="unit_name_refund" readonly>
                                            <input type="hidden" name="unit_id_refund[]" value="{{old('unit_id_refund')[$key]}}" class="text-center form-control form-control-sm unit_id_refund" tabindex="-1" autocomplete="off" id="unit_id_refund">
                                        </td>
                                        <td><input type="text" name="refund_rate[]" value="{{old('refund_rate')[$key]}}" class="text-center form-control form-control-sm refund_rate" tabindex="-1" autocomplete="off" id="refund_rate" readonly></td>

                                        <td><input type="text" name="quantity_refund[]" value="{{old('quantity_refund')[$key]}}" class="text-center form-control form-control-sm quantity_refund" tabindex="-1" autocomplete="off" id="quantity_refund"></td>

                                        <td><input type="text" name="amount_refund[]" value="{{old('amount_refund')[$key]}}" class="text-center form-control form-control-sm amount_refund " tabindex="-1" autocomplete="off" id="amount_refund" readonly></td>

                                        <td class="text-center">
                                            <button class="btn btn-danger btn-sm deleteItemRefund" onclick="removQRowRefund(this)" type="button">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                                @else
                                @if (!empty($costing))
                                    @foreach ($costing->csdFinalCostingRefund as $csdFinalCosting)
                                    <tr>
                                        <td>
                                            <input type="text" name="material_name_refund[]" value="{{ $csdFinalCosting->csdMaterials->name }}" id="material_name_refund" class="text-center form-control form-control-sm material_name_refund" autocomplete="off" required>
                                            <input type="hidden" name="material_id_refund[]" value="{{ $csdFinalCosting->csdMaterials->id }}" class="material_id_refund" id="material_id_refund">
                                        </td>
                                        <td>
                                            <input type="text" name="unit_name_refund[]" value="{{ $csdFinalCosting->csdMaterials->unit->name }}" class="text-center form-control form-control-sm unit_name_refund" tabindex="-1" autocomplete="off" id="unit_name_refund" readonly>
                                            <input type="hidden" name="unit_id_refund[]" value="{{ $csdFinalCosting->csdMaterials->unit->id }}" class="text-center form-control form-control-sm unit_id_refund" tabindex="-1" autocomplete="off" id="unit_id_refund">
                                        </td>
                                        <td><input type="text" name="refund_rate[]" value="{{ $csdFinalCosting->refund_rate }}" class="text-center form-control form-control-sm refund_rate" tabindex="-1" autocomplete="off" id="refund_rate" readonly></td>
                                        <td><input type="text" name="quantity_refund[]" value="{{ $csdFinalCosting->quantity_refund }}" class="text-center form-control form-control-sm quantity_refund" tabindex="-1" autocomplete="off" id="quantity_refund"></td>
                                        <td><input type="text" name="amount_refund[]" value="{{ $csdFinalCosting->amount_refund }}" class="text-center form-control form-control-sm amount_refund " tabindex="-1" autocomplete="off" id="amount_refund" readonly></td>

                                        <td class="text-center">
                                            <button class="btn btn-danger btn-sm deleteItemRefund" onclick="removQRowRefund(this)" type="button">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                @endif
                            @endif
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" class="text-right"> Grand Total </td>
                                <td>{{ Form::number('grand_total_refund', old('grand_total_refund', $purchaseOrder->sub_total ?? null), ['class' => 'text-center form-control form-control-sm grand_total_refund text-right', 'id' => 'grand_total_refund', 'placeholder' => '0.00 ', 'readonly']) }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
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

        function addItemDtl() {
            var Row = `
            <tr>
                <td>
                    <input type="text" name="material_name[]" id="material_name" class="text-center form-control form-control-sm material_name" autocomplete="off" required>
                    <input type="hidden" name="material_id[]" class="material_id" id="material_id">
                </td>
                <td>
                    <input type="text" name="unit_name[]" class="text-center form-control form-control-sm unit_name" tabindex="-1" autocomplete="off" id="unit_name" readonly>
                    <input type="hidden" name="unit_id[]" class="text-center form-control form-control-sm unit_id" tabindex="-1" autocomplete="off" id="unit_id">
                </td>
                <td><input type="text" name="demand_rate[]" class="text-center form-control form-control-sm demand_rate" tabindex="-1" autocomplete="off" id="demand_rate" readonly></td>
                <td><input type="text" name="quantity[]" class="text-center form-control form-control-sm quantity" tabindex="-1" autocomplete="off" id="quantity"></td>
                <td><input type="text" name="amount[]" class="text-center form-control form-control-sm amount " tabindex="-1" autocomplete="off" id="amount" readonly></td>

                <td class="text-center">
                    <button class="btn btn-danger btn-sm deleteItem" onclick="removQRow(this)" type="button">
                        <i class="fa fa-minus"></i>
                    </button>
                </td>
            </tr>
            `;
            var tableItem = $('#Table').append(Row);
            calculateTotalPrice(this);
            totalOperation();
        }

        function addItemDtlRefund() {
            var Row = `
            <tr>
                <td>
                    <input type="text" name="material_name_refund[]" id="material_name_refund" class="text-center form-control form-control-sm material_name_refund" autocomplete="off" required>
                    <input type="hidden" name="material_id_refund[]" class="material_id_refund" id="material_id_refund">
                </td>
                <td>
                    <input type="text" name="unit_name_refund[]" class="text-center form-control form-control-sm unit_name_refund" tabindex="-1" autocomplete="off" id="unit_name_refund" readonly>
                    <input type="hidden" name="unit_id_refund[]" class="text-center form-control form-control-sm unit_id_refund" tabindex="-1" autocomplete="off" id="unit_id_refund">
                </td>
                <td><input type="text" name="refund_rate[]" class="text-center form-control form-control-sm refund_rate" tabindex="-1" autocomplete="off" id="refund_rate" readonly></td>
                <td><input type="text" name="quantity_refund[]" class="text-center form-control form-control-sm quantity_refund" tabindex="-1" autocomplete="off" id="quantity_refund"></td>
                <td><input type="text" name="amount_refund[]" class="text-center form-control form-control-sm amount_refund " tabindex="-1" autocomplete="off" id="amount_refund" readonly></td>

                <td class="text-center">
                    <button class="btn btn-danger btn-sm deleteItemRefund" onclick="removQRowRefund(this)" type="button">
                        <i class="fa fa-minus"></i>
                    </button>
                </td>
            </tr>
            `;
            var tableItemRefund = $('#TableRefund').append(Row);
            calculateTotalPriceRefund(this);
            totalOperationRefund();
        }

        // Function for calculating total price
        function calculateTotalPrice(thisVal) {
            let quantity = $(thisVal).closest('tr').find('.quantity').val() > 0 ? parseFloat($(thisVal).closest('tr').find(
                '.quantity').val()) : 0;
            let demand_rate = $(thisVal).closest('tr').find('.demand_rate').val() > 0 ? parseFloat($(thisVal).closest('tr')
                .find('.demand_rate').val()) : 0;
            let total = (quantity * demand_rate).toFixed(2);
            $(thisVal).closest('tr').find('.amount').val(total);
            totalOperation();
        }

        // Function for calculating total price
            function totalOperation() {
                var total = 0;
                if ($(".amount").length > 0) {
                    $(".amount").each(function(i, row) {
                        var amount = Number($(row).val());
                        total += parseFloat(amount);
                    })
                }
                $("#grand_total").val(total.toFixed(2));
            };

            // Function for calculating total price Refund
                function calculateTotalPriceRefund(thisVal) {
                    let quantity_refund = $(thisVal).closest('tr').find('.quantity_refund').val() > 0 ? parseFloat($(thisVal).closest('tr').find(
                        '.quantity_refund').val()) : 0;
                    let refund_rate = $(thisVal).closest('tr').find('.refund_rate').val() > 0 ? parseFloat($(thisVal).closest('tr')
                        .find('.refund_rate').val()) : 0;
                    let total = (quantity_refund * refund_rate).toFixed(2);
                    $(thisVal).closest('tr').find('.amount_refund').val(total);
                    totalOperationRefund();
                }

            // Function for calculating total price Refund
                function totalOperationRefund() {
                    var total = 0;
                    if ($(".amount_refund").length > 0) {
                        $(".amount_refund").each(function(i, row) {
                            var amount_refund = Number($(row).val());
                            total += parseFloat(amount_refund);
                        })
                    }
                    $("#grand_total_refund").val(total.toFixed(2));
                };

        var loadedClientsWithApartment = [];
        // Function for getting CS supplier repair
        function loadSoldClientsWithApartment() {
                const project_id = $("#project_id").val();
                let sell_id = @json(old('sell_id', $costing->sell_id ?? ''));

                if (project_id != '') {
                    let dropdown = $('#sell_id');
                    dropdown.empty();
                    dropdown.append('<option selected="true" disabled>Select Client </option>');
                    dropdown.prop('selectedIndex', 0);

                    const url = '{{ url("loadSoldClientsWithApartment") }}/' + project_id;
                    $.getJSON(url, function(items) {

                        $.each(items, function(key, sellDetails) {
                            loadedClientsWithApartment[sellDetails.sell_client.client.name + " [Apartment : " + sellDetails.apartment.name + "]"] = sellDetails.apartment.id
                            let select = (sell_id === sellDetails.id) ? "selected" : '';
                            let options =
                                `<option value="${sellDetails.id}" ${select}>
                                    ${sellDetails.sell_client.client.name} [Apartment : ${sellDetails.apartment.name}]
                                </option>`;
                            dropdown.append(options);
                        })
                    });
                }
            }


            $(document).on('change', "#sell_id", function(){
                const selected_val = $('#sell_id :selected').text().trim();

               for (var key in loadedClientsWithApartment) {
                if(key == selected_val){
                    $('.apartment_id').val(loadedClientsWithApartment[key]);
                }
            }

            });
        // Function for deleting a row
        function removQRow(qval) {
            var rowIndex = qval.parentNode.parentNode.rowIndex;
            document.getElementById("Table").deleteRow(rowIndex);
        }

        // Function for deleting a row
        function removQRowRefund(qval) {
            var rowIndex = qval.parentNode.parentNode.rowIndex;
            document.getElementById("TableRefund").deleteRow(rowIndex);
        }


        var CSRF_TOKEN = "{{csrf_token()}}";
        $(function() {

            @if ($formType == 'create' && !old('material_id'))

            addItemDtl();
            addItemDtlRefund();
            @endif

            $( "#project_name").autocomplete({
                source: function( request, response ) {
                    $.ajax({
                        url:"{{route('projectAutoSuggest')}}",
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
                    $('#project_name').val(ui.item.label);
                    $('#project_id').val(ui.item.value);
                    return false;
                }
            }).on('change', function(){
                loadSoldClientsWithApartment();
            });







            $(document).on('keyup', ".material_name", function(){
                $(this).autocomplete({
                source: function( request, response ) {
                    $.ajax({
                        url:"{{route('csd.csdMaterialAutoSuggestWithRate')}}",
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

                    $(this).closest('#material_name').val(ui.item.label);
                    $(this).closest('tr').find("#material_id").val(ui.item.material_id);
                    $(this).closest('tr').find("#unit_name").val(ui.item.unit_name);
                    $(this).closest('tr').find("#unit_id").val(ui.item.unit_id);
                    $(this).closest('tr').find("#demand_rate").val(ui.item.demand_rate);

                    return false;
                    }
                })
            });


            $(document).on('keyup', ".material_name_refund", function(){
                $(this).autocomplete({
                source: function( request, response ) {
                    $.ajax({
                        url:"{{route('csd.csdMaterialAutoSuggestWithRate')}}",
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

                    $(this).closest('#material_name_refund').val(ui.item.label);
                    $(this).closest('tr').find("#material_id_refund").val(ui.item.material_id);
                    $(this).closest('tr').find("#unit_name_refund").val(ui.item.unit_name);
                    $(this).closest('tr').find("#unit_id_refund").val(ui.item.unit_id);
                    $(this).closest('tr').find("#refund_rate").val(ui.item.refund_rate);

                    return false;
                    }
                })
            });

            $(document).on('mouseenter', '.start_date, .finish_date', function() {
                $(this).datepicker({
                    format: "yyyy-mm-dd",
                    autoclose: true,
                    todayHighlight: true,
                    showOtherMonths: true
                });
            });
        });



        $(function() {

            // Function for getting CS supplier repair for edit
            // function loadSoldClientsWithApartment() {
            //     const project_id = $("#project_id").val();
            //     let sell_id = @json(old('sell_id', $costing->sell_id ?? ''));

            //     if (project_id != '') {
            //         let dropdown = $('#sell_id');
            //         dropdown.empty();
            //         dropdown.append('<option selected="true" disabled>Select Client </option>');
            //         dropdown.prop('selectedIndex', 0);

            //         const url = '{{ url("loadSoldClientsWithApartment") }}/' + project_id;
            //         $.getJSON(url, function(items) {
            //             $.each(items, function(key, sellDetails) {
            //                 console.log(sellDetails);
            //                 let select = (sell_id === sellDetails.id) ? "selected" : '';
            //                     $('.apartment_id').val(sell_id);
            //                 let options =
            //                     `<option value="${sellDetails.sell_client.client.id}" ${select}>
            //                         ${sellDetails.sell_client.client.name} [Apartment : ${sellDetails.apartment.name}]
            //                     </option>`;
            //                 dropdown.append(options);
            //             })
            //         });
            //     }
            // }

            $(document).on('click', '.deleteItem', function(){
                $(this).closest('tr').remove();
                $('.deleteItem').each(function(i){
                    $(this).val(i+1);
                });
                calculateTotalPrice();
            });

            $(document).on('click', '.deleteItemRefund', function(){
                $(this).closest('tr').remove();
                $('.deleteItemRefund').each(function(i){
                    $(this).val(i+1);
                });
                calculateTotalPriceRefund();
            });

            $(document).on('keyup change', '.quantity', function() {
                calculateTotalPrice(this);
            });

            $(document).on('keyup change', '.quantity_refund', function() {
                calculateTotalPriceRefund(this);
            });

            @if ($formType == "edit")
                $(document).load('keyup change', '.quantity', function() {
                    calculateTotalPrice(this);
                });

                $(document).load('keyup change', '.quantity_refund', function() {
                    calculateTotalPriceRefund(this);
                });

                loadSoldClientsWithApartment();
            @endif

        });


    </script>
@endsection
