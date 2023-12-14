@extends('layouts.backend-layout')
@section('title', 'BOQ - Utility Bill List')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title')
    List of Utility Bill
@endsection

@section('breadcrumb-button')
    @can('project-create')
        <a href="{{ route('eme.utility_bill.create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
    @endcan
@endsection

@section('sub-title')
    Total: {{ $utilityBills->total() }}
    @endsection

    @section('content')
            <!-- put search form here.. -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>SL</th>
                <th style="width: 250px;word-wrap:break-word">Client Name</th>
                <th style="width: 250px;word-wrap:break-word">Project Name</th>
                <th style="width: 250px;word-wrap:break-word">Apartment Name</th>
                <th style="width: 250px;word-wrap:break-word">period</th>
                <th style="width: 250px;word-wrap:break-word">Total Bill</th>
                <th>Action</th>
            </tr>
            </thead>
            <tfoot>
            </tfoot>
            <tbody>
                @php
                 $indx = ( $utilityBills->currentPage() - 1 ) * $utilityBills->perPage() ;
                @endphp
                @foreach($utilityBills as $data)
                <tr>
                    <td>{{++$indx}}</td>
                    <td>{{$data->client->name }}</td>
                    <td>{{$data->project->name }}</td>
                    <td>{{$data->apartment->name }}</td>
                    <td>{{$data->period }}</td>
                    <td>{{$data->total_bill }}</td>
                    <td>
                        <div class="icon-btn">
                            <nobr>
                                    <a href="{{ route('eme.utility_bill.edit', ['utility_bill' => $data]) }}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning">
                                        <i class="fas fa-pen"></i>
                                    <a href="{{ route('eme.utility_bill.show', ['utility_bill' => $data]) }}" data-toggle="tooltip" title="Details" class="btn btn-outline-primary"><i class="fas fa-eye"></i></a>
                                    <form action="{{ route('eme.utility_bill.destroy', ['utility_bill' => $data]) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm delete">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                    <a href="{{ route('eme.utility_bill.pdf', ['utility_bill' => $data]) }}" title="PDF" class="btn btn-out-dashed btn-sm btn-success"><i class="fas fa-file-pdf"></i></a>
                        
                            </nobr>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="float-right">
            {{ $utilityBills->onEachSide(2)->links() }}
        </div>
    </div>
@endsection

@section('script')
    <script src="{{asset('js/Datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('js/Datatables/dataTables.bootstrap4.min.js')}}"></script>
    <script>
        $(window).scroll(function () {
            //set scroll position in session storage
            sessionStorage.scrollPos = $(window).scrollTop();
        });
        var init = function () {
            //get scroll position in session storage
            $(window).scrollTop(sessionStorage.scrollPos || 0)
        };
        window.onload = init;

        $(document).ready(function () {
            $('#dataTable').DataTable({
                stateSave: true,
                bPaginate: false
            });
        });
    </script>
@endsection
