@csrf

<div class="tableHeading">
    <h5> <span>&#10070;</span>Material Specification<span>&#10070;</span><span class="work_unit"></span> </h5>
</div>
<div class="mt-2">
    <div class="input-group input-group-sm input-group-primary">
        
        @if ($boqCivilMaterialSpecifications)
        <label class="input-group-addon" for="work_id">Selected Head</label>
        <input class="form-control" disabled name="item_head" value="{{ $boqCivilMaterialSpecifications->first()->item_head }}">
        @else
        <label class="input-group-addon" for="work_id">Select Head<span class="text-danger">*</span></label>
        <select class="form-control material_head select2" id="material_head" name="item_head" required>
            <option value="" selected disabled>Select Head</option>
            @foreach ($globalMaterialSpecifications as $key => $value)
                <option value="{{ $key }}">{{ $key }}</option>
            @endforeach
        </select>
        @endif
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
            <tbody>
                @if ($boqCivilMaterialSpecifications)
                @foreach ($boqCivilMaterialSpecifications as $boqCivilMaterialSpecification)
                <tr>
                    <td width="10%"> <input type="text" name="item_name[]" class="form-control item_name" value="{{ $boqCivilMaterialSpecification->item_name }}" required autocomplete="off"> </td>
                    <td width="70%">
                        <select class="form-control unit_id" name="unit_id[]" required>
                            <option value="">Select Unit</option>
                            @foreach ($units as $unit)
                                <option value="{{ $unit->id }}" {{ ($boqCivilMaterialSpecification->unit_id == $unit->id) ? "selected" : "" }}>{{ $unit?->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td width="10%"> <input type="text" name="specification[]" class="form-control specification" required autocomplete="off" value="{{ $boqCivilMaterialSpecification->specification }}"> </td>
                    <td width="10%"> <input type="number" name="unit_price[]" class="form-control unit_price" autocomplete="off" value="{{ $boqCivilMaterialSpecification->unit_price }}"> </td>
                    <td width="20%"> <input type="text" name="remarks[]" class="form-control remarks" autocomplete="off" value="{{ $boqCivilMaterialSpecification->remarks }}"> </td>
                    <td> <i class="btn btn-danger btn-sm fa fa-minus remove-calculation-row"></i> </td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        let all_data = {!! json_encode($globalMaterialSpecifications) !!}
        let new_data = Object.entries(all_data);

       $("#material_head").on("change", function() {
            new_data.find(item => {
                if (item[0] == $(this).val()) {
                    let data = item[1];
                    let html = '';
                    data.forEach(element => {
                        html += `
                            <tr>
                                <td width="10%">
                                    <input type="text" name="item_name[]" class="form-control item_name" value="${element.item_name}" required autocomplete="off">
                                </td>
                                <td width="70%">
                                    <select class="form-control unit_id" name="unit_id[]" required>
                                        <option value="">Select Unit</option>
                                            @foreach ($units as $unit)
                                                <option value="{{ $unit->id }}" ${(element.unit_id == {{$unit->id}}) ? "selected" : ""}>{{ $unit?->name }}</option>
                                            @endforeach
                                    </select>
                                </td>
                                <td width="10%">
                                    <input type="text" name="specification[]" class="form-control specification" required autocomplete="off" value="${element.specification}">
                                </td>
                                <td width="10%">
                                    <input type="number" name="unit_price[]" class="form-control unit_price" autocomplete="off" value="${element.unit_price}">
                                </td>
                                <td width="10%">
                                    <input type="text" name="remarks[]" class="form-control remarks" required autocomplete="off" value="${element.remarks}">
                                </td>
                                <td>
                                    <i class="btn btn-danger btn-sm fa fa-minus remove-calculation-row"></i>
                                </td>
                            </tr>
                        `;
                    });
                    $("#material_specification_table tbody").html(html);
                }
            });
        });

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
