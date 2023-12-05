@extends('layouts.backend-layout')
@section('title', 'Material Plan')

@section('breadcrumb-title')
        Make Material Plan
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', null)

@section('content')
    @if($formType == 'edit')
        {!! Form::open(array('url' => "construction/material_plan/$materialPlan->id",'method' => 'PUT', 'class'=>'custom-form','id' => 'tagForm')) !!}
        <input type="hidden" name="id" value="{{ $materialPlan->id }}"/>
    @else
        {!! Form::open(array('url' => 'construction/material_plan','method' => 'POST', 'class'=>'custom-form','id' => 'tagForm')) !!}
    @endif
    @if ($formType == 'edit' && $materialPlan->is_saved == 0)
        <input type="hidden" name="draft_id" value="{{ $materialPlan->id }}" id="draft_id" />
    @endif

        <div class="row">
            <div class="col-md-4">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="project_id">Project Name<span class="text-danger">*</span></label>
                    {{Form::select('project_id', $projects, old('project_id') ? old('project_id') : (!empty($materialPlan->project_id) ? $materialPlan->project_id : null),['class' => 'form-control','id' => 'project_id', 'placeholder'=>"Select Project Name", 'autocomplete'=>"off",'required'])}}
                </div>
            </div>
            <div class="col-md-4">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="from_date">From Date<span class="text-danger">*</span></label>
                    {{Form::text('from_date', old('from_date') ? old('from_date') : (!empty($materialPlan->from_date) ? $materialPlan->from_date : null),['class' => 'form-control from_date','id' => 'from_date','autocomplete'=>"off","required", 'placeholder' => 'From Date', 'readonly'])}}
                </div>
            </div>
            <div class="col-md-4">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="to_date">To Date<span class="text-danger">*</span></label>
                    {{Form::text('to_date', old('to_date') ? old('to_date') : (!empty($materialPlan->to_date) ? $materialPlan->to_date : null),['class' => 'form-control to_date','id' => 'to_date','autocomplete'=>"off","required", 'placeholder' => 'To Date', 'readonly'])}}
                </div>
            </div>
        </div>

    <hr class="bg-success">
