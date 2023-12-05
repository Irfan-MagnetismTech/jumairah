@extends('bd.feasibility.layout.app')
@section('title', 'Sub & Generator')

@section('breadcrumb-title')
    @if($formType == 'edit')
        Edit Sub & Generator for {{ $bd_lead_location_name[0]->land_location }}
    @else
        Add Sub & Generator for {{ $bd_lead_location_name[0]->land_location }}
    @endif
@endsection

@section('breadcrumb-button')
    <a href="{{ route('feasibility.location.sub-and-generator.index',[ $bd_lead_location_name[0]->id]) }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'offset-md-1 col-md-8 offset-lg-2 col-lg-6 my-3')

@section('content')
        @if($formType == 'edit')
        {!! Form::open(array('url' => "feasibility/location/$BdLeadGeneration_id/sub-and-generator/$sub_and_generator->id",'method' => 'PUT','class'=>'custom-form')) !!}
        @else
        {!! Form::open(array('url' => "feasibility/location/$BdLeadGeneration_id/sub-and-generator",'method' => 'POST','class'=>'custom-form')) !!}
        @endif
        <div class="row">
            <div class="col-md-12 col-xl-12">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="kva">KVA<span class="text-danger">*</span></label>
                    {{Form::text('kva', old('kva') ? old('kva') : (!empty($sub_and_generator->kva) ? $sub_and_generator->kva : null),['class' => 'form-control','id' => 'kva', 'autocomplete'=>"off",'required'])}}
                </div>
            </div>
            <div class="col-md-12 col-xl-12">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="generator_rate">Generator Rate</label>
                    {{Form::text('generator_rate', old('generator_rate') ? old('generator_rate') : (!empty($sub_and_generator->generator_rate) ? $sub_and_generator->monthly_expense : null),['class' => 'form-control','id' => 'monthly_expense', 'autocomplete'=>"off"])}}
                </div>
            </div>
            <div class="col-md-12 col-xl-12">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="sub_station_rate">Sub Station Rate</label>
                    {{Form::text('sub_station_rate', old('sub_station_rate') ? old('sub_station_rate') : (!empty($sub_and_generator->sub_station_rate) ? $sub_and_generator->sub_station_rate : null),['class' => 'form-control','id' => 'sub_station_rate', 'autocomplete'=>"off"])}}
                </div>
            </div>
            <div class="col-md-12 col-xl-12">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="remarks">Remarks</label>
                    {{Form::text('remarks', old('remarks') ? old('remarks') : (!empty($sub_and_generator->remarks) ? $sub_and_generator->remarks : null),['class' => 'form-control','id' => 'remarks', 'autocomplete'=>"off"])}}
                </div>
            </div>
        </div>

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
        
     

        $(function() { 
            document.addEventListener("keydown", function(event) {
                if (event.key === "Enter") {
                    event.preventDefault();
                }
            });
            
        }) // Document.Ready
    </script>
    
@endsection
