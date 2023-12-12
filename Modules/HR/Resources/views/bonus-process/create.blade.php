@extends('layouts.backend-layout')
@section('title', 'Bonus Process')

@section('breadcrumb-title')
@if ($formType == 'edit')
Edit
@else
Create
@endif
Bonus Process
@endsection

@section('style')
<style scoped>
    .input-group-addon {
        min-width: 120px;
    }
</style>
@endsection
@section('breadcrumb-button')
<a class="btn btn-out-dashed btn-sm btn-warning" href="{{ route('bonus-process.index') }}"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
<span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'col-md-12 col-lg-12')

@section('content')
@if ($formType == 'create')
{!! Form::open(['url' => 'hr/bonus-process', 'method' => 'POST', 'class' => 'custom-form', 'files' =>
true,'enctype'=>'multipart/form-data']) !!}
@else
{!! Form::open([
'url' => "hr/bonus-process/$processed_bonus->id",
'method' => 'PUT',
'class' => 'custom-form',
'files' => true,
'enctype'=>'multipart/form-data',
]) !!}
@endif

<div class="row">
    <div class="col-6">
        <div class="input-group input-group-sm input-group-primary">
            <label style="min-width: 22% !important; max-width:22% !important;" class="input-group-addon" for="date">Date <span class="text-danger">*</span></label>
            {{ Form::text('date', old('date')
            ? old('date')
            : (!empty($processed_bonus->date)
            ? $processed_bonus->date
            : now()->format('Y-m-d')), ['class' => 'form-control date-picker', 'id' => 'date', 'autocomplete' => 'off', 'required']) }}
            @error('date')
            <p class="text-danger">{{ $errors->first('date') }}</p>
            @enderror
        </div>
    </div>

    {{-- <div class="col-6">
        <div class="input-group input-group-sm input-group-primary">
            <label style="min-width: 22% !important; max-width: 22% !important" class="input-group-addon" for="name">Product Type <span class="text-danger">*</span></label>
            {{ Form::select(
            'product_type_id',
            $product_types,
            old('product_type_id')
            ? old('product_type_id')
            : (!empty($product_purchase_requisition->product_type_id)
            ? $product_purchase_requisition->product_type_id
            : null),
            ['class' => 'form-control select2', 'id' => 'product_type_id', 'placeholder' => 'Select Product Type', 'required'],
            ) }}
            @error('product_type_id')
            <p class="text-danger">{{ $errors->first('product_type_id') }}</p>
            @enderror
        </div>
    </div> --}}
    <div class="col-6">
        <div class="input-group input-group-sm input-group-primary">
            <label style="min-width: 22% !important; max-width:22% !important;" class="input-group-addon" for="bonus_id">Bonus</label>

            {{Form::select('bonus_id', $bonuses, old('bonus_id') ? old('bonus_id') : (!empty($processed_bonus->bonus_id) ? $processed_bonus->bonus_id : null ),['class' => 'form-control','id' => 'bonus_id', 'placeholder'=>"Select Bonus", 'required'])}}
            @error('bonus_id')
                <p class="text-danger">{{ $errors->first('bonus_id') }}</p>
            @enderror
        </div>
    </div>
{{-- {{ dd($processed_bonus->processedBonusDetails?->first()?->employee?->department_id) }} --}}
    <div class="col-6">
        <div class="input-group input-group-sm input-group-primary">
            <label style="min-width: 22% !important; max-width: 22% !important" class="input-group-addon" for="department_id">Department <span class="text-danger">*</span></label>
            {{Form::select('department_id', $departments, old('department_id') ? old('department_id') : (!empty($processed_bonus) ? $processed_bonus->processedBonusDetails?->first()?->employee?->department_id : null ),['class' => 'form-control','id' => 'department_id', 'placeholder'=>"Select Department", 'required'])}}
            @error('department_id')
                <p class="text-danger">{{ $errors->first('department_id') }}</p>
            @enderror
        </div>
    </div>



    <div class="col-6">
        <div class="input-group input-group-sm input-group-primary">
            <label style="min-width: 22% !important; max-width:22% !important;" class="input-group-addon" for="employee_id">Employee</label>
            {{-- {{Form::select('employee_id', $employees, old('employee_id'),['class' => 'form-control','id' => 'employee_id', 'placeholder'=>"All", 'autocomplete'=>"off", ""])}} --}}
            {{-- <select name="employee_id[]" class="form-control select2" data-placeholder="All" id="employee_id"  multiple>
            </select> --}}
            {{ Form::select(
                'employee_id[]',
                $employees,
                old('employee_id')
                ? old('employee_id')
                : (!empty($processed_bonus->employee_id)
                ? json_decode($processed_bonus->employee_id)
                : null),
                ['class' => 'form-control select2', 'id' => 'employee_id' ,'multiple', 'data-placeholder' => 'All'],
                ) }}
            @error('employee_id')
                <p class="text-danger">{{ $errors->first('employee_id') }}</p>
            @enderror
        </div>
    </div>


