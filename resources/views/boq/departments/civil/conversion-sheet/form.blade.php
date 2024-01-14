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

    .boq_floor_id>.select2-selection {
        height: 33px !important;
    }
</style>

<div class="tableHeading">
    <h5> <span>&#10070;</span>Material Conversion Sheet<span>&#10070;</span><span class="work_unit"></span> </h5>
</div>
<div class="mt-2">
    <div class="input-group input-group-sm input-group-primary mb-2">
        <label class="input-group-addon" for="nested_material_id">Select Material <span
                class="text-danger">*</span></label>
        {{-- <select class="form-control nested_material_id select2" name="nested_material_id" required>
            <option value="" disabled selected>Select Option</option>
            @foreach ($materials as $material)
                <option value="{{ $material->id }}">{{ $material?->name }}</option>
            @endforeach
        </select> --}}

        <select class="form-control nested_material_id select2" id="nested_material_id" name="nested_material_id" required {!! isset($conversion_data) ? 'disabled' : '' !!}>
            <option value="" disabled selected>Select Option</option>
            @foreach ($materials as $material)
                <option value="{{ $material?->id }}" {{ isset($conversion_data) && $material?->id === $conversion_data?->material_id ? 'selected' : '' }}>
                    {{ $material?->name }}</option>
            @endforeach
        </select>
        @if (isset($conversion_data))
            <input type="hidden" class="form-control nested_material_id" id="nested_material_id" name="nested_material_id" value="{{ $conversion_data->material_id }}">
        @endif
    </div>
    <div class="input-group input-group-sm input-group-primary mb-2">
        <div class="col-md-4 input-group input-group-sm input-group-primary"
            style="padding-left: 4px; padding-right: 0">
            <label class="input-group-addon" for="unit">Unit</label>
            <input type="text" id="unit" value="{{ old('unit', isset($conversion_data) ? $conversion_data?->material?->unit?->name : '') }}" class="form-control mr-2" readonly>
        </div>
        <label class="input-group-addon" for="date">Date <span class="text-danger">*</span></label>
        <input type="date" value="{{ old('conversion_date', isset($conversion_data) ? $conversion_data?->conversion_date : '') }}" name="conversion_date" id="date"
            class="form-control mr-2 col-md-4" required>
        <label class="input-group-addon" for="escalation_date">Conversion of<span class="text-danger"> *</span></label>
        <select name="budget_type" id="budget_type" class="form-control col-md-4" required>
            <option value="" selected disabled>Select Option</option>
            <option value="material"
                {{ isset($conversion_data) && $conversion_data?->budget_type === 'material' ? 'selected' : '' }}>Material
            </option>
            <option value="labour"
                {{ isset($conversion_data) && $conversion_data?->budget_type === 'labour' ? 'selected' : '' }}>Labour
            </option>
            <option value="material-labour"
                {{ isset($conversion_data) && $conversion_data?->budget_type === 'material-labour' ? 'selected' : '' }}>
                Material-Labour</option>
            <option value="other"
                {{ isset($conversion_data) && $conversion_data?->budget_type === 'other' ? 'selected' : '' }}>Other</option>
        </select>
    </div>

</div>
<div class="row">
    <div class="col-md-12">
        <table class="table table-bordered" id="material_specification_table">
            <thead>
                <tr>
                    <th width="20%"> Floor <span class="text-danger">*</span></th>
                    <th width="20%"> BOQ Qty <span class="text-danger">*</span></th>
                    <th width="20%"> Qty(+/-) <span class="text-danger">*</span></th>
                    <th width="20%"> Final Quantity <span class="text-danger">*</span></th>
                    <th width="20%"> Remarks</th>
                    @if(!isset($conversion_data) || !$conversion_data)
                        <th><i class="btn btn-primary btn-sm fa fa-plus add-specification-row"></i></th>
                    @endif
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <select class="form-control boq_floor_id" name="boq_floor_id[]" id="boq_floor_id" required
                            {!! isset($conversion_data) ? 'disabled' : '' !!}>
                            <option value="" selected disabled>Select Option</option>
                            @foreach ($floor_list as $floor)
                                <option value="{{ $floor->boq_floor_id }}"
                                    {{ isset($conversion_data) && $conversion_data->boq_floor_id == $floor->boq_floor_id ? 'selected' : '' }}>
                                    {{ $floor->boqCivilCalcProjectFloor->boqCommonFloor->name }}
                                </option>
                            @endforeach
                            <option {{ isset($conversion_data) && $conversion_data->boq_floor_id == 'Construction equipment (Re-useable)' ? 'selected' : '' }} value="Construction equipment (Re-useable)">Construction equipment (Re-useable)</option>
                            <option {{ isset($conversion_data) && $conversion_data->boq_floor_id == 'Consumable materials' ? 'selected' : '' }} value="Consumable materials">Consumable materials</option>
                            <option {{ isset($conversion_data) && $conversion_data->boq_floor_id == 'Other Related Work' ? 'selected' : '' }} value="Other Related Work">Other Related Work</option>
                            <option {{ isset($conversion_data) && $conversion_data->boq_floor_id == 'Safety staging & Canopy materials' ? 'selected' : '' }} value="Safety staging & Canopy materials">Safety staging & Canopy materials</option>
                            <option {{ isset($conversion_data) && $conversion_data->boq_floor_id == 'Steel shuttering materials (Re-useable)' ? 'selected' : '' }} value="Steel shuttering materials (Re-useable)">Steel shuttering materials (Re-useable)</option>
                        </select>
                        @if (isset($conversion_data))
                        <input type="hidden" class="form-control boq_floor_id" name="boq_floor_id[]" id="boq_floor_id" value="{{ $conversion_data->boq_floor_id }}">
                        @endif
                    </td>
                    <td width="20%"> <input type="number" readonly name="previous_quantity[]" value="{{ old('previous_quantity', isset($conversion_data) ? $conversion_data?->boq_qty : '') }}"
                            class="form-control previous_quantity" autocomplete="off" required> </td>
                    <td width="20%"> <input type="number" name="used_quantity[]" value="{{ old('used_quantity', isset($conversion_data) ? $conversion_data?->changed_qty : '') }}" class="form-control used_quantity"
                            autocomplete="off" required> </td>
                    <td width="20%"> <input type="number" name="revised_quantity[]" value="{{ old('revised_quantity', isset($conversion_data) ? $conversion_data?->final_qty : '') }}"
                            class="form-control revised_quantity" readonly required> </td>
                    <td width="20%"> <input type="text" name="remarks[]" value="{{ old('remarks', isset($conversion_data) ? $conversion_data?->remarks : '') }}" class="form-control remarks"
                            autocomplete="off"> </td>
                    @if(!isset($conversion_data) || !$conversion_data)
                    <td> <i class="btn btn-danger btn-sm fa fa-minus remove-calculation-row"></i> </td>
                    @endif
                </tr>
            </tbody>
            <tfoot>
                <input type="hidden" name="project_id" value="{{ $project?->id }}">
            </tfoot>
        </table>
    </div>
