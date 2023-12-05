@csrf
<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-10">
        <div class="card">
            <div class="tableHeading">
                <h5> <span>&#10070;</span>Work type<span>&#10070;</span> </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Select work -->
                    <div class="col-xl-12 col-md-12">
                        <div class="input-group input-group-sm input-group-primary">
                            <label class="input-group-addon" for="work_id">Select Work<span class="text-danger">*</span></label>
                            <select class="form-control" id="work_id" name="work_id" required>
                                <option value="">Select Work</option>
                                @foreach ($boq_works as $work)
                                    <option value="{{ $work->id }}">{{ $work->name }} - {{ $work->short_name }}</option>
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

<hr>

<!-- Calculation -->
<div class="mt-4 row">
    <div class="col-md-1"></div>
    <div class="col-md-10">
        <div class="card">
            <div class="tableHeading">
                <h5> <span>&#10070;</span>Calculations<span>&#10070;</span><span class="work_unit"></span> </h5>
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
                                    <th> No <span class="text-danger">*</span></th>
                                    <th> Length <span class="text-danger">*</span></th>
                                    <th> Breadth <span class="text-danger">*</span></th>
                                    <th> Height <span class="text-danger">*</span></th>
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
        let rcc_id = @json($rcc_id);
        let old = @json(old());
        let unit = "";

        /* Appends PSI and Casting by */
        function appendRccSubworkRow() {
            let psi_row = `
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="psi">Select PSI<span class="text-danger">*</span></label>
                    <select class="form-control" id="psi" name="psi" required>
                        <option value="">Select PSI</option>
                        @for ($i = 2000; $i <= 5500; $i += 500)
                            <option value="{{ $i }}">{{ $i }} PSI</option>
                        @endfor
                    </select>
                </div>`;

            let casting_row = `
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="casting_type">Casting By<span class="text-danger">*</span></label>
                    <select class="form-control" id="casting_type" name="casting_type" required>
                        <option value="">Select Casting</option>
                        <option value="RMC">RMC</option>
                        <option value="Mixture machine">Mixture Machine</option>
                    </select>
                </div>`;

            $('#subwork').append(psi_row, casting_row);
        }

        /* Appends sub-works */
        function appendSubwork(sub_works) {
            let row = `
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="psi">Select Sub-work<span class="text-danger">*</span></label>
                    <select class="form-control" id="sub_work_id" name="sub_work_id" required>
                        <option value="">Select Sub-work</option>
                    </select>
                </div>
            `;

            $('#subwork').append(row);

            sub_works.forEach(function(item) {
                $('#sub_work_id').append(`<option value="${item.id}">${item.short_name}</option>`);
            });
        }

        /* Appends calculation row */
        function appendCalculationRow() {
            let row = `
                <tr>
                    <td> <input type="text" name="sub_location_name[]" class="form-control sub_location" placeholder="Sub-location"> </td>
                    <td> <input type="number" name="no[]" class="form-control no" required min="0.01" max="100000000" step="0.01" placeholder="No"> </td>
                    <td> <input type="number" name="length[]" class="form-control length" required min="0.01" max="100000000" step="0.01" placeholder="Length"> </td>
                    <td> <input type="number" name="breadth[]" class="form-control breadth" required min="0.01" max="100000000" step="0.01" placeholder="Breadth"> </td>
                    <td> <input type="number" name="height[]" class="form-control height" required min="0.01" max="100000000" step="0.01" placeholder="Height"> </td>
                    <td> <div class="form-control text-right sub_total" readonly>0.00</div> </td>
                    <td> <i class="btn btn-danger btn-sm fa fa-minus remove-calculation-row"></i> </td>
                </tr>
            `;

            $('#calculation_table tbody').append(row);

            changeCalculationType();
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

        /* Changes calculation type based on UNIT */
        function changeCalculationType() {
            $('.length').each(function() {
                $(this).attr('readonly', unit === 'CFT' || unit === 'SFT' || unit === '' ? false : true);
                $(this).attr('required', unit === 'CFT' || unit === 'SFT' || unit === '' ? true : false);
                $(this).val(unit === 'RFT' ? '' : $(this).val());
            });
            $('.breadth').each(function() {
                $(this).attr('readonly', unit === 'CFT' || unit === 'SFT' || unit === '' ? false : true);
                $(this).attr('required', unit === 'CFT' || unit === 'SFT' || unit === '' ? true : false);
                $(this).val(unit === 'RFT' ? '' : $(this).val());
            });
            $('.height').each(function() {
                $(this).attr('readonly', unit === 'CFT' || unit === 'RFT' || unit === '' ? false : true);
                $(this).attr('required', unit === 'CFT' || unit === 'RFT' || unit === '' ? true : false);
                $(this).val(unit === 'SFT' ? '' : $(this).val());
            });

            $('.work_unit').text(unit ? 'Unit: ' + unit : '');
        }

        /* Gets the sub-works by work_id on change */
        function getSubworkByWork(work_id) {
            $.ajax({
                url: "{{ route('boq.get_boq_sub_works_by_work_id') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    work_id: work_id,
                },
                success: function(data) {
                    if (!isObjectEmpty(data)) {
                        appendSubwork(data);
                    }
                }
            });
        }

        /* Gets the work unit by work id */
        function getWorkUnitByWorkId(work_id) {
            $.ajax({
                url: "{{ route('boq.get_boq_work_unit_by_work_id') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    work_id: work_id,
                },
                success: function(data) {
                    unit = isObjectEmpty(data) ? "" : data;
                    changeCalculationType();
                }
            });
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
        $("#calculation_table").on('keyup', '.no, .length, .breadth, .height', function() {
            let no = $(this).closest('tr').find('.no').val() ? parseFloat($(this).closest('tr').find('.no').val()) : 1;
            let length = $(this).closest('tr').find('.length').val() ? parseFloat($(this).closest('tr').find('.length').val()) : 1;
            let breadth = $(this).closest('tr').find('.breadth').val() ? parseFloat($(this).closest('tr').find('.breadth').val()) : 1;
            let height = $(this).closest('tr').find('.height').val() ? parseFloat($(this).closest('tr').find('.height').val()) : 1;

            let sub_total = no * length * breadth * height;
            $(this).closest('tr').find('.sub_total').text(parseFloat(sub_total).toFixed(2));

            calculateTotal();
        })

        /* Adds sub-work on change of work_id */
        $('#work_id').on('change', function() {
            let work_id = $(this).val();
            $('#subwork').empty();

            work_id == rcc_id ? appendRccSubworkRow() : getSubworkByWork(work_id);

            getWorkUnitByWorkId(work_id);
        });

        /* Gets the sub-work unit by work_id on change */
        $(document).on('change', '#sub_work_id', function() {
            let work_id = $(this).val();
            getWorkUnitByWorkId(work_id);
        });


        /* The document function */
        $(function() {
            appendCalculationRow();
        });
    </script>
@endsection
