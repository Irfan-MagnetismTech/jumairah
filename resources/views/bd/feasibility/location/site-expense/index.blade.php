@extends('bd.feasibility.layout.app')
@section('title', 'Site Expense')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title')
    List of Site Expense for {{ $bd_lead_location_name[0]->land_location }}
@endsection


@section('breadcrumb-button')
    @can('employee-create')
        <a href="{{ route('feasibility.location.site-expense.create',[ $bd_lead_location_name[0]->id]) }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
    @endcan
@endsection

    @section('content')
            <!-- put search form here.. -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Land Area of Project</th>
                    <th>Monthly Expense</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tfoot>
            <tr>
                <th>SL</th>
                <th>Land Area of Project</th>
                <th>Monthly Expense</th>
                <th>Action</th>
            </tr>
            </tfoot>
            <tbody>
               @foreach($BdLeadGenerations as $site_expense)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{ $site_expense->land_area}}</td>
                        <td>{{ $site_expense->monthly_expense }}</td>
                        <td>
                            <div class="icon-btn">
                                <nobr>
                                    <a href="{{ url("feasibility/location/$BdLeadGeneration_id/site-expense/$site_expense->id/edit")}}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                    {{-- <a href="{{  }}" data-toggle="tooltip" title="Delete" class="btn btn-outline-danger btn-sm delete"><i class="fa fa-trash"></i></a> --}}
                                    {!! Form::open(array('url' => "feasibility/location/$BdLeadGeneration_id/site-expense/$site_expense->id",'method' => 'delete', 'class'=>'d-inline','data-toggle'=>'tooltip','title'=>'Delete')) !!}
                                    {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-outline-danger btn-sm delete'])}}
                                    {!! Form::close() !!}
                                
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
