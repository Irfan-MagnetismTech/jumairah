@extends('layouts.backend-layout')
@section('title', 'Lead Generation')

@section('breadcrumb-title')
    {{ empty($bd_lead) ? 'New Lead Generation' : 'Edit Lead Generation' }}
@endsection

@section('breadcrumb-button')
    <a href="{{ url('bd_lead') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', null)

@section('content')
<style>

    #image_input::file-selector-button {
      padding-right: 55%!important;
      
    }
    .dtl {
        background-color: rgba(14, 12, 12, 0.3);
        color:rgb(240, 240, 240);
        padding: 0.03% 0.94%;
        z-index: 9999!important;
        position: absolute!important;
        cursor: default;
        }
    
    .dtl:hover {
        background-color: rgba(0, 0, 0);
        }
    
    </style>
    <link rel="stylesheet" href={{ asset("js/image-viewer-smooth-animations/assets/css/master.css") }}>
    {!! Form::open(['url' => empty($bd_lead) ? route('bd_lead.store') : route('bd_lead.update', $bd_lead->id), 'method' => empty($bd_lead) ? 'POST' : 'PUT', 'class' => 'custom-form','encType' =>"multipart/form-data"]) !!}

    <div class="table-responsive">
        <table id="purchaseTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>L/O Name<span class="text-danger">*</span></th>
                    <th>Mobile<span class="text-danger">*</span></th>
                    <th>E-mail</th>
                    <th>Present Address<span class="text-danger">*</span></th>
                    <th><i class="btn btn-primary btn-sm fa fa-plus" id="addItem" onclick="addItemDtl()"> </i></th>
                </tr>
            </thead>
            <tbody>
                @if(old('name'))
                    @foreach(old('name') as $key => $OldData)
                        <tr>
                            <td>
                                <input type="text" name="name[]" value="{{old('name')[$key]}}" class="form-control form-control-sm text-center name" autocomplete="off" placeholder="Owner's Name" required>
                            </td>
                            <td>
                                <input type="text" name="mobile[]" value="{{old('mobile')[$key]}}" class="form-control mobile text-center" autocomplete="off" required>
                            </td>
                            <td>
                                <input type="email" name="mail[]" value="{{old('mail')[$key]}}" class="form-control mail text-center" autocomplete="off" placeholder="example@gmail.com">
                            </td>
                            <td>
                                <input type="text" name="present_address[]" value="{{old('present_address')[$key]}}" class="form-control present_address text-center" autocomplete="off" placeholder="Present Address" required>
                            </td>
                            <td class="text-center">
                                <button class="btn btn-danger btn-sm deleteItem" onclick="removQRow(this)" type="button">
                                    <i class="fa fa-minus"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                @else
                    @if(!empty($bd_lead))
                        @foreach($bd_lead->BdLeadGenerationDetails as $data)
                            <tr>
                                <td>
                                    <input type="text" name="name[]" value="{{ $data->name }}" class="form-control form-control-sm text-center name" placeholder="Owner's Name" autocomplete="off" required>
                                </td>
                                <td>
                                    <input type="text" name="mobile[]" value="{{ $data->mobile }}" class="form-control mobile text-center" autocomplete="off" required>
                                </td>
                                <td>
                                    <input type="email" name="mail[]" value="{{ $data->mail }}" class="form-control mail text-center" autocomplete="off" placeholder="example@gmail.com">
                                </td>
                                <td>
                                    <input type="text" name="present_address[]" value="{{ $data->present_address }}" class="form-control present_address text-center" autocomplete="off" placeholder="Present Address" required>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-danger btn-sm deleteItem" onclick="removQRow(this)" type="button">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                @endif

            </tbody>
        </table>
    </div>


    <div class="row">
        <div class="col-xl-4 col-md-4">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="category">Project Type<span class="text-danger">*</span></label>
                {{Form::select('category', $category, old('category') ? old('category') : (!empty($bd_lead->category) ? $bd_lead->category : null), ['class' => 'form-control','id' => 'category', 'placeholder' => 'Select Project Type','required'])}}

            </div>
        </div>
        <div class="col-md-4">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="land_under">Land Category<span class="text-danger">*</span></label>
                {{ Form::select('land_under', $land_under, old('land_under') ? old('land_under') :(!empty($bd_lead->land_under) ? $bd_lead->land_under : null), ['class' => 'form-control', 'id' => 'land_under', 'placeholder' => 'Select Land Category', 'autocomplete' => 'off', 'required']) }}
                
            </div>
        </div>
        <div class="col-md-4">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="lead_stage">Lead Stage<span class="text-danger">*</span></label>
                {{ Form::select('lead_stage', $lead_stage, old('lead_stage') ? old('lead_stage') :(!empty($bd_lead->lead_stage) ? $bd_lead->lead_stage : null), ['class' => 'form-control', 'id' => 'lead_stage', 'placeholder' => 'Select Lead Stage', 'autocomplete' => 'off', 'required']) }}
                
            </div>
        </div>
        <div class="col-xl-4 col-md-4">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="category">Project Category<span class="text-danger">*</span></label>
                {{Form::select('project_category', $project_category, old('project_category') ? old('project_category') : (!empty($bd_lead->project_category) ? $bd_lead->project_category : null), ['class' => 'form-control','id' => 'project_category', 'placeholder' => 'Select Project Category','required'])}}

            </div>
        </div>

        <div class="col-xl-4 col-md-4">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="land_status">Land Status<span class="text-danger">*</span></label>
                {{Form::text('land_status', old('land_status') ? old('land_status') : (!empty($bd_lead->land_status) ? $bd_lead->land_status : null), ['class' => 'form-control','id' => 'land_status', 'placeholder' => 'Type Land Status','required'])}}
            </div>
        </div>

        <div class="col-xl-4 col-md-4">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="source_id">Source<span class="text-danger">*</span></label>
                {{Form::select('source_id', $source, old('source_id') ? old('source_id') : (!empty($bd_lead->source_id) ? $bd_lead->source_id : null), ['class' => 'form-control','id' => 'project_category', 'placeholder' => 'Select Source'
                
                
                ])}}
                {{-- {{ Form::text('source_name', old('source_name') ? old('source_name') :(!empty($bd_lead->source->name) ? $bd_lead->source->name : null), ['class' => 'form-control', 'id' => 'source_name', 'placeholder' => 'Search Source', 'autocomplete' => 'off', 'required']) }}
                {{ Form::hidden('source_id', old('source_id') ? old('source_id') :(!empty($bd_lead->source_id) ? $bd_lead->source_id : null), ['class' => 'form-control', 'id' => 'source_id', 'placeholder' => 'Select Source', 'autocomplete' => 'off', 'required']) }} --}}
                
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-8">
            

            <div class="row">
                <div class="col-md-4">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="land_location"> Division<span class="text-danger">*</span></label>
                        {{ Form::select('division_id',$divisions, old('division_id', $bd_lead->division_id ?? null), ['class' => 'form-control', 'id' => 'division_id', 'rows' => 2, 'autocomplete' => 'off', 'required','placeholder'=>'Select Division']) }}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="land_location"> District<span class="text-danger">*</span></label>
                        {{ Form::select('district_id',$districts, old('district_id', $bd_lead->district_id ?? null), ['class' => 'form-control', 'id' => 'district_id', 'rows' => 2, 'autocomplete' => 'off', 'required','placeholder'=>'Select District']) }}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="land_location"> Thana<span class="text-danger">*</span></label>
                        {{ Form::select('thana_id',$thanas, old('thana_id', $bd_lead->thana_id ?? null), ['class' => 'form-control', 'id' => 'thana_id', 'rows' => 2, 'autocomplete' => 'off', 'required','placeholder'=>'Select Thana']) }}
                    </div>
                </div>
        
                <div class="col-md-4">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="mouja">Mouza</label>
                        {{ Form::select('mouza_id',$mouzas, old('mouza_id') ? old('mouza_id') : (!empty($bd_lead->mouza_id) ? $bd_lead->mouza_id : null), ['class' => 'form-control', 'id' => 'mouza_id', 'rows' => 2, 'autocomplete' => 'off', 'placeholder'=>'Select Mouza']) }}
                    </div>
                </div>
                
                
               
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="land_size"> Land Size (katha) <span class="text-danger">*</span></label>
                        {{ Form::text('land_size', old('land_size', $bd_lead->land_size ?? null), ['class' => 'form-control land_size', 'id' => 'land_size', 'required', 'autocomplete' => 'off']) }}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="front_road_size"> Front Road (feet) <span class="text-danger">*</span></label>
                        {{ Form::text('front_road_size', old('front_road_size', $bd_lead->front_road_size ?? null), ['class' => 'form-control front_road_size', 'id' => 'front_road_size', 'autocomplete' => 'off']) }}
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="front_road_size"> Storey<span class="text-danger">*</span></label>
                        {{ Form::text('storey', old('storey', $bd_lead->storey ?? null), ['class' => 'form-control storey', 'id' => 'storey', 'autocomplete' => 'off']) }}
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="basement"> Basement<span class="text-danger">*</span></label>
                        {{ Form::text('basement', old('basement', $bd_lead->basement ?? null), ['class' => 'form-control front_road_size', 'id' => 'basement', 'required', 'autocomplete' => 'off']) }}
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="land_location"> Land Location<span class="text-danger">*</span></label>
                        {{ Form::textarea('land_location', old('land_location', $bd_lead->land_location ?? null), ['class' => 'form-control', 'id' => 'land_location', 'rows' => 2, 'autocomplete' => 'off', 'required']) }}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="remarks"> Remarks</label>
                        {{ Form::textarea('remarks', old('remarks', $bd_lead->remarks ?? null), ['class' => 'form-control', 'id' => 'remarks', 'rows' => 2, 'autocomplete' => 'off']) }}
                    </div>
                </div>
                {{-- <div class="col-md-4">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="side_road_size"> Side Road (feet)</label>
                        {{ Form::text('side_road_size', old('side_road_size', $bd_lead->side_road_size ?? null), ['class' => 'form-control side_road_size', 'id' => 'side_road_size', 'autocomplete' => 'off']) }}
                    </div>
                </div> --}}
            </div>
        </div>
        <div class="col-4">
            <fieldset class="form form-control form-group">
                <legend>Side Road:</legend>
            
            <div class="table-responsive">
                <table id="sideRoadTable" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>#SL</th>
                            <th>Road Size (Feet)</th>
                            <th><i class="btn btn-primary btn-sm fa fa-plus" id="addItem" onclick="addRoadDtl()"> </i></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(old('side_road_size'))
                            @foreach(old('side_road_size') as $key => $OldData)
                                <tr>
                                    <td class="text-center">
                                        <span class="side_road_index">#{{$key + 1}}</span>
                                    </td>
                                    <td>
                                        <input type="text" name="side_road_size[]" value="{{old('side_road_size')[$key]}}" class="form-control mobile text-center" autocomplete="off">
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-danger btn-sm deleteItem" onclick="removRoadRow(this)" type="button">
                                            <i class="fa fa-minus"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            @if(!empty($bd_lead))
                                @foreach($bd_lead->BdLeadGenerationSideRoads as $key => $data)
                                    <tr>
                                        <td class="text-center">
                                            <span class="side_road_index">#{{$key + 1}}</span>
                                        </td>
                                        <td>
                                            <input type="text" name="side_road_size[]" value="{{ $data->feet }}" class="form-control mobile text-center" autocomplete="off">
                                        </td>
                                        <td class="text-center">
                                            <button class="btn btn-danger btn-sm deleteItem" onclick="removRoadRow(this)" type="button">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        @endif
        
                    </tbody>
                </table>
            </div>
        </fieldset>
        </div>
    </div>
    



    {{-- <div class="row">
        
        <div class="col-md-4">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="surrendered_land"><span>Surrendered Land<span class="text-danger">*</span><br/>(feet)</span></label>
                {{ Form::text('surrendered_land', old('surrendered_land', $bd_lead->surrendered_land ?? null), ['class' => 'form-control surrendered_land', 'id' => 'surrendered_land', 'required', 'autocomplete' => 'off']) }}
            </div>
        </div>
        <div class="col-md-4">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="proposed_front_road_size"> <span>Front Road (feet) <span class="text-danger">*</span><br/> [ Proposed ]</span></label>
                {{ Form::text('proposed_front_road_size', old('proposed_front_road_size', $bd_lead->proposed_front_road_size ?? null), ['class' => 'form-control proposed_front_road_size', 'id' => 'proposed_front_road_size', 'required', 'autocomplete' => 'off']) }}
            </div>
        </div>
        <div class="col-md-4">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="proposed_side_road_size"> <span>Side Road (feet) <span class="text-danger">*</span><br/> [ Proposed ]</span></label>
                {{ Form::text('proposed_side_road_size', old('proposed_side_road_size', $bd_lead->proposed_side_road_size ?? null), ['class' => 'form-control proposed_side_road_size', 'id' => 'proposed_side_road_size', 'autocomplete' => 'off']) }}
            </div>
        </div>
    </div> --}}
    
   

    <div class="row" id="picture_div">
        <div class="col-md-3">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="survey_report"> Survey Report</label>
                {{ Form::file('survey_report',['class' => 'form-control', 'accept' => '.png, .jpg, .jpeg, .pdf','id' => '',"onchange"=>"document.getElementById('survey').src = window.URL.createObjectURL(this.files[0])"]) }}
            </div>
        </div>
        <div class="col-md-1">
            <div class="images">
                @if ($formType=='edit' && $bd_lead != null && !empty($bd_lead->survey_report))
                    <img src="{{ asset("storage/{$bd_lead->survey_report}") }}" id="survey" width="40px" height="40px" alt="Survey Report">
                @else
                    <img id="survey" width="40px" height="40px" alt="" />
                @endif
            </div>
        </div>
        <div class="row col-12">
            <div class="col-md-4">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="picture"> Attachment</label>
                    <i class="btn btn-primary btn-sm fa fa-plus ml-2" id="addItem" title="add attachment photo" data-toggle="tooltip" onclick="addPhotoAttachment()"> </i>
                </div>
            </div>
           
            <div class="col-md-12">
                <fieldset class="form form-control form-group">
                    <legend>Attachment:</legend>

                    @if ($formType=='edit' && $bd_lead != null && !empty($bd_lead->BdLeadGenerationPictures[0]->picture))
                        <div class="row" id="attachment_photo_div">
                            @foreach ($bd_lead->BdLeadGenerationPictures as $kk => $item)
                            <div class="row col-4             ">
                                <div class="col-6 attachment">
                                    {{Form::file('picture[]', ['class' => 'form-control', 'accept' => '.png, .jpg, .jpeg, .pdf', "onchange"=>"previewAttachmentImages(this)" ])}}
                                </div>
                                <div class="col-6 images">
                                    <span class="dtl" style="" onclick="deleteAttachmentImages(this)">x</span>
                                    <img class="img" width="40px" height="40px" alt="" src="{{ asset("storage/{$item->picture}") }}"/>
                                    <input type="hidden" name="imgname[]" class="imgname" value="{{ $item->picture }}">
                                </div>

                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="row" id="attachment_photo_div">

                        </div>
                    @endif
                    <div class="mt-2">
                        <i class="btn btn-primary btn-sm fa fa-plus ml-2" id="addItem" title="add attachment photo" data-toggle="tooltip" onclick="addPhotoAttachment()"> </i>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>
    <!-- div to show preview image -->
        <div id="image-viewer" style="z-index: 9999">
            <span class="close">&times;</span>
            <img class="modal-content" id="full-image">
        </div>
    <!-- div to show preview image -->
    <div class="row">
        <div class="offset-md-4 col-md-4 mt-2">
            <div class="input-group input-group-sm">
                <button class="btn btn-success btn-round btn-block py-2">Submit</button>
            </div>
        </div>
    </div>

    {!! Form::close() !!}
