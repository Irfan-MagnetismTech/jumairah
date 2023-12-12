@extends('layouts.backend-layout')
@section('title', 'Apartments')

@section('breadcrumb-title')
    @if($formType == 'edit')
        Edit Inventory
    @else
        Add New Inventory
    @endif
@endsection

@section('breadcrumb-button')
    <a href="{{ url('apartments') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', null)

@section('content')

    @if($formType == 'edit')
        {!! Form::open(array('url' => "apartments/$apartment->id",'encType' =>"multipart/form-data", 'method' => 'PUT', 'class'=>'custom-form')) !!}
        <input type="hidden" value="{{$apartment->id}}" name="id">
    @else
        {!! Form::open(array('url' => "apartments",'method' => 'POST','encType' =>"multipart/form-data", 'class'=>'custom-form')) !!}
    @endif
    <div class="row">
        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="project_name">Project Name<span class="text-danger">*</span></label>
                {{Form::text('project_name', old('project_name') ? old('project_name') : (!empty($apartment->project->name) ? $apartment->project->name : null),['class' => 'form-control','id' => 'project_name', 'autocomplete'=>"off"])}}
                {{Form::hidden('project_id', old('project_id') ? old('project_id') : (!empty($apartment->project->id) ? $apartment->project->id: null),['class' => 'form-control','id' => 'project_id', 'autocomplete'=>"off",'required'])}}
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="type_composite_key">Type<span class="text-danger">*</span></label>
                {{Form::select('type_composite_key',$types,old('type_composite_key') ? old('type_composite_key') : (!empty($apartment->type_composite_key) ? $apartment->type_composite_key: null),['class' => 'form-control','id' => 'type_composite_key', 'autocomplete'=>"off",'required'])}}
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="floor">Floor<span class="text-danger">*</span></label>
                {{Form::number('floor', old('floor') ? old('floor') : (!empty($apartment->floor) ? $apartment->floor : null),['class' => 'form-control', 'id' => 'floor', 'min'=>'0', 'placeholder' => '0', 'autocomplete'=>"off",'required'] )}}
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="name">Apartment ID<span class="text-danger">*</span></label>
                {{Form::text('name', old('name') ? old('name') : (!empty($apartment->name) ? $apartment->name : null),['class' => 'form-control','id' => 'name', 'autocomplete'=>"off",'required'])}}
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="face">Apartment Type<span class="text-danger">*</span></label>
                {{Form::select('apartment_type', $apartmentType, old('apartment_type') ? old('apartment_type') : (!empty($apartment->apartment_type) ? $apartment->apartment_type : null),['class' => 'form-control', 'id' => 'type', 'autocomplete'=>"off", 'placeholder'=>'Select Type','required'] )}}
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="face">Face<span class="text-danger">*</span></label>
                {{Form::select('face', $faces, old('face') ? old('face') : (!empty($apartment->face) ? $apartment->face : null),['class' => 'form-control', 'id' => 'face', 'autocomplete'=>"off", 'placeholder'=>'Select Face','required'] )}}
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="owner">Owner<span class="text-danger">*</span></label>
                {{Form::select('owner', [1=>'Jumairah Holdings Ltd' , 2=>'Land Owner'], old('owner') ? old('owner') : (!empty($apartment->owner) ? $apartment->owner : null),['class' => 'form-control', 'id' => 'owner', 'autocomplete'=>"off", 'placeholder'=>'Select Owner','required'] )}}
            </div>
        </div>
    </div> <!-- row -->
    <hr class="bg-success">
    <div class="row">
        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="apartment_size">Apartment Size <span class="text-danger">*</span></label>
                {{Form::number('apartment_size', old('apartment_size') ? old('apartment_size') : (!empty($apartment->apartment_size) ? $apartment->apartment_size : null),['class' => 'form-control', 'id' => 'apartment_size', 'min'=>'0', 'step'=>'0.01', 'placeholder' => '0', 'autocomplete'=>"off",'required'] )}}
            </div>
        </div>
        <div class="col-xl-4 col-md-6 {{!empty($apartment) && $apartment->owner  == 2 ? "d-none" : null}}" id="apartment_rate_area">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="apartment_rate">Rate (Per SFT) <span class="text-danger">*</span></label>
                {{Form::number('apartment_rate', old('apartment_rate') ? old('apartment_rate') : (!empty($apartment->apartment_rate) ? $apartment->apartment_rate : null),['class' => 'form-control', 'id' => 'apartment_rate', 'min'=>'0', 'step'=>'0.01', 'placeholder' => '0', 'autocomplete'=>"off"] )}}
            </div>
        </div>
        <div class="col-xl-4 col-md-6 {{!empty($apartment) && $apartment->owner  == 2 ? "d-none" : null}}" id="apartment_value_area">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="apartment_value">Apartment Value <span class="text-danger">*</span></label>
                {{Form::number('apartment_value', old('apartment_value') ? old('apartment_value') : (!empty($apartment->apartment_value) ? $apartment->apartment_value : null),['class' => 'form-control total_price', 'id' => 'apartment_value', 'min'=>'0', 'step'=>'0.01', 'placeholder' => '0', 'autocomplete'=>"off", 'readonly','tabindex'=>'-1'] )}}
            </div>
        </div>
        <div class="col-xl-4 col-md-6 {{!empty($apartment) && $apartment->owner  == 2 ? "d-none" : null}}" id="parking_no_area">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="parking_no">Parking No <span class="text-danger">*</span></label>
                {{Form::number('parking_no', old('parking_no') ? old('parking_no') : (!empty($apartment->parking_no) ? $apartment->parking_no : null),['class' => 'form-control', 'id' => 'parking_no', 'min'=>'0', 'step'=>'1', 'placeholder' => '0', 'autocomplete'=>"off"] )}}
            </div>
        </div>
        <div class="col-xl-4 col-md-6 {{!empty($apartment) && $apartment->owner  == 2 ? "d-none" : null}}" id="parking_rate_area">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="parking_rate">Parking Rate <span class="text-danger">*</span></label>
                {{Form::number('parking_rate', old('parking_rate') ? old('parking_rate') : (!empty($apartment->parking_rate) ? $apartment->parking_rate : null),['class' => 'form-control', 'id' => 'parking_rate', 'min'=>'0', 'step'=>'0.01', 'placeholder' => '0', 'autocomplete'=>"off"] )}}
            </div>
        </div>
        <div class="col-xl-4 col-md-6 {{!empty($apartment) && $apartment->owner  == 2 ? "d-none" : null}}" id="parking_price_area">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="parking_price">Price of Parking <span class="text-danger">*</span></label>
                {{Form::number('parking_price', old('parking_price') ? old('parking_price') : (!empty($apartment->parking_price) ? $apartment->parking_price : null),['class' => 'form-control total_price', 'id' => 'parking_price', 'min'=>'0', 'step'=>'0.01', 'placeholder' => '0', 'autocomplete'=>"off", 'readonly','tabindex'=>'-1'] )}}
            </div>
        </div>
        <div class="col-xl-4 col-md-6 {{!empty($apartment) && $apartment->owner  == 2 ? "d-none" : null}}" id="utility_no_area">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="utility_no">Utility No <span class="text-danger">*</span></label>
                {{Form::number('utility_no', old('utility_no') ? old('utility_no') : (!empty($apartment->utility_no) ? $apartment->utility_no : null),['class' => 'form-control', 'id' => 'utility_no', 'min'=>'0', 'step'=>'1', 'placeholder' => '0', 'autocomplete'=>"off"] )}}
            </div>
        </div>
        <div class="col-xl-4 col-md-6 {{!empty($apartment) && $apartment->owner  == 2 ? "d-none" : null}}" id="utility_price_area">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="utility_rate">Utility Rate <span class="text-danger">*</span></label>
                {{Form::number('utility_rate', old('utility_rate') ? old('utility_rate') : (!empty($apartment->utility_rate) ? $apartment->utility_rate : null),['class' => 'form-control', 'id' => 'utility_rate', 'min'=>'0', 'step'=>'0.01', 'placeholder' => '0', 'autocomplete'=>"off"] )}}
            </div>
        </div>
        <div class="col-xl-4 col-md-6 {{!empty($apartment) && $apartment->owner  == 2 ? "d-none" : null}}" id="utility_fees_area">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="utility_fees">Utility Fees<span class="text-danger">*</span></label>
                {{Form::number('utility_fees', old('utility_fees') ? old('utility_fees') : (!empty($apartment->utility_fees) ? $apartment->utility_fees : null),['class' => 'form-control total_price', 'id' => 'utility_fees', 'min'=>'0', 'step'=>'0.01', 'placeholder' => '0', 'autocomplete'=>"off", 'readonly','tabindex'=>'-1'] )}}
            </div>
        </div>
        <div class="col-xl-4 col-md-6 {{!empty($apartment) && $apartment->owner  == 2 ? "d-none" : null}}" id="reserve_no_area">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="reserve_no">Reserve No <span class="text-danger">*</span></label>
                {{Form::number('reserve_no', old('reserve_no') ? old('reserve_no') : (!empty($apartment->reserve_no) ? $apartment->reserve_no : null),['class' => 'form-control', 'id' => 'reserve_no', 'min'=>'0', 'step'=>'1', 'placeholder' => '0', 'autocomplete'=>"off"] )}}
            </div>
        </div>
        <div class="col-xl-4 col-md-6 {{!empty($apartment) && $apartment->owner  == 2 ? "d-none" : null}}" id="reserve_rate_area">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="reserve_rate">Reserve Rate <span class="text-danger">*</span></label>
                {{Form::number('reserve_rate', old('reserve_rate') ? old('reserve_rate') : (!empty($apartment->reserve_rate) ? $apartment->reserve_rate : null),['class' => 'form-control', 'id' => 'reserve_rate', 'min'=>'0', 'step'=>'0.01', 'placeholder' => '0', 'autocomplete'=>"off"] )}}
            </div>
        </div>
        <div class="col-xl-4 col-md-6 {{!empty($apartment) && $apartment->owner  == 2 ? "d-none" : null}}" id="reserve_fund_area">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="reserve_fund">Reserve Fund <span class="text-danger">*</span></label>
                {{Form::number('reserve_fund', old('reserve_fund') ? old('reserve_fund') : (!empty($apartment->reserve_fund) ? $apartment->reserve_fund : null),['class' => 'form-control total_price', 'id' => 'reserve_fund', 'min'=>'0', 'step'=>'0.01', 'placeholder' => '0', 'autocomplete'=>"off", 'readonly','tabindex'=>'-1'] )}}
            </div>
        </div>
        <div class="col-xl-4 col-md-6 {{!empty($apartment) && $apartment->owner  == 2 ? "d-none" : null}}" id="others_area">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="others">Others<span class="text-danger">*</span></label>
                {{Form::number('others', old('others') ? old('others') : (!empty($apartment->others) ? $apartment->others : null),['class' => 'form-control total_price', 'id' => 'others', 'min'=>'0', 'step'=>'0.01', 'placeholder' => '0', 'autocomplete'=>"off"] )}}
            </div>
        </div>
        <div class="col-xl-4 col-md-6 {{!empty($apartment) && $apartment->owner  == 2 ? "d-none" : null}}" id="total_value_area">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="total_value">Total Apartment<br>Value <span class="text-danger">*</span></label>
                {{Form::number('total_value', old('total_value') ? old('total_value') : (!empty($apartment->total_value) ? $apartment->total_value : null),['class' => 'form-control', 'id' => 'total_value', 'min'=>'0', 'step'=>'0.01', 'placeholder' => '0', 'autocomplete'=>"off", 'readonly','tabindex'=>'-1'] )}}
            </div>
        </div>
    </div><!-- end row -->

    <div class="row">
        <div class="offset-md-4 col-xl-4 col-md-6 mt-2">
            <div class="input-group input-group-sm ">
                <button class="btn btn-success btn-round btn-block py-2">Submit</button>
            </div>
        </div>
    </div> <!-- end row -->

    {!! Form::close() !!}

