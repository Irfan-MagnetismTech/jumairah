@extends('layouts.backend-layout')
@section('title', 'Materail Budget')


@section('content-grid', 'offset-md-1 col-md-6 offset-lg-2 col-lg-6 my-3')

@section('content')

@can('scm-material-budget')

    <div class="row">
        <div class="col-md-12">
            <a href="{{ url('scm-material-budget-project-list') }}/{{$year}}/{{$month}}">
                <div class="card text-white" style="background-color: #116A7B">
                    <div class="card-body text-center">
                        <h4>Entry rate</h4>
                    </div>
                </div>
            </a>
        </div>
    </div>
@endcan
@can('scm-material-budget-dashboard')

    <div class="row">
        <div class="col-md-12">
            <a href="{{ url('scm-material-budget-dashboard')}}/{{$year}}/{{$month}}">
                <div class="card text-white" style="background-color: #116A7B">
                    <div class="card-body text-center">
                        <h4>Budget Dashboard</h4>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <a href="{{ url('scm-material-payment-dashboard')}}/{{$year}}/{{$month}}">
                <div class="card text-white" style="background-color: #116A7B">
                    <div class="card-body text-center">
                        <h4>Payment Dashboard</h4>
                    </div>
                </div>
            </a>
        </div>
    </div>
@endcan
@endsection
