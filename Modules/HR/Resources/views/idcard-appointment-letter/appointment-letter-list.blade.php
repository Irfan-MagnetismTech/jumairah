@extends('layouts.backend-layout')
@section('title', 'Appointment Letters')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    Appointment Letters
@endsection
@section('breadcrumb-button')
    <a href="{{ route('appointmentLetterGenerationForm') }}" class="btn btn-out-dashed btn-sm btn-warning"><i
            class="fas fa-plus"></i></a>
@endsection
@section('style')

@endsection
@section('breadcrumb-button')
    @can('employee-appointment-letter-create')
        <a href="{{ route('fix-attendances.create') }}" class="btn btn-out-dashed btn-sm btn-warning"><i
                class="fas fa-plus"></i></a>
    @endcan
@endsection
@section('sub-title')
    Total: {{ count($appointmentLetters) }}
@endsection

@section('content')
    <style>
        table th,
        table td {
            border: 1px solid #D3E7FB !important;
        }
    </style>
    <div class="dt-responsive table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#SL</th>
                    <th>Letter No.</th>
                    <th>Employee Name</th>
                    <th>Department</th>
                    <th>Designation</th>
                    <th>Issued Date</th>
                    <th>Letter Issued By</th>
                    @can('employee-appointment-letter-show')
                        <th>Action</th>
                    @endcan
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>#SL</th>
                    <th>Letter No.</th>
                    <th>Employee Name</th>
                    <th>Department</th>
                    <th>Designation</th>
                    <th>Issued Date</th>
                    <th>Letter Issued By</th>
                    @can('employee-appointment-letter-show')
                        <th>Action</th>
                    @endcan
                </tr>
            </tfoot>
            <tbody>
                @foreach ($appointmentLetters as $key => $data)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td class="text-left">{{ $data->letter_no }}</td>
                        <td class="text-left">{{ $data->employee_name }}</td>
                        <td class="text-left">{{ $data->employee_department }}</td>
                        <td class="text-center">{{ $data->employee_designation }}</td>
                        <td class="text-center">{{ $data->letter_issue_date }}</td>
                        <td class="text-center">{{ $data->letter_issuer_name }}</td>
                        @can('employee-appointment-letter-show')
                        <td>
                            <div class="icon-btn">
                                <nobr>
                                    <a href="{{ url('hr/appointment-letter-view/' . $data->id) }}" target="_blank"
                                        rel="noopener noreferrer">
                                        <button type="submit" class="btn btn-outline-danger btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </a>
                                </nobr>
                            </div>
                        </td>
                        @endcan
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
    </script>
@endsection
