@extends('layouts.backend-layout')
@section('title', 'Final Costing')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title')
    Final Costing
@endsection


@section('breadcrumb-button')
    <a href="{{ url('csd/costing/create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
@endsection

    @section('content')
            <!-- put search form here.. -->
        <div class="row">
            <div class="col-md-12 col-xl-12">
                <div class="table-responsive">
                    <table id="dataTable" class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th colspan="6">Additional/Demand Work</th>
                            
                        </tr>
                        <tr>
                            <th>SL</th>
                            <th>Project Name</th>
                            <th>Apartment</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        
                        <tbody>
                            @foreach ($costings as $costing)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $costing->projects->name }}</td>
                                    <td>{{ $costing->apartments->name }}</td>
                                    <td>
                                        <a href="{{ url("csd/costing/$costing->id") }}" data-toggle="tooltip" title="Details" class="btn btn-outline-primary"><i class="fas fa-eye"></i></a>
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

        // $(document).ready(function () {
        //     $('#dataTable').DataTable({
        //         stateSave: true
        //     });
        // });
    </script>
@endsection
