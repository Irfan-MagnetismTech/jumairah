
@csrf
<!-- Calculation -->
<div class="mt-1 row">
    <div class="col-md-1"></div>
    <div class="col-md-10">
        <div class="card">
            <div class="tableHeading">
                <h5> <span>&#10070;</span>Material Formula<span>&#10070;</span><span class="work_unit"></span> </h5>
            </div>
            <div class="card-body">
                <!-- Calculations -->
                <div class="mt-1 row">
                    <div class="col-md-12">
                        <table class="table table-bordered" id="calculation_table">
                            <thead>
                            <tr>
                                <th> Material <span class="text-danger">*</span></th>
                                <th> Price <span class="text-danger">*</span></th>
                                <th> Wastage(%) <span class="text-danger"></span></th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                            <tfoot>
                            <tr>

                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-1"></div>
</div>

@section('script')
    <script>
        /* Appends calculation row */
        function appendCalculationRow() {
            let row = `
                <tr>
                    <td>
                        <select class="form-control nested_material_id" name="nested_material_id" required>
                             <option value="">Select Work</option>
                                @foreach($nested_materials as $single_material)
                                <option value="{{ $single_material->id }}" @if ($single_material->id == old('nested_material_id', $materialPriceWastage->nested_material_id ?? -1)) selected @endif>{{ $single_material->name }}</option>
                                @if (count($single_material->children) > 0)
                                @include('boq.configurations.materialpricewastage.submaterial', ['nested_materials' => $single_material->children, 'prefix' => '-'])
                                @endif
                                @endforeach
                        </select>
                    </td>
                    <td> <input type="text" name="price" class="form-control price" required value="{{ old('price', $materialPriceWastage->price ?? '') }}" placeholder="Material Price"> </td>
                    <td> <input type="text" name="wastage" class="form-control wastage" value="{{ old('wastage', $materialPriceWastage->wastage ?? '') }}" placeholder="Wastage value"> </td>

                </tr>
            `;

            $('#calculation_table tbody').append(row);
        }

        /* Adds and removes calculation row on click */
        $("#calculation_table")
            .on('click', '.add-calculation-row', () => appendCalculationRow())
            .on('click', '.remove-calculation-row', function() {
                $(this).closest('tr').remove();
            });

        /* The document function */
        $(function() {
            appendCalculationRow();
        });
    </script>
@endsection

