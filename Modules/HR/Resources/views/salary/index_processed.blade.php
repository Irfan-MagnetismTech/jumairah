@extends('layouts.backend-layout')
@section('title', 'Processed Salary')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    List of Processed Salary
@endsection

@section('style')

@endsection
@section('breadcrumb-button')
@endsection
{{-- @section('sub-title')
    Total: {{ count($processed_salaries) }}
@endsection --}}


@section('content')
    <style>
        th,
        td {
            font-size: 14px;
            padding: 16px 6px;
        }

        .nav-tabs .nav-item.show .nav-link,
        .nav-tabs .nav-link.active {
            color: #007af5;
            background-color: #ececec;
            border-color: #ddd #ddd #fff;
        }
    </style>
    <nav>
        <div class="nav nav-tabs mb-3" id="nav-tab" role="tablist">
            <a class="nav-item nav-link active p-2 h6" id="nav-home-tab" data-toggle="tab" href="#processed_salary"
                role="tab" aria-controls="nav-home" aria-selected="true">Processed Salary List</a>
            <a class="nav-item nav-link p-2 h6" id="nav-profile-tab" data-toggle="tab" href="#process_salary" role="tab"
                aria-controls="nav-profile" aria-selected="false">Process Salary</a>
        </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="processed_salary" role="tabpanel" aria-labelledby="nav-home-tab">
            {!! Form::open([
                'url' => 'hr/process-salary',
                'method' => 'GET',
                'class' => 'custom-form',
                'id' => 'filter_processed_salary_form',
            ]) !!}
            <div class="row px-4 pt-2 pb-4">
                <div class="col-md-3">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="year">Month <span class="text-danger">*</span></label>
                        {{ Form::month('filter_month', $_GET['filter_month'] ?? now()->format('Y-m'), [
                            'class' => 'form-control',
                            'id' => 'filter_month',
                            'placeholder' => '',
                            'required',
                        ]) }}

                        @error('filter_month')
                            <p class="text-danger">{{ $errors->first('filter_month') }}</p>
                        @enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="filter_department_id">Department<span
                                class="text-danger">*</span></label>
                        {{ Form::select('filter_department_id', $departments, $_GET['filter_department_id'] ?? null, [
                            'class' => 'form-control employee_active',
                            'id' => 'filter_department_id',
                            'placeholder' => 'Select Department',
                            'required',
                        ]) }}
                        @error('filter_department_id')
                            <p class="text-danger">{{ $errors->first('filter_department_id') }}</p>
                        @enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="filter_cost_center_id">Cost Center<span
                                class="text-danger">*</span></label>
                        {{ Form::select('filter_cost_center_id', $costCenters, $_GET['filter_cost_center_id'] ?? null, [
                            'class' => 'form-control  employee_active',
                            'id' => 'filter_cost_center_id',
                            'placeholder' => 'Select Cost Center',
                            'required',
                        ]) }}
                        @error('filter_cost_center_id')
                            <p class="text-danger">{{ $errors->first('filter_cost_center_id') }}</p>
                        @enderror
                    </div>
                </div>

                <div class="col-md-3">

                    <div class="input-group input-group-sm">
                        <button class="btn btn-primary btn-round btn-block py-2 px-2"
                            id="get_filtered_processed_salary_btn">
                            Get Processed Salary
                        </button>
                    </div>

                </div>

                <!-- Background shadow -->

            </div>
            {!! Form::close() !!}
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>#SL</th>
                            <th>Employee Code</th>
                            <th>Employee Name</th>
                            <th>Department</th>
                            <th>Month</th>
                            <th>Total working days</th>
                            <th>Total OT hour</th>
                            <th>Adjustment Amount</th>
                            <th>Total Amount</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#SL</th>
                            <th>Employee Code</th>
                            <th>Employee Name</th>
                            <th>Department</th>
                            <th>Month</th>
                            <th>Total working days</th>
                            <th>Total OT hour</th>
                            <th>Adjustment Amount</th>
                            <th>Total Amount</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($processed_salaries as $key => $data)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td class="text-left">{{ $data->employee?->emp_code }}</td>
                                <td class="text-left">{{ $data->employee?->emp_name }}</td>
                                <td class="text-left">{{ $data->employee->department->name }}</td>
                                <td class="text-center">{{ $data->month }}</td>
                                <td class="text-center">{{ $data->total_working_day }}</td>
                                <td class="text-center">{{ $data->total_ot_hour }}</td>
                                <td class="text-center">{{ $data->adjustment_amount }}</td>
                                <td class="text-center">
                                    {{ $data->total_working_day ? $data->total_working_amount + $data->total_ot_amount + $data->house_rent + $data->medical_allowance + $data->tansport_allowance + $data->food_allowance + $data->other_allowance + $data->mobile_allowance + $data->grade_bonus + $data->skill_bonus + $data->management_bonus + $data->adjustment_amount - $data->income_tax : '0' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $processed_salaries->links() }}
        </div>

        {{-- Process Salary Tab --}}
        @can('process-salary')
            <div class="tab-pane fade" id="process_salary" role="tabpanel" aria-labelledby="nav-profile-tab">
                {!! Form::open([
                    'url' => 'hr/salary/processed',
                    'method' => 'POST',
                    'class' => 'custom-form',
                    'id' => 'salary_processed_form',
                    'files' => true,
                    'enctype' => 'multipart/form-data',
                ]) !!}
                <div class="row px-4 pt-2 pb-4">
                    <div class="col-md-3">
                        <div class="input-group input-group-sm input-group-primary">
                            <label class="input-group-addon" for="year">Month <span class="text-danger">*</span></label>
                            {{ Form::month('month', old('month') ? old('month') : '', [
                                'class' => 'form-control',
                                'id' => 'month',
                                'placeholder' => '',
                                'required',
                            ]) }}

                            @error('month')
                                <p class="text-danger">{{ $errors->first('month') }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group input-group-sm input-group-primary">
                            <label class="input-group-addon" for="department_id">Department<span
                                    class="text-danger">*</span></label>
                            {{ Form::select('department_id', $departments, old('department_id') ? old('department_id') : null, [
                                'class' => 'form-control select2 employee_active',
                                'id' => 'department_id',
                                'placeholder' => 'Select Bank',
                                'required',
                            ]) }}
                            @error('department_id')
                                <p class="text-danger">{{ $errors->first('department_id') }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3 mr-1">
                        <div class="input-group input-group-sm input-group-primary">
                            <label class="input-group-addon" for="department_id">Cost Center<span
                                    class="text-danger">*</span></label>
                            {{ Form::select('cost_center_id', $costCenters, old('cost_center_id') ? old('cost_center_id') : null, [
                                'class' => 'form-control select2 employee_active',
                                'id' => 'cost_center_id',
                                'placeholder' => 'Select Bank',
                                'required',
                            ]) }}
                            @error('cost_center_id')
                                <p class="text-danger">{{ $errors->first('cost_center_id') }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-2">

                        <div class="input-group input-group-sm">
                            {{-- <a class="btn btn-out-dashed btn-md btn-danger rounded text-white">Processed Data</a> --}}
                            <button class="btn btn-warning btn-round btn-block py-2" id="processed_btn">
                                Process Salary
                            </button>
                        </div>

                    </div>

                    <!-- Background shadow -->

                </div>
                {!! Form::close() !!}
            </div>
        @endcan
    </div>



@endsection

@section('script')
    <script>
        $(window).scroll(function() {
            //set scroll position in session storage
            sessionStorage.scrollPos = $(window).scrollTop();
        });
        var init = function() {
            //get scroll position in session storage
            $(window).scrollTop(sessionStorage.scrollPos || 0)
        };
        window.onload = init;
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var monthField = document.getElementById("month");
            var currentMonth = new Date().toISOString().slice(0, 7);
            var currentDate = new Date(currentMonth + '-01');
            var previous = new Date(currentDate);
            previous.setMonth(previous.getMonth() - 1);
            var previousMonth = previous.toISOString().slice(0, 7);
            monthField.min = previousMonth;
            monthField.max = currentMonth;
            monthField.value = null;
        });
    </script>
@endsection
