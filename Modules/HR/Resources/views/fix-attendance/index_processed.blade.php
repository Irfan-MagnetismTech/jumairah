@extends('layouts.backend-layout')
@section('title', 'Processed Attendance')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    List of Processed Attendance
@endsection

@section('style')

@endsection
@section('breadcrumb-button')
@endsection
@section('sub-title')
    Total: {{ count($processed_attendances) }}
@endsection


@section('content')
    <style>
        table th,
        table td {
            border: 1px solid #D3E7FB !important;
        }

        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 9999;
        }

        .modal-loader {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 10000;
        }

        .custom-form .input-group-addon {
            min-width: 110px !important;
        }
    </style>
    {!! Form::open([
        'url' => 'hr/attendance/processed',
        'method' => 'POST',
        'class' => 'custom-form',
        'id' => 'processed_form',
        'files' => true,
        'enctype' => 'multipart/form-data',
    ]) !!}

    <div class="row px-4 py-2">
        <div class="col-md-6 py-2">
            <div class="input-group input-group-sm input-group-primary type_of_select"
                style="display:flex;  flex-wrap: wrap;
            justify-content: space-around;font-size: 14px;">
                <div>
                    <input class="checkbox search_type date_wise" type="checkbox" name="date_wise" id="date_wise"
                        value="date" checked> Date Wise
                </div>
                <div>
                    <input class="checkbox search_type month_wise" type="checkbox" name="month_wise" id="month_wise"
                        value="month"> Month Wise
                </div>
            </div>
        </div>
    </div>
    <div class="row px-4 pt-2 pb-4">
        <div class="col-md-3" id="date_field">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="year">Date <span class="text-danger">*</span></label>
                {{ Form::date('date', old('date') ? old('date') : null, [
                    'class' => 'form-control',
                    'id' => 'date',
                    'placeholder' => 'Enter Date Here',
                    'required',
                ]) }}

                @error('date')
                    <p class="text-danger">{{ $errors->first('date') }}</p>
                @enderror
            </div>
        </div>
        <div class="col-md-3 d-none" id="month_field">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="year">Month <span class="text-danger">*</span></label>
                {{ Form::month('month', old('month') ? old('month') : '', [
                    'class' => 'form-control',
                    'id' => 'month',
                    'placeholder' => '',
                ]) }}

                @error('to_date')
                    <p class="text-danger">{{ $errors->first('to_date') }}</p>
                @enderror
            </div>
        </div>
        <div class="col-md-3">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="department_id">Department<span class="text-danger">*</span></label>
                {{ Form::select('department_id', $departments, old('department_id') ? old('department_id') : null, [
                    'class' => 'form-control select2 employee_active',
                    'id' => 'department_id',
                    'placeholder' => 'Select Department',
                    'required',
                ]) }}
                @error('department_id')
                    <p class="text-danger">{{ $errors->first('department_id') }}</p>
                @enderror
            </div>
        </div>
        {{-- <div class="col-md-3">
            <div class="input-group input-group-sm input-group-primary">
                <label class="input-group-addon" for="overtime">Overtime</label>
                {{Form::select('overtime',
                [
                '01' => '01',
                '02' => '02',
                '03' => '03',
                '04' => '04',
                '05' => '05',
                '06' => '06',
                '07' => '07',
                '08' => '08',
                ],
                old('overtime') ? old('overtime') : null,['class' => 'form-control select2 employee_active','id' => 'overtime', 'placeholder' =>
                'Select Hours',] )}}
                @error('overtime') <p class="text-danger">{{ $errors->first('overtime') }}</p> @enderror
            </div>
        </div> --}}
        <div class="col-md-3">
            <div class="offset-md-4 col-md-8">
                <div class="input-group input-group-sm">
                    {{-- <a class="btn btn-out-dashed btn-md btn-danger rounded text-white">Processed Data</a> --}}
                    <button class="btn btn-warning btn-round btn-block py-2" id="processed_btn">
                        Process
                    </button>
                </div>
            </div>
        </div>

        <!-- Background shadow -->
        <div class="modal-overlay"></div>
        <!-- Processed Loader -->
        <div class="modal-loader">
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
    </div>
    {!! Form::close() !!}

    <div class="dt-responsive table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#SL</th>
                    <th>Employee Code</th>
                    <th>Employee Name</th>
                    <th>Punch Date</th>
                    <th>Late Hour</th>
                    <th>Time In</th>
                    <th>Time Out</th>
                    <th>OT Hour</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>#SL</th>
                    <th>Employee Code</th>
                    <th>Employee Name</th>
                    <th>Punch Date</th>
                    <th>Late Hour</th>
                    <th>Time In</th>
                    <th>Time Out</th>
                    <th>OT Hour</th>
                    <th>Status</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach ($processed_attendances as $key => $data)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td class="text-left">{{ $data->employee?->emp_code }}</td>
                        <td class="text-left">{{ $data->employee?->emp_name }}</td>
                        <td class="text-center">{{ $data->punch_date }}</td>
                        <td class="text-center">{{ $data->late }}</td>
                        <td class="text-center">{{ $data->time_in }}</td>
                        <td class="text-center">{{ $data->time_out }}</td>
                        <td class="text-center">{{ $data->ot_hour }}</td>
                        <td class="text-center">{{ strtoupper($data->status) }}</td>
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
        // $(document).ready(function() {
        //     $('#dataTable').DataTable({
        //         // stateSave: true
        //         dom: 'lBfrtip',
        //         lengthMenu: [5, 10, 20, 50, 100, 200, 500],
        //         buttons: [
        //                 // 'csv'
        //         ],
        //         info: true,
        //         bAutoWidth: false,
        //     });
        // });

        $(document).ready(function() {
            $('#processed_btn').click(function() {
                var form = document.getElementById("processed_form");
                if (form.checkValidity()) {
                    $('.modal-overlay').fadeIn();
                    $('.modal-loader').fadeIn();
                }
            });
        });

        $(document).on('change', '.search_type', function() {
            let search_type = $(this).val();
            if (search_type == 'month') {
                $("#month_field").removeClass("d-none");
                $("#month").prop("required", true);
                $("#date").prop("required", false);
                $("#date").val("");
                $("#date_field").addClass("d-none");
            } else if (search_type == 'date') {
                $("#date_field").removeClass("d-none");
                $("#month").prop("required", false);
                $("#date").prop("required", true);
                $("#month").val("");
                $("#month_field").addClass("d-none");
            }
            // alert(search_type);
        });
    </script>
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
