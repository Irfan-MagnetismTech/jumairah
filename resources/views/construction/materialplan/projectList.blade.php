@extends('layouts.backend-layout')
@section('title', 'Material Plan')

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
            @foreach($projects as $key => $value)
            <div class="col-md-6">
                    <a href="{{ url('construction/material-budget-details') }}/{{ $value->year }}/{{$value->month}}/{{ $value->project_id }}">
                    <div class="card col-md-12 text-white text-center" style="background-color: #227447;">
                        <div class="card-body">
                            <i class="fas fa-file-excel"></i> &nbsp;&nbsp;
                            {{ $value->projects->name }}
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
        

    @endsection