</div><!-- end row -->



<div class="row">
    <div class="offset-md-4 col-md-4 mt-2 ">
        <div class="input-group input-group-sm ">
            <button class="btn btn-success btn-round btn-block py-2">Submit</button>
        </div>
    </div>
</div> <!-- end row -->
{!! Form::close() !!}
@endsection

@php



$row_count = 1;
if(old('productpurchaserequisitiondetails')){
$row_count = count(old('productpurchaserequisitiondetails'));

}
elseif(!empty($product_purchase_requisition)){
$row_count = count($product_purchase_requisition->productpurchaserequisitiondetails);
}

@endphp



@section('script')
{{-- <script>
    let row_count = '{{ $row_count }}';
    let product_option = '';
    $(document).ready(function() {

        $('.select2').select2();
    })

    $(document).on('change', '#product_type_id', function(params) {
        let product_type_id = $(this).val();
        let product_dropdown = $('.product_dropdown');
        if (product_type_id) {
            $.ajax({
                url: '{{ route("product.product-requisitions.fetchProductPurchaseInfoByType") }}',
                type: 'POST',
                data: {
                    '_token': '{{ csrf_token() }}',
                    'product_type_id': product_type_id
                },
                success: function(data) {
                    $('#product_requisitions_ids').html(data);
                    $('.select2').select2({
                        'placeholder': 'Select Requisition',
                    });
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });

            $.ajax({
                url: '{{ route("products.getProductByType") }}',
                type: 'POST',
                data: {
                    '_token': '{{ csrf_token() }}',
                    'product_type_id': product_type_id
                },
                success: function(data) {
                    product_dropdown.html('');
                    product_dropdown.append('<option value="">Select Product</option>');
                    product_option += '<option value="">Select Product</option>';
                    $.each(data, function(key, value) {
                        product_dropdown.append(`<option value="${value.id}">${value.text}</option>`);
                        product_option += `<option value="${value.id}">${value.text}</option>`;
                    })
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
    })

    //add row
    $(document).on('click', '.add-row', function() {
        row_count++;
        let html = '';
        html += `<tr id=row_${row_count}>
            <td>
                <select required name="productpurchaserequisitiondetails[${row_count}][product_id]" class="form-control product_dropdown select2" id="product_id_${row_count}" onchange="LoadUnitByProductId('${row_count}');">
                    ${product_option}
                </select>
            </td>
            <td><input class="form-control" id="product_unit_${row_count}" disabled /></td>
            <td>
                <input required placeholder="Qty" type="number" name="productpurchaserequisitiondetails[${row_count}][qty]" class="form-control" id="product_qty_${row_count}" onchange="UpdateRemainQty('${row_count}')">
                <input type="hidden" name="productpurchaserequisitiondetails[${row_count}][remain_qty]" class="form-control" id="remain_qty_${row_count}">
            </td>
            <td><button type="button" class="btn btn-danger btn-sm remove-row"><i class="ti-minus"></i></button></td>
        </tr>`;

        $('tbody').append(html);

        $('.select2').select2();
    });

    //remove row
    $(document).on('click', '.remove-row', function() {
        $(this).closest('tr').remove();
    });



    function LoadUnitByProductId(rowid) {
        let product_id = $(`#product_id_${rowid}`).val();
        if (rowid) {
            $.ajax({
                url: '{{ route("product.getUnitNameByProductId") }}',
                type: 'POST',
                data: {
                    '_token': '{{ csrf_token() }}',
                    'product_id': product_id
                },
                success: function(data) {
                    $(`#product_unit_${rowid}`).val(data);

                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
    }

    function UpdateRemainQty(rowid) {
        $(`#remain_qty_${rowid}`).val($(`#product_qty_${rowid}`).val());
    }



</script> --}}
<script>
    $(document).ready(function() {
        $('#category_id').change(()=>{
            $.ajax({
                url: "{{ route('getCategoryWiseProducts') }}",
                type: 'GET',
                dataType: 'json',
                data: {
                    _token: '{{ csrf_token() }}',
                    category_id: $('#category_id').val()
                },
                success: function(response) {
                    $('.product_id').empty();
                    $('.product_id').append('<option value="">' + "All" + '</option>');
                    $.each(response, function(index, value) {

                        $('.product_id').append('<option value="' + value.id + '">' + value
                            .text + '</option>');
                    });
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus + ': ' + errorThrown);
                }
            });
        });

        $('#employee_type_id').change(()=>{
            $.ajax({
                url: "{{ route('getTypeWiseEmployees') }}",
                type: 'GET',
                dataType: 'json',
                data: {
                    _token: '{{ csrf_token() }}',
                    employee_type_id: $('#employee_type_id').val()
                },
                success: function(response) {
                    $('#employee_id').empty();
                    $('#employee_id').append('<option value="">' + "All" + '</option>');
                    $.each(response, function(index, value) {

                        $('#employee_id').append('<option value="' + value.id + '">' + value
                            .text + '</option>');
                    });
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus + ': ' + errorThrown);
                }
            });
        });

        $('#designation_id').change(()=>{
            $.ajax({
                url: "{{ route('getDesignationWiseEmployees') }}",
                type: 'GET',
                dataType: 'json',
                data: {
                    _token: '{{ csrf_token() }}',
                    designation_id: $('#designation_id').val()
                },
                success: function(response) {
                    $('#employee_id').empty();
                    $('#employee_id').append('<option value="">' + "All" + '</option>');
                    $.each(response, function(index, value) {

                        $('#employee_id').append('<option value="' + value.id + '">' + value
                            .text + '</option>');
                    });
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus + ': ' + errorThrown);
                }
            });
        });

        $('#department_id').change(()=>{
            $.ajax({
                url: "{{ route('getDepartmentWiseEmployees') }}",
                type: 'GET',
                dataType: 'json',
                data: {
                    _token: '{{ csrf_token() }}',
                    department_id: $('#department_id').val()
                },
                success: function(response) {
                    $('#employee_id').empty();
                    $('#employee_id').append('<option value="">' + "All" + '</option>');
                    $.each(response, function(index, value) {

                        $('#employee_id').append('<option value="' + value.id + '">' + value
                            .text + '</option>');
                    });
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus + ': ' + errorThrown);
                }
            });
        });

        $('#shift_id').change(()=>{
            $.ajax({
                url: "{{ route('getShiftWiseEmployees') }}",
                type: 'GET',
                dataType: 'json',
                data: {
                    _token: '{{ csrf_token() }}',
                    shift_id: $('#shift_id').val()
                },
                success: function(response) {
                    $('#employee_id').empty();
                    $('#employee_id').append('<option value="">' + "All" + '</option>');
                    $.each(response, function(index, value) {

                        $('#employee_id').append('<option value="' + value.id + '">' + value
                            .text + '</option>');
                    });
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus + ': ' + errorThrown);
                }
            });
        });

    });
</script>
@endsection
