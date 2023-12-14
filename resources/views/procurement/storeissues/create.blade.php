@extends('layouts.backend-layout')
@section('title', 'Store Issue')

@section('breadcrumb-title')
    @if($formType == 'edit')
        Edit Store Issue Note
    @else
        Add Store Issue Note
    @endif
@endsection

@section('breadcrumb-button')
    <a href="{{ url('storeissues') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', null)

@section('content')
    @if($formType == 'edit')
        {!! Form::open(array('url' => "storeissues/$storeissue->id",'method' => 'PUT', 'class'=>'custom-form')) !!}
    @else
        {!! Form::open(array('url' => "storeissues",'method' => 'POST', 'class'=>'custom-form')) !!}
    @endif
        <input type="hidden" name="requisition_id" value="{{(!empty($storeissue->id) ? $storeissue->id : null)}}">
        <div class="row">
            <div class="col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="project_id">Project Name<span class="text-danger">*</span></label>
                    {{Form::text('project_name', old('project_name') ? old('project_name') : (!empty($storeissue) ? $storeissue->costCenter->name : null),['class' => 'form-control','id' => 'project_name', 'autocomplete'=>"off","required"])}}
                    {{Form::hidden('project_id', old('project_id') ? old('project_id') : (!empty($storeissue) ? $storeissue->costCenter->project_id: null),['class' => 'form-control','id' => 'project_id', 'autocomplete'=>"off"])}}
                    {{Form::hidden('cost_center_id', old('cost_center_id') ? old('cost_center_id') : (!empty($storeissue) ? $storeissue->cost_center_id : null),['class' => 'form-control','id' => 'cost_center_id', 'autocomplete'=>"off"])}}
                </div>
            </div>
            <div class="col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="sin_no">SIN No.<span class="text-danger">*</span></label>
                    {{Form::number('sin_no', old('sin_no') ? old('sin_no') : (!empty($storeissue->sin_no) ? $storeissue->sin_no : null),['class' => 'form-control','id' => 'sin_no','autocomplete'=>"off","required"])}}
                </div>
            </div>

            <div class="col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="srf_no">SRF No.<span class="text-danger">*</span></label>
                    {{Form::text('srf_no', old('srf_no') ? old('srf_no') : (!empty($storeissue->srf_no) ? $storeissue->srf_no : null),['class' => 'form-control','id' => 'srf_no','autocomplete'=>"off","required"])}}
                </div>
            </div>
            <div class="col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="date">Date<span class="text-danger">*</span></label>
                    {{Form::text('date', old('date') ? old('date') : (!empty($storeissue->date) ? $storeissue->date : null),['class' => 'form-control','id' => 'date','autocomplete'=>"off","required", 'readonly'])}}
                </div>
            </div>

        </div><!-- end row -->

        {{-- <div id="material_and_quantity">
        </div> --}}

    <div class="table-responsive">
        <table class="table table-striped table-bordered table-sm text-center" id="itemTable">
            <thead>
            <tr>
                <th width="200px">Floor Name</th>
                <th>Material Name <span class="text-danger">*</span></th>
                <th>Unit</th>
                <th>MRR<br>Quantity</th>
                <th>Current Stock</th>
                <th>Ledger Folio No.<span class="text-danger">*</span></th>
                <th>Issued <br> Quantity<span class="text-danger">*</span></th>
                <th>Purpose of Works<span class="text-danger">*</span></th>
                <th>Notes</th>
                <th>
                    <button class="btn btn-success btn-sm addItem" type="button"><i class="fa fa-plus"></i></button>
                </th>
            </tr>
            </thead>
            <tbody>

            @if(old('material_id'))
                @foreach(old('material_id') as $key => $materialOldData) 
                    <tr>
                        <td>
                            <input type="text" name="floor_name[]"   value="{{old('floor_name')[$key]}}" id="floor_name" class="form-control text-center form-control-sm floor_name">
                            <input type="hidden" name="floor_id[]"   value="{{old('floor_id')[$key]}}" id="floor_id" class="form-control text-center form-control-sm floor_id">
                        </td>
                        <td>
                            <input type="text" name="material_name[]"   value="{{old('material_name')[$key]}}" class="form-control text-center form-control-sm material_name text-center">
                            <input type="hidden" name="material_id[]" value="{{old('material_id')[$key]}}" class="form-control form-control-sm text-center material_id" >
                        </td>
                        <td><input type="text" name="unit[]"  value="{{old('unit')[$key]}}" class="form-control text-center text-center form-control-sm unit" readonly tabindex="-1"></td>
                        <td><input type="text" name="mrr_quantity[]"  value="{{old('mrr_quantity')[$key]}}" class="form-control text-center form-control-sm mrr_quantity" readonly tabindex="-1"></td>
                        <td><input type="text" name="ledger_folio_no[]" value="{{old('ledger_folio_no')[$key]}}" class="form-control text-center form-control-sm ledger_folio_no" ></td>
                        <td><input type="number" name="issued_quantity[]" value="{{old('issued_quantity')[$key]}}" class="form-control text-center form-control-sm issued_quantity" ></td>
                        <td> <textarea name="purpose[]" class ='form-control text-center' id ='purpose' rows=1>{{old('purpose')[$key]}}</textarea></td>
                        <td> <textarea name="notes[]" class ='form-control text-center' id ='notes' rows=1>{{old('notes')[$key]}}</textarea></td>
                        
                        <td><button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i class="fa fa-minus"></i></button></td>

                    </tr>
                @endforeach
            @else
                @if(!empty($storeissue))
                    @foreach($storeissue->storeissuedetails as $storeissuedetail)
                        <tr>
                            <td>
                                <input type="text" name="floor_name[]"   value="{{!empty($storeissuedetail->floor_id) ? $storeissuedetail->boqFloor->name : ""}}" id="floor_name" class="form-control text-center form-control-sm">
                                <input type="hidden" name="floor_id[]" value="{{!empty($storeissuedetail->floor_id) ? $storeissuedetail->floor_id : ""}}" id="floor_id" class="form-control form-control-sm text-center floor_name" >
                            </td>
                            <td>
                                <input type="text" name="material_name[]"   value="{{$storeissuedetail->nestedMaterials->name}}" class="form-control text-center form-control-sm material_name">
                                <input type="hidden" name="material_id[]" value="{{$storeissuedetail->nestedMaterials->id}}" class="form-control form-control-sm text-center material_id" >
                            </td>
                            <td><input type="text" name="unit[]"  value="{{$storeissuedetail->nestedMaterials->unit->name}}" class="form-control text-center form-control-sm unit" readonly tabindex="-1"></td>
                            <td><input type="text" name="mrr_quantity[]"  value="{{$storeissuedetail->quantity}}" class="form-control text-center form-control-sm mrr_quantity" readonly tabindex="-1"></td>
                            <td><input type="text" name="ledger_folio_no[]" value="{{$storeissuedetail->ledger_folio_no}}" class="form-control text-center form-control-sm ledger_folio_no" autocomplete="off" ></td>
                            <td><input type="number" name="issued_quantity[]" value="{{$storeissuedetail->issued_quantity}}" class="form-control text-center form-control-sm issued_quantity"  autocomplete="off"></td>
                            <td> <textarea name="purpose[]" class ='form-control text-center' id ='purpose' rows=1>{{$storeissuedetail->purpose}}</textarea></td>
                            <td> <textarea name="notes[]" class ='form-control text-center' id ='notes' rows=1>{{$storeissuedetail->notes}}</textarea></td>
                            <td><button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i class="fa fa-minus"></i></button></td>
                        </tr>
                    @endforeach
                @endif
            @endif
            </tbody>
        </table>
    </div>


        <div class="row">
            <div class="offset-md-4 col-md-4 mt-2">
                <div class="input-group input-group-sm">
                    <button class="btn btn-success btn-round btn-block py-2">Submit</button>
                </div>
            </div>
        </div> <!-- end row -->
    {!! Form::close() !!}
