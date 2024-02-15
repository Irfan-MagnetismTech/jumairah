@extends('layouts.backend-layout')
@section('title', 'Client List')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title')
    Sales Client List
@endsection


@section('breadcrumb-button')
    {{-- <a href="{{ url('csd/costing/create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a> --}}
@endsection

    @section('content')
            <!-- put search form here.. -->
        <div class="row">
            <div class="col-md-12 col-xl-12">
                <div class="table-responsive">
                    <table id="dataTable" class="table table-striped table-bordered">
                        <thead>

                        <tr>
                            <th>SL</th>
                            <th>Project Name</th>
                            <th>Apartment</th>
                            <th>Sold By</th>
                            <th>Client Name</th>
                            <th>Client Phone</th>
                            <th>Client Email</th>
                            <th>Action</th>
                        </tr>
                        </thead>

                        <tbody>
                            @foreach ($sales as $sale)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $sale->apartment->project->name }}</td>
                                    <td>{{ $sale->apartment->name }}</td>
                                    <td>{{ $sale->sellClients->first()->sell->user->name }}</td>
                                    <td>{{ $sale->sellClients->first()->client->name  }}</td>
                                    <td>{{ $sale->sellClients->first()->client->contact  }}</td>
                                    <td>{{ $sale->sellClients->first()->client->email  }}</td>
                                    <td>
                                        <a href="{{ url("csd/apartment-handover/$sale->id") }}" title="Apartment Handover PDF" class="btn btn-out-dashed btn-sm btn-success"><i class="fas fa-file-pdf"></i></a>
                                        <a href="{{ url("csd/key-handover/$sale->id") }}" title="Key Handover PDF" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-file-pdf"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
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
                 stateSave: true
             });
         });
    </script>
@endsection
