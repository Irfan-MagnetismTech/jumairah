@extends('layouts.backend-layout')
@section('title', 'Labor Budget')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('content')
    <div class="row">
        @foreach($months as $key => $value)
        <div class="col-md-6">
            <a href="{{ url('construction/budget-details') }}/{{ $value->first()->year }}/{{$key}}">
                <div class="card col-md-12 text-white text-center" style="background-color: #116A7B;">
                    <div class="card-body">
                        <i class="fas fa-file-excel"></i> &nbsp;&nbsp;
                        {{ DateTime::createFromFormat('!m', $key)->format('F') . ', ' . $value->first()->year }}
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
@endsection
