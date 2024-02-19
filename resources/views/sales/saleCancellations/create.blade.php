@extends('layouts.backend-layout')
@section('title', 'Sales Collection')

@section('breadcrumb-title')
    @if($formType == 'edit')
        Edit Sale Cancellation
    @else
        New Sale Cancellation
    @endif
@endsection

@section('breadcrumb-button')
    <a href="{{ url('saleCancellations') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
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

@section('content-grid', 'offset-md-1 col-md-10 offset-lg-2 col-lg-8 my-3')

@section('content')

    @if($formType == 'edit')
        {!! Form::open(array('url' => "saleCancellations/$saleCancellation->id",'encType' =>"multipart/form-data", 'method' => 'PUT', 'class'=>'custom-form')) !!}
    @else
        {!! Form::open(array('url' => "saleCancellations",'method' => 'POST','encType' =>"multipart/form-data", 'class'=>'custom-form')) !!}
    @endif
    <div class="row">
        <div class="col-12">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="applied_date">Applied Date <span class="text-danger">*</span></label>
                {{Form::text('applied_date', old('applied_date') ? old('applied_date') : (!empty($saleCancellation->applied_date) ? $saleCancellation->applied_date : null),['class' => 'form-control', 'id' => 'applied_date','placeholder'=>'dd-mm-yyyy', 'autocomplete'=>"off",'required'] )}}
            </div>
        </div>
        <div class="col-12">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="cancelled_by">Cancelled By<span class="text-danger">*</span></label>
                <div class="form-radio px-1 d-flex" style="width: 100%">
                    <div class="radio radiofill radio-warning radio-inline " style="width: 50%">
                        <label class="my-1 py-1">
                            <input type="radio" name="cancelled_by" value="Client" {{old('cancelled_by') && old('cancelled_by') == "Client" ? "Checked" : (!empty($saleCancellation->cancelled_by) && $saleCancellation->cancelled_by == "Client" ? "Checked" : null)}} required>
                            <i class="helper"></i> Client
                        </label>
                    </div>
                    <div class="radio radiofill radio-danger radio-inline " style="width: 50%">
                        <label class="my-1 py-1">
                            <input type="radio" name="cancelled_by" value="Developer" {{old('cancelled_by') && old('cancelled_by') == "Developer" ? "Checked" : (!empty($saleCancellation->cancelled_by) && $saleCancellation->cancelled_by == "Developer" ? "Checked" : null)}} required>
                            <i class="helper"></i> Developer
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="project_name">Project Name<span class="text-danger">*</span></label>
                {{Form::text('project_name', old('project_name') ? old('project_name') : (!empty($saleCancellation) ? $saleCancellation->sell->apartment->project->name : null),['class' => 'form-control','id' => 'project_name', 'autocomplete'=>"off",'required'])}}
                {{Form::hidden('project_id', old('project_id') ? old('project_id') : (!empty($saleCancellation) ? $saleCancellation->sell->apartment->project_id : null),['class' => 'form-control','id' => 'project_id', 'autocomplete'=>"off",'required'])}}
            </div>
        </div>
        <div class="col-12">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="sell_id">Client Name<span class="text-danger">*</span></label>
                {{Form::select('sell_id', $clients, old('sell_id') ? old('sell_id') : (!empty($saleCancellation) ? $saleCancellation->sell_id : null),['class' => 'form-control','id' => 'sell_id', 'autocomplete'=>"off"])}}
            </div>
        </div>
        <div class="col-12">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="sold_price">Sold Price<span class="text-danger">*</span></label>
                <input type="number" id="sold_price"  name="sold_price" value="{{old('sold_price') ? old('sold_price') : (!empty($saleCancellation) ? $saleCancellation->sell->total_value : null)}}" class="form-control form-control-sm" readonly tabindex="-1">
            </div>
        </div>
        <div class="col-12">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="paid_amount">Paid Amount<span class="text-danger">*</span></label>
                <input type="number" id="paid_amount"  name="paid_amount" value="{{old('paid_amount') ? old('paid_amount') : (!empty($saleCancellation) ? $saleCancellation->paid_amount : null)}}" class="form-control form-control-sm" readonly tabindex="-1">
            </div>
        </div>

        <div class="col-12">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="service_charge">Service Charge<span class="text-danger">*</span></label>
                <input type="number" id="service_charge" name="service_charge" value="{{old('service_charge') ? old('service_charge') : (!empty($saleCancellation) ? $saleCancellation->service_charge : null)}}" class="form-control form-control-sm" data-toggle="tooltip" title="In Percentage (%)">
            </div>
        </div>

        <div class="col-12">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="deducted_amount">Deducted Amount<span class="text-danger">*</span></label>
                <input type="number" id="deducted_amount" name="deducted_amount" value="{{old('deducted_amount') ? old('deducted_amount') : (!empty($saleCancellation) ? $saleCancellation->deducted_amount : null)}}" class="form-control form-control-sm" tabindex="-1">
            </div>
        </div>
        <div class="col-12">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="refund_amount">Refund Amount<span class="text-danger">*</span></label>
                <input type="number" id="refund_amount" name="refund_amount" value="{{old('refund_amount') ? old('refund_amount') : (!empty($saleCancellation) ? $saleCancellation->refund_amount : null)}}" class="form-control form-control-sm" readonly tabindex="-1">
            </div>
        </div>

        <div class="col-12">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="attachment">Attachment</label>
                {{Form::file('attachment', ['class' => 'form-control','id' => 'attachment'])}}
            </div>
            <p class="text-right">
                @if(!empty($saleCancellation) && $saleCancellation->attachment)
                    <strong><a href="{{asset("storage/$saleCancellation->attachment")}}" target="_blank"> See Current Attachment </a></strong>
                @endif
            </p>
        </div>
        <div class="col-12">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="remarks">Remarks</label>
                {{Form::textarea('remarks', old('remarks') ? old('remarks') : (!empty($saleCancellation->remarks) ? $saleCancellation->remarks : null),['class' => 'form-control', 'id' => 'remarks', 'rows'=>2, 'autocomplete'=>"off"] )}}
            </div>
        </div>




    </div> <!-- row -->

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
        function loadSoldClientsWithApartment(){
            let dropdown = $('#sell_id');
            let oldSelectedItem = "{{old('sell_id') ? old('sell_id') : (!empty($saleCancellation->sell_id) ? $saleCancellation->sell_id : null)}}";
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
            let sell_id = $("#sell_id").val();
            if(sell_id){
                let url =`{{url("loadSoldApartmentInformation")}}/${sell_id}`;
                fetch(url)
                .then((resp) => resp.json())
                .then(function(soldinformation) {
                    $("#sold_price").val(soldinformation.total_value);
                    $("#paid_amount").val(soldinformation.sales_collection_details_sum_amount);
                })
                .catch(function () {
                    $("#sold_price, #paid_amount").val(null);
                });
            }
        }
        function calculateRefund(){
            let sold_price = $("#sold_price").val();
            let paid_amount = $("#paid_amount").val();
            let service_charge = $("#service_charge").val();
            let deducted_amount = (sold_price / 100 * service_charge).toFixed(2);
            $("#deducted_amount").val(deducted_amount);
            $("#refund_amount").val((paid_amount - deducted_amount).toFixed(2));
        }

        function calculateRefundAmount(){
            let sold_price = $("#sold_price").val();
            let paid_amount = $("#paid_amount").val();
            let deducted_amount = $("#deducted_amount").val();
            let service_charge = (deducted_amount * 100 /sold_price).toFixed(2);
            $("#service_charge").val(service_charge);
            $("#refund_amount").val((paid_amount - deducted_amount).toFixed(2));
        }

        var CSRF_TOKEN = "{{csrf_token()}}";
        $(function(){
            @if(old() || $formType == 'edit')
                loadSoldClientsWithApartment();
            @endif

            $("#applied_date").datepicker({format: "dd-mm-yyyy",autoclose: true,todayHighlight: true,showOtherMonths: true});
            loadSoldApartmentInformation();

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
            $("#sell_id").on('change', function(){
                loadSoldApartmentInformation();
            });

            $("#service_charge").on('change', function(){
                calculateRefund();
            });

            $("#deducted_amount").on('change', function(){
                calculateRefundAmount();
            });
        });//document.ready
    </script>
@endsection
