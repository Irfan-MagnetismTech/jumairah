@extends('layouts.backend-layout')
@section('title', 'Log')

@section('breadcrumb-title')
    {{class_basename($saleCancel)}}'s Log
@endsection

@section('breadcrumb-button')
{{--    <a href="{{ url('saleCancellations') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>--}}
@endsection

@section('sub-title')
        {{--<span class="text-danger">*</span> Marked are required.--}}
@endsection

@section('content-grid', 'col-md-12 col-lg-10 offset-lg-1')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive">
                <table id="dataTable" class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>Sl</th>
                        <th>Type</th>
                        <th>User</th>
                        <th>Old Data</th>
                        <th>New Data</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Sl</th>
                        <th>Type</th>
                        <th>User</th>
                        <th>Old Data</th>
                        <th>New Data</th>
                    </tr>
                    </tfoot>
                    <tbody>

                    @forelse($activities as $key => $activity)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td> {{$activity->description}}</td>
                            <td> {{$activity->causer->name}}</td>
                            <td class="" style="word-wrap:break-word!important;">
                                @if(!in_array($activity->description, ['created', 'deleted', 'restored']))
                                    @foreach($activity->properties['old'] as $key => $attribute)
                                        {{ucwords($key)}} : <strong>{{$attribute}}</strong> <br>
                                    @endforeach
                                @else
                                    - - -
                                @endif
                            </td>
                            <td>
                                @if(!in_array($activity->description, ['created', 'deleted', 'restored']))
                                    @foreach($activity->properties['attributes'] as $key => $attribute)
                                        {{ucwords($key)}} : <strong>{{$attribute}}</strong> <br>
                                    @endforeach
                                @else
                                    - - -
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5"> <h5 class="text-muted my-3"> No Data Found Based on your query. </h5> </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div> <!-- end row -->
@endsection

