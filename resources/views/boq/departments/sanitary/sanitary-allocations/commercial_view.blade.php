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
        <div class="row">
            <div class="col-md-12 table-responsive">
                <table class="table table-bordered" id="calculation_table">
                    <thead>
                        <tr style="background-color: #2ed8b6!important;">
                            <td class="text-center" colspan="13">
                                <h5 style="color: white" class="text-center">Commercial Part</h5>
                            </td>
                        </tr>
                        <tr>
                            <th>Floor Details</th>
                            <th>No of Floor</th>
                            <th colspan="2">Toilet</th>
                            <th colspan="2">Wash Basin</th>
                            <th colspan="2">Urinal</th>
                            <th colspan="2">Pantry </th>
                            <th colspan="2">Common Toilet </th>
                        </tr>

                        @foreach($allocationsCommercial as $key => $comdata)

                        <tr style="background-color: #c9e8dd">
                            <td> {{$comdata['floor']}}</td>
                            <td> {{$comdata['floor_no']}}</td>
                            @foreach($comdata['typeWiseQuantity'] as $d)
                            <td colspan="2">{{$d['fc_quantity']}}</td>
                            @endforeach
                        </tr>
                        @endforeach

                        </tbody>
                </table>
                <br>
                <hr>
                <br>
                <table class="table table-bordered" id="calculation_table">
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
                            <td>{{$sanitaryAllocation->materials->name}}</td>
                            <td>{{$sanitaryAllocation->materials->unit->name}}</td>
                            <td>{{$sanitaryAllocation->commercial_toilet}}</td>
                            <td>{{$sanitaryAllocation->basin}}</td>
                            <td>{{$sanitaryAllocation->urinal}}</td>
                            <td>{{$sanitaryAllocation->pantry}}</td>
                            <td>{{$sanitaryAllocation->common_toilet}}</td>
                            <td>{{$sanitaryAllocation->total}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

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