@extends('boq.departments.sanitary.layout.app')
@section('title', 'BOQ - Sanitary')

@section('breadcrumb-title')
@if($formType == 'create')
    New
@else
    Update
@endif
    Formula
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
            @if($formType == 'edit')
                {!! Form::open(array('url' => "boq/project/$project->id/departments/sanitary/sanitary-formulas/$sanitaryFormula->id",'method' => 'PUT', 'class'=>'custom-form')) !!}
                <input type="hidden" name="id" value="{{old('id') ? old('id') : (isset($sanitaryFormula) ? $sanitaryFormula->id : null)}}">
            @else
                {!! Form::open(array('url' => "boq/project/$project->id/departments/sanitary/sanitary-formulas",'method' => 'POST', 'class'=>'custom-form')) !!}
            @endif
                <div class="row">
                    <div class="col-md-6 col-xl-6">
                        <div class="input-group input-group-sm input-group-primary">
                            <label class="input-group-addon" for="parent_id">Location Type</label>
                            {{Form::select('location_type', $locationTypes, old('location_type') ? old('location_type') : (!empty($sanitaryFormula) ? $sanitaryFormula->location_type : null),['class' => 'form-control material','id' => 'location_type','placeholder'=>'Select Type','autocomplete'=>"off"])}}
                        </div>
                    </div>
                    <div class="col-md-3 pr-md-1 my-1 my-md-0">
                        <div class="input-group input-group-sm input-group-primary">
                            <label class="input-group-addon" for="project_id">Location for<span class="text-danger"></span></label>
                            <input type="radio" id="yes" name="location_for" style="height:20px; width:20px; margin-left: 30px; margin-top: 8px" value="1" {{ (!empty($sanitaryFormula) && $sanitaryFormula->location_for == 1 ? 'checked' : "") }}>
                            <label  style="margin-left: 5px; margin-top: 12px" for="yes">Residential </label><br>
                            <input type="radio" id="no" name="location_for" style="height:20px; width:20px; margin-left: 30px; margin-top: 8px" value="0" {{ (!empty($sanitaryFormula) && $sanitaryFormula->location_for == 0 ? 'checked': "") }}>
                            <label  style="margin-left: 5px; margin-top: 12px" for="no">Commercial </label><br>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <table class="table table-bordered" id="calculation_table">
                            <thead>
                                <tr class="electrical_calc_head">
                                    <th> Item <span class="text-danger">*</span></th>
                                    <th class="material_rate_th"> Unit <span class="text-danger">*</span></th>
                                    <th class="material_rate_th"> Multiply Qnt <span class="text-danger">*</span></th>
                                    <th class="material_rate_th"> Addition Qnt <span class="text-danger">*</span></th>
                                    <th class="material_rate_th"> Formula <span class="text-danger">*</span></th>
                                    <th>
                                        <i class="btn btn-primary btn-sm fa fa-plus add-calculation-row"></i>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($formType == 'edit')
                                @foreach ($sanitaryFormula->sanitaryFormulaDetails as $data)
                                    <tr>
                                        <td>
                                            <input type="hidden" name="material_id[]" value="{{ $data->material_id }}" class="material_id" >
                                            <input type="text" name="material_name[]" value='{{ $data->material->name }}' class="form-control text-center form-control-sm material_name" autocomplete="off" required placeholder="Material Name" >
                                        </td>
                                        <td> <input type="text" name="unit[]" value='{{ $data->material->unit->name }}' class="form-control form-control-sm text-center unit" readonly tabindex="-1"> </td>
                                        <td> <input type="number" name="multiply_qnt[]" value='{{ $data->multiply_qnt }}' class="form-control form-control-sm text-center multiply_qnt" required placeholder="0.00"> </td>
                                        <td> <input type="number" name="additional_qnt[]" value='{{ $data->additional_qnt }}' class="form-control form-control-sm text-center additional_qnt" required placeholder="0.00"> </td>
                                        <td> <input type="text" name="formula[]" value='{{ $data->formula }}' class="form-control form-control-sm text-center formula" required readonly> </td>

                                            <td> <i class="btn btn-danger btn-sm fa fa-minus remove-calculation-row"></i> </td>
                                    </tr>
                                @endforeach
                                @endif
                            </tbody>
                            <tfoot>

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

        $(document).on('keyup','.material_name',function(events){
            $(this).closest('tr').find('.material_id').val(null);
            $(this).autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ url('boq/project/$project->id/departments/sanitary/get-sanitary-material') }}",
                        type: 'post',
                        dataType: "json",
                        data: {
                            _token: CSRF_TOKEN,
                            search: request.term,
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

        $(document).on('keyup','.multiply_qnt, .additional_qnt', function (){
            changeFormula($(this));
        })
        function changeFormula (thisVal){
            let multiplyVal = thisVal.closest('tr').find('.multiply_qnt').val();
            let additionalVal = thisVal.closest('tr').find('.additional_qnt').val();
            let formula = "1 * "+ multiplyVal + " + " + additionalVal
            thisVal.closest('tr').find('.formula').val(formula);
        }
        function appendCalculationRow(material_id,material_name) {
            let row = `
                <tr>
                    <td>
                        <input type="hidden" name="material_id[]" class="material_id" >
                        <input type="text" name="material_name[]" class="form-control text-center form-control-sm material_name" autocomplete="off" required placeholder="Material Name" >
                    </td>
                    <td> <input type="text" name="unit[]" class="form-control form-control-sm text-center unit" readonly tabindex="-1"> </td>
                    <td> <input type="number" name="multiply_qnt[]" class="form-control form-control-sm text-center multiply_qnt" required placeholder="0.00"> </td>
                    <td> <input type="number" name="additional_qnt[]" class="form-control form-control-sm text-center additional_qnt" required placeholder="0.00"> </td>
                    <td> <input type="text" name="formula[]" class="form-control form-control-sm text-center formula" required readonly> </td>
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
            @if($formType == 'create')
            appendCalculationRow();
            @endif
        })
    </script>
@endsection



