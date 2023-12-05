@extends('layouts.backend-layout')
@section('title', 'Comparative Statements')

@php
    $is_old = old('effective_date') ? true : false;
    $form_heading = !empty($work_c->id) ? 'Update' : 'Add';
    $form_url = !empty($work_c->id) ? route('eme.work_cs.update', ['work_c' => $work_c->id]) : route('eme.work_cs.store');
    $form_method = !empty($work_c->id) ? 'PUT' : 'POST';
@endphp

@section('breadcrumb-title')
    {{ ucfirst($form_heading) }} Comparative Statement & Supplier
@endsection

@section('breadcrumb-button')
    <a href="{{ route('eme.work_cs.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
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
                            $reference_no = $is_old ? old('reference_no') : $work_c->reference_no ?? null;
                            $effective_date = $is_old ? old('effective_date') : $work_c->effective_date ?? null;
                            $expiry_date = $is_old ? old('expiry_date') : $work_c->expiry_date ?? null;
                            $remarks = $is_old ? old('remarks') : $work_c->remarks ?? null;
                            $project_name = $is_old ? old('project_name') : $work_c->project->name ?? null;
                            $project_id = $is_old ? old('project_id') : $work_c->project_id ?? null;
                        @endphp
                         <div class="col-md-4 col-xl-4">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="project_name">Project Name</label>
                                {{Form::text('project_name',old('project_name') ? old('project_name') : ($project_name),['class' => 'form-control','id' => 'project_name', 'placeholder'=>"Search Project Name", 'autocomplete'=>"off"])}}
                                {{Form::hidden('project_id', old('project_id') ? old('project_id') : (!empty($utility_bill) ? $utility_bill->project_id  : null),['class' => 'form-control','id' => 'project_id','autocomplete'=>"off"])}}
                            </div>
                        </div>
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
                                $materials = $is_old ? old('material_id') ?? [] : $work_c->csMaterials ?? [];
                            @endphp
                            @forelse ($materials as $material_key => $material_value)
                                @php
                                    $material_id = $is_old ? old('material_id')[$material_key] : $material_value->material->id;
                                    $material_name = $is_old ? old('material_name')[$material_key] : $material_value->material->name;
                                    $unit = $is_old ? old('unit')[$material_key] : $material_value->material->unit->name ?? '---';
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

                    <h5><i class="btn btn-primary btn-sm fa fa-plus addSupplier float-right px-2 py-1"></i>
                        <a href="{{ route('suppliers.create') }}" target="_blank" style="color: white" class="float-left">
                            <u>Click Here to Add New Supplier</u>
                            <span style="font-size: 12px">
                            <i class="fas fa-external-link-square-alt"></i>
                            </span>
                        </a> <span>&#10070;</span>Suppliers<span>&#10070;</span> </h5>
                </div>
                <div id="ssss">
                    @php
                        $suppliers = $is_old ? old('supplier_id') ?? [] : $work_c->csSuppliers ?? [];
                    @endphp
                    @if ($formType == 'edit')
                        @foreach ($suppliers as $supplier_key => $supplier)
                        @php
                             $checked_supplier = $is_old ? isset(old('checked_supplier')[$supplier_key]) ?? false : $supplier->is_checked ?? false;
                        @endphp
                            <div class="mt-4 row px-3">
                                <div class="col-md-12 pt-2 pl-3 border border-primary">

                                    <div class="row mb-3 pl-0">
                                        <div class="col-xl-4 col-md-4">
                                            <div class="input-group input-group-sm input-group-primary">
                                                <label class="input-group-addon" for="effective_date">Supplier Name<span class="text-danger">*</span></label>
                                                <input type="hidden" name="supplier_id[]" value="{{ $supplier->supplier_id }}" class="supplier_id">
                                                <input type="text" name="supplier_name[]" class="form-control supplier_name" autocomplete="off" required value="{{ $supplier->supplier->name }}">
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-md-4">
                                            <div class="form-check">
                                                <label class="form-check-label" for="">
                                                    <input name="checked_supplier[]" @if ($checked_supplier) checked @endif class="form-check-input checked_supplier_id" type="checkbox" id="flexCheckDefault[]" value="{{ $supplier->supplier_id }}">
                                                    Mark as selected
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-md-4">
                                            <i class="btn btn-danger btn-sm fa fa-minus deleteItem float-right"></i>
                                        </div>
                                    </div>

                                    <div class="table-responsive">
                                        <table id="optionTable" class="table text-center table-striped table-sm table-bordered optionTable">
                                            <thead>

                                                <tr>
                                                    <th> Details <span class="text-danger">*</span></th>
                                                    <th> Status/Value <span class="text-danger">*</span></th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody class="optionTabletbody">
                                                @foreach($supplier->csSupplierOptions as $option)
                                                    <tr>
                                                        <td>
                                                            <span>{{ $option->options->name }}</span>
                                                            <input type="hidden" name="option_id[{{ $option->options->name }}][]" value="{{$option->options->id }}"class="form-control form-control-sm collection_way" autocomplete="off" required>
                                                        </td>
                                                        <td>
                                                            <input type="text" name="option_value[{{ $option->options->name }}][]" value="{{ $option->value }}" class="form-control form-control-sm collection_way" autocomplete="off" required>
                                                        </td>
                                                        <td>
                                                            <i class="btn btn-danger btn-sm fa fa-minus deleteOptionItem"></i>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
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
                                                {{ $is_old ? old('material_name')[$supplier_key] : $material_value->material->name }}
                                            </td>
                                    @endif
                                    <td>
                                        <input type="text" name="price[]" value="{{ $is_old
                                        ? old('price')[$price_index++]
                                        : $work_c->csMaterialsSuppliers->where('boq_eme_cs_material_id', $material_value->id)->where('boq_eme_cs_supplier_id', $supplier_value->id)->first()->price }}" class="form-control" placeholder="Pricez" required />
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

        function addSupplier() {
            $('#ssss').append(
                `
                <div class="mt-4 row px-3">
                    <div class="col-md-12 pt-2 pl-3 border border-primary">

                        <div class="row mb-3 pl-0">
                            <div class="col-xl-4 col-md-4">
                                <div class="input-group input-group-sm input-group-primary">
                                    <label class="input-group-addon" for="effective_date">Supplier Name<span class="text-danger">*</span></label>
                                    <input type="hidden" name="supplier_id[]" class="supplier_id">
                                    <input type="text" name="supplier_name[]" class="form-control supplier_name" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-4">
                                <div class="form-check">
                                    <label class="form-check-label" for="">
                                        <input name="checked_supplier[]" class="form-check-input checked_supplier_id" type="checkbox" id="flexCheckDefault[]">
                                        Mark as selected
                                    </label>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-4">
                                <i class="btn btn-danger btn-sm fa fa-minus deleteItem float-right"></i>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table id="optionTable" class="table text-center table-striped table-sm table-bordered optionTable">
                                <thead>

                                    <tr>
                                        <th> Details <span class="text-danger">*</span></th>
                                        <th> Status/Value <span class="text-danger">*</span></th>
                                        <th><th/>
                                    </tr>
                                </thead>
                                <tbody class="optionTabletbody">
                @foreach($supplier_options as $options)
                    <tr>
                        <td>
                            <span>{{ $options->name }}</span>
                            <input type="hidden" name="option_id[{{ $options->name }}][]" value="{{ $options->id }}"class="form-control form-control-sm collection_way" autocomplete="off" required>
                        </td>
                        <td>
                            <input type="text" name="option_value[{{ $options->name }}][]" class="form-control form-control-sm collection_way" autocomplete="off" required>
                        </td>
                        <td>
                            <i class="btn btn-danger btn-sm fa fa-minus deleteOptionItem"></i>
                        </td>

                    </tr>
                @endforeach
                </tbody>
                </table>
                </div>
                </div>
            </div>`
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
                     $("#project_name").autocomplete({
                    source: function( request, response ) {
                        $.ajax({
                            url:"{{route('projectAutoSuggest')}}",
                            type: 'post',
                            dataType: "json",
                            data: {
                                _token: CSRF_TOKEN,
                                search: request.term
                            },
                            success: function( data ) {
                                response( data );
                            }
                        });
                    },
                    select: function (event, ui) {
                        $('#project_name').val(ui.item.label);
                        $('#project_id').val(ui.item.value);
                        return false;
                    }
                });
            });
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
                        $(this).parent('div').parent('div').parent('div').find('.supplier_name').val(ui.item.label);
                        $(this).parent('div').parent('div').parent('div').find('.supplier_id').val(ui.item.value);
                        $(this).parent('div').parent('div').parent('div').find('.checked_supplier_id').val(ui.item.value);
                        $(this).parent('div').parent('div').parent('div').find('.address').val(ui.item.address);
                        $(this).parent('div').parent('div').parent('div').find('.contact').val(ui.item.contact);

                        changeCsColumn($(this).parent('div').parent('div').parent('div').parent('div').parent('div'), ui.item.label);
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

            $(document).on('click', '.addSupplier', function() {
                addSupplier();
                addCsColumn();
            }).on('click', '.deleteItem', function() {
                removeCsColumn($(this).parent('div').parent('div').index() + 1);
                $(this).parent('div').parent('div').remove();
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
        $(document).on('click','.deleteOptionItem', function(){

            let optionTable = $('.optionTabletbody');
            var rowIndex = $(this).closest('tr').prop('rowIndex');
                $('.optionTabletbody tr').filter(function () {
                    return this.rowIndex === rowIndex;
                }).remove();
        });

        $(select_all_projects);
        $("#select_all_projects").change(select_all_projects);
    </script>
@endsection
