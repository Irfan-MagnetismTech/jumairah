@extends('layouts.backend-layout')
@section('title', 'Employee Leave Entry')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    Employee Leave Entry
@endsection

@section('style')
    <style>
    </style>
@endsection
@section('breadcrumb-button')
    <a href="{{ route('leave-entries.create') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-plus"></i></a>
@endsection
@section('sub-title')
    Total: {{ count($leave_entries) }}
@endsection


@section('content')
    <div class="dt-responsive table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#SL</th>
                    <th>Employee Name</th>
                    <th>Employee Code</th>
                    <th>Apply Date</th>
                    <th>Leave Type</th>
                    <th>From Date</th>
                    <th>To Date</th>
                    <th>Days</th>
                    <th>Reasons</th>
                    <th>Approved</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>#SL</th>
                    <th>Employee Name</th>
                    <th>Employee Code</th>
                    <th>Apply Date</th>
                    <th>Leave Type</th>
                    <th>From Date</th>
                    <th>To Date</th>
                    <th>Days</th>
                    <th>Reasons</th>
                    <th>Approved</th>
                    <th>Action</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach ($leave_entries as $key => $data)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td class="text-left">{{ $data->employee?->emp_name }}</td>
                        <td class="text-left">{{ $data->employee?->emp_code }}</td>
                        <td class="text-left">{{ date('d/m/Y', strtotime($data->apply_date)) }}</td>
                        <td class="text-left">{{ $data->leave_type->name }}</td>
                        <td class="text-left">{{ date('d/m/Y', strtotime($data->from_date)) }}</td>
                        <td class="text-left">{{ date('d/m/Y', strtotime($data->to_date)) }}</td>
                        <td class="text-left">{{ $data->total_day }}</td>
                        <td class="text-left">{{ $data->reason }}</td>
                        <td class="text-left">
                            {{ $data->is_approved == 1 && $data->is_reject == 0 ? 'Approved' : ($data->is_approved == 0 && $data->is_reject == 1 ? 'Rejected' : ($data->is_approved == 1 && $data->is_reject == 1 ? 'Approve' : 'In Progress')) }}
                        </td>
                        <td>
                            <div class="icon-btn">
                                <nobr>
                                    @if ($data->is_approved == 0 && $data->is_reject == 0)
                                        <a href="{{ route('leave-entries.leave-approve', $data->id) }}"
                                            data-toggle="tooltip" title="Approve" class="btn btn-outline-success"><i
                                                class="fas fa-check"></i>
                                        </a>
                                        <!-- <a href="{{ route('leave-entries.leave-reject', $data->id) }}"
                                                    data-toggle="tooltip" title="Reject" class="btn btn-outline-danger"><i
                                                        class="fas fa-times"></i>
                                        </a> -->
                                        <a data-toggle="modal" data-target="#reject_modal" data-entry="{{ $data->id }}"
                                            title="Reject" class="btn btn-outline-warning reject-leave-entry"><i
                                                class="fas fa-times"></i></a>
                                        <a href="{{ route('leave-entries.edit', $data->id) }}" data-toggle="tooltip"
                                            title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                        <form action="{{ url("hr/leave-entries/$data->id") }}" method="POST"
                                            data-toggle="tooltip" title="Delete" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm delete"><i
                                                    class="fas fa-trash"></i></button>
                                        </form>
                                    @endif
                                    @if ($data->is_approved == 0 && $data->is_reject != 0)
                                        <a href="{{ route('leave-entries.leave-approve', $data->id) }}"
                                            data-toggle="tooltip" title="Approve" class="btn btn-outline-success"><i
                                                class="fas fa-check"></i>
                                        </a>
                                        <a href="{{ route('leave-entries.edit', $data->id) }}" data-toggle="tooltip"
                                            title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                        <form action="{{ url("hr/leave-entries/$data->id") }}" method="POST"
                                            data-toggle="tooltip" title="Delete" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm delete"><i
                                                    class="fas fa-trash"></i></button>
                                        </form>
                                    @endif
                                </nobr>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="modal fade" id="reject_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" style="border-bottom: 2px solid #1D84EB;">
                    <h4 class="modal-title" id="exampleModalLabel">Reject</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('leave-entries.leave-reject') }}" method="POST">
                        @csrf
                        <input type="hidden" id="leave_entry_id" name="leave_entry_id" value="">

                        <div class="input-group input-group-sm input-group-primary mb-2">
                            <label class="input-group-addon" for="date">Reject Note: <span
                                    class="text-danger">*</span></label>
                            {{ Form::textarea('remarks', old('remarks') ? old('remarks') : null, [
                                'class' => 'form-control disable',
                                'id' => 'remarks',
                                'placeholder' => '',
                                'required',
                                'rows' => 3,
                            ]) }}
                        </div>
                        <div class="row">
                            <div class="offset-md-4 col-md-4 mt-2">
                                <div class="input-group input-group-sm">
                                    <button class="btn btn-danger btn-round btn-block py-2">
                                        Reject
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
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

        $('.reject-leave-entry').click(function() {
            var leave_entry = this.getAttribute('data-entry');
            $('#leave_entry_id').val(leave_entry);
        });
    </script>
@endsection
