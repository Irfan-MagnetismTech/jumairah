@extends('layouts.backend-layout')
@section('title', 'apartment-shifting')

@section('breadcrumb-title')
    @if(!empty($nameTransfer))
        Edit Apartment Shifting
    @else
        New Apartment Shifting
    @endif
@endsection

@section('breadcrumb-button')
    <a href="{{ url('name-transfers') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid',null)

@section('content')

    @if(!empty($nameTransfer))
        {!! Form::open(array('url' => "apartment-shiftings/$apartmentShifting->id",'encType' =>"multipart/form-data", 'method' => 'PUT', 'class'=>'custom-form')) !!}
    @else
        {!! Form::open(array('url' => "apartment-shiftings",'method' => 'POST','encType' =>"multipart/form-data", 'class'=>'custom-form')) !!}
    @endif
    {{Form::hidden('id', old('id') ? old('id') : (!empty($apartmentShifting) ? $apartmentShifting->id : null),['class' => 'form-control','autocomplete'=>"off"])}}
    <div class="row">
        <div class="col-md-8">
            <div class="col-12">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="old_project_name">Project Name <span class="text-danger">*</span></label>
                    {{Form::text('old_project_name', old('old_project_name') ? old('old_project_name') : (!empty($apartmentShifting) ? $apartmentShifting->oldProject->name : null),['class' => 'form-control','id' => 'old_project_name', 'autocomplete'=>"off",'required'])}}
                    {{Form::hidden('old_project_id', old('old_project_id') ? old('old_project_id') : (!empty($apartmentShifting) ? $apartmentShifting->old_project_id : null),['class' => 'form-control','id' => 'old_project_id', 'autocomplete'=>"off",'required'])}}
                </div>
            </div>

            <div class="col-12">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="sale_id">Old Client<span class="text-danger">*</span></label>
                    {{Form::select('sale_id', $clients, old('sale_id') ? old('sale_id') : (!empty($apartmentShifting) ? $apartmentShifting->sale_id : null),['class' => 'form-control','id' => 'sale_id', 'autocomplete'=>"off"])}}
                </div>
            </div>

            <div class="col-12">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="tf_percentage">Shifting Fee (%)<span class="text-danger">*</span></label>
                    {{Form::text('tf_percentage', old('tf_percentage') ? old('tf_percentage') : (!empty($apartmentShifting) ? $apartmentShifting->tf_percentage : null),['class' => 'form-control','id' => 'tf_percentage', 'autocomplete'=>"off"])}}
                    <label class="input-group-addon" for="transfer_fee"> Shifting Fee (tk)<span class="text-danger">*</span></label>
                    {{Form::text('transfer_fee', old('transfer_fee') ? old('transfer_fee') : (!empty($apartmentShifting) ? $apartmentShifting->transfer_fee : null),['class' => 'form-control','id' => 'transfer_fee', 'autocomplete'=>"off"])}}
                </div>
            </div>

            <div class="col-12">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="discount">Discount<span class="text-danger">*</span></label>
                    {{Form::text('discount', old('discount') ? old('discount') : (!empty($apartmentShifting) ? $apartmentShifting->discount : null),['class' => 'form-control','id' => 'discount', 'autocomplete'=>"off"])}}
                    <label class="input-group-addon" for="net_pay"> Net Pay<span class="text-danger">*</span></label>
                    {{Form::text('net_pay', old('net_pay') ? old('net_pay') : (!empty($apartmentShifting) ? $apartmentShifting->net_pay : null),['class' => 'form-control','id' => 'net_pay', 'readonly'])}}
                </div>
            </div>
            <div class="col-xl-6 col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="attachment">Attachment</label>
                    {{Form::file('attachment', ['class' => 'form-control','id' => 'attachment'])}}
                </div>
                <p class="text-right">
                    @if(!empty($apartmentShifting) && $apartmentShifting->attachment)
                        <strong><a href="{{asset("storage/$apartmentShifting->attachment")}}" target="_blank"> See Current Attachment </a></strong>
                    @endif
                </p>
            </div>
            <div class="col-12">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="reason">Reason</label>
                    {{Form::text('reason', old('reason') ? old('reason') : (!empty($apartmentShifting) ? $apartmentShifting->reason : null),['class' => 'form-control','id' => 'reason', 'autocomplete'=>"off"])}}
                </div>
            </div>
            <br>
            <hr>
            <div class="col-md-12">
                <table id="clientTable" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <td class="bg-success" colspan="5"> <h5 class="text-center">New Apartment Information</h5></td>
                    </tr>
                    </thead>
                </table>
                <div class="row">
                    <div class="col-xl-4 col-md-6">
                        <div class="input-group input-group-sm input-group-primary">
                            <label class="input-group-addon" for="new_project_name">Project<span class="text-danger">*</span></label>
                            {{Form::text('new_project_name', old('new_project_name') ? old('new_project_name') : (!empty($apartmentShifting->newProject->name) ? $apartmentShifting->newProject->name : null),['class' => 'form-control','id' => 'new_project_name', 'autocomplete'=>"off",'required' ])}}
                            {{Form::hidden('new_project_id', old('new_project_id') ? old('new_project_id') : (!empty($apartmentShifting->newProject->id) ? $apartmentShifting->newProject->id: null),['class' => 'form-control','id' => 'new_project_id', 'autocomplete'=>"off",'required'])}}
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6">
                        <div class="input-group input-group-sm input-group-primary">
                            <label class="input-group-addon" for="apartment_id">Apartment ID<span class="text-danger">*</span></label>
                            {{Form::select('new_apartment_id',$apartments,old('apartment_id') ? old('apartment_id') : (!empty($apartmentShifting->new_apartment_id) ? $apartmentShifting->new_apartment_id : null),['class' => 'form-control','id' => 'apartment_id', 'autocomplete'=>"off",'required'])}}
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6">
                        <div class="input-group input-group-sm input-group-primary">
                            <label class="input-group-addon" for="">Hand-Over Date<span class="text-danger"></span></label>
                            {{Form::text('hand_over_date', old('hand_over_date') ? old('hand_over_date') : (!empty($apartmentShifting->hand_over_date) ? $apartmentShifting->hand_over_date :null),['class' => 'form-control total_price', 'id' => 'hand_over_date', 'min'=>'0', 'step'=>'0.01', 'placeholder' => '0', 'autocomplete'=>"off", ] )}}
                        </div>
                    </div>
                </div><!-- end row -->
                <div class="row">
                    <div class="col-xl-4 col-md-6">
                        <div class="input-group input-group-sm input-group-primary">
                            <label class="input-group-addon" for="apartment_size">Apartment Size <span class="text-danger">*</span></label>
                            {{Form::number('new_apartment_size', old('new_apartment_size') ? old('new_apartment_size') : (!empty($apartmentShifting->new_apartment_size) ? $apartmentShifting->new_apartment_size : null),['class' => 'form-control', 'id' => 'new_apartment_size', 'min'=>'0', 'step'=>'0.01', 'placeholder' => '0', 'autocomplete'=>"off",'required'] )}}
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6">
                        <div class="input-group input-group-sm input-group-primary">
                            <label class="input-group-addon" for="apartment_rate">Rate (Per SFT) <span class="text-danger">*</span></label>
                            {{Form::number('new_apartment_rate', old('new_apartment_rate') ? old('new_apartment_rate') : (!empty($apartmentShifting->new_apartment_rate) ? $apartmentShifting->new_apartment_rate : 0),['class' => 'form-control', 'id' => 'new_apartment_rate', 'min'=>'0', 'step'=>'0.01', 'placeholder' => '0', 'autocomplete'=>"off",'required'] )}}
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6">
                        <div class="input-group input-group-sm input-group-primary">
                            <label class="input-group-addon" for="apartment_value">Apartment Value <span class="text-danger">*</span></label>
                            {{Form::number('new_apartment_value', old('new_apartment_value') ? old('new_apartment_value') : (!empty($apartmentShifting->new_apartment_rate) ? $apartmentShifting->new_apartment_rate * $apartmentShifting->new_apartment_size : 0),['class' => 'form-control total_price', 'id' => 'new_apartment_value', 'min'=>'0', 'step'=>'0.01', 'placeholder' => '0', 'autocomplete'=>"off", 'readonly','required','tabindex'=>'-1'] )}}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-4 col-md-6">
                        <div class="input-group input-group-sm input-group-primary">
                            <label class="input-group-addon" for="utility_no">Utility No <span class="text-danger">*</span></label>
                            {{Form::number('new_utility_no', old('new_utility_no') ? old('new_utility_no') : (!empty($apartmentShifting->new_utility_no) ? $apartmentShifting->new_utility_no : 0),['class' => 'form-control', 'id' => 'new_utility_no', 'min'=>'0', 'placeholder' => '0', 'autocomplete'=>"off",'required'] )}}
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6">
                        <div class="input-group input-group-sm input-group-primary">
                            <label class="input-group-addon" for="utility_price">Utility Rate <span class="text-danger">*</span></label>
                            {{Form::number('new_utility_price', old('new_utility_price') ? old('new_utility_price') : (!empty($apartmentShifting->new_utility_price) ? $apartmentShifting->new_utility_price : 0),['class' => 'form-control', 'id' => 'new_utility_price', 'min'=>'0', 'step'=>'0.01', 'placeholder' => '0', 'autocomplete'=>"off",'required'] )}}
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6">
                        <div class="input-group input-group-sm input-group-primary">
                            <label class="input-group-addon" for="utility_fees">Utility Fees<span class="text-danger">*</span></label>
                            {{Form::number('utility_fees', old('utility_fees') ? old('utility_fees') : (!empty($apartmentShifting->new_utility_price) ? $apartmentShifting->new_utility_price * $apartmentShifting->new_utility_no : 0),['class' => 'form-control total_price', 'id' => 'utility_fees', 'min'=>'0', 'step'=>'0.01', 'placeholder' => '0', 'autocomplete'=>"off", 'readonly','required','tabindex'=>'-1'] )}}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-4 col-md-6">
                        <div class="input-group input-group-sm input-group-primary">
                            <label class="input-group-addon" for="reserve_no">Reserve No <span class="text-danger">*</span></label>
                            {{Form::number('new_reserve_no', old('new_reserve_no') ? old('new_reserve_no') : (!empty($apartmentShifting->new_reserve_no) ? $apartmentShifting->new_reserve_no : 0),['class' => 'form-control', 'id' => 'new_reserve_no', 'min'=>'0',  'placeholder' => '0', 'autocomplete'=>"off",'required'] )}}
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6">
                        <div class="input-group input-group-sm input-group-primary">
                            <label class="input-group-addon" for="reserve_rate">Reserve Rate <span class="text-danger">*</span></label>
                            {{Form::number('new_reserve_rate', old('new_reserve_rate') ? old('new_reserve_rate') : (!empty($apartmentShifting->new_reserve_rate) ? $apartmentShifting->new_reserve_rate : 0),['class' => 'form-control', 'id' => 'new_reserve_rate', 'min'=>'0', 'step'=>'0.01', 'placeholder' => '0', 'autocomplete'=>"off",'required'] )}}
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6">
                        <div class="input-group input-group-sm input-group-primary">
                            <label class="input-group-addon" for="reserve_fund">Reserve Fund <span class="text-danger">*</span></label>
                            {{Form::number('reserve_fund', old('reserve_fund') ? old('reserve_fund') : (!empty($apartmentShifting->new_reserve_rate) ? $apartmentShifting->new_reserve_rate *  $apartmentShifting->new_reserve_no: 0),['class' => 'form-control total_price', 'id' => 'reserve_fund', 'min'=>'0', 'step'=>'0.01', 'placeholder' => '0', 'autocomplete'=>"off", 'readonly','required','tabindex'=>'-1'] )}}
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6">
                        <div class="input-group input-group-sm input-group-primary">
                            <label class="input-group-addon" for="parking_no">Parking No <span class="text-danger">*</span></label>
                            {{Form::number('new_parking_no', old('new_parking_no') ? old('new_parking_no') : (!empty($apartmentShifting->new_parking_no) ? $apartmentShifting->new_parking_no : 0),['class' => 'form-control', 'id' => 'new_parking_no', 'min'=>'0', 'placeholder' => '0', 'autocomplete'=>"off",'required', 'readonly','tabindex'=>'-1'] )}}
                        </div>
                    </div>

                    <div class="col-xl-4 col-md-6">
                        <div class="input-group input-group-sm input-group-primary">
                            <label class="input-group-addon" for="parking_price">Price of Parking <span class="text-danger">*</span></label>
                            {{Form::number('new_parking_price', old('new_parking_price') ? old('new_parking_price') : (!empty($apartmentShifting->new_parking_price) ? $apartmentShifting->new_parking_price : 0),['class' => 'form-control total_price', 'id' => 'new_parking_price', 'min'=>'0', 'step'=>'0.01', 'placeholder' => '0', 'autocomplete'=>"off", 'required', 'readonly','tabindex'=>'-1'] )}}
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6">
                        <div class="input-group input-group-sm input-group-primary">
                            <label class="input-group-addon" for="total_value">Total  Apartment<br> Value <span class="text-danger">*</span></label>
                            {{Form::number('total_value', old('total_value') ? old('total_value') : (!empty($apartmentShifting->new_total_value) ? $apartmentShifting->new_total_value : 0),['class' => 'form-control', 'id' => 'total_value', 'min'=>'0', 'step'=>'0.01', 'placeholder' => '0', 'autocomplete'=>"off", 'readonly','required','tabindex'=>'-1'] )}}
                        </div>
                    </div>
                    <hr>
                    <div class="col-lg-12">
                        <div class="table-responsive">
                            <table id="parkingTable" class="table table-striped table-bordered table-sm text-center">
                                <tr>
                                    <td class="bg-success" colspan="3"> <h5 class="text-center">Parking Information</h5></td>
                                </tr>
                                <tr>
                                    <th>Parking Name</th>
                                    <th>Parking Rate</th>
                                    <th><i class="btn btn-success btn-sm fa fa-plus" onclick="addParking()"> </i></th>
                                </tr>
                                <tbody>

                                @if(old('parking_composite'))
                                    @foreach(old('parking_composite') as $oldKey => $oldItem)
                                        <tr>
                                            <td>
                                                <select class ="form-control form-control-sm" id="parking_composite" name="parking_composite[]">
                                                    @if(!empty($unsoldParkings))
                                                        @foreach ($unsoldParkings as $key => $unsoldParking)
                                                            <option value="{{$key}}" {{ $key == old('parking_composite')[$oldKey]  ? 'selected': null }}>{{$unsoldParking}}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </td>
                                            <td><input type="text" name="parking_rate[]" value="{{old('parking_rate')[$oldKey]}}" class="form-control form-control-sm parking_rate" min="0" step="1" required></td>
                                            <td><button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i class="fa fa-minus"></i></button></td>
                                        </tr>
                                    @endforeach
                                @else
                                    @if(!empty($apartmentShifting))
                                        @foreach($apartmentShifting->apartmentShiftingDetails as $parking)
                                            <tr>
                                                <input type="hidden" name="id" value="{{(!empty($parking->id) ? $parking->id : null)}}">
                                                <td>
                                                    <select class ="form-control form-control-sm parking_composite" id="parking_composite" name="parking_composite[]">
                                                        @if(!empty($unsoldParkings))
                                                            @foreach ($unsoldParkings as $key => $unsoldParking)
                                                                <option value="{{$key}}" {{$key == $parking->parking_composite ? "selected" : null}}>{{$unsoldParking}}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </td>
                                                <td>{{Form::number('parking_rate[]', old('parking_rate') ? old('parking_rate') : (!empty($parking->parking_rate) ? $parking->parking_rate : null),['class' => 'form-control form-control-sm parking_rate', 'min'=>'0', 'step'=>'1', 'required'] )}}</td>
                                                <td><button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i class="fa fa-minus"></i></button></td>
                                            </tr>
                                        @endforeach
                                    @endif
                                @endif

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <p class="mb-1"><strong>Client:</strong> <span id="name_text"> </span></p>
            <p class="mb-1"><strong>Phone:</strong> <span id="client_phone"> </span></p>
            <hr class="my-1">
            <p class="mb-1"><strong>Apartment ID:</strong> <span id="apartment_name_text"> </span></p>
            <p class="mb-1"><strong>Apartment Size (SFT):</strong> <span id="apartment_size_text"> </span></p>
            <p class="mb-1"><strong>Apartment Rate:</strong> <span id="apartment_rate_text"> </span></p>
            <p class="mb-1"><strong>Apartment Value:</strong> <span id="apartment_value_text"> </span></p>
            <p class="mb-1"><strong>No of Parking:</strong> <span id="parking_no_text"> </span></p>
            <p class="mb-1"><strong>Parking Amount:</strong> <span id="parking_amount_text">  </span></p>
            <hr class="my-1">
            <p class="mb-1 p-1 bg-primary"><strong>Total Amount : <span id="total_amount_text"> </span></strong> </p>
            <p class="mb-1 p-1 bg-success"><strong>Total Paid Amount: <span id="total_paid_amount"> </span></strong></p>
            <p class="mb-1 p-1 bg-warning"><strong>Due Amount : <span id="due_amount_text"> </span></strong></p>
            <p class="mb-1 p-1 bg-info"><strong>Rebate Amount : <span id="total_applied_amount"> </span></strong></p>

            <p class="mb-1"><strong>
                <a href="#" id="paymentHistory" target="_blank" class="btn btn-sm btn-primary btn-block d-none">Check Payment History</a></strong>
            </p>
        </div>
    </div>
    <hr class="bg-success">

    <div class="row">
        <div class="offset-md-4 col-md-4 mt-2">
            <div class="input-group input-group-sm ">
                <button class="btn btn-success btn-round btn-block py-2">Apply</button>
            </div>
        </div>
    </div> <!-- end row -->

    {!! Form::close() !!}


