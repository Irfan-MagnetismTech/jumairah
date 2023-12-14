@extends('layouts.backend-layout')
@section('title', 'IOU')

@section('breadcrumb-title')
    IOU Slip Approval
@endsection

@section('breadcrumb-button')
    <a href="{{ url('ious') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', null)

@section('content')
{{--    @if($formType == 'edit')--}}
        {!! Form::open(array('url' => "iouapprovals",'method' => 'POST', 'class'=>'custom-form')) !!}
{{--    @else--}}
{{--        {!! Form::open(array('url' => "ious",'method' => 'POST', 'class'=>'custom-form')) !!}--}}
{{--    @endif--}}
        <input type="hidden" name="iou_id" value="{{(old('iou_id') ? old('iou_id') : (!empty($iou->id) ? $iou->id : null))}}">
        <div class="row">
            <div class="col-xl-4 col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="applied_date">Applied Date<span class="text-danger">*</span></label>
                    {{Form::text('applied_date', old('applied_date') ? old('applied_date') : (!empty($iou->applied_date) ? $iou->applied_date : null),['class' => 'form-control','id' => 'applied_date','autocomplete'=>"off","required",'readonly'])}}
                </div>
            </div>
            @if(!empty($iou->supplier_id))
            <div class="col-xl-4 col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="project_id">Supplier Name<span class="text-danger">*</span></label>
                    {{Form::text('supplier_name', old('supplier_name') ? old('supplier_name') : (!empty($iou) ? $iou->supplier->name : null),['class' => 'form-control','id' => 'supplier_name','placeholder'=>"Search Supplier Name" ,'autocomplete'=>"off","readonly"])}}
                </div>
            </div>
            @else
            <div class="col-xl-4 col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="project_id">Employee Name<span class="text-danger">*</span></label>
                    {{Form::text('employee_name', old('employee_name') ? old('employee_name') : (!empty($iou) ? $iou->appliedBy->name : null),['class' => 'form-control','id' => 'employee_name','placeholder'=>"Search Supplier Name" ,'autocomplete'=>"off","readonly"])}}
                </div>
            </div>
            @endif
            <div class="col-xl-4 col-md-6 d-none" id="source_name_area">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="date">Bank Name<span class="text-danger">*</span></label>
                    {{Form::text('bank_account_name', old('bank_account_name') ? old('bank_account_name') : (!empty($salesCollectionApproval->bank_account_name) ? $salesCollectionApproval->bank_account_name : null),['class' => 'form-control','id' => 'bank_account_name','autocomplete'=>"off", 'placeholder'=>"Select Bank",])}}
                    {{Form::hidden('bank_account_id', old('bank_account_id') ? old('bank_account_id') : (!empty($salesCollectionApproval->bank_account_id) ? $salesCollectionApproval->bank_account_id : null),['class' => 'form-control','id' => 'bank_account_id','autocomplete'=>"off", 'placeholder'=>"Select Bank"])}}
                </div>
            </div>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-xl-4 col-md-6">
                        <div class="input-group input-group-sm input-group-primary">
                            <label class="input-group-addon" for="payment_mode">Payment Mode <span class="text-danger">*</span></label>
                            {{Form::select('payment_mode', $paymentsMode, old('payment_mode') ? old('payment_mode') : (!empty($salesCollection->payment_mode) ? $salesCollection->payment_mode : null),['class' => 'form-control', 'id' => 'payment_mode', 'placeholder' => 'Select Payment Mode', 'autocomplete'=>"off",'required'] )}}
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6 d-none" id="dated_area">
                        <div class="input-group input-group-sm input-group-primary">
                            <label class="input-group-addon" for="cheque_type">Cheque Date<span class="text-danger">*</span></label>
                            {{Form::text('cheque_date', old('cheque_date') ? old('cheque_date') : (!empty($voucher) ? $voucher->cheque_date : null),['class' => 'form-control','id' => 'cheque_date', 'autocomplete'=>"off", 'rows'=>2])}}
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6 d-none" id="transaction_no_area">
                        <div class="input-group input-group-sm input-group-primary">
                            <label class="input-group-addon" for="cheque_number">Cheque Number<span class="text-danger">*</span></label>
                            {{Form::text('cheque_number', old('cheque_number') ? old('cheque_number') : (!empty($voucher) ? $voucher->cheque_number : null),['class' => 'form-control','id' => 'cheque_number', 'autocomplete'=>"off", 'rows'=>2])}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="narration">Narration</label>
                    {{Form::textarea('narration', old('narration') ? old('narration') : (!empty($iou->narration) ? $iou->narration : null),['class' => 'form-control','id' => 'narration', 'rows'=>2])}}
                </div>
            </div>
        </div><!-- end row -->

    <hr class="bg-success">

    <div class="row">
        <div class="offset-md-4 col-md-4 mt-2">
            <div class="input-group input-group-sm ">
                <button class="btn btn-success btn-round btn-block py-2">Approved</button>
            </div>
        </div>
    </div> <!-- end row -->
<br>
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-sm text-center" id="itemTable">
            <thead>
            <tr>
                <th >Particulars<span class="text-danger">*</span></th>
                <th >Remarks</th>
                <th class="text-right">Amount</th>
            </tr>
            </thead>
            <tbody>
                @foreach($iou->ioudetails as $key => $ioudetail)
                    <tr>
                        <td> {{$ioudetail->purpose}} {{$ioudetail->po_no ? "- $ioudetail->po_no" : ''}} </td>
                        <td> {{$ioudetail->remarks}}</td>
                        <td class="text-right">@money($ioudetail->amount) </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
            <tr>
                <td colspan="2" class="text-right">Total </td>
                <td class="text-right"> <strong>@money($iou->total_amount)</strong></td>
            </tr>
            </tfoot>
        </table>
    </div> <!-- end table responsive -->
    {!! Form::close() !!}
@endsection

@section('script')
    <script>
        $("#bank_account_name").autocomplete({
            source: function(request, response) {
                console.log(response)
                $.ajax({
                    url: "{{ route('bankAutoSuggest') }}",
                    type: 'post',
                    dataType: "json",
                    data: {
                        _token: "{{csrf_token()}}",
                        search: request.term
                    },
                    success: function(data) {
                        response(data);
                    }
                });
            },
            select: function(event, ui) {
                $('#bank_account_name').val(ui.item.label);
                $('#bank_account_id').val(ui.item.value);
                return false;
            }
        });

        $("#payment_mode").on('change', function(){
            checkPaymentMode();
        });

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
        // $('#applied_date',).datepicker({
        //     format: "dd-mm-yyyy",
        //     autoclose: true,
        //     todayHighlight: true,
        //     showOtherMonths: true
        // });

        $(function(){
            $('#approval_date, #cheque_date').datepicker({format: "dd-mm-yyyy",autoclose: true,todayHighlight: true,showOtherMonths: true});
        });
    </script>
@endsection
