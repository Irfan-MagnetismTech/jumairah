@extends('layouts.backend-layout')
@section('title', 'Team')

@section('breadcrumb-title')
    Showing information of {{strtoupper($team->name)}}
@endsection

@section('breadcrumb-button')
    <a href="{{ url('teams') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    {{--    <span class="text-danger">*</span> Marked are required.--}}
@endsection

@section('content-grid', 'col-md-12 col-lg-10 offset-lg-1')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive">
                <table id="dataTable" class="table table-striped table-bordered">
                    <tbody class="text-left">
                    <tr class="bg-success"><td> <strong>Team Name</strong> </td> <td> <strong>{{ $team->name}}</strong></td></tr>
                    <tr><td> <strong>Team Head</strong> </td> <td> {{ $team->user->name}}</td></tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="row">
            <div class="col-lg-12">
                <p class="text-center font-weight-bold m-b-0">Information of Team Member</p>
                <div class="table-responsive">
                    <table id="dataTable" class="table table-striped table-bordered text-center">
                        <thead>
                        <tr>
                            <th>Sl.</th>
                            <th>Name</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($team->members as $member)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$member->user->name}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

    </div>

     <!-- end row -->


@endsection

@section('script')

@endsection




