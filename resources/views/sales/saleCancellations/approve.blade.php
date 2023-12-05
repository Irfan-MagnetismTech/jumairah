@extends('layouts.backend-layout')
@section('title', 'Sales Collection')

@section('breadcrumb-title')
        Approve Sale Cancellation
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
    {!! Form::open(array('url' => "approveSaleCancellation",'method' => 'POST','encType' =>"multipart/form-data", 'class'=>'custom-form')) !!}
    <div class="row">
        <input type="hidden" name="sale_cancellation_id" value="{{old('sale_cancellation_id') ? old('sale_cancellation_id') : (!empty($saleCancellation->id) ? $saleCancellation->id : null)}}">
        <div class="col-12">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="applied_date">Applied Date <span class="text-danger">*</span></label>
                <input type="text" readonly class="form-control" id="applied_date"  name="applied_date" value="{{old('applied_date') ? old('applied_date') : (!empty($saleCancellation->applied_date) ? $saleCancellation->applied_date : null)}}">
            </div>
        </div>
        <div class="col-12">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="cancelled_by">Cancelled By<span class="text-danger">*</span></label>
                <input type="text" readonly class="form-control" id="cancelled_by"  name="cancelled_by" value="{{old('cancelled_by') ? old('cancelled_by') : (!empty($saleCancellation->cancelled_by) ? $saleCancellation->cancelled_by : null)}}">
            </div>
        </div>

        <div class="col-12">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="project_name">Project Name<span class="text-danger">*</span></label>
                {{Form::text('project_name', old('project_name') ? old('project_name') : (!empty($saleCancellation) ? $saleCancellation->sell->apartment->project->name : null),['class' => 'form-control','id' => 'project_name', 'autocomplete'=>"off",'readonly'])}}
            </div>
        </div>

        <div class="col-12">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="sell_id">Client Name<span class="text-danger">*</span></label>
                {{Form::text('client_name', old('client_name') ? old('client_name') : (!empty($saleCancellation) ? $saleCancellation->sell->sellClient->client->name.' ['.$saleCancellation->sell->apartment->name.']' : null),['class' => 'form-control','id' => 'client_name', 'autocomplete'=>"off",'readonly'])}}
            </div>
        </div>
        <div class="col-12">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="sold_price">Sold Price<span class="text-danger">*</span></label>
                <input type="number" id="sold_price" name="sold_price" value="{{old('sold_price') ? old('sold_price') : (!empty($saleCancellation) ? $saleCancellation->sell->total_value : null)}}" class="form-control form-control-sm" readonly tabindex="-1">
            </div>
        </div>
        <div class="col-12">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="paid_amount">Paid Amount<span class="text-danger">*</span></label>
                <input type="number" id="paid_amount"  name="paid_amount" value="{{old('paid_amount') ? old('paid_amount') : (!empty($saleCancellation) ? $saleCancellation->paid_amount : null)}}" class="form-control form-control-sm" readonly tabindex="-1">
            </div>
        </div>

        <div class="col-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="service_charge">Service Charge <span class="text-danger">*</span></label>
                <input type="number" id="service_charge" name="service_charge" value="{{old('service_charge') ? old('service_charge') : (!empty($saleCancellation) ? $saleCancellation->service_charge : null)}}" class="form-control form-control-sm" data-toggle="tooltip" readonly title="In Percentage (%)">
            </div>
        </div>

        <div class="col-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="deducted_amount">Deducted Amount<span class="text-danger">*</span></label>
                <input type="number" id="deducted_amount" name="deducted_amount" value="{{old('deducted_amount') ? old('deducted_amount') : (!empty($saleCancellation) ? $saleCancellation->deducted_amount : null)}}" class="form-control form-control-sm" readonly tabindex="-1">
            </div>
        </div>

        <div class="col-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="approved_service_charge">Approved Charge<span class="text-danger">*</span></label>
                <input type="number" id="approved_service_charge" name="approved_service_charge" value="{{old('approved_service_charge') ? old('approved_service_charge') : (!empty($saleCancellation->approved_service_charge) ? $saleCancellation->approved_service_charge :  $saleCancellation->service_charge)}}" class="form-control form-control-sm" data-toggle="tooltip" title="In Percentage (%)" min="0" autofocus>
            </div>
        </div>
        <div class="col-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="approved_deducted_amount">Deducted Amount<span class="text-danger">*</span></label>
                <input type="number" id="approved_deducted_amount" name="approved_deducted_amount" value="{{old('approved_deducted_amount') ? old('approved_deducted_amount') : (!empty($saleCancellation->approved_deducted_amount) ? $saleCancellation->approved_deducted_amount : $saleCancellation->deducted_amount)}}" class="form-control form-control-sm" readonly tabindex="-1">
            </div>
        </div>

        <div class="col-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="discount_amount"> Discount <span class="text-danger">*</span></label>
                <input type="number" id="discount_amount" name="discount_amount" min="0" value="{{old('discount_amount') ? old('discount_amount') : (!empty($saleCancellation->discount_amount) ? $saleCancellation->discount_amount : $saleCancellation->discount_amount)}}" class="form-control form-control-sm">
            </div>
        </div>

        <div class="col-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="deducted_amount">Status<span class="text-danger">*</span></label>
                {{Form::select('status', ['1'=>'Approved','0'=>'Reject'],old('status') ? old('status') : (!empty($saleCancellation->status) ? $saleCancellation->status : null),['class' => 'form-control', 'id' => 'status', 'rows'=>2, 'autocomplete'=>"off", 'placeholder' =>'Select'] )}}

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
                <p class="text-right py-2 my-0 ml-2">
                    @if(!empty($saleCancellation) && $saleCancellation->attachment)
                        <strong><a href="{{asset($saleCancellation->attachment)}}" target="_blank"> See Attachment </a></strong>
                    @else
                        Not Uploaded
                    @endif
                </p>
            </div>
        </div>
        <div class="col-12">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="remarks">Remarks</label>
                {{Form::textarea('remarks', old('remarks') ? old('remarks') : (!empty($saleCancellation->remarks) ? $saleCancellation->remarks : null),['class' => 'form-control', 'id' => 'remarks', 'rows'=>2, 'autocomplete'=>"off", 'readonly'] )}}
            </div>
        </div>
    </div> <!-- row -->

    <div class="row">
        <div class="offset-md-4 col-xl-4 col-md-6 mt-2">
            <div class="input-group input-group-sm ">
                <button class="btn btn-success btn-round btn-block py-2">Approve</button>
            </div>
        </div>
    </div> <!-- end row -->

    {!! Form::close() !!}

@endsection
@section('script')
    <script>
        function calculateRefund(){
            let sold_price = $("#sold_price").val();
            let paid_amount = parseFloat($("#paid_amount").val());
            let service_charge = $("#approved_service_charge").val();
            let deducted_amount = parseFloat((sold_price / 100 * service_charge).toFixed(2));
            let discount_amount = $("#discount_amount").val() > 0 ? parseFloat($("#discount_amount").val()) : 0 ;
            $("#approved_deducted_amount").val(deducted_amount);
            $("#refund_amount").val((paid_amount + discount_amount - deducted_amount).toFixed(2));
        }

        var CSRF_TOKEN = "{{csrf_token()}}";
        $(function(){
            calculateRefund();

            $("#approved_service_charge, #discount_amount").on('change keyup', function(){
                calculateRefund();
            });
        });//document.ready
    </script>
@endsection
