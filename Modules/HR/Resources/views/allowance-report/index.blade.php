@extends('layouts.backend-layout')
@section('title', 'Allowance Report')

@section('breadcrumb-title')
    @if ($formType == 'edit')
        Edit
    @else
        Create
    @endif
    Allowance Report
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
    @if ($formType == 'allowance-report')
        {!! Form::open([
            'url' => 'hr/allowance-report/report',
            'method' => 'POST',
            'class' => 'custom-form',
            'files' => true,
            'enctype' => 'multipart/form-data',
        ]) !!}
    @endif

    <div class="row">

        <div class="col-md-12">
            <div class="input-group input-group-sm input-group-primary d-flex flex-column justify-content-between my-2"
                style="font-size: 14px;">
                <div>
                    <input class="checkbox report-type" type="radio" name="report_type" id="month-wise-report" value="monthly"
                        checked> Monthly Allowance Report
                </div>
                <div>
                    <input class="checkbox report-type" type="radio" name="report_type" id="year-wise-report"
                        value="yearly"> Yearly Allowance Report
                </div>
            </div>
        </div>


        <div class="col-md-4 col-sm-12">
            <div class="input-group input-group-sm input-group-primary">
                <label style="" class="input-group-addon" for="employee_type_id">Employee</label>
                {{ Form::select('employee_id', $employees, old('employee_id'), ['class' => 'form-control select2', 'id' => 'employee_id', 'placeholder' => 'All', 'autocomplete' => 'off', '']) }}
                @error('employee_id')
                    <p class="text-danger">{{ $errors->first('employee_id') }}</p>
                @enderror
            </div>
        </div>

        <div class="col-md-4 col-sm-12" id='month-container'>
            <div class="input-group input-group-sm input-group-primary">
                <label style="" class="input-group-addon" for="date">Month<span
                        class="text-danger">*</span></label>
                {{ Form::month('month', old('month'), [
                    'class' => 'form-control',
                    'id' => 'month',
                    'placeholder' => 'Enter month Here',
                    'required',
                ]) }}

            </div>
            @error('month')
                <p class="text-danger">{{ $errors->first('month') }}</p>
            @enderror
        </div>

        <div class="col-md-4 col-sm-12" id="year-container">
            <div class="input-group input-group-sm input-group-primary">
                <label style="" class="input-group-addon" for="date">Year<span
                        class="text-danger">*</span></label>
                {{ Form::number('year', old('year'), [
                    'class' => 'form-control',
                    'id' => 'year',
                    'placeholder' => 'Enter year Here',
                    'required',
                ]) }}

            </div>
            @error('year')
                <p class="text-danger">{{ $errors->first('year') }}</p>
            @enderror
        </div>

    </div>


    <div class="row">
        <div class="offset-md-4 col-md-4 mt-2 ">
            <div class="input-group input-group-sm ">
                <button class="btn btn-success btn-round btn-block py-2" formtarget="_blank">Submit</button>
            </div>
        </div>
    </div> <!-- end row -->

    {!! Form::close() !!}
@endsection
@section('script')

    <script>
        $(document).ready(function() {
            setReportType($('.report-type').val())
        });

        $(document).on('change', '.report-type', function() {
            let reportType = $(this).val();
            setReportType(reportType)
        });

        function setReportType(type) {

            let reportType = type;

            if (reportType == 'monthly') {
                $("#year").val('');
                $('#year-container').hide();
                $("#year").prop("disabled", true);
                $("#month").prop("disabled", false);
                $('#month-container').show();
            } else {
                $("#month").val('');
                $('#month-container').hide();
                $("#month").prop("disabled", true);
                $("#year").prop("disabled", false);
                $('#year-container').show();
            }
        }
    </script>

@endsection
