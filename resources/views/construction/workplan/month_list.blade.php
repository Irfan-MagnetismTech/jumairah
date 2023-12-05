@extends('layouts.backend-layout')
@section('title', 'Work Plan')

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
            @foreach($months as $key => $value)
            <div class="col-md-6">
                <a href="{{ url('construction/planDetails') }}/{{ $value->first()->year }}/{{$key}}">
                    <div class="card col-md-12 text-white text-center" style="background-color: #227447;">
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
