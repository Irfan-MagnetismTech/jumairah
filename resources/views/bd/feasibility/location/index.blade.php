@extends('layouts.backend-layout')
@section('title', 'Locations')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection




@section('breadcrumb-button')
@endsection

@section('sub-title')
    {{-- Total: {{ count($requisitions) }} --}}
    @endsection


    @section('content')
        <div class="row">
            @foreach($bd_lead_locations as $bd_lead_location)
        <div class="col-md-3">
            <a href="{{ url('feasibility/location', ['dashboard' => $bd_lead_location]) }}">
                <div class="card text-white" style="background-color: #116A7B;">
                    <div class="card-body text-center" >
                        {{ $bd_lead_location->land_location }}
                    </div>
                </div>
            </a> 
        </div>
        @endforeach
        </div>

    @endsection
