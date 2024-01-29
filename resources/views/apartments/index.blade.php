@extends('layouts.backend-layout')
@section('title', 'Apartments')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title')
    List of Inventory
@endsection


@section('breadcrumb-button')
    @can('apartment-create')
        <a href="{{ url('apartments/create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
    @endcan
@endsection

@section('sub-title')
    Total: {{ count($apartments) }}
@endsection

    @section('content')
    <!-- put search form here.. -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>SL</th>
                <th>Apartment ID</th>
                <th>Project</th>
                <th>Floor</th>
                <th>Owner</th>
                <th>Size</th>
                <th>Total Price</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>SL</th>
                    <th>Apartment ID</th>
                    <th>Project</th>
                    <th>Floor</th>
                    <th>Owner</th>
                    <th>Size</th>
                    <th>Total Price</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </tfoot>
            <tbody>
            @foreach($apartments as $key => $apartment)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td ><strong><a href="{{ url("apartments/$apartment->id") }}">{{$apartment->name}}</a></strong></td>
                    <td class="breakWords text-center"><strong>{{$apartment->project->name}}</strong></td>
                    <td>{{$apartment->floor}}</td>
                    <td>{{$apartment->owner  == 2 ? "LandOwner" :  config('company_info.company_fullname')}}</td>
                    <td  class="text-right">@money($apartment->apartment_size)</td>
                    <td  class="text-right">@money($apartment->total_value)</td>
                    <td>
                        @if($apartment->sell)
                            <a href="{{route('sells.show', $apartment->sell->id)}}" target="_blank" class="btn btn-success btn-sm">Sold</a>
                        @else
                            <button class="btn btn-dark btn-sm" disabled> Unsold </button>
                        @endif
                    </td>
                    <td>
                        <div class="icon-btn">
                            <nobr>
                                @can('apartment-view')
                                    <a href="{{ url("apartments/$apartment->id") }}" data-toggle="tooltip" title="Show" class="btn btn-outline-primary"><i class="fas fa-eye"></i></a>
                                @endcan
                                @can('apartment-edit')
                                    <a href="{{ url("apartments/$apartment->id/edit") }}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                @endcan
                                @can('apartment-delete')
                                        {!! Form::open(array('url' => "apartments/$apartment->id",'method' => 'delete', 'class'=>'d-inline','data-toggle'=>'tooltip','title'=>'Delete')) !!}
                                        {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete'])}}
                                @endcan
                                        {!! Form::close() !!}
                                <a href="{{ url("apartments/{$apartment->id}/log") }}" data-toggle="tooltip" title="Log" class="btn btn-dark"><i class="fas fa-history"></i></a>
                            </nobr>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('script')
    <script src="{{asset('js/Datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('js/Datatables/dataTables.bootstrap4.min.js')}}"></script>
    <script>
        $(window).scroll(function () {
            //set scroll position in session storage
            sessionStorage.scrollPos = $(window).scrollTop();
        });
        var init = function () {
            //get scroll position in session storage
            $(window).scrollTop(sessionStorage.scrollPos || 0)
        };
        window.onload = init;

        $(document).ready(function () {
            $('#dataTable').DataTable({
                stateSave: true
            });
        });
    </script>
@endsection
