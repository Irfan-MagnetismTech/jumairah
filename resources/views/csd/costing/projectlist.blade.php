@extends('layouts.backend-layout')
@section('title', 'Final Costing')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection




@section('breadcrumb-button')
    {{-- <a href="{{ url('requisitions/create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a> --}}
@endsection

@section('sub-title')
    {{-- Total: {{ count($requisitions) }} --}}
    @endsection


    @section('content')
        <div class="row">
            @foreach($projects as $project)
        <div class="col-md-3">
            <a href="{{ url('csd/apartment-List') }}/{{ $project[0]->project_id }}">

                <div class="card text-white" style="background-color: #116A7B">
                    <div class="card-body text-center">
                        <h6>{{ $project[0]->projects->name }}</h6>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
        </div>

    @endsection
