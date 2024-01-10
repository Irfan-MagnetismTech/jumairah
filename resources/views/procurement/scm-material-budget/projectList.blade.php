@extends('layouts.backend-layout')
@section('title', 'Material Budget')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

    @section('content')
        <div class="row">
            @foreach($projects as $key => $value)
            <div class="col-md-6">
                    <a href="{{ url('scm-material-budget-details') }}/{{ $value->year }}/{{$value->month}}/{{ $value->project_id }}/{{ $value->id }}">
                    <div class="card col-md-12 text-white text-center" style="background-color: #116A7B;">
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
