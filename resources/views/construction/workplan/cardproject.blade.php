@extends('layouts.backend-layout')
@section('title', 'Work Plan')

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
        @foreach($ProjectWiseWorkPlanData as $project)
            <div class="card col-md-3">
                <div class="card-body">
                    <a href="{{ url('construction/yearList') }}/{{ $project[0]->project_id }}">{{ $project[0]->projects->name }}</a>
                </div>
            </div>
        @endforeach

    @endsection
