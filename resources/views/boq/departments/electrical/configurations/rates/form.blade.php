
@csrf
<div class="switch-toggle">
    <div class="button-check float-right" id="button-check">
      <input type="checkbox" class="checkbox" id='switch' name='type' value="1" @if(old('type') || (isset($BoqEmeDatas) && ($BoqEmeDatas->type == 1))) checked @endif>
      <span class="switch-btn"></span>
      <span class="layer"></span>
    </div>
</div>
<div class="material_rate" style="{{ (((isset($BoqEmeDatas) && ($BoqEmeDatas->type == null)) || old('parent_id_second') || ($formType == 'create' && !old('parent_id_second')) ) ? '' :"display:none")}}" >
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
                        <div class="col-md-12 col-xl-12">
                            <div class="input-group input-group-sm input-group-primary">
                                {{-- <label class="input-group-addon" for="parent_id0">1st layer</label>
                                {{Form::select('parent_id[]', $leyer1NestedMaterial, old('parent_id[0]') ? old('parent_id[0]') : (!empty($BoqEmeDatas) ? $BoqEmeDatas->NestedMaterialSecondLayer->parent_id : null),['class' => 'form-control material','id' => 'parent_id0', 'placeholder'=>"Select 1st layer material Name", 'autocomplete'=>"off"])}} --}}
                                <input type="text" class="form-control material" name="parent_id0" readonly value="{{ $emeMaterial->name }}">
                            </div>
                        </div>
                        <div class="col-md-12 col-xl-12">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="parent_id_second">2nd layer</label>
                                {{-- {{Form::select('parent_id_second', !empty($BoqEmeDatas->parent_id_second) ? $leyer2NestedMaterial : [],old('parent_id_second') ? old('parent_id_second') : (!empty($BoqEmeDatas) ? $BoqEmeDatas->parent_id_second : null),['class' => 'form-control material','id' => 'parent_id_second', 'placeholder'=>"Select 2nd layer material Name", 'autocomplete'=>"off"])}} --}}

                                {{Form::select('parent_id_second', $secondMaterial,old('parent_id_second') ? old('parent_id_second') : (!empty($BoqEmeDatas) ? $BoqEmeDatas->parent_id_second : null),['class' => 'form-control material','id' => 'parent_id_second'])}}
                            </div>
                        </div>

                        <input type="hidden" name="final_total" id="final_total">

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
    <div class="row mt-1">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <div class="card">
                <div class="tableHeading">
                    <h5> <span>&#10070;</span>Material Item Rate<span>&#10070;</span><span class="work_unit"></span> </h5>
                </div>
                <div class="card-body">
                    <!-- Calculations -->
                    <div class="mt-1 row">
                        <div class="col-md-12">
                            <table class="table table-bordered" id="calculation_table">
                                <thead>
                                    <tr class="electrical_calc_head">
                                        <th>Material Item <span class="text-danger">*</span></th>
                                        <th>Unit</th>
                                        <th class="labour_rate_th"> Material Rate</th>
                                        @if ($formType == 'create')
                                            <th><i class="btn btn-primary btn-sm fa fa-plus add-calculation-row"></i></th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>

                                    @if ($formType == 'edit' && !($BoqEmeDatas->type))
                                            <tr>
                                                <tr>
                                                    <td>
                                                        <input type="hidden" name="material_id[]" value="{{ $BoqEmeDatas->material_id }}" class="material_id" id="material_id">
                                                        <input type="text" name="material_name[]" value="{{ $BoqEmeDatas->NestedMaterial->name }}" class="form-control text-center form-control-sm material_name" autocomplete="off" placeholder="Material Name" tabindex="-1">
                                                    </td>
                                                    <td>
                                                        <input type="text" name="unit[]" value="{{ $BoqEmeDatas->NestedMaterial->unit->name }}" class="form-control text-center form-control-sm unit" autocomplete="off" placeholder="Unit" tabindex="-1" readonly>
                                                    </td>
                                                    <td> <input type="number" name="labour_rate[]" class="form-control text-center labour_rate" value="{{ $BoqEmeDatas->labour_rate }}" placeholder="Labour Rate"> </td>
                                                    @if ($formType == 'create')
                                                    <td> <i class="btn btn-danger btn-sm fa fa-minus remove-calculation-row"></i> </td>
                                                    @endif
                                                </tr>
                                            </tr>
                                    @endif
                                </tbody>
                                <tfoot>
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
 <!-- Work -->
