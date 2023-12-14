@extends('layouts.backend-layout')
@section('title', 'Project Layout')

    @section('content')
        <div class="row">
            @foreach($locations as $key => $location)
                <div class="col-md-3">
                    <a href="{{url('feasibility-entry/create',['location_id' => $location])}}">
                        <div class="card text-white" style="background-color: #227447;">
                            <div class="card-body text-center" >
                                {{ $location->land_location }}
                                <p class="m-0">
                                    <small>LO : {{ $location->BdLeadGenerationDetails->first()->name }}</small>
                                </p>
                            </div>
                        </div>
                    </a> 
                </div>
            @endforeach
        </div>

    @endsection
