@extends('layouts.backend-layout')
@section('title', 'final-settlements')

@section('breadcrumb-title')
    @if(!empty($finalSettlement))
        Edit Final Settlement Cost
    @else
        Add Final Settlement Cost
    @endif
@endsection

@section('breadcrumb-button')
    <a href="{{ url('final-settlements') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'offset-md-1 col-md-10 offset-lg-2 col-lg-8 my-3')

@section('content')

    @if(!empty($finalSettlement))
        {!! Form::open(array('url' => "final-settlements/$finalSettlement->id",'encType' =>"multipart/form-data", 'method' => 'PUT', 'class'=>'custom-form')) !!}
    @else
        {!! Form::open(array('url' => "final-settlements",'method' => 'POST','encType' =>"multipart/form-data", 'class'=>'custom-form')) !!}
    @endif
    {{Form::hidden('id', old('id') ? old('id') : (!empty($finalSettlement) ? $finalSettlement->id : null),['class' => 'form-control','autocomplete'=>"off"])}}
    <div class="row">
        <div class="col-12">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="project_name">Project Name<span class="text-danger">*</span></label>
                {{Form::text('project_name', old('project_name') ? old('project_name') : (!empty($finalSettlement) ? $finalSettlement->sell->apartment->project->name : null),['class' => 'form-control','id' => 'project_name', 'autocomplete'=>"off",'required'])}}
                {{Form::hidden('project_id', old('project_id') ? old('project_id') : (!empty($finalSettlement) ? $finalSettlement->sell->apartment->project_id : null),['class' => 'form-control','id' => 'project_id', 'autocomplete'=>"off",'required'])}}
            </div>
        </div>

        <div class="col-12">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="sale_id">Client Name<span class="text-danger">*</span></label>
                {{Form::select('sale_id', $clients, old('sale_id') ? old('sale_id') : (!empty($finalSettlement) ? $finalSettlement->sale_id : null),['class' => 'form-control','id' => 'sale_id', 'autocomplete'=>"off"])}}
            </div>
        </div>

        <div class="col-12">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="registration_cost">Registration Cost <span class="text-danger">*</span></label>
                {{Form::text('registration_cost', old('registration_cost') ? old('registration_cost') : (!empty($finalSettlement) ? $finalSettlement->registration_cost : null),['class' => 'form-control text-right','id' => 'registration_cost', 'autocomplete'=>"off"])}}
            </div>
        </div>

        <div class="col-12">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="discount">Special Discount <span class="text-danger">*</span></label>
                {{Form::text('discount', old('discount') ? old('discount') : (!empty($finalSettlement) ? $finalSettlement->discount : null),['class' => 'form-control text-right','id' => 'discount', 'autocomplete'=>"off"])}}
            </div>
        </div>
    </div>
    <hr class="bg-success">

    <div class="row">
        <div class="offset-md-4 col-md-4 mt-2">
            <div class="input-group input-group-sm ">
                <button class="btn btn-success btn-round btn-block py-2">Save</button>
            </div>
        </div>
    </div> <!-- end row -->

    {!! Form::close() !!}


@endsection
@section('script')
    <script>
        var CSRF_TOKEN = "{{csrf_token()}}";
        $(function(){
            $( "#project_name").autocomplete({
                source: function( request, response ) {
                    $.ajax({
                        url:"{{route('projectAutoSuggest')}}",
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
                    $('#project_name').val(ui.item.label);
                    $('#project_id').val(ui.item.value);
                    return false;
                }
            }).on('change', function(){
                loadSoldClientsWithApartment();
            });
        });

        function loadSoldClientsWithApartment(){
            let dropdown = $('#sale_id');
            let oldSelectedItem = "{{old('sale_id') ? old('sale_id') : (!empty($finalSettlement->sale_id) ? $finalSettlement->sale_id : null)}}";
            dropdown.empty();
            dropdown.append('<option selected="true" disabled>Select Type </option>');
            dropdown.prop('selectedIndex', 0);
            const url = '{{url("loadSoldClientsWithApartment")}}/' + $("#project_id").val();
            // Populate dropdown with list of provinces
            $.getJSON(url, function (sells) {
                $.each(sells, function (key, sell) {
                    let select=(oldSelectedItem == sell.id) ? "selected" : null;
                    dropdown.append($(`<option ${select}></option>`).attr('value', sell.id).text(`${sell.sell_client.client.name} [Apartment : ${sell.apartment.name}]`));
                });
            });
        }

        $(function(){
            @if(old() || !empty($finalSettlement))
                loadSoldClientsWithApartment();
            @endif
        });

        $(document).on('keyup','#registration_cost, #discount ',function (){
            addComma(this)
        });

        function addComma (thisVal){
            $(thisVal).keyup(function(event) {
                if(event.which >= 37 && event.which <= 40) return;
                $(this).val(function(index, value) {
                    return value .replace(/[^0-9\.]/g, "") .replace(/\B(?=(\d{3})+(?!\d))/g, ",") ;
                });
            });
        }
    </script>
@endsection

