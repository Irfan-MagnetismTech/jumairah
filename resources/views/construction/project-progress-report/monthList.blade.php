@extends('layouts.backend-layout')
@section('title', 'Progress Report')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

    @section('content')
        <div class="row">
            @foreach($months as $month)
        <div class="col-md-3">
            <a href="{{ url('construction/project-progress-report-list') }}/{{ $year }}/{{ $month }}">
                <div class="card text-white" style="background-color: #227447;">
                    <div class="card-body text-center" >
                        {{ DateTime::createFromFormat('!m', $month)->format('F') . ', ' . $year }}
                    </div>
                </div>
            </a>
        </div>
        @endforeach
        </div>

    @endsection
