@extends('layouts.backend-layout')
@section('title', 'Vouchers')

@section('breadcrumb-title')
    @if(!empty($voucher))
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
        select[readonly]
        {
            pointer-events: none;
        }
        .form-control{
            background: inherit;
            color: #000000;
        }
    </style>
@endsection

@section('breadcrumb-button')
    <a href="{{ url('accounts/vouchers') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', null)

@section('content')

    @if(!empty($voucher))
        {!! Form::open(array('url' => "accounts/vouchers/$voucher->id",'method' => 'PUT', 'class'=>'custom-form')) !!}
    @else
        {!! Form::open(array('url' => "accounts/vouchers",'method' => 'POST', 'class'=>'custom-form')) !!}
    @endif
        <div class="col-md-12 p-1" id="voucher_preview" style="border: 1px solid #8a8a8a">
            <div class="text-center">
                <h5 class="text-center" id="voucher_title" style="display:inline-block; text-align: center; padding: 5px 10px; border: 1px solid #000000; border-radius: 30px">Voucher</h5>
            </div>
            <div class="row py-2">
                <div class="col-4">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="reason">Voucher Type<span class="text-danger">*</span></label>
                        {{Form::select('voucher_type', $types, old('voucher_type') ? old('voucher_type') : (!empty($voucher) ? $voucher->voucher_type : null),['class' => 'form-control','id' => 'voucher_type', 'placeholder'=>" Voucher Type", 'autocomplete'=>"off", "required"])}}
                    </div>
                </div>
                <div class="col-4">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="bill_no"> Bill No</label>
                        {{Form::text('bill_no', old('bill_no') ? old('bill_no') : (!empty($voucher) ?  $voucher->bill_no : null),['class' => 'form-control','id' => 'bill_no', 'list' => 'bill_no_list', 'autocomplete'=>"off"])}}

                        <datalist id="bill_no_list">
                            @foreach($bills as $bill)
                                <option value="{{$bill}}">
                            @endforeach
                        </datalist>
                    </div>
                </div>
                <div class="col-4">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="transaction_date"> Date <span class="text-danger">*</span></label>
                        {{Form::text('transaction_date', old('transaction_date') ? old('transaction_date') : (!empty($voucher) ?  date('d-m-Y',strtotime($voucher->transaction_date)) : now()->format('d-m-Y')),['class' => 'form-control','id' => 'transaction_date', 'autocomplete'=>"off", 'required'])}}
                    </div>
                </div>
            </div>
        @php
            $accounts = old('account', !empty($voucher) ?  $voucher->ledgerEntries->pluck('account.account_name') : []);
            $account_ids = old('account_id', !empty($voucher) ?  $voucher->ledgerEntries->pluck('account_id') : []);
            $balance_line = old('account_id', !empty($voucher) ?  $voucher->ledgerEntries->pluck('account.balance_and_income_line_id') : []);
            $ref_bill = old('ref_bill', !empty($voucher) ?  $voucher->ledgerEntries->pluck('ref_bill') : []);
            $cost_center_names = old('project', !empty($voucher) ?  $voucher->ledgerEntries->pluck('costCenter.name') : []);
            $cost_center_ids = old('cost_center_id', !empty($voucher) ?  $voucher->ledgerEntries->pluck('cost_center_id') : []);
            $dr_amounts = old('dr_amount', !empty($voucher) ?  $voucher->ledgerEntries->pluck('dr_amount') : []);
            $cr_amounts = old('cr_amount', !empty($voucher) ?  $voucher->ledgerEntries->pluck('cr_amount') : []);
            $remarkss = old('remarks', !empty($voucher) ?  $voucher->ledgerEntries->pluck('remarks') : []);
        @endphp
        {{-- {{dd($account_id[0])}} --}}
            <table class="table table-bordered text-right" id="voucherTable">
                <thead class="text-center">
                    <tr class="bg-dark">
                        <th>Accounts</th>
                        <th>Ref Bill</th>
                        <th>Cost Center</th>
                        <th>Debit</th>
                        <th>Credit</th>
                        <th>Remarks</th>
                        <th>
                            <button class="btn btn-success btn-sm addItem" type="button"><i class="fa fa-plus"></i></button>
                        </th>
                    </tr>
                </thead>
                <tbody class="text-right">
                    @foreach ($accounts as $key => $account)
                        <tr>
                            <td class="text-left">
                                {{Form::text('account[]', $accounts[$key],['class' => 'form-control account','id' => 'account', 'placeholder'=>" Enter Account Name", 'autocomplete'=>"off"])}}
                                {{Form::hidden('account_id[]', $account_ids[$key],['class' => 'form-control account_id','id' => 'account_id'])}}
                            </td>
                            <td class="text-left">
                                @php $readonly = $balance_line[$key] != '34' ? 'readonly' : '';

                                @endphp
                                <div class="input-group">
                                    {{Form::select('ref_bill[]',$refBills, $ref_bill[$key],['class' => 'form-control account','id' => 'account', 'placeholder'=>" Enter Account Name", 'autocomplete'=>"off" ,$readonly])}}
                                    {{Form::text('bill_amount[]', null,['class' => 'form-control bill_amount text-right','id' => '', 'placeholder'=>" 0.00", 'autocomplete'=>"off",'readonly'])}}
                                </div>
                            </td>
                            <td>
                                {{Form::text('project[]', $cost_center_names[$key],['class' => 'form-control project','id' => 'project', 'placeholder'=>" Project Name", 'autocomplete'=>"off"])}}
                                {{Form::hidden('cost_center_id[]', $cost_center_ids[$key],['class' => 'form-control cost_center_id','id' => 'cost_center_id',])}}
                            </td>
                            <td>
                                {{Form::text('dr_amount[]', number_format($dr_amounts[$key],2),['class' => 'form-control dr_amount text-right','id' => 'dr_amount', 'step' => '0.05', 'autocomplete'=>"off"])}}
                            </td>
                            <td>
                                {{Form::text('cr_amount[]', number_format($cr_amounts[$key],2),['class' => 'form-control cr_amount text-right','id' => 'cr_amount', 'step' => '0.05', 'autocomplete'=>"off"])}}
                            </td>
                            <td>
                                {{Form::textarea('remarks[]', $remarkss[$key],['class' => 'form-control','id' => 'remarks', 'autocomplete'=>"off", 'rows'=>1])}}
                            </td>
                            <td>
                                <button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i class="fa fa-minus"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

                <tfoot>
                    <tr>
                        <td colspan="3" class="text-right">TOTAL TK.</td>
                        <td>
                            {{Form::text('total_dr_amount', old('total_dr_amount') ? old('total_dr_amount') : (!empty($voucher) ? $voucher->total_dr_amount : null),['class' => 'form-control total_dr_amount text-right','id' => 'total_dr_amount', "readonly"])}}
                        </td>
                        <td>
                            {{Form::text('total_cr_amount', old('total_cr_amount') ? old('total_cr_amount') : (!empty($voucher) ? $voucher->total_cr_amount : null),['class' => 'form-control total_cr_amount text-right','id' => 'total_cr_amount', "readonly"])}}
                        </td>
                        <td colspan="2"></td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="cheque_number">Cheque Number<span class="text-danger">*</span></label>
                                {{Form::text('cheque_number', old('cheque_number') ? old('cheque_number') : (!empty($voucher) ? $voucher->cheque_number : null),['class' => 'form-control','id' => 'cheque_number', 'autocomplete'=>"off", 'rows'=>2])}}
                            </div>
                        </td>
                        <td colspan="2">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="cheque_type">Payment Type<span class="text-danger">*</span></label>
                                {{Form::select('cheque_type',['A/C Payee' => 'A/C Payee','Cheque' => 'Cheque','Cash' =>'Cash','Pay Order' =>'Pay Order','Draft' =>'Draft'], old('cheque_type') ? old('cheque_type') : (!empty($voucher) ? $voucher->cheque_type : null),['class' => 'form-control','id' => 'cheque_type', 'placeholder' => 'Payment Type', 'autocomplete'=>"off", 'rows'=>2])}}
                            </div>
                        </td>
                        <td colspan="2">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="cheque_type">Cheque Date<span class="text-danger">*</span></label>
                                {{Form::text('cheque_date', old('cheque_date') ? old('cheque_date') : (!empty($voucher) ? $voucher->cheque_date : null),['class' => 'form-control','id' => 'cheque_date', 'autocomplete'=>"off", 'rows'=>2])}}
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="7">
                            <div class="input-group input-group-sm input-group-primary">
                                <label class="input-group-addon" for="narration">Narration<span class="text-danger">*</span></label>
                                {{Form::textarea('narration', old('narration') ? old('narration') : (!empty($voucher) ? $voucher->narration : null),['class' => 'form-control','id' => 'narration', 'autocomplete'=>"off", 'rows'=>2])}}
                            </div>
                        </td>
                    </tr>
                </tfoot>
            </table>
            <div class="row">
                <div class="offset-md-4 col-md-4 mt-2">
                    <div class="input-group input-group-sm ">
                        <button class="btn btn-success btn-round btn-block py-2">Submit</button>
                    </div>
                </div>
            </div> <!-- end row -->
        </div>
        <!-- end row -->
    {!! Form::close() !!}

