@extends('layouts.backend-layout')
@section('title', 'MIR')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection




@section('breadcrumb-button')
    <!-- {{-- <a href="{{ url('requisitions/create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a> --}} -->
@endsection


    @section('content')
        <div class="row">
            @foreach($months as $month)
        <div class="col-md-3">
            <a href='{{ url("get-report/{$cost_center_id}/{$year}/{$month}") }}'>
                <div class="card text-white" style="background-color: #227447;">
                    <div class="card-body text-center" >
                        {{ DateTime::createFromFormat('!m', $month)->format('F') }}
                    </div>
                </div>
            </a>
        </div>
        @endforeach
        </div>

    @endsection
