@extends('boq.departments.electrical.layout.app')
@section('title', 'BOQ - EME Load Calculation')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
<style>

    .radio_container {
      position: relative!important;
      padding-left: 35px!important;
      margin-bottom: 12px!important;
      cursor: pointer!important;
      font-size: 15px!important;
      -webkit-user-select: none!important;
      -moz-user-select: none!important;
      -ms-user-select: none!important;
      user-select: none!important;

    }

    /* Hide the browser's default radio button */
    .radio_container input {
      position: absolute!important;
      opacity: 0!important;
      cursor: pointer!important;
      box-sizing: border-box!important;
    }
    .checkmark {
      position: absolute!important;
      top: 5%!important;
      left: 0!important;
      height: 20px!important;
      width: 20px!important;
      margin-left: 5px!important;
      background-color: #227447!important;
      border-radius: 50%!important;
    }
    .radio_container:hover input ~ .checkmark {
      background-color: #96cfce!important;
    }
    .radio_container input:checked ~ .checkmark {
      background-color: #227447!important;
    }
    .checkmark:after {
      content: ""!important;
      position: absolute!important;
      display: none!important;
    }
    .radio_container input:checked ~ .checkmark:after {
      display: block!important;
    }
    .radio_container .checkmark:after {
         top: 6px!important;
        left: 6px!important;
        width: 8px!important;
        height: 8px!important;
        border-radius: 50%!important;
        background: white!important;
    }
</style>
@endsection

@section('breadcrumb-title', "EME Load Calculation")

@section('breadcrumb-button')
@endsection

