@extends('boq.departments.sanitary.layout.app')
@section('title', 'BOQ - Sanitary')

@section('breadcrumb-title')
    Update Material Rate
@endsection

@section('project-name')
    {{session()->get('project_name')}}
@endsection

@section('breadcrumb-button')
{{--    @include('components.buttons.breadcrumb-button', ['route' => route('boq.project.departments.electrical.configurations.rates.index',['project' => Session::get('project_id')]), 'type' => 'index'])--}}
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'offset-md-1 col-md-10')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <form action="{{ route('boq.project.departments.sanitary.project-wise-materials.update',['project' => $project,'project_wise_material'=>$project_wise_material,
            'calculation' => $calculation]) }}" method="POST" class="custom-form">
                {{-- {!! Form::open(array(route('boq.project.departments.sanitary.project-wise-materials.update', ['project' => $project,'project_wise_material'=>$project_wise_material]),'method' => 'PUT', 'class'=>'custom-form')) !!} --}}
                @method('put')
                @csrf

                <input type="hidden" name="id" value="{{old('id') ? old('id') : (isset($ProjectWiseMaterialData) ? $ProjectWiseMaterialData->id : null)}}">

                <div class="row">
                    <div class="col-md-12 col-xl-12">
                        <div class="input-group input-group-sm input-group-primary">
                            <label class="input-group-addon" for="parent_id0">Floor</label>
                            {{Form::select('floor_id', $floors, old('floor_id') ? old('floor_id') : (isset($ProjectWiseMaterialData) ? $ProjectWiseMaterialData->floor_id :  null),['class' => 'form-control floor_id','id' => 'floor_id', 'placeholder'=>"Select Floor", 'autocomplete'=>"off"])}}
                        </div>
                    </div>
                    <div class="col-md-12 col-xl-12">
                        <div class="input-group input-group-sm input-group-primary">
                            <label class="input-group-addon" for="parent_id0">1st layer</label>
                            {{Form::select('parent_id', $leyer1NestedMaterial, old('parent_id') ? old('parent_id') : (isset($ProjectWiseMaterialData) ? $ProjectWiseMaterialData->NestedMaterial->parent_id : null ),['class' => 'form-control material','id' => 'parent_id', 'placeholder'=>"Select 1st layer material Name", 'autocomplete'=>"off"])}}
                        </div>
                    </div>
                    <div class="col-md-12 col-xl-12">
                        <div class="input-group input-group-sm input-group-primary">
                            <label class="input-group-addon" for="material_second_id">2nd layer</label>
                            {{Form::select('material_second_id', $secondLayerMaterial,old('material_second_id') ? old('material_second_id') : (isset($ProjectWiseMaterialData) ? $ProjectWiseMaterialData->material_second_id : null),['class' => 'form-control ','id' => 'material_second_id', 'placeholder'=>"Select 2nd layer Name", 'autocomplete'=>"off"])}}
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
                                <th class="material_rate_th"> Quantity <span class="text-danger">*</span></th>
                                <th class="material_rate_th"> Total Rate <span class="text-danger">*</span></th>
                                <th>
{{--                                    <i class="btn btn-primary btn-sm fa fa-plus add-calculation-row"></i>--}}
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr style="background-color: #c9e8dd; font-size: 12px; font-weight: bold">
                                    <td colspan="6"> {{ (isset($ProjectWiseMaterialData) ? $ProjectWiseMaterialData->NestedMaterial->name : null) }}</td>
                                </tr>

                                @if(isset($ProjectWiseMaterialData))
                                    @php
                                        $total = 0;
                                    @endphp
                                    @foreach ($ProjectWiseMaterialData->projectWiseMaterialDetails as $data)
                                        <tr>
                                            <td>
                                                <input type="hidden" name="material_id[]" value="{{ $data->material_id }}"  class="material_id" >
                                                <input type="text" name="material_name[]" value='{{ $data->material->name }}' class="form-control form-control-sm material_name" readonly tabindex="-1">
                                            </td>
                                            <td> {{Form::select('rate_type[]', $rateType, $data->rate_type,['class' => 'form-control form-control-sm', 'placeholder'=>"Select Type", 'autocomplete'=>"off"])}}</td>
                                            <td> <input type="text" name="material_rate[]" value="{{ $data->material_rate }}" class="form-control form-control-sm text-center material_rate" required > </td>
                                            <td> <input type="number" name="quantity[]" value="{{ $data->quantity ?? 0}}" class="form-control text-center form-control-sm quantity" placeholder="0.00"> </td>
                                            @php
                                                $rate = $data->material_rate ?? 0;
                                                $qty = $data->quantity ?? 0;
                                                $total += $rate*$qty;
                                            @endphp
                                            <td><input type="text" name="total_rate[]" value="{{ $rate * $qty}}" class="form-control text-center form-control-sm total_rate" required placeholder="0.00" readonly tabindex="-1"> </td>
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
                                <td  colspan="4" class="text-right" ><b>Total</b> </td>
                                <td class="text-right">
                                    <input type="text" name="grand_total" id="grand_total" class="form-control text-center" value="{{ $total }}" readonly/>
                                </td>
                            </tr>
                            </tfoot>
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
           </form>
        </div>
    </div>


