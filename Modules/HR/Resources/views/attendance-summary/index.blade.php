@extends('layouts.backend-layout')
@section('title', 'Attendance Summary')

@section('breadcrumb-title')
    @if ($formType == 'edit')
        Edit
    @else
        Create
    @endif
    Attendance Summary
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
    @if ($formType == 'attendance-summary')
        {!! Form::open([
            'url' => 'hr/attendance-summary/report',
            'method' => 'POST',
            'class' => 'custom-form',
            'files' => true,
            'enctype' => 'multipart/form-data',
        ]) !!}
    @endif

    <div class="row">

        <div class="col-md-6 col-sm-12">
            <div class="input-group input-group-sm input-group-primary d-flex flex-column justify-content-between my-2" style="font-size: 14px;">
                <div>
                    <input class="checkbox report-type"  type="radio" name="report_type" id="month-wise-report" value="monthly" checked> Monthly Attendance Summary
                </div>
                <div>
                    <input class="checkbox report-type"  type="radio" name="report_type" id="year-wise-report" value="yearly" > Yearly Attendance Summary
                </div>
            </div>
        </div>

        <div class="col-md-6 col-sm-12">
            <div id="month-container">
                <div class="input-group input-group-sm input-group-primary">
                    <label style="" class="input-group-addon" for="month">Month <span
                            class="text-danger">*</span></label>

                    <input type="month" class="form-control" name="month" id="month" placeholder="Select Month Here" value="{{ date('Y-m') }}" required/>

                </div>
                @error('month')
                    <p class="text-danger">{{ $errors->first('month') }}</p>
                @enderror
            </div>
            <div id="year-container">
                <div class="input-group input-group-sm input-group-primary">
                    <label style="" class="input-group-addon" for="year">Year <span
                            class="text-danger">*</span></label>

                    <input type="number" class="form-control" name="year" id="year" placeholder="Select year here" min="1900" max="2900" value="{{ date('Y') }}" required/>

                </div>
                @error('year')
                    <p class="text-danger">{{ $errors->first('year') }}</p>
                @enderror
            </div>

        </div>

        <div class="col-md-12">
            <hr>
            <div class="input-group input-group-sm input-group-primary d-flex flex-wrap justify-content-between my-2" style="font-size: 14px;">
                <div>
                    <input class="checkbox search-type"  type="radio" name="search_type" id="all-employee" value="all" checked> All Employee
                </div>
                <div>
                    <input class="checkbox search-type"  type="radio" name="search_type" id="department-wise" value="department" > Department Wise
                </div>
                <div>
                    <input class="checkbox search-type"  type="radio" name="search_type" id="section-wise" value="employee-type"> Employee Type Wise
                </div>
                <div>
                    <input class="checkbox search-type"  type="radio" name="search_type" id="designation-wise" value="designation"> Designation Wise
                </div>
                {{-- <div>
                    <input class="checkbox search-type"  type="radio" name="search_type" id="shift-wise" value="shift"> Shift Wise
                </div> --}}

            </div>
        </div>
        <div class="col-md-4 col-sm-12">
            <div class="input-group input-group-sm input-group-primary">
                <label style="" class="input-group-addon" for="employee_type_id">Employee Type</label>
                {{Form::select('employee_type_id', $employee_types, old('employee_type_id'),['class' => 'form-control','id' => 'employee_type_id', 'placeholder'=>"All", 'autocomplete'=>"off", ""])}}
                @error('employee_type_id')
                    <p class="text-danger">{{ $errors->first('employee_type_id') }}</p>
                @enderror
            </div>
        </div>

        <div class="col-md-4 col-sm-12">
            <div class="input-group input-group-sm input-group-primary">
                <label style="" class="input-group-addon" for="designation_id">Designation</label>
                {{Form::select('designation_id', $designations, old('designation_id'),['class' => 'form-control','id' => 'designation_id', 'placeholder'=>"All", 'autocomplete'=>"off", ""])}}
                @error('designation_id')
                    <p class="text-danger">{{ $errors->first('designation_id') }}</p>
                @enderror
            </div>
        </div>

        <div class="col-md-4 col-sm-12">
            <div class="input-group input-group-sm input-group-primary">
                <label style="" class="input-group-addon" for="department_id">Department</label>
                {{Form::select('department_id', $departments, old('department_id'),['class' => 'form-control','id' => 'department_id', 'placeholder'=>"All", 'autocomplete'=>"off", ""])}}
                @error('department_id')
                    <p class="text-danger">{{ $errors->first('department_id') }}</p>
                @enderror
            </div>
        </div>

        {{-- <div class="col-md-4 col-sm-12">
            <div class="input-group input-group-sm input-group-primary">
                <label style="" class="input-group-addon" for="shift_id">Shift</label>
                {{Form::select('shift_id', $shifts, old('shift_id'),['class' => 'form-control','id' => 'shift_id', 'placeholder'=>"All", 'autocomplete'=>"off", ""])}}
                @error('shift_id')
                    <p class="text-danger">{{ $errors->first('shift_id') }}</p>
                @enderror
            </div>
        </div> --}}

        <div class="col-md-4 col-sm-12">
            <div class="input-group input-group-sm input-group-primary">
                <label style="" class="input-group-addon" for="employee_id">Employee</label>
                {{Form::select('employee_id', $employees, old('employee_id'),['class' => 'form-control','id' => 'employee_id', 'placeholder'=>"All", 'autocomplete'=>"off", ""])}}
                @error('employee_id')
                    <p class="text-danger">{{ $errors->first('employee_id') }}</p>
                @enderror
            </div>
        </div>

        {{-- <div class="col-md-4 col-sm-12">
            <div class="input-group input-group-sm input-group-primary">
                <label style="" class="input-group-addon" for="status">Status</label>
                <select name="status" class="form-control"
                                id="status" autocomplete="off">
                                <option value="">All</option>
                                <option value="P">Present</option>
                                <option value="A">Absent</option>
                                <option value="L">Late</option>

                                @foreach ($leave_types as $leave_type_key => $leave_type)
                                    <option value="{{ $leave_type_key }}">{{ $leave_type }}</option>
                                @endforeach
                </select>
                @error('status')
                    <p class="text-danger">{{ $errors->first('status') }}</p>
                @enderror
            </div>
        </div> --}}









        {{-- <div class="col-md-4 col-sm-12">
            <div class="input-group input-group-sm input-group-primary">
                <label style="" class="input-group-addon" for="department_id">Status</label>
                <select name="status" class="form-control"
                                id="status" autocomplete="off">
                                <option value="">All</option>
                                <option value="active">Active</option>

                                @foreach ($released_types as $released_type)
                                    <option value="{{ $released_type->id }}">{{ $released_type->name }}</option>
                                @endforeach
                </select>
                @error('department_id')
                    <p class="text-danger">{{ $errors->first('department_id') }}</p>
                @enderror
            </div>
        </div> --}}







        {{-- <div class="col-md-4 col-sm-12">
            <div class="input-group input-group-sm input-group-primary">
                <label style="" class="input-group-addon" for="date"> Date <span
                        class="text-danger">*</span></label>
                {{ Form::date(
                    'from_date',
                    old('from_date'),
                    [
                        'class' => 'form-control',
                        'id' => 'from_date',
                        'placeholder' => 'Enter from_date Here',
                        'required',
                    ],
                ) }}

            </div>
                @error('from_date')
                    <p class="text-danger">{{ $errors->first('from_date') }}</p>
                @enderror
        </div> --}}
        {{-- <div class="col-md-4 col-sm-12">
            <div class="input-group input-group-sm input-group-primary">
                <label style="" class="input-group-addon" for="date"> To Date <span
                        class="text-danger">*</span></label>
                {{ Form::date(
                    'to_date',
                    old('to_date'),
                    [
                        'class' => 'form-control',
                        'id' => 'to_date',
                        'placeholder' => 'Enter to_date Here',
                        'required',
                    ],
                ) }}

            </div>
            @error('to_date')
                    <p class="text-danger">{{ $errors->first('to_date') }}</p>
                @enderror
        </div> --}}











    </div>

    {{-- <hr class="bg-success"> --}}



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
        $('#category_id').change(()=>{
            $.ajax({
                url: "{{ route('getCategoryWiseProducts') }}",
                type: 'GET',
                dataType: 'json',
                data: {
                    _token: '{{ csrf_token() }}',
                    category_id: $('#category_id').val()
                },
                success: function(response) {
                    $('.product_id').empty();
                    $('.product_id').append('<option value="">' + "All" + '</option>');
                    $.each(response, function(index, value) {

                        $('.product_id').append('<option value="' + value.id + '">' + value
                            .text + '</option>');
                    });
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus + ': ' + errorThrown);
                }
            });
        });

        $('#employee_type_id').change(()=>{
            $.ajax({
                url: "{{ route('getTypeWiseEmployees') }}",
                type: 'GET',
                dataType: 'json',
                data: {
                    _token: '{{ csrf_token() }}',
                    employee_type_id: $('#employee_type_id').val()
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

        $('#designation_id').change(()=>{
            $.ajax({
                url: "{{ route('getDesignationWiseEmployees') }}",
                type: 'GET',
                dataType: 'json',
                data: {
                    _token: '{{ csrf_token() }}',
                    designation_id: $('#designation_id').val()
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

        $('#department_id').change(()=>{
            $.ajax({
                url: "{{ route('getDepartmentWiseEmployees') }}",
                type: 'GET',
                dataType: 'json',
                data: {
                    _token: '{{ csrf_token() }}',
                    department_id: $('#department_id').val()
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

        // $('#shift_id').change(()=>{
        //     $.ajax({
        //         url: "{{ route('getShiftWiseEmployees') }}",
        //         type: 'GET',
        //         dataType: 'json',
        //         data: {
        //             _token: '{{ csrf_token() }}',
        //             shift_id: $('#shift_id').val()
        //         },
        //         success: function(response) {
        //             $('#employee_id').empty();
        //             $('#employee_id').append('<option value="">' + "All" + '</option>');
        //             $.each(response, function(index, value) {

        //                 $('#employee_id').append('<option value="' + value.id + '">' + value
        //                     .text + '</option>');
        //             });
        //         },
        //         error: function(jqXHR, textStatus, errorThrown) {
        //             console.log(textStatus + ': ' + errorThrown);
        //         }
        //     });
        // });








        $("#all-employee").prop("checked", true);

        $("#employee_type_id option:selected").prop("selected", false);
        $('#employee_type_id').prop('disabled', true);

        $("#designation_id option:selected").prop("selected", false);
        $('#designation_id').prop('disabled', true);

        $("#department_id option:selected").prop("selected", false);
        $('#department_id').prop('disabled', true);

        // $("#shift_id option:selected").prop("selected", false);
        // $('#shift_id').prop('disabled', true);


        $(document).on('change', '.search-type', function() {
            let searchType = $(this).val();
            if(searchType == 'all'){

                $("#employee_type_id option:selected").prop("selected", false);
                $('#employee_type_id').prop('disabled', true);

                $("#designation_id option:selected").prop("selected", false);
                $('#designation_id').prop('disabled', true);

                $("#department_id option:selected").prop("selected", false);
                $('#department_id').prop('disabled', true);

                // $("#shift_id option:selected").prop("selected", false);
                // $('#shift_id').prop('disabled', true);



                let employees = {!! json_encode($employees) !!};
                $('#employee_id').empty();
                $('#employee_id').append('<option value="">' + "All" + '</option>');
                $.each(employees, function(index, value) {
                    $('#employee_id').append('<option value="' + index + '">' + value + '</option>');
                });
            }
            else if(searchType == 'department'){
                $("#employee_type_id option:selected").prop("selected", false);
                $('#employee_type_id').prop('disabled', true);

                $("#designation_id option:selected").prop("selected", false);
                $('#designation_id').prop('disabled', true);

                $('#department_id').prop('disabled', false);

                // $("#shift_id option:selected").prop("selected", false);
                // $('#shift_id').prop('disabled', true);

                $('#employee_id').empty();
                $('#employee_id').append('<option value="">' + "All" + '</option>');
            }
            else if(searchType == 'designation'){
                $("#employee_type_id option:selected").prop("selected", false);
                $('#employee_type_id').prop('disabled', true);

                $('#designation_id').prop('disabled', false);

                $("#department_id option:selected").prop("selected", false);
                $('#department_id').prop('disabled', true);

                // $("#shift_id option:selected").prop("selected", false);
                // $('#shift_id').prop('disabled', true);



                $('#employee_id').empty();
                $('#employee_id').append('<option value="">' + "All" + '</option>');
            }
            else if(searchType == 'employee-type'){
                $('#employee_type_id').prop('disabled', false);

                $("#designation_id option:selected").prop("selected", false);
                $('#designation_id').prop('disabled', true);

                $("#department_id option:selected").prop("selected", false);
                $('#department_id').prop('disabled', true);

                // $("#shift_id option:selected").prop("selected", false);
                // $('#shift_id').prop('disabled', true);



                $('#employee_id').empty();
                $('#employee_id').append('<option value="">' + "All" + '</option>');
            }





        });




        //Report Type

        $("#month-wise-report").prop("checked", true);
        $('#year-container').hide();

        $(document).on('change', '.report-type', function(){
            let reportType = $(this).val();

            let month = {!! json_encode(date('Y-m')) !!};
            let year = {!! json_encode(date('Y')) !!};

            if(reportType == 'monthly'){
                $('#year-container').hide();

                $("#year").prop("disabled", true);
                $("#month").prop("disabled", false);

                $("#month").val(month);
                $('#month-container').show();
            }
            else{
                $('#month-container').hide();

                $("#month").prop("disabled", true);
                $("#year").prop("disabled", false);

                $("#year").val(year);
                $('#year-container').show();
            }
        });


    });


</script>

@endsection
