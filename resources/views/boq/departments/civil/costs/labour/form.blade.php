@csrf

<!-- Calculation -->
<div class="mt-1 row">
    <div class="col-md-1"></div>
    <div class="col-12">
        <div class="card">
            <div class="tableHeading">
                <h5> <span>&#10070;</span>Civil Labour Cost<span>&#10070;</span><span class="work_unit"></span> </h5>
            </div>
            <div class="card-body">
                <!-- Calculations -->
                <div class="mt-1 row">
                    <div class="col-md-12">
                        <table class="table table-bordered" id="calculation_table">
                            <thead>
                                <tr>
                                    <th> Quantity <span class="text-danger">*</span></th>
                                    <th> Rate <span class="text-danger">*</span></th>
                                    <th> Total Amount <span class="text-danger">*</span></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($labour_statements as $statement)
                                    <tr>
                                        <td>
                                            <input class="form-control quantity" name="quantity" type="text" value="{{ $statement?->quantity }}" readonly>
                                            <input type="hidden" name="id" value="{{ $statement?->id }}">
                                        </td>
                                        <td>
                                            <input class="form-control rate" name="rate" type="text" value="{{ $statement?->rate }}">
                                        </td>
                                        <td>
                                            <input readonly class="form-control total_amount" type="text" value="{{ $statement?->total_amount }}">
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3">No data found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th> Quantity <span class="text-danger">*</span></th>
                                    <th> Rate <span class="text-danger">*</span></th>
                                    <th> Total Amount <span class="text-danger">*</span></th>
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
        $(".rate").on('keyup', function() {
            var rate = $(this).val() != "" ? parseFloat($(this).val()) : 0;
            var quantity = $(this).parent().parent().find('.quantity').val();
            var total_amount = rate * quantity;
            $(this).parent().parent().find('.total_amount').val(total_amount);
        });
        /* Appends calculation row */
        {{-- function appendCalculationRow() { --}}
        {{-- let row = ` --}}
        {{-- <tr> --}}
        {{-- <td> --}}
        {{-- <select class="form-control nested_material_id" name="nested_material_id[]" required> --}}
        {{-- <option value="">Select Material</option> --}}
        {{-- @foreach ($nested_materials as $id => $name) --}}
        {{-- <option value="{{ $id }}"> --}}
        {{-- {{ $name }} --}}
        {{-- </option> --}}
        {{-- @endforeach --}}
        {{-- </select> --}}
        {{-- </td> --}}
        {{-- <td> <input type="text" name="quantity[]" value="" class="form-control quantity" required placeholder="Quantity"> </td> --}}
        {{-- <td> <i class="btn btn-danger btn-sm fa fa-minus remove-calculation-row"></i> </td> --}}
        {{-- </tr> --}}
        {{-- `; --}}

        {{-- $('#calculation_table tbody').append(row); --}}
        {{-- } --}}

        {{-- /* Adds and removes calculation row on click */ --}}
        {{-- $("#calculation_table") --}}
        {{-- .on('click', '.add-calculation-row', () => appendCalculationRow()) --}}
        {{-- .on('click', '.remove-calculation-row', function() { --}}
        {{-- $(this).closest('tr').remove(); --}}
        {{-- }); --}}

        {{-- /* The document function */ --}}
        {{-- $(function() { --}}
        {{-- appendCalculationRow(); --}}
        {{-- }); --}}
    </script>
@endsection