@section('sub-title')
@endsection
@section('content-grid', 'offset-md-1 col-md-10 offset-lg-2 col-lg-8 my-3')
@section('content')
            <div class="row">
                <div class="col-md-12">
                    @if($formType == 'edit')
                        {!! Form::open(array('url' => "boq/project/$project->id/departments/electrical/load_calculations/$load_calculation->id",'method' => 'PUT', 'class'=>'custom-form')) !!}
                        <input type="hidden" name="id" value="{{old('id') ? old('id') : (isset($load_calculation) ? $load_calculation->id : null)}}">
                    @else
                        {!! Form::open(array('url' => "boq/project/$project->id/departments/electrical/load_calculations",'method' => 'POST', 'class'=>'custom-form')) !!}
                    @endif
                    <input type="hidden" name="project_id" value="{{old('project_id') ? old('project_id') :$project->id}}">
                        <div class="row">
                            <div class="col-md-6 offset-md-3 pr-md-1 mb-2 pt-2 d-flex justify-content-around" style="border:1px solid rgb(210, 223, 221);float:left">
                                <label class="radio_container">Residential
                                  <input type="radio" id="residential" class="residential" value="0" name="project_type" {{ (((!empty(old('project_type')) && (old('project_type') == '0')) || (isset($load_calculation) && ($load_calculation->project_type == 0))) ? 'checked': "checked") }}>
                                  <span class="checkmark"></span>
                                </label>
                                <label class="radio_container">Commercial
                                  <input type="radio" id="commercial" class="commercial" value="1" name="project_type" {{ (((!empty(old('project_type')) && (old('project_type') == '1')) || (isset($load_calculation) && ($load_calculation->project_type == 1)))  ? 'checked' : "") }}>
                                  <span class="checkmark"></span>
                                </label>
                                {{-- <label class="radio_container">Residential Cum Commercial
                                    <input type="radio" id="residential_cum_commercial" class="residential_cum_commercial" value="2" name="project_type" {{ (((!empty(old('project_type')) && (old('project_type') == '2')) || (isset($load_calculation) && ($load_calculation->project_type == 2)))  ? 'checked' : "") }}>
                                    <span class="checkmark"></span>
                                </label> --}}
                          </div>

                          <div class="col-md-6 offset-md-3 pr-md-1 mb-2 mt-1 pt-2 d-flex justify-content-around" style="border:1px solid rgb(210, 223, 221);float:left">
                            <label class="radio_container">Common
                              <input type="radio" id="common" class="common" value="0" name="calculation_type" {{ (((!empty(old('calculation_type')) && (old('calculation_type') == '0')) || (isset($load_calculation) && ($load_calculation->calculation_type == 0))) ? 'checked': "checked") }}>
                              <span class="checkmark"></span>
                            </label>
                            <label class="radio_container">Typical
                              <input type="radio" id="typical" class="typical" value="1" name="calculation_type" {{ (((!empty(old('calculation_type')) && (old('calculation_type') == '1')) || (isset($load_calculation) && ($load_calculation->calculation_type == 1)))  ? 'checked' : "") }}>
                              <span class="checkmark"></span>
                            </label>
                            <label class="radio_container">Generator
                                 <input type="radio" id="generator" class="generator" value="2" name="calculation_type" {{ (((!empty(old('calculation_type')) && (old('calculation_type') == '2')) || (isset($load_calculation) && ($load_calculation->calculation_type == 2)))  ? 'checked' : "") }}>
                                <span class="checkmark"></span>
                              </label>
                        </div>
                        <div class="col-3 pr-md-1 mb-2 mt-1 pt-2">
                            <div class="input-group input-group-sm input-group-primary" id="hidden_content" style="{{ (((!empty(old('calculation_type')) && (old('calculation_type') == '2')) || (isset($load_calculation) && ($load_calculation->calculation_type == 2)))  ? '' : 'display: none;') }}">
                            <input type="text" name="genarator_efficiency" class="form-control text-center form-control-sm" placeholder="efficiency of genarator" value="{{ old('genarator_efficiency') ? old('genarator_efficiency') : ((isset($load_calculation) && ($load_calculation->calculation_type == 2)) ? $load_calculation->genarator_efficiency : null) }}"/>
                            <label class="input-group-addon" for="client_name" style="min-width:12%!important;padding-left: 3.6% !important">%</label>
                            </div>
                        </div>
                            <div class="col-md-12">
                                <table class="table table-bordered" id="calculation_table">
                                    <thead>
                                        <tr class="electrical_calc_head">
                                            <th> Floor </th>
                                            <th class="material_rate_th"> Material Name <span class="text-danger">*</span></th>
                                            <th class="material_rate_th"> Unit <span class="text-danger">*</span></th>
                                            <th class="material_rate_th"> Load <br/>(Watt) <span class="text-danger">*</span></th>
                                            <th class="material_rate_th"> Qty <br/>(Quantity) <span class="text-danger">*</span></th>
                                            <th class="material_rate_th"> Connected load <br/> (KW)<span class="text-danger">*</span></th>
                                            <th>
                                                <i class="btn btn-primary btn-sm fa fa-plus add-calculation-row"></i>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(old('material_id'))
                                            @foreach (old('material_id') as $key => $value )
                                                <tr>
                                                    <td>
                                                        <input type="hidden" name="floor_id[]" value="{{ old('floor_id')[$key] }}" class="floor_id" >
                                                        <input type="text" name="floor_name[]" value="{{ old('floor_name')[$key] }}"class="form-control text-center form-control-sm floor_name" autocomplete="off" required placeholder="Floor Name" >
                                                    </td>
                                                    <td>
                                                        <input type="hidden" name="material_id[]" value="{{ old('material_id')[$key] }}" class="material_id" >
                                                        <input type="text" name="material_name[]" value="{{ old('material_name')[$key] }}"class="form-control text-center form-control-sm material_name" autocomplete="off" required placeholder="Material Name" >
                                                    </td>
                                                    <td> <input type="text" name="unit[]" value="{{ old('unit')[$key] }}" class="form-control form-control-sm text-center unit" readonly tabindex="-1"> </td>
                                                    <td> <input type="number" name="load[]" class="form-control form-control-sm text-center load" value="{{ old('load')[$key] }}" required placeholder="0.00"> </td>
                                                    <td> <input type="number" name="qty[]" value="{{ old('qty')[$key] }}" class="form-control form-control-sm text-center qty" required placeholder="0.00"> </td>
                                                    <td> <input type="text" name="connected_load[]" value="{{ old('connected_load')[$key] }}" class="form-control form-control-sm text-center connected_load" required readonly> </td>
                                                <td> <i class="btn btn-danger btn-sm fa fa-minus remove-calculation-row"></i> </td>
                                                </tr>
                                                @endforeach
                                        @endif

                                        @if(isset($load_calculation))
                                            @foreach ($load_calculation->boq_eme_load_calculations_details as $key => $boq_eme_load_calculations_detail )
                                                <tr>
                                                    <td>
                                                        <input type="hidden" name="floor_id[]" value="{{ $boq_eme_load_calculations_detail->floor_id }}" class="floor_id" >
                                                        <input type="text" name="floor_name[]" value="{{ $boq_eme_load_calculations_detail->floor->name }}"class="form-control text-center form-control-sm floor_name" autocomplete="off" required placeholder="Floor Name" >
                                                    </td>
                                                    <td>
                                                        <input type="hidden" name="material_id[]" value="{{ $boq_eme_load_calculations_detail->material_id }}" class="material_id" >
                                                        <input type="text" name="material_name[]" value="{{ $boq_eme_load_calculations_detail->material->name }}"class="form-control text-center form-control-sm material_name" autocomplete="off" required placeholder="Material Name" >
                                                    </td>
                                                    <td> <input type="text" name="unit[]" value="{{ $boq_eme_load_calculations_detail->material->unit->name }}" class="form-control form-control-sm text-center unit" readonly tabindex="-1"> </td>
                                                    <td> <input type="number" name="load[]" class="form-control form-control-sm text-center load" value="{{ $boq_eme_load_calculations_detail->load }}" required placeholder="0.00"> </td>
                                                    <td> <input type="number" name="qty[]" value="{{ $boq_eme_load_calculations_detail->qty }}" class="form-control form-control-sm text-center qty" required placeholder="0.00"> </td>
                                                    <td> <input type="text" name="connected_load[]" value="{{ $boq_eme_load_calculations_detail->connected_load }}" class="form-control form-control-sm text-center connected_load" required readonly> </td>
                                                <td> <i class="btn btn-danger btn-sm fa fa-minus remove-calculation-row"></i> </td>
                                                </tr>
                                                @endforeach
                                        @endif


                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="5" class="text-right" ><b>Total Connecting Watage</b> </td>
                                            <td> <input type="text" name="total_connecting_wattage" value="{{ !empty(old('total_connecting_wattage')) ? old('total_connecting_wattage') : (isset($load_calculation) ? $load_calculation->total_connecting_wattage : null)}}" id="grand_total" class="form-control form-control-sm text-center" required readonly> </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="text-right" ><b>Assuming (%)</b></td>
                                            <td> <input type="text" name="demand_percent" value="{{ !empty(old('demand_percent')) ? old('demand_percent') : (isset($load_calculation) ? $load_calculation->demand_percent : 100)}}" id="demand_percent" class="form-control form-control-sm text-center" required> </td>
                                            <td class="text-right" ><b>Total Demand Watage</b></td>
                                            <td><input type="text" name="total_demand_wattage" id="demand_total" class="form-control form-control-sm text-center" required readonly value="{{ !empty(old('total_demand_wattage')) ? old('total_demand_wattage') : (isset($load_calculation) ? $load_calculation->total_demand_wattage : null)}}" > </td>
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

