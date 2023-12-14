@extends('layouts.backend-layout')
@section('title', 'Parking')

@section('breadcrumb-title')
    @if($formType == 'edit')
        Edit Parking
    @else
        Add New Parking
    @endif
@endsection

@section('breadcrumb-button')
    <a href="{{ url('parkings') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'offset-md-1 col-md-10 offset-lg-2 col-lg-8 my-3')


@section('content')

    @if($formType == 'edit')
        {!! Form::open(array('url' => "parkings/$parking->id",'encType' =>"multipart/form-data", 'method' => 'PUT', 'class'=>'custom-form')) !!}
        <input type="hidden" name="id" value="{{old('id') ? old('id') : (!empty($parking->id) ? $parking->id : null)}}">
    @else
        {!! Form::open(array('url' => "parkings",'method' => 'POST','encType' =>"multipart/form-data", 'class'=>'custom-form')) !!}
    @endif
    <div class="row">
        <div class="col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="project_id">Project Name<span class="text-danger">*</span></label>
                {{Form::text('project_name', old('project_name') ? old('project_name') : (!empty($parking) ? $parking->project->name : null),['class' => 'form-control','id' => 'project_name', 'autocomplete'=>"off","required"])}}
                {{Form::hidden('project_id', old('project_id') ? old('project_id') : (!empty($parking) ? $parking->project->id: null),['class' => 'form-control','id' => 'project_id', 'autocomplete'=>"off"])}}
            </div>
        </div>
        <div class="col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="owner">Parking Location<span class="text-danger">*</span></label>
                {{Form::select('location', $locations, old('location') ? old('location') : (!empty($parking->location) ? $parking->location : null),['class' => 'form-control', 'id' => 'location', 'autocomplete'=>"off", 'placeholder'=>'Select Location',"required"] )}}
            </div>
        </div>
        <div class="col-md-6 {{!empty($parking) && $parking->level ? null : "d-none"}}" id="level_area">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="level">Level No<span class="text-danger">*</span></label>
                {{Form::select('level', $levels, old('level') ? old('level') : (!empty($parking->level) ? $parking->level : null),['class' => 'form-control','id' => 'level', 'autocomplete'=>"off", 'placeholder'=>'Select Level',"required"])}}
            </div>
        </div>

        <div class="col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="total_parking">Total Parking<span class="text-danger">*</span></label>
                {{Form::number('total_parking', old('total_parking') ? old('total_parking') : (!empty($parking->total_parking) ? $parking->total_parking : null),['class' => 'form-control', 'id' => 'total_parking', 'min'=>'0', 'placeholder' => 'Number of Parking', 'autocomplete'=>"off","required"] )}}
            </div>
        </div>
    </div> <!-- row -->
    <hr class="bg-success">

    <div class="row" id="parkingList">
        @if(old('parking_name'))
            @foreach(old('parking_name') as $key=>$parkingName)
                <div class="col-md-12">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="parking_name">Parking Name<span class="text-danger">*</span></label>
                        <input type="text" value="{{$parkingName}}" name="parking_name[]" class="form-control" autocomplete="off" required>
                        <select name="parking_owner[]"  class="form-control" required >
                            <option value="">Select Owner</option>
                            <option value="JHL"{{ old('parking_owner')[$key] == 'JHL' ? 'selected' : '' }}>Jumairah Holdings Ltd</option>
                            <option value="Landowner" {{old('parking_owner')[$key]== 'Landowner' ? 'selected' : '' }}>LandOwner</option>
                        </select>
                    </div>
                </div>
            @endforeach
        @elseif(!empty($parking) && $parking->parkingDetails->isNotEmpty())
            @foreach($parking->parkingDetails as $key=>$parkingName)
                <div class="col-md-12">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="parking_name">Parking Name<span class="text-danger">*</span></label>
                        <input type="text" value="{{$parkingName->parking_name}}" name="parking_name[]" class="form-control" autocomplete="off" required>
                        <select name="parking_owner[]"  class="form-control" required >
                            <option value="">Select Owner</option>
                            <option value="JHL" {{ $parkingName->parking_owner == 'JHL' ? 'selected' : '' }}>Jumairah Holdings Ltd</option>
                            <option value="Landowner" {{ $parkingName->parking_owner == 'Landowner' ? 'selected' : '' }}>LandOwner</option>
                        </select>
                    </div>
                </div>
            @endforeach
        @endif
    </div> <!-- row -->

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
        function loadProjectBasement(){
            let i, dropdown = $('#level');
            let oldSelectedItem = "{{old('level') ? old('level') : (!empty($parking) ? $parking->level : null) }}";
            dropdown.empty();
            dropdown.append('<option selected="true" disabled>Select Level </option>');
            dropdown.prop('selectedIndex', 0);
            const url = '{{url("loadProjectBasement")}}/' + $("#project_id").val();
            // Populate dropdown with list of provinces
            $.getJSON(url, function (items) {
                console.log(items);
                for(i = 1; i <= items; i++){
                    let select=(oldSelectedItem == i) ? "selected" : null;
                    dropdown.append($(`<option ${select}></option>`).attr('value', i).text(i));
                }

            });
        }
        function parkingLocation(){
            const url = '{{url("loadProjectBasement")}}/' + $("#project_id").val();
            fetch(url)
            .then((resp) => resp.json())
            .then(function(basmentInformation) {
                if(basmentInformation > 0){
                    let dropdown = $('#location');
                    dropdown.empty();
                    dropdown.append(
                        `<option selected="true" disabled>Select Location </option>
                         <option value="Ground" {{!empty($parking) && ($parking->location)=='Ground'}}>Ground</option>
                         <option value="Basement" {{!empty($parking) && ($parking->location)=='Basement'}}>Basement</option>`
                    );
                    dropdown.prop('selectedIndex', 0);
                }else{
                    let dropdown = $('#location');
                    dropdown.empty();
                    dropdown.append(
                        `<option selected="true" disabled>Select Location </option>
                         <option value="Ground" {{!empty($parking) && ($parking->location)=='Ground'}}>Ground</option>`
                    );
                    dropdown.prop('selectedIndex', 0);
                }
            })
        }

        var CSRF_TOKEN = "{{csrf_token()}}";
        $(function(){
            loadProjectBasement();
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
                parkingLocation();
            });

            $("#location,#project_name").on('change', function(){
                let location = $("#location").val();
                if(location == 'Basement'){
                    loadProjectBasement();
                    $("#level_area").removeClass('d-none');
                }else{
                    $("#level_area").addClass('d-none');
                }
            });

            $("#total_parking, #location, #level").on('change', function(){
                if($("#location").val() && $("#project_id").val()) {
                    generate_parking_number();
                }
                else{
                    alert("Please Select Project Name & Parking Location First");
                }
            });

            function generate_parking_number(){
                let i;
                let parkingName;
                let location = $("#location").val();
                let totalParking = $("#total_parking").val() > 0 ? parseInt($("#total_parking").val()) : 0;
                let parkingList = $('#parkingList');
                let level = $("#level").val();
                if(location){
                    if(location == 'Basement'){
                        parkingName = (level && level!=1) ? 'B'+level : 'B';
                    }
                    if(location == 'Ground'){
                        parkingName = 'G';
                    }
                }
                else{

                    $("#total_parking").val(null);
                }
                parkingList.empty();
                for(i = 1; i <= totalParking; i++){
                    parkingList.append(`
                    <div class="col-md-12">
                        <div class="input-group input-group-sm input-group-primary">
                            <label class="input-group-addon" for="parking_name">Parking Name<span class="text-danger">*</span></label>
                            <input type="text" value="${parkingName}-${i}" name="parking_name[]" class="form-control" autocomplete="off" required>
                            <select name="parking_owner[]"  class="form-control" required >
                                <option value="">Select Owner</option>
                                <option value="JumairahProperties">Jumairah Properties Ltd</option>
                                <option value="Landowner">LandOwner</option>
                            </select>
                        </div>
                    </div>
`);
                }
            }

        });
    </script>
@endsection
