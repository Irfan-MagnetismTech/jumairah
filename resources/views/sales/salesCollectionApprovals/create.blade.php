@extends('layouts.backend-layout')
@section('title', 'Sales Collection Approval')

@section('breadcrumb-title')
    @if (!empty($salesCollectionApproval))
        Edit Sale Collection Approval
    @else
        Add Sale Collection Approval
    @endif
@endsection

@section('breadcrumb-button')
    <a href="{{ url('salesCollectionApprovals') }}" class="btn btn-out-dashed btn-sm btn-warning"><i
            class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', null)

@section('content')
    @if (!empty($salesCollectionApproval))
        {!! Form::open([
            'url' => "salesCollectionApprovals/$salesCollectionApproval->id",
            'encType' => 'multipart/form-data',
            'method' => 'PUT',
            'class' => 'custom-form',
        ]) !!}
    @else
        {!! Form::open([
            'url' => 'salesCollectionApprovals',
            'method' => 'POST',
            'encType' => 'multipart/form-data',
            'class' => 'custom-form',
        ]) !!}
    @endif
    <div class="row">
        <input type="hidden" value="{{ !empty($saleCollection) ? $saleCollection->id : null }}">
        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="client_name">Client Name</label>
                {{ Form::text('client_name', old('client_name') ? old('client_name') : (!empty($saleCollection) ? $saleCollection->sell->sellClient->client->name : null), ['class' => 'form-control', 'id' => 'saleCollection_name', 'autocomplete' => 'off', 'required', 'readonly', 'tabindex' => '-1']) }}
                {{ Form::hidden('salecollection_id', old('salecollection_id') ? old('salecollection_id') : (!empty($saleCollection) ? $saleCollection->id : null), ['class' => 'form-control', 'id' => 'saleCollection_id', 'autocomplete' => 'off', 'required']) }}
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="project_name">Project Name</label>
                {{ Form::text('project_name', old('project_name') ? old('project_name') : (!empty($saleCollection) ? $saleCollection->sell->apartment->project->name : null), ['class' => 'form-control', 'id' => 'project_name', 'autocomplete' => 'off', 'required', 'readonly', 'tabindex' => '-1']) }}
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="apartment_id">Apartment ID</label>
                {{ Form::text('apartment_id', old('apartment_id') ? old('apartment_id') : (!empty($saleCollection) ? $saleCollection->sell->apartment->name : null), ['class' => 'form-control', 'id' => 'apartment_id', 'autocomplete' => 'off', 'required', 'readonly', 'tabindex' => '-1']) }}
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="payment_info">Payment Mode</label>
                {{ Form::text('payment_info', old('payment_info') ? old('payment_info') : (!empty($saleCollection) ? $saleCollection->payment_mode : null), ['class' => 'form-control', 'id' => 'payment_info', 'autocomplete' => 'off', 'required', 'readonly', 'tabindex' => '-1']) }}
            </div>
        </div>


        <div class="col-xl-4 col-md-6 " id="">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="source_name">Bank Name</label>
                {{ Form::text('source_name', old('source_name') ? old('source_name') : (!empty($saleCollection) ? $saleCollection->source_name : null), ['class' => 'form-control', 'id' => 'received_date', 'autocomplete' => 'off', 'required', 'readonly', 'tabindex' => '-1']) }}
            </div>
        </div>

        <div class="col-xl-4 col-md-6 " id="transaction_no_area">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="transaction_no">Payment No</label>
                {{ Form::text('transaction_no', old('transaction_no') ? old('transaction_no') : (!empty($saleCollection) ? $saleCollection->transaction_no : null), ['class' => 'form-control', 'id' => 'received_date', 'autocomplete' => 'off', 'required', 'readonly', 'tabindex' => '-1']) }}
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="amount">Amount</label>
                {{ Form::text('receive_amount', old('receive_amount') ? old('receive_amount') : (!empty($saleCollection) ? number_format($saleCollection->received_amount, 2) : null), ['class' => 'form-control', 'id' => 'receive_amount', 'autocomplete' => 'off', 'required', 'readonly', 'tabindex' => '-1']) }}
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="received_date">Received Date</label>
                {{ Form::text('received_date', old('received_date') ? old('received_date') : (!empty($saleCollection) ? $saleCollection->received_date : null), ['class' => 'form-control', 'id' => 'received_date', 'autocomplete' => 'off', 'required', 'readonly', 'tabindex' => '-1']) }}
            </div>
        </div>
        <div class="col-xl-4 col-md-6 " id="dated_area">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="dated">Dated</label>
                {{ Form::text('dated', old('dated') ? old('dated') : (!empty($saleCollection) ? $saleCollection->dated : null), ['class' => 'form-control', 'id' => 'dated', 'autocomplete' => 'off', 'required', 'readonly', 'tabindex' => '-1']) }}
            </div>
        </div>
    </div>
    <hr class="bg-success">
    <div class="row">
        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="approval_status">Approval Status<span
                        class="text-danger">*</span></label>
                {{ Form::select('approval_status', $approval_status, old('approval_status') ? old('approval_status') : (!empty($salesCollectionApproval->approval_status) ? $salesCollectionApproval->approval_status : null), ['class' => 'form-control', 'id' => 'approval_status', 'autocomplete' => 'off', 'required', 'tabindex' => '-1', 'placeholder' => 'Select Status']) }}
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="date">Approval Date<span class="text-danger">*</span></label>
                {{ Form::text('approval_date', old('approval_date') ? old('approval_date') : (!empty($salesCollectionApproval->approval_date) ? $salesCollectionApproval->approval_date : Carbon\Carbon::now()), ['class' => 'form-control', 'id' => 'approval_date', 'autocomplete' => 'off', 'required', 'readonly']) }}
            </div>
        </div>

        @if ($saleCollection->payment_mode == 'Adjustment')
            <div class="col-xl-4 col-md-6 " id="">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="sundry_creditor_name">Supplier Name <span
                            class="text-danger">*</span></label>
                    {{ Form::text('sundry_creditor_name', old('sundry_creditor_name') ? old('sundry_creditor_name') : (!empty($salesCollectionApproval) ? $salesCollectionApproval->sundryCreditor->account_name : null), ['class' => 'form-control', 'id' => 'sundry_creditor_name', 'autocomplete' => 'off', 'required']) }}
                    {{ Form::hidden('sundry_creditor_account_id', old('sundry_creditor_account_id') ? old('sundry_creditor_account_id') : (!empty($salesCollectionApproval->sundry_creditor_account_id) ? $salesCollectionApproval->sundry_creditor_account_id : null), ['class' => 'form-control', 'id' => 'sundry_creditor_account_id', 'autocomplete' => 'off', 'placeholder' => 'Select Bank', 'required']) }}
                </div>
            </div>
        @else
            <div class="col-xl-4 col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="bank_date">Bank Date</label>
                    {{ Form::text('bank_date', old('bank_date') ? old('bank_date') : (!empty($saleCollection->bank_date) ? $saleCollection->bank_date : Carbon\Carbon::now()), ['class' => 'form-control', 'id' => 'bank_date', 'autocomplete' => 'off', 'readonly']) }}
                </div>
            </div>
            <div class="col-xl-4 col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="date">Bank Name <span class="text-danger">*</span> </label>
                    {{ Form::text('bank_account_name', old('bank_account_name') ? old('bank_account_name') : (!empty($salesCollectionApproval->bancAccount->account_name) ? $salesCollectionApproval->bancAccount->account_name : null), ['class' => 'form-control', 'id' => 'bank_account_name', 'autocomplete' => 'off', 'placeholder' => 'Select Bank', 'required']) }}
                    {{ Form::hidden('bank_account_id', old('bank_account_id') ? old('bank_account_id') : (!empty($salesCollectionApproval->bank_account_id) ? $salesCollectionApproval->bank_account_id : null), ['class' => 'form-control', 'id' => 'bank_account_id', 'autocomplete' => 'off', 'placeholder' => 'Select Bank', 'required']) }}
                </div>
            </div>
        @endif
    </div>
    <div class="row">
        <div class="col-xl-8 col-md-8">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="reason">Reason</label>
                @php
                    $installment_no = '';
                    $dated = $saleCollection->dated ? $saleCollection->dated . ' || ' : '';
                    $transaction_no = $saleCollection->transaction_no ? $saleCollection->transaction_no . ' || ' : '';
                    foreach ($saleCollection->salesCollectionDetails as $saleCollectionDetail) {
                        if ($saleCollectionDetail->installment_no != '') {
                            $installment_no .= $saleCollectionDetail->installment_no;
                        }
                    }
                @endphp
                {{ Form::textarea('reason', old('reason') ? old('reason') : (!empty($salesCollectionApproval->reason) ? $salesCollectionApproval->reason : $dated . $transaction_no . $installment_no), ['class' => 'form-control', 'id' => 'reason', 'rows' => 2, 'autocomplete' => 'off']) }}
            </div>
        </div>
    </div>
    <hr class="bg-success">

    <div class="row">
        <div class="col-xl-8 offset-2">
            @if ($saleCollection->payment_mode == 'Adjustment')
                <table class="table table-bordered text-right" id="billTable">
                    <thead class="text-center">
                        <tr class="bg-dark">
                            <th>Bill</th>
                            <th>Amount</th>
                            <th>
                                <button class="btn btn-success btn-sm addItem" type="button"><i
                                        class="fa fa-plus"></i></button>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="text-right">
                    </tbody>
                    <tfoot>
                        <tr>
                            <td>Total</td>
                            <td id=""><input type="text" readonly class="form-control text-right"
                                    id="total_bill"></td>
                        </tr>
                    </tfoot>
                </table>
            @endif
        </div>
    </div> <!-- end row -->

    <hr class="bg-success">

    <div class="row">
        <div class="offset-md-4 col-md-4 mt-2">
            <div class="input-group input-group-sm ">
                <button class="btn btn-success btn-round btn-block py-2">Submit</button>
            </div>
        </div>
    </div> <!-- end row -->
    {!! Form::close() !!}
