@extends('boq.departments.sanitary.layout.app')
@section('title', 'BOQ - Sanitary')

@section('breadcrumb-title')
Material Allocations Plan
@endsection

@section('project-name')
{{$project->name}}
@endsection

@section('breadcrumb-button')
{{-- @include('components.buttons.breadcrumb-button', ['route' => route('boq.project.departments.electrical.configurations.rates.index',['project' => Session::get('project_id')]), 'type' => 'index'])--}}
@endsection

@section('sub-title')
<span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'offset-md-1 col-md-10')

@section('content')
<div class="row">
    <div class="col-md-12">
        @if(!empty($sanitaryBudgetSummary))
        {!! Form::open(array('url' => "boq/project/$project->id/departments/sanitary/sanitary-allocations/$project->id",'method' => 'PUT', 'class'=>'custom-form')) !!}
        <input type="hidden" name="id" value="{{old('id') ? old('id') : (!empty($project->id) ? $project->id : null)}}">
        @else
        {!! Form::open(array('url' => "boq/project/$project->id/departments/sanitary/sanitary-allocations",'method' => 'POST', 'class'=>'custom-form')) !!}
        @endif
        <input type="hidden" name="type" value="{{old('type') ? old('type') : $type}}">
        <div class="row">
            <div class="col-md-12 table-responsive">
                <table class="table table-bordered" id="commercial_table">
                    <thead>
                        <tr style="background-color: #2ed8b6!important;">
                            <td class="" colspan="7">
                                <h5 style="color: white" class="text-center">Commercial Part</h5>
                            </td>
                        </tr>
                        <tr>
                            <th> Floor Details</th>
                            <th> No Of <br> Floor </th>
                            <th> Toilet<span class="text-danger">*</span></th>
                            <th> Wash <br> Basin <span class="text-danger">*</span></th>
                            <th> Urinal<span class="text-danger">*</span></th>
                            <th> Pantry <span class="text-danger">*</span></th>
                            <th> Common <br> Toilet <span class="text-danger">*</span></th>
                        </tr>

                    </thead>
                    <tbody>
                        <tr>
                            <td>{{Form::text('floor_Type[]', old('floor_Type') ? old('floor_Type') : (!empty($nestedmaterial->floor_Type) ? $layer1 : 'Ground Floor'),['class' => 'form-control form-control-sm','floor_type', 'readonly'])}}</td>
                            <td>{{Form::text('floor_no[]', old('floor_no') ? old('floor_no') : (!empty($nestedmaterial->floor_no) ? $layer1 : null),['class' => 'form-control form-control-sm floor_no','autocomplete'=>"off"])}}</td>
                            <td>{{Form::text('commercial_toilet[]', old('commercial_toilet') ? old('commercial_toilet') : (!empty($nestedmaterial->commercial_toilet) ? $layer1 : null),['class' => 'form-control form-control-sm commercial_toilet', 'autocomplete'=>"off"])}}</td>
                            <td>{{Form::text('basin[]', old('basin') ? old('basin') : (!empty($nestedmaterial->basin) ? $layer1 : null),['class' => 'form-control form-control-sm basin', 'autocomplete'=>"off"])}}</td>
                            <td>{{Form::text('urinal[]', old('urinal') ? old('urinal') : (!empty($nestedmaterial->urinal) ? $layer1 : null),['class' => 'form-control form-control-sm urinal', 'autocomplete'=>"off"])}}</td>
                            <td>{{Form::text('pantry[]', old('pantry') ? old('pantry') : (!empty($nestedmaterial->pantry) ? $layer1 : null),['class' => 'form-control form-control-sm pantry', 'autocomplete'=>"off"])}}</td>
                            <td>{{Form::text('common_toilet[]', old('common_toilet') ? old('common_toilet') : (!empty($nestedmaterial->common_toilet) ? $layer1 : null),['class' => 'form-control form-control-sm common_toilet', 'autocomplete'=>"off"])}}</td>
                        </tr>
                        <tr>
                            <td>{{Form::text('floor_Type[]', old('floor_Type') ? old('floor_Type') : (!empty($nestedmaterial->floor_Type) ? $layer1 : 'Typical Floor'),['class' => 'form-control form-control-sm','floor_type', 'readonly'])}}</td>
                            <td>{{Form::text('floor_no[]', old('floor_no') ? old('floor_no') : (!empty($nestedmaterial->floor_no) ? $layer1 : null),['class' => 'form-control form-control-sm floor_no','autocomplete'=>"off"])}}</td>
                            <td>{{Form::text('commercial_toilet[]', old('commercial_toilet') ? old('commercial_toilet') : (!empty($nestedmaterial->commercial_toilet) ? $layer1 : null),['class' => 'form-control form-control-sm commercial_toilet', 'autocomplete'=>"off"])}}</td>
                            <td>{{Form::text('basin[]', old('basin') ? old('basin') : (!empty($nestedmaterial->basin) ? $layer1 : null),['class' => 'form-control form-control-sm basin', 'autocomplete'=>"off"])}}</td>
                            <td>{{Form::text('urinal[]', old('urinal') ? old('urinal') : (!empty($nestedmaterial->urinal) ? $layer1 : null),['class' => 'form-control form-control-sm urinal', 'autocomplete'=>"off"])}}</td>
                            <td>{{Form::text('pantry[]', old('pantry') ? old('pantry') : (!empty($nestedmaterial->pantry) ? $layer1 : null),['class' => 'form-control form-control-sm pantry', 'autocomplete'=>"off"])}}</td>
                            <td>{{Form::text('common_toilet[]', old('common_toilet') ? old('common_toilet') : (!empty($nestedmaterial->common_toilet) ? $layer1 : null),['class' => 'form-control form-control-sm common_toilet', 'autocomplete'=>"off"])}}</td>
                        </tr>
                        <tr>
                            <td>{{Form::text('floor_Type[]', old('floor_Type') ? old('floor_Type') : (!empty($nestedmaterial->floor_Type) ? $layer1 : 'Roof Top'),['class' => 'form-control form-control-sm','floor_type', 'readonly'])}}</td>
                            <td>{{Form::text('floor_no[]', old('floor_no') ? old('floor_no') : (!empty($nestedmaterial->floor_no) ? $layer1 : null),['class' => 'form-control form-control-sm floor_no','autocomplete'=>"off"])}}</td>
                            <td>{{Form::text('commercial_toilet[]', old('commercial_toilet') ? old('commercial_toilet') : (!empty($nestedmaterial->commercial_toilet) ? $layer1 : null),['class' => 'form-control form-control-sm commercial_toilet', 'autocomplete'=>"off"])}}</td>
                            <td>{{Form::text('basin[]', old('basin') ? old('basin') : (!empty($nestedmaterial->basin) ? $layer1 : null),['class' => 'form-control form-control-sm basin', 'autocomplete'=>"off"])}}</td>
                            <td>{{Form::text('urinal[]', old('urinal') ? old('urinal') : (!empty($nestedmaterial->urinal) ? $layer1 : null),['class' => 'form-control form-control-sm urinal', 'autocomplete'=>"off"])}}</td>
                            <td>{{Form::text('pantry[]', old('pantry') ? old('pantry') : (!empty($nestedmaterial->pantry) ? $layer1 : null),['class' => 'form-control form-control-sm pantry', 'autocomplete'=>"off"])}}</td>
                            <td>{{Form::text('common_toilet[]', old('common_toilet') ? old('common_toilet') : (!empty($nestedmaterial->common_toilet) ? $layer1 : null),['class' => 'form-control form-control-sm common_toilet', 'autocomplete'=>"off"])}}</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2" class="text-right"><b>Total</b> </td>
                            <td class="text-right">
                                <input type="text" name="total_toilet" id="total_toilet" class="form-control text-right" value="" readonly />
                            </td>
                            <td class="text-right">
                                <input type="text" name="total_basin" id="total_basin" class="form-control text-right" value="" readonly />
                            </td>
                            <td class="text-right">
                                <input type="text" name="total_urinal" id="total_urinal" class="form-control text-right" value="" readonly />
                            </td>
                            <td class="text-right">
                                <input type="text" name="total_pantry" id="total_pantry" class="form-control text-right" value="" readonly />
                            </td>
                            <td class="text-right">
                                <input type="text" name="total_common_toilet" id="total_common_toilet" class="form-control text-right" value="" readonly />
                            </td>
                        </tr>
                    </tfoot>
                </table>
                <br>
                <hr>
                {{--//allocate area--}}
                <table class="table table-bordered" id="">
                    <thead>
                        <tr class="">
                            <th>Item </th>
                            <th>Unit </th>
                            <th>Toilet</th>
                            <th>Wash Basin</th>
                            <th>Urinal</th>
                            <th>Pantry</th>
                            <th>Common Toilet</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($formulas as $formulaData)
                        <tr>
                            @php
                            $materialName = $formulaData->flatten()->pluck('material')->flatten();
                            @endphp
                            <td class="text-left">{{$materialName[0]->name}}
                                {{Form::hidden("material_id[]", old('material_id') ? old('material_id') : (!empty($nestedmaterial->material_id) ? $layer1 : $materialName[0]->id),['class' => "material_id"])}}
                            </td>
                            <td class="">{{$materialName[0]->unit->name}}</td>
                            @foreach($types as $key => $type)
                            @php
                            $items = \App\SanitaryFormulaDetail::whereHas('sanitaryFormula', function ($q)use($type){
                            $q->where('location_type',$type->name)->where('location_for',0);
                            })->where('material_id',$materialName[0]->id )->first();
                            @endphp
                            <td>
                                {{Form::hidden("hidden_multi_$type->value[]", old('hidden_master_multi_fc') ? old('hidden_master_multi_fc') : (!empty($nestedmaterial->hidden_master_multi_fc) ? $layer1 : $items->multiply_qnt ?? 0),['class' => "hidden_multi_$type->value"])}}
                                {{Form::hidden("hidden_add_$type->value[]", old('hidden_master_add_fc') ? old('hidden_master_add_fc') : (!empty($nestedmaterial->hidden_master_add_fc) ? $layer1 : $items->additional_qnt ?? 0),['class' => "hidden_add_$type->value"])}}
                                {{Form::text("allocate_$type->value[]", old('allocate_master_fc') ? old('allocate_master_fc') : (!empty($nestedmaterial->allocate_master_fc) ? $layer1 : null),['class' => "form-control form-control-sm text-center allocate_$type->value", 'autocomplete'=>"off"])}}
                            </td>
                            @endforeach
                            <td>
                                {{Form::text("total[]", old('total') ? old('total') : (!empty($nestedmaterial->total) ? $layer1 : null),['class' => "form-control form-control-sm text-center total", 'autocomplete'=>"off", 'readonly'])}}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="offset-md-4 col-md-4 mt-2">
                <div class="input-group input-group-sm ">
                    <button class="btn btn-success btn-round btn-block py-2">Submit</button>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@endsection

@section('script')
<script>
    const CSRF_TOKEN = "{{ csrf_token() }}";

    $(document).on('keyup', '.commercial_toilet', function() {
        changeTotalCommercialToilet();
    })
    $(document).on('keyup', '.basin', function() {
        changeTotalBasin();
    })
    $(document).on('keyup', '.urinal', function() {
        changeTotalUrinal();
    })
    $(document).on('keyup', '.pantry', function() {
        changeTotalPantry();
    })
    $(document).on('keyup', '.common_toilet', function() {
        changeTotalCommonToilet();
    })

    function changeTotalCommercialToilet() {
        let total = 0;
        if ($(".commercial_toilet").length > 0) {
            $(".commercial_toilet").each(function(i, row) {
                let totalQnt = Number($(row).val());
                total += parseFloat(totalQnt);
            })
        }
        $("#total_toilet").val(total);
        changeAllocateToilet();
    }

    function changeTotalBasin() {
        let total = 0;
        if ($(".basin").length > 0) {
            $(".basin").each(function(i, row) {
                let totalQnt = Number($(row).val());
                total += parseFloat(totalQnt);
            })
        }
        $("#total_basin").val(total);
        changeAllocateBasin();
    }

    function changeTotalUrinal() {
        let total = 0;
        if ($(".urinal").length > 0) {
            $(".urinal").each(function(i, row) {
                let totalQnt = Number($(row).val());
                total += parseFloat(totalQnt);
            })
        }
        $("#total_urinal").val(total);
        changeAllocateUrinal();
    }

    function changeTotalPantry() {
        let total = 0;
        if ($(".pantry").length > 0) {
            $(".pantry").each(function(i, row) {
                let totalQnt = Number($(row).val());
                total += parseFloat(totalQnt);
            })
        }
        $("#total_pantry").val(total);
        changeAllocatePantry();
    }

    function changeTotalCommonToilet() {
        let total = 0;
        if ($(".common_toilet").length > 0) {
            $(".common_toilet").each(function(i, row) {
                let totalQnt = Number($(row).val());
                total += parseFloat(totalQnt);
            })
        }
        $("#total_common_toilet").val(total);
        changeAllocateCommonToilet();
    }

    function changeAllocateToilet() {
        $(".hidden_multi_toilet").each(function(i, row) {
            let allocateMultiToilet = Number($(row).val());
            let allocateAddToilet = parseFloat($(row).closest('tr').find('.hidden_add_toilet').val());
            let totalTiilet = parseFloat($("#total_toilet").val());
            $(row).closest('tr').find('.allocate_toilet').val(allocateMultiToilet * totalTiilet + allocateAddToilet);
            changeTotal($(row));
        });
    }

    function changeAllocateBasin() {
        $(".hidden_multi_basin").each(function(i, row) {
            let allocateMultiToilet = Number($(row).val());
            let allocateAddToilet = parseFloat($(row).closest('tr').find('.hidden_add_basin').val());
            let totalTiilet = parseFloat($("#total_basin").val());
            $(row).closest('tr').find('.allocate_basin').val(allocateMultiToilet * totalTiilet + allocateAddToilet);
            changeTotal($(row));
        });
    }

    function changeAllocateUrinal() {
        $(".hidden_multi_urinal").each(function(i, row) {
            let allocateMasterMultiFc = Number($(row).val());
            let allocateMasterAddFc = parseFloat($(row).closest('tr').find('.hidden_add_urinal').val());
            let totalMasterFc = $("#total_urinal").val();
            $(row).closest('tr').find('.allocate_urinal').val(allocateMasterMultiFc * totalMasterFc + allocateMasterAddFc);
            changeTotal($(row));
        })
    }

    function changeAllocatePantry() {
        $(".hidden_multi_pantry").each(function(i, row) {
            let allocateMasterMultiFc = Number($(row).val());
            let allocateMasterAddFc = parseFloat($(row).closest('tr').find('.hidden_add_pantry').val());
            let totalMasterFc = $("#total_pantry").val();
            $(row).closest('tr').find('.allocate_pantry').val(allocateMasterMultiFc * totalMasterFc + allocateMasterAddFc);
            changeTotal($(row));
        })
    }

    function changeAllocateCommonToilet() {
        $(".hidden_multi_commonToilet").each(function(i, row) {
            let allocateMasterMultiFc = Number($(row).val());
            let allocateMasterAddFc = parseFloat($(row).closest('tr').find('.hidden_add_commonToilet').val());
            let totalMasterFc = $("#total_common_toilet").val();
            $(row).closest('tr').find('.allocate_commonToilet').val(allocateMasterMultiFc * totalMasterFc + allocateMasterAddFc);
            changeTotal($(row));
        })
    }

    function changeTotal(thisVal) {
        let allocate_toilet = thisVal.closest('tr').find('.allocate_toilet').val() > 0 ? parseFloat(thisVal.closest('tr').find('.allocate_toilet').val()) : 0;
        let allocate_basin = thisVal.closest('tr').find('.allocate_basin').val() > 0 ? parseFloat(thisVal.closest('tr').find('.allocate_basin').val()) : 0;
        let allocate_urinal = thisVal.closest('tr').find('.allocate_urinal').val() > 0 ? parseFloat(thisVal.closest('tr').find('.allocate_urinal').val()) : 0;
        let allocate_pantry = thisVal.closest('tr').find('.allocate_pantry').val() > 0 ? parseFloat(thisVal.closest('tr').find('.allocate_pantry').val()) : 0;
        let allocate_commonToilet = thisVal.closest('tr').find('.allocate_commonToilet').val() > 0 ? parseFloat(thisVal.closest('tr').find('.allocate_commonToilet').val()) : 0;
        thisVal.closest('tr').find('.total').val(allocate_toilet + allocate_basin + allocate_urinal + allocate_pantry + allocate_commonToilet);
    }
</script>
@endsection