<div class="work_rate" style="{{ (((isset($BoqEmeDatas) && ($BoqEmeDatas->type == 1)) || old('work_id')) ? '' : "display:none" )}}" >
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <div class="card">
                <div class="tableHeading">
                    <h5> <span>&#10070;</span>EME Item<span>&#10070;</span> </h5>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-12 col-md-12" id="works-table">
                            <div class="input-group input-group-sm input-group-primary" id="work-0">
                                <label class="input-group-addon" for="work_id">Select Work<span class="text-danger">*</span></label>
                                <select class="form-control workparent_id" id="work_id" name="parentwork_id" required>
                                    <option value="">Select Work</option>
                                    @foreach ($boq_works as $boq_floor_type)
                                    <option value="{{ $boq_floor_type->id }}" @if (isset($BoqEmeDatas) && ($BoqEmeDatas->emeWork->id == $boq_floor_type->id)) selected @endif>{{ $boq_floor_type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- @if ($formType == 'edit')
                                @php
                                    $work_data = [];
                                @endphp
                                @foreach($parent_data as $key => $value)
                                @if(!($loop->first))
                                    <div class="input-group input-group-sm input-group-primary" id="work-{{ $loop->index }}">
                                        <label class="input-group-addon" for="work_id">Select Work<span class="text-danger">*</span></label>
                                        <select class="form-control workparent_id" name="parentwork_id">
                                            <option value="">Select Work</option>
                                            @foreach($work_data as $key1 => $value1)
                                            <option value="{{ $key1 }}" @if($key == $key1) selected @endif>{{ $value1 }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif
                                @if (!($loop->last))
                                    @php
                                        $work_data = \App\Boq\Configurations\BoqWork::where('parent_id',$key)->pluck('name', 'id');
                                    @endphp
                                @endif
                                @endforeach
                            @endif --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-1">
        </div>
    </div>

    <hr>
    <div class="mt-1 row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <div class="card">
                <div class="tableHeading">
                    <h5> <span>&#10070;</span>Work Item Rate<span>&#10070;</span><span class="work_unit"></span> </h5>
                </div>
                <div class="card-body">
                    <!-- Calculations -->
                    <div class="mt-1 row">
                        <div class="col-md-12">
                            <table class="table table-bordered" id="work_calculation_table">
                                <thead>
                                    <tr class="electrical_calc_head">
                                        <th>Work Item <span class="text-danger">*</span></th>
                                        <th class="labour_rate_th"> Labour Rate <span class="text-danger">*</span></th>
                                        @if ($formType == 'create')
                                            <th><i class="btn btn-primary btn-sm fa fa-plus add-work-calculation-row"></i></th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>

                                    @if ($formType == 'edit' && ($BoqEmeDatas->type))
                                            <tr>
                                                <tr>
                                                    {{-- <td>
                                                        <input type="hidden" name="work_id[]" value="{{ $BoqEmeDatas->boq_work_id }}" class="work_id">
                                                        <input type="text" name="work_name[]" value="{{ $BoqEmeDatas->boqWork->name }}" class="form-control text-center form-control-sm work_name" autocomplete="off" placeholder="Work Name" tabindex="-1">
                                                    </td> --}}
                                                    <td>
                                                        <input list="options" name="work_id[]"  class="form-control text-center form-control-sm" value="{{ $BoqEmeDatas->boq_work_name }}" required>
                                                        <datalist id="options">
                                                            @foreach ($options as $option)
                                                                <option value="{{ $option }}">
                                                            @endforeach
                                                        </datalist>
                                                    </td>
                                                    <td> <input type="number" name="work_labour_rate[]" class="form-control text-center labour_rate" value="{{ $BoqEmeDatas->labour_rate }}" placeholder="Labour Rate" required> </td>
                                                    @if ($formType == 'create')
                                                    <td> <i class="btn btn-danger btn-sm fa fa-minus remove-work-calculation-row"></i> </td>
                                                    @endif
                                                </tr>
                                            </tr>
                                    @endif
                                </tbody>
                                <tfoot>
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


@section('script')
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
        // const BOQ_SUB_WORK_BY_WORK_ID_URL = "{{ route('boq.project.departments.electrical.configurations.rates.get_boq_sub_work_by_work_id', $project->id) }}";
        // const BOQ_WORK_BY_WORK_ID_URL = "{{ route('boq.project.departments.electrical.configurations.rates.get_boq_work_by_work_id', $project->id) }}";
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
                        <input type="hidden" name="material_id[]" class="material_id" id="material_id">
                        <input type="text" name="material_name[]" class="form-control text-center form-control-sm material_name" autocomplete="off" placeholder="Material Name" tabindex="-1">
                    </td>
                    <td>
                        <input type="text" name="unit[]" class="form-control text-center form-control-sm unit" autocomplete="off" placeholder="Unit" tabindex="-1" readonly>
                    </td>
                    <td> <input type="number" name="labour_rate[]" class="form-control text-center labour_rate" placeholder="Material Rate"> </td>
                    <td> <i class="btn btn-danger btn-sm fa fa-minus remove-calculation-row"></i> </td>
                </tr>
                `;
            $('#calculation_table tbody').append(row);
        }

        function appendWorkCalculationRow() {
            let row = `
                <tr>
                    <td>
                        <input list="options" name="work_id[]"  class="form-control text-center form-control-sm" placeholder="Work Name" required>
                        <datalist id="options">
                            @foreach ($options as $option)
                                <option value="{{ $option }}">
                            @endforeach
                        </datalist>
                    </td>
                    <td> <input type="number" name="work_labour_rate[]" class="form-control text-center labour_rate" placeholder="Labour Rate" required> </td>
                    <td> <i class="btn btn-danger btn-sm fa fa-minus remove-work-calculation-row"></i> </td>
                </tr>
                `;
            $('#work_calculation_table tbody').append(row);
        }

        // function for searching third layer material
                $(document).on('keyup','.material_name',function(events){
                    let secondLayerMaterial = $("#parent_id_second option:selected").val();
                    $(this).autocomplete({
                        source: function(request, response) {
                            $.ajax({
                                url: "{{route('boq.project.departments.electrical.configurations.rates.getDecendentsBasedOnParent',$project->id)}}",
                                type: 'post',
                                dataType: "json",
                                data: {
                                    _token: CSRF_TOKEN,
                                    search: request.term,
                                    parent_material_id: secondLayerMaterial
                                },
                                success: function( data ) {
                                    console.log(data);
                                    response( data );
                                }
                            });
                        },
                        select: function(event, ui) {
                            $(this).closest('tr').find('.material_name').val(ui.item.label);
                            $(this).closest('tr').find('.material_id').val(ui.item.material_id);
                            $(this).closest('tr').find('.unit').val(ui.item.unit_name);
                            return false;
                        }
                    });
                });

                // $(document).on('keyup','.work_name',function(events){
                //     let parent_id = $('.workparent_id:last').val();
                //     $(this).autocomplete({
                //         source: function(request, response) {
                //             $.ajax({
                //                 url: "{{route('boq.project.departments.electrical.configurations.rates.boqWorkAutoSuggest',$project->id)}}",
                //                 type: 'post',
                //                 dataType: "json",
                //                 data: {
                //                     _token: CSRF_TOKEN,
                //                     search: request.term,
                //                     // parent_id
                //                 },
                //                 success: function( data ) {
                //                     response( data );
                //                 }
                //             });
                //         },
                //         select: function(event, ui) {
                //             $(this).closest('tr').find('.work_name').val(ui.item.label);
                //             $(this).closest('tr').find('.work_id').val(ui.item.value);
                //             return false;
                //         }
                //     });
                // });



        /* Adds and removes calculation row on click */
        $("#calculation_table")
            .on('click', '.add-calculation-row', () => appendCalculationRow())
            .on('click', '.remove-calculation-row', function() {
                $(this).closest('tr').remove();
            });
        $("#work_calculation_table")
            .on('click', '.add-work-calculation-row', () => appendWorkCalculationRow())
            .on('click', '.remove-work-calculation-row', function() {
                $(this).closest('tr').remove();
            });

        /* The document function */
        @if ($formType == "create")
        $(function() {
            appendCalculationRow();
            appendWorkCalculationRow();
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

        // async function getSubWorkByWork(workId, trId) {
        //     try {
        //         let formData = {
        //             _token: "{{ csrf_token() }}",
        //             work_id: workId,
        //         };
        //         console.log(formData);
        //         const response = await axios.post(BOQ_SUB_WORK_BY_WORK_ID_URL, formData);
        //         const data = await response.data;
        //         appendSubWork(workId, trId, data);

        //         if (isObjectEmpty(data)) {
        //             lastWorkId = workId;
        //         } else {
        //             lastWorkId = -1;
        //         }
        //     } catch (error) {
        //         console.log("Get Sub work", error);
        //         alert("Something went wrong. Please try again later.");
        //     } finally {}
        // }


        // $('#works-table').on('change', '.workparent_id', function() {
        //     let workId = $(this).val();
        //     let trId = parseInt($(this).closest('div').attr('id').split('-')[1]);
        //     console.log(workId,trId);
        //     getSubWorkByWork(workId, trId);
        // });

        // function appendSubWork(workId, trId, subWorks) {
        //     var rowCount = $('#works-table div').length;

        //     for (let i = trId + 1; i <= rowCount; i++) {
        //         $('#work-' + i).remove();
        //     }

        //     let options = "";

        //     for (let i = 0; i < subWorks.length; i++) {
        //         options += `<option value="${subWorks[i].id}">${subWorks[i].name}</option>`;
        //     }

        //     let row = `<div class="input-group input-group-sm input-group-primary" id="work-${trId + 1}">
        //                 <label class="input-group-addon" for="work_id">Select Work<span class="text-danger">*</span></label>
        //                 <select class="form-control workparent_id" name="parentwork_id[]">
        //                     <option value="">Select Work</option>
        //                     ${options}
        //                 </select>
        //             </div> `;

        //     if (!isObjectEmpty(subWorks)) {
        //         $('#works-table').append(row);
        //     }
        // }
        // function isObjectEmpty(obj) {
        //     return Object.keys(obj).length === 0;
        // }
    </script>
@endsection
