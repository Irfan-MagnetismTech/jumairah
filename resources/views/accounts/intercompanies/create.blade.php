@extends('layouts.backend-layout')
@section('title', 'Inter Companies')

@section('breadcrumb-title')
    @if($formType == 'edit')
        Edit Inter Company
    @else
        Add New Inter Company
    @endif
@endsection

@section('breadcrumb-button')
    <a href="{{ route('interCompanies.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'offset-md-1 col-md-10 offset-lg-2 col-lg-8 my-3')

@section('content')

    @if($formType == 'edit')
        {!! Form::open(array('url' => route('interCompanies.update', $interCompany->id),'method' => 'PUT', 'class'=>'custom-form')) !!}
    @else
        {!! Form::open(array('url' => route('interCompanies.store'),'method' => 'POST', 'class'=>'custom-form')) !!}
    @endif
        <div class="row">
            <input type="hidden" name="id" value="{{old('id') ? old('id') : (!empty($interCompany->id) ? $interCompany->id : null)}}">
            <div class="col-12">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="name">Company Name<span class="text-danger">*</span></label>
                    {{Form::text('name', old('name') ? old('name') : (!empty($interCompany->name) ? $interCompany->name : null),['class' => 'form-control','id' => 'name', 'autocomplete'=>"off"])}}
                </div>
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="address">Address</label>
                    {{Form::textarea('address', old('address') ? old('address') : (!empty($interCompany->address) ? $interCompany->address : null),['class' => 'form-control','id' => 'address', 'rows'=>"2"])}}
                </div>
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="office_phone">Office Phone</label>
                    {{Form::text('office_phone', old('office_phone') ? old('office_phone') : (!empty($interCompany->office_phone) ? $interCompany->office_phone : null),['class' => 'form-control','id' => 'office_phone', 'autocomplete'=>"off"])}}
                </div>
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="contact_person">Contact Person</label>
                    {{Form::text('contact_person', old('contact_person') ? old('contact_person') : (!empty($interCompany->contact_person) ? $interCompany->contact_person : null),['class' => 'form-control','id' => 'contact_person', 'autocomplete'=>"off", 'placeholder'=>"Enter Name"])}}
                    {{Form::text('contact_person_cell', old('contact_person_cell') ? old('contact_person_cell') : (!empty($interCompany->contact_person_cell) ? $interCompany->contact_person_cell : null),['class' => 'form-control','id' => 'contact_person_cell', 'autocomplete'=>"off", 'placeholder'=>"Enter Mobile No"])}}
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
