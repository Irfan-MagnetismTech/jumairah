@csrf

<!-- Calculation -->
<div class="mt-1 row">
    <div class="col-md-1"></div>
    <div class="col-md-10">
        <div class="card">
            <div class="tableHeading">
                <h5> <span>&#10070;</span>Civil Consumable Cost<span>&#10070;</span><span class="work_unit"></span> </h5>
            </div>
            <div class="card-body">
                <!-- Calculations -->
                <div class="mt-1 row">
                    <div class="col-md-12">
                        <table class="table table-bordered" id="calculation_table">
                            <thead>
                                <tr>
                                    <th> Material <span class="text-danger">*</span></th>
                                    <th> Quantity <span class="text-danger">*</span></th>
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
                        <select class="form-control nested_material_id select2" name="nested_material_id" required>
                             <option value="">Select Material</option>
                             @foreach ($nested_materials as $nested_material)
            <option value="{{ $nested_material->id }}" @if (old('nested_material_id', $consumable->nested_material_id ?? null) == $nested_material->id) selected @endif>
                                     {{ $nested_material->name }}
            </option>
@endforeach
{{--                             @foreach ($nested_materials as $id => $name)--}}
{{--                                 <option value="{{ $id }}" @if (old('nested_material_id', $consumable->nested_material_id ?? null) == $id) selected @endif>--}}
{{--                                     {{ $name }}--}}
{{--                                 </option>--}}
{{--                             @endforeach--}}
            </select>
        </td>
        <td> <input type="text" name="quantity" value="{{ old('quantity', $consumable->quantity ?? '') }}" class="form-control quantity" required placeholder="Quantity"> </td>

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



{{-- @csrf --}}
{{-- <div class="row"> --}}
{{-- <div class="col-md-12"> --}}
{{-- <div class="card"> --}}
{{-- <div class="card-body"> --}}
{{-- <div class="row"> --}}
{{-- <div class="col-md-12"> --}}
{{-- <div class="input-group input-group-sm input-group-primary"> --}}
{{-- <label class="input-group-addon" for="nested_material_id">Select Material<span class="text-danger">*</span></label> --}}
{{-- <select name="nested_material_id" class="form-control"> --}}
{{-- <option value="">-- Select Material --</option> --}}
{{-- @foreach ($nested_materials as $id => $name) --}}
{{-- <option value="{{ $id }}" @if (old('nested_material_id', $boq_consumable_cost->nested_material_id ?? null) == $id) selected @endif> --}}
{{-- {{ $name }} --}}
{{-- </option> --}}
{{-- @endforeach --}}
{{-- </select> --}}
{{-- </div> --}}
{{-- </div> --}}
{{-- <div class="col-md-6"> --}}
{{-- <div class="input-group input-group-sm input-group-primary"> --}}
{{-- <label class="input-group-addon" for="quantity">Quantity<span class="text-danger">*</span></label> --}}
{{-- <input type="number" class="form-control" name="quantity" value="{{ old('quantity', $boq_consumable_cost->quantity ?? '') }}"> --}}
{{-- </div> --}}
{{-- </div> --}}
{{-- </div> --}}
{{-- </div> --}}
{{-- </div> --}}
{{-- </div> --}}
{{-- </div> --}}
