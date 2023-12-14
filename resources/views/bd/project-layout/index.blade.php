@extends('layouts.backend-layout')
@section('title', 'Project Layout Index')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title')
   Far Calculation List
@endsection




@section('sub-title')
    Total: {{ count($bd_lead_generation) }}
@endsection

@section('content')
            <!-- put search form here.. -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>SL</th>
                <th>Location</th>
                <th>Proposed MGC</th>
                <th>Proposed Story</th>
                <th>Total FAR</th>
                <th>Land Owner Name</th>
                <th>Action</th>
            </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>SL</th>
                    <th>Location</th>
                    <th>Proposed MGC</th>
                    <th>Proposed Story</th>
                    <th>Total FAR</th>
                    <th>Land Owner Name</th>
                    <th>Action</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach ($projectLayout as $key=>$projectLay )
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td><strong>{{$bd_lead_generation[$key]->first()->land_location}}</strong></td>
                   
                    <td>
                        @if (isset($projectLayout[$key]))
                        {{$projectLayout[$key]?->first()?->proposed_mgc ?? NUll}}
                        @endif
                    </td>
                    <td>
                        @if (isset($projectLayout[$key]))
                        {{$projectLayout[$key]?->first()?->proposed_story ?? NULL}}
                        @endif
                        
                    </td>
                    <td>
                        @if (isset($projectLayout[$key]))
                        {{$projectLayout[$key]?->first()?->total_far ?? NULL}}
                        @endif
                    </td>
                    <td>
                        @if (isset($bd_lead_generation[$key]) && count($bd_lead_generation[$key]->first()->BdLeadGenerationDetails))
                            @foreach ($bd_lead_generation[$key]->first()->BdLeadGenerationDetails as $kk=>$val )
                            {{ \Illuminate\Support\Str::ucfirst($val->name) }}
                                @if (!$loop->last)
                                    ,
                                @endif
                            @endforeach
                        @endif
                        {{-- @if (count($bd_lead_location->first()->BdLeadGenerationDetails))
                            @foreach ($bd_lead_location->first()->BdLeadGenerationDetails as $kk=>$val )
                            {{ \Illuminate\Support\Str::ucfirst($val->name) }}
                                @if (!$loop->last)
                                    ,
                                @endif
                            @endforeach
                        @endif --}}
                    </td>
                    <td>
                        <div class="icon-btn">
                        @if (isset($projectLayout[$key]))
                        <a href="{{ route("project-layout.edit", $projectLayout[$key]?->first()->id) }}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning btn-sm"><i class="fas fa-pen"></i></a>
                        {!! Form::open(array('url' => route("project-layout.destroy", $projectLayout[$key]?->first()->id),'method' => 'delete', 'class'=>'d-inline','data-toggle'=>'tooltip','title'=>'Delete')) !!}
                                        {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete'])}}
                                        {!! Form::close() !!}
                        @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            
              
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
