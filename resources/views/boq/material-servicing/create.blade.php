@extends('layouts.backend-layout')
@section('title', 'Material Servicing')

@section('breadcrumb-title')
        Material Servicing
@endsection

@section('breadcrumb-button')
    <a href="{{ url('boq/MaterialServincing/index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', null)

@section('content')
        {!! Form::open(array('url' => "boq/MaterialServincing",'method' => 'POST', 'class'=>'custom-form')) !!}
       

    <hr class="bg-success">
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-sm text-center" id="itemTable">
            <thead>
            <tr>
                <th>Material Name <span class="text-danger">*</span></th>
                <th>Unit</th>
                <th>Material Tag<span class="text-danger">*</span></th>
                <th>Present<br>Status</th>
                <th>Servicing<br>Date</th>
                <th>Comment</th>
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
                            <input type="text" name="material_id[]"   value="{{old('material_id')[$key]}}" class="form-control text-center form-control-sm material_name">
                        </td>
                        <td><input type="text" name="unit[]"  value="{{old('unit')[$key]}}" class="form-control text-center form-control-sm unit" readonly tabindex="-1"></td>
                        <td>
                            <input type="select" name="fixed_asset_id[]"   value="{{old('fixed_asset_id')[$key]}}" class="form-control text-center form-control-sm tag">
                        </td>
                        <td>
                            <select class="form-control form-control-sm tag" name="fixed_asset_id[]" required>
                                <option selected disabled>Select Tag </option>
                                {{-- @foreach ($materials as $material_id => $material)
                                    <option value="{{ $fixed_asset_id }}" @if (old("fixed_asset_id.{$key}", $value->nestedMaterials->id ?? null) == $material_id) selected @endif>
                                        {{ $material }}
                                    </option>
                                @endforeach --}}
                            </select>
                        </td>
                        <td><input type="text" name="present_status[]" value="{{old('present_status')[$key]}}"  class="form-control text-center form-control-sm present_status"></td>
                        <td><input type="text" name="servicing_date[]" value="{{old('servicing_date')[$key]}}"  class="form-control text-center form-control-sm servicing_date"></td>
                        <td><input type="text" name="comment[]" value="{{old('comment')[$key]}}"  class="form-control text-center form-control-sm comment"></td>
                        <td><button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i class="fa fa-minus"></i></button></td>
                    </tr>
                @endforeach
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
                    <td>
                        <input type="text" name="unit[]" class="form-control form-control text-center form-control-sm unit" readonly tabindex="-1">
                    </td>
                    <td>
                        <select class ="form-control form-control-sm tag"  name="fixed_asset_id[]" required>
                            <option value="">Select Tag</option>
                        </select>
                    </td>
                    <td><input type="text" name="present_status[]" class="form-control text-center form-control-sm present_status"></td>
                    <td><input type="text" name="servicing_date[]" class="form-control text-center form-control-sm servicing_date"></td>
                    <td><input type="text" name="comment[]" class="form-control text-center form-control-sm comment"></td>
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

            $(document).on('mouseenter', '.servicing_date', function(){
                $(this).datepicker({format: "dd-mm-yyyy",autoclose: true,todayHighlight: true,showOtherMonths: true});
            });


            $(document).on('keyup', ".material_name", function(){

                $(this).autocomplete({
                    source: function( request, response ) {
                        $.ajax({
                            url:"{{route('scj.getScrapMaterial')}}",
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
                        $(this).val(ui.item.label);
                        $(this).closest('tr').find('.material_id').val(ui.item.value);
                        $(this).closest('tr').find('.material_name').val(ui.item.label);
                        $(this).closest('tr').find('.unit').val(ui.item.unit);
                        let prnt = $(this)
                        let url ='{{url("scj/loadFixedCost")}}/'+ ui.item.value;
                        fetch(url)
                        .then((resp) => resp.json())
                        .then(function(data) {
                                if(data.length > 0) {
                                    prnt.closest('tr').find(".tag").html(null);
                                    prnt.closest('tr').find(".tag").append(`<option value=""> Select Tag</option>`);
                                    console.log(data);
                                    $.each(data, function(fixedAssets, fixedAsset){
                                    let option = `<option value="${fixedAsset.id}">${fixedAsset.tag}</option>`;
                                    console.log(option);
                                    prnt.closest('tr').find(".tag").append(option);
                                });
                                }
                            })
                        .catch(function ($err) {
                        });
                        return false;
                    }
                });
            });
        });

    </script>
@endsection
