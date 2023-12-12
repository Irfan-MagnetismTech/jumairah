@extends('layouts.backend-layout')
@section('title', 'Device')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    List of finger print Devices
@endsection

@section('style')
    <style>
    </style>
@endsection
@section('breadcrumb-button')
    @can('fingerprint-device-create')
        <a href="{{ route('finger-print-device-infos.create') }}" class="btn btn-out-dashed btn-sm btn-warning"><i
                class="fas fa-plus"></i>
        </a>
    @endcan
@endsection
@section('sub-title')
    Total: {{ count($devices) }}
@endsection


@section('content')
    <div class="dt-responsive table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#SL</th>
                    <th>Device Name</th>
                    <th>IP Address</th>
                    <th>Serial number</th>
                    <th>Location</th>
                    @canany(['fingerprint-device-edit', 'fingerprint-device-delete'])
                        <th>Action</th>
                    @endcanany
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>#SL</th>
                    <th>Device Name</th>
                    <th>IP Address</th>
                    <th>Serial number</th>
                    <th>Location</th>
                    @canany(['fingerprint-device-edit', 'fingerprint-device-delete'])
                        <th>Action</th>
                    @endcanany
                </tr>
            </tfoot>
            <tbody>
                @foreach ($devices as $key => $data)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td class="text-left">{{ $data->device_name }}</td>
                        <td class="text-left">{{ $data->device_ip }}</td>
                        <td class="text-left">{{ $data->device_serial }}</td>
                        <td class="text-left">{{ $data->device_location }}</td>
                        @canany(['fingerprint-device-edit', 'fingerprint-device-delete'])
                            <td>
                                <div class="icon-btn">
                                    <nobr>
                                        @can('fingerprint-device-connect')
                                            <form action="{{ url("hr/device-connection-chk/$data->id") }}" method="POST"
                                                data-toggle="tooltip" title="Check Connection" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-plug"></i>
                                                    Check Connection</button>
                                            </form>
                                        @endcan

                                        @can('fingerprint-device-edit')
                                            <a href="{{ route('finger-print-device-infos.edit', $data->id) }}" data-toggle="tooltip"
                                                title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                        @endcan

                                        @can('fingerprint-device-delete')
                                            <form action="{{ url("hr/finger-print-device-infos/$data->id") }}" method="POST"
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

    <script></script>
@endsection
