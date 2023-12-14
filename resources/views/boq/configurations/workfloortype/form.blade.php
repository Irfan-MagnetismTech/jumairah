{{--@csrf--}}
{{--<div class="row">--}}
{{--    <div class="col-xl-12 col-md-12 mt-2">--}}
{{--        <div class="input-group input-group-sm input-group-primary">--}}
{{--            <label class="input-group-addon" for="effective_date">Select Type<span class="text-danger">*</span></label>--}}
{{--            <select name="boq_floor_type_id" id="boq_floor_type_id" class="form-control select2" required>--}}
{{--                <option value="">-- Select Floor type --</option>--}}
{{--                @foreach($floor_types as $type)--}}
{{--                <option value="{{ $type->id }}" @if ($type->id == old('type_id', $floor->type_id ?? -1)) selected @endif>{{ $type->name }}</option>--}}
{{--                @endforeach--}}
{{--            </select>--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <div class="col-xl-12 col-md-12 mt-2">--}}
{{--        <div class="input-group input-group-sm input-group-primary">--}}
{{--            <label class="input-group-addon" for="effective_date">Work</label>--}}
{{--            <select name="boq_work_id" id="boq_work_id" class="form-control select2">--}}
{{--                <option value="">-- Select Work --</option>--}}
{{--                @foreach ($works as $single_work)--}}
{{--                    <option value="{{ $single_work->id }}" @if ($single_work->id == old('parent_id', $work->parent_id ?? -1)) selected @endif>{{ $single_work->name }}</option>--}}
{{--                    @if (count($single_work->children) > 0)--}}
{{--                        @include('boq.departments.civil.configurations.work.subwork', ['works' => $single_work->children, 'prefix' => '__'])--}}
{{--                    @endif--}}
{{--                @endforeach--}}
{{--            </select>--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <input name="account_id" type="hidden" value="{{ \Illuminate\Support\Facades\Auth::user()->id }}">--}}

{{--</div>--}}

@csrf
<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-10">
        <div class="card">
            <div class="tableHeading">
                <h5> <span>&#10070;</span>Floor type<span>&#10070;</span> </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Select work -->
                    <div class="col-xl-12 col-md-12">
                        <div class="input-group input-group-sm input-group-primary">
                            <label class="input-group-addon" for="boq_floor_type_id">Select Floor Type<span class="text-danger">*</span></label>
                            <select class="form-control select2" id="boq_floor_type_id" name="boq_floor_type_id" required>
                                <option value="">Select Type</option>
                                @foreach($floor_types as $type)
                                    <option value="{{ $type->id }}" @if ($type->id == old('type_id', $floor->type_id ?? -1)) selected @endif>{{ $type->name }}</option>
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        /* Appends calculation row */
        function appendCalculationRow() {
            let row = `
                <tr>
                    <td width="90%">
                        <select class="form-control boq_work_id" name="boq_work_id[]" required>
                             <option value="">Select Work</option>
                             @foreach ($works as $single_work)
                                <option value="{{ $single_work->id }}" @if ($single_work->id == old('parent_id', $work->parent_id ?? -1)) selected @endif>{{ $single_work->name }}</option>
                                @if (count($single_work->children) > 0)
                                    @include('boq.departments.civil.configurations.work.subwork', ['works' => $single_work->children, 'prefix' => '__'])
                                @endif
                            @endforeach
            </select>
        </td>
        <td> <i class="btn btn-danger btn-sm fa fa-minus remove-calculation-row"></i> </td>
    </tr>
`;

            $('#calculation_table tbody').append(row);
        }

        /* Adds and removes calculation row on click */
        $("#calculation_table")
            .on('click', '.add-calculation-row', () => {
                appendCalculationRow();
                $('.boq_work_id').select2();
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
            $('.boq_work_id').select2();
        });
    </script>
@endsection

