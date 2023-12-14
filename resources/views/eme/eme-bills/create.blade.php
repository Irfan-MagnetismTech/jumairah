@extends('layouts.backend-layout')
@section('title', 'EME Bill')

@section('breadcrumb-title')

    @if(!empty($constructionBill))
        Edit EME Bill
    @else
        Add EME Bill
    @endif
@endsection

@section('breadcrumb-button')
    <a href="{{ url('eme/bills') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection


@section('content-grid', null)

@section('style')

<style>

    .radio_container {
      position: relative;
      padding-left: 35px;
      margin-bottom: 12px;
      cursor: pointer;
      font-size: 15px;
      -webkit-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none;
      user-select: none;

    }

    /* Hide the browser's default radio button */
    .radio_container input {
      position: absolute;
      opacity: 0;
      cursor: pointer;
      box-sizing: border-box
    }
    .checkmark {
      position: absolute;
      top: 5%;
      left: 0;
      height: 20px;
      width: 20px;
      margin-left: 5px;
      background-color: #227447;
      border-radius: 50%;
    }
    .radio_container:hover input ~ .checkmark {
      background-color: #ccc;
    }
    .radio_container input:checked ~ .checkmark {
      background-color: #227447;
    }
    .checkmark:after {
      content: "";
      position: absolute;
      display: none;
    }
    .radio_container input:checked ~ .checkmark:after {
      display: block;
    }
    .radio_container .checkmark:after {
         top: 6px;
        left: 6px;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: white;
    }
</style>
@endsection

