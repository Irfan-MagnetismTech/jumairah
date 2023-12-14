@extends('layouts.backend-layout')
@section('title', 'salaries')

@section('breadcrumb-title')
    @if(!empty($salary))
        Edit Salary
    @else
        Add Salary
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
    <a href="{{ url('accounts/salaries') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', null)

@section('content')

    @if(!empty($salary))
        {!! Form::open(array('url' => "accounts/salaries/$salary->id",'method' => 'PUT', 'class'=>'custom-form')) !!}
    @else
        {!! Form::open(array('url' => "accounts/salaries",'method' => 'POST', 'class'=>'custom-form')) !!}
    @endif
        <div class="col-md-12 p-1" id="" >
            <div class="row py-2">
                <div class="col-4">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="month"> Month <span class="text-danger">*</span></label>
                        {{Form::month('month', old('month') ? old('month') : (!empty($salary) ?  date('Y-m',strtotime($salary->month)) : now()->format('Y-m')),['class' => 'form-control','id' => 'month', 'autocomplete'=>"off", 'required'])}}
                    </div>
                </div>
            </div>
            <hr>
            @php
                $salary_head_ids = old('account_id', !empty($salary) ?  $salary->salaryDetails->pluck('salary_head_id') : []);
                //$balance_line = old('account_id', !empty($salary) ?  $salary->salaryDetails->pluck('account.balance_and_income_line_id') : []);
                $gross_salary = old('gross_salary', !empty($salary) ?  $salary->salaryDetails->pluck('gross_salary') : []);
                $fixed_allow = old('fixed_allow', !empty($salary) ?  $salary->salaryDetails->pluck('fixed_allow') : []);
                $area_bonus = old('area_bonus', !empty($salary) ?  $salary->salaryDetails->pluck('area_bonus') : []);
                $other_refund = old('other_refund', !empty($salary) ?  $salary->salaryDetails->pluck('other_refund') : []);
                $less_working_day = old('less_working_day', !empty($salary) ?  $salary->salaryDetails->pluck('less_working_day') : []);
                $payable = old('payable', !empty($salary) ?  $salary->salaryDetails->pluck('payable') : []);
                $pf = old('pf', !empty($salary) ?  $salary->salaryDetails->pluck('pf') : []);
                $other_deduction = old('other_deduction', !empty($salary) ?  $salary->salaryDetails->pluck('other_deduction') : []);
                $lwd_deduction = old('lwd_deduction', !empty($salary) ?  $salary->salaryDetails->pluck('lwd_deduction') : []);
                $advance_salary = old('advance_salary', !empty($salary) ?  $salary->salaryDetails->pluck('advance_salary') : []);
                $ait = old('ait', !empty($salary) ?  $salary->salaryDetails->pluck('ait') : []);
                $mobile_bill = old('mobile_bill', !empty($salary) ?  $salary->salaryDetails->pluck('mobile_bill') : []);
                $canteen = old('canteen', !empty($salary) ?  $salary->salaryDetails->pluck('canteen') : []);
                $pick_drop = old('pick_drop', !empty($salary) ?  $salary->salaryDetails->pluck('pick_drop') : []);
                $loan_deduction = old('loan_deduction', !empty($salary) ?  $salary->salaryDetails->pluck('loan_deduction') : []);
                $total_deduction = old('total_deduction', !empty($salary) ?  $salary->salaryDetails->pluck('total_deduction') : []);
                $net_payable = old('net_payable', !empty($salary) ?  $salary->salaryDetails->pluck('net_payable') : []);
                $remarks = old('remarks', !empty($salary) ?  $salary->salaryDetails->pluck('remarks') : []);
            @endphp
        {{-- {{dd($account_id[0])}} --}}
            <table class="table table-bordered table-responsive text-right" id="voucherTable">
                <thead class="text-center">
                    <tr class="bg-dark">
                        <th>Particulars</th>
                        <th>Gross</th>
                        <th>Fixed Allow</th>
                        <th>Arrear Bonus</th>
                        <th>Other Refund</th>
                        <th>LWD</th>
                        <th>Payable</th>
                        <th>PF</th>
                        <th> Other Deduction</th>
                        <th> LWD Deduction</th>
                        <th>Advance Salary</th>
                        <th>AIT</th>
                        <th>Mobile Bill</th>
                        <th>Canteen</th>
                        <th>Pick & Drop</th>
                        <th>Loan Deduction</th>
                        <th>Total Deduction</th>
                        <th>Net Payable</th>
                        <th>Remarks</th>
                        <th>
                            <button class="btn btn-success btn-sm addItem" type="button"><i class="fa fa-plus"></i></button>
                        </th>
                    </tr>
                </thead>
                <tbody class="text-right">
                    @foreach ($salary_head_ids as $key => $detail)
                        <tr>
                            <td class="text-left"> {{Form::select('salary_head_id[]',$salaryHeads, $salary_head_ids[$key],['style'=>'width:300px', 'class' => 'form-control','placeholder'=>" Particulars", 'autocomplete'=>"off"])}} </td>
                            <td>{{Form::text('gross_salary[]', number_format($gross_salary[$key],2),['style'=>'width:100px', 'class' => 'form-control gross_salary text-right', 'step' => '0.05', 'autocomplete'=>"off"])}}</td>
                            <td>{{Form::text('fixed_allow[]', number_format($fixed_allow[$key],2),['style'=>'width:100px', 'class' => 'form-control fixed_allow text-right', 'step' => '0.05', 'autocomplete'=>"off"])}}</td>
                            <td>{{Form::text('area_bonus[]', number_format($area_bonus[$key],2),['style'=>'width:100px', 'class' => 'form-control area_bonus text-right', 'step' => '0.05', 'autocomplete'=>"off"])}}</td>
                            <td>{{Form::text('other_refund[]', number_format($other_refund[$key],2),['style'=>'width:100px', 'class' => 'form-control other_refund text-right', 'step' => '0.05', 'autocomplete'=>"off"])}}</td>
                            <td>{{Form::text('less_working_day[]', number_format($less_working_day[$key],2),['style'=>'width:100px','class' => 'form-control less_working_day text-right', 'step' => '0.05', 'autocomplete'=>"off"])}}</td>
                            <td>{{Form::text('payable[]', number_format($payable[$key],2),['style'=>'width:100px', 'class' => 'form-control payable text-right', 'step' => '0.05', 'autocomplete'=>"off", 'readonly'])}}</td>
                            <td>{{Form::text('pf[]', number_format($pf[$key],2),['style'=>'width:100px', 'class' => 'form-control pf text-right', 'step' => '0.05', 'autocomplete'=>"off"])}}</td>
                            <td>{{Form::text('other_deduction[]', number_format($other_deduction[$key],2),['style'=>'width:100px', 'class' => 'form-control other_deduction text-right', 'step' => '0.05', 'autocomplete'=>"off"])}}</td>
                            <td>{{Form::text('lwd_deduction[]', number_format($lwd_deduction[$key],2),['style'=>'width:100px', 'class' => 'form-control lwd_deduction text-right', 'step' => '0.05', 'autocomplete'=>"off"])}}</td>
                            <td>{{Form::text('advance_salary[]', number_format($advance_salary[$key],2),['style'=>'width:100px', 'class' => 'form-control advance_salary text-right', 'step' => '0.05', 'autocomplete'=>"off"])}}</td>
                            <td>{{Form::text('ait[]', number_format($ait[$key],2),['style'=>'width:100px', 'class' => 'form-control ait text-right', 'step' => '0.05', 'autocomplete'=>"off"])}}</td>
                            <td>{{Form::text('mobile_bill[]', number_format($mobile_bill[$key],2),['style'=>'width:100px', 'class' => 'form-control mobile_bill text-right', 'step' => '0.05', 'autocomplete'=>"off"])}}</td>
                            <td>{{Form::text('canteen[]', number_format($canteen[$key],2),['style'=>'width:100px', 'class' => 'form-control canteen text-right', 'step' => '0.05', 'autocomplete'=>"off"])}}</td>
                            <td>{{Form::text('pick_drop[]', number_format($pick_drop[$key],2),['style'=>'width:100px', 'class' => 'form-control pick_drop text-right', 'step' => '0.05', 'autocomplete'=>"off"])}}</td>
                            <td>{{Form::text('loan_deduction[]', number_format($loan_deduction[$key],2),['style'=>'width:100px', 'class' => 'form-control loan_deduction text-right', 'step' => '0.05', 'autocomplete'=>"off"])}}</td>
                            <td>{{Form::text('total_deduction[]', number_format($total_deduction[$key],2),['style'=>'width:100px', 'class' => 'form-control total_deduction text-right', 'step' => '0.05', 'autocomplete'=>"off", 'readonly'])}}</td>
                            <td>{{Form::text('net_payable[]', number_format($net_payable[$key],2),['style'=>'width:100px', 'class' => 'form-control net_payable text-right', 'step' => '0.05', 'autocomplete'=>"off", 'readonly'])}}</td>
                            <td>{{Form::text('remarks[]', $remarks[$key],['style'=>'width:100px', 'class' => 'form-control remarks text-right', 'step' => '0.05', 'autocomplete'=>"off"])}}</td>
                            <td> <button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i class="fa fa-minus"></i></button></td>
                        </tr>
                    @endforeach
                </tbody>

                <tfoot>
                    <tr>
                        <td class="text-right"><b>TOTAL TK.</b></td>
                        <td><input type="text" class="form-control text-right" id="total_gross_salary" value="{{old('gross_salary') ? old('gross_salary') : (!empty($salary) ? number_format($salary->salaryDetails->flatten()->sum('gross_salary'), 2) : 0.00 ) }}" name="total_gross_salary" readonly></td>
                        <td><input type="text" class="form-control text-right" id="total_fixed_allow" value="{{old('fixed_allow') ? old('fixed_allow') : (!empty($salary) ? number_format($salary->salaryDetails->flatten()->sum('fixed_allow'), 2) : 0.00 ) }}" name="total_fixed_allow" readonly></td>
                        <td><input type="text" class="form-control text-right" id="total_area_bonus" value="{{old('area_bonus') ? old('area_bonus') : (!empty($salary) ? number_format($salary->salaryDetails->flatten()->sum('area_bonus'), 2) : 0.00 ) }}" name="total_area_bonus" readonly></td>
                        <td><input type="text" class="form-control text-right" id="total_other_refund" value="{{old('other_refund') ? old('other_refund') : (!empty($salary) ? number_format($salary->salaryDetails->flatten()->sum('other_refund'), 2) : 0.00 ) }}" name="total_other_refund" readonly></td>
                        <td></td>
                        <td><input type="text" class="form-control text-right" id="total_payable" value="{{old('payable') ? old('payable') : (!empty($salary) ? number_format($salary->salaryDetails->flatten()->sum('payable'), 2) : 0.00 ) }}" name="total_payable" readonly></td>
                        <td><input type="text" class="form-control text-right" id="total_pf" value="{{old('pf') ? old('pf') : (!empty($salary) ? number_format($salary->salaryDetails->flatten()->sum('pf'), 2) : 0.00 ) }}" name="total_pf" readonly></td>
                        <td><input type="text" class="form-control text-right" id="total_other_deduction" value="{{old('other_deduction') ? old('other_deduction') : (!empty($salary) ? number_format($salary->salaryDetails->flatten()->sum('other_deduction'), 2) : 0.00 ) }}" name="total_other_deduction" readonly></td>
                        <td><input type="text" class="form-control text-right" id="total_lwd_deduction" value="{{old('lwd_deduction') ? old('lwd_deduction') : (!empty($salary) ? number_format($salary->salaryDetails->flatten()->sum('lwd_deduction'), 2) : 0.00 ) }}" name="total_lwd_deduction" readonly></td>
                        <td><input type="text" class="form-control text-right" id="total_advance_salary" value="{{old('advance_salary') ? old('advance_salary') : (!empty($salary) ? number_format($salary->salaryDetails->flatten()->sum('advance_salary'), 2) : 0.00 ) }}" name="total_advance_salary" readonly></td>
                        <td><input type="text" class="form-control text-right" id="total_ait" value="{{old('ait') ? old('ait') : (!empty($salary) ? number_format($salary->salaryDetails->flatten()->sum('ait'), 2) : 0.00 ) }}" name="total_ait" readonly></td>
                        <td><input type="text" class="form-control text-right" id="total_mobile_bill" value="{{old('mobile_bill') ? old('mobile_bill') : (!empty($salary) ? number_format($salary->salaryDetails->flatten()->sum('mobile_bill'), 2) : 0.00 ) }}" name="total_mobile_bill" readonly></td>
                        <td><input type="text" class="form-control text-right" id="total_canteen" value="{{old('canteen') ? old('canteen') : (!empty($salary) ? number_format($salary->salaryDetails->flatten()->sum('canteen'), 2) : 0.00 ) }}" name="total_canteen" readonly></td>
                        <td><input type="text" class="form-control text-right" id="total_pick_drop" value="{{old('pick_drop') ? old('pick_drop') : (!empty($salary) ? number_format($salary->salaryDetails->flatten()->sum('pick_drop'), 2) : 0.00 ) }}" name="total_pick_drop" readonly></td>
                        <td><input type="text" class="form-control text-right" id="total_loan_deduction" value="{{old('loan_deduction') ? old('loan_deduction') : (!empty($salary) ? number_format($salary->salaryDetails->flatten()->sum('loan_deduction'), 2) : 0.00 ) }}" name="total_loan_deduction" readonly></td>
                        <td><input type="text" class="form-control text-right" id="total_total_deduction" value="{{old('total_deduction') ? old('total_deduction') : (!empty($salary) ? number_format($salary->salaryDetails->flatten()->sum('total_deduction'), 2) : 0.00 ) }}" name="total_total_deduction" readonly></td>
                        <td><input type="text" class="form-control text-right" id="total_net_payable" value="{{old('net_payable') ? old('net_payable') : (!empty($salary) ? number_format($salary->salaryDetails->flatten()->sum('net_payable'), 2) : 0.00 ) }}" name="total_net_payable" readonly></td>
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
            @if(empty($salary))
                addRow();
            @endif

            function addRow(){
                let row = `
                    <tr>
                        <td>
                            {{Form::select('salary_head_id[]',$salaryHeads, null,['style' => 'width: 300px','class' => 'form-control','style' => 'width: 200px','id' => 'salary_head_id', 'placeholder'=>"Particulars", 'autocomplete'=>"off"])}}
                        </td>
                        <td>{{Form::text('gross_salary[]', null,['style' => 'width: 100px','class' => 'form-control gross_salary text-right', 'step' => '0.05', 'autocomplete'=>"off"])}}</td>
                        <td>{{Form::text('fixed_allow[]', null,['style' => 'width: 100px','class' => 'form-control fixed_allow text-right', 'step' => '0.05', 'autocomplete'=>"off"])}}</td>
                        <td>{{Form::text('area_bonus[]', null,['style' => 'width: 100px','class' => 'form-control area_bonus text-right', 'step' => '0.05', 'autocomplete'=>"off"])}}</td>
                        <td>{{Form::text('other_refund[]', null,['style' => 'width: 100px','class' => 'form-control other_refund text-right', 'step' => '0.05', 'autocomplete'=>"off"])}}</td>
                        <td>{{Form::text('less_working_day[]', null,['style' => 'width: 100px','class' => 'form-control less_working_day text-right', 'step' => '0.05', 'autocomplete'=>"off"])}}</td>
                        <td>{{Form::text('payable[]', null,['style' => 'width: 100px','class' => 'form-control payable text-right', 'step' => '0.05', 'autocomplete'=>"off", 'readonly'])}}</td>
                        <td>{{Form::text('pf[]', null,['style' => 'width: 100px','class' => 'form-control pf text-right', 'step' => '0.05', 'autocomplete'=>"off"])}}</td>
                        <td>{{Form::text('other_deduction[]', null,['style' => 'width: 100px','class' => 'form-control other_deduction text-right', 'step' => '0.05', 'autocomplete'=>"off"])}}</td>
                        <td>{{Form::text('lwd_deduction[]', null,['style' => 'width: 100px','class' => 'form-control lwd_deduction text-right', 'step' => '0.05', 'autocomplete'=>"off"])}}</td>
                        <td>{{Form::text('advance_salary[]', null,['style' => 'width: 100px','class' => 'form-control advance_salary text-right', 'step' => '0.05', 'autocomplete'=>"off"])}}</td>
                        <td>{{Form::text('ait[]', null,['style' => 'width: 100px','class' => 'form-control ait text-right', 'step' => '0.05', 'autocomplete'=>"off"])}}</td>
                        <td>{{Form::text('mobile_bill[]', null,['style' => 'width: 100px', 'class' => 'form-control mobile_bill text-right', 'step' => '0.05', 'autocomplete'=>"off"])}}</td>
                        <td>{{Form::text('canteen[]', null,['style' => 'width: 100px','class' => 'form-control canteen text-right', 'step' => '0.05', 'autocomplete'=>"off"])}}</td>
                        <td>{{Form::text('pick_drop[]', null,['style' => 'width: 100px','class' => 'form-control pick_drop text-right', 'step' => '0.05', 'autocomplete'=>"off"])}}</td>
                        <td>{{Form::text('loan_deduction[]', null,['style' => 'width: 100px','class' => 'form-control loan_deduction text-right', 'step' => '0.05', 'autocomplete'=>"off"])}}</td>
                        <td>{{Form::text('total_deduction[]', null,['style' => 'width: 100px','class' => 'form-control total_deduction text-right', 'step' => '0.05', 'autocomplete'=>"off", 'readonly'])}}</td>
                        <td>{{Form::text('net_payable[]', null,['style' => 'width: 100px','class' => 'form-control net_payable text-right', 'step' => '0.05', 'autocomplete'=>"off", 'readonly'])}}</td>
                        <td>{{Form::text('remarks[]', null,['style' => 'width: 100px','class' => 'form-control remarks text-right', 'step' => '0.05', 'autocomplete'=>"off"])}}</td>
                        <td>
                            <button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i class="fa fa-minus"></i></button>
                        </td>
                    </tr>
                `;
                $('#voucherTable tbody').append(row);
            }

            function total_gross_salary(){
                let total = 0;
                if($(".gross_salary").length > 0){
                    $(".gross_salary").each(function(i, row){
                        var amountTK = Number($(row).val().replace(/,/g, ''));
                        total += parseFloat(amountTK);
                    })
                }
                $("#total_gross_salary").val(total.toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 }));
            }
            function total_fixed_allow(){
                let total = 0;
                if($(".fixed_allow").length > 0){
                    $(".fixed_allow").each(function(i, row){
                        var amountTK = Number($(row).val().replace(/,/g, ''));
                        total += parseFloat(amountTK);
                    })
                }
                $("#total_fixed_allow").val(total.toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 }));
            }
            function total_fixed_allow(){
                let total = 0;
                if($(".fixed_allow").length > 0){
                    $(".fixed_allow").each(function(i, row){
                        var amountTK = Number($(row).val().replace(/,/g, ''));
                        total += parseFloat(amountTK);
                    })
                }
                $("#total_fixed_allow").val(total.toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 }));
            }
            function total_area_bonus(){
                let total = 0;
                if($(".area_bonus").length > 0){
                    $(".area_bonus").each(function(i, row){
                        var amountTK = Number($(row).val().replace(/,/g, ''));
                        total += parseFloat(amountTK);
                    })
                }
                $("#total_area_bonus").val(total.toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 }));
            }
            function total_other_refund(){
                let total = 0;
                if($(".other_refund").length > 0){
                    $(".other_refund").each(function(i, row){
                        var amountTK = Number($(row).val().replace(/,/g, ''));
                        total += parseFloat(amountTK);
                    })
                }
                $("#total_other_refund").val(total.toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 }));
            }
            function total_payable(){
                let total = 0;
                if($(".payable").length > 0){
                    $(".payable").each(function(i, row){
                        let amountTK = Number($(row).val().replace(/,/g, ''));
                        total += parseFloat(amountTK);
                    })
                }
                $("#total_payable").val(total.toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 }));
            }
            function total_pf(){
                let total = 0;
                if($(".pf").length > 0){
                    $(".pf").each(function(i, row){
                        var amountTK = Number($(row).val().replace(/,/g, ''));
                        total += parseFloat(amountTK);
                    })
                }
                $("#total_pf").val(total.toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 }));
            }
            function total_other_deduction(){
                let total = 0;
                if($(".other_deduction").length > 0){
                    $(".other_deduction").each(function(i, row){
                        var amountTK = Number($(row).val().replace(/,/g, ''));
                        total += parseFloat(amountTK);
                    })
                }
                $("#total_other_deduction").val(total.toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 }));
            }
            function total_lwd_deduction(){
                let total = 0;
                if($(".lwd_deduction").length > 0){
                    $(".lwd_deduction").each(function(i, row){
                        var amountTK = Number($(row).val().replace(/,/g, ''));
                        total += parseFloat(amountTK);
                    })
                }
                $("#total_lwd_deduction").val(total.toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 }));
            }
            function total_advance_salary(){
                let total = 0;
                if($(".advance_salary").length > 0){
                    $(".advance_salary").each(function(i, row){
                        var amountTK = Number($(row).val().replace(/,/g, ''));
                        total += parseFloat(amountTK);
                    })
                }
                $("#total_advance_salary").val(total.toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 }));
            }
            function total_ait(){
                let total = 0;
                if($(".ait").length > 0){
                    $(".ait").each(function(i, row){
                        var amountTK = Number($(row).val().replace(/,/g, ''));
                        total += parseFloat(amountTK);
                    })
                }
                $("#total_ait").val(total.toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 }));
            }
            function total_mobile_bill(){
                let total = 0;
                if($(".mobile_bill").length > 0){
                    $(".mobile_bill").each(function(i, row){
                        var amountTK = Number($(row).val().replace(/,/g, ''));
                        total += parseFloat(amountTK);
                    })
                }
                $("#total_mobile_bill").val(total.toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 }));
            }
            function total_canteen(){
                let total = 0;
                if($(".canteen").length > 0){
                    $(".canteen").each(function(i, row){
                        var amountTK = Number($(row).val().replace(/,/g, ''));
                        total += parseFloat(amountTK);
                    })
                }
                $("#total_canteen").val(total.toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 }));
            }
            function total_pick_drop(){
                let total = 0;
                if($(".pick_drop").length > 0){
                    $(".pick_drop").each(function(i, row){
                        var amountTK = Number($(row).val().replace(/,/g, ''));
                        total += parseFloat(amountTK);
                    })
                }
                $("#total_pick_drop").val(total.toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 }));
            }
            function total_loan_deduction(){
                let total = 0;
                if($(".loan_deduction").length > 0){
                    $(".loan_deduction").each(function(i, row){
                        var amountTK = Number($(row).val().replace(/,/g, ''));
                        total += parseFloat(amountTK);
                    })
                }
                $("#total_loan_deduction").val(total.toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 }));
            }
            function total_total_deduction(){
                let totalDeduction = 0;
                if($(".total_deduction").length > 0){
                    $(".total_deduction").each(function(i, row){
                        let amountDeductionTK = Number($(row).val().replace(/,/g, ''));
                        totalDeduction += parseFloat(amountDeductionTK);
                    })
                }
                $("#total_total_deduction").val(totalDeduction.toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 }));
            }
            function total_net_payable(){
                let total = 0;
                if($(".net_payable").length > 0){
                    $(".net_payable").each(function(i, row){
                        let amountTK = Number($(row).val().replace(/,/g, ''));
                        total += parseFloat(amountTK);
                    })
                }
                $("#total_net_payable").val(total.toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 }));
            }

            function getPayable (thisVal){
                let gross = $(thisVal).closest('tr').find('.gross_salary').val().replace(/,/g, '') > 0 ? parseFloat($(thisVal).closest('tr').find('.gross_salary').val().replace(/,/g, '')) : 0;
                let fixed_allow = $(thisVal).closest('tr').find('.fixed_allow').val().replace(/,/g, '') ? parseFloat($(thisVal).closest('tr').find('.fixed_allow').val().replace(/,/g, '')) : 0;
                let area_bonus = $(thisVal).closest('tr').find('.area_bonus').val().replace(/,/g, '') ? parseFloat($(thisVal).closest('tr').find('.area_bonus').val().replace(/,/g, '')) : 0;
                let other_refund = $(thisVal).closest('tr').find('.other_refund').val().replace(/,/g, '') ? parseFloat($(thisVal).closest('tr').find('.other_refund').val().replace(/,/g, '')) : 0;
                let totalPayable = gross+ fixed_allow + area_bonus + other_refund;
                $(thisVal).closest('tr').find('.payable').val(totalPayable.toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 }))
            }

            function getTotalDeduction (thisVal){
                let pf = $(thisVal).closest('tr').find('.pf').val().replace(/,/g, '') > 0 ? parseFloat($(thisVal).closest('tr').find('.pf').val().replace(/,/g, '')) : 0;
                let other_deduction = $(thisVal).closest('tr').find('.other_deduction').val().replace(/,/g, '') ? parseFloat($(thisVal).closest('tr').find('.other_deduction').val().replace(/,/g, '')) : 0;
                let lwd_deduction = $(thisVal).closest('tr').find('.lwd_deduction').val().replace(/,/g, '') ? parseFloat($(thisVal).closest('tr').find('.lwd_deduction').val().replace(/,/g, '')) : 0;
                let advance_salary = $(thisVal).closest('tr').find('.advance_salary').val().replace(/,/g, '') ? parseFloat($(thisVal).closest('tr').find('.advance_salary').val().replace(/,/g, '')) : 0;
                let ait = $(thisVal).closest('tr').find('.ait').val().replace(/,/g, '') ? parseFloat($(thisVal).closest('tr').find('.ait').val().replace(/,/g, '')) : 0;
                let mobile_bill = $(thisVal).closest('tr').find('.mobile_bill').val().replace(/,/g, '') ? parseFloat($(thisVal).closest('tr').find('.mobile_bill').val().replace(/,/g, '')) : 0;
                let canteen = $(thisVal).closest('tr').find('.canteen').val().replace(/,/g, '') ? parseFloat($(thisVal).closest('tr').find('.canteen').val().replace(/,/g, '')) : 0;
                let pick_drop = $(thisVal).closest('tr').find('.pick_drop').val().replace(/,/g, '') ? parseFloat($(thisVal).closest('tr').find('.pick_drop').val().replace(/,/g, '')) : 0;
                let loan_deduction = $(thisVal).closest('tr').find('.loan_deduction').val().replace(/,/g, '') ? parseFloat($(thisVal).closest('tr').find('.loan_deduction').val().replace(/,/g, '')) : 0;
                let totalDeduction = pf + other_deduction + lwd_deduction + advance_salary + ait + mobile_bill + canteen + pick_drop + loan_deduction ;
                $(thisVal).closest('tr').find('.total_deduction').val(totalDeduction.toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 }))
            }

            function getNetPayable (thisVal){
                let payable = $(thisVal).closest('tr').find('.payable').val().replace(/,/g, '') ? parseFloat($(thisVal).closest('tr').find('.payable').val().replace(/,/g, '')) : 0;
                let deduction = $(thisVal).closest('tr').find('.total_deduction').val().replace(/,/g, '') ? parseFloat($(thisVal).closest('tr').find('.total_deduction').val().replace(/,/g, '')) : 0;
                $(thisVal).closest('tr').find('.net_payable').val((payable - deduction).toLocaleString(undefined, { minimumFractionDigits: 2,  maximumFractionDigits: 2 }))
            }

            $(document).on('keyup', ".gross_salary, .fixed_allow, .area_bonus, .other_refund", function(){
                total_gross_salary();
                total_fixed_allow();
                total_area_bonus();
                total_other_refund();

                getPayable(this);
                getNetPayable(this);
                total_payable();
                total_net_payable();
            });

            $(document).on('keyup', ".pf, .other_deduction, .lwd_deduction, .advance_salary, .ait, .mobile_bill, .canteen, .pick_drop, .loan_deduction", function(){
                total_pf();
                total_other_deduction();
                total_lwd_deduction();
                total_advance_salary();
                total_ait();
                total_mobile_bill();
                total_canteen();
                total_pick_drop();
                total_loan_deduction();

                getTotalDeduction(this);
                getNetPayable(this);
                total_total_deduction();
                total_net_payable();
            });

            $(document).on('click', '.deleteItem', function(){
                $(this).closest('tr').remove();
            });
            $(document).on('click', ".addItem", function(){
                addRow();
                total_gross_salary();
                total_fixed_allow();
                total_area_bonus();
                total_other_refund();
                total_payable();
                total_pf();
                total_other_deduction();
                total_lwd_deduction();
                total_advance_salary();
                total_ait();
                total_mobile_bill();
                total_canteen();
                total_pick_drop();
                total_loan_deduction();
                total_total_deduction();
            });

            $(document).on('keyup','.salary_head_id,.gross_salary,.fixed_allow,.area_bonus,.other_refund,.less_working_day,.payable,.pf,' +
                '.other_deduction,.lwd_deduction,.advance_salary,.ait,.mobile_bill,.canteen,.pick_drop,.loan_deduction,.total_deduction,.net_payable',function (){
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
        }); //document.ready

    </script>
@endsection

