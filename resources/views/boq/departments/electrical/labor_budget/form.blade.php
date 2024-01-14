
@csrf

<div class="labor_rate"  >
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <div class="card">
                <div class="tableHeading">
                    <h5> <span>&#10070;</span>EME Labor Budget<span>&#10070;</span> </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Select work -->
                        <div class="col-md-12 col-xl-12">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="work_parent_id">Parent Work<span class="text-danger">*</span></label>
                                <select name="work_parent_id" class="form-control work_parent_id" id="work_parent_id">
                                    @foreach($parentWorks as $parentWork)
                                        <option value="{{ $parentWork->id }}"
                                            {{ old('work_parent_id') ? (old('work_parent_id') == $parentWork->id ? 'selected' : '') : (!empty($laborBudget) && $laborBudget->boq_eme_rate_id->parent_id_second == $parentWork->id ? 'selected' : '') }}>
                                            {{ $parentWork->name }}
                                        </option>
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
        <div class="col-md-1">
        </div>
    </div>

    <hr>
    <!-- Calculation -->
    <div class="row mt-1">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <div class="card">
                <div class="tableHeading">
                    <h5> <span>&#10070;</span>EME Work Rate<span>&#10070;</span><span class="work_unit"></span> </h5>
                </div>
                <div class="card-body">
                    <!-- Calculations -->
                    <div class="mt-1 row">
                        <div class="col-md-12">
                            <table class="table table-bordered" id="calculation_table">
                                <thead>
                                    <tr class="electrical_calc_head">
                                        <th>Work Name <span class="text-danger">*</span></th>
                                        <th>Labor Unit</th>
                                        <th class="labour_rate_th"> Labor Rate</th>
                                        @if ($formType == 'create')
                                            <th><i class="btn btn-primary btn-sm fa fa-plus add-calculation-row"></i></th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($formType == 'edit' && !($laborBudget->type))
                                            <tr>
                                                <tr>
                                                    <td>
                                                        <input type="text" name="work_id[]" value="{{ $laborBudget->boq_eme_rate_id->boq_work_name }}" class="form-control text-center form-control-sm work_id" autocomplete="off" placeholder="Work Name" tabindex="-1" required>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="labor_unit[]" value="{{ $laborBudget->boq_eme_rate_id->labor_unit }}" class="form-control text-center form-control-sm labor_unit" autocomplete="off" placeholder="Labor Unit" tabindex="-1" readonly>
                                                    </td>
                                                    <td> <input type="number" name="labor_rate[]" class="form-control text-center rate" value="{{ $laborBudget->rate }}" placeholder="Labor Rate"> </td>
                                                    @if ($formType == 'create')
                                                    <td> <i class="btn btn-danger btn-sm fa fa-minus remove-calculation-row"></i> </td>
                                                    @endif
                                                </tr>
                                            </tr>
                                    @endif
                                </tbody>
                                <tfoot>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-1"></div>
    </div>
</div>

@section('script')
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
        const CSRF_TOKEN = "{{ csrf_token() }}";
        $(function() {
            $('.work_parent_id').on('change', function(){
                var work_parent_id = $(this).val();
                $.ajax({
                    url: "{{ url('scj/getEmeWorks') }}",
                    type: 'GET',
                    data: {'work_parent_id': work_parent_id},
                    success: function(data){
                        $('.work_id').data('work_id', data);
                    },
                    error: function(error) {
                        console.error('Error fetching EME works:', error);
                    }
                });
            });
        })

        function appendCalculationRow(work_id) {
            let row = `
                <tr>
                    <td>
                        <input type="text" name="work_id[]" class="form-control text-center form-control-sm work_id" autocomplete="off" placeholder="Work Name" tabindex="-1">
                    </td>
                    <td>
                        <input type="text" name="labor_unit[]" class="form-control text-center form-control-sm labor_unit" autocomplete="off" placeholder="Labor Unit" tabindex="-1" readonly>
                    </td>
                    <td> <input type="number" name="labor_rate[]" class="form-control text-center labor_rate" placeholder="Labor Rate"> </td>
                    <td> <i class="btn btn-danger btn-sm fa fa-minus remove-calculation-row"></i> </td>
                </tr>
                `;
            $('#calculation_table tbody').append(row);
        }

        // function for searching third layer material
                $(document).on('keyup','.work_id',function(events){
                    let work_parent_id = $(".work_parent_id option:selected").val();
                    $(this).autocomplete({
                        source: function(request, response) {
                            $.ajax({
                                url: "{{ url('scj/getLaborWorks') }}",
                                type: 'post',
                                dataType: "json",
                                data: {
                                    _token: CSRF_TOKEN,
                                    search: request.term,
                                    work_parent_id: work_parent_id
                                },
                                success: function( data ) {
                                    console.log(data);
                                    response( data );
                                }
                            });
                        },
                        select: function(event, ui) {
                            $(this).closest('tr').find('.work_id').val(ui.item.label);
                            $(this).closest('tr').find('.labor_unit').val(ui.item.unit_name);
                            return false;
                        }
                    });
                });

                $(document).ready(function() {
                    $('#parent_id_second').on('change', function() {
                        $('.material_name').val('');
                    });
                });

        /* Adds and removes calculation row on click */
        $("#calculation_table")
            .on('click', '.add-calculation-row', () => appendCalculationRow())
            .on('click', '.remove-calculation-row', function() {
                $(this).closest('tr').remove();
            });

        /* The document function */
        @if ($formType == "create")
        $(function() {
            appendCalculationRow();
        });
        @endif
    </script>
@endsection
