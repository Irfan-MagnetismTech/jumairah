@extends('layouts.backend-layout')
@section('title', 'BD-Feasibility-Fees-Cost')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    List of Fees And Cost
@endsection


@section('breadcrumb-button')
    {{-- <a href="{{ route('ctc.create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a> --}}
@endsection

@section('sub-title')
    Total: {{ count($BdFeasiFessAndCost) }}
@endsection

@section('content')
    <!-- put search form here.. -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Location</th>
                    <th>Type</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>SL</th>
                    <th>Location</th>
                    <th>Type</th>
                    <th>Action</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach ($BdFeasiFessAndCost as $key => $bd)
                    @php($types = $bd->BdFeasiFessAndCostDetail->pluck('headable.type', 'headable.type'))
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><strong>{{ $bd->BdLeadGeneration->land_location }}</strong></td>
                        <td>
                            @foreach ($types as $type)
                                {{ $type }} <br>
                            @endforeach
                        </td>
                        <td>
                            <div class="icon-btn">
                                <nobr>
                                    <a href="{{ route('fees_cost.edit', $bd->id) }}" data-toggle="tooltip" title="Edit"
                                        class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                    <!-- {!! Form::open([
                                        'url' => "ctc/$bd->id",
                                        'method' => 'delete',
                                        'class' => 'd-inline',
                                        'data-toggle' => 'tooltip',
                                        'title' => 'Delete',
                                    ]) !!}
                                                                                            {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete']) }}
                                                                                            {!! Form::close() !!} -->
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
