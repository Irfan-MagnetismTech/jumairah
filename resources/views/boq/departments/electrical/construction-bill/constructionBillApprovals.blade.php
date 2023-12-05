@extends('layouts.backend-layout')
@section('title', 'Construction Bill Details')

@section('breadcrumb-title')
   Construction Bill Approval
@endsection

@section('breadcrumb-button')
    <a href="{{ url('construction-bills') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    {{--    <span class="text-danger">*</span> Marked are required.--}}
@endsection

@section('content-grid',null)

@section('content')

        {!! Form::open(array('url' => "construction-bill-approval-store",'method' => 'POST', 'class'=>'custom-form')) !!}
        <input type="hidden" name="id" value="{{$constructionBill->id}}">
    <div class="row">
        <div class="col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="bill_received_date">Bill Received Date</label>
                {{Form::text('bill_received_date', old('bill_received_date') ? old('bill_received_date') : (!empty($constructionBill->bill_received_date) ? $constructionBill->bill_received_date : null),['class' => 'form-control','id' => 'bill_received_date','autocomplete'=>"off",'readonly'])}}
            </div>
        </div>
        <div class="col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="title">Bill Title</label>
                {{Form::text('title', old('title') ? old('title') : (!empty($constructionBill->title) ? $constructionBill->title : null),['class' => 'form-control','id' => 'title','autocomplete'=>"off",'readonly'])}}
            </div>
        </div>
        <div class="col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="account_id">Work Type<span class="text-danger">*</span></label>
                {{Form::select('account_id',$accounts,old('account_id') ? old('account_id') : (!empty($constructionBill->account_id) ? $constructionBill->account_id : null),['class' => 'form-control','id' => 'remarks', 'rows'=>2, 'autocomplete'=>"off",'placeholder' => 'Select Work Type','required'])}}
            </div>
        </div>
        <div class="col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="work_type">Work Description</label>
                {{Form::textarea('work_type', old('work_type') ? old('work_type') : (!empty($constructionBill->work_type) ? $constructionBill->work_type : null),['class' => 'form-control','id' => 'remarks', 'rows'=>2, 'autocomplete'=>"off",'readonly'])}}
            </div>
        </div>
        <div class="col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="project_id">Project Name<span class="text-danger">*</span></label>
                {{Form::text('project_name', old('project_name') ? old('project_name') : (!empty($constructionBill) ? $constructionBill->project->name : null),['class' => 'form-control','id' => 'project_name','placeholder'=>"Enter Project Name" ,'autocomplete'=>"off",'readonly'])}}
                {{Form::hidden('project_id', old('project_id') ? old('project_id') : (!empty($constructionBill) ? $constructionBill->project->id: null),['class' => 'form-control','id' => 'project_id', 'autocomplete'=>"off"])}}
                {{Form::hidden('cost_center_id', old('cost_center_id') ? old('cost_center_id') : (!empty($constructionBill) ? $constructionBill->cost_center_id: null),['class' => 'form-control','id' => 'cost_center_id', 'autocomplete'=>"off"])}}
            </div>
        </div>
        <div class="col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="supplier_name">Supplier Name<span class="text-danger">*</span></label>
                {{Form::text('supplier_name', old('supplier_name') ? old('supplier_name') : (!empty($constructionBill) ? $constructionBill->supplier->name : null),['class' => 'form-control','id' => 'supplier_name','placeholder'=>"Enter Supplier Name" ,'autocomplete'=>"off",'readonly'])}}
                {{Form::hidden('supplier_id', old('supplier_id') ? old('supplier_id') : (!empty($constructionBill) ? $constructionBill->supplier->id: null),['class' => 'form-control','id' => 'supplier_id', 'autocomplete'=>"off"])}}
            </div>
        </div>

        <div class="col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="bill_no">Bill No</label>
                {{Form::text('bill_no', old('bill_no') ? old('bill_no') : (!empty($constructionBill->bill_no) ? $constructionBill->bill_no : null),['class' => 'form-control','id' => 'bill_no','autocomplete'=>"off",'readonly'])}}
            </div>
        </div>

        <div class="col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="reference_no">Reference No</label>
                {{Form::text('reference_no', old('reference_no') ? old('reference_no') : (!empty($constructionBill->reference_no) ? $constructionBill->reference_no : null),['class' => 'form-control','id' => 'reference_no','autocomplete'=>"off",'readonly'])}}
            </div>
        </div>

        <div class="col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="bill_amount">Bill Amount<span class="text-danger">*</span></label>
                {{Form::number('bill_amount', old('bill_amount') ? old('bill_amount') : (!empty($constructionBill->bill_amount) ? $constructionBill->bill_amount : null),['class' => 'form-control bill_amount','id' => 'bill_amount','autocomplete'=>"off",'readonly'])}}
            </div>
        </div>

        <div class="col-md-3">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="percentage">Security (%)</label>
                {{Form::number('percentage', old('percentage') ? old('percentage') : (!empty($constructionBill->percentage) ? $constructionBill->percentage : null),['class' => 'form-control percentage','id' => 'percentage','autocomplete'=>"off",'readonly'])}}
            </div>
        </div>
        <div class="col-md-4 col-xl-4">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="year">Year (forcasted)<span class="text-danger">*</span></label>
                <select name="year" id="year" class="form-control" readonly>
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
                <select name="month" id="month" class="form-control" readonly>
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
                <select name="week" id="week" class="form-control" readonly>
                    <option value="">Select Week {{$constructionBill->week}}</option>
                    @for ($i = 1; $i <= 4; $i++)
                        <option value="{{ old('week', $i) }}" {{ ($constructionBill->week == $i) ? "selected": null}}> {{ $i }} </option>
                    @endfor
                </select>
            </div>
        </div>

        <div class="col-md-12">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="remarks">Remarks</label>
                {{Form::textarea('remarks', old('remarks') ? old('remarks') : (!empty($constructionBill->remarks) ? $constructionBill->remarks : null),['class' => 'form-control','id' => 'remarks', 'rows'=>2, 'autocomplete'=>"off"])}}
            </div>
        </div>
        <hr>
        <div class="offset-md-4 col-md-4 mt-2">
            <div class="input-group input-group-sm ">
                <button class="btn btn-success btn-round btn-block py-2">Submit</button>
            </div>
        </div>

    </div>
    {!! Form::close() !!}
@endsection

@section('script')
    <script>
        $(function() {
            $('#bill_received_date').datepicker({
                format: "dd-mm-yyyy",
                autoclose: true,
                todayHighlight: true,
                showOtherMonths: true
            });
        });
    </script>
@endsection

