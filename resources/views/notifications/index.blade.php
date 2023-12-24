@extends('layouts.backend-layout')
@section('title', 'Notification')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    List of Notification
@endsection


@section('breadcrumb-button')

    <a href="" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>

@endsection

@section('sub-title')
    Total: {{ count($allNotifications) }}
@endsection

@section('content')
    <!-- put search form here.. -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Date</th>
                    <th>Message</th>
                    <Th>Read Status</Th>
                    <th>Action</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>SL</th>
                    <th>Date</th>
                    <th>Message</th>
                    <Th>Read Status</Th>
                    <th>Action</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach ($allNotifications as $key => $data)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            {{ $data->created_at->format('d-m-Y') }}
                            <br>
                            {{ $data->created_at->format('h:i:s A') }}
                        </td>
                        <td>{{ $data->data['message'] }}</td>
                        <td>
                            @if ($data->read_at == null)
                                <span class="badge badge-danger">Unread</span>
                            @else
                                <span class="badge badge-success">Read</span>
                            @endif
                        </td>

                        <td>
                            <div class="icon-btn">
                                <nobr>

                                </nobr>
                            </div>
                        </td>
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
