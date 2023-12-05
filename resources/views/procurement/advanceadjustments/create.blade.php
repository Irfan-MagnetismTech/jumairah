@extends('layouts.backend-layout')
@section('title', 'Advance Adjustment')

@section('breadcrumb-title')
    @if($formType == 'edit')
        Edit Advance Adjustment
    @else
        Add Advance Adjustment
    @endif
@endsection

@section('breadcrumb-button')
    <a href="{{ url('advanceadjustments') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', null)

@section('content')
    @if($formType == 'edit')
        {!! Form::open(array('url' => "advanceadjustments/$advanceadjustment->id", 'enctype' =>"multipart/form-data", 'method' => 'PUT', 'class'=>'custom-form')) !!}
    @else
        {!! Form::open(array('url' => "advanceadjustments",'method' => 'POST', 'enctype' =>"multipart/form-data", 'class'=>'custom-form')) !!}
    @endif
        <input type="hidden" name="advanceadjustment_id" value="{{(!empty($advanceadjustment->id) ? $advanceadjustment->id : null)}}">
        <div class="row">
            <div class="col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="date">Date<span class="text-danger">*</span> </label>
                    {{Form::text('date', old('date') ? old('date') : (!empty($advanceadjustment->date) ? $advanceadjustment->date : null),['class' => 'form-control','id' => 'date','autocomplete'=>"off","required", 'readonly'])}}
                </div>
            </div>
            <div class="col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="project_id">Project Name<span class="text-danger">*</span></label>
                    {{Form::text('project_name', old('project_name') ? old('project_name') : (!empty($advanceadjustment) ? $advanceadjustment->costCenter->name: null),['class' => 'form-control','id' => 'project_name', 'autocomplete'=>"off","required","tabindex"=>-1])}}
                    {{Form::hidden('cost_center_id', old('cost_center_id') ? old('cost_center_id') : (!empty($advanceadjustment) ? $advanceadjustment->cost_center_id: null),['class' => 'form-control','id' => 'cost_center_id', 'autocomplete'=>"off","required","tabindex"=>-1])}}
                </div>
            </div>
            <div class="col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="mpr_id">Received Amount<span class="text-danger">*</span></label>
                    {{Form::number('received_amount', old('received_amount') ? old('received_amount') : (!empty($advanceadjustment) ? $advanceadjustment->grand_total + $advanceadjustment->balance : null),['class' => 'form-control','id' => 'received_amount', 'autocomplete'=>"off","required","readonly","tabindex"=>-1])}}
                </div>
            </div>

            <div class="col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="iou_no">Iou No<span class="text-danger">*</span></label>
                    <input type="text" name="iou_no" id="iou_no" value="{{ old('iou_no') ? old('iou_no') : (!empty($advanceadjustment) ? $advanceadjustment->iou->iou_no: null) }}" class="form-control form-control-sm iou_no" id="iou_no">
                    <input type="hidden" name="iou_id" value="{{ old('iou_id') ? old('iou_id') : (!empty($advanceadjustment) ? $advanceadjustment->iou_id: null) }}" id="iou_id" class="form-control form-control-sm iou_id">
                </div>
            </div>
            <div class="col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="project_id">Adjastment for<span class="text-danger">*</span></label>
                    <div class="d-flex">
                        <input type="radio" id="employee_adjustment" class="employee_adjustment" name="switch" value="employee_adjustment" style="margin-left: 30px;" {{ (empty($advanceadjustment->mrr_id) && !empty($advanceadjustment) ? 'checked' : "") }}>
                        <label  style="margin-left: 5px; margin-top: 7px" for="employee_adjustment">Employee Adjustment</label>
                    </div>
                   <div class="d-flex">
                        <input type="radio" id="cash_adjustment" class="cash_adjustment" value="cash_adjustment" name="switch" style="margin-left: 30px;" {{ (!empty($advanceadjustment->mrr_id) ? 'checked': "") }}>
                        <label  style="margin-left: 5px; margin-top: 7px" for="cash_adjustment">Cash Adjustment</label>
                   </div>


                </div>
            </div>
            <div class="col-md-6 mrr_no" style="{{ (!empty($advanceadjustment->mrr_id) ? '': "display:none") }}">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="mrr_no">MRR No<span class="text-danger">*</span></label>
                    {{Form::text('mrr_no', old('mrr_no') ? old('mrr_no') : (!empty($advanceadjustment) ? $advanceadjustment->mrr->mrr_no : null),['class' => 'form-control','id' => 'mrr_no','placeholder'=>"Search MRR No" ,'autocomplete'=>"off"])}}
                    {{Form::hidden('mrr_id', old('mrr_id') ? old('mrr_id') : (!empty($advanceadjustment) ? $advanceadjustment->mrr_id : null),['class' => 'form-control','id' => 'mrr_id', 'autocomplete'=>"off"])}}
                </div>
            </div>
        </div><!-- end row -->
    <hr class="bg-success">
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-sm text-center" id="itemTable">
            <thead>
            <tr>
                <th>Purpose
                    (Account head) <span class="text-danger">*</span></th>
                <th width="300px">Description<span class="text-danger">*</span></th>
                <th>Remarks<span class="text-danger">*</span></th>
                <th>Attachments<span class="text-danger">*</span></th>
                <th>Amount<span class="text-danger">*</span></th>
                <th>
                    <button class="btn btn-success btn-sm addItem" type="button"><i class="fa fa-plus"></i></button>
                </th>
            </tr>
            </thead>
            <tbody>

            @if(old('bill_date'))
                @foreach(old('bill_date') as $key => $advanceadjustmentOldData)
                    <tr>
                        <td>
                            <input type="text" name="account_head_name[]" value="{{old('account_head_name')[$key]}}" class="form-control form-control-sm account_head_name">
                            <input type="hidden" name="account_id[]" value="{{old('account_id')[$key]}}" class="form-control form-control-sm account_id">
                        </td>
                        <td><textarea class="ckeditor form-control form-control-sm description" cols="80" name="description[]">{{old('description')[$key]}}</textarea></td>
                        <td><input type="text" name="remarks[]" value="{{old('remarks')[$key]}}" class="form-control form-control-sm remarks"></td>
                        <td><input type="text" name="amount[]" value="{{old('amount')[$key]}}" class="form-control form-control-sm amount"></td>
                        <td><input type="file" class="dropify" accept='.png, .jpg, .jpeg, .pdf' data-height="300" name="image[]"/></td>
                        <td><button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i class="fa fa-minus"></i></button></td>

                    </tr>
                @endforeach
            @else
                @if(!empty($advanceadjustment))
                    @foreach($advanceadjustment->advanceadjustmentdetails as $advanceadjustmentdetail)
                        <tr>
                            <td>
                                <input type="text" name="account_head_name[]" value="{{ $advanceadjustmentdetail->account->account_name }}" class="form-control form-control-sm account_head_name">
                                <input type="hidden" name="account_id[]" value="{{$advanceadjustmentdetail->account_id}}}}" class="form-control form-control-sm account_id">
                            </td>
                            <td>
                                <textarea class="ckeditor form-control form-control-sm description" cols="80" name="description[]">{{$advanceadjustmentdetail->description}}</textarea>
                            </td>
                            <td><input type="text" name="remarks[]" value="{{$advanceadjustmentdetail->remarks}}" class="form-control form-control-sm remarks"></td>
                            <td><input type="file" class="dropify" accept='.png, .jpg, .jpeg, .pdf' data-height="300" name="image[]"/></td>
                            <td><input type="number" name="amount[]" value="{{$advanceadjustmentdetail->amount}}" class="form-control form-control-sm amount"></td>
                            <td><button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i class="fa fa-minus"></i></button></td>
                        </tr>
                    @endforeach
                @endif
            @endif
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" class="text-right">Total Amount</td>
                    <td>{{Form::number('grand_total', old('grand_total') ? old('grand_total') : (!empty($advanceadjustment->grand_total) ? $advanceadjustment->grand_total : null),['class' => 'form-control total_amount text-right', 'id'=>"total_amount",'placeholder' => '0.00 ', 'readonly'] )}}</td>
                </tr>
                <tr>
                    <td colspan="4" class="text-right">Balance</td>
                    <td>{{Form::number('balance', old('balance') ? old('balance') : (!empty($advanceadjustment->balance) ? $advanceadjustment->balance : null),['class' => 'form-control text-right','min' => '0','id'=>"balance",'placeholder' => '0.00 ', 'readonly'] )}}</td>

                </tr>
            </tfoot>
        </table>
    </div> <!-- end table responsive -->


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
<script defer>



    function addRow(){
        let row = `
            <tr>
                <td>
                    <input type="text" name="account_head_name[]" class="form-control form-control-sm account_head_name">
                    <input type="hidden" name="account_id[]" class="form-control form-control-sm account_id">
                </td>
                <td><textarea class="ckeditor" cols="80" name="description[]"></textarea></td>
                <td><input type="text" name="remarks[]" class="form-control form-control-sm remarks"></td>
                <td><input type="file" class="dropify" accept='.png, .jpg, .jpeg, .pdf' data-height="300" name="image[]"/></td>
                <td><input type="text" name="amount[]" autocomplete="off" class="form-control form-control-sm amount text-right"></td>
                <td><button class="btn btn-danger btn-sm deleteItem" type="button" tabindex="-1"><i class="fa fa-minus"></i></button></td>
            </tr>
        `;
        $('#itemTable tbody').append(row);



    }

    //  function ckinit(){
    //      $(document).ready(function(){
    //          setTimeout(
    //          function() {
    //              alert();
    //              CKEDITOR.replaceClass = 'ckeditor';
    //          }, 2500);

    //      })

    //  }


        // $(document).on('mouseenter', '.bill_date', function(){
        //     ckinit();
        // });
    function totalOperation(){
        let cash = $('#received_amount').val();
        let total = 0;
        if($(".amount").length > 0){
            $(".amount").each(function(){
                var amount = $(this).val();
                total += parseFloat(amount);
            })
        }

        $("#total_amount").val(total);
        $("#balance").val(cash - total);
    }


    var CSRF_TOKEN = "{{csrf_token()}}";
    $(function(){
        @if($formType == 'create')
            addRow();
        @endif

        $("#itemTable").on('click', ".addItem", function(){
            addRow();

        }).on('click', '.deleteItem', function(){
            $(this).closest('tr').remove();
            totalOperation();
        });

        $('#date').datepicker({format: "dd-mm-yyyy",autoclose: true,todayHighlight: true,showOtherMonths: true});

        $(document).on('mouseenter', '.bill_date', function(){
            $(this).datepicker({format: "dd-mm-yyyy",autoclose: true,todayHighlight: true,showOtherMonths: true});
        });


        //For Total Amount
        $(document).on('keyup mousewheel', ".amount", function(){
            let cash = $('#received_amount').val();
            if(cash == null || cash == ''){
                alert('Please search project first');
            }
            totalOperation();
        })

        $( "#project_name").autocomplete({
            source: function( request, response ) {
                $.ajax({
                    url:"{{route('scj.ProjectAutoSearchHavingIou')}}",
                    type: 'get',
                    dataType: "json",
                    data: {
                        _token: CSRF_TOKEN,
                        search: request.term
                    },
                    success: function(data) {
                        response(data);
                    }
                });
            },
            select: function (event, ui) {
                $('#project_name').val(ui.item.label);
                $('#project_id').val(ui.item.value);
                $('#cost_center_id').val(ui.item.value);
                $('#received_amount').val(ui.item.sum);
                $('#total_amount').attr('max',ui.item.sum);
                return false;
            }
        });

        $(document).on('keyup', ".account_head_name", function(){
            $(this).autocomplete({
            source: function( request, response ) {
                $.ajax({
                    url:"{{route('scj.SearchAccountHead')}}",
                    type: 'get',
                    dataType: "json",
                    data: {
                        _token: CSRF_TOKEN,
                        search: request.term
                    },
                    success: function(data) {
                        response(data);
                    }
                });
            },
            select: function (event, ui) {
                $(this).val(ui.item.label);
                $(this).closest('td').find('.account_id').val(ui.item.value);
                return false;
            }
        });
        })
        $(document).on('keyup', "#iou_no", function(){
            $(this).autocomplete({
            source: function( request, response ) {
                $.ajax({
                    url:"{{route('scj.SearchIouNo')}}",
                    type: 'get',
                    dataType: "json",
                    data: {
                        _token: CSRF_TOKEN,
                        search: request.term
                    },
                    success: function(data) {
                        response(data);
                    }
                });
            },
            select: function (event, ui) {
                $(this).val(ui.item.label);
                $('#iou_id').val(ui.item.value);
                return false;
            }
        });
        })
        $(document).on('keyup', "#mrr_no", function(){
            let cost_center_id = $("#cost_center_id").val();
            let iou_id = $("#iou_id").val();
        $(this).autocomplete({
                source: function( request, response ) {
                    $.ajax({
                        url:"{{route('scj.getMrrByCostCenterAndIou')}}",
                        type: 'get',
                        dataType: "json",
                        data: {
                            _token: CSRF_TOKEN,
                            search: request.term,
                            cost_center_id : cost_center_id,
                            iou_id : iou_id,
                        },
                        success: function(data) {
                            response(data);
                        }
                    });
                },
                select: function (event, ui) {
                  $(this).val(ui.item.label);
                  $('#mrr_id').val(ui.item.value);
                    return false;
                }
            });
        });

    }); // end document ready
    $(document).ready(function(){
        $('#employee_adjustment').click(function() {
        $('.mrr_no').hide("fade");
        });
    });
    $(document).ready(function(){
        $('#cash_adjustment').click(function() {
        $('.mrr_no').show("fade");
        });
    });
</script>

@endsection
