@extends('layouts.backend-layout')
@section('title', 'Scrap CS Create')

@php
    $is_old = old('effective_date') ? true : false;
    $form_heading = !empty($scrapCs->id) ? 'Update' : 'Add';
    $form_url = !empty($scrapCs->id) ? route('scrapCs.update', $scrapCs->id) : route('scrapCs.store');
    $form_method = !empty($scrapCs->id) ? 'PUT' : 'POST';
@endphp

@section('breadcrumb-title')
    {{ ucfirst($form_heading) }} Scrap CS
@endsection

@section('breadcrumb-button')
    <a href="{{ route('scrapCs.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
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
                            $reference_no = $is_old ? old('reference_no') : $scrapCs->reference_no ?? null;
                            $effective_date = $is_old ? old('effective_date') : $scrapCs->effective_date ?? null;
                            $expiry_date = $is_old ? old('expiry_date') : $scrapCs->expiry_date ?? null;
                            $remarks = $is_old ? old('remarks') : $scrapCs->remarks ?? null;
                        @endphp
                        <div class="col-xl-3 col-md-3">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="effective_date">CS Reference No<span class="text-danger">*</span></label>
                                {{ Form::text('reference_no', $reference_no, ['class' => 'form-control', 'id' => 'reference_no', 'autocomplete' => 'off', 'placeholder' => '#Reference', 'required']) }}
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-3">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="effective_date">Effective Date<span class="text-danger">*</span></label>
                                {{ Form::text('effective_date', $effective_date, ['class' => 'form-control', 'id' => 'effective_date', 'autocomplete' => 'off', 'placeholder' => 'Effective Date', 'required', 'readonly']) }}
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-3">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="expiry_date">Expiry Date<span class="text-danger">*</span></label>
                                {{ Form::text('expiry_date', $expiry_date, ['class' => 'form-control', 'id' => 'expiry_date', 'autocomplete' => 'off', 'placeholder' => 'Expiry Date', 'required', 'readonly']) }}
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-3">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="project_id">Project<span class="text-danger">*</span></label>
                                {{ Form::text('project_name', old('project_name') ? old('project_name') : (!empty($scrapCs) ? $scrapCs->costCenter->name : null), ['class' => 'form-control', 'id' => 'project_name', 'autocomplete' => 'off', 'required', 'placeholder' => 'Project Name']) }}
                                {{ Form::hidden('project_id', old('project_id') ? old('project_id') : (!empty($scrapCs) ? $scrapCs->costCenter->project_id : null), ['class' => 'form-control', 'id' => 'project_id', 'autocomplete' => 'off']) }}
                                {{ Form::hidden('cost_center_id', old('cost_center_id') ? old('cost_center_id') : (!empty($scrapCs) ? $scrapCs->cost_center_id : null), ['class' => 'form-control', 'id' => 'cost_center_id', 'autocomplete' => 'off']) }}
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
                                <th>SGSF No<span class="text-danger">*</span></th>
                                <th>Material Name<span class="text-danger">*</span></th>
                                <th>Unit</th>
                                <th><i class="btn btn-primary btn-sm fa fa-plus addMaterial"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $materials = $is_old ? old('material_id') ?? [] : $scrapCs->ScrapcsMaterials ?? [];
                            @endphp
                            @forelse ($materials as $material_key => $material_value)
                                 @php
                                    $material_id = $is_old ? old('material_id')[$material_key] : $material_value->nestedMaterial->id;
                                    $material_name = $is_old ? old('material_name')[$material_key] : $material_value->nestedMaterial->name;
                                    $unit = $is_old ? old('unit')[$material_key] : $material_value->nestedMaterial->unit->name ?? '---'; 
                                    $sgsf_id = $is_old ? old('scrap_form_id')[$material_key] : $material_value->scrap_form_id ?? '---'; 
                                    $sgsf_no = $is_old ? old('sgsf_no')[$material_key] : $material_value?->ScrapForm?->sgsf_no ?? '---'; 
                                    $Scrap_materials = \App\BD\ScrapFormDetail::with("nestedMaterial")->whereHas('scrapForm',function($query)use($sgsf_id){ return $query->where('id',$sgsf_id); })->get()->pluck("material_id","nestedMaterial.name");
                                @endphp 
                                <tr>
                                    <td>
                                        <input type="hidden" name="scrap_form_id[]" value="{{ $sgsf_id}}" class="sgsf_id" id="sgsf_no">
                                        <input type="text" name="sgsf_no[]" value="{{ $sgsf_no}}" class="form-control form-control-sm sgsf_no" id="sgsf_no" autocomplete="off" required>
                                    </td>
                                    <td>
                                        <select class="form-control form-control-sm material_name" name="material_id[]" required>
                                            <option selected disabled>Select Material </option>
                                            @foreach ($Scrap_materials as $key => $value)
                                                <option value="{{ $value }}" @if((old("material_id[$material_key]") == $value) || ($material_id == $value)) selected @endif>
                                                    {{ $key }}
                                                </option>
                                            @endforeach
                                        </select>
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
                                <th>Supplier Info</th>
                                <th>Security Money<span class="text-danger">*</span></th>
                                <th>Vat/Tax<span class="text-danger">*</span></th>
                                <th>Payment Type<span class="text-danger">*</span></th>
                                <th>Lead Time<span class="text-danger">*</span></th>
                                <th><i class="btn btn-primary btn-sm fa fa-plus addSupplier"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $suppliers = $is_old ? old('supplier_id') ?? [] : $scrapCs->ScrapcsSuppliers ?? [];
                            @endphp
                            @forelse ($suppliers as $supplier_key => $supplier_value)
                                @php
                                    $supplier_id = $is_old ? old('supplier_id')[$supplier_key] : $supplier_value->supplier->id;
                                    $supplier_name = $is_old ? old('supplier_name')[$supplier_key] : $supplier_value->supplier->name;
                                    $checked_supplier = $is_old ? isset(old('checked_supplier')[$supplier_key]) ?? false : $supplier_value->is_checked ?? false;
                                    $address = $is_old ? old('address')[$supplier_key] : $supplier_value->supplier->address ?? '---';
                                    $contact = $is_old ? old('contact')[$supplier_key] : $supplier_value->supplier->contact ?? '---';
                                    $pt_value = $is_old ? old('payment_type')[$supplier_key] : $supplier_value->payment_type;
                                    $vat_tax = $is_old ? old('vat_tax')[$supplier_key] : $supplier_value->vat_tax;
                                    $lead_time = $is_old ? old('lead_time')[$supplier_key] : $supplier_value->lead_time;
                                    $security_money = $is_old ? old('security_money')[$supplier_key] : $supplier_value->security_money;
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
                                        <input type="text" name="security_money[]" value="{{ $security_money }}" class="form-control form-control-sm form-control-center security_money" placeholder="Seccurity Money" autocomplete="off" required>
                                    </td>
                                    <td>
                                        <select name="vat_tax[]" id="vat_tax" class="form-control form-control-sm form-control-center vat_tax" required style="">
                                            @foreach ($Taxes as $data)
                                                <option value="{{ $data }}" @if($data == $vat_tax) selected @endif>{{ $data }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="style-4">
                                        <select name="payment_type[]" id="vat_tax" class="form-control form-control-sm form-control-center vat_tax" required style="">
                                            @foreach ($payment_type as $data)
                                                <option value="{{ $data }}" @if($data == $pt_value) selected @endif>{{ $data }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" name="lead_time[]" value="{{ $lead_time }}" class="form-control form-control-sm form-control-center lead_time" placeholder="Lead Time" autocomplete="off" required>
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
                                        : $scrapCs->ScrapcsMaterialsSuppliers->where('scrap_cs_material_id', $material_value->id)->where('scrap_cs_supplier_id', $supplier_value->id)->first()->price }}" class="form-control" placeholder="Pricez" required />
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
                        <input type="hidden" name="scrap_form_id[]" class="sgsf_id" id="sgsf_id">
                        <input type="text" name="sgsf_no[]" class="form-control form-control-sm sgsf_no" id="sgsf_no" autocomplete="off" required>
                    </td>
                    <td>
                        <select class ="form-control form-control-sm material_name"  name="material_id[]" required>
                            <option value=""> Select Material</option>
                        </select>
                    </td>
                    <td>
                        <input type="text" name="unit[]" class="form-control text-center form-control-sm unit" readonly tabindex="-1">
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
                        <input type="text" name="supplier_name[]" class="form-control form-control-sm  form-control-center supplier_name" autocomplete="off" required placeholder="Search Supplier">
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
                        <input type="text" name="security_money[]" class="form-control form-control-sm form-control-center security_money" placeholder="Seccurity Money" autocomplete="off" required>
                    </td>
                    <td>
                        <select name="vat_tax[]" id="vat_tax" class="form-control form-control-sm form-control-center vat_tax" required style="">
                            @foreach ($Taxes as $data)
                                <option value="{{ $data }}">{{ $data }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td class="style-4">
                        <select name="payment_type[]" id="vat_tax" class="form-control form-control-sm form-control-center vat_tax" required style="">
                            @foreach ($payment_type as $data)
                                <option value="{{ $data }}">{{ $data }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="text" name="lead_time[]" class="form-control form-control-sm form-control-center lead_time" placeholder="Lead Time" autocomplete="off" required>
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
                    `<td> <input type="number" name="price[]" class="form-control form-control-center" placeholder="Price" step="0.01" required/> </td>`;
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
                    `<td> <input type="number" name="price[]" class="form-control form-control-center" placeholder="Price" step="0.01" required/> </td>`
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
            $(document).on('change', ".material_name", function() {
                changeCsRow($(this).closest('tr'), $(this).find("option:selected").text());
                const material_id = $(this).find("option:selected").val();
                const main = $(this);
                $.ajax({
                            url: "{{ route('scj.getUnitForMaterial') }}",
                            type: 'post',
                            dataType: "json",
                            data: {
                                _token: CSRF_TOKEN,
                                material_id
                            },
                            success: function(data) {
                                main.closest('tr').find('.unit').val(data[0]);
                            }
                        });
            });
            $(document).on('keyup', ".sgsf_no", function(){
                let cost_center_id = $('#cost_center_id').val();
                if(cost_center_id == null || cost_center_id == '' ){
                    alert('Please Search Cost Center First');
                }
                $(this).autocomplete({
                    source: function(request, response) {
                    $.ajax({
                        url: "{{ route('scj.LoadSgsf') }}",
                        type: 'post',
                        dataType: "json",
                        data: {
                            _token: CSRF_TOKEN,
                            search: request.term,
                            cost_center_id
                        },
                        success: function(data) {
                            response(data);
                        }
                    });
                },
                select: function(event, ui) {
                    $(this).val(ui.item.label);
                    $(this).closest('tr').find('.sgsf_id').val(ui.item.value);
                    $(this).closest('tr').find('.sgsf_no').val(ui.item.label);

                    let prnt = $(this)
                    let url ='{{url("scj/getSgsfMaterial")}}/'+ ui.item.value;
                    fetch(url)
                    .then((resp) => resp.json())
                    .then(function(data) {
                            if(data.length > 0) {
                                prnt.closest('tr').find(".material_name").html(null);
                                prnt.closest('tr').find(".material_name").append(`<option value="">Select Material</option>`);
                                $.each(data, function(materialItems, materialItem){
                                let option = `<option value="${materialItem.material_id}">${materialItem.material_name}</option>`;
                                prnt.closest('tr').find(".material_name").append(option);
                            });
                            }
                        })
                    .catch(function ($err) {
                    });
                    return false;
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
     
        $(function() {
            $('#project_name').on('keyup',function(){
                $(this).autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ route('projectAutoSuggestForScrap') }}",
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
                    $('#cost_center_id').val(ui.item.value);
                    $('#project_id').val(ui.item.project_id);
                    $('#project_name').val(ui.item.label);
                    return false;
                }
            })
            })
        })
        $(select_all_projects);
        $("#select_all_projects").change(select_all_projects);
    </script>
@endsection
