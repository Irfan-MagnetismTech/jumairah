@extends('bd.feasibility.layout.app')
@section('title', 'Site Expense')

@section('breadcrumb-title')
    @if($formType == 'edit')
        Edit Site Expense for {{ $bd_lead_location_name[0]->land_location }}
    @else
        Add Site Expense for {{ $bd_lead_location_name[0]->land_location }}
    @endif
@endsection

@section('breadcrumb-button')
    <a href="{{ route('feasibility.location.site-expense.index',[ $bd_lead_location_name[0]->id]) }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'offset-md-1 col-md-8 offset-lg-2 col-lg-6 my-3')

@section('content')
        @if($formType == 'edit')
        {!! Form::open(array('url' => "feasibility/location/$BdLeadGeneration_id/site-expense/$site_expense->id",'method' => 'PUT','class'=>'custom-form')) !!}
        @else
        {!! Form::open(array('url' => "feasibility/location/$BdLeadGeneration_id/site-expense",'method' => 'POST','class'=>'custom-form')) !!}
        @endif
        <div class="row">
            <div class="col-md-12 col-xl-12">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="name">Land Area<span class="text-danger">*</span></label>
                    {{Form::text('land_area', old('land_area') ? old('land_area') : (!empty($site_expense->land_area) ? $site_expense->land_area : null),['class' => 'form-control','id' => 'land_area', 'autocomplete'=>"off",'required'])}}
                </div>
            </div>
            <div class="col-md-12 col-xl-12">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="name">Monthly Expense<span class="text-danger">*</span></label>
                    {{Form::text('monthly_expense', old('monthly_expense') ? old('monthly_expense') : (!empty($site_expense->monthly_expense) ? $site_expense->monthly_expense : null),['class' => 'form-control','id' => 'monthly_expense', 'autocomplete'=>"off",'required'])}}
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
