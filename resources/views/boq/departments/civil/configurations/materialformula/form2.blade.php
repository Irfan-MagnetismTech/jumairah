@csrf
<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-10">
        <div class="card">
            <div class="tableHeading">
                <h5> <span>&#10070;</span>Work type<span>&#10070;</span> </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Select work -->
                    <div class="col-xl-12 col-md-12">
                        <div class="input-group input-group-sm input-group-primary">
                            <label class="input-group-addon" for="work_id">Select Work<span class="text-danger">*</span></label>
                            <select class="form-control select2" id="work_id" name="work_id" required>
                                <option value="">Select Work</option>
                                @foreach ($works as $single_work)
                                    <option value="{{ $single_work->id }}" @if ($single_work->id == old('work_id', $materialFormula->work_id ?? -1)) selected @endif>{{ $single_work->name }}</option>
                                    @if (count($single_work->children) > 0)
                                        @include('boq.departments.civil.configurations.materialformula.subwork', ['works' => $single_work->children, 'prefix' => '-'])
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <input type="hidden" name="final_total" id="final_total">
                    <input type="hidden" name="project_id" value="{{ $project?->id }}">

                    <!-- Select sub-work -->
                    <div class="col-xl-12 col-md-12">
                        <div id="subwork"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-1">
    </div>
</div>

<hr>
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
                                    <th> Value(%) <span class="text-danger">*</span></th>
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

                        <select class="form-control nested_material_id select2" name="nested_material_id" required>
                            <option value="">Select Material</option>
                                @foreach ($nested_materials as $material)
                                    <option value="{{ $material?->id }}" {{ isset($materialFormula) && $material?->id === $materialFormula?->nested_material_id ? 'selected' : '' }}>
                                    {{ $material?->name }}</option>
                                @endforeach
                        </select>
                    </td>
                    <td> <input type="text" name="percentage_value" class="form-control percentage_value" required value="{{ old('percentage_value', $materialFormula->percentage_value ?? '') }}" placeholder="Formula value"> </td>
                    <td> <input type="text" name="wastage" class="form-control wastage" value="{{ old('wastage', $materialFormula->wastage ?? '') }}" placeholder="Wastage value"> </td>

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
