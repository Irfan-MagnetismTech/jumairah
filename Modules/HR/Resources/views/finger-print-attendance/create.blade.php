@extends('layouts.backend-layout')
@section('title', 'Finger Print Attendance')

@section('breadcrumb-title')
    @if ($formType == 'edit')
        Edit
    @else
        Enter
    @endif
    Finger Print Device User
@endsection

@section('style')
    <style>
        .input-group-addon {
            min-width: 120px;
        }
    </style>
@endsection
@section('breadcrumb-button')
    <a class="btn btn-out-dashed btn-sm btn-warning" href="{{ route('finger-print-device-users.index') }}"><i
            class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'offset-md-1 col-md-10 offset-lg-2 col-lg-8 my-3')

@section('content')
    @if ($formType == 'create')
        {!! Form::open([
            'url' => 'hr/finger-print-device-users',
            'method' => 'POST',
            'class' => 'custom-form',
            'files' => true,
            'enctype' => 'multipart/form-data',
        ]) !!}
    @else
        {!! Form::open([
            'url' => "hr/finger-print-device-users/$user->id",
            'method' => 'PUT',
            'class' => 'custom-form',
            'files' => true,
            'enctype' => 'multipart/form-data',
        ]) !!}
    @endif

    <div class="row">

        <div class="col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label style="min-width: 22% !important;" class="input-group-addon" for="name">User Name <span
                        class="text-danger">*</span></label>
                {{ Form::text(
                    'device_user_name',
                    old('device_user_name') ? old('device_user_name') : (!empty($device->device_user_name) ? $device->device_user_name : null),
                    [
                        'class' => 'form-control',
                        'id' => 'device_user_name',
                        'placeholder' => 'Enter device user name Here',
                        'required',
                    ],
                ) }}
                @error('device_user_name')
                    <p class="text-danger">{{ $errors->first('device_user_name') }}</p>
                @enderror
            </div>
        </div>

        <div class="col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label style="min-width: 22% !important;" class="input-group-addon" for="name">User Password <span
                        class="text-danger">*</span></label>
                {{ Form::text(
                    'device_user_password',
                    old('device_user_password') ? old('device_user_password') : (!empty($device->device_user_password) ? $device->device_user_password : null),
                    [
                        'class' => 'form-control',
                        'id' => 'device_user_password',
                        'placeholder' => 'Enter device User ID Here',
                        'required',
                        'max' => 100
                    ],
                ) }}
                @error('device_user_password')
                    <p class="text-danger">{{ $errors->first('device_user_password') }}</p>
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
        $country_id = !empty($device->division->country->id) ? $device->division->country->id : null;
        $division_id = !empty($device->division->id) ? $device->division->id : null;
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
                    url: '{{ route('fetchDivisions') }}',
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
