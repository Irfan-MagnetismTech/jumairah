@extends('layouts.backend-layout')
@section('title', 'Material Budget')

@section('breadcrumb-title')
    @if($formType == 'edit') Edit @else Add @endif
    BOQ (Civil) Budget
@endsection

 @section('breadcrumb-button')
    @if($formType == 'edit');
        <a href="{{ url("supreme-budget-list/$budgetFor") }}" data-toggle="tooltip" title="Projects" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
    @endif
@endsection 

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', null)

@section('content')
<style>
.tableFixHead { overflow-y: auto; height: 80vh; }

/* Just common table stuff. */
table  { border-collapse: collapse; width: 100%; }
th, td { padding: 8px 16px; }
</style>
 
  
    @if($formType == 'edit')
        {!! Form::open(array('url' => "supreme-budget-update/$budgetFor/$project_id",'method' => 'PUT','encType' =>"multipart/form-data", 'class'=>'custom-form')) !!}
    @else
        {!! Form::open(array('url' => "boqSupremeBudgets",'method' => 'POST','encType' =>"multipart/form-data", 'class'=>'custom-form')) !!}
    @endif
        <div class="row">
            <div class="col-md-6 col-xl-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="project_id">Project Name<span class="text-danger">*</span></label>
                    {{Form::select('project_id', $projects, old('project_id') ? old('project_id') : (!empty($boq_supreme_budget_data[0]->project_id) ? $boq_supreme_budget_data[0]->project_id : null),['class' => 'form-control','id' => 'project_id', 'placeholder'=>"Select Project Name", 'autocomplete'=>"off",'required'])}}
                </div>
            </div>
            <div class="col-md-2 col-xl-2"></div>
            @if($formType == 'create') 
                <div class="col-md-4 col-xl-4">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="budget_for"> Budget For <span class="text-danger">*</span></label>
                        {{ Form::select('budget_for', ['Civil' => 'Civil','Senitary' => 'Senitary', 'EME' => 'EME'], old('budget_for', $boq_supreme_budget_data[0]->budget_for ?? null), ['class' => 'form-control', 'id' => 'budget_for', 'autocomplete' => 'off', 'placeholder' => 'Select One', 'required']) }}
                    </div>
                </div>
            @endif
            <div class="col-12">
                <div class="col-md-4 col-xl-4 float-left pl-0">
                    <div class="input-group input-group-sm input-group-primary">
                        <input type="text" id="material_name" class="form-control form-control-sm" value="" placeholder="Search Material Name" autocomplete="off">
                    </div>
                 </div>
            </div>
            {{-- <div class="col-md-2 col-xl-2"></div>
            <div class="col-md-4 col-xl-4">
                <div class="input-group input-group-sm input-group-primary">
                    <input type="text" id="check_material_name" name="check_material_name" class="form-control form-control-sm check_material_name" value="" placeholder="Search Material Name" autocomplete="off">
                </div>
            </div> --}}
        </div><!-- end row -->
    <hr class="bg-success">
                <div class="tableHeading">
                    <h5> <span>&#10070;</span> Material Details <span>&#10070;</span> </h5>
                </div>
                <div class="tableFixHead">
                    <table id="materialTable" class="table text-center">
                        <thead>
                            <tr>
                                <th rowspan="2" width="240px">#Sl</th>
                                <th rowspan="2" width="240px"> Floor Name</th>
                                <th colspan="3"> Material Name<span class="text-danger">*</span></th>
                                <th rowspan="2" width="100px"> Unit</th>
                                <th rowspan="2" width="200px"> Quantity<span class="text-danger">*</span></th>
                                <th rowspan="2"> Remarks</th>
                                <th width="150px" rowspan="2"><i class="btn btn-primary btn-sm fa fa-plus addMaterial"></i></th>
                            </tr>
                            <tr>
                                <th width="750px" style="width: 750px!important;">1st Layer</th>
                                <th width="750px" style="width: 750px!important;">2nd Layer</th>
                                <th width="750px" style="width: 750px!important;">3rd Layer<span class="text-danger">*</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(old('material_id'))
                                @foreach(old('material_id') as $key=>$oldMaterialName)
                                    <tr>
                                        <td class="sl">
                                            {{ $key+1 }}
                                        </td>
                                        <td>
                                            <input type="hidden" name="floor_id[]" value="{{old('floor_id')[$key]}}" class="floor_id">
                                            <input type="text" name="floor_name[]" value="{{old('floor_name')[$key]}}" class="form-control form-control-sm floor_name" autocomplete="off">
                                        </td>
                                        <td>
                                            {{Form::select('layer1_material_id[]', $material_layer1, null,['class' => 'form-control 1st_layer_material','id' => 'parent_id0', 'placeholder'=>"Select 1st layer material Name", 'autocomplete'=>"off"])}}
                                         </td> 
                                        <td>
                                            {{Form::select('layer2_material_id[]', [] , null,['class' => 'form-control 2nd_layer_material','id' => 'parent_id1', 'placeholder'=>"Select 2nd layer material Name", 'autocomplete'=>"off"])}}
                                        </td> 
                                        <td>
                                            <input type="hidden" name="material_id[]" value="{{old('material_id')[$key]}}" class="material_id" required>
                                            <input type="text" name="material_name[]" value="{{old('material_name')[$key]}}" class="form-control form-control-sm material_name" autocomplete="off" required>
                                        </td>
                                        <td><input type="text" name="unit[]" value="{{old('unit')[$key]}}" class="form-control form-control-sm unit" readonly tabindex="-1"></td>
                                       <td><input type="number" name="quantity[]" value="{{old('quantity')[$key]}}" class="form-control form-control-sm  text-center quantity" step="0.01" placeholder="0.00" autocomplete="off" required></td>
                                        <td><input type="text" name="remarks[]" value="{{old('remarks')[$key]}}" class="form-control form-control-sm  text-center remarks" placeholder="Remarks" autocomplete="off"></td>
                                        <td><i class="btn btn-primary btn-sm fa fa-plus addMaterial"></i><i class="btn btn-danger btn-sm fa fa-minus deleteItem"></i></td>
                                    </tr>
                                @endforeach
                            @else
                                @if(!empty($boq_supreme_budget_data))
                                    @foreach($boq_supreme_budget_data as $key => $value)
                                    {{-- @dump($value); --}}
                                        <tr>
                                            <td class="sl">
                                                {{ $key+1 }}
                                            </td>
                                            <td>
                                                <input type="hidden" name="floor_id[]" value="{{ $value->floor_id }}" class="floor_id">
                                                <input type="text" name="floor_name[]" value="{{ $value->boqFloorProject->floor->name }}" class="form-control form-control-sm floor_name" autocomplete="off">
                                            </td>
                                            <td>
                                                {{Form::select('layer1_material_id[]', $material_layer1, null,['class' => 'form-control 1st_layer_material','id' => 'parent_id0', 'placeholder'=>"", 'autocomplete'=>"off"])}}
                                            </td>
                                            <td>
                                                {{Form::select('layer2_material_id[]', [] , null,['class' => 'form-control 2nd_layer_material','id' => 'parent_id1', 'placeholder'=>"", 'autocomplete'=>"off"])}}
                                             </td>
                                            <td>
                                            @php
                                                $approval = \App\Procurement\NestedMaterial::where('parent_id',$value->nestedMaterial->parent_id)->pluck('name','id');
                                            @endphp
                                                <input type="hidden" name="material_id[]" value="{{ $value->material_id }}" class="material_id" required>
                                                <input type="text" name="material_name[]" value="{{ $value->nestedMaterial->name }}" class="form-control form-control-sm material_name" autocomplete="off" required> 
                                            </td>
                                            <td><input type="text" name="unit[]" value="{{ $value->nestedMaterial->unit->name }}" class="form-control form-control-sm unit" readonly tabindex="-1"></td>
                                            <td><input type="number" name="quantity[]" value="{{ $value->quantity }}" class="form-control form-control-sm  text-center quantity" step="0.01" placeholder="0.00" autocomplete="off" required></td>
                                            <td><input type="text" name="remarks[]" value="{{ $value->remarks }}" class="form-control form-control-sm  text-center remarks" placeholder="Remarks" autocomplete="off"></td>
                                            <td><i class="btn btn-primary btn-sm fa fa-plus addMaterial"></i><i class="btn btn-danger btn-sm fa fa-minus deleteItem"></i></td>
                                        </tr>
                                    @endforeach
                                    {{-- @die(); --}}
                                @endif
                            @endif
                        </tbody>
                    </table>
        </div>
        <div class="row">
            <div class="offset-md-4 col-md-4 mt-2">
                <div class="input-group input-group-sm ">
                    <button class="btn btn-success btn-round btn-block py-2">Submit</button>
                </div>
            </div>
        </div> <!-- end row -->
{!! Form::close() !!}
@endsection

