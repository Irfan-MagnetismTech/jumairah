@extends('layouts.backend-layout')
@section('title', 'District')

@section('breadcrumb-title')
@if ($formType == 'edit')
Edit
@else
Create
@endif
Districts
@endsection

@section('style')
<style>
    .input-group-addon {
        min-width: 120px;
    }
</style>
@endsection
@section('breadcrumb-button')
<a class="btn btn-out-dashed btn-sm btn-warning" href="{{ route('districts.index') }}"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
<span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'offset-md-1 col-md-10 offset-lg-2 col-lg-8 my-3')

@section('content')
@if ($formType == 'create')
{!! Form::open(['url' => 'hr/districts', 'method' => 'POST', 'class' => 'custom-form', 'files' =>
true,'enctype'=>'multipart/form-data']) !!}
@else

{!! Form::open([
'url' => "hr/districts/$district->id",
'method' => 'PUT',
'class' => 'custom-form',
'files' => true,
'enctype'=>'multipart/form-data',
]) !!}
@endif

<div class="row">
    <div class="col-12">
        <div class="input-group input-group-sm input-group-primary">
            <label style="min-width: 22% !important; max-width:22% !important;" class="input-group-addon" for="name">District Name <span class="text-danger">*</span></label>
            {{ Form::text(
            'name',
            old('name')
            ? old('name')
            : (!empty($district->name)
            ? $district->name
            : null),
            ['class' => 'form-control', 'id' => 'name', 'placeholder' => 'Enter name Here', 'required'],
            ) }}
            @error('name')
            <p class="text-danger">{{ $errors->first('name') }}</p>
            @enderror
        </div>
    </div>
    <div class="col-12">
        <div class="input-group input-group-sm input-group-primary">
            <label style="min-width: 22% !important; max-width:22% !important;" class="input-group-addon" for="name">Bangla <span class="text-danger">*</span></label>
            {{ Form::text(
            'bangla',
            old('bangla')
            ? old('bangla')
            : (!empty($district->bangla)
            ? $district->bangla
            : null),
            ['class' => 'form-control', 'id' => 'bangla', 'placeholder' => 'Enter bangla Here', 'required'],
            ) }}
            @error('bangla')
            <p class="text-danger">{{ $errors->first('bangla') }}</p>
            @enderror
        </div>
    </div>

    <div class="col-12">
        <div class="input-group input-group-sm input-group-primary">
            <label style="min-width: 22% !important; max-width:22% !important;" class="input-group-addon" for="name">Short Name <span class="text-danger">*</span></label>
            {{ Form::text(
            'short_name',
            old('short_name')
            ? old('short_name')
            : (!empty($district->short_name)
            ? $district->short_name
            : null),
            ['class' => 'form-control', 'id' => 'short_name', 'placeholder' => 'Enter Short name Here', 'required'],
            ) }}
            @error('short_name')
            <p class="text-danger">{{ $errors->first('short_name') }}</p>
            @enderror
        </div>
    </div>

    <div class="col-6">
        <div class="input-group input-group-sm input-group-primary">
            <label style="min-width: 22% !important; max-width:22% !important;" class="input-group-addon" for="name">Country <span class="text-danger">*</span></label>
            {{Form::select(
                    '',
                    $country,
                    old('country_id') ? old('country_id')
                    : (!empty($district->division->country->id) ? $district->division->country->id : null),
                    ['class' => 'form-control form-control-sm','id' => 'country_id', 'placeholder' => 'Select Country ', 'autocomplete'=>"off"] )}}
            @error('country_id')
            <p class="text-danger">{{ $errors->first('country_id') }}</p>
            @enderror
        </div>
    </div>

    <div class="col-6">
        <div class="input-group input-group-sm input-group-primary">
            <label style="min-width: 22% !important; max-width:22% !important;" class="input-group-addon" for="division_id">Division <span class="text-danger">*</span></label>
            <select id="division_id" name="division_id" class="form-control form-control-sm">
                <option value="">No Divisions</option>
            </select>
            @error('division_id')
            <p class="text-danger">{{ $errors->first('division_id') }}</p>
            @enderror
        </div>
    </div>
</div><!-- end row -->

<div class="row">
    <div class="offset-md-4 col-md-4 mt-2 ">
        <div class="input-group input-group-sm ">
            <button class="btn btn-success btn-round btn-block py-2">Submit</button>
        </div>
    </div>
</div> <!-- end row -->
{!! Form::close() !!}
@endsection
@section('script')
@php
$country_id = (!empty($district->division->country->id) ? $district->division->country->id : null);
$division_id = (!empty($district->division->id) ? $district->division->id : null);
@endphp
<script>
    $(document).ready(function() {
        let countryId = "{{ $country_id }}";
        LoadDivisionDropDown(countryId);
    });

    $(document).on('change', '#country_id', function(params) {
        var countryId = $('#country_id').val();
        LoadDivisionDropDown(countryId);
    })

    function LoadDivisionDropDown(countryId) {
        if (countryId) {
            $.ajax({
                url: '{{ route("fetchDivisions") }}',
                type: 'POST',
                data: {
                    '_token': '{{ csrf_token() }}',
                    'country_id': countryId
                },
                success: function(data) {
                    // Update the Division dropdown with the fetched divisions
                    $('#division_id').html(data);
                    $('#division_id').val("{{ $division_id }}");
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
    }
</script>

@endsection
