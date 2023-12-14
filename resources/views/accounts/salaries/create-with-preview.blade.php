@extends('layouts.backend-layout')
@section('title', 'Vouchers')

@section('breadcrumb-title')
    @if($formType == 'edit')
        Edit Vouchers
    @else
        Add New Vouchers
    @endif
@endsection

@section('style')
    <style>
        #voucher_preview tr > td, #voucher_preview thead > tr > th{
            border:1px solid #000000 !important;
        }
        #voucher_preview thead > th{
            background: gray!important;
        }
        #voucher_preview tr > td{
            color: #000000;
            font-weight:bold;

        }
    </style>
@endsection

@section('breadcrumb-button')
    <a href="{{ url('vouchers') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', null)

@section('content')

    @if($formType == 'edit')
        {!! Form::open(array('url' => "vouchers/$voucher->id",'method' => 'PUT', 'class'=>'custom-form')) !!}
    @else
        {!! Form::open(array('url' => "vouchers",'method' => 'POST', 'class'=>'custom-form')) !!}
    @endif
    <div class="row">
        <div class="col-md-5">
            <div class="row">
                <div class="col-12">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="date"> Date <span class="text-danger">*</span></label>
                        {{Form::text('date', old('date') ? old('date') : (!empty($voucher->date) ?  date('d-m-Y',strtotime($voucher->date)) : now()->format('d-m-Y')),['class' => 'form-control','id' => 'date', 'autocomplete'=>"off", 'required'])}}
                    </div>
                </div>
                <div class="col-12 ">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="reason">Voucher Type<span class="text-danger">*</span></label>
                        {{Form::select('voucher_type', $types, old('voucher_type') ? old('voucher_type') : (!empty($voucher->voucher_type) ? $voucher->voucher_type : null),['class' => 'form-control','id' => 'voucher_type', 'placeholder'=>" Voucher Type", 'autocomplete'=>"off"])}}
                    </div>
                </div>
                <div class="col-12 ">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="dr_account">Dr. Account <span class="text-danger">*</span></label>
                        {{Form::text('dr_account', old('dr_account') ? old('dr_account') : (!empty($voucher->dr_account) ? $voucher->dr_account : null),['class' => 'form-control','id' => 'dr_account', 'placeholder'=>" Debit Head", 'autocomplete'=>"off"])}}
                        {{Form::hidden('dr_account_id', old('dr_account_id') ? old('dr_account_id') : (!empty($voucher->dr_account_id) ? $voucher->dr_account_id : null),['class' => 'form-control','id' => 'dr_account_id', 'placeholder'=>" Debit Head", 'autocomplete'=>"off"])}}
                    </div>
                </div>
                <div class="col-12 ">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="reason">Cr. Account <span class="text-danger">*</span></label>
                        {{Form::text('cr_account', old('cr_account') ? old('cr_account') : (!empty($voucher->cr_account) ? $voucher->cr_account : null),['class' => 'form-control','id' => 'cr_account', 'placeholder'=>" Credit Head", 'autocomplete'=>"off"])}}
                        {{Form::hidden('cr_account_id', old('cr_account_id') ? old('cr_account_id') : (!empty($voucher->cr_account_id) ? $voucher->cr_account_id : null),['class' => 'form-control','id' => 'cr_account_id', 'placeholder'=>" Credit Head", 'autocomplete'=>"off"])}}
                    </div>
                </div>
                <div class="col-12">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="cheque_no"> Cheque No <span class="text-danger">*</span></label>
                        {{Form::text('cheque_no', old('cheque_no') ? old('cheque_no') : (!empty($voucher->cheque_no) ?  date('d-m-Y',strtotime($voucher->cheque_no)) : null),['class' => 'form-control','id' => 'cheque_no', 'autocomplete'=>"off", 'required'])}}
                    </div>
                </div>
                <div class="col-12">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="cheque_no"> Amount (Tk.) <span class="text-danger">*</span></label>
                        {{Form::number('amount', old('amount') ? old('amount') : (!empty($voucher->amount) ?  $voucher->amount : null),['class' => 'form-control','id' => 'amount', 'steo' => '0.05', 'autocomplete'=>"off", 'required'])}}
                    </div>
                </div>
                <div class="col-12">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="narration">Narration<span class="text-danger">*</span></label>
                        {{Form::textarea('narration', old('narration') ? old('narration') : (!empty($voucher->narration) ? $voucher->narration : null),['class' => 'form-control','id' => 'narration', 'autocomplete'=>"off", 'rows'=>2])}}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="offset-md-4 col-md-4 mt-2">
                    <div class="input-group input-group-sm ">
                        <button class="btn btn-success btn-round btn-block py-2">Submit</button>
                    </div>
                </div>
            </div> <!-- end row -->
        </div>
        <div class="col-md-7 p-1" id="voucher_preview" style="border: 1px solid #8a8a8a">
            <h6 class="text-center"> Voucher Preview</h6>
            <div class="text-center">
                <h5 class="text-center" id="voucher_title" style="display:inline-block; text-align: center; padding: 5px 10px; border: 1px solid #000000; border-radius: 30px">Voucher</h5>
            </div>

            <p class="mb-2 text-right font-weight-bold" id="preview_date">Date: </p>
            <table class="table table-bordered text-right">
                <thead class="text-center">
                    <tr class="bg-dark">
                        <th>Accounts Head</th>
                        <th>A/C Code</th>
                        <th>DEBIT</th>
                        <th>CREDIT</th>
                    </tr>
                </thead>
                <tbody class="text-right">
                    <tr id="debitRow">
                        <td class="text-left">
                            <span class="preview_account_name"></span> CEM Ready Mix Concrete Ltd.
                            <span class="preview_cheque_no"></span>
                        </td>
                        <td></td>
                        <td> <span class="preview_amount"></span></td>
                        <td></td>
                    </tr>
                    <tr id="creditRow">
                        <td class="text-left">
                            <span class="preview_account_name ml-4"> </span>
                            <span class="preview_cheque_no"></span>
                        </td>
                        <td></td>
                        <td></td>
                        <td> <span class="preview_amount"></span></td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2" class="text-right">TOTAL TK.</td>
                        <td> <span id="preview_total_debit"></span></td>
                        <td> <span id="preview_total_credit"></span></td>
                    </tr>
                </tfoot>
            </table>
            <p> Amount in Words: <strong id="preview_inwords"> </strong></p>
            <p> Narration: <strong id="preview_narration"></strong></p>
        </div>
    </div><!-- end row -->
        <!-- end row -->
    {!! Form::close() !!}

