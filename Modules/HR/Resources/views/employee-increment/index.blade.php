@extends('layouts.backend-layout')
@section('title', 'Employee Increment')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    List of Employee Increment
@endsection

@section('style')
    <style>
    </style>
@endsection
@section('breadcrumb-button')
    @can('employee-increment-create')
        <a href="{{ route('employee-increments.create') }}" class="btn btn-out-dashed btn-sm btn-warning"><i
                class="fas fa-plus"></i></a>
    @endcan
@endsection
@section('sub-title')
    Total: {{ count($employee_increments) }}
@endsection


@section('content')
    <div class="dt-responsive table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#SL</th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Date</th>
                    <!-- <th>Increment Amount</th> -->
                    <th>Remarks</th>
                    @canany(['employee-increment-edit', 'employee-increment-delete'])
                        <th>Action</th>
                    @endcanany
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>#SL</th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Date</th>
                    <!-- <th>Increment Amount</th> -->
                    <th>Remarks</th>
                    @canany(['employee-increment-edit', 'employee-increment-delete'])
                        <th>Action</th>
                    @endcanany
                </tr>
            </tfoot>
            <tbody>
                @foreach ($employee_increments as $key => $data)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td class="text-left">{{ $data->employee?->emp_name }}</td>
                        <td class="text-left">{{ $data->incement_type }}</td>
                        <td class="text-left">{{ $data->date }}</td>
                        <!-- <td class="text-left">{{ $data->increment_amount }}</td> -->
                        <td class="text-left">{{ $data->remarks }}</td>
                        @canany(['employee-increment-edit', 'employee-increment-delete'])
                            <td>
                                <div class="icon-btn">
                                    <nobr>
                                        @can('employee-increment-edit')
                                            <a data-toggle="modal" data-target="#exampleModal" data-entry="{{ $data->id }}"
                                                title="View" class="btn btn-outline-warning view-emplyee-increment"><i
                                                    class="fas fa-eye"></i></a>
                                        @endcan
                                        @can('employee-increment-delete')
                                            <form action="{{ url("hr/employee-increments/$data->id") }}" method="POST"
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

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="border-bottom: 2px solid #1D84EB;">
                    <h6 class="modal-title" id="exampleModalLabel">Employee Details</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-loader" id="loader" style="display: none; position:absloute;">
                    <div class="loader animation-start">
                        <span class="circle delay-1 size-2"></span>
                        <span class="circle delay-2 size-4"></span>
                        <span class="circle delay-3 size-6"></span>
                        <span class="circle delay-4 size-7"></span>
                        <span class="circle delay-5 size-7"></span>
                        <span class="circle delay-6 size-6"></span>
                        <span class="circle delay-7 size-4"></span>
                        <span class="circle delay-8 size-2"></span>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="row px-3">
                        <div class="col-md-5">
                            <p>Name:</p>
                        </div>
                        <div class="col-md-7">
                            <p id="emp_name"></p>
                        </div>
                    </div>
                    <div class="row px-3">
                        <div class="col-md-5">
                            <p>Code:</p>
                        </div>
                        <div class="col-md-7">
                            <p id="emp_code"></p>
                        </div>
                    </div>
                    <div class="row px-3">
                        <div class="col-md-5">
                            <p>Designation:</p>
                        </div>
                        <div class="col-md-7">
                            <p id="emp_design"></p>
                        </div>
                    </div>
                    <div class="row px-3">
                        <div class="col-md-5">
                            <p>Section:</p>
                        </div>
                        <div class="col-md-7">
                            <p id="emp_section"></p>
                        </div>
                    </div>
                    <div class="row px-3">
                        <div class="col-md-5">
                            <p>Type of employee:</p>
                        </div>
                        <div class="col-md-7">
                            <p id="emp_type"></p>
                        </div>
                    </div>
                    <div class="row px-3">
                        <div class="col-md-5">
                            <p>Type of increment:</p>
                        </div>
                        <div class="col-md-7">
                            <p id="increment_type"></p>
                        </div>
                    </div>
                    <div class="row px-3">
                        <div class="col-md-5">
                            <p>Date:</p>
                        </div>
                        <div class="col-md-7">
                            <p id="inc_date"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('js/Datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/Datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script>
       

        $(document).ready(function() {
            $('.view-emplyee-increment').click(function() {
                var employee_id = this.getAttribute('data-entry');
                $('#loader').show();
                getEntryData(employee_id);
            });

            function getEntryData(employee_id) {
                $.ajax({
                    url: "{{ route('getSingleEmployeeIncrementSalary') }}",
                    type: 'POST',
                    data: {
                        employee_id: employee_id,
                        _token: "{{ csrf_token() }}",
                    },
                    success: function(data) {
                        // console.log(data);
                        if (data.length == 0) {
                            console.log("Data not found.");
                        } else {
                            // set values
                            $('#emp_name').text(data.employee.emp_name);
                            $('#emp_code').text(data.employee?.emp_code);
                            $('#increment_type').text(data.incement_type);
                            $('#inc_date').text(data.date.slice(0, 10).split('-').reverse().join('/'));
                            if (data.new_designation != null) {
                                $('#emp_design').text(data.new_designation?.name);
                            } else {
                                $('#emp_design').text(data.old_designation?.name);
                            }
                            if (data.new_section != null) {
                                $('#emp_section').text(data.new_section?.name);
                            } else {
                                $('#emp_section').text(data.old_section?.name);
                            }
                            if (data.new_emp_type != null) {
                                $('#emp_type').text(data.new_emp_type?.name);
                            } else {
                                $('#emp_type').text(data.old_emp_type?.name);
                            }
                            $('#loader').hide();
                        }
                    }
                });
            }


        });
    </script>
@endsection