@section('content')
    @if(!empty($constructionBill))
        {!! Form::open(array('url' => "eme/bills/$constructionBill->id",'method' => 'PUT', 'class'=>'custom-form','id' => 'tagForm')) !!}
        @php
                $work_order_id = $constructionBill->emeWorkorder->id;
                $work_order_no = $constructionBill->emeWorkorder->workorder_no;
        @endphp
    @else
        {!! Form::open(array('url' => "eme/bills",'method' => 'POST', 'class'=>'custom-form','id' => 'tagForm')) !!}
    @endif
        <input type="hidden" name="construction_id" value="{{(!empty($constructionBill->id) ? $constructionBill->id : null)}}">
        <div class="row">
            {{Form::hidden('type',1,['class' => 'form-control','id' => 'type','autocomplete'=>"off", 'readonly'])}}
            <div class="col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="bill_received_date">Bill Received Date</label>
                    {{Form::text('bill_received_date', old('bill_received_date') ? old('bill_received_date') : (!empty($constructionBill->bill_received_date) ? $constructionBill->bill_received_date : null),['class' => 'form-control','id' => 'bill_received_date','autocomplete'=>"off", 'readonly'])}}
                </div>
            </div>
            <div class="col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="title">Work Order No<span class="text-danger">*</span></label>
                    {{Form::text('work_order_no', old('work_order_no') ? old('work_order_no') : (!empty($constructionBill) ? $work_order_no : null),['class' => 'form-control','id' => 'work_order_no','autocomplete'=>"off",'placeholder' => 'Please Search Work Order No'])}}
                    {{Form::hidden('workorder_id', old('workorder_id') ? old('workorder_id') : (!empty($constructionBill) ? $work_order_id : null),['class' => 'form-control','id' => 'workorder_id','autocomplete'=>"off"])}}
                </div>
            </div>
            <div class="col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="title">Bill Title</label>
                    {{Form::text('title', old('title') ? old('title') : (!empty($constructionBill->title) ? $constructionBill->title : null),['class' => 'form-control','id' => 'title','autocomplete'=>"off"])}}
                    
                </div>
            </div>
            <div class="col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="project_id">Project Name<span class="text-danger">*</span></label>
                    {{Form::text('project_name', old('project_name') ? old('project_name') : (!empty($constructionBill) ? $constructionBill->project?->name  : null),['class' => 'form-control','id' => 'project_name','placeholder'=>"Enter Project Name" ,'autocomplete'=>"off", 'readonly'])}}
                    {{Form::hidden('project_id', old('project_id') ? old('project_id') : (!empty($constructionBill) ? $constructionBill->project_id: null),['class' => 'form-control','id' => 'project_id', 'autocomplete'=>"off"])}}
                    {{Form::hidden('cost_center_id', old('cost_center_id') ? old('cost_center_id') : (!empty($constructionBill) ? $constructionBill->cost_center_id: null),['class' => 'form-control','id' => 'cost_center_id', 'autocomplete'=>"off"])}}
                </div>
            </div>
            <div class="col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="supplier_name">Supplier Name<span class="text-danger">*</span></label>
                    {{Form::text('supplier_name', old('supplier_name') ? old('supplier_name') : (!empty($constructionBill) ? $constructionBill->supplier?->name : null),['class' => 'form-control','id' => 'supplier_name','placeholder'=>"Enter Supplier Name" ,'autocomplete'=>"off",'readonly'])}}
                    {{Form::hidden('supplier_id', old('supplier_id') ? old('supplier_id') : (!empty($constructionBill) ? $constructionBill->supplier?->id: null),['class' => 'form-control','id' => 'supplier_id', 'autocomplete'=>"off"])}}
                    {{Form::hidden('account_id', old('account_id') ? old('account_id') : (!empty($constructionBill) ? $constructionBill->supplier->account->id: null),['class' => 'form-control','id' => 'account_id', 'autocomplete'=>"off"])}}
                </div>
            </div>

            <div class="col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="bill_no">Bill No</label>
                    {{Form::text('bill_no', old('bill_no') ? old('bill_no') : (!empty($constructionBill->bill_no) ? $constructionBill->bill_no : null),['class' => 'form-control','id' => 'bill_no','autocomplete'=>"off"])}}
                </div>
            </div>

            <div class="col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="reference_no">Reference No</label>
                    {{Form::text('reference_no', old('reference_no') ? old('reference_no') : (!empty($constructionBill->reference_no) ? $constructionBill->reference_no : null),['class' => 'form-control','id' => 'reference_no','autocomplete'=>"off"])}}
                </div>
            </div>

            <div class="col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="bill_amount">Bill Amount<span class="text-danger">*</span></label>
                    {{Form::number('bill_amount', old('bill_amount') ? old('bill_amount') : (!empty($constructionBill->bill_amount) ? $constructionBill->bill_amount : null),['class' => 'form-control bill_amount','id' => 'bill_amount','autocomplete'=>"off"])}}
                </div>
            </div>

            <div class="col-md-3">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="percentage">Security (%)</label>
                    {{Form::number('percentage', old('percentage') ? old('percentage') : (!empty($constructionBill->percentage) ? $constructionBill->percentage : null),['class' => 'form-control percentage','id' => 'percentage','autocomplete'=>"off"])}}
                </div>
            </div>
            <div class="col-md-3">
            </div>
            <div class="col-md-6">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="adjusted_amount">Adjusted Amount</label>
                    {{Form::number('adjusted_amount', old('adjusted_amount') ? old('adjusted_amount') : (!empty($constructionBill->adjusted_amount) ? $constructionBill->adjusted_amount : null),['class' => 'form-control adjusted_amount','id' => 'adjusted_amount','autocomplete'=>"off"])}}
                </div>
            </div>
            <div class="col-md-12">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="remarks">Remarks</label>
                    {{Form::textarea('remarks', old('remarks') ? old('remarks') : (!empty($constructionBill->remarks) ? $constructionBill->remarks : null),['class' => 'form-control','id' => 'remarks', 'rows'=>2, 'autocomplete'=>"off"])}}
                </div>
            </div>
            <div class="col-md-4 col-xl-4">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="year">Year (forcasted)<span class="text-danger">*</span></label>
                    <select name="year" id="year" class="form-control">
                        <option value="{{date('Y')}}">{{date('Y')}}</option>
                        @for ($i = 2000; $i <= 3000; $i++)
                            <option value="{{ old('year', $i) }}" {{ (@$constructionBill->year == $i) ? "selected": null}}> {{ $i }} </option>
                        @endfor
                    </select>
                </div>
            </div>
            <div class="col-md-4 col-xl-4">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="month">Month (forcasted)<span class="text-danger">*</span></label>
                    <select name="month" id="month" class="form-control">
                        <option value="">Select Month</option>
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ old('month', $i) }}" {{ (@$constructionBill->month == $i) ? "selected": null}}> {{ date('F', mktime(0,0,0,$i)) }} </option>
                        @endfor
                    </select>
                </div>
            </div>
            <div class="col-md-4 col-xl-4">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="week">Week (forcasted)<span class="text-danger">*</span></label>
                    <select name="week" id="week" class="form-control">
                        <option value="">Select Week</option>
                        @for ($i = 1; $i <= 4; $i++)
                            <option value="{{ old('week', $i) }}" {{ (@$constructionBill->week == $i) ? "selected": null}}> {{ $i }} </option>
                        @endfor
                    </select>
                </div>
            </div>
        </div><!-- end row -->


       
        <div class="row">
            <div class="mt-2 offset-md-4 col-md-4">
                <div class="input-group input-group-sm ">
                    <button class="py-2 btn btn-success btn-round btn-block">Save</button>
                </div>
            </div>
        </div>
    {!! Form::close() !!}

