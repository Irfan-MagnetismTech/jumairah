@extends('layouts.backend-layout')
@section('title', 'Sell Details')

@section('breadcrumb-title')
    {{--Showing information of {{strtoupper($sell->sellClient->client->name)}}--}}
@endsection

@section('breadcrumb-button')
    {{--<a href="{{ url('sells') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>--}}
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid',null)

@section('content')
    <div class="row">

    </div> <!-- end row -->
@endsection

@section('script')

@endsection
