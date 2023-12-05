@extends('layouts.backend-layout')
@section('title', 'Bill Register')

@section('breadcrumb-title')
    @if ($formType == 'edit')
        Edit Bill Register
    @else
        Add Bill Register
    @endif
@endsection

@section('breadcrumb-button')
    <a href="{{ url('bill-register') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', null)

@section('content')
    @if ($formType == 'edit')
        {!! Form::open(['url' => "bill-register/$billRegister->id", 'method' => 'PUT', 'class' => 'custom-form']) !!}
        <input type="hidden" name="id" value="{{ $billRegister->id }}">
    @else
        {!! Form::open(['url' => 'bill-register', 'method' => 'POST', 'class' => 'custom-form']) !!}
    @endif


    <hr class="bg-success">
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-sm text-center" id="itemTable">
            <thead>
                <tr>
                    <th>Serial No<span class="text-danger">*</span></th>
                    <th>Bill No</th>
                    <th>Supplier Name <span class="text-danger">*</span></th>
                    <th>Amount<span class="text-danger">*</span></th>
                    <th>Department<span class="text-danger">*</span></th>
                    {{-- <th>Employee <span class="text-danger">*</span></th> --}}
                    @if ($formType == 'create')
                        <th>
                            <button class="btn btn-success btn-sm addItem" type="button"><i
                                    class="fa fa-plus"></i></button>
                        </th>
                    @endif

                </tr>
            </thead>
            <tbody>

                @if (old('supplier_id'))
                    @foreach (old('supplier_id') as $key1 => $materialOldData)
                        <tr>
                            <td>
                                <input type="text" name="serial_no[]" value="{{ old('serial_no')[$key1] }}"
                                    class="form-control text-center form-control-sm serial_no" autocomplete="off" required
                                    placeholder="Serial No">
                            </td>
                            <td>
                                <input type="text" name="bill_no[]" value="{{ old('bill_no')[$key1] }}"
                                    class="form-control text-center form-control-sm bill_no" autocomplete="off"
                                    placeholder="Bill No">
                            </td>
                            <td>
                                <select class='form-control form-control-sm supplier select2' name="supplier_id[]"
                                    id="" required>
                                    @foreach ($suppliers as $key => $data)
                                        <option value="{{ $key }}"
                                            @if ($key == old('supplier_id')[$key1]) selected @endif> {{ $data }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="number" name="amount[]" value="{{ old('amount')[$key1] }}"
                                    class="form-control text-center form-control-sm amount" tabindex="-1"
                                    placeholder="Bill Amount">
                            </td>
                            <td>
                                <select name="department_id[]" id=""
                                    class='form-control form-control-sm department select2' required>
                                    @foreach ($departments as $key => $data)
                                        <option value="{{ $key }}"
                                            @if ($key == old('department_id')[$key1]) selected @endif>
                                            {{ $data }}</option>
                                    @endforeach
                                </select>
                            </td>
                            @if ($formType == 'create')
                                <td><button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i
                                            class="fa fa-minus"></i></button></td>
                            @endif
                        </tr>
                    @endforeach
                @elseif($formType == 'edit')
                    <tr>
                        <td>
                            <input type="text" name="serial_no[]"
                                class="form-control text-center form-control-sm serial_no" autocomplete="off"
                                value="{{ $billRegister->serial_no }}" required placeholder="Serial No">
                        </td>
                        <td>
                            <input type="text" name="bill_no[]" class="form-control text-center form-control-sm bill_no"
                                autocomplete="off" value="{{ $billRegister->bill_no ?? null }}" placeholder="Bill No">
                        </td>
                        <td>
                            {{ Form::select('supplier_id[]', $suppliers, $billRegister->supplier_id, ['class' => 'form-control form-control-sm supplier select2', 'placeholder' => 'Select Supplier', 'autocomplete' => 'off', 'required']) }}
                        </td>
                        <td><input type="number" name="amount[]" value="{{ $billRegister->amount }}"
                                class="form-control text-center form-control-sm amount" tabindex="-1"
                                placeholder="Bill Amount"></td>
                        <td>{{ Form::select('department_id[]', $departments, $billRegister->department_id, ['class' => 'form-control form-control-sm department select2', 'placeholder' => 'Select Department', 'required']) }}
                        </td>
                        {{--    <td>{{ Form::select('employee_id[]', $employees,$billRegister->employee_id, ['class' => 'form-control form-control-sm employee', 'placeholder' => 'Select Employee',  'required']) }}</td> --}}
                    </tr>
                @endif
            </tbody>
        </table>
    </div> <!-- end table responsive -->
    <div class="row">
        <div class="offset-md-4 col-md-4 mt-2">
            <div class="input-group input-group-sm ">
                <button class="btn btn-success btn-round btn-block py-2">Submit</button>
            </div>
        </div>
    </div> <!-- end row -->
    {!! Form::close() !!}
@endsection


@section('script')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        function addRow() {
            let row = `
    <tr>
        <td>
            <input type="text" name="serial_no[]" class="form-control text-center form-control-sm serial_no"
                autocomplete="off" required placeholder="Serial No">
        </td>
        <td>
            <input type="text" name="bill_no[]" class="form-control text-center form-control-sm bill_no"
                autocomplete="off" placeholder="Bill No">
        </td>
        <td>
            {{ Form::select('supplier_id[]', $suppliers, null, ['class' => 'form-control form-control-sm supplier select2', 'placeholder' => 'Select Supplier', 'autocomplete' => 'off', 'required']) }}
        </td>
        <td><input type="number" name="amount[]" class="form-control text-center form-control-sm amount" tabindex="-1"
                placeholder="Bill Amount"></td>
        <td>
            {{ Form::select('department_id[]', $departments, null, ['class' => 'form-control form-control-sm department select2', 'placeholder' => 'Select Department', 'autocomplete' => 'off', 'required']) }}
        </td>
        <td><button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i
                    class="fa fa-minus"></i></button></td>
    </tr>
    `;
            $('#itemTable tbody').append(row);
            $('.select2').select2();
        }


        var CSRF_TOKEN = "{{ csrf_token() }}";

        function get_employee(a) {}
        $(function() {
            @if ($formType == 'create' && !old('supplier_id'))
                addRow();
            @endif

            @if (old('department_id'))
                $(".department").each(function() {
                    let department_id = $(this).val();

                    let dropdown = $(this);
                    dropdown.closest('tr').find('.employee').empty();
                    dropdown.closest('tr').find('.employee').append('<option>Select Employee</option>');
                    dropdown.closest('tr').find('.employee').prop('selectedIndex', 0);
                    const url = '{{ url('getDepartmentEmployee') }}/' + department_id;
                    // Populate dropdown with list of provinces
                    $.getJSON(url, function(employee) {
                        $.each(employee, function(key, entry) {
                            dropdown.closest('tr').find('.employee').append($(
                                '<option></option>').attr('value', key).text(entry));
                        })
                    });
                });
            @endif



            $("#itemTable").on('click', ".addItem", function() {
                addRow();
                loadProjectWiseFloor(this);
            }).on('click', '.deleteItem', function() {
                $(this).closest('tr').remove();
            });

            $('#date,#applied_date').datepicker({
                format: "dd-mm-yyyy",
                autoclose: true,
                todayHighlight: true,
                showOtherMonths: true
            });

            $(document).on('mouseenter', '.required_date', function() {
                $(this).datepicker({
                    format: "dd-mm-yyyy",
                    autoclose: true,
                    todayHighlight: true,
                    showOtherMonths: true
                });
            });

            $(document).on('change', '.department', function() {
                let department_id = $(this).val();
                let dropdown = $(this);
                dropdown.closest('tr').find('.employee').empty();
                dropdown.closest('tr').find('.employee').append('<option>Select Employee</option>');
                dropdown.closest('tr').find('.employee').prop('selectedIndex', 0);
                const url = '{{ url('getDepartmentEmployee') }}/' + department_id;
                // Populate dropdown with list of provinces
                $.getJSON(url, function(employee) {
                    $.each(employee, function(key, entry) {
                        dropdown.closest('tr').find('.employee').append($(
                            '<option></option>').attr('value', key).text(entry));
                    })
                });
            });


        });
    </script>
@endsection
