@extends('layouts.backend-layout')
@section('title', 'Progress Report')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

    @section('content')
        <div class="row">
            @foreach($years as $year)
        <div class="col-md-3">
            <a href="{{ url('construction/cost-incurred-report') }}/{{ $year }}">
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
