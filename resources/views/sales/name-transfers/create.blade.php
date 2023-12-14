@extends('layouts.backend-layout')
@section('title', 'name-transfers')

@section('breadcrumb-title')
    @if(!empty($nameTransfer))
        Edit Name Transfer
    @else
        New Name Transfer
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
        {!! Form::open(array('url' => "name-transfers/$nameTransfer->id",'encType' =>"multipart/form-data", 'method' => 'PUT', 'class'=>'custom-form')) !!}
    @else
        {!! Form::open(array('url' => "name-transfers",'method' => 'POST','encType' =>"multipart/form-data", 'class'=>'custom-form')) !!}
    @endif
    {{Form::hidden('id', old('id') ? old('id') : (!empty($nameTransfer) ? $nameTransfer->id : null),['class' => 'form-control','autocomplete'=>"off"])}}
    <div class="row">
        <div class="col-md-8">
            <div class="col-12">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="project_name">Project Name<span class="text-danger">*</span></label>
                    {{Form::text('project_name', old('project_name') ? old('project_name') : (!empty($nameTransfer) ? $nameTransfer->sale->apartment->project->name : null),['class' => 'form-control','id' => 'project_name', 'autocomplete'=>"off",'required'])}}
                    {{Form::hidden('project_id', old('project_id') ? old('project_id') : (!empty($nameTransfer) ? $nameTransfer->sale->apartment->project_id : null),['class' => 'form-control','id' => 'project_id', 'autocomplete'=>"off",'required'])}}
                </div>
            </div>

            <div class="col-12">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="sale_id">Old Client<span class="text-danger">*</span></label>
                    {{Form::select('sale_id', $clients, old('sale_id') ? old('sale_id') : (!empty($nameTransfer) ? $nameTransfer->sale_id : null),['class' => 'form-control','id' => 'sale_id', 'autocomplete'=>"off"])}}
                </div>
            </div>

            <div class="col-12">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="tf_percentage">Transfer Fee (%)<span class="text-danger">*</span></label>
                    {{Form::text('tf_percentage', old('tf_percentage') ? old('tf_percentage') : (!empty($nameTransfer) ? $nameTransfer->tf_percentage : null),['class' => 'form-control','id' => 'tf_percentage', 'autocomplete'=>"off"])}}
                    <label class="input-group-addon" for="transfer_fee"> Transfer Fee (tk)<span class="text-danger">*</span></label>
                    {{Form::text('transfer_fee', old('transfer_fee') ? old('transfer_fee') : (!empty($nameTransfer) ? $nameTransfer->transfer_fee : null),['class' => 'form-control','id' => 'transfer_fee', 'autocomplete'=>"off"])}}
                </div>
            </div>

            <div class="col-12">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="discount">Discount<span class="text-danger">*</span></label>
                    {{Form::text('discount', old('discount') ? old('discount') : (!empty($nameTransfer) ? $nameTransfer->discount : null),['class' => 'form-control','id' => 'discount', 'autocomplete'=>"off"])}}
                    <label class="input-group-addon" for="net_pay"> Net Pay<span class="text-danger">*</span></label>
                    {{Form::text('net_pay', old('net_pay') ? old('net_pay') : (!empty($nameTransfer) ? $nameTransfer->net_pay : null),['class' => 'form-control','id' => 'net_pay', 'readonly'])}}
                </div>
            </div>
            <div class="col-xl-6 col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="attachment">Attachment</label>
                    {{Form::file('attachment', ['class' => 'form-control','id' => 'attachment'])}}
                </div>
                <p class="text-right">
                    @if(!empty($nameTransfer) && $nameTransfer->attachment)
                        <strong><a href="{{asset("storage/$nameTransfer->attachment")}}" target="_blank"> See Current Attachment </a></strong>
                    @endif
                </p>
            </div>
            <br>
            <hr>
            <div class="col-md-12">
                <table id="clientTable" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <td class="bg-success" colspan="5"> <h5 class="text-center">New Client Information</h5></td>
                    </tr>
                    <tr>
                        <th>Name</th>
                        <th>Contact</th>
                        <th>Client ID </th>
                        <th>Details</th>
                        <th><i class="btn btn-primary btn-sm fa fa-plus" id="addClient"> </i></th>
                    </tr>
                    </thead>
                    <tbody>
                        @if(old('client_id'))
                            @foreach(old('client_id') as $key => $clientOldData)
                                <tr>
                                    <td>
                                        <input type="text" name="name[]" value="{{old('name')[$key]}}" class="form-control form-control-sm name" placeholder="Type Client Name"  required>
                                    </td>
                                    <td><input type="text" name="contact[]" value="{{old('contact')[$key]}}" class="form-control form-control-sm contact" readonly></td>
                                    <td><input type="text" name="client_id[]" value="{{old('client_id')[$key]}}" class="form-control form-control-sm text-center client_id" required readonly></td>
                                    <td class="text-center"><button class="btn btn-danger btn-sm deleteItem" type="button"><i class="fa fa-minus"></i></button></td>
                                </tr>
                            @endforeach
                        @else
                            @if(!empty($nameTransfer))
                                @foreach($nameTransfer->saleClients as $sellClient)
                                    <tr>
                                        <td><input type="text" name="name[]" value="{{$sellClient->client->name}}" class="form-control form-control-sm name" placeholder="Type Client Name"  required></td>
                                        <td><input type="text" name="contact[]" value="{{$sellClient->client->contact}}" class="form-control form-control-sm contact" readonly ></td>
                                        <td><input type="text" name="client_id[]" value="{{$sellClient->client->id}}" class="form-control form-control-sm text-center client_id" required readonly></td>
                                        <td><span>{{$sellClient->client->nid}}</span><br><span>{{$sellClient->client->profession}}</span></td>
                                        <td class="text-center"><button class="btn btn-danger btn-sm deleteItem" type="button"><i class="fa fa-minus"></i></button></td>
                                    </tr>
                                @endforeach
                            @endif
                        @endif
                    </tbody>
                </table>
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
        function addClient(){
            $('#clientTable tbody').append(
                `<tr>
                    <td><input type="text" name="name[]" class="form-control form-control-sm name" placeholder="Type Client Name" required></td>
                    <td><input type="text" name="contact[]" class="form-control form-control-sm contact" readonly required></td>
                    <td><input  style="text-align: center;" type="text" name="client_id[]" class="form-control form-control-sm client_id" required readonly></td>
                    <td><span class="nid"></span><br><span class="profession"></span></td>
                    <td class="text-center"><button class="btn btn-danger btn-sm deleteItem" type="button"><i class="fa fa-minus"></i></button></td>
                </tr>`
            );
        }

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
            let oldSelectedItem = "{{old('sale_id') ? old('sale_id') : (!empty($nameTransfer->sale_id) ? $nameTransfer->sale_id : null)}}";
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
        }

        function changePercentage(){
            let transfer_fee = parseFloat($("#transfer_fee").val()) > 0 ? parseFloat($("#transfer_fee").val()) : 0;
            let total_amount = parseFloat($("#total_amount_text").text()) > 0 ? parseFloat($("#total_amount_text").text().replace(/,/g, '')) : 0;
            let percentage = ((transfer_fee / total_amount) * 100);
            $("#tf_percentage").val(percentage.toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 }))
        }

        function changeNetPay(){
            let discount = parseFloat($("#discount").val()) > 0 ? parseFloat($("#discount").val()) : 0;
            let transfer_fee = parseFloat($("#transfer_fee").val()) > 0 ? parseFloat($("#transfer_fee").val().replace(/,/g, '')) : 0;
            let NetPay = (transfer_fee - discount).toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 });
            $("#net_pay").val(NetPay);
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

        $(function() {
            loadSoldApartmentInformation();
            @if(empty($nameTransfer)  && !old('client_id'))
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
            @if(old() || !empty($nameTransfer))
                loadSoldClientsWithApartment();
            @endif
        });

    </script>
@endsection

