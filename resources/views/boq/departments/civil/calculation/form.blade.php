@csrf
<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-10">
        <div class="card">
            <div class="tableHeading">
                <h5> <span>&#10070;</span>Area & Work type<span>&#10070;</span> </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-12 col-md-12" style="margin-bottom: 10px">
                        <div class="input-group input-group-sm input-group-primary">
                            <label class="input-group-addon" for="work_id">Select Work<span class="text-danger">*</span></label>
                            <select class="form-control work_id" id="work_id" name="work_id" required>
                                <option value="">Select Work</option>
                                @foreach ($boq_works as $work)
                                    <option value="{{ $work->id }}">{{ $work->name }}</option>
                                    @if (count($work->children) > 0)
                                        @include('boq.departments.civil.calculation.subwork', ['boq_works' => $work->children, 'prefix' => '-'])
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <input type="hidden" name="calculation_type" value="{{ $calculation_type }}">
                    <!-- Select work -->
                    <div class="col-xl-12 col-md-12">
                        <div class="input-group input-group-sm input-group-primary">
                            <label class="input-group-addon" for="boq_floor_id">Select Area <span class="text-danger">*</span></label>
                            <select class="form-control" id="boq_floor_id" name="boq_floor_id" required>
                                <option value="">Select Area</option>
                                @foreach ($boq_floors as $boq_floor)
                                    <option value="{{ $boq_floor->boq_floor_project_id }}">{{ $boq_floor->boqCommonFloor->name ?? '' }}</option>
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
    <div class="col-md-1"></div>
</div>