<div class="row">
<div class="col-md-12">
    <div class="tableHeading">
        <h5> <span>&#10070;</span> Details <span>&#10070;</span> </h5>
    </div>
    <div class="table-responsive">
        <table id="Table" class="table table-striped table-sm text-center table-bordered" >
            <thead>
                <tr>
                    <th>Search<br> Material Name<span class="text-danger">*</span></th>
                    <th>Unit</th>
                    <th>Week-1<span class="text-danger">*</span></th>
                    <th>Week-2<span class="text-danger">*</span></th>
                    <th>Week-3<span class="text-danger">*</span></th>
                    <th>Week-4<span class="text-danger">*</span></th>
                    <th>Remarks</th>
                    <th>Total<br>Quantity</th>
                    <th><i class="btn btn-primary btn-sm fa fa-plus" id="addItem" onclick="addItemDtl()"> </i></th>
                </tr>
            </thead>
            <tbody>
                @if(old('material_id'))
                    @foreach(old('material_id') as $key=>$oldMaterialName)
                        <tr>
                            <td>
                                <input type="text" name="material_name[]" value="{{old('material_name')[$key]}}" id="material_name" class="text-center  form-control form-control-sm material_name" autocomplete="off" required>
                                <input type="hidden" name="material_id[]" value="{{old('material_id')[$key]}}" class="text-center material_id" id="material_id">
                            </td>
                            <td>
                                <input type="text" name="unit[]" tabindex="-1" value="{{old('unit')[$key]}}" class="text-center form-control form-control-sm unit" autocomplete="off" readonly>
                                <input type="hidden" name="unit_id[]" value="{{old('unit_id')[$key]}}" class="text-center form-control form-control-sm unit_id" autocomplete="off">
                            </td>
                            <td><input type="number" name="week_one[]" value="{{old('week_one')[$key]}}" class="text-center form-control form-control-sm week_one" autocomplete="off"></td>
                            <td><input type="number" name="week_two[]" value="{{old('week_two')[$key]}}" class="text-center form-control form-control-sm week_two" autocomplete="off"></td>
                            <td><input type="number" name="week_three[]" value="{{old('week_three')[$key]}}" class="text-center form-control form-control-sm week_three" autocomplete="off"></td>
                            <td><input type="number" name="week_four[]" value="{{old('week_four')[$key]}}" class="text-center form-control form-control-sm week_four" autocomplete="off"></td>
                            <td><input type="text" name="remarks[]" value="{{old('remarks')[$key]}}" class="text-center form-control form-control-sm remarks" autocomplete="off"></td>
                            <td><input type="number" name="total_quantity[]" tabindex="-1" value="{{old('total_quantity')[$key]}}" class="text-center form-control form-control-sm total_quantity" autocomplete="off" readonly></td>
                            <td class="text-center">
                                <button class="btn btn-danger btn-sm deleteItem" onclick="removQRow(this)" type="button">
                                    <i class="fa fa-minus"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                @else
                    @if (!empty($materialPlan))
                        @foreach ($materialPlan->materialPlanDetails as $data)
                        <tr >
                            <td>
                                <input type="text" name="material_name[]" value="{{ $data->nestedMaterials->name ?? null }}" id="material_name" class="text-center form-control form-control-sm material_name" autocomplete="off" required>
                                <input type="hidden" name="material_id[]" value="{{ $data->nestedMaterials->id ?? null }}" class="text-center material_id" id="material_id">
                            </td>
                            <td>
                                <input type="text" name="unit[]" tabindex="-1" value="{{ $data->nestedMaterials->unit->name ?? null }}" class="text-center form-control form-control-sm unit" autocomplete="off" readonly>
                                <input type="hidden" name="unit_id[]" value="{{ $data->nestedMaterials->unit->id ?? null }}" class="text-center form-control form-control-sm unit_id">
                            </td>
                            <td><input type="number" name="week_one[]" value="{{ $data->week_one ?? null }}" class="text-center form-control form-control-sm week_one" autocomplete="off"></td>
                            <td><input type="number" name="week_two[]" value="{{ $data->week_two ?? null }}" class="text-center form-control form-control-sm week_two" autocomplete="off"></td>
                            <td><input type="number" name="week_three[]" value="{{ $data->week_three ?? null }}" class="text-center form-control form-control-sm week_three" autocomplete="off"></td>
                            <td><input type="number" name="week_four[]" value="{{ $data->week_four ?? null }}" class="text-center form-control form-control-sm week_four" autocomplete="off"></td>
                            <td><input type="text" name="remarks[]" value="{{ $data->remarks ?? null }}" class="text-center form-control form-control-sm remarks" autocomplete="off"></td>
                            <td><input type="number" name="total_quantity[]" tabindex="-1" value="{{ $data->total_quantity ?? null }}" class="text-center form-control form-control-sm total_quantity" autocomplete="off" readonly></td>

                            <td class="text-center">
                                <button class="btn btn-danger btn-sm deleteItem" onclick="removQRow(this)" type="button">
                                    <i class="fa fa-minus"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    @endif
                @endif
            </tbody>
        </table>
    </div>
</div>
</div>
@if (($formType == 'edit' && $materialPlan->is_saved == 0) || $formType == 'create')
    <div class="row">
        <div class="mt-2 offset-md-2 col-md-4">
            <div class="input-group input-group-sm">
                <button class="py-2 btn btn-success btn-round btn-block py-2 submit_button">Save</button>
            </div>
        </div>
        <div class="mt-2 col-md-4">
            <div class="input-group input-group-sm">
                <button class="py-2 btn btn-success btn-round btn-block py-2 submit_button" id='draft_button'>Save as draft</button>
            </div>
        </div>
    </div>
    @else
    <div class="row">
        <div class="mt-2 offset-md-4 col-md-4">
            <div class="input-group input-group-sm ">
                <button class="py-2 btn btn-success btn-round btn-block py-2 submit_button">Save</button>
            </div>
        </div>
    </div>
@endif
{!! Form::close() !!}



@endsection

