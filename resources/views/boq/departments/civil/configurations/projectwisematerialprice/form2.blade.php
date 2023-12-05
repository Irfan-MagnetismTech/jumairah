@csrf
<!-- Calculation -->
<div class="mt-1 row">
    <div class="col-md-1"></div>
    <div class="col-md-10">
        <div class="card">
            <div class="tableHeading">
                <h5> <span>&#10070;</span>Material Price<span>&#10070;</span><span class="work_unit"></span> </h5>
            </div>
            <div class="card-body">
                <!-- Calculations -->
                <div class="mt-1 row">
{{--                    <div class="col-3">--}}
{{--                        <input type="checkbox" name="is_other_cost" value="{{ old('is_other_cost', $projectWiseMaterialPrice?->boqMaterialPriceWastage?->is_other_cost ?? '') }}" {{($projectWiseMaterialPrice?->boqMaterialPriceWastage?->is_other_cost) ? 'checked' : ''}}> is Consumable Material--}}
{{--                    </div>--}}
{{--                    <div class="col-9">--}}
{{--                        <input type="text" name="other_material_head" value="{{ old('other_material_head', $projectWiseMaterialPrice?->boqMaterialPriceWastage?->other_material_head ?? '') }}" class="form-control other_material_head" placeholder="Other Material Head">--}}
{{--                    </div>--}}

                    <div class="col-md-12">
                        <table class="table table-bordered" id="calculation_table">
                            <thead>
                                <tr>
                                    <th> Material <span class="text-danger">*</span></th>
                                    <th> Price <span class="text-danger">*</span></th>
                                </tr>
                            </thead>
                            <tbody>
                            @if($projectWiseMaterialPrice?->boqMaterialPriceWastage?->is_other_cost == 0)
                                <tr>
                                    <td>
                                        <select class="form-control nested_material_id select2" name="nested_material_id" required>
                                            <option value="">Select Work</option>
                                            @foreach ($nested_materials as $single_material)
                                                <option value="{{ $single_material->id }}" @if ($single_material->id == old('nested_material_id', $projectWiseMaterialPrice->nested_material_id ?? -1)) selected @endif>{{ $single_material->name }}</option>
                                                @if (count($single_material->children) > 0)
                                                    @include('boq.departments.civil.configurations.projectwisematerialprice.submaterial', ['nested_materials' => $single_material->children, 'prefix' => '-'])
                                                @endif
                                            @endforeach
                                        </select>
                                    </td>
                                    <td> <input type="text" name="rate" class="form-control price" required value="{{ old('price', $projectWiseMaterialPrice->rate ?? '') }}" placeholder="Material Price"> </td>
                                </tr>
                            @endif
                            </tbody>
                            <tfoot>
                                <tr>

                                </tr>
                                <input type="hidden" name="project_id" value="{{ $project->id }}">
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
        $('input[type="checkbox"]').click(function(){
            if($(this).val() == 0){
                $(this).val(1);
                $('.other_material_head').css('display','block');
            }else{
                $(this).val(0);
                $('.other_material_head').css('display','none');
            }
        });
        /* Appends calculation row */
        function appendCalculationRow() {
            let row = `
                <tr>
                    <td>
                        <select class="form-control nested_material_id select2" name="nested_material_id" required>
                             <option value="">Select Work</option>
                                @foreach ($nested_materials as $single_material)
                                    <option value="{{ $single_material->id }}" @if ($single_material->id == old('nested_material_id', $projectWiseMaterialPrice->nested_material_id ?? -1)) selected @endif>{{ $single_material->name }}</option>
                                    @if (count($single_material->children) > 0)
                                        @include('boq.departments.civil.configurations.projectwisematerialprice.submaterial', ['nested_materials' => $single_material->children, 'prefix' => '-'])
                                    @endif
                                @endforeach
                        </select>
                    </td>
                    <td> <input type="text" name="rate" class="form-control price" required value="{{ old('price', $projectWiseMaterialPrice->rate ?? '') }}" placeholder="Material Price"> </td>
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
            //materialPriceWastage
            const IS_OTHER_COST = {{ $projectWiseMaterialPrice?->boqMaterialPriceWastage?->is_other_cost }};

            if(IS_OTHER_COST == 0){
                $('.is_other_cost').val(0);
                $('input[type="checkbox"]').attr('checked', 'checked');
                $('.other_material_head').css('display','none');
            }else{
                $('.is_other_cost').val(1);
                $('input[type="checkbox"]').attr('checked', '');
                $('.other_material_head').css('display','block');
            }
        });
    </script>
@endsection
