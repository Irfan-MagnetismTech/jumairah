@extends('layouts.backend-layout')
@section('title', 'Apartment Handover')

@section('breadcrumb-title')
    @if($formType=='edit')
        Edit Apartment Handover
    @else
        Add Apartment Handover
    @endif
@endsection

@section('breadcrumb-button')
    <a href="{{ route('apartment-handovers.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', null)

@section('content')

    @if($formType=='edit')
        {!! Form::open(array('url' => route('apartment-handovers.update', $sell->handover->id),'encType' =>"multipart/form-data", 'method' => 'PUT', 'class'=>'custom-form')) !!}
    @else
        {!! Form::open(array('url' => route('apartment-handovers.store'),'method' => 'POST','encType' =>"multipart/form-data", 'class'=>'custom-form')) !!}
    @endif
    <div class="row">
        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="client_name">Client Name</label>
                {{Form::text('client_name', old('client_name') ? old('client_name') : (!empty($sell) ? $sell->sellClient->client->name : null),['class' => 'form-control','id' => 'client_name', 'readonly'])}}
                {{Form::hidden('sell_id', old('sell_id') ? old('sell_id') : (!empty($sell) ? $sell->id : null),['class' => 'form-control','id' => 'sell_id','required'])}}
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="project_name">Project Name</label>
                {{Form::text('project_name', old('project_name') ? old('project_name') : (!empty($sell) ? $sell->apartment->project->name : null),['class' => 'form-control','id' => 'project_name', 'required', 'readonly'])}}
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="apartment_id">Apartment ID</label>
                {{Form::text('apartment_id', old('apartment_id') ? old('apartment_id') : (!empty($sell) ? $sell->apartment->name: null),['class' => 'form-control', 'id' => 'apartment_id', 'readonly'])}}
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="sold_date">Sold Date</label>
                {{Form::text('sold_date', old('sold_date') ? old('sold_date') : (!empty($sell) ? $sell->sell_date : null),['class' => 'form-control','id' => 'sold_date', 'readonly'])}}
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="total_value">Total Value</label>
                {{Form::text('total_value', old('total_value') ? old('total_value') : (!empty($sell) ? $sell->total_value : null),['class' => 'form-control','id' => 'total_value', 'readonly'])}}
            </div>
        </div>
            <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="sold_by">Sold By</label>
                {{Form::text('sold_by', old('sold_by') ? old('sold_by') : (!empty($sell) ? $sell->user->name : null),['class' => 'form-control','id' => 'sold_by', 'readonly'])}}
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="paid_amount">Paid Amount</label>
                {{Form::text('paid_amount', old('paid_amount') ? old('paid_amount') : (!empty($sell) ? $sell->salesCollections->sum('received_amount') : null), ['class' => 'form-control', 'id' => 'paid_amount', 'readonly'])}}
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="due_amount">Due Amount</label>
                {{Form::text('due_amount', old('due_amount') ? old('due_amount') : (!empty($sell) ? $sell->total_value - $sell->salesCollections->sum('received_amount') : null),['class' => 'form-control','id' => 'due_amount', 'readonly'])}}
            </div>
        </div>

        <div class="col-xl-4 col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="date">Handover Date<span class="text-danger">*</span></label>
                {{Form::text('handover_date', old('handover_date') ? old('handover_date') : (!empty($sell) &&  $sell->handover ? $sell->handover->handover_date : null),['class' => 'form-control','id' => 'handover_date', 'autocomplete'=>"off",'required','placeholder'=>'dd-mm-yyyy'])}}
            </div>
        </div>

        <div class="col-xl-8 col-md-8">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="remarks">Remarks</label>
                {{Form::textarea('remarks', old('remarks') ? old('remarks') : (!empty($sell) &&  $sell->handover ? $sell->handover->remarks : null),['class' => 'form-control','id' => 'remarks', 'rows'=>2,'autocomplete'=>"off"])}}
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
    {!! Form::close() !!}
@endsection
@section('script')
    <script>
        $(function(){
            $('#handover_date').datepicker({format: "dd-mm-yyyy",autoclose: true,todayHighlight: true,showOtherMonths: true});
        });//document.ready
    </script>
@endsection