@endsection
@section('script')
    <script>
        var CSRF_TOKEN = "{{csrf_token()}}";
        function addParking(){
            $('#parkingTable').append(
                `<tr>
                          <td>
                            <select class ="form-control form-control-sm parking_composite"  name="parking_composite[]" required>
                                    <option></option>
                            </select>
                          </td>
                            <td><input type="number" name="parking_rate[]" class="form-control form-control-sm parking_rate" min="0" step='1'  autocomplete="off" required></td>
                            <td><button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i class="fa fa-minus"></i></button></td>
                    <tr>`
            );
            $('#new_parking_no').val($('.parking_composite').length);
        }
        $(function(){
            $( "#old_project_name").autocomplete({
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
                    $('#old_project_name').val(ui.item.label);
                    $('#old_project_id').val(ui.item.value);
                    return false;
                }
            }).on('change', function(){
                loadSoldClientsWithApartment();
            });

            $("#parkingTable").on('click', '.deleteItem', function(){
                $(this).closest('tr').remove();
                $('#new_parking_no').val($('.parking_composite').length);
                calculateParkingPrice();
            });

            $(document).on('keyup change', '.parking_rate', function(){
                calculateParkingPrice();
            });

            $(document).on('click', '.parking_composite', function(){
                let project_id = $("#new_project_id").val();
                if(!$(this).val()){
                    let dropdown = $(this);
                    dropdown.empty();
                    dropdown.prop('selectedIndex', 0);
                    const url = '{{url("loadProjectUnsoldParkings")}}/' + project_id;
                    // Populate dropdown with list of provinces
                    $.getJSON(url, function (items) {
                        $.each(items, function (key, entry) {
                            dropdown.append($('<option></option>').attr('value', key).text(entry));
                        })
                    });
                }
            });
        });

        function calculateParkingPrice(){
            // let size = $("#parking_no").val() > 0 ? parseFloat($("#parking_no").val()) : 0;
            let totalAmount = 0;
            $(".parking_rate").each(function(){
                totalAmount += $(this).val() > 0 ? parseFloat($(this).val()) : 0;
            });

            $("#new_parking_price").val(totalAmount.toFixed(2));
            grand_total_price();
            calculateInstallment();
        }

        function loadSoldClientsWithApartment(){
            let dropdown = $('#sale_id');
            let oldSelectedItem = "{{old('sale_id') ? old('sale_id') : (!empty($apartmentShifting->sale_id) ? $apartmentShifting->sale_id : null)}}";
            dropdown.empty();
            dropdown.append('<option selected="true" disabled>Select Type </option>');
            dropdown.prop('selectedIndex', 0);
            const url = '{{url("loadSoldClientsWithApartment")}}/' + $("#old_project_id").val();
            // Populate dropdown with list of provinces
            $.getJSON(url, function (sells) {
                console.log(sells)
                $.each(sells, function (key, sell) {
                    console.log(sell.id)
                    console.log(oldSelectedItem)
                    let select=(oldSelectedItem == sell.id) ? "selected" : null;
                    dropdown.append($(`<option ${select}></option>`).attr('value', sell.id).text(`${sell.sell_client.client.name} [Apartment : ${sell.apartment.name}]`));
                });
            });
        }

        $(function(){
            @if(old() || !empty($apartmentShifting))
            loadSoldClientsWithApartment();
            @endif
        });

        $( "#new_project_name").autocomplete({
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
                $('#new_project_name').val(ui.item.label);
                $('#new_project_id').val(ui.item.value);
                return false;
            }
        }).on('change', function(){
            loadProjectApartment();
        });

        function loadProjectApartment(){
            let dropdown = $('#apartment_id');
            let oldSelectedItem = "{{old('new_apartment_id') ? old('new_apartment_id') : null}}";
            dropdown.empty();
            dropdown.append('<option selected="true" disabled>Select Apartment </option>');
            dropdown.prop('selectedIndex', 0);
            const url = '{{url("loadProjectApartment")}}/' + $("#new_project_id").val();
            // Populate dropdown with list of provinces
            $.getJSON(url, function (items) {
                $.each(items, function (key, entry) {
                    let select=(oldSelectedItem == entry.id) ? "selected" : null;
                    dropdown.append($(`<option ${select}></option>`).attr('value', entry.id).text(entry.name));
                })
            });
        }

        function loadSoldApartmentInformation(){
            let sell_id = $("#sale_id").val();
            // alert(sell_id)
            if(sell_id){
                let url =`{{url("loadSoldApartmentInformation")}}/${sell_id}`;
                fetch(url)
                    .then((resp) => resp.json())
                    .then(function(soldinformation) {
                        $("#name_text").text(soldinformation.sell_client.client.name);
                        $("#client_phone").text(soldinformation.sell_client.client.contact);
                        $("#apartment_name_text").text(soldinformation.apartment.name);
                        $("#apartment_size_text").text(soldinformation.apartment.apartment_size);
                        $("#apartment_rate_text").text(soldinformation.apartment_rate);
                        $("#apartment_value_text").text(soldinformation.apartment_value.toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 }));
                        $("#parking_no_text").text(soldinformation.parking_no);
                        $("#parking_amount_text").text(soldinformation.parking_price.toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 }));
                        $("#total_amount_text").text(soldinformation.total_value.toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 }));
                        $("#total_paid_amount").text((parseFloat(soldinformation.sales_collection_details_sum_amount)).toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 }));
                        $("#due_amount_text").text((soldinformation.total_value - soldinformation.sales_collection_details_sum_amount).toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 }));
                        $("#total_applied_amount").text(soldinformation.sales_collection_details_sum_applied_amount);
                        $("#paymentHistory").attr('href', `{{url("sells/")}}/${sell_id}`).removeClass('d-none');
                    })
                    .catch(function () {
                        $("#name_text,#client_phone,#apartment_name_text,#apartment_size_text,#apartment_rate_text,#apartment_value_text,#parking_no_text,#parking_amount_text,#total_amount_text,#total_paid_amount,#due_amount_text,#total_applied_amount").text(null);
                        $("#paymentHistory").attr('href', "").addClass("d-none");
                    });
            }
        }

        function changeFee(){
            let total_amount = parseFloat($("#total_amount_text").text()) > 0 ? parseFloat($("#total_amount_text").text().replace(/,/g, '')) : 0;
            let tf_percentage = parseFloat($("#tf_percentage").val()) > 0 ? parseFloat($("#tf_percentage").val()) : 0 ;
            let transferFee = ((total_amount * tf_percentage)/100).toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 });
            $("#transfer_fee").val(transferFee);
            $("#net_pay").val(transferFee);
            calculateParkingPrice();
        }

        function changePercentage(){
            let transfer_fee = parseFloat($("#transfer_fee").val()) > 0 ? parseFloat($("#transfer_fee").val()) : 0;
            let total_amount = parseFloat($("#total_amount_text").text()) > 0 ? parseFloat($("#total_amount_text").text().replace(/,/g, '')) : 0;
            let percentage = ((transfer_fee / total_amount) * 100);
            $("#tf_percentage").val(percentage.toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 }))
            calculateParkingPrice();
        }

        function changeNetPay(){
            let discount = parseFloat($("#discount").val()) > 0 ? parseFloat($("#discount").val()) : 0;
            let transfer_fee = parseFloat($("#transfer_fee").val()) > 0 ? parseFloat($("#transfer_fee").val().replace(/,/g, '')) : 0;
            let NetPay = (transfer_fee - discount).toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 });
            $("#net_pay").val(NetPay);
            calculateParkingPrice();
        }

        $("#tf_percentage").on('change', function (){
            changeFee();
            changeNetPay();
        });

        $("#transfer_fee").on('change', function(){
            changePercentage();
            changeNetPay();
        })

        $("#discount").on('keyup', function(){
            changeNetPay();
        })

        function calculateApartmentValue(){
            let size = $("#new_apartment_size").val() > 0 ? parseFloat($("#new_apartment_size").val()) : 0;
            let rate = $("#new_apartment_rate").val() > 0 ? parseFloat($("#new_apartment_rate").val()) : 0;
            let total = (size * rate).toFixed(2);
            $("#new_apartment_value").val(total);
            grand_total_price();
        }

        function calculateUtilityFees(){
            let size = $("#new_utility_no").val() > 0 ? parseFloat($("#new_utility_no").val()) : 0;
            let rate = $("#new_utility_price").val() > 0 ? parseFloat($("#new_utility_price").val()) : 0;
            let total = (size * rate).toFixed(2);
            $("#utility_fees").val(total);
            grand_total_price();
        }

        function calculateReserveFund(){
            let size = $("#new_reserve_no").val() > 0 ? parseFloat($("#new_reserve_no").val()) : 0;
            let rate = $("#new_reserve_rate").val() > 0 ? parseFloat($("#new_reserve_rate").val()) : 0;
            let total = (size * rate).toFixed(2);
            $("#reserve_fund").val(total);
            grand_total_price();
        }

        $(document).on('change keyup', '#new_apartment_size, #new_apartment_rate', function(){
            calculateApartmentValue();
        });

        $(document).on('change keyup', '#new_utility_no, #new_utility_price', function(){
            calculateUtilityFees();
        });

        $(document).on('change keyup', '#new_reserve_no, #new_reserve_rate', function(){
            calculateReserveFund();
        });

        function grand_total_price(){
            let total_value=0;
            $(".total_price").each(function(){
                let currentValue = $(this).val() > 0 ? parseFloat($(this).val()) : 0;
                total_value +=parseFloat(currentValue);
            });
            $('#total_value').val((total_value).toFixed(2));
        }

        $(function() {

            $('#hand_over_date').datepicker({format: "dd-mm-yyyy",autoclose: true,todayHighlight: true,showOtherMonths: true});

            loadSoldApartmentInformation();
            @if(empty($apartmentShifting)  && !old('client_id'))
            addClient();
            @endif

            $("#clientTable").on('click', '.deleteItem', function(){
                $(this).closest('tr').remove();
            });

            $("#addClient").click(function(){
                addClient();
            });

            $(document).on('keyup', '.name', function(){
                $(this).autocomplete({
                    minLength: 0,
                    source: function (request, response) {
                        $.ajax({
                            url: "{{route('clientAutoSuggest')}}",
                            type: 'post',
                            dataType: "json",
                            data: {
                                _token: CSRF_TOKEN,
                                search: request.term
                            },
                            success: function (data) {
                                response(data);
                            }
                        });
                    },
                    select: function (event, ui) {
                        $(this).val(ui.item.label);
                        $(this).closest('tr').find('.client_id').val(ui.item.value);
                        $(this).closest('tr').find('.contact').val(ui.item.contact);
                        $(this).closest('tr').find('.profession').text(ui.item.profession);
                        $(this).closest('tr').find('.nid').text(ui.item.nid);
                        return false;
                    }
                })
            });

        });

        $("#sale_id").on('change', function (){
            loadSoldApartmentInformation();
        })

        $(function(){
            @if(old() || !empty($apartmentShifting))
            @endif
        });

    </script>
@endsection
