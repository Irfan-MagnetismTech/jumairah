@extends('layouts.backend-layout')
@section('title', 'Loans')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('css/Datatables/dataTables.bootstrap4.min.css')}}">
@endsection

@section('breadcrumb-title')
    List of Loans
@endsection

@section('breadcrumb-button')
    <a href="{{ route('loans.create') }}" class="btn btn-out-dashed btn-sm btn-success"><i class="fa fa-plus"></i></a>
@endsection

@section('sub-title')
    Total: {{ count($loans) }}
@endsection

@section('content')
    <!-- put search form here.. -->
    <div class="table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Source Name</th>
                    <th>Loan <br> Nature</th>
                    <th>Total <br> Sanctioned</th>
                    <th>Opening <br> Date</th>
                    <th>Maturity <br>  Date</th>
                    <th>Interest <br> Rate</th>
                    <th>Total <br> Installment</th>
                    <th>Sanctioned <br> Limit</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>SL</th>
                    <th>Source Name</th>
                    <th>Loan <br> Nature</th>
                    <th>Total <br> Sanctioned</th>
                    <th>Opening <br> Date</th>
                    <th>Maturity <br>  Date</th>
                    <th>Interest <br> Rate</th>
                    <th>Total <br> Installment</th>
                    <th>Sanctioned <br> Limit</th>
                    <th>Action</th>
                </tr>
            </tfoot>
            <tbody>
            @foreach($loans as $key => $data)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$data->loanable->name ?? ''}}</td>
                    <td>{{$data->loan_type}}</td>
                    <td class="text-right">{{number_format($data->total_sanctioned, 2)}}</td>
                    <td>{{$data->opening_date}}</td>
                    <td>{{$data->maturity_date}}</td>
                    <td>{{$data->interest_rate}}</td>
                    <td>{{$data->total_installment}}</td>
                    <td class="text-right">{{number_format($data->sanctioned_limit, 2)}}</td>
                    <td>
                        <div class="icon-btn">
                            <nobr>
                                <a href="{{ route("loans.edit", $data->id) }}" data-toggle="tooltip" title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>
                                {!! Form::open(array('url' => route('loans.destroy', $data->id),'method' => 'delete', 'class'=>'d-inline','data-toggle'=>'tooltip','title'=>'Delete')) !!}
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
