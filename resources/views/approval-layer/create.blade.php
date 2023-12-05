@extends('layouts.backend-layout')
@section('title', 'Approval Layer')

@section('breadcrumb-title')
    @if($formType == 'edit')
        Edit Approval Layer
    @else
        Add Approval Layer
    @endif
@endsection

@section('breadcrumb-button')
    <a href="{{ url('approval-layer') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'offset-md-1 col-md-10 offset-lg-2 col-lg-8 my-3')

@section('content')

    @if($formType == 'edit')
        {!! Form::open(array('url' => "approval-layer/$approvalLayer->id",'method' => 'PUT', 'class'=>'custom-form')) !!}
    @else
        {!! Form::open(array('url' => "approval-layer",'method' => 'POST', 'class'=>'custom-form')) !!}
    @endif
        <div class="row">
            <div class="col-md-12 col-xl-12">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="layer_for">Approval For<span class="text-danger">*</span></label>
                    <select name="name" class="form-control" placeholder="Select Approval Layer">
                        <option value="">Select Approval Layer</option>
                        @foreach($layers as $layer)
                        <option value="{{$layer->name ?? ''}}" @if(!empty($approvalLayer) && ($layer->name == $approvalLayer->name))selected @endif>{{$layer->name ?? ''}}</option>
                        @endforeach
                    </select>
                    {{Form::select('for_department_id', $departments, !empty($approvalLayer) ? $approvalLayer->department_id : null ,['class' => 'form-control','id' => 'type','placeholder'=>'Select Department ', 'autocomplete'=>"off",'required'])}}
                </div>
            </div>
        </div><!-- end row -->


        <div class="table-responsive">
            <table class="table table-striped table-bordered table-sm text-center" id="itemTable">
                <thead>
                    <tr>
                        <th>Department<span class="text-danger">*</span></th>
                        <th>Designation<span class="text-danger">*</span></th>
                        <th>Layer Name<span class="text-danger">*</span></th>
                        <th width="200px">Order By<span class="text-danger">*</span></th>
                        <th>
                            <button class="btn btn-success btn-sm addItem" type="button"><i class="fa fa-plus"></i></button>
                        </th>
                    </tr>
                </thead>
                <tbody>

                @if(old('designation_id'))
                    @foreach(old('designation_id') as $key => $designationOldData)
                        <tr>
                            <td>
                                <input type="text" name="designation_name[]"   value="{{old('designation_name')[$key]}}" id="designation_name" class="form-control text-center form-control-sm designation_name">
                                <input type="hidden" name="designation_id[]"   value="{{old('designation_id')[$key]}}" id="designation_id" class="form-control text-center form-control-sm designation_id">
                            </td>
                            <td><input type="text" name="layer_name[]"  value="{{old('layer_name')[$key]}}" class="form-control text-center form-control-sm layer_name" autocomplete="off"></td>
                            <td><input type="text" name="order_by[]"  value="{{old('order_by')[$key]}}" class="form-control text-center form-control-sm order_by" autocomplete="off"></td>
                            <td><button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i class="fa fa-minus"></i></button></td>
                        </tr>
                    @endforeach
                @else
                    @if(!empty($approvalLayer))
                        @foreach($approvalLayer->approvalLeyarDetails as $approvalLeyarDetail)

                            <tr>
                                <td>
                                    {{Form::select('department_id[]', $departments, $approvalLeyarDetail->department_id ,['class' => 'form-control','id' => 'type','placeholder'=>'Select Department ', 'autocomplete'=>"off",'required'])}}
                                </td>
                                <td>
                                    <input type="text" name="designation_name[]"   value="{{ !empty($approvalLeyarDetail) ? $approvalLeyarDetail->designation->name : "" }}" id="designation_name" class="form-control text-center form-control-sm designation_name">
                                    <input type="hidden" name="designation_id[]" value="{{ !empty($approvalLeyarDetail->designation_id) ? $approvalLeyarDetail->designation_id : "" }}" id="designation_id" class="form-control form-control-sm text-center designation_id" >
                                </td>
                                <td><input type="text" name="layer_name[]"  value="{{ $approvalLeyarDetail->name }}" class="form-control text-center form-control-sm text-center layer_name" autocomplete="off"></td>
                                <td><input type="text" name="order_by[]"  value="{{ $approvalLeyarDetail->order_by }}" class="form-control text-center form-control-sm text-center layer_name" autocomplete="off"></td>
                                <td><button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i class="fa fa-minus"></i></button></td>
                            </tr>
                        @endforeach
                    @endif
                @endif
                </tbody>
            </table>
        </div> <!-- end table responsive -->


    <hr class="bg-success">
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
                {{Form::select('department_id[]', $departments, null,['class' => 'form-control','id' => 'type','placeholder'=>'Select Department ', 'autocomplete'=>"off",'required'])}}
                </td>
                <td>
                    <input type="hidden" name="designation_id[]" id="designation_id" class="form-control text-center form-control-sm designation_id">
                    <input type="text" name="designation_name[]" class="form-control text-center form-control-sm designation_name" autocomplete="off">
                </td>
                <td><input type="text" name="layer_name[]" class="form-control text-center form-control-sm layer_name" autocomplete="off"></td>
                <td><input type="text" name="order_by[]" class="form-control text-center form-control-sm order_by" autocomplete="off"></td>
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
        })

        $(document).on('keyup', ".designation_name", function(){
            $(this).autocomplete({
                source: function( request, response ) {
                    $.ajax({
                        url:'{{route("designationNameAutoSuggest")}}',
                        type: 'get',
                        dataType: "json",
                        data: {
                            _token: CSRF_TOKEN,
                            search: request.term
                        },
                        success: function( data ) {
                            response(data);
                        }
                    });
                },
                select: function (event, ui) {
                    $(this).closest('tr').find('.designation_id').val(ui.item.value);
                    $(this).closest('tr').find('.designation_name').val(ui.item.label);
                    return false;
                }
            });
        });
    </script>

    @endsection

