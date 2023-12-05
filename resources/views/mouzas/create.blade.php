@extends('layouts.backend-layout')
@section('title', 'Mouza')

@section('breadcrumb-title')
    @if($formType == 'edit')  Edit  @else  Create  @endif
    Mouza
@endsection

@section('style')
    <style>
        .input-group-addon{
            min-width: 120px;
        }
        .input-group-info .input-group-addon{
            /*background-color: #04748a!important;*/
        }
    </style>
@endsection
@section('breadcrumb-button')
    <a href="{{ route('mouzas.index')}}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'offset-md-1 col-md-10 offset-lg-2 col-lg-8 my-3')

@section('content')
    @if($formType == 'create')
        {!! Form::open(array('url' => "mouzas",'method' => 'POST', 'class'=>'custom-form')) !!}
    @else
        {!! Form::open(array('url' => "mouzas/$mouza->id",'method' => 'PUT', 'class'=>'custom-form')) !!}
        {{Form::hidden('id', old('id') ? old('id') : (!empty($mouza->id) ? $mouza->id : null),['class' => 'form-control','id' => 'id'] )}}
    @endif
     <div class="row">
         <div class="col-12">
             <div class="input-group input-group-sm input-group-primary">
                 <label class="input-group-addon" for="name">Division</label>
                 {{Form::select('division_id',$division, old('division_id') ? old('division_id') : (!empty($mouza) ? $mouza->thana->district->division_id : null),['class' => 'form-control','id' => 'division_id', 'placeholder' => 'Select Division'] )}}
             </div>
         </div>
         <div class="col-12">
             <div class="input-group input-group-sm input-group-primary">
                 <label class="input-group-addon" for="name">District</label>
                {{Form::select('district_id',$district, old('district_id') ? old('district_id') : (!empty($mouza) ? $mouza->thana->district_id : null),['class' => 'form-control','id' => 'district_id', 'placeholder' => 'Select District'] )}}
             </div>
         </div>
         <div class="col-12">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="name">Thana<span class="text-danger">*</span></label>
                {{Form::select('thana_id',$thana, old('thana_id') ? old('thana_id') : (!empty($mouza) ? $mouza->thana_id : null),['class' => 'form-control','id' => 'thana_id', 'placeholder' => 'Select Thana', 'required'] )}}
            </div>
        </div>
         <div class="col-12">
             <div class="input-group input-group-sm input-group-primary">
                 <label class="input-group-addon" for="name">Mouza Name <span class="text-danger">*</span></label>
                 {{Form::text('name', old('name') ? old('name') : (!empty($mouza->name) ? $mouza->name : null),['class' => 'form-control','id' => 'name', 'placeholder' => 'Type Mouza Name Here', 'required'] )}}
             </div>
         </div>
         
    </div><!-- end row -->
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
       
        const CSRF_TOKEN= "{{csrf_token()}}";

        $(function(){
            $('#division_id').on('change',function () {
                let division_id = $(this).val();
                const url = '{{url("getDistricts")}}/' + division_id;
                let dropdown = $('#district_id');
                let thana_dropdown = $('#thana_id');
                thana_dropdown.empty();
                dropdown.empty();
                dropdown.append('<option selected="true" disabled>Select District </option>');
                thana_dropdown.append('<option selected="true" disabled>Select Thana </option>');
                dropdown.prop('selectedIndex', 0)
                        $.ajax({
                            url: url,
                            type: 'get',
                            dataType: "json",
                            data: {
                                _token: CSRF_TOKEN,
                                division_id
                            },
                            success: function( districts ) {
                                $.each(districts, function (key, district) {
                                dropdown.append($('<option></option>').attr('value', district.id).text(district.name));
                                })
                            }
                        });

            });

            $('#district_id').on('change',function () {
                let district_id = $(this).val();
                const url = '{{url("getThanas")}}/' + district_id;
                let dropdown = $('#thana_id');
                dropdown.empty();
                dropdown.append('<option selected="true" disabled>Select Thana </option>');
                dropdown.prop('selectedIndex', 0)
                        $.ajax({
                            url: url,
                            type: 'get',
                            dataType: "json",
                            data: {
                                _token: CSRF_TOKEN,
                                district_id
                            },
                            success: function( thanas ) {
                                $.each(thanas, function (key, thana) {
                                dropdown.append($('<option></option>').attr('value', thana.id).text(thana.name));
                                })
                            }
                        });

            });

        });//document.ready

       
    </script>

@endsection
