@csrf
<div class="row">
    <!-- Work Head -->
    <div class="col-xl-12 col-md-12 mt-2">
        <div class="input-group input-group-sm input-group-primary">
            <label class="input-group-addon" for="effective_date">Work For <span class="text-danger">*</span></label>
            <select name="calculation_type" id="calculation_type" class="form-control" required>
                <option value="" disabled selected>-- Select Option --</option>
                <option value="material">Material</option>
                <option value="labour">Labour</option>
                <option value="material-labour">Material & Labour</option>
            </select>
        </div>
    </div>

    <div class="col-xl-12 col-md-12 mt-2">
        <div class="input-group input-group-sm input-group-primary">
            <label class="input-group-addon" for="effective_date">Work Head</label>
            <select name="parent_id" id="parent_id" class="form-control select2">
                <option value="">-- Select Work Head --</option>
                @foreach ($works as $single_work)
                    <option value="{{ $single_work->id }}" @if ($single_work->id == old('parent_id', $work->parent_id ?? -1)) selected @endif>{{ $single_work->name }} -(<strong>{{ $single_work->calculation_type }}</strong>)</option>
                    @if (count($single_work->children) > 0)
                        @include('boq.departments.civil.configurations.work.subwork', ['works' => $single_work->children, 'prefix' => '__'])
                    @endif
                @endforeach
            </select>
        </div>
    </div>

    <!-- Work Head -->
    <div class="col-xl-12 col-md-12 mt-2">
        <div class="input-group input-group-sm input-group-primary">
            <label class="input-group-addon" for="effective_date">Work Name<span class="text-danger">*</span></label>
            <input type="text" name="name" id="name" required value="{{ old('name', $work->name ?? '') }}" placeholder="Enter work name" autocomplete="off" class="form-control">
        </div>
    </div>

        <div class="col-xl-12 col-md-12 mt-2">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="unit_id">Work Unit</label>
                <select name="unit_id" id="unit_id" class="form-control select2">
                    <option value="">-- Select Work Unit --</option>
                    @foreach ($units as $unit)
                        <option value="{{ $unit->id }}" @if ($unit->id == old('material_unit', $work->material_unit ?? -1)) selected @endif>{{ $unit->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

    <!-- Material Unit -->
{{--    <div class="col-xl-12 col-md-12 mt-2">--}}
{{--        <div class="input-group input-group-sm input-group-primary">--}}
{{--            <label class="input-group-addon" for="material_unit">Material Unit</label>--}}
{{--            <select name="material_unit" id="material_unit" class="form-control select2">--}}
{{--                <option value="">-- Select Material Unit --</option>--}}
{{--                @foreach ($units as $unit)--}}
{{--                    <option value="{{ $unit->id }}" @if ($unit->id == old('material_unit', $work->material_unit ?? -1)) selected @endif>{{ $unit->name }}</option>--}}
{{--                @endforeach--}}
{{--            </select>--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <!-- Labour Unit -->--}}
{{--    <div class="col-xl-12 col-md-12 mt-2">--}}
{{--        <div class="input-group input-group-sm input-group-primary">--}}
{{--            <label class="input-group-addon" for="labour_unit">Labour Unit</label>--}}
{{--            <select name="labour_unit" id="labour_unit" class="form-control select2">--}}
{{--                <option value="">-- Select Labour Unit --</option>--}}
{{--                @foreach ($units as $unit)--}}
{{--                    <option value="{{ $unit->id }}" @if ($unit->id == old('labour_unit', $work->labour_unit ?? -1)) selected @endif>{{ $unit->name }}</option>--}}
{{--                @endforeach--}}
{{--            </select>--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <div class="col-xl-12 col-md-12 mt-2">--}}
{{--        <div class="input-group input-group-sm input-group-primary">--}}
{{--            <label class="input-group-addon" for="labour_unit">Labour Budget Type</label>--}}
{{--            <select name="labour_budget_type" id="labour_budget_type" class="form-control" required>--}}
{{--                <option value="">-- Select Labour Budget Type --</option>--}}
{{--                <option value="0" @if(isset($work)) @if($work->labour_budget_type == 0) selected @endif @endif>Material Calculation Qty</option>--}}
{{--                <option value="1" @if(isset($work)) @if($work->labour_budget_type == 1) selected @endif @endif>Floor Wise Area</option>--}}
{{--            </select>--}}
{{--        </div>--}}
{{--    </div>--}}

    <!-- Is Reinforcement -->
    <div class="col-6 my-1 mt-3">
        <div class="input-group input-group-sm input-group-primary">
            <div class="border-checkbox-section col-12">
                <div class="row">
                    <div class="col-12">
                        <div class="border-checkbox-group border-checkbox-group-warning">
                            <input class="border-checkbox" type="checkbox" name="is_reinforcement" id="is_reinforcement" {{ old('is_reinforcement', isset($work) ? ($work->is_reinforcement ? 'checked' : '') : '') }}>
                            <label class="border-checkbox-label" for="is_reinforcement">Type of Reinforcement work</label>
                        </div>
                    </div>
                </div> <!-- end row -->
            </div> <!-- end border-checkbox-section -->
        </div>
    </div>
{{--    <div class="col-6 my-1 mt-3">--}}
{{--        <div class="input-group input-group-sm input-group-primary">--}}
{{--            <div class="border-checkbox-section col-12">--}}
{{--                <div class="row">--}}
{{--                    <div class="col-12">--}}
{{--                        <div class="border-checkbox-group border-checkbox-group-warning">--}}
{{--                            <input class="border-checkbox" type="checkbox" name="is_multiply_calc_no" id="is_multiply_calc_no" {{ old('is_multiply_calc_no', isset($work) ? ($work->is_multiply_calc_no ? 'checked' : '') : '') }}>--}}
{{--                            <label class="border-checkbox-label" for="is_multiply_calc_no">Multiply With Calculation No.</label>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div> <!-- end row -->--}}
{{--            </div> <!-- end border-checkbox-section -->--}}
{{--        </div>--}}
{{--    </div>--}}


    <input name="account_id" type="hidden" value="{{ \Illuminate\Support\Facades\Auth::user()->id }}">
</div>
