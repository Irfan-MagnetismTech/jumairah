@extends('layouts.backend-layout')
@section('title', 'Entry')

@section('breadcrumb-title')
    Feasibility Entry
@endsection

@section('breadcrumb-button')
    
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', null)

@section('content')

        @if($formType == 'edit')
            {!! Form::open(array('url' => "feasibility-entry/$BdLeadGeneration_id",'method' => 'PUT','class'=>'custom-form')) !!}
        @else
            {!! Form::open(array('url' => "feasibility-entry",'method' => 'POST','class'=>'custom-form')) !!}
        @endif

        <div class="row">
            <div class="col-xl-3 col-md-3"></div>
            <div class="col-xl-3 col-md-3">
                <div class="input-group input-group-sm input-group-primary">
                    <p>Location</p>
                </div>
            </div>
            <div class="col-xl-3 col-md-3">
                <div class="input-group input-group-sm input-group-primary">
                    {{Form::text('location_name', old('location_name') ? old('location_name') : (count($location) ? $location->values()->first() : null),['class' => 'form-control text-center', 'autocomplete'=>"off" , 'required','readonly'])}}

                    {{Form::hidden('location_id', old('location_id') ? old('location_id') : (count($location) ? $location->keys()->first() : null),['class' => 'form-control text-center','id' => 'floor_number', 'autocomplete'=>"off" , 'required'])}}
                
                   
                </div>
            </div> 
            <div class="col-xl-3 col-md-3"></div>

            <div class="col-xl-3 col-md-3"></div>
            <div class="col-xl-3 col-md-3">
                <div class="input-group input-group-sm input-group-primary">
                    <p>Total Payment for Land (BDT)</p>
                </div>
            </div>
            <div class="col-xl-3 col-md-3">
                <div class="input-group input-group-sm input-group-primary">
                    {{Form::number('total_payment', old('total_payment') ? old('total_payment') : (count($previous_data) ? $previous_data->first()->total_payment : null),['class' => 'form-control text-center','id' => 'total_payment', 'autocomplete'=>"off" , 'required','placeholder' => 10000000])}}
                </div>
            </div>  
            <div class="col-xl-3 col-md-3"></div> 

            <div class="col-xl-3 col-md-3"></div>
            <div class="col-xl-3 col-md-3">
                <div class="input-group input-group-sm input-group-primary">
                    <p>RFPL Ratio</p>
                </div>
            </div>
            <div class="col-xl-3 col-md-3">
                <div class="input-group input-group-sm input-group-primary">
                    {{Form::number('rfpl_ratio', old('rfpl_ratio') ? old('rfpl_ratio') : (count($previous_data) ? $previous_data->first()->rfpl_ratio : null),['class' => 'form-control text-center','id' => 'rfpl_ratio', 'autocomplete'=>"off" , 'required'])}}
                </div>
            </div>  
            <div class="col-xl-3 col-md-3"></div> 

            <div class="col-xl-3 col-md-3"></div>
            <div class="col-xl-3 col-md-3">
                <div class="input-group input-group-sm input-group-primary">
                    <p>Registration Cost (%)</p>
                </div>
            </div>
            <div class="col-xl-3 col-md-3">
                <div class="input-group input-group-sm input-group-primary">
                    {{Form::number('registration_cost', old('docuregistration_costment') ? old('registration_cost') : (count($previous_data) ? $previous_data->first()->registration_cost : null),['class' => 'form-control text-center','id' => 'registration_cost', 'autocomplete'=>"off" , 'required'])}}
                </div>
            </div>  
            <div class="col-xl-3 col-md-3"></div> 

            <div class="col-xl-3 col-md-3"></div>
            <div class="col-xl-3 col-md-3">
                <div class="input-group input-group-sm input-group-primary">
                    <p>Adjacent Road Width (Feet)</p>
                </div>
            </div>
            <div class="col-xl-3 col-md-3">
                <div class="input-group input-group-sm input-group-primary">
                    {{Form::number('adjacent_road_width', old('adjacent_road_width') ? old('adjacent_road_width') : (count($previous_data) ? $previous_data->first()->adjacent_road_width : null),['class' => 'form-control text-center','id' => 'adjacent_road_width', 'autocomplete'=>"off" , 'required'])}}
                </div>
            </div>  
            <div class="col-xl-3 col-md-3"></div> 

            <div class="col-xl-3 col-md-3"></div>
            <div class="col-xl-3 col-md-3">
                <div class="input-group input-group-sm input-group-primary">
                    <p>Parking area per car (SFT)</p>
                </div>
            </div>
            <div class="col-xl-3 col-md-3">
                <div class="input-group input-group-sm input-group-primary">
                    {{Form::number('parking_area_per_car', old('parking_area_per_car') ? old('parking_area_per_car') : (count($previous_data) ? $previous_data->first()->parking_area_per_car : null),['class' => 'form-control text-center','id' => 'parking_area_per_car', 'autocomplete'=>"off" , 'required'])}}
                </div>
            </div>  
            <div class="col-xl-3 col-md-3"></div> 

            <div class="col-xl-3 col-md-3"></div>
            <div class="col-xl-3 col-md-3">
                <div class="input-group input-group-sm input-group-primary">
                    <p>Building Front Length (FT)</p>
                </div>
            </div>
            <div class="col-xl-3 col-md-3">
                <div class="input-group input-group-sm input-group-primary">
                    {{Form::number('building_front_length', old('building_front_length') ? old('building_front_length') : (count($previous_data) ? $previous_data->first()->building_front_length : null),['class' => 'form-control text-center','id' => 'building_front_length', 'autocomplete'=>"off" , 'required'])}}
                </div>
            </div>  
            <div class="col-xl-3 col-md-3"></div> 

            {{-- <div class="col-xl-3 col-md-3"></div>
            <div class="col-xl-3 col-md-3">
                <div class="input-group input-group-sm input-group-primary">
                    <p>Total Number of Floor(s)</p>
                </div>
            </div> --}}
            {{-- <div class="col-xl-3 col-md-3">
                <div class="input-group input-group-sm input-group-primary">
                    {{Form::number('floor_number', old('floor_number') ? old('floor_number') : (count($previous_data) ? $previous_data->first()->floor_number : null),['class' => 'form-control text-center','id' => 'floor_number', 'autocomplete'=>"off" , 'required'])}}
                </div>
            </div>   --}}
            {{-- <div class="col-xl-3 col-md-3"></div>  --}}

            <div class="col-xl-3 col-md-3"></div>
            <div class="col-xl-3 col-md-3">
                <div class="input-group input-group-sm input-group-primary">
                    <p>Fire Stair Area (SFT)</p>
                </div>
            </div>
            <div class="col-xl-3 col-md-3">
                <div class="input-group input-group-sm input-group-primary">
                    {{Form::number('fire_stair_area', old('fire_stair_area') ? old('fire_stair_area') : (count($previous_data) ? $previous_data->first()->fire_stair_area : null),['class' => 'form-control text-center','id' => 'fire_stair_area', 'autocomplete'=>"off" , 'required'])}}
                </div>
            </div>  
            <div class="col-xl-3 col-md-3"></div> 

            <div class="col-xl-3 col-md-3"></div>
            <div class="col-xl-3 col-md-3">
                <div class="input-group input-group-sm input-group-primary">
                    <p>Number of Parkings in Basement</p>
                </div>
            </div>
            <div class="col-xl-3 col-md-3">
                <div class="input-group input-group-sm input-group-primary">
                    {{Form::number('parking_number', old('parking_number') ? old('parking_number') : (count($previous_data) ? $previous_data->first()->parking_number : null),['class' => 'form-control text-center','id' => 'parking_number', 'autocomplete'=>"off" , 'required'])}}
                </div>
            </div>  
            <div class="col-xl-3 col-md-3"></div>

            <div class="col-xl-3 col-md-3"></div>
            <div class="col-xl-3 col-md-3">
                <div class="input-group input-group-sm input-group-primary">
                    <p>Total Construction Life Cycle (Years)</p>
                </div>
            </div>
            <div class="col-xl-3 col-md-3">
                <div class="input-group input-group-sm input-group-primary">
                    {{Form::number('construction_life_cycle', old('construction_life_cycle') ? old('construction_life_cycle') : (count($previous_data) ? $previous_data->first()->construction_life_cycle : null),['class' => 'form-control text-center','id' => 'construction_life_cycle', 'autocomplete'=>"off" , 'required', 'step' => '0.01'])}}
                </div>
            </div>  
            <div class="col-xl-3 col-md-3"></div> 

            <div class="col-xl-3 col-md-3"></div>
            <div class="col-xl-3 col-md-3">
                <div class="input-group input-group-sm input-group-primary">
                    <p>Parking Sales Revenue (BDT/Parking)</p>
                </div>
            </div>
            <div class="col-xl-3 col-md-3">
                <div class="input-group input-group-sm input-group-primary">
                    {{Form::number('parking_sales_revenue', old('parking_sales_revenue') ? old('parking_sales_revenue') : (count($previous_data) ? $previous_data->first()->parking_sales_revenue : null),['class' => 'form-control text-center','id' => 'parking_sales_revenue', 'autocomplete'=>"off" , 'required'])}}
                </div>
            </div>  
            <div class="col-xl-3 col-md-3"></div> 

            {{-- <div class="col-xl-3 col-md-3"></div>
            <div class="col-xl-3 col-md-3">
                <div class="input-group input-group-sm input-group-primary">
                    <p>Semi Basement Floor Area (FAR Free)</p>
                </div>
            </div>
            <div class="col-xl-3 col-md-3">
                <div class="input-group input-group-sm input-group-primary">
                    {{Form::number('semi_basement_floor_area', old('semi_basement_floor_area') ? old('semi_basement_floor_area') : (count($previous_data) ? $previous_data->first()->semi_basement_floor_area : null),['class' => 'form-control text-center','id' => 'semi_basement_floor_area', 'autocomplete'=>"off" , 'required'])}}
                </div>
            </div>  
            <div class="col-xl-3 col-md-3"></div>  --}}

            {{-- <div class="col-xl-3 col-md-3"></div>
            <div class="col-xl-3 col-md-3">
                <div class="input-group input-group-sm input-group-primary">
                    <p>Total Ground Floor Area (FAR Free)</p>
                </div>
            </div>
            <div class="col-xl-3 col-md-3">
                <div class="input-group input-group-sm input-group-primary">
                    {{Form::number('ground_floor_area', old('ground_floor_area') ? old('ground_floor_area') : (count($previous_data) ? $previous_data->first()->ground_floor_area : null),['class' => 'form-control text-center','id' => 'ground_floor_area', 'autocomplete'=>"off" , 'required'])}}
                </div>
            </div>  
            <div class="col-xl-3 col-md-3"></div>  --}}

            <div class="col-xl-3 col-md-3"></div>
            <div class="col-xl-3 col-md-3">
                <div class="input-group input-group-sm input-group-primary">
                    <p>Total Apertment Number</p>
                </div>
            </div>
            <div class="col-xl-3 col-md-3">
                <div class="input-group input-group-sm input-group-primary">
                    {{Form::number('apertment_number', old('apertment_number') ? old('apertment_number') : (count($previous_data) ? $previous_data->first()->apertment_number : null),['class' => 'form-control text-center','id' => 'apertment_number', 'autocomplete'=>"off" , 'required'])}}
                </div>
            </div>  
            <div class="col-xl-3 col-md-3"></div> 

            <div class="col-xl-3 col-md-3"></div>
            <div class="col-xl-3 col-md-3">
                <div class="input-group input-group-sm input-group-primary">
                    <p>Floor Area %(FAR Free)</p>
                </div>
            </div>
            <div class="col-xl-3 col-md-3">
                <div class="input-group input-group-sm input-group-primary">
                    {{Form::number('floor_area_far_free', old('floor_area_far_free') ? old('floor_area_far_free') : (count($previous_data) ? $previous_data->first()->floor_area_far_free : null),['class' => 'form-control text-center','id' => 'floor_area_far_free', 'autocomplete'=>"off" ,'placeholder'=>'85', 'required'])}}
                </div>
            </div>  
            <div class="col-xl-3 col-md-3"></div> 

            <div class="col-xl-3 col-md-3"></div>
            <div class="col-xl-3 col-md-3">
                <div class="input-group input-group-sm input-group-primary">
                    <p>Bonus Sale-able area(%)</p>
                </div>
            </div>
            <div class="col-xl-3 col-md-3">
                <div class="input-group input-group-sm input-group-primary">
                    {{Form::number('bonus_saleable_area', old('bonus_saleable_area') ? old('bonus_saleable_area') : (count($previous_data) ? $previous_data->first()->bonus_saleable_area : null),['class' => 'form-control text-center','id' => 'bonus_saleable_area', 'autocomplete'=>"off" ,'placeholder'=>'15', 'required'])}}
                </div>
            </div>  
            <div class="col-xl-3 col-md-3"></div> 

            {{-- <div class="col-xl-3 col-md-3"></div>
            <div class="col-xl-3 col-md-3">
                <div class="input-group input-group-sm input-group-primary">
                    <p>Costing Value</p>
                </div>
            </div>
            <div class="col-xl-3 col-md-3">
                <div class="input-group input-group-sm input-group-primary">
                    {{Form::number('costing_value', old('costing_value') ? old('costing_value') : (count($previous_data) ? $previous_data->first()->costing_value : null),['class' => 'form-control text-center','id' => 'costing_value', 'autocomplete'=>"off" , 'placeholder'=>'1000000', 'required'])}}
                </div>
            </div>  
            <div class="col-xl-3 col-md-3"></div>  --}}

            <div class="col-xl-3 col-md-3"></div>
            <div class="col-xl-3 col-md-3">
                <div class="input-group input-group-sm input-group-primary">
                    <p>Parking Rate</p>
                </div>
            </div>
            <div class="col-xl-3 col-md-3">
                <div class="input-group input-group-sm input-group-primary">
                    {{Form::number('parking_rate', old('parking_rate') ? old('parking_rate') : (count($previous_data) ? $previous_data->first()->parking_rate : null),['class' => 'form-control text-center','id' => 'parking_rate', 'autocomplete'=>"off" , 'placeholder'=>'30000', 'required'])}}
                </div>
            </div>  
            <div class="col-xl-3 col-md-3"></div> 

            <div class="col-xl-3 col-md-3"></div>
            <div class="col-xl-3 col-md-3">
                <div class="input-group input-group-sm input-group-primary">
                    <p>Basement/Semi Basement FLoor Area</p>
                </div>
            </div>
            <div class="col-xl-3 col-md-3">
                <div class="input-group input-group-sm input-group-primary">
                    {{Form::number('basement_no', old('basement_no') ? old('basement_no') : (count($previous_data) ? $previous_data->first()->basement_no : null),['class' => 'form-control text-center','id' => 'basement_no', 'autocomplete'=>"off" , 'placeholder'=>'2', 'required'])}}
                </div>
            </div>  
            <div class="col-xl-3 col-md-3"></div> 

            <div class="col-xl-3 col-md-3"></div>
            <div class="col-xl-3 col-md-3">
                <div class="input-group input-group-sm input-group-primary">
                    <p>Development Plan</p>
                </div>
            </div>
            <div class="col-xl-3 col-md-3">
                <div class="input-group input-group-sm input-group-primary">
                    {{Form::text('dev_plan', old('dev_plan') ? old('dev_plan') : (count($previous_data) ? $previous_data->first()->dev_plan : null),['class' => 'form-control text-center','id' => 'dev_plan', 'autocomplete'=>"off" , 'placeholder'=>'2FB+SB+ GF+ 13 Living Floors + Lounge', 'required'])}}
                </div>
            </div>  
            <div class="col-xl-3 col-md-3"></div> 

        </div>
    
   
    <div class="row">
        <div class="offset-md-4 col-md-4 mt-2">
            <div class="input-group input-group-sm">
                <button class="btn btn-success btn-round btn-block py-2">Submit</button>
            </div>
        </div>
    </div>

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