@endsection

@section('script')
    <script>
        const material_row_data = @json(old('material_id', []));
        intialize_photo_preview();
        const CSRF_TOKEN = "{{ csrf_token() }}";
        var road_no = 1;

        // Function for adding new material row
        function addItemDtl() {
            var Row = `
            <tr>
                <td>
                    <input type="text" name="name[]" value="" class="form-control form-control-sm text-center name" placeholder="Owner's Name" autocomplete="off" required>
                </td>
                <td>
                    <input type="text" name="mobile[]" value="" class="form-control mobile text-center" autocomplete="off" required>
                </td>
                <td>
                    <input type="mail" name="mail[]" value="" class="form-control mail text-center" placeholder="example@gmail.com" autocomplete="off">
                </td>
                <td>
                    <input type="text" name="present_address[]" value="" class="form-control present_address text-center" placeholder="Present Address" autocomplete="off" required>
                </td>
                <td class="text-center">
                    <button class="btn btn-danger btn-sm deleteItem" onclick="removQRow(this)" type="button">
                        <i class="fa fa-minus"></i>
                    </button>
                </td>
            </tr>
            `;
            var tableItem = $('#purchaseTable').append(Row);
        }


         // Function for adding new material row
         function addRoadDtl() {
            var rowIndex = $('table#sideRoadTable tr:last').prop('rowIndex')+1;
            var Row = `
            <tr>
                <td class="text-center">
                    <span class="side_road_index">#${rowIndex}</span>
                </td>
                <td>
                    <input type="text" name="side_road_size[]" value="" class="form-control side_road_size text-center" autocomplete="off">
                </td>
                <td class="text-center">
                    <button class="btn btn-danger btn-sm deleteItem" onclick="removRoadRow(this)" type="button">
                        <i class="fa fa-minus"></i>
                    </button>
                </td>
            </tr>
            `;
            var tableItem = $('#sideRoadTable').append(Row);
        }
        
        function loadDistrict(){
            let dropdown = $('#district_id');
            dropdown.empty();
            dropdown.append('<option selected="true" disabled>Select District </option>');
            dropdown.prop('selectedIndex', 0);
            const url = '{{url("getDistrict")}}/' + $("#division_id").val();
            // Populate dropdown with list of provinces
            $.getJSON(url, function (sells) {
                $.each(sells, function (key, sell) {
                    dropdown.append($('<option></option>').attr('value', sell.id).text(`${sell.sell_client.client.name} [Apartment : ${sell.apartment.name}]`));
                });
            });
        }

        function addPhotoAttachment(){
            let photo_div_attachment = `
                <div class="row col-4">
                    <div class="col-6 attachment">
                        {{Form::file('picture[]', ['class' => 'form-control', 'accept' => '.png, .jpg, .jpeg,.pdf', "onchange"=>"previewAttachmentImages(this)"])}}
                    </div>
                    <div class="col-6 images">
                        <span class="dtl" style="" onclick="deleteAttachmentImages(this)">x</span>
                        <img class="img" width="40px" height="40px" alt="" />
                        <input class="imgname" type="hidden" name="imgname[]">
                    </div>
                </div>
            `;   
            $('#attachment_photo_div').append(photo_div_attachment);   
            intialize_photo_preview();       
        }

        // Function for deleting a row
        function removQRow(qval) {
            var rowIndex = qval.parentNode.parentNode.rowIndex;
            document.getElementById("purchaseTable").deleteRow(rowIndex); 
        }

        function roadIndex(){
            $('.side_road_index').each(function(index){
                $(this).closest('tr').find('.side_road_index').text('#'+(index+1));
            })   
        }

        function removRoadRow(qval) {
            var rowIndex = qval.parentNode.parentNode.rowIndex;
            document.getElementById("sideRoadTable").deleteRow(rowIndex); 
            roadIndex();
        }

        
        function deleteAttachmentImages(selected_div){
            $(selected_div).parent('div').parent('div').remove();
            intialize_photo_preview()
        }
      function previewAttachmentImages(selected_div){
        let selectedImages = window.URL.createObjectURL(selected_div.files[0]);
        $(selected_div).parent('div').next('div').find('.img').attr('src',selectedImages);
        $(selected_div).parent('div').next('div').find('.imgname').val(selected_div.files[0].name);
      }
      function intialize_photo_preview(){
            $(".images img").click(function(){
            $("#full-image").attr("src", null);
            $("#full-image").attr("src", $(this).attr("src"));
            $('#image-viewer').show();
            });

            $("#image-viewer .close").click(function(){
            $('#image-viewer').hide();
            });
      }

        $(function() {
            @if ($formType == 'create') ; 
             addPhotoAttachment();
             addItemDtl();
             addRoadDtl();
            @elseif($formType == 'edit')
                    // @foreach ($bd_lead->BdLeadGenerationPictures as $kk => $item)
                    // var edtfiles = '{{ asset("storage/{$item->picture}") }}';
                    // selectedImages = [...edtfiles];
                    // @endforeach
                    // inputImage.value = selectedImages;
            @endif
            $('#source_name').on('keyup',function () {
                let accountId = '';
                $(this).autocomplete({
                    source: function( request, response ) {
                        $.ajax({
                            url:"{{route('bd.sourceAutoSuggest')}}",
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
                        $('#source_id').val(ui.item.value);
                        return false;
                    }

                });

            });
        //     function loadDistrict() {
        //     let dropdown = $('#district_id');
        //     dropdown.empty();
        //     dropdown.append('<option selected="true" disabled>Select District </option>');
        //     dropdown.prop('selectedIndex', 0);
            
        //     // Populate dropdown with list of provinces
        //     $.getJSON(url, function (district) {
        //         $.each(district, function (key, entry) {
        //             dropdown.append($('<option></option>').attr('value', entry.id).text(entry.name));
        //         })
        //     });
        // }
            $('#division_id').on('change',function () {
                let division_id = $(this).val();
                const url = '{{url("getDistricts")}}/' + division_id;
                let dropdown = $('#district_id');
                dropdown.empty();
                dropdown.append('<option selected="true" disabled>Select District </option>');
                dropdown.prop('selectedIndex', 0)
                        $.ajax({
                            url: url,
                            type: 'get',
                            dataType: "json",
                            data: {
                                _token: CSRF_TOKEN,
                                division_id
                            },
                            success: function( districts ) {
                                $.each(districts, function (key, district) {
                                dropdown.append($('<option></option>').attr('value', district.id).text(district.name));
                                })
                            }
                        });

            });

            $('#district_id').on('change',function () {
                let district_id = $(this).val();
                const url = '{{url("getThanas")}}/' + district_id;
                let dropdown = $('#thana_id');
                dropdown.empty();
                dropdown.append('<option selected="true" disabled>Select Thana </option>');
                dropdown.prop('selectedIndex', 0)
                        $.ajax({
                            url: url,
                            type: 'get',
                            dataType: "json",
                            data: {
                                _token: CSRF_TOKEN,
                                district_id
                            },
                            success: function( thanas ) {
                                $.each(thanas, function (key, thana) {
                                dropdown.append($('<option></option>').attr('value', thana.id).text(thana.name));
                                })
                            }
                        });

            });


            $('#thana_id').on('change',function () {
                let thana_id = $(this).val();
                const url = '{{url("getMouzas")}}/' + thana_id;
                let dropdown = $('#mouza_id');
                dropdown.empty();
                dropdown.append('<option selected="true" disabled>Select Mouza </option>');
                dropdown.prop('selectedIndex', 0)
                        $.ajax({
                            url: url,
                            type: 'get',
                            dataType: "json",
                            data: {
                                _token: CSRF_TOKEN,
                                thana_id
                            },
                            success: function( mouzas ) {
                                $.each(mouzas, function (key, mouza) {
                                dropdown.append($('<option></option>').attr('value', mouza.id).text(mouza.name));
                                })
                            }
                        });

            });



        }) // Document.Ready

     

        $(function() { 
            document.addEventListener("keydown", function(event) {
                if (event.key === "Enter") {
                    event.preventDefault();
                }
            });
            
        }) // Document.Ready
    </script>
    
@endsection
