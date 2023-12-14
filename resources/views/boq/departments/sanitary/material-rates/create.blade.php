@extends('boq.departments.sanitary.layout.app')
@section('title', 'BOQ - Sanitary')

@section('breadcrumb-title')
    New Material Rate
@endsection

@section('project-name')
    {{$project->name}}
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
            @php($project = session()->get('project_id'))
            @if(!empty($sanitaryMaterialRate))
                {{-- {!! Form::open(array('url' => "suppliers/$supplier->id",'method' => 'PUT', 'class'=>'custom-form')) !!} --}}
                {{-- <input type="hidden" name="id" value="{{old('id') ? old('id') : (!empty($supplier->id) ? $supplier->id : null)}}"> --}}

                {!! Form::open(array('url' => "boq/project/$project/departments/sanitary/material-rates/$sanitaryMaterialRate->id",'method' => 'PUT', 'class'=>'custom-form')) !!}
                <input type="hidden" name="id" value="{{old('id') ? old('id') : (isset($sanitaryMaterialRate) ? $sanitaryMaterialRate->id : null)}}">
            @else
                {!! Form::open(array('url' => "boq/project/$project/departments/sanitary/material-rates",'method' => 'POST', 'class'=>'custom-form')) !!}
            @endif
                <div class="row">
                    <div class="col-md-12 col-xl-12">
                        <div class="input-group input-group-sm input-group-primary">
                            <label class="input-group-addon" for="parent_id0">1st layer</label>
                            {{Form::select('parent_id', $leyer1NestedMaterial, old('parent_id[0]') ? old('parent_id[0]') : (!empty($nestedmaterial->parent_id) ? $layer1 : null),['class' => 'form-control material','id' => 'parent_id0', 'placeholder'=>"Select 1st layer material Name", 'autocomplete'=>"off"])}}
                        </div>
                    </div>
                    <div class="col-md-12 col-xl-12">
                        <div class="input-group input-group-sm input-group-primary">
                            <label class="input-group-addon" for="parent_id_second">2nd layer</label>
                            {{Form::select('parent_id_second', !empty($nestedmaterial->parent_id) ? $leyer2NestedMaterial : [],old('parent_id_second') ? old('parent_id_second') : (!empty($nestedmaterial->parent_id) ? $layer2 : null),['class' => 'form-control material','id' => 'parent_id_second', 'placeholder'=>"Select 2nd layer material Name", 'autocomplete'=>"off"])}}
                        </div>
                    </div>
                    <br>
                    <hr>
                    <div class="col-md-12">
                        <table class="table table-bordered" id="calculation_table">
                            <thead>
                                <tr class="electrical_calc_head">
                                    <th> Item <span class="text-danger">*</span></th>
{{--                                    <th class="material_rate_th"> Rate Type <span class="text-danger">*</span></th>--}}
                                    <th class=""> Unit<span class="text-danger">*</span></th>
                                    <th class="material_rate_th"> Material Unit Rate <span class="text-danger">*</span></th>
                                    <th><i class="btn btn-primary btn-sm fa fa-plus add-calculation-row"></i></th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                            <tfoot>
                            <tr>

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
            {!! Form::close() !!}
        </div>
    </div>


@endsection

@section('script')
    <script>
        const CSRF_TOKEN = "{{ csrf_token() }}";
        $(function() {
            $('.material').on('change',function(){
                var material_id = $(this).val();
                var selected_data = this;
                $.ajax({
                    url:"{{ url('scj/getChildMaterial') }}",
                    type: 'GET',
                    data: {'material_id': material_id},
                    success: function(data){
                        $(selected_data).parent('div').parent('div').next('div').find('.material').html();
                        $(selected_data).parent('div').parent('div').next('div').find('.material').html(data);
                    }
                });
            })
        })

        $(document).on('keyup','.material_name',function(events){
            let secondLayerMaterial = $("#parent_id_second").val();
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
                    $(this).closest('tr').find('.unit').val(ui.item.unit_name);
                    return false;
                }
            });
        });

        function appendCalculationRow(material_id,material_name) {
            let row = `
                <tr>
                    <td>
                        <input type="hidden" name="material_id[]" class="material_id" >
                        <input type="text" name="material_name[]" class="form-control text-center form-control-sm material_name" autocomplete="off" required placeholder="Material Name" tabindex="-1">
                    </td>
{{--                    <td> {{Form::select('parent_id_second', $rateType, null,['class' => 'form-control form-control-sm', 'placeholder'=>"Select Type", 'autocomplete'=>"off"])}}</td>--}}
                    <td> <input type="text" name="unit[]" class="form-control form-control-sm unit text-center" readonly> </td>
                    <td> <input type="number" name="material_rate[]" class="form-control form-control-sm material_rate" required placeholder="Material Unit Rate"> </td>
                    <td> <i class="btn btn-danger btn-sm fa fa-minus remove-calculation-row"></i> </td>
                </tr>
                `;
            $('#calculation_table tbody').append(row);
        }

        $("#calculation_table")
            .on('click', '.add-calculation-row', () => appendCalculationRow())
            .on('click', '.remove-calculation-row', function() {
                $(this).closest('tr').remove();
            });

        $(function() {
            appendCalculationRow();
        });
    </script>
@endsection
