@extends('layouts.backend-layout')
@section('title', 'Feasibility Finance')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title')
    List of Finance
@endsection


@section('breadcrumb-button')
    <a href="{{ url('finance') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
@endsection

    @section('content')
            <!-- put search form here.. -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>SL</th>
                <th>Location</th>
                <th>Schedule</th>@extends('layouts.backend-layout')
@section('title', 'Feasibility Finance')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title')
    List of Finance
@endsection


@section('breadcrumb-button')
    <a href="{{ url('finance') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
@endsection

    @section('content')
            <!-- put search form here.. -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>SL</th>
                <th>Location</th>
                <th>Month</th>
                <th>Cash Benefit</th>
                <th>Action</th>
            </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>SL</th>
                    <th>Location</th>
                    <th>Month</th>
                    <th>Cash Benefit</th>
                    <th>Action</th>
                </tr>
            </tfoot>
            <tbody>
            @foreach($finance->financeDetails as $key => $data)
                <tr>
                    <td>{{  $loop->iteration}}</td>
                    <td> {{ $finance->BdLeadGeneration->land_location}}</td>
                    <td> {{ $data->month }}</td>
                    <td> {{ $data->amount }}</td>
                    <td>
                        
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
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

                <th>Action</th>
            </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>SL</th>
                    <th>Location</th>
                    <th>Rate</th>
                    <th>Action</th>
                </tr>
            </tfoot>
            <tbody>
            @foreach($finance as $key => $data)
                <tr>
                    <td>{{  $loop->iteration}}</td>
                    <td> {{ $data->BdLeadGeneration->land_location}}</td>
                    <td> {{ $data->rate }}</td>
                    <td>
                        
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
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
