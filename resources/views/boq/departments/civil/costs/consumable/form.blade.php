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
                    <div class="col-xl-12 col-md-12">
                        <div class="input-group input-group-sm input-group-primary">
                            <label class="input-group-addon" for="work_id">Select Head<span class="text-danger">*</span></label>
                            <select class="form-control other_material_head select2" id="other_material_head" name="cost_head" required>
                                <option value="" selected disabled>Select Head</option>
                                @foreach ($consumable_cost_heads as $head)
                                    <option value="{{ $head->other_material_head }}" @if(isset($selectedHead) && $selectedHead === "$head->other_material_head") selected @endif>{{ $head->other_material_head }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <input type="hidden" name="selected_head" value="@if(isset($selectedHead)) {{ $selectedHead }}  @endif">
                    <div class="col-md-1">
                        <svg id="calculation-loader" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--eos-icons" width="32" height="20" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
                            <path fill="currentColor" d="M12 2A10 10 0 1 0 22 12A10 10 0 0 0 12 2Zm0 18a8 8 0 1 1 8-8A8 8 0 0 1 12 20Z" opacity=".5"></path>
                            <path fill="currentColor" d="M20 12h2A10 10 0 0 0 12 2V4A8 8 0 0 1 20 12Z">
                                <animateTransform attributeName="transform" dur="1s" from="0 12 12" repeatCount="indefinite" to="360 12 12" type="rotate"></animateTransform>
                            </path>
                        </svg>
                    </div>

                    <div class="col-md-12 mt-3">
                        <table class="table table-bordered" id="calculation_table">
                            <thead>
                                <tr>
                                    <th> SL </th>
                                    <th> Material <span class="text-danger">*</span></th>
                                    <th> Unit <span class="text-danger">*</span></th>
                                    <th> Quantity <span class="text-danger">*</span></th>
                                    <th> Rate/Unit <span class="text-danger">*</span></th>
                                    <th> Amount <span class="text-danger">*</span></th>
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
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
        const PROJECT = @json($project->id);
        const SELECTED_HEAD = "{{ $selectedHead ?? '' }}";
        const CALCULATION_LOADER = $('#calculation-loader');
        const BOQ_CONSUMABLE_COST_URL = "{{ route('boq.project.departments.civil.get-consumable-material-by-head', $project) }}";
        const BOQ_CONSUMABLE_MATERIAL_DATA_URL = "{{ route('boq.project.departments.civil.get-consumable-material-by-id', $project) }}";


        $(".other_material_head").on("change", function() {
            getConsumableMaterialList($(this).val());
        });


        async function getConsumableMaterialList(formData) {
            CALCULATION_LOADER.show();
            let response = await axios.post(BOQ_CONSUMABLE_COST_URL, {
                _token: "{{ csrf_token() }}",
                other_material_head: formData,
            });
            consumableMaterials = await response.data;
            CALCULATION_LOADER.hide();
            listOfConsumableMaterial(consumableMaterials);
        }

        function listOfConsumableMaterial(consumableMaterials){
            let list = "";
            $.each(consumableMaterials, function(index, item) {
                if(item.nested_material_id){
                    list +=`
                <tr>
                <td>
                ${index + 1}
                </td>
                    <td width="30%">
                        <select class="form-control nested_material_id select2" name="nested_material_id[]" required>
                             <option value="">Select Material</option>
                             @foreach ($nested_materials as $nested_material)
                             <option value="{{ $nested_material->id }}" ${(item.nested_material_id == {{$nested_material->id}}) ? "selected" : ""}>{{ $nested_material->name }}</option>
                             @endforeach
{{--                             @foreach ($nested_materials as $id => $name)--}}
{{--                    <option value="{{ $id }}" ${(item.nested_material_id == {{$id}}) ? "selected" : ""}>{{ $name }}</option>--}}
{{--                             @endforeach--}}
                    </select>
                </td>
                <td width="10%"> <input type="text" name="unit[]" value="${item?.unit}" class="form-control unit" readonly placeholder="Unit"> </td>
                <td width="20%"> <input type="text" name="quantity[]" value="${item?.other_civil_budget?.total_quantity ? item?.other_civil_budget?.total_quantity : 0}" class="form-control quantity" required placeholder="Quantity"> </td>
                <td width="20%"> <input type="text" name="rate[]" value="${item?.price}" class="form-control rate" placeholder="Rate"> </td>
                <td width="20%"> <input type="text" name="amount[]" value="${item?.other_civil_budget?.total_amount ? item?.other_civil_budget?.total_amount : 0}" class="form-control amount" readonly placeholder="Amount"> </td>
                <td> <i class="btn btn-danger btn-sm fa fa-minus remove-calculation-row"></i> </td>
                </tr>`;
                }
            });
            $('#calculation_table tbody').html(list);
            $('.select2').select2();
        }

        /* Appends calculation row */
        function appendCalculationRow() {
            let row = `
                <tr>
                 <td>1</td>
                    <td width="30%">
                        <select class="form-control nested_material_id select2" name="nested_material_id[]" required>
                             <option value="">Select Material</option>
                             @foreach ($nested_materials as $nested_material)
                                 <option value="{{ $nested_material->id }}">
                                     {{ $nested_material->name }}
                                 </option>
                             @endforeach
                        </select>
                    </td>
<td width="10%"> <input type="text" name="unit[]" value="" class="form-control unit" readonly placeholder="Unit"> </td>
<td width="20%"> <input type="text" name="quantity[]" value="" class="form-control quantity" required placeholder="Quantity"> </td>
<td width="20%"> <input type="text" name="rate[]" value="" class="form-control rate" placeholder="Rate"> </td>
<td width="20%"> <input type="text" name="amount[]" class="form-control amount" readonly placeholder="Amount"> </td>
<td> <i class="btn btn-danger btn-sm fa fa-minus remove-calculation-row"></i> </td>
                </tr>
            `;
            $('#calculation_table tbody').append(row);
            $('.select2').select2();
        }

        function calculateAmount(element){
            let rate = ($(element).closest('tr').find('.rate').val()) ? $(element).closest('tr').find('.rate').val() : 1;
            let quantity = ($(element).closest('tr').find('.quantity').val()) ? $(element).closest('tr').find('.quantity').val() : 1;
            $(element).closest('tr').find('.amount').val(quantity * rate);
        }

        async function getConsumableMaterialDataById(materialId,element){
            let response = await axios.post(BOQ_CONSUMABLE_MATERIAL_DATA_URL, {
                _token: "{{ csrf_token() }}",
                nested_material_id: materialId,
            });
            materialData = await response.data;
            updateMaterialData(materialData,element);
        }

        function updateMaterialData(materialData,element){
            $(element).closest('tr').find('.unit').val(materialData?.material?.unit?.name);
            $(element).closest('tr').find('.rate').val(materialData?.price);
            calculateAmount(element);
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
            $('.select2').select2();
            CALCULATION_LOADER.hide();

            $(document).on("change",'.nested_material_id', function() {
                getConsumableMaterialDataById($(this).val(),this);
            });

            $(document).on("keyup change",'.quantity, .rate', function() {
                calculateAmount(this);
            });

            $(document).ready(function() {
                //if SELECTED_HEAD is not empty then get the list of materials
                if(SELECTED_HEAD !== ""){
                    getConsumableMaterialList(SELECTED_HEAD);
                }
            });
        });
    </script>
@endsection
