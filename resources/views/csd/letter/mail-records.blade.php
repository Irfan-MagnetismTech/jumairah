@extends('layouts.backend-layout')
@section('title', 'Mail Records')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title')
    Mail Records
@endsection



    @section('content')
            <!-- put search form here.. -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>SL</th>
                <th>Project Name</th>
                <th>Clent Name[Apartment]</th>
                <th>Letter Subject</th>
                <th>Sending Time</th>
            </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>SL</th>
                    <th>Project Name</th>
                    <th>Clent Name[Apartment]</th>
                    <th>Letter Subject</th>
                    <th>Sending Time</th>
                </tr>
            </tfoot>
            <tbody>
            @foreach($mail_records as $key => $letter)
                <tr>
                    <td>{{  $loop->iteration}}</td>
                    <td> {{ $letter->project->name }}</td>
                    <td> {{ $letter->client->name }} [{{ $letter->apartment->name }}]</td>
                    <td> {{ $letter->letter_subject }}</td>
                    <td> {{ $letter->created_at }}</td>
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
