@csrf

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
                    <div class="col-3">
                        <input type="checkbox" name="is_other_cost" value="0"> is Related Material
                    </div>
                    <div class="col-9">
                        <input type="text" name="other_material_head" class="form-control other_material_head" placeholder="Other Material Head">
                    </div>

                    <div class="col-md-12 mt-3">
                        <table class="table table-bordered" id="calculation_table">
                            <thead>
                                <tr>
                                    <th width="60%"> Material <span class="text-danger">*</span></th>
                                    <th width="20%"> Material Price <span class="text-danger">*</span></th>
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
                    <td width="70%">
                        <select class="form-control nested_material_id select2" name="nested_material_id[]" required>
                             <option value="">Select Material</option>
                                @foreach ($nested_materials as $single_material)
                                    <option value="{{ $single_material->id }}" @if ($single_material->id == old('nested_material_id', $materialFormula->nested_material_id ?? -1)) selected @endif>{{ $single_material->name }}</option>
                                    @if (count($single_material->children) > 0)
                                        @include('boq.departments.civil.configurations.materialpricewastage.submaterial', ['nested_materials' => $single_material->children, 'prefix' => '-'])
                                    @endif
                                @endforeach
                        </select>
                    </td>
                    <td width="30%"> <input type="text" name="price[]" class="form-control price" required placeholder="Material Price"> </td>
                    <td> <i class="btn btn-danger btn-sm fa fa-minus remove-calculation-row"></i> </td>
                </tr>
            `;

            $('#calculation_table tbody').append(row);
        }

        /* Adds and removes calculation row on click */
        $("#calculation_table")
            .on('click', '.add-calculation-row', () => {
                appendCalculationRow();
                $('.select2').select2();

            })
            .on('click', '.remove-calculation-row', function() {
                $(this).closest('tr').remove();
            });

        /* The document function */
        $(function() {
            appendCalculationRow();
        });

        $(document).ready(function() {
            $('.select2').select2();
            $('.other_material_head').css('display','none');
        });
    </script>
@endsection
