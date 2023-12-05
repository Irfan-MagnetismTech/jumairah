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
        {!! Form::open(array('url' => "boq/project/$project->id/departments/sanitary/sanitary-allocations/$project->id",'method' => 'PUT', 'class'=>'custom-form')) !!}
        <input type="hidden" name="id" value="{{old('id') ? old('id') : (!empty($project->id) ? $project->id : null)}}">

        <input type="hidden" name="type" value="{{old('type') ? old('type') : $type}}">
        <div class="row">
            <div class="col-md-12 table-responsive">
                <table class="table table-bordered" id="commercial_table">
                    <thead>
                        <tr style="background-color: #2ed8b6!important;">
                            <td class="text-center" colspan="13">
                                <h5 style="color: white" class="text-center">Commercial Part</h5>
                            </td>
                        </tr>
                        <tr>
                            <th>Floor Details</th>
                            <th>No of Floor</th>
                            <th>Toilet</th>
                            <th>Wash Basin</th>
                            <th>Urinal</th>
                            <th>Pantry </th>
                            <th>Common Toilet </th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($allocationsCommercial as $key => $comdata)
                        <tr>
                            <td>
                                {{Form::text("floor[]", old('floor') ? old('floor') : (!empty($comdata['floor']) ? $comdata['floor'] : null),['class' => "form-control form-control-sm text-left floor", 'autocomplete'=>"off"])}}
                            </td>
                            <td class="text-center">
                                {{Form::text("floor_no[]", old('floor_no') ? old('floor_no') : (!empty($comdata['floor_no']) ? $comdata['floor_no'] : null),['class' => "form-control form-control-sm text-center floor_no", 'autocomplete'=>"off"])}}
                            </td>
                            @foreach($comdata['typeWiseQuantity'] as $d)
                            <td class="text-center ">
                                <input type="text" name="quantity[]" class="form-control form-control-sm text-center quantity {{ 'calculate_'.strtolower($d['location_type']) }}" value="{{$d['fc_quantity']}}" autocomplete="off">
                            </td>
                            @endforeach
                        </tr>
                        @endforeach

                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2" class="text-right"><b>Total</b> </td>
                            @php
                            $total_toilet = 0;
                            $total_basin = 0;
                            $total_urinal = 0;
                            $total_pantry = 0;
                            $total_common_toilet = 0;
                            @endphp
                            @foreach($allocationsCommercial as $key => $comdata)
                            @foreach($comdata['typeWiseQuantity'] as $d)
                            @php
                            if($d['location_type'] == 'Toilet')
                            $total_toilet += $d['fc_quantity'];
                            if($d['location_type'] == 'Wash Basin')
                            $total_basin += $d['fc_quantity'];
                            if($d['location_type'] == 'Urinal')
                            $total_urinal += $d['fc_quantity'];
                            if($d['location_type'] == 'Pantry')
                            $total_pantry += $d['fc_quantity'];
                            if($d['location_type'] == 'Common Toilet')
                            $total_common_toilet += $d['fc_quantity'];
                            @endphp
                            @endforeach
                            @endforeach



                            <td class="text-right">
                                <input type="text" name="total_toilet" id="total_toilet" class="form-control text-right" value="{{$total_toilet}}" readonly />
                            </td>
                            <td class="text-right">
                                <input type="text" name="total_basin" id="total_basin" class="form-control text-right" value="{{$total_basin}}" readonly />
                            </td>
                            <td class="text-right">
                                <input type="text" name="total_urinal" id="total_urinal" class="form-control text-right" value="{{$total_urinal}}" readonly />
                            </td>
                            <td class="text-right">
                                <input type="text" name="total_pantry" id="total_pantry" class="form-control text-right" value="{{$total_pantry}}" readonly />
                            </td>
                            <td class="text-right">
                                <input type="text" name="total_common_toilet" id="total_common_toilet" class="form-control text-right" value="{{$total_common_toilet}}" readonly />
                            </td>
                        </tr>
                    </tfoot>
                </table>
                <br>
                <hr>
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
                        @foreach($sanitaryAllocations as $sanitaryAllocation)
                        <tr>
                            <td class="text-left">
                                {{Form::text("item_name[]", old('item_name') ? old('item_name') : (!empty($sanitaryAllocation->materials->name) ? $sanitaryAllocation->materials->name : null),['class' => "form-control form-control-sm text-left item_name", 'autocomplete'=>"off"])}}
                            </td>
                            <td class="">
                                {{Form::text("unit[]", old('unit') ? old('unit') : (!empty($sanitaryAllocation->materials->unit->name) ? $sanitaryAllocation->materials->unit->name : null),['class' => "form-control form-control-sm text-center unit", 'autocomplete'=>"off"])}}
                            </td>
                            <td class="">
                                {{Form::text("toilet[]", old('toilet') ? old('toilet') : (!empty($sanitaryAllocation->commercial_toilet) ? $sanitaryAllocation->commercial_toilet : null),['class' => "form-control form-control-sm text-center hidden_add_toilet", 'autocomplete'=>"off"])}}
                            </td>
                            <td class="">
                                {{Form::text("wash_basin[]", old('wash_basin') ? old('wash_basin') : (!empty($sanitaryAllocation->basin) ? $sanitaryAllocation->basin : null),['class' => "form-control form-control-sm text-center wash_basin", 'autocomplete'=>"off"])}}
                            </td>
                            <td class="">
                                {{Form::text("urinal[]", old('urinal') ? old('urinal') : (!empty($sanitaryAllocation->urinal) ? $sanitaryAllocation->urinal : null),['class' => "form-control form-control-sm text-center urinal", 'autocomplete'=>"off"])}}
                            </td>
                            <td class="">
                                {{Form::text("pantry[]", old('pantry') ? old('pantry') : (!empty($sanitaryAllocation->pantry) ? $sanitaryAllocation->pantry : null),['class' => "form-control form-control-sm text-center pantry", 'autocomplete'=>"off"])}}
                            </td>
                            <td class="">
                                {{Form::text("common_toilet[]", old('common_toilet') ? old('common_toilet') : (!empty($sanitaryAllocation->common_toilet) ? $sanitaryAllocation->common_toilet : null),['class' => "form-control form-control-sm text-center common_toilet", 'autocomplete'=>"off"])}}
                            </td>
                            <td class="">
                                {{Form::text("total[]", old('total') ? old('total') : (!empty($sanitaryAllocation->total) ? $sanitaryAllocation->total : null),['class' => "form-control form-control-sm text-center total", 'autocomplete'=>"off"])}}
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

    $(document).on('keyup', '.calculate_toilet', function() {
        changeTotalCommercialToilet();
    })
    $(document).on('keyup', '.calculate_wash', function() {
        changeTotalBasin();
    })
    $(document).on('keyup', '.calculate_urinal', function() {
        changeTotalUrinal();
    })
    $(document).on('keyup', '.calculate_pantry', function() {
        changeTotalPantry();
    })
    $(document).on('keyup', '.calculate_common', function() {
        changeTotalCommonToilet();
    })

    function changeTotalCommercialToilet() {
        let total = 0;
        if ($(".calculate_toilet").length > 0) {
            $(".calculate_toilet").each(function(i, row) {
                console.log('row', row);
                let totalQnt = Number($(row).val());
                total += parseFloat(totalQnt);
            })
        }
        $("#total_toilet").val(total);
        changeAllocateToilet();
    }

    function changeTotalBasin() {
        let total = 0;
        if ($(".calculate_wash").length > 0) {
            $(".calculate_wash").each(function(i, row) {
                let totalQnt = Number($(row).val());
                total += parseFloat(totalQnt);
            })
        }
        $("#total_basin").val(total);
        changeAllocateBasin();
    }

    function changeTotalUrinal() {
        let total = 0;
        if ($(".calculate_urinal").length > 0) {
            $(".calculate_urinal").each(function(i, row) {
                let totalQnt = Number($(row).val());
                total += parseFloat(totalQnt);
            })
        }
        $("#total_urinal").val(total);
        changeAllocateUrinal();
    }

    function changeTotalPantry() {
        let total = 0;
        if ($(".calculate_pantry").length > 0) {
            $(".calculate_pantry").each(function(i, row) {


                let totalQnt = Number($(row).val());
                total += parseFloat(totalQnt);
            })
        }
        $("#total_pantry").val(total);
        changeAllocatePantry();
    }

    function changeTotalCommonToilet() {
        let total = 0;
        if ($(".calculate_common").length > 0) {
            $(".calculate_common").each(function(i, row) {
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