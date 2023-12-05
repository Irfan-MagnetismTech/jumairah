@extends('layouts.backend-layout')
@section('title', 'Sales Collection')

@section('breadcrumb-title')
    @if($formType == 'edit')
        Edit Sale Collection
    @else
        New Sale Collection
    @endif
@endsection

@section('breadcrumb-button')
    <a href="{{ url('salesCollections') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('style')
    <style>
        #basic_information p{
            font-size: 12px!important;
        }
    </style>
@endsection

@section('content-grid', null)

@section('content')

    @if($formType == 'edit')
        {!! Form::open(array('url' => "salesCollections/$salesCollection->id",'encType' =>"multipart/form-data", 'method' => 'PUT', 'class'=>'custom-form')) !!}
    @else
        {!! Form::open(array('url' => "salesCollections",'method' => 'POST','encType' =>"multipart/form-data", 'class'=>'custom-form')) !!}
    @endif
    <div class="row">
        <div class="col-lg-9 p-1">
            <div class="row">
                <div class="col-xl-6 col-md-6">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="project_name">Project Name<span class="text-danger">*</span></label>
                        {{Form::text('project_name', old('project_name') ? old('project_name') : (!empty($salesCollection) ? $salesCollection->sell->apartment->project->name : null),['class' => 'form-control','id' => 'project_name', 'autocomplete'=>"off",'required'])}}
                        {{Form::hidden('project_id', old('project_id') ? old('project_id') : (!empty($salesCollection) ? $salesCollection->sell->apartment->project_id : null),['class' => 'form-control','id' => 'project_id', 'autocomplete'=>"off",'required'])}}
                    </div>
                </div>
                <div class="col-xl-6 col-md-6">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="sell_id">Client Name<span class="text-danger">*</span></label>
                        {{Form::select('sell_id', $clients, old('sell_id') ? old('sell_id') : (!empty($salesCollection) ? $salesCollection->sell_id : null),['class' => 'form-control','id' => 'sell_id', 'autocomplete'=>"off"])}}
                    </div>
                </div>
                <div class="col-xl-6 col-md-6">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="received_date">Received Date <span class="text-danger">*</span></label>
                        {{Form::text('received_date', old('received_date') ? old('received_date') : (!empty($salesCollection->received_date) ? $salesCollection->received_date : null),['class' => 'form-control', 'id' => 'received_date','placeholder'=>'dd-mm-yyyy', 'autocomplete'=>"off",'required'] )}}
                    </div>
                </div>
                <div class="col-xl-6 col-md-6">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="payment_mode">Payment Mode <span class="text-danger">*</span></label>
                        {{Form::select('payment_mode', $paymentModes, old('payment_mode') ? old('payment_mode') : (!empty($salesCollection->payment_mode) ? $salesCollection->payment_mode : null),['class' => 'form-control', 'id' => 'payment_mode', 'placeholder' => 'Select Payment Mode', 'autocomplete'=>"off",'required'] )}}
                    </div>
                </div>
                <div class="col-xl-6 col-md-6 d-none" id="source_name_area">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="source_name">Bank Name <span class="text-danger">*</span></label>
                        {{Form::text('source_name', old('source_name') ? old('source_name') : (!empty($salesCollection->source_name) ? $salesCollection->source_name : null),['class' => 'form-control', 'id' => 'source_name', 'placeholder' => 'Enter Bank Name', 'autocomplete'=>"off"] )}}
                    </div>
                </div>
                <div class="col-xl-6 col-md-6 d-none" id="transaction_no_area">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="transaction_no">Payment No <span class="text-danger">*</span></label>
                        {{Form::text('transaction_no', old('transaction_no') ? old('transaction_no') : (!empty($salesCollection->transaction_no) ? $salesCollection->transaction_no : null),['class' => 'form-control', 'id' => 'transaction_no', 'placeholder' => 'Enter Payment No', 'autocomplete'=>"off"] )}}
                    </div>
                </div>
                <div class="col-xl-6 col-md-6 d-none" id="dated_area">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="dated">Dated <span class="text-danger">*</span></label>
                        {{Form::text('dated', old('dated') ? old('dated') : (!empty($salesCollection->dated) ? $salesCollection->dated : null),['class' => 'form-control', 'id' => 'dated', 'autocomplete'=>"off"] )}}
                    </div>
                </div>
                <div class="col-xl-6 col-md-6">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="attachment">Attachment</label>
                        {{Form::file('attachment', ['class' => 'form-control','id' => 'attachment'])}}
                    </div>
                    <p class="text-right">
                        @if(!empty($salesCollection) && $salesCollection->attachment)
                            <strong><a href="{{asset("storage/$salesCollection->attachment")}}" target="_blank"> See Current Attachment </a></strong>
                        @endif
                    </p>
                </div>
                <div class="col-12">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="remarks">Remarks</label>
                        {{Form::textarea('remarks', old('remarks') ? old('remarks') : (!empty($salesCollection->remarks) ? $salesCollection->remarks : null),['class' => 'form-control', 'id' => 'remarks', 'rows'=>2, 'autocomplete'=>"off"] )}}
                    </div>
                </div>
            </div> <!-- end row -->
            <hr class="bg-success">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-sm text-center" id="collectionTable">
                    <thead>
                        <tr>
                            <th>Particulars <span class="text-danger">*</span></th>
                            <th>No</th>
                            <th>Scheduled <br> Date</th>
                            <th>Scheduled <br> Amount</th>
                            <th>Paid</th>
                            <th>Due</th>
                            <th>Received <br> Amount<span class="text-danger">*</span></th>
                            <th>Balance</th>
                            <th>
                                <button class="btn btn-success btn-sm addItem" type="button"><i class="fa fa-plus"></i></button>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- {{dd(
// $inst_paids,
// $inst_paids,
// $amounts,
// $inst_balances
                        )}} --}}

                    @if(old('particular'))
                        @foreach(old('particular') as $oldKey => $oldData)
                            <tr>
                                <td>
                                    <select name="particular[]" class="form-control form-control-sm particular" required>
                                        <option disabled selected>Select Particular</option>
                                        @foreach($paymentTypes as $key => $paymentType)
                                            @if(old('particular')[$oldKey] == $key)
                                                <option value="{{$key}}" selected> {{$paymentType}}</option>
                                            @else
                                                <option value="{{$key}}"> {{$paymentType}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="hidden" name="installment_composite[]" value="{{old('installment_composite')[$oldKey]}}" class="installment_composite">
                                    <input type="number" name="installment_no[]" value="{{old('installment_no')[$oldKey]}}" class="form-control form-control-sm inst_no" tabindex="-1" readonly>
                                </td>
                                <td><input type="number" name="inst_amount[]" value="{{old('inst_amount')[$oldKey]}}" class="form-control form-control-sm inst_amount" tabindex="-1" readonly></td>
                                <td><input type="number" name="inst_paid[]" value="{{old('inst_paid')[$oldKey]}}" class="form-control form-control-sm inst_paid" tabindex="-1" readonly></td>
                                <td><input type="number" name="inst_due[]" value="{{old('inst_due')[$oldKey]}}" class="form-control form-control-sm inst_due" tabindex="-1" readonly></td>
                                <td>
                                    {{Form::number('amount[]', old('amount')[$oldKey],['class' => 'form-control form-control-sm amount text-right', 'min' => '0', 'step' => '0.01', 'autocomplete'=>"off",'required'] )}}
                                </td>
                                <td><input type="number" name="inst_balance[]" value="{{old('inst_balance')[$oldKey]}}" class="form-control form-control-sm inst_balance" tabindex="-1" readonly></td>
                                <td><button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i class="fa fa-minus"></i></button></td>
                            </tr>
                        @endforeach
                    @elseif(!empty($salesCollection) && $salesCollection->salesCollectionDetails)
                        @foreach($salesCollection->salesCollectionDetails as $salesCollectionDetail)
                            <tr>
                                <td>
                                    <select name="particular[]" class="form-control form-control-sm particular" required>
                                        <option disabled selected>Select Particular</option>
                                        @foreach($paymentTypes as $key => $paymentType)
                                            @if($salesCollectionDetail->particular == $key)
                                                <option value="{{$key}}" selected> {{$paymentType}}</option>
                                            @else
                                                <option value="{{$key}}"> {{$paymentType}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </td>

                                <td>
                                    <input type="hidden" name="installment_composite[]" value="{{$salesCollectionDetail->installment_composite}}" class="installment_composite">
                                    <input type="number" name="installment_no[]" value="{{$salesCollectionDetail->installment_no}}" class="form-control form-control-sm inst_no" tabindex="-1" readonly>
                                </td>
                                <td>
                                    <input type="text" name="installment_date[]" value="{{$salesCollectionDetail->installment->installment_date ?? null}}" class="form-control form-control-sm installment_date" tabindex="-1" readonly>
                                </td>
                                <td><input type="number" name="inst_amount[]" value="{{$salesCollectionDetail->installment->installment_amount ?? 0}}" class="form-control form-control-sm inst_amount" tabindex="-1" readonly></td>

                                <td><input type="number" name="inst_paid[]" class="form-control form-control-sm inst_paid" tabindex="-1" readonly></td>
                                <td><input type="number" name="inst_due[]" class="form-control form-control-sm inst_due" tabindex="-1" readonly></td>
                                <td>
                                    {{Form::number('amount[]', $salesCollectionDetail->amount,['class' => 'form-control form-control-sm amount text-right', 'min' => '0', 'step' => '0.01', 'autocomplete'=>"off",'required'] )}}
                                </td>
                                <td><input type="number" name="inst_balance[]" class="form-control form-control-sm inst_balance" tabindex="-1" readonly></td>
                                <td><button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i class="fa fa-minus"></i></button></td>
                            </tr>
                        @endforeach

                    @endif

                    </tbody>

                    <tfoot>
                        <tr>
                            <td colspan="6" class="text-right"> Total </td>
                            <td>
                                {{Form::number('received_amount', old('received_amount') ? old('received_amount') : (!empty($salesCollection->received_amount) ? $salesCollection->received_amount : null),['class' => 'form-control form-control-sm text-right', 'id' => 'received_amount', 'tabindex'=>"-1", 'autocomplete'=>"off",'required','readonly'] )}}
                            </td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

        </div> <!-- end col-md-9 -->

        <div class="col-lg-3 p-1" id="basic_information">
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
            <h6 class="text-center bg-dark py-2">Last Payment</h6>
            <p class="mb-1"><strong>Date:</strong> <span id="last_payment_date_text"> </span></p>
            <p class="mb-1"><strong>Purpose:</strong> <span id="last_payment_purpose"> </span></p>
            <p class="mb-1 d-none" id="last_installment_no_area"><strong>Installment No.:</strong> <span id="last_installment_no"> </span></p>
            <p class="mb-1"><strong>Paid Amount:</strong> <span id="last_paid_amount_text"> </span></p>
            <p class="mb-1"><strong>
                <a href="#" id="paymentHistory" target="_blank" class="btn btn-sm btn-primary btn-block d-none">Check Payment History</a></strong>
            </p>
        </div> <!-- end col-md-3 -->
    </div> <!-- row -->
    <hr class="bg-success">

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
        function addRow(){
            let row = `
                <tr>
                    <td>
                        {{Form::select('particular[]', $paymentTypes, null,['class' => 'form-control form-control-sm particular', 'placeholder' => 'Select Particular', 'autocomplete'=>"off",'required'] )}}
                    </td>
                    <td>
                        <input type="hidden" name="installment_composite[]" class="installment_composite">
                        <input type="number" name="installment_no[]" class="form-control form-control-sm inst_no" tabindex="-1" readonly>
                    </td>
                    <td><input type="text" name="inst_date[]" class="form-control form-control-sm inst_date" tabindex="-1" readonly></td>
                    <td><input type="number" name="inst_amount[]" class="form-control form-control-sm inst_amount" tabindex="-1" readonly></td>
                    <td><input type="number" name="inst_paid[]" class="form-control form-control-sm inst_paid" tabindex="-1" readonly></td>
                    <td><input type="number" name="inst_due[]" class="form-control form-control-sm inst_due" tabindex="-1" readonly></td>
                    <td><input style="text-align: right" type="number" name="amount[]" class="form-control form-control-sm amount" min="0"  step="0.01" placeholder="0.00" required autocomplete="off"></td>
                    <td><input type="number" name="inst_balance[]" class="form-control form-control-sm inst_balance" readonly tabindex="-1"></td>
                    <td><button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i class="fa fa-minus"></i></button></td>
                </tr>
            `;
            $('#collectionTable tbody').append(row);
            totalOperation();
        }

        function totalOperation(){
            var total = 0;
            if($(".amount").length > 0){
                $(".amount").each(function(i, row){
                    var amountTK = Number($(row).val());
                    total += parseFloat(amountTK);
                })
            }
            $("#received_amount").val(total);
        }

        function checkPaymentMode(){
            let paymentMode = $("#payment_mode").val();
            let moreInfoNeeds = ['Cheque', 'Pay Order','DD','TT','Online Bank Transfer'];
            if(jQuery.inArray(paymentMode, moreInfoNeeds) !== -1){
                $("#source_name_area, #transaction_no_area").removeClass('d-none');
                $("#transaction_no_area").find('label').text(paymentMode + " No");
                $("#source_name, #transaction_no").prop('required', true);
                if(paymentMode === "Cheque"){
                    $("#dated_area").removeClass('d-none');
                    $("#dated").prop('required', true);
                }else{
                    $("#dated_area").addClass('d-none');
                    $("#dated").prop('required', false).val(null);
                }
            }else{
                $("#source_name_area, #transaction_no_area, #dated_area").addClass('d-none');
                $("#source_name, #transaction_no, #dated").prop('required', false).val(null);
            }
        }

        function loadSoldClientsWithApartment(){
            let dropdown = $('#sell_id');
            dropdown.empty();
            dropdown.append('<option selected="true" disabled>Select Type </option>');
            dropdown.prop('selectedIndex', 0);
            const url = '{{url("loadSoldClientsWithApartment")}}/' + $("#project_id").val();
            // Populate dropdown with list of provinces
            $.getJSON(url, function (sells) {
                $.each(sells, function (key, sell) {
                    dropdown.append($('<option></option>').attr('value', sell.id).text(`${sell.sell_client.client.name} [Apartment : ${sell.apartment.name}]`));
                });
            });
        }

        function loadSoldApartmentInformation(){
            let sell_id = $("#sell_id").val();
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
                    $("#apartment_value_text").text(soldinformation.apartment_value);
                    $("#parking_no_text").text(soldinformation.parking_no);
                    $("#parking_amount_text").text(soldinformation.parking_price);
                    $("#total_amount_text").text(soldinformation.total_value);
                    $("#total_paid_amount").text(soldinformation.sales_collection_details_sum_amount);
                    $("#due_amount_text").text((soldinformation.total_value - soldinformation.sales_collection_details_sum_amount).toFixed(2));
                    $("#total_applied_amount").text(soldinformation.sales_collection_details_sum_applied_amount);
                    $("#last_payment_date_text").text(soldinformation.last_payment_date);
                    $("#last_payment_purpose").text(soldinformation.last_payment_purpose);
                    if(soldinformation.last_installment_no){
                        $("#last_installment_no").text(soldinformation.last_installment_no);
                        $("#last_installment_no_area").removeClass('d-none');
                    }else{
                        $("#last_installment_no").text("---");
                        $("#last_installment_no_area").addClass('d-none');
                    }
                    $("#last_paid_amount_text").text(soldinformation.last_received_amount);
                    $("#paymentHistory").attr('href', `{{url("sells/")}}/${sell_id}`).removeClass('d-none');
                })
                .catch(function () {
                    $("#name_text,#client_phone,#apartment_name_text,#apartment_size_text,#apartment_rate_text,#apartment_value_text,#parking_no_text,#parking_amount_text,#total_amount_text,#total_paid_amount,#due_amount_text,#total_applied_amount").text(null);
                    $("#paymentHistory").attr('href', "").addClass("d-none");
                });
            }