</div>

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
        var CSRF_TOKEN = "{{ csrf_token() }}";
        const BOQ_MATERIAL_CONVERSION_DATA_URL =
            "{{ route('boq.project.departments.civil.get-material-conversion-data-by-id', $project) }}";

        function appendCalculationRow(selectedOption = null) {
            let row = `
                    <tr>
                    <td>
                        <select class="form-control boq_floor_id" name="boq_floor_id[]" required>
                            <option value="" selected disabled>Select Option</option>
                            @foreach ($floor_list as $floor)
                                <option value="{{ $floor->boq_floor_id }}">
                                    {{ $floor?->boqCivilCalcProjectFloor?->boqCommonFloor?->name }}
                                </option>
                            @endforeach
                            <option {{ isset($conversion_data) && $conversion_data->boq_floor_id == 'Construction equipment (Re-useable)' ? 'selected' : '' }} value="Construction equipment (Re-useable)">Construction equipment (Re-useable)</option>
                            <option {{ isset($conversion_data) && $conversion_data->boq_floor_id == 'Consumable materials' ? 'selected' : '' }} value="Consumable materials">Consumable materials</option>
                            <option {{ isset($conversion_data) && $conversion_data->boq_floor_id == 'Other Related Work' ? 'selected' : '' }} value="Other Related Work">Other Related Work</option>
                            <option {{ isset($conversion_data) && $conversion_data->boq_floor_id == 'Safety staging & Canopy materials' ? 'selected' : '' }} value="Safety staging & Canopy materials">Safety staging & Canopy materials</option>
                            <option {{ isset($conversion_data) && $conversion_data->boq_floor_id == 'Steel shuttering materials (Re-useable)' ? 'selected' : '' }} value="Steel shuttering materials (Re-useable)">Steel shuttering materials (Re-useable)</option>
                        </select>
                    </td>
                    <td width="20%"> <input type="number" readonly name="previous_quantity[]"
                            class="form-control previous_quantity" value="0" autocomplete="off" required> </td>
                    <td width="20%"> <input type="number" name="used_quantity[]" class="form-control used_quantity"
                            autocomplete="off" required> </td>
                    <td width="20%"> <input type="number" name="revised_quantity[]"
                            class="form-control revised_quantity" readonly required> </td>
                    <td width="20%"> <input type="text" name="remarks[]" class="form-control remarks" autocomplete="off"> </td>
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

        async function getConsumableMaterialDataById(floorId, materialId, budget_type, e) {
            let response = await axios.post(BOQ_MATERIAL_CONVERSION_DATA_URL, {
                _token: "{{ csrf_token() }}",
                nested_material_id: materialId,
                budget_type: budget_type,
                floor_id: floorId,

            });
            materialData = await response.data;
            $(e).closest('tr').find('.previous_quantity').val(materialData.quantity ?? 0)
        }

        $("#nested_material_id").on('change', function() {

            $.ajax({
                url: "{{ route('boq.materialunit') }}",
                type: 'get',
                data: {
                    _token: CSRF_TOKEN,
                    nested_material_id: $("#nested_material_id").val(),
                },
                success: function(data) {
                    $('#unit').val(data.nested_material.unit.name);

                }
            });
        });



        $(document).ready(function() {
            $('.select2').select2();

            $(document).on("change", '.boq_floor_id', function() {
                let material_id = document.getElementById("nested_material_id").value;
                let budget_type = document.getElementById("budget_type").value;
                getConsumableMaterialDataById($(this).val(), material_id, budget_type, this);
            });

            $(document).on("select2:select", '.boq_floor_id', function(e) {
                let selectedOption = e.params.data;
                appendCalculationRow(selectedOption);
            });

            $(document).on("select2:unselect", '.boq_floor_id', function(e) {
                let removedOption = e.params.data;
                removeCalculationRow(removedOption);
            });

            //onchange boq_floor_id,previous_quantity,used_qty,revised_qty
            $(document).on("change", '.previous_quantity,.used_quantity,.revised_quantity',
                function() {
                    let previous_quantity = $(this).closest('tr').find('.previous_quantity').val();
                    let used_quantity = $(this).closest('tr').find('.used_quantity').val();

                    let total_quantity = parseFloat(previous_quantity) + parseFloat(used_quantity);

                    $(this).closest('tr').find('.revised_quantity').val(total_quantity.toFixed(2));
                });
        });
    </script>
@endsection
