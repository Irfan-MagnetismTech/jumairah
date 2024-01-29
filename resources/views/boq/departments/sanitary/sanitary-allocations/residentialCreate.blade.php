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
                <table class="table table-bordered" id="calculation_table">
                    <thead>
                        <tr style="background-color: #2ed8b6!important;">
                            <td class="" colspan="12">
                                <h5 style="color: white" class="text-center">Residential Part </h5>
                            </td>
                        </tr>
                        <tr class="electrical_calc_head">
                            <th class="material_rate_th" rowspan="2"> Apartment <br> Type</th>
                            <th class="material_rate_th" rowspan="2"> No </th>
                            <th class="material_rate_th" colspan="2">
                                <input type="text" class="form-control text-center" name="master" value="Master Bath" style="background-color: #116A7B; color: white">
                            </th>
                            <th class="material_rate_th" colspan="2">
                                <input type="text" class="form-control text-center" name="child" value="Child Bath" style="background-color: #116A7B; color: white">
                            </th>
                            <th class="material_rate_th" colspan="2">
                                <input type="text" class="form-control text-center" name="common" value="Common Bath" style="background-color: #116A7B; color: white">
                            </th>
                            <th class="material_rate_th" colspan="2">
                                <input type="text" class="form-control text-center" name="smalltoilet" value="S. Toilet Bath" style="background-color: #116A7B; color: white">
                            </th>
                            <th class="material_rate_th" colspan="2">
                                <input type="text" class="form-control text-center" name="kitchen" value="Kitchen" style="background-color: #116A7B; color: white">
                            </th>
                        </tr>
                        <tr>
                            <th>JHL</th>
                            <th>LO</th>
                            <th>JHL</th>
                            <th>LO</th>
                            <th>JHL</th>
                            <th>LO</th>
                            <th>JHL</th>
                            <th>LO</th>
                            <th>JHL</th>
                            <th>LO</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($project->projectType as $projectType)
                        <tr>
                            <td>{{$projectType->type_name}}
                                <input type="hidden" name="apartment_type[]" value="{{$projectType->composite_key}}">
                            </td>
                            <td>{{$projectType->typeApartments->count()}}</td>
                            <td>{{Form::text('master_FC[]', old('floor_id') ? old('floor_id') : (!empty($nestedmaterial->floor_id) ? $layer1 : null),['class' => 'form-control form-control-sm master_FC', 'autocomplete'=>"off"])}}</td>
                            <td>{{Form::text('master_LW[]', old('floor_id') ? old('floor_id') : (!empty($nestedmaterial->floor_id) ? $layer1 : null),['class' => 'form-control form-control-sm master_LW', 'autocomplete'=>"off"])}}</td>
                            <td>{{Form::text('child_FC[]', old('floor_id') ? old('floor_id') : (!empty($nestedmaterial->floor_id) ? $layer1 : null),['class' => 'form-control form-control-sm child_FC', 'autocomplete'=>"off"])}}</td>
                            <td>{{Form::text('child_LW[]', old('floor_id') ? old('floor_id') : (!empty($nestedmaterial->floor_id) ? $layer1 : null),['class' => 'form-control form-control-sm child_LW', 'autocomplete'=>"off"])}}</td>
                            <td>{{Form::text('common_FC[]', old('floor_id') ? old('floor_id') : (!empty($nestedmaterial->floor_id) ? $layer1 : null),['class' => 'form-control form-control-sm common_FC', 'autocomplete'=>"off"])}}</td>
                            <td>{{Form::text('common_LW[]', old('floor_id') ? old('floor_id') : (!empty($nestedmaterial->floor_id) ? $layer1 : null),['class' => 'form-control form-control-sm common_LW', 'autocomplete'=>"off"])}}</td>
                            <td>{{Form::text('smalltoilet_FC[]', old('floor_id') ? old('floor_id') : (!empty($nestedmaterial->floor_id) ? $layer1 : null),['class' => 'form-control form-control-sm smalltoilet_FC', 'autocomplete'=>"off"])}}</td>
                            <td>{{Form::text('smalltoilet_LW[]', old('floor_id') ? old('floor_id') : (!empty($nestedmaterial->floor_id) ? $layer1 : null),['class' => 'form-control form-control-sm smalltoilet_LW', 'autocomplete'=>"off"])}}</td>
                            <td>{{Form::text('kitchen_FC[]', old('floor_id') ? old('floor_id') : (!empty($nestedmaterial->floor_id) ? $layer1 : null),['class' => 'form-control form-control-sm kitchen_FC', 'autocomplete'=>"off"])}}</td>
                            <td>{{Form::text('kitchen_LW[]', old('floor_id') ? old('floor_id') : (!empty($nestedmaterial->floor_id) ? $layer1 : null),['class' => 'form-control form-control-sm kitchen_LW', 'autocomplete'=>"off"])}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2" class="text-right"><b>Total</b> </td>
                            <td class="text-right">
                                <input type="text" name="total_master_fc" id="total_master_fc" class="form-control text-right" value="" readonly />
                            </td>
                            <td class="text-right">
                                <input type="text" name="total_master_lw" id="total_master_lw" class="form-control text-right" value="" readonly />
                            </td>
                            <td class="text-right">
                                <input type="text" name="total_child_fc" id="total_child_fc" class="form-control text-right" value="" readonly />
                            </td>
                            <td class="text-right">
                                <input type="text" name="total_child_lw" id="total_child_lw" class="form-control text-right" value="" readonly />
                            </td>
                            <td class="text-right">
                                <input type="text" name="total_common_fc" id="total_common_fc" class="form-control text-right" value="" readonly />
                            </td>
                            <td class="text-right">
                                <input type="text" name="total_common_lw" id="total_common_lw" class="form-control text-right" value="" readonly />
                            </td>
                            <td class="text-right">
                                <input type="text" name="total_toilet_fc" id="total_toilet_fc" class="form-control text-right" value="" readonly />
                            </td>
                            <td class="text-right">
                                <input type="text" name="total_toilet_lw" id="total_toilet_lw" class="form-control text-right" value="" readonly />
                            </td>
                            <td class="text-right">
                                <input type="text" name="total_kitchen_fc" id="total_kitchen_fc" class="form-control text-right" value="" readonly />
                            </td>
                            <td class="text-right">
                                <input type="text" name="total_kitchen_lw" id="total_kitchen_lw" class="form-control text-right" value="" readonly />
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
                            <th rowspan="2">Item </th>
                            <th rowspan="2">Unit </th>
                            <th colspan="2">Master Bath</th>
                            <th colspan="2">Child / Attached Bath</th>
                            <th colspan="2">Common Bath</th>
                            <th colspan="2">S. Toilet Bath</th>
                            <th colspan="2">Kitchen</th>
                            <th rowspan="2">Common <br> Area</th>
                            <th rowspan="2">Total</th>
                        </tr>
                        <tr>
                            <th>JHL</th>
                            <th>LO</th>
                            <th>JHL</th>
                            <th>LO</th>
                            <th>JHL</th>
                            <th>LO</th>
                            <th>JHL</th>
                            <th>LO</th>
                            <th>JHL</th>
                            <th>LO</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($formulas as $mkey => $formulaData)
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
                            $q->where('location_type',$type->name)->where('location_for',1);
                            })->where('material_id',$materialName[0]->id )->first();
                            @endphp
                            <td>
                                {{Form::hidden("hidden_multi_$type->value[]", old('hidden_master_multi_fc') ? old('hidden_master_multi_fc') : (!empty($nestedmaterial->hidden_master_multi_fc) ? $layer1 : $items->multiply_qnt ?? 0),['class' => "hidden_multi_fc_$type->value"])}}
                                {{Form::hidden("hidden_add_$type->value[]", old('hidden_master_add_fc') ? old('hidden_master_add_fc') : (!empty($nestedmaterial->hidden_master_add_fc) ? $layer1 : $items->additional_qnt ?? 0),['class' => "hidden_add_fc_$type->value"])}}
                                {{Form::text("allocate_$type->value[]", old('allocate_master_fc') ? old('allocate_master_fc') : (!empty($nestedmaterial->allocate_master_fc) ? $layer1 : null),['class' => "form-control form-control-sm text-center allocate_fc_$type->value", 'autocomplete'=>"off"])}}
                            </td>
                            <td>
                                {{Form::hidden("hidden_multi_lw_$type->value[]", old('hidden_master_multi_lw') ? old('hidden_master_multi_lw') : (!empty($nestedmaterial->hidden_master_multi_lw) ? $layer1 : $items->multiply_qnt ?? 0),['class' => "hidden_multi_lw_$type->value"])}}
                                {{Form::hidden("hidden_add_lw_$type->value[]", old('hidden_master_add_lw') ? old('hidden_master_add_lw') : (!empty($nestedmaterial->hidden_master_add_lw) ? $layer1 : $items->additional_qnt ?? 0),['class' => "hidden_add_lw_$type->value"])}}
                                {{Form::text("allocate_lw_$type->value[]", old('allocate_master_lw') ? old('allocate_master_lw') : (!empty($nestedmaterial->allocate_master_lw) ? $layer1 : null),['class' => "form-control form-control-sm text-center allocate_lw_$type->value", 'autocomplete'=>"off"])}}
                            </td>
                            @endforeach
                            <td>
                                {{Form::text("common_area[]", old('common_area') ? old('common_area') : (!empty($nestedmaterial->common_area) ? $layer1 : null),['class' => "form-control form-control-sm text-center common_area", 'autocomplete'=>"off"])}}
                            </td>
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

    $(document).on('keyup', '.master_FC', function() {
        changeTotalMasterFc();
    })
    $(document).on('keyup', '.master_LW', function() {
        changeTotalMasterLw();
    })
    $(document).on('keyup', '.child_FC', function() {
        changeTotalChildFc();
    })
    $(document).on('keyup', '.child_LW', function() {
        changeTotalChildLw();
    })
    $(document).on('keyup', '.common_FC', function() {
        changeTotalCommonFc();
    })
    $(document).on('keyup', '.common_LW', function() {
        changeTotalCommonLw();
    })
    $(document).on('keyup', '.smalltoilet_FC', function() {
        console.log('smalltoilet_FC')
        changeTotalSToiletFc();
    })
    $(document).on('keyup', '.smalltoilet_LW', function() {
        changeTotalSToiletLw();
    })
    $(document).on('keyup', '.kitchen_FC', function() {
        changeTotalKitchenFc();
    })
    $(document).on('keyup', '.kitchen_LW', function() {
        changeTotalKitchenLw();
    })
    $(document).on('keyup', '.common_area', function() {
        changeTotal($(this));
    })

    function changeTotalMasterFc() {
        let total = 0;
        if ($(".master_FC").length > 0) {
            $(".master_FC").each(function(i, row) {
                let totalQnt = Number($(row).val());
                total += parseFloat(totalQnt);
            })
        }
        $("#total_master_fc").val(total);
        changeAllocateMasterFc();
    }

    function changeTotalMasterLw() {
        let total = 0;
        if ($(".master_LW").length > 0) {
            $(".master_LW").each(function(i, row) {
                let totalQnt = Number($(row).val());
                total += parseFloat(totalQnt);
            })
        }
        $("#total_master_lw").val(total);
        changeAllocateMasterLw();
    }

    function changeTotalChildFc() {
        let total = 0;
        if ($(".child_FC").length > 0) {
            $(".child_FC").each(function(i, row) {
                let totalQnt = Number($(row).val());
                total += parseFloat(totalQnt);
            })
        }
        $("#total_child_fc").val(total);
        changeAllocateChildFc();
    }

    function changeTotalChildLw() {
        let total = 0;
        if ($(".child_LW").length > 0) {
            $(".child_LW").each(function(i, row) {
                let totalQnt = Number($(row).val());
                total += parseFloat(totalQnt);
            })
        }
        $("#total_child_lw").val(total);
        changeAllocateChildLw();
    }

    function changeTotalCommonFc() {
        let total = 0;
        if ($(".common_FC").length > 0) {
            $(".common_FC").each(function(i, row) {
                let totalQnt = Number($(row).val());
                total += parseFloat(totalQnt);
            })
        }
        $("#total_common_fc").val(total);
        changeAllocateCommonFc();
    }

    function changeTotalCommonLw() {
        let total = 0;
        if ($(".common_LW").length > 0) {
            $(".common_LW").each(function(i, row) {
                let totalQnt = Number($(row).val());
                total += parseFloat(totalQnt);
            })
        }
        $("#total_common_lw").val(total);
        changeAllocateCommonLw();
    }

    function changeTotalSToiletFc() {
        console.log('fine')
        let total = 0;
        if ($(".smalltoilet_FC").length > 0) {
            $(".smalltoilet_FC").each(function(i, row) {
                let totalQnt = Number($(row).val());
                total += parseFloat(totalQnt);
            })
        }
        $("#total_toilet_fc").val(total);
        changeAllocateSToiletFc();
    }

    function changeTotalSToiletLw() {
        let total = 0;
        if ($(".smalltoilet_LW").length > 0) {
            $(".smalltoilet_LW").each(function(i, row) {
                let totalQnt = Number($(row).val());
                total += parseFloat(totalQnt);
            })
        }
        $("#total_toilet_lw").val(total);
        changeAllocateSToiletLw();
    }

    function changeTotalKitchenFc() {
        let total = 0;
        if ($(".kitchen_FC").length > 0) {
            $(".kitchen_FC").each(function(i, row) {
                let totalQnt = Number($(row).val());
                total += parseFloat(totalQnt);
            })
        }
        $("#total_kitchen_fc").val(total);
        changeAllocateKitchenFc();
    }

    function changeTotalKitchenLw() {
        let total = 0;
        if ($(".kitchen_LW").length > 0) {
            $(".kitchen_LW").each(function(i, row) {
                let totalQnt = Number($(row).val());
                total += parseFloat(totalQnt);
            })
        }
        $("#total_kitchen_lw").val(total);
        changeAllocateKitchenLw();
    }

    function changeTotal(thisVal) {
        let allocateQntmfc = thisVal.closest('tr').find('.allocate_fc_master').val() > 0 ? parseFloat(thisVal.closest('tr').find('.allocate_fc_master').val()) : 0;
        let allocateQntmlw = thisVal.closest('tr').find('.allocate_lw_master').val() > 0 ? parseFloat(thisVal.closest('tr').find('.allocate_lw_master').val()) : 0;
        let allocateQntcfc = thisVal.closest('tr').find('.allocate_fc_child').val() > 0 ? parseFloat(thisVal.closest('tr').find('.allocate_fc_child').val()) : 0;
        let allocateQntclw = thisVal.closest('tr').find('.allocate_lw_child').val() > 0 ? parseFloat(thisVal.closest('tr').find('.allocate_lw_child').val()) : 0;
        let allocateQntcbfc = thisVal.closest('tr').find('.allocate_fc_commonBath').val() > 0 ? parseFloat(thisVal.closest('tr').find('.allocate_fc_commonBath').val()) : 0;
        let allocateQntcblw = thisVal.closest('tr').find('.allocate_lw_commonBath').val() > 0 ? parseFloat(thisVal.closest('tr').find('.allocate_lw_commonBath').val()) : 0;
        let allocateQntstfc = thisVal.closest('tr').find('.allocate_fc_smallToilet').val() > 0 ? parseFloat(thisVal.closest('tr').find('.allocate_fc_smallToilet').val()) : 0;
        let allocateQntstlw = thisVal.closest('tr').find('.allocate_lw_smallToilet').val() > 0 ? parseFloat(thisVal.closest('tr').find('.allocate_lw_smallToilet').val()) : 0;
        let allocateQntkfc = thisVal.closest('tr').find('.allocate_fc_kitchen').val() > 0 ? parseFloat(thisVal.closest('tr').find('.allocate_fc_kitchen').val()) : 0;
        let allocateQntklw = thisVal.closest('tr').find('.allocate_lw_kitchen').val() > 0 ? parseFloat(thisVal.closest('tr').find('.allocate_lw_kitchen').val()) : 0;
        let commonAreaQnt = thisVal.closest('tr').find('.common_area').val() > 0 ? parseFloat(thisVal.closest('tr').find('.common_area').val()) : 0;
        thisVal.closest('tr').find('.total').val(allocateQntmfc + allocateQntmlw + allocateQntcfc + allocateQntclw + allocateQntcbfc + allocateQntcblw + allocateQntstfc +
            allocateQntstlw + allocateQntkfc + allocateQntklw + commonAreaQnt);
    }

    function changeAllocateMasterFc() {
        $(".hidden_multi_fc_master").each(function(i, row) {
            let allocateMasterMultiFc = Number($(row).val());
            let allocateMasterAddFc = parseFloat($(row).closest('tr').find('.hidden_add_fc_master').val());
            let totalMasterFc = $("#total_master_fc").val();
            $(row).closest('tr').find('.allocate_fc_master').val(allocateMasterMultiFc * totalMasterFc + allocateMasterAddFc)
            changeTotal($(row));
        })
    }

    function changeAllocateMasterLw() {
        $(".hidden_multi_lw_master").each(function(i, row) {
            let allocateMasterMultiFc = Number($(row).val());
            let allocateMasterAddFc = parseFloat($(row).closest('tr').find('.hidden_add_lw_master').val());
            let totalMasterFc = $("#total_master_lw").val();
            $(row).closest('tr').find('.allocate_lw_master').val(allocateMasterMultiFc * totalMasterFc + allocateMasterAddFc)
            changeTotal($(row));
        })
    }

    function changeAllocateChildFc() {
        $(".hidden_multi_fc_child").each(function(i, row) {
            let allocateMasterMultiFc = Number($(row).val());
            let allocateMasterAddFc = parseFloat($(row).closest('tr').find('.hidden_add_fc_child').val());
            let totalMasterFc = $("#total_child_fc").val();
            $(row).closest('tr').find('.allocate_fc_child').val(allocateMasterMultiFc * totalMasterFc + allocateMasterAddFc)
            changeTotal($(row));
        })
    }

    function changeAllocateChildLw() {
        $(".hidden_multi_lw_child").each(function(i, row) {
            let allocateMasterMultiFc = Number($(row).val());
            let allocateMasterAddFc = parseFloat($(row).closest('tr').find('.hidden_add_lw_child').val());
            let totalMasterFc = $("#total_child_lw").val();
            $(row).closest('tr').find('.allocate_lw_child').val(allocateMasterMultiFc * totalMasterFc + allocateMasterAddFc)
            changeTotal($(row));
        })
    }

    function changeAllocateCommonFc() {
        $(".hidden_multi_fc_commonBath").each(function(i, row) {
            let allocateMasterMultiFc = Number($(row).val());
            let allocateMasterAddFc = parseFloat($(row).closest('tr').find('.hidden_add_fc_commonBath').val());
            let totalMasterFc = $("#total_common_fc").val();
            $(row).closest('tr').find('.allocate_fc_commonBath').val(allocateMasterMultiFc * totalMasterFc + allocateMasterAddFc)
            changeTotal($(row));
        })
    }

    function changeAllocateCommonLw() {
        $(".hidden_multi_lw_commonBath").each(function(i, row) {
            let allocateMasterMultiFc = Number($(row).val());
            let allocateMasterAddFc = parseFloat($(row).closest('tr').find('.hidden_add_lw_commonBath').val());
            let totalMasterFc = $("#total_common_lw").val();
            $(row).closest('tr').find('.allocate_lw_commonBath').val(allocateMasterMultiFc * totalMasterFc + allocateMasterAddFc)
            changeTotal($(row));
        })
    }

    function changeAllocateSToiletFc() {
        $(".hidden_multi_fc_smallToilet").each(function(i, row) {
            let allocateMasterMultiFc = Number($(row).val());
            let allocateMasterAddFc = parseFloat($(row).closest('tr').find('.hidden_add_fc_smallToilet').val());
            let totalMasterFc = $("#total_toilet_fc").val();
            $(row).closest('tr').find('.allocate_fc_smallToilet').val(allocateMasterMultiFc * totalMasterFc + allocateMasterAddFc)
            changeTotal($(row));
        })
    }

    function changeAllocateSToiletLw() {
        $(".hidden_multi_lw_smallToilet").each(function(i, row) {
            let allocateMasterMultiFc = Number($(row).val());
            let allocateMasterAddFc = parseFloat($(row).closest('tr').find('.hidden_add_lw_smallToilet').val());
            let totalMasterFc = $("#total_toilet_lw").val();
            $(row).closest('tr').find('.allocate_lw_smallToilet').val(allocateMasterMultiFc * totalMasterFc + allocateMasterAddFc)
            changeTotal($(row));
        })
    }

    function changeAllocateKitchenFc() {
        $(".hidden_multi_fc_kitchen").each(function(i, row) {
            let allocateMasterMultiFc = Number($(row).val());
            let allocateMasterAddFc = parseFloat($(row).closest('tr').find('.hidden_add_fc_kitchen').val());
            let totalMasterFc = $("#total_kitchen_fc").val();
            $(row).closest('tr').find('.allocate_fc_kitchen').val(allocateMasterMultiFc * totalMasterFc + allocateMasterAddFc)
            changeTotal($(row));
        })
    }

    function changeAllocateKitchenLw() {
        $(".hidden_multi_lw_kitchen").each(function(i, row) {
            let allocateMasterMultiFc = Number($(row).val());
            let allocateMasterAddFc = parseFloat($(row).closest('tr').find('.hidden_add_lw_kitchen').val());
            let totalMasterFc = $("#total_kitchen_lw").val();
            $(row).closest('tr').find('.allocate_lw_kitchen').val(allocateMasterMultiFc * totalMasterFc + allocateMasterAddFc)
            changeTotal($(row));
        })
    }
</script>
@endsection
