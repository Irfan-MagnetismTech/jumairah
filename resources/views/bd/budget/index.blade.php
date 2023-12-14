@extends('layouts.backend-layout')
@section('title', 'Budget')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection




@section('breadcrumb-button')
    <a href="{{ route('bd_budget.create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
@endsection

@section('content')
    <div class="row">
        @foreach($years as $year)
            <div class="col-md-3">
                <a href="{{ url('bd-budget-list') }}/ {{ $year[0]->year }}">
                
                    <div class="card text-white" style="background-color: #227447">
                        <div class="card-body text-center">
                            <h1>{{ $year[0]->year }}</h1>
                        </div>
                    </div>
                </a> 
            </div>
        @endforeach
    </div>
@endsection