@endsection


@section('script')
    <script>
        function addRow(){
            let row = `
                <tr>
                    <td>
                        <select class ="form-control form-control-sm floor_name"  name="floor_id[]" id="floor_name" autocomplete="off">
                            <option value=""></option>
                        </select>
                    </td>
                    <td>
                        <input type="hidden" name="material_id[]" class="material_id">
                        <input type="text" name="material_name[]" class="form-control text-center form-control-sm material_name" autocomplete="off" required placeholder="Material Name">
                    </td>
                    <td><input type="text" name="unit[]" class="form-control text-center form-control-sm unit" readonly tabindex="-1"></td>
                    <td><input type="text" name="mrr_quantity[]" class="form-control text-center form-control-sm mrr_quantity" readonly tabindex="-1"></td>
                    <td><input type="text" name="current_stock[]" class="form-control text-center form-control-sm current_stock" readonly tabindex="-1"></td>
                    <td><input type="text" name="ledger_folio_no[]" class="form-control text-center form-control-sm ledger_folio_no" autocomplete="off"></td>
                    <td><input type="number" name="issued_quantity[]" class="form-control text-center form-control-sm issued_quantity" autocomplete="off" required></td>
                    <td> <textarea name="purpose[]" class ='form-control text-center' id ='purpose' rows=1></textarea></td>
                    <td> <textarea name="notes[]" class ='form-control text-center' id ='notes' rows=1></textarea></td>
                    <td><button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i class="fa fa-minus"></i></button></td>
                </tr>
            `;
            $('#itemTable tbody').append(row);
        }
        
        var CSRF_TOKEN = "{{csrf_token()}}";
        $(function(){

            // check double entry protection of material for a floor
            function checkFloorWiseMaterialDoubleEntry(currentRow){
                let costCenterId         = $("#cost_center_id").val();

                let currentFloorId       = $(currentRow).closest('tr').find(".floor_name").val();
                let currentMaterialId    = $(currentRow).closest('tr').find(".material_id").val();
                let currentFloorMaterial = `${currentFloorId}-${currentMaterialId}`; 
                let materialNames        = $(".floor_name").not($(currentRow).closest('tr').find(".floor_name")); 

                materialNames.each(function(){
                    let floorId       = $(this).closest('tr').find(".floor_name").val();
                    let materialId    = $(this).closest('tr').find(".material_id").val();
                    let floorMaterial = `${floorId}-${materialId}`; 
                    if(floorId){
                        if(floorMaterial == currentFloorMaterial){
                            alert("Duplicate Found"); 
                            $(this).closest('tr').remove();
                        }
                    }else{
                        if(materialId == currentMaterialId){
                            alert("Duplicate Found"); 
                            $(this).closest('tr').remove();
                        }
                    }
                });
            }


            @if($formType == 'create' && !old('material_name'))
                addRow();
            @endif

            $("#itemTable").on('click', ".addItem", function(){
                addRow();
                loadProjectWiseFloorAfterMrr(this);
            }).on('click', '.deleteItem', function(){
                $(this).closest('tr').remove();
            });

            $('#date').datepicker({format: "dd-mm-yyyy",autoclose: true,todayHighlight: true,showOtherMonths: true});

            $(document).on('mouseenter', '.required_date', function(){
                $(this).datepicker({format: "dd-mm-yyyy",autoclose: true,todayHighlight: true,showOtherMonths: true});
            });
            $(document).on('change', '.floor_name', function(){
                $(this).closest('tr').find('input').val('');
            });

            $(document).on('change', '#cost_center_id', function() {
                alert('ok');
            });


            // Function for autocompletion of projects
        
            $( "#project_name").autocomplete({
                source: function( request, response ) {
                    $.ajax({
                        url:"{{route('scj.projectAutoSuggestAfterMRR')}}",
                        type: 'post',
                        dataType: "json",
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
                    $('#cost_center_id').val(ui.item.value);
                    $('#project_id').val(ui.item.project_id);
                    $('#project_name').val(ui.item.label);
                    $("#itemTable").find("tbody").children("tr").remove();
                    addRow();
                    loadProjectWiseFloorAfterMrr();
                    return false;
                } 
            })

            // Function for autocompletion of floor 

            function loadProjectWiseFloorAfterMrr(item){
                let project_id  = $("#project_id").val();
                if(project_id) {
                    const url  = '{{url("scj/loadProjectWiseFloorAfterMrr")}}/'+ project_id;
                    let dropdown; 

                    $('.floor_name').each(function (){
                        dropdown = $(this).closest('tr').find('.floor_name');
                    });
                    dropdown.empty();
                    dropdown.append('<option selected disabled>Select Floor</option>');
                    dropdown.prop('selectedIndex', 0);

                    $.getJSON(url, function (items) {
                        $.each(items, function (key, data) {
                            dropdown.append($('<option></option>').attr('value', data.value).text(data.label));
                        })
                    });
                }
            };


            $(document).on('keyup', ".material_name", function(){
                let project_id      = $("#project_id").val();
                let cost_center_id  = $("#cost_center_id").val();
                let floor_name      = $(this).closest('tr').find(".floor_name").val();

                if(cost_center_id){
                    if(project_id && floor_name)
                    {
                        $(this).autocomplete({
                            source: function( request, response ) {
                                $.ajax({
                                    url:'{{route("scj.floorswiseMrrMaterials")}}',
                                    type: 'get',
                                    dataType: "json",
                                    data: {
                                        _token: CSRF_TOKEN,
                                        search: request.term,
                                        cost_center_id : cost_center_id,
                                        project_id : project_id,
                                        floor_name : floor_name,
                                    },
                                    success: function( data ) {
                                        response( data );
                                    }
                                });
                            },
                            select: function (event, ui) {
                                let vm = this;
                                $(this).val(ui.item.label);
                                $(this).closest('tr').find('.material_name').val(ui.item.label);
                                $(this).closest('tr').find('.material_id').val(ui.item.material_id);
                                $(this).closest('tr').find('.unit').val(ui.item.unit_name);
                                $(this).closest('tr').find('.mrr_quantity').val(ui.item.mrr_quantity);
                                let material_id = ui.item.material_id;
                                $.ajax({
                                    url:'{{route("scj.getMrrDetailsByMaterial")}}',
                                    
                                    type: 'get',
                                    dataType: "json",
                                    data: {
                                        _token: CSRF_TOKEN,
                                        cost_center_id : cost_center_id,
                                        project_id : project_id,
                                        floor_name : floor_name,
                                        material_id: material_id
                                        
                                    },
                                    success: function( data ) {
                                        $.each(data, function(materials, material){
                                            let issued_quantity = material.mrr_quantity - material.issue_total;

                                            $(vm).closest('tr').find('.mrr_quantity').val( material.mrr_quantity);
                                            $(vm).closest('tr').find('.issued_quantity').attr('max', issued_quantity);
                                        })
                                    }
                                }); 
                                $.ajax({
                                        url: '{{ route("scj.getPresentStockQuantity") }}',
                                        type: 'post',
                                        dataType: "json",
                                        data: {
                                            _token: CSRF_TOKEN,
                                            cost_center_id: cost_center_id,
                                            material_id: material_id
                                        },
                                        success: function(data) {
                                            $(vm).closest('tr').find('.current_stock').val(data.mrr_quantity);
                                        }
                                    });
                                checkFloorWiseMaterialDoubleEntry($(this));
                            }
                        });
                    }else if(project_id)
                    {
                        $(this).autocomplete({
                            source: function( request, response ) {
                                $.ajax({
                                    url:'{{route("scj.projectWiseMrrMaterials")}}',
                                    type: 'get',
                                    dataType: "json",
                                    data: {
                                        _token: CSRF_TOKEN,
                                        search: request.term,
                                        cost_center_id : cost_center_id,
                                        project_id : project_id
                                    },
                                    success: function( data ) {
                                        response( data );
                                    }
                                });
                            },
                            select: function (event, ui) {
                                let vm = this;
                                $(this).val(ui.item.label);
                                $(this).closest('tr').find('.material_name').val(ui.item.label);
                                $(this).closest('tr').find('.material_id').val(ui.item.material_id);
                                $(this).closest('tr').find('.unit').val(ui.item.unit_name);
                                $(this).closest('tr').find('.mrr_quantity').val(ui.item.mrr_quantity);
                                let material_id = ui.item.material_id;

                                $.ajax({
                                    url:'{{route("scj.getMrrDetailsByMaterial")}}',
                                    
                                    type: 'post',
                                    dataType: "json",
                                    data: {
                                        _token: CSRF_TOKEN,
                                        cost_center_id : cost_center_id,
                                        project_id : project_id,
                                        floor_name : floor_name,
                                        material_id: material_id
                                        
                                    },
                                    success: function( data ) {
                                        $.each(data, function(materials, material){
                                            $(vm).closest('tr').find('.mrr_quantity').val( material.mrr_quantity);
                                            $(vm).closest('tr').find('.issued_quantity').attr('max', material.mrr_quantity);
                                        })
                                    }
                                }); 

                                $.ajax({
                                        url: '{{ route("scj.getPresentStockQuantity") }}',
                                        type: 'post',
                                        dataType: "json",
                                        data: {
                                            _token: CSRF_TOKEN,
                                            cost_center_id: cost_center_id,
                                            material_id: material_id
                                        },
                                        success: function(data) {
                                            $(vm).closest('tr').find('.current_stock').val(data.mrr_quantity);
                                        }
                                    });
                                checkFloorWiseMaterialDoubleEntry($(this));
                            }
                        });
                    }else if(project_id === "" && floor_name === "")
                    {
                        $(this).autocomplete({
                            source: function( request, response ) {
                                $.ajax({
                                    url:'{{route("scj.headOfficeWiseMrrMaterials")}}',
                                    type: 'get',
                                    dataType: "json",
                                    data: {
                                        _token: CSRF_TOKEN,
                                        search: request.term,
                                        cost_center_id : cost_center_id,
                                        project_id : project_id
                                    },
                                    success: function( data ) {
                                        response( data );
                                    }
                                });
                            },
                            select: function (event, ui) {
                                let vm = this;
                                $(this).val(ui.item.label);
                                $(this).closest('tr').find('.material_name').val(ui.item.label);
                                $(this).closest('tr').find('.material_id').val(ui.item.material_id);
                                $(this).closest('tr').find('.unit').val(ui.item.unit_name);
                                $(this).closest('tr').find('.mrr_quantity').val(ui.item.mrr_quantity);
                                let material_id = ui.item.material_id;

                                $.ajax({
                                    url:'{{route("scj.getMrrDetailsByMaterial")}}',
                                    
                                    type: 'post',
                                    dataType: "json",
                                    data: {
                                        _token: CSRF_TOKEN,
                                        cost_center_id : cost_center_id,
                                        project_id : project_id,
                                        floor_name : floor_name,
                                        material_id: material_id
                                        
                                    },
                                    success: function( data ) {
                                        $.each(data, function(materials, material){
                                            $(vm).closest('tr').find('.mrr_quantity').val( material.mrr_quantity);
                                            $(vm).closest('tr').find('.issued_quantity').attr('max', material.mrr_quantity);
                                        })
                                    }
                                }); 

                                $.ajax({
                                        url: '{{ route("scj.getPresentStockQuantity") }}',
                                        type: 'post',
                                        dataType: "json",
                                        data: {
                                            _token: CSRF_TOKEN,
                                            cost_center_id: cost_center_id,
                                            material_id: material_id
                                        },
                                        success: function(data) {
                                            $(vm).closest('tr').find('.current_stock').val(data.mrr_quantity);
                                        }
                                    });
                            }
                        });
                    }else{
                        $(document).on('keyup', ".material_name", function() {
                            let project_id  = $("#project_id").val();
                            if((project_id = true)){
                                alert("No data available");
                                $("#itemTable").find("tbody").children("tr").remove();
                                addRow();
                            }
                        });
                    };
                }else{
                    $(document).on('keyup', ".material_name", function() {
                        let project_id  = $("#project_id").val();
                        if((project_id = true)){
                            alert("Search project name first");
                            $("#itemTable").find("tbody").children("tr").remove();
                            addRow();
                        }
                    });
                };
            });
        });


        
    </script>
@endsection