@endsection
@section('script')
    <script>

        $(function(){
            @if(empty($voucher))
                addRow();
                addRow();
            @endif

            $('#transaction_date').datepicker({format: "dd-mm-yyyy",autoclose: true,todayHighlight: true,showOtherMonths: true});
            $('#cheque_date').datepicker({format: "dd-mm-yyyy",autoclose: true,todayHighlight: true,showOtherMonths: true});
            totalCredit()
            totalDebit();

            function addRow(){
                let row = `
                    <tr>
                        <td class="text-left">
                            {{Form::text('account[]', null,['class' => 'form-control account','id' => 'account', 'placeholder'=>" Enter Account Name", 'autocomplete'=>"off"])}}
                            {{Form::hidden('account_id[]', null,['class' => 'form-control account_id','id' => '', 'placeholder'=>" Credit Head", 'autocomplete'=>"off"])}}
                        </td>
                        <td class="text-left">
                            <div class="input-group">
                                {{Form::select('ref_bill[]',$refBills, null,['class' => 'form-control ref_bill','id' => '', 'placeholder'=>" Enter Bill", 'autocomplete'=>"off",'readonly'])}}
                                {{Form::text('bill_amount[]', null,['class' => 'form-control bill_amount text-right','id' => '', 'placeholder'=>" 0.00", 'autocomplete'=>"off",'readonly'])}}
                            </div>
                        </td>
                        <td>
                            {{Form::text('project[]', null,['class' => 'form-control project','id' => 'project', 'placeholder'=>" Project Name", 'autocomplete'=>"off"])}}
                            {{Form::hidden('cost_center_id[]', old('cost_center_id') ? old('cost_center_id') : (!empty($voucher) ? $voucher->cost_center_id : null),['class' => 'form-control cost_center_id','id' => 'cost_center_id', 'autocomplete'=>"off"])}}
                        </td>
                        <td>
                            {{Form::text('dr_amount[]', null,['class' => 'form-control dr_amount text-right','id' => 'dr_amount', 'step' => '0.05', 'autocomplete'=>"off"])}}
                        </td>
                        <td>
                            {{Form::text('cr_amount[]', null,['class' => 'form-control cr_amount text-right','id' => 'cr_amount', 'step' => '0.05', 'autocomplete'=>"off"])}}
                        </td>
                        <td>
                            {{Form::textarea('remarks[]', null,['class' => 'form-control','id' => 'remarks', 'autocomplete'=>"off", 'rows'=>1])}}
                        </td>
                        <td>
                            <button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i class="fa fa-minus"></i></button>
                        </td>
                    </tr>
                `;
                $('#voucherTable tbody').append(row);
            }

            $("#voucher_type").on('change', function(){
                let voucher_type = $(this).val();
                let background = null;
                if(voucher_type == "Payment"){
                    background = "#85A25C";
                }else if(voucher_type == "Receipt"){
                    background = "#F9D771";
                }else if(voucher_type == "Journal"){
                    background = "#F2F2F2";
                }else if(voucher_type == "Contra"){
                    background = "#BF7E7D";
                }else{
                    background = null;
                }
                $("#voucher_preview").css('background', background);
                $("#voucher_title").text(voucher_type + " Voucher");
            });

            var CSRF_TOKEN = "{{csrf_token()}}";
            $(document).on('keyup focus','.account',function () {
                let accountId = '';
                $(this).autocomplete({
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
                        $(this).val(ui.item.label);
                        $(this).closest('tr').find('.account_id').val(ui.item.value);
                        changeBill($(this), ui.item.balance_income_line_id);
                        return false;
                    }

                });

            });

            function changeBill(thisRow, balance_line){
                if (balance_line == 34){
                    thisRow.closest('tr').find('.ref_bill').attr('readonly',false)
                    let account_Id = thisRow.closest('tr').find('.account_id').val();
                    const url = '{{url("unpaidBill")}}/' + account_Id;
                    let oldSelectedItem = "{{ old('ref_bill)', $voucher->ref_bill ?? '') }}";
                    let dropdown = thisRow.closest('tr').find('.ref_bill');
                    dropdown.empty();
                    dropdown.append('<option selected="true" disabled> Enter Bill </option>');
                    dropdown.prop('selectedIndex', 0);

                    $.getJSON(url, function(items) {
                        console.log(items);
                        $.each(items, function(key, billData) {
                            let select = (oldSelectedItem == billData) ? "selected" : null;
                            let options = `<option value="${billData}" ${select}>${billData}</option>`;
                            dropdown.append(options);
                        })
                    });
                }else {
                    account.closest('tr').find('.ref_bill').attr('readonly',true)
                }
            }

            $(document).on('change','.ref_bill',function () {
                loadBillAmount($(this));
            });

            function loadBillAmount (bill_no){
                let bill_Id = bill_no.closest('tr').find('.ref_bill').val();
                const url = '{{url("loadBillAmount")}}/' + bill_Id;
                fetch(url)
                    .then((resp) => resp.json())
                    .then(function(data) {
                        let trt = bill_no.closest('tr').find(".bill_amount").val(data);
                    })
            }

            $(document).on('keyup','.project',function () {
                $(this).autocomplete({
                    source: function( request, response ) {
                        $.ajax({
                            url:"{{route('costCenterAutoSuggest')}}",
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
                        $(this).closest('tr').find('.cost_center_id').val(ui.item.value);
                        return false;
                    }
                });
            });

            function totalCredit(){
                var total = 0;
                if($(".cr_amount").length > 0){
                    $(".cr_amount").each(function(i, row){
                        var amountTK = Number($(row).val().replace(/,/g, ''));
                        total += parseFloat(amountTK);
                    })
                }
                $("#total_cr_amount").val(total.toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 }));
            }

            function totalDebit(){
                var total = 0;
                if($(".dr_amount").length > 0){
                    $(".dr_amount").each(function(i, row){
                        var amountTK = Number($(row).val().replace(/,/g, ''));
                        total += parseFloat(amountTK);
                    })
                }
                $("#total_dr_amount").val(total.toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 }));
            }
            $(document).on('keyup', ".cr_amount", function(){
                totalCredit();
            });
            $(document).on('keyup', ".dr_amount", function(){
                totalDebit();
            });

            $(document).on('keyup','.dr_amount, .cr_amount, #total_dr_amount, #total_cr_amount ',function (){
                addComma(this)
            });

            function addComma (thisVal){
                $(thisVal).keyup(function(event) {
                    if(event.which >= 37 && event.which <= 40) return;
                    $(this).val(function(index, value) {
                        return value .replace(/[^0-9\.]/g, "") .replace(/\B(?=(\d{3})+(?!\d))/g, ",") ;
                    });
                });
            }

            $(document).on('click', '.deleteItem', function(){
                $(this).closest('tr').remove();
                totalDebit();
                totalCredit();
            });
            $(document).on('click', ".addItem", function(){
                addRow();
            });


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

        }); //document.ready

    </script>
@endsection

