@extends('layouts.backend-layout')
@section('title', 'MPR')

@section('breadcrumb-title')
    @if($formType == 'edit')
        Edit Material Purchase Requisition(MPR)
    @else
        Add Material Purchase Requisition(MPR)
    @endif
@endsection

@section('breadcrumb-button')
    <a href="{{ url('general-requisitions') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', null)

@section('content')
    @if($formType == 'edit') 
        {!! Form::open(array('url' => "general-requisitions/$general_requisition->id",'method' => 'PUT', 'class'=>'custom-form')) !!}
    @else
        {!! Form::open(array('url' => "general-requisitions",'method' => 'POST', 'class'=>'custom-form')) !!}
    @endif
        <input type="hidden" name="requisition_id" value="{{(!empty($general_requisition->id) ? $general_requisition->id : null)}}">
        <div class="row">
            <div class="col-md-3">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="reason">MPR No.<span class="text-danger">*</span></label>
                    @if(empty($general_requisition))
                    {{Form::number('mpr_no', old('mpr_no') ? old('mpr_no') : (!empty($general_requisition->mpr_no) ? $general_requisition->mpr_no : null),['class' => 'form-control','id' => 'mpr_no', 'placeholder'=>"MPR No.", 'required','autocomplete'=>"off" ])}}
                    {{Form::hidden('mpr_id', old('mpr_id') ? old('mpr_id') : (!empty($general_requisition->mpr_no) ? $general_requisition->mpr_no : null),['class' => 'form-control','id' => 'mpr_id', 'autocomplete'=>"off",'required'])}}
                    @else
                    {{Form::number('mpr_no', old('mpr_no') ? old('mpr_no') : (!empty($general_requisition->mpr_no) ? $general_requisition->mpr_no : null),['class' => 'form-control','id' => 'mpr_no', 'placeholder'=>"MPR No.", 'required','autocomplete'=>"off", 'readonly' ])}}
                    {{Form::hidden('mpr_id', old('mpr_id') ? old('mpr_id') : (!empty($general_requisition->mpr_no) ? $general_requisition->mpr_no : null),['class' => 'form-control','id' => 'mpr_id', 'autocomplete'=>"off",'required'])}}
                    @endif

                </div>
            </div>

            <div class="col-md-3">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="project_id">Project Name<span class="text-danger">*</span></label>
                    {{Form::text('project_name', old('project_name') ? old('project_name') : (!empty($general_requisition) ? $general_requisition->costCenter->name : null),['class' => 'form-control','id' => 'project_name', 'autocomplete'=>"off","required", 'placeholder' => 'Project Name'])}}
                    {{Form::hidden('project_id', old('project_id') ? old('project_id') : (!empty($general_requisition) ? $general_requisition->costCenter->project_id: null),['class' => 'form-control','id' => 'project_id', 'autocomplete'=>"off"])}}
                    {{Form::hidden('cost_center_id', old('cost_center_id') ? old('cost_center_id') : (!empty($general_requisition) ? $general_requisition->cost_center_id: null),['class' => 'form-control','id' => 'cost_center_id', 'autocomplete'=>"off"])}}
                </div>
            </div>
            <div class="col-md-3">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="applied_date">Applied Date<span class="text-danger">*</span></label>
                    {{Form::text('applied_date', old('applied_date') ? old('applied_date') : (!empty($general_requisition->applied_date) ? $general_requisition->applied_date : null),['class' => 'form-control','id' => 'applied_date','autocomplete'=>"off","required", 'placeholder' => 'Applied Date', 'readonly'])}}
                </div>
            </div>
            <div class="col-md-3">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon">Approval Type<span class="text-danger">*</span></label>
                    {{Form::select('approval_layer_id',$ApprovalLayerName, old('approval_layer_id') ? old('approval_layer_id') : (!empty($general_requisition) ? $general_requisition->approval_layer_id : null),['class' => 'form-control','autocomplete'=>"off","required", 'placeholder' => 'Select One'])}}
                </div>
            </div>
            <div class="col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="note">Note</label>
                    {{Form::textarea('note', old('note') ? old('note') : (!empty($general_requisition->note) ? $general_requisition->note : null),['class' => 'form-control','id' => 'note', 'rows'=>2,'autocomplete'=>"off", 'placeholder' => 'Note'])}}
                </div>
            </div>

            <div class="col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="remarks">Remarks(site)</label>
                    {{Form::textarea('remarks', old('remarks') ? old('remarks') : (!empty($general_requisition->remarks) ? $general_requisition->remarks : null),['class' => 'form-control','id' => 'remarks', 'rows'=>2,'autocomplete'=>"off", 'placeholder' => 'Remarks(site)'])}}
                </div>
            </div>
        </div><!-- end row -->

    <hr class="bg-success">
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-sm text-center" id="itemTable">
            <thead>
            <tr>
                <th>Floor Name</th>
                <th>Material Name <span class="text-danger">*</span></th>
                <th>Unit</th>
                <th>Total Estimated<br>Requirement</th>
                <th>Net Comulative<br>Received</th>
                <th>Present Stock</th>
                <th>Required Presently<span class="text-danger">*</span></th>
                <th width="120px">Required Delivery<br> Date</th>
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
                            <input type="text" name="floor_name[]" value="{{old('floor_name')[$key]}}" id="floor_name" class="form-control text-center form-control-sm floor_name">
                            <input type="hidden" name="floor_id[]" value="{{old('floor_id')[$key]}}" id="floor_id" class="form-control text-center form-control-sm floor_id">                       
                        </td>
                        <td>
                            <input type="text" name="material_id[]" value="{{old('material_id')[$key]}}" class="form-control text-center form-control-sm material_name">
                        </td>
                        <td><input type="text" name="unit[]" value="{{old('unit')[$key]}}" class="form-control text-center form-control-sm unit" readonly tabindex="-1"></td>
                        <td><input type="number" name="boq_quantity[]" value="{{old('boq_quantity')[$key]}}" class="form-control text-center form-control-sm boq_quantity" tabindex="-1" readonly></td>
                        <td><input type="number" name="taken_quantity[]" value="{{old('taken_quantity')[$key]}}"  class="form-control text-center form-control-sm taken_quantity" tabindex="-1" readonly></td>
                        <td><input type="number" name="present_stock[]" value="{{old('present_stock')[$key]}}" class="form-control text-center form-control-sm prestent_stock" tabindex="-1" readonly></td>
                        <td><input type="number" name="quantity[]" value="{{old('quantity')[$key]}}" class="form-control form-control-sm text-center quantity" min="0" step="0.05" placeholder="0.00" required autocomplete="off"></td>
                        <td><input type="date" name="required_date[]" value="{{old('required_date')[$key]}}"  class="form-control form-control-sm required_date" autocomplete="off"></td>
                        <td><button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i class="fa fa-minus"></i></button></td>
                    </tr>
                @endforeach
            @else
                @if(!empty($general_requisition))
                    @foreach($general_requisition->requisitiondetails as $general_requisitiondetail)
                    {{-- @php
                        $boq_quantity = $general_requisitiondetail->nestedMaterial->boqSupremeBudgets->first()->quantity ?? 0;
                        $taken_quantity = $general_requisitiondetail->quantity ?? 0; //taken_quantity will be calculated after mrr
                        $present_stock = $boq_quantity - $taken_quantity;
                    @endphp --}}
                        <tr>
                            <td>
                                <input type="text" name="floor_name[]" value="{{$general_requisitiondetail->boqFloor->name ?? ''}}" id="floor_name" class="form-control text-center form-control-sm floor_name">
                                <input type="hidden" name="floor_id[]" value="{{$general_requisitiondetail->floor_id}}" id="floor_id" class="form-control text-center form-control-sm floor_id">                       
                            </td>
                            <td>
                                <input type="text" name="material_name[]"   value="{{$general_requisitiondetail->nestedMaterial->name}}" class="form-control text-center form-control-sm material_name">
                                <input type="hidden" name="material_id[]" value="{{$general_requisitiondetail->nestedMaterial->id}}" class="form-control form-control-sm text-center material_id" required >
                            </td>
                            <td><input type="text" name="unit[]"  value="{{$general_requisitiondetail->nestedMaterial->unit->name}}" class="form-control text-center form-control-sm text-center unit" readonly tabindex="-1"></td>
                            <td><input type="number" name="boq_quantity[]" value="" class="form-control text-center form-control-sm boq_quantity" tabindex="-1" readonly></td>
                            <td><input type="number" name="taken_quantity[]" value=""  class="form-control text-center form-control-sm taken_quantity" tabindex="-1" readonly></td>
                            <td><input type="number" name="present_stock[]" value="" class="form-control text-center form-control-sm prestent_stock" tabindex="-1" readonly></td>
                            <td><input type="number" name="quantity[]" value="{{ $general_requisitiondetail->quantity }}" class="form-control form-control-sm text-center quantity" min="0" max="" step="0.05" placeholder="0.00" required autocomplete="off"></td>
                            <td><input type="text" name="required_date[]" value="{{$general_requisitiondetail->required_date}}"  class="form-control form-control-sm required_date" autocomplete="off" readonly></td>
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

        function addRow(){
            let row = `
                <tr> 
                    <td>
                           <input type="text" name="floor_name[]" id="floor_name" class="form-control text-center form-control-sm floor_name">
                           <input type="hidden" name="floor_id[]" id="floor_id" class="form-control text-center form-control-sm floor_id">                       
                    </td>
                    <td>
                        <input type="hidden" name="material_id[]" class="material_id">
                        <input type="text" name="material_name[]" class="form-control text-center form-control-sm material_name" autocomplete="off" required placeholder="Material Name">
                    </td>
                    <td><input type="text" name="unit[]" class="form-control form-control text-center form-control-sm unit" readonly tabindex="-1"></td>
                    <td><input type="number" name="boq_quantity[]" class="form-control text-center form-control-sm boq_quantity" tabindex="-1" readonly></td>
                    <td><input type="number" name="taken_quantity[]" class="form-control text-center form-control-sm taken_quantity" tabindex="-1" readonly></td>
                    <td><input type="number" name="present_stock[]" class="form-control text-center form-control-sm prestent_stock" tabindex="-1" readonly></td>
                    <td><input type="number" name="quantity[]" class="form-control form-control-sm text-center quantity" min="1" step="0.05" placeholder="0.00" required autocomplete="off"></td>
                    <td><input type="text" name="required_date[]" class="form-control form-control-sm required_date" autocomplete="off" placeholder="Required Date" readonly></td>
                    <td><button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i class="fa fa-minus"></i></button></td>
                </tr>
            `;
            $('#itemTable tbody').append(row);
        }


        var CSRF_TOKEN = "{{csrf_token()}}";
        $(function(){
            @if($formType == 'create' && !old('material_id'))
                addRow();
            @endif

            $("#itemTable").on('click', ".addItem", function(){
                addRow();
                loadProjectWiseFloor(this);
            }).on('click', '.deleteItem', function(){
                $(this).closest('tr').remove();
            });

            $('#date,#applied_date').datepicker({format: "dd-mm-yyyy",autoclose: true,todayHighlight: true,showOtherMonths: true});

            $(document).on('mouseenter', '.required_date', function(){
                $(this).datepicker({format: "dd-mm-yyyy",autoclose: true,todayHighlight: true,showOtherMonths: true});
            });

            // Function for autocompletion of projects
        
            $( "#project_name").autocomplete({
                source: function( request, response ) {
                    $.ajax({
                        url:"{{route('scj.projectAutoSuggestBeforeBOQ')}}",
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
                    return false;
                } 
            })

            $(document).on('keyup', ".material_name", function(){
                let cost_center_id  = $("#cost_center_id").val();
                if(cost_center_id){
                    $(this).autocomplete({
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
                            $(this).val(ui.item.label);
                            $(this).closest('tr').find('.material_name').val(ui.item.label);
                            $(this).closest('tr').find('.material_id').val(ui.item.material_id);
                            $(this).closest('tr').find('.unit').val(ui.item.unit.name);
                        }
                    });
                }else{
                    alert("Search project name first");
                    $("#itemTable").find("tbody").children("tr").remove();
                    addRow();
                }
            });

            $(document).on('keyup', ".floor_name", function(){
                    $(this).autocomplete({
                        source: function(request, response) {
                            $.ajax({
                                url: "{{ route('scj.allFloorAutoSuggest') }}",
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
                            $(this).val(ui.item.label);
                            $(this).closest('tr').find('.floor_id').val(ui.item.value);
                            return false;
                        }
                    });
            });

        });

    </script>
@endsection
