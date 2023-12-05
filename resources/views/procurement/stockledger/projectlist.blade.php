@extends('layouts.backend-layout')
@section('title', 'Material Ledger')

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
            @foreach($datas as $data)
        <div class="col-md-3">
            <a href="{{ url('get-material') }}/{{ $data[0]['cost_center_id'] }}">
                <div class="card text-white" style="background-color: #227447">
                    <div class="card-body text-center">
                        <h6>{{ $data[0]['cost_center_name'] }}</h6>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
        </div>

    @endsection
