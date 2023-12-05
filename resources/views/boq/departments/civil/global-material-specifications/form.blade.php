@csrf

<div class="tableHeading">
    <h5> <span>&#10070;</span>Global Material Specification<span>&#10070;</span><span class="work_unit"></span> </h5>
</div>
<div class="mt-2">
    <div class="input-group input-group-sm input-group-primary">
        <label class="input-group-addon" for="effective_date">Item Head</label>
        <input type="text" name="item_head" id="item_head" @if(!empty($boqCivilMaterialSpecifications)) value="{{ $boqCivilMaterialSpecifications[0]->item_head }}" @endif class="form-control">
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <table class="table table-bordered" id="material_specification_table">
            <thead>
                <tr>
                    <th width="70%"> Item Name <span class="text-danger">*</span></th>
                    <th width="40%"> Unit <span class="text-danger">*</span></th>
                    <th width="10%"> Specification <span class="text-danger">*</span></th>
                    <th width="10%"> Unit Price <span class="text-danger">*</span></th>
                    <th width="20%"> Remarks </th>
                    <th><i class="btn btn-primary btn-sm fa fa-plus add-specification-row"></i></th>
                </tr>
            </thead>
            <tbody></tbody>
            <tfoot>
                @if (empty($boqCivilMaterialSpecifications))
                    <tr>
                        <td width="10%"> <input type="text" name="item_name[]" class="form-control item_name" required autocomplete="off"> </td>
                        <td width="70%">
                            <select class="form-control unit_id" name="unit_id[]" required>
                                <option value="">Select Unit</option>
                                    @foreach ($units as $unit)
                                        <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                    @endforeach
                            </select>
                        </td>
                        <td width="10%"> <input type="text" name="specification[]" class="form-control specification" autocomplete="off"> </td>
                        <td width="10%"> <input type="number" name="unit_price[]" class="form-control unit_price" autocomplete="off"> </td>
                        <td width="10%"> <input type="text" name="remarks[]" class="form-control remarks" autocomplete="off"> </td>
                        <td> <i class="btn btn-danger btn-sm fa fa-minus remove-calculation-row"></i> </td>
                    </tr>
                @else

                @foreach($boqCivilMaterialSpecifications as $boqCivilMaterialSpecification)
                    <tr>
                        <td width="10%"> <input type="text" name="item_name[]" class="form-control item_name" value="{{ $boqCivilMaterialSpecification?->item_name }}" required autocomplete="off"> </td>

                        <td width="70%">
                            <select class="form-control unit_id" name="unit_id[]" required>
                                <option value="">Select Unit</option>
                                    @foreach ($units as $unit)
                                        <option value="{{ $unit->id }}" {{ $boqCivilMaterialSpecification?->unit_id == $unit?->id ? 'selected' : '' }}>{{ $unit?->name }}</option>
                                    @endforeach
                            </select>
                        </td>

                        <td width="10%">
                            <input type="text" name="specification[]" class="form-control specification" required autocomplete="off" value="{{ $boqCivilMaterialSpecification?->specification }}">
                        </td>
                        <td width="10%">
                            <input type="number" name="unit_price[]" class="form-control unit_price" autocomplete="off" value="{{ $boqCivilMaterialSpecification?->unit_price }}">
                        </td>
                        <td width="10%">
                            <input type="text" name="remarks[]" class="form-control remarks" autocomplete="off" value="{{ $boqCivilMaterialSpecification?->remarks }}">
                        </td>
                        <td> <i class="btn btn-danger btn-sm fa fa-minus remove-calculation-row"></i> </td>
                    </tr>
                @endforeach

                @endif

                <tr>

                </tr>
                <input type="hidden" name="project_id" value="{{ $project?->id }}">
            </tfoot>
        </table>
    </div>
</div>

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        /* Appends specification row */
        function appendCalculationRow() {
            let row = `
                    <tr>
                        <td width="10%"> <input type="text" name="item_name[]" class="form-control item_name" required autocomplete="off"> </td>
                        <td width="70%">
                            <select class="form-control unit_id" name="unit_id[]" required>
                                <option value="">Select Unit</option>
                                    @foreach ($units as $unit)
                                        <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                    @endforeach
                            </select>
                        </td>
                        <td width="10%"> <input type="text" name="specification[]" class="form-control specification" required autocomplete="off"> </td>
                        <td width="10%"> <input type="number" name="unit_price[]" class="form-control unit_price" autocomplete="off"> </td>
                        <td width="10%"> <input type="text" name="remarks[]" class="form-control remarks" autocomplete="off"> </td>
                        <td> <i class="btn btn-danger btn-sm fa fa-minus remove-calculation-row"></i> </td>
                    </tr>
                `;

            $('#material_specification_table tbody').append(row);
        }

        /* Adds and removes specification row on click */
        $("#material_specification_table")
            .on('click', '.add-specification-row', () => {
                appendCalculationRow();
            })
            .on('click', '.remove-calculation-row', function() {
                $(this).closest('tr').remove();
            });

        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
@endsection
