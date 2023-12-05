@extends('layouts.backend-layout')
@section('title', 'Yearly Budget')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title') 
    Budget List
@endsection

@section('breadcrumb-button')
    <a href="{{ route('bd_yearly_budget.create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
@endsection


    @section('content')
    
            <!-- put search form here.. -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Month</th>
                    <th>Cost(Project in Progress)</th>
                    <th>Cost(Project in Future)</th>
                    <th>Total Payable Amount</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <tr>
                        <th>SL</th>
                        <th>Month</th>
                        <th>Cost(Project in Progress)</th>
                        <th>Cost(Project in Future)</th>
                        <th>Total Payable Amount</th>
                        <th>Action</th>
                    </tr>
                </tr>
            </tfoot>
            <tbody>
            @foreach($years_list as $row)
                <tr>
                    <td> {{ $loop->iteration }} </td>
                    <td> {{ DateTime::createFromFormat('!m', $month->month)->format('F') . ', ' . $month->year }} </td>
                    <td> {{ $month->progress_total_amount }} </td>
                    <td> {{ $month->future_total_amount }} </td>
                    <td> {{ $month->total_amount }} </td>

                    <td> 
                        <div class="icon-btn">
                            <nobr>
                                <a href="{{ url('bd-budget-pdf') }}/{{ $month->id }}" title="PDF" class="btn btn-out-dashed btn-sm btn-success"><i class="fas fa-file-pdf"></i></a>
                                <a href="{{ url("bd_budget/$month->id/edit") }}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                {!! Form::open(array('url' => "bd_budget/$month->id",'method' => 'delete', 'class'=>'d-inline','data-toggle'=>'tooltip','title'=>'Delete')) !!}
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
