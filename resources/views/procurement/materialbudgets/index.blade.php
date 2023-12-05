@extends('layouts.backend-layout')
@section('title', 'Existing Budget')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

    @section('content')
        <div class="row">
            @foreach($groupBy_project_id as $project)
        <div class="col-md-3">
{{--            <a href="{{ url('boqSupremeBudgets') }}/{{$project[0]->project_id}}">--}}
            <a href="{{ url('supreme-budget-show') }}/{{$budgetfor}}/{{$project[0]->project_id}}">
                <div class="card text-white" style="background-color: #227447;">
                    <div class="card-body text-center" >
                        {{ $project[0]->costCenter->name }}
                    </div>
                </div>
            </a>
        </div>
        @endforeach
        </div>

    @endsection
