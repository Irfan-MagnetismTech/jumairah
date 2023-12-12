@extends('layouts.backend-layout')
@section('title', 'ID Card')

@section('breadcrumb-title')
    Print Employee ID Card
@endsection

@section('style')
    <style scoped>
        .input-group-addon {
            min-width: 120px;
        }

        .border-none>tr>td {
            border: none !important;
        }
    </style>
@endsection
@section('breadcrumb-button')
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'col-md-12 col-lg-12 col-sm-12 my-3')

@section('content')

    {!! Form::open([
        'url' => 'hr/employee-idcard-print',
        'method' => 'POST',
        'class' => 'custom-form',
    ]) !!}


    <div class="row">

        <div class="col-md-6 col-sm-12">
            <div class="input-group input-group-sm input-group-primary">
                <label style="min-width: 22% !important; max-width:22% !important;" class="input-group-addon"
                    for="department_id">Department<span class="text-danger">*</span></label>
                {{ Form::select('department_id', $departments, old('department_id'), ['class' => 'form-control select2', 'id' => 'department_id', 'placeholder' => 'All', 'autocomplete' => 'off', '']) }}
                @error('department_id')
                    <p class="text-danger">{{ $errors->first('department_id') }}</p>
                @enderror
            </div>
        </div>

        <div class="col-md-6">
            <div class="input-group input-group-sm input-group-primary " id="employee_box">
                <label style="min-width: 22% !important; max-width:22% !important;" class="input-group-addon"
                    for="name">Employee<span class="text-danger">*</span></label>
                {{ Form::select('employee_id[]', $employees, old('employee_id') ? old('employee_id') : '', [
                    'class' => 'form-control select2 multiple',
                    'id' => 'employee_id',
                    'multiple' => 'multiple',
                    'required',
                ]) }}
                @error('employee_id')
                    <p class="text-danger">{{ $errors->first('employee_id') }}</p>
                @enderror
            </div>
        </div>
    </div>


    <div class="row">
        <div class="offset-md-4 col-md-4 mt-2 ">
            <div class="input-group input-group-sm ">
                <button class="btn btn-success btn-round btn-block py-2" formtarget="_blank">Submit</button>
            </div>
        </div>
    </div>

    {!! Form::close() !!}
@endsection




@section('script')
    <script>
        $('#department_id').change(() => {

            $('#employee_box').waitMe({
                effect: 'ios'
            });

            $.ajax({
                url: "{{ route('getDepartmentWiseEmployees') }}",
                type: 'GET',
                dataType: 'json',
                data: {
                    _token: '{{ csrf_token() }}',
                    department_id: $('#department_id ').val()
                },
                success: function(response) {
                    $('#employee_id').empty();
                    $('#employee_id').append('<option value="">' + "All" + '</option>');
                    $.each(response, function(index, value) {

                        $('#employee_id').append('<option value="' + value.id + '">' + value
                            .text + '</option>');
                    });
                    $('#employee_box').waitMe("hide");

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $('#employee_box').waitMe("hide");
                    console.log(textStatus + ': ' + errorThrown);
                }
            });
        });
    </script>
@endsection
