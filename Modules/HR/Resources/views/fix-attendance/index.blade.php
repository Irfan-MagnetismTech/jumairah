@extends('layouts.backend-layout')
@section('title', 'Fix Attendance')

@section('style')
<link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
List of Fix Attendance
@endsection

@section('style')

@endsection
@section('breadcrumb-button')
{{-- <a href="{{ route('fix-attendances.processed') }}" class="btn btn-out-dashed btn-sm btn-danger text-white">Processed Data</a> --}}
<a href="{{ route('fix-attendances.create') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-plus"></i></a>
@endsection
@section('sub-title')
Total: {{ count($fix_attendances) }}
@endsection


@section('content')
<style>
    table th, table td{
        border: 1px solid #D3E7FB !important;
    }
</style>
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
                <th>Remarks</th>
                <th>Action</th>
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
                <th>Remarks</th>
                <th>Action</th>
            </tr>
        </tfoot>
        <tbody>
            @foreach ($fix_attendances as $key => $data)
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
                    <td class="text-left">{{ $data->remarks }}</td>
                    <td class="text-left">{{ ($data->action==0)?'Not Processed':'Processed' }}</td>

                {{--    <td>
                        <div class="icon-btn">
                            <nobr>
                                <a href="{{ route('leave-balances.edit', $data->id) }}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                <form action="{{ url("hr/leave-balances/$data->id") }}" method="POST" data-toggle="tooltip" title="Delete" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm delete"><i class="fas fa-trash"></i></button>
                                </form>
                            </nobr>
                        </div>
                    </td>
                --}}
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



</script>
@endsection
