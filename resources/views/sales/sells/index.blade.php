@extends('layouts.backend-layout')
@section('title', 'Sales')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title')
    List of Sales
@endsection


@section('breadcrumb-button')
    @can('sell-create')
        <a href="{{ url('sells/create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
    @endcan
@endsection

@section('sub-title')
    Total: {{ count($sells) }}
    @endsection
    @section('content')
            <!-- put search form here.. -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>SL</th>
                <th>Client</th>
                <th>Apartment</th>
                <th>Project</th>
                <th>Total Value</th>
                <th>Booking Money</th>
                <th>Downpayment</th>
                <th>Installment</th>
                <th>
                @hasanyrole('super-admin|admin|Sales-HOD|CSD-Manager')
                    Action
                @endhasrole
                </th>
            </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>SL</th>
                    <th>Client</th>
                    <th>Apartment</th>
                    <th>Project</th>
                    <th>Total Value</th>
                    <th>Booking Money</th>
                    <th>Downpayment</th>
                    <th>Installment</th>
                    <th>
                    @hasanyrole('super-admin|admin|Sales-HOD|CSD-Manager')
                        Action
                    @endhasrole
                    </th>

                </tr>
            </tfoot>
            <tbody>
            @foreach($sells as $key => $sell)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td class="text-left breakWords">
                        <strong>
{{--                        @hasanyrole('super-admin|admin|Sales-HOD')--}}
                            <a href="{{ url("sells/$sell->id") }}">
                                {{$sell->sellClient->client->name ?? "Client is Empty"}}
                            </a>
{{--                        @else--}}
{{--                            {{$sell->sellClient->client->name ?? "Client is Empty"}}--}}
{{--                        @endhasrole--}}
                        </strong>
                        <br>
                    </td>
                    <td><strong>{{$sell->apartment->name}}</strong></td>
                    <td><strong>{{$sell->apartment->project->name}}</strong></td>
                    <td  class="text-right">@money($sell->total_value)</td>
                    <td  class="text-right">@money($sell->booking_money)</td>
                    <td  class="text-right">@money($sell->downpayment)</td>
                    <td  class="text-right">@money($sell->installment)</td>
                    <td>
                        <div class="icon-btn">
                            <nobr>
                            @hasanyrole('super-admin|admin|Sales-HOD|CSD-Manager')
                                @can('sell-view')
                                    <a href="{{ url("sells/$sell->id") }}" data-toggle="tooltip" title="Show" class="btn btn-outline-primary"><i class="fas fa-eye"></i></a>
                                @endcan
                                <a href="{{ url("addsaleactivity/$sell->id") }}" data-toggle="tooltip" title="Add Activity" class="btn btn-outline-success"><i class="fas fa-plus"></i></a>
                                <a href="{{ url("sells/$sell->id/saleactivity") }}" data-toggle="tooltip" title="Check Activities" class="btn btn-outline-info"><i class="fas fa-database"></i></a>
                            @endhasrole
                            @hasanyrole('super-admin|admin|Sales-HOD|Accounts-Manager|CSD-Manager')
                                @if(!$sell->handover)
                                <a href="{{ url("sells/$sell->id/handover") }}" data-toggle="tooltip" title="Handover" class="btn btn-outline-info"><i class="fas fa-key"></i></a>
                                @endif
                            @endhasrole
                            @hasanyrole('super-admin|admin|Sales-HOD|CSD-Manager')
                                @can('sell-edit')
                                    <a href="{{ url("sells/$sell->id/edit") }}" data-toggle="tooltip" title="Edit Sale Information" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                @endcan
                                @can('sell-delete')
                                    {!! Form::open(array('url' => "sells/$sell->id",'method' => 'delete', 'class'=>'d-inline','data-toggle'=>'tooltip','title'=>'Delete')) !!}
                                    {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete'])}}
                                @endcan
                                    {!! Form::close() !!}
                            @endhasanyrole
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
