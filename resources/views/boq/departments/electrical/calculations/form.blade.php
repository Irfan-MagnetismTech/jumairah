
@csrf
<div class="row">
    <div class="col-md-1"></div>
    <div class="col-12">
        <div class="card">
            <div class="tableHeading">
                <h5> <span>&#10070;</span>EME Item<span>&#10070;</span> </h5>
                <input type="hidden" name="project_id" value="{{ $project->id }}">
                <input type="hidden" name="id" value="{{ isset($BoqEmeDatas) ? $BoqEmeDatas->id :null }}">
            </div>
            @php
                $BoqEmeData1 = $BoqEmeDatas->budget_head_id ?? '';
            @endphp
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-12 col-md-12">
                        <div class="input-group input-group-sm input-group-primary">
                            <label class="input-group-addon" for="work_id">Select Head<span class="text-danger">*</span></label>
                            <select class="form-control budget_head_id" id="budget_head_id" name="budget_head_id" required>
                                <option value="">Select Head</option>
                                @foreach ($EmeBudgetHeads as $EmeBudgetHead)
                                <option value="{{ $EmeBudgetHead->id }}" @if (isset($EmeBudgetHead) && !empty($EmeBudgetHead) && ($BoqEmeData1 == $EmeBudgetHead->id)) selected @endif>{{ $EmeBudgetHead->name ?? '' }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Select work -->
                    <div class="col-xl-12 col-md-12">
                        <div class="input-group input-group-sm input-group-primary">
                            <label class="input-group-addon" for="work_id">Select Item<span class="text-danger">*</span></label>
                            <select class="form-control item_id" id="item_id" name="item_id" required>
                                <option value="">Select Item</option>
                                @foreach ($boqEmeRates as $boqEmeRate)
                                <option value="{{ $boqEmeRate->parent_id_second }}" @if (isset($BoqEmeDatas) && !empty($BoqEmeDatas) && ($BoqEmeDatas->item_id==$boqEmeRate->parent_id_second)) selected @endif>{{ $boqEmeRate->NestedMaterialSecondLayer->name ?? '' }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    {{-- <input type="hidden" name="final_total" id="final_total"> --}}

                    <!-- Select sub-work -->
                    <div class="col-xl-12 col-md-12">
                        <div id="subwork"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<hr>
<!-- Calculation -->
<div class="row">
    <div class="col-md-1"></div>
    <div class="col-12">
        <div class="card">
            <div class="tableHeading">
                <h5> <span>&#10070;</span>Item Calculation<span>&#10070;</span><span class="work_unit"></span> </h5>
            </div>
            <div class="card-body">
                <!-- Calculations -->
                <div class="row">
                    <div class="col-md-12" style="overflow-x: scroll">
                        <table class="table table-bordered" id="calculation_table">
                            <thead>
                                <tr class="electrical_calc_head"  height="35px">
                                    <th> Floor</th>
                                    <th> Material <span class="text-danger">*</span></th>
                                    <th> Unit <span class="text-danger">*</span></th>
                                    <th> Quantity <span class="text-danger">*</span></th>
                                    <th class="material_rate_th"> Material Rate <span class="text-danger">*</span></th>
                                    {{-- <th class="labour_rate_th"> Labour Rate <span class="text-danger">*</span></th> --}}
                                    <th class="total_material_amount_th"> Total Amount <span class="text-danger">*</span></th>
                                    {{-- <th class="total_labour_amount_th"> Total Labour Amount</th> --}}
                                    {{-- <th class="total_amount_th"> Total Amount <span class="text-danger">*</span></th> --}}
                                    <th class="remarks_th"> Remarks </th>
                                    @if ($formType == 'create')
                                        <th><i class="btn btn-primary btn-sm fa fa-plus add-calculation-row"></i></th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @if(old('material_id'))
                                @foreach(old('material_id') as $key=>$oldMaterialName)
                                    <tr>
                                        <td>
                                            <input type="hidden" name="floor_id[]" value="{{old('floor_id')[$key]}}" class="floor_id">
                                            <input type="text" name="floor_name[]" value="{{old('floor_name')[$key]}}" class="form-control form-control-sm floor_name" autocomplete="off">
                                        </td>
                                        <td>
                                            <input type="hidden" name="material_id[]" value="{{old('material_id')[$key]}}" class="material_id" id="material_id" required>
                                            <input type="text" name="material_name[]" value="{{old('material_name')[$key]}}" class="form-control form-control-sm material_name" autocomplete="off" required>
                                        </td>
                                        <td><input type="text" name="unit_id[]" value="{{old('unit_id')[$key]}}" class="form-control form-control-sm unit" readonly tabindex="-1"></td>
                                        <td><input type="number" name="quantity[]" value="{{old('quantity')[$key]}}" class="form-control form-control-sm  text-center quantity" step="0.01" placeholder="0.00" autocomplete="off" required></td>
                                        <td><input type="number" name="material_rate[]" value="{{old('material_rate')[$key]}}" class="form-control form-control-sm  text-center material_rate" step="0.01" placeholder="0.00" autocomplete="off" required></td>
                                        {{-- <td><input type="number" name="labour_rate[]" value="{{old('labour_rate')[$key]}}" class="form-control form-control-sm  text-center labour_rate" step="0.01" placeholder="0.00" autocomplete="off" required></td> --}}
                                        <td><input type="number" name="total_material_amount[]" value="{{old('total_material_amount')[$key]}}" class="form-control form-control-sm  text-center total_material_amount" readonly step="0.01" placeholder="0.00" autocomplete="off" required></td>
                                        {{-- <td><input type="number" name="total_labour_amount[]" value="{{old('total_labour_amount')[$key]}}" class="form-control form-control-sm  text-center total_labour_amount" readonly step="0.01" placeholder="0.00" autocomplete="off" required></td> --}}
                                        {{-- <td><input type="number" name="total_amount[]" value="{{old('total_amount')[$key]}}" class="form-control form-control-sm  text-center total_amount" step="0.01" placeholder="0.00" readonly autocomplete="off" required></td> --}}
                                        <td><input type="text" name="remarks[]" value="{{old('remarks')[$key]}}" class="form-control form-control-sm  text-center remarks" placeholder="Remarks" autocomplete="off"></td>
                                        @if ($formType == 'create')
                                            <td><i class="btn btn-danger btn-sm fa fa-minus remove-calculation-row"></i></td>
                                        @endif
                                    </tr>
                                @endforeach
                            @else
                                @if(!empty($BoqEmeDatas))
                                    <tr>
                                        <td>
                                            <input type="hidden" name="floor_id[]" value="{{$BoqEmeDatas->floor_id }}" class="floor_id">
                                            <input type="text" name="floor_name[]" value="{{$BoqEmeDatas->BoqFloorProject->floor->name }}" class="form-control form-control-sm floor_name" autocomplete="off">
                                        </td>
                                        <td>
                                            <input type="hidden" name="boq_eme_rate_id[]" value="{{$BoqEmeDatas->boq_eme_rate_id }}" id="boq_eme_rate_id" required>
                                            <input type="hidden" name="material_id[]" value="{{$BoqEmeDatas->material_id }}" class="material_id" id="material_id" required>
                                            <input type="text" name="material_name[]" value="{{$BoqEmeDatas->NestedMaterial->name }}" class="form-control form-control-sm material_name" autocomplete="off" required>
                                        </td>
                                        <td><input type="text" name="unit_id[]" value="{{$BoqEmeDatas->NestedMaterial->unit->name }}" class="form-control form-control-sm unit" readonly tabindex="-1"></td>
                                        <td><input type="number" name="quantity[]" value="{{$BoqEmeDatas->quantity }}" class="form-control form-control-sm  text-center quantity" step="0.01" placeholder="0.00" autocomplete="off" required></td>
                                        <td><input type="number" name="material_rate[]" value="{{$BoqEmeDatas->material_rate}}" class="form-control form-control-sm  text-center material_rate" step="0.01" placeholder="0.00" autocomplete="off" required tabindex="-1"></td>
                                        {{-- <td><input type="number" name="labour_rate[]" value="{{$BoqEmeDatas->labour_rate }}" class="form-control form-control-sm  text-center labour_rate" step="0.01"  placeholder="0.00" autocomplete="off" required tabindex="-1"></td> --}}
                                        <td><input type="number" name="total_material_amount[]" value="{{$BoqEmeDatas->total_material_amount}}" class="form-control form-control-sm  text-center total_material_amount" readonly step="0.01" placeholder="0.00" autocomplete="off" required tabindex="-1"></td>
                                        {{-- <td><input type="number" name="total_labour_amount[]" value="{{$BoqEmeDatas->total_labour_amount}}" class="form-control form-control-sm  text-center total_labour_amount" readonly step="0.01" placeholder="0.00" autocomplete="off" required tabindex="-1"></td> --}}
                                        {{-- <td><input type="number" name="total_amount[]" value="{{$BoqEmeDatas->total_amount }}" class="form-control form-control-sm  text-center total_amount" readonly step="0.01" placeholder="0.00" autocomplete="off" required tabindex="-1"></td> --}}
                                        <td><input type="text" name="remarks[]" value="{{$BoqEmeDatas->remarks }}" class="form-control form-control-sm  text-center remarks" placeholder="Remarks" autocomplete="off"></td>
                                        {{-- @if ($formType == 'create')
                                            <td><i class="btn btn-primary btn-sm fa fa-plus add-calculation-row"></i><i class="btn btn-danger btn-sm fa fa-minus remove-calculation-row"></i></td>
                                        @endif --}}
                                    </tr>
                                @endif
                            @endif
                        </tbody>
                            </tbody>
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
        const PROJECT = @json($project->id);
        /* Appends calculation row */
        function appendCalculationRow() {
                var Row =
                `<tr>
                    <td>
                        <input type="hidden" name="floor_id[]" value="" class="floor_id" required>
                        <input type="text" name="floor_name[]" class="form-control form-control-sm floor_name text-center" autocomplete="off">
                    </td>
                    <td>
                        <input type="hidden" name="boq_eme_rate_id[]" value="" class="boq_eme_rate_id" id="boq_eme_rate_id" required>
                        <input type="hidden" name="material_id[]" value="" class="material_id" id="material_id" required>
                        <input type="text" name="material_name[]" class="form-control form-control-sm material_name text-center" autocomplete="off" required>
                    </td>
                    <td> <input type="text" name="unit_id[]" class="form-control unit_id text-center" required placeholder="Unit" readonly tabindex="-1"> </td>
                    <td> <input type="number" name="quantity[]" class="form-control quantity text-center" id="quantity" required placeholder="Quantity"> </td>
                    <td> <input type="number" name="material_rate[]" class="form-control material_rate text-center" id="material_rate" required placeholder="Material Rate" tabindex="-1"> </td>
                    <td> <input type="number" name="total_material_amount[]" class="form-control total_material_amount text-center" id="total_material_amount" required placeholder="Total amount" readonly tabindex="-1"> </td>
                    <td> <input type="text" name="remarks[]" class="form-control remarks text-center" placeholder="Remarks"> </td>
                    <td> <i class="btn btn-danger btn-sm fa fa-minus remove-calculation-row"></i> </td>
                </tr>
            `;
            var tableItem = $('#calculation_table tbody').append(Row);
        }

        var CSRF_TOKEN = "{{csrf_token()}}";
        $(function() {
            @if($formType == 'create' && !old('material_name'))
            appendCalculationRow();
            @endif

            $(document).on('keyup','.quantity, .material_rate',function(){
                RateCalculations($(this));
            });

            function RateCalculations(thisVal){
                if(thisVal.closest('tr').find('#material_id').val()){
                    let quantity = $(thisVal).closest('tr').find('.quantity').val() > 0 ? parseFloat($(thisVal).closest('tr').find(
                    '.quantity').val()) : 0;
                    let material_rate = $(thisVal).closest('tr').find('.material_rate').val() > 0 ? parseFloat($(thisVal).closest(
                    'tr').find('.material_rate').val()) : 0;
                    // let labour_rate = $(thisVal).closest('tr').find('.labour_rate').val() > 0 ? parseFloat($(thisVal).closest('tr').find('.labour_rate').val()) : 0;
                    // let quantity        = thisVal.closest('tr').find('#quantity').val();
                    // let material_rate   = thisVal.closest('tr').find('#material_rate').val();
                    // let labour_rate     = thisVal.closest('tr').find('#labour_rate').val();
                    let total_material_amount = quantity * material_rate;
                    // let total_labor_amount = quantity * labour_rate;
                    // let total_amount = total_material_amount + total_labor_amount;

                    $(thisVal).closest('tr').find('.total_material_amount').val(total_material_amount);
                    // $(thisVal).closest('tr').find('.total_labour_amount').val(total_labor_amount);
                    // $(thisVal).closest('tr').find('.total_amount').val(total_amount);
                }else{
                    alert("Search Material First");
                    $(thisVal).closest('tr').remove();
                }

            }

            $("#calculation_table").on('click', '.add-calculation-row', function(){
                appendCalculationRow();
            }).on('click', '.remove-calculation-row', function(){
                $(this).closest('tr').remove();
            });

            $(document).on('keyup', ".floor_name", function(){

                    $(this).closest('tr').find('.floor_id').val('');
                    $(this).autocomplete({
                        source: function( request, response ) {
                            $.ajax({
                                url:"{{route('scj.floorAutoSuggest')}}",
                                type: 'post',
                                dataType: "json",
                                data: {
                                    _token: CSRF_TOKEN,
                                    search: request.term,
                                    project_id: PROJECT
                                },
                                success: function( data ) {
                                        response( data );
                                },
                            });
                        },
                        select: function (event, ui) {
                            $(this).val(ui.item.label);
                                $(this).closest('tr').find('.floor_name').val(ui.item.label);
                                $(this).closest('tr').find('.floor_id').val(ui.item.floor_id);
                        }
                    });
            });


                // function for searching third layer material
                $(document).on('keyup','.material_name',function(events){
                    let item_id = $("#item_id").val();

                    $(this).autocomplete({
                    source: function(request, response) {
                        $.ajax({
                            url: "{{ route('scj.getLayer3MaterialRateWise') }}",
                            type: 'get',
                            dataType: "json",
                            data: {
                                _token: CSRF_TOKEN,
                                search: request.term,
                                item_id: item_id
                            },
                            success: function( data ) {
                                    response( data );
                                }
                            });

                        },
                        select: function(event, ui) {
                            $(this).closest('tr').find('.boq_eme_rate_id').val(ui.item.boq_eme_rate_id);
                            $(this).closest('tr').find('.material_name').val(ui.item.label);
                            $(this).closest('tr').find('.material_id').val(ui.item.material_id);
                            $(this).closest('tr').find('.unit_id').val(ui.item.unit_name);
                            $(this).closest('tr').find('.material_rate').val(ui.item.labour_rate);
                            return false;
                        }
                    });
                });
         });


    </script>
@endsection
