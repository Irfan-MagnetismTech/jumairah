@extends('layouts.backend-layout')
@section('title', 'MTR')

@section('breadcrumb-title')
    @if(!empty($movementRequisition))
        Edit Movement Requisition
    @else
        Add Movement Requisition
    @endif
@endsection

@section('breadcrumb-button')
    <a href="{{ url('movement-requisitions') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', null)

@section('content')
    @if(!empty($movementRequisition))
        {!! Form::open(array('url' => "movement-requisitions/$requisition->id",'method' => 'PUT', 'class'=>'custom-form')) !!}
    @else
        {!! Form::open(array('url' => "movement-requisitions",'method' => 'POST', 'class'=>'custom-form')) !!}
    @endif
        <input type="hidden" name="requisition_id" value="{{(!empty($requisition->id) ? $requisition->id : null)}}">
        <div class="row">
        <div class="col-md-4">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="reason">MTRF NO.<span class="text-danger">*</span></label>
                    {{Form::number('mtrf_no', old('mtrf_no') ? old('mtrf_no') : (!empty($requisition) ? $requisition->mtrf_no : null),['class' => 'form-control','id' => 'mtrf_no', 'placeholder'=>"MTRF No.", 'required','autocomplete'=>"off" ])}}
                </div>
            </div>
            <div class="col-md-4">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="delivery_date">Requested Date<span class="text-danger">*</span></label>
                    {{Form::text('date', old('date') ? old('date') : (!empty($requisition) ? $requisition->date : date('d-m-Y',strtotime(now()))),['class' => 'form-control','id' => 'date','autocomplete'=>"off","required", 'placeholder' => 'Applied Date', 'readonly'])}}
                </div>
            </div>
            <div class="col-md-4">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="delivery_date">Delivery Date <span class="text-danger">*</span></label>
                    {{Form::text('delivery_date', old('delivery_date') ? old('delivery_date') : (!empty($requisition) ? $requisition->delivery_date : null),['class' => 'form-control','id' => 'delivery_date','autocomplete'=>"off","required", 'placeholder' => 'Applied Date','readonly'])}}
                </div>
            </div>
            <div class="col-md-4">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="project_id">From Project <span class="text-danger">*</span></label>
                    {{Form::text('from_costcenter_name', old('from_costcenter_name') ? old('from_costcenter_name') : (!empty($requisition) ? $requisition->costCenter->name : null),['class' => 'form-control','id' => 'from_costcenter_name', 'autocomplete'=>"off","required", 'placeholder' => 'Project Name'])}}
                    {{Form::hidden('from_costcenter_id', old('from_costcenter_id') ? old('from_costcenter_id') : (!empty($requisition) ? $requisition->from_costcenter_id: null),['class' => 'form-control','id' => 'from_costcenter_id', 'autocomplete'=>"off"])}}
                </div>
            </div>
            <div class="col-md-4">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="project_id">To Project <span class="text-danger">*</span></label>
                    {{Form::text('project_name', old('project_name') ? old('project_name') : (!empty($requisition) ? $requisition->costCenter->name : null),['class' => 'form-control','id' => 'project_name', 'autocomplete'=>"off","required", 'placeholder' => 'Project Name'])}}
                    {{Form::hidden('project_id', old('project_id') ? old('project_id') : (!empty($requisition) ? $requisition->costCenter->project_id: null),['class' => 'form-control','id' => 'project_id', 'autocomplete'=>"off"])}}
                    {{Form::hidden('cost_center_id', old('cost_center_id') ? old('cost_center_id') : (!empty($requisition) ? $requisition->cost_center_id: null),['class' => 'form-control','id' => 'cost_center_id', 'autocomplete'=>"off"])}}
                </div>
            </div>
            <div class="col-md-4">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="project_id">Requested By <span class="text-danger">*</span></label>
                    {{Form::text('requested_by', auth()->user()->name,['class' => 'form-control','id' => 'to_costcenter_name', 'autocomplete'=>"off","readonly", 'placeholder' => 'Project Name'])}}
                </div>
            </div>

            <div class="col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" style="max-width:220px!important" for="note">Material Required for </label>
                    {{Form::textarea('reason', old('reason') ? old('reason') : (!empty($requisition) ? $requisition->reason : null),['class' => 'form-control','id' => 'reason', 'rows'=>2,'autocomplete'=>"off", 'placeholder' => 'reason'])}}
                </div>
            </div>

            <div class="col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="remarks">Remarks (site)</label>
                    {{Form::textarea('remarks', old('remarks') ? old('remarks') : (!empty($requisition) ? $requisition->remarks : null),['class' => 'form-control','id' => 'remarks', 'rows'=>2,'autocomplete'=>"off", 'placeholder' => 'Remarks(site)'])}}
                </div>
            </div>
        </div><!-- end row -->

    <hr class="bg-success">
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-sm text-center" id="itemTable">
            <thead>
            <tr>
                <th width="200px">Floor Name <span class="text-danger">*</span></th>
                <th>Material Name <span class="text-danger">*</span></th>
                <th>Unit</th>
                <th>Total Estimated<br>Requirement</th>
                <th>Net Comulative<br>Received</th>
                <th>Present Stock</th>
                <th>Available Stock</th>
                <th>Required Presently<span class="text-danger">*</span></th>
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
                            <input type="text" name="material_name[]"   value="{{old('material_name')[$key]}}" class="form-control text-center form-control-sm material_name">
                        </td>
                        <td><input type="text" name="unit[]"  value="{{old('unit')[$key]}}" class="form-control text-center form-control-sm unit" readonly tabindex="-1"></td>
                        <td><input type="number" name="boq_quantity[]" value="{{old('boq_quantity')[$key]}}" class="form-control text-center form-control-sm boq_quantity" tabindex="-1" readonly></td>
                        <td><input type="number" name="taken_quantity[]" value="{{old('taken_quantity')[$key]}}"  class="form-control text-center form-control-sm taken_quantity" tabindex="-1" readonly></td>
                        <td><input type="number" name="present_stock[]" value="{{old('present_stock')[$key]}}" class="form-control text-center form-control-sm prestent_stock" tabindex="-1" readonly></td>
                        <td><input type="number" name="quantity[]" value="{{old('quantity')[$key]}}" class="form-control form-control-sm text-center quantity" min="0" step="0.05" placeholder="0.00" required autocomplete="off"></td>
                        <td><button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i class="fa fa-minus"></i></button></td>
                    </tr>
                @endforeach
            @else
                @if(!empty($requisition))
                    @foreach($requisition->requisitiondetails as $requisitiondetail)
                        @php
                            $boqMaterial = App\Procurement\NestedMaterial::whereHas('boqSupremeBudgets')->whereAncestorOrSelf($requisitiondetail->material_id)->orderBy('id','desc')->first();

                            if (!empty($requisitiondetail->floor_id)) {
                                $floorNo = $requisitiondetail->boqFloors->where('project_id', $requisitiondetail->requisition->costCenter->project_id)->first();
                                $boq_quantity = App\Procurement\BoqSupremeBudget::
                                        where('project_id',$requisitiondetail->requisition->costCenter->project_id)
                                    ->where('floor_id', $floorNo->boq_floor_project_id)
                                    ->where('material_id', $boqMaterial->id)
                                    ->first();

                            }else{
                                $boq_quantity = App\Procurement\BoqSupremeBudget::
                                    where('project_id',$requisitiondetail->requisition->costCenter->project_id)
                                    ->where('material_id', $boqMaterial->id)
                                    ->first();
                            }

                            $budgeted_quantity = $boq_quantity->quantity ?? 0;
                            $taken_quantity = $requisitiondetail->quantity ?? 0; //will be calculated after MRR
                            $present_stock = $budgeted_quantity - $taken_quantity;
                        @endphp
                        <tr>
                            <td>
                                <input type="text" name="floor_name[]"   value="{{ !empty($requisitiondetail->boqFloor->name) ? $requisitiondetail->boqFloor->name : "" }}" id="floor_name" class="form-control text-center form-control-sm">
                                <input type="hidden" name="floor_id[]" value="{{ !empty($requisitiondetail->floor_id) ? $requisitiondetail->floor_id : "" }}" id="floor_id" class="form-control form-control-sm text-center floor_name" >
                            </td>
                            <td>
                                <input type="text" name="material_name[]"   value="{{ $requisitiondetail->nestedMaterial->name }}" class="form-control text-center form-control-sm material_name">
                                <input type="hidden" name="material_id[]" value="{{ $requisitiondetail->nestedMaterial->id }}" class="form-control form-control-sm text-center material_id" required >
                            </td>
                            <td><input type="text" name="unit[]"  value="{{ $requisitiondetail->nestedMaterial->unit->name }}" class="form-control text-center form-control-sm text-center unit" readonly tabindex="-1"></td>
                            <td><input type="number" name="boq_quantity[]" value="{{ $budgeted_quantity }}" class="form-control text-center form-control-sm boq_quantity" tabindex="-1" readonly></td>
                            <td><input type="number" name="taken_quantity[]" value="{{ $requisitiondetail->quantity ?? 0 }}"  class="form-control text-center form-control-sm taken_quantity" tabindex="-1" readonly></td>
                            <td><input type="number" name="present_stock[]" value="{{ $present_stock }}" class="form-control text-center form-control-sm prestent_stock" tabindex="-1" readonly></td>
                            <td><input type="number" name="quantity[]" value="{{ $requisitiondetail->quantity }}" class="form-control form-control-sm text-center quantity" min="0" max="{{$present_stock}}" step="0.05" placeholder="0.00" required autocomplete="off"></td>
                            <td><input type="text" name="required_date[]" value="{{ $requisitiondetail->required_date }}"  class="form-control form-control-sm required_date" autocomplete="off"></td>
                            <td><button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i class="fa fa-minus"></i></button></td>
                        </tr>
                    @endforeach
                @endif
            @endif
            </tbody>
        </table>
    </div> <!-- end table responsive -->
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

        $( "#from_costcenter_name").autocomplete({
            source: function( request, response ) {
                $.ajax({
                    url:"{{route('costCenterAutoSuggest')}}",
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
                $('#from_costcenter_id').val(ui.item.value);
                $('#from_costcenter_name').val(ui.item.label);
                $("#itemTable").find("tbody").children("tr").remove();
                return false;
            }
        });

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
                    <td><input type="text" name="unit[]" class="form-control form-control text-center form-control-sm unit" readonly tabindex="-1"></td>
                    <td><input type="number" name="boq_quantity[]" class="form-control text-center form-control-sm boq_quantity" tabindex="-1" readonly></td>
                    <td><input type="number" name="taken_quantity[]" class="form-control text-center form-control-sm taken_quantity" tabindex="-1" readonly></td>
                    <td><input type="number" name="present_stock[]" class="form-control text-center form-control-sm prestent_stock" tabindex="-1" readonly></td>
                    <td><input type="number" name="available_stock[]" class="form-control form-control-sm text-center available_stock" min="1" readonly step="0.05" placeholder="0.00" required autocomplete="off"></td>
                    <td><input type="number" name="quantity[]" class="form-control form-control-sm text-center quantity" min="1" step="0.05" placeholder="0.00" required autocomplete="off"></td>
                    <td><button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i class="fa fa-minus"></i></button></td>
                </tr>
            `;
            $('#itemTable tbody').append(row);
        }


        var CSRF_TOKEN = "{{csrf_token()}}";
        $(function(){
            @if(!empty($movementRequisition) && !old('material_id'))
                addRow();
            @endif

            $("#itemTable").on('click', ".addItem", function(){
                addRow();
                loadProjectWiseFloor(this);
            }).on('click', '.deleteItem', function(){
                $(this).closest('tr').remove();
            });

            $('#date, #delivery_date').datepicker({format: "dd-mm-yyyy",autoclose: true,todayHighlight: true,showOtherMonths: true});

            $(document).on('mouseenter', '.required_date', function(){
                $(this).datepicker({format: "dd-mm-yyyy",autoclose: true,todayHighlight: true,showOtherMonths: true});
            });

            // Function for autocompletion of projects



            $( "#project_name").autocomplete({
                source: function( request, response ) {
                    $.ajax({
                        url:"{{route('scj.projectAutoSuggest')}}",
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
                    loadProjectWiseFloor();
                    return false;
                }
            })

            // Function for autocompletion of floor

            function loadProjectWiseFloor(item){
                let project_id  = $("#project_id").val();
                if(project_id) {
                    const url  = '{{url("scj/loadProjectWiseFloor")}}/'+ project_id;
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
                let cost_center_id = $("#cost_center_id").val();
                let project_id  = $("#project_id").val();
                let floor_name    = $(this).closest('tr').find(".floor_name").val();

                if(project_id && floor_name)
                {
                    $(this).autocomplete({
                        source: function( request, response ) {
                            $.ajax({
                                url:'{{route("scj.floorswiseBOQbudgetedMaterials")}}',
                                type: 'get',
                                dataType: "json",
                                data: {
                                    _token: CSRF_TOKEN,
                                    search: request.term,
                                    project_id : project_id,
                                    floor_name : floor_name
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
                            $(this).closest('tr').find('.unit').val(ui.item.unit.name);
                            $(this).closest('tr').find('.boq_quantity').val(ui.item.quantity);
                            let material_id = ui.item.material_id;

                            $.ajax({
                                url:'{{route("scj.getRequisionDetailsByProjectAndMaterial")}}',

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
                                    let taken_quantity = data.material_receive_quantity_sum;
                                    let present_stock = data.present_stock_in_stock_history;
                                    let max_quantity = ui.item.quantity - data.requisition_quantity;
                                    $(vm).closest('tr').find('.taken_quantity').val(taken_quantity);
                                    $(vm).closest('tr').find('.prestent_stock').val(present_stock);
                                    // $(vm).closest('tr').find('.quantity').attr('max', max_quantity);
                                    loadAvailableStock($(vm));
                                }
                            });
                        }
                    });
                }else if(project_id)
                {
                    var material_id ='';
                    $(this).autocomplete({
                        source: function( request, response ) {
                            $.ajax({
                                url:'{{route("scj.ProjectWiseBOQbudgetedMaterials")}}',
                                type: 'post',
                                dataType: "json",
                                data: {
                                    _token: CSRF_TOKEN,
                                    search: request.term,
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
                            $(this).closest('tr').find('.unit').val(ui.item.unit.name);
                            $(this).closest('tr').find('.boq_quantity').val(ui.item.quantity);
                            material_id = ui.item.material_id;

                            $.ajax({
                                url:'{{route("scj.getRequisionDetailsByProjectAndMaterial")}}',

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
                                    let taken_quantity = data.material_receive_quantity_sum;
                                    let present_stock = data.present_stock_in_stock_history;
                                    let max_quantity = ui.item.quantity - data.requisition_quantity;
                                    $(vm).closest('tr').find('.taken_quantity').val(taken_quantity);
                                    $(vm).closest('tr').find('.prestent_stock').val(present_stock);
                                    // $(vm).closest('tr').find('.quantity').attr('max', max_quantity);
                                    loadAvailableStock($(this));
                                }
                            });
                        }
                    });
                }else{
                    $(document).on('keyup', ".material_name", function() {
                        let project_id  = $("#project_id").val();
                        if((project_id = true)){
                            alert("Search project name first");
                            $("#itemTable").find("tbody").children("tr").remove();
                            addRow();
                        }
                    });
                    loadAvailableStock($(this));
                };

            });

            function loadAvailableStock(thisVal) {
                let material = thisVal.closest('tr').find(".material_id").val();
                let from_costcenter = $("#from_costcenter_id").val();
                const url = '{{url("get-project-available-stock")}}/' + from_costcenter + '/' + material;
                fetch(url)
                .then((resp) => resp.json())
                    .then(function(data) {
                        console.log(thisVal);
                        thisVal.closest('tr').find(".available_stock").val(data.present_stock);
                    })
            }
        });

    </script>
@endsection
