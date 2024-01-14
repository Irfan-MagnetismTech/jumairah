@csrf

<style>
    /*.select2-selection{*/
    /*    height: 35px !important;*/
    /*}*/

    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #116A7B;
        border: 1px solid #116A7B;
        color: #fff;
    }
</style>

<div class="tableHeading">
    <h5> <span>&#10070;</span>Material Revised Sheet<span>&#10070;</span><span class="work_unit"></span> </h5>
</div>
<div class="mt-2">
    <div class="input-group input-group-sm input-group-primary mt-4 mb-2">
        <label class="input-group-addon" for="escalation_no">Price Escalation No. <span class="text-danger">*</span></label>
        <select name="escalation_no" id="escalation_no" class="form-control mr-2" required>
            <option value="" selected disabled>Select Option</option>
            <option value="1" {{ isset($revised_data) && $revised_data->escalation_no === 1 ? 'selected' : '' }}>1
            </option>
            <option value="2" {{ isset($revised_data) && $revised_data->escalation_no === 2 ? 'selected' : '' }}>2
            </option>
            <option value="3" {{ isset($revised_data) && $revised_data->escalation_no === 3 ? 'selected' : '' }}>3
            </option>
            <option value="4" {{ isset($revised_data) && $revised_data->escalation_no === 4 ? 'selected' : '' }}>4
            </option>
            <option value="5" {{ isset($revised_data) && $revised_data->escalation_no === 5 ? 'selected' : '' }}>5
            </option>
            <option value="6" {{ isset($revised_data) && $revised_data->escalation_no === 6 ? 'selected' : '' }}>6
            </option>
            <option value="7" {{ isset($revised_data) && $revised_data->escalation_no === 7 ? 'selected' : '' }}>7
            </option>
            <option value="8" {{ isset($revised_data) && $revised_data->escalation_no === 8 ? 'selected' : '' }}>8
            </option>
            <option value="9" {{ isset($revised_data) && $revised_data->escalation_no === 9 ? 'selected' : '' }}>9
            </option>
            <option value="10" {{ isset($revised_data) && $revised_data->escalation_no === 10 ? 'selected' : '' }}>
                10</option>
        </select>
        <label class="input-group-addon" for="escalation_date">Revision Date</label>
        <input type="date"
            value="{{ old('escalation_date', isset($revised_data) ? $revised_data?->escalation_date : '') }}"
            name="escalation_date" id="escalation_date" class="form-control mr-2">
        <label class="input-group-addon" for="escalation_date">Escalation For<span class="text-danger"> *</span></label>
        <select name="budget_type" id="budget_type" class="form-control mr-2" required>
            <option value="" selected disabled>Select Option</option>
            <option value="material"
                {{ isset($revised_data) && $revised_data?->budget_type === 'material' ? 'selected' : '' }}>Material
            </option>
            <option value="labour"
                {{ isset($revised_data) && $revised_data?->budget_type === 'labour' ? 'selected' : '' }}>Labour
            </option>
            <option value="material-labour"
                {{ isset($revised_data) && $revised_data?->budget_type === 'material-labour' ? 'selected' : '' }}>
                Material-Labour</option>
            <option value="other"
                {{ isset($revised_data) && $revised_data?->budget_type === 'other' ? 'selected' : '' }}>Other</option>
        </select>
    </div>
    <div class="input-group input-group-sm input-group-primary mb-2">
        <div class="col-md-6 input-group input-group-sm input-group-primary"
            style="padding-left: 0; padding-right: 4px;">
            <label class="input-group-addon" for="effective_date">Select Material <span class="text-danger"> *</span></label>
            <select class="form-control nested_material_id select2" id="nested_material_id" name="nested_material_id"
                required>
                <option value="" disabled selected>Select Option</option>
                @foreach ($materials as $material)
                    <option value="{{ $material?->id }}"
                        {{ isset($revised_data) && $material?->id === $revised_data?->nested_material_id ? 'selected' : '' }}>
                        {{ $material?->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-6 input-group input-group-sm input-group-primary"
            style="padding-left: 4px; padding-right: 0">
            <label class="input-group-addon" for="unit">Unit</label>
            <input type="text" name="unit"
                value="{{ old('unit', isset($revised_data) ? $revised_data?->material?->unit?->name : '') }}"
                id="unit" class="form-control" readonly>
        </div>
    </div>

</div>
<div class="row">
    <div class="col-md-12">
        <table class="table table-bordered" id="material_specification_table">
            <thead>
                <tr>
                    {{--                    <th width="10%"> Floor <span class="text-danger">*</span></th> --}}
                    <th width="20%"> Floor <span class="text-danger">*</span></th>
                    {{--                    <th width="5%"> Unit <span class="text-danger">*</span></th> --}}
                    <th width="10%"> Curr. Price <span class="text-danger">*</span></th>
                    <th width="10%"> Date <span class="text-danger">*</span></th>
                    <th width="10%"> Balance Qty <span class="text-danger">*</span></th>
{{--                    <th width="10%"> Qty(+/-) <span class="text-danger">*</span></th>--}}
                    <th width="10%"> New Price <span class="text-danger">*</span></th>
                    <th width="20%"> Amount <span class="text-danger">*</span></th>
                    <th width="20%"> Remarks</th>
                    <th><i class="btn btn-primary btn-sm fa fa-plus add-specification-row"></i></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <select class="form-control boq_floor_id" name="boq_floor_id[]" required>
                            <option value="" selected disabled>Select Option</option>
                            @foreach ($floor_list as $floor)
                                <option value="{{ $floor->boq_floor_id }}"
                                    {{ isset($revised_data) && $floor->boq_floor_id === $revised_data?->boq_floor_id ? 'selected' : '' }}>
                                    {{ $floor?->boqCivilCalcProjectFloor?->boqCommonFloor?->name }}</option>
                            @endforeach
                            <option {{ isset($revised_data) && $revised_data->boq_floor_id == 'Construction equipment (Re-useable)' ? 'selected' : '' }} value="Construction equipment (Re-useable)">Construction equipment (Re-useable)</option>
                            <option {{ isset($revised_data) && $revised_data->boq_floor_id == 'Consumable materials' ? 'selected' : '' }} value="Consumable materials">Consumable materials</option>
                            <option {{ isset($revised_data) && $revised_data->boq_floor_id == 'Other Related Work' ? 'selected' : '' }} value="Other Related Work">Other Related Work</option>
                            <option {{ isset($revised_data) && $revised_data->boq_floor_id == 'Safety staging & Canopy materials' ? 'selected' : '' }} value="Safety staging & Canopy materials">Safety staging & Canopy materials</option>
                            <option {{ isset($revised_data) && $revised_data->boq_floor_id == 'Steel shuttering materials (Re-useable)' ? 'selected' : '' }} value="Steel shuttering materials (Re-useable)">Steel shuttering materials (Re-useable)</option>
                        </select>
                    </td>
                    <td width="10%"> <input type="number" readonly
                            value="{{ old('primary_price', isset($revised_data) ? $revised_data?->primary_price : '') }}"
                            step=".01" name="primary_price[]" class="form-control primary_price" autocomplete="off">
                    </td>
                    <td width="10%"> <input type="date"
                            value="{{ old('till_date', isset($revised_data) ? $revised_data?->till_date : '') }}"
                            name="till_date[]" class="form-control till_date" autocomplete="off"> </td>
                    <td width="10%"> <input type="number"
                            value="{{ old('primary_qty', isset($revised_data) ? $revised_data?->primary_qty : '') }}"
                            step=".01" readonly name="primary_qty[]" class="form-control primary_qty"
                            autocomplete="off"> </td>
{{--                    <td width="10%"> <input type="number"--}}
{{--                            value="{{ old('revised_qty', isset($revised_data) ? $revised_data?->revised_qty : 0) }}"--}}
{{--                            name="revised_qty[]" class="form-control revised_qty" autocomplete="off"> </td>--}}
                    <td width="10%"> <input type="number" name="revised_price[]"
                            value="{{ old('revised_price', isset($revised_data) ? $revised_data?->revised_price : 0) }}"
                            class="form-control revised_price" autocomplete="off"> </td>
                    {{--                <td width="10%"> <input type="hidden" name="amount_after_revised[]" class="form-control amount_after_revised" readonly> </td> --}}
                    <td width="10%"> <input type="number" step=".01" name="increased_or_decreased_amount[]"
                            value="{{ old('increased_or_decreased_amount', isset($revised_data) ? $revised_data?->increased_or_decreased_amount : 0) }}"
                            class="form-control increased_or_decreased_amount" readonly> </td>
                    <td width="10%"> <input type="text" name="remarks[]"
                            value="{{ old('remarks', isset($revised_data) ? $revised_data?->remarks : '') }}"
                            class="form-control remarks"> </td>
                    <td> <i class="btn btn-danger btn-sm fa fa-minus remove-calculation-row"></i> </td>
                </tr>
            </tbody>
            <tfoot>
                <input type="hidden" name="project_id" value="{{ $project?->id }}">
                <input type="hidden" name="revised_sheet_id"
                    value="{{ isset($revised_data) ? $revised_data?->id : '' }}">
            </tfoot>
        </table>
    </div>
</div>

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
        const BOQ_MATERIAL_REVISED_BUDGET_DATA_URL =
            "{{ route('boq.project.departments.civil.get-material-revised-budget-by-id', $project) }}";
        const BOQ_MATERIAL_LEFT_BALANCE_DATA_URL =
            "{{ route('boq.project.departments.civil.get-material-left-balance-quantity-by-date', $project) }}";
        const BOQ_MATERIAL_CURRENT_PRICE_DATA_URL =
            "{{ route('boq.project.departments.civil.get-material-current-price', $project) }}";
        let globalMaterialData = null;

        // <td>
        //     <input type="text" placeholder="${selectedOption.text}" id="${selectedOption.id}" class="form-control revised_material_floor" autocomplete="off" readonly>
        //         <input type="hidden" name="revised_material_floor[]" value="${selectedOption.id}" class="form-control" autocomplete="off">
        // </td>

        /* Appends specification row */

        // <td width="10%"> <input type="number" name="revised_qty[]" value="0" class="form-control revised_qty" autocomplete="off"> </td>
        function appendCalculationRow(selectedOption = null) {
            let row = `
                    <tr>
                        <td>
                            <select class="form-control boq_floor_id" name="boq_floor_id[]" required>
                                <option value="" selected disabled>Select Option</option>
                                @foreach ($floor_list as $floor)
            <option value="{{ $floor->boq_floor_id }}">{{ $floor?->boqCivilCalcProjectFloor?->boqCommonFloor?->name }}</option>
                                @endforeach
            </select>
       </td>
       <td width="10%"> <input type="number" step=".01" name="primary_price[]" class="form-control primary_price" autocomplete="off"> </td>
       <td width="10%"> <input type="date" name="till_date[]" class="form-control till_date" autocomplete="off"> </td>
       <td width="10%"> <input type="number" step=".01" readonly name="primary_qty[]" class="form-control primary_qty" autocomplete="off"> </td>
       <td width="10%"> <input type="number" name="revised_price[]" value="0" class="form-control revised_price" autocomplete="off"> </td>
       <td width="10%"> <input type="number" step=".01" readonly name="increased_or_decreased_amount[]" class="form-control increased_or_decreased_amount" autocomplete="off"> </td>
       <td width="10%"> <input type="text" name="remarks[]" class="form-control remarks" autocomplete="off"> </td>
       <td> <i class="btn btn-danger btn-sm fa fa-minus remove-calculation-row"></i> </td>
   </tr>
`;


            $('#material_specification_table tbody').append(row);
            $('.select2').select2();
        }

        /* Adds and removes specification row on click */
        $("#material_specification_table")
            .on('click', '.add-specification-row', () => {
                appendCalculationRow();
            })
            .on('click', '.remove-calculation-row', function() {
                $(this).closest('tr').remove();
            });

        function updateMaterialData(materialData, element) {
            $('#unit').val(materialData?.material?.unit?.name);
        }

        function updateBalanceQuantityData(responseData, element) {
            $(element).closest('tr').find('.primary_qty').val(responseData.toFixed(2) ?? 0);
        }

        function updateCurrentPriceData(responseData, element) {
            $(element).closest('tr').find('.primary_price').val(globalMaterialData?.price_after_revised ?? 0);
        }

        async function getConsumableMaterialDataById(materialId, element) {
            let escalation_no = $('#escalation_no').val();
            if(escalation_no === null){
                alert("Please select escalation no first");
                return;
            }
            let response = await axios.post(BOQ_MATERIAL_REVISED_BUDGET_DATA_URL, {
                _token: "{{ csrf_token() }}",
                nested_material_id: materialId,
                escalation_no: escalation_no,
            });
            materialData = await response.data;
            globalMaterialData = response.data;
            updateMaterialData(materialData, element);
        }

        async function getLeftBalanceQtyByDate(date, element) {
            let material_id = $('.nested_material_id').val();
            let floor_id = $(element).closest('tr').find('.boq_floor_id').val();
            let response = await axios.post(BOQ_MATERIAL_LEFT_BALANCE_DATA_URL, {
                _token: "{{ csrf_token() }}",
                till_date: date,
                material_id: material_id,
                floor_id: floor_id,
            });
            //materialData = await response.data;
            updateBalanceQuantityData(response.data, element);
        }

        async function getMaterialCurrentPrice(floorId, element) {
            let material_id = $('.nested_material_id').val();
            let escalation_no = $('#escalation_no').val();
            if(escalation_no === null){
                alert("Please select escalation no first");
                return;
            }
            let response = await axios.post(BOQ_MATERIAL_CURRENT_PRICE_DATA_URL, {
                _token: "{{ csrf_token() }}",
                material_id: material_id,
                floor_id: floorId,
                escalation_no: escalation_no,
            });
            updateCurrentPriceData(response.data, element);
        }

        function removeCalculationRow(option) {
            $(`#material_specification_table tbody tr`).each(function() {
                if ($(this).find('.revised_material_floor').attr('id') == option.id) {
                    $(this).remove();
                }
            });
        }

        $(document).ready(function() {
            $('.select2').select2();

            $(document).on("change", '.nested_material_id', function() {
                getConsumableMaterialDataById($(this).val(), this);
            });

            $(document).on("change", '.till_date', function() {
                getLeftBalanceQtyByDate($(this).val(), this);
            });

            $(document).on("change", '.boq_floor_id', function() {
                getMaterialCurrentPrice($(this).val(), this);
            });

            //onchange boq_floor_id,primary_price,till_date,primary_qty,revised_qty,revised_price,amount_after_revised
// <<<<<<< HEAD
//             $(document).on("change", '.primary_price,.till_date,.primary_qty,.revised_qty,.revised_price',
//                 function() {
//                     let primary_price = $(this).closest('tr').find('.primary_price').val();
//                     let primary_qty = $(this).closest('tr').find('.primary_qty').val();
//                     let revised_qty = $(this).closest('tr').find('.revised_qty').val();
//                     let revised_price = $(this).closest('tr').find('.revised_price').val();
//                     // let amount_after_revised = $(this).closest('tr').find('.amount_after_revised').val();
//                     let increased_or_decreased_amount = $(this).closest('tr').find(
//                         '.increased_or_decreased_amount').val();
//                     let total = 0;
//
//                     let total_qty = parseFloat(primary_qty) + parseFloat(revised_qty);
//                     let total_price = parseFloat(primary_price) + parseFloat(revised_price);
//                     let total_amount = total_qty * total_price;
// =======
            $(document).on("change", '.primary_price,.till_date,.revised_price',
            function() {
                let primary_price = $(this).closest('tr').find('.primary_price').val();
                let primary_qty = $(this).closest('tr').find('.primary_qty').val();
                // let revised_qty = $(this).closest('tr').find('.revised_qty').val();
                let revised_price = $(this).closest('tr').find('.revised_price').val();
                // let amount_after_revised = $(this).closest('tr').find('.amount_after_revised').val();
                let increased_or_decreased_amount = $(this).closest('tr').find(
                    '.increased_or_decreased_amount').val();
                let total = 0;

                let total_qty = parseFloat(primary_qty);
                //let total_price = parseFloat(revised_price);
                //let total_price = parseFloat(primary_price) + parseFloat(revised_price);
                //let total_amount = total_qty * total_price;

                    let changedAmount = total_qty * parseFloat(revised_price);
                    // let changedAmount = total_qty *  parseFloat(revised_price !== '0' ? revised_price : primary_price);
                    // $(this).closest('tr').find('.amount_after_revised').val(total_amount.toFixed(2));
                    $(this).closest('tr').find('.increased_or_decreased_amount').val(changedAmount.toFixed(2));

                    // if(primary_price && primary_qty && revised_qty && revised_price){
                    //     total = (parseFloat(primary_price) * parseFloat(primary_qty)) + (parseFloat(revised_qty) * parseFloat(revised_price));
                    // }
                    // $(this).closest('tr').find('.amount_after_revised').val(total.toFixed(2));
                });

        });
    </script>
@endsection



{{-- @csrf --}}

{{-- <style> --}}
{{--    /*.select2-selection{*/ --}}
{{--    /*    height: 35px !important;*/ --}}
{{--    /*}*/ --}}

{{--    .select2-container--default .select2-selection--multiple .select2-selection__choice { --}}
{{--        background-color: #116A7B; --}}
{{--        border: 1px solid #227447; --}}
{{--        color: #fff; --}}
{{--    } --}}

{{--    .nested_material_id > .select2-selection { --}}
{{--        height: 33px !important; --}}
{{--    } --}}


{{-- </style> --}}

{{-- <div class="tableHeading"> --}}
{{--    <h5> <span>&#10070;</span>Material Revised Sheet<span>&#10070;</span><span class="work_unit"></span> </h5> --}}
{{-- </div> --}}
{{-- <div class="mt-2"> --}}
{{--    <div class="input-group input-group-sm input-group-primary mt-4 mb-2"> --}}
{{--        <label class="input-group-addon" for="effective_date">Price Escalation SL.</label> --}}
{{--        <input type="text" name="item_head" id="item_head" @if (!empty($boqCivilMaterialSpecifications)) value="{{ $boqCivilMaterialSpecifications[0]->item_head }}" @endif class="form-control"> --}}
{{--        <select name="escalation_no" id="serial_of_revision" class="form-control mr-2" required> --}}
{{--            <option value="" selected disabled>Select Option</option> --}}
{{--            <option value="1">1</option> --}}
{{--            <option value="2">2</option> --}}
{{--            <option value="3">3</option> --}}
{{--            <option value="4">4</option> --}}
{{--            <option value="5">5</option> --}}
{{--            <option value="6">6</option> --}}
{{--            <option value="7">7</option> --}}
{{--            <option value="8">8</option> --}}
{{--            <option value="9">9</option> --}}
{{--            <option value="10">10</option> --}}
{{--        </select> --}}
{{--        <label class="input-group-addon" for="effective_date">Revision Date</label> --}}
{{--        <input type="date" name="escalation_date" id="revision_date" class="form-control"> --}}
{{--    </div> --}}
{{--    <div class="input-group input-group-sm input-group-primary mb-2"> --}}
{{--        <label class="input-group-addon" for="effective_date">Select Floor</label> --}}
{{--        <select class="form-control boq_floor_id select2" name="boq_floor_id[]" multiple required> --}}
{{--            @foreach ($floor_list as $floor) --}}
{{--                <option value="{{ $floor->boq_floor_id }}">{{ $floor?->boqCivilCalcProjectFloor?->boqCommonFloor?->name }}</option> --}}
{{--            @endforeach --}}
{{--        </select> --}}
{{--    </div> --}}

{{-- </div> --}}
{{-- <div class="row"> --}}
{{--    <div class="col-md-12"> --}}
{{--        <table class="table table-bordered" id="material_specification_table"> --}}
{{--            <thead> --}}
{{--                <tr> --}}
{{--                    <th width="10%"> Floor <span class="text-danger">*</span></th> --}}
{{--                    <th width="20%"> Material <span class="text-danger">*</span></th> --}}
{{--                    <th width="5%"> Unit <span class="text-danger">*</span></th> --}}
{{--                    <th width="5%"> Curr. Price <span class="text-danger">*</span></th> --}}
{{--                    <th width="10%"> Balance Qty <span class="text-danger">*</span></th> --}}
{{--                    <th width="10%"> Qty(+/-) <span class="text-danger">*</span></th> --}}
{{--                    <th width="10%"> Price(+/-) <span class="text-danger">*</span></th> --}}
{{--                    <th width="10%"> Amount <span class="text-danger">*</span></th> --}}
{{--                    <th width="10%"> Remarks <span class="text-danger">*</span></th> --}}
{{--                    <th><i class="btn btn-primary btn-sm fa fa-plus add-specification-row"></i></th> --}}
{{--                </tr> --}}
{{--            </thead> --}}
{{--            <tbody> --}}
{{--                <tr> --}}
{{--                    <td> --}}
{{--                        <select class="form-control nested_material_id select2" name="nested_material_id" required> --}}
{{--                            <option value="" selected disabled>Select Option</option> --}}
{{--                            @foreach ($materials as $material) --}}
{{--                                <option value="{{ $material->id }}">{{ $material?->name }}</option> --}}
{{--                            @endforeach --}}
{{--                        </select> --}}
{{--                    </td> --}}
{{--                    <td> --}}
{{--                        <input type="text" name="unit" class="form-control unit" autocomplete="off" readonly> --}}
{{--                    </td> --}}
{{--                    <td width="10%"> <input type="number" name="previous_quantity[]" class="form-control previous_quantity" autocomplete="off"> </td> --}}
{{--                    <td width="10%"> <input type="number" readonly name="previous_quantity[]" class="form-control previous_quantity" autocomplete="off"> </td> --}}
{{--                    <td width="10%"> <input type="number" name="used_quantity[]" class="form-control used_quantity" autocomplete="off"> </td> --}}
{{--                    <td width="10%"> <input type="number" name="current_quantity[]" class="form-control current_quantity" autocomplete="off"> </td> --}}
{{--                    <td width="10%"> <input type="number" readonly name="revised_quantity[]" class="form-control revised_quantity"> </td> --}}
{{--                    <td width="10%"> <input type="number" name="revised_rate[]" class="form-control revised_rate"> </td> --}}
{{--                    <td> <i class="btn btn-danger btn-sm fa fa-minus remove-calculation-row"></i> </td> --}}
{{--                </tr> --}}
{{--            </tbody> --}}
{{--            <tfoot> --}}
{{--                <input type="hidden" name="project_id" value="{{ $project?->id }}"> --}}
{{--            </tfoot> --}}
{{--        </table> --}}
{{--    </div> --}}
{{-- </div> --}}

{{-- @section('script') --}}
{{--    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}
{{--    <script src="https://unpkg.com/axios/dist/axios.min.js"></script> --}}
{{--    <script> --}}
{{--        const BOQ_MATERIAL_REVISED_BUDGET_DATA_URL = "{{ route('boq.project.departments.civil.get-material-revised-budget-by-id', $project) }}"; --}}

{{--        // <td> --}}
{{--        //     <input type="text" placeholder="${selectedOption.text}" id="${selectedOption.id}" class="form-control revised_material_floor" autocomplete="off" readonly> --}}
{{--        //         <input type="hidden" name="revised_material_floor[]" value="${selectedOption.id}" class="form-control" autocomplete="off"> --}}
{{--        // </td> --}}

{{--        /* Appends specification row */ --}}
{{--            function appendCalculationRow(selectedOption=null) { --}}
{{--            let row = ` --}}
{{--                    <tr> --}}
{{--                        <td> --}}
{{--                            <select class="form-control nested_material_id select2" name="nested_material_id[]" required> --}}
{{--                                <option value="" selected disabled>Select Option</option> --}}
{{--                                @foreach ($materials as $material) --}}
{{--                                <option value="{{ $material->id }}">{{ $material?->name }}</option> --}}
{{--                                @endforeach --}}
{{--                             </select> --}}
{{--                        </td> --}}
{{--                        <td> --}}
{{--                            <input type="text" name="material_unit[]" class="form-control unit" autocomplete="off" readonly> --}}
{{--                        </td> --}}
{{--                        <td width="10%"> <input type="text" name="previous_quantity[]" class="form-control previous_quantity" autocomplete="off"> </td> --}}
{{--                        <td width="10%"> <input type="text" name="previous_quantity[]" class="form-control previous_quantity" autocomplete="off"> </td> --}}
{{--                        <td width="10%"> <input type="number" name="used_quantity[]" class="form-control used_quantity" autocomplete="off"> </td> --}}
{{--                        <td width="10%"> <input type="text" name="current_quantity[]" class="form-control current_quantity" autocomplete="off"> </td> --}}
{{--                        <td width="10%"> <input type="number" step=".01" name="revised_quantity[]" class="form-control revised_quantity" autocomplete="off"> </td> --}}
{{--                        <td width="10%"> <input type="number" step=".01" name="revised_rate[]" class="form-control revised_rate" autocomplete="off"> </td> --}}

{{--                    </tr> --}}
{{-- `; --}}
{{--                // <td> <i class="btn btn-danger btn-sm fa fa-minus remove-calculation-row"></i> </td> --}}

{{--            $('#material_specification_table tbody').append(row); --}}
{{--            $('.select2').select2(); --}}
{{--        } --}}

{{--        /* Adds and removes specification row on click */ --}}
{{--        $("#material_specification_table") --}}
{{--            .on('click', '.add-specification-row', () => { --}}
{{--                appendCalculationRow(); --}}
{{--            }) --}}
{{--            .on('click', '.remove-calculation-row', function() { --}}
{{--                $(this).closest('tr').remove(); --}}
{{--            }); --}}



{{--        function updateMaterialData(materialData,element){ --}}
{{--            $(element).closest('tr').find('.unit').val(materialData?.material?.unit?.name); --}}
{{--            // $(element).closest('tr').find('.rate').val(materialData?.price); --}}
{{--            // calculateAmount(element); --}}
{{--        } --}}

{{--        async function getConsumableMaterialDataById(materialId,element){ --}}
{{--            let response = await axios.post(BOQ_MATERIAL_REVISED_BUDGET_DATA_URL, { --}}
{{--                _token: "{{ csrf_token() }}", --}}
{{--                nested_material_id: materialId, --}}
{{--            }); --}}
{{--            materialData = await response.data; --}}
{{--            updateMaterialData(materialData,element); --}}
{{--        } --}}

{{--        function removeCalculationRow(option) { --}}
{{--            $(`#material_specification_table tbody tr`).each(function() { --}}
{{--                if ($(this).find('.revised_material_floor').attr('id') == option.id) { --}}
{{--                    $(this).remove(); --}}
{{--                } --}}
{{--            }); --}}
{{--        } --}}

{{--        $(document).ready(function() { --}}
{{--            $('.select2').select2(); --}}
{{--            $(document).on("change",'.nested_material_id', function() { --}}
{{--                getConsumableMaterialDataById($(this).val(),this); --}}
{{--            }); --}}

{{--            // $(document).on("select2:select", '.boq_floor_id', function(e) { --}}
{{--            //     let selectedOption = e.params.data; --}}
{{--            //     appendCalculationRow(selectedOption); --}}
{{--            // }); --}}
{{--            // --}}
{{--            // $(document).on("select2:unselect", '.boq_floor_id', function(e) { --}}
{{--            //     let removedOption = e.params.data; --}}
{{--            //     removeCalculationRow(removedOption); --}}
{{--            // }); --}}
{{--        }); --}}
{{--    </script> --}}
{{-- @endsection --}}
