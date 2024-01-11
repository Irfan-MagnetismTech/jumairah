@extends('layouts.backend-layout')
@section('title', 'Bonus Setting')

@section('breadcrumb-title')
    @if ($formType == 'edit')
        Edit
    @else
        Create
    @endif
    Bonus Setting
@endsection

@section('style')
    <style>
        .input-group-addon {
            min-width: 120px;
        }
    </style>
@endsection
@section('breadcrumb-button')
    <a class="btn btn-out-dashed btn-sm btn-warning" href="{{ route('bonus-settings.index') }}"><i
            class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'offset-md-1 col-md-10 offset-lg-2 col-lg-8 my-3')

@section('content')
    @if ($formType == 'create')
        {!! Form::open([
            'url' => 'hr/bonus-settings',
            'method' => 'POST',
            'class' => 'custom-form',
            'files' => true,
            'enctype' => 'multipart/form-data',
        ]) !!}
    @else
        {!! Form::open([
            'url' => "hr/bonus-settings/$bonusSetting->id",
            'method' => 'PUT',
            'class' => 'custom-form',
            'files' => true,
            'enctype' => 'multipart/form-data',
        ]) !!}
    @endif

    <div class="row">

        <div class="col-md-6 col-sm-12">
            <div class="input-group input-group-sm input-group-primary">
                <label style="min-width: 22% !important; max-width:22% !important;" class="input-group-addon"
                    for="department_id">Department<span class="text-danger">*</span></label>
                {{ Form::select('department_id', $departments, old('department_id'), ['class' => 'form-control', 'id' => 'department_id', 'placeholder' => 'All', 'autocomplete' => 'off', '']) }}
                @error('department_id')
                    <p class="text-danger">{{ $errors->first('department_id') }}</p>
                @enderror
            </div>
        </div>

        <div class="col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label style="min-width: 22% !important; max-width:22% !important;" class="input-group-addon"
                    for="name">Employee<span class="text-danger">*</span></label>
                {{ Form::select(
                    'employee_id[]',
                    $employees,
                    old('employee_id') ? old('employee_id') : (!empty($bonusSetting->employee_id) ? $bonusSetting->employee_id : ''),
                    [
                        'class' => 'form-control employee_id select2',
                        'id' => 'employee_id',
                        // 'placeholder' => 'Select Employee',
                        'multiple' => 'multiple',
                    ],
                ) }}
                @error('employee_id')
                    <p class="text-danger">{{ $errors->first('employee_id') }}</p>
                @enderror
            </div>
        </div>

        <div class="col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label style="min-width: 22% !important; max-width:22% !important;" class="input-group-addon"
                    for="name">Bonus<span class="text-danger">*</span></label>

                {{ Form::select(
                    'bonus_id[]',
                    $bonuses,
                    old('bonus_id') ? old('bonus_id') : (!empty($bonusSetting->bonus_id) ? json_decode($bonusSetting->bonus_id) : []),
                    ['class' => 'form-control select2', 'id' => 'bonus_id', 'multiple'],
                ) }}
                @error('bonus_id')
                    <p class="text-danger">{{ $errors->first('bonus_id') }}</p>
                @enderror
            </div>
        </div>

        <div class="col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label style="min-width: 24% !important; max-width:24% !important;" class="input-group-addon"
                    for="name">Bonus Based on<span class="text-danger">*</span></label>
                {{ Form::select(
                    'based_on',
                    [
                        'gross' => 'gross',
                        'basic' => 'basic',
                    ],
                    old('based_on') ? old('based_on') : (!empty($bonusSetting->based_on) ? $bonusSetting->based_on : ''),
                    ['class' => 'form-control', 'id' => 'based_on', 'placeholder' => 'Select Bonus Base Type'],
                ) }}
                @error('based_on')
                    <p class="text-danger">{{ $errors->first('based_on') }}</p>
                @enderror
            </div>
        </div>

        <div class="col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label style="min-width: 22% !important; max-width:22% !important;" class="input-group-addon"
                    for="name">Amount Type<span class="text-danger">*</span></label>
                {{ Form::select(
                    'amount_type',
                    [
                        'flat' => 'flat',
                        'percentage' => 'percentage',
                    ],
                    old('amount_type')
                        ? old('amount_type')
                        : (!empty($bonusSetting->amount_type)
                            ? $bonusSetting->amount_type
                            : 'flat'),
                    ['class' => 'form-control', 'id' => 'amount_type', 'placeholder' => 'Select Amount Type'],
                ) }}
                @error('amount_type')
                    <p class="text-danger">{{ $errors->first('amount_type') }}</p>
                @enderror
            </div>
        </div>

        <div class="col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label style="min-width: 22% !important; max-width:22% !important;" class="input-group-addon"
                    for="name">Amount<span class="text-danger">*</span></label>
                {{ Form::number(
                    'amount',
                    old('amount') ? old('amount') : (!empty($bonusSetting->amount) ? $bonusSetting->amount : 'flat'),
                    ['class' => 'form-control', 'id' => 'amount', 'placeholder' => 'Amount'],
                ) }}
                @error('amount')
                    <p class="text-danger">{{ $errors->first('amount') }}</p>
                @enderror
            </div>
        </div>

        <div class="col-md-6">
            <div class="input-group input-group-sm input-group-primary">
                <label style="min-width: 26% !important; max-width:26% !important;" class="input-group-addon"
                    for="name">Applicable after<span class="text-danger">*</span></label>
                {{ Form::select(
                    'applicable_after',
                    [
                        0 => 'Immediately',
                        1 => 'One Month',
                        2 => 'Two Month',
                        3 => 'Three Month',
                        4 => 'Four Month',
                        5 => 'Five Month',
                        6 => 'Six Month',
                        7 => 'Seven Month',
                        8 => 'Eight Month',
                        9 => 'Nine Month',
                        10 => 'Ten Month',
                        11 => 'Eleven Month',
                        12 => 'Twelve Month',
                    ],
                    old('applicable_after')
                        ? old('applicable_after')
                        : (!empty($bonusSetting->applicable_after)
                            ? $bonusSetting->applicable_after
                            : '1'),
                    ['class' => 'form-control', 'id' => 'applicable_after', 'placeholder' => 'Select Applicable After'],
                ) }}
                @error('applicable_after')
                    <p class="text-danger">{{ $errors->first('applicable_after') }}</p>
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
    <script>
        $('#department_id').change(() => {
            $.ajax({
                url: "{{ route('getDepartmentWiseEmployees') }}",
                type: 'GET',
                dataType: 'json',
                data: {
                    _token: '{{ csrf_token() }}',
                    department_id: $('#department_id').val() ?? ''
                },
                success: function(response) {
                    $('#employee_id').empty();
                    $('#employee_id').append('<option value="">' + "All" + '</option>');
                    $.each(response, function(index, value) {

                        $('#employee_id').append('<option value="' + value.id + '">' + value
                            .text + '</option>');
                    });
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus + ': ' + errorThrown);
                }
            });
        });

        $('#amount_type').change(() => {
            let amount_type = $('#amount_type').val();
            let amount = $('#amount').val()
            if (amount_type == 'percentage' && amount > 100) {
                $('#amount').val(100)
            }
        });


        $('#amount').keyup(function(e) {
            let amount_type = $('#amount_type').val();
            let amount = $('#amount').val()
            if (amount_type == 'percentage' && amount > 100) {
                $('#amount').val(100)
            }
        });
    </script>
@endsection