@endsection
@section('script')
    <script>
        var a = ['','one ','two ','three ','four ', 'five ','six ','seven ','eight ','nine ','ten ','eleven ','twelve ','thirteen ','fourteen ','fifteen ','sixteen ','seventeen ','eighteen ','nineteen '];
        var b = ['', '', 'twenty','thirty','forty','fifty', 'sixty','seventy','eighty','ninety'];

        function inWords (num) {
            if ((num = num.toString()).length > 9) return 'Too Large';
            n = ('000000000' + num).substr(-9).match(/^(\d{2})(\d{2})(\d{2})(\d{1})(\d{2})$/);
            if (!n) return; var str = '';
            str += (n[1] != 0) ? (a[Number(n[1])] || b[n[1][0]] + ' ' + a[n[1][1]]) + 'crore ' : '';
            str += (n[2] != 0) ? (a[Number(n[2])] || b[n[2][0]] + ' ' + a[n[2][1]]) + 'lakh ' : '';
            str += (n[3] != 0) ? (a[Number(n[3])] || b[n[3][0]] + ' ' + a[n[3][1]]) + 'thousand ' : '';
            str += (n[4] != 0) ? (a[Number(n[4])] || b[n[4][0]] + ' ' + a[n[4][1]]) + 'hundred ' : '';
            str += (n[5] != 0) ? ((str != '') ? 'and ' : '') + (a[Number(n[5])] || b[n[5][0]] + ' ' + a[n[5][1]]) + 'only ' : '';
            return str;
        }


        $(function(){
            $("#preview_date").text("Date : " + $("#date").val());
            $('#date').datepicker({format: "dd-mm-yyyy",autoclose: true,todayHighlight: true,showOtherMonths: true})
            .change(function(){
                $("#preview_date").text("Date : " + $(this).val());
            });

            $("#voucher_type").on('change', function(){
                let voucher_type = $(this).val();
                let background = null;
                if(voucher_type == "Payment"){
                    background = "#85A25C";
                }else if(voucher_type == "Receipt"){
                    background = "#F9D771";
                }else if(voucher_type == "Journal"){
                    background = "#BF7E7D";
                }else if(voucher_type == "Contra"){
                    background = "#F2F2F2";
                }else{
                    background = null;
                }
                $("#voucher_preview").css('background', background);
                $("#voucher_title").text(voucher_type + " Voucher");
            });

            $('input[type=radio][name=payment_type]').change(function() {
                if (this.value == 'Cash') {
                    $("#creditRow").find('.preview_account_name').text("Cash");
                }else{
                    $("#creditRow").find('.preview_account_name').text(null);
                }
            });

            $("#bank").change(function(){
                let selected_label = $(this).children("option:selected").text();
                $("#creditRow").find('.preview_account_name').text(selected_label);
            });

            $("#cheque_no").on('change, keyup', function(){
                let check_no = null;
                $(this).val().length > 0 ? check_no = "# " + $(this).val() : null;
                $("#creditRow").find('.preview_cheque_no').text(check_no);
            });

            $("#amount").on('change, keyup', function(){
                let amount = null;
                $(this).val().length > 0 ? amount = $(this).val() : null;
                $("#creditRow, #debitRow").find('.preview_amount').text(amount);
                $("#preview_total_debit, #preview_total_credit").text(amount);
                $("#preview_inwords").text("TAKA " + inWords(amount).toUpperCase() + "ONLY");
            });

            $("#narration").on('change, keyup', function(){
                let narration = null;
                $(this).val().length > 0 ? narration = $(this).val() : null;
                $("#preview_narration").text(narration);
            });
            $("#dr_account").on('change, keyup', function(){
                let selected_label = $(this).children("option:selected").text();
                $("#debitRow").find('.preview_account_name').text(selected_label);
            });


//            #debitRow
//            #creditRow
//            #preview_total_debit
//            #preview_total_credit

        }); //document.ready


        var CSRF_TOKEN = "{{csrf_token()}}";
        $( "#dr_account").autocomplete({
            source: function( request, response ) {
                $.ajax({
                    url:"{{url('api/account-name')}}",
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
                $('#dr_account').val(ui.item.label);
                $('#dr_account_id').val(ui.item.value);
                return false;
            }
        }); 
        $( "#cr_account").autocomplete({
            source: function( request, response ) {
                $.ajax({
                    url:"{{url('api/account-name')}}",
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
                $('#cr_account').val(ui.item.label);
                $('#cr_account_id').val(ui.item.value);
                return false;
            }
        });        

    </script>
@endsection