@endsection


@section('script')
    <script>

        var CSRF_TOKEN = "{{csrf_token()}}";
        @if (old('type') && (old('type')== 0) && old('workorder_id'))
            GetWorkType(old('workorder_id'));
        @endif
        $(function() {
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
                    $('#cost_center_id').val(ui.item.cost_center_id);
                    return false;
                }
            });

            $("#supplier_name").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ route('supplierAutoSuggest') }}",
                        type: 'post',
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
                select: function(event, ui) {
                    $('#supplier_name').val(ui.item.label);
                    $('#supplier_id').val(ui.item.value);
                    return false;
                }
            });

            $("#work_order_no").on('keyup', function() {
                    
                        $('#workorder_id').val('');
                        $('#work_type').html('');
                        $('#supplier_name').val('');
                        $('#supplier_id').val('');
                        $('#project_name').val('');
                        $('#project_id').val('');
                        $('#cost_center_id').val('');
                        $('#account_id').val('');
                        $(this).autocomplete({
                            source: function(request, response) {
                                $.ajax({
                                    url: "{{ route('boqEmeWorkOrderAutoSuggest') }}",
                                    type: 'post',
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
                            select: function(event, ui) {
                                $('#work_order_no').val(ui.item.label);
                                $('#workorder_id').val(ui.item.value);
                                $('#supplier_name').val(ui.item.supplier_name);
                                $('#supplier_id').val(ui.item.supplier_id);
                                $('#project_name').val(ui.item.project_name);
                                $('#project_id').val(ui.item.project_id);
                                $('#cost_center_id').val(ui.item.cost_center_id);
                                $('#account_id').val(ui.item.account_id);
                            
                                return false;
                            }
                        });
                 });



            function GetWorkType(work_order_id){
                $.ajax({
                        url: "{{ route('searchWorkType') }}",
                        type: 'get',
                        data: {
                            _token: CSRF_TOKEN,
                            search: work_order_id
                        },
                        success: function(data) {
                             $('#work_type').html();
                             $('#work_type').html(data);
                             return false;
                        }
                    });
            }
            
            $('#bill_received_date').datepicker({
                format: "dd-mm-yyyy",
                autoclose: true,
                todayHighlight: true,
                showOtherMonths: true
            });
        });

       
       
    </script>
@endsection
