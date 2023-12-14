@extends('layouts.backend-layout')
@section('title', 'Sale Activity')

@section('breadcrumb-title')
    @if($formType == 'edit')
        Edit Activity
    @else
        Add New Activity
    @endif
@endsection

@section('breadcrumb-button')
    <a href="{{ url('saleactivities') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', null)

@section('content')
    @if($formType == 'edit')
        {!! Form::open(array('url' => "saleactivities/$saleactivity->id",'encType' =>"multipart/form-data", 'method' => 'PUT', 'class'=>'custom-form')) !!}
    @else
        {!! Form::open(array('url' => "saleactivities",'method' => 'POST','encType' =>"multipart/form-data", 'class'=>'custom-form')) !!}
    @endif
    <div class="row">
        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="client_name">Client Name<span class="text-danger">*</span></label>
                {{Form::text('client_name', old('client_name') ? old('client_name') : (!empty($sell) ? $sell->sellClient->client->name : null),['class' => 'form-control','id' => 'client_name', 'autocomplete'=>"off",'required', 'readonly','tabindex'=>'-1'])}}
                {{Form::hidden('sell_id', old('sell_id') ? old('sell_id') : (!empty($sell) ? $sell->id : null),['class' => 'form-control','id' => 'sell_id', 'autocomplete'=>"off",'required'])}}
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="date">Activity Date<span class="text-danger">*</span></label>
                {{Form::text('date', old('date') ? old('date') : (!empty($saleactivity->date) ? $saleactivity->date : now()->format('d-m-Y')),['class' => 'form-control','id' => 'date', 'autocomplete'=>"off",'required','placeholder'=>'dd-mm-yyyy'])}}
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="time_from">Time From<span class="text-danger">*</span></label>
                {{Form::time('time_from', old('time_from') ? old('time_from') : (!empty($saleactivity->time_from) ? $saleactivity->time_from : null),['class' => 'form-control','id' => 'time_from', 'autocomplete'=>"off",'required'])}}
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="time_till">Time Till<span class="text-danger">*</span></label>
                {{Form::time('time_till', old('time_till') ? old('time_till') : (!empty($saleactivity->time_till) ? $saleactivity->time_till : null),['class' => 'form-control','id' => 'time_till', 'autocomplete'=>"off",'required'])}}
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="activity_type">Activity Type<span class="text-danger">*</span></label>
                {{Form::text('activity_type', old('activity_type') ? old('activity_type') : (!empty($saleactivity->activity_type) ? $saleactivity->activity_type : null),['class' => 'form-control','id' => 'activity_type', 'autocomplete'=>"off",'required', 'placeholder'=>'Enter Activity Type', 'list'=>'activity_type_list'])}}
                <datalist id="activity_type_list">
                    <option value="Physical Visit"></option>
                    <option value="Telephone Conversation"></option>
                    <option value="Jumairah Office Visit"></option>
                </datalist>
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="reason">Activity For<span class="text-danger">*</span></label>
                {{Form::text('reason', old('reason') ? old('reason') : (!empty($saleactivity->reason) ? $saleactivity->reason : null),['class' => 'form-control','id' => 'reason', 'autocomplete'=>"off",'required'])}}
            </div>
        </div>

        <div class="col-xl-12 col-md-12">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="feedback">Client <br>Feedback <span class="text-danger" style="margin-top: 12px;">*</span></label>
                {{Form::textarea('feedback', old('feedback') ? old('feedback') : (!empty($saleactivity->feedback) ? $saleactivity->feedback : null),['class' => 'form-control','id' => 'feedback', 'rows' => '2', 'autocomplete'=>"off",'required'])}}
            </div>
        </div>
        <div class="col-xl-12 col-md-12">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="remarks">Remarks</label>
                {{Form::textarea('remarks', old('remarks') ? old('remarks') : (!empty($saleactivity->remarks) ? $saleactivity->remarks : null),['class' => 'form-control','id' => 'remarks', 'rows' => '2', 'autocomplete'=>"off"])}}
            </div>
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
        $(function(){
            $('#date').datepicker({format: "dd-mm-yyyy",autoclose: true,todayHighlight: true,showOtherMonths: true});

        });//document.ready
    </script>
@endsection
