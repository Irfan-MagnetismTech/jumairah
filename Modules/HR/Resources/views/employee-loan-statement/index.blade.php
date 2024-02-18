@extends('layouts.backend-layout')
@section('title', 'Employee Loan Statement')

@section('breadcrumb-title')

    Employee Loan Statement
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
    {{-- <a class="btn btn-out-dashed btn-sm btn-warning" href="{{ route('delivery-challans.index') }}"><i
            class="fas fa-database"></i></a> --}}
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'col-md-12 col-lg-12 col-sm-12 my-3')

@section('content')
    @if ($formType == 'employee-loan-statement')
        {!! Form::open([
            'url' => 'hr/employee-loan-statement/report',
            'method' => 'POST',
            'class' => 'custom-form',
            'files' => true,
            'enctype' => 'multipart/form-data',
        ]) !!}
    @endif


    <div class="row">

        <div class="col-md-6 col-sm-12" id="emp_field">
            <div class="input-group input-group-sm input-group-primary">
                <label style="" class="input-group-addon" for="employee_id">Employee</label>
                {{ Form::select('employee_id', $employees, old('employee_id'), ['class' => 'form-control select2', 'id' => 'employee_id', 'placeholder' => 'All', 'autocomplete' => 'off']) }}
                @error('employee_id')
                    <p class="text-danger">{{ $errors->first('employee_id') }}</p>
                @enderror
            </div>
        </div>


        <div class="col-md-6 col-sm-12" id="emp_field">
            <div class="input-group input-group-sm input-group-primary">
                <label style="" class="input-group-addon" for="employee_id">Employee Loan</label>
                {{ Form::select('employee_loan_id', [], old('employee_loan_id'), ['class' => 'form-control select2', 'id' => 'employee_loan_id', 'placeholder' => 'All', 'autocomplete' => 'off']) }}
                @error('employee_loan_id')
                    <p class="text-danger">{{ $errors->first('employee_loan_id') }}</p>
                @enderror
            </div>
        </div>
    </div>


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

    <script>
        $(document).on('change', '#employee_id', function() {
            var employee_id = $(this).val();
            if (employee_id) {
                $.ajax({
                    url: "{{ url('hr/get-employee-loan') }}",
                    type: "GET",
                    data: {
                        employee_id: employee_id
                    },
                    success: function(data) {
                        console.log("data", data)

                        $('#employee_loan_id').empty();
                        $('#employee_loan_id').append('<option value="">Select Employee Loan</option>');
                        $.each(data, function(key, value) {
                            $('#employee_loan_id').append('<option value="' + value.id + '">' +
                                value.loan_type + '</option>');
                        });




                    }
                });
            }
        });
    </script>

@endsection
