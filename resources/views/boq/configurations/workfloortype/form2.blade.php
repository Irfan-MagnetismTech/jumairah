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
                            <select class="form-control select2" id="boq_floor_type_id" name="boq_floor_type_id" required>
                                <option value="">Select Type</option>
                                @foreach($floor_types as $type)
                                    <option value="{{ $type->id }}" @if ($type->id == old('boq_floor_type_id', $floor_type_work->boq_floor_type_id ?? -1)) selected @endif>{{ $type->name }}</option>
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
                <h5> <span>&#10070;</span>Work<span>&#10070;</span><span class="work_unit"></span> </h5>
            </div>
            <div class="card-body">
                <!-- Calculations -->
                <div class="mt-1 row">
                    <div class="col-md-12">
                        <table class="table table-bordered" id="calculation_table">
                            <thead>
                            <tr>
                                <th width="90%"> Work <span class="text-danger">*</span></th>
                                <th><i class="btn btn-primary btn-sm fa fa-plus add-calculation-row"></i></th>
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
                        <select class="form-control boq_work_id" name="boq_work_id" required>
                             <option value="">Select Work</option>
                             @foreach ($works as $single_work)
            <option value="{{ $single_work->id }}" @if ($single_work->id == old('boq_work_id', $floor_type_work->boq_work_id ?? -1)) selected @endif>{{ $single_work->name }}</option>
                                @if (count($single_work->children) > 0)
            @include('boq.departments.civil.configurations.work.subwork', ['works' => $single_work->children, 'prefix' => '__'])
            @endif
            @endforeach
            </select>
                    </td>

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
