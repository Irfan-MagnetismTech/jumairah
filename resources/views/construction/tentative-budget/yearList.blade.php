@extends('layouts.backend-layout')
@section('title', 'Tentative Budget')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection




@section('breadcrumb-button')
    <!-- {{-- <a href="{{ url('requisitions/create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a> --}} -->
@endsection


    @section('content')
        <div class="row">
            @foreach($years as $year)
        <div class="col-md-3">
            <a href="{{ url('construction/tentative-budget-details') }}/{{ $year }}">
                <div class="card text-white" style="background-color: #227447;">
                    <div class="card-body text-center" >
                        {{ $year }}
                    </div>
                </div>
            </a>
        </div>
        @endforeach
        </div>

    @endsection