@endsection
@section('script')
    <script>
        function loadProjectTypes(){
            let dropdown = $('#type_composite_key');
            let oldSelectedItem = "{{old('type_composite_key') ? old('type_composite_key') : null}}";
            dropdown.empty();
            dropdown.append('<option selected="true" disabled>Select Type </option>');
            dropdown.prop('selectedIndex', 0);
            const url = '{{url("loadProjectTypes")}}/' + $("#project_id").val();
            // Populate dropdown with list of provinces
            $.getJSON(url, function (items) {
                $.each(items, function (key, entry) {
                    let select=(oldSelectedItem == entry.composite_key) ? "selected" : null;
                    dropdown.append(
                        $(`<option ${select}></option>`)
                        .attr('value', entry.composite_key).text(entry.type_name));
                })
            });
        }


        function grand_total_price(){
            let total_value=0;
            $(".total_price").each(function(){
                let currentValue = $(this).val() > 0 ? parseFloat($(this).val()) : 0;
                total_value +=parseFloat(currentValue);
            });
            $('#total_value').val((total_value).toFixed(2));
        }

        function calculateApartmentValue(){
            let size = $("#apartment_size").val() > 0 ? parseFloat($("#apartment_size").val()) : 0;
            let rate = $("#apartment_rate").val() > 0 ? parseFloat($("#apartment_rate").val()) : 0;
            let total = (size * rate).toFixed(2);
            $("#apartment_value").val(total);
            grand_total_price();
        }

        function calculateParkingPrice(){
            let size = $("#parking_no").val() > 0 ? parseFloat($("#parking_no").val()) : 0;
            let rate = $("#parking_rate").val() > 0 ? parseFloat($("#parking_rate").val()) : 0;
            let total = (size * rate).toFixed(2);
            $("#parking_price").val(total);
            grand_total_price();
        }

        function calculateUtilityFees(){
            let size = $("#utility_no").val() > 0 ? parseFloat($("#utility_no").val()) : 0;
            let rate = $("#utility_rate").val() > 0 ? parseFloat($("#utility_rate").val()) : 0;
            let total = (size * rate).toFixed(2);
            $("#utility_fees").val(total);
            grand_total_price();
        }

        function calculateReserveFund(){
            let size = $("#reserve_no").val() > 0 ? parseFloat($("#reserve_no").val()) : 0;
            let rate = $("#reserve_rate").val() > 0 ? parseFloat($("#reserve_rate").val()) : 0;
            let total = (size * rate).toFixed(2);
            $("#reserve_fund").val(total);
            grand_total_price();
        }

        function calculateInstallment(){
            let total_value = $("#total_value").val() > 0 ? parseFloat($("#total_value").val()) : 0;
            let booking_money = $("#booking_money").val() > 0 ? parseFloat($("#booking_money").val()) : 0;
            let downpayment = $("#downpayment").val() > 0 ? parseFloat($("#downpayment").val()) : 0 ;
            $("#installment").val( total_value - (booking_money + downpayment));
        };


        var CSRF_TOKEN = "{{csrf_token()}}";
        $(function(){
            @if(old())
            loadProjectTypes();
            @endif

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
                loadProjectTypes();
            });

            $("#size, #rate").on('change keyup', function(){
                calculateAmount();
                calculateInstallment();
            });

            $(document).on('change keyup', '#apartment_size, #apartment_rate', function(){
                calculateApartmentValue();
                calculateInstallment();
            });

            $(document).on('change keyup', '#parking_no, #parking_rate', function(){
                calculateParkingPrice();
                calculateInstallment();
            });

            $(document).on('change keyup', '#utility_no, #utility_rate', function(){
                calculateUtilityFees();
                calculateInstallment();
            });

            $(document).on('change keyup', '#reserve_no, #reserve_rate', function(){
                calculateReserveFund();
                calculateInstallment();
            });

            $(document).on('change keyup', '#others', function(){
                grand_total_price();
                calculateInstallment();
            });

            $(document).on('change keyup', '#booking_money, #downpayment, #installment', function(){
                grand_total_price();
                calculateInstallment();
            });

            $("#owner").on('change', function(){
                let owner = $(this).val();
                if(owner == 2){
                    $("#apartment_size_area,#apartment_rate_area,#apartment_value_area,#parking_no_area,#parking_rate_area,#parking_price_area,#utility_no_area,#utility_price_area,#utility_fees_area,#reserve_no_area,#reserve_rate_area,#reserve_fund_area,#others_area,#total_value_area").addClass('d-none');
                    $("#apartment_rate,#apartment_value,#parking_no,#parking_rate,#parking_price,#utility_no,#utility_rate,#utility_fees,#reserve_no,#reserve_rate,#reserve_fund,#others,#total_value").removeAttr('required').val(null);
                }else{
                    $("#apartment_size_area,#apartment_rate_area,#apartment_value_area,#parking_no_area,#parking_rate_area,#parking_price_area,#utility_no_area,#utility_price_area,#utility_fees_area,#reserve_no_area,#reserve_rate_area,#reserve_fund_area,#others_area,#total_value_area").removeClass('d-none');
                    $("#apartment_rate,#apartment_value,#parking_no,#parking_rate,#parking_price,#utility_no,#utility_rate,#utility_fees,#reserve_no,#reserve_rate,#reserve_fund,#others,#total_value").prop('required', true);
                }

            });

        });

        $("#type_composite_key,#floor").on('change keyup', function(){
            generateApartmentId();
        });
        function generateApartmentId(){
            if($("#floor").val() && $("#type_composite_key").val()){
                $("#name").val($("#type_composite_key option:selected").text()+'-' +$("#floor").val());
            }else{
                $("#name").val(null);
            }
        }

    </script>
@endsection
