@extends('layouts.backend-layout')
@section('title', 'Vouchers')

@section('breadcrumb-title')
    @if(!empty($accountOpeningBalance))
        Edit Opening Balance
    @else
        Add Opening Balance
    @endif
@endsection

@section('style')

@endsection

@section('breadcrumb-button')
    <a href="{{ url('accounts/account-opening-balances') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', null)

@section('content')

    @if(!empty($accountOpeningBalance))
        {!! Form::open(array('url' => "accounts/account-opening-balances/$accountOpeningBalance->id",'method' => 'PUT', 'class'=>'custom-form')) !!}
    @else
        {!! Form::open(array('url' => "accounts/account-opening-balances",'method' => 'POST', 'class'=>'custom-form')) !!}
    @endif
    <div class="col-md-12 p-1" id="voucher_preview" style="border: 1px solid #8a8a8a">

        <div class="row py-2">
            <div class="col-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="reason">Accounts Name <span class="text-danger">*</span></label>
                    <input type="text" id="account_name" name="account_name" class="form-control form-control-sm" value="{{!empty($accountOpeningBalance) ? $accountOpeningBalance->account->account_name : null}}" placeholder="Enter Account Name" autocomplete="off">
                    <input type="hidden" id="account_id" name="account_id" class="form-control form-control-sm" value="{{!empty($accountOpeningBalance) ? $accountOpeningBalance->account_id : ''}}">                </div>
            </div>

            <div class="col-4">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="date"> Date <span class="text-danger">*</span></label>
                    {{Form::text('date', old('date') ? old('date') : (!empty($accountOpeningBalance) ?  $accountOpeningBalance->date : now()->format('d-m-Y')),['class' => 'form-control','id' => 'date', 'autocomplete'=>"off", 'required'])}}
                </div>
            </div>

            @if(!empty($accountOpeningBalance))
                <div class="col-6">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="reason">Cost Center <span class="text-danger">*</span></label>
                        <input type="text" id="costCenter_name" name="" class="form-control project form-control-sm" value="{{!empty($accountOpeningBalance) ? $accountOpeningBalance->costCenter->name : null}}" placeholder="Select Cost Center Name" autocomplete="off">
                        <input type="hidden" id="costCenter_id" name="cost_center_id" class="form-control form-control-sm" value="{{!empty($accountOpeningBalance) ?? $accountOpeningBalance->cost_center_id}}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="reason">Debit Amount<span class="text-danger">*</span></label>
                        <input type="text" id="" name="dr_amount" class="form-control dr_amount text-right form-control-sm" value="{{!empty($accountOpeningBalance) ? number_format($accountOpeningBalance->dr_amount,2) : null}}" placeholder="0.00" autocomplete="off">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="reason">Credit Amount <span class="text-danger">*</span></label>
                        <input type="text" id="" name="cr_amount" class="form-control cr_amount text-right form-control-sm" value="{{!empty($accountOpeningBalance) ? number_format($accountOpeningBalance->cr_amount,2) : null}}" placeholder="0.00" autocomplete="off">
                    </div>
                </div>
            @endif

        </div>
        @php
            //$cost_center_names = old('project', !empty($accountOpeningBalance) ?  $accountOpeningBalance->pluck('costCenter.name') : []);
            //$cost_center_ids = old('cost_center_id', !empty($accountOpeningBalance) ?  $accountOpeningBalance->pluck('cost_center_id') : []);
            //$dr_amounts = old('dr_amount', !empty($accountOpeningBalance) ?  $accountOpeningBalance->pluck('dr_amount') : []);
            //$cr_amounts = old('cr_amount', !empty($accountOpeningBalance) ?  $accountOpeningBalance->pluck('cr_amount') : []);
            //$remarkss = old('remarks', !empty($accountOpeningBalance) ?  $accountOpeningBalance->pluck('remarks') : []);
        @endphp
        {{-- {{dd($account_id[0])}} --}}
        @if(empty($accountOpeningBalance))
            <table class="table table-bordered text-right" id="voucherTable">
                <thead class="text-center">
                <tr class="bg-dark">
                    <th>Cost Center</th>
                    <th>Debit</th>
                    <th>Credit</th>
                    <th>
                        <button class="btn btn-success btn-sm addItem" type="button"><i class="fa fa-plus"></i></button>
                    </th>
                </tr>
                </thead>
                <tbody class="text-right">
                {{--@foreach ($cost_center_names as $key => $account)
                    <tr>
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
                            <button class="btn btn-success btn-sm addItem" type="button"><i class="fa fa-plus"></i></button>
                            <button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i class="fa fa-minus"></i></button>
                        </td>
                    </tr>
                @endforeach--}}
                </tbody>

                <tfoot>
                </tfoot>
            </table>
        @endif

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
            @if(empty($accountOpeningBalance))
                addRow();
            @endif

            $('#date').datepicker({format: "dd-mm-yyyy",autoclose: true,todayHighlight: true,showOtherMonths: true});

            function addRow(){
                let row = `
                    <tr>
                        <td> {{Form::text('project[]', null,['class' => 'form-control project','id' => 'project', 'placeholder'=>" Project Name", 'autocomplete'=>"off"])}}
                             {{Form::hidden('cost_center_id[]', null,['class' => 'form-control cost_center_id','id' => 'cost_center_id', 'autocomplete'=>"off"])}}
                        </td>
                        <td>{{Form::text('dr_amount[]', null,['class' => 'form-control dr_amount text-right','id' => '', 'step' => '0.05', 'autocomplete'=>"off"])}}
                        </td>
                        <td>{{Form::text('cr_amount[]', null,['class' => 'form-control cr_amount text-right','id' => '', 'step' => '0.05', 'autocomplete'=>"off"])}}
                        </td>
                        <td class="text-center">
                            <button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i class="fa fa-minus"></i></button>
                        </td>
                    </tr>
                `;
                $('#voucherTable tbody').append(row);
            }

            $("#account_name").autocomplete({
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
                    $('#account_name').val(ui.item.label);
                    $('#account_id').val(ui.item.value);
                    return false;
                }
            }).change(function(){
                if(!$(this).val()){
                    $('#account_id').val(null);
                }
            });

            var CSRF_TOKEN = "{{csrf_token()}}";

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

            $(document).on('click', '.deleteItem', function(){
                $(this).closest('tr').remove();
            });
            $(document).on('click', ".addItem", function(){
                addRow();
            });

            $(document).on('keyup','.dr_amount, .cr_amount',function (){
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

