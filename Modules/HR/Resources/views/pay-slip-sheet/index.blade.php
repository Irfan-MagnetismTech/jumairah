@extends('layouts.backend-layout')
@section('title', 'Pay Slip Sheet')

@section('breadcrumb-title')
    @if ($formType == 'edit')
        Edit
    @else
        Create
    @endif
    Pay Slip Report
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
    @if ($formType == 'pay-slip-report')
        {!! Form::open([
            'url' => 'hr/pay-slip-report/report',
            'method' => 'POST',
            'class' => 'custom-form',
            'files' => true,
            'enctype' => 'multipart/form-data',
        ]) !!}
    @endif

    <div class="row px-4 py-2">
        <div class="col-md-6 py-2">
            <div class="input-group input-group-sm input-group-primary type_of_select" style="display:flex;  flex-wrap: wrap;
                justify-content: space-around;font-size: 14px;">
                <div>
                    <input class="checkbox search_type employee_wise"  type="checkbox" name="employee_wise" id="employee_wise" value="employee" checked> Employee Wise
                </div>
                <div>
                    <input class="checkbox search_type department_wise"  type="checkbox" name="department_wise" id="department_wise" value="department"> Department Wise
                </div>
            </div>
        </div>
    </div>
    <div class="row px-5">
        <div class="col-md-4 col-sm-12 d-none" id="dept_field">
            <div class="input-group input-group-sm input-group-primary">
                <label style="" class="input-group-addon" for="department">Department</label>
                {{Form::select('department_id', $departments, old('department_id'),['class' => 'form-control','id' => 'department_id', 'placeholder'=>"All", 'autocomplete'=>"off", ""])}}
                @error('department_id')
                    <p class="text-danger">{{ $errors->first('department_id') }}</p>
                @enderror
            </div>
        </div>
        <div class="col-md-4 col-sm-12" id="emp_field">
            <div class="input-group input-group-sm input-group-primary">
                <label style="" class="input-group-addon" for="employee_id">Employee</label>
                {{Form::select('employee_id', $employees, old('employee_id'),['class' => 'form-control select2','id' => 'employee_id', 'placeholder'=>"All", 'autocomplete'=>"off", "required"])}}
                @error('employee_id')
                    <p class="text-danger">{{ $errors->first('employee_id') }}</p>
                @enderror
            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="input-group input-group-sm input-group-primary">
                <label style="" class="input-group-addon" for="employee_id">Type</label>
                {{Form::select('type',
                    [
                        'salary' => 'Salary',
                        'bonus' => 'Bonus',
                    ]
                , old('type'),['class' => 'form-control','id' => 'type', 'placeholder'=>"All", 'autocomplete'=>"off", "required"])}}
                @error('type')
                    <p class="text-danger">{{ $errors->first('type') }}</p>
                @enderror
            </div>
        </div>

        <div class="col-md-4 col-sm-12" id='month-container'>
            <div class="input-group input-group-sm input-group-primary">
                <label style="" class="input-group-addon" for="date">Month<span
                        class="text-danger">*</span></label>
                {{ Form::month(
                    'month',
                    old('month'),
                    [
                        'class' => 'form-control',
                        'id' => 'month',
                        'placeholder' => 'Enter month Here',
                        'required',
                    ],
                ) }}

            </div>
                @error('month')
                    <p class="text-danger">{{ $errors->first('month') }}</p>
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
    $(document).on('change', '.search_type', function() {
        let search_type = $(this).val();
        if(search_type== 'employee'){
            $("#emp_field").removeClass("d-none");
            $("#employee_id").prop("required", true);
            $("#depertment_id").prop("required", false);
            $("#depertment_id").val("");
            $("#dept_field").addClass("d-none");
        }else if(search_type== 'department'){
            $("#dept_field").removeClass("d-none");
            $("#employee_id").prop("required", false);
            $("#depertment_id").prop("required", true);
            $("#employee_id").val("");
            $("#emp_field").addClass("d-none");
        }
    });


    // use for shift table only one item check
    const checkboxes = document.querySelectorAll('input[type="checkbox"]');
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', () => {
            if (checkbox.checked) {
                uncheckOtherCheckboxes(checkbox);
            }
        });
    });

    function uncheckOtherCheckboxes(checkedCheckbox) {
        checkboxes.forEach(checkbox => {
        if (checkbox !== checkedCheckbox) {
            checkbox.checked = false;
        }
        });
    }
</script>

@endsection
