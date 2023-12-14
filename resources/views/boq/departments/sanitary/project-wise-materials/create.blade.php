@extends('boq.departments.sanitary.layout.app')
@section('title', 'BOQ - Sanitary')

@section('breadcrumb-title')
    @if ($formType == 'create')
        New
    @else
        Edit
    @endif
    Material Rate
@endsection

@section('project-name')
    {{ session()->get('project_name') }}
@endsection

@section('breadcrumb-button')
    {{--    @include('components.buttons.breadcrumb-button', ['route' => route('boq.project.departments.electrical.configurations.rates.index',['project' => Session::get('project_id')]), 'type' => 'index']) --}}
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'offset-md-1 col-md-10')

@section('content')
    <div class="row">
        <div class="col-md-12">
            @if ($formType == 'edit')
                {!! Form::open([
                    'url' => "boq/project/$project/departments/sanitary/project-wise-materials/$ProjectWiseMaterialData->id",
                    'method' => 'PUT',
                    'class' => 'custom-form',
                ]) !!}
                <input type="hidden" name="id"
                    value="{{ old('id') ? old('id') : (isset($ProjectWiseMaterialData) ? $ProjectWiseMaterialData->id : null) }}">
            @else
                {!! Form::open([
                    'url' => "boq/project/$project->id/departments/sanitary/project-wise-materials",
                    'method' => 'POST',
                    'class' => 'custom-form',
                ]) !!}
            @endif
            <div class="row">
                {{--                    <div class="col-md-12 col-xl-12"> --}}
                {{--                        <div class="input-group input-group-sm input-group-primary"> --}}
                {{--                            <label class="input-group-addon" for="parent_id0">Floor</label> --}}
                {{--                            {{Form::select('floor_id', $floors, old('floor_id') ? old('floor_id') : (isset($ProjectWiseMaterialData) ? $ProjectWiseMaterialData->floor_id :   null),['class' => 'form-control floor_id','id' => 'floor_id', 'placeholder'=>"Select Floor", 'autocomplete'=>"off"])}} --}}
                {{--                        </div> --}}
                {{--                    </div> --}}
                <div class="col-md-12 col-xl-12">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="parent_id0">1st layer</label>
                        {{ Form::select('parent_id', $leyer1NestedMaterial, old('parent_id') ? old('parent_id') : (isset($ProjectWiseMaterialData) ? $ProjectWiseMaterialData->NestedMaterial->parent_id : $parent_id ?? []), ['class' => 'form-control material', 'id' => 'parent_id', 'placeholder' => 'Select 1st layer material Name', 'autocomplete' => 'off']) }}
                    </div>
                </div>
                <div class="col-md-12 col-xl-12">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="material_second_id">2nd layer</label>
                        {{ Form::select('material_second_id', isset($secondLayerMaterial) ? $secondLayerMaterial : $secondParents ?? [], old('material_second_id') ? old('material_second_id') : (isset($ProjectWiseMaterialData) ? $ProjectWiseMaterialData->material_second_id : null), ['class' => 'form-control ', 'id' => 'material_second_id', 'placeholder' => 'Select 2nd layer Name', 'autocomplete' => 'off']) }}
                    </div>
                </div>
                <br>
                <hr>
                <div class="col-md-12">
                    <table class="table table-bordered" id="calculation_table">
                        <thead>
                            <tr class="electrical_calc_head">
                                <th> Item <span class="text-danger">*</span></th>
                                <th class="material_rate_th"> Rate Type <span class="text-danger">*</span></th>
                                <th class="material_rate_th"> Material Unit Rate <span class="text-danger">*</span></th>
                                <th class="material_rate_th" colspan="2"> Quantity <span class="text-danger">*</span>
                                </th>
                                <th class="material_rate_th"> Total Rate <span class="text-danger">*</span></th>
                                <th>
                                    {{--                                    <i class="btn btn-primary btn-sm fa fa-plus add-calculation-row"></i> --}}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($formType == 'edit')
                                @php
                                    $total = 0;
                                @endphp
                                @foreach ($ProjectWiseMaterialData->projectWiseMaterialDetails as $data)
                                    <tr>
                                        <td>{{ $data->material->name }}
                                            <input type="hidden" name="material_id[]" value="{{ $data->material_id }}"
                                                class="material_id">
                                            {{--                                            <input type="text" name="material_name[]" value='{{ $data->material->name }}' class="form-control form-control-sm material_name" readonly tabindex="-1"> --}}
                                        </td>
                                        <td> {{ Form::select('rate_type[]', $rateType, $data->rate_type, ['class' => 'form-control form-control-sm', 'autocomplete' => 'off']) }}
                                        </td>
                                        <td> <input type="text" name="material_rate[]" value="{{ $data->material_rate }}"
                                                class="form-control form-control-sm text-center material_rate" required>
                                        </td>
                                        <td colspan="2"> <input type="number" name="quantity[]" value="{{ $data->quantity ?? 0 }}"
                                                class="form-control text-center form-control-sm quantity"
                                                placeholder="0.00"> </td>
                                        @php
                                            $rate = $data->material_rate ?? 0;
                                            $qty = $data->quantity ?? 0;
                                            $total += $rate * $qty;
                                        @endphp
                                        <td><input type="text" name="total_rate[]" value="{{ $rate * $qty }}"
                                                class="form-control text-center form-control-sm total_rate" required
                                                placeholder="0.00" readonly tabindex="-1"> </td>
                                        <td>
                                            <i class="btn btn-success btn-sm fa fa-copy add-calculation-row"></i>
                                            <i class="btn btn-danger btn-sm fa fa-minus remove-calculation-row"></i>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif

                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5" class="text-right"><b>Total</b> </td>
                                <td class="text-right">
                                    <input type="text" name="grand_total" id="grand_total"
                                        class="form-control text-right"
                                        value="{{ isset($secondLayerMaterial) ? $total : null }}" readonly />
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <div class="row">
                <div class="offset-md-4 col-md-4 mt-2">
                    <div class="input-group input-group-sm ">
                        <button class="btn btn-success btn-round btn-block py-2 " id="submit_btn">Submit</button>
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
        $(function() {
            $('.material').on('change', function() {
                let material_id = $(this).val();
                let selected_data = this;
                $.ajax({
                    url: "{{ url('scj/getChildMaterial') }}",
                    type: 'GET',
                    data: {
                        'material_id': material_id
                    },
                    success: function(data) {
                        $("#material_second_id").html();
                        $("#material_second_id").html(data);
                    }
                });
            })
        })

        $(document).on('keyup', '.material_name', function(events) {
            let secondLayerMaterial = $("#material_second_id").val();
            $(this).closest('tr').find('.material_id').val(null);
            $(this).autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ route('scj.getLayer3Material') }}",
                        type: 'get',
                        dataType: "json",
                        data: {
                            _token: CSRF_TOKEN,
                            search: request.term,
                            parent_material_id: secondLayerMaterial
                        },
                        success: function(data) {
                            response(data);
                        }
                    });
                },
                select: function(event, ui) {
                    $(this).closest('tr').find('.material_name').val(ui.item.label);
                    $(this).closest('tr').find('.material_id').val(ui.item.material_id);
                    return false;
                }
            });
        });

        $("#material_second_id").on('change', function() {
            appendCalculationRow();
        })

        var parentQnt = 0;

        function appendCalculationRow() {
            let materialSecond = $("#material_second_id").val();
            let materialFirst = $("#parent_id").val();
            let formType = "{{ $formType }}";
            @if ($formType == 'edit')
                let url =
                    "{{ url("boq/project/$ProjectWiseMaterialData->id/departments/sanitary/get-project-wise-material-rate") }}";
                let project_id = {{ $ProjectWiseMaterialData->id }};
            @else
                let url = "{{ url("boq/project/$project->id/departments/sanitary/get-project-wise-material-rate") }}"
                let project_id = {{ $project->id }};
            @endif
            $('#calculation_table tbody').empty();
            $.ajax({
                url: url,
                type: 'post',
                dataType: "json",
                data: {
                    _token: CSRF_TOKEN,
                    material_first: materialFirst,
                    material_second: materialSecond,
                    project_id: project_id
                },
                success: function(material) {
                    console.log(material);
                    parentQnt = material.total_sanitary ? material.total_sanitary : 0;
                    let row = `<tr style="background-color: #c9e8dd; font-size: 12px; font-weight: bold">
                                        <td colspan="3"> ${material.name}</td>
                                        <td colspan="" class="" id="parent_quantity">${parentQnt}</td>
                                        <td colspan="3"> </td>
                                    </tr>`;
                    $('#calculation_table tbody').append(row);
                    // $.each(materials, function (key, material){
                    //     let parentMaterial = material.name
                    //     // console.log(material);
                    //      parentQnt = material.material_allocation ? material.material_allocation.total : 0;
                    //     let row = `<tr style="background-color: #c9e8dd; font-size: 12px; font-weight: bold">
                //                     <td colspan="3"> ${parentMaterial}</td>
                //                     <td colspan="" class="">${parentQnt}</td>
                //                     <td colspan="3"> </td>
                //                 </tr>`;
                    //     $('#calculation_table tbody').append(row);
                    let grandTtoal = 0
                    // console.log(material.descendants);
                    $.each(material.descendants, function(key, sanitaryMaterials) {
                        let childMaterial = sanitaryMaterials.name;
                        let totalQnt = sanitaryMaterials.material_allocation ? sanitaryMaterials
                            .material_allocation.total : 0;
                        let rate = sanitaryMaterials.sanitary_material_rates ? sanitaryMaterials
                            .sanitary_material_rates[0].material_rate : 0;
                        let total = rate * totalQnt;
                        let maxQnt = parentQnt > 0 ? parentQnt : totalQnt;
                        // console.log(maxQnt);
                        let totalFixGroupQnt = 0;

                        let fixedQntClass = ".fixed_quantity_" + sanitaryMaterials.id;

                        let quantity = parentQnt > 0 ? parentQnt : totalQnt;

                        let row = `
                            <tr>
                                <td class="text-left">
                                    <input type="hidden" " name="material_id[]" value="${sanitaryMaterials.id}"  class="material_id ${childMaterial}" >
                                    ${childMaterial}
                                </td>
                                <td> {{ Form::select('rate_type[]', $rateType, null, ['class' => 'form-control form-control-sm', 'autocomplete' => 'off']) }}</td>
                                <td> <input type="text" name="material_rate[]" value="${rate}" class="form-control form-control-sm text-center material_rate" required > </td>
                                <td> <input type="number" name="fixed_quantity[]" value="${totalQnt}" class="form-control text-center form-control-sm fixed_quantity fixed_quantity_${sanitaryMaterials.id}" placeholder="0.00" max="" readonly> </td>
                                <td> <input type="number" name="quantity[]" value="" class="form-control text-center form-control-sm quantity quantity_${material.id} quantity_${sanitaryMaterials.id}" placeholder="0.00" max=""> </td>
                                <td> <input type="text" name="total_rate[]" value="${total}" class="form-control text-right form-control-sm total_rate" required placeholder="0.00" readonly tabindex="-1"> </td>
                                <td class="remove_td">
                                    <i class="btn btn-success btn-sm fa fa-copy add-calculation-row"></i>
                                    <div class="remove_div"></div>
                                </td>
                            </tr>
                            `;
                        $('#calculation_table tbody').append(row);
                        grandTtoal += total;
                        // console.log($(fixedQntClass).val());
                    });
                    $("#grand_total").val(grandTtoal);
                    // });
                }
            });
        }

        $("#parent_id").change(function() {
            if ($(this).val() == 998) {
                $(document).on('change', '.quantity', function() {
                    let quantity_val = $(this).val();
                    let className = $(this).attr('class');
                    let classArr = className.split(" ");

                    let totalGroupQnt = 0;
                    $("." + classArr[4]).each(function(i, g_row) {
                        let groupQnt = Number($(g_row).val());
                        totalGroupQnt += parseFloat(groupQnt);
                    });
                    let totalChildQnt = 0;
                    $("." + classArr[5]).each(function(ci, c_row) {
                        let childQnt = Number($(c_row).val());
                        totalChildQnt += parseFloat(childQnt);
                    })
                    let fixedQuantity = $(this).closest('tr').find('.fixed_quantity');
                    let fixedQntClassName = fixedQuantity.attr('class');
                    let fixedQntClassArr = fixedQntClassName.split(" ");

                    let totalFixedQnt = 0;
                    $("." + fixedQntClassArr[4]).each(function(gi, f_row) {
                        let fixQnt = Number($(f_row).val());
                        totalFixedQnt += parseFloat(fixQnt);
                    })
                    if (parentQnt > 0 && parentQnt < totalGroupQnt) {
                        alert('Given Quantity Beyond the Limit')
                        $("#submit_btn").hide()
                    } else if (parentQnt == 0 && totalFixedQnt < totalChildQnt) {
                        alert('Given Quantity Beyond the Limit')
                        $("#submit_btn").hide();
                    } else {
                        $("#submit_btn").show()
                    }
                })
            }
        });



        // function parentQuantityCheck(){

        // }

        $(document).on('click', '.add-calculation-row', function() {
            appendRow($(this));
        })

        function appendRow(thisVal) {
            let parentTR = thisVal.closest('tr');
            let cloanData = parentTR.clone().insertAfter(parentTR);
            cloanData.find('.quantity').val(0);
            cloanData.find('.fixed_quantity').val(0);
            cloanData.find('.remove_div').empty();
            let remove_btn = `<i class="btn btn-danger btn-sm fa fa-minus remove-calculation-row remove_btn"></i>`
            cloanData.find('.remove_div').append(remove_btn);
        }

        // function getTotalQuantity (thisVal){
        //     let totalFixGroupQnt = 0;  let totalGroupQnt = 0; let totalQnt = 0;
        //     let quantityClass = "quantity_"+thisVal.closest('tr').find('.material_id').val();
        //     let fixedQuantityClass = "fixed_quantity_"+thisVal.closest('tr').find('.material_id').val();
        //     if ($("."+fixedQuantityClass).length > 0) {
        //         $("."+fixedQuantityClass).each(function(fi, f_row) {
        //             let fixgroupQnt = Number($(f_row).val());
        //             totalFixGroupQnt += parseFloat(fixgroupQnt);
        //         })
        //     }
        //     if ($("."+quantityClass).length > 0) {
        //         $("."+quantityClass).each(function(gi, g_row) {
        //             let groupQnt = Number($(g_row).val());
        //             totalGroupQnt += parseFloat(groupQnt);
        //         })
        //     }
        //     if ($(".quantity").length > 0) {
        //         $(".quantity").each(function(i, row) {
        //             let qnt = Number($(row).val());
        //             totalQnt += parseFloat(qnt);
        //         })
        //     }
        // let thisQnt = thisVal.closest('tr').find('.')
        // let maxQnt=0
        // if(parentQnt > 0){
        //     maxQnt = parentQnt-totalQnt;
        //     $('.quantity').attr('max', parseInt(maxQnt));
        // }else{
        //     maxQnt =  totalFixGroupQnt - totalGroupQnt;
        //     $("."+quantityClass).attr('max', parseInt(maxQnt));
        // }

        // console.log(maxQnt)
        // }

        // $(document).on('keyup change', '.quantity', function() {
        //     getTotalQuantity($(this))
        // })

        function totalOperation() {
            var total = 0;
            if ($(".total_rate").length > 0) {
                $(".total_rate").each(function(i, row) {
                    let total_price = Number($(row).val());
                    total += parseFloat(total_price);
                })
            }
            $("#grand_total").val(total.toFixed(2));
        }

        function calculateTotalPrice(thisVal) {
            let quantity = $(thisVal).closest('tr').find('.quantity').val() > 0 ? parseFloat($(thisVal).closest('tr').find(
                '.quantity').val()) : 0;
            let material_rate = $(thisVal).closest('tr').find('.material_rate').val() > 0 ? parseFloat($(thisVal).closest(
                'tr').find('.material_rate').val()) : 0;
            let total = (quantity * material_rate).toFixed(2);
            $(thisVal).closest('tr').find('.total_rate').val(total);
            totalOperation();
        }

        $(document).on('keyup change', '.quantity, .material_rate', function() {
            calculateTotalPrice(this);
            totalOperation();
        });

        $("#calculation_table")
            // .on('click', '.add-calculation-row', () => appendCalculationRow())
            .on('click', '.remove-calculation-row', function() {
                $(this).closest('tr').remove();
            });

        $(function() {
            // @if ($formType == 'create')
            // appendCalculationRow();
            // @endif

        });
    </script>
@endsection
