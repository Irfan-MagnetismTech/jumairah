@csrf
<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <div class="card">
            <div class="tableHeading">
                <h5>UNIT WEIGHT OF BARS</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Dia</th>
                                    <th>Unit Weight</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($boq_reinforcement_measurements as $boq_reinforcement_measurement)
                                    <tr>
                                        <td>{{ $boq_reinforcement_measurement->dia }} mm</td>
                                        <td>
                                            {{ $boq_reinforcement_measurement->weight }}
                                            {{ $boq_reinforcement_measurement->unit }}/rft
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-2"></div>
</div>

<!-- Calculation -->
<div class="mt-4 row">
    <div class="col-md-1"></div>
    <div class="col-md-10">
        <div class="card">
            <div class="tableHeading">
                <h5> <span>&#10070;</span>Reinforcement<span>&#10070;</span> </h5>
            </div>
            <div class="card-body">
                <!-- Group name -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="input-group input-group-sm input-group-primary">
                            <label class="input-group-addon" for="group_name">Group name</label>
                            <input type="text" name="group_name" id="group_name" class="form-control" placeholder="Leave it empty if you don't want to make a group">
                        </div>
                    </div>
                </div>

                <!-- Calculations -->
                <div class="mt-4 row">
                    <div class="col-md-12">
                        <table class="table table-bordered" id="calculation_table">
                            <thead>
                                <tr>
                                    <th> Location </th>
                                    <th> Dia <span class="text-danger">*</span></th>
                                    <th> Length <span class="text-danger">*</span></th>
                                    <th> No. of member <span class="text-danger">*</span></th>
                                    <th> No. of bar <span class="text-danger">*</span></th>
                                    <th> Sub-total </th>
                                    <th><i class="btn btn-primary btn-sm fa fa-plus add-calculation-row"></i></th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="5" class="text-right">Total:</th>
                                    <th>
                                        <div id="total" class="form-control text-right" readonly>0.00</div>
                                    </th>
                                    <th></th>
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
        let old = @json(old());
        let boq_reinforcement_measurements = @json($boq_reinforcement_measurements);
        let measurementKeys = @json($measurement_keys);

        /* Appends calculation row */
        function appendCalculationRow() {
            let diaDropdown = `
                <select name="dia[]" class="form-control dia" required>
                    <option value="">Select dia</option>
                    @foreach ($boq_reinforcement_measurements as $boq_reinforcement_measurement)
                        <option value="{{ $boq_reinforcement_measurement->dia }}">{{ $boq_reinforcement_measurement->dia }} mm</option>
                    @endforeach
                </select>
            `;

            let row = `
                <tr>
                    <td> <input type="text" name="location_name[]" class="form-control location" placeholder="Location"> </td>
                    <td> ${diaDropdown} </td>
                    <td> <input type="number" name="length[]" class="form-control length" required min="0.01" max="100000000" step="0.01" placeholder="Length"> </td>
                    <td> <input type="number" name="member_no[]" class="form-control member_no" required min="0.01" max="100000000" step="0.01" placeholder="No. of member"> </td>
                    <td> <input type="number" name="bar_no[]" class="form-control bar_no" required min="0.01" max="100000000" step="0.01" placeholder="No. of bar"> </td>
                    <td> 
                        <div class="form-control text-right sub_total" readonly>0.00</div> 
                        <input type="hidden" id="quantity" name="quantity[]" class="quantity" value="0">
                    </td>
                    <td> <i class="btn btn-danger btn-sm fa fa-minus remove-calculation-row"></i> </td>
                </tr>
            `;

            $('#calculation_table tbody').append(row);
        }

        /* Calculates the total */
        function calculateTotal() {
            let total = 0;
            $('#calculation_table tbody tr').each(function() {
                total += parseFloat($(this).find('.sub_total').text());
            });

            $('#total').text(parseFloat(total).toFixed(2));
        }


        /* Checks if an object is empty or not */
        function isObjectEmpty(obj) {
            return Object.keys(obj).length === 0;
        }

        /* Adds and removes calculation row on click */
        $("#calculation_table")
            .on('click', '.add-calculation-row', () => appendCalculationRow())
            .on('click', '.remove-calculation-row', function() {
                $(this).closest('tr').remove();
            });

        /* Calculates the sub-total */
        $("#calculation_table").on('change', '.dia, .length, .member_no, .bar_no', function() {
            let dia = $(this).closest('tr').find('.dia').val() ? parseFloat($(this).closest('tr').find('.dia').val()) : 0;
            let length = $(this).closest('tr').find('.length').val() ? parseFloat($(this).closest('tr').find('.length').val()) : 0;
            let member_no = $(this).closest('tr').find('.member_no').val() ? parseFloat($(this).closest('tr').find('.member_no').val()) : 0;
            let bar_no = $(this).closest('tr').find('.bar_no').val() ? parseFloat($(this).closest('tr').find('.bar_no').val()) : 0;
            let weight = measurementKeys[dia] ? measurementKeys[dia] : 0;

            let sub_total = length * member_no * bar_no * weight;
            $(this).closest('tr').find('.sub_total').text(parseFloat(sub_total).toFixed(2));
            $(this).closest('tr').find('.quantity').val(parseFloat(sub_total).toFixed(2));

            calculateTotal();
        });

        /* The document function */
        $(function() {
            appendCalculationRow();
        });
    </script>
@endsection
