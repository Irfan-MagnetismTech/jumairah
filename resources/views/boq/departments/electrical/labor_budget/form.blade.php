
@csrf
<div class="row">
    <div class="col-md-1"></div>
    <div class="col-12">
        <div class="card">
            <div class="tableHeading">
                <h5> <span>&#10070;</span>EME Labor Head<span>&#10070;</span> </h5>
                <input type="hidden" name="project_id" value="{{ $project->id }}">
                <input type="hidden" name="id" value="{{ isset($BoqEmeDatas) ? $BoqEmeDatas->id :null }}">
            </div>
            @php
                $EmeLaborBudget1 = $EmeLaborBudget->boqEmeRate->parent_id_second ?? '';
            @endphp
            <div class="card-body">
                <div class="row">
                    <!-- Select work -->
                    <div class="col-xl-12 col-md-12">
                        <div class="input-group input-group-sm input-group-primary">
                            <label class="input-group-addon" for="work_id">Select Item<span class="text-danger">*</span></label>
                            <select class="form-control item_id" id="item_id" name="item_id" required>
                                <option value="">Select Work Head</option>
                                @foreach ($parentWorks as $parentWork)
                                <option value="{{ $parentWork->parent_id_second }}" @if ($EmeLaborBudget1 == $parentWork->parent_id_second) selected @endif>{{ $parentWork->emeWork->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
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
                <h5> <span>&#10070;</span>Labor Budget Calculation<span>&#10070;</span><span class="work_unit"></span> </h5>
            </div>
            <div class="card-body">
                <!-- Calculations -->
                <div class="row">
                    <div class="col-md-12" style="overflow-x: scroll">
                        <table class="table table-bordered" id="calculation_table">
                            <thead>
                                <tr class="electrical_calc_head"  height="35px">
                                    <th> Work Item <span class="text-danger">*</span></th>
                                    <th> Unit <span class="text-danger">*</span></th>
                                    <th> Quantity <span class="text-danger">*</span></th>
                                    <th> Labor Rate <span class="text-danger">*</span></th>
                                    <th> Total Amount <span class="text-danger">*</span></th>
                                    <th class="remarks_th"> Remarks </th>
                                    @if ($formType == 'create')
                                        <th><i class="btn btn-primary btn-sm fa fa-plus add-calculation-row"></i></th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                 @if(old('boq_eme_rate_id'))
                                    @foreach(old('boq_eme_rate_id') as $key=>$oldWorkName)
                                    <tr>
                                        <td>
                                            <input type="hidden" name="boq_eme_rate_id[]" value="{{old('boq_eme_rate_id')[$key]}}" id="boq_eme_rate_id" required>
                                            <input type="text" name="work_name[]" value="{{old('work_name')[$key]}}" class="form-control form-control-sm work_name" autocomplete="off" required>
                                        </td>
                                        <td><input type="text" name="unit_id[]" value="{{old('unit_id')[$key]}}" class="form-control form-control-sm unit_id" readonly tabindex="-1"></td>
                                        <td><input type="number" name="quantity[]" value="{{old('quantity')[$key]}}" class="form-control form-control-sm  text-center quantity" step="0.01" placeholder="0.00" autocomplete="off" required></td>
                                        <td><input type="number" name="labor_rate[]" value="{{old('labor_rate')[$key]}}" class="form-control form-control-sm  text-center labor_rate" step="0.01" placeholder="0.00" autocomplete="off" required></td>
                                        <td><input type="number" name="total_labor_amount[]" value="{{old('total_labor_amount')[$key]}}" class="form-control form-control-sm  text-center total_labor_amount" readonly step="0.01" placeholder="0.00" autocomplete="off" required></td>
                                        <td><input type="text" name="remarks[]" value="{{old('remarks')[$key]}}" class="form-control form-control-sm  text-center remarks" placeholder="Remarks" autocomplete="off"></td>
                                        @if ($formType == 'create')
                                            <td><i class="btn btn-danger btn-sm fa fa-minus remove-calculation-row"></i></td>
                                        @endif
                                    </tr>
                                @endforeach
                            @else
                                @if(!empty($EmeLaborBudget))
                                    <tr>
                                        <td>
                                            <input type="hidden" name="boq_eme_rate_id[]" value="{{$EmeLaborBudget->boq_eme_rate_id }}" id="boq_eme_rate_id" required>
                                            <input type="text" name="work_name[]" value="{{$EmeLaborBudget->boqEmeRate->boq_work_name }}" class="form-control form-control-sm work_name" autocomplete="off" required>
                                        </td>
                                        <td><input type="text" name="unit_id[]" value="{{$EmeLaborBudget->boqEmeRate->laborUnit->name }}" class="form-control form-control-sm unit_id" readonly tabindex="-1"></td>
                                        <td><input type="number" name="quantity[]" value="{{$EmeLaborBudget->quantity }}" class="form-control form-control-sm  text-center quantity" step="0.01" placeholder="0.00" autocomplete="off" required></td>
                                        <td><input type="number" name="labor_rate[]" value="{{$EmeLaborBudget->labor_rate}}" class="form-control form-control-sm  text-center labor_rate" step="0.01" placeholder="0.00" autocomplete="off" required tabindex="-1"></td>
                                        <td><input type="number" name="total_labor_amount[]" value="{{$EmeLaborBudget->total_labor_amount}}" class="form-control form-control-sm  text-center total_labor_amount" readonly step="0.01" placeholder="0.00" autocomplete="off" required tabindex="-1"></td>
                                        <td><input type="text" name="remarks[]" value="{{$EmeLaborBudget->remarks }}" class="form-control form-control-sm  text-center remarks" placeholder="Remarks" autocomplete="off"></td>
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
                        <input type="hidden" name="boq_eme_rate_id[]" value="" class="boq_eme_rate_id" id="boq_eme_rate_id" required>
                        <input type="text" name="work_name[]" class="form-control form-control-sm work_name text-center" autocomplete="off" required>
                    </td>
                    <td> <input type="text" name="unit_id[]" class="form-control unit_id text-center" required placeholder="Unit" readonly tabindex="-1"> </td>
                    <td> <input type="number" name="quantity[]" class="form-control quantity text-center" id="quantity" required placeholder="Quantity"> </td>
                    <td> <input type="number" name="labor_rate[]" class="form-control labor_rate text-center" id="labor_rate" required placeholder="Labor Rate" tabindex="-1"> </td>
                    <td> <input type="number" name="total_labor_amount[]" class="form-control total_labor_amount text-center" id="total_labor_amount" required placeholder="Total amount" readonly tabindex="-1"> </td>
                    <td> <input type="text" name="remarks[]" class="form-control remarks text-center" placeholder="Remarks"> </td>
                    <td> <i class="btn btn-danger btn-sm fa fa-minus remove-calculation-row"></i> </td>
                </tr>
            `;
            var tableItem = $('#calculation_table tbody').append(Row);
        }

        var CSRF_TOKEN = "{{csrf_token()}}";
        $(function() {
            @if($formType == 'create' && !old('work_name'))
            appendCalculationRow();
            @endif

            $(document).on('keyup','.quantity, .labor_rate',function(){
                RateCalculations($(this));
            });

            function RateCalculations(thisVal){
                if(thisVal.closest('tr').find('#boq_eme_rate_id').val()){
                    let quantity = $(thisVal).closest('tr').find('.quantity').val() > 0 ? parseFloat($(thisVal).closest('tr').find(
                    '.quantity').val()) : 0;
                    let labor_rate = $(thisVal).closest('tr').find('.labor_rate').val() > 0 ? parseFloat($(thisVal).closest(
                    'tr').find('.labor_rate').val()) : 0;
                    let total_labor_amount = quantity * labor_rate;
                    $(thisVal).closest('tr').find('.total_labor_amount').val(total_labor_amount);
                }else{
                    alert("Search Work First");
                    $(thisVal).closest('tr').remove();
                }
            }

            $("#calculation_table").on('click', '.add-calculation-row', function(){
                appendCalculationRow();
            }).on('click', '.remove-calculation-row', function(){
                $(this).closest('tr').remove();
            });
                // function for searching eme works
                $(document).on('keyup','.work_name',function(events){
                    let item_id = $("#item_id").val();

                    $(this).autocomplete({
                    source: function(request, response) {
                        $.ajax({
                            url: "{{ route('scj.getEmeWorks') }}",
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
                            $(this).closest('tr').find('.work_name').val(ui.item.label);
                            $(this).closest('tr').find('.unit_id').val(ui.item.unit_name);
                            $(this).closest('tr').find('.labor_rate').val(ui.item.labour_rate);
                            return false;
                        }
                    });
                });
         });


    </script>
@endsection
