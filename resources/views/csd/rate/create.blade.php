@extends('layouts.backend-layout')
@section('title', 'Material Rate')

@section('breadcrumb-title')
    @if($formType == 'edit')
        Edit Material Rate
    @else
        Add Material Rate
    @endif
@endsection

@section('breadcrumb-button')
    <a href="{{ url('csd/material_rate') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', null)

@section('content')
    @if($formType == 'edit')
        {!! Form::open(array('url' => "csd/material_rate/$rate->id",'method' => 'PUT', 'class'=>'custom-form')) !!}
    @else
        {!! Form::open(array('url' => "csd/material_rate",'method' => 'POST', 'class'=>'custom-form')) !!}
    @endif

    <hr class="bg-success">
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-sm text-center" id="itemTable">
            <thead>
            <tr>
                <th >Material Name <span class="text-danger">*</span></th>
                <th >Unit</th>
                <th >Refund Rate<span class="text-danger">*</span></th>
                <th >Actual Rate<span class="text-danger">*</span></th>
                <th >Demand Rate<span class="text-danger">*</span></th>
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
                            <input type="text" name="material_name[]"   value="{{old('material_name')[$key]}}" id="material_name" class="form-control form-control-sm material_name" autocomplete="off">
                            <input type="hidden" name="material_id[]"   value="{{old('material_id')[$key]}}" id="material_id" class="form-control form-control-sm material_id">
                        </td>
                        <td>
                            <input type="text" name="unit_name[]"  value="{{old('unit_name')[$key]}}" id="unit_name" class="form-control form-control-sm unit_name" readonly tabindex="-1">
                            {{-- <input type="hidden" name="unit_id[]"  value="{{old('unit_id')[$key]}}" id="unit_id" class="form-control form-control-sm unit_id"> --}}
                        </td>
                        <td><input type="text" name="refund_rate[]"  value="{{old('refund_rate')[$key]}}" id="refund_rate" class="form-control form-control-sm refund_rate" autocomplete="off" readonly></td>
                        <td><input type="text" name="actual_rate[]"  value="{{old('actual_rate')[$key]}}" id="actual_rate" class="form-control form-control-sm actual_rate" autocomplete="off"></td>
                        <td><input type="text" name="demand_rate[]"  value="{{old('demand_rate')[$key]}}" id="demand_rate" class="form-control form-control-sm demand_rate" autocomplete="off" readonly></td>
                        <td><button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i class="fa fa-minus"></i></button></td>
                    </tr>
                @endforeach
            @else
                @if(!empty($rate))
                    <tr>
                        <input type="hidden" name="id"   value="{{ $rate->id }}" id="id" class="form-control form-control-sm id">

                        <td>
                            <input type="text" name="material_name"   value="{{ $rate->material->name }}" id="material_name" class="form-control form-control-sm material_name" autocomplete="off">
                            <input type="hidden" name="material_id"   value="{{ $rate->material->id }}" id="material_id" class="form-control form-control-sm material_id">
                        </td>
                        <td>
                            <input type="text" name="unit_name"  value="{{ $rate->material->unit->name }}" id="unit_name" class="form-control form-control-sm unit_name" readonly tabindex="-1">
                            {{-- <input type="hidden" name="unit_id"  value="{{ $rate->csdMaterials->unit->id }}" id="unit_id" class="form-control form-control-sm unit_id"> --}}
                        </td>
                        <td><input type="text" name="refund_rate"  value="{{ $rate->refund_rate }}" id="refund_rate" class="form-control form-control-sm refund_rate" autocomplete="off" readonly></td>
                        <td><input type="text" name="actual_rate"  value="{{ $rate->actual_rate }}" id="actual_rate"  class="form-control form-control-sm actual_rate" autocomplete="off"></td>
                        <td><input type="text" name="demand_rate"  value="{{ $rate->demand_rate }}" id="demand_rate" class="form-control form-control-sm demand_rate" autocomplete="off" readonly></td>
                        <td><button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i class="fa fa-minus"></i></button></td>
                    </tr>
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
                    <input type="text" name="material_name[]" id="material_name" class="form-control form-control-sm material_name" autocomplete="off">
                    <input type="hidden" name="material_id[]" id="material_id" class="form-control form-control-sm material_id">
                </td>
                <td>
                    <input type="text" name="unit_name[]" id="unit_name" class="form-control form-control-sm unit_name" readonly tabindex="-1">
                </td>
                <td><input type="text" name="refund_rate[]" id="refund_rate" class="form-control form-control-sm refund_rate" autocomplete="off" readonly></td>
                <td><input type="text" name="actual_rate[]" id="actual_rate" class="form-control form-control-sm actual_rate" autocomplete="off"></td>
                <td><input type="text" name="demand_rate[]" id="demand_rate" class="form-control form-control-sm demand_rate" autocomplete="off" readonly></td>
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

            $('#date,#applied_date').datepicker({format: "dd-mm-yyyy",autoclose: true,todayHighlight: true,showOtherMonths: true});

            $(document).on('mouseenter', '.required_date', function(){
                $(this).datepicker({format: "dd-mm-yyyy",autoclose: true,todayHighlight: true,showOtherMonths: true});
            });


            $(document).on('keyup', ".material_name", function(){
                // $(this).autocomplete({
                // source: function( request, response ) {
                //     $.ajax({
                //         url:"{{route('csd.csdMaterialAutoSuggest')}}",
                //         type: 'post',
                //         dataType: "json",
                //         data: {
                //             _token: CSRF_TOKEN,
                //             search: request.term
                //         },
                //         success: function( data ) {
                //             response( data );
                //         }
                //     });
                // },
                // select: function (event, ui) {

                //     $(this).closest('#material_name').val(ui.item.label);
                //     $(this).closest('tr').find("#material_id").val(ui.item.material_id);
                //     $(this).closest('tr').find("#unit_name").val(ui.item.unit_name);
                //     $(this).closest('tr').find("#unit_id").val(ui.item.unit_id);

                //     return false;
                //     }
                // })
                $(this).autocomplete({
                        source: function(request, response) {
                            $.ajax({
                                url: "{{route('scj.materialAutoSuggest')}}",
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
                            $(this).closest('tr').find('.unit_name').val(ui.item.unit.name);
                        }
                    });
            });
            $(document).on('keyup change', ".actual_rate", function(){
                const actual_rate = $(this).val();
                let refund_rate = (actual_rate*(1 - 0.20));
                let demand_rate = (actual_rate*(1 + 0.20));
                if(refund_rate < 1.5){
                    refund_rate = refund_rate.toFixed(2);
                }else{
                    refund_rate = Math.round(refund_rate);
                }
                if(demand_rate < 1.5){
                    demand_rate = demand_rate.toFixed(2);
                }else{
                    demand_rate = Math.round(demand_rate);
                }
                $(this).closest('tr').find(".demand_rate").val(demand_rate);
                $(this).closest('tr').find(".refund_rate").val(refund_rate);

            });
        });


    </script>
@endsection
