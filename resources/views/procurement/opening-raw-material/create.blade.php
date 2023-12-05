@extends('layouts.backend-layout')
@section('title', 'Opening Material')

@section('breadcrumb-title')
    @if($formType == 'edit')
        Edit Opening Material
    @else
        Add Opening Material
    @endif
@endsection

@section('breadcrumb-button')
    <a href="{{ url('opening-material') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', null)

@section('content')
    @if($formType == 'edit') 
        {!! Form::open(array('url' => "opening-material/$openingMaterial->id",'method' => 'PUT', 'class'=>'custom-form')) !!}
    @else
        {!! Form::open(array('url' => "opening-material",'method' => 'POST', 'class'=>'custom-form')) !!}
    @endif

        <div class="row">
            <div class="col-md-3">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="project_id">Project Name<span class="text-danger">*</span></label>
                    {{Form::text('project_name', old('project_name') ? old('project_name') : (!empty($openingMaterial) ? $openingMaterial->costCenter->name : null),['class' => 'form-control','id' => 'project_name', 'autocomplete'=>"off","required", 'placeholder' => 'Project Name'])}}
                    {{Form::hidden('cost_center_id', old('cost_center_id') ? old('cost_center_id') : (!empty($openingMaterial) ? $openingMaterial->cost_center_id: null),['class' => 'form-control','id' => 'cost_center_id', 'autocomplete'=>"off"])}}
                </div>
            </div>
            <div class="col-md-3">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="applied_date">Applied Date<span class="text-danger">*</span></label>
                    {{Form::text('applied_date', old('applied_date') ? old('applied_date') : (!empty($openingMaterial) ? $openingMaterial->applied_date : null),['class' => 'form-control','id' => 'applied_date','autocomplete'=>"off","required", 'placeholder' => 'Applied Date', 'readonly'])}}
                </div>
            </div>
        </div><!-- end row -->

    <hr class="bg-success">
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-sm text-center" id="itemTable">
            <thead>
            <tr>
                <th>Material Name <span class="text-danger">*</span></th>
                <th>Unit</th>
                <th>Quantity<span class="text-danger">*</span></th>
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
                            <input type="text" name="material_id[]" value="{{old('material_id')[$key]}}" class="form-control text-center form-control-sm material_name">
                        </td>
                        <td><input type="text" name="unit[]" value="{{old('unit')[$key]}}" class="form-control text-center form-control-sm unit" readonly tabindex="-1"></td>
                        <td><input type="text" name="quantity[]" value="{{old('quantity')[$key]}}"  class="form-control form-control-sm quantity" autocomplete="off"></td>
                        <td><button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i class="fa fa-minus"></i></button></td>
                    </tr>
                @endforeach
            @else
                @if(!empty($openingMaterial))
                    @foreach($openingMaterial->OpeningRawMaterialDetails as $key => $requisitiondetail)
                        <tr>
                            <td>
                                <input type="text" name="material_name[]"   value="{{$requisitiondetail->nestedMaterial->name}}" class="form-control text-center form-control-sm material_name">
                                <input type="hidden" name="material_id[]" value="{{$requisitiondetail->nestedMaterial->id}}" class="form-control form-control-sm text-center material_id" required >
                            </td>
                            <td><input type="text" name="unit[]"  value="{{$requisitiondetail->nestedMaterial->unit->name}}" class="form-control text-center form-control-sm text-center unit" readonly tabindex="-1"></td>
                            <td><input type="text" name="quantity[]" value="{{$requisitiondetail->quantity}}"  class="form-control form-control-sm quantity" autocomplete="off"></td>
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
                        <input type="hidden" name="material_id[]" class="material_id">
                        <input type="text" name="material_name[]" class="form-control text-center form-control-sm material_name" autocomplete="off" required placeholder="Material Name">
                    </td>
                    <td><input type="text" name="unit[]" class="form-control form-control text-center form-control-sm unit" readonly tabindex="-1"></td>
                    <td><input type="text" name="quantity[]" class="form-control form-control-sm quantity" autocomplete="off" placeholder="0.00" ></td>
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
            }).on('click', '.deleteItem', function(){
                $(this).closest('tr').remove();
            });

            $('#applied_date').datepicker({format: "dd-mm-yyyy",autoclose: true,todayHighlight: true,showOtherMonths: true});



            // Function for autocompletion of projects
        
            $( "#project_name").autocomplete({
                source: function( request, response ) {
                    $.ajax({
                        url:"{{route('scj.costCenterAutoSuggest')}}",
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
        });

    </script>
@endsection