//            $('#collectionTable tbody').empty();
//            addRow();
        }



        function loadInstallmentInformation(currentItem){
            if($("#sell_id").val()){
                let selectedItem = $(currentItem);
                let sell_id = $("#sell_id").val();
                let installment_composite = $(selectedItem).closest('tr').find(".installment_composite");
                let inst_no = $(selectedItem).closest('tr').find(".inst_no");
                let inst_date = $(selectedItem).closest('tr').find(".inst_date");
                let inst_amount = $(selectedItem).closest('tr').find(".inst_amount");
                let inst_paid = $(selectedItem).closest('tr').find(".inst_paid");
                let inst_due = $(selectedItem).closest('tr').find(".inst_due");
                let inst_balance = $(selectedItem).closest('tr').find(".inst_balance");
                let received_amount = $(selectedItem).closest('tr').find(".amount").val(null);

                if(selectedItem.val() === 'Installment'){

                    var currentParticulars = $('.particular').not(selectedItem)
                    .filter(function(){
                        return $(this).val() == 'Installment';
                    });
                    let totalCurrentInstallment = currentParticulars.length;
                    if(totalCurrentInstallment > 0){
                        let lastInstallmentBalance = $(currentParticulars[totalCurrentInstallment - 1]).closest('tr').find('.inst_balance').val();
                        let lastInstallmentNo = parseInt($(currentParticulars[totalCurrentInstallment - 1]).closest('tr').find('.inst_no').val()) + 1;
                        if(lastInstallmentBalance == 0 ){
                            let url =`{{url("loadNextInstallment")}}/${sell_id}/${lastInstallmentNo}`;
                            fetch(url)
                            .then((resp) => resp.json())
                            .then(function(current){
                                $(installment_composite).val(current.installment_composite);
                                $(inst_no).val(current.installment_no);
                                $(inst_date).val(current.installment_date);
                                $(inst_amount).val(current.installment_amount);
                                $(inst_paid).val(null);
                                $(inst_due).val(current.installment_amount);
                                $(inst_balance).val(null);
                            })
                            .catch(function (){
                                // alert("There is no more unpaid Installment.");
                                $(installment_composite,inst_no,inst_date,inst_amount,inst_paid,inst_due,inst_balance).val(null);
                            });
                        }else{
                            alert("Please Pay Full Amount.");
                            $(selectedItem).val(null);
                            $(installment_composite,inst_no,inst_date,inst_amount,inst_paid,inst_due,inst_balance).val(null);
                        }
                    }else{
                        let url =`{{url("loadCurrentInstallment")}}/${sell_id}`;
                        fetch(url)
                        .then((resp) => resp.json())
                        .then(function(current){
                            $(installment_composite).val(current.installment_composite);
                            $(inst_no).val(current.installment_no);
                            $(inst_date).val(current.installment_date);
                            $(inst_amount).val(current.installment_amount);
                            $(inst_paid).val(current.installment_collections_sum_amount);
                            $(inst_due).val(current.installment_amount - current.installment_collections_sum_amount);
                            $(inst_balance).val(current.installment_amount - current.installment_collections_sum_amount);
                        })
                        .catch(function () {
                            alert("There is no more unpaid Installment.");
                            $(installment_composite,inst_no,inst_date,inst_amount,inst_paid,inst_due,inst_balance).val(null);
                        });
                    }
                }
                else if(selectedItem.val() === 'Booking Money'){
                    let url =`{{url("loadBookingMoney")}}/${sell_id}`;
                    fetch(url)
                    .then((resp) => resp.json())
                    .then(function(current) {
                        $(installment_composite).val(null);
                        $(inst_no).val(null);
                        $(inst_date).val(current.booking_money_date);
                        $(inst_amount).val(current.booking_money);
                        $(inst_paid).val(current.booking_money_collections_sum_amount);
                        $(inst_due).val(current.due);
                        $(inst_balance).val(current.due);
                    })
                    .catch(function () {
                        $(installment_composite,inst_no,inst_date,inst_amount,inst_paid,inst_due,inst_balance).val(null);
                    });
                }
                else if(selectedItem.val() === 'Down Payment'){
                    let url =`{{url("loadDownpayment")}}/${sell_id}`;
                    fetch(url)
                    .then((resp) => resp.json())
                    .then(function(current) {
                        $(installment_composite).val(null);
                        $(inst_no).val(null);
                        $(inst_date).val(current.downpayment_date);
                        $(inst_amount).val(current.downpayment);
                        $(inst_paid).val(current.downpayment_collections_sum_amount);
                        $(inst_due).val(current.due);
                        $(inst_balance).val(current.due);
                    })
                    .catch(function () {
                        $(installment_composite,inst_no,inst_date,inst_amount,inst_paid,inst_due,inst_balance).val(null);
                    });
                }
                else{
                    $(selectedItem).closest('tr').find('.installment_composite,.inst_no,.inst_date,.inst_amount,.inst_paid,.inst_due,.inst_balance').val(null);
                }
            }else{
                alert("Please Select Client Name First");
            }
            totalOperation();
        }

        var CSRF_TOKEN = "{{csrf_token()}}";
        $(function(){
            checkPaymentMode();
            totalOperation();
            loadSoldApartmentInformation();

            @if($formType == 'create' && old('particular'))
                addRow();
            @endif

            {{--@if(old())--}}
                {{--loadSoldClientsWithApartment();--}}
            {{--@endif--}}

            $("#received_date, #dated").datepicker({format: "dd-mm-yyyy",autoclose: true,todayHighlight: true,showOtherMonths: true});
            $("#payment_mode").on('change', function(){
                checkPaymentMode();
            });

            $(document).on('click', ".addItem", function(){
                addRow();
            });

            $(document).on('keyup', ".amount", function(){
                totalOperation();
            });
            $("#collectionTable").on('click', '.deleteItem', function(){
                $(this).closest('tr').remove();
                totalOperation();
            });

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
                $("#name_text,#client_phone,#apartment_name_text,#apartment_size_text,#apartment_rate_text,#apartment_value_text,#parking_no_text,#parking_amount_text,#total_amount_text,#total_paid_amount,#due_amount_text, #total_applied_amount").text(null);
                $("#paymentHistory").attr('href', "").addClass("d-none");
            });

            $(document).on('change', '.particular', function(){
                loadInstallmentInformation(this);
            });

            $(document).on('change', '#sell_id', function(){
                loadSoldApartmentInformation();
                $("#collectionTable tbody").empty();
            });

            $(document).on('change keyup', '.amount', function(){
                let inst_due = $(this).closest('tr').find('.inst_due').val() > 0 ? parseFloat($(this).closest('tr').find('.inst_due').val()) : 0;
                let paying = $(this).val() > 0 ? parseFloat($(this).val()) : 0;
                if(inst_due){
                    if(inst_due >= paying){
                        $(this).closest('tr').find('.inst_balance').val(inst_due - paying);
                    }else{
                        $(this).closest('tr').find('.inst_balance').val(inst_due);
                        $(this).val(null).focus();
                    }
                    totalOperation();
                }
            });

        });//document.ready

    </script>
@endsection
