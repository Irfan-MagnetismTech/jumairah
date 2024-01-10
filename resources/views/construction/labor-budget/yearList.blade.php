@extends('layouts.backend-layout')
@section('title', 'Labor Budget')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('content')
    <div class="row">
        @foreach($years as $year)
            <div class="col-md-3">
                <a href="{{ url('construction/labour-budget-month-List') }}/ {{ $year[0]->year }}">
                    <div class="card text-white" style="background-color: #116A7B;">
                        <div class="card-body text-center" >
                            {{ $year[0]->year }}
                        </div>
                    </div>
                </a> 
            </div>
        @endforeach
    </div>

@endsection
