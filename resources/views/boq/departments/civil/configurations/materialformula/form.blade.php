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
                                    <option value="{{ $single_work->id }}" @if ($single_work->id == old('parent_id', $work->parent_id ?? -1)) selected @endif>{{ $single_work->name }} -(<strong>{{ $single_work->calculation_type }}</strong>)</option>
                                    @if (count($single_work->children) > 0)
                                        @include('boq.departments.civil.configurations.materialformula.subwork', ['works' => $single_work->children, 'prefix' => '-'])
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <input type="hidden" name="final_total" id="final_total">

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
                                    <th width="70%"> Material <span class="text-danger">*</span></th>
                                    <th width="10%"> Value(%) <span class="text-danger">*</span></th>
                                    <th width="10%"> Wastage(%) <span class="text-danger"></span></th>
{{--                                    <th width="10%"> Multiply With <br> Pile Number <span class="text-danger"></span></th>--}}
                                    <th><i class="btn btn-primary btn-sm fa fa-plus add-calculation-row"></i></th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                            <tfoot>
                                <tr>

                                </tr>
                                <input type="hidden" name="project_id" value="{{ $project?->id }}">
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        /* Appends calculation row */
        function appendCalculationRow() {
            let row = `
                <tr>
                    <td width="70%">
                        <select class="form-control nested_material_id" name="nested_material_id[]" required>
                            <option value="">Select Material</option>
                                @foreach ($nested_materials as $material)
                                    <option value="{{ $material?->id }}">
                                    {{ $material?->name }}</option>
                                @endforeach
                        </select>
                    </td>
                    <td width="10%"> <input type="text" name="percentage_value[]" class="form-control percentage_value" required autocomplete="off"> </td>
                    <td width="10%"> <input type="text" name="wastage[]" class="form-control wastage" autocomplete="off"> </td>

                    <td> <i class="btn btn-danger btn-sm fa fa-minus remove-calculation-row"></i> </td>
                </tr>
            `;
            // <td width="10%"> <input type="checkbox" name="is_multiply_calc_no[]" class="border-checkbox form-control is_multiply_calc_no"> </td>

            $('#calculation_table tbody').append(row);
        }

        /* Adds and removes calculation row on click */
        $("#calculation_table")
            .on('click', '.add-calculation-row', () => {
                appendCalculationRow();
                $('.nested_material_id').select2();
            })
            .on('click', '.remove-calculation-row', function() {
                $(this).closest('tr').remove();
            });

        /* The document function */
        $(function() {
            //appendCalculationRow();
        });

        $(document).ready(function() {
            $('.select2').select2();
            $('.nested_material_id').select2();
        });
    </script>
@endsection