@section('script')

    <script>

        function addItemDtl() {
            var Row = `
            <tr>
                <td>
                    <input type="text" name="material_name[]" value="" id="material_name" class="text-center form-control form-control-sm material_name" autocomplete="off" required>
                    <input type="hidden" name="material_id[]" value="" class="material_id" id="material_id">
                </td>
                <td>
                    <input type="text" name="unit[]" value="" tabindex="-1" class="text-center form-control form-control-sm unit" id="unit" autocomplete="off" readonly>
                    <input type="hidden" name="unit_id[]" value="" class="text-center form-control form-control-sm unit_id" id="unit_id" >
                </td>
                <td><input type="number" name="week_one[]" value="" class="text-center form-control form-control-sm week_one" autocomplete="off"></td>
                <td><input type="number" name="week_two[]" value="" class="text-center form-control form-control-sm week_two" autocomplete="off"></td>
                <td><input type="number" name="week_three[]" value="" class="text-center form-control form-control-sm week_three" autocomplete="off"></td>
                <td><input type="number" name="week_four[]" value="" class="text-center form-control form-control-sm week_four" autocomplete="off"></td>
                <td><input type="text" name="remarks[]" value="" class="text-center form-control form-control-sm remarks" autocomplete="off"></td>
                <td><input type="number" name="total_quantity[]" tabindex="-1" value="" class="text-center form-control form-control-sm total_quantity" autocomplete="off" readonly></td>

                <td class="text-center">
                    <button class="btn btn-danger btn-sm deleteItem" onclick="removQRow(this)" type="button">
                        <i class="fa fa-minus"></i>
                    </button>
                </td>
            </tr>
            `;
            var tableItem = $('#Table').append(Row);
            calculateTotalPrice(this);
            totalOperation();
        }



        // Function for deleting a row
        function removQRow(qval) {
            var rowIndex = qval.parentNode.parentNode.rowIndex;
            document.getElementById("Table").deleteRow(rowIndex);
        }


        var CSRF_TOKEN = "{{csrf_token()}}";
        $(function() {

            @if ($formType == 'create' && !old('project_id'))
                addItemDtl();
            @endif
            $('#tagForm').submit(function(){

            });
            $('form').submit(function (event) {
            $('.submit_button').attr('disabled', true);
            if ($(this).hasClass('submitted')) {
                event.preventDefault();
            }
            else {
                $('.submit_button').html('<i class="fa fa-spinner fa-spin"></i>');
                $('.submit_button').addClass('submitted');
            }
        });


            $(document).on('keyup', ".material_name", function(){
                $(this).autocomplete({
                    source: function(request, response) {
                    $.ajax({
                        url: "{{ route('construction.LoadmaterialName') }}",
                        type: 'post',
                        dataType: "json",
                        data: {
                            _token: CSRF_TOKEN,
                            search: request.term
                        },
                        success: function(data) {
                            response(data);
                            console.log(data);
                        }
                    });
                },
                select: function(event, ui) {
                    $(this).closest('tr').find('.material_id').val(ui.item.value);
                    $(this).closest('tr').find('.material_name').val(ui.item.label);
                    $(this).closest('tr').find('.unit').val(ui.item.unit);
                    $(this).closest('tr').find('.unit_id').val(ui.item.unit_id);
                    return false;
                    }
                });
            });


            $(document).on('mouseenter', '.from_date, .to_date', function() {
                $(this).datepicker({
                    format: "yyyy-mm-dd",
                    autoclose: true,
                    todayHighlight: true,
                    showOtherMonths: true
                });
            });
        });

            // Function for calculating total price
            function calculateTotalPrice(thisVal) {
                let week_one = $(thisVal).closest('tr').find('.week_one').val() > 0 ? parseFloat($(thisVal).closest('tr').find(
                    '.week_one').val()) : 0;
                let week_two = $(thisVal).closest('tr').find('.week_two').val() > 0 ? parseFloat($(thisVal).closest('tr').find(
                    '.week_two').val()) : 0;
                let week_three = $(thisVal).closest('tr').find('.week_three').val() > 0 ? parseFloat($(thisVal).closest('tr').find(
                    '.week_three').val()) : 0;
                let week_four = $(thisVal).closest('tr').find('.week_four').val() > 0 ? parseFloat($(thisVal).closest('tr').find(
                    '.week_four').val()) : 0;
                let total = (week_one + week_two + week_three + week_four).toFixed(2);
                $(thisVal).closest('tr').find('.total_quantity').val(total);
                totalOperation();
            }

            // Function for calculating total price
            function totalOperation() {
                var total = 0;
                if ($(".total_quantity").length > 0) {
                    $(".total_quantity").each(function(i, row) {
                        var total_quantity = Number($(row).val());
                        total += parseFloat(total_quantity);
                    })
                }
            }


        $(function() {


            $(document).on('keyup change', '.week_one,.week_two, .week_three, .week_four', function() {
                calculateTotalPrice(this);
            });
            totalOperation();
        });
        @if (($formType == 'edit' && $materialPlan->is_saved == 0) || $formType == 'create')
            var CSRF_TOKEN = "{{ csrf_token() }}";
            $(document).ready(function() {
                    $('#draft_button').on('click', function (e) {
                        $('.submit_button').attr('disabled', true);
                        e.preventDefault();
                        var tagForm = document.getElementById('tagForm');
                        tagForm.action = "{{ route('construction.materialPlan.DraftSave') }}";
                        tagForm.method = 'POST';
                        $('input[name=_method]').remove();
                        tagForm.submit();
                    })
            })
        @endif
    </script>
@endsection
