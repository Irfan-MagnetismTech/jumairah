@extends('layouts.backend-layout')
@section('title', 'Project Layout')

    @section('content')
        <div class="row">
            @foreach($bd_lead_locations as $bd_lead_location)
                <div class="col-md-3">
                    <a href="{{url('project-layout-create',$bd_lead_location)}}">
                        <div class="card text-white" style="background-color: #227447;">
                            <div class="card-body text-center" >
                                {{ $bd_lead_location->land_location }}
                                <p class="m-0">
                                    <small>LO : {{  $bd_lead_location->BdLeadGenerationDetails->first()->name }}</small>
                                </p>
                            </div>
                        </div>
                    </a> 
                </div>
            @endforeach
        </div>

    @endsection
