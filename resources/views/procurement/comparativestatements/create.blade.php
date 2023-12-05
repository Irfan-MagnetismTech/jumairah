@extends('layouts.backend-layout')
@section('title', 'Comparative Statements')

@php
    $is_old = old('effective_date') ? true : false;
    $form_heading = !empty($comparative_statement->id) ? 'Update' : 'Add';
    $form_url = !empty($comparative_statement->id) ? route('comparative-statements.update', $comparative_statement->id) : route('comparative-statements.store');
    $form_method = !empty($comparative_statement->id) ? 'PUT' : 'POST';
@endphp

@section('breadcrumb-title')
    {{ ucfirst($form_heading) }} Comparative Statement & Supplier
@endsection

@section('breadcrumb-button')
    <a href="{{ route('comparative-statements.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', null)

@section('content')

    {!! Form::open(['url' => $form_url, 'method' => $form_method, 'encType' => 'multipart/form-data', 'class' => 'custom-form']) !!}

    {{-- Comparative Statement --}}
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="tableHeading">
                    <h5> <span> &#10070; </span> Comparative Statement <span>&#10070;</span> </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @php
                            $reference_no = $is_old ? old('reference_no') : $comparative_statement->reference_no ?? null;
                            $effective_date = $is_old ? old('effective_date') : $comparative_statement->effective_date ?? null;
                            $expiry_date = $is_old ? old('expiry_date') : $comparative_statement->expiry_date ?? null;
                            $remarks = $is_old ? old('remarks') : $comparative_statement->remarks ?? null;
                        @endphp
                        <div class="col-xl-4 col-md-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="effective_date">CS Reference No<span class="text-danger">*</span></label>
                                {{ Form::text('reference_no', $reference_no, ['class' => 'form-control', 'id' => 'reference_no', 'autocomplete' => 'off', 'placeholder' => '#Reference', 'required']) }}
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="effective_date">Effective Date<span class="text-danger">*</span></label>
                                {{ Form::text('effective_date', $effective_date, ['class' => 'form-control', 'id' => 'effective_date', 'autocomplete' => 'off', 'placeholder' => 'Effective Date', 'required', 'readonly']) }}
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="expiry_date">Expiry Date<span class="text-danger">*</span></label>
                                {{ Form::text('expiry_date', $expiry_date, ['class' => 'form-control', 'id' => 'expiry_date', 'autocomplete' => 'off', 'placeholder' => 'Expiry Date', 'required', 'readonly']) }}
                            </div>
                        </div>
                        <div class="mt-1 col-xl-12 col-md-12">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="remarks">Remarks</label>
                                {{ Form::textarea('remarks', $remarks, ['class' => 'form-control', 'id' => 'remarks', 'autocomplete' => 'off', 'placeholder' => 'Remarks', 'rows' => 2]) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div id="cs">
        {{-- Projects & Materials --}}
        <div class="mt-4 row">
            <div class="col-md-12">
                <div class="tableHeading">
                    <h5> <span>&#10070;</span>Materials<span>&#10070;</span> </h5>
                </div>
                <div class="table-responsive">
                    <table id="materialTable" class="table text-center table-striped table-sm table-bordered">
                        <thead>
                            <tr>
                                <th>Material Name<span class="text-danger">*</span></th>
                                <th>Unit</th>
                                {{-- <th>Type</th>
                                <th>Size</th> --}}
                                <th><i class="btn btn-primary btn-sm fa fa-plus addMaterial"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $materials = $is_old ? old('material_id') ?? [] : $comparative_statement->csMaterials ?? [];
                            @endphp
                            @forelse ($materials as $material_key => $material_value)
                                @php
                                    $material_id = $is_old ? old('material_id')[$material_key] : $material_value->nestedMaterial->id;
                                    $material_name = $is_old ? old('material_name')[$material_key] : $material_value->nestedMaterial->name;
                                    $unit = $is_old ? old('unit')[$material_key] : $material_value->nestedMaterial->unit->name ?? '---';
                                @endphp
                                <tr>
                                    <td>
                                        <input type="hidden" name="material_id[]" value="{{ $material_id }}" class="material_id">
                                        <input type="text" name="material_name[]" value="{{ $material_name }}" class="form-control form-control-sm material_name" autocomplete="off" required>
                                    </td>
                                    <td>
                                        <input type="text" name="unit[]" value="{{ $unit }}" class="form-control form-control-sm unit" hidden tabindex="-1">
                                        <div class="unit_div form-control" readonly>{{ $unit }}</div>
                                    </td>
                                    <td>
                                        <i class="btn btn-danger btn-sm fa fa-minus deleteItem"></i>
                                    </td>
                                </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <hr>
        {{-- Suppliers --}}
        <div class="mt-4 row">
            <div class="col-md-12">
                <div class="tableHeading">
                    <h5> <span>&#10070;</span>Suppliers<span>&#10070;</span> </h5>
                </div>
                <div class="table-responsive">
                    <table id="supplierTable" class="table text-center table-striped table-sm table-bordered">
                        <thead>
                            <tr>
                                <th width="300px"> Supplier Name<span class="text-danger">*</span><br>
                                    <a href="{{ route('suppliers.create') }}" target="_blank" style="color: white">
                                        <u>Click Here to Add New Supplier</u>
                                    </a>
                                    <span style="font-size: 12px">
                                        <i class="fas fa-external-link-square-alt"></i>
                                    </span>
                                </th>
                                <th> Supplier Info </th>
                                <th> Price Collection Way <span class="text-danger">*</span></th>
                                <th> Grade <span class="text-danger">*</span></th>
                                <th> Vat <span class="text-danger">*</span></th>
                                <th> Tax <span class="text-danger">*</span></th>
                                <th> Credit Period <span class="text-danger">*</span></th>
                                <th> Material Availability <span class="text-danger">*</span></th>
                                <th> Delivery Condition <span class="text-danger">*</span></th>
                                <th> Required Time <span class="text-danger">*</span></th>
                                <th> Upload File</th>
                                <th> Remarks</th>
                                <th><i class="btn btn-primary btn-sm fa fa-plus addSupplier"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $suppliers = $is_old ? old('supplier_id') ?? [] : $comparative_statement->csSuppliers ?? [];
                            @endphp
                            @forelse ($suppliers as $supplier_key => $supplier_value)
                                @php
                                    $supplier_id = $is_old ? old('supplier_id')[$supplier_key] : $supplier_value->supplier->id;
                                    $supplier_name = $is_old ? old('supplier_name')[$supplier_key] : $supplier_value->supplier->name;
                                    $supplier_remarks = $is_old ? old('supplier_remarks')[$supplier_key] ?? '' : $supplier_value->remarks;
                                    $checked_supplier = $is_old ? isset(old('checked_supplier')[$supplier_key]) ?? false : $supplier_value->is_checked ?? false;
                                    $address = $is_old ? old('address')[$supplier_key] : $supplier_value->supplier->address ?? '---';
                                    $contact = $is_old ? old('contact')[$supplier_key] : $supplier_value->supplier->contact ?? '---';
                                    $collection_way = $is_old ? old('collection_way')[$supplier_key] : $supplier_value->collection_way;
                                    $grade = $is_old ? old('grade')[$supplier_key] : $supplier_value->grade;
                                    $vat_tax = $is_old ? old('vat_tax')[$supplier_key] : $supplier_value->vat_tax;
                                    $tax = $is_old ? old('tax')[$supplier_key] : $supplier_value->tax;
                                    $credit_period = $is_old ? old('credit_period')[$supplier_key] : $supplier_value->credit_period;
                                    $material_availability = $is_old ? old('material_availability')[$supplier_key] : $supplier_value->material_availability;
                                    $delivery_condition = $is_old ? old('delivery_condition')[$supplier_key] : $supplier_value->delivery_condition;
                                    $required_time = $is_old ? old('required_time')[$supplier_key] : $supplier_value->required_time;
                                @endphp
                                <tr>
                                    <td>
                                        <input type="hidden" name="supplier_id[]" value="{{ $supplier_id }}" class="supplier_id">
                                        <div class="form-check">
                                            <input name="checked_supplier[]" @if ($checked_supplier) checked @endif value="{{ $supplier_id }}" class="form-check-input checked_supplier_id" type="checkbox" id="flexCheckDefault">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                Mark as selected
                                            </label>
                                        </div>
                                        <input type="text" name="supplier_name[]" value="{{ $supplier_name }}" class="form-control form-control-sm supplier_name" autocomplete="off" required>
                                    </td>
                                    <td>
                                        <input type="text" name="address[]" value="{{ $address }}" class="form-control form-control-sm address" hidden tabindex="-1">
                                        <div>
                                            <span><b>Address : </b></span>
                                            <span class="address_div"> {{ $address }} </span>
                                        </div>
                                        <input type="number" name="contact[]" value="{{ $contact }}" class="form-control form-control-sm contact" hidden autocomplete="off" readonly tabindex="-1">
                                        <div>
                                            <span><b>Contact : </b></span>
                                            <span class="contact_div">{{ $contact }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <input type="text" name="collection_way[]" value="{{ $collection_way }}" class="form-control form-control-sm collection_way" placeholder="Collection Way" autocomplete="off" required>
                                    </td>
                                    <td>
                                        <select name="grade[]" id="cars" class="form-control form-control-sm grade" required style="width: 70px">
                                            @foreach ($grades as $data)
                                                <option value="{{ $data }}" @if ($grade == $data) Selected @endif>{{ $data }}</option>
                                            @endforeach
                                        </select> 
                                    </td>
                                    <td>
                                    <select name="vat_tax[]" id="vat_tax" class="form-control form-control-sm vat_tax" required style="width: 80px">
                                            @foreach ($Taxes as $data)
                                                <option value="{{ $data }}" @if ($vat_tax == $data) Selected @endif>{{ $data }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <select name="tax[]" id="tax" class="form-control form-control-sm tax" required style="width: 160px">
                                            @foreach ($Taxes as $data)
                                                <option value="{{ $data }}" @if ($tax == $data) Selected @endif>{{ $data }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <!-- <select name="credit_period[]" id="credit_period" class="form-control form-control-sm credit_period" required style="width: 120px">
                                            @foreach ($credit_Period as $data)
                                                <option value="{{ $data }}" @if ($credit_period == $data) Selected @endif>{{ $data }}</option>
                                            @endforeach
                                        </select> -->
                                        <input type="text" name="credit_period[]" value="{{ $credit_period }}" class="form-control form-control-sm credit_period" placeholder="Credit Period" autocomplete="off" required list='credit_period_types'>
                                        <datalist id="credit_period_types">
                                            @foreach ($credit_Period as $type)
                                                {{$type}}
                                                <option value="{{$type}}">{{$type}}</option>
                                            @endforeach
                                        </datalist>
                                    </td>
                                    <td>
                                        <input type="text" name="material_availability[]" class="form-control form-control-sm material_availability" readonly value="Available" placeholder="Material Availability" autocomplete="off" required style="width: 100px">
                                    </td>
                                    <td>
                                        <select name="delivery_condition[]" id="delivery_condition" class="form-control form-control-sm delivery_condition" required style="width: 120px">
                                            @foreach ($delivery_conditions as $data)
                                                <option value="{{ $data }}" @if($delivery_condition == $data) Selected @endif>{{ $data }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" name="required_time[]" class="form-control form-control-sm required_time" placeholder="Required Time" readonly value="As per our requirement" autocomplete="off" required style="width: 150px">
                                    </td>
                                    <td>
                                        <input type="file" name="files[]" class="form-control form-control-sm required_time"  readonly autocomplete="off" style="width: 150px">
                                    </td>
                                    <td>
                                        <textarea type="text" name="supplier_remarks[]" class="form-control form-control-sm supplier_remarks" placeholder="Remarks" autocomplete="off">{{ $supplier_remarks }}</textarea>
                                    </td>
                                    <td>
                                        <i class="btn btn-danger btn-sm fa fa-minus deleteItem"></i>
                                    </td>
                                </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <hr>

    {{-- Comparative Statement Details --}}
    <div id="cs_details">
        <div class="mt-4 row">
            <div class="col-md-12">
                <div class="tableHeading">
                    <h5> <span>&#10070;</span>Comparative Statement Details<span>&#10070;</span> </h5>
                </div>
                <div class="table-responsive">
                    <table id="csDetailsTable" class="table text-center table-striped table-sm table-bordered">
                        <thead>
                            <tr>
                                <th>Materials</th>
                                @forelse ($suppliers as $supplier_key => $supplier_value)
                                    <th>
                                        {{ $is_old ? old('supplier_name')[$supplier_key] : $supplier_value->supplier->name }}
                                    </th>
                                @empty
                                @endforelse
                            </tr>
                        </thead>
                        <tbody>
                            @php $price_index = 0; @endphp
                            @forelse ($materials as $material_key => $material_value)
                                @forelse ($suppliers as $supplier_key => $supplier_value)
                                    @if ($loop->first)
                                        <tr>
                                            <td>
                                                {{ $is_old ? old('material_name')[$supplier_key] : $material_value->nestedMaterial->name }}
                                            </td>
                                    @endif
                                    <td>
                                        <input type="text" name="price[]" value="{{ $is_old
                                        ? old('price')[$price_index++]
                                        : $comparative_statement->csMaterialsSuppliers->where('cs_material_id', $material_value->id)->where('cs_supplier_id', $supplier_value->id)->first()->price }}" class="form-control" placeholder="Pricez" required />
                                    </td>
                                     @if ($loop->last) </tr> @endif
                                @empty
                                @endforelse
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="mt-2 offset-md-4 col-md-4">
            <div class="input-group input-group-sm ">
                <button class="py-2 btn btn-success btn-round btn-block">Save</button>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection

@section('script')
    <script>
        let is_confirmed = false;

        function addMaterial() {
            $('#materialTable tbody').append(
                `<tr>
                    <td>
                        <input type="hidden" name="material_id[]" value="" class="material_id">
                        <input type="text" name="material_name[]" class="form-control form-control-sm material_name" autocomplete="off" required>
                    </td>
                    <td>
                        <input type="text" name="unit[]" class="form-control form-control-sm unit" hidden tabindex="-1">
                        <div class="unit_div form-control" readonly>---</div>
                    </td>
                    <td>
                        <i class="btn btn-danger btn-sm fa fa-minus deleteItem"></i>
                    </td>
                </tr>`
            );
        }

        function addProject() {
            $('#projectTable tbody').append(
                `<tr>
                    <td>
                        <input type="hidden" name="project_id[]" value="" class="project_id">
                        <input type="text" name="project_name[]" class="form-control form-control-sm project_name" autocomplete="off" required>
                    </td>
                    <td>
                        <i class="btn btn-danger btn-sm fa fa-minus deleteItem"></i>
                    </td>
                </tr>`
            );
        }
        var credit_types = {!! json_encode($credit_Period) !!};
        var datalist = '';
        credit_types.forEach(function(creditType) {
            datalist +=  `<option value="${creditType}">${creditType}</option>`;
        });

       
        function addSupplier() {
            $('#supplierTable tbody').append(
                `<tr>
                    <td>
                        <input type="hidden" name="supplier_id[]" class="supplier_id">
                        <div class="form-check">
                            <input name="checked_supplier[]" class="form-check-input checked_supplier_id" type="checkbox" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">
                                Mark as selected
                            </label>
                        </div>
                        <input type="text" name="supplier_name[]" class="form-control form-control-sm supplier_name" autocomplete="off" required>
                    </td>
                    <td>
                        <input type="text" name="address[]" class="form-control form-control-sm address" hidden tabindex="-1">
                        <div>
                            <span><b>Address : </b></span>
                            <span class="address_div">---</span>
                        </div>
                        <input type="number" name="contact[]" class="form-control form-control-sm contact" hidden autocomplete="off" readonly tabindex="-1">
                        <div>
                            <span><b>Contact : </b></span>
                            <span class="contact_div">---</span>
                        </div>
                    </td>
                    <td>
                        <input type="text" name="collection_way[]" class="form-control form-control-sm collection_way" placeholder="Collection Way" autocomplete="off" required>
                    </td>
                    <td>
                        <select name="grade[]" id="grade" class="form-control form-control-sm grade" required style="width: 70px">
                            @foreach ($grades as $data)
                                <option value="{{ $data }}">{{ $data }}</option>
                            @endforeach
                        </select> 
                    </td>
                    <td>
                        <select name="vat_tax[]" id="vat_tax" class="form-control form-control-sm vat_tax" required style="width: 80px">
                            @foreach ($Taxes as $data)
                                <option value="{{ $data }}">{{ $data }}</option>
                            @endforeach
                        </select> 
                    </td>
                    <td>
                        <select name="tax[]" id="tax" class="form-control form-control-sm tax" required style="width: 80px">
                            @foreach ($Taxes as $data)
                                <option value="{{ $data }}">{{ $data }}</option>
                            @endforeach
                        </select> 
                    </td>
                    <td>
                    <input type="text" name="credit_period[]" value="" class="form-control form-control-sm credit_period" placeholder="Credit Period" autocomplete="off" required list='credit_period_types'>
                        <datalist id="credit_period_types">
                            ${datalist}
                        </datalist>
                    </td>
                    <td>
                        <input type="text" name="material_availability[]" class="form-control form-control-sm material_availability" placeholder="Material Availability" readonly value="Available" autocomplete="off" required style="width: 100px">
                    </td>
                    <td>
                        <select name="delivery_condition[]" id="delivery_condition" class="form-control form-control-sm delivery_condition" required style="width: 160px">
                            @foreach ($delivery_conditions as $data)
                                <option value="{{ $data }}">{{ $data }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="text" value="As per our requirement" name="required_time[]" class="form-control form-control-sm required_time" placeholder="Required Time" autocomplete="off" readonly required style="width: 150px">
                    </td>
                    <td>
                        <input type="file" name="files[]" class="form-control form-control-sm required_time" placeholder="Upload File" readonly autocomplete="off" style="width: 150px">
                    </td>
                
                    <td>
                        <textarea type="text" name="supplier_remarks[]" class="form-control form-control-sm supplier_remarks" placeholder="Remarks" autocomplete="off"></textarea>
                    </td>
                    <td>
                        <i class="btn btn-danger btn-sm fa fa-minus deleteItem"></i>
                    </td>
                </tr>`
            );
        }

        // Function for populating dropdowns
        function populateDropDown(dropdown, data, key_name, type) {
            dropdown.empty();

            dropdown.append(`<option selected="true" value>Select ${type}</option>`);
            dropdown.prop('selectedIndex', 0);

            $.each(data, function(key, value) {
                dropdown.append($(`<option></option>`).attr('value', value[key_name]).text(value[key_name]));
            });
        }

        // Cs Details Row
        function changeCsRow(column, material_name) {
            let cs_details_table_body = $('#csDetailsTable tbody');
            let th = cs_details_table_body.children(`tr:eq(${column.index()})`).find(".cs_material").html(material_name);
        }

        function addCsRow() {
            let cs_details_table_tbody = $('#csDetailsTable tbody');
            let count_supplier = $('.supplier_name').length ? 0 : $('.supplier_name').length;
            let table_data = `<tr><td colspan="${count_supplier}" class="cs_material">Select a Material</td>`;

            $('.supplier_name').each(function() {
                table_data +=
                    `<td> <input type="number" name="price[]" class="form-control" placeholder="Price" step="0.01" required/> </td>`;
            });

            cs_details_table_tbody.append(table_data += `</tr>`);
        }

        function removeCsRow(index) {
            let cs_details_table_body = $('#csDetailsTable tbody');
            cs_details_table_body.children(`tr:eq(${index})`).remove();
        }

        // Cs Details Column
        function changeCsColumn(column, supplier_name) {
            let cs_details_table_head = $('#csDetailsTable thead tr');
            let th = cs_details_table_head.children(`th:eq(${column.index() + 1})`).html(supplier_name);
        }

        function addCsColumn() {
            let cs_details_table_head = $('#csDetailsTable thead tr');
            cs_details_table_head.append(`<th>Select a Supplier</th>`);

            let cs_details_table_body = $('#csDetailsTable tbody');
            $("#csDetailsTable tbody tr").each(function() {
                $(this).append(
                    `<td> <input type="number" name="price[]" class="form-control" placeholder="Price" step="0.01" required/> </td>`
                );
            });
        }

        function removeCsColumn(index) {
            let cs_details_table_head = $('#csDetailsTable thead tr');
            cs_details_table_head.children(`th:eq(${index})`).remove();

            let cs_details_table_body = $('#csDetailsTable tbody');
            $("#csDetailsTable tbody tr").each(function() {
                $(this).children(`td:eq(${index})`).remove();
            });
        }

        var CSRF_TOKEN = "{{ csrf_token() }}";
        $(function() {
            $(document).on('keyup', ".project_name", function() {
                $(this).autocomplete({
                    source: function(request, response) {
                        $.ajax({
                            url: "{{ route('projectAutoSuggest') }}",
                            type: 'post',
                            dataType: "json",
                            data: {
                                _token: CSRF_TOKEN,
                                search: request.term
                            },
                            success: function(data) {
                                response(data);
                            }
                        });
                    },
                    select: function(event, ui) {
                        $(this).closest('tr').find('.project_name').val(ui.item.label);
                        $(this).closest('tr').find('.project_id').val(ui.item.value);
                        return false;
                    }
                });
            });
            $(document).on('keyup', ".supplier_name", function() {
                $(this).autocomplete({
                    source: function(request, response) {
                        $.ajax({
                            url: "{{ route('supplierAutoSuggest') }}",
                            type: 'post',
                            dataType: "json",
                            data: {
                                _token: CSRF_TOKEN,
                                search: request.term
                            },
                            success: function(data) {
                                response(data);
                            }
                        });
                    },
                    select: function(event, ui) {
                        $(this).closest('tr').find('.supplier_name').val(ui.item.label);
                        $(this).closest('tr').find('.supplier_id').val(ui.item.value);
                        $(this).closest('tr').find('.checked_supplier_id').val(ui.item.value);
                        $(this).closest('tr').find('.address').val(ui.item.address);
                        $(this).closest('tr').find('.address_div').html(ui.item.address);
                        $(this).closest('tr').find('.contact').val(ui.item.contact);
                        $(this).closest('tr').find('.contact_div').html(ui.item.contact);

                        changeCsColumn($(this).closest('tr'), ui.item.label);
                        return false;
                    }
                });
            });
            $(document).on('keyup', ".material_name", function() {
                $(this).autocomplete({
                    source: function(request, response) {
                        $.ajax({
                            url: "{{ route('scj.requisitionWiseMaterialAutoSuggest') }}",
                            type: 'post',
                            dataType: "json",
                            data: {
                                _token: CSRF_TOKEN,
                                search: request.term
                            },
                            success: function(data) {
                                response(data);
                            }
                        });
                    },
                    select: function(event, ui) {
                        $(this).val(ui.item.label);
                        $(this).closest('tr').find('.material_name').val(ui.item.label);
                        $(this).closest('tr').find('.material_id').val(ui.item.material_id);
                        $(this).closest('tr').find('.unit').val(ui.item.unit.name);
                        $(this).closest('tr').find('.unit_div').html(ui.item.unit.name);
                        changeCsRow($(this).closest('tr'), ui.item.label);
                    }
                });
            });

            $("#projectTable").on('click', '.addProject', function() {
                addProject();
            }).on('click', '.deleteItem', function() {
                $(this).closest('tr').remove();
            });

            $("#materialTable").on('click', '.addMaterial', function() {
                addMaterial();
                addCsRow();
            }).on('click', '.deleteItem', function() {
                removeCsRow($(this).closest('tr').index());
                $(this).closest('tr').remove();
            });

            $("#supplierTable").on('click', '.addSupplier', function() {
                addSupplier();
                addCsColumn();
            }).on('click', '.deleteItem', function() {
                removeCsColumn($(this).closest('tr').index() + 1);
                $(this).closest('tr').remove();
            });

            $('#expiry_date,#effective_date').datepicker({
                format: "dd-mm-yyyy",
                autoclose: true,
                todayHighlight: true,
                showOtherMonths: true
            });
        }); // document.ready


        var select_all_projects = function() {
            if ($("#select_all_projects").is(":checked")) {
                $('#plus').prop('disabled', true);
            } else {
                $('#plus').prop('disabled', false);
            }

        };

        $(select_all_projects);
        $("#select_all_projects").change(select_all_projects);
    </script>
@endsection
