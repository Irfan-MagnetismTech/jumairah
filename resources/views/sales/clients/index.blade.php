@extends('layouts.backend-layout')
@section('title', 'Clients')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title')
    List of Clients
@endsection


@section('breadcrumb-button')
    @can('client-create')
        <a href="{{ url('clients/create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
    @endcan
@endsection

@section('sub-title')
    Total: {{ count($clients) }}
    @endsection


    @section('content')
            <!-- put search form here.. -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>SL</th>
                <th>Name</th>
                <th>Apartment</th>
                <th>Project</th>

                <th>
                    @hasanyrole('super-admin|admin|Sales-HOD|CSD-Manager')
                        Action
                    @endhasrole
                </th>

            </tr>
            </thead>
            <tbody>
            @foreach($clients as $key => $client)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td class="text-left breakWords"> <strong>
                        @hasanyrole('super-admin|admin|Sales-HOD|CSD-Manager')
                            <a href="{{ url("clients/$client->id") }}">{{$client->name}}</a>
                        @else
                            {{$client->name}}
                        @endhasrole
                        </strong>
                    </td>
                    <td>
                        @foreach ($client->sellsClients as $sells)
                            {{$sells->sell->apartment->name}}
                        @endforeach
                    </td>
                    <td class="breakWords">
                        @foreach ($client->sellsClients as $sells)
                            {{$sells->sell->apartment->project->name}}
                        @endforeach
                    </td>
                    <td>
                        <div class="icon-btn">
                        @hasanyrole('super-admin|admin|Sales-HOD|CSD-Manager')
                        <nobr>
                                @can('client-view')
                                    <a href="{{ url("clients/$client->id") }}" data-toggle="tooltip" title="Show" class="btn btn-outline-primary"><i class="fas fa-eye"></i></a>
                                @endcan
                                @can('client-edit')
                                    <a href="{{ url("clients/$client->id/edit") }}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                @endcan
                                @can('client-delete')
                                    {!! Form::open(array('url' => "clients/$client->id",'method' => 'delete', 'class'=>'d-inline','data-toggle'=>'tooltip','title'=>'Delete')) !!}
                                    {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete'])}}
                                @endcan
                                     {!! Form::close() !!}
                                <a href="{{ url("clients/{$client->id}/log") }}" data-toggle="tooltip" title="Log" class="btn btn-dark"><i class="fas fa-history"></i></a>
                            </nobr>
                        @endhasrole

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