@section('script')
    <script>
         function tableFixHead (e) {
            const el = e.target,
                sT = el.scrollTop;
            el.querySelectorAll("thead th").forEach(th => 
            th.style.transform = `translateY(${sT}px)`
            );
        }
        document.querySelectorAll(".tableFixHead").forEach(el => 
            el.addEventListener("scroll", tableFixHead)
        );
        function addMaterial(){
            
            $('#materialTable tbody').append(
            `<tr>
                <td class="sl">
                    
                </td>
                <td>
                    <input type="hidden" name="floor_id[]" value="" class="floor_id" required>
                    <input type="text" name="floor_name[]" class="form-control form-control-sm floor_name" autocomplete="off">
                </td>
                <td>
                    {{Form::select('layer1_material_id[]', $material_layer1, null,['class' => 'form-control 1st_layer_material','id' => 'parent_id0', 'placeholder' => '', 'autocomplete'=>"off"])}}
                </td>
                <td>
                    {{Form::select('layer2_material_id[]', [] , null,['class' => 'form-control 2nd_layer_material', 'placeholder' => '', 'id' => 'parent_id1', 'autocomplete'=>"off"])}}
                </td>
                <td>
                     <input type="hidden" name="material_id[]" value="" class="material_id" required>
                    <input type="text" name="material_name[]" class="form-control form-control-sm material_name" autocomplete="off" required> 
                </td>
                <td><input type="text" name="unit[]" class="form-control form-control-sm unit" readonly tabindex="-1"></td>
                <td><input type="number" name="quantity[]" value="" class="form-control form-control-sm  text-center quantity" step="0.01" placeholder="0.00" autocomplete="off" required></td>
                <td><input type="text" name="remarks[]" value="" class="form-control form-control-sm text-center remarks" placeholder="Remarks" autocomplete="off"></td>
                <td><i class="btn btn-primary btn-sm fa fa-plus addMaterial"></i><i class="btn btn-danger btn-sm fa fa-minus deleteItem"></i></td>
            </tr>`
            );
            $('#materialTable tr:last').find('.floor_id').val($('#materialTable tr:last').prev().find('.floor_id').val());
            $('#materialTable tr:last').find('.floor_name').val($('#materialTable tr:last').prev().find('.floor_name').val());
            addSerial();
        }



        var CSRF_TOKEN = "{{csrf_token()}}";
        $(function() {
            @if($formType == 'create' && !old('material_name'))
                addMaterial();
            @endif

             // check double entry protection of material for a floor
            function checkFloorWiseMaterialDoubleEntry(currentRow){
                let currentFloorId       = currentRow.closest('tr').find(".floor_id").val();
                let searchdata = currentRow.closest('tr').find(".material_id").val();
                let selectdata = currentRow.closest('tr').find('.material.3rd_layer').val();
                if(selectdata){
                    var currentMaterialId = selectdata;
                }else{
                    var currentMaterialId = searchdata;
                }
                let currentFloorMaterial = `${currentFloorId}-${currentMaterialId}`; 
                let materialNames        = $(".floor_id").not(currentRow.closest('tr').find(".floor_id")); 
                materialNames.each(function(){
                    let floorId       = $(this).closest('tr').find(".floor_id").val();
                    let materialId    = $(this).closest('tr').find(".material_id").val();
                    let floorMaterial = `${floorId}-${materialId}`; 
                    if(floorId){
                        if(floorMaterial == currentFloorMaterial){
                            alert("Duplicate Found"); 
                            currentRow.closest('tr').remove();
                        }
                    }else{
                        if(materialId == currentMaterialId){
                            alert("Duplicate Found"); 
                            currentRow.closest('tr').remove();
                        }
                    }
                });
                return false;
            }
            $("#materialTable").on('click', '.addMaterial', function(){
                addMaterial();
            }).on('click', '.deleteItem', function(){
                $(this).closest('tr').remove();
                addSerial();
            });

             $(document).on('keyup', ".check_material_name", function(){
                
                $(this).autocomplete({
                     source: function( request, response ) {
                         $.ajax({
                             url:"{{route('scj.CheckMaterialAutoSuggestWhereDepthThree')}}",
                             type: 'post',
                             datatype: "json",
                             data: {
                                 _token: csrf_token,
                                 search: request.term
                             },
                             success: function( data ) {
                                 response( data );
                             }
                         });
                     },
                     select: function (event, ui) {
                         $(this).val(ui.item.label);
                         $(this).closest('tr').find('.check_material_name').val(ui.item.label);
                         return false;
                     }
                 });
             });
            $(document).on('keyup', ".floor_name", function(){
                if(!$("#project_id").val()){
                    alert("Select Project Name First");
                }else{
                    let project_id  = $("#project_id").val();
                    $(this).closest('tr').find('.floor_id').val('');
                    $(this).autocomplete({
                        source: function( request, response ) {
                            $.ajax({
                                url:"{{route('scj.floorAutoSuggest')}}",
                                type: 'post',
                                dataType: "json",
                                data: {
                                    _token: CSRF_TOKEN,
                                    search: request.term,
                                    project_id: project_id
                                },
                                success: function( data ) {
                                   
                                    if (data.length > 0) {
                                        response( data );
                                } else {
                                    //If no records found, set the default "No match found" item with value -1.
                                    
                                    response([{ 
                                        label: 'No results found.',
                                        val: -1,
                                        floor_id: null
                                    }]);
                                }
                                },
                                error: function(xhr, status, error) {
                                }
                            });
                        },
                        select: function (event, ui) {
                            if (ui.item.val == -1) {
                                $(this).val("");
                                $(this).closest('tr').find('.floor_id').val(ui.item.floor_id);
                                return false;
                            }else{
                                $(this).val(ui.item.label);
                                    $(this).closest('tr').find('.floor_name').val(ui.item.label);
                                    $(this).closest('tr').find('.floor_id').val(ui.item.floor_id);
                                    checkFloorWiseMaterialDoubleEntry($(this));
                                    return false;
                            }
                        }
                    });
                }
            });

            


            $(document).on('click', ".1st_layer_material", function(){
                if(!$("#project_id").val()){
                     alert("select project name first");
                }else{
                
                    var material_id = $(this).val();
                    var selected_data = this;
                    
                       
                        $.ajax({
                            url:"{{ url('scj/getChildMaterial') }}",
                            type: 'GET',
                            data: {'material_id': material_id},
                            success: function(data){
                                $(selected_data).parent('td').next('td').find('.2nd_layer_material').html();
                                $(selected_data).parent('td').next('td').find('.2nd_layer_material').html(data);
                                return false;
                            }
                        });  
                    }
               
            })
                
            $(document).on('click', ".2nd_layer_material", function(){
                if(!$("#project_id").val()){
                     alert("select project name first");
                }else{
                
                    var material_id = $(this).val();
                    var selected_data = this;
                    var a = $(this).parent('td').prev('td').find('.1st_layer_material').val();
                    if(a == null || a == ''){
                        alert('Please select parent material');
                        return false;
                    }
                       
                        $.ajax({
                            url:"{{ url('scj/getChildMaterial') }}",
                            type: 'GET',
                            data: {'material_id': material_id},
                            success: function(data){
                                $(selected_data).parent('td').next('td').html('').append($('<select></select>')
                                .attr({
                                        class:'form-control material 3rd_layer',
                                        placeholder:"Select 3rd layer material Name",
                                        autocomplete: "off",
                                        name: "material_id[]"
                                    }).append(data)).append('<input type="hidden" name="material_name[]" class="material_name">');
                                    return false;
                            }
                        });  
                    }
               
            })

            $(document).on('click', ".material", function(){
                    if(!$("#project_id").val()){
                        alert("select project name first");
                    }else{
                    
                        var material_id = $(this).val();
                        var selected_data = this;
                        var a = $(this).parent('td').prev('td').find('.2nd_layer_material').val();
                        @if($formType == 'create')
                        if(a == null || a == ''){
                            alert('Please select parent material');
                            return false;
                        }
                        @else

                        @endif
                        
                            $.ajax({
                                url:"{{ url('scj/getChildMaterial') }}",
                                type: 'GET',
                                data: {'material_id': material_id},
                                success: function(data){
                                    $(selected_data).parent('td').next('td').find('.material').html();
                                    $(selected_data).parent('td').next('td').find('.material').html(data);
                                    return false;
                                }
                            });  
                        }
                
                })
            
            
            $(document).on('change', ".3rd_layer", function(){
                if(!$("#project_id").val()){
                     alert("select project name first");
                }else{
                    let selected_material = $(this);
                    var search_val = selected_material.children("option:selected").text();
                    $.ajax({
                            url: "{{ route('scj.materialAutoSuggest') }}",
                            type: 'post',
                            dataType: "json",
                            data: {
                                _token: CSRF_TOKEN,
                                search: search_val
                            },
                            success: function(data) {
                                $(selected_material).closest('tr').find('.unit').val(data[0].unit.name);
                                $(selected_material).closest('tr').find('.material_name').val(selected_material.children("option:selected").text());
                                checkFloorWiseMaterialDoubleEntry(selected_material);
                                return false;
                            }
                        })
                  }
                });
                $(document).on('keyup', ".material_name", function(){
                if(!$("#project_id").val()){
                    alert("select project name first");
                }else{
                    var layer2_material_id = $(this).closest('tr').find('.layer2_material_id').val();
                    
                            $(this).autocomplete({
                            source: function( request, response ) {
                                $.ajax({
                                    url:"{{route('scj.materialAutoSuggestWhereDepthThree')}}",
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
                                $(this).closest('tr').find('.material_name').val(ui.item.label);
                                $(this).closest('tr').find('.material_id').val(ui.item.material_id);
                                $(this).closest('tr').find('.unit').val(ui.item.unit.name);
                                checkFloorWiseMaterialDoubleEntry($(this));
                                return false;
                            }
                        });
                    
         
                }
            });

            $("#material_name").autocomplete({
                    source: function(request, response) {
                    $.ajax({
                        url: "{{ route('scj.materialAutoSuggest') }}",
                        type: 'post',
                        dataType: "json",
                        data: {
                            _token: CSRF_TOKEN,
                            search: request.term
                        },
                        success: function(data) {
                            response(data);
                        }
                    });
                },
                select: function(event, ui) {
                    $(this).val(ui.item.value);
                    return false;
                }
            }); 
            
        }); // document .ready
        function addSerial(){
                let sl = 0;
                 $('.sl').each(function(){
                    sl++;
                    $(this).text(sl)
                     });
                  }
       
    </script>
@endsection