const CSRF_TOKEN = "{{csrf_token()}}";
function appendCalculationRow(material_id,material_name) {
            let row = `
                <tr>
                    <td>
                        <input type="hidden" name="floor_id[]" class="floor_id" >
                        <input type="text" name="floor_name[]" class="form-control text-center form-control-sm floor_name" autocomplete="off" required placeholder="Floor Name" >
                    </td>
                    <td>
                        <input type="hidden" name="material_id[]" class="material_id" >
                        <input type="text" name="material_name[]" class="form-control text-center form-control-sm material_name" autocomplete="off" required placeholder="Material Name" >
                    </td>
                    <td> <input type="text" name="unit[]" class="form-control form-control-sm text-center unit" readonly tabindex="-1"> </td>
                    <td> <input type="number" name="load[]" class="form-control form-control-sm text-center load" required placeholder="0.00"> </td>
                    <td> <input type="number" name="qty[]" class="form-control form-control-sm text-center qty" required placeholder="0.00"> </td>
                    <td> <input type="text" name="connected_load[]" class="form-control form-control-sm text-center connected_load" required readonly> </td>
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
            @if($formType == 'create' && !old('project_id'))
            appendCalculationRow();
            @endif
        })

        function changeFormula(){
            var total = 0;
            if ($(".connected_load").length > 0) {
                $(".connected_load").each(function(i, row) {
                    let total_price = Number($(row).val());
                    total += parseFloat(total_price);
                })
            }
            $("#grand_total").val(total);
        }

        function connected_load(thisVal){
            let load = $(thisVal).closest('tr').find('.load').val() > 0 ? $(thisVal).closest('tr').find('.load').val() : 0;
            let qty = $(thisVal).closest('tr').find('.qty').val() > 0 ? $(thisVal).closest('tr').find('.qty').val() : 0;
            let formula = load * qty / 1000;
            $(thisVal).closest('tr').find('.connected_load').val(formula);
        }

        $(document).on('keyup change', '.load, .qty', function() {
            connected_load(this);
            changeFormula();
            calculate_demand_load();
        });

        function calculate_demand_load(){
            let grand_total = $("#grand_total").val() > 0 ? $("#grand_total").val() : 0;
            let demand_percent = $("#demand_percent").val();
            $("#demand_total").val(grand_total * demand_percent / 100);
        }
        $("#demand_percent").on('change keyup', function(){
            calculate_demand_load();
        });


        $(document).on('keyup', ".material_name", function(){
                $(this).autocomplete({
                     source: function( request, response ) {
                         $.ajax({
                             url:"{{route('boq.project.departments.electrical.load_calculations.materialAutoSuggestWhereDepthMorethanThree',$project->id)}}",
                             type: 'post',
                             datatype: "json",
                             data: {
                                 _token: CSRF_TOKEN,
                                 search: request.term
                             },
                             success: function( data ) {
                                 response( data );
                             }
                         });
                     },
                     select: function (event, ui) {
                         $(this).val(ui.item.label);
                         $(this).closest('tr').find('.material_id').val(ui.item.material_id);
                         $(this).closest('tr').find('.unit').val(ui.item.unit);
                         return false;
                     }
                 });
            });

            $(document).on('keyup', ".floor_name", function(){
                $(this).autocomplete({
                    source: function( request, response ) {
                        $.ajax({
                            url:"{{route('boq.project.departments.electrical.load_calculations.floorAutoSuggest',$project->id)}}",
                            type: 'post',
                            datatype: "json",
                            data: {
                                _token: CSRF_TOKEN,
                                search: request.term
                            },
                            success: function( data ) {
                                response( data );
                            }
                        });
                    },
                    select: function (event, ui) {
                        $(this).val(ui.item.label);
                        $(this).closest('tr').find('.floor_id').val(ui.item.floor_id);
                        return false;
                    }
                });
            });


        $(document).ready(function(){
            $('#common,#typical').click(function() {
                $("#hidden_content").animate({width: 'hide'}, "slow");
            });
        });
        $(document).ready(function(){
            $('#generator').click(function() {
                $("#hidden_content").animate({width: 'show'}, "slow");
            });
        });

        </script>
@endsection

