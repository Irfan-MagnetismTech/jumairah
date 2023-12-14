@extends('layouts.backend-layout')
@section('title', 'Warehouses')

@section('breadcrumb-title')
    @if($formType == 'edit')
        Edit Warehouse
    @else
        Add New Warehouse
    @endif
@endsection

@section('breadcrumb-button')
    <a href="{{ url('warehouses') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'offset-md-1 col-md-10 offset-lg-2 col-lg-8 my-3')

@section('content')

    @if($formType == 'edit')
        {!! Form::open(array('url' => "warehouses/$warehouse->id",'encType' =>"multipart/form-data",'method' => 'PUT', 'class'=>'custom-form')) !!}
    @else
        {!! Form::open(array('url' => "warehouses",'encType' =>"multipart/form-data",'method' => 'POST', 'class'=>'custom-form')) !!}
    @endif
        <div class="row">
            <input type="hidden" name="id" value="{{old('id') ? old('id') : (!empty($warehouse->id) ? $warehouse->id : null)}}">
            <div class="col-12">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="name">Warehouse Name<span class="text-danger">*</span></label>
                    {{Form::text('name', old('name') ? old('name') : (!empty($warehouse->name) ? $warehouse->name : null),['class' => 'form-control','id' => 'name', 'autocomplete'=>"off","required"])}}
                </div>
            </div>

            <div class="col-12">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="location">Location <span class="text-danger">*</span></label>
                    {{Form::text('location', old('location') ? old('location') : (!empty($warehouse->location) ? $warehouse->location : null),['class' => 'form-control','id' => 'location', 'autocomplete'=>"off","required"])}}
                </div>
            </div>

            <div class="col-12">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="number">Contact Number <span class="text-danger">*</span></label>
                    {{Form::text('number', old('number') ? old('number') : (!empty($warehouse->number) ? $warehouse->number : null),['class' => 'form-control','id' => 'number', 'autocomplete'=>"off","required"])}}
                </div>
            </div>

            <div class="col-12">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="contact_person_id">Contact Person<span class="text-danger">*</span></label>
                    {{Form::select('contact_person_id', $employees, old('contact_person_id') ? old('contact_person_id') : (!empty($warehouse->contact_person_id) ? $warehouse->contact_person_id : null),['class' => 'form-control','id' => 'contact_person_id', 'autocomplete'=>"off","required"])}}
                </div>
            </div>

            <div class="col-12">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="number">Total Value</label>
                    {{Form::text('total_value', old('total_value') ? old('total_value') : (!empty($warehouse->WarehouseDetail->total_value) ? $warehouse->WarehouseDetail->total_value : null),['class' => 'form-control','id' => 'total_value', 'autocomplete'=>"off"])}}
                </div>
            </div>

            <div class="col-12">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="number">Per Month Rent</label>
                    {{Form::text('per_mounth_rent', old('per_mounth_rent') ? old('per_mounth_rent') : (!empty($warehouse->WarehouseDetail->per_mounth_rent) ? $warehouse->WarehouseDetail->per_mounth_rent : null),['class' => 'form-control','id' => 'per_mounth_rent', 'autocomplete'=>"off","required"])}}
                </div>
            </div>

            <div class="col-12">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="number">Adjusted Amount</label>
                    {{Form::text('adjusted_amount', old('adjusted_amount') ? old('adjusted_amount') : (!empty($warehouse->WarehouseDetail->adjusted_amount) ? $warehouse->WarehouseDetail->adjusted_amount : null),['class' => 'form-control','id' => 'adjusted_amount', 'autocomplete'=>"off"])}}
                </div>
            </div>

            <div class="col-12">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="number">Advance Amount</label>
                    {{Form::text('advance', old('advance') ? old('advance') : (!empty($warehouse->WarehouseDetail->advance) ? $warehouse->WarehouseDetail->advance : null),['class' => 'form-control','id' => 'advance', 'autocomplete'=>"off"])}}
                </div>
            </div>

            <div class="col-12">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="number">Duration</label>
                    {{Form::text('duration', old('duration') ? old('duration') : (!empty($warehouse->WarehouseDetail->duration) ? $warehouse->WarehouseDetail->duration : null),['class' => 'form-control','id' => 'duration', 'autocomplete'=>"off"])}}
                </div>
            </div>

            <div class="col-12">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="number">Owner's Name</label>
                    {{Form::text('owner_name', old('owner_name') ? old('owner_name') : (!empty($warehouse->WarehouseDetail->owner_name) ? $warehouse->WarehouseDetail->owner_name : null),['class' => 'form-control','id' => 'owner_name', 'autocomplete'=>"off"])}}
                </div>
            </div>

            <div class="col-12">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="number">Owner's Contact</label>
                    {{Form::text('owner_contact', old('owner_contact') ? old('owner_contact') : (!empty($warehouse->WarehouseDetail->owner_contact) ? $warehouse->WarehouseDetail->owner_contact : null),['class' => 'form-control','id' => 'owner_contact', 'autocomplete'=>"off"])}}
                </div>
            </div>

            <div class="col-12">
                <div class="input-group input-group-sm input-group-primary">
                    <label class="input-group-addon" for="number">Owner's Address</label>
                    {{Form::text('owner_address', old('owner_address') ? old('owner_address') : (!empty($warehouse->WarehouseDetail->owner_address) ? $warehouse->WarehouseDetail->owner_address : null),['class' => 'form-control','id' => 'owner_address', 'autocomplete'=>"off"])}}
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