@endsection

@section('script')
    <script>
        const CSRF_TOKEN = "{{ csrf_token() }}";
        $(function() {
            $('.material').on('change',function(){
                let material_id = $(this).val();
                let selected_data = this;
                $.ajax({
                    url:"{{ url('scj/getChildMaterial') }}",
                    type: 'GET',
                    data: {'material_id': material_id},
                    success: function(data){
                        $("#material_second_id").html();
                        $("#material_second_id").html(data);
                    }
                });
            })
        })

        $(document).on('keyup','.material_name',function(events){
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
                        success: function( data ) {
                            response( data );
                        }
                    });

                },
                select: function(event, ui) {
                    console.log(ui);
                    $(this).closest('tr').find('.material_name').val(ui.item.label);
                    $(this).closest('tr').find('.material_id').val(ui.item.material_id);
                    return false;
                }
            });
        });

        $("#parent_id, #material_second_id").on('change', function (){
            appendCalculationRow();
        })

        function appendCalculationRow() {
            let materialSecond = $("#material_second_id").val();
            let materialFirst = $("#parent_id").val();
            $('#calculation_table tbody').empty();
            $.ajax({
                url: '{{ url("boq/project/$project/departments/sanitary/get-project-wise-material-rate")}}',
                type: 'post',
                dataType: "json",
                data: {
                    _token: CSRF_TOKEN,
                    material_first: materialFirst,
                    material_second: materialSecond,
                    project_id: {{$project}}
                },
                success: function(materials) {
                    $.each(materials, function (key, material){
                        let parentMaterial = material.name
                        console.log(material);
                        let row = `<tr style="background-color: #c9e8dd; font-size: 12px; font-weight: bold">
                                        <td colspan="6"> ${parentMaterial}</td>
                                    </tr>`;
                        $('#calculation_table tbody').append(row);
                        $.each(material['sanitaryMaterials'], function (key, sanitaryMaterials){
                            let material = sanitaryMaterials.material.name;
                            let row = `
                            <tr>
                                <td>
                                    <input type="hidden" name="material_id[]" value="${sanitaryMaterials.material_id}"  class="material_id" >
                                    <input type="text" name="material_name[]" value='${material}' class="form-control form-control-sm material_name" readonly tabindex="-1">
                                </td>
                                <td> {{Form::select('rate_type[]', $rateType, 'A',['class' => 'form-control form-control-sm', 'placeholder'=>"Select Type", 'autocomplete'=>"off"])}}</td>
                                <td> <input type="text" name="material_rate[]" value="${sanitaryMaterials.material_rate}" class="form-control form-control-sm text-center material_rate" required > </td>
                                <td> <input type="number" name="quantity[]" class="form-control text-center form-control-sm quantity" placeholder="0.00"> </td>
                                <td> <input type="text" name="total_rate[]" class="form-control text-center form-control-sm total_rate" required placeholder="0.00" readonly tabindex="-1"> </td>
                                <td>
                                    <i class="btn btn-success btn-sm fa fa-copy add-calculation-row"></i>
                                    <i class="btn btn-danger btn-sm fa fa-minus remove-calculation-row"></i>
                                </td>
                            </tr>
                            `;
                            $('#calculation_table tbody').append(row);
                        });
                    });
                }
            });
        }

        $(document).on('click', '.add-calculation-row', function() {
            appendRow($(this));
        })

        function appendRow(thisVal){
            let parentTR = thisVal.closest('tr');
            parentTR.clone().insertAfter(parentTR);
        }

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
            let quantity = $(thisVal).closest('tr').find('.quantity').val() > 0 ? parseFloat($(thisVal).closest('tr').find('.quantity').val()) : 0;
            let material_rate = $(thisVal).closest('tr').find('.material_rate').val() > 0 ? parseFloat($(thisVal).closest('tr').find('.material_rate').val()) : 0;
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


    </script>
@endsection



