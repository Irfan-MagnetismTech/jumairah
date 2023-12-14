@extends('layouts.backend-layout')
@section('title', 'Followup')

@section('breadcrumb-title')
    @if($formType == 'edit')
        Edit Followup
    @else
        Add New Followup
    @endif
@endsection

@section('breadcrumb-button')
    <a href="{{ url('followups') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', null)

@section('content')
    @if($formType == 'edit')
        {!! Form::open(array('url' => "followups/$followup->id",'encType' =>"multipart/form-data", 'method' => 'PUT', 'class'=>'custom-form')) !!}
    @else
        {!! Form::open(array('url' => "followups",'method' => 'POST','encType' =>"multipart/form-data", 'class'=>'custom-form')) !!}
    @endif
    <div class="row">

        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="leadgeneration_name">Prospect Name<span class="text-danger">*</span></label>
                {{Form::text('leadgeneration_name', old('leadgeneration_name') ? old('leadgeneration_name') : (!empty($leadGeneration) ? $leadGeneration->name : null),['class' => 'form-control','id' => 'leadgeneration_name', 'autocomplete'=>"off",'required', 'readonly','tabindex'=>'-1'])}}
                {{Form::hidden('leadgeneration_id', old('leadgeneration_id') ? old('leadgeneration_id') : (!empty($leadGeneration) ? $leadGeneration->id : null),['class' => 'form-control','id' => 'leadgeneration_id', 'autocomplete'=>"off",'required'])}}
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="date">Activity Date<span class="text-danger">*</span></label>
                {{Form::text('date', old('date') ? old('date') : (!empty($followup->date) ? $followup->date : date('d-m-Y',strtotime(now()))),['class' => 'form-control','id' => '', 'autocomplete'=>"off",'required','placeholder'=>'dd-mm-yyyy','readonly'])}}
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="date">Next Followup Date<span class="text-danger">*</span></label>
                {{Form::text('next_followup_date', old('next_followup_date') ? old('next_followup_date') : (!empty($followup->next_followup_date) ? $followup->next_followup_date : null),['class' => 'form-control','id' => 'next_followup_date', 'autocomplete'=>"off",'required','placeholder'=>'dd-mm-yyyy'])}}
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="time_from">Time From<span class="text-danger">*</span></label>
                {{Form::time('time_from', old('time_from') ? old('time_from') : (!empty($followup->time_from) ? $followup->time_from : date('H:i',strtotime(now()))),['class' => 'form-control','id' => 'time_from', 'autocomplete'=>"off",'required','readonly'])}}
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="time_till">Time Till <span class="text-danger">*</span></label>
                {{Form::time('time_till', old('time_till') ? old('time_till') : (!empty($followup->time_till) ? $followup->time_till : null),['class' => 'form-control','id' => 'time_till', 'autocomplete'=>"off",'required'])}}
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="activity_type">Activity Type<span class="text-danger">*</span></label>
                {{Form::text('activity_type', old('activity_type') ? old('activity_type') : (!empty($followup->activity_type) ? $followup->activity_type : null),['class' => 'form-control','id' => 'activity_type', 'autocomplete'=>"off",'required', 'placeholder'=>'Enter Activity Type', 'list'=>'activity_type_list'])}}
                <datalist id="activity_type_list">
                    <option value="Physical Visit"></option>
                    <option value="Telephone Conversation"></option>
                    <option value="Ranks Office Visit"></option>
                    <option value="Project Visit"></option>
                </datalist>
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="reason">Activity For<span class="text-danger">*</span></label>
                {{Form::text('reason', old('reason') ? old('reason') : (!empty($followup->reason) ? $followup->reason : null),['class' => 'form-control','id' => 'reason', 'autocomplete'=>"off",'required'])}}
            </div>
        </div>

        <div class="col-xl-12 col-md-12">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="feedback">Prospect <br>Feedback <span class="text-danger" style="margin-top: 12px;">*</span></label>
                {{Form::textarea('feedback', old('feedback') ? old('feedback') : (!empty($followup->feedback) ? $followup->feedback : null),['class' => 'form-control','id' => 'feedback', 'rows' => '2', 'autocomplete'=>"off",'required'])}}
            </div>
        </div>
        <div class="col-xl-12 col-md-12">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="remarks">Remarks</label>
                {{Form::textarea('remarks', old('remarks') ? old('remarks') : (!empty($followup->remarks) ? $followup->remarks : null),['class' => 'form-control','id' => 'remarks', 'rows' => '2', 'autocomplete'=>"off"])}}
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
            $('#date, #next_followup_date').datepicker({format: "dd-mm-yyyy",autoclose: true,todayHighlight: true,showOtherMonths: true});

        });//document.ready
    </script>
@endsection

