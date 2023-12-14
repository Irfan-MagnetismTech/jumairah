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
                    <div class="col-3">
                        <input type="checkbox" name="is_other_cost" value="{{ old('is_other_cost', $materialPriceWastage->is_other_cost ?? '') }}" {{($materialPriceWastage->is_other_cost) ? 'checked' : ''}} disabled> is Consumable Material
                        <input type="hidden" name="is_other_cost" value="{{($materialPriceWastage->is_other_cost) ? $materialPriceWastage->is_other_cost : ''}}">
                    </div>
                    <div class="col-9">
{{--                        <input type="text" name="other_material_head" value="{{ old('other_material_head', $materialPriceWastage->other_material_head ?? '') }}" class="form-control other_material_head" placeholder="Other Material Head">--}}
                        <select class="form-control other_material_head select2" id="other_material_head" name="other_material_head" disabled>
                            <option value="" selected disabled>Select Head</option>
                            <option value="Construction equipment (Re-useable)" @if($materialPriceWastage->other_material_head === 'Construction equipment (Re-useable)') selected @endif>Construction equipment (Re-useable)</option>
                            <option value="Consumable materials" @if($materialPriceWastage->other_material_head === 'Consumable materials') selected @endif>Consumable materials</option>
                            <option value="Other Related Work" @if($materialPriceWastage->other_material_head === 'Other Related Work') selected @endif>Other Related Work</option>
                            <option value="Safety staging & Canopy materials" @if($materialPriceWastage->other_material_head === 'Safety staging & Canopy materials') selected @endif>Safety staging & Canopy materials</option>
                            <option value="Steel shuttering materials (Re-useable)" @if($materialPriceWastage->other_material_head === 'Steel shuttering materials (Re-useable)') selected @endif>Steel shuttering materials (Re-useable)</option>
{{--                            @foreach ($consumable_cost_heads as $head)--}}
{{--                                <option value="{{ $head->other_material_head }}" @if($materialPriceWastage->other_material_head === $head->other_material_head) selected @endif>{{ $head->other_material_head }}</option>--}}
{{--                            @endforeach--}}
                        </select>
                        @if (isset($materialPriceWastage))
                            <input type="hidden" class="form-control other_material_head" id="other_material_head" name="other_material_head" value="{{ $materialPriceWastage->other_material_head }}">
                        @endif
                    </div>

                    <div class="col-md-12 mt-3">
                        <table class="table table-bordered" id="calculation_table">
                            <thead>
                                <tr>
                                    <th> Material <span class="text-danger">*</span></th>
                                    <th> Price <span class="text-danger">*</span></th>
                                </tr>
                            </thead>
                            <tbody>
                            @if($materialPriceWastage?->is_other_cost == 0)
                                <tr>
                                    <td><input type="hidden" name="nested_material_id" class="form-control nested_material_id" value="{{ $materialPriceWastage->nested_material_id }}"> {{ $materialPriceWastage->nestedMaterial->name }}</td>
                                    <td> <input type="text" name="price" class="form-control price" required value="{{ old('price', $materialPriceWastage->price ?? '') }}" placeholder="Material Price"> </td>
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
                    <td><input type="hidden" name="nested_material_id" class="form-control nested_material_id" value="{{ $materialPriceWastage->nested_material_id }}"> {{ $materialPriceWastage->nestedMaterial->name }}</td>
                    <td> <input type="text" name="price" class="form-control price" required value="{{ old('price', $materialPriceWastage->price ?? '') }}" placeholder="Material Price"> </td>
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
            const IS_OTHER_COST = {{ $materialPriceWastage?->is_other_cost }};

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