@endsection
@section('script')
    <script>
        $("#bank_account_name").autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: "{{ route('bankAutoSuggest') }}",
                    type: 'post',
                    dataType: "json",
                    data: {
                        _token: "{{ csrf_token() }}",
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

        $("#sundry_creditor_name").autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: "{{ route('sundryCreditorAutoSuggest') }}",
                    type: 'post',
                    dataType: "json",
                    data: {
                        _token: "{{ csrf_token() }}",
                        search: request.term
                    },
                    success: function(data) {
                        response(data);
                    }
                });
            },
            select: function(event, ui) {
                $('#sundry_creditor_name').val(ui.item.label);
                $('#sundry_creditor_account_id').val(ui.item.value);
                return false;
            }
        });

        function addRow() {
            let row = `
                    <tr>
                        <td>
                            {{ Form::select('bill_no[]', [], null, ['class' => 'form-control bill_no', 'placeholder' => ' Select Bill ', 'autocomplete' => 'off']) }}
                        </td>
                        <td class="text-left">
                            {{ Form::text('bill_amount[]', null, ['class' => 'form-control text-right bill_amount', 'placeholder' => ' 0.00', 'autocomplete' => 'off']) }}
                        </td>
                        <td>
                            <button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i class="fa fa-minus"></i></button>
                        </td>
                    </tr>
                `;
            $('#billTable tbody').append(row);

        }

        function loadBill() {
            let account_id = $("#sundry_creditor_account_id").val();
            const url = '{{ url('unpaidBill') }}/' + account_id;
            // let oldSelectedItem = "{{ old('bill_no)', $voucher->bill_no ?? '') }}";
            // alert(this);
            let dropdown;
            $('.bill_no').each(function() {
                dropdown = $(this).closest('tr').find('.bill_no');
            });
            dropdown.empty();
            dropdown.append('<option selected="true" disabled> Select Bill </option>');
            dropdown.prop('selectedIndex', 0);
            $.getJSON(url, function(items) {
                // console.log(items);
                $.each(items, function(key, billData) {
                    // let select = (oldSelectedItem == billData) ? "selected" : null;
                    let options = $('<option></option>').attr('value', billData).text(billData);
                    dropdown.append(options);
                })
            });
        }

        $(document).on('change', '.bill_no', function() {
            loadBillAmount($(this));
        });

        function loadBillAmount(bill_no) {
            let bill_Id = bill_no.closest('tr').find('.bill_no').val();
            const url = '{{ url('loadBillAmount') }}/' + bill_Id;
            fetch(url)
                .then((resp) => resp.json())
                .then(function(data) {
                    let trt = bill_no.closest('tr').find(".bill_amount").val(data.toLocaleString(undefined, {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    }));
                    totalBill();
                })
        }

        function totalBill() {
            let collectionAmount = $("#receive_amount").val();
            var total = 0;
            if ($(".bill_amount").length > 0) {
                $(".bill_amount").each(function(i, row) {
                    var amountTK = Number($(row).val().replace(/,/g, ''));
                    total += parseFloat(amountTK);
                })
            }
            $("#total_bill").val(total.toLocaleString(undefined, {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }));
            // $("#total_bill").val(total);
            // $("#total_bill").attr('max', collectionAmount);
        }

        $("form").submit(function(event) {
            let totalBill = $("#total_bill").val().replace(/,/g, '');
            let recvAmount = $("#receive_amount").val().replace(/,/g, '');

            if (recvAmount == totalBill) {
                return;
            }
            alert('Please Make Sure Creditors Total Bill Amount is Equal to Received Amount');
            event.preventDefault();
        });

        $(function() {
            $(document).on('click', '.deleteItem', function() {
                $(this).closest('tr').remove();
            });
            $(document).on('keyup', ".bill_amount", function() {
                totalBill();
                addComma(this);
            });
            $(document).on('click', ".addItem", function() {
                addRow();
                totalBill()
                loadBill();
            });

            function addComma(thisVal) {
                $(thisVal).keyup(function(event) {
                    if (event.which >= 37 && event.which <= 40) return;
                    $(this).val(function(index, value) {
                        return value.replace(/[^0-9\.]/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                    });
                });
            }

            $('#approval_date').datepicker({
                format: "dd-mm-yyyy",
                autoclose: true,
                todayHighlight: true,
                showOtherMonths: true
            });

            $('#bank_date').datepicker({
                format: "dd-mm-yyyy",
                autoclose: true,
                todayHighlight: true,
                showOtherMonths: true
            });
            //
            // $('#approval_date').on('mouseenter', function(){
            //     $(this).datepicker({format: "dd-mm-yyyy",autoclose: true,todayHighlight: true,showOtherMonths: true});
            // });
        }); //document.ready
    </script>
@endsection
