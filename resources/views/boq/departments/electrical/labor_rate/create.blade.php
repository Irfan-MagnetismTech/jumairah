@extends('boq.departments.electrical.layout.app')

@if ($formType == 'edit')
    @section('title', 'BOQ - Edit Labor Rate')
@else
    @section('title', 'BOQ - Create Labor Rate')
@endif
@section('breadcrumb-title')
@if ($formType == 'edit') Edit @else Create @endif Labor Rate
@endsection

@section('breadcrumb-button')
    @include('components.buttons.breadcrumb-button', ['route' => route('boq.project.departments.electrical.labor_rate.index',['project' => $project]), 'type' => 'index'])
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'col-12')

@section('content')
<style>
#calculation_table.table-bordered td, .table-bordered th{
    border: 1px solid gainsboro!important;
}
#calculation_table.table-styling .table-info, .table-styling.table-info{
    background-color: #f6f9f9!important;
    color: #191818!important;
    border: 3px solid #07995D!important;
}
#calculation_table.table-styling .table-info tfoot, .table-styling.table-info tfoot {
    background-color: #07995D;
    border: 3px solid #07995D;
}


.switch-toggle {
    display: flex;
    height: 100%;
    width: 100%;
    align-items: center;
  }
  .switch-btn, .layer {
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
  }

  .button-check {
    position: relative;
    width: 90px;
    height: 42px;
    overflow: hidden;
    border-radius: 50px;
    -webkit-border-radius: 50px;
    -moz-border-radius: 50px;
    -ms-border-radius: 50px;
    -o-border-radius: 50px;
  }
  .checkbox {
    position: relative;
    width: 100%;
    height: 100%;
    padding: 0;
    margin: 0;
    opacity: 0;
    cursor: pointer;
    z-index: 3;
  }

  .switch-btn {
    z-index: 2;
  }

  .layer {
    width: 100%;
    background-color: #8cf7a0;
    transition: 0.3s ease all;
    z-index: 1;
  }
  #button-check .switch-btn:before, #button-check .switch-btn:after {
    position: absolute;
    top: 5px;
    left: 5px;
    width: 42px;
    height: 32px;
    color: #fff;
    font-size: 9.5px;
    font-weight: bold;
    text-align: center;
    line-height: 1;
    padding: 9px 4px;
    background-color: #1bc88c;
    border-radius: 50%;
    transition: 0.3s cubic-bezier(0.18, 0.89, 0.35, 1.15) all;
    display: flex;
    align-items: center;
    justify-content: center;
    font-family: 'IBM Plex Sans', sans-serif;
  }

  #button-check .switch-btn:before {
    content: 'material rate';
  }

  #button-check .switch-btn:after {
    content: 'work rate';
  }

  #button-check .switch-btn:after {
    right: -50px;
    left: auto;
    background-color: #de579b;
  }

  #button-check .checkbox:checked + .switch-btn:before {
    left: -50px;
  }

  #button-check .checkbox:checked + .switch-btn:after {
    right: 4px;
  }

  #button-check .checkbox:checked ~ .layer {
    background-color: #fdd1d1;
  }

  .custom-form .input-group-addon {
    min-width: 150px !important;
}
</style>
<div class="row">
    <div class="col-md-12">
        @if ($formType == 'edit')
        <form action="{{ route('boq.project.departments.electrical.labor_rate.update',['project' => $project,'labor_rate' => $labor_rate]) }}" method="POST" class="custom-form">
        @method('put')
        @else
        <form action="{{ route('boq.project.departments.electrical.labor_rate.store',['project' => $project]) }}" method="POST" class="custom-form">
        @endif
        @csrf
        <div class="switch-toggle">
            <div class="button-check float-right" id="button-check">
              <input type="checkbox" class="checkbox" id='switch' name='type' value="1" @if(old('type') || (isset($labor_rate) && ($labor_rate->type == 1))) checked @endif>
              <span class="switch-btn"></span>
              <span class="layer"></span>
            </div>
        </div>
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <div class="card">
                    <div class="tableHeading">
                        <h5> <span>&#10070;</span>EME Item<span>&#10070;</span> </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Select work -->
                            <div class="col-md-12 col-xl-12 material_rate" style="{{ (((isset($labor_rate) && ($labor_rate->type == null)) || old('parent_id') || ($formType == 'create' && !old('parent_id')) ) ? '' :"display:none")}}" >
                                <div class="input-group input-group-sm input-group-primary">
                                    <label class="input-group-addon" for="parent_id0">1st layer</label>
                                    {{Form::select('parent_id', $leyer1NestedMaterial, old('parent_id') ? old('parent_id') : (!empty($labor_rate) ? $labor_rate->NestedMaterialSecondLayer->parent_id : null),['class' => 'form-control material','id' => 'parent_id0', 'placeholder'=>"Select 1st layer material Name", 'autocomplete'=>"off"])}}
                                </div>
                            </div>
                            <div class="col-md-12 col-xl-12 material_rate" style="{{ (((isset($labor_rate) && ($labor_rate->type == null)) || old('second_layer_parent_id') || ($formType == 'create' && !old('second_layer_parent_id')) ) ? '' :"display:none")}}" >
                                <div class="input-group input-group-sm input-group-primary">
                                    <label class="input-group-addon" for="parent_id_second">2nd layer</label>
                                    {{Form::select('second_layer_parent_id', !empty($labor_rate->second_layer_parent_id) ? $leyer2NestedMaterial : [],old('second_layer_parent_id') ? old('second_layer_parent_id') : (!empty($labor_rate) ? $labor_rate->second_layer_parent_id : null),['class' => 'form-control material','id' => 'parent_id_second', 'placeholder'=>"Select 2nd layer material Name", 'autocomplete'=>"off"])}}
                                </div>
                            </div>
                            <div class="col-xl-12 col-md-12 work_rate" id="works-table" style="{{ (((isset($labor_rate) && ($labor_rate->type == 1)) || old('parentwork_id'[0])) ? '' : "display:none" )}}" >
                                <div class="input-group input-group-sm input-group-primary" id="work-0">
                                    <label class="input-group-addon" for="work_id">Select Work<span class="text-danger">*</span></label>
                                    <select class="form-control workparent_id" id="work_id" name="parentwork_id[]">
                                        <option value="">Select Work</option>
                                        @foreach ($boq_works as $boq_floor_type)
                                        <option value="{{ $boq_floor_type->id }}" @if (isset($parent_data) && ($parent_data->take(1)->keys()->first() == $boq_floor_type->id)) selected @endif>{{ $boq_floor_type->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @if ($formType == 'edit')
                                    @php
                                        $work_data = [];
                                    @endphp
                                    @foreach($parent_data as $key => $value)
                                    @if(!($loop->first))
                                        <div class="input-group input-group-sm input-group-primary" id="work-{{ $loop->index }}">
                                            <label class="input-group-addon" for="work_id">Select Work<span class="text-danger">*</span></label>
                                            <select class="form-control workparent_id" name="parentwork_id[]">
                                                <option value="">Select Work</option>
                                                @foreach($work_data as $key1 => $value1)
                                                <option value="{{ $key1 }}" @if($key == $key1) selected @endif>{{ $value1 }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endif
                                    @if (!($loop->last))
                                        @php
                                            $work_data = \App\Boq\Configurations\BoqWork::where('parent_id',$key)->hasChildren()->pluck('name', 'id');
                                        @endphp
                                    @endif
                                    @endforeach
                                @endif
                            </div>
                            <div class="col-xl-12 col-md-12">
                                <div class="input-group input-group-sm input-group-primary">
                                    <label class="input-group-addon" for="feedback">Description of work <span class="text-danger pl-1">*</span></label>
                                    {{Form::textarea('description', old('description') ? old('description') : (!empty($labor_rate->description) ? $labor_rate->description : null),['class' => 'form-control','id' => 'description', 'rows' => '2', 'autocomplete'=>"off"])}}
                                </div>
                            </div>
                            <div class="col-xl-12 col-md-12">
                                <div class="input-group input-group-sm input-group-primary">
                                    <label class="input-group-addon" for="feedback">Basis of measurement <span class="text-danger pl-1">*</span></label>
                                    {{Form::textarea('basis_of_measurement', old('basis_of_measurement') ? old('basis_of_measurement') : (!empty($labor_rate->basis_of_measurement) ? $labor_rate->basis_of_measurement : null),['class' => 'form-control','id' => 'basis_of_measurement', 'rows' => '2', 'autocomplete'=>"off"])}}
                                </div>
                            </div>
                            <div class="col-xl-12 col-md-12">
                                <div class="input-group input-group-sm input-group-primary">
                                    <label class="input-group-addon" for="feedback">Note <span class="text-danger pl-1">*</span></label>
                                    {{Form::textarea('note', old('note') ? old('note') : (!empty($labor_rate->note) ? $labor_rate->note : null),['class' => 'form-control','id' => 'note', 'rows' => '2', 'autocomplete'=>"off"])}}
                                </div>
                            </div>
                            <!-- Select sub-work -->
                            <div class="col-xl-12 col-md-12">
                                <div id="subwork"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-1">
            </div>
        </div>

        <hr>
        <!-- Calculation -->
        <div class="material_rate" style="{{ (((isset($labor_rate) && ($labor_rate->type == null)) || old('parent_id_second') || ($formType == 'create' && !old('parent_id_second')) ) ? '' :"display:none")}}" >
            <div class="mt-1 row">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                    <div class="card">
                        <div class="tableHeading">
                            <h5> <span>&#10070;</span>Item Rate<span>&#10070;</span><span class="work_unit"></span> </h5>
                        </div>
                        <div class="card-body">
                            <!-- Calculations -->
                            <div class="mt-1 row">
                                <div class="col-md-12">
                                    <table class="table table-striped table-bordered table-styling table-info table-sm text-center" id="calculation_table">
                                        <thead>
                                            <tr class="electrical_calc_head">
                                                <th> Material Name <span class="text-danger">*</span></th>
                                                <th class="material_rate_th"> Unit <span class="text-danger">*</span></th>
                                                <th class="material_rate_th"> Rate <span class="text-danger">*</span></th>
                                                <th class="material_rate_th"> Quantity <span class="text-danger">*</span></th>
                                                <th class="labour_rate_th">Amount</th>
                                                <th><i class="btn btn-primary btn-sm fa fa-plus add-calculation-row"></i></th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @if ($formType == 'edit')
                                                @foreach($labor_rate->labor_rate_details as $key => $value)
                                                    <tr>

                                                        <td>
                                                            <input type="hidden" name="material_id[]" value="{{ $value->material_id }}" class="material_id" id="material_id">
                                                            <input type="text" name="material_name[]" value="{{ $value->NestedMaterial->name }}" class="form-control text-center form-control-sm material_name" autocomplete="off" placeholder="Material Name" tabindex="-1">
                                                        </td>
                                                        <td> <input type="number" name="unit[]" value="{{ $value->NestedMaterial->unit->name }}" class="form-control unit" readonly placeholder="Material Rate"> </td>
                                                        <td> <input type="number" name="labor_rate[]" value="{{ $value->labor_rate }}" class="form-control labor_rate" readonly placeholder="Material Rate"> </td>
                                                        <td> <input type="number" name="qty[]" value="{{ $value->qty }}" class="form-control qty"> </td>
                                                        <td> <input type="number" name="amount[]" value="{{ $value->qty * $value->labor_rate }}" class="form-control amount"> </td>
                                                        <td> <i class="btn btn-danger btn-sm fa fa-minus remove-calculation-row"></i> </td>

                                                    </tr>
                                                @endforeach

                                            @endif
                                        </tbody>
                                        <tfoot>
                                            <tr class="electrical_calc_head">
                                                <th> Material Name <span class="text-danger">*</span></th>
                                                <th class="material_rate_th"> Unit <span class="text-danger">*</span></th>
                                                <th class="material_rate_th"> Rate <span class="text-danger">*</span></th>
                                                <th class="material_rate_th"> Quantity <span class="text-danger">*</span></th>
                                                <th class="labour_rate_th">Amount</th>
                                                <th><i class="btn btn-primary btn-sm fa fa-plus add-calculation-row"></i></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-1"></div>
            </div>
        </div>

        <div class="work_rate" style="{{ (((isset($labor_rate) && ($labor_rate->type == 1)) || old('work_id')) ? '' : "display:none" )}}" >
            <div class="mt-1 row">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                    <div class="card">
                        <div class="tableHeading">
                            <h5> <span>&#10070;</span>Item Rate<span>&#10070;</span><span class="work_unit"></span> </h5>
                        </div>
                        <div class="card-body">
                            <!-- Calculations -->
                            <div class="mt-1 row">
                                <div class="col-md-12">
                                    <table class="table table-striped table-bordered table-styling table-info table-sm text-center" id="workcalculation_table">
                                        <thead>
                                            <tr class="electrical_calc_head">
                                                <th>Work Name <span class="text-danger">*</span></th>
                                                <th class="material_rate_th"> Rate <span class="text-danger">*</span></th>
                                                <th class="material_rate_th"> Quantity <span class="text-danger">*</span></th>
                                                <th class="labour_rate_th">Amount</th>
                                                <th><i class="btn btn-primary btn-sm fa fa-plus add-workcalculation-row"></i></th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @if ($formType == 'edit')
                                                @foreach($labor_rate->labor_rate_details as $key => $value)
                                                <tr>

                                                        <td>
                                                            <input type="hidden" name="work_id[]" value="{{ $value->boq_work_id }}" class="work_id">
                                                            <input type="text" name="work_name[]" value="{{ $value->boqWork->name }}" class="form-control text-center form-control-sm work_name" autocomplete="off" placeholder="Work Name" tabindex="-1">
                                                        </td>
                                                        <td> <input type="number" name="work_labor_rate[]" value="{{ $value->labor_rate }}" class="form-control labor_rate" readonly placeholder="Material Rate"> </td>
                                                        <td> <input type="number" name="work_qty[]" value="{{ $value->qty }}" class="form-control qty"> </td>
                                                        <td> <input type="number" name="work_amount[]" value="{{ $value->qty * $value->labor_rate }}"class="form-control amount"> </td>
                                                        <td> <i class="btn btn-danger btn-sm fa fa-minus remove-workcalculation-row"></i> </td>

                                                </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                        <tfoot>
                                            <tr class="electrical_calc_head">
                                                <th>Work Name <span class="text-danger">*</span></th>
                                                <th class="material_rate_th"> Rate <span class="text-danger">*</span></th>
                                                <th class="material_rate_th"> Quantity <span class="text-danger">*</span></th>
                                                <th class="labour_rate_th">Amount</th>
                                                <th><i class="btn btn-primary btn-sm fa fa-plus add-workcalculation-row"></i></th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-1"></div>
            </div>
        </div>

        <div class="row">
            <div class="mt-2 offset-md-4 col-md-4">
                <div class="input-group input-group-sm input-group-button">
                    <button type="submit" class="py-2 btn btn-success btn-round btn-block" id="submit-button">{{ isset($BoqEmeDatas) ? 'Update' : 'Create' }}</button>
                </div>
            </div>
        </div>
        </form>
    </div>
</div>
@endsection
@section('script')
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script>
    const BOQ_SUB_WORK_BY_WORK_ID_URL = "{{ route('boq.project.departments.electrical.configurations.rates.get_boq_sub_work_by_work_id', $project->id) }}";
    const BOQ_WORK_BY_WORK_ID_URL = "{{ route('boq.project.departments.electrical.configurations.rates.get_boq_work_by_work_id', $project->id) }}";
    let lastWorkId = -1;
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
        }) // Document.Ready

        function appendCalculationRow(material_id,material_name) {
            let row = `
                <tr>
                    <td>
                        <input type="hidden" name="material_id[]" class="material_id">
                        <input type="text" name="material_name[]" class="form-control text-center form-control-sm material_name" autocomplete="off" placeholder="Material Name" tabindex="-1">
                    </td>
                    <td> <input type="text" name="unit[]" class="form-control unit" readonly> </td>
                    <td> <input type="number" name="labor_rate[]" class="form-control labor_rate" readonly> </td>
                    <td> <input type="number" name="qty[]" class="form-control qty"> </td>
                    <td> <input type="number" name="amount[]" class="form-control amount"> </td>
                    <td> <i class="btn btn-danger btn-sm fa fa-minus remove-calculation-row"></i> </td>
                </tr>
                `;
            $('#calculation_table tbody').append(row);
        }

        function appendworkCalculationRow() {
            let row = `
                <tr>
                    <td>
                        <input type="hidden" name="work_id[]" class="work_id">
                        <input type="text" name="work_name[]" class="form-control text-center form-control-sm work_name" autocomplete="off" placeholder="Work Name" tabindex="-1">
                    </td>
                    <td> <input type="number" name="work_labor_rate[]" class="form-control labor_rate" readonly> </td>
                    <td> <input type="number" name="work_qty[]" class="form-control qty"> </td>
                    <td> <input type="number" name="work_amount[]" class="form-control amount"> </td>
                    <td> <i class="btn btn-danger btn-sm fa fa-minus remove-workcalculation-row"></i> </td>
                </tr>
                `;
            $('#workcalculation_table tbody').append(row);
        }

        // function for searching third layer material
                $(document).on('keyup','.material_name',function(events){
                    let secondLayerMaterial = $("#parent_id_second").val();
                    $(this).autocomplete({
                        source: function(request, response) {
                            $.ajax({
                                url:"{{route('boq.project.departments.electrical.labor_rate.materialSuggestWithLaborRate',$project->id)}}",
                                type: 'post',
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
                            $(this).closest('tr').find('.material_name').val(ui.item.label);
                            $(this).closest('tr').find('.material_id').val(ui.item.value);
                            $(this).closest('tr').find('.labor_rate').val(ui.item.rate);
                            $(this).closest('tr').find('.unit').val(ui.item.unit);
                            return false;
                        }
                    });
                });

                $(document).on('keyup','.work_name',function(events){
                    let parent_id = $('.workparent_id:last').val();
                    $(this).autocomplete({
                        source: function(request, response) {
                            $.ajax({
                                url:"{{route('boq.project.departments.electrical.labor_rate.workSuggestWithLaborRate',$project->id)}}",
                                type: 'post',
                                dataType: "json",
                                data: {
                                    _token: CSRF_TOKEN,
                                    search: request.term,
                                    parent_id
                                },
                                success: function( data ) {
                                    response( data );
                                }
                            });
                        },
                        select: function(event, ui) {
                            console.log(ui.item);
                            $(this).closest('tr').find('.work_name').val(ui.item.label);
                            $(this).closest('tr').find('.work_id').val(ui.item.value);
                            $(this).closest('tr').find('.labor_rate').val(ui.item.rate);
                            return false;
                        }
                    });
                });
                $(document).on('keyup','.labor_rate,.qty',function(events){
                    let material_rate = $(this).closest('tr').find('.labor_rate').val() ? $(this).closest('tr').find('.labor_rate').val() : 0;
                    let qty = $(this).closest('tr').find('.qty').val() ? $(this).closest('tr').find('.qty').val() : 0;
                    let amount = material_rate * qty;
                    $(this).closest('tr').find('.amount').val(amount);
                });




        /* Adds and removes calculation row on click */
        $("#calculation_table")
            .on('click', '.add-calculation-row', () => appendCalculationRow())
            .on('click', '.remove-calculation-row', function() {
                $(this).closest('tr').remove();
            });
            $("#workcalculation_table")
            .on('click', '.add-workcalculation-row', () => appendworkCalculationRow())
            .on('click', '.remove-workcalculation-row', function() {
                $(this).closest('tr').remove();
            });
        /* The document function */
        @if ($formType == "create")
        $(function() {
            appendCalculationRow();
            appendworkCalculationRow();
        });
        @endif
        $('#switch').on('change', function() {
            if($('#switch').is(':checked')){
                $('.material_rate').hide("fade");
                $('.work_rate').show("fade");
            }else{
                $('.work_rate').hide("fade");
                $('.material_rate').show("fade");
            }
        });

        async function getSubWorkByWork(workId, trId) {
            try {
                let formData = {
                    _token: "{{ csrf_token() }}",
                    work_id: workId,
                };
                const response = await axios.post(BOQ_SUB_WORK_BY_WORK_ID_URL, formData);
                const data = await response.data;
                console.log(data);
                appendSubWork(workId, trId, data);

                if (isObjectEmpty(data)) {
                    lastWorkId = workId;
                } else {
                    lastWorkId = -1;
                }
            } catch (error) {
                console.log("Get Sub work", error);
                alert("Something went wrong. Please try again later.");
            } finally {}
        }


        $('#works-table').on('change', '.workparent_id', function() {
            let workId = $(this).val();
            let trId = parseInt($(this).closest('div').attr('id').split('-')[1]);
            getSubWorkByWork(workId, trId);
        });

        function appendSubWork(workId, trId, subWorks) {
            var rowCount = $('#works-table div').length;

            for (let i = trId + 1; i <= rowCount; i++) {
                $('#work-' + i).remove();
            }

            let options = "";

            for (let i = 0; i < subWorks.length; i++) {
                console.log(subWorks[i]);
                options += `<option value="${subWorks[i].id}">${subWorks[i].name}</option>`;
            }

            let row = `<div class="input-group input-group-sm input-group-primary" id="work-${trId + 1}">
                        <label class="input-group-addon" for="work_id">Select Work<span class="text-danger">*</span></label>
                        <select class="form-control workparent_id" name="parentwork_id[]">
                            <option value="">Select Work</option>
                            ${options}
                        </select>
                    </div> `;

            if (!isObjectEmpty(subWorks)) {
                $('#works-table').append(row);
            }
        }
        function isObjectEmpty(obj) {
            return Object.keys(obj).length === 0;
        }
    </script>
@endsection