{{-- <div class="mt-2 row reinforceMeasurement" style="display: none"> --}}
{{-- <div class="col-md-1"></div> --}}
{{-- <div class="col-md-10"> --}}
{{-- <div class="card"> --}}
{{-- <div class="tableHeading"> --}}
{{-- <h5>UNIT WEIGHT OF BARS</h5> --}}
{{-- </div> --}}
{{-- <div class="card-body"> --}}
{{-- <div class="row"> --}}
{{-- <div class="col-md-12"> --}}
{{-- <table class="table table-bordered"> --}}
{{-- <thead> --}}
{{-- <tr> --}}
{{-- <th>Dia</th> --}}
{{-- <th>Unit Weight</th> --}}
{{-- </tr> --}}
{{-- </thead> --}}
{{-- <tbody> --}}
{{-- @foreach ($boq_reinforcement_measurements as $boq_reinforcement_measurement) --}}
{{-- <tr> --}}
{{-- <td>{{ $boq_reinforcement_measurement->dia }} mm</td> --}}
{{-- <td> --}}
{{-- {{ $boq_reinforcement_measurement->weight }} --}}
{{-- {{ $boq_reinforcement_measurement->unit }}/rft --}}
{{-- </td> --}}
{{-- </tr> --}}
{{-- @endforeach --}}
{{-- </tbody> --}}
{{-- </table> --}}
{{-- </div> --}}
{{-- </div> --}}
{{-- </div> --}}
{{-- </div> --}}
{{-- </div> --}}
{{-- <div class="col-md-1"></div> --}}
{{-- </div> --}}
<!-- Calculation -->
<div class="mt-4 row">
    <div class="col-md-1"></div>
    <div class="col-md-10">
        <div class="card">
            <div class="tableHeading">
                <h5> <span>&#10070;</span>{{ $calculation_type ?? '' }} Calculations<span>&#10070;</span><span class="work_unit"></span> </h5>
            </div>
            <div class="card-body">
                <!-- Group name -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="input-group input-group-sm input-group-primary">
                            <label class="input-group-addon" for="work_id">Group name</label>
                            <input type="text" name="name" class="form-control" placeholder="Leave it empty if you don't want to make a group">
                        </div>
                    </div>
                </div>

                <!-- Calculations -->
                <div class="mt-4 row">
                    <div class="col-md-12">
                        <table class="table table-bordered" id="calculation_table">
                            <thead>
                                <tr>
                                    <th> Sub-location </th>
                                    <th class="calc_no_or_dia"> No <span class="text-danger">*</span></th>
                                    <th class="calc_length"> Length </th>
                                    <th class="calc_breadth_member"> Breadth</th>
                                    <th class="calc_height_bar"> Height </th>
                                    <th> Sub-total </th>
                                    <th><i class="btn btn-primary btn-sm fa fa-plus add-calculation-row" id="calc_add_btn"></i></th>
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
        let measurementKeys = @json($measurement_keys);
        let is_reinforcement = @json($is_reinforcement);

        /* Appends calculation row */
        function appendNormalCalculationRow() {
            let row = `
                <tr>
                    <td> <input type="text" name="sub_location_name[]" class="form-control sub_location" placeholder="Sub-location"> </td>
                    <td> <input type="number" name="no_or_dia[]" class="form-control no" required max="100000000" step="0.01" placeholder="Enter no"> </td>
                    <td> <input type="number" name="length[]" class="form-control length" max="100000000" step="0.01" placeholder="Enter length"> </td>
                    <td> <input type="number" name="breadth_or_member[]" class="form-control breadth" max="100000000" step="0.01" placeholder="Enter breadth"> </td>
                    <td> <input type="number" name="height_or_bar[]" class="form-control height" max="100000000" step="0.01" placeholder="Enter height"> </td>
                    <td> <div class="form-control text-right sub_total" readonly>0.00</div> </td>
                    <td> <i class="btn btn-danger btn-sm fa fa-minus remove-calculation-row"></i> </td>
                </tr>
            `;

            $('#calculation_table tbody').append(row);
        }

        function appendReinforcementCalculationRow() {
            let diaDropdown = `
                <select name="boq_reinforcement_measurement_id[]" class="form-control boq_reinforcement_measurement_id" required>
                    <option value="">Select dia</option>
                    @foreach ($boq_reinforcement_measurements as $boq_reinforcement_measurement)
                        <option value="{{ $boq_reinforcement_measurement->id }}">{{ $boq_reinforcement_measurement->dia }} mm</option>
                    @endforeach
            </select>`;

            let row = `
                <tr>
                    <td> <input type="text" name="sub_location_name[]" class="form-control sub_location" placeholder="Sub-location"> </td>
                    <td width="15%">
                        ${diaDropdown}
                        <input type="hidden" name="no_or_dia[]" class="form-control no" max="100000000" step="0.01" placeholder="Enter no">
                    </td>
                    <td> <input type="number" name="length[]" class="form-control length" max="100000000" step="0.01" placeholder="Enter length"> </td>
                    <td> <input type="number" name="breadth_or_member[]" class="form-control breadth" required max="100000000" step="0.01" placeholder="No. of member"> </td>
                    <td> <input type="number" name="height_or_bar[]" class="form-control height" required max="100000000" step="0.01" placeholder="No. of bar"> </td>
                    <td> <div class="form-control text-right sub_total" readonly>0.00</div> </td>
                    <td> <i class="btn btn-danger btn-sm fa fa-minus remove-calculation-row"></i> </td>
                </tr>`;

            $('#calculation_table tbody').append(row);
        }

        /* Calculates the total */
        function calculateTotal() {
            let total = 0;
            $('#calculation_table tbody tr').each(function() {
                total += parseFloat($(this).find('.sub_total').text());
            });

            $('#total').text(parseFloat(total).toFixed(2));
            $('#final_total').val(parseFloat(total).toFixed(2));
        }

        /* Checks if an object is empty or not */
        function isObjectEmpty(obj) {
            return Object.keys(obj).length === 0;
        }

        /* Adds and removes calculation row on click */
        $("#calculation_table")
            .on('click', '.add-calculation-row', () => appendNormalCalculationRow())
            .on('click', '.remove-calculation-row', function() {
                $(this).closest('tr').remove();
                calculateTotal();
            });

        $("#calculation_table")
            .on('click', '.add-reinforcement-row', () => appendReinforcementCalculationRow())
            .on('click', '.remove-calculation-row', function() {
                $(this).closest('tr').remove();
                calculateTotal();
            });


        /* Calculates the sub-total */
        $("#calculation_table").on('keyup change', '.boq_reinforcement_measurement_id, .no, .length, .breadth, .height', function() {
            let no;

            if (is_reinforcement === 1) {
                let dia = $(this).closest('tr').find('.boq_reinforcement_measurement_id').val() ? parseFloat($(this).closest('tr').find('.boq_reinforcement_measurement_id').val()) : 0;
                no = measurementKeys[dia] ? measurementKeys[dia] : 0;
                $(this).closest('tr').find('.no').val(no);
            } else {
                no = $(this).closest('tr').find('.no').val() ? parseFloat($(this).closest('tr').find('.no').val()) : 1;
            }

            let length = $(this).closest('tr').find('.length').val() ? parseFloat($(this).closest('tr').find('.length').val()) : 1;
            let breadth = $(this).closest('tr').find('.breadth').val() ? parseFloat($(this).closest('tr').find('.breadth').val()) : 1;
            let height = $(this).closest('tr').find('.height').val() ? parseFloat($(this).closest('tr').find('.height').val()) : 1;

            let sub_total = no * length * breadth * height;
            $(this).closest('tr').find('.sub_total').text(parseFloat(sub_total).toFixed(2));

            calculateTotal();
        });

        $('.work_id').on('change', function() {
            let work_id = $(this).val();
            getWorkByWork(work_id);
        });

        function getWorkByWork(work_id) {
            $.ajax({
                url: "{{ route('boq.configurations.get_boq_work_by_work_id') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    work_id: work_id,
                },
                success: function(data) {

                    if (!isObjectEmpty(data)) {
                        $('#calculation_table tbody').html("");
                        if (data.is_reinforcement === 1) {
                            is_reinforcement = 1;
                            $('#calc_add_btn').removeClass("add-calculation-row").addClass("add-reinforcement-row");
                            $('.reinforceMeasurement').css('display', 'flex');
                            $('.calc_no_or_dia').html("Dia <span class='text-danger'>*</span>");
                            $('.calc_breadth_member').html("No. of member");
                            $('.calc_height_bar').html("No. of bar");
                            appendReinforcementCalculationRow();
                        } else {
                            is_reinforcement = 0;
                            $('#calc_add_btn').removeClass("add-reinforcement-row").addClass("add-calculation-row");
                            $('.reinforceMeasurement').css('display', 'none');
                            $('.calc_no_or_dia').html("No <span class='text-danger'>*</span>");
                            $('.calc_breadth_member').html("Breadth");
                            $('.calc_height_bar').html("Height");
                            appendNormalCalculationRow();
                        }

                    }
                }
            });
        }
        /* The document function */
        $(function() {
            appendNormalCalculationRow();
        });
    </script>
@endsection
