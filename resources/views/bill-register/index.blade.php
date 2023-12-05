@extends('layouts.backend-layout')
@section('title', 'Bill Registers')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    List of Bill Register
@endsection


@section('breadcrumb-button')
    <a href="{{ url('bill-register/create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
@endsection

@section('sub-title')
    Total: {{ count($bill_registers) }}
@endsection


@section('content')
    <!-- put search form here.. -->
    <div class="table-responsive" style="width:100%">
        <table id="dataTable" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th style="display: none">SL No</th>
                    <th>SL No</th>
                    <th>Bill No</th>
                    <th>Department</th>
                    <th>Supplier Name</th>
                    <th>Amount</th>
                    <th>Bill Register <br>Time</th>
                    <th>Status</th>
                    {{-- <th>Bill Accepted <br>Time</th>
                    <th>Bill Delivered <br>Time</th> --}}
                    <th>Action</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th style="display: none">SL No</th>
                    <th>SL No</th>
                    <th>Bill No</th>
                    <th>Department</th>
                    <th>Supplier Name</th>
                    <th>Amount</th>
                    <th>Bill Register <br>Time</th>
                    <th>Status</th>
                    {{-- <th>Bill Accepted <br>Time</th>
                    <th>Bill Delivered <br>Time</th> --}}
                    <th>Action</th>
                </tr>
            </tfoot>
            <tbody>
                @php
                    $Status = ['Pending', 'Delivered'];
                    $index = 1;
                @endphp
                @foreach ($bill_registers as $key => $bill_register)
                    @if (auth()->id() == 1 ||
                            auth()->user()->department_id == $bill_register->department_id ||
                            auth()->user()->department_id == 18)
                        <tr>
                            <td style="display: none">{{ $loop->iteration }}</td>
                            <td>{{ $bill_register->serial_no }}</td>
                            <td>{{ $bill_register->bill_no }}</td>
                            <td>{{ $bill_register->department->name ?? '' }}</td>
                            <td>{{ $bill_register?->supplier?->name }}</td>
                            <td class="breakWords text-center" width="140px"> {{ $bill_register->amount }}</td>
                            <td>{{ date_format($bill_register->created_at, 'Y-m-d h:i:s A') }}</td>
                            <td class="breakWords text-center" width="140px">
                                {{ $Status[$bill_register->deliver_status] }}</td>
                            {{-- <td>
                            @if ($Status[$bill_register->status] == 'Pending')
                                <span style="color:red">{{$Status[$bill_register->status]}}</span>
                            @else
                            {{$Status[$bill_register->status] ." By ".$bill_register->user->name . "(" . $bill_register->department->name .")"}}
                            @endif
                        </td>
                        <td>{{ $bill_register->accepted_date }}</td>
                        <td></td> --}}
                            <td>
                                <div class="icon-btn">
                                    <nobr>
                                        {{-- @if (!$bill_register->approval_status)
                                        @if (auth()->user()->roles[0]->name == 'Executive(front-desk)')
                                            @if ($bill_register->status == 1)
                                                @if ($bill_register->deliver_status == 1)

                                                @else
                                                    <a href="{{ route('bill-delivered',$bill_register->id) }}" data-toggle="tooltip" title="Deliver" class="btn btn-success"><i class="fa fa-check" aria-hidden="true"></i></a>
                                                @endif
                                            @else
                                                <a href="{{ url("bill-register/$bill_register->id/edit") }}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                                {!! Form::open(array('url' => "bill-register/$bill_register->id",'method' => 'delete', 'class'=>'d-inline','data-toggle'=>'tooltip','title'=>'Delete')) !!}
                                                {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete'])}}
                                                {!! Form::close() !!}
                                            @endif
                                        @else
                                            @if ($bill_register->status == 1)
                                                @if ($bill_register->deliver_status == 1 && $bill_register->user_id == auth()->user()->id)
                                                    <a href="{{ route('bill-register-approve',$bill_register->id) }}" data-toggle="tooltip" title="Approve" class="btn btn-success"><i class="fa fa-check" aria-hidden="true"></i></a>
                                                    <a href="{{ url("bill-register/$bill_register->id/edit") }}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>

                                                @else
                                                @endif
                                            @else
                                                <a href="{{ route('bill-accept',$bill_register->id) }}" data-toggle="tooltip" title="Accept" class="btn btn-success"><i class="fa fa-check" aria-hidden="true"></i></a>
                                            @endif
                                        @endif
                                    @endif --}}
                                        @if ($bill_register->deliver_status == 1)
                                        @else
                                            <a href="{{ route('bill-delivered', $bill_register->id) }}"
                                                data-toggle="tooltip" title="Delivered" class="btn btn-success"><i
                                                    class="fa fa-check" aria-hidden="true"></i></a>
                                        @endif
                                        @can('bill-register-edit')
                                            <a href="{{ url("bill-register/$bill_register->id/edit") }}" data-toggle="tooltip"
                                                title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                        @endcan
                                        @can('bill-register-delete')
                                            {!! Form::open([
                                                'url' => "bill-register/$bill_register->id",
                                                'method' => 'delete',
                                                'class' => 'd-inline',
                                                'data-toggle' => 'tooltip',
                                                'title' => 'Delete',
                                            ]) !!}
                                            {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete']) }}
                                            {!! Form::close() !!}
                                        @endcan
                                    </nobr>
                                </div>
                            </td>
                        </tr>
                    @endif
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
