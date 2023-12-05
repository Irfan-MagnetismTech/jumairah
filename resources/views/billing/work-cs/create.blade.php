@extends('layouts.backend-layout')
@section('title', 'Comparative Statements')

@php
    $is_old = old('effective_date') ? true : false;
    $form_heading = !empty($workC->id) ? 'Update' : 'Add';
    $form_url = !empty($workC->id) ? route('work-cs.update', $workC->id) : route('work-cs.store');
    $form_method = !empty($workC->id) ? 'PUT' : 'POST';
@endphp

@section('breadcrumb-title')
    {{ ucfirst($form_heading) }} Comparative Statement & Supplier
@endsection

@section('breadcrumb-button')
    <a href="{{ route('work-cs.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', null)

@section('content')
    <style>
        /* .ck-editor__editable
     {
        min-height: 150px !important;
        max-height: 400px !important;

     } */

        /* .switch input {
          top: 0;
          right: 0;
          bottom: 0;
          left: 0;
          -ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
          filter: alpha(opacity=0);
          -moz-opacity: 0;
          opacity: 0;
          z-index: 100;
          position: absolute;
          width: 100%;
          height: 100%;
          cursor: pointer;
        }

        .switch {
          width: 130px;
          height: 30px;
          position: relative;
          margin: 10px auto;
                top: 0px;
        }

        .switch label {
          display: block;
          width: 82%;
          height: 95%;
          position: relative;
          background: #fffff;
            background: linear-gradient(#ccadad, #c78585);
          border-radius: 30px 30px 30px 30px;
          box-shadow:
                inset 0 3px 8px 1px rgba(92, 31, 71,0.5),
                inset 0 1px 0 rgba(105, 45, 102,0.5),
                0 1px 0 rgba(255,255,255,0.2);
            -webkit-transition: all .5s ease;
        transition: all .5s ease;

        }

        .switch input ~ label i {
            display: block;
            height: 51px;
            width: 51px;
            position: absolute;
            left: 2px;
            top: 1px;
            z-index: 2;
            border-radius: inherit;
            background: #a19a16;
            background: linear-gradient(#615d06, #ccbe08);
            box-shadow:
                inset 0 1px 0 rgba(255,255,255,0.2),
                0 0 8px rgba(0,0,0,0.3),
                0 12px 12px rgba(0,0,0,0.4);
          -webkit-transition: all .5s ease;
        transition: all .5s ease;
        }


        .switch label + span {
          content: "";
          display: inline-block;
          position: absolute;
          right: 0px;
          top: 18px;
          width: 19px;
          height: 18px;
          border-radius: 11px;
          background: #b0a70e;
        background: gradient-gradient(#450a54, #69063e);
        box-shadow:
              inset 0 1px 0 rgba(128, 8, 32,0.2),
              0 1px 0 rgba(255,255,255,0.1),
              0 0 10px rgba(114,200,210,0.3),
          inset 0 0 8px rgba(142,141,118,0.9),
          inset 0 -2px 5px rgba(0,0,0,0.3),
          inset 0 -5px 5px rgba(0,0,0,0.5);
          -webkit-transition: all .5s ease;
          transition: all .5s ease;
          z-index: 2;
        }


        .fa-plane {
          position: absolute;
          z-index: 6;
          top: 10px;
          left: 9px;
          -webkit-transform: rotate(15deg);
          transform: rotate(15deg);
          font-size: 35px;
          color: white;
        }

        .switch input:checked ~ label + span {
          content: "";
          display: inline-block;
          position: absolute;
          width: 19px;
          height: 18px;
          border-radius: 10px;
          -webkit-transition: all .5s ease;
          transition: all .5s ease;
          z-index: 2;
          background: #00e4ff;
        background: gradient-gradient(#ffffff, #226f9c);
        box-shadow:
              inset 0 1px 0 rgba(0,0,0,0.1),
              0 1px 0 rgba(255,255,255,0.1),
              0 0 10px rgba(114,200,210,1),
              inset 0 0 8px rgba( 61,157,247,0.8),
          inset 0 -2px 5px rgba(185,231,253,0.3),
          inset 0 -3px 8px rgba(185,231,253,0.5);

         }

        .switch input:checked ~ label i {
            left: auto;
            left: 63%;
          box-shadow:
                inset 0 1px 0 rgba(255,255,255,0.2),
                0 0 8px rgba(0,0,0,0.3),
                0 8px 8px rgba(0,0,0,0.3),
            inset -1px 0 1px #029bb8;

          -webkit-transition: all .5s ease;
        transition: all .5s ease;
        } */
    </style>


    {!! Form::open([
        'url' => $form_url,
        'method' => $form_method,
        'encType' => 'multipart/form-data',
        'class' => 'custom-form',
        'id' => 'tagForm',
    ]) !!}
    @if ($form_heading == 'Update' && $workC->is_saved == 0)
        <input type="hidden" name="draft_id" value="{{ $workC->id }}" id="draft_id" />
    @endif
    <input type="hidden" name="id" value="{{ $is_old ? old('id') : $workC->id ?? null }}" id="id" />
    {{-- Comparative Statement --}}
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="tableHeading">
                    <h5> <span>&#10070;</span>Comparative Statement<span>&#10070;</span> </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @php
                            $reference_no = $is_old ? old('reference_no') : $workC->reference_no ?? null;
                            $effective_date = $is_old ? old('effective_date') : $workC->effective_date ?? null;
                            $expiry_date = $is_old ? old('expiry_date') : $workC->expiry_date ?? null;
                            $description = $is_old ? old('description') : $workC->description ?? null;
                            $involvement = $is_old ? old('involvement') : $workC->involvement ?? null;
                            $remarks = $is_old ? old('remarks') : $workC->remarks ?? null;
                            $notes = $is_old ? old('notes') : $workC->notes ?? null;
                        @endphp
                        <div class="col-12">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="title"> CS Title <span
                                        class="text-danger">*</span></label>
                                {{ Form::text('title', old('title') ? old('title') : (!empty($workC) ? $workC->title : null), ['class' => 'form-control', 'id' => 'cs_title', 'autocomplete' => 'off', 'required']) }}
                            </div>
                        </div>
                        <div class="col-xl-6 col-md-6">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="cs_type">CS Type <span
                                        class="text-danger">*</span></label>
                                {{ Form::text('cs_type', old('cs_type') ? old('cs_type') : (!empty($workC) ? $workC->cs_type : null), ['class' => 'form-control', 'id' => 'cs_type', 'list' => 'cs_types', 'autocomplete' => 'off', 'required']) }}
                                <datalist id="cs_types">
                                    @foreach ($csTypes as $type)
                                        {{ $type }}
                                        <option value="{{ $type }}">{{ $type }}</option>
                                    @endforeach
                                </datalist>
                            </div>
                        </div>

                        <div class="col-xl-6 col-md-6">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="project_name">Project Name<span
                                        class="text-danger">*</span></label>
                                {{ Form::text('project_name', old('project_name') ? old('project_name') : (!empty($workC) ? $workC->project->name ?? 'n/a' : null), ['class' => 'form-control', 'id' => 'project_name', 'autocomplete' => 'off', 'required']) }}
                                {{ Form::hidden('project_id', old('project_id') ? old('project_id') : (!empty($workC) ? $workC->project_id : null), ['class' => 'form-control', 'id' => 'project_id', 'autocomplete' => 'off', 'required']) }}
                            </div>
                        </div>
                        <div class="col-xl-6 col-md-6">
                            {{-- <div class="switch">
                                <input type="checkbox" name="toggle">
                                <label for="toggle"><i><div class="fa fa-plane"></div></i></label>
                                <span></span>
                              </div> --}}
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="project_name"
                                    style="display: block;padding-left: 15px;text-indent: -15px;">Applied For All<span
                                        class="text-danger">*</span>

                                </label>
                                <input type="checkbox" name="is_for_all" value="1"
                                    style=" width: 13px;height: 13px;padding: 0;margin:0;vertical-align: bottom;position: relative;top: 0.5rem;left: 0.5rem;*overflow: hidden;"
                                    class="form-checkbox is_for_all" id="is_for_all"
                                    @if (isset($workC->is_for_all) && $workC->is_for_all == 1) checked @endif>
                            </div>
                        </div>

                        <div class="col-xl-6 col-md-6">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="effective_date">Reference No<span
                                        class="text-danger">*</span></label>
                                {{ Form::text('reference_no', $reference_no, ['class' => 'form-control', 'readonly', 'id' => 'reference_no', 'autocomplete' => 'off', 'placeholder' => '#Reference', 'required']) }}
                            </div>
                        </div>
                        <div class="col-xl-6 col-md-6">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="effective_date">Effective Date<span
                                        class="text-danger">*</span></label>
                                {{ Form::text('effective_date', $effective_date, ['class' => 'form-control', 'id' => 'effective_date', 'autocomplete' => 'off', 'placeholder' => 'Effective Date', 'required', 'readonly']) }}
                            </div>
                        </div>
                        <div class="col-xl-6 col-md-6">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="expiry_date">Expiry Date</label>
                                {{ Form::text('expiry_date', $expiry_date, ['class' => 'form-control', 'id' => 'expiry_date', 'autocomplete' => 'off', 'placeholder' => 'Expiry Date', 'required', 'readonly']) }}
                            </div>
                        </div>

                        <div class="mt-1 col-xl-12 col-md-12">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="description">Description </label>
                                {{ Form::textarea('description', $description, ['class' => 'form-control', 'id' => 'description', 'autocomplete' => 'off', 'placeholder' => 'Description of Work', 'rows' => 2]) }}
                            </div>
                        </div>

                        <div class="mt-1 col-xl-12 col-md-12">

                            <div class="page-body border">
                                <!-- Article Editor card start -->
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Involvement</h5>
                                    </div>
                                    <div class="card-block">
                                        <table id="involvmentTable"
                                            class="table text-center table-striped table-sm table-bordered">
                                            <thead>
                                                <tr>
                                                    <th> Details </th>
                                                    <th><i class="btn btn-primary btn-sm fa fa-plus addInvolvment"></i></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $details = $is_old ? old('detail') : (isset($workC) ? $workC->workCsInvolvment->pluck('detail') : []);
                                                @endphp
                                                @if (!empty($details))
                                                    @forelse ($details as $detail_key => $detail_value)
                                                        <tr>
                                                            <td>
                                                                <input type="text" name="detail[]"
                                                                    value="{{ $details[$detail_key] }}"
                                                                    class="form-control form-control-sm detail"
                                                                    tabindex="-1">
                                                            </td>
                                                            <td>
                                                                <i
                                                                    class="btn btn-danger btn-sm fa fa-minus deleteInvolvment"></i>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                    @endforelse
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- Article Editor card end -->
                            </div>
                        </div>

                        <div class="mt-1 col-xl-12 col-md-12">

                            <div class="page-body border">
                                <!-- Article Editor card start -->
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Remarks</h5>
                                    </div>
                                    <div class="card-block">
                                        {{ Form::textarea('remarks', $remarks, ['class' => 'form-control', 'id' => '', 'autocomplete' => 'off', 'placeholder' => 'Remarks']) }}
                                    </div>
                                </div>
                                <!-- Article Editor card end -->
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>

    <div id="cs">
        {{-- Suppliers --}}
        <div class="mt-2 row">
            <div class="col-md-12">
                <div class="card">
                    <div class="tableHeading">
                        <h5> <span>&#10070;</span>Suppliers<span>&#10070;</span> </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="supplierTable" class="table text-center table-striped table-sm table-bordered">
                                <thead>
                                    <tr>
                                        <th width="300px"> Supplier Name <span class="text-danger">*</span><br>
                                            <a href="{{ route('suppliers.create') }}" target="_blank" style="color: white">
                                                <u>Click Here to Add New Supplier</u>
                                            </a>
                                            <span style="font-size: 12px">
                                                <i class="fas fa-external-link-square-alt"></i>
                                            </span>
                                        </th>
                                        <th> Supplier Info </th>
                                        <th> VAT/ AIT </th>
                                        <th> Advanced </th>
                                        <th><i class="btn btn-primary btn-sm fa fa-plus addSupplier"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $suppliers = $is_old ? old('supplier_id') ?? [] : $workC->workCsSuppliers ?? [];
                                    @endphp

                                    @forelse ($suppliers as $supplier_key => $supplier_value)
                                        @php
                                            $supplier_id = $is_old ? old('supplier_id')[$supplier_key] : $supplier_value->supplier->id;
                                            $supplier_name = $is_old ? old('supplier_name')[$supplier_key] : $supplier_value->supplier->name;
                                            $checked_supplier = $is_old ? isset(old('checked_supplier')[$supplier_key]) ?? false : $supplier_value->is_checked ?? false;
                                            $address = $is_old ? old('address')[$supplier_key] : $supplier_value->supplier->address ?? '---';
                                            $contact = $is_old ? old('contact')[$supplier_key] : $supplier_value->supplier->contact ?? '---';
                                            $vat = $is_old ? old('vat')[$supplier_key] : $supplier_value->vat;
                                            $advanced = $is_old ? old('advanced')[$supplier_key] : $supplier_value->advanced;
                                        @endphp
                                        <tr>
                                            <td>
                                                <input type="hidden" name="supplier_id[]" value="{{ $supplier_id }}"
                                                    class="supplier_id">
                                                <div class="form-check">
                                                    <input name="checked_supplier[]"
                                                        @if ($checked_supplier) checked @endif
                                                        value="{{ $supplier_id }}"
                                                        class="form-check-input checked_supplier_id" type="checkbox"
                                                        id="flexCheckDefault">
                                                    <label class="form-check-label" for="flexCheckDefault">
                                                        Mark as selected
                                                    </label>
                                                </div>
                                                <input type="text" name="supplier_name[]"
                                                    value="{{ $supplier_name }}"
                                                    class="form-control form-control-sm supplier_name" autocomplete="off"
                                                    required>
                                            </td>
                                            <td>
                                                <input type="text" name="address[]" value="{{ $address }}"
                                                    class="form-control form-control-sm address" hidden tabindex="-1">
                                                <div>
                                                    <span><b>Address : </b></span>
                                                    <span class="address_div"> {{ $address }} </span>
                                                </div>
                                                <input type="hidden" name="contact[]" value="{{ $contact }}"
                                                    class="form-control form-control-sm contact" hidden autocomplete="off"
                                                    readonly tabindex="-1">
                                                <div>
                                                    <span><b>Contact : </b></span>
                                                    <span class="contact_div">{{ $contact }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <input type="text" name="vat[]" value="{{ $vat }}"
                                                    class="form-control form-control-sm vat" autocomplete="off">
                                            </td>
                                            <td>
                                                <input type="text" name="advanced[]" value="{{ $advanced }}"
                                                    class="form-control form-control-sm advanced" autocomplete="off">
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
        </div>

        {{-- Projects & Materials --}}
        <div class="mt-2 row">
            <div class="col-md-12">
                <div class="card">
                    <div class="tableHeading">
                        <h5> <span>&#10070;</span> Works <span>&#10070;</span> </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="workTable" class="table text-center table-striped table-sm table-bordered">
                                <thead>
                                    <tr>
                                        <th>Level of Work<span class="text-danger">*</span></th>
                                        <th>Description<span class="text-danger">*</span></th>
                                        <th>Apprx Qty</th>
                                        <th>Unit</th>
                                        <th><i class="btn btn-primary btn-sm fa fa-plus addWorkLevel"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $allWorks = $is_old ? old('material_id') ?? [] : $workC->workCsLines ?? [];
                                    @endphp

                                    @forelse ($allWorks as $material_key => $work)
                                        @php
                                            $work_level = $is_old ? old('work_level')[$material_key] : $work->work_level;
                                            $work_description = $is_old ? old('work_description')[$material_key] : $work->work_description;
                                            $work_quantity = $is_old ? old('work_quantity')[$material_key] : $work->work_quantity ?? '---';
                                            $work_unit = $is_old ? old('work_unit')[$material_key] : $work->work_unit ?? '---';
                                        @endphp

                                        <tr>
                                            <td>
                                                <input type="text" name="work_level[]" value="{{ $work_level }}"
                                                    class="form-control form-control-sm work_level" autocomplete="off"
                                                    required>
                                            </td>
                                            <td>
                                                <textarea name="work_description[]" class="form-control form-control-sm work_description" rows=2 required>{{ $work_description }}</textarea>
                                            </td>
                                            <td> <input type="number" name="work_quantity[]"
                                                    value="{{ $work_quantity }}" class="form-control work_quantity"
                                                    step="0.01" required /> </td>
                                            <td>
                                                <select name="work_unit[]" class="form-control form-control-sm">
                                                    <option>Select Unit</option>
                                                    @foreach ($units as $unit)
                                                        <option value="{{ $unit }}"
                                                            {{ $work_unit == $unit ? 'selected' : null }}>
                                                            {{ $unit }} </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <i class="btn btn-danger btn-sm fa fa-minus deleteItem"></i>
                                                <i class="btn btn-primary btn-sm fa fa-plus addWorkNextLevel"></i>
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
        </div>


        <hr>
    </div>

    <hr>


    {{-- Comparative Statement Details --}}
    <div id="cs_details">
        <div class="mt-4 row">
            <div class="col-md-12">
                <div class="card">
                    <div class="tableHeading">
                        <h5> <span>&#10070;</span> Comparative Statement Details <span>&#10070;</span> </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="csDetailsTable" class="table text-center table-striped table-sm table-bordered">
                                <thead>
                                    <tr>
                                        <th>Level Work</th>
                                        <th>Apprx. Qty</th>
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
                                    @forelse ($allWorks as $work_key => $work)
                                        @forelse ($suppliers as $supplier_key => $supplier_value)
                                            @if ($loop->first)
                                                <tr>
                                                    <td class="cs_level"> {{ $work->work_level }} </td>
                                                    <td class="cs_quantity">{{ $work->work_quantity }} </td>
                                            @endif
                                            <td>
                                                <input type="number" name="price[]"
                                                    value="{{ $workC->csSuppliersRates->where('work_cs_line_id', $work->id)->where('work_cs_supplier_id', $supplier_value->supplier_id)->first()->price }}"
                                                    class="form-control price" placeholder="Price" step="0.01"
                                                    required />
                                            </td>
                                            @if ($loop->last)
                                                </tr>
                                            @endif
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
        </div>
    </div>
    <div class="row">
        <div class="mt-1 col-xl-12 col-md-12">

            <div class="page-body border">
                <!-- Article Editor card start -->
                <div class="card">
                    <div class="card-header">
                        <h5>Notes</h5>
                    </div>
                    <div class="card-block">
                        {{ Form::textarea('notes', $notes ?? null, ['class' => 'form-control', 'id' => '', 'autocomplete' => 'off', 'placeholder' => 'Notes', 'rows' => 2, 'style' => 'visibility: hidden; display: none;']) }}
                    </div>
                </div>
                <!-- Article Editor card end -->
            </div>
        </div>
    </div>
    @if (($form_heading == 'Update' && $workC->is_saved == 0) || $form_heading == 'Add')
        <div class="row">
            <div class="mt-2 offset-md-2 col-md-4">
                <div class="input-group input-group-sm ">
                    <button class="py-2 btn btn-success btn-round btn-block">Save</button>
                </div>
            </div>
            <div class="mt-2 col-md-4">
                <div class="input-group input-group-sm">
                    <button class="py-2 btn btn-success btn-round btn-block" id='draft_button'>Save as draft</button>
                </div>
            </div>
        </div>
    @else
        <div class="row">
            <div class="mt-2 offset-md-4 col-md-4">
                <div class="input-group input-group-sm ">
                    <button class="py-2 btn btn-success btn-round btn-block">Save</button>
                </div>
            </div>
        </div>
    @endif
    {!! Form::close() !!}
@endsection

@section('script')
    <script src="{{ asset('js/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('js/ckeditor/ckeditor-custom.js') }}"></script>
    <script>
        $(document).ready(function() {
            CKEDITOR.replace('notes', {
                toolbar: [{
                    name: 'document',
                    items: ['Print']
                }, {
                    name: 'clipboard',
                    items: ['Undo', 'Redo']
                }, {
                    name: 'styles',
                    items: ['Format', 'Font', 'FontSize']
                }, {
                    name: 'basicstyles',
                    items: ['Bold', 'Italic', 'Underline', 'Strike', 'RemoveFormat',
                        'CopyFormatting'
                    ]
                }, {
                    name: 'colors',
                    items: ['TextColor', 'BGColor']
                }, {
                    name: 'align',
                    items: ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock']
                }, {
                    name: 'links',
                    items: ['Link', 'Unlink']
                }, {
                    name: 'paragraph',
                    items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-',
                        'Blockquote'
                    ]
                }, {
                    name: 'insert',
                    items: ['Image', 'Table']
                }, {
                    name: 'tools',
                    items: ['Maximize']
                }, {
                    name: 'editing',
                    items: ['Scayt']
                }],
                width: '100%', // set the initial width to 100%
                resize_enabled: true, // allow the user to resize the editor
                startup_resize: true, // resize the editor on startup
            });


            //     CKEDITOR.replace('remarks', {
            //     toolbar: [{
            // name: 'document',
            // items: ['Print']
            //     }, {
            //         name: 'clipboard',
            //         items: ['Undo', 'Redo']
            //     }, {
            //         name: 'styles',
            //         items: ['Format', 'Font', 'FontSize']
            //     }, {
            //         name: 'basicstyles',
            //         items: ['Bold', 'Italic', 'Underline', 'Strike', 'RemoveFormat', 'CopyFormatting']
            //     }, {
            //         name: 'colors',
            //         items: ['TextColor', 'BGColor']
            //     }, {
            //         name: 'align',
            //         items: ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock']
            //     }, {
            //         name: 'links',
            //         items: ['Link', 'Unlink']
            //     }, {
            //         name: 'paragraph',
            //         items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote']
            //     }, {
            //         name: 'insert',
            //         items: ['Image', 'Table']
            //     }, {
            //         name: 'tools',
            //         items: ['Maximize']
            //     }, {
            //         name: 'editing',
            //         items: ['Scayt']
            //     }],
            //         width: '100%', // set the initial width to 100%
            //         resize_enabled: true, // allow the user to resize the editor
            //         startup_resize: true, // resize the editor on startup
            //     });

            CKEDITOR.replace('involvement', {
                toolbar: [{
                    name: 'document',
                    items: ['Print']
                }, {
                    name: 'clipboard',
                    items: ['Undo', 'Redo']
                }, {
                    name: 'styles',
                    items: ['Format', 'Font', 'FontSize']
                }, {
                    name: 'basicstyles',
                    items: ['Bold', 'Italic', 'Underline', 'Strike', 'RemoveFormat',
                        'CopyFormatting'
                    ]
                }, {
                    name: 'colors',
                    items: ['TextColor', 'BGColor']
                }, {
                    name: 'align',
                    items: ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock']
                }, {
                    name: 'links',
                    items: ['Link', 'Unlink']
                }, {
                    name: 'paragraph',
                    items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-',
                        'Blockquote'
                    ]
                }, {
                    name: 'insert',
                    items: ['Image', 'Table']
                }, {
                    name: 'tools',
                    items: ['Maximize']
                }, {
                    name: 'editing',
                    items: ['Scayt']
                }],
                width: '100%', // set the initial width to 100%
                resize_enabled: true, // allow the user to resize the editor
                startup_resize: true, // resize the editor on startup
            });
        });




        var CSRF_TOKEN = "{{ csrf_token() }}";
        let is_confirmed = false;

        // Appends work levels
        function addWorkLevel() {
            $('#workTable tbody').append(
                `<tr>
                    <td>
                        <input type="text" name="work_level[]" class="form-control form-control-sm work_level" autocomplete="off" required>
                    </td>
                    <td>
                        <textarea name="work_description[]" class="form-control form-control-sm work_description" rows=2 required> </textarea>
                    </td>
                    <td> <input type="number" name="work_quantity[]" class="form-control work_quantity" step="0.01" required/> </td>
                    <td>
                        <select name="work_unit[]" class="form-control form-control-sm">
                            <option>Select Unit</option>
                            @foreach ($units as $unit)
                                <option value="{{ $unit }}"> {{ $unit }} </option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <i class="btn btn-danger btn-sm fa fa-minus deleteItem"></i>
                        <i class="btn btn-primary btn-sm fa fa-plus addWorkNextLevel"></i>
                    </td>
                </tr>`
            );
        }

        // Appends row for supplier
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
                        <input type="text" name="vat[]" class="form-control form-control-sm" autocomplete="off">
                    </td>
                    <td>
                        <input type="text" name="advanced[]" class="form-control form-control-sm" autocomplete="off">
                    </td>
                    <td>
                        <i class="btn btn-danger btn-sm fa fa-minus deleteItem"></i>
                    </td>
                </tr>`
            );
        }

        function addInvolvment() {
            $('#involvmentTable tbody').append(
                `<tr>
                    <td>
                        <input type="text" name="detail[]" class="form-control form-control-sm detail" autocomplete="off">
                    </td>
                    <td>
                        <i class="btn btn-danger btn-sm fa fa-minus deleteInvolvment"></i>
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

        // Changes work level
        function changeCsRow(column) {
            let work_level = $(column).find('.work_level').val();
            let work_quantity = $(column).find('.work_quantity').val();
            let cs_details_table_body = $('#csDetailsTable tbody');
            cs_details_table_body.children(`tr:eq(${column.index()})`).find(".cs_level").html(work_level);
            cs_details_table_body.children(`tr:eq(${column.index()})`).find(".cs_quantity").html(work_quantity);
        }

        // Appends a CS column. Here, the 'Work levels' are used as column.
        function addCsRow() {
            let cs_details_table_tbody = $('#csDetailsTable tbody');
            let count_supplier = $('.supplier_name').length ? 0 : $('.supplier_name').length;
            let table_data = `<tr>
                <td colspan="${count_supplier}" class="cs_level">Select a work level</td>
                <td colspan="${count_supplier}" class="cs_quantity">Apprx.Qty</td>
            `;

            $('.supplier_name').each(function() {
                table_data +=
                    `<td> <input type="number" name="price[]" class="form-control" placeholder="Price" step="0.01" required/> </td>`;
            });
            cs_details_table_tbody.append(table_data += `</tr>`);
        }

        // Removes a CS row
        function removeCsRow(index) {
            let cs_details_table_body = $('#csDetailsTable tbody');
            cs_details_table_body.children(`tr:eq(${index})`).remove();
        }

        // Cs Details Column
        function changeCsColumn(column, supplier_name) {
            let cs_details_table_head = $('#csDetailsTable thead tr');
            let th = cs_details_table_head.children(`th:eq(${column.index() + 2})`).html(`Rate <br> (${supplier_name})`);
        }

        // Appends a CS column. Here, the 'suppliers' are used as column.
        function addCsColumn() {
            $('#csDetailsTable thead tr').append(`<th>Select a Supplier</th>`);

            let cs_details_table_body = $('#csDetailsTable tbody');
            $("#csDetailsTable tbody tr").each(function() {
                $(this).append(
                    `<td> <input type="number" name="price[]" class="form-control" placeholder="Price" step="0.01" required/> </td>`
                    );
            });
        }


        // Remove a CS column
        function removeCsColumn(index) {
            let cs_details_table_head = $('#csDetailsTable thead tr');
            cs_details_table_head.children(`th:eq(${index})`).remove();

            let cs_details_table_body = $('#csDetailsTable tbody');
            $("#csDetailsTable tbody tr").each(function() {
                $(this).children(`td:eq(${index})`).remove();
            });
        }

        // document.ready
        $(function() {
            $("#project_name").autocomplete({
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
                    $('#project_name').val(ui.item.label);
                    $('#project_id').val(ui.item.value);
                    return false;
                }
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
            $(document).on('keyup', ".work_level, .work_quantity", function() {
                changeCsRow($(this).closest('tr'));
            });

            $("#workTable").on('click', '.addWorkNextLevel', function() {
                let rowIndex = $(this).closest('tr').prop('rowIndex');
                $(this).closest('tr').after(`<tr>
                    <td>
                        <input type="text" name="work_level[]" class="form-control form-control-sm work_level" autocomplete="off" required>
                    </td>
                    <td>
                        <textarea name="work_description[]" class="form-control form-control-sm work_description" rows=2 required> </textarea>
                    </td>
                    <td> <input type="number" name="work_quantity[]" class="form-control work_quantity" step="0.01" required/> </td>
                    <td>
                        <select name="work_unit[]" class="form-control form-control-sm">
                            <option>Select Unit</option>
                            @foreach ($units as $unit)
                                <option value="{{ $unit }}"> {{ $unit }} </option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <i class="btn btn-danger btn-sm fa fa-minus deleteItem"></i>
                        <i class="btn btn-primary btn-sm fa fa-plus addWorkNextLevel"></i>
                    </td>
                </tr>`);
                addCsRowNext(rowIndex);
            });

            function addCsRowNext(rowIndex) {
                let cs_details_table_tbody = $('#csDetailsTable tbody');
                let count_supplier = $('.supplier_name').length ? 0 : $('.supplier_name').length;
                let table_data = `<tr>
                <td colspan="${count_supplier}" class="cs_level">Select a work level</td>
                <td colspan="${count_supplier}" class="cs_quantity">Apprx.Qty</td>
            `;

                $('.supplier_name').each(function() {
                    table_data +=
                        `<td> <input type="number" name="price[]" class="form-control" placeholder="Price" step="0.01" required/> </td>`;
                });
                var row = cs_details_table_tbody.find('tr').eq(rowIndex - 1);
                row.after(table_data += `</tr>`)
            }

            $("#workTable").on('click', '.addWorkLevel', function() {
                addWorkLevel();
                addCsRow();
            }).on('click', '.deleteItem', function() {
                removeCsRow($(this).closest('tr').index());
                $(this).closest('tr').remove();
            });

            $("#supplierTable").on('click', '.addSupplier', function() {
                addSupplier();
                addCsColumn();
            }).on('click', '.deleteItem', function() {
                removeCsColumn($(this).closest('tr').index() + 2);
                $(this).closest('tr').remove();
            });
            $("#involvmentTable").on('click', '.addInvolvment', function() {
                addInvolvment();
            }).on('click', '.deleteInvolvment', function() {
                $(this).closest('tr').remove();
            });


            $('#expiry_date,#effective_date').datepicker({
                format: "dd-mm-yyyy",
                autoclose: true,
                todayHighlight: true,
                showOtherMonths: true
            });
            $(document).ready(function() {})

        });
        @if (($form_heading == 'Update' && $workC->is_saved == 0) || $form_heading == 'Add')
            var CSRF_TOKEN = "{{ csrf_token() }}";
            $(document).ready(function() {
                $('#draft_button').on('click', function(e) {
                    e.preventDefault();
                    var tagForm = document.getElementById('tagForm');
                    tagForm.action = "{{ route('WorkCs.DraftSave') }}";
                    tagForm.method = 'POST';
                    $('input[name=_method]').remove();
                    tagForm.submit();
                })
            })
        @endif
    </script>
@endsection
