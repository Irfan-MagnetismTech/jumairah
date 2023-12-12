@extends('layouts.backend-layout')
@section('title', 'Employee Salary')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    List of Employee Salary
@endsection

@section('style')
    <style>
    </style>
@endsection
@section('breadcrumb-button')
    @can('employee-salary-create')
        <a href="{{ route('employee-salaries.create') }}" class="btn btn-out-dashed btn-sm btn-warning"><i
                class="fas fa-plus"></i></a>
    @endcan
@endsection
@section('sub-title')
    Total: {{ count($employee_salaries) }}
@endsection


@section('content')
    <div class="dt-responsive table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#SL</th>
                    <th>Name</th>
                    <th>Gross Salary</th>
                    <th>Basic Salary</th>
                    <th>House Rent</th>
                    <th>Medical Allow</th>
                    <th>Transport Allow</th>
                    <th>Food Allow</th>
                    <th>Other Allow</th>
                    <th>Mobile Allow</th>
                    <th>Grade Bonus</th>
                    <th>Skill Bonus</th>
                    <th>Management Bonus</th>
                    <th>Total Salary</th>
                    <th>Income Tax</th>
                    <th>Casual Salary</th>
                    <th>OT Calculation Based On</th>
                    <th>Ot Salary(/hour)</th>
                    @canany(['employee-salary-edit', 'employee-salary-delete'])
                        <th>Action</th>
                    @endcanany
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>#SL</th>
                    <th>Name</th>
                    <th>Gross Salary</th>
                    <th>Basic Salary</th>
                    <th>House Rent</th>
                    <th>Medical Allow</th>
                    <th>Transport Allow</th>
                    <th>Food Allow</th>
                    <th>Other Allow</th>
                    <th>Mobile Allow</th>
                    <th>Grade Bonus</th>
                    <th>Skill Bonus</th>
                    <th>Management Bonus</th>
                    <th>Total Salary</th>
                    <th>Income Tax</th>
                    <th>Casual Salary</th>
                    <th>OT Calculation Based On</th>
                    <th>Ot Salary(/hour)</th>
                    @canany(['employee-salary-edit', 'employee-salary-delete'])
                        <th>Action</th>
                    @endcanany
                </tr>
            </tfoot>
            <tbody>
                @foreach ($employee_salaries as $key => $data)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td class="text-left">{{ $data->employee?->emp_name }}</td>
                        <td class="text-left">{{ $data->gross_salary }}</td>
                        <td class="text-left">{{ $data->basic_salary }}</td>
                        <td class="text-left">{{ $data->house_rent }}</td>
                        <td class="text-left">{{ $data->medical_allowance }}</td>
                        <td class="text-left">{{ $data->tansport_allowance }}</td>
                        <td class="text-left">{{ $data->food_allowance }}</td>
                        <td class="text-left">{{ $data->other_allowance }}</td>
                        <td class="text-left">{{ $data->mobile_allowance }}</td>
                        <td class="text-left">{{ $data->grade_bonus }}</td>
                        <td class="text-left">{{ $data->skill_bonus }}</td>
                        <td class="text-left">{{ $data->management_bonus }}</td>
                        <td class="text-left">{{ $data->total_salary }}</td>
                        <td class="text-left">{{ $data->income_tax }}</td>
                        <td class="text-left">{{ $data->casual_salary }}</td>
                        <td class="text-left">
                            {{ $data->ot_calculation_basis ? ($data->ot_calculation_basis == 'basic' ? 'Basic Salary' : 'Gross Salary') : '' }}
                        </td>
                        <td class="text-right">{{ $data->ot_salary }}{{ $data->ot_salary ? '%' : '' }}</td>
                        @canany(['employee-salary-edit', 'employee-salary-delete'])
                            <td>
                                <div class="icon-btn">
                                    <nobr>
                                        @can('employee-salary-edit')
                                            <a href="{{ route('employee-salaries.edit', $data->id) }}" data-toggle="tooltip"
                                                title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                        @endcan
                                        @can('employee-salary-delete')
                                            <form action="{{ url("hr/employee-salaries/$data->id") }}" method="POST"
                                                data-toggle="tooltip" title="Delete" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm delete"><i
                                                        class="fas fa-trash"></i></button>
                                            </form>
                                        @endcan
                                    </nobr>
                                </div>
                            </td>
                        @endcanany
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('script')
    <script src="{{ asset('js/Datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/Datatables/dataTables.bootstrap4.min.js') }}"></script>
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

        $(document).ready(function() {
            $('#dataTable').DataTable({
                stateSave: true
            });
        });
    </script>
@endsection